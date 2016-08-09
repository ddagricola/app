<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;
use DB;
class Colaborador extends Model
{
    protected $table = "colaborador";
    public $timestamps = false;
    protected $fillable = [
        "id_usuario",
        "id_jefatura",
		"id_tipo_colaborador",
        "id_puesto",
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
		"contrato",
        "cui"
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

    public static function colaboradorJefatura(){
        return DB::select(DB::raw("select puesto.nombre as puesto,jefatura.nombre as jefatura,colaborador.* from colaborador 
        join jefatura on jefatura.id = colaborador.id_jefatura
        join puesto on puesto.id = colaborador.id_puesto"));
    }
}
