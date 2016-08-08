<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Auth;
use App\Http\Requests;
use App\Renglon;
use App\Proyecto;
class RenglonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('renglon.listado');
    }

    public function todo(Request $request){
        if($request->ajax()){
            //$renglones = Renglon::renglonTodo();
            $renglones = Renglon::all();
            return response()->json(["data"=>$renglones]);
        }
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $proyectos = Proyecto::proyectoActividad();
        return view('renglon.nuevo',["proyectos"=>$proyectos]);
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
            //'id_proyecto'=> 'required',
            'codigo'=> 'required'
        ]);
        
        $data = $request->all();
        $nombre = $this->cleanInput( strtoupper(trim($data['nombre'])) ); 
        $renglon = new Renglon;
        (isset($data['id_proyecto'])) ? $renglon->id_proyecto : null ;
        $renglon->nombre = $nombre;
        $renglon->estado = 1;
        $renglon->fecha_creacion = Carbon::now();
        $renglon->email_creacion = (Auth::check())? Auth::user()->email : 'admin@admin';
        $renglon->ip_creacion = $request->ip();
        $renglon->codigo_partida = $data['codigo'];
        $renglon->save();
        return redirect()->action('RenglonController@index');
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
    public function remove(Request $request, $id){
        $pais = Departamento::find($id);
        $pais->estado = 0;
        $pais->fecha_modificacion = Carbon::now();
        $pais->email_modificacion = (Auth::check())? Auth::user()->email : 'admin@admin';
        $pais->ip_modificacion = $request->ip();
        $pais->save();
    }
    public function findPerPais($id){
        $departamentos = Departamento::whereEstado(1)->whereIdPais($id)->orderBy("nombre", "asc")->get();
        return response()->json($departamentos);        
    }
    private function cleanInput($input){
       $search  = array('á', 'é', 'í', 'ó', 'ú');
       $replace = array('Á', 'É', 'Í', 'Ó', 'Ú');
       return str_replace($search, $replace, $input);
    }
}

