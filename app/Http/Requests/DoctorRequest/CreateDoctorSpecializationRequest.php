<?php

namespace App\Http\Requests\DoctorRequest;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;


class CreateDoctorSpecializationRequest extends FormRequest
{
   /**
 *  @OA\Schema(
 *   schema="CreateDoctorSpecializationRequest",
 *   type="object",
 *   allOf={
 *       @OA\Schema(ref="#/components/schemas/CreateDoctorSpecializationRequest"),
 *       @OA\Schema(
 *         
 *           @OA\Property(property="doctor_id", format="integer", type="integer")
 *       ),
 *        @OA\Schema(
 *         
 *           @OA\Property(property="specialization_id", format="integer", type="integer")
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
         
            'specialization_id'=>'required|integer',
            
             ];
    }

    protected function failedValidation(Validator $validator)
    {



        $response = 
        [
            'status' => 'failure',
            'status_code' => 400,
            'message' => 'Bad Request',
            'errors' => $validator->errors(),
        ];

        throw new HttpResponseException(response()->json($response, 400));
    }
}
