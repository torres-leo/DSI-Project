<?php

namespace CompraVenta\Http\Requests;

use CompraVenta\Http\Requests\Request;

class ArticuloFormRequest extends Request
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
            'idCategoria' => 'required',
            'codigo' => 'required|max:50|unique',
            'nombre' => 'required|max:50',
            'stock' => 'required|numeric',
            'descripcion' => 'max:400',
            'codigo' => 'required|max:50',
            'imagen' => 'mimes:jpeg,bmp,png',
        ];
    }
}