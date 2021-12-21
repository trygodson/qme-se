<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminRequest\AppointmentFeeRequest;
use App\Interfaces\IAppointmentRepository;
use App\Interfaces\IDoctorRepository;
use App\Interfaces\IDrugListRepository;
use App\Interfaces\ILabTestRequestRepository;
use App\Interfaces\IPharmacyOrderRepository;
use App\Interfaces\ISystemsettingsRepository;
use App\Interfaces\ITenantRepository;
use App\Interfaces\IUserRepository;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    private $appointment;
    private $user;
    private $doctor;
    private $tenant;
    private $drug;
    private $labtest;
    private $prescription;
    private $settings;

    public function __construct(IUserRepository $user, IAppointmentRepository $appointment, IDoctorRepository $doctor, ITenantRepository $tenant, IDrugListRepository $drug, ILabTestRequestRepository $labtest, IPharmacyOrderRepository $prescription, ISystemsettingsRepository $settings)
    {
        $this->appointment = $appointment;
        $this->user = $user;
        $this->doctor = $doctor;
        $this->tenant = $tenant;
        $this->drug = $drug;
        $this->prescription = $prescription;
        $this->labtest = $labtest;
        $this->settings = $settings;
    }



 /**
     * @OA\Get(
     *      path="/api/v1/administrator/summary",
     *      operationId="getSummary",
     *      tags={"Administrator"},
     *      summary="To get count of summary of the application",
     *      description="Returns counts",
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
    public function summary(){
        $users = $this->user->getAll()->count();
        $doctors = $this->doctor->getAll()->count();
        $appointments = $this->appointment->getAll()->count();
        $drug = $this->drug->getAll()->count();
        $tenant = $this->tenant->getAll()->count();
        $labtest = $this->labtest->getAll()->count();
        $prescription = $this->prescription->getAll()->count();

        $message =  [
            'users' => $users,
            'doctors' => $doctors,
            'appointments' => $appointments,
            'drugs' => $drug,
            'tenant' => $tenant,
            'labtest' => $labtest,
            'prescription' => $prescription
        ];

        return response()->json($message, 200);

    }
    /**
     * @OA\Get(
     *      path="/api/v1/administrator/appointments",
     *      operationId="getAppointments",
     *      tags={"Administrator"},
     *      summary="To get all appointments details",
     *      description="Returns Appointments",
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

    public function getappointments(){
        $appointment = $this->appointment->querable()->where('id', '>', 0)->with(['doctor' => function($query){
            $query->with('users');
        }])->with('user')->paginate(10);

        return response()->json($appointment, 200);
    }

    /**
     * @OA\Post  (
     *     path="/api/v1/adminstrator/appointmentfee/update",
     *     tags={"Administrator"},
     *     summary="Adjust appointment fee",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 ref="#/components/schemas/AppointmentFeeRequest",
     *             )
     *         )
     *     ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     * )
     */
    public function setfee(AppointmentFeeRequest $request){
            $check = $this->settings->querable()->where('key', 'appointmentfee')->first();
            if($check != null){
                $setting = $this->settings->update_($check->id, ['value' => $request->amount]);
                if($setting){
                    return response()->json($setting, 200);
                }
            }else{
                $setting = $this->settings->add([
                    'key' => 'appointmentfee',
                    'value' => $request->amount
                ]);
                if($setting){
                    return response()->json($setting, 200);
                }
            }
    }

    public function getfee(){
        $fee = $this->settings->querable()->where('key', 'appointmentfee')->first();
        if($fee != null){
            return response()->json($fee, 200);
        }else{
            return response()->json(['message' => 'Appointment fee has not been set']);
        }
    }
}

