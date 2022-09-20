<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UsuarioRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        switch ($this->method()){
            case 'GET':
            case 'DELETE':
                return [];
            case 'POST':
                return [
                    'nombre' => 'required|min:3',
                    'email' => 'required|email|unique:usuarios',
                    'password' => 'required|confirmed',
                    'password_confirmation' => 'required'
                ];
            case 'PUT':
                return [
                    'nombre' => 'required|min:3',
                    'email' => "required|email|unique:usuarios,email,".$this->route()->usuario->id.",id", //validamos excepto si ponemos el mismo mail que tenemos
                    'password' => 'nullable|min:6|confirmed',
                    'password_confirmation' => 'nullable|min:6'
                ];
        }
    }
}
