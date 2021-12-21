<?php

namespace App\Http\Requests\SpecializationRequest;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;


class CreateSpecializationRequest extends FormRequest
{
   /**
 *  @OA\Schema(
 *   schema="CreateSpecializationRequest",
 *   type="object",
 *   allOf={
 *       @OA\Schema(ref="#/components/schemas/CreateSpecializationRequest"),
 *       @OA\Schema(
 *         
 *           @OA\Property(property="name", format="string", type="string")
 *       ),
 *       @OA\Schema(
 *         
 *           @OA\Property(property="description", format="string", type="string")
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
            'name' => 'required|string',
            'description' => 'required|string',
            
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
