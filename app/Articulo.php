<?php

namespace CompraVenta;

use Illuminate\Database\Eloquent\Model;

// OBTENIENDO LAS VARIABLES A TOMAR DE LA TABLA

class Articulo extends Model
{
    protected $table = 'articulo';
    protected $primaryKey = 'idArticulo';
    public $timestamps = false;
    protected $fillable = [
        'idCategoria',
        'codigo',
        'nombre',
        'stock',
        'descripcion',
        'imagen',
        'estado',
    ];

    protected $guarded = [];
}