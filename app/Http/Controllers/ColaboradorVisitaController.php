<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Jefatura;
use App\Colaborador;
use App\ColaboradorVisita;
use Carbon\Carbon;
use Auth;
class ColaboradorVisitaController extends Controller
{
	public function indexVisita($id){//-- id jefatura
		$jefatura = Jefatura::find($id);
		$visitas = ColaboradorVisita::visitaJefatura($id);
		return view("colaboradorVisita.listado",["visitas"=>$visitas, "jefatura"=>$jefatura]);	
	}

    public function nuevo($id){
    	$jefatura = Jefatura::find($id);
    	$colaborador = Colaborador::where('id_jefatura','=',$id)->get();
    	
    	return view("colaboradorVisita.nuevo",["jefatura"=>$jefatura, "colaboradores"=>$colaborador]);	
    }

    public function guardar(Request $request){
    	$this->validate($request, [
    		'tipo_visita' => 'required',
            'id_colaborador' => 'required',
            'nombre_visitante' => 'required',
            'lugar_visitante' => 'required',
            'motivo_visita' => 'required'
        ]);
    	$colaboradorVisita = new ColaboradorVisita;
    	$fecha = $request->fecha;
    	$fechaExplode = explode(' ', $fecha);
    	$fechaFromRequest = $fechaExplode[0];
    	$fechaUS = Carbon::parse($this->strdate_slash($fechaFromRequest))->format('Y-m-d');
    	$fechaToDB = $fechaUS.' '.$fechaExplode[1];
    	

    	$colaboradorVisita->id_tipo_visita = $request->tipo_visita; 
	    $colaboradorVisita->id_colaborador  = $request->id_colaborador;
	   $colaboradorVisita->nombre_visitante = $this->str_utf(strtoupper($request->nombre_visitante));
	    $colaboradorVisita->lugar_visitante = $this->str_utf(strtoupper($request->motivo_visita));
	    $colaboradorVisita->dia_visita = $fechaToDB;
	    $colaboradorVisita->hora_visita = null; //strtoupper($request->motivo_visita);
	    $colaboradorVisita->motivo_visita = $this->str_utf(strtoupper($request->motivo_visita));
		$colaboradorVisita->estado = 1;
		$colaboradorVisita->fecha_creacion = Carbon::now();
	$colaboradorVisita->email_creacion = (isset(Auth::user()->id))? Auth::user()->email : 'guest';
		$colaboradorVisita->ip_creacion = $request->ip();
		$colaboradorVisita->save();

		return redirect()->action('ColaboradorVisitaController@indexVisita', $request->id_jefatura);

    	//var_dump($request->all());
    }

    public function str_utf($string){
    	$vowels = array("á", "é", "í", "ó", "ú");
    	$replace = array('Á', 'É', 'Í', 'Ó', 'Ú'); 

		return  str_replace($vowels, $replace, $string);
    }
    private function strdate_slash($input){
       $search  = array('/');
       $replace = array('-');
       return str_replace($search, $replace, $input);
    }
}
