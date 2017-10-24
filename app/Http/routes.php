<?php

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

Route::group(['Middleware' => ['auth', 'administrador'], 'prefix' => 'admin'], function () {


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
    route::post('createcallstatus', 'AdminController@create_status_retirement');
    route::post('createpaymentstatus', 'AdminController@create_status_payment_method');
    route::get('teoHome', 'TeoController@Home');
    Route::get('createRutas', 'AdminController@rutas');
    route::get('admin', 'AdminController@admin');
    route::post('comuna', 'AdminController@addcomuna');
    route::get('filtrarpor', 'OperacionesController@filtrarpor');
    route::post('showDay1', 'OperacionesController@showDay1');
    route::get('validarSocio', 'OperacionesController@validarSocio');
    route::get('verRutas','OperacionesController@verRutas');
    route::post('filtroRutas','OperacionesController@verRutasFiltradas');
    route::post('capFilter','TeoController@capFilter');
    Route::post('addStatusCap','OperacionesController@addStatusCap');
    route::post('addStatusCapAjax','TeoController@addStatusCapAjax');
    route::post('homeBack','TeoController@homeBack');
    Route::post('addStatusMdt','OperacionesController@addStatusMdt');
    Route::get('editCap{id}','TeoController@editCap');
    route::post('editCapPost','TeoController@editCapPost');
    route::get('dispRutas', 'TeoController@dispRutas');
    Route::post('addMinMaxCap','OperacionesController@adminMaxMinCap');
    Route::post('secondRoute','RutasController@addSecondRoute');
    Route::post('thirdRoute','RutasController@addThirdRoute');
    Route::get('reAgendamiento','OperacionesController@reAgendamiento');
    Route::get('detalleReAgendamiento/{id}','OperacionesController@detalleReagendamiento');
    Route::Post('reagendar','OperacionesController@reagendar');
    Route::get('PorReagendar','TeoController@PorReagendar');
    route::get('detalleReagendamientoTeo/{id}','TeoController@detalleReagendamiento');
    route::post('reagendado','TeoController@reagendado');
    
 
     route::get('ajax-rutero', function () {

        $rutero_id = Input::get('ruteroid');
        $nombre_rutero = comunaRetiro::where('comuna', '=', $rutero_id)->get();

        return Response::json($nombre_rutero);
    });

});

/*
	el grupo de rutas del teleoperador tiene acceso paracial a las rutas de el controlador teoController
	y adicionalmente tiene acceso a las rutas de el controlador de agendamiento, al cual solo tendra acceso
	a la funcion show y create
*/
Route::group(['Middleware' => ['auth', 'teleoperador'], 'prefix' => 'teo'], function () {

    Route::Resource('call', 'TeoController');
    Route::post('actualizado&{id}', 'TeoController@actualizar');
    Route::get('edit&{id}', 'TeoController@editar');
    Route::get('mandatoExitoso&{id}&{id_interno_dues}', 'TeoController@create');
    Route::post('agregado', 'TeoController@store');
    route::post('siguiente/{id}', 'teoController@siguiente');
    route::post('capFilter','TeoController@capFilter');
    route::get('teoHome','TeoController@Home');
    route::get('validarSocio', 'OperacionesController@validarSocio');
    route::post('homeBack','TeoController@homeBack');
    Route::get('editCap/{id}','TeoController@editCap');
    route::post('editCapPost','TeoController@editCapPost');
    Route::get('PorReagendar','TeoController@PorReagendar');
    route::get('detalleReagendamientoTeo/{id}','TeoController@detalleReagendamiento');
    route::post('reagendado','TeoController@reagendado');
    route::get('dispRutas', 'TeoController@dispRutas');

    route::get('ajax-rutero', function () {
        $rutero_id = Input::get('ruteroid');
        $nombre_rutero = comunaRetiro::where('comuna', '=', $rutero_id)->get();

        return Response::json($nombre_rutero);
    });
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
Route::group(['Middleware' => ['auth', 'supervisor'], 'prefix' => 'sup'], function () {

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

Route::group(['Middleware' => ['auth', 'operaciones'], 'prefix' => 'ope'], function () {

    Route::Resource('ope', 'OperacionesController');
    Route::Resource('sup', 'supController');
    Route::Resource('call', 'TeoController');
    Route::get('verRutas','OperacionesController@verRutas');
    route::post('filtroRutas','OperacionesController@verRutasFiltradas');
    Route::post('addStatusCap','OperacionesController@addStatusCap');
    Route::post('addStatusMdt','OperacionesController@addStatusMdt');
    route::get('adminconfig', 'AdminController@adminConfig');
    Route::post('addMinMaxCap','OperacionesController@adminMaxMinCap');
    Route::get('reAgendamiento','OperacionesController@reAgendamiento');
    Route::get('reAgendamiento','OperacionesController@reAgendamiento');
    Route::get('detalleReAgendamiento/{id}','OperacionesController@detalleReagendamiento');
    Route::Post('reagendar','OperacionesController@reagendar');
    route::post('showDay1', 'OperacionesController@showDay1');

  
    

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
Route::group(['Middleware' => ['auth', 'ruteros'], 'prefix' => 'rutas'], function () {

    Route::Resource('rutas', 'RutasController');
    Route::post('secondRoute','RutasController@addSecondRoute');
    Route::post('thirdRoute','RutasController@addThirdRoute');
    



});


