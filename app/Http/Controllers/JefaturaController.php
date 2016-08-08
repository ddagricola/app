<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Auth;
use App\Http\Requests;
use App\Ministerio;
use App\Direccion;
use App\Jefatura;

class JefaturaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('jefatura.listado');
    }

    public function todo(Request $request){
        if($request->ajax()){
            $jefaturas = Jefatura::jefaturaToDireccion();
            return response()->json(["data"=>$jefaturas]);
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
        return view('jefatura.nuevo',["ministerios"=>$ministerios]);
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
            'id_direccion'=> 'required'
        ]);
        $data = $request->all();
        $nombre = $this->cleanInput( strtoupper(trim($data['nombre'])) ); 
        $municipio = new Jefatura;
        $municipio->id_direccion = $data['id_direccion'];
        $municipio->nombre = $nombre;
        $municipio->estado = 1;
        $municipio->fecha_creacion = Carbon::now();
        $municipio->email_creacion = (Auth::check())? Auth::user()->email : 'admin@admin';
        $municipio->ip_creacion = $request->ip();
        $municipio->save();
        return redirect()->action('JefaturaController@index');
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
        $jefatura = Jefatura::find($id);
        $jefatura->estado = 0;
        $jefatura->fecha_modificacion = Carbon::now();
        $jefatura->email_modificacion = (Auth::check())? Auth::user()->email : 'admin@admin';
        $jefatura->ip_modificacion = $request->ip();
        $jefatura->save();
    }
    private function cleanInput($input){
       $search  = array('á', 'é', 'í', 'ó', 'ú');
       $replace = array('Á', 'É', 'Í', 'Ó', 'Ú');
       return str_replace($search, $replace, $input);
    }
}

