<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pais extends Model
{
    protected $table = 'pais';
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
		'ip_modificacion'
    ];
}
