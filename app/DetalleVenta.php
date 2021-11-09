<?php

namespace CompraVenta;

use Illuminate\Database\Eloquent\Model;

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