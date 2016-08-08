<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Jefatura;
use Auth;
use App\Consolidado;
use App\FuenteFinanciamiento;
use App\Http\Requests;

class ConsolidadoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $jefatura = Jefatura::find($id);
        return view("intervencion.listado",['jefatura'=>$jefatura]);
    }

    public function todo(Request $request, $id){
        if($request->ajax()){
            $consolidados = Consolidado::consolidadoPorJefatura($id);
            return response()->json(["data"=>$consolidados]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $jefatura = Jefatura::find($id);
        $fuentes = FuenteFinanciamiento::all();
        return view("intervencion.nuevo",['jefatura'=>$jefatura,'fuentes'=>$fuentes]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate($request, [
            'id_jefatura' => 'required',
            'nombre' => 'required',
            'id_fuente' => 'required',
            'justificacion' => 'required',
        ]);
        $consolidado = new Consolidado;
        $consolidado->id_usuario = Auth::user()->id;
        $consolidado->id_fuente_financiamiento = $request->id_fuente;
        $consolidado->id_jefatura = $request->id_jefatura;
        $consolidado->estado = 1;
        $consolidado->anio = date('Y');
        $consolidado->nombre = strtoupper($request->nombre);
        $consolidado->justificacion = $request->justificacion;
        $consolidado->fecha_creacion = Carbon::now();
        $consolidado->email_creacion = (isset(Auth::user()->email)) ? Auth::user()->email : 'guest' ;
        $consolidado->ip_creacion = $request->ip();
        $consolidado->save();
        return redirect()->action('ConsolidadoController@index', $request->id_jefatura);
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
