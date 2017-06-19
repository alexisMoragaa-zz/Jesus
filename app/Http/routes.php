<?php

/*
	grupo las rutas por middleware para luego atravez de el middleware definir los roles y que usuarios pueden
	acceder a las vistas que se programan en el grupo de rutas correspondiente a el rol.
*/

	/*
		Todos lo grupos de rutas incluyen el middleware auth, esto es para que a ese grupo de rutas se tenga
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

Route::group(['middleware' =>['auth', 'administrador'],'prefix'=>'admin'], function(){
	

	Route::Resource('user','AdminController');
	Route::Resource('sup','supController');
	Route::Resource('call' ,'TeoController');
	Route::Resource('rutas','RutasController');
	Route::Resource('ope','OperacionesController');
	Route::Resource('load','CargaController');
	Route::get('cargas', 'CargaController@form_cargar_datos');
	Route::post('cargar_datos', 'CargaController@cargar_datos');
	Route::get('edit&{id}', 'TeoController@editar');
	Route::get('mandatoExitoso&{id}&{id_interno_dues}', 'TeoController@create');
	Route::post('agregado', 'TeoController@store');
	Route::post('actualizado&{id}','TeoController@actualizar');
	Route::get('detalle{id}','supController@detalleUser');
	
	Route::get('/', function(){

		return view('admin/administradorr');
	});
});

/*
	el grupo de rutas del teleoperador tiene acceso paracial a las rutas de el controlador teoController
	y adicionalmente tiene acceso a las rutas de el controlador de agendamiento, al cual solo tendra acceso
	a la funcion show y create
*/
Route::group(['middleware' =>['auth', 'teleoperador'],'prefix'=>'teo'], function(){
	
		Route::Resource('call','TeoController');
		Route::post('actualizado&{id}','TeoController@actualizar');
		Route::get('edit&{id}', 'TeoController@editar');
	    Route::get('mandatoExitoso&{id}&{id_interno_dues}', 'TeoController@create');
		Route::post('agregado', 'TeoController@store');
		Route::get(' ', function(){

			return view('teo/call');
	});

	});

/*
	El grupo de rutas para el supervior entregara acceso commpleto a las rutas de teleoperador y adicionalmente
	tendra acceso a un controlador que le permitira asignar los teleoperadores para trabajar en campañas
	(por definir -> tendra acceso a editar los agendamientos en caso de ser necesario, ya que los teleopradores
	no podran hacerlo)	
*/
Route::group(['middleware' =>['auth', 'supervisor'], 'prefix'=>'sup'], function(){

	Route::Resource('sup','supController');
	Route::Resource('call','TeoController');
	Route::get('detalle{id}','supController@detalleUser');

	/*Route::get('/', function(){

		return view('sup/supervisor');
	});*/
	});
/*
	El grupo de rutas de Operaciones tendra un acceso casi completo al sistema, salvo algunas funciones especificas de el administrador
*/

Route::group(['middleware' =>['auth', 'operaciones'], 'prefix'=>'ope'], function(){

	Route::Resource('/','OperacionesController');
	Route::Resource('sup','supController');
	Route::Resource('call','TeoController');

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
Route::group(['middleware'=>['auth','ruteros'], 'prefix'=>'rutas'], function(){

	Route::Resource('/','RutasController');

});


