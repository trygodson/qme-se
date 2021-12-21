<?php

namespace App\Http\Requests\DrugRequest;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;


class CreatePrescriptionRequest extends FormRequest
{
   /**
 *  @OA\Schema(
 *   schema="CreatePrescriptionRequest",
 *   type="object",
 *   allOf={
 *       @OA\Schema(ref="#/components/schemas/CreatePrescriptionRequest"),
 *       @OA\Schema(
 *         
 *           @OA\Property(property="drug_prescription_id", format="integer", type="integer")
 *       ),
 *        @OA\Schema(
 *         
 *           @OA\Property(property="name", format="string", type="string")
 *       ),
 *    @OA\Schema(
 *         
 *           @OA\Property(property="dosage_description", format="string", type="string")
 *       ),
    * @OA\Schema(
    *         
    *           @OA\Property(property="amount", format="integer", type="integer")
    *       ),
    *    @OA\Schema(
    *         
    *           @OA\Property(property="total", format="integer", type="integer")
    *       ),
    *    @OA\Schema(
    *         
    *           @OA\Property(property="appointment_id", format="integer", type="integer")
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
            'total'=>'required|integer',
            'appointment_id'=>'required|integer',
            'drugs' => 'required'
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