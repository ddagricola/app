<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Municipio extends Model
{
    protected $table = 'municipio';
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_departamento',
        'id_tipo_division',
        'nombre',
		'estado',
		'fecha_creacion',
		'email_creacion',
		'ip_creacion',
		'fecha_modificacion',
		'email_modificacion',
		'ip_modificacion',
        'codigo',
    ];

    public function scopeMunicipioToDepartamento($query){
        $tableName = 'municipio';
        return   
            DB::table($tableName)
            ->join('departamento', 'departamento.id', '=', $tableName.'.id_departamento')
            ->join('pais', 'pais.id', '=', 'departamento.id_pais')
            ->join('tipo_division', 'tipo_division.id', '=', 'municipio.id_tipo_division')
            ->select(
                DB::raw("tipo_division.nombre as division,municipio.id as id_municipio, departamento.nombre as departamento, pais.nombre as pais, municipio.*")
                )
            ->where($tableName.'.estado', '=', 1)
            ->get();    
    }

    public function comunidades(){
        //return $this->belongsTo('App\Rol', 'id_rol');
        return $this->hasMany('App\Comunidad', 'id_comunidad');
    }
}
