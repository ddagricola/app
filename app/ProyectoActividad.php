<?php

namespace App;
use DB;
use Illuminate\Database\Eloquent\Model;

class ProyectoActividad extends Model
{
    protected $table = 'proyecto_actividad';
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_renglon_proyecto',
		'id_actividad',
		'estado',
		'fecha_creacion',
		'email_creacion',
		'ip_creacion',
		'fecha_modificacion',
		'email_modificacion',
		'ip_modificacion'
    ];

    public static function partidasPresupuestarias(){
    	return DB::select(DB::raw('
    		select 
				proyecto_actividad.id,
				concat(
				(select year(now())), "-",
				"1113", "-",
				ministerio.codigo_partida, "-",
				direccion.codigo_partida,"-",
				programa.codigo_partida,"-",
				ifnull(subprograma.codigo_partida, "000"),"-",
				actividad.codigo_partida,"-",
				proyecto.codigo_partida,"-",
				renglon.codigo_partida,"-",
				departamento.codigo,
				municipio.codigo,"-",
				fuente_financiamiento.codigo_partida
				) as partida_presupuestaria
				 from ministerio 	
					join direccion on direccion.id_ministerio = ministerio.id
				    join programa on programa.id_direccion = direccion.id
					join programa subprograma on subprograma.id_programa_padre = programa.id
				    join actividad on actividad.id_programa = subprograma.id
				    join proyecto_actividad on proyecto_actividad.id_actividad = actividad.id
				    join renglon_proyecto on renglon_proyecto.id = proyecto_actividad.id_renglon_proyecto
				    join proyecto on proyecto.id = renglon_proyecto.id_proyecto 
				    join municipio_renglon on municipio_renglon.id = renglon_proyecto.id_municipio_renglon
				    join municipio on municipio.id = municipio_renglon.id_municipio
				    join fuente_financiamiento on fuente_financiamiento.id = municipio_renglon.id_fuente_financiamiento
				    join renglon on renglon.id = municipio_renglon.id_renglon
				    join departamento on departamento.id = municipio.id_departamento
				where
					ministerio.estado = 1
				    and direccion.estado = 1
				    and programa.estado = 1
				    and subprograma.estado = 1
				    and actividad.estado = 1
				    and renglon_proyecto.estado = 1
				    and proyecto_actividad.estado = 1
				    and renglon.estado =1
				    and proyecto.estado = 1
    	'));
    }
}
