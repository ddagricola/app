<?php

namespace App;
use DB;
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
    	$data = DB::select(DB::raw("
    		select sum(nbeneficiario) as ingresados
				from movimiento where id_detalle_intervencion = $id and estado = 1;
    	"));
    	
    	return (Object) $data[0];
    }
}
