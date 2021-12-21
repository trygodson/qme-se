<?php

namespace App\Http\Requests\WalletRequest;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateWithdrawalRequest extends FormRequest
{
/**
 *  @OA\Schema(
 *   schema="CreateWithdrawalRequest",
 *   type="object",
 *   allOf={
 *       @OA\Schema(ref="#/components/schemas/CreateWithdrawalRequest"),
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
        'amount' => 'required|integer',


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
