<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Auth;
use App\Http\Requests;
use App\FuenteFinanciamiento;
class FuenteFinanciamientoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('fuenteFinanciamiento.listado');
    }

    public function todo(Request $request){
        if($request->ajax()){
            $fuentes = FuenteFinanciamiento::whereEstado(1)->orderBy("id","DESC")->get();
            return response()->json(["data"=>$fuentes]);
            /*$view = view('pais.todo')->with(['paises'=>$paises]);
            return $view->renderSections()['content'];*/
        }
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('fuenteFinanciamiento.nuevo');
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
            'nombre' => 'required',
            'codigo' => 'required'
        ]);

        $data = $request->all();
        $nombre = $this->cleanInput( strtoupper(trim($data['nombre'])) ); 
        $fuente = new FuenteFinanciamiento;
        $fuente->nombre = $nombre;
        $fuente->codigo_partida = $request->codigo;
        $fuente->estado = 1;
        $fuente->fecha_creacion = Carbon::now();
        $fuente->email_creacion = (Auth::check())? Auth::user()->email : 'admin@admin';
        $fuente->ip_creacion = $request->ip();
        $fuente->save();
        return redirect()->action('FuenteFinanciamientoController@index');
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
        $fuente = FuenteFinanciamiento::find($id);
        return view('fuenteFinanciamiento.editar',['fuente'=>$fuente]);
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
        $this->validate($request, [
            'nombre' => 'required',
            'codigo' => 'required'
        ]);

        $data = $request->all();
        $nombre = $this->cleanInput( strtoupper(trim($data['nombre'])) ); 
        $fuente = FuenteFinanciamiento::find($id);
        $fuente->nombre = $nombre;
        $fuente->codigo_partida = $request->codigo;
        $fuente->estado = 1;
        $fuente->fecha_modificacion = Carbon::now();
        $fuente->email_modificacion = (Auth::check())? Auth::user()->email : 'admin@admin';
        $fuente->ip_modificacion = $request->ip();
        $fuente->save();
        return redirect()->action('FuenteFinanciamientoController@index');   
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
    public function remove(Request $request, $id){
        $pais = FuenteFinanciamiento::find($id);
        $pais->estado = 0;
        $pais->fecha_modificacion = Carbon::now();
        $pais->email_modificacion = (Auth::check())? Auth::user()->email : 'admin@admin';
        $pais->ip_modificacion = $request->ip();
        $pais->save();
    }
    private function cleanInput($input){
       $search  = array('á', 'é', 'í', 'ó', 'ú');
       $replace = array('Á', 'É', 'Í', 'Ó', 'Ú');
       return str_replace($search, $replace, $input);
    }
}

