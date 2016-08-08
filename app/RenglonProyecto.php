<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RenglonProyecto extends Model
{
    protected $table = 'renglon_proyecto';
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_municipio_renglon',
		'id_proyecto',
		'estado',
		'fecha_creacion',
		'email_creacion',
		'ip_creacion',
		'fecha_modificacion',
		'email_modificacion',
		'ip_modificacion'
    ];
}
