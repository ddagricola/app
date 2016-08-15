<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Puesto;
use Auth;
use Carbon\Carbon;

class PuestoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("puesto.listado");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("puesto.nuevo");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //var_dump($request->all());die;
        $puesto = new Puesto;
        $puesto->nombre = $this->str_utf(strtoupper($request->nombre));
        $puesto->estado = 1;
        $puesto->fecha_creacion = Carbon::now();
        $puesto->email_creacion = (isset(Auth::user()->email)) ?Auth::user()->email : 'guest';
        $puesto->ip_creacion = $request->ip();
        $puesto->save();
        return redirect()->action('PuestoController@index');

    }

   public function todo(Request $request){
        if($request->ajax()){
            $puestos = Puesto::whereEstado(1)->orderBy("id","DESC")->get();
            return response()->json(["data"=>$puestos]);
        }
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
        $puesto = Puesto::find($id);
        return view("puesto.editar",["puesto"=>$puesto]);
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
        $puesto = Puesto::find($id);
        $puesto->nombre = $this->str_utf(strtoupper($request->nombre));
        $puesto->fecha_modificacion = Carbon::now();
        $puesto->email_modificacion = (isset(Auth::user()->email)) ?Auth::user()->email : 'guest';
        $puesto->ip_modificacion = $request->ip();
        $puesto->save();
        return redirect()->action('PuestoController@index');
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
    public function delete(Request $request, $id){
        $puesto = Puesto::find($id);
        $puesto->estado = 0;
        $puesto->fecha_modificacion = Carbon::now();
        $puesto->email_modificacion = (isset(Auth::user()->email)) ?Auth::user()->email : 'guest';
        $puesto->ip_modificacion = $request->ip();
        $puesto->save();
        return redirect()->action('PuestoController@index');
    }
    public function str_utf($string){
        $vowels = array("á", "é", "í", "ó", "ú");
        $replace = array('Á', 'É', 'Í', 'Ó', 'Ú'); 

        return  str_replace($vowels, $replace, $string);
    }
}
