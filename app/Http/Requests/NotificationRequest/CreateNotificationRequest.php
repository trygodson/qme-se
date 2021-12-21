<?php

namespace App\Http\Requests\NotificationRequest;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;


class CreateNotificationRequest extends FormRequest
{
   /**
 *  @OA\Schema(
 *   schema="CreateNotificationRequest",
 *   type="object",
 *   allOf={
 *       @OA\Schema(ref="#/components/schemas/CreateNotificationRequest"),
 *       @OA\Schema(
 *         
 *           @OA\Property(property="user_id", format="integer", type="integer")
 *       ),
 *        @OA\Schema(
 *         
 *           @OA\Property(property="title", format="string", type="string")
 *       ),
 *    @OA\Schema(
 *         
 *           @OA\Property(property="type", format="string", type="string")
 *       ),
    * @OA\Schema(
    *         
    *           @OA\Property(property="description", format="string", type="string")
    *       ),
    *    @OA\Schema(
    *         
    *           @OA\Property(property="isread", format="boolean", type="boolean")
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
            'title'=>'required|string',
            'type'=>'required|string',
            'description'=>'required|string',
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