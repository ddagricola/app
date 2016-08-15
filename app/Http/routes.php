<?php
ini_set('xdebug.max_nesting_level', 200);

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::auth();

Route::get('/home', 'HomeController@index');

Route::get('beneficiario/cui', 'DistribucionController@oldBeneficiario');
Route::get('beneficiario/edad', 'DistribucionController@edadBeneficiario');
Route::get('paises/todo','PaisController@todo');
Route::get('paises/remove/{id}','PaisController@remove');
Route::get('departamentos/todo','DepartamentoController@todo');
Route::get('departamentos/remove/{id}','DepartamentoController@remove');
Route::get('departamentos/findPerPais/{id}','DepartamentoController@findPerPais');
Route::get('municipios/todo','MunicipioController@todo');
Route::get('municipios/remove/{id}','MunicipioController@remove');
Route::get('municipios/buscar/departamento/{id}','MunicipioController@municipioPerDepartamento');
Route::get('ministerios/todo','MinisterioController@todo');
Route::get('ministerios/remove/{id}','MinisterioController@remove');
Route::get('direcciones/todo','DireccionController@todo');
Route::get('direcciones/remove/{id}','DireccionController@remove');
Route::get('direcciones/findPerMinisterio/{id}','DireccionController@findPerMinisterio');
Route::get('jefaturas/todo','JefaturaController@todo');
Route::get('jefaturas/remove/{id}','JefaturaController@remove');
Route::get('tipo-insumo/todo','TipoInsumoController@todo');
Route::get('tipo-insumo/remove/{id}','TipoInsumoController@remove');
Route::get('tipo-division/todo','TipoDivisionController@todo');
Route::get('tipo-division/remove/{id}','TipoDivisionController@remove');
Route::get('insumos/todo','InsumoController@todo');
Route::get('insumos/remove/{id}','InsumoController@remove');
Route::get('programas/todo','ProgramaController@todo');
Route::get('programas/remove/{id}','ProgramaController@remove');
Route::get('programas/todo-sub/{id}','ProgramaController@todoSub');
Route::get('programas/remove-sub/{id}','ProgramaController@remove');
//Route::get('departamentos/findPerPais/{id}','DepartamentoController@findPerPais');
Route::get('actividades/todo','ActividadController@todo');
Route::get('actividades/remove/{id}','ActividadController@remove');
Route::get('proyectos/todo','ProyectoController@todo');
Route::get('proyectos/remove/{id}','ProyectoController@remove');
Route::get('renglones/todo','RenglonController@todo');
Route::get('renglones/remove/{id}','RenglonController@remove');
Route::get('fuentes-financiamiento/todo','FuenteFinanciamientoController@todo');
Route::get('fuentes-financiamiento/remove/{id}','FuenteFinanciamientoController@remove');
Route::get('municipio-renglon/todo','MunicipioRenglonController@todo');

Route::get('proyecto-actividad/partidas/todo','ProyectoActividadController@partidas');
Route::get('intervenciones/granos-basicos/listado/{id}','ConsolidadoController@index');
Route::get('intervenciones/general/todo/{id}','ConsolidadoController@todo');
Route::get('intervenciones/listado/todo','IntervencionController@todo');
Route::get('partidas/todo','PartidaController@todo');
Route::get('detalle-intervencion/detalle/{item}','DetalleIntervencionController@detalleTemplate');
Route::get('detalle-intervencion/partida','DetalleIntervencionController@detallePartidaCodigo');
Route::get('insumos/buscar/tipo/{id}','InsumoController@insumoTipoInsumo');
Route::get("detalle-intervencion/export/{id}","DetalleIntervencionController@exportFromExcel");
Route::get('puestos/todo','PuestoController@todo');
/** clean **/
Route::get('ben/todo','BeneficiarioController@todo');
Route::get('pdf/{id}','BeneficiarioController@pdf');
/** clean **/
Route::group(['prefix'=>'intervenciones','middleware'=>'auth'], function(){
	Route::get('listado', 'IntervencionController@index');
	Route::get('nuevo/{id}', 'IntervencionController@create');
	Route::get('editar/{id}', 'IntervencionController@edit');
	Route::post('guardar', 'IntervencionController@store');
	Route::post('actualizar/{id}', 'IntervencionController@update');

	Route::get('detalle-intervencion/{id}', 'DetalleIntervencionController@create');
	Route::post('detalle-intervencion/guardar', 'DetalleIntervencionController@guardarDetalle');
	/*Route::get('granos-basicos/nuevo/{id}', 'ConsolidadoController@create');
	Route::post('consolidado-general', 'ConsolidadoController@store');
	*/
});

Route::group(['prefix'=>'mantenimiento','middleware'=>'auth'], function(){
	Route::get('proyecto-actividad/partidas','ProyectoActividadController@listadoPartidas');
	Route::resource('paises','PaisController');
	Route::resource('departamentos','DepartamentoController');
	Route::resource('municipios','MunicipioController');
	Route::resource('puestos','PuestoController');

	Route::resource('ministerios','MinisterioController');
	Route::resource('direcciones','DireccionController');
	Route::resource('programas','ProgramaController');
	Route::resource('divisiones','DivisionController');
	//Route::resource('divisiones/create/{id}','DivisionController@create');
	Route::get('programas/subprogramas/{id}','ProgramaController@indexSubPrograma');
	Route::get('programas/subprogramas/create/{id}','ProgramaController@createSubPrograma');
	Route::post('programas/subprogramas/save','ProgramaController@storeSubPrograma');
	Route::resource('jefaturas','JefaturaController');
	Route::resource('tipo-insumo','TipoInsumoController');
	Route::resource('tipo-division','TipoDivisionController');
	Route::resource('insumos','InsumoController');
	Route::resource('actividades','ActividadController');
	Route::resource('proyectos','ProyectoController');
	Route::resource('renglones','RenglonController');
	Route::resource('fuentes-financiamiento','FuenteFinanciamientoController');
	Route::resource('municipio-renglon','MunicipioRenglonController');
	Route::resource('partidas','PartidaController');
	//Route::get('consolidados/nuevo/{id}', 'ConsolidadoController@create');
	//Route::resource('consolidados','ConsolidadoController');
});
Route::resource('beneficiarios','BeneficiarioController');
Route::get('usuario/todo','UsuarioController@todo');
Route::get('puestos/remove/{id}','PuestoController@delete');

Route::group(['prefix'=>'configuration','middleware'=>'auth'], function(){
	Route::resource('usuario','UsuarioController');
	
	//Route::get('usuario/cuenta','ColaboradorController@configCuenta');
	//Route::post('usuario/store','ColaboradorController@store');
	//Route::get('listado-general', 'UsuarioController@create');
	//Route::get('todo-general', 'UsuarioController@todo');
});

Route::group(['prefix'=>'distribuciones','middleware'=>'auth'], function(){
	Route::get('departamentos','DistribucionController@listadoDepartamentos');
	Route::get('municipios/{idDepartamento}','DistribucionController@listadoMunicipios');
	Route::get('departamentos/todo','DistribucionController@todoDepartamentos');
	Route::get('municipios/todo/{id}','DistribucionController@todoMunicipios');
	Route::get('municipios/intervenciones/{id}','DistribucionController@intervencionMunicipal');
	Route::get('municipios/intervenciones/todo/{id}','DistribucionController@todoIntervencionMunicipal');
	Route::get('municipios/intervenciones/ingreso/{id}','DistribucionController@intervencionIngreso');

	Route::post('beneficiario/ingreso', 'DistribucionController@ingresoBeneficiario');
});

Route::group(['prefix'=>'movimiento','middleware'=>'auth'], function(){
	Route::get('municipal/{id}/{detalle}', 'MovimientoController@movimientoMunicipal');
	Route::post('comunidad/evento-nuevo','MovimientoController@nuevoEventoComunidad');
	Route::get('comunidad/todo-eventos/{id}','MovimientoController@todoEventoComunidad');
	Route::get("beneficiarios/evento/{id}", "MovimientoController@eventoBeneficiarios");

});

Route::group(['prefix'=>'recepcion','middleware'=>'auth'], function(){
	Route::get('jefatura/nuevo/{id}', 'ColaboradorVisitaController@nuevo');
	Route::post('jefatura/guardar', 'ColaboradorVisitaController@guardar');
	Route::get('jefatura/listado/{id}', 'ColaboradorVisitaController@indexVisita');

	Route::get("colaboradores/nuevo", "ColaboradorController@nuevo");
	Route::get("colaboradores/editar/{id}", "ColaboradorController@editar");
	Route::get("colaboradores/listado", "ColaboradorController@listado");
	Route::get("colaboradores/todo", "ColaboradorController@todo");

	Route::post("colaboradores/guardar", "ColaboradorController@guardar");
	Route::post("colaboradores/update/{id}", "ColaboradorController@update");
	Route::get("colaboradores/exportar", "ColaboradorController@export");
});
Route::get("recepcion/colaboradores/remove/{id}", "ColaboradorController@delete");

Route::get("planilla", function(){
	$data = \App\MovimientoBeneficiario::beneficiariosIngresoEvento(1);
	$movimiento = \App\Movimiento::find(1);
	
	//--- LOGICA PARA HOJAS DE PDF --//
	$pages = [];
	$i=0;
	$pagesItem = [];
	$registerCount = 0;
	$pagesCount = 0;
	
	foreach ($data as $value) {
		if($registerCount == 10){
			array_push($pages, $pagesItem);
			$pagesItem = [];
			$registerCount =0;
		}	
		array_push($pagesItem, $value);
		$registerCount++;
	}

	array_push($pages,$pagesItem);
	
	//return view('movimiento.planilla-beneficiarios-evento',['pages'=>$pages]);die;
	$pdf = \PDF::loadView('movimiento.planilla-beneficiarios-evento',
		[
			
		'movimiento'=>$movimiento,
		'pages'=>$pages,
		])->setPaper("A4","landscape");
      return $pdf->download("Planilla-".'.pdf');

});

Route::get("boleta", function(){

/*
	echo DNS1D::getBarcodeSVG("4445645656", "PHARMA2T");
echo DNS1D::getBarcodeHTML("4445645656", "PHARMA2T");
echo '<img src="data:image/png,' . DNS1D::getBarcodePNG("4", "C39+") . '" alt="barcode"   />';
echo DNS1D::getBarcodePNGPath("4445645656", "PHARMA2T");
echo '<img src="data:image/png;base64,' . DNS1D::getBarcodePNG("4", "C39+") . '" alt="barcode"   />';

echo DNS1D::getBarcodeSVG("4445645656", "C39");
echo DNS2D::getBarcodeHTML("4445645656", "QRCODE");
echo DNS2D::getBarcodePNGPath("4445645656", "PDF417");
echo DNS2D::getBarcodeSVG("4445645656", "DATAMATRIX");
echo '<img src="data:image/png;base64,' . DNS2D::getBarcodePNG("4", "PDF417") . '" alt="barcode"   />';
echo DNS1D::getBarcodeSVG("4445645656", "PHARMA2T",3,33);
echo DNS1D::getBarcodeHTML("4445645656", "PHARMA2T",3,33);
echo '<img src="' . DNS1D::getBarcodePNG("4", "C39+",3,33) . '" alt="barcode"   />';
echo DNS1D::getBarcodePNGPath("4445645656", "PHARMA2T",3,33);
*///echo '<img src="data:image/png;base64,' . DNS1D::getBarcodePNG("999999999999", "C39+",1,50) . '" alt="barcode"   />';
//die;	
	$data = \App\MovimientoBeneficiario::beneficiariosIngresoEvento(1);
	$movimiento = \App\Movimiento::find(1);
	
	//--- LOGICA PARA HOJAS DE PDF --//
	$pages = [];
	$i=0;
	$pagesItem = [];
	$registerCount = 0;
	$pagesCount = 0;


	foreach ($data as $value) {
		$value->{'barcode'} = DNS1D::getBarcodePNG("999999999999", "C39+",1,30);
		//$value['codebar'] = [];
		if($registerCount == 3){
			array_push($pages, $pagesItem);
			$pagesItem = [];
			$registerCount =0;
		}	
		array_push($pagesItem, $value);
		$registerCount++;
	}
	
	array_push($pages,$pagesItem);
	
	//return view('movimiento.boleta-beneficiarios-evento',['pages'=>$pages]);die;
	$pdf = \PDF::loadView('movimiento.boleta-beneficiarios-evento',
		[
			
		'movimiento'=>$movimiento,
		'pages'=>$pages,
		])->setPaper("A4"); //,"landscape"
      return $pdf->download("Boleta-".'.pdf');

});

/*Route::group(['prefix'=>'usuario','middleware'=>'auth'], function(){
	Route::get('listado-general', 'UsuarioController@create');
	Route::get('todo-general', 'UsuarioController@todo');
});*/