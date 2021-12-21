<?php

namespace App\Http\Requests\TenantRequest;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ChangeTenant extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */


       /**
 *  @OA\Schema(
 *   schema="ChangeTenantStatus",
 *   type="object",
 *   allOf={
 *       @OA\Schema(ref="#/components/schemas/ChangeTenantStatus"),
 *       @OA\Schema(
 *
 *           @OA\Property(property="status", format="integer", type="integer")
 *       ),
 *
 *
 *   }
 * )
 */
    public function rules()
    {
        return [
            'status' => 'required|int',
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
