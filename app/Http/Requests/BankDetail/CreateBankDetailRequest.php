<?php

namespace App\Http\Requests\Bankdetail;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;


class CreateBankDetailRequest extends FormRequest
{
   /**
 *  @OA\Schema(
 *   schema="CreateBankDetailRequest",
 *   type="object",
 *   allOf={
 *       @OA\Schema(ref="#/components/schemas/CreateBankDetailRequest"),
 *        @OA\Schema(
 *
 *           @OA\Property(property="bank", format="string", type="string")
 *       ),
 *    @OA\Schema(
 *
 *           @OA\Property(property="account_number", format="string", type="string")
 *       ),
 *     @OA\Schema(
 *
 *           @OA\Property(property="sort_code", format="string", type="string")
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

            'bank'=>'required|string',
            'account_number'=>'required|string|min:10|max:10',
            'sort_code'=>'required|string'
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
