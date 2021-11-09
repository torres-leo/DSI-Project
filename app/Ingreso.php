<?php

namespace CompraVenta;

use Illuminate\Database\Eloquent\Model;

class Ingreso extends Model
{

    protected $table = 'ingreso';
    protected $primaryKey = 'idIngreso';
    public $timestamps = false;
    protected $fillable = [
        'idProveedor',
        'tipoComprobante',
        'serieComprobante',
        'numComprobante',
        'fechaHora',
        'impuesto',
        'estado',
    ];

    protected $guarded = [];
}