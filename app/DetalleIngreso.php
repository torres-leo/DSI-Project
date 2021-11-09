<?php

namespace CompraVenta;

use Illuminate\Database\Eloquent\Model;

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