<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class MunicipioRenglon extends Model
{
    protected $table = 'municipio_renglon';
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_municipio',
        'id_fuente_financiamiento',
        'id_renglon',
        'id_proyecto',
        'nombre',
        'codigo',
        'descripcion',
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
    public static function municipioRenglon(){
        return DB::select(DB::raw("
            select 
            municipio_renglon.id,
            concat(departamento.codigo,' - ',departamento.nombre) as departamento,
            concat(municipio.codigo,' - ',municipio.nombre) as municipio,
            concat(renglon.codigo_partida,' - ',renglon.nombre) as renglon,
            concat(fuente_financiamiento.codigo_partida,' - ',fuente_financiamiento.nombre) as fuente
                from municipio_renglon
                    join municipio on municipio.id = municipio_renglon.id_municipio
                    join renglon on renglon.id = municipio_renglon.id_renglon
                    join fuente_financiamiento on fuente_financiamiento.id = municipio_renglon.id_fuente_financiamiento
                    join departamento on departamento.id = municipio.id_departamento
                    where municipio_renglon.estado = 1;
            "));
    }
}
