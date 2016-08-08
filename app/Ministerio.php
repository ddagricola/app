<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ministerio extends Model
{
    protected $table = 'ministerio';
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre',
        'siglas',
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
