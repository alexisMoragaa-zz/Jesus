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


Route::Get('/', 'WelcomeController@index');
Route::Get('home', 'HomeController@index');


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
    Route::Get('updatePivot{user_id}/{pivot_id}', 'supController@updatePivot');
    Route::Post('updatepivot2', 'supController@updatepivot2');
    Route::Post('updatePass/{id}', 'AdminController@updatePass');
    Route::Post('siguiente/{id}', 'teoController@siguiente');
    Route::Get('adminconfig', 'AdminController@adminConfig');
    Route::Post('createstatus', 'AdminController@create_status');
    Route::Post('createcallstatus', 'AdminController@create_status_retirement');
    Route::Post('createpaymentstatus', 'AdminController@create_status_payment_method');
    Route::Get('teoHome', 'TeoController@Home');
    Route::Get('createRutas', 'AdminController@rutas');
    Route::Get('admin', 'AdminController@admin');
    Route::Post('comuna', 'AdminController@addcomuna');
    Route::Get('filtrarpor', 'OperacionesController@filtrarpor');
    Route::Post('showDay1', 'OperacionesController@showDay1');
    Route::Get('validarSocio', 'OperacionesController@validarSocio');
    Route::Get('verRutas','OperacionesController@verRutas');
    Route::Post('filtroRutas','OperacionesController@verRutasFiltradas');
    Route::Post('capFilter','TeoController@capFilter');
    Route::Post('addStatusCap','OperacionesController@addStatusCap');
    Route::Post('addStatusCapAjax','TeoController@addStatusCapAjax');
    Route::Post('homeBack','TeoController@homeBack');
    Route::Post('addStatusMdt','OperacionesController@addStatusMdt');
    Route::Get('editCap/{id}','TeoController@editCap');
    Route::Post('editCapPost','TeoController@editCapPost');
    Route::Get('dispRutas', 'TeoController@dispRutas');
    Route::Post('addMinMaxCap','OperacionesController@adminMaxMinCap');
    Route::Post('secondRoute','RutasController@addSecondRoute');
    Route::Post('thirdRoute','RutasController@addThirdRoute');
    Route::Get('reAgendamiento','OperacionesController@reAgendamiento');
    Route::Get('detalleReAgendamiento/{id}','OperacionesController@detalleReagendamiento');
    Route::Post('reagendar','OperacionesController@reagendar');
    Route::Get('PorReagendar','TeoController@PorReagendar');
    Route::Get('detalleReagendamientoTeo/{id}','TeoController@detalleReagendamiento');
    Route::Post('reagendado','TeoController@reagendado');
    Route::Get('byfoundation/{id}', 'CargaController@byFoundation');
    Route::Get('foundations','AdminController@foundations');
    Route::Post('create/foundation','AdminController@createFoundation');
    Route::Get('foundation/show/{id}','AdminController@showFoundation');
    Route::Get('campana/{campana}', 'InformesController@informeCampana');
    Route::Post('create/campana','AdminController@createCampana');
    Route::Get('reporte/{id}','InformesController@campanaReport');
    Route::Get('export/report/campana/{id}','CargaController@exportReportCampana');
    Route::Post('load/cobertura','CargaController@loadCobertura');
    Route::Get('load/cobertura/view','CargaController@loadCoberturaView');
    Route::Post('loadCampaing','CargaController@loadCampaing');


    Route::Get('ajax-rutero', function () {
        $rutero_id = Input::Get('ruteroid');
        $nombre_rutero = comunaRetiro::where('comuna', '=', $rutero_id)->Get();
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
    Route::Resource('regiones','RegionesController');
    Route::Post('actualizado&{id}', 'TeoController@actualizar');
    Route::Get('edit&{id}', 'TeoController@editar');
    Route::Get('mandatoExitoso&{id}&{id_interno_dues}', 'TeoController@create');
    Route::Post('agregado', 'TeoController@store');
    Route::Post('siguiente/{id}', 'TeoController@siguiente');
    Route::Post('capFilter','TeoController@capFilter');
    Route::Get('teoHome','TeoController@Home');
    Route::Get('validarSocio', 'OperacionesController@validarSocio');
    Route::Post('homeBack','TeoController@homeBack');
    Route::Get('editCap/{id}','TeoController@editCap');
    Route::Post('editCapPost','TeoController@editCapPost');
    Route::Get('PorReagendar','TeoController@PorReagendar');
    Route::Get('detalleReagendamientoTeo/{id}','TeoController@detalleReagendamiento');
    Route::Post('reagendado','TeoController@reagendado');
    Route::Get('dispRutas', 'TeoController@dispRutas');
    Route::Get('reageWithEdition/{id}', 'TeoController@reagendarConEdicion');
    Route::Post('reagece', 'TeoController@editAge');
    Route::Get('fallidos','TeoController@fallidos');
    Route::Get('detalleFallidos/{id}','TeoController@detalleFallidos');
    Route::Post('validatePassCode','TeoController@ValidatePassCode');
    Route::Get('llamadas/agendadas','TeoController@llamadasAgendadas');
    Route::Get('agendamiento/llamada/llamar/{id}','TeoController@agendamientoLlamadoLlamar');
    Route::Get('agendamiento/llamada/llamadoExitoso/{id}/{tipe}','TeoController@agendamientoLlamadaLlamadoExitoso');
    Route::Get('show/cobertura','RegionesController@showCobertura');
    Route::Get('complete/comunas','RegionesController@completeComunas');

    Route::Get('agendar/grabacion/{id}','TeoController@agendarGrabacion');
    Route::Get('ajax-rutero', function () {
        $rutero_id = Input::Get('ruteroid');
        $nombre_rutero = comunaRetiro::where('comuna', '=', $rutero_id)->Get();

        return Response::json($nombre_rutero);
    });
    Route::Get('/', function () {

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
    Route::Get('detalle{id}', 'supController@detalleUser');
    Route::Get('updatePivot{user_id}/{pivot_id}', 'supController@updatePivot');
    Route::Post('updatepivot2', 'supController@updatepivot2');
    Route::Resource('user', 'AdminController');


});
/*
	El grupo de rutas de Operaciones tendra un acceso casi completo al sistema, salvo algunas funciones especificas de el administrador
*/

Route::group(['middleware' => ['auth', 'operaciones'], 'prefix' => 'ope'], function () {

    Route::Resource('ope', 'OperacionesController');
    Route::Resource('sup', 'supController');
    Route::Resource('call', 'TeoController');
    Route::Resource('dely', 'RegionesController');
    Route::Get('verRutas','OperacionesController@verRutas');
    Route::Post('filtroRutas','OperacionesController@verRutasFiltradas');
    Route::Post('addStatusCap','OperacionesController@addStatusCap');
    Route::Post('addStatusMdt','OperacionesController@addStatusMdt');
    Route::Get('adminconfig', 'AdminController@adminConfig');
    Route::Post('addMinMaxCap','OperacionesController@adminMaxMinCap');
    Route::Get('reAgendamiento','OperacionesController@reAgendamiento');
    Route::Get('reAgendamiento','OperacionesController@reAgendamiento');
    Route::Get('detalleReAgendamiento/{id}','OperacionesController@detalleReagendamiento');
    Route::Post('reagendar','OperacionesController@reagendar');
    Route::Post('showDay1', 'OperacionesController@showDay1');
    Route::Get('createRutas', 'AdminController@rutas');
    Route::Post('comuna', 'AdminController@addcomuna');
    Route::Get('mdtWhithEdition/{id}','OperacionesController@mdtWithEdition');
    Route::Get('rutas','OperacionesController@rutas');
    Route::Get('rutas/semana/actual/{rutero}','OperacionesController@rutasSemanaActual');
    Route::Get('rutas/semana/pasada/{rutero}','OperacionesController@rutasSemanaPasada');
    Route::Get('rutas/semana/siguiente/{rutero}','OperacionesController@rutasSemanaSiguiente');
    Route::Get('rutas/dia/{rutero}/{dia}','OperacionesController@detalleRutasPorDia');
    Route::Get('detalleRuta/{id}','RutasController@detalleRuta');
    Route::Post('pc','OperacionesController@passcode');
    Route::Post('resetPassCode','OperacionesController@resetPassCode');
    Route::Get('agendamiento/llamados','OperacionesController@agendamientoLlamado');
    Route::Get('agendamiento/llamada/finalizar/{id}','OperacionesController@AgendamientoLlamadoFinalizar');
    Route::Post('agendamiento/llamado/Finalizar',   'OperacionesController@AgendamientoLlamadosFinalizarRegistro');
    Route::Get('mandatos','OperacionesController@mandatos');
    Route::Get('mandatos/pat','OperacionesController@mandatosPat');
    Route::Get('addMdt/status/pat','OperacionesController@addMandatosPat');
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
    Route::Get('addRecords/letterAjax','OperacionesController@addRecodsLetterAjax');
    Route::Get('show/letter/{id}','OperacionesController@showLetter');
    Route::Post('add/PostMan','OperacionesController@PostMan');

    Route::Get('delivery/history/filter/{id}/{date}','RegionesController@filtroDeliveryHistory');
    Route::Get('add/mandate/delivery/{id}','RegionesController@addMdtDely');
    Route::Get('delivery/history','RegionesController@deliveryHistory');
    Route::Get('delivery/daily','RegionesController@deliveryDaily');
    Route::Get('export/delivery/daily','CargaController@exportDeliveryDaily');
    Route::Get('export/delivery/history','CargaController@exportDeliveryHistory');
    Route::Get('edit/cobertura','RegionesController@editCobertura');
    Route::Post('edit/cobertura','RegionesController@editCoberturaPost');


    Route::Get('create/letter','OperacionesController@createLetter');
    Route::Post('add/letter','OperacionesController@addLetter');
    Route::Get('addRecords/campaing/{id_letter}','OperacionesController@addRecordsCampaing');
    Route::Get('export/letter/{id}/excel','CargaController@exportLetter');
    Route::Get('/', function(){

        return view('operac/ope');
    });
});

/*
	El grupo de rutas para rutero tendra acceso al controlador para el agendamiento de rutas
*/
Route::group(['middleware' => ['auth', 'ruteros'], 'prefix' => 'rutas'], function () {

    Route::Resource('rutas', 'RutasController');
    Route::Post('secondRoute','RutasController@addSecondRoute');
    Route::Post('thirdRoute','RutasController@addThirdRoute');
    Route::Get('historialRutas','RutasController@historialRutas');
    Route::Post('historialRutasFiltrado','RutasController@historialFiltrado');
    Route::Get('detalleRuta/{id}','RutasController@detalleRuta');
    Route::Get('semana','OperacionesController@rutas');
    Route::Get('semana/actual/{rutero}','OperacionesController@rutasSemanaActual');
    Route::Get('semana/pasada/{rutero}','OperacionesController@rutasSemanaPasada');
    Route::Get('semana/siguiente/{rutero}','OperacionesController@rutasSemanaSiguiente');
    Route::Get('dia/{rutero}/{dia}','OperacionesController@detalleRutasPorDia');
    Route::Get('detalleRuta/{id}','RutasController@detalleRuta');

});

Route::group(['middleware'=>['auth','informes'],'prefix'=>'informes'],function(){
      Route::Resource('info', 'InformesController');
      Route::Get('campana/{campana}', 'InformesController@informeCampana');
      Route::Get('fundacion/{fundacion}', 'InformesController@informeFundacion');
      Route::Get('rutero/{rutero}','InformesController@informeRutero');
      Route::Get('reporte/{id}','InformesController@campanaReport');
      Route::Get('export/report/campana/{id}','CargaController@exportReportCampana');

      Route::Get('user/{user}', 'InformesController@informeUser');
      Route::Get('user/{user}/campaing/{campaing}','InformesController@informeUserCampaing');

      Route::Get('campana/{id}/recorrido/{recorrido}','InformesController@informeCampanaRecorridos');
});
