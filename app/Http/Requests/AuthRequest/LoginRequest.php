<?php

namespace App\Http\Requests\AuthRequest;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
/**
 *  @OA\Schema(
 *   schema="LoginRequest",
 *   type="object",
 *   allOf={
 *       @OA\Schema(ref="#/components/schemas/LoginRequest"),
 *       @OA\Schema(
 *         
 *           @OA\Property(property="email", format="string", type="string")
 *       ),
 *       @OA\Schema(
 *         
 *           @OA\Property(property="password", format="string", type="string")
 *       )
 *   }
 * )
 */
    public function authorize()
    {
        return true;
    }

    public $name;
    
    public function rules()
    {
        return [
            'email' => 'required|string',
            'password' => 'required|string'
        ];
    }
}
