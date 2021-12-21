<?php

namespace App\Http\Requests\AdminRequest;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;


class ChangeStateRequest extends FormRequest
{
   /**
 *  @OA\Schema(
 *   schema="ChangeStateRequest",
 *   type="object",
 *   allOf={
 *       @OA\Schema(ref="#/components/schemas/ChangeStateRequest"),
 *       @OA\Schema(
 *         
 *           @OA\Property(property="is_deleted", format="boolean", type="boolean")
 *       ),
 *        @OA\Schema(
 *         
 *           @OA\Property(property="isactivated", format="boolean", type="boolean")
 *       ),
 *       @OA\Schema(
 *         
 *           @OA\Property(property="isverified", format="boolean", type="boolean")
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
            'is_deleted',
            'isactivated',
            'isverified'
            
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
