<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Auth;
use App\Http\Requests;
use App\Ministerio;
class MinisterioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('ministerio.listado');
    }

    public function todo(Request $request){
        if($request->ajax()){
            $paises = Ministerio::whereEstado(1)->orderBy("id","DESC")->get();
            return response()->json(["data"=>$paises]);
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
        return view('ministerio.nuevo');
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
            'siglas' => 'required',
        ]);

        $data = $request->all();
        $nombre = $this->cleanInput( strtoupper(trim($data['nombre'])) ); 
        $siglas = $this->cleanInput( strtoupper(trim($data['siglas'])) ); 
        $ministerio = new Ministerio;
        $ministerio->nombre = $nombre;
        $ministerio->siglas = $siglas;
        $ministerio->codigo_partida = $data["codigo"];
        $ministerio->estado = 1;
        $ministerio->fecha_creacion = Carbon::now();
        $ministerio->email_creacion = (Auth::check())? Auth::user()->email : 'admin@admin';
        $ministerio->ip_creacion = $request->ip();
        $ministerio->save();
        return redirect()->action('MinisterioController@index');
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
        $ministerio = Ministerio::find($id);
        return view('ministerio.editar',["ministerio"=>$ministerio]);
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
            'siglas' => 'required',
        ]);

        $data = $request->all();
        $nombre = $this->cleanInput( strtoupper(trim($data['nombre'])) ); 
        $siglas = $this->cleanInput( strtoupper(trim($data['siglas'])) ); 
        
        $ministerio = Ministerio::find($id);
        $ministerio->nombre = $nombre;
        $ministerio->siglas = $siglas;
        $ministerio->codigo_partida = $data["codigo"];
        $ministerio->estado = 1;
        $ministerio->fecha_modificacion = Carbon::now();
        $ministerio->email_modificacion = (Auth::check())? Auth::user()->email : 'admin@admin';
        $ministerio->ip_modificacion = $request->ip();
        $ministerio->save();
        return redirect()->action('MinisterioController@index');
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
        $ministerio = Ministerio::find($id);
        $ministerio->estado = 0;
        $ministerio->fecha_modificacion = Carbon::now();
        $ministerio->email_modificacion = (Auth::check())? Auth::user()->email : 'admin@admin';
        $ministerio->ip_modificacion = $request->ip();
        $ministerio->save();
    }
    private function cleanInput($input){
       $search  = array('á', 'é', 'í', 'ó', 'ú');
       $replace = array('Á', 'É', 'Í', 'Ó', 'Ú');
       return str_replace($search, $replace, $input);
    }
}

