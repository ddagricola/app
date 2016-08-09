<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class ColaboradorVisita extends Model
{
    
    protected $table = 'visita_colaborador';
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_tipo_visita',
	    'id_colaborador',
	    'nombre_visitante',
	    'lugar_visitante',
	    'dia_visita',
	    'hora_visita',
	    'motivo_visita',
		'estado',
		'fecha_creacion',
		'email_creacion',
		'ip_creacion',
		'fecha_modificacion',
		'email_modificacion',
		'ip_modificacion'
    ];

    public static function visitaJefatura($id){//id de jefatura
    	return DB::select(DB::raw("select 
		concat(
			colaborador.primer_nombre,' ', colaborador.segundo_nombre,
		    ' ', colaborador.tercer_nombre,' ', colaborador.primer_apellido,
		    ' ', colaborador.segundo_apellido
		    ) as colaborador,
		    jefatura.nombre as jefatura,
		    visita_colaborador.dia_visita,
		    visita_colaborador.nombre_visitante,
		    visita_colaborador.lugar_visitante,
		    visita_colaborador.id as id_visita_colaborador
		 from visita_colaborador
			join colaborador on colaborador.id = visita_colaborador.id_colaborador
		    join jefatura on jefatura.id = colaborador.id_jefatura
		    where colaborador.id_jefatura = $id"));
    }
}
