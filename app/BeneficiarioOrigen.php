<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class BeneficiarioOrigen extends Model
{
	protected $table = 'beneficiario';
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
		'genero',
		'estado',
		'fecha_creacion',
		'usuario_creacion',
		'fecha_modificacion',
		'usuario_modificacion'
    ];

    public static function beneficiario($cui){
    	return DB::select(DB::raw("
    		select 
    			(select 'update') as event,
				municipio.id as id_municipio,
				departamento.id as id_departamento,
				date_format(beneficiario.fecha_nacimiento, '%d/%m/%Y') as fecha_nacimiento_st,
				beneficiario.*
				 from beneficiario 
					join municipio on municipio.id = beneficiario.id_municipio
				    join departamento on departamento.id = municipio.id_departamento
				    join etnia on etnia.id = beneficiario.id_etnia
				    join pueblo on pueblo.id = beneficiario.id_pueblo
				    where beneficiario.cui = $cui and beneficiario.estado = 1;
    	"));
    }
}
