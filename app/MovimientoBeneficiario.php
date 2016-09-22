<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class MovimientoBeneficiario extends Model
{
    protected $table = 'movimiento_beneficiario';
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
		'id_movimiento',
		'id_beneficiario',
		'estado',
		'fecha_creacion',
		'email_creacion',
		'ip_creacion',
		'fecha_modificacion',
		'email_modificacion',
		'ip_modificacion',
		'precio',
		'nbeneficiario',
		'cantidad_beneficiario'
    ];

    public static function ingresadosMovimientoBeneficiario($id){
    	$db =  DB::select(DB::raw("select count(*) as ingresados from movimiento_beneficiario where id_movimiento = $id and estado not in(0)"));
    	return (Object) $db[0];
    }
    public static function beneficiariosIngresoEvento($id){
      return DB::select(DB::raw("
      select
	unidad_entrega.nombre as unidad_entrega,
    insumo.nombre as insumo,
    tipo_insumo.nombre as tipo_insumo,
    municipio_beneficiario.nombre as municipio_beneficiario,
                departamento_beneficiario.nombre as departamento_beneficiario,
                departamento.nombre as departamento_entrega,
                pueblo.codigo as sigla_pueblo,
                etnia.codigo as codigo_etnia,
                beneficiario.genero,
                year(curdate())-year(beneficiario.fecha_nacimiento) as edad,
                etnia.nombre as etnia,
                pueblo.nombre as pueblo,
                beneficiario.id as id_beneficiario,
                detalle_intervencion.id as id_detalle_intervencion,
                movimiento_beneficiario.id as id_movimiento_beneficiario,
                municipio.nombre as municipio,
                comunidad.nombre as comunidad,
                beneficiario.id as id_beneficiario,
                beneficiario.cui,
                beneficiario.primer_nombre,
                beneficiario.segundo_nombre,
                beneficiario.tercer_nombre,
                beneficiario.primer_apellido,
                beneficiario.segundo_apellido,
                beneficiario.apellido_casada,
                date_format(beneficiario.fecha_nacimiento,'%d-%m-%Y') as fecha_nacimiento_beneficiario,
                detalle_intervencion.cantidad_beneficiario,
                insumo.nombre as insumo
                 from movimiento_beneficiario
                    join movimiento on movimiento.id = movimiento_beneficiario.id_movimiento
                    join beneficiario on beneficiario.id = movimiento_beneficiario.id_beneficiario
                    join grupo_intervencion on grupo_intervencion.id = movimiento.id_grupo_intervencion
                    join detalle_grupo on detalle_grupo.id_grupo_intervencion = grupo_intervencion.id
                    join detalle_intervencion on detalle_intervencion.id = detalle_grupo.id_detalle_intervencion
                    join comunidad on comunidad.id = movimiento.id_comunidad
                    join municipio on municipio.id = comunidad.id_municipio
                    join intervencion on intervencion.id = detalle_intervencion.id_intervencion
                    join insumo on insumo.id = intervencion.id_insumo
                    join etnia on etnia.id = beneficiario.id_etnia
                    join pueblo on pueblo.id = beneficiario.id_pueblo
                    join departamento on departamento.id = municipio.id_departamento
                    join municipio municipio_beneficiario on municipio_beneficiario.id = beneficiario.id_municipio
                    join departamento departamento_beneficiario on departamento_beneficiario.id = municipio_beneficiario.id_departamento
                    join tipo_insumo on tipo_insumo.id = insumo.id_tipo_insumo
                    join unidad_medida unidad_entrega on unidad_entrega.id = detalle_intervencion.id_unidad_entrega
                    where movimiento.id = $id and movimiento_beneficiario.estado = 1
                    group by beneficiario.id;
      "));
        /*return DB::select(DB::raw("
                select
                unidad_entrega.nombre as unidad_entrega,
                insumo.nombre as insumo,
                tipo_insumo.nombre as tipo_insumo,
                municipio_beneficiario.nombre as municipio_beneficiario,
                departamento_beneficiario.nombre as departamento_beneficiario,
                departamento.nombre as departamento_entrega,
                pueblo.codigo as sigla_pueblo,
                etnia.codigo as codigo_etnia,
                beneficiario.genero,
                year(curdate())-year(beneficiario.fecha_nacimiento) as edad,
                etnia.nombre as etnia,
                pueblo.nombre as pueblo,
                beneficiario.id as id_beneficiario,
                detalle_intervencion.id as id_detalle_intervencion,
                movimiento_beneficiario.id as id_movimiento_beneficiario,
                municipio.nombre as municipio,
                comunidad.nombre as comunidad,
                beneficiario.cui,
                beneficiario.primer_nombre,
                beneficiario.segundo_nombre,
                beneficiario.tercer_nombre,
                beneficiario.primer_apellido,
                beneficiario.segundo_apellido,
                beneficiario.apellido_casada,
                date_format(beneficiario.fecha_nacimiento,'%d-%m-%Y') as fecha_nacimiento_beneficiario,
                detalle_intervencion.cantidad_beneficiario,
                insumo.nombre as insumo
                 from movimiento_beneficiario
                    join movimiento on movimiento.id = movimiento_beneficiario.id_movimiento
                    join beneficiario on beneficiario.id = movimiento_beneficiario.id_beneficiario
                    join detalle_intervencion on detalle_intervencion.id = movimiento.id_detalle_intervencion
                    join comunidad on comunidad.id = movimiento.id_comunidad
                    join municipio on municipio.id = comunidad.id_municipio
                    join intervencion on intervencion.id = detalle_intervencion.id_intervencion
                    join insumo on insumo.id = intervencion.id_insumo
                    join etnia on etnia.id = beneficiario.id_etnia
                    join pueblo on pueblo.id = beneficiario.id_pueblo
                    join departamento on departamento.id = municipio.id_departamento
                    join municipio municipio_beneficiario on municipio_beneficiario.id = beneficiario.id_municipio
                    join departamento departamento_beneficiario on departamento_beneficiario.id = municipio_beneficiario.id_departamento
                    join tipo_insumo on tipo_insumo.id = insumo.id_tipo_insumo
                    join unidad_medida unidad_entrega on unidad_entrega.id = detalle_intervencion.id_unidad_entrega
                    where movimiento.id = $id and movimiento_beneficiario.estado = 1;
            "));*/
    }
    public static function maxBeneficiario(){
      $data =  DB::select(DB::raw("
          select length(max(id)) as max from beneficiario ;
      "));

      return $data[0]->max;
    }
    public static function insumosGrupoIntervencion($id){
      $data = DB::select(DB::raw("
        select
        group_concat(
        	concat(
                detalle_intervencion.cantidad_beneficiario,' ',
                unidad_medida.abreviatura,'. DE ',
                insumo.nombre
        	)

         ) as insumo
        			 from movimiento
        				join comunidad on comunidad.id = movimiento.id_comunidad
        				join municipio on municipio.id = comunidad.id_municipio
        			    join departamento on departamento.id = municipio.id_departamento

        			                        join grupo_intervencion on grupo_intervencion.id = movimiento.id_grupo_intervencion
                            join detalle_grupo on detalle_grupo.id_grupo_intervencion = grupo_intervencion.id
                            join detalle_intervencion on detalle_intervencion.id = detalle_grupo.id_detalle_intervencion
        			    join intervencion on intervencion.id = detalle_intervencion.id_intervencion
                        join unidad_medida on unidad_medida.id = detalle_intervencion.id_unidad_entrega
        			    join insumo on insumo.id = intervencion.id_insumo
        			    join tipo_insumo on tipo_insumo.id = insumo.id_tipo_insumo
        			where movimiento.id = $id
                    and detalle_grupo.estado = 1 ;
      "));

      return $data[0]->insumo;
    }
}
