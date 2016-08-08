<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Colaborador;
use Auth;
use Carbon\Carbon;
class ColaboradorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $colaborador = Colaborador::whereIdUsuario(Auth::user()->id)->count();
        if($colaborador == 0){
            return view('colaborador.perfil',[]);
        }else{
            $colaborador = Colaborador::whereIdUsuario(Auth::user()->id)->get()->first();
            return view('colaborador.edit-perfil',['colaborador'=>$colaborador]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $colaborador = new Colaborador;
        $colaborador->id_usuario = Auth::user()->id;
        $colaborador->id_tipo_colaborador = 1;
        $colaborador->nombre = 1;
        $colaborador->primer_nombre = $this->cleanInput(strtoupper($request->primer_nombre));
        $colaborador->segundo_nombre = strtoupper($request->segundo_nombre) ;
        $colaborador->tercer_nombre = strtoupper($request->tercer_nombre);
        $colaborador->primer_apellido = $this->cleanInput(strtoupper($request->primer_apellido));
        $colaborador->segundo_apellido = strtoupper($request->segundo_apellido);
        $colaborador->apellido_casada = strtoupper($request->apellido_casada);
        $colaborador->estado = 1;
        $colaborador->fecha_creacion = Carbon::now();
        $colaborador->email_creacion = Auth::user()->email;
        $colaborador->ip_creacion = $request->ip();
        $colaborador->contrato = $request->contrato;
        $colaborador->save();

        return redirect()->action('ColaboradorController@edit',$colaborador->id);
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

    public function configCuenta(){
        
    }

    private function cleanInput($input){
       $search  = array('á', 'é', 'í', 'ó', 'ú');
       $replace = array('Á', 'É', 'Í', 'Ó', 'Ú');
       return str_replace($search, $replace, $input);
    }
}
