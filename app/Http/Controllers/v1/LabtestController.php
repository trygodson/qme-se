<?php

namespace App\Http\Controllers\v1;

use App\Models\Labtest;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;
use App\Helpers\CustomNotification;
use App\Interfaces\IUserRepository;
use App\Http\Controllers\Controller;
use App\Interfaces\IDoctorRepository;
use App\Interfaces\ILabTestRepository;
use App\Repositories\LabTestRepository;
use App\Http\Requests\LabtestRequest\CreateLabtestRequest;
use App\Http\Requests\LabtestRequest\UpdateResultRequest;



class LabtestController extends Controller
{

    private $labtest;
    private $user;
    private $doctor;   
    
    public function __construct(ILabTestRepository $labtest, IUserRepository $user, IDoctorRepository $doctor)
    {
        $this->labtest = $labtest;
        $this->user = $user;
        $this->doctor = $doctor;
    }


     //
     /**

     * @OA\Post  (

     *     path="/api/v1/labtest/add",

     *     tags={"Labtest"},

     *     summary="Create a new lab test for a user.",

     *     @OA\RequestBody(

     *         @OA\MediaType(

     *             mediaType="application/json",

     *             @OA\Schema(

     *                 type="object",

     *                 ref="#/components/schemas/CreateLabtestRequest",

     *             )

     *         )

     *     ),

     *      @OA\Response(

     *          response=401,

     *          description="Unauthenticated",

     *      ),
     * 
     *      

     * ),
     * 
     * 

     */
    public function store(CreateLabtestRequest $request)
    {
        $labtest= $this->labtest->add($request->all());

        return response()->json($labtest, 200);
    }



    /**

     * @OA\Get(

     *      path="/api/v1/user/labtest/{id}",

     *      operationId="id",

     *      tags={"Labtest"},

     *      summary="Returns a user lab tests",

     *      description="Returns lab tests of provided user id",

     *      @OA\Parameter(

     *         name="id",

     *         in="path",
     
     *         required=true,

     *         description="User Id",



     *      ),

     *      @OA\Response(

     *          response=401,

     *          description="Unauthenticated",

     *      ),

     *      @OA\Response(

     *          response=403,

     *          description="Forbidden"

     *      )

     *     )

     */
    
    public function getPatientTests($id)
    {
        $labtest = $this->user->querable()->where('id', $id)->with('labtests')->first();
        return response()->json($labtest, 200);
    }



     /**

     * @OA\Get(

     *      path="/api/v1/doctor/labtest/{id}",

     *      operationId="id",

     *      tags={"Labtest"},

     *      summary="Return lab tests from a doctor",

     *      description="Returns lab tests made by the provided doctor id",

     *      @OA\Parameter(

     *         name="id",

     *         in="path",

     *          required=true,

     *         description="Doctor Id",



     *      ),

     *      @OA\Response(

     *          response=401,

     *          description="Unauthenticated",

     *      ),

     *      @OA\Response(

     *          response=403,

     *          description="Forbidden"

     *      )

     *     )

     */

    public function getDoctorTestsRequests($id)
    {
        $labtest = $this->doctor->querable()->where('id', $id)->with('labtests')->get();
        return response()->json($labtest, 200);
    }


    /**
     * @OA\Patch  (
     
     *     path="/api/v1/lab/external/{id}",
     *     tags={"Labtest"},
     *     summary="change the state of isexternallab column to 1",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
 
     *         description="Appointment Id",
     
     *      ),
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 ref="#/components/schemas/UpdateIsExternalLabRequest",
     *             )
     *         )
     *     ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     * )
     */

   public function isExternalLabTrue($id)
   {
        $data = [
            'isexternallab' => 1
        ];

        try{

            $labtest = $this->labtest->update($id, $data);
    
            return response()->json($labtest, 201);
    
        } catch (\Throwable $ex) {
    
            return response()->json($ex->getMessage(), 400);
    
        }
   }


   /**
     * @OA\Patch  (
     
     *     path="/api/v1/lab/internal/{id}",
     *     tags={"Labtest"},
     *     summary="change the state of isexternallab column to 0",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
 
     *         description="Appointment Id",
     
     *      ),
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 ref="#/components/schemas/UpdateIsExternalLabRequest",
     *             )
     *         )
     *     ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     * )
     */
   public function isExternalLabFalse($id)
   {
        $data = [
            'isexternallab' => 0
        ];

        try{

            $labtest = $this->labtest->update($id, $data);

            // //Using Custom Notification class
            // $customNotification = new CustomNotification();

            // //setting custom notification parameters parameter
            // $subject = 'Lab Test Notification';
            // $body = '<h3>Test Request Notications for Labs</h3> ' . '<p> A test request has been sent to you be carried out. </p>';
            // $toemail = 'ucheemeka666.ue@gmail.com';
            // $toname = 'H-MEDIX LABS';
            

            //  $customNotification->sendmail( $body, $toname, $toemail, $subject );

            return response()->json($labtest, 201);

        } catch (\Throwable $ex) {

            return response()->json($ex->getMessage(), 400);

        }
   }



     /**

     * @OA\Get(

     *      path="/api/v1/labtests",

     *      operationId="getAllLabtests",

     *      tags={"Labtest"},

     *      summary="Return a json array of all the labtests sent to the user.",

     *      description="Returns all lab tests both the completed and uncompleted. If isdoctorended is placed in the URL as parameter with a value of
     * 1, it will return all completed tests. The opposite happens if the value of isdoctorended is made 0",

     *      @OA\Parameter(

     *         name="isdoctorended",

     *         in="parameter",

     *         required=false,

     *         description="Status of the lab test",



     *      ),

     *      @OA\Response(

     *          response=401,

     *          description="Unauthenticated",

     *      ),

     *      @OA\Response(

     *          response=403,

     *          description="Forbidden"

     *      )

     *     )

     */


   public function getLabTests()
   {

       try{

        // $labtest = $this->labtest->getLabTestPipeline($request->all());

        $labtests = app(Pipeline::class)
                    ->send(Labtest::query())
                    ->through([
                        \App\QueryFilters\Labtests\IsDoctorEnded::class
                    ])
                    ->thenReturn()
                    ->paginate(10)
                    ->all();

        return response()->json($labtests, 201);

        } catch (\Throwable $ex) {

            return response()->json($ex->getMessage(), 400);

        }

   }

   /**

     * @OA\Get(

     *      path="/v1/getlabtestbyappointmentid/{id}",

     *      operationId="getLabTestByAppointmentId",

     *      tags={"Labtest"},

     *      summary="Returns labtest object gotten via an appointment_id",

     *      description="Returns labtest object gotten via an appointment_id",

     *      @OA\Parameter(

     *         name="isdoctorended",

     *         in="parameter",

     *         required=false,

     *         description="Status of the lab test",



     *      ),

     *      @OA\Response(
**/
    public function getLabTestByAppointmentId($id) 
    {
        try{
            $check = $this->labtest->querable()->where('appointment_id', $id)->get();
            return response()->json($check, 200);
        } catch (\Throwable $ex) {
            return response()->json($ex->getMessage(), 400);
        }
    }




    /**
     * @OA\Patch  (
     
     *     path="/api/v1/isdoctorended/{id}",
     *     tags={"Labtest"},
     *     summary="change the state of isdoctorended column to 1 and changes the appointment step to 3",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
 
     *         description="Appointment Id",
     
     *      ),
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 ref="#/components/schemas/UpdateIsDoctorEndedRequest",
     *             )
     *         )
     *     ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     * )
     *

     *          response=401,

     *          description="Unauthenticated",

     *      ),

     *      @OA\Response(

     *          response=403,

     *          description="Forbidden"

     *      )

     *     )

     */

   

   public function isDoctorEnded($id)
   {
        $data = [
            'isdoctorended' => 1
        ];

        try {
            //code...
            $labtest = $this->labtest->update($id, $data);
            // return response()->json( $labtest, 200 );
            
            if( $labtest )
            {
                /**
                 * Getting the appointment from the Appointment Model from the provided appointment id;
                 * Updating the appointement_step of that appointment to 3
                 * **/
                
                $appointment = Appointment::findOrFail($id);
                $appointment->update([
                    'appointment_step' => 3
                ]);

                return response()->json( $labtest, 200 );
            }

        } catch (\Throwable $th) {
            //throw $th;
            return response()->json($th->getMessage(), 400);
        }
       
   }




   /**
     * @OA\Patch  (
     
     *     path="/api/v1/updateresult/labtest/{id}",
     *     tags={"Labtest"},
     *     summary="Update the result in the labtest table",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
 
     *         description="Appointment Id",
     
     *      ),
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 ref="#/components/schemas/UpdateResultRequest",
     *             )
     *         )
     *     ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     * )
     *

     *          response=401,

     *          description="Unauthenticated",

     *      ),

     *      @OA\Response(

     *          response=403,

     *          description="Forbidden"

     *      )

     *     )

     */

   public function updateResult(UpdateResultRequest $request, $id)
   {
        try {

            $appointment = $this->labtest->querable()->where('appointment_id', $id)->with('appointment')->first();  

            //getting the user {doctor} detials
            $doctor_id = $appointment->appointment->doctor_id;
            $doctor = $this->doctor->getById($doctor_id);
            $doctorId = $doctor->user_id;
            $doctorDetail = $this->user->getById($doctorId);

            //getting the user {patient} detials
            $user_id = $appointment->appointment->user_id;
            $userDetail = $this->user->getById($user_id);
            $userName =  $userDetail->firstname . ' ' . $userDetail->lastname; //holds retrieved patients/user email

            $doctorEmail = $doctorDetail->email; //holds retrieved doctors/user email
            $doctorName = $doctorDetail->firstname . ' ' . $doctorDetail->lastname; //holds retrieved doctors/user email

            // //Using Custom Notification class
            $customNotification = new CustomNotification();

            // //setting custom notification parameters parameter
            $subject = 'Lab Test Result Update Notification for ' . $userName;
            $body = '<h3>Lab test result notications for Doctor</h3> ' . '<p> A lab test has been updated. </p>';
            $toemail = $doctorEmail;
            $toname = $doctorName;
            
            //sending email
            $customNotification->sendmail( $body, $toname, $toemail, $subject );


            $result = $request->result;
            //code...
            $data = [
                'result' => $result
            ];
    
            $response = $this->labtest->update($id, $data);
            return response()->json($response, 200);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json($th->getMessage(), 400);
        }
   }

   
}
