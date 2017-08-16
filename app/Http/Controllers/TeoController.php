<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\captaciones;
use App\CaptacionesExitosa;
use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;
use App\estado;
use App\Campana;
use Illuminate\Support\Facades\Auth;
use App\comunaRetiro;

class TeoController extends Controller {

	public function home(){
		
		return view('teo/teoHome');
		
	}

	public function index()
	{
		$status= estado::where('modulo','=','llamado')->get();
		$date=Carbon::now()->format('d-m-Y');
		$dato = Campana::findOrFail(Auth::user()->campana)->nombre_campana;

		$cap= captaciones::where('id','>=', 1 )
							->where('campana','=',$dato)->where('f_ultimo_llamado','!=',$date)->where('estado','!=','cu-')->where('estado','!=','cu+')->first();// ->where('estado_registro','=',0)
							//->where('f_ultimo_llamado','!=',$date)->first();


		if(empty($cap)){

			return view('teo/teoError');
		}

		DB::table('captaciones')
				->where('id', '=', $cap->id)
				->update([
				'estado_registro'=>1
				]);

		return view('teo/teoin', compact('cap','status'));

	}

	public function siguiente(Request $request, $id){

		$date=Carbon::now()->format('d-m-Y');
		$observation=$request->input('observation1');
		$call_status =$request->input('call_status');
		$call_again=$request->input('call_again');
		$type = estado::where('estado','=',$call_status)->pluck('tipo');
		$llamado1= captaciones::where('id','=',$id)->pluck('primer_llamado');
		$llamado2= captaciones::where('id','=',$id)->pluck('segundo_llamado');

		if ($llamado1 == null){
				$llamado='primer_llamado';
				$name_status='estado_llamada1';
				$n_llamado='1';

		}elseif($llamado2 == null){
			$llamado='segundo_llamado';
			$name_status='estado_llamada2';
			$n_llamado='2';

		}else{
			$llamado='tercer_llamado';
			$name_status='estado_llamada3';
			$n_llamado='3';
		}

			DB::table('captaciones')
				->where('id', '=', $id)
				->update([
					'estado_registro'=>0,
					'f_ultimo_llamado'=>$date,
					'observacion'=>$observation,
					$name_status=>$call_status,
					'estado'=>$type,
					$llamado=>$date,
					'n_llamados'=>$n_llamado,
					'volver_llamar'=>$call_again
					]);

		return redirect()->route('admin.call.index');


	}
	
	public function create($id,$id_interno_dues)
	{

			DB::table('captaciones')
				->where('id','=',$id)
				->update([
					'estado_registro'=>0,
					'estado'=>'cu+'

				]);

		    $capta = captaciones::findOrFail($id);

			$comunas = comunaRetiro::where('region','=','metropolitana')->where('ciudad','=','santiago')->get();
	    
		return view('teo/mandatoRegistrado',compact('capta','comunas'));
	}

	
	public function store(Request $request)
	{
			$data = $request->all();
			$date=Carbon::now()->format('d/m/Y');
			CaptacionesExitosa::create([
				'n_dues' => $data['n_dues'],
				'id_fundacion' => $data['id_fundacion'],
				'fecha_captacion'=> $date,
				'fecha_agendamiento' => $data['fecha_agendamiento'],
				'tipo_retiro' => $data['tipo_retiro'],
				'jornada'=> $data['jornada'],
				'horario'=> $data['horario'],
				'rut' => $data['rut'],
				'dv'=> $data ['dv'],
				'fono_1' => $data['fono_1'],
				'nombre'=> $data['nombre'],
				'apellido'=> $data['apellido'],
				'direccion'=> $data['direccion'],
				'comuna' => $data['comuna'],
				'correo_1' => $data['correo_1'],
				'monto'=> $data['monto'],
				'rutero'=> $data['rutero'],
				'teleoperador' => $data['teleoperador'],
				'nom_campana'=> $data['nom_campana'],
				'fundacion' => $data ['fundacion'],
				'observaciones' => $data['observaciones'],
				'forma_pago'=>$data['forma_pago'],
				'user_id'=>$data['teleoperador'],


			
		]);
		return view('teo/teoHome');
	
	}

	
	public function show($id)
	{
	 
	}
	
	public function editar($id)
	{
	
		$capta = captaciones::findOrFail($id);
		return view('teo/modificar', compact('capta'));
	}


    public function actualizar(Request $request,$id)
	{
		$capta = captaciones::findOrFail($id);
       
        $capta->nombre = $request->nombre;
        $capta->apellido = $request->apellido;
        $capta->fono_1 = $request->fono1;
        $capta->fono_2 = $request->fono2;
        $capta->fono_3 = $request->fono3;
        $capta->fono_4 = $request->fono4;
        $capta->correo_1 = $request->correo1;
		$capta->correo_2 = $request->correo2;

		$capta->save();
		
        return view('teo/actualizado');
	} 
	 
	
	public function destroy($id)
	{
		//
	}

	/** comentarios del controlador
	 *index:    selecciona el primer registro de la base de datos que cumpla con las condiciones establecidas en los where
			    luego inserta acontinuacion inserta un 1 en estado para vbloquear el registro a los demas usuarios. finalmente
	 * 		     envia la informacion a la vista
	 *Siguiente: toma el registro entregado por la vista, inserta un 0 para desbloquear el registro, he inserta la fecha correspondiente
	 * 		     al dia, para que de esta forma no se llamena los mismos registros el mismo dia. luego redirecciona al index y se repite el proceso
	 */

}
