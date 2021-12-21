<?php

namespace CompraVenta;

use Illuminate\Database\Eloquent\Model;

// OBTENIENDO LAS VARIABLES A TOMAR DE LA TABLA

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