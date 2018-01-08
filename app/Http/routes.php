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

Route::group(['middleware' => ['auth', 'administrador'], 'prefix' => 'admin'], function () {


    Route::Resource('user', 'AdminController');
    Route::Resource('sup', 'supController');
    Route::Resource('call', 'TeoController');
    Route::Resource('rutas', 'RutasController');
    Route::Resource('ope', 'OperacionesController');
    Route::Resource('load', 'CargaController');
    Route::Get('cargas', 'CargaController@form_cargar_datos');
    Route::Post('cargar_datos', 'CargaController@cargar_datos');
    Route::Get('edit&{id}', 'TeoController@editar');
    Route::Get('mandatoExitoso&{id}&{id_interno_dues}', 'TeoController@create');
    Route::Post('agregado', 'TeoController@store');
    Route::Post('actualizado&{id}', 'TeoController@actualizar');
    Route::Get('detalle{id}', 'supController@detalleUser');
    route::Get('updatePivot{user_id}/{pivot_id}', 'supController@updatePivot');
    Route::Post('updatepivot2', 'supController@updatepivot2');
    route::Post('updatePass/{id}', 'adminController@updatePass');
    route::Post('siguiente/{id}', 'teoController@siguiente');
    route::Get('adminconfig', 'AdminController@adminConfig');
    route::Post('createstatus', 'AdminController@create_status');
    route::Post('createcallstatus', 'AdminController@create_status_retirement');
    route::Post('createpaymentstatus', 'AdminController@create_status_payment_method');
    route::Get('teoHome', 'TeoController@Home');
    Route::Get('createRutas', 'AdminController@rutas');
    route::Get('admin', 'AdminController@admin');
    route::Post('comuna', 'AdminController@addcomuna');
    route::Get('filtrarpor', 'OperacionesController@filtrarpor');
    route::post('showDay1', 'OperacionesController@showDay1');
    route::Get('validarSocio', 'OperacionesController@validarSocio');
    route::Get('verRutas','OperacionesController@verRutas');
    route::Post('filtroRutas','OperacionesController@verRutasFiltradas');
    route::Post('capFilter','TeoController@capFilter');
    Route::Post('addStatusCap','OperacionesController@addStatusCap');
    route::Post('addStatusCapAjax','TeoController@addStatusCapAjax');
    route::Post('homeBack','TeoController@homeBack');
    Route::Post('addStatusMdt','OperacionesController@addStatusMdt');
    Route::Get('editCap/{id}','TeoController@editCap');
    route::Post('editCapPost','TeoController@editCapPost');
    route::Get('dispRutas', 'TeoController@dispRutas');
    Route::Post('addMinMaxCap','OperacionesController@adminMaxMinCap');
    Route::Post('secondRoute','RutasController@addSecondRoute');
    Route::Post('thirdRoute','RutasController@addThirdRoute');
    Route::Get('reAgendamiento','OperacionesController@reAgendamiento');
    Route::Get('detalleReAgendamiento/{id}','OperacionesController@detalleReagendamiento');
    Route::Post('reagendar','OperacionesController@reagendar');
    Route::Get('PorReagendar','TeoController@PorReagendar');
    route::Get('detalleReagendamientoTeo/{id}','TeoController@detalleReagendamiento');
    route::Post('reagendado','TeoController@reagendado');
    Route::Get('byfoundation/{id}', 'CargaController@byFoundation');
    Route::Get('foundations','AdminController@foundations');
    Route::Post('create/foundation','AdminController@createFoundation');
    Route::Get('foundation/show/{id}','AdminController@showFoundation');
    Route::Get('campana/{campana}', 'InformesController@informeCampana');
    Route::Post('create/campana','AdminController@createCampana');
     route::Get('ajax-rutero', function () {

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
Route::group(['middleware' => ['auth', 'teleoperador'], 'prefix' => 'teo'], function () {

    Route::Resource('call', 'TeoController');
    Route::Post('actualizado&{id}', 'TeoController@actualizar');
    Route::Get('edit&{id}', 'TeoController@editar');
    Route::Get('mandatoExitoso&{id}&{id_interno_dues}', 'TeoController@create');
    Route::Post('agregado', 'TeoController@store');
    Route::Post('siguiente/{id}', 'TeoController@siguiente');
    Route::post('capFilter','TeoController@capFilter');
    Route::Get('teoHome','TeoController@Home');
    Route::Get('validarSocio', 'OperacionesController@validarSocio');
    route::Post('homeBack','TeoController@homeBack');
    Route::Get('editCap/{id}','TeoController@editCap');
    Route::Post('editCapPost','TeoController@editCapPost');
    Route::Get('PorReagendar','TeoController@PorReagendar');
    Route::get('detalleReagendamientoTeo/{id}','TeoController@detalleReagendamiento');
    Route::Post('reagendado','TeoController@reagendado');
    Route::Get('dispRutas', 'TeoController@dispRutas');
    Route::Get('reageWithEdition/{id}', 'TeoController@reagendarConEdicion');
    Route::Post('reagece', 'TeoController@editAge');
    Route::Get('fallidos','TeoController@fallidos');
    Route::Get('detalleFallidos/{id}','TeoController@detalleFallidos');
    Route::Post('validatePassCode','TeoController@ValidatePassCode');
    Route::get('llamadas/agendadas','TeoController@llamadasAgendadas');
    Route::Get('agendamiento/llamada/llamar/{id}','TeoController@agendamientoLlamadoLlamar');
    Route::Get('agendamiento/llamada/llamadoExitoso/{id}','TeoController@agendamientoLlamadaLlamadoExitoso');

    route::get('ajax-rutero', function () {
        $rutero_id = Input::get('ruteroid');
        $nombre_rutero = comunaRetiro::where('comuna', '=', $rutero_id)->get();

        return Response::json($nombre_rutero);
    });
    Route::get('/', function () {

        return redirect('/teo/teoHome');
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
    Route::get('updatePivot{user_id}/{pivot_id}', 'supController@updatePivot');
    Route::post('updatepivot2', 'supController@updatepivot2');
    Route::Resource('user', 'AdminController');

    /*Route::get('/', function(){

        return view('sup/supervisor');
    });*/
});
/*
	El grupo de rutas de Operaciones tendra un acceso casi completo al sistema, salvo algunas funciones especificas de el administrador
*/

Route::group(['middleware' => ['auth', 'operaciones'], 'prefix' => 'ope'], function () {

    Route::Resource('ope', 'OperacionesController');
    Route::Resource('sup', 'supController');
    Route::Resource('call', 'TeoController');
    Route::Get('verRutas','OperacionesController@verRutas');
    route::Post('filtroRutas','OperacionesController@verRutasFiltradas');
    Route::Post('addStatusCap','OperacionesController@addStatusCap');
    Route::Post('addStatusMdt','OperacionesController@addStatusMdt');
    route::Get('adminconfig', 'AdminController@adminConfig');
    Route::Post('addMinMaxCap','OperacionesController@adminMaxMinCap');
    Route::Get('reAgendamiento','OperacionesController@reAgendamiento');
    Route::Get('reAgendamiento','OperacionesController@reAgendamiento');
    Route::Get('detalleReAgendamiento/{id}','OperacionesController@detalleReagendamiento');
    Route::Post('reagendar','OperacionesController@reagendar');
    route::post('showDay1', 'OperacionesController@showDay1');
    Route::get('createRutas', 'AdminController@rutas');
    route::post('comuna', 'AdminController@addcomuna');
    Route::get('mdtWhithEdition/{id}','OperacionesController@mdtWithEdition');
    Route::get('rutas','OperacionesController@rutas');
    Route::get('rutas/semana/actual/{rutero}','OperacionesController@rutasSemanaActual');
    Route::get('rutas/semana/pasada/{rutero}','OperacionesController@rutasSemanaPasada');
    Route::get('rutas/semana/siguiente/{rutero}','OperacionesController@rutasSemanaSiguiente');
    Route::get('rutas/dia/{rutero}/{dia}','OperacionesController@detalleRutasPorDia');
    Route::Get('detalleRuta/{id}','RutasController@detalleRuta');
    Route::Post('pc','OperacionesController@passcode');
    Route::Post('resetPassCode','OperacionesController@resetPassCode');
    Route::Get('agendamiento/llamados','OperacionesController@agendamientoLlamado');
    Route::Get('agendamiento/llamada/finalizar/{id}','OperacionesController@AgendamientoLlamadoFinalizar');
    Route::Post('agendamiento/llamado/Finalizar',   'OperacionesController@AgendamientoLlamadosFinalizarRegistro');
    Route::Get('mandatos','OperacionesController@mandatos');
    Route::Get('mandatos/pat','OperacionesController@mandatosPat');
    Route::Post('registrar/mandato/captacion','OperacionesController@registrarMandatoCaptacion');
    Route::Post('registrar/mandato/ruta','OperacionesController@registrarMandatoRuta');
    Route::Post('registrar/mandato/ruta/conReparo','OperacionesController@registrarMandatoRutaConReparo');
    Route::Post('agregar/mandato/1','OperacionesController@agregarMandato1');
    Route::Post('agregar/mandato/2','OperacionesController@agregarMandato2');
    Route::Post('agregar/mandato/3','OperacionesController@agregarMandato3');
    Route::Get('mandatos/conReparo','OperacionesController@mandatosConReparo');
    Route::Post('conReparo/cambiarEstado','OperacionesController@ConReparoAgregarEstado');
    Route::Get('liberar/registros','OperacionesController@liberarRegistros');
    Route::Get('liberar/registros/show/{id}','OperacionesController@liberarRegistrosShow');
    Route::Get('liberar/registro/ajax','OperacionesController@liberarAjax');
    Route::Get('mandatos/exitosos','OperacionesController@mandatosExitosos');
    Route::Post('mandatos/exitosos/filtrado','OperacionesController@mandatosExitososFiltrados');
    Route::Get('cambiarRutero','OperacionesController@cambiarRutero');
    Route::Post('cambiarRutero','OperacionesController@cambiarRuteroPost');
    Route::Get('byFoundation/{id}','OperacionesController@byFoundation');
    Route::Get('byRutero/{id}','OperacionesController@byRutero');
    Route::Get('change/rutero/{id}/{rutero}','OperacionesController@changeRutero');
    Route::Get('create/letter','OperacionesController@createLetter');
    Route::Post('add/letter','OperacionesController@addLetter');
    Route::Get('addRecords/campaing/{id_letter}','OperacionesController@addRecordsCampaing');
    Route::Get('addRecords/letterAjax','OperacionesController@addRecodsLetterAjax');
    Route::Get('show/letter/{id}','OperacionesController@showLetter');
    Route::Post('add/PostMan','OperacionesController@postMan');
    Route::get('/', function(){

        return view('operac/ope');
    });
});

/*
	El grupo de rutas para rutero tendra acceso al controlador para el agendamiento de rutas
*/
Route::group(['middleware' => ['auth', 'ruteros'], 'prefix' => 'rutas'], function () {

    Route::Resource('rutas', 'RutasController');
    Route::post('secondRoute','RutasController@addSecondRoute');
    Route::post('thirdRoute','RutasController@addThirdRoute');
    Route::get('historialRutas','RutasController@historialRutas');
    Route::Post('historialRutasFiltrado','RutasController@historialFiltrado');
    Route::Get('detalleRuta/{id}','RutasController@detalleRuta');
    Route::get('semana','OperacionesController@rutas');
    Route::get('semana/actual/{rutero}','OperacionesController@rutasSemanaActual');
    Route::get('semana/pasada/{rutero}','OperacionesController@rutasSemanaPasada');
    Route::get('semana/siguiente/{rutero}','OperacionesController@rutasSemanaSiguiente');
    Route::get('dia/{rutero}/{dia}','OperacionesController@detalleRutasPorDia');
    Route::Get('detalleRuta/{id}','RutasController@detalleRuta');

});

Route::group(['middleware'=>['auth','informes'],'prefix'=>'informes'],function(){
      Route::Resource('info', 'InformesController');
      Route::get('campana/{campana}', 'InformesController@informeCampana');
      Route::get('fundacion/{fundacion}', 'InformesController@informeFundacion');
      Route::get('user/{user}', 'InformesController@informeUser');
      Route::get('rutero/{rutero}','InformesController@informeRutero');
});
