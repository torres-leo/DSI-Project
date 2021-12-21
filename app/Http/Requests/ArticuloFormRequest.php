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
        // INGRESAR LAS VALIDACIONES DE CADA PARAMETRO
        return [
            'idCategoria' => 'required',
            'codigo' => 'required|string|max:50|unique:articulo,idArticulo' . $this->idArticulo,
            'nombre' => 'required|max:100',
            'stock' => 'required|numeric|min:0',
            'descripcion' => 'max:400',
            // 'codigo' => 'required|max:50',
            'imagen' => 'mimes:jpeg,bmp,png,webp',
        ];
    }
}