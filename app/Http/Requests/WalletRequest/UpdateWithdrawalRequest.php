<?php

namespace App\Http\Requests\WalletRequest;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateWithdrawalRequest extends FormRequest
{
/**
 *  @OA\Schema(
 *   schema="UpdateWithdrawalRequest",
 *   type="object",
 *   allOf={
 *       @OA\Schema(ref="#/components/schemas/UpdateWithdrawalRequest"),
 *       @OA\Schema(
 *
 *           @OA\Property(property="status", format="string", type="string")
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
        'status' => 'required|string',


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
