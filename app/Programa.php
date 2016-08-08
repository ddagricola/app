<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Programa extends Model
{
    protected $table = 'programa';
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_direccion',
        'id_programa_padre',
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

    public function scopeProgramaToDireccion($query){
        $tableName = 'programa';
        return   
            DB::table($tableName)
            ->join('direccion', 'direccion.id', '=', $tableName.'.id_direccion')
            ->select(
                DB::raw("direccion.id as id_direccion,direccion.codigo_partida as codigo_direccion, direccion.nombre as direccion, programa.*")
                )
            ->where($tableName.'.estado', '=', 1)
            ->where($tableName.'.id_programa_padre', '=', null)
            ->get();    
    }

    public function scopeSubProgramaDisponible($query){
        return DB::select(DB::raw('
            select 
            subprograma.id as id_subprograma,
            concat(programa.codigo_partida," - ",programa.nombre) as programa,
            concat(ifnull(subprograma.codigo_partida,0), " ", ifnull(subprograma.nombre," -- SIN SUBPROGRAMA --")) as subprograma,
            subprograma.ip_creacion
             from programa 
                join programa subprograma on subprograma.id_programa_padre = programa.id
            where subprograma.estado = 1
        '));  
    }

    public function scopeSubProgramaToDireccion($query, $idPrograma){
        return DB::select(DB::raw('
            select 
            subprograma.id as id_subprograma,
            concat(programa.codigo_partida," - ",programa.nombre) as programa,
            concat(ifnull(subprograma.codigo_partida,programa.codigo_partida), " - ", ifnull(subprograma.nombre,programa.nombre)) as subprograma,
            subprograma.ip_creacion
             from programa 
                join programa subprograma on subprograma.id_programa_padre = programa.id
            where programa.id = 1 and subprograma.estado = 1
        '));  
    }

}
