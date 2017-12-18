<?php namespace App\Http\Controllers;

use App\estadoRuta;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\CaptacionesExitosa;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use DB;
use App\informeRuta;
use Storage;
use Illuminate\Http\Request;

class RutasController extends Controller {

	public function index()
	{
		$hoy = Carbon::now()->format('Y-m-d');
		$cap =CaptacionesExitosa::where('rutero','=',Auth::user()->name)->where('estado_captacion','=','OK')
		->where('estado_mandato','=',"")
			//->where('fecha_agendamiento','=',$hoy)
			->orderBy('horario')
			->get();
				return view('rutas/rutasDiarias',compact('cap'));

	/**Tomatos los agendamientos correspondiemtes al dia actual, lo filtramos por el rutero logeado
	*por estado de captacion ok, lo ordenamos pro horario y lo retornamos a la vista
	*/
	}


	public function create(Request $request)
	{

		return view('');
	}



	public function store(Request $request)
	{
		$hoy = Carbon::now()->format('Y-m-d');
		$estado =$request->Status;
		$motivo =$request->Motivo;
		$observacion =$request->observacion;
		$id =$request->id;
		$reagendar =CaptacionesExitosa::find($id);

		DB::table('estado_rutas')
			->where('id','=',$id)
			->update([
				'estado_primer_agendamiento'=>$estado,
				'detalle_primer_agendamiento'=>$motivo,
				'observacion_primer_agendamiento'=>$observacion,
				'estado'=>$estado,
				'updated_at'=>$hoy

			]);
		$imagen_ruta="";
    if($estado=="noRetirado"){

					$img = $this->validate($request,[
					'file'=>'required|image'
				]);
				//obtenemos el campo file definido en el formulario
					$file = $request->file('file');
					$nombre=$reagendar->nombre.$reagendar->apellido."visita01.jpg";
				//indicamos que queremos guardar un nuevo archivo en el disco local
					$imagen_ruta  = "../storage/app/".$nombre;
					$ti=Storage::disk('local')->put($nombre, \File::get($file));

				if($motivo !="retracta"){

				$reagendar->reagendar=1;
				$reagendar->save();
			}else{
				$reagendar->reagendar=5;
				$reagendar->estado_mandato="retracta";
				$reagendar->save();
			}
		}



			$ruta =informeRuta::where('id_captacion','=',$request->id)->where('num_retiro','=',1)->get()->first();
			$ruta->estado =$estado;
			$ruta->imagen=$imagen_ruta;
			$ruta->motivo=$motivo;
			$ruta->save();


			if(Auth::user()->perfil==5){
				return redirect(route('rutas.rutas.index'));
			}else if(Auth::user()->perfil==1){
				return redirect(route('admin.rutas.index'));
			}

	}

	public function addSecondRoute(Request $request){
		$hoy = Carbon::now()->format('Y-m-d');
		$estado =$request->Status;
		$motivo =$request->Motivo;
		$observacion =$request->observacion;
		$id =$request->id;
		$reagendar =CaptacionesExitosa::find($id);

		DB::table('estado_rutas')
			->where('id','=',$id)
			->update([
				'estado_segundo_agendamiento'=>$estado,
				'detalle_segundo_agendamiento'=>$motivo,
				'observacion_segundo_agendamiento'=>$observacion,
				'estado'=>$estado,
				'updated_at'=>$hoy

			]);
$imagen_ruta="";
		if($estado=="noRetirado"){
					$img = $this->validate($request,[
					'file'=>'required|image'
					]);
					//obtenemos el campo file definido en el formulario
					$file = $request->file('file');
					$nombre=$reagendar->nombre.$reagendar->apellido."visita02.jpg";
					//indicamos que queremos guardar un nuevo archivo en el disco local
					$imagen_ruta  = "../storage/app/".$nombre;
					$ti=Storage::disk('local')->put($nombre, \File::get($file));

			if($motivo !="retracta"){
				$reagendar->reagendar=1;
				$reagendar->save();
			}else{
				$reagendar->reagendar=5;
				$reagendar->estado_mandato="retracta";
				$reagendar->save();
			}
		}



	$ruta =informeRuta::where('id_captacion','=',$request->id)->where('num_retiro','=',2)->get()->first();
		$ruta->estado =$estado;
		$ruta->imagen=$imagen_ruta;
		$ruta->motivo=$motivo;
		$ruta->save();

		if(Auth::user()->perfil==5){
			return redirect(route('rutas.rutas.index'));
		}else if(Auth::user()->perfil==2){
			return redirect(route('admin.rutas.index'));
		}

	}

	public function addThirdRoute(Request $request){
		$hoy = Carbon::now()->format('Y-m-d');
		$estado =$request->Status;
		$motivo =$request->Motivo;
		$observacion =$request->observacion;
		$id =$request->id;

		DB::table('estado_rutas')
			->where('id','=',$id)
			->update([
				'estado_tercer_agendamiento'=>$estado,
				'detalle_tercer_agendamiento'=>$motivo,
				'observacion_tercer_agendamiento'=>$observacion,
				'estado'=>$estado,
				'updated_at'=>$hoy

			]);
			$imagen_ruta="";
		if($estado=="noRetirado"){

					$img = $this->validate($request,[
					'file'=>'required|image'
				]);
					//obtenemos el campo file definido en el formulario
					$file = $request->file('file');
					$nombre=$reagendar->nombre.$reagendar->apellido."visita02.jpg";
					//indicamos que queremos guardar un nuevo archivo en el disco local
					$imagen_ruta  = "../storage/app/".$nombre;
					$ti=Storage::disk('local')->put($nombre, \File::get($file));

			$reagendar =CaptacionesExitosa::find($id);
			$reagendar->reagendar=5;
			$reagendar->estado_mandato="AgendamientoFallido";
			$reagendar->save();
		}

		$ruta =informeRuta::where('id_captacion','=',$request->id)->where('num_retiro','=',3)->get()->first();
			$ruta->estado =$estado;
			$ruta->imagen=$imagen_ruta;
			$ruta->motivo=$motivo;
			$ruta->save();

		if(Auth::user()->perfil==5){
			return redirect(route('rutas.rutas.index'));
		}else if(Auth::user()->perfil==1){
			return redirect(route('admin.rutas.index'));
		}

	}


	public function show($id)
	{
		//
		$hoy = Carbon::now()->format('Y-m-d');
		$ruta =CaptacionesExitosa::find($id);
		$esta = estadoRuta::find($id);
		$est=$esta->updated_at->format('Y-m-d');



		return view('rutas/DetalleRutasDiarias',compact('ruta','est','hoy','esta'));
	}


	public function historialRutas(){
		$hoy = Carbon::now()->format('Y-m-d');
		$ruta = CaptacionesExitosa::where('rutero','=',Auth::user()->name)->where('fecha_agendamiento','<=',$hoy)
		->orderBy('fecha_agendamiento')->get();

		return view('rutas.historialRutas',['rutas'=>$ruta]);
	}

	public function historialFiltrado(Request $request){

		$dia = $request->dia;
		$estado =$request->estado;


		if($estado !=""){

			if($dia !=""){
				if($estado ==1){
					$filtro = "Rutas Exitosas El Dia ".$dia;
					$ruta =CaptacionesExitosa::where('estado_mandato','=','OK')->where('fecha_agendamiento','=',$dia)->get();
					return view('rutas.historialRutas',['rutas'=>$ruta,'filtro'=>$filtro]);
				}elseif($estado ==2){
					$filtro = "Rutas Rechazadas Dia ".$dia;
					$ruta =CaptacionesExitosa::where('estado_mandato','=','rechazado')->where('fecha_agendamiento','=',$dia)->get();
					return view('rutas.historialRutas',['rutas'=>$ruta,'filtro'=>$filtro]);
				}

			}else{
				if($estado==1){
					$filtro = "Rutas Exitosas";
					$ruta = CaptacionesExitosa::where('estado_mandato', '=', 'OK')->get();
					return view('rutas.historialRutas',['rutas'=>$ruta,'filtro'=>$filtro]);
				}elseif($estado ==2){
					$filtro = "Rutas Rechazadas";
					$ruta = CaptacionesExitosa::where('estado_mandato', '=', 'retracta')->orWhere('estado_mandato', '=', 'AgendamientoFallido')->get();
					return view('rutas.historialRutas',['rutas'=>$ruta,'filtro'=>$filtro]);
				}

			}

		}else{
			$filtro = "Rutas Dia ".$dia;
			$ruta =CaptacionesExitosa::where('fecha_agendamiento','=',$dia)->get();
			return view('rutas.historialRutas',['rutas'=>$ruta,'filtro'=>$filtro]);
		}




	}

	public function detalleRuta($id){

		$ruta = CaptacionesExitosa::findOrFail($id);
		$img1 = informeRuta::where('id_captacion','=',$id)->where('num_retiro','=',1)->get()->first();
		$img2 = informeRuta::where('id_captacion','=',$id)->where('num_retiro','=',2)->get()->first();
		$img3 = informeRuta::where('id_captacion','=',$id)->where('num_retiro','=',3)->get()->first();
		return view('rutas.detalleRuta',[
			'reage'=>$ruta,
			'img1'=>$img1,
			'img2'=>$img2,
			'img3'=>$img3,
		]);
	}




/**DOCUMENTACION RUTAS CONTROLLER
 *
 *
 */
}
