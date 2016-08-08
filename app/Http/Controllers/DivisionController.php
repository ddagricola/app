<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Auth;
use App\Http\Requests;
use App\Pais;
use App\Departamento;
use App\Municipio;
use App\TipoDivision;
use App\Comunidad;
class DivisionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('division.listado');
    }

    public function todo(Request $request){
        if($request->ajax()){
            $municipios = Municipio::municipioToDepartamento();
            return response()->json(["data"=>$municipios]);
        }
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $municipio = Municipio::find($id);
        $divisiones = TipoDivision::whereEstado(1)->get();
        return view('division.nuevo',["municipio"=>$municipio,"divisiones"=>$divisiones]);
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
            'id_departamento'=> 'required',
            'id_tipo_division'=>'required'
        ]);
        $data = $request->all();
        $nombre = $this->cleanInput( strtoupper(trim($data['nombre'])) ); 
        $municipio = new Municipio;
        $municipio->id_departamento = $data['id_departamento'];
        $municipio->nombre = $nombre;
        $municipio->estado = 1;
        $municipio->id_tipo_division = $data['id_tipo_division'];
        $municipio->fecha_creacion = Carbon::now();
        $municipio->email_creacion = (Auth::check())? Auth::user()->email : 'admin@admin';
        $municipio->ip_creacion = $request->ip();
        $municipio->save();
        return redirect()->action('MunicipioController@index');
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
        $municipio = Municipio::find($id);
        $paises = Pais::whereEstado(1)->get();
        $divisiones = TipoDivision::whereEstado(1)->get();
        $departamentos = Departamento::all();
        $departamento = Departamento::find($municipio->id_departamento);
        
        return view('municipio.editar',["paises"=>$paises,"divisiones"=>$divisiones,"municipio"=>$municipio,"departamentos"=>$departamentos,"departamento"=>$departamento]);
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
            'codigo' => 'required',
            'id_departamento'=> 'required',
            'id_tipo_division'=>'required'
        ]);
        $data = $request->all();
        $nombre = $this->cleanInput( strtoupper(trim($data['nombre'])) ); 
        $municipio = Municipio::find($id);
        $municipio->id_departamento = $data['id_departamento'];
        $municipio->nombre = $nombre;
        $municipio->estado = 1;
        $municipio->codigo = $request->codigo;
        $municipio->id_tipo_division = $data['id_tipo_division'];
        $municipio->fecha_modificacion = Carbon::now();
        $municipio->email_modificacion = (Auth::check())? Auth::user()->email : 'admin@admin';
        $municipio->ip_modificacion = $request->ip();
        $municipio->save();
        return redirect()->action('MunicipioController@index');
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
        $municipio = Municipio::find($id);
        $municipio->estado = 0;
        $municipio->fecha_modificacion = Carbon::now();
        $municipio->email_modificacion = (Auth::check())? Auth::user()->email : 'admin@admin';
        $municipio->ip_modificacion = $request->ip();
        $municipio->save();
    }
    private function cleanInput($input){
       $search  = array('á', 'é', 'í', 'ó', 'ú');
       $replace = array('Á', 'É', 'Í', 'Ó', 'Ú');
       return str_replace($search, $replace, $input);
    }
    public function municipioPerDepartamento($id){
        $municipios = Municipio::whereIdDepartamento($id)->whereEstado(1)->whereIdTipoDivision(1)->orderBy("codigo","asc")->get();
        return response()->json($municipios);
    }
}

