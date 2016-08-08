<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $table = 'usuario';
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email',
        'password',
        'fecha_creacion',
        'email_creacion',
        'ip_creacion',
        'fecha_modificacion',
        'email_modificacion',
        'remember_token',
        'ip_modificacion',
        'id_jefatura',
        'id_rol',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function usuarioRol(){
        //return $this->belongsToMany('App\Rol');
            return $this->belongsTo('App\Rol', 'id_rol');
            //return $this->hasMany('App\Rol', 'id_rol');


    }
}
