<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Symfony\Component\HttpFoundation\Response;

class LoginRequest extends FormRequest
{
    public function failedValidation(Validator $validator)
    {
    throw new HttpResponseException(response()->json([
        'success'   => false,
        'message'   => 'Erori la creeare unui cont nou',
        'data'      => $validator->errors()
    ],Response::HTTP_FORBIDDEN));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'email' => 'required|email|string|exists:users,email',
            'password' => 'required|max:40'
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'Email obligatoriu',
            'email.email' => 'Nu este un email valid',
            'email.exists' => 'Email necunoscut',
            'password.required' => 'Parola obligatorie',
            'password.max' => 'Parola depaseste numarul de caractere permis',
            'password.confirmed' => 'Parolele nu se potrivesc'
        ];
    }
}
