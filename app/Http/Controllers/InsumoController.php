<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Auth;
use App\Http\Requests;
use App\TipoInsumo;
use App\Insumo;
use App\Jefatura;
class InsumoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('insumo.listado');
    }

    public function todo(Request $request){
        if($request->ajax()){
            $departamentos = Insumo::insumoToTipoInsumo();
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
        $tipoInsumo = TipoInsumo::whereEstado(1)->get();
        $jefaturas = Jefatura::whereEstado(1)->get();
        return view('insumo.nuevo',["tipoInsumo"=>$tipoInsumo, "jefaturas"=>$jefaturas]);
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
            'id_tipo_insumo'=> 'required'
        ]);
        $data = $request->all();
        $nombre = $this->cleanInput( strtoupper(trim($data['nombre'])) ); 
        $departamento = new Insumo;
        $departamento->id_tipo_insumo = $data['id_tipo_insumo'];
        $departamento->id_jefatura = $data["id_jefatura"];
        $departamento->nombre = $nombre;
        $departamento->estado = 1;
        $departamento->fecha_creacion = Carbon::now();
        $departamento->email_creacion = (Auth::check())? Auth::user()->email : 'admin@admin';
        $departamento->ip_creacion = $request->ip();
        $departamento->save();
        return redirect()->action('InsumoController@index');
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
        $pais = Insumo::find($id);
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
    public function insumoTipoInsumo($id){
        $departamentos = Insumo::whereEstado(1)->whereIdTipoInsumo($id)->orderBy("nombre", "asc")->get();
        return response()->json($departamentos);        
    }
    private function cleanInput($input){
       $search  = array('á', 'é', 'í', 'ó', 'ú');
       $replace = array('Á', 'É', 'Í', 'Ó', 'Ú');
       return str_replace($search, $replace, $input);
    }
}

