<?php

namespace CompraVenta;

use Illuminate\Database\Eloquent\Model;

// OBTENIENDO LAS VARIABLES A TOMAR DE LA TABLA

class DetalleIngreso extends Model
{
    protected $table = 'detalleingreso';
    protected $primaryKey = 'idDetalleIngreso';
    public $timestamps = false;
    protected $fillable = [
        'idIngreso',
        'idArticulo',
        'cantidad',
        'precioCompra',
        'precioVenta',
    ];

    protected $guarded = [];
}