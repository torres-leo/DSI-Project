<?php

namespace CompraVenta;

use Illuminate\Database\Eloquent\Model;

// OBTENIENDO LAS VARIABLES A TOMAR DE LA TABLA

class DetalleVenta extends Model
{
    protected $table = 'detalleVenta';
    protected $primaryKey = 'idDetalleVenta';
    public $timestamps = false;
    protected $fillable = [
        'idVenta',
        'idArticulo',
        'cantidad',
        'precioVenta',
        'descuento',
    ];

    protected $guarded = [];
}