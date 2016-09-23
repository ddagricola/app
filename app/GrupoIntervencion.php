<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Auth;

class GrupoIntervencion extends Model
{
  protected $table = 'grupo_intervencion';
  public $timestamps = false;
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'nombre',
    'estado',
    'fecha_creacion',
    'email_creacion',
    'ip_creacion',
    'fecha_modificacion',
    'email_modificacion',
    'ip_modificacion'
  ];

  public static function beneficiariosGrupoIntervencion($id){
    $data = DB::select(DB::raw("
      select detalle_intervencion.nbeneficiario from grupo_intervencion
      join detalle_grupo on detalle_grupo.id_grupo_intervencion = grupo_intervencion.id
      join detalle_intervencion on detalle_grupo.id_detalle_intervencion = detalle_intervencion.id
      where grupo_intervencion.id = $id
        and grupo_intervencion.estado = 1
          and detalle_intervencion.estado = 1
          group by grupo_intervencion.id limit 1
        "));
    return $data[0];
  }
  public static function municipioGrupoIntervencion($id){
    /*echo "select detalle_intervencion.id_municipio from grupo_intervencion
    join detalle_grupo on detalle_grupo.id_grupo_intervencion = grupo_intervencion.id
    join detalle_intervencion on detalle_grupo.id_detalle_intervencion = detalle_intervencion.id
    where grupo_intervencion.id = $id
      and grupo_intervencion.estado = 1
        and detalle_intervencion.estado = 1
        group by grupo_intervencion.id limit 1";die;*/
    $data = DB::select(DB::raw("
      select detalle_intervencion.id_municipio from grupo_intervencion
      join detalle_grupo on detalle_grupo.id_grupo_intervencion = grupo_intervencion.id
      join detalle_intervencion on detalle_grupo.id_detalle_intervencion = detalle_intervencion.id
      where grupo_intervencion.id = $id
      	and grupo_intervencion.estado = 1
          and detalle_intervencion.estado = 1
          group by grupo_intervencion.id limit 1
        "));
    return $data[0]->id_municipio;
  }
  public static function listadoGrupos($id){
    return DB::select(DB::raw("
        select
    	concat(departamento.nombre, '-',departamento.codigo) as departamento,
        concat(municipio.nombre, ' - ',municipio.codigo) as municipio,
        -- detalle_intervencion.nbeneficiario,
        concat(tipo_insumo.nombre, '-', insumo.nombre) as insumo,
        concat(detalle_intervencion.id, ' ', unidad_medida.nombre,' POR BENEFICIARIO') as cantidad
        -- group_concat(insumo.nombre) as insumos
    	from detalle_grupo
        join detalle_intervencion on detalle_intervencion.id = detalle_grupo.id_detalle_intervencion
        join municipio on municipio.id = detalle_intervencion.id_municipio
        join departamento on departamento.id = municipio.id_departamento
        join intervencion on intervencion.id = detalle_intervencion.id_intervencion
        join insumo on insumo.id = intervencion.id_insumo
        join usuario on usuario.id = intervencion.id_usuario
        JOIN tipo_insumo on tipo_insumo.id = insumo.id_tipo_insumo
        join unidad_medida on unidad_medida.id = id_unidad_entrega
        where detalle_grupo.id_grupo_intervencion= $id
    "));
  }
  public static function grupoIntervencion(){
    return DB::select(DB::raw("
    select
      grupo_intervencion.id as id_grupo_intervencion,
    	concat(departamento.nombre, '-',departamento.codigo) as departamento,
        concat(municipio.nombre, '-',municipio.codigo) as municipio,
        detalle_intervencion.nbeneficiario,
        group_concat(insumo.nombre) as insumos
     from grupo_intervencion
    	join detalle_grupo on detalle_grupo.id_grupo_intervencion = grupo_intervencion.id
        join detalle_intervencion on detalle_intervencion.id = detalle_grupo.id_detalle_intervencion
        join municipio on municipio.id = detalle_intervencion.id_municipio
        join departamento on departamento.id = municipio.id_departamento
        join intervencion on intervencion.id = detalle_intervencion.id_intervencion
        join insumo on insumo.id = intervencion.id_insumo
        join usuario on usuario.id = intervencion.id_usuario
        where usuario.id_jefatura = ".Auth::user()->id_jefatura."
        group by grupo_intervencion.id
    "));
  }


}
