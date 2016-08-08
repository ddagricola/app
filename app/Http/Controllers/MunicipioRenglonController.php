<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Auth;
use App\Http\Requests;
use App\Pais;
use App\Departamento;
use App\Renglon;
use App\FuenteFinanciamiento;
use App\MunicipioRenglon;
class MunicipioRenglonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('municipioRenglon.listado');
    }

    public function todo(Request $request){
        if($request->ajax()){
            $departamentos = MunicipioRenglon::municipioRenglon();
            return response()->json(["data"=>$departamentos]);
        }
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $departamentos = Departamento::whereEstado(1)->get();
        $renglones = Renglon::whereEstado(1)->get();
        $fuentes = FuenteFinanciamiento::whereEstado(1)->get();
        return view('municipioRenglon.nuevo',["departamentos"=>$departamentos,'renglones'=>$renglones,'fuentes'=>$fuentes]);
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
            'id_municipio'=> 'required',
            'id_fuente'=> 'required',
            'id_renglon'=> 'required'
        ]);
        
        $data = $request->all();
        $municipioRenglon = new MunicipioRenglon;
        $municipioRenglon->id_municipio = $request->id_municipio;
        $municipioRenglon->id_fuente_financiamiento = $request->id_fuente;
        $municipioRenglon->id_renglon =$request->id_renglon;
        $municipioRenglon->nombre = 1;
        $municipioRenglon->estado = 1;
        $municipioRenglon->fecha_creacion = Carbon::now();
        $municipioRenglon->email_creacion = (Auth::check())? Auth::user()->email : 'admin@admin';
        $municipioRenglon->ip_creacion = $request->ip();
        $municipioRenglon->save();
        return redirect()->action('MunicipioRenglonController@index');
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
        $paises = Pais::whereEstado(1)->get();
        $departamento = Departamento::find($id);
        return view('departamento.editar',["paises"=>$paises,"departamento"=>$departamento]);
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
            'id_pais'=> 'required'
        ]);
        
        $data = $request->all();
        $nombre = $this->cleanInput( strtoupper(trim($data['nombre'])) ); 
        $departamento = Departamento::find($id);
        $departamento->id_pais = $data['id_pais'];
        $departamento->nombre = $nombre;
        $departamento->estado = 1;
        $departamento->codigo = $request->codigo;
        $departamento->fecha_modificacion = Carbon::now();
        $departamento->email_modificacion = (Auth::check())? Auth::user()->email : 'admin@admin';
        $departamento->ip_modificacion = $request->ip();
        $departamento->save();
        return redirect()->action('DepartamentoController@index');
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

