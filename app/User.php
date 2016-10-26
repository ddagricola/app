<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Auth;
use App\Jefatura;
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
    /*public function usuarioToJefatura(){
      return $this->belongsTo('App\Jefatura', 'id_jefatura');
    }*/
    public static function usuarioToJefatura(){
        $jefatura = Jefatura::find(Auth::user()->id_jefatura);
        $search  = array('Á', 'É', 'Í', 'Ó', 'Ú','Ñ',' ');
        $replace = array('A', 'E', 'I', 'O', 'U','N', '-');
        $nameClean = str_replace($search, $replace, $jefatura->nombre);

        //str_replace();
        $nameToLower = strtolower($nameClean);
        return $nameToLower;
    }
}
