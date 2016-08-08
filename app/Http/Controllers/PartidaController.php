<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Partida;
use App\FuenteFinanciamiento;
use App\Municipio;
use App\Renglon;
use Auth;
use App\Departamento;
use Carbon\Carbon;
class PartidaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("partida.listado");
    }


    public function todo(Request $request){
        if($request->ajax()){
            $partidas = Partida::partidas();
            return response()->json(["data"=>$partidas]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $renglones = Renglon::whereEstado(1)->get();
        $fuentes = FuenteFinanciamiento::whereEstado(1)->get();
        $municipios = Municipio::whereEstado(1)->get();
        $departamentos = Departamento::whereEstado(1)->orderBy('codigo','asc')->get();
        return view("partida.nuevo",["departamentos"=>$departamentos,"renglones"=>$renglones, "fuentes"=>$fuentes, "municipios"=>$municipios]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $partida = new Partida;
        $partida->id_renglon = $request->renglon;
        $partida->id_fuente_financiamiento = $request->fuente;
        $partida->id_municipio = $request->municipio;
        $partida->codigo = $request->codigo;
        $partida->estado = 1;
        $partida->fecha_creacion = Carbon::now();
        $partida->email_creacion = (isset(Auth::user()->email)) ? Auth::user()->email : 'guest' ;
        $partida->ip_creacion = $request->ip();
        $partida->save();
        return redirect()->action('PartidaController@index');    
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
}
