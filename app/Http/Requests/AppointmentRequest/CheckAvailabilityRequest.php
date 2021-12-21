<?php

namespace App\Http\Requests\AppointmentRequest;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CheckAvailabilityRequest extends FormRequest
{
  /**
 *  @OA\Schema(
 *   schema="CheckAvailabilityRequest",
 *   type="object",
 *   allOf={
 *       @OA\Schema(ref="#/components/schemas/CheckAvailabilityRequest"),
 *       @OA\Schema(
 *
 *           @OA\Property(property="id", format="integer", type="integer")
 *       ),
 *  @OA\Schema(
 *
 *           @OA\Property(property="starts_at", format="string", type="string")
 *       ),
 *  @OA\Schema(
 *
 *           @OA\Property(property="ends_at", format="string", type="string")
 *       ),



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
        'id' => 'required|integer',
        'starts_at' => 'required',
        'ends_at' => 'required'

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
