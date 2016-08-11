<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;
class RolAcceso extends Model
{
    protected $table = 'rol_acceso';
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_usuario',
        'id_rol',
        'id_jefatura',
		'estado',
		'fecha_creacion',
		'email_creacion',
		'ip_creacion',
		'fecha_modificacion',
		'email_modificacion',
		'ip_modificacion'
    ];


    public function access()
    {
        return $this->belongsTo('App\User','id');
    }
    public function scopeRolAcceso(){
        return $this->where('id_usuario','=',Auth::user()->id)->get();
    }
}