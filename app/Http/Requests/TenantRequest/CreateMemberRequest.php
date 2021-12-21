<?php

namespace App\Http\Requests\TenantRequest;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateMemberRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */

     /**
 *  @OA\Schema(
 *   schema="CreateMemberRequest",
 *   type="object",
 *   allOf={
 *       @OA\Schema(ref="#/components/schemas/CreateMemberRequest"),
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
 *           @OA\Property(property="password", format="string", type="string")
 *       ),
 *  @OA\Schema(
 *
 *           @OA\Property(property="gender", format="string", type="string")
 *       ),
 *
 *  @OA\Schema(
 *
 *           @OA\Property(property="tenant_id", format="integer", type="integer")
 *       ),
 * *  @OA\Schema(
 *
 *           @OA\Property(property="state_id", format="integer", type="integer")
 *       ),
 * @OA\Schema(
 *
 *           @OA\Property(property="tenant_role_id", format="integer", type="integer")
 *       ),
 *
 *   }
 * )
 */
    public function rules()
    {
        return [

            'firstname' => 'required|string',
            'lastname' => 'required|string',
            'phonenumber' => 'required|string||unique:users,phonenumber',
            'email' => 'required|string|unique:users,email',
            'password' => 'min:6|required_with:password_confirmation|same:password_confirmation',
            'password_confirmation' => 'min:6',
            'roles_id' => 'required|int',
            'state_id' => 'required|int',
            'tenant_id' => 'required|int',
            'tenant_role_id' => 'required|int',
            'gender' => 'required|string',


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
