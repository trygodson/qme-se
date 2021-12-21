<?php

namespace App\Http\Requests\DrugRequest;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;


class UpdatePrescriptionRequest extends FormRequest
{
   /**
 *  @OA\Schema(
 *   schema="UpdatePrescriptionRequest",
 *   type="object",
 *   allOf={
 *       @OA\Schema(ref="#/components/schemas/UpdatePrescriptionRequest"),
 *       @OA\Schema(
 *         
 *           @OA\Property(property="delivery_type", format="string", type="string")
 *       ),
 *        @OA\Schema(
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
            'delivery_type' => 'required|string',
            'appoinment_step'=>'integer',
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