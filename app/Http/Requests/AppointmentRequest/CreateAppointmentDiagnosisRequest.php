<?php

namespace App\Http\Requests\AppointmentRequest;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateAppointmentDiagnosisRequest extends FormRequest
{
   /**
 *  @OA\Schema(
 *   schema="CreateAppointmentDiagnosisRequest",
 *   type="object",
 *   allOf={
 *       @OA\Schema(ref="#/components/schemas/CreateAppointmentDiagnosisRequest"),
 *       @OA\Schema(
 *
 *           @OA\Property(property="appointment_id", format="integer", type="integer")
 *       ),
 * @OA\Schema(
 *
 *           @OA\Property(property="conclusion", format="string", type="string")
 *       ),
 * @OA\Schema(
 *
 *           @OA\Property(property="healthchallenges", format="string", type="string")
 *       ),
 *
 *
 *
 *
 *
 *

 *
 *   }
 * )
 */
public function authorize()
{
    return true;
}

/**
 * Get the validation rules that apply to the request.
 *
 * @return array
 */
public function rules()
{
    return [
        'appointment_id' => 'required|integer',
        'healthchallenges' => 'string',
        'conclusion' => 'required|string',


    ];
}

protected function failedValidation(Validator $validator)
{



    $response = [
        'status' => 'failure',
        'status_code' => 400,
        'message' => 'Bad Request',
        'errors' => $validator->errors(),
    ];

    throw new HttpResponseException(response()->json($response, 400));
}
}
