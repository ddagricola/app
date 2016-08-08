<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Departamento extends Model
{
    protected $table = 'departamento';
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_pais',
        'nombre',
		'estado',
        'codigo',
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
}
