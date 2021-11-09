<?php

namespace CompraVenta\Http\Requests;

use CompraVenta\Http\Requests\Request;

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
        return [
            'name' => 'required|max:255',
            'email' => 'required|string|email|max:255|unique:users,id' . $this->id,
            // 'email' => 'required|email|max:255|unique:users', // Este no porque da error al no modificarle el correo al usuario
            'password' => 'required|min:6|confirmed',
        ];
    }
}