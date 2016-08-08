<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Proyecto extends Model
{
    protected $table = 'proyecto';
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_actividad',
        'codigo_partida',
        'descripcion',
        'nombre',
		'estado',
		'fecha_creacion',
		'email_creacion',
		'ip_creacion',
		'fecha_modificacion',
		'email_modificacion',
		'ip_modificacion'
    ];

    public static function proyectoPerActividad(){
        return DB::select(DB::raw("
                select 
                proyecto.id as id_proyecto,
                proyecto.codigo_partida as codigo_proyecto,
                proyecto.nombre as nombre_proyecto,
                actividad.id as id_actividad,
                actividad.codigo_partida as codigo_actividad,
                actividad.nombre as nombre_actividad,
                concat(programa.codigo_partida,' - ',programa.nombre) as programa,
                programa.codigo_partida as codigo_programa,
                concat(ifnull(subprograma.codigo_partida,''), ' - ', ifnull(subprograma.nombre,'-- SIN SUBPROGRAMA --')) as subprograma,
                ifnull(subprograma.codigo_partida,'') as codigo_subprograma,
                ifnull(subprograma.nombre,'-- SIN SUBPROGRAMA --') as nombre_subprograma
                 from proyecto
                    join actividad on actividad.id = proyecto.id_actividad
                    join programa subprograma on subprograma.id = actividad.id_programa
                    join programa on programa.id = subprograma.id_programa_padre
                where proyecto.estado = 1 and proyecto.codigo_partida is not null
        "));
    }

    public function scopeProyectoActividad($query){

        return DB::select(DB::raw("
            select 
                actividad.id as id_actividad,
                concat('(', actividad.codigo_partida,') ', actividad.nombre) as actividad,
                proyecto.id as id_proyecto,
                proyecto.nombre as proyecto
                    from actividad 
                        join proyecto on proyecto.id_actividad = actividad.id
                where proyecto.estado = 1
        "));
    }
    

}
