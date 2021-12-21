<?php

namespace App\Http\Requests\AppointmentRequest;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;


class CreateAppointmentRequest extends FormRequest
{
   /**
 *  @OA\Schema(
 *   schema="CreateAppointmentRequest",
 *   type="object",
 *   allOf={
 *       @OA\Schema(ref="#/components/schemas/CreateAppointmentRequest"),
 *       @OA\Schema(
 *
 *           @OA\Property(property="specialization_id", format="integer", type="integer")
 *       ),
 *       @OA\Schema(
 *
 *           @OA\Property(property="doctor_id", format="integer", type="integer")
 *       ),
 *       @OA\Schema(
 *
 *           @OA\Property(property="amount", format="decimal", type="number")
 *       ),
  *       @OA\Schema(
 *
 *           @OA\Property(property="user_id", format="integer", type="integer")
 *       ),
 *         @OA\Schema(
 *
 *           @OA\Property(property="note", format="string", type="string")
 *       ),
 *         @OA\Schema(
 *
 *           @OA\Property(property="starts_at", format="datatime", type="string")
 *       ),
 *          @OA\Schema(
 *
 *           @OA\Property(property="ends_at", format="datetime", type="string")
 *       ),
 *          @OA\Schema(
 *
 *           @OA\Property(property="ref_id", format="string", type="string")
 *       ),
 *      @OA\Schema(
 *
 *           @OA\Property(property="payment_methods_id", format="integer", type="integer")
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
            'specialization_id' => 'required|integer',
            'doctor_id' => 'required|integer',
            'user_id' => 'required|integer',
            'amount'=>'required',
            'note'=>'required',
            'starts_at'=>'required',
            'ends_at'=>'required',
            'ref_id' => 'required',
            'payment_methods_id' => 'required'

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
