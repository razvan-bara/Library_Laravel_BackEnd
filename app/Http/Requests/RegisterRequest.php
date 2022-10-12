<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Symfony\Component\HttpFoundation\Response;

class RegisterRequest extends FormRequest
{
    public function failedValidation(Validator $validator)
    {
    throw new HttpResponseException(response()->json([
        'success'   => false,
        'message'   => 'Validation errors',
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
            'first_name' => 'required|string|regex:/^[a-zA-ZăâîșțĂÂÎȘȚ]+$/',
            'last_name' => 'required|string||regex:/^[a-zA-ZăâîșțĂÂÎȘȚ]+$/',
            'email' => 'required|email|string|unique:users,email',
            'password' => 'required|confirmed|min:8'
        ];
    }

    public function messages()
    {
        return [
            'first_name.regex' => 'Prenumele poate contine doar litere',
            'last_name.regex' => 'Numele poate contine doar litere',
            'first_name.required' => 'Prenume obligatoriu',
            'last_name.required' => 'Nume obligatoriu',
            'email.required' => 'Email obligatoriu',
            'email.email' => 'Nu este un email valid',
            'email.unique' => 'Email deja inregistrat',
            'password.required' => 'Parola obligatorie',
            'password.min' => 'Parola trebuie sa aiba un minim de :min caractere',
            'password.confirmed' => 'Parola difera de confirmare'
        ];
    }
}
