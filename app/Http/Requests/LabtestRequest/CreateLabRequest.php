<?php

namespace App\Http\Requests\LabtestRequest;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;


class CreateLabRequest extends FormRequest
{
   /**
 *  @OA\Schema(
 *   schema="CreateLabRequest",
 *   type="object",
 *   allOf={
 *       @OA\Schema(ref="#/components/schemas/CreateLabRequest"),
 *       @OA\Schema(
 *         
 *           @OA\Property(property="tenant_id", format="integer", type="integer")
 *       ),
 *        @OA\Schema(
 *         
 *           @OA\Property(property="labtest_id", format="integer", type="integer")
 *       ),
    *    @OA\Schema(
    *         
    *           @OA\Property(property="delivery_type", format="string", type="string")
    *       ),
    *    @OA\Schema(
    *         
    *          @OA\Property(property="integer", format="integer", type="integer")
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
            'tenant_id' => 'required|integer',
            'labtest_id'=>'required|integer',
            'delivery_type'=>'required|string',
            'amount' => 'required|integer'
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
