<?php namespace App\Http\Controllers;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use DB;
use App\CaptacionesExitosa;
use App\CoberturaRegiones;
use App\comunaRetiro;
use App\captaciones;
use Carbon\Carbon;
use App\estado;
use App\Letter;
use App\maxCap;
use App\User;

class RegionesController extends Controller {

	public function store(Request $request)
	{

			 $data = $request->all();//seleccionamos todo el request y lo asignamos a data|

			 $date = Carbon::now()->format('d/m/Y');//seleccionamos la fecha de hoy y la guardamos en la variable hoy
			 $comuna=CoberturaRegiones::where('comuna','=',$request->comunas)->get()->first();

			 $region =$comuna->region;//asignamos el valor de la propiedad region del objeto comuna a la variable region
			 $direccion = $request->direccion." #".$request->numero." / ".$request->lugarRetiro." #".$request->off_depto." / ".$request->comuna;
			 // usando el request concatenamos los diferentes campos que conforman la direccion y le damos el formato que guardaremos enb la bd

			 $letter = Letter::where('id_fundacion','=',$request->fundacion)->where('number','=',0)->get()->first();
			 $letter_id = $letter->id;

		 $cap= CaptacionesExitosa::create([//creamos una captaion exitosa usando el metodo create de eloquent
							 'letter'=>$letter_id,
							 'n_dues' => $data['n_dues'],
							 'fecha_captacion' => $date,
							 'fecha_agendamiento' => $data['fecha_agendamiento'],
							 'tipo_retiro' => $data['tipo_retiro'],
							 'horario' => $data['jornada'],
							 'rut' => $data['rut'],
							 'fono_1' => $data['fono_1'],
							 'nombre' => $data['nombre'],
							 'apellido' => $data['apellido'],
							 'direccion' => $direccion,
							 'comuna' => $comuna->comuna,
							 'region' =>$region,
							 'correo_1' => $data['correo_1'],
							 'monto' => $data['monto'],
							 'teleoperador' => $data['teleoperador'],
							 'originalTeo'=>$data['teleoperador'],
							 'nom_campana' => $data['nom_campana'],
							 'fundacion' => $data ['fundacion'],
							 'observaciones' => $data['observaciones'],
							 'forma_pago' => $data['forma_pago'],
							 // 'cuenta_movistar' => $data['c_movistar'],
						 ]);
			 /**Segunda Parte
					 en esta parte vemo a que numero de llamado corresponde  y asignamos variables para posteriormente agregar el estado donde corresponda
			 */
			 $id = $request->id_captacion;
			 //tomamos el id de captacion y con eso luego tomamos el valor del primer y el segundo llamado
			 $llamado1 = captaciones::where('id', '=', $id)->pluck('primer_llamado');//tomamos el valor del primer llamado
			 $llamado2 = captaciones::where('id', '=', $id)->pluck('segundo_llamado');//tomamos el valor del segundo llamado

			 if ($llamado1 == null) {//si llamado1 es nulo o vacio
					 $name_status = 'estado_llamada1';//agregamos el estado en el campo promer llamado
					 $f_llamado ='primer_llamado';
					 $n_llamado ="1";
					 $teocall="teo1";
					 $callstatus="estado1";
			 } elseif ($llamado2 == null) {//si llamado2 es nulo o vacio
					 $name_status = 'estado_llamada2';//agregamos el estado en segundo llamado
						 $f_llamado ='segundo_llamado';
						 $n_llamado ="2";
						 $teocall="teo2";
						 $callstatus="estado2";
			 } else {//si ninguna de las anteriores se cumple
					 $name_status = 'estado_llamada3';//agregamos el estado en el tercer llamado
					 $f_llamado ='tercer_llamado';
					 $n_llamado ="3";
					 $teocall="teo3";
					 $callstatus="estado3";
			 }

			 $t_retiro=$request->tipo_retiro;//guardamos en la variable t_retiro el tipo de retiro obtenido del request

			 DB::table('captaciones')//usamos el metodo update de query builder
					 ->where('id', '=', $id)//usamos where para buscar el registro que dseseamos actualizar por id
					 ->update(//usamos el metodo update y le pasamos los datos que deseamos actualizar
						 [
							 'estado_registro' => 0,//ponemos es estado de registro en 0
							 'estado' => 'cu+',//y el estado en cu+
							 'n_llamados'=> $n_llamado,
							 $f_llamado=>$date,
							 $name_status=>$t_retiro,// asignamos el nombre de estado como el tipo de retiro
							 'teoFinal'=>Auth::user()->id,
 							 $teocall=>Auth::user()->id,
 							 $callstatus=>"cu+",
						 ]);

						 $id =DB::table('estado_rutas')->insertGetId([
							 'id'=>$cap->id,
							 'primer_agendamiento' =>'no aplica',
							 'estado_primer_agendamiento' => 'no aplica',
						 ]);

	return redirect(url('teo/teoHome'));

}

 public function show($id)
  {//funcion que nos retornara una vista similar a la vista normal de agendamiento, pero dedicada exclusivamente a realizar agendamientos de regiones
		$status = estado::where('modulo', '=', 'llamado')->get();
		$f_pago = estado::where('modulo','=','pago')->get();
		$capta = captaciones::findOrFail($id);
		$minmax =maxCap::find(1);
		$comunas = CoberturaRegiones::all();

		return view('teo/agendamientoRegiones',
		['capta'=>$capta,
		'comunas'=>$comunas,
		'status'=>$status,
		'f_pago'=>$f_pago,
		'minmax'=>$minmax]);

	}

public function deliveryDaily()
{//funcion que nos retorna una vista con los agendamientos de delivery creados el dia inmediatamente anterior
	//al dia en que se ejecuta la consulta

	$dia =Carbon::now()->subDay()->format('d/m/Y');//seleccionamos el dia anterior a hoy
	$registros = CaptacionesExitosa::where('tipo_retiro','=','Acepta Delivery')//seleccionamos los agendamientos de delivery
	->where('fecha_Captacion','=',$dia)//que se realizaron el dia anterior al actual
	->get();
		$breadcrum ="Registros Delivery Obtenidos el dia ".$dia;
		return view('Delivery.deliveryDaily',//retornamos la vista
		[
			'breadcrum' =>$breadcrum,//retornamos la variable con el dia anterior para mostra en la vista
			'data'=>$registros,
		]);
}

public function deliveryHistory(){
	$registros =CaptacionesExitosa::where('tipo_retiro','=','Acepta Delivery')
	->where('estado_Captacion','=','OK')->get();
	//seleccionamos todos los deliverys en la historia que esten validados por operaciones
	$breadcrum ="Historial completo Delivery";
	$teos = user::where('perfil','=','2')->get();
	return view('Delivery.deliveryHistorie',[
		'breadcrum'=> $breadcrum,
		'data' => $registros,
		'teos' => $teos,
	]);
}

public function completeComunas()
{
	$term = Input::get('term');
	$results = array();

	$queries = DB::table('cobertura_regiones')
		->where('comuna', 'LIKE', '%'.$term.'%')->take(10)->get();
		foreach ($queries as $query )
		{
			$results[] = [ 'id' => $query->id, 'value' =>$query->comuna];

		}

		return Response::json($results);
}

public function showCobertura()
{
	//funcion que se accesa mediante ajax y nos retorna la coberura de retiros en recsa de una comuna en concreto
		$comuna = Input::Get('comuna');//obtenemos el id de la comuna desde el campo comuna enviado desde ajax
		$cobertura = CoberturaRegiones::where('comuna','=',$comuna)->get()->first();//seleccionamos la cobertura usando el metodo fid
		return Response::json($cobertura);//retoenamos la cobertura obtenida en formato json
}

public function editCobertura()
{
	$comunas = CoberturaRegiones::all();
	return view('Delivery.editCobertura',['comunas'=>$comunas]);
}

public function editCoberturaPost(Request $request)
{
//esta funcion nos permite editar la cobertura mediante una serie de validaciones realizadas a los checkbox enviados mediante el request

	$cobertura =CoberturaRegiones::find($request->comunas);
	if(Input::Get('checkbox1')){
		$cobertura->semana_1_lunes   	 ="x" ;

	}else{

		$cobertura->semana_1_lunes   	 ="" ;
	}
	if(Input::Get('checkbox2')){
		$cobertura->semana_1_martes   	 ="x" ;
	}else{
		$cobertura->semana_1_martes   	 ="" ;
	}

	if(Input::Get('checkbox3')){
		$cobertura->semana_1_miercoles   	 ="x" ;
	}else{
		$cobertura->semana_1_miercoles   	 ="" ;
	}

	if(Input::Get('checkbox4')){
		$cobertura->semana_1_jueves   	 ="x" ;
	}else{
		$cobertura->semana_1_jueves   	 ="" ;
	}

	if(Input::Get('checkbox5')){
		$cobertura->semana_1_viernes   	 ="x" ;
	}else{
		$cobertura->semana_1_viernes   	 ="" ;
	}
//fin semana 1

if(Input::Get('checkbox6')){
	$cobertura->semana_2_lunes   	 ="x" ;
}else{
	$cobertura->semana_2_lunes   	 ="" ;
}
if(Input::Get('checkbox7')){
	$cobertura->semana_2_martes   	 ="x" ;
}else{
	$cobertura->semana_2_martes   	 ="" ;
}

if(Input::Get('checkbox8')){
	$cobertura->semana_2_miercoles   	 ="x" ;
}else{
	$cobertura->semana_2_miercoles   	 ="" ;
}

if(Input::Get('checkbox9')){
	$cobertura->semana_2_jueves   	 ="x" ;
}else{
	$cobertura->semana_2_jueves   	 ="" ;
}

if(Input::Get('checkbox10')){
	$cobertura->semana_2_viernes   	 ="x" ;
}else{
	$cobertura->semana_2_viernes   	 ="" ;
}
//fin semana 2

if(Input::Get('checkbox11')){
	$cobertura->semana_3_lunes   	 ="x" ;
}else{
	$cobertura->semana_3_lunes   	 ="" ;
}
if(Input::Get('checkbox12')){
	$cobertura->semana_3_martes   	 ="x" ;
}else{
	$cobertura->semana_3_martes   	 ="" ;
}

if(Input::Get('checkbox13')){
	$cobertura->semana_3_miercoles   	 ="x" ;
}else{
	$cobertura->semana_3_miercoles   	 ="" ;
}

if(Input::Get('checkbox14')){
	$cobertura->semana_3_jueves   	 ="x" ;
}else{
	$cobertura->semana_3_jueves   	 ="" ;
}

if(Input::Get('checkbox15')){
	$cobertura->semana_3_viernes   	 ="x" ;
}else{
	$cobertura->semana_3_viernes   	 ="" ;
}
//fin semana 3

if(Input::Get('checkbox16')){
	$cobertura->semana_4_lunes   	 ="x" ;
}else{
	$cobertura->semana_4_lunes   	 ="" ;
}
if(Input::Get('checkbox17')){
	$cobertura->semana_4_martes   	 ="x" ;
}else{
	$cobertura->semana_4_martes   	 ="" ;
}

if(Input::Get('checkbox18')){
	$cobertura->semana_4_miercoles   	 ="x" ;
}else{
	$cobertura->semana_4_miercoles   	 ="" ;
}

if(Input::Get('checkbox19')){
	$cobertura->semana_4_jueves   	 ="x" ;
}else{
	$cobertura->semana_4_jueves   	 ="" ;
}

if(Input::Get('checkbox20')){
	$cobertura->semana_4_viernes   	 ="x" ;
}else{
	$cobertura->semana_4_viernes   	 ="" ;
}
//fin semana 4
		$cobertura->save();
	return redirect('/ope/edit/cobertura');
}

	public function edit($id)
	{
		$registro = CaptacionesExitosa::find($id);
		$breadcrum ="Detalle Delivery ".$registro->nombre." ".$registro->apellido;
		return view('Delivery.detailsDelivery',
		[
			'breadcrum'=>$breadcrum,
			'data'=>$registro,
		]);
	}
	public function addMdtDely($id){
		$data = CaptacionesExitosa::find($id);
		$data->estado_mandato ="OK";
		$data->save();
		if($data->estado_mandato =="OK")
		{
			Session::flash('message','Mandato Recepcionado con exito');
		}else{

			Session::flash('message','Error Al Recepcionar el Mandato');
		}
		return redirect('ope/dely/'.$id.'/edit');
	}


public function filtroDeliveryHistory($id, $date){
	$user = user::find($id);
	$breadcrum ="Historial Delivery Filtrado por ".$user->name." ".$user->last_name." Con Fecha de Retiro ".$date;

	$registros =CaptacionesExitosa::where('tipo_retiro','=','Acepta Delivery')
	->where('estado_Captacion','=','OK')
	->where('teleoperador','=',$id)
	->where('fecha_agendamiento','=',$date)->get();
	//seleccionamos todos los deliverys en la historia que esten validados por operaciones

	$teos = user::where('perfil','=','2')->get();
	return view('Delivery.deliveryHistorie',[
		'breadcrum'=> $breadcrum,
		'data' => $registros,
		'teos' => $teos,
	]);
}




}
