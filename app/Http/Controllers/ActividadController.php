<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Auth;
use App\Http\Requests;
use App\Programa;
use App\Actividad;
use App\Proyecto;
class ActividadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('actividad.listado');
    }

    public function todo(Request $request){
        if($request->ajax()){
            $actividades = Actividad::actividadPerPrograma();
            return response()->json(["data"=>$actividades]);
        }
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $programas = Programa::subProgramaDisponible();
        return view('actividad.nuevo',["programas"=>$programas]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /*$this->validate($request, [
            'nombre' => 'required',
            'id_pais'=> 'required'
        ]);
        */
        $data = $request->all();
        $nombre = $this->cleanInput( strtoupper(trim($data['nombre'])) ); 
        $actividad = new Actividad;
        $actividad->id_programa = $data['id_programa'];
        $actividad->nombre = $nombre;
        $actividad->codigo_partida = $data['codigo'];
        $actividad->estado = 1;
        $actividad->fecha_creacion = Carbon::now();
        $actividad->email_creacion = (Auth::check())? Auth::user()->email : 'admin@admin';
        $actividad->ip_creacion = $request->ip();
        $actividad->save();
            $proyecto = new Proyecto;
            $proyecto->id_actividad = $actividad->id;
            $proyecto->nombre = "-- SIN PROYECTO --";
            $proyecto->codigo_partida = null;
            $proyecto->descripcion = null;
            $proyecto->estado = 1;
            $proyecto->fecha_creacion = Carbon::now();
            $proyecto->email_creacion = (Auth::check())? Auth::user()->email : 'admin@admin';
            $proyecto->ip_creacion = $request->ip();
            $proyecto->save();

        return redirect()->action('ActividadController@index');
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
        $programas = Programa::subProgramaDisponible();
        $actividad = Actividad::find($id);
        return view('actividad.editar',["programas"=>$programas,'actividad'=>$actividad]);

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

        $data = $request->all();
        $nombre = $this->cleanInput( strtoupper(trim($data['nombre'])) ); 
        $actividad = Actividad::find($id);
        $actividad->id_programa = $data['id_programa'];
        $actividad->nombre = $nombre;
        $actividad->codigo_partida = $data['codigo'];
        $actividad->estado = 1;
        $actividad->fecha_modificacion = Carbon::now();
        $actividad->email_modificacion = (Auth::check())? Auth::user()->email : 'admin@admin';
        $actividad->ip_modificacion = $request->ip();
        $actividad->save();

        return redirect()->action('ActividadController@index');
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

