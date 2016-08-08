<?php

namespace App;
use DB;
use Illuminate\Database\Eloquent\Model;

class Consolidado extends Model
{
    protected $table = 'consolidado';
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_usuario',
		'id_fuente_financiamiento',
		'id_jefatura',
		'estado',
		'anio',
		'nombre',
		'justificacion',
		'fecha_creacion',
		'email_creacion',
		'ip_creacion',
		'fecha_modificacion',
		'email_modificacion',
		'ip_modificacion'
    ];

    public static function consolidadoPorJefatura($id){
    	return DB::select(DB::raw("
    		select 
			consolidado.id,
			consolidado.anio,
			consolidado.nombre,
			concat(fuente_financiamiento.codigo_partida,' - ', fuente_financiamiento.nombre) as fuente,
			jefatura.nombre as jefatura,
			consolidado.estado
			from consolidado 
				join fuente_financiamiento on fuente_financiamiento.id = consolidado.id_fuente_financiamiento
				join jefatura on jefatura.id = consolidado.id_jefatura
				where consolidado.estado = 1 and consolidado.id_jefatura = $id;
    	"));
    }
}
