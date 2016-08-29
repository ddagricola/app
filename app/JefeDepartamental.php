<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JefeDepartamental extends Model
{
    protected $table = 'jefe_departamental';
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_departamento',
        'nombre',
        'cui',
		'telefono',
		'estado',
		'fecha_creacion',
		'email_creacion',
		'ip_creacion',
		'fecha_modificacion',
		'email_modificacion'
	];	
}
