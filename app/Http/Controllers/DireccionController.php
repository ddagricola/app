<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Auth;
use App\Http\Requests;
use App\Direccion;
use App\Ministerio;
class DireccionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('direccion.listado');
    }

    public function todo(Request $request){
        if($request->ajax()){
            $direcciones = Direccion::direccionPerMinisterio();
            return response()->json(["data"=>$direcciones]);
        }
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $ministerios = Ministerio::whereEstado(1)->get();
        return view('direccion.nuevo',["ministerios"=>$ministerios]);
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
            'id_ministerio'=> 'required',
            'siglas'=> 'required',
            'codigo'=> 'required',
        ]);
        

        $data = $request->all();
        $nombre = $this->cleanInput( strtoupper(trim($data['nombre'])) ); 
        $siglas = $this->cleanInput( strtoupper(trim($data['siglas'])) ); 
        $direccion = new Direccion;
        $direccion->id_ministerio = $data['id_ministerio'];
        $direccion->nombre = $nombre;
        $direccion->siglas = $siglas;
        $direccion->codigo_partida = $data['codigo'];
        $direccion->estado = 1;
        $direccion->fecha_creacion = Carbon::now();
        $direccion->email_creacion = (Auth::check())? Auth::user()->email : 'admin@admin';
        $direccion->ip_creacion = $request->ip();
        $direccion->save();
        return redirect()->action('DireccionController@index');
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
        $ministerios = Ministerio::all();
        $direccion = Direccion::find($id);
        return view('direccion.editar',["ministerios"=>$ministerios,'direccion'=>$direccion]);
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
            'id_ministerio'=> 'required',
            'siglas'=> 'required',
            'codigo'=> 'required',
        ]);
        

        $data = $request->all();
        $nombre = $this->cleanInput( strtoupper(trim($data['nombre'])) ); 
        $siglas = $this->cleanInput( strtoupper(trim($data['siglas'])) ); 
        $direccion = Direccion::find($id);
        $direccion->id_ministerio = $data['id_ministerio'];
        $direccion->nombre = $nombre;
        $direccion->siglas = $siglas;
        $direccion->codigo_partida = $data['codigo'];
        $direccion->estado = 1;
        $direccion->fecha_modificacion = Carbon::now();
        $direccion->email_modificacion = (Auth::check())? Auth::user()->email : 'admin@admin';
        $direccion->ip_modificacion = $request->ip();
        $direccion->save();
        return redirect()->action('DireccionController@index');
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
        $direccion = Direccion::find($id);
        $direccion->estado = 0;
        $direccion->fecha_modificacion = Carbon::now();
        $direccion->email_modificacion = (Auth::check())? Auth::user()->email : 'admin@admin';
        $direccion->ip_modificacion = $request->ip();
        $direccion->save();
    }
    public function findPerMinisterio($id){
        $direcciones = Direccion::whereEstado(1)->whereIdMinisterio($id)->orderBy("nombre", "asc")->get();
        return response()->json($direcciones);        
    }
    private function cleanInput($input){
       $search  = array('á', 'é', 'í', 'ó', 'ú');
       $replace = array('Á', 'É', 'Í', 'Ó', 'Ú');
       return str_replace($search, $replace, $input);
    }
}

