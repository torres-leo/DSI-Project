<?php

namespace CompraVenta;

use Illuminate\Database\Eloquent\Model;

// OBTENIENDO LAS VARIABLES A TOMAR DE LA TABLA

class Persona extends Model
{

    protected $table = 'persona';
    protected $primaryKey = 'idPersona';
    public $timestamps = false;
    protected $fillable = [
        'tipoPersona',
        'nombre',
        'tipoDocumento',
        'numDocumento',
        'direccion',
        'telefono',
        'email',
    ];

    protected $guarded = [];
}