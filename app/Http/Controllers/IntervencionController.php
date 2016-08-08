<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Insumo;
use App\Http\Requests;
use App\Consolidado;
use App\TipoIntervencion;
use App\Intervencion;
use Carbon\Carbon;
use Auth;
use App\Departamento;
use App\TipoInsumo;
use App\FuenteFinanciamiento;
class IntervencionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //-- id de consolidado
        //Carbon::setLocale(config('app.locale'));
        $consolidado = Intervencion::whereIdUsuario(Auth::user()->id);//Consolidado::find($id);
        return view('intervencion.listado-intervenciones',['consolidado'=>$consolidado]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $consolidado = Consolidado::find($id);
        $tipoIntervencion = TipoIntervencion::whereEstado(1)->get();
        $tipoInsumos = TipoInsumo::whereEstado(1)->get();
        $departamentos = Departamento::whereEstado(1)->get();
        $fuentes = FuenteFinanciamiento::whereEstado(1)->get();
        $insumos = Insumo::insumoJefatura();
        return view("intervencion.intervencion",[
            "tipoInsumos"=>$tipoInsumos,
            "insumos"=>$insumos,
            "fuentes"=>$fuentes,
            "departamentos"=>$departamentos,"consolidado"=>$consolidado,"tipoIntervencion"=>$tipoIntervencion]);
    }

    public function todo(Request $request){
        if($request->ajax()){
            $intervenciones = Intervencion::intervencionConsolidado();
            return response()->json(["data"=>$intervenciones]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $intervencion = new Intervencion;
        $intervencion->id_consolidado = null; //$request->id_consolidado;
        $intervencion->id_tipo_intervencion = $request->id_tipo_intervencion;
        $intervencion->id_usuario = Auth::user()->id;
        $intervencion->id_departamento = $request->departamento;
        $intervencion->nombre = strtoupper($request->nombre);
        $intervencion->justificacion = $request->justificacion;
        $intervencion->estado = 1;
        $intervencion->id_tipo_intervencion = 1;
        $intervencion->id_insumo = $request->id_insumo;
        $intervencion->id_fuente_financiamiento = $request->id_fuente;
        $intervencion->fecha_creacion = Carbon::now();
        $intervencion->email_creacion = (isset(Auth::user()->email)) ? Auth::user()->email : 'guest' ;
        $intervencion->ip_creacion = $request->ip();
        $intervencion->orden = (int) $request->orden;
        $intervencion->anio = $request->anio;
        $intervencion->save();
        return redirect()->action('IntervencionController@index', 1);
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
        $consolidado = Consolidado::find($id);
        $tipoIntervencion = TipoIntervencion::whereEstado(1)->get();
        $tipoInsumos = TipoInsumo::whereEstado(1)->get();
        $departamentos = Departamento::whereEstado(1)->get();
        $fuentes = FuenteFinanciamiento::whereEstado(1)->get();
        $insumos = Insumo::insumoJefatura();
        $intervencion = Intervencion::find($id);

        return view("intervencion.editar",[
            "tipoInsumos"=>$tipoInsumos,
            "intervencion"=>$intervencion,
            "insumos"=>$insumos,
            "fuentes"=>$fuentes,
            "departamentos"=>$departamentos,"consolidado"=>$consolidado,"tipoIntervencion"=>$tipoIntervencion]);
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
        $intervencion = Intervencion::find($id);
        $intervencion->id_consolidado = null; //$request->id_consolidado;
        $intervencion->id_tipo_intervencion = $request->id_tipo_intervencion;
        $intervencion->id_usuario = Auth::user()->id;
        $intervencion->id_departamento = $request->departamento;
        $intervencion->nombre = strtoupper($request->nombre);
        $intervencion->justificacion = $request->justificacion;
        $intervencion->estado = 1;
        $intervencion->id_tipo_intervencion = 1;
        $intervencion->id_insumo = $request->id_insumo;
        $intervencion->id_fuente_financiamiento = $request->id_fuente;
        $intervencion->fecha_modificacion = Carbon::now();
        $intervencion->email_modificacion = (isset(Auth::user()->email)) ? Auth::user()->email : 'guest' ;
        $intervencion->ip_modificacion = $request->ip();
        $intervencion->orden = (int) $request->orden;
        $intervencion->anio = $request->anio;
        $intervencion->save();
        return redirect()->action('IntervencionController@index', 1);
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
}
