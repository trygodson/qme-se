<?php

namespace App\Http\Requests\LabtestRequest;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;


class UpdateIsExternalLabRequest extends FormRequest
{
   /**
 *  @OA\Schema(
 *   schema="UpdateIsExternalLabRequest",
 *   type="object",
 *   allOf={
 *       @OA\Schema(ref="#/components/schemas/UpdateIsExternalLabRequest"),
 *       @OA\Schema(
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
            'appointment_id' => 'required|integer',
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
