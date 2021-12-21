<?php

namespace App\Http\Controllers\v1;

use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Models\DrugPrescription;
use App\Http\Controllers\Controller;
use App\Interfaces\IDrugPrescriptionRepository;
use App\Http\Requests\DrugRequest\UpdatePrescriptionRequest;

class DrugPrescriptionController extends Controller
{
    private $drugprescriptionRepository;

    public function __construct(IDrugPrescriptionRepository $drugprescriptionRepository) {
        $this->drugprescriptionRepository = $drugprescriptionRepository;
    }

    /**
     * @OA\Post  (
     *     path="/api/v1/drug/delivery/{id}",
     *     tags={"Drug Prescription"},
     *     summary="user chooses how he wants to recieve drug",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 ref="#/components/schemas/UpdatePrescriptionRequest",
     *             )
     *         )
     *     ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     * )
     */
    public function setDeliveryType(UpdatePrescriptionRequest $request, $id) {
        $deliveryType = DrugPrescription::findOrFail($id);
        $data = [
            'delivery_type' => $request->delivery_type
        ];

        $deliveryType->update($data);

        $appointment_step = Appointment::find($deliveryType->appointment_id);

        $appointment_data = [
            'appointment_step' => 4
        ];

        return $appointment_step->update($appointment_data);
    }

     /**
     * @OA\Get(
     *      path="/api/v1/drug/prescription/byappointment/",
     *      operationId="getByAppointmentId",
     *      tags={"Drug Prescription"},
     *      summary="Get prescription by appointment id",
     *      description="Returns the prescription the specified user",
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

    public function getByAppointmentId()
    {
        $drugprescription = $this->drugprescriptionRepository->getByAppointmentId();
        return response()->json($drugprescription, 200);
    }
} 
