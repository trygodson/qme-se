<?php

namespace App\Http\Requests\PharmacyRequest;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
class CreatePharmacyOrderRequest extends FormRequest
{
     /**
 *  @OA\Schema(
 *   schema="CreatePharmacyOrderRequest",
 *   type="object",
 *   allOf={
 *       @OA\Schema(ref="#/components/schemas/CreatePharmacyOrderRequest"),
 *       @OA\Schema(
 *         
 *           @OA\Property(property="tenant_id", format="integer", type="integer")
 *       ),
 *        @OA\Schema(
 *         
 *           @OA\Property(property="drug_prescription_id", format="integer", type="integer")
 *       ),
 *    @OA\Schema(
 *         
 *           @OA\Property(property="deliverychannel", format="integer", type="integer")
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
        'rating' => 'integer|max:5',
        'user_id'=>'required|integer',
        'rated_user_id'=>'required|integer',
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
