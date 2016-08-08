<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;

class Colaborador extends Model
{
    protected $table = "colaborador";
    public $timestamps = false;
    protected $fillable = [
        "id_usuario",
		"id_tipo_colaborador",
		"nombre",
		"primer_nombre",
		"segundo_nombre",
		"tercer_nombre",
		"primer_apellido",
		"segundo_apellido",
		"apellido_casada",
		"estado",
		"fecha_creacion",
		"email_creacion",
		"ip_creacion",
		"fecha_modificacion",
		"email_modificacion",
		"ip_modificacion",
		"contrato"
    ];
    public function scopeNombreAuth($query){
    	$nombre = "";
    	$colaborador = $query->whereIdUsuario(Auth::user()->id)->count();
    	if($colaborador==0){
    		$nombre = Auth::user()->email;
    	}else{
    		$colaborador = $query->whereIdUsuario(Auth::user()->id)->get()->first();
    		$nombre = $colaborador->primer_nombre.' '.$colaborador->primer_apellido;
    	}
    	return $nombre;

    }
}
