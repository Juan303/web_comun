<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class ContactoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (Route::has('login')) {
            return Auth::check();
        }
        return true;
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
                    'email' => 'required|email',
                    'mensaje' => 'required|min:3',
                    'g-recaptcha-response' => 'required|recaptchav3:register,0.5'
                ];
            case 'PUT':
                return [];
        }
    }
}
