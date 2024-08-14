<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IniciarSesionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'correo_electronico' => 'required|email',
            'password'           => 'required'
        ];
    }

    public function messages()
    {
        return [
            'password.required' => 'La contraseña es obligatoria',
            'password.min'      => 'La contraseña debe contener más de 8 caracteres'
        ];
    }

}
