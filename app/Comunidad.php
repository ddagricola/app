<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
}
