<?php namespace App\Http\Controllers;

use App\estadoRuta;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\CaptacionesExitosa;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use DB;

use Illuminate\Http\Request;

class RutasController extends Controller {

	public function index()
	{
		$hoy = Carbon::now()->format('Y-m-d');
		$cap =CaptacionesExitosa::where('rutero','=',Auth::user()->name)->where('estado_captacion','=','OK')
			//->where('fecha_agendamiento','=',$hoy)
		->get();
		
	
			return view('rutas/rutasDiarias',compact('cap'));
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
				'updated_at'=>$hoy

			]);
        if($estado=="noRetirado"){
			if($motivo !="retracta"){
				$reagendar->reagendar=1;
				$reagendar->save();
			}else{
				$reagendar->reagendar=5;
				$reagendar->estado_mandato="retracta";
				$reagendar->save();
			}
		}
		
		
		
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
				'updated_at'=>$hoy

			]);
		if($estado=="noRetirado"){
			if($motivo !="retracta"){
				$reagendar->reagendar=1;
				$reagendar->save();
			}else{
				$reagendar->reagendar=5;
				$reagendar->estado_mandato="retracta";
				$reagendar->save();
			}

		}
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
				'updated_at'=>$hoy

			]);

		if($estado=="noRetirado"){
			$reagendar =CaptacionesExitosa::find($id);
			$reagendar->reagendar=5;
			$reagendar->estado_mandato="AgendamientoFallido";
			$reagendar->save();
		}
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


	public function edit($id)
	{
		//
	}


	public function update($id)
	{
		//
	}


	public function destroy($id)
	{
		//
	}
/**DOCUMENTACION RUTAS CONTROLLER
 *
 *
 */
}
