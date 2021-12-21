<?php

namespace App\Http\Requests\DoctorRequest;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;


class CreateDoctorRequest extends FormRequest
{
   /**
 *  @OA\Schema(
 *   schema="CreateDoctorRequest",
 *   type="object",
 *   allOf={
 *       @OA\Schema(ref="#/components/schemas/CreateDoctorRequest"),
 *       @OA\Schema(
 *         
 *           @OA\Property(property="folio_id", format="string", type="string")
 *       ),
 *        @OA\Schema(
 *         
 *           @OA\Property(property="yearsofexperience", format="integer", type="integer")
 *       ),
 *    @OA\Schema(
 *         
 *           @OA\Property(property="proffessional_bio", format="string", type="string")
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
            'folio_id' => 'required|string',
            'yearsofexperience'=>'required|integer',
            'proffessional_bio'=>'required|string',
            'qualification'=>'required|string',
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
