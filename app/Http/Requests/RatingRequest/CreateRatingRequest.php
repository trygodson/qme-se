<?php

namespace App\Http\Requests\RatingRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class CreateRatingRequest extends FormRequest
{
     /**
 *  @OA\Schema(
 *   schema="CreateRatingRequest",
 *   type="object",
 *   allOf={
 *       @OA\Schema(ref="#/components/schemas/CreateRatingRequest"),
 *       @OA\Schema(
 *         
 *           @OA\Property(property="user_id", format="integer", type="integer")
 *       ),
 *        @OA\Schema(
 *         
 *           @OA\Property(property="rating", format="integer", type="integer")
 *       ),
 *    @OA\Schema(
 *         
 *           @OA\Property(property="rated_user_id", format="integer", type="integer")
 *       ),
 * @OA\Schema(
 *         
 *           @OA\Property(property="appointment_id", format="integer", type="integer")
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
        'rating' => 'integer|max:5',
        'user_id'=>'required|integer',
        'rated_user_id'=>'required|integer',
        'appointment_id'=>'required|integer',
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
