<?php

namespace App\Http\Controllers;
use Auth;
use App\Movimiento;
use Illuminate\Http\Request;
use App\Intervencion;
use App\DetalleIntervencion;
use App\Http\Requests;
use App\Departamento;
use App\Municipio;
use App\Comunidad;
use App\Beneficiario;
use App\BeneficiarioOrigen;
use Carbon\Carbon;
use App\Pueblo;
use App\Etnia;
use App\MovimientoBeneficiario;
class DistribucionController extends Controller
{
    public function listadoDepartamentos()
    {
        return view('distribucion.listado');
    }
    public function edadBeneficiario(Request $request){
        return response()->json(['fecha'=> Carbon::createFromFormat('d/m/Y', $request->nacimiento)->age]);
    }
    public function listadoMunicipios($id)
    {
        $departamento = Departamento::find($id);
        return view('distribucion.listado-municipios',["departamento"=>$departamento]);
    }
    public function intervencionMunicipal($id){
        $municipio = Municipio::find($id);
        return view('distribucion.listado-intervencion-municipal', ['municipio'=>$municipio]);
    }
    public function intervencionIngreso($id){ ///-- id de movimiento
        $movimiento = Movimiento::find($id);
        $comunidad = Comunidad::find($movimiento->id_comunidad);

        //$detalles = DetalleIntervencion::detalleIntervencionIngreso($movimiento->id_detalle_intervencion);
        // PRECAUCIÓN:: ESTA FUNCIÓN NO CONTIENE LOS VALORES REALES.
        $detalles = Movimiento::detalleIngresoBeneficiario($id);//DetalleIntervencion::detalleIntervencionIngreso(1);

        $departamento = Departamento::whereEstado(1)->orderBy('nombre','ASC')->get();
        $etnia = Etnia::whereEstado(1)->orderBy('nombre','ASC')->get();
        $pueblo = Pueblo::whereEstado(1)->orderBy('nombre','ASC')->get();

        return view('distribucion.ingreso-beneficiario-municipal', ['detalle'=>$detalles[0], 'departamentos'=>$departamento,
            "etnia"=>$etnia,
            "pueblo"=>$pueblo,
            "movimiento"=>$movimiento,
            "comunidad"=>$comunidad,
            ]);
    }
    public function todoIntervencionMunicipal(Request $request, $id){
        if($request->ajax()){
            $detalles = DetalleIntervencion::detalleIntervencionMunicipal($id); // id del municipio
            return response()->json(["data"=>$detalles]);
        }
    }
    public function todoDepartamentos(Request $request){
        if($request->ajax()){
            $departamentos = Intervencion::todoDepartamentos();
            return response()->json(["data"=>$departamentos]);
    	}
    }
    public function todoMunicipios(Request $request, $id){
        if($request->ajax()){
            $municipios = Intervencion::todoMunicipios($id);
            return response()->json(["data"=>$municipios]);
        }
    }
    public function oldBeneficiario(Request $request){
        $beneficiarioOrigen = BeneficiarioOrigen::beneficiario($request->cui);//whereCui($request->cui)->

        if (!empty($beneficiarioOrigen)){
            return response()->json($beneficiarioOrigen);
        }else{
            $beneficiario = Beneficiario::beneficiarios($request->cui);
            if (!empty($beneficiario)){
                return response()->json($beneficiario);
            }else{
                return response()->json([]);
            }
        }

        /*if(empty($beneficarioOrigen)){
            $beneficiario = Beneficiario::whereCui($request->cui)->get();


            if(empty($beneficiario)){
                return response()->json([]);
            }else{
                return response()->json($beneficiario);
            }
        }else{
            return response()->json($beneficiarioOrigen);
        }*/

    }
    public function ingresoBeneficiario(Request $request){
        $id_beneficiario = null;
        if($request->event=="update"){

            $this->validate($request, [
                'cui' => 'required',
                'event' => 'required',
            ]);

            $primerNombre = $this->str_replace_utf(strtoupper($request->primer_nombre));
            $segundoNombre = (trim($request->segundo_nombre) != '') ? $this->str_replace_utf(strtoupper($request->segundo_nombre)) : null;
            $tercerNombre = (trim($request->tercer_nombre) != '') ? $this->str_replace_utf(strtoupper($request->tercer_nombre)) : null ;
            $primerApellido = $this->str_replace_utf(strtoupper($request->primer_apellido));
            $segundoApellido = (trim($request->segundo_apellido) != '') ? $this->str_replace_utf(strtoupper($request->segundo_apellido)) : null ;
            $apellidoCasada = (trim($request->apellido_casada) != '') ? $this->str_replace_utf(strtoupper($request->apellido_casada)) : null ;

            $beneficiario = BeneficiarioOrigen::find($request->id);
            $beneficiario->id_municipio = $request->municipio_nacimiento;
            $beneficiario->primer_nombre = $primerNombre;
            $beneficiario->segundo_nombre = $segundoNombre;
            $beneficiario->tercer_nombre = $tercerNombre;
            $beneficiario->primer_apellido = $primerApellido;
            $beneficiario->segundo_apellido = $segundoApellido;
            $beneficiario->apellido_casada = $apellidoCasada;
            $beneficiario->fecha_nacimiento = Carbon::parse($this->strdate_slash($request->fecha_nacimiento))->format('Y-m-d');
            $beneficiario->nacionalidad = $request->nacionalidad;
            $beneficiario->estado_civil = $request->estado_civil;
            $beneficiario->fecha_modificacion = Carbon::now();
            $beneficiario->email_modificacion = (Auth::check()) ? Auth::user()->email :'guest' ;
            $beneficiario->genero= $request->genero;
            $beneficiario->estado=1;
            $beneficiario->id_etnia = $request->etnia;
            $beneficiario->id_pueblo = $request->pueblo;
            $beneficiario->ip_modificacion = $request->ip();
            $beneficiario->leer = $request->leer;
            $beneficiario->escribir = $request->escribir;
            $beneficiario->save();
            $id_beneficiario = $beneficiario->id;

        }else if ($request->event=="insert" || $request->event=="new"){

            $this->validate($request, [
                'cui' => 'required|unique:beneficiario',
                'event' => 'required',
            ]);


            $primerNombre = $this->str_replace_utf(strtoupper($request->primer_nombre));
            $segundoNombre = (trim($request->segundo_nombre) != '') ? $this->str_replace_utf(strtoupper($request->segundo_nombre)) : null;
            $tercerNombre = (trim($request->tercer_nombre) != '') ? $this->str_replace_utf(strtoupper($request->tercer_nombre)) : null ;
            $primerApellido = $this->str_replace_utf(strtoupper($request->primer_apellido));
            $segundoApellido = (trim($request->segundo_apellido) != '') ? $this->str_replace_utf(strtoupper($request->segundo_apellido)) : null ;
            $apellidoCasada = (trim($request->apellido_casada) != '') ? $this->str_replace_utf(strtoupper($request->apellido_casada)) : null ;


            $beneficiario = new BeneficiarioOrigen;
            $beneficiario->id_municipio = $request->municipio_nacimiento;
            $beneficiario->cui = $request->cui;
            $beneficiario->primer_nombre = $primerNombre;
            $beneficiario->segundo_nombre = $segundoNombre;
            $beneficiario->tercer_nombre = $tercerNombre;
            $beneficiario->primer_apellido = $primerApellido;
            $beneficiario->segundo_apellido = $segundoApellido;
            $beneficiario->apellido_casada = $apellidoCasada;
            //$beneficiario->edad = $request->estado_civil;
            $beneficiario->fecha_nacimiento = Carbon::parse($this->strdate_slash($request->fecha_nacimiento))->format('Y-m-d');
            $beneficiario->nacionalidad = $request->nacionalidad;
            $beneficiario->estado_civil = $request->estado_civil;
            $beneficiario->fecha_creacion = Carbon::now();
            $beneficiario->email_creacion = (Auth::check()) ? Auth::user()->email :'guest' ;
            $beneficiario->genero= $request->genero;
            $beneficiario->estado=1;
            $beneficiario->id_etnia = $request->etnia;
            $beneficiario->id_pueblo = $request->pueblo;
            $beneficiario->ip_creacion = $request->ip();
            $beneficiario->leer = $request->leer;
            $beneficiario->escribir = $request->escribir;
            $beneficiario->save();
            $id_beneficiario = $beneficiario->id;
        }

        //*** ingreso del beneficiario a la entrega **//
        $movimientoExistente = MovimientoBeneficiario::whereIdBeneficiario($id_beneficiario)->whereEstado(1)->get();
        if(count($movimientoExistente)==0){

            $movimiento = Movimiento::find($request->id_evento);
            $beneficiariosAutorizados = $movimiento->nbeneficiario;
            $beneficiariosMovimiento = MovimientoBeneficiario::ingresadosMovimientoBeneficiario($request->id_evento);

            if($beneficiariosMovimiento->ingresados < $beneficiariosAutorizados){
                $movimiento = new MovimientoBeneficiario;
                $movimiento->id_movimiento = $request->id_evento;
                $movimiento->id_beneficiario = $id_beneficiario;
                $movimiento->estado = 1;
                $movimiento->fecha_creacion = Carbon::now();
                $movimiento->email_creacion = (Auth::check()) ? Auth::user()->email : 'Guest';
                $movimiento->ip_creacion = $request->ip();
                $movimiento->save();
                return response()->json(["status"=>200, "text"=>"Usuario ingresado correctamente"]);
            }else{
                return response()->json(["status"=>500, "text"=>"Ha excedido el limite de beneficiarios autorizados."]);
            }
        }else{
            return response()->json(["status"=>500, "text"=>"Usuario ya se encuentra ingresado."]);
        }
    }

    private function strdate_slash($input){
       $search  = array('/');
       $replace = array('-');
       return str_replace($search, $replace, $input);
    }

    private function str_replace_utf($input){
        $search  = array('á','é','í','ó','ú');
        $replace = array('Á','É','Í','Ó','Ú');
       return str_replace($search, $replace, $input);
    }

    
}
