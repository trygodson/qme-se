<?php

namespace App\Http\Requests\AuthRequest;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class VerifyRequest extends FormRequest
{
  /**
 *  @OA\Schema(
 *   schema="VerifyRequest",
 *   type="object",
 *   allOf={
 *       @OA\Schema(ref="#/components/schemas/VerifyRequest"),
 *       @OA\Schema(
 *         
 *           @OA\Property(property="id", format="int", type="integer")
 *       ),
 *        @OA\Schema(
 *         
 *           @OA\Property(property="password", format="string", type="string")
 *       ),
 *       @OA\Schema(
 *         
 *           @OA\Property(property="pin", format="string", type="string")
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
            'id' => 'required|int',
            'pin' => 'required|string',
           
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
