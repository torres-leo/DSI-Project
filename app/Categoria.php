<?php

namespace CompraVenta;

use Illuminate\Database\Eloquent\Model;

// OBTENIENDO LAS VARIABLES A TOMAR DE LA TABLA

class Categoria extends Model
{
    protected $table = 'categoria';
    protected $primaryKey = 'idCategoria';
    public $timestamps = false;
    protected $fillable = [
        'nombre',
        'descripcion',
        'condicion'
    ];

    protected $guarded = [];
}