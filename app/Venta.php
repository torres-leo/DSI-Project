<?php

namespace CompraVenta;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    protected $table = 'venta';
    protected $primaryKey = 'idVenta';
    public $timestamps = false;
    protected $fillable = [
        'idCliente',
        'tipoComprobante',
        'serieComprobante',
        'numComprobante',
        'fechaHora',
        'impuesto',
        'totalVenta',
        'estado',
    ];

    protected $guarded = [];
}