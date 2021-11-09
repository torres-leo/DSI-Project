<?php

namespace CompraVenta\Http\Requests;

use CompraVenta\Http\Requests\Request;

class VentaFormRequest extends Request
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
            'idCliente' => 'required',
            'tipoComprobante' => 'required|max:20',
            'serieComprobante' => 'max:7',
            'numComprobante' => 'required|max:10',
            'idArticulo' => 'required',
            'cantidad' => 'required',
            'precioVenta' => 'required',
            'descuento' => 'required',
            'totalVenta' => 'required',
        ];
    }
}