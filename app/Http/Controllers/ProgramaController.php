<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Auth;
use App\Http\Requests;
use App\Direccion;
use App\Programa;
class ProgramaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('programa.listado');
    }

    public function indexSubPrograma($idPrograma)
    {
        return view('programa.listado-sub', ['idPrograma'=>$idPrograma]);
    }


    public function todo(Request $request){
        if($request->ajax()){
            $programa = Programa::programaToDireccion();
            return response()->json(["data"=>$programa]);
        }
    }
    public function todoSub(Request $request, $idPrograma){
        if($request->ajax()){
            $programa = Programa::subProgramaToDireccion($idPrograma);
            return response()->json(["data"=>$programa]);
        }
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $direcciones = Direccion::whereEstado(1)->get();
        return view('programa.nuevo',["direcciones"=>$direcciones]);
    }
    public function createSubPrograma($idPrograma)
    {
        $direcciones = Direccion::whereEstado(1)->get();
        $programaPadre = Programa::find($idPrograma);
        return view('programa.nuevo-sub',["direcciones"=>$direcciones,"programaPadre"=>$programaPadre]);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeSubPrograma(Request $request){
        $subprograma = new Programa;
        $nombre = $this->cleanInput( strtoupper(trim($request->nombre)) ); 
        $subprograma->id_direccion = $request->id_direccion;
        $subprograma->id_programa_padre = $request->id_programa;
        $subprograma->codigo_partida = $request->codigo;
        $subprograma->nombre = $nombre;
        $subprograma->descripcion = $request->descripcion;
        $subprograma->estado = 1;
        $subprograma->fecha_creacion = Carbon::now();
        $subprograma->email_creacion = (Auth::check())? Auth::user()->email : 'admin@admin';
        $subprograma->ip_creacion = $request->ip();
        $subprograma->save();
        return redirect()->action('ProgramaController@indexSubPrograma',['idPrograma'=>$request->id_programa]);

    }
    public function store(Request $request)
    {
         $this->validate($request, [
            'nombre' => 'required',
            'id_direccion'=> 'required',
            'codigo'=> 'required'
        ]);
        $data = $request->all();
        $nombre = $this->cleanInput( strtoupper(trim($data['nombre'])) ); 
        $programa = new Programa;
        $programa->id_direccion = $data['id_direccion'];
        $programa->id_programa_padre = null;
        $programa->codigo_partida = strtoupper($data['codigo']);
        $programa->nombre = strtoupper($nombre);
        $programa->descripcion = $data['descripcion'];
        $programa->estado = 1;
        $programa->fecha_creacion = Carbon::now();
        $programa->email_creacion = (Auth::check())? Auth::user()->email : 'admin@admin';
        $programa->ip_creacion = $request->ip();
        $programa->save();

        $subprograma = new Programa;
        $subprograma->id_direccion = $data['id_direccion'];
        $subprograma->id_programa_padre = $programa->id;
        $subprograma->codigo_partida = null;//$data['codigo'];
        $subprograma->nombre = null;
        $subprograma->descripcion = $data['descripcion'];
        $subprograma->estado = 1;
        $subprograma->fecha_creacion = Carbon::now();
        $subprograma->email_creacion = (Auth::check())? Auth::user()->email : 'admin@admin';
        $subprograma->ip_creacion = $request->ip();
        $subprograma->save();

        return redirect()->action('ProgramaController@index');
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
        $direcciones = Direccion::all();
        $programa = Programa::find($id);
        return view('programa.editar',["direcciones"=>$direcciones,'programa'=>$programa]);
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
            'id_direccion'=> 'required',
            'codigo'=> 'required'
        ]);
        $data = $request->all();
        $nombre = $this->cleanInput( strtoupper(trim($data['nombre'])) ); 
        $programa = Programa::find($id);
        $programa->id_direccion = $data['id_direccion'];
        $programa->id_programa_padre = null;
        $programa->codigo_partida = strtoupper($data['codigo']);
        $programa->nombre = strtoupper($nombre);
        $programa->descripcion = $data['descripcion'];
        $programa->estado = 1;
        $programa->fecha_modificacion = Carbon::now();
        $programa->email_modificacion = (Auth::check())? Auth::user()->email : 'admin@admin';
        $programa->ip_modificacion = $request->ip();
        $programa->save();
        return redirect()->action('ProgramaController@index');
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
        $programa = Programa::find($id);
        $programa->estado = 0;
        $programa->fecha_modificacion = Carbon::now();
        $programa->email_modificacion = (Auth::check())? Auth::user()->email : 'admin@admin';
        $programa->ip_modificacion = $request->ip();

        Programa::where('id_programa_padre', $id)->update(['estado' => 0]);
        
        $programa->save();
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

