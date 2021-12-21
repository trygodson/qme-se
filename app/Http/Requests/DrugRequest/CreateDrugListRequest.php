<?php

namespace App\Http\Requests\DrugRequest;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;


class CreateDrugListRequest extends FormRequest
{
   /**
 *  @OA\Schema(
 *   schema="CreateDrugListRequest",
 *   type="object",
 *   allOf={
 *       @OA\Schema(ref="#/components/schemas/CreateDrugListRequest"),
 *       @OA\Schema(
 *         
 *           @OA\Property(property="name", format="string", type="string")
 *       ),
 *        @OA\Schema(
 *         
 *           @OA\Property(property="isavailable", format="boolean", type="boolean")
 *       ),
 *    @OA\Schema(
 *         
 *           @OA\Property(property="amount", format="decimal", type="decimal")
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
            'name' => 'string',
            'amount'=>'numeric',
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