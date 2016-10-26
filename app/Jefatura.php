<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Jefatura extends Model
{
    protected $table = 'jefatura';
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_direccion',
        'nombre',
		'estado',
		'fecha_creacion',
		'email_creacion',
		'ip_creacion',
		'fecha_modificacion',
		'email_modificacion',
		'ip_modificacion'
    ];

    public function scopeJefaturaToDireccion($query){
        $tableName = 'jefatura';
        return
            DB::table($tableName)
            ->join('direccion', 'direccion.id', '=', $tableName.'.id_direccion')
            ->join('ministerio', 'ministerio.id', '=', 'direccion.id_ministerio')
            ->select(
                DB::raw("
                    direccion.siglas as siglas_direccion,
                    direccion.nombre as direccion,
                    ministerio.nombre as ministerio,
                    ministerio.siglas as siglas_ministerio,
                    jefatura.*
                    ")
                )
            ->where($tableName.'.estado', '=', 1)
            ->get();
    }

}
