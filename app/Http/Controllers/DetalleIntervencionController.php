<?php

namespace App\Http\Controllers;
use Dompdf\Dompdf;
use Excel;
use Illuminate\Http\Request;
use App\FuenteFinanciamiento;
use App\Partida;
use App\Renglon;
use App\Municipio;
use App\Intervencion;
use App\Http\Requests;
use App\DetalleIntervencion;
use App\UnidadMedida;
use Auth;
use Carbon\Carbon;
class DetalleIntervencionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $intervencion = Intervencion::find($id);
        $detalles = DetalleIntervencion::detalleIntervencion($id);
        $fuente = FuenteFinanciamiento::whereEstado(1)->get();
        $renglones = Renglon::whereEstado(1)->get();
        $municipio = Municipio::whereIdDepartamento($intervencion->id_departamento)
            ->whereEstado(1)
            ->whereIdTipoDivision(1)->get();
        $total = Intervencion::totalIntervencion($id);
        $totalBeneficiarios = Intervencion::totalIntervencionBeneficiarios($id);

        $unidades = UnidadMedida::whereEstado(1)->get();
        return view("detalleIntervencion.nuevo",[
            "total"=>$total,
            "totalBeneficiarios"=>$totalBeneficiarios,
            "unidades"=>$unidades,
            "intervencion"=>$intervencion,
            "detalles"=>$detalles,
            'fuentes'=>$fuente,
            "renglones"=>$renglones,
            "municipio"=>$municipio
            ]);
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
    public function detalleTemplate(Request $request, $item){
        $fuente = FuenteFinanciamiento::whereEstado(1)->get();
        $renglones = Renglon::whereEstado(1)->get();
        $municipio = Municipio::whereIdDepartamento($request->id_departamento)
            ->whereEstado(1)
            ->whereIdTipoDivision(1)->get();
        $unidades = UnidadMedida::whereEstado(1)->get();
        $view = view('detalleIntervencion.templates.detalle')->with([
            "unidades"=>$unidades,
            'item'=>$item,'fuentes'=>$fuente,"renglones"=>$renglones, "municipio"=>$municipio]);
        return $view->renderSections()['content'];
    }
    public function detallePartidaCodigo(Request $request){
        $partidas = Partida::whereIdRenglon($request->renglon)
                        ->whereIdFuenteFinanciamiento($request->fuente)
                        ->whereIdMunicipio($request->municipio)->get();
        return response()->json($partidas);
    }
    public function guardarDetalle(Request $request){

        foreach ($request->data as $detalle) {
            $intervecion = Intervencion::find($request->id_intervencion);
            $id_partida = Partida::partidaIntervencion($detalle["id_municipio"], $intervecion->id_fuente_financiamiento, 100);

            if($detalle["state"] == "new"){
                $detalleIntervencion = new DetalleIntervencion;
                $detalleIntervencion->id_intervencion = $request->id_intervencion;
                $detalleIntervencion->cantidad = $detalle["cantidad"];
                $detalleIntervencion->id_partida_presupuestaria = $id_partida->first()->id;
                $detalleIntervencion->id_municipio = $detalle["id_municipio"];
                $detalleIntervencion->id_unidad_medida = $detalle["id_medida"];
                $detalleIntervencion->estado = 1;
                $detalleIntervencion->precio = $detalle["precio"];
                $detalleIntervencion->nbeneficiario = $detalle["beneficiario"];
                $detalleIntervencion->cantidad_beneficiario = $detalle["cantidad_beneficiario"];
                $detalleIntervencion->fecha_creacion = Carbon::now();
                $detalleIntervencion->email_creacion = (isset(Auth::user()->email)) ? Auth::user()->email : 'guest';
                $detalleIntervencion->ip_creacion = $request->ip();
                $detalleIntervencion->id_unidad_entrega = $detalle["medida_entrega"];
                $detalleIntervencion->save();
            }else if($detalle["state"] == "edit"){
                $detalleIntervencion = DetalleIntervencion::find($detalle['id']);
                $detalleIntervencion->id_intervencion = $request->id_intervencion;
                $detalleIntervencion->id_unidad_medida = $detalle["id_medida"];
                $detalleIntervencion->cantidad = $detalle["cantidad"];
                $detalleIntervencion->id_partida_presupuestaria = $id_partida->first()->id;
                $detalleIntervencion->id_municipio = $detalle["id_municipio"];
                $detalleIntervencion->estado = 1;
                $detalleIntervencion->precio = $detalle["precio"];
                $detalleIntervencion->cantidad_beneficiario = $detalle["cantidad_beneficiario"];
                $detalleIntervencion->nbeneficiario = $detalle["beneficiario"];
                $detalleIntervencion->fecha_modificacion = Carbon::now();
                $detalleIntervencion->email_modificacion = (isset(Auth::user()->email)) ? Auth::user()->email : 'guest';
                $detalleIntervencion->id_unidad_entrega = $detalle["medida_entrega"];
                $detalleIntervencion->ip_modificacion = $request->ip();
                $detalleIntervencion->save();


            }else if($detalle["state"] == "delete"){
                $detalleIntervencion = DetalleIntervencion::find($detalle['id']);
                //$detalleIntervencion->id_intervencion = $request->id_intervencion;
                //$detalleIntervencion->id_unidad_medida = $detalle["id_medida"];
                //$detalleIntervencion->cantidad = $detalle["cantidad"];
                //$detalleIntervencion->id_partida_presupuestaria = $detalle["id_partida"];
                //$detalleIntervencion->id_municipio = $detalle["id_municipio"];
                $detalleIntervencion->estado = 0;
                //$detalleIntervencion->precio = $detalle["precio"];
                //$detalleIntervencion->nbeneficiario = $detalle["beneficiario"];
                $detalleIntervencion->fecha_modificacion = Carbon::now();
                $detalleIntervencion->email_modificacion = (isset(Auth::user()->email)) ? Auth::user()->email : 'guest';
                $detalleIntervencion->ip_modificacion = $request->ip();
                $detalleIntervencion->save();
            }
        }
        return response()->json(['status'=>'ok']);
    }

    function exportFromExcel($id){
        $_SESSION['id'] = $id;
        Excel::create('Listado-Detalle-Intervenciones', function($excel) {
            $excel->sheet('Second sheet', function($sheet) {
                $data = DetalleIntervencion::exportToExcel($_SESSION['id']);
                $sheet->loadView('movimiento.export-listado-detalle-intervenciones',["data"=>$data]);
            });

        })->download('xls');
    }
}
