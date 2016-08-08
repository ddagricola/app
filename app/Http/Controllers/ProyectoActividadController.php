<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\ProyectoActividad;
class ProyectoActividadController extends Controller
{
    public function listadoPartidas(){
    	return view("proyectoActividad.partidas");
    }
    public function partidas(Request $request){
    	if($request->ajax()){
            $partidas = ProyectoActividad::partidasPresupuestarias();
            return response()->json(["data"=>$partidas]);
        }
    }
}
