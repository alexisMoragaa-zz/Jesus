<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\captaciones;
use App\CaptacionesExitosa;
use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;
use App\estado;




class TeoController extends Controller {


	public function index()
	{
		$date=Carbon::now()->format('d-m-Y');

		$cap= captaciones::where('id','>=', 1 )->where('estado','!=','cu-')->first();// ->where('estado_registro','=',0)->where('f_ultimo_llamado','!=',$date)->first();

      DB::table('captaciones')
			->where('id', '=', $cap->id)
			->update([
				'estado_registro'=>1
			]);

		$status= estado::where('modulo','=','llamado')->get();

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
		 /** $c=  DB::table('captaciones')
            ->join('captaciones_exitosas', 'captaciones.id', '=', 'captaciones_exitosas.id')
			->where('captaciones_exitosas.n_interno_dues','=', $id_interno_dues)
            ->get();
			
			$c = DB::table('captaciones_exitosas')
		    ->where('n_dues','=', $id_interno_dues)->get();
			*/
		    $capta = captaciones::findOrFail($id);
	    
		return view('teo/mandatoRegistrado',compact('capta'));
	}

	
	public function store(Request $request)
	{
			$data = $request->all();
			
			CaptacionesExitosa::create([
				'n_dues' => $data['n_dues'],
				'id_fundacion' => $data['id_fundacion'],
				'fecha_captacion'=> $data['fecha_captacion'],
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

			
		]);
	
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
       
        $capta->monto_original = $request->monto_original;	
        $capta->monto_aporte = $request->monto_aporte;
        $capta->monto_final = $request->monto_final;
        $capta->estado = $request->estado;	
        $capta->fecha_volver_allamar = $request->fecha_volver_allamar;	
        $capta->mensaje = $request->mensaje;	
        $capta->observacion = $request->observacion;
		$capta->n_llamados = $request->n_llamados;
		$capta->fecha_primer_llamado = $request->fecha_primer_llamado;
		$capta->fecha_segundo_llamado = $request->fecha_segundo_llamado;
		$capta->fecha_tercer_llamado = $request->fecha_tercer_llamado;
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
