<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class RegistroRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'  => ['required', 'string'],
            'email' => ['required' , 'email' , 'unique:users,email'],
            'password' =>[
                'required',
                'confirmed',
                Password::min(2)
                //Password::min(8)->letters()->symbols()->numbers()
                
            ]
        ];
    }



    public function messages()
    {
        return [
            'name' => 'El nombre es obligatorio',
            'email.required' => 'El nombre es obligatorio',
            'email.email' => 'El email no es valido',
            'email.unique' => 'El email ya existe',
            'password' => 'El password debe contener al menos 8 caracteres',
            'password.confirmed' => 'No coinciden las contraseñas'
        ];
    }
}
