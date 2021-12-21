<?php

namespace App\Http\Requests\DoctorRequest;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;


class UpdateDoctorRequest extends FormRequest
{
   /**
 *  @OA\Schema(
 *   schema="UpdateDoctorRequest",
 *   type="object",
 *   allOf={
 *       @OA\Schema(ref="#/components/schemas/UpdateDoctorRequest"),
 *       @OA\Schema(
 *         
 *           @OA\Property(property="consultation_fee", format="float128bit", type="number", )
 *       ),
 *        @OA\Schema(
 *         
 *           @OA\Property(property="yearsofexperience", format="integer", type="integer")
 *       ),
 *    @OA\Schema(
 *         
 *        @OA\Property(property="availability", format="string", type="string")
 *       ),
 *    @OA\Schema(
 *         
 *           @OA\Property(property="proffessional_bio", format="string", type="string")
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
            
           
            'consultation_fee',
           
            'availability',
            'proffessional_bio',
            'yearsofexperience'
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
