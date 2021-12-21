<?php

namespace App\Http\Requests\AuthRequest;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;


class UpdateUserRequest extends FormRequest
{
   /**
 *  @OA\Schema(
 *   schema="UpdateUserRequest",
 *   type="object",
 *   allOf={
 *       @OA\Schema(ref="#/components/schemas/UpdateUserRequest"),
 *       @OA\Schema(
 *         
 *           @OA\Property(property="facebook", format="string", type="string")
 *       ),
 *       @OA\Schema(
 *         
 *           @OA\Property(property="twitter", format="string", type="string")
 *       ),
 *       @OA\Schema(
 *         
 *           @OA\Property(property="bio", format="string", type="string")
 *       ),
 *  @OA\Schema(
 *         
 *           @OA\Property(property="instagram", format="string", type="string")
 *       ),

 *  @OA\Schema(
 *         
 *           @OA\Property(property="avatar", format="string", type="string")
 *       ),
 *  @OA\Schema(
 *         
 *           @OA\Property(property="linkedin", format="string", type="string")
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
