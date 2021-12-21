<?php

namespace App\Http\Controllers\v1;



use App\Http\Controllers\Controller;
use App\Http\Requests\AdminRequest\ChangeStateRequest;

use App\Http\Requests\DoctorRequest\UpdateDoctorSpecializationRequest;
use App\Http\Requests\DoctorRequest\CreateDoctorSpecializationRequest;
use App\Interfaces\IDoctorRepository;
use App\Interfaces\IDoctorSpecializationRepository;
use Illuminate\Pipeline\Pipeline;

class DoctorSpecializationController extends Controller
{
    private $_data;
    private $_doctordata;





    public function __construct(IDoctorSpecializationRepository $data,IDoctorRepository $doctordata)
    {
        $this->_data = $data;
        $this->_doctordata=$doctordata;

    }
        /**
     * @OA\Post  (

     *     path="/api/v1/doctorspecialization/create",
     *     tags={"Doctor"},
     *     summary="doctors add thier specializations",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 ref="#/components/schemas/CreateDoctorSpecializationRequest",
     *             )
     *         )
     *     ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     * )
     */
    public function  register(CreateDoctorSpecializationRequest $request)
    {

        try {

            $user = request()->user();
            $query=$this->_doctordata->querable()->where('user_id',$user->id)->first();
            $request['doctor_id']=$query->id;
            $check_if_doctor_specialization_exist=$this->_data->querable()->where('doctor_id',$query->id)->first();

            if ($check_if_doctor_specialization_exist ==null)
            {
                $action = $this->_data->add($request->all());
                $data = [
                    "is_specialization" => true
                ];
                $query->update($data);
                if($action ==true)
                {
                    return response()->json($action, 201);
                }else
                {
                    return response()->json(["message"=>"Sorry We cant Process your request at the moment"], 400);

                }


            }
            else
            {
                return response()->json(["message"=>"You already have this specialization"], 400);
            }
        } catch (\Throwable $ex) {

            return response()->json($ex->getMessage(), 400);
        }
    }

         /**
     * @OA\Get  (
    *     @OA\Parameter(
     *         name="specialization_id",
     *         in="query",


     *         description="For SPecialization",

     *      ),
     *      @OA\Parameter(
     *         name="availability",
     *         in="query",


     *         description="For SPecialization",

     *      ),
     *     path="/api/v1/doctorsearch",
     *     tags={"Doctor"},
     *     summary="to get doctor detail",

     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     * )
     */
    public function getdoctorbysearch()
    {
        $pipeline=app(Pipeline::class)
        ->send($this->_data->querable()->with(['doctors','doctors.users']))
        ->through([
            \App\QueryFilters\Doctor\SpecializationId::class,
            \App\QueryFilters\Doctor\Availability::class
         ])

        ->thenReturn()
        ->paginate(10);
       return  response()->json($pipeline,200);

    return  $pipeline;
    }


                  /**
     * @OA\Get  (
    *     @OA\Parameter(
     *         name="id",
     *         in="path",
     * required=true,

     *         description="doctor id",

     *      ),
     *     path="/api/v1/doctor/specialization/{id}",
     *     tags={"Doctor"},
     *     summary="To get the doctor's specializtation",

     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     * )
     */
    public function doctorspecialization($id){
        $spec = $this->_doctordata->getById($id)->specialization()->get();

        if($spec){
            return response()->json($spec, 200);
        }
    }
}
