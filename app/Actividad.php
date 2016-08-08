<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Actividad extends Model
{
    protected $table = 'actividad';
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_programa',
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
    public static function actividadPerPrograma(){
        return DB::select(DB::raw("
        select 
        actividad.id as id_actividad,
        actividad.codigo_partida as codigo_actividad,
        actividad.nombre as nombre_actividad,
        actividad.ip_creacion,
        concat(programa.codigo_partida,' - ',programa.nombre) as programa,
        programa.codigo_partida as codigo_programa,
        concat(ifnull(subprograma.codigo_partida,''), ' - ', ifnull(subprograma.nombre,'-- SIN SUBPROGRAMA --')) as subprograma,
        ifnull(subprograma.codigo_partida,'') as codigo_subprograma,
        ifnull(subprograma.nombre,'-- SIN SUBPROGRAMA --') as nombre_subprograma
         from actividad 
            join programa subprograma on subprograma.id = actividad.id_programa
            join programa on programa.id = subprograma.id_programa_padre
         where actividad.estado = 1
            "));
    }
}
