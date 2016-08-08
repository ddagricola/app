<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
//use Partida;
class Partida extends Model
{
    protected $table = 'partida';
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_renglon',
        'id_fuente_financiamiento',
        'id_municipio',
        'codigo',
		'estado',
		'fecha_creacion',
		'email_creacion',
		'ip_creacion',
		'fecha_modificacion',
		'email_modificacion',
		'ip_modificacion'
    ];
    public static function partidas(){
        return DB::select(DB::raw("
            select 
                partida.codigo as partida,
                partida.id as id,
                concat(renglon.codigo_partida,' - ', renglon.nombre) as renglon,
                concat(fuente_financiamiento.codigo_partida,' - ', fuente_financiamiento.nombre) as fuente,
                concat(ifnull(municipio.codigo,'00'),' - ', municipio.nombre) as municipio,
                concat(ifnull(departamento.codigo,'00'),' - ', departamento.nombre) as departamento
                 from partida
                    join renglon on renglon.id = partida.id_renglon
                    join fuente_financiamiento on fuente_financiamiento.id = partida.id_fuente_financiamiento
                    join municipio on municipio.id = partida.id_municipio
                    join departamento on departamento.id = municipio.id_departamento
                    and partida.estado = 1;
        "));
    }
    public function scopePartidaIntervencion($query, $idMunicipio, $idFuente, $idRenglon){
        $data = $this->whereIdMunicipio($idMunicipio)
                        ->whereIdFuenteFinanciamiento($idFuente)
                        ->whereIdRenglon($idRenglon)
                        ->get();
        return $data;
    }
}
