<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Auth;
class Insumo extends Model
{
    protected $table = 'insumo';
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_tipo_insumo',
        'id_jefatura',
        'nombre',
		'estado',
		'fecha_creacion',
		'email_creacion',
		'ip_creacion',
		'fecha_modificacion',
		'email_modificacion',
		'ip_modificacion'
    ];
    public function scopeInsumoJefatura($query){
        return DB::select(DB::raw("
            select 
            insumo.id,
            concat(tipo_insumo.nombre, ' - ',insumo.nombre) as insumo
             from insumo
                join tipo_insumo on tipo_insumo.id = insumo.id_tipo_insumo
                where insumo.id_jefatura = 
        ".Auth::user()->id_jefatura));
    }
    public function scopeInsumoToTipoInsumo($query){
        $tableName = 'insumo';
        return   
            DB::table($tableName)
            ->join('tipo_insumo', 'tipo_insumo.id', '=', $tableName.'.id_tipo_insumo')
            ->select(
                DB::raw("tipo_insumo.id as id_tipo_insumo, tipo_insumo.nombre as tipo_insumo, insumo.*")
                )
            ->where($tableName.'.estado', '=', 1)
            ->get();    
    }
}
