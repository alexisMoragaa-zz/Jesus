<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\CaptacionesExitosa;
use App\informeRuta;
use App\captaciones;
use Carbon\Carbon;
use App\fundacion;
use App\Campana;
use App\user;

class InformesController extends Controller {


	public function index()
	{
		$fundaciones =fundacion::all();
		$campanas =Campana::all();
		$teos = user::where('perfil','=',2)->get();
		$ruteros = user::where('perfil','=',5)->get();
	return view('Informes.Dashboard',[
		'fundaciones'=>$fundaciones,
		'campanas'=>$campanas,
		'teos'=>$teos,
		'ruteros'=>$ruteros,
	]);
	}


public function informeCampana($campana){
	//infome completo sobre la campaña que recivimos como parametro desde la url
		$campana = Campana::find($campana);//seleccionamos la campana que enviamos
		$total =$campana->registrosCampana->count();//tomamos el total de registros asiciados a la campaña

			$llamados = captaciones::where('estado','!=',0)->where('campana_id','=',$campana->id)->count();
			$pendientes = captaciones::where('estado','=',0)->where('campana_id','=',$campana->id)->count();
			$cumas = captaciones::where('estado','=','cu+')->where('campana_id','=',$campana->id)->count();
			$cumenos = captaciones::where('estado','=','cu-')->where('campana_id','=',$campana->id)->count();
			$cnu = captaciones::where('estado','=','cnu')->where('campana_id','=',$campana->id)->count();
			$call_again = captaciones::where('estado','=','ca')->where('campana_id','=',$campana->id)->count();

			$contactados = $cumas+$cumenos+$call_again;//seleccionamos os contactados
			$recorrido ="Recorrido Genaral de la Base";//enviamos un breadcrum que nos indica donde nos encontramos

			$lab = captaciones::select('f_ultimo_llamado')//seleccionamos las fechas de ultimo llamado sin repetirse para graficas el resultado general
			->where('campana_id',$campana->id)->distinct()->get()->sortByDesc('f_ultimo_llamado');

		$contador =0;//inicializamos un contador en 0
				foreach ($lab as $l ) {//recorremos las fechas de llamados obtenidos desde la query
					/*Usamos el foreach para recorrer la coleccion y por cada iteracion tomamos la fecha de ultimo llamado y seleccionamos la data usando esa fecha en cada iteracion*/
					$dcumas =captaciones::where('estado','cu+')//seleccionamos los cu+
					->where('f_ultimo_llamado',$l->f_ultimo_llamado)->where('campana_id',$campana->id)->count();
					$dCumasGeneral[$contador]=$dcumas;//guardamos el resultado en la posicion asignada por el contador que se incremente en 1 por cada iteracion

					$dcumenos =captaciones::where('estado','cu-')//seleccionamos los cu-
					->where('f_ultimo_llamado',$l->f_ultimo_llamado)->where('campana_id',$campana->id)->count();
						$dCumenosGeneral[$contador]=$dcumenos;//guardamos el resultado en la posicion asignada por el contador que se incremente en 1 por cada iteracion

					$dcnu = captaciones::where('estado','cnu')//seleccionamos los cnu
					->where('f_ultimo_llamado',$l->f_ultimo_llamado)->where('campana_id',$campana->id)->count();
					$dCnuGeneral[$contador]=$dcnu;//guardamos el resultado en la posicion asignada por el contador que se incremente en 1 por cada iteracion

					$dca = captaciones::where('estado','ca')//seleccionamos los ca
					->where('f_ultimo_llamado',$l->f_ultimo_llamado)->where('campana_id',$campana->id)->count();
					$dCallAgainGeneral[$contador]=$dca;//guardamos el resultado en la posicion asignada por el contador que se incremente en 1 por cada iteracion

						$labels[$contador]=$l->f_ultimo_llamado;//guardamos en un array los labels para poder graficarlso de forma dinamica
						$contador = $contador+1;//aumentamos el contador en 1 por cada iteracion del ciclo
				}


		$breadcrum2="Resumen General base por dias llamados <small>Informacion Obtenida en base a la fecha de ultimo llamado</small>";
		if($contactados != 0){
			$penetracion =  number_format($cumas/$llamados*100,2,'.','');
			$penetracionTotal = number_format($cumas/$total*100,2,'.','');
			$contactabilidad = number_format((float)$contactados/$llamados*100, 2, '.', '');
		}else{
			$penetracion = "Sin Informacion";
			$penetracionTotal = "Sin Informacion";
			$contactabilidad = "Sin Informacion";
		}

		$montoCumas = \DB::table('captaciones_exitosas')->where('nom_campana',$campana->nombre_campana)->sum('monto');

			return view('Informes.informeCampana',[
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
				'recorrido'=>$recorrido,
				'labels'=>$labels,
				'dCumasGeneral'=>$dCumasGeneral,
				'dCumenosGeneral'=>$dCumenosGeneral,
				'dCnuGeneral'=>$dCnuGeneral,
				'dCallAgainGeneral'=>$dCallAgainGeneral,
				'breadcrum2'=>$breadcrum2,
				'montoCumas'=>$montoCumas,
			]);


}


public function informeCampanaRecorridos($id,$vuelta){

	$campana = Campana::find($id);

		if($vuelta==1){
			$recorrer ="primer_llamado";
			$estado_llamado="estado_llamada1";
			$recorrido ="Recorrido Primera Vuelta  de la Base";
			$total = $campana->registrosCampana->count();
			$estado = "estado1";
			$breadcrum2="Resumen Primer Recorrido base por dias llamados <small>Informacion Obtenida en base a la fecha del Primer llamado</small>";

		}elseif($vuelta == 2){

				$recorrer ="segundo_llamado";
				$estado_llamado="estado_llamada2";
				$recorrido ="Recorrido Segunda Vuelta  de la Base";
				$estado = "estado2";
				$breadcrum2="Resumen Segundo Recorrido base por dias llamados <small>Informacion Obtenida en base a la fecha del Segundo llamado</small>";
				$cumas = captaciones::where('campana_id',$campana->id)->where('estado1','cu+')->count();

			$cumenos = captaciones::where('campana_id',$campana->id)->where('estado1','cu-')->count();
			$total=$campana->registrosCampana->count()-$cumas-$cumenos;

		}elseif($vuelta == 3){

			$recorrer ="tercer_llamado";
			$estado_llamado="estado_llamada3";
			$recorrido ="Recorrido Tercera Vuelta  de la Base";
			$recorrer ="tercer_llamado";
			$estado ="estado3";
			$breadcrum2="Resumen Tercer Recorrido base por dias llamados <small>Informacion Obtenida en base a la fecha del Tercer llamado</small>";
			$cumasvuelta1 = captaciones::where('campana_id',$campana->id)->where('estado1','cu+')->count();
			$cumasvuelta2 = captaciones::where('campana_id',$campana->id)->where('estado2','cu+')->count();
			$cumenosvuelta1 = captaciones::where('campana_id',$campana->id)->where('estado1','cu-')->count();
			$cumenosvuelta2 = captaciones::where('campana_id',$campana->id)->where('estado2','cu-')->count();
			$total=$campana->registrosCampana->count()-$cumasvuelta1-$cumenosvuelta1-$cumasvuelta2-$cumenosvuelta2;

		}

		$llamados = captaciones::where('campana_id','=',$id)->where($recorrer,'!=',0)->count();
		$pendientes =$total-$llamados;

			$cumas = captaciones::where('campana_id',$id)->where($estado,'cu+')->count();
			$cumenos = captaciones::where('campana_id',$id)->where($estado,'cu-')->count();
			$cnu = captaciones::where('campana_id',$id)->where($estado,'cnu')->count();
			$call_again = captaciones::where($estado_llamado,'=','Agendar Llamado')->where('campana_id','=',$campana->id)->count();
			$contactados = $cumas+$cumenos+$call_again;

		$lab = captaciones::select($recorrer)//seleccionamos las fechas de ultimo llamado sin repetirse para graficas el resultado general
		->where('campana_id',$campana->id)->distinct()->whereNotNull($recorrer)->get()->sortByDesc($recorrer);

		$contador = 0;//inicializamos un contador en 0
				foreach ($lab as $l ) {//recorremos las fechas de llamados obtenidos desde la query
					/*Usamos el foreach para recorrer la coleccion y por cada iteracion tomamos la fecha de ultimo llamado y seleccionamos la data usando esa fecha en cada iteracion*/
					$dcumas =captaciones::where($estado,'cu+')//seleccionamos los cu+
					->where($recorrer,$l->$recorrer)->where('campana_id',$campana->id)->count();
					$dCumasGeneral[$contador]=$dcumas;//guardamos el resultado en la posicion asignada por el contador que se incremente en 1 por cada iteracion

					$dcumenos =captaciones::where($estado,'cu-')//seleccionamos los cu-
					->where($recorrer,$l->$recorrer)->where('campana_id',$campana->id)->count();
						$dCumenosGeneral[$contador]=$dcumenos;//guardamos el resultado en la posicion asignada por el contador que se incremente en 1 por cada iteracion

					$dcnu = captaciones::where($estado,'cnu')//seleccionamos los cnu
					->where($recorrer,$l->$recorrer)->where('campana_id',$campana->id)->count();
					$dCnuGeneral[$contador]=$dcnu;//guardamos el resultado en la posicion asignada por el contador que se incremente en 1 por cada iteracion

					$dca = captaciones::where($estado,'ca')//seleccionamos los ca
					->where($recorrer,$l->$recorrer)->where('campana_id',$campana->id)->count();
					$dCallAgainGeneral[$contador]=$dca;//guardamos el resultado en la posicion asignada por el contador que se incremente en 1 por cada iteracion

						$labels[$contador]=$l->$recorrer;//guardamos en un array los labels para poder graficarlso de forma dinamica
						$contador = $contador+1;//aumentamos el contador en 1 por cada iteracion del ciclo
				}


	if($contactados != 0){
		$penetracion =  number_format($cumas/$llamados*100,2,'.','');
		$penetracionTotal = number_format($cumas/$total*100,2,'.','');
		$contactabilidad = number_format((float)$contactados/$llamados*100, 2, '.', '');
	}else{
		$penetracion =  "Sin Informacion";
		$penetracionTotal = "Sin Informacion";
		$contactabilidad = "Sin Informacion";
	}
		return view('Informes.informeCampana',[
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
			'recorrido'=>$recorrido,
			'labels'=>$labels,
			'dCumasGeneral'=>$dCumasGeneral,
			'dCumenosGeneral'=>$dCumenosGeneral,
			'dCnuGeneral'=>$dCnuGeneral,
			'dCallAgainGeneral'=>$dCallAgainGeneral,
			'breadcrum2'=>$breadcrum2,
		]);

}



public function informeFundacion($fundacion){
		$fundacion = fundacion::find($fundacion);
		$campanas = Campana::where('fundacion','=',$fundacion->id)->get();
		return view('Informes.informeFundacion',[
			'fundacion'=>$fundacion,
			'campanas'=>$campanas,
		]);

}

public function informeUser($id){
	$user = User::find($id);
	$campana = Campana::find($user->campana);

	$cumas = captaciones::where('campana_id',$user->campana)->where('estado','cu+')->where('teoFinal',$id)->count();
	$cumenos = captaciones::where('campana_id',$user->campana)->where('estado','cu-')->where('teoFinal',$id)->count();
	$ca = captaciones::where('campana_id',$user->campana)->where('estado','ca')->where('teoFinal',$id)->count();
	$registrosContactados = $cumas+$cumenos+$ca;

	$cnu1 = captaciones::where('campana_id',$user->campana)->where('estado1','cnu')->where('teo1',$id)->count();
	$cnu2 = captaciones::where('campana_id',$user->campana)->where('estado2','cnu')->where('teo2',$id)->count();
	$cnu3 = captaciones::where('campana_id',$user->campana)->where('estado3','cnu')->where('teo3',$id)->count();
	$cnu = $cnu1+$cnu2+$cnu3;
	$llamados =$cumas+$cumenos+$ca+$cnu;

	$agendamiento = CaptacionesExitosa::where('nom_campana','=',$campana->nombre_campana)->where('teleoperador','=',$user->id)->where('tipo_retiro','=','Acepta Agendamiento')->count();
	$grabacion = CaptacionesExitosa::where('nom_campana','=',$campana->nombre_campana)->where('teleoperador','=',$user->id)->where('tipo_retiro','=','Acepta Grabacion')->count();
	$delivery = CaptacionesExitosa::where('nom_campana','=',$campana->nombre_campana)->where('teleoperador','=',$user->id)->where('tipo_retiro','=','Acepta Delivery')->count();
	$iradues = CaptacionesExitosa::where('nom_campana','=',$campana->nombre_campana)->where('teleoperador','=',$user->id)->where('tipo_retiro','=','Acepta ir a Dues')->count();
	$breadcrum = $user->name." ".$user->last_name." / ".$campana->nombre_campana;

	$firstlabs = captaciones::select('primer_llamado')->where('teo1',$user->id)//seleccionamos las fechas de ultimo llamado sin repetirse para graficas el resultado general
	->where('campana_id',$campana->id)->distinct()->whereNotNull('primer_llamado')->get()->sortByDesc('primer_llamado');

	$contador = 0;//inicializamos un contador en 0
			foreach ($firstlabs as $l ){//recorremos las fechas de llamados obtenidos desde la query
				/*Usamos el foreach para recorrer la coleccion y por cada iteracion tomamos la fecha de ultimo llamado y seleccionamos la data usando esa fecha en cada iteracion*/
				$dcumas =captaciones::where('estado1','cu+')->where('teo1',$user->id)//seleccionamos los cu+
				->where('primer_llamado',$l->primer_llamado)->where('campana_id',$user->campana)->count();
				$dCumasPrimer[$contador]=$dcumas;//guardamos el resultado en la posicion asignada por el contador que se incremente en 1 por cada iteracion

				$dcumenos =captaciones::where('estado1','cu-')->where('teo1',$user->id)//seleccionamos los cu-
				->where('primer_llamado',$l->primer_llamado)->where('campana_id',$user->campana)->count();
					$dCumenosPrimer[$contador]=$dcumenos;//guardamos el resultado en la posicion asignada por el contador que se incremente en 1 por cada iteracion

				$dcnu = captaciones::where('estado1','cnu')->where('teo1',$user->id)//seleccionamos los cnu
				->where('primer_llamado',$l->primer_llamado)->where('campana_id',$campana->id)->count();
				$dCnuPrimer[$contador]=$dcnu;//guardamos el resultado en la posicion asignada por el contador que se incremente en 1 por cada iteracion

				$dca = captaciones::where('estado1','ca')->where('teo1',$user->id)//seleccionamos los ca
				->where('primer_llamado',$l->primer_llamado)->where('campana_id',$campana->id)->count();
				$dCallAgainPrimer[$contador]=$dca;//guardamos el resultado en la posicion asignada por el contador que se incremente en 1 por cada iteracion

					$labelsPrimer[$contador]=$l->primer_llamado;//guardamos en un array los labels para poder graficarlso de forma dinamica
					$contador = $contador+1;//aumentamos el contador en 1 por cada iteracion del ciclo
			}

			$secondlabs = captaciones::select('segundo_llamado')->where('teo2',$user->id)//seleccionamos las fechas de ultimo llamado sin repetirse para graficas el resultado general
			->where('campana_id',$campana->id)->distinct()->whereNotNull('segundo_llamado')->get()->sortByDesc('segundo_llamado');

			$contador2 = 0;//inicializamos un contador en 0
					foreach ($secondlabs as $l ){//recorremos las fechas de llamados obtenidos desde la query
						/*Usamos el foreach para recorrer la coleccion y por cada iteracion tomamos la fecha de ultimo llamado y seleccionamos la data usando esa fecha en cada iteracion*/
						$dcumas =captaciones::where('estado2','cu+')->where('teo2',$user->id)//seleccionamos los cu+
						->where('segundo_llamado',$l->segundo_llamado)->where('campana_id',$user->campana)->count();
						$dCumasSegundo[$contador2]=$dcumas;//guardamos el resultado en la posicion asignada por el contador que se incremente en 1 por cada iteracion

						$dcumenos =captaciones::where('estado2','cu-')->where('teo2',$user->id)//seleccionamos los cu-
						->where('segundo_llamado',$l->segundo_llamado)->where('campana_id',$user->campana)->count();
							$dCumenosSegundo[$contador2]=$dcumenos;//guardamos el resultado en la posicion asignada por el contador que se incremente en 1 por cada iteracion

						$dcnu = captaciones::where('estado2','cnu')->where('teo2',$user->id)//seleccionamos los cnu
						->where('segundo_llamado',$l->segundo_llamado)->where('campana_id',$campana->id)->count();
						$dCnuSegundo[$contador2]=$dcnu;//guardamos el resultado en la posicion asignada por el contador que se incremente en 1 por cada iteracion

						$dca = captaciones::where('estado2','ca')->where('teo2',$user->id)                                  //seleccionamos los ca
						->where('segundo_llamado',$l->segundo_llamado)->where('campana_id',$campana->id)->count();
						$dCallAgainSegundo[$contador2]=$dca;//guardamos el resultado en la posicion asignada por el contador que se incremente en 1 por cada iteracion

							$labelsSegundo[$contador2]=$l->segundo_llamado;//guardamos en un array los labels para poder graficarlso de forma dinamica
							$contador2 = $contador2+1;//aumentamos el contador en 1 por cada iteracion del ciclo
					}


					$threelabs = captaciones::select('tercer_llamado')->where('teo3',$user->id)//seleccionamos las fechas de ultimo llamado sin repetirse para graficas el resultado general
					->where('campana_id',$campana->id)->distinct()->whereNotNull('tercer_llamado')->get()->sortByDesc('tercer_llamado');

					$contador3 = 0;//inicializamos un contador en 0
							foreach ($threelabs as $l ){//recorremos las fechas de llamados obtenidos desde la query
								/*Usamos el foreach para recorrer la coleccion y por cada iteracion tomamos la fecha de ultimo llamado y seleccionamos la data usando esa fecha en cada iteracion*/
								$dcumas =captaciones::where('estado3','cu+')->where('teo3',$user->id)//seleccionamos los cu+
								->where('tercer_llamado',$l->tercer_llamado)->where('campana_id',$user->campana)->count();
								$dCumasTercer[$contador3]=$dcumas;//guardamos el resultado en la posicion asignada por el contador que se incremente en 1 por cada iteracion

								$dcumenos =captaciones::where('estado3','cu-')->where('teo3',$user->id)//seleccionamos los cu-
								->where('tercer_llamado',$l->tercer_llamado)->where('campana_id',$user->campana)->count();
									$dCumenosTercer[$contador3]=$dcumenos;//guardamos el resultado en la posicion asignada por el contador que se incremente en 1 por cada iteracion

								$dcnu = captaciones::where('estado3','cnu')->where('teo3',$user->id)//seleccionamos los cnu
								->where('tercer_llamado',$l->tercer_llamado)->where('campana_id',$campana->id)->count();
								$dCnuTercer[$contador3]=$dcnu;//guardamos el resultado en la posicion asignada por el contador que se incremente en 1 por cada iteracion

								$dca = captaciones::where('estado3','ca')->where('teo3',$user->id)//seleccionamos los ca
								->where('tercer_llamado',$l->tercer_llamado)->where('campana_id',$campana->id)->count();
								$dCallAgainTercer[$contador3]=$dca;//guardamos el resultado en la posicion asignada por el contador que se incremente en 1 por cada iteracion

									$labelsTercer[$contador3]=$l->tercer_llamado;//guardamos en un array los labels para poder graficarlso de forma dinamica
									$contador3 = $contador3+1;//aumentamos el contador en 1 por cada iteracion del ciclo
							}

	if($registrosContactados != 0){
		$penetracion =  number_format($cumas/$llamados*100,2,'.','');
		$contactabilidad = number_format((float)$registrosContactados/$llamados*100, 2, '.', '');
	}else{
		$penetracion = "Sin Registros";
		$contactabilidad = "Sin Registros";
	}

	return view('Informes.informeUser',
	[
		'user'=>$user,
		'llamados' =>$llamados,
		'registrosContactados' =>$registrosContactados,
		'cumas' => $cumas,
		'cumenos' => $cumenos,
		'cnu' => $cnu,
		'agendamiento'=>$agendamiento,
		'grabacion'=>$grabacion,
		'delivery'=>$delivery,
		'breadcrum'=>$breadcrum,
		'penetracion'=>$penetracion,
		'contactabilidad'=>$contactabilidad,
		'iradues'=>$iradues,
		'ca'=>$ca,
		'labelsPrimer'=>$labelsPrimer,
		'dCallAgainPrimer'=>$dCallAgainPrimer,
		'dCnuPrimer'=>$dCnuPrimer,
		'dCumenosPrimer'=>$dCumenosPrimer,
		'dCumasPrimer'=>$dCumasPrimer,
		'dCumasSegundo'=>$dCumasSegundo,
		'dCumenosSegundo'=>$dCumenosSegundo,
		'dCnuSegundo'=>$dCnuSegundo,
		'dCallAgainSegundo'=>$dCallAgainSegundo,
		'labelsSecond'=>$labelsSegundo,
		'dCumasTercero'=>$dCumasTercer,
		'dCumenosTercero'=>$dCumenosTercer,
		'dCnuTercero'=>$dCnuTercer,
		'dCallAgainTercero'=>$dCallAgainTercer,
		'labelsTercero'=>$labelsTercer,

	]);
}


public function informeUserCampaing($user, $campaing){

	$usuario = User::find($user);
	$campana = Campana::find($campaing);

	$cumas = captaciones::where('campana_id',$campaing)->where('estado','cu+')->where('teoFinal',$user)->count();
	$cumenos = captaciones::where('campana_id',$campaing)->where('estado','cu-')->where('teoFinal',$user)->count();
	$ca =captaciones::where('campana_id',$campaing)->where('estado','ca')->where('teoFinal',$user)->count();
	$registrosContactados=$cumas+$cumenos+$ca;

	$cnu1 = captaciones::where('campana_id','=',$campaing)->where('teo1',$user)->where('estado1','cnu')->count();
	$cnu2 = captaciones::where('campana_id','=',$campaing)->where('teo2',$user)->where('estado2','cnu')->count();
	$cnu3 = captaciones::where('campana_id','=',$campaing)->where('teo3',$user)->where('estado3','=','cnu')->count();
	$cnu=$cnu1+$cnu2+$cnu3;

	$llamados =$cumas+$cumenos+$ca+$cnu;;

	$agendamiento = CaptacionesExitosa::where('nom_campana','=',$campana->nombre_campana)->where('teleoperador','=',$user)->where('tipo_retiro','=','Acepta Agendamiento')->count();
	$grabacion = CaptacionesExitosa::where('nom_campana','=',$campana->nombre_campana)->where('teleoperador','=',$user)->where('tipo_retiro','=','Acepta Grabacion')->count();
	$delivery = CaptacionesExitosa::where('nom_campana','=',$campana->nombre_campana)->where('teleoperador','=',$user)->where('tipo_retiro','=','Acepta Delivery')->count();
	$iradues = CaptacionesExitosa::where('nom_campana','=',$campana->nombre_campana)->where('teleoperador','=',$user)->where('tipo_retiro','=','Acepta ir a Dues')->count();

	$breadcrum = $usuario->name." ".$usuario->last_name." / ".$campana->nombre_campana;

	if($registrosContactados != 0){
		$penetracion =  number_format($cumas/$llamados*100,2,'.','');
		$contactabilidad = number_format((float)$registrosContactados/$llamados*100, 2, '.', '');
	}else{
			$penetracion = "Sin Registros";
			$contactabilidad = "Sin Registros";
	}
	return view('Informes.informeUser',[
		'user'=>$usuario,
		'llamados' =>$llamados,
		'registrosContactados' =>$registrosContactados,
		'cumas' => $cumas,
		'cumenos' => $cumenos,
		'cnu' => $cnu,
		'agendamiento'=>$agendamiento,
		'grabacion'=>$grabacion,
		'delivery'=>$delivery,
		'breadcrum'=>$breadcrum,
		'penetracion'=>$penetracion,
		'contactabilidad'=>$contactabilidad,
		'ca'=>$ca,
		'iradues'=>$iradues,
	]);
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

	return view('Informes.informeRutero',[
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
		'hoy'=>$hoy,
	]);
}

public function campanaReport($id){
	$campana = Campana::find($id);
	$llamados = captaciones::where('estado','!=',0)->where('campana_id','=',$campana->id)->count();
	$pendientes = captaciones::where('estado','=',0)->where('campana_id','=',$campana->id)->count();

	return view('Informes/reportCampaing',[
		'campana'=>$campana,
		'llamados'=>$llamados,
		'pendientes'=>$pendientes,]);
}




}
