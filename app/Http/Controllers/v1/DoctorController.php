<?php

namespace App\Http\Controllers\v1;

use Carbon\Carbon;

use App\Models\User;
use App\Models\Doctor;
use Illuminate\Pipeline\Pipeline;
use App\Http\Controllers\Controller;
use App\Models\DoctorSpecialization;
use App\Interfaces\IDoctorRepository;
use App\Interfaces\IAppointmentRepository;
use Illuminate\Contracts\Support\Jsonable;
use App\Interfaces\IAppointmentDiagnosisRepository;
use App\Http\Requests\AdminRequest\ChangeStateRequest;
use App\Http\Requests\DoctorRequest\CreateDoctorRequest;
use App\Http\Requests\DoctorRequest\UpdateDoctorRequest;

class DoctorController extends Controller
{
    private $_data;
    private $appointment;




    public function __construct(IDoctorRepository $data, IAppointmentRepository $appointment)
    {
        $this->_data = $data;
        $this->appointment = $appointment;

    }
        /**
     * @OA\Post  (

     *     path="/api/v1/doctor/create",
     *     tags={"Doctor"},
     *     summary="register a doctor",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 ref="#/components/schemas/CreateDoctorRequest",
     *             )
     *         )
     *     ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     * )
     */
    public function  register(CreateDoctorRequest $request)
    {

        try {

            $user = request()->user();
            $request['user_id']=$user->id;
            $request['ratercount']=0;
            $request['availability']='online';
            $action = $this->_data->add($request->all());

            if ($action == true)
            {
                return response()->json($action, 201);

            } else
            {
                return response()->json(["message"=>"This Account Have Been Registered "], 400);
            }
        } catch (\Throwable $ex) {

            return response()->json($ex->getMessage(), 400);
        }
    }
            /**
     * @OA\Patch  (

     *     path="/api/v1/doctor/changestate/{id}",
     *     tags={"Administrator"},
     *     summary="change the state of a doctor",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     * required=true,

     *         description="Doctors Id",

     *      ),
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 ref="#/components/schemas/ChangeStateRequest",
     *             )
     *         )
     *     ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     * )
     */
    public function  adminchangestate($id,ChangeStateRequest $request)
    {

        try {

            $action = $this->_data->update_($id, $request->all());
            return response()->json($action, 200);
        } catch (\Throwable $ex) {

            return response()->json($ex->getMessage(), 400);
        }
    }
      /**
     * @OA\Get(
     *      path="/api/v1/doctors",
     *      operationId="getDoctors",
     *      tags={"Administrator"},
     *      summary="Get list of doctors",
     *      description="Returns list of all doctors",
     *      @OA\Parameter(
     *         name="page",
     *         in="query",
     *         description="Page Size",

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
    public function getalldoctors()
    {
        $pipeline=app(Pipeline::class)
        ->send($this->_data->querable() ->with('users',))
        ->through([
            \App\QueryFilters\IsDeleted::class,
         ])

        ->thenReturn()
        ->paginate();
        $lastpage = collect(['lastpage' => $pipeline->lastPage()]);
       $data = $lastpage->merge($pipeline);
       return  response()->json($pipeline,200);
    }


         /**
     * @OA\Get  (
    *     @OA\Parameter(
     *         name="id",
     *         in="path",
     * required=true,

     *         description="Doctors Id",

     *      ),
     *     path="/api/v1/doctordetail/{id}",
     *     tags={"Doctor"},
     *     summary="to get doctor detail",

     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     * )
     */
    public function getdoctor($id)
    {



        try {
            $action = $this->_data->getById($id);
            return response()->json($action, 200);
          } catch (\Throwable $ex)
          {
                $message = "Doctor not found";
              return response()->json($message, 400);
          }
    }

     /**
     * @OA\Get  (
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,

     *         description="Doctors Id",

     *      ),
     *     path="/api/v1/doctordetail/user/{id}",
     *     tags={"Doctor"},
     *     summary="to get doctor detail",

     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     * )
     */
    public function getdoctoruserId($id)
    {
        try {
          $action = $this->_data->querable()->where('user_id',$id)->first();
          if ($action !=null){
            return response()->json($action, 200);
          }else{
            return response()->json($action, 400);
          }

        } catch (\Throwable $ex)
        {

            return response()->json($ex->getMessage(), 400);
        }

    }

    /**
     * @OA\Patch  (

     *     path="/api/v1/updatedoctor",
     *     tags={"Doctor"},
     *     summary="to update user detail",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 ref="#/components/schemas/UpdateDoctorRequest",
     *             )
     *         )
     *     ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     * )
     */
    public function updatedoctor(UpdateDoctorRequest $request)
    {
        $user = request()->user();
        $query= $this->_data->querable()->where('user_id',$user->id)->first();
        $action = $this->_data->update_($query->id, $request->all());
        return response()->json($action, 200);
    }

     /**
     * @OA\Get  (
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,

     *         description="Doctors Id",

     *      ),
     *     path="/api/v1/doctor/detailscount/{id}",
     *     tags={"Doctor"},
     *     summary="to get doctor appointtment statistics",

     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     * )
     */
    public function detailscount($id){
        $appointment = $this->appointment->querable()->where('doctor_id', $id)->get();
        $pending = $this->appointment->querable()->where('doctor_id', $id)->where('status', 'processing')->get();
        $finished =  $this->appointment->querable()->where('doctor_id', $id)->where('status', 'completed')->get();
        $canceled =  $this->appointment->querable()->where('doctor_id', $id)->where('status', 'canceled')->get();

        $response = [
            'total_appointments' => $appointment->count(),
            'pending_appointments' => $pending->count(),
            'completed_appointments' => $finished->count(),
            'canceled_appointments' => $canceled->count()
        ];

        return response()->json($response, 200);
     }


     /**
     * @OA\Get  (
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,

     *         description="Doctors Id",

     *      ),
     *     path="/api/v1/doctor/account/{id}",
     *     tags={"Doctor"},
     *     summary="To get doctor's accounting data",

     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     * )
     */
     public function account($id){
        $start = Carbon::now()->startOfWeek();
        $end = Carbon::now()->EndOfWeek();
         $total = $this->appointment->querable()->where('doctor_Id', $id)->where('status', 'completed')->get();
         $totalamount = $total->sum('doctor_share');
         $today = $this->appointment->querable()->where('doctor_Id', $id)->where('status', 'completed')->where('updated_at','>=', Carbon::today())->get();
         $todaysum = $today->sum('doctor_share');
         $week = $this->appointment->querable()->where('doctor_Id', $id)->where('status', 'completed')->where('updated_at','>=', $start)->where('updated_at', '<=', $end)->get();
         $weeksum = $week->sum('doctor_share');
         $pending = $this->appointment->querable()->where('doctor_Id', $id)->where('status', '!=', 'completed')->where('transaction_status', 'success')->get();
         $pendingsum = $pending->sum('doctor_share');

         $message = [
            'totalamount' => $totalamount,
            'todayamount' => $todaysum,
            'thisweekamount'=> $weeksum,
            'pendingbalance' => $pendingsum
         ];
         return response()->json($message, 200);
     }
}
