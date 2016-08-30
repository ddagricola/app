<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jefatura;
use App\Rol;
use App\Http\Requests;
use App\User;
use Carbon\Carbon;
use Auth;
class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('usuario.listado');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $jefaturas = Jefatura::whereEstado(1)->get();
        $roles = Rol::whereEstado(1)->where("id","!=",1)->get();

        return view('usuario.nuevo',["roles"=>$roles, "jefaturas"=>$jefaturas]);
    }
    
    public function todo(){
        return response()->json(["data"=>User::with("usuarioRol")->get()]);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   

        $data = $request->all();
         User::create([
            'email' => $data['email'],
            'id_rol' => $data['id_rol'],
            'id_jefatura' => $data['id_jefatura'],
            'password' => bcrypt($data['password']),
            'fecha_creacion'=>Carbon::now(),
            'email_creacion'=> (Auth::check())? Auth::user()->email : 'admin@admin',
            'ip_creacion'=>$request->ip()
        ]);
        return redirect()->action('UsuarioController@index');
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
    public function createRestaurarContrasena(){
        $usuario = User::find(Auth::user()->id);
        return view('usuario.restaurar',['user'=>$usuario]);        
    }
    public function storeRestaurarContrasena(Request $request){
        $this->validate($request, [
            'password' => 'required|min:6',
        ],['password.required'=>'Campo obligatorio',
        'password.min'=>'Contraseña debe contener al menos 6 caracteres.']);

        $usuario = User::find(Auth::user()->id);
        $usuario->password = bcrypt($request->password);
        $usuario->fecha_modificacion = Carbon::now();
        $usuario->ip_modificacion = $request->ip();
        $usuario->email_modificacion = Auth::user()->email;        
        $usuario->remember_token=null;
        return redirect('/logout');        
    }
}
