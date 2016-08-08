<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Auth;
use App\Http\Requests;
use App\Actividad;
use App\Direccion;
use App\Programa;
use App\Proyecto;
class ProyectoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('proyecto.listado');
    }

    public function indexSubPrograma($idPrograma)
    {
        return view('programa.listado-sub', ['idPrograma'=>$idPrograma]);
    }


    public function todo(Request $request){
        if($request->ajax()){
            $programa = Proyecto::proyectoPerActividad();
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
        $actividades = Actividad::actividadPerPrograma();
        return view('proyecto.nuevo',["actividades"=>$actividades]);
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
            //'id_actividad'=> 'required',
            'codigo'=> 'required'
        ]);
        $data = $request->all();
        
        $nombre = $this->cleanInput( strtoupper(trim($data['nombre'])) ); 
        $programa = new Proyecto;
        $programa->id_actividad = (isset($request->id_actividad)  && !empty($request->id_actividad)) ? $request->id_actividad: null ;
        $programa->codigo_partida = strtoupper($data['codigo']);
        $programa->nombre = strtoupper($nombre);
        $programa->descripcion = $data['descripcion'];
        $programa->estado = 1;
        $programa->fecha_creacion = Carbon::now();
        $programa->email_creacion = (Auth::check())? Auth::user()->email : 'admin@admin';
        $programa->ip_creacion = $request->ip();
        $programa->save();

        return redirect()->action('ProyectoController@index');
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

