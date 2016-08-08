<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Direccion extends Model
{
    protected $table = 'direccion';
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_ministerio',
        'nombre',
        'siglas',
		'estado',
		'fecha_creacion',
		'email_creacion',
		'ip_creacion',
		'fecha_modificacion',
		'email_modificacion',
		'ip_modificacion',
        'codigo_partida'
    ];

    public function scopeDireccionPerMinisterio($query){
        $tableName = 'direccion';
        return   
            DB::table($tableName)
            ->join('ministerio', 'ministerio.id', '=', $tableName.'.id_ministerio')
            ->select(
                DB::raw("concat(ministerio.siglas,' - ',ministerio.nombre) as ministerio, direccion.*")
                )
            ->where($tableName.'.estado', '=', 1)
            ->get();    
    }
}
