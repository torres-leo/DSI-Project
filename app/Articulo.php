<?php

namespace CompraVenta;

use Illuminate\Database\Eloquent\Model;

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