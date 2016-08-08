<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FuenteFinanciamiento extends Model
{
     protected $table = 'fuente_financiamiento';
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre',
		'estado',
		'fecha_creacion',
		'email_creacion',
		'ip_creacion',
		'fecha_modificacion',
		'email_modificacion',
		'ip_modificacion',
        'codigo_partida'
    ];
}
