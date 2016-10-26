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
        concat(detalle_intervencion.cantidad_beneficiario, ' ', unidad_medida.nombre,' POR BENEFICIARIO') as cantidad
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

  public static function distribucionMunicipal(){
    return DB::select(DB::raw("
      select
      departamento.nombre as departamento,
      municipio.nombre as municipio,
      grupo_intervencion.id as id_grupo,
      -- insumo.nombre as insumo,
      -- group_concat(insumo.nombre) as kit_insumo,
      group_concat(DISTINCT insumo.nombre) as kit_insumo,
      tipo_insumo.nombre as tipo_insumo,
      grupo_intervencion.nombre as nombre_grupo,
      intervencion.nombre as nombre_intervencion,
      intervencion.id as id_intervencion,
      detalle_grupo.id as id_detalle_grupo,
      detalle_intervencion.cantidad as cantidad_detalle,
      detalle_intervencion.precio as precio_detalle,
      detalle_intervencion.nbeneficiario as beneficiarios,
      concat(detalle_intervencion.nbeneficiario,' asignados') as otorgados,
      detalle_intervencion.cantidad_beneficiario,
      medida_compra.nombre,
      medida_entrega.nombre
       from grupo_intervencion
      	join detalle_grupo on detalle_grupo.id_grupo_intervencion = grupo_intervencion.id
          join detalle_intervencion on detalle_intervencion.id= detalle_grupo.id_detalle_intervencion
          join municipio on municipio.id = detalle_intervencion.id_municipio
          join intervencion on intervencion.id = detalle_intervencion.id_intervencion
          join unidad_medida medida_compra on medida_compra.id = detalle_intervencion.id_unidad_medida
          join unidad_medida medida_entrega on medida_entrega.id = detalle_intervencion.id_unidad_entrega
          join insumo on insumo.id = intervencion.id_insumo
          join tipo_insumo on insumo.id_tipo_insumo = tipo_insumo.id
          join departamento on departamento.id = municipio.id_departamento
          where grupo_intervencion.estado = 1
          and detalle_grupo.estado = 1
          and intervencion.estado = 1
          and detalle_intervencion.estado = 1
          and intervencion.id_jefatura is null
          group by grupo_intervencion.id;
    "));
  }

  public static function distribucionComunidad($id){
    return DB::select(DB::raw("
    select
      departamento.nombre as departamento,
      municipio.nombre as municipio,
      grupo_intervencion.id as id_grupo,
      movimiento.id as id_movimiento,
		tipo_division.nombre as tipo_division ,
		comunidad.nombre as comunidad,
		concat(tipo_division.nombre, ' ' ,comunidad.nombre) as ubicacion_entrega,
		date_format(movimiento.fecha_entrega, '%d/%m/%Y') as fecha_entrega,
      -- group_concat(insumo.nombre) as kit_insumo,
      tipo_insumo.nombre as tipo_insumo,
      grupo_intervencion.nombre as nombre_grupo,
      intervencion.nombre as nombre_intervencion,
      intervencion.id as id_intervencion,
      detalle_grupo.id as id_detalle_grupo,
      detalle_intervencion.cantidad as cantidad_detalle,
      detalle_intervencion.precio as precio_detalle,
      detalle_intervencion.nbeneficiario as beneficiarios,
      concat(detalle_intervencion.nbeneficiario,' asignados') as otorgados,
      detalle_intervencion.cantidad_beneficiario,
      medida_compra.nombre,
      medida_entrega.nombre
       from grupo_intervencion
      	join detalle_grupo on detalle_grupo.id_grupo_intervencion = grupo_intervencion.id
          join detalle_intervencion on detalle_intervencion.id= detalle_grupo.id_detalle_intervencion
          join municipio on municipio.id = detalle_intervencion.id_municipio
          join intervencion on intervencion.id = detalle_intervencion.id_intervencion
          join unidad_medida medida_compra on medida_compra.id = detalle_intervencion.id_unidad_medida
          join unidad_medida medida_entrega on medida_entrega.id = detalle_intervencion.id_unidad_entrega
          join insumo on insumo.id = intervencion.id_insumo
          join tipo_insumo on insumo.id_tipo_insumo = tipo_insumo.id
          join departamento on departamento.id = municipio.id_departamento
          join movimiento movimiento on movimiento.id_grupo_intervencion = grupo_intervencion.id
		  join comunidad on comunidad.id = movimiento.id_comunidad
		join tipo_division on tipo_division.id = comunidad.id_tipo_division
          where grupo_intervencion.estado = 1
          and detalle_grupo.estado = 1
          and movimiento.id_grupo_intervencion = $id
          and movimiento.estado = 1
          and intervencion.estado = 1
          and detalle_intervencion.estado = 1
          -- group by grupo_intervencion.id;
          group by movimiento.id
          "));
  }
  public static function distribucionEvento($id){
    return DB::select(DB::raw("
        select
        grupo_intervencion.id as id_grupo_intervencion,
        departamento.nombre as departamento,
        municipio.nombre as municipio,
        municipio.id as id_municipio,
        grupo_intervencion.id as id_grupo,
        movimiento.id as id_movimiento,
      tipo_division.nombre as tipo_division ,
      comunidad.nombre as comunidad,
      concat(tipo_division.nombre, ' ' ,comunidad.nombre) as ubicacion_entrega,
      date_format(movimiento.fecha_entrega, '%d/%m/%Y') as fecha_entrega,
        -- group_concat(insumo.nombre) as kit_insumo,
        tipo_insumo.nombre as tipo_insumo,
        grupo_intervencion.nombre as nombre_grupo,
        intervencion.nombre as nombre_intervencion,
        intervencion.id as id_intervencion,
        detalle_grupo.id as id_detalle_grupo,
        detalle_intervencion.cantidad as cantidad_detalle,
        detalle_intervencion.precio as precio_detalle,
        detalle_intervencion.nbeneficiario as beneficiarios,
        concat(detalle_intervencion.nbeneficiario,' asignados') as otorgados,
        detalle_intervencion.cantidad_beneficiario,
        medida_compra.nombre,
        medida_entrega.nombre
         from grupo_intervencion
          join detalle_grupo on detalle_grupo.id_grupo_intervencion = grupo_intervencion.id
            join detalle_intervencion on detalle_intervencion.id= detalle_grupo.id_detalle_intervencion
            join municipio on municipio.id = detalle_intervencion.id_municipio
            join intervencion on intervencion.id = detalle_intervencion.id_intervencion
            join unidad_medida medida_compra on medida_compra.id = detalle_intervencion.id_unidad_medida
            join unidad_medida medida_entrega on medida_entrega.id = detalle_intervencion.id_unidad_entrega
            join insumo on insumo.id = intervencion.id_insumo
            join tipo_insumo on insumo.id_tipo_insumo = tipo_insumo.id
            join departamento on departamento.id = municipio.id_departamento
            join movimiento movimiento on movimiento.id_grupo_intervencion = grupo_intervencion.id
        join comunidad on comunidad.id = movimiento.id_comunidad
      join tipo_division on tipo_division.id = comunidad.id_tipo_division
            where grupo_intervencion.estado = 1
            and detalle_grupo.estado = 1
            and movimiento.id= $id
            and movimiento.estado = 1
            and intervencion.estado = 1
            and detalle_intervencion.estado = 1
            group by movimiento.id
    "));
  }
  public static function detalleGrupoIntervencion($id){
    return DB::select(DB::raw("
    select
      departamento.nombre as departamento,
      municipio.nombre as municipio,
      municipio.id as id_municipio,
      grupo_intervencion.id as id_grupo,
      group_concat(DISTINCT insumo.nombre) as insumos,
      tipo_insumo.nombre as tipo_insumo,
      grupo_intervencion.nombre as nombre_grupo,
      intervencion.nombre as nombre_intervencion,
      intervencion.id as id_intervencion,
      detalle_grupo.id as id_detalle_grupo,
      detalle_intervencion.cantidad as cantidad_detalle,
      detalle_intervencion.precio as precio_detalle,
      detalle_intervencion.nbeneficiario as beneficiarios,
      concat(detalle_intervencion.nbeneficiario,' asignados') as otorgados,
      detalle_intervencion.cantidad_beneficiario,
      medida_compra.nombre,
      medida_entrega.nombre
       from grupo_intervencion
      	join detalle_grupo on detalle_grupo.id_grupo_intervencion = grupo_intervencion.id
          join detalle_intervencion on detalle_intervencion.id= detalle_grupo.id_detalle_intervencion
          join municipio on municipio.id = detalle_intervencion.id_municipio
          join intervencion on intervencion.id = detalle_intervencion.id_intervencion
          join unidad_medida medida_compra on medida_compra.id = detalle_intervencion.id_unidad_medida
          join unidad_medida medida_entrega on medida_entrega.id = detalle_intervencion.id_unidad_entrega
          join insumo on insumo.id = intervencion.id_insumo
          join tipo_insumo on insumo.id_tipo_insumo = tipo_insumo.id
          join departamento on departamento.id = municipio.id_departamento
          where grupo_intervencion.estado = 1
          and detalle_grupo.estado = 1
          and grupo_intervencion.id= $id
          and intervencion.estado = 1
          and detalle_intervencion.estado = 1;
    "));
  }
  public static function distribucionEventos($id){
    return DB::select(DB::raw("select * from distribucion_movimiento where id_movimiento = $id and estado = 1"));
  }
}
