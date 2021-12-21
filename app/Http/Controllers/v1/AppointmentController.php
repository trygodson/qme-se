<?php

namespace App\Http\Controllers\v1;

use Carbon\Carbon;
use Carbon\CarbonPeriod;
use App\Helpers\ZoomIntegration;
use App\Helpers\CustomNotification;
use App\Interfaces\IUserRepository;
use App\Http\Controllers\Controller;
use App\Helpers\VerifyPaymentGateway;
use App\Interfaces\IDoctorRepository;
use App\Interfaces\IAppointmentRepository;
use App\Http\Requests\AppointmentRequest\CheckAvailabilityRequest;
use App\Http\Requests\AppointmentRequest\CreateAppointmentRequest;
use App\Http\Requests\AppointmentRequest\ChangeAppointmentStateRequest;
use App\Http\Requests\AppointmentRequest\CreateAppointmentDiagnosisRequest;
use App\Interfaces\IAppointmentDiagnosisRepository;
use App\Interfaces\IBiodataRepository;
use App\Interfaces\ISystemsettingsRepository;
use App\Interfaces\ITransactionRepository;
use App\Models\Appointment;
use App\Interfaces\IWalletRepository;
use App\Interfaces\IWalletTransactionRepository;

class AppointmentController extends Controller
{
    private $_data;
    private $_doctordata;
    private $_userdata;
    private $diagnosis;
    private $transaction;
    private $setting;
    private $wallet;
    private $wallet_trans;
    private $biodata;





    public function __construct(IAppointmentRepository $data,IDoctorRepository $doctordata,IUserRepository $userdata, IAppointmentDiagnosisRepository $diagnosis, ITransactionRepository $transaction, ISystemsettingsRepository $setting, IWalletRepository $wallet, IWalletTransactionRepository $wallet_trans, IBiodataRepository $biodata)
    {
        $this->_data = $data;
        $this->_doctordata=$doctordata;
        $this->_userdata=$userdata;
        $this->diagnosis = $diagnosis;
        $this->transaction = $transaction;
        $this->setting = $setting;
        $this->wallet = $wallet;
        $this->wallet_trans = $wallet_trans;
        $this->biodata = $biodata;

    }

         /**
     * @OA\Post  (
     *     path="/api/v1/appointment/customer/checkavailability",
     *     tags={"Appointment"},
     *     summary="Check doctor's availability",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 ref="#/components/schemas/CheckAvailabilityRequest",
     *             )
     *         )
     *     ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     * )
     */
     public function checkavailability(CheckAvailabilityRequest $request){
         $startdate=Carbon::parse($request->starts_at);
         $enddate=Carbon::parse($request->ends_at);
        $check_if_doctor_will_be_busy = $this->_data->querable()->where('doctor_id',$request->id)->where('starts_at','>=',$startdate)->where('ends_at','<=',$enddate)->get();

        // foreach($check_if_doctor_will_be_busy as $check){
        //     $period = CarbonPeriod::create($check->starts_at, $check->ends_at);
        //    $confirm = $period->contains($request->starts_at);

        //     if($confirm == true){
        //         return response()->json(["message"=>"Please Pick another date the doctor already have an appointment for the day you chose"], 400);
        //         break;
        //     }
        // }
            if( $check_if_doctor_will_be_busy->count() > 0){
                return response()->json(["message"=>"Please Pick another date the doctor already have an appointment for the day you chose"], 400);
            }else{

               return response()->json(["message"=>"Proceed to set Appointment"], 200);



            }
    }
        /**
     * @OA\Post  (
     *     path="/api/v1/appointment/customer/create",
     *     tags={"Appointment"},
     *     summary="a customer can create an appointment",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 ref="#/components/schemas/CreateAppointmentRequest",
     *             )
     *         )
     *     ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     * )
     */
    public function  addappointmentbycustomer(CreateAppointmentRequest $request)
    {
        //initialized= when a new appointment is sent to the doctor, processing= when appointment is accepted by doctor,rejected=when the request is rejected by the doctpr,completed= bafter diaggnosis
       $message="You have a new request to attend to. Please login to your dashboard to perform action to avaoid keeoing your customer waiting";
         try {
            $appointment = $this->_data->querable()->where('ref_id', $request->ref_id)->get();
           if($appointment->count() > 0){
               return response()->json(["message" => "Transaction already recorded"], 400);
           }else{

            $payment = VerifyPaymentGateway::verify($request->payment_methods_id, $request->ref_id);

            if($payment == [] || $payment == false){
                return response()->json(["message" => "Invalid Transaction Id"], 400);
            }else{

                $transaction_data = [
                    "reference_id" => $request->ref_id,
                    "isdebit" => false,
                    "Payment_description"=> "Appointment Payment",
                    "amount" => ($payment->data->amount / 100),
                    "payment_methods_id" => $request->payment_methods_id
                ];

                $transaction = $this->transaction->add($transaction_data);
          // return response()->json($payment, 200);

            if($payment->data->status == "success"){

                $value = $this->setting->querable()->where('key', 'appointment_percentage')->first();
                $percentage = (int)$value->value;

                $request['transaction_status']='success';
                $request['amount']=$payment->data->amount / 100;
                $request['meetingid']='waiting';
                $request['meetingpassword']='waiting';
                $request['rejection_note']='';
                $request['appointment_step']=1;
                $request['status']="initialized";
                $request['onemedy_share']= $request['amount'] *($percentage / 100);
                $request['doctor_share'] = $request['amount'] - $request['onemedy_share'];


                $action = $this->_data->add($request->all());
               if($action ==true)
                {
                    $query_to_fetch_email=$this->_doctordata->getById($request['doctor_id']);
                    $get_doctor_email=$this->_userdata->getById($query_to_fetch_email->user_id);
                    CustomNotification::sendmail($message,$get_doctor_email->firstname,$get_doctor_email->email, 'New Consultation Request');
                    return response()->json($action, 201);
                }else
                {
                   return response()->json(["message"=>"You seem to have a request unattended to. Please kindly cancel it or wait till the doctor attends to you"], 400);

                }


            }else{
                $request['transaction_status']='failed';
                $request['amount']=$payment->data->amount / 100;
                $request['link']='';
                $request['rejection_note']='';
                $request['appointment_step']=1;
                $request['onemedy_share']= 0.00;
                $request['doctor_share'] = 0.00;

                $action = $this->_data->add($request->all());
                if($action == true){
                    return response()->json(["message"=>"Sorry the transaction was not successful"], 400);
                }
            }




        }
    }



        } catch (\Throwable $ex) {

            return response()->json($ex->getMessage(), 400);
        }
    }


    /**
     * @OA\Patch  (

     *     path="/api/v1/appointment/changestatus/{id}",
     *     tags={"Appointment"},
     *     summary="to update the status of an appointment",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 ref="#/components/schemas/ChangeAppointmentStateRequest",
     *             )
     *         )
     *     ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     * )
     */
    public function acceptordecline($id,ChangeAppointmentStateRequest $request)
    {

      $success_message="Your Order was accepted. Kindly Wait for your consultation day to get the best service from our doctors";
      $error_message="We regret to inform you that the doctor declined your request. This is mostly due to the fact that the doctor might have been busy at the moment";
      if( $request['status']=="accepted")
      {
        $createmeeting=ZoomIntegration::generateZoomToken();
        $request['meetingid']=$createmeeting['id'];
        $request['meetingpassword']=$createmeeting['pwd'];
        $this->_data->update_($id,$request->all());
        $query_to_fetch_email=$this->_data->querable('id',$id)->first();
        $update_status = $query_to_fetch_email->update(['status' => 'processing']);
        $get_user_email=$this->_userdata->getById($query_to_fetch_email->user_id);
        CustomNotification::sendmail($success_message,$get_user_email->firstname,$get_user_email->email, 'Accepted Request');
       return response()->json(["message"=>"Order Accepted"], 200);
      }else if($request['status']=='declined'){
        $this->_data->update_($id,$request->all());
        $query_to_fetch_email=$this->_data->querable('id',$id)->first();
        $update_status = $query_to_fetch_email->update(['status' => 'declined']);
        $get_user_email=$this->_userdata->getById($query_to_fetch_email->user_id);
        CustomNotification::sendmail($$error_message,$get_user_email->firstname,$get_user_email->email, 'Declined Request');
       return response()->json(["message"=>"Order Declined"], 200);
      }else{
        return response()->json(["message"=>"Sorry We do not understand your input"], 400);
      }
    }

             /**
     * @OA\Get  (
    *     @OA\Parameter(
     *         name="id",
     *         in="path",
     * required=true,

     *         description="doctor id",

     *      ),
     *     path="/api/v1/appointment/doctor/{id}",
     *     tags={"Appointment"},
     *     summary="To get the appointments of a doctor",

     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     * )
     */
    public function doctorappointments($id){
    try{
        $appoint = $this->_data->querable()->where('doctor_id', $id)->with('doctor.users')->with('user')->with('appointmentdiagnosis')->paginate(10);

            return response()->json($appoint,200);

    } catch (\Throwable $ex) {

        return response()->json(['message'=> 'No appointments Found'], 400);
    }

    }

               /**
     * @OA\Get  (
    *     @OA\Parameter(
     *         name="id",
     *         in="path",
     * required=true,

     *         description="user id",

     *      ),
     *     path="/api/v1/appointment/customer/{id}",
     *     tags={"Appointment"},
     *     summary="To get the appointments of a customer",

     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     * )
     */
    public function customerappointments($id){
        try{
            $appoint = $this->_data->querable()->where('user_id', $id)->with('user')->with('appointmentdiagnosis')->with(['doctor' => function($query){
                $query->with('users');
            }])->paginate(10);
            return response()->json($appoint,200);
        } catch (\Throwable $ex) {

            return response()->json(['message'=> 'No appointments Found'], 400);
        }

    }



               /**
     * @OA\Get  (
    *     @OA\Parameter(
     *         name="id",
     *         in="path",
     * required=true,

     *         description="appointment id",

     *      ),
     *     path="/api/v1/appointment/checktime/{id}",
     *     tags={"Appointment"},
     *     summary="To check if it's time to proceed with zoom meeting",

     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     * )
     */
    public function checkappointmentdate($id){
        $appoint = $this->_data->getById($id);

        if(Carbon::now() >= $appoint->starts_at){
            return response()->json(['message'=> 'Proceed to appointment'], 200);
        }else{
            return response()->json(['message'=> 'Not Time for appointment'], 400);

        }

}

    /**
     * @OA\Patch  (
    *     @OA\Parameter(
     *         name="id",
     *         in="path",
     * required=true,

     *         description="appointment id",

     *      ),
     *     path="/api/v1/appointment/update/{id}",
     *     tags={"Appointment"},
     *     summary="To update the appointment step after a zoom meeting",

     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     * )
     */
    public function updateappointment($id){
        try{
        $data = [
            "appointment_step" => 2,
            "updated_at" => Carbon::now(),

        ];

        $update = $this->_data->update_($id, $data);
        if($update){

          return response()->json($update,200);
         }else{
                return response()->json(['message'=> ' appointment Not Found'], 400);
        }
    } catch (\Throwable $ex) {

        return response()->json(['message'=> 'No appointments Found'], 400);
    }

    }

      /**
     * @OA\Post  (
     *     path="/api/v1/appointment/diagnosis/create",
     *     tags={"Appointment"},
     *     summary="create an appointment Diagnosis",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 ref="#/components/schemas/CreateAppointmentDiagnosisRequest",
     *             )
     *         )
     *     ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     * )
     */
    public function addappointmentdiagnosis(CreateAppointmentDiagnosisRequest $request){

        $check = $this->diagnosis->querable()->where('appointment_id', $request->appointment_id)->first();
      if($check == null){
          $this->_data->update_($request->appointment_id,['status'=>'completed', 'appointment_step'=>5]);
          $appointment = $this->_data->getById($request->appointment_id);
          $doctorsuccess = $appointment->doctor->jobcountsuccess;
          $newcount = 1 + $doctorsuccess;
          $update_doctor_job = $appointment->doctor()->update(['jobcountsuccess' => $newcount]);

          $doctor_balance = $appointment->doctor->users->wallet->balance;
          $newbalance = $appointment->doctor_share + $doctor_balance;
          $doctorwallet = $appointment->doctor->users->wallet;
          $doctorwallet->update(['balance' => $newbalance]);
          $wallet_trans = $this->wallet_trans->add([
              "wallet_id" => $doctorwallet->id,
              "amount"    => $appointment->doctor_share,
              "status"    => 1,
              "action"    => "credit",
              "purpose"   => "credit doctor for appointment"
          ]);

          $transaction = $this->transaction->add([
            "reference_id" => $wallet_trans->id,
            "isdebit"   => 0,
            "payment_description" => "Doctor Appointment Payment",
            "amount" => $appointment->doctor_share,
            "payment_methods_id" => 4,
            "user_id" => $appointment->doctor->users->id
          ]);


          $medical = $this->biodata->querable()->where('user_id', $appointment->user->id)->first();


          $diagnosis = $this->diagnosis->add([
              "appointment_id"      => $request->appointment_id,
              "weight"              => $medical->weight,
              "height"              => $medical->height,
              "BMI"                 => $medical->bmi,
              "healthchallenges"    => $request->healthchallenges,
              "bloodgroup"          => $medical->bloodgroup,
              "genotype"            => $medical->genotype,
              "conclusion"          => $request->conclusion
          ]);

          return response()->json($diagnosis, 200);
        }else{
            return response()->json(['message'=> 'Unable to add diagnosis'], 200);
        }


    }

               /**
     * @OA\Get  (
    *     @OA\Parameter(
     *         name="id",
     *         in="path",
     * required=true,

     *         description="appointment id",

     *      ),
     *     path="/api/v1/appointment/getbyid/{id}",
     *     tags={"Appointment"},
     *     summary="To get a single apppointment",

     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     * )
     */
    public function getAppointmentById($id)
    {
        $check = $this->_data->querable()->where('id',$id)->with('appointmentdiagnosis')->first();
        return response()->json($check, 200);
    }


     /**
     * @OA\Patch  (
    *     @OA\Parameter(
     *         name="id",
     *         in="path",
     * required=true,

     *         description="id",

     *      ),
     *     path="/api/v1/appointment/labtest/skip/{id}",
     *     tags={"Appointment"},
     *     summary="To skip labtest for an appointment",

     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     * )
     */
    public function skipTest($id)
    {
        $data = [
            'appointment_step' => 3
        ];

        try {
            //code...
            $appointment = $this->_data->update_($id, $data);
            return response()->json( $appointment, 200 );
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json($th->getMessage(), 400);
        }

    }


               /**
     * @OA\Get  (
    *     @OA\Parameter(
     *         name="id",
     *         in="path",
     * required=true,

     *         description="userId",

     *      ),
     *     path="/api/v1/lastappointment/user/{id}",
     *     tags={"Appointment"},
     *     summary="To get the last or latest appointment of a user with the appointment diagnosis",

     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     * )
     */
    public function getUserLastAppointment($id)
    {

        try {
            //code...
            $appointments = $this->_data->querable()->where('user_id', $id)->with('appointmentdiagnosis')->get();
            $_appointments = collect($appointments);
            $appointment = $_appointments->last();
            return response()->json($appointment, 200);

        } catch (\Throwable $th) {
            //throw $th;
            return response()->json($th->getMessage(), 400);
        }
    }


            /**
     * @OA\Get  (
    *     @OA\Parameter(
     *         name="id",
     *         in="path",
     * required=true,

     *         description="Appointment Id",

     *      ),
     *     path="/api/v1/prescriptions/appointment/{id}",
     *     tags={"Appointment"},
     *     summary="To get the prescriptions of an appointment",

     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     * )
     */
    public function getDrugprescription($id)
    {
        $appointmentPrescriptions = $this->_data->querable()->where('id', $id)->with('drugPrescriptionItem')->first();
        return response()->json($appointmentPrescriptions, 200);
    }
}
