<?php

namespace App\Http\Requests\AuthRequest;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class IDRequest extends FormRequest
{
/**
 *  @OA\Schema(
 *   schema="IDRequest",
 *   type="object",
 *   allOf={
 *       @OA\Schema(ref="#/components/schemas/IDRequest"),
 *       @OA\Schema(
 *         
 *           @OA\Property(property="id", format="int", type="integer")
 *       ),

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
            'id' => 'required|int',
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
