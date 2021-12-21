<?php

namespace App\Http\Requests\AuthRequest;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ChangePasswordRequest extends FormRequest
{
  /**
 *  @OA\Schema(
 *   schema="ChangePasswordRequest",
 *   type="object",
 *   allOf={
 *       @OA\Schema(ref="#/components/schemas/ChangePasswordRequest"),
 *       @OA\Schema(
 *         
 *           @OA\Property(property="id", format="int", type="integer")
 *       ),
 *       @OA\Schema(
 *         
 *           @OA\Property(property="password", format="string", type="string")
 *       ),
 *   @OA\Schema(
 *         
 *           @OA\Property(property="email", format="string", type="string")
 *       )
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

            'id' ,
            'password' ,
            'email'
           
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
