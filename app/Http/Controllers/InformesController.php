<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\captaciones;
use App\fundacion;
use App\Campana;
use App\user;
use App\informeRuta;
use Illuminate\Http\Request;
use Carbon\Carbon;

class InformesController extends Controller {


	public function index()
	{
		$fundaciones =fundacion::all();
		$campanas =Campana::all();
		$teos = user::where('perfil','=',2)->get();
		$ruteros = user::where('perfil','=',5)->get();
	return view('informes.Dashboard',[
		'fundaciones'=>$fundaciones,
		'campanas'=>$campanas,
		'teos'=>$teos,
		'ruteros'=>$ruteros,
	]);
	}


public function informeCampana($campana){
	$campana = campana::where('id','=',$campana)->get()->first();

$total =$campana->registrosCampana->count();
	// $total= captaciones::where('')->count();
	$llamados = captaciones::where('estado','!=',0)->where('campana_id','=',$campana->id)->count();
	$pendientes = captaciones::where('estado','=',0)->where('campana_id','=',$campana->id)->count();
	$cumas = captaciones::where('estado','=','cu+')->where('campana_id','=',$campana->id)->count();
	$cumenos = captaciones::where('estado','=','cu-')->where('campana_id','=',$campana->id)->count();
	$cnu = captaciones::where('estado','=','cnu')->where('campana_id','=',$campana->id)->count();
	$call_again = captaciones::where('estado','=','ca')->where('campana_id','=',$campana->id)->count();

	$contactados = $cumas+$cumenos+$call_again;

if($contactados != 0){
	$penetracion =  number_format($cumas/$llamados*100,2,'.','');
	$penetracionTotal = number_format($cumas/$total*100,2,'.','');
	$contactabilidad = number_format((float)$contactados/$llamados*100, 2, '.', '');

	return view('informes.informeCampana',[
		'total'=>$total,
		'llamados'=>$llamados,
		'pendientes'=>$pendientes,
		'cumas'=>$cumas,
		'cumenos'=>$cumenos,
		'cnu'=>$cnu,
		'base'=>$campana,
		'penetracion'=>$penetracion,
		'contactabilidad'=>$contactabilidad,
		'penetracionTotal'=>$penetracionTotal,
		'call_again'=>$call_again,
	]);
}else{
	return view('informes.informeCampana',[
		'total'=>$total,
		'llamados'=>$llamados,
		'pendientes'=>$pendientes,
		'base'=>$campana,
		'cumas'=>$cumas,
		'cumenos'=>$cumenos,
		'cnu'=>$cnu,
		'call_again'=>$call_again
	]);

}

}



public function informeFundacion($fundacion){

	return view('informes.informeFundacion');
	// return "hola";
}

public function informeUser($user){

	return view('informes.informeUser');
}

public function informeRutero($rutero_id){
$hoy = Carbon::now()->format('Y-m-d');
$rutero = user::find($rutero_id);
$rutas_realizadas = informeRuta::where('rutero_id','=',$rutero_id)
	->where('estado','!=','Visita Pendiente')->where('estado','!=',"")->count();
$rutas_pendientes = informeRuta::where('rutero_id','=',$rutero_id)->where('fecha_agendamiento','>',$hoy)->count();

$rutas_exitosas = informeRuta::where('rutero_id','=',$rutero_id)->where('estado','=','OK')->count();
$rutas_con_reparo = informeRuta::where('rutero_id','=',$rutero_id)->where('estado','=','ConReparo')->count();
$rutas_no_retiradas = informeRuta::where('rutero_id','=',$rutero_id)->where('estado','=','noRetirado')->count();
$rutas_fallidas = informeRuta::where('rutero_id','=',$rutero_id)->where('estado','=','AgendamientoFallido')->count();

$retracta = informeRuta::where('rutero_id','=',$rutero_id)->where('estado','=','noRetirado')->where('motivo','=','retracta')->count();
$no_contesta = informeRuta::where('rutero_id','=',$rutero_id)->where('estado','=','noRetirado')->where('motivo','=','noContesta')->count();
$no_esta_domicilio = informeRuta::where('rutero_id','=',$rutero_id)->where('estado','=','noRetirado')->where('motivo','=','NoEstaEnDomicilio')->count();
$no_encuentro_direccion = informeRuta::where('rutero_id','=',$rutero_id)->where('estado','=','noRetirado')->where('motivo','=','noEncuentroDirecion')->count();



	return view('informes.informeRutero',[
		'rutero'=>$rutero,
		'rutasRealizadas'=>$rutas_realizadas,
		'rutasPendientes'=>$rutas_pendientes,
		'rutasExitosas'=>$rutas_exitosas,
		'rutasConReparo'=>$rutas_con_reparo,
		'rutasRechazadas'=>$rutas_fallidas,
		'rutasNoRetiradas'=>$rutas_no_retiradas,
		'rutasRetracta'=>$retracta,
		'noContesta'=>$no_contesta,
		'noEstaDomicilio'=>$no_esta_domicilio,
		'noEncuentroDireccion'=>$no_encuentro_direccion,
	]);
}


}
