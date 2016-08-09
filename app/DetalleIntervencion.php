<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use App\Partida;
class DetalleIntervencion extends Model
{
    protected $table = 'detalle_intervencion';
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
		'id_intervencion',
		'id_unidad_medida',
		'id_partida_presupuestaria',
		'id_municipio',
		'cantidad',
		'estado',
		'fecha_creacion',
		'email_creacion',
		'ip_creacion',
		'fecha_modificacion',
		'email_modificacion',
		'ip_modificacion',
		'precio',
		'nbeneficiario',
		'cantidad_beneficiario',
		'id_unidad_entrega'
    ];
    public static function detalleIntervencion($id){
    	return DB::select(DB::raw("
    		select 
				municipio.id as id_municipio,
				detalle_intervencion.id_unidad_medida,
				fuente_financiamiento.id as id_fuente,
				renglon.id as id_renglon,
				partida.id as id_partida,
				detalle_intervencion.id as id_detalle,
				detalle_intervencion.cantidad,
				detalle_intervencion.precio,
				detalle_intervencion.nbeneficiario,
				detalle_intervencion.cantidad_beneficiario,
				detalle_intervencion.estado,
				detalle_intervencion.id_unidad_entrega
				 from detalle_intervencion 
					join partida on partida.id = detalle_intervencion.id_partida_presupuestaria
				    join renglon on renglon.id = partida.id_renglon
				    join municipio on municipio.id = partida.id_municipio
				    join fuente_financiamiento on fuente_financiamiento.id = partida.id_fuente_financiamiento
					where detalle_intervencion.id_intervencion = $id
				    and detalle_intervencion.estado not in(0);
    	"));
    }
    public static function partidasPorRenglon($id, $idMunicipio){
    	return Partida::whereIdRenglon($id)->whereIdMunicipio($idMunicipio)->get();
    }
    public static function detalleIntervencionIngreso($id){
    	return DB::select(DB::raw("
    		select 
				intervencion.id as id_intervencion,
				detalle_intervencion.id as id_detalle_intervencion,
				case intervencion.orden
					when 1 then 'PRIMERA INTERVENCIÓN'
				    when 2 then 'SEGUNDA INTERVENCIÓN'
				    when 3 then 'TERCERA INTERVENCIÓN'
				    when 4 then 'CUARTA INTERVENCIÓN'
				end as orden,
				concat(tipo_insumo.nombre,' - ',insumo.nombre) as insumo,
				concat(departamento.nombre) as departamento,
				concat(municipio.nombre) as municipio,
				detalle_intervencion.nbeneficiario as beneficiarios,
				detalle_intervencion.cantidad_beneficiario,
				case unidad_medida.id
					when 1 then concat(detalle_intervencion.cantidad_beneficiario, ' LBS')
				end  as cantidad_por_beneficiario,
				detalle_intervencion.cantidad,
				unidad_medida.nombre as unidad_medida,
				case unidad_medida.id 
					when 1 then ( detalle_intervencion.cantidad*unidad_medida.cantidad_libra )
				end as total_comprado,
				detalle_intervencion.precio,
				partida.codigo
				 from intervencion
					join detalle_intervencion on detalle_intervencion.id_intervencion = intervencion.id
				    join insumo on insumo.id = intervencion.id_insumo
				    join tipo_insumo on tipo_insumo.id = insumo.id_tipo_insumo
					join municipio on municipio.id = detalle_intervencion.id_municipio
				    join departamento on departamento.id = municipio.id_departamento
				    join unidad_medida on unidad_medida.id = detalle_intervencion.id_unidad_medida
				    join partida on partida.id = detalle_intervencion.id_partida_presupuestaria
				    where detalle_intervencion.estado = 1
						and detalle_intervencion.id= $id
    	"));
    }
    public static function detalleIntervencionMunicipal($idMunicipio){
    	return DB::select(DB::raw("
    		select 
				intervencion.id as id_intervencion,
				detalle_intervencion.id as id_detalle_intervencion,
				case intervencion.orden
					when 1 then 'PRIMERA INTERVENCIÓN'
				    when 2 then 'SEGUNDA INTERVENCIÓN'
				    when 3 then 'TERCERA INTERVENCIÓN'
				    when 4 then 'CUARTA INTERVENCIÓN'
				end as orden,
				concat(tipo_insumo.nombre,' - ',insumo.nombre) as insumo,
				concat(departamento.codigo,' - ',departamento.nombre) as departamento,
				concat(municipio.codigo,' - ',municipio.nombre) as municipio,
				detalle_intervencion.nbeneficiario as beneficiarios,
				detalle_intervencion.cantidad_beneficiario,
				concat(detalle_intervencion.cantidad_beneficiario, ' ', medida_entrega.nombre) as cantidad_por_beneficiario,
				detalle_intervencion.cantidad,
				unidad_medida.nombre as unidad_medida,
				case unidad_medida.id 
					when 1 then ( detalle_intervencion.cantidad*unidad_medida.cantidad_libra )
				end as total_comprado,
				detalle_intervencion.precio,
				partida.codigo
				 from intervencion
					join detalle_intervencion on detalle_intervencion.id_intervencion = intervencion.id
				    join insumo on insumo.id = intervencion.id_insumo
				    join tipo_insumo on tipo_insumo.id = insumo.id_tipo_insumo
					join municipio on municipio.id = detalle_intervencion.id_municipio
				    join departamento on departamento.id = municipio.id_departamento
				    join unidad_medida on unidad_medida.id = detalle_intervencion.id_unidad_medida
				    join unidad_medida medida_entrega on medida_entrega.id = detalle_intervencion.id_unidad_entrega
				    join partida on partida.id = detalle_intervencion.id_partida_presupuestaria
				    where detalle_intervencion.estado = 1
				    and detalle_intervencion.id_municipio = $idMunicipio;
    	"));
    }
    public static function exportToExcel($id){
		return DB::select(DB::raw('
			select 
				concat("#",intervencion.id ) as intervencion,
				concat(departamento.codigo, "-", departamento.nombre) as departamento,
				concat(municipio.codigo, "-", municipio.nombre) as municipio,
				partida.codigo,
				intervencion.nombre as base_legal,
				intervencion.anio as anio_intervencion,
				tipo_insumo.nombre as tipo_insumo,
				insumo.nombre as insumo,
				detalle_intervencion.cantidad,
				detalle_intervencion.precio,
				unidad_compra.nombre as unidad_compra,
				detalle_intervencion.nbeneficiario as beneficiarios_convocados,
				detalle_intervencion.cantidad_beneficiario as cantidad_beneficiario,
				unidad_entrega.nombre as unidad_entrega
				 from intervencion
					join detalle_intervencion on detalle_intervencion.id_intervencion = intervencion.id
				    join insumo on insumo.id = intervencion.id_insumo
				    join tipo_insumo on tipo_insumo.id = insumo.id_tipo_insumo
				    join unidad_medida unidad_compra on unidad_compra.id = detalle_intervencion.id_unidad_medida
				    join unidad_medida unidad_entrega on unidad_entrega.id = detalle_intervencion.id_unidad_entrega
				    join partida on partida.id = detalle_intervencion.id_partida_presupuestaria
				    join municipio on municipio.id = detalle_intervencion.id_municipio
				    join departamento on departamento.id = municipio.id_departamento
				    where intervencion.id = '.$id));    	
    }
}
