<?php


/*/*
grupo las rutas por middleware para luego atravez de el middleware definir los roles y que usuarios pueden
acceder a las vistas que se programan en el grupo de rutas correspondiente a el rol.
*/

use App\comunaRetiro;
use App\CaptacionesExitosa;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;

/* Todos lo grupos de rutas incluyen el middleware auth, esto es para que a ese grupo de rutas se tenga
		acceso solo despues de que sean registrado
	*/
Route::controllers([
    'auth' => 'Auth\AuthController',
    'password' => 'Auth\PasswordController',
]);


Route::get('/', 'WelcomeController@index');
Route::get('home', 'HomeController@index');


/*
	el grupo de rutas del administrador tiene acceso a todas las rutas del sistema
*/

Route::group(['middleware' => ['auth', 'administrador'], 'prefix' => 'admin'], function () {


    Route::Resource('user', 'AdminController');
    Route::Resource('sup', 'supController');
    Route::Resource('call', 'TeoController');
    Route::Resource('rutas', 'RutasController');
    Route::Resource('ope', 'OperacionesController');
    Route::Resource('load', 'CargaController');
    Route::get('cargas', 'CargaController@form_cargar_datos');
    Route::post('cargar_datos', 'CargaController@cargar_datos');
    Route::get('edit&{id}', 'TeoController@editar');
    Route::get('mandatoExitoso&{id}&{id_interno_dues}', 'TeoController@create');
    Route::post('agregado', 'TeoController@store');
    Route::post('actualizado&{id}', 'TeoController@actualizar');
    Route::get('detalle{id}', 'supController@detalleUser');
    route::get('updatePivot{user_id}/{pivot_id}', 'supController@updatePivot');
    route::post('updatepivot2', 'supController@updatepivot2');
    route::post('updatePass/{id}', 'adminController@updatePass');
    route::post('siguiente/{id}', 'teoController@siguiente');
    route::get('adminconfig', 'AdminController@adminConfig');
    route::post('createstatus', 'AdminController@create_status');
    route::post('createcallstatus', 'Admincontroller@create_status_retirement');
    route::post('createpaymentstatus', 'Admincontroller@create_status_payment_method');
    route::get('teoHome', 'Teocontroller@Home');
    route::get('rutas', 'Admincontroller@rutas');
    route::get('admin', 'Admincontroller@admin');
    route::post('comuna', 'Admincontroller@addcomuna');
    route::get('filtrarpor', 'OperacionesController@filtrarpor');
    route::get('showDay1', 'OperacionesController@showDay1');
    route::get('validarSocio', 'OperacionesController@validarSocio');
    route::get('ajax-rutero', function () {
        $rutero_id = Input::get('ruteroid');
        $nombre_rutero = comunaRetiro::where('comuna', '=', $rutero_id)->get();

        return Response::json($nombre_rutero);
    });
    route::get('carbon', function () {

        $hoy = Carbon::now()->format('d/m/Y');
        $last_week = Carbon::now()->subMonth()->format('d/m/Y');
        $start = Carbon::now()->startOfMonth()->format('d/m/Y');

        return ("la fecha de hoy es " . $hoy . " " . "y la semana pasada era " . $last_week . " " . " y el primer dia de este mes fue " . $start);
    });

    /*Route::get('/', function(){

        return view('admin/administradorr');
    });*/
});

/*
	el grupo de rutas del teleoperador tiene acceso paracial a las rutas de el controlador teoController
	y adicionalmente tiene acceso a las rutas de el controlador de agendamiento, al cual solo tendra acceso
	a la funcion show y create
*/
Route::group(['middleware' => ['auth', 'teleoperador'], 'prefix' => 'teo'], function () {

    Route::Resource('call', 'TeoController');
    Route::post('actualizado&{id}', 'TeoController@actualizar');
    Route::get('edit&{id}', 'TeoController@editar');
    Route::get('mandatoExitoso&{id}&{id_interno_dues}', 'TeoController@create');
    Route::post('agregado', 'TeoController@store');
    route::post('siguiente{id}', 'teoController@siguinente');
    Route::get(' ', function () {

        return view('teo/call');
    });

});

/*
	El grupo de rutas para el supervior entregara acceso commpleto a las rutas de teleoperador y adicionalmente
	tendra acceso a un controlador que le permitira asignar los teleoperadores para trabajar en campañas
	(por definir -> tendra acceso a editar los agendamientos en caso de ser necesario, ya que los teleopradores
	no podran hacerlo)	
*/
Route::group(['middleware' => ['auth', 'supervisor'], 'prefix' => 'sup'], function () {

    Route::Resource('sup', 'supController');
    Route::Resource('call', 'TeoController');
    Route::get('detalle{id}', 'supController@detalleUser');
    route::get('updatePivot{id}', 'supController@updatePivot');
    Route::Resource('user', 'AdminController');

    /*Route::get('/', function(){

        return view('sup/supervisor');
    });*/
});
/*
	El grupo de rutas de Operaciones tendra un acceso casi completo al sistema, salvo algunas funciones especificas de el administrador
*/

Route::group(['middleware' => ['auth', 'operaciones'], 'prefix' => 'ope'], function () {

    Route::Resource('/', 'OperacionesController');
    Route::Resource('sup', 'supController');
    Route::Resource('call', 'TeoController');

    /*Route::get('/', function(){

        return view('operac/ope');
    });*/
});

/*Route::group(['middleware' =>['auth', 'operaciones'], 'prefix'=>'ope'], function(){

	Route::Resource('sup','supController');
	Route::Resource('call','TeoController');
	Route::Resource('ope', 'OperacionesController');
	Route::get('/', function(){

		return view('operac/ope');
	});

});*/

/*
	El grupo de rutas para rutero tendra acceso al controlador para el agendamiento de rutas
*/
Route::group(['middleware' => ['auth', 'ruteros'], 'prefix' => 'rutas'], function () {

    Route::Resource('/', 'RutasController');

});


