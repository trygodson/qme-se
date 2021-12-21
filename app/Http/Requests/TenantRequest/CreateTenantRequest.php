<?php

namespace App\Http\Requests\TenantRequest;


use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateTenantRequest extends FormRequest
{
/**
 *  @OA\Schema(
 *   schema="CreateTenantRequest",
 *   type="object",
 *   allOf={
 *       @OA\Schema(ref="#/components/schemas/CreateTenantRequest"),
 *       @OA\Schema(
 *
 *           @OA\Property(property="email", format="string", type="string")
 *       ),
 *
 *  @OA\Schema(
 *
 *           @OA\Property(property="phonenumber", format="string", type="string")
 *       ),
 *  @OA\Schema(
 *
 *           @OA\Property(property="roles_id", format="int32", type="integer")
 *       ),
 *  @OA\Schema(
 *
 *           @OA\Property(property="firstname", format="string", type="string")
 *       ),
 *  @OA\Schema(
 *
 *           @OA\Property(property="lastname", format="string", type="string")
 *       ),
  *  @OA\Schema(
 *
 *           @OA\Property(property="city", format="string", type="string")
 *       ),
 *  @OA\Schema(
 *
 *           @OA\Property(property="address", format="string", type="string")
 *       ),
 *  @OA\Schema(
 *
 *           @OA\Property(property="name", format="string", type="string")
 *       ),
 *
 *  @OA\Schema(
 *
 *           @OA\Property(property="state_id", format="integer", type="integer")
 *       ),
 * @OA\Schema(
 *
 *           @OA\Property(property="tenant_type_id", format="integer", type="integer")
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
        
        'admin' => 'required',
        'tenant' => 'required',
        
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
