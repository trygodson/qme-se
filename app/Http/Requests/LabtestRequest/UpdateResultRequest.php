<?php

namespace App\Http\Requests\LabtestRequest;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;


class UpdateResultRequest extends FormRequest
{
   /**
 *  @OA\Schema(
 *   schema="UpdateIsDoctorEndedRequest",
 *   type="object",
 *   allOf={
 *       @OA\Schema(ref="#/components/schemas/UpdateResultRequest"),
 *       @OA\Schema(
 *         
 *           @OA\Property(property="update", format="string", type="string")
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
            'result' => 'required|string'
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
