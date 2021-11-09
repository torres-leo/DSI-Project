<?php

namespace CompraVenta;

use Illuminate\Database\Eloquent\Model;

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