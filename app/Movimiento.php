<?php

namespace App;
use DB;
use Auth;
use Illuminate\Database\Eloquent\Model;

class Movimiento extends Model
{
 	protected $table = 'movimiento';
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
		'id_detalle_intervencion',
		'id_comunidad',
		'nombre_extensionista',
		'cui_extensionista',
		'telefono_extensionista',
		'nombre_jefe',
		'cui_jefe',
		'telefono_jefe',
		'observacion',
		'fecha_entrega',
		'estado',
		'fecha_creacion',
		'email_creacion',
		'ip_creacion',
		'fecha_modificacion',
		'email_modificacion',
		'ip_modificacion',
		'nbeneficiario'
    ];
    public static function listadoEventosComunidad($idMunicipio){ //con grupos
        return DB::select(DB::raw("
        select
                grupo_intervencion.id as id_grupo_intervencion,
                intervencion.anio as anio,
              	concat(departamento.nombre, '-',departamento.codigo) as departamento,
                  concat(municipio.nombre, '-',municipio.codigo) as municipio,
                  comunidad.nombre as comunidad,
                  detalle_intervencion.nbeneficiario,
                  movimiento.id as id_movimiento,
                  movimiento.*,
                   grupo_intervencion.nombre as insumo
                  -- group_concat(insumo.nombre) as insumo
               from grupo_intervencion
          		join movimiento on movimiento.id_grupo_intervencion = grupo_intervencion.id
              	join detalle_grupo on detalle_grupo.id_grupo_intervencion = grupo_intervencion.id
                  join detalle_intervencion on detalle_intervencion.id = detalle_grupo.id_detalle_intervencion
                  join comunidad on comunidad.id = movimiento.id_comunidad
                  join municipio on municipio.id = detalle_intervencion.id_municipio
                  join departamento on departamento.id = municipio.id_departamento
                  join intervencion on intervencion.id = detalle_intervencion.id_intervencion
                  join insumo on insumo.id = intervencion.id_insumo
                  join usuario on usuario.id = intervencion.id_usuario
                  where usuario.id_jefatura = ".Auth::user()->id_jefatura."
                  and movimiento.estado = 1
                  group by movimiento.id

        "));
    }
    public static function listadoEventosPorComunidad($idMunicipio){
    	return DB::select(DB::raw("select
    		movimiento.nbeneficiario as nbeneficiario,
    		detalle_intervencion.id as id_detalle_intervencion,
			movimiento.id as id_movimiento,
			insumo.nombre as insumo,
			municipio.nombre as municipio,
			comunidad.nombre as comunidad,
			intervencion.nombre as intervencion,
			intervencion.anio as anio,
			detalle_intervencion.cantidad,
			detalle_intervencion.precio,
			detalle_intervencion.nbeneficiario as beneficiarios,
			detalle_intervencion.cantidad_beneficiario as cantidad_por_beneficiario,
			movimiento.*
			 from movimiento
				join comunidad on comunidad.id = movimiento.id_comunidad
				join municipio on municipio.id = comunidad.id_municipio
			    join detalle_intervencion on detalle_intervencion.id = movimiento.id_detalle_intervencion
			    join intervencion on intervencion.id = detalle_intervencion.id_intervencion
			    join insumo on insumo.id = intervencion.id_insumo
			    join tipo_insumo on tipo_insumo.id = insumo.id_tipo_insumo
			    where comunidad.id_municipio = $idMunicipio and movimiento.estado = 1;"));
    }
    public static function beneficiarioIngresadosPorComunidad($id){
    	/*$data = DB::select(DB::raw("
    		select sum(nbeneficiario) as ingresados
				from movimiento where id_detalle_intervencion = $id and estado = 1;
    	"));
      */
      $data = DB::select(DB::raw("
    		select sum(nbeneficiario) as ingresados
				from movimiento where id_grupo_intervencion = $id and estado = 1;
    	"));

    	return (Object) $data[0];
    }
    public static function ubicacionMovimiento($id){
    	return DB::select(DB::raw("
    		select
			comunidad.nombre as comunidad,
			municipio.nombre as municipio,
			departamento.nombre as departamento
			 from comunidad
				join municipio on municipio.id = comunidad.id_municipio
			    join departamento on departamento.id = municipio.id_departamento
			where comunidad.id = $id
		"));
    }
    public static function dataMovimiento($id){
      return DB::select(DB::raw("
      select
			tipo_insumo.nombre as tipo,
			insumo.nombre as insumo,
			comunidad.nombre as comunidad,
			municipio.nombre as municipio,
			departamento.nombre as departamento,
      departamento.id as id_departamento,
			date_format(movimiento.fecha_entrega,'%d-%m-%Y') as fecha_entrega,
			nombre_extensionista,
			cui_extensionista,
			telefono_extensionista
			 from movimiento
				join comunidad on comunidad.id = movimiento.id_comunidad
				join municipio on municipio.id = comunidad.id_municipio
			    join departamento on departamento.id = municipio.id_departamento
			                        join grupo_intervencion on grupo_intervencion.id = movimiento.id_grupo_intervencion
                    join detalle_grupo on detalle_grupo.id_grupo_intervencion = grupo_intervencion.id
                    join detalle_intervencion on detalle_intervencion.id = detalle_grupo.id_detalle_intervencion
			    join intervencion on intervencion.id = detalle_intervencion.id_intervencion
			    join insumo on insumo.id = intervencion.id_insumo
			    join tipo_insumo on tipo_insumo.id = insumo.id_tipo_insumo
			where movimiento.id = $id group by grupo_intervencion.id;
      "));
    	/*return DB::select(DB::raw("
    		select
			tipo_insumo.nombre as tipo,
			insumo.nombre as insumo,
			comunidad.nombre as comunidad,
			municipio.nombre as municipio,
			departamento.nombre as departamento,
			date_format(movimiento.fecha_entrega,'%d-%m-%Y') as fecha_entrega,
			nombre_extensionista,
			cui_extensionista,
			telefono_extensionista
			 from movimiento
				join comunidad on comunidad.id = movimiento.id_comunidad
				join municipio on municipio.id = comunidad.id_municipio
			    join departamento on departamento.id = municipio.id_departamento
			    join detalle_intervencion on detalle_intervencion.id = movimiento.id_detalle_intervencion
			    join intervencion on intervencion.id = detalle_intervencion.id_intervencion
			    join insumo on insumo.id = intervencion.id_insumo
			    join tipo_insumo on tipo_insumo.id = insumo.id_tipo_insumo
			where movimiento.id = $id
    		"));*/
    }

    public static function detalleIngresoBeneficiario($id){
      return DB::select(DB::raw("
      select
        intervencion.anio,
        detalle_intervencion.cantidad_beneficiario as cantidad_por_beneficiario,
        grupo_intervencion.nombre as insumo,
        detalle_intervencion.cantidad as cantidad,
        detalle_intervencion.nbeneficiario as beneficiarios,
            grupo_intervencion.id as id_grupo_intervencion,
            concat(departamento.nombre, '-',departamento.codigo) as departamento,
              concat(municipio.nombre, '-',municipio.codigo) as municipio,
              comunidad.nombre as comunidad,
              detalle_intervencion.nbeneficiario,
              movimiento.*
              -- group_concat(insumo.nombre) as insumos
           from grupo_intervencion
          join movimiento on movimiento.id_grupo_intervencion = grupo_intervencion.id
            join detalle_grupo on detalle_grupo.id_grupo_intervencion = grupo_intervencion.id
              join detalle_intervencion on detalle_intervencion.id = detalle_grupo.id_detalle_intervencion
              join comunidad on comunidad.id = movimiento.id_comunidad
              join municipio on municipio.id = detalle_intervencion.id_municipio
              join departamento on departamento.id = municipio.id_departamento
              join intervencion on intervencion.id = detalle_intervencion.id_intervencion
              join insumo on insumo.id = intervencion.id_insumo
              join usuario on usuario.id = intervencion.id_usuario
              -- where usuario.id_jefatura = 5
              and movimiento.id = $id
              and movimiento.estado = 1
              group by movimiento.id
      "));
    }
}
