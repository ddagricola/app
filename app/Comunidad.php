<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Comunidad extends Model
{
    protected $table = 'comunidad';
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_municipio',
        'nombre',
		'estado',
		'fecha_creacion',
		'email_creacion',
		'ip_creacion',
		'fecha_modificacion',
		'email_modificacion',
		'ip_modificacion'
    ];

    public function municipios(){
        return $this->belongsTo('App\Municipio', 'id_municipio');
        //return $this->hasMany('App\Municipio', 'id_municipio');
    }
    public static function divisionTipoDivision($id){ //id de municipio
        return DB::select(DB::raw("
                select 
                tipo_division.nombre as division,
                comunidad.nombre as comunidad,
                comunidad.id as id
                 from comunidad 
                    join tipo_division on tipo_division.id = comunidad.id_tipo_division
                        where comunidad.id_municipio = $id;
            "));

    }
}
