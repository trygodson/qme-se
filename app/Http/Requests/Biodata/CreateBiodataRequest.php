<?php

namespace App\Http\Requests\Biodata;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;


class CreateBiodataRequest extends FormRequest
{
   /**
 *  @OA\Schema(
 *   schema="CreateBiodataRequest",
 *   type="object",
 *   allOf={
 *       @OA\Schema(ref="#/components/schemas/CreateBiodataRequest"),
 *       @OA\Schema(
 *         
 *           @OA\Property(property="user_id", format="integer", type="integer")
 *       ),
 *        @OA\Schema(
 *         
 *           @OA\Property(property="weight", format="integer", type="integer")
 *       ),
 *    @OA\Schema(
 *         
 *           @OA\Property(property="height", format="integer", type="integer")
 *       ),
 *     @OA\Schema(
 *         
 *           @OA\Property(property="boodgroup", format="string", type="string")
 *       ),
 *      @OA\Schema(
 *         
 *           @OA\Property(property="genotype", format="string", type="string")
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
            'user_id' => 'required|integer',
            'weight'=>'required|numeric',
            'height'=>'required|numeric',
            'bloodgroup'=>'required|string',
            'genotype'=>'required|string',
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