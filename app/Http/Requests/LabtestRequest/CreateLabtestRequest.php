<?php

namespace App\Http\Requests\LabtestRequest;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;


class CreateLabtestRequest extends FormRequest
{
   /**
 *  @OA\Schema(
 *   schema="CreateLabtestRequest",
 *   type="object",
 *   allOf={
 *       @OA\Schema(ref="#/components/schemas/CreateLabtestRequest"),
 *       @OA\Schema(
 *         
 *           @OA\Property(property="appointment_id", format="integer", type="integer")
 *       ),
 *        @OA\Schema(
 *         
 *           @OA\Property(property="title", format="string", type="string")
 *       ),
    *    @OA\Schema(
    *         
    *           @OA\Property(property="result", format="string", type="string")
    *       ),
    *    @OA\Schema(
    *         
    *          @OA\Property(property="description", format="string", type="string")
    *    ),

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
            'title'=>'required|string',
            'result'=>'string',
            'description' => 'required|string'
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
