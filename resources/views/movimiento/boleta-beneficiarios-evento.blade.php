<?php //ini_set('memory_limit', '-1'); ?>
<?php //ini_set('max_execution_time', '-1'); ?>

<style type="text/css">
  html{
    margin: 0px;
  }
 .item-page{
   /*height: 10.8cm;*/
   height: 11cm;
   border-bottom: 1px solid black;
   border-bottom-style:  dashed;
 }
 .table-image{
   margin-top: 10px;
   width: 100%;
 }
 .table-image tr td{
   width: 50%;
 }
 .box-barcode,.box-codigo {
   text-align: center;
 }
 .box-codigo{
   font-size: 13px;
 }
 .titulo-boleta{
   width: 100%;
   text-align: center;
   font-size: 14px;
   font-weight: bold;
 }
 .titulo-leyenda{
   width: 100%;
   text-align: center;
   font-size: 12px;
   height: 0.7cm;
   line-height: 12px;
 }
 .titulo-leyenda span{
   height: 0.7cm;
 }
 .td-grid-data tr td{
   width: 400px;
 }
 .td-grid-beneficiario .td-grid-tittle{
   font-size: 12px;
   text-decoration: underline;
   font-weight: bold;
   width: 100%;
 }
 .line-data{
   width: 100%;
   overflow: hidden;
 }
.line-data .line-data-tittle{
    font-size: 13px;
    font-weight: bold;
}
.line-data-tittle-value{
  font-size: 12px;
}
.line-name-data{
  font-size: 8px;
}
.table-firmas{
  width: 100%;
}
.table-firmas tr td{
  clear:both;
}
.content-data{
  height: 9.5cm;
}
.content-firmas{
  height: 1.5 cm;
}
.content-firmas tr td div{
  width: 100%;
  font-size: 12px;
}
</style>
@foreach ($pages as $page)
	<div class="page">
		@foreach ($page as $item)
			<div class="item-page">
        <div class="content-data">
				<table class="table-image">
				  <tr>
				    <td>
              @if(Auth::user()->id_jefatura==1)
  							<img src="{{public_path().'/img/BOLETA-GRANOSBASICOS.jpg'}}" style="width:500px;">
              @elseif(Auth::user()->id_jefatura==2)
                <img src="{{public_path().'/img/BOLETA-DEFRUTA.jpg'}}" style="width:500px;">
              @elseif(Auth::user()->id_jefatura==3)
                <img src="{{public_path().'/img/BOLETA-CUENCASHIDROGRAFICAS.jpg'}}" style="width:500px;">
              @elseif(Auth::user()->id_jefatura==4)
                <img src="{{public_path().'/img/BOLETA-CULTIVOSAGROINDUSTRIALIZABLES.jpg'}}" style="width:500px;">
  						@elseif(Auth::user()->id_jefatura==5)
  							<img src="{{public_path().'/img/BOLETA-HORTICULTURA.jpg'}}" style="width:500px;">
  						@endif
				    </td>
            <td class="td-barcode">
              <div class="box-barcode">
  								<img src="data:image/png;base64,{{$item->barcode}}"/>
  						</div>
  						<div class="box-codigo">
  							<span>{{$item->code}}</span>
  						</div>
            </td>
				  </tr>
				</table>
        <!-- titulo de planilla unica -->
        <div class="titulo-boleta">
          <span>PLANILLA <!--ÚNICA--> DE BENEFICIARIO - {{ $item->tipo_insumo }} </span>
        </div>
        <div class="titulo-leyenda">
          <span>
            {{ $item->nombre_intervencion }}
          </span>
        </div>
        <!-- tabla de datos -->
        <table class="td-grid-data">
          <tr>
            <td class="td-grid-beneficiario">
              <span class="td-grid-tittle">DATOS DE BENEFICIARIO</span>
              <div class="line-data" style="margin-top:4px">
                <div style="width:30%; display: inline-block">
                  <span class="line-data-tittle">Nombre Completo:</span>
                </div>
                <div style="width:2%; display: inline-block">
                </div>
                <div style="width:63.3%; display: inline-block">
                  <span class="line-data-tittle-value">
                    {{ $item->primer_nombre }}
      							{{ $item->segundo_nombre }}
      							{{ $item->tercer_nombre }}
      							{{ $item->primer_apellido }}
      							{{ $item->segundo_apellido }}
      							@if ($item->apellido_casada != "" || $item->apellido_casada != null)
      								{{ $item->apellido_casada }}
      							@endif
                  </span>
                </div>
              </div>
              <!-- cui -->
              <div class="line-data">
                <div style="width:30%; display: inline-block">
                  <span class="line-data-tittle">No. de DPI:</span>
                </div>
                <div style="width:2%; display: inline-block">
                </div>
                <div style="width:63.3%; display: inline-block">
                  <span class="line-data-tittle-value">
                    {{ $item->cui }}
                  </span>
                </div>
              </div>
              <!-- fecha de nacimiento -->
              <div class="line-data">
                <div style="width:32%; display: inline-block">
                  <span class="line-data-tittle">Fecha de Nacimiento:</span>
                </div>
                <div style="width:0%; display: inline-block">
                </div>
                <div style="width:53.3%; display: inline-block">
                  <span class="line-data-tittle-value">
                    <?php $date = explode('-',$item->fecha_nacimiento_beneficiario); ?>
        						{{ $item->fecha_nacimiento_beneficiario }}
                  </span>
                </div>
              </div>
              <div class="line-data">
                <div style="width:32%; display: inline-block">
                  <span class="line-data-tittle">Edad:</span>
                </div>
                <div style="width:0%; display: inline-block">
                </div>
                <div style="width:53.3%; display: inline-block">
                  <span class="line-data-tittle-value">
                    <?php $date = explode('-',$item->fecha_nacimiento_beneficiario); ?>
        						{{ date("Y") - $date[2] }} AÑOS
                  </span>
                </div>
              </div>
              <!-- sexo -->
              <div class="line-data">
                <div style="width:30%; display: inline-block">
                  <span class="line-data-tittle">Sexo:</span>
                </div>
                <div style="width:2%; display: inline-block">
                </div>
                <div style="width:63.3%; display: inline-block">
                  <span class="line-data-tittle-value">
                    @if($item->genero==1)
      								MASCULINO
      							@else
      								FEMENINO
      							@endif
                  </span>
                </div>
              </div>
              <!-- pueblo -->
              <div class="line-data">
                <div style="width:30%; display: inline-block">
                  <span class="line-data-tittle">Pueblo:</span>
                </div>
                <div style="width:2%; display: inline-block">
                </div>
                <div style="width:63.3%; display: inline-block">
                  <span class="line-data-tittle-value">
                    {{$item->pueblo}}
                  </span>
                </div>
              </div>
              <!-- etnia -->
              <div class="line-data">
                <div style="width:30%; display: inline-block">
                  <span class="line-data-tittle">Etnia:</span>
                </div>
                <div style="width:2%; display: inline-block">
                </div>
                <div style="width:63.3%; display: inline-block">
                  <span class="line-data-tittle-value">
                    {{$item->etnia}}
                  </span>
                </div>
              </div>
            </td>
            <td class="td-grid-beneficiario">
              <span class="td-grid-tittle">DATOS DE ENTREGA</span>
              <div class="line-data" style="margin-top:4px">
                <div style="width:30%; display: inline-block">
                  <span class="line-data-tittle">Departamento:</span>
                </div>
                <div style="width:2%; display: inline-block">
                </div>
                <div style="width:63.3%; display: inline-block">
                  <span class="line-data-tittle-value">
                    {{ $item->departamento_entrega }}
                  </span>
                </div>
              </div>
              <div class="line-data">
                <div style="width:30%; display: inline-block">
                  <span class="line-data-tittle">Municipio:</span>
                </div>
                <div style="width:2%; display: inline-block">
                </div>
                <div style="width:63.3%; display: inline-block">
                  <span class="line-data-tittle-value">
                    {{ $item->municipio }}
                  </span>
                </div>
              </div>
              <div class="line-data">
                <div style="width:30%; display: inline-block">
                  <span class="line-data-tittle">Comunidad:</span>
                </div>
                <div style="width:2%; display: inline-block">
                </div>
                <div style="width:63.3%; display: inline-block">
                  <span class="line-data-tittle-value">
                    {{ $item->comunidad }}
                  </span>
                </div>
              </div>
              <!-- cui -->
              <div class="line-data">
                <div style="width:30%; display: inline-block">
                  <span class="line-data-tittle">Fecha de Entrega:</span>
                </div>
                <div style="width:2%; display: inline-block">
                </div>
                <div style="width:63.3%; display: inline-block">
                  <span class="line-data-tittle-value">
                    {{ $movimiento->fecha_entrega }}
                  </span>
                </div>
              </div>
              <!-- fecha de nacimiento -->
              <!---<div class="line-data">
                <div style="width:32%; display: inline-block">
                  <span class="line-data-tittle">Insumo Entregado:</span>
                </div>
                <div style="width:0%; display: inline-block">
                </div>
                <div style="width:53.3%; display: inline-block">
                  <span class="line-data-tittle-value">
                    {{ $item->tipo_insumo }}
                  </span>
                </div>
              </div>-->
              <!-- sexo -->
              <div class="line-data">
                <div style="width:30%; display: inline-block">
                  <span class="line-data-tittle">Cantidad Entregada:</span>
                </div>
                <div style="width:2%; display: inline-block">
                </div>
                <div style="width:63.3%; display: inline-block">
                  <!-- listado de insumos para granos básicos -->
                  @if (Auth::user()->id_jefatura == 1)
                  <span class="line-data-tittle-value">
                    {{-- $item->cantidad_parcial --}} {{-- $item->unidad_entrega --}} {{ $item->insumo }}
                  </span>
                  @elseif (Auth::user()->id_jefatura == 5) <!-- horticultura -->
                  <span class="line-data-tittle-value">
                    {{ $item->insumo }}
                  </span>
                  @else
                  <span class="line-data-tittle-value">
                    {{ $item->cantidad_parcial }} {{ $item->tipo_insumo }}
                  </span>
                  <span class="line-data-tittle-value" style="font-size:10px">
                    ( AZADON, PALA, PIOCHA, CHUZO, MACHETE )
                  </span>
                  @endif
                </div>
              </div>
            </td>
          </tr>
        </table>
      </div>
      <div class="content-firmas">
        <table class="table-firmas">
          <tr>
            <td style="border-bottom:1px solid black"></td>
            <td style="width:2%"></td>
            <td style="border-bottom:1px solid black"></td>
            <td style="width:2%"></td>
            <td style="border-bottom:1px solid black"></td>
          </tr>
          <tr>
            <td>
              <div class="">
                <div style="width:100%; text-align:center"><span>Firma o Huella Digital de Beneficiario</span></div>
                <div style="width:100%; text-align:center;color:white"><span>{{$movimiento->nombre_extensionista}}</span></div>
                <div style="width:100%; text-align:center;color:white"><span>DPI: 11111111111 TELÉFONO: 44444444</span></div>
              </div>
            </td>
            <td style="width:2%"></td>
            <td>
              <div style="width:100%; text-align:center"><span>Firma de Extensionista o Técnico Responsable</span></div>
              <div style="width:100%; text-align:center; font-size:10px"><span>NOMBRE: {{$movimiento->nombre_extensionista}}</span></div>
              <div style="width:100%; text-align:center;font-size:10px"><span><!--DPI: {{$movimiento->cui_extensionista}}--> TELÉFONO: 11111111{{$movimiento->telefono_extensionista}}</span></div>
            </td>
            <td style="width:2%"></td>
            <td>
              <div style="width:100%; text-align:center"><span>Firma y Sello de Jefe Departamental</span></div>
              <div style="width:100%; text-align:center"><span>Nombre: {{$jefeDepartamental->nombre}}</span></div>
              <div style="width:100%; text-align:center;color:white"><span>DPI: 11111111111 TELÉFONO: 44444444</span></div>
            </td>
          </tr>
        </table>
      </div>
			</div>
		@endforeach
	</div>
@endforeach
