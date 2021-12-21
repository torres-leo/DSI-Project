<?php

namespace CompraVenta\Http\Requests;

use CompraVenta\Http\Requests\Request;
use Illuminate\Validation\Rule;
use Validator;
use Auth;

class UsuarioFormRequest extends Request
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
     * @return array
     */
    public function rules()
    {
        // INGRESAR LAS VALIDACIONES DE CADA PARAMETRO

        return [
            'name' => 'required|max:255',
            // 'email' => 'required|string|email|max:255|unique:users,email,' . $this->id, // to create
            'email' => 'required|string|email|max:255|unique:users,id,' . $this->id, // to update
            'password' => 'required|min:6|confirmed',
        ];
    }
}