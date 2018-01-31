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
		$campana = Campana::find($campana);

		$total =$campana->registrosCampana->count();

			$llamados = captaciones::where('estado','!=',0)->where('campana_id','=',$campana->id)->count();
			$pendientes = captaciones::where('estado','=',0)->where('campana_id','=',$campana->id)->count();
			$cumas = captaciones::where('estado','=','cu+')->where('campana_id','=',$campana->id)->count();
			$cumenos = captaciones::where('estado','=','cu-')->where('campana_id','=',$campana->id)->count();
			$cnu = captaciones::where('estado','=','cnu')->where('campana_id','=',$campana->id)->count();
			$call_again = captaciones::where('estado','=','ca')->where('campana_id','=',$campana->id)->count();

			$contactados = $cumas+$cumenos+$call_again;
			$recorrido ="Recorrido Genaral de la Base";
		if($contactados != 0){
			$penetracion =  number_format($cumas/$llamados*100,2,'.','');
			$penetracionTotal = number_format($cumas/$total*100,2,'.','');
			$contactabilidad = number_format((float)$contactados/$llamados*100, 2, '.', '');

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
			]);
		}else{
			return view('Informes.informeCampana',[
				'total'=>$total,
				'llamados'=>$llamados,
				'pendientes'=>$pendientes,
				'base'=>$campana,
				'cumas'=>$cumas,
				'cumenos'=>$cumenos,
				'cnu'=>$cnu,
				'call_again'=>$call_again,
				'recorrido'=>$recorrido,
			]);

		}

}


public function informeCampanaRecorridos($id,$vuelta){

	$campana = Campana::find($id);

		if($vuelta==1){
			$recorrer ="primer_llamado";
			$estado_llamado="estado_llamada1";
			$recorrido ="Recorrido Primera Vuelta  de la Base";
			$total=$campana->registrosCampana->count();

		}elseif($vuelta==2){

						$recorrer ="segundo_llamado";
						$estado_llamado="estado_llamada2";
						$recorrido ="Recorrido Segunda Vuelta  de la Base";

						$cumas1 = captaciones::where('estado_llamada1','=','Acepta Agendamiento')->where('campana_id','=',$id)->count();
						$cumas2 = captaciones::where('estado_llamada1','=','Acepta Grabacion')->where('campana_id','=',$id)->count();
						$cumas3 = captaciones::where('estado_llamada1','=','Acepta Delivery')->where('campana_id','=',$id)->count();
						$cumas4 = captaciones::where('estado_llamada1','=','Acepta ir a Dues')->where('campana_id','=',$id)->count();
						$cumas = $cumas1+$cumas2+$cumas3+$cumas4;

						$cumenos1  = captaciones::where('campana_id','=',$campana->id)->where('estado_llamada1', '=', 'Civer Activista')->count();
						$cumenos2  = captaciones::where('campana_id','=',$campana->id)->where('estado_llamada1', '=', 'Aporta a otra Fundacion')->count();
						$cumenos3  = captaciones::where('campana_id','=',$campana->id)->where('estado_llamada1', '=', 'Es Socio')->count();
						$cumenos4  = captaciones::where('campana_id','=',$campana->id)->where('estado_llamada1', '=', 'Fue Contactado')->count();
						$cumenos5  = captaciones::where('campana_id','=',$campana->id)->where('estado_llamada1', '=', 'Jubilado')->count();
						$cumenos6  = captaciones::where('campana_id','=',$campana->id)->where('estado_llamada1', '=', 'Menor de Edad')->count();
						$cumenos7  = captaciones::where('campana_id','=',$campana->id)->where('estado_llamada1', '=', 'No tiene Cuenta')->count();
						$cumenos8  = captaciones::where('campana_id','=',$campana->id)->where('estado_llamada1', '=', 'Sin Dinero')->count();
						$cumenos9  = captaciones::where('campana_id','=',$campana->id)->where('estado_llamada1', '=', 'Auto Upgrade')->count();
						$cumenos10 = captaciones::where('campana_id','=',$campana->id)->where('estado_llamada1', '=', 'Sin Trabajo')->count();
						$cumenos11 = captaciones::where('campana_id','=',$campana->id)->where('estado_llamada1', '=', 'No Interesado')->count();
						$cumenos12 = captaciones::where('campana_id','=',$campana->id)->where('estado_llamada1', '=', 'Molesto por Llamado')->count();
						$cumenos13 = captaciones::where('campana_id','=',$campana->id)->where('estado_llamada1', '=', 'Persona Cuelga')->count();
						$cumenos14 = captaciones::where('campana_id','=',$campana->id)->where('estado_llamada1', '=', 'Quiere Renunciar')->count();
					$cumenos = $cumenos1+$cumenos2+$cumenos3+$cumenos4+$cumenos5+$cumenos6+$cumenos7+$cumenos8+$cumenos9+$cumenos10+$cumenos11+$cumenos12+$cumenos13+$cumenos14;
				$total=$campana->registrosCampana->count()-$cumas-$cumenos;

		}elseif($vuelta==3){

						$recorrer ="tercer_llamado";
						$estado_llamado="estado_llamada3";
						$recorrido ="Recorrido Tercera Vuelta  de la Base";
						$recorrer ="tercer_llamado";
						$estado_llamado="estado_llamada3";
						$recorrido ="Recorrido Tercera Vuelta  de la Base";

						$cumas1 = captaciones::where('estado_llamada1','=','Acepta Agendamiento')->where('campana_id','=',$id)->count();
						$cumas2 = captaciones::where('estado_llamada1','=','Acepta Grabacion')->where('campana_id','=',$id)->count();
						$cumas3 = captaciones::where('estado_llamada1','=','Acepta Delivery')->where('campana_id','=',$id)->count();
						$cumas4 = captaciones::where('estado_llamada1','=','Acepta ir a Dues')->where('campana_id','=',$id)->count();

						$cumas5 = captaciones::where('estado_llamada2','=','Acepta Agendamiento')->where('campana_id','=',$id)->count();
						$cumas6 = captaciones::where('estado_llamada2','=','Acepta Grabacion')->where('campana_id','=',$id)->count();
						$cumas7 = captaciones::where('estado_llamada2','=','Acepta Delivery')->where('campana_id','=',$id)->count();
						$cumas8 = captaciones::where('estado_llamada2','=','Acepta ir a Dues')->where('campana_id','=',$id)->count();

						$cumasvuelta1 = $cumas1+$cumas2+$cumas3+$cumas4;
						$cumasvuelta2 = $cumas5+$cumas6+$cumas7+$cumas8;

						$cumenos1  = captaciones::where('campana_id','=',$campana->id)->where('estado_llamada1', '=', 'Civer Activista')->count();
						$cumenos2  = captaciones::where('campana_id','=',$campana->id)->where('estado_llamada1', '=', 'Aporta a otra Fundacion')->count();
						$cumenos3  = captaciones::where('campana_id','=',$campana->id)->where('estado_llamada1', '=', 'Es Socio')->count();
						$cumenos4  = captaciones::where('campana_id','=',$campana->id)->where('estado_llamada1', '=', 'Fue Contactado')->count();
						$cumenos5  = captaciones::where('campana_id','=',$campana->id)->where('estado_llamada1', '=', 'Jubilado')->count();
						$cumenos6  = captaciones::where('campana_id','=',$campana->id)->where('estado_llamada1', '=', 'Menor de Edad')->count();
						$cumenos7  = captaciones::where('campana_id','=',$campana->id)->where('estado_llamada1', '=', 'No tiene Cuenta')->count();
						$cumenos8  = captaciones::where('campana_id','=',$campana->id)->where('estado_llamada1', '=', 'Sin Dinero')->count();
						$cumenos9  = captaciones::where('campana_id','=',$campana->id)->where('estado_llamada1', '=', 'Auto Upgrade')->count();
						$cumenos10 = captaciones::where('campana_id','=',$campana->id)->where('estado_llamada1', '=', 'Sin Trabajo')->count();
						$cumenos11 = captaciones::where('campana_id','=',$campana->id)->where('estado_llamada1', '=', 'No Interesado')->count();
						$cumenos12 = captaciones::where('campana_id','=',$campana->id)->where('estado_llamada1', '=', 'Molesto por Llamado')->count();
						$cumenos13 = captaciones::where('campana_id','=',$campana->id)->where('estado_llamada1', '=', 'Persona Cuelga')->count();
						$cumenos14 = captaciones::where('campana_id','=',$campana->id)->where('estado_llamada1', '=', 'Quiere Renunciar')->count();

						$cumenos15  = captaciones::where('campana_id','=',$campana->id)->where('estado_llamada2', '=', 'Civer Activista')->count();
						$cumenos16  = captaciones::where('campana_id','=',$campana->id)->where('estado_llamada2', '=', 'Aporta a otra Fundacion')->count();
						$cumenos17  = captaciones::where('campana_id','=',$campana->id)->where('estado_llamada2', '=', 'Es Socio')->count();
						$cumenos18  = captaciones::where('campana_id','=',$campana->id)->where('estado_llamada2', '=', 'Fue Contactado')->count();
						$cumenos19  = captaciones::where('campana_id','=',$campana->id)->where('estado_llamada2', '=', 'Jubilado')->count();
						$cumenos20  = captaciones::where('campana_id','=',$campana->id)->where('estado_llamada2', '=', 'Menor de Edad')->count();
						$cumenos21  = captaciones::where('campana_id','=',$campana->id)->where('estado_llamada2', '=', 'No tiene Cuenta')->count();
						$cumenos22  = captaciones::where('campana_id','=',$campana->id)->where('estado_llamada2', '=', 'Sin Dinero')->count();
						$cumenos23  = captaciones::where('campana_id','=',$campana->id)->where('estado_llamada2', '=', 'Auto Upgrade')->count();
						$cumenos24 = captaciones::where('campana_id','=',$campana->id)->where('estado_llamada2', '=', 'Sin Trabajo')->count();
						$cumenos25 = captaciones::where('campana_id','=',$campana->id)->where('estado_llamada2', '=', 'No Interesado')->count();
						$cumenos26 = captaciones::where('campana_id','=',$campana->id)->where('estado_llamada2', '=', 'Molesto por Llamado')->count();
						$cumenos27 = captaciones::where('campana_id','=',$campana->id)->where('estado_llamada2', '=', 'Persona Cuelga')->count();
						$cumenos28 = captaciones::where('campana_id','=',$campana->id)->where('estado_llamada2', '=', 'Quiere Renunciar')->count();

					$cumenosvuelta1 = $cumenos1+$cumenos2+$cumenos3+$cumenos4+$cumenos5+$cumenos6+$cumenos7+$cumenos8+$cumenos9+$cumenos10+$cumenos11+$cumenos12+$cumenos13+$cumenos14;
					$cumenosvuelta2 = $cumenos15+$cumenos16+$cumenos17+$cumenos18+$cumenos19+$cumenos20+$cumenos21+$cumenos22+$cumenos23+$cumenos24+$cumenos25+$cumenos26+$cumenos17+$cumenos28;

				$total=$campana->registrosCampana->count()-$cumasvuelta1-$cumenosvuelta1-$cumasvuelta2-$cumenosvuelta2;

		}

		$llamados = captaciones::where('campana_id','=',$id)->where($recorrer,'!=',0)->count();
		$pendientes =$total-$llamados;

			$cumas1 = captaciones::where($estado_llamado,'=','Acepta Agendamiento')->where('campana_id','=',$id)->count();
			$cumas2 = captaciones::where($estado_llamado,'=','Acepta Grabacion')->where('campana_id','=',$id)->count();
			$cumas3 = captaciones::where($estado_llamado,'=','Acepta Delivery')->where('campana_id','=',$id)->count();
			$cumas4 = captaciones::where($estado_llamado,'=','Acepta ir a Dues')->where('campana_id','=',$id)->count();
			$cumas = $cumas1+$cumas2+$cumas3+$cumas4;

			$cumenos1  = captaciones::where('campana_id','=',$campana->id)->where($estado_llamado, '=', 'Civer Activista')->count();
			$cumenos2  = captaciones::where('campana_id','=',$campana->id)->where($estado_llamado, '=', 'Aporta a otra Fundacion')->count();
			$cumenos3  = captaciones::where('campana_id','=',$campana->id)->where($estado_llamado, '=', 'Es Socio')->count();
			$cumenos4  = captaciones::where('campana_id','=',$campana->id)->where($estado_llamado, '=', 'Fue Contactado')->count();
			$cumenos5  = captaciones::where('campana_id','=',$campana->id)->where($estado_llamado, '=', 'Jubilado')->count();
			$cumenos6  = captaciones::where('campana_id','=',$campana->id)->where($estado_llamado, '=', 'Menor de Edad')->count();
			$cumenos7  = captaciones::where('campana_id','=',$campana->id)->where($estado_llamado, '=', 'No tiene Cuenta')->count();
			$cumenos8  = captaciones::where('campana_id','=',$campana->id)->where($estado_llamado, '=', 'Sin Dinero')->count();
			$cumenos9  = captaciones::where('campana_id','=',$campana->id)->where($estado_llamado, '=', 'Auto Upgrade')->count();
			$cumenos10 = captaciones::where('campana_id','=',$campana->id)->where($estado_llamado, '=', 'Sin Trabajo')->count();
			$cumenos11 = captaciones::where('campana_id','=',$campana->id)->where($estado_llamado, '=', 'No Interesado')->count();
			$cumenos12 = captaciones::where('campana_id','=',$campana->id)->where($estado_llamado, '=', 'Molesto por Llamado')->count();
			$cumenos13 = captaciones::where('campana_id','=',$campana->id)->where($estado_llamado, '=', 'Persona Cuelga')->count();
			$cumenos14 = captaciones::where('campana_id','=',$campana->id)->where($estado_llamado, '=', 'Quiere Renunciar')->count();
		$cumenos = $cumenos1+$cumenos2+$cumenos3+$cumenos4+$cumenos5+$cumenos6+$cumenos7+$cumenos8+$cumenos9+$cumenos10+$cumenos11+$cumenos12+$cumenos13+$cumenos14;

			$cnu1  = captaciones::where('campana_id','=',$campana->id)->where($estado_llamado, '=', 'Fono Ocupado')->count();
			$cnu2  = captaciones::where('campana_id','=',$campana->id)->where($estado_llamado, '=', 'Grabadora')->count();
			$cnu3  = captaciones::where('campana_id','=',$campana->id)->where($estado_llamado, '=', 'Fax')->count();
			$cnu4  = captaciones::where('campana_id','=',$campana->id)->where($estado_llamado, '=', 'No Contesta')->count();
			$cnu5  = captaciones::where('campana_id','=',$campana->id)->where($estado_llamado, '=', 'Fuera de Servicio')->count();
			$cnu6  = captaciones::where('campana_id','=',$campana->id)->where($estado_llamado, '=', 'Mala Conexion')->count();
			$cnu7  = captaciones::where('campana_id','=',$campana->id)->where($estado_llamado, '=', 'Otra Persona')->count();
			$cnu8  = captaciones::where('campana_id','=',$campana->id)->where($estado_llamado, '=', 'Fallecido')->count();
		$cnu = $cnu1+$cnu2+$cnu3+$cnu4+$cnu5+$cnu6+$cnu7+$cnu8;

		$call_again = captaciones::where($estado_llamado,'=','Agendar Llamado')->where('campana_id','=',$campana->id)->count();

		$contactados = $cumas+$cumenos+$call_again;

	if($contactados != 0){
		$penetracion =  number_format($cumas/$llamados*100,2,'.','');
		$penetracionTotal = number_format($cumas/$total*100,2,'.','');
		$contactabilidad = number_format((float)$contactados/$llamados*100, 2, '.', '');

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
		]);
	}else{
		return view('Informes.informeCampana',[
			'total'=>$total,
			'llamados'=>$llamados,
			'pendientes'=>$pendientes,
			'base'=>$campana,
			'cumas'=>$cumas,
			'cumenos'=>$cumenos,
			'cnu'=>$cnu,
			'call_again'=>$call_again,
			'recorrido'=>$recorrido,
		]);

	}
}



public function informeFundacion($fundacion){
		$fundacion = fundacion::find($fundacion);
		$campanas = Campana::where('fundacion','=',$fundacion->id)->get();
		return view('Informes.informeFundacion',[
			'fundacion'=>$fundacion,
			'campanas'=>$campanas,
		]);
	// return "hola";
}

public function informeUser($id){
	$user = User::find($id);
	$campana = Campana::find($user->campana);

	$llamados1 = captaciones::where('campana_id','=',$user->campana)->where('teo1','=',$id)->count();
	$llamados2 = captaciones::where('campana_id','=',$user->campana)->where('teo1','!=',$id)->where('teo2','=',$id)->count();
	$llamados3 = captaciones::where('campana_id','=',$user->campana)->where('teo1','!=',$id)->where('teo2','!=',$id)->where('teo3','=',$id)->count();
	$llamados=$llamados1+$llamados2+$llamados3;

	$llamados1 = captaciones::where('campana_id','=',$user->campana)->where('teo1','=',$id)->where('estado','!=','cnu')->count();
	$llamados2 = captaciones::where('campana_id','=',$user->campana)->where('teo1','!=',$id)->where('teo2','=',$id)->where('estado','!=','cnu')->count();
	$llamados3 = captaciones::where('campana_id','=',$user->campana)->where('teo1','!=',$id)->where('teo2','!=',$id)->where('teo3','=',$id)->where('estado','!=','cnu')->count();
	$registrosContactados=$llamados1+$llamados2+$llamados3;

	$llamados1 = captaciones::where('campana_id','=',$user->campana)->where('teo1','=',$id)->where('estado','=','cu+')->count();
	$llamados2 = captaciones::where('campana_id','=',$user->campana)->where('teo1','!=',$id)->where('teo2','=',$id)->where('estado','=','cu+')->count();
	$llamados3 = captaciones::where('campana_id','=',$user->campana)->where('teo1','!=',$id)->where('teo2','!=',$id)->where('teo3','=',$id)->where('estado','=','cu+')->count();
	$cumas=$llamados1+$llamados2+$llamados3;

	$llamados1 = captaciones::where('campana_id','=',$user->campana)->where('teo1','=',$id)->where('estado','=','cu-')->count();
	$llamados2 = captaciones::where('campana_id','=',$user->campana)->where('teo1','!=',$id)->where('teo2','=',$id)->where('estado','=','cu-')->count();
	$llamados3 = captaciones::where('campana_id','=',$user->campana)->where('teo1','!=',$id)->where('teo2','!=',$id)->where('teo3','=',$id)->where('estado','=','cu-')->count();
	$cumenos=$llamados1+$llamados2+$llamados3;

	$llamados1 = captaciones::where('campana_id','=',$user->campana)->where('teo1','=',$id)->where('estado','=','cnu')->count();
	$llamados2 = captaciones::where('campana_id','=',$user->campana)->where('teo1','!=',$id)->where('teo2','=',$id)->where('estado','=','cnu')->count();
	$llamados3 = captaciones::where('campana_id','=',$user->campana)->where('teo1','!=',$id)->where('teo2','!=',$id)->where('teo3','=',$id)->where('estado','=','cnu')->count();
	$cnu=$llamados1+$llamados2+$llamados3;

	$llamados1 = captaciones::where('campana_id','=',$user->campana)->where('teo1','=',$id)->where('estado','=','ca')->count();
	$llamados2 = captaciones::where('campana_id','=',$user->campana)->where('teo1','!=',$id)->where('teo2','=',$id)->where('estado','=','ca')->count();
	$llamados3 = captaciones::where('campana_id','=',$user->campana)->where('teo1','!=',$id)->where('teo2','!=',$id)->where('teo3','=',$id)->where('estado','=','ca')->count();
	$ca=$llamados1+$llamados2+$llamados3;


	$agendamiento = CaptacionesExitosa::where('nom_campana','=',$campana->nombre_campana)->where('teleoperador','=',$user->id)->where('tipo_retiro','=','Acepta Agendamiento')->count();
	$grabacion = CaptacionesExitosa::where('nom_campana','=',$campana->nombre_campana)->where('teleoperador','=',$user->id)->where('tipo_retiro','=','Acepta Grabacion')->count();
	$delivery = CaptacionesExitosa::where('nom_campana','=',$campana->nombre_campana)->where('teleoperador','=',$user->id)->where('tipo_retiro','=','Acepta Delivery')->count();

	$breadcrum = $user->name." ".$user->last_name." / ".$campana->nombre_campana;

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
		'ca'=>$ca,
	]);
}


public function informeUserCampaing($user, $campaing){

	$usuario = User::find($user);
	$campana = Campana::find($campaing);

	$llamados1 = captaciones::where('campana_id','=',$campaing)->where('teo1','=',$user)->count();
	$llamados2 = captaciones::where('campana_id','=',$campaing)->where('teo1','!=',$user)->where('teo2','=',$user)->count();
	$llamados3 = captaciones::where('campana_id','=',$campaing)->where('teo1','!=',$user)->where('teo2','!=',$user)->where('teo3','=',$user)->count();
	$llamados=$llamados1+$llamados2+$llamados3;

	$llamados1 = captaciones::where('campana_id','=',$campaing)->where('teo1','=',$user)->where('estado','!=','cnu')->count();
	$llamados2 = captaciones::where('campana_id','=',$campaing)->where('teo1','!=',$user)->where('teo2','=',$user)->where('estado','!=','cnu')->count();
	$llamados3 = captaciones::where('campana_id','=',$campaing)->where('teo1','!=',$user)->where('teo2','!=',$user)->where('teo3','=',$user)->where('estado','!=','cnu')->count();
	$registrosContactados=$llamados1+$llamados2+$llamados3;

	$llamados1 = captaciones::where('campana_id','=',$campaing)->where('teo1','=',$user)->where('estado','=','cu+')->count();
	$llamados2 = captaciones::where('campana_id','=',$campaing)->where('teo1','!=',$user)->where('teo2','=',$user)->where('estado','=','cu+')->count();
	$llamados3 = captaciones::where('campana_id','=',$campaing)->where('teo1','!=',$user)->where('teo2','!=',$user)->where('teo3','=',$user)->where('estado','=','cu+')->count();
	$cumas=$llamados1+$llamados2+$llamados3;

	$llamados1 = captaciones::where('campana_id','=',$campaing)->where('teo1','=',$user)->where('estado','=','cu-')->count();
	$llamados2 = captaciones::where('campana_id','=',$campaing)->where('teo1','!=',$user)->where('teo2','=',$user)->where('estado','=','cu-')->count();
	$llamados3 = captaciones::where('campana_id','=',$campaing)->where('teo1','!=',$user)->where('teo2','!=',$user)->where('teo3','=',$user)->where('estado','=','cu-')->count();
	$cumenos=$llamados1+$llamados2+$llamados3;

	$llamados1 = captaciones::where('campana_id','=',$campaing)->where('teo1','=',$user)->where('estado','=','cnu')->count();
	$llamados2 = captaciones::where('campana_id','=',$campaing)->where('teo1','!=',$user)->where('teo2','=',$user)->where('estado','=','cnu')->count();
	$llamados3 = captaciones::where('campana_id','=',$campaing)->where('teo1','!=',$user)->where('teo2','!=',$user)->where('teo3','=',$user)->where('estado','=','cnu')->count();
	$cnu=$llamados1+$llamados2+$llamados3;

	$llamados1 = captaciones::where('campana_id','=',$campaing)->where('teo1','=',$user)->where('estado','=','ca')->count();
	$llamados2 = captaciones::where('campana_id','=',$campaing)->where('teo1','!=',$user)->where('teo2','=',$user)->where('estado','=','ca')->count();
	$llamados3 = captaciones::where('campana_id','=',$campaing)->where('teo1','!=',$user)->where('teo2','!=',$user)->where('teo3','=',$user)->where('estado','=','ca')->count();
	$ca=$llamados1+$llamados2+$llamados3;

	$agendamiento = CaptacionesExitosa::where('nom_campana','=',$campana->nombre_campana)->where('teleoperador','=',$user)->where('tipo_retiro','=','Acepta Agendamiento')->count();
	$grabacion = CaptacionesExitosa::where('nom_campana','=',$campana->nombre_campana)->where('teleoperador','=',$user)->where('tipo_retiro','=','Acepta Grabacion')->count();
	$delivery = CaptacionesExitosa::where('nom_campana','=',$campana->nombre_campana)->where('teleoperador','=',$user)->where('tipo_retiro','=','Acepta Delivery')->count();

	$breadcrum = $usuario->name." ".$usuario->last_name." / ".$campana->nombre_campana;

	if($registrosContactados != 0){
		$penetracion =  number_format($cumas/$llamados*100,2,'.','');
		$contactabilidad = number_format((float)$registrosContactados/$llamados*100, 2, '.', '');
	}else{
			$penetracion = "Sin Registros";
			$contactabilidad = "Sin Registros";
	}
	return view('Informes.informeUser',
	[
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
