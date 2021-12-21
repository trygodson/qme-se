<?php

namespace App\Http\Requests\AdminRequest;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class AppointmentFeeRequest extends FormRequest
{
   /**
 *  @OA\Schema(
 *   schema="AppointmentFeeRequest",
 *   type="object",
 *   allOf={
 *       @OA\Schema(ref="#/components/schemas/AppointmentRequest"),
 *       @OA\Schema(
 *
 *           @OA\Property(property="amount", format="integer", type="integer")
 *       ),
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
        'amount' => 'required|numeric',


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
