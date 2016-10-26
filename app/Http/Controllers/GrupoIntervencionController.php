<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DNS1D;
use Carbon\Carbon;
use App\Http\Requests;
use App\GrupoIntervencion;
use App\Beneficiario;
use App\DistribucionMovimiento;
use App\Comunidad;
use App\Movimiento;
use App\Departamento;
use App\Etnia;
use App\Pueblo;
use App\JefeDepartamental;
use App\MovimientoBeneficiario;
class GrupoIntervencionController extends Controller
{
    public function distribucionMunicipal($jefatura){
      return view('entrega.distribucion-municipal');
    }
    public function distribucionComunidad($jefatura,$id){
      //id de grupo_intervencion.
      $detalleGrupoIntervencion = GrupoIntervencion::detalleGrupoIntervencion($id);
      $comunidades = Comunidad::divisionTipoDivision($detalleGrupoIntervencion[0]->id_municipio);
      return view('entrega.distribucion-comunidad',[
        'id'=>$id,
        'comunidades'=>$comunidades,
        'detalle'=>$detalleGrupoIntervencion
      ]);
    }
    public function distribucionEvento($jefatura,$id){
      //id de movimiento
      $detalleGrupoIntervencion = GrupoIntervencion::distribucionEvento($id);
      $comunidad = Comunidad::all();
      $movimiento = Movimiento::find($id);
      return view('entrega.distribucion-evento',[
        'id'=>$id,
        'detalle'=>$detalleGrupoIntervencion,
        'comunidades'=>$comunidad,
        'movimiento'=>$movimiento
      ]);
    }
    public function todoDistribucionMunicipal(Request $request){
      if($request->ajax()){
          $grupos = GrupoIntervencion::distribucionMunicipal();
          return response()->json(["data"=>$grupos]);
      }else{
        return response()->json([]);
      }
    }
    public function todoDistribucionComunidad(Request $request, $id){
      if($request->ajax()){
          $grupos = GrupoIntervencion::distribucionComunidad($id);
          return response()->json(["data"=>$grupos]);
      }else{
        return response()->json([]);
      }
    }
    public function todoDistribucionEvento(Request $request, $id){
      if($request->ajax()){
          $grupos = GrupoIntervencion::distribucionEventos($id);
          return response()->json(["data"=>$grupos]);
      }else{
        return response()->json([]);
      }
    }
    public function NuevaDistribucionEvento(Request $request){
      //-- validación para no exceder el techo del movimiento //
      $movimiento = Movimiento::find($request->id_movimiento);
      $techoMovimiento = $movimiento->nbeneficiario;
      $totalAsignado = DistribucionMovimiento::totalAsignacionEvento($request->id_movimiento);

      $distribucionMovimiento = new DistribucionMovimiento;
      $distribucionMovimiento->id_movimiento = $request->id_movimiento;
      $distribucionMovimiento->cantidad = $request->cantidad_beneficiario;
      $distribucionMovimiento->nbeneficiario = $request->nbeneficiario;
      $distribucionMovimiento->estado = 1;
      $distribucionMovimiento->fecha_creacion = Carbon::now();
      $distribucionMovimiento->email_creacion = (isset(Auth::user()->email)) ? Auth::user()->email : 'guest' ;
      $distribucionMovimiento->ip_creacion = $request->ip();
      $distribucionMovimiento->save();

      $jefatura =  \App\User::usuarioToJefatura();
      return redirect()->action('GrupoIntervencionController@distribucionEvento',[$jefatura,$request->id_movimiento]);

    }

    public function beneficiarioIngreso($jefatura,$id){ ///-- id de distribucion_movimiento
        //$movimiento = Movimiento::find($id);
        $distribucionMovimiento = DistribucionMovimiento::find($id);
        $movimiento = Movimiento::find($distribucionMovimiento->id_movimiento);
        $comunidad = Comunidad::find($movimiento->id_comunidad);

        //$detalles = DetalleIntervencion::detalleIntervencionIngreso($movimiento->id_detalle_intervencion);
        // PRECAUCIÓN:: ESTA FUNCIÓN NO CONTIENE LOS VALORES REALES.
        $detalles = Movimiento::detalleIngresoBeneficiario($distribucionMovimiento->id_movimiento);//DetalleIntervencion::detalleIntervencionIngreso(1);

        $departamento = Departamento::whereEstado(1)->orderBy('nombre','ASC')->get();
        $etnia = Etnia::whereEstado(1)->orderBy('nombre','ASC')->get();
        $pueblo = Pueblo::whereEstado(1)->orderBy('nombre','ASC')->get();

        return view('entrega.ingreso-beneficiario', ['detalle'=>$detalles[0], 'departamentos'=>$departamento,
            "etnia"=>$etnia,
            "pueblo"=>$pueblo,
            "movimiento"=>$movimiento,
            "comunidad"=>$comunidad,
            "distribucion"=>$distribucionMovimiento
            ]);
    }

    public function recursosDistribucion($jefatura, $id){
      $movimiento = Movimiento::find($id);

      return view('entrega.distribucion-recursos',['movimiento'=>$movimiento]);
    }

    public function descargaPlanillaGeneral($jefatura, $id){
    $data = MovimientoBeneficiario::beneficiariosIngresoEvento($id);
    $movimiento = Movimiento::dataMovimiento($id);
    $movimientoObject = (Object) $movimiento[0];
    /*$movimiento = Movimiento::find($id);
    $ubicacionMovimiento = Movimiento::ubicacionMovimiento($id);*/
    //--- LOGICA PARA HOJAS DE PDF --//
    $pages = [];
    $i=0;
    $pagesItem = [];
    $registerCount = 0;
    $pagesCount = 0;

    foreach ($data as $value) {
        if($registerCount == 10){
            array_push($pages, $pagesItem);
            $pagesItem = [];
            $registerCount =0;
        }
        array_push($pagesItem, $value);
        $registerCount++;
    }

    array_push($pages,$pagesItem);

    //return view('movimiento.planilla-beneficiarios-evento',['pages'=>$pages]);die;
    $pdf = \PDF::loadView('movimiento.planilla-beneficiarios-evento',
        [

        'movimiento'=>$movimientoObject,
        'pages'=>$pages,
        'legend'=>$data[0]->nombre_intervencion,
        'medidaEntrega'=>$data[0]->unidad_entrega
        ])->setPaper("A4","landscape");
      return $pdf->download("planilla".substr(\Crypt::encrypt($id), 0, 9).'.pdf');
    }

    public function descargaPlanillaUnica($jefatura, $id){

          $data = \App\MovimientoBeneficiario::beneficiariosIngresoEvento($id);
          //$movimiento = \App\Movimiento::find($id);
          $movimiento = Movimiento::dataMovimiento($id);
          $movimientoObject = (Object) $movimiento[0];


          $jefeDepartamental = JefeDepartamental::whereIdDepartamento($movimiento[0]->id_departamento)->get();

          //--- LOGICA PARA HOJAS DE PDF --//
          $pages = [];
          $i=0;
          $pagesItem = [];
          $registerCount = 0;
          $pagesCount = 0;
          $complete = 0;
          $cantCompleto=null;
          $zeros = "";


          foreach ($data as $value) {
              $max = MovimientoBeneficiario::maxBeneficiario();
              $lengthCrypto = strlen($value->id_beneficiario);

              for ($i=0; $i < ($max-$lengthCrypto); $i++) {
                  $i = $i;
              }

              for ($j=0; $j < $i ; $j++) {
                $zeros.="0";
              }

              $crypto = $zeros.$value->id_movimiento_beneficiario;

              //$value->{'barcode'} = DNS1D::getBarcodePNG($crypto, "C39+",1,30);
              $value->{'cui'} = Beneficiario::cuiImpresion($value->cui);
              $value->{'barcode'} = DNS1D::getBarcodePNG($crypto, "C128",3,30);
              $value->{'insumo'} = MovimientoBeneficiario::insumosCadena(MovimientoBeneficiario::insumosGrupoIntervencion($id));//MovimientoBeneficiario::insumosGrupoIntervencion($id);
              $value->{'code'} = $value->id_beneficiario.$crypto;
              //$value['codebar'] = [];
              if($registerCount == 3){
                  array_push($pages, $pagesItem);
                  $pagesItem = [];
                  $registerCount =0;
              }
              array_push($pagesItem, $value);
              $registerCount++;
              $zeros="";
          }
          array_push($pages,$pagesItem);

          //return view('movimiento.boleta-beneficiarios-evento',['pages'=>$pages]);die;
          $customPaper = array(0,0,612.283464567,935.433070866);

          $pdf = \PDF::loadView('movimiento.boleta-beneficiarios-evento',
              [

              'movimiento'=>$movimientoObject,
              'jefeDepartamental'=>$jefeDepartamental[0],
              'pages'=>$pages,
            ])->setPaper("Legal");//setPaper($customPaper);//->setPaper("A4"); //,"landscape"
          //return $pdf->download("boletas".substr(\Crypt::encrypt($id), 0, 9).'.pdf');
          return $pdf->download('boletas.pdf');
    }
}
