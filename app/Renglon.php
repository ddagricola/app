<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Renglon extends Model
{
    protected $table = 'renglon';
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_proyecto',
        'nombre',
		'estado',
		'fecha_creacion',
		'email_creacion',
		'ip_creacion',
		'fecha_modificacion',
		'email_modificacion',
		'ip_modificacion'
    ];

    public function scopeDepartamentoToPais($query){
        $tableName = 'departamento';
        return   
            DB::table($tableName)
            ->join('pais', 'pais.id', '=', $tableName.'.id_pais')
            ->select(
                DB::raw("departamento.id as id_departamento, pais.nombre as pais, departamento.*")
                )
            ->where($tableName.'.estado', '=', 1)
            ->get();    
    }
    /*
    public function scopeRenglonTodo(){
        return DB::select(DB::raw("
            select 
            renglon.id  as id_renglon,
            renglon.codigo_partida as codigo_renglon,
            renglon.nombre as nombre_renglon,
            proyecto.nombre as proyecto,
            actividad.nombre as actividad,
            subprograma.nombre as subprograma,
            programa.nombre as programa
             from renglon 
                join proyecto on proyecto.id = renglon.id_proyecto
                join actividad on actividad.id = proyecto.id_actividad
                join programa as subprograma on subprograma.id = actividad.id_programa
                join programa as programa on programa.id = subprograma.id_programa_padre
            where renglon.estado = 1
            "));
    }
    */
}
