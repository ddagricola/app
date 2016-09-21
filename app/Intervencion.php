<?php

namespace App;
use DB;
use Auth;
use Illuminate\Database\Eloquent\Model;

class Intervencion extends Model
{
    protected $table = 'intervencion';
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_fuente_financiamiento',
        'id_insumo',
        'id_consolidado',
        'id_usuario',
        'id_municipio',
        'id_departamento',
		'id_tipo_intervencion',
		'nombre',
		'justificacion',
		'estado',
		'fecha_creacion',
		'email_creacion',
		'ip_creacion',
		'fecha_modificacion',
		'email_modificacion',
		'ip_modificacion',
        'codigo_partida',
        'orden',
        'anio'
    ];

    public static function intervencionConsolidado(){
        $auth = Auth::user()->id;
    	return DB::select(DB::raw("
    		select
                departamento.id as id_departamento,
                intervencion.id as id_intervencion,
                concat('#',intervencion.id) as correlativo,
                intervencion.anio,
                case intervencion.orden
                    when 1 then 'PRIMERA INTERVENCIÓN'
                    when 2 then 'SEGUNDA INTERVENCIÓN'
                    when 3 then 'TERCERA INTERVENCIÓN'
                    when 4 then 'CUARTA INTERVENCIÓN'
                end as orden,
                concat(ifnull(departamento.codigo, '000'), ' - ', departamento.nombre) as departamento,
                intervencion.nombre as nombre_intervencion,
                concat(tipo_insumo.nombre, ' - ', insumo.nombre) as insumo
                 from intervencion
                    join departamento on departamento.id = intervencion.id_departamento
                    join insumo on insumo.id = intervencion.id_insumo
                    join tipo_insumo on tipo_insumo.id = insumo.id_tipo_insumo
                    where intervencion.estado = 1 and intervencion.id_usuario = $auth;
    	"));
    }
    public static function totalIntervencion($id){
        return DB::select(DB::raw("
            select sum( (detalle_intervencion.precio * detalle_intervencion.cantidad) ) as total_intervencion
                from intervencion
                    join detalle_intervencion on detalle_intervencion.id_intervencion = intervencion.id
                    where detalle_intervencion.estado = 1 and intervencion.id = $id;
        "));
    }

    public static function totalIntervencionBeneficiarios($id){
        return DB::select(DB::raw("
              select sum( detalle_intervencion.nbeneficiario ) as total_beneficiarios
    from intervencion
    join detalle_intervencion on detalle_intervencion.id_intervencion = intervencion.id
        where detalle_intervencion.estado = 1 and intervencion.id =$id
        "));
    }

    public function scopeTodoMunicipios($query, $id){
        return DB::select(DB::raw("
            select
            intervencion.id as id_intervencion,
            municipio.id as id_municipio,
            detalle_intervencion.id as id_detalle_intervencion,
            concat(ifnull(municipio.codigo, '000'), ' - ', municipio.nombre) as municipio
             from detalle_intervencion
                join intervencion on intervencion.id = detalle_intervencion.id_intervencion
                join municipio on municipio.id = detalle_intervencion.id_municipio
                where municipio.id_departamento = $id and detalle_intervencion.estado = 1 group by detalle_intervencion.id_municipio;
        "));
    }
    public function scopeTodoDepartamentos($query){
        return DB::select(DB::raw("
        select
          usuario.email,
          usuario.id_jefatura,
          departamento.id as id_departamento,
          concat(ifnull(departamento.codigo, '00'), ' - ', departamento.nombre) as departamento
          from intervencion
                  join departamento on departamento.id = intervencion.id_departamento
                  join usuario on usuario.id = intervencion.id_usuario
                  where intervencion.estado = 1
                  and usuario.id_jefatura = ".Auth::user()->id_jefatura."
                  group by intervencion.id_departamento
        "));
    }
}
