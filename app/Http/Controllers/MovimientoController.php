<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DNS1D;
use App\Http\Requests;
use App\Municipio;
use App\Comunidad;
use App\Movimiento;
use Carbon\Carbon;
use App\DetalleIntervencion;
use App\MovimientoBeneficiario;
use App\GrupoIntervencion;
use Auth;
use App\JefeDepartamental;
class MovimientoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function todoEventoComunidad(Request $request, $id){
         if($request->ajax()){
            //$listado = Movimiento::listadoEventosPorComunidad($id);
            $listado = Movimiento::listadoEventosComunidad($id);
            return response()->json(["data"=>$listado]);
        }
    }
    public function movimientoMunicipal($idMunicipio, $idDetalleIntervencion){
        $municipio = Municipio::find($idMunicipio);
        $comunidades = Comunidad::divisionTipoDivision($idMunicipio);//whereIdMunicipio($idMunicipio)->with("municipios")->get();
        return view('movimiento.listado-comunidad',["municipio"=>$municipio, "comunidades"=>$comunidades,"id_detalle_intervencion"=>$idDetalleIntervencion]);
    }

    public function listadoEntregas($id){ //id de grupo intervencion
        $idMunicipio = GrupoIntervencion::municipioGrupoIntervencion($id);
        $municipio = Municipio::find($idMunicipio);
        $comunidades = Comunidad::divisionTipoDivision($idMunicipio);//whereIdMunicipio($idMunicipio)->with("municipios")->get();
        //return view('movimiento.listado-entregas',["municipio"=>$municipio, "comunidades"=>$comunidades,"id_detalle_intervencion"=>$idDetalleIntervencion]);
        return view('movimiento.listado-entregas',["municipio"=>$municipio, "comunidades"=>$comunidades,"id_grupo_intervencion"=>$id]);
    }

    public function nuevoEventoComunidad(Request $request){
        //$detalleIntervencion = DetalleIntervencion::find($request->id_detalle_intervencion);

        $detalleIntervencion = GrupoIntervencion::beneficiariosGrupoIntervencion($request->id_grupo_intervencion);

        //$beneficiarios = Movimiento::beneficiarioIngresadosPorComunidad($request->id_detalle_intervencion);
        $beneficiarios = Movimiento::beneficiarioIngresadosPorComunidad($request->id_grupo_intervencion);


        $beneficiariosAutorizados = $detalleIntervencion->nbeneficiario;
        $beneficiariosRegistrados = ($beneficiarios->ingresados == null)? 0 : $beneficiarios->ingresados;
        $beneficiariosSolicitud = $request->nbeneficiario;
        $guardar = 0;
        $mensaje = "";
        //echo $beneficiariosAutorizados."<br>";
        //echo $beneficiariosRegistrados."<br>";
        //echo $beneficiariosSolicitud."<br>";

        if($beneficiariosRegistrados < $beneficiariosAutorizados){
            $beneficiariosIngresados = ($beneficiariosRegistrados + $beneficiariosSolicitud);
            if($beneficiariosIngresados <= $beneficiariosAutorizados){
            }else{
                if($beneficiariosSolicitud > $beneficiariosAutorizados){
                    $mensaje = "La cantidad de beneficiarios solitados ($beneficiariosSolicitud) supera los autorizados ($beneficiariosAutorizados).";
                $guardar = 1;
                }else{
                    $mensaje = "No se pueden registrar $beneficiariosSolicitud beneficiarios por que ya se encuentran $beneficiariosRegistrados de $beneficiariosAutorizados ingresados.";
                    $guardar = 1;
                }
            }
        }else{
            $mensaje = "No se pueden registrar $beneficiariosSolicitud beneficiarios por que ya se encuentran $beneficiariosRegistrados de $beneficiariosAutorizados ingresados.";
            $guardar = 1;
        }

        if($guardar==0){
            $movimiento = new Movimiento;
            $movimiento->id_comunidad = $request->id_comunidad;
            //$movimiento->id_detalle_intervencion = $request->id_detalle_intervencion;
            $movimiento->id_grupo_intervencion = $request->id_grupo_intervencion;
            $movimiento->nombre_extensionista = strtoupper($request->nombre_extensionista);
            $movimiento->cui_extensionista = $request->dpi_extensionista;
            $movimiento->telefono_extensionista = $request->telefono_extensionista;
            $movimiento->nombre_jefe = null;//strtoupper($request->nombre_jefe);
            $movimiento->cui_jefe = null;//$request->dpi_jefe_departamental;
            $movimiento->telefono_jefe = null; //$request->telefono_nombre_jefe;
            $movimiento->observacion = null;
            $movimiento->fecha_entrega = Carbon::parse($this->strdate_slash($request->fecha_evento))->format('Y-m-d');
            $movimiento->estado = 1;
            $movimiento->fecha_creacion = Carbon::now();
            $movimiento->email_creacion = (Auth::check()) ? Auth::user()->email:"guest" ;
            $movimiento->ip_creacion = $request->ip();
            $movimiento->nbeneficiario = $request->nbeneficiario;
            $movimiento->save();
        }else{
            \Session::flash('message', $mensaje);
            \Session::flash('alert-class', 'alert-danger');
        }

        //return redirect()->action('MovimientoController@movimientoMunicipal',[$request->id_municipio, $request->id_detalle_intervencion]);
        return redirect()->action('MovimientoController@listadoEntregas',[$request->id_grupo_intervencion]);
        /*******
        $movimiento = new Movimiento;
                $movimiento->id_comunidad = $request->id_comunidad;
                $movimiento->id_detalle_intervencion = $request->id_detalle_intervencion;
                $movimiento->nombre_extensionista = $request->nombre_extensionista;
                $movimiento->cui_extensionista = $request->dpi_extensionista;
                $movimiento->telefono_extensionista = $request->telefono_extensionista;
                $movimiento->nombre_jefe = $request->nombre_jefe;
                $movimiento->cui_jefe = $request->dpi_jefe_departamental;
                $movimiento->telefono_jefe = $request->telefono_nombre_jefe;
                $movimiento->observacion = null;
                $movimiento->fecha_entrega = null;
                $movimiento->estado = 1;
                $movimiento->fecha_creacion = Carbon::now();
                $movimiento->email_creacion = (Auth::check()) ? Auth::user()->email:"guest" ;
                $movimiento->ip_creacion = $request->ip();
                $movimiento->nbeneficiario = $request->nbeneficiario;
                $movimiento->save();

                return redirect()->action('MovimientoController@movimientoMunicipal',[$request->id_municipio, $request->id_detalle_intervencion]);
        *********/

    }
    public function exportarPlanillaBeneficiarios($id){
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
        ])->setPaper("A4","landscape");
      return $pdf->download("planilla".substr(\Crypt::encrypt($id), 0, 9).'.pdf');
    }

    public function exportarBoletasBeneficiarios($id){
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
        $pdf = \PDF::loadView('movimiento.boleta-beneficiarios-evento',
            [

            'movimiento'=>$movimientoObject,
            'jefeDepartamental'=>$jefeDepartamental[0],
            'pages'=>$pages,
            ])->setPaper("A4"); //,"landscape"
        return $pdf->download("boletas".substr(\Crypt::encrypt($id), 0, 9).'.pdf');
    }
    public function eventoBeneficiarios($id){
        $movimiento = Movimiento::find($id);

        $data = MovimientoBeneficiario::beneficiariosIngresoEvento($id);

        return view("movimiento.listado-beneficiarios-evento",["movimiento"=>$movimiento,"data"=>$data]);
    }
    private function strdate_slash($input){
       $search  = array('/');
       $replace = array('-');
       return str_replace($search, $replace, $input);
    }
}
