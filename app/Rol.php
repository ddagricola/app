<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    protected $table = 'rol';
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

    public function usuarios(){
        return $this->hasMany('App\User', 'id_rol');
    }
}
