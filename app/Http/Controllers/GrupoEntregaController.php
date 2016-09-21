<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\GrupoIntervencion;
use App\DetalleGrupo;
use App\DetalleIntervencion;
use Carbon\Carbon;
use Auth;
use DB;
class GrupoEntregaController extends Controller
{
    public function index(){
      return view("grupoIntervencion.listado");
    }
    public function descripcionGrupo($id){
      $listado = GrupoIntervencion::listadoGrupos($id);
      return view("grupoIntervencion.descripcion",["data"=>$listado]);
    }
    public function todoGrupoIntervencion(Request $request){
        if($request->ajax()){
            $detalles = GrupoIntervencion::grupoIntervencion(); // id del municipio
            return response()->json(["data"=>$detalles]);
        }
    }
    public function createGrupoIntervencion(Request $request){
      DB::beginTransaction();
      try {

        $nombreGrupo = trim(strtoupper($request->nombreGrupo));
        $grupoEntrega = new GrupoIntervencion;
        $grupoEntrega->nombre = $nombreGrupo;
        $grupoEntrega->estado = 1;
        $grupoEntrega->fecha_creacion = Carbon::now();
        $grupoEntrega->email_creacion = ( Auth::user() !=null) ? Auth::user()->email : 'guest' ;
        $grupoEntrega->ip_creacion = $request->ip();
        if($grupoEntrega->save()){
          $detalles = json_decode($request->detalle);
          foreach ($detalles as $value) {
              $detalleGrupo = new DetalleGrupo;
              $detalleGrupo->id_grupo_intervencion = $grupoEntrega->id;
              $detalleGrupo->id_detalle_intervencion = $value->id;
              $detalleGrupo->estado = 1;
              $detalleGrupo->fecha_creacion = Carbon::now();
              $detalleGrupo->email_creacion = ( Auth::user() !=null) ? Auth::user()->email : 'guest' ;
              $detalleGrupo->ip_creacion = $request->ip();
              if($detalleGrupo->save()){
                $detalle = DetalleIntervencion::find($value->id);
                $detalle->fecha_modificacion = Carbon::now();
                $detalle->email_modificacion = ( Auth::user() !=null) ? Auth::user()->email : 'guest' ;
                $detalle->ip_modificacion = $request->ip();
                $detalle->agrupado = 1;
                $detalle->save();
              }

          }
          DB::commit();
          return redirect()->back();
        }else{
          DB::rollBack();
        }


      } catch (\Exception $e) {

        DB::rollBack();

      }

    }
}
