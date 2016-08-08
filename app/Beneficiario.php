<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class Beneficiario extends Model
{
	protected $table = 'mg_beneficiario';
    public $timestamps = false;

    protected $fillable = [
		'id_municipio',
		'cui',
		'primer_nombre',
		'segundo_nombre',
		'tercer_nombre',
		'primer_apellido',
		'segundo_apellido',
		'apellido_casada',
		'edad',
		'fecha_nacimiento',
		'nacionalidad',
		'estado_civil',
		'pueblo',
		'etnia',
		'genero',
		'estado',
		'fecha_creacion',
		'usuario_creacion',
		'fecha_modificacion',
		'usuario_modificacion',
		'modo_entrega',
		'estado_carga '
    ];
    public static function beneficiarios($cui){
    	return DB::select(DB::raw("
    		select *, (select 'insert') as event from mg_beneficiario where cui = $cui;
    	"));
    }
    public static function alls(){
    	return DB::select(DB::raw("
    		select 
				mg_municipio.nombre as mun,
				mg_departamento.nombre as dep,
				mg_beneficiario.*
				 from mg_beneficiario join 
					mg_municipio on mg_municipio.id = mg_beneficiario.id_municipio
				    join mg_departamento on mg_departamento.id = mg_municipio.id_departamento limit 200
    	"));
    }
}
