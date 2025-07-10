<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class zonaSegura extends Model
{
    protected $fillable = [
        'nombre',
        'radio',
        'latitud',
        'longitud',
        'tipo_seguridad',
    ];
}
