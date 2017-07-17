<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\captaciones;
use App\CaptacionesExitosa;
use Illuminate\Http\Request;
use DB;


class TeoController extends Controller {


	public function index()
	{
		//
		$cap= captaciones::where('id','>=', 1 )->where('id','<=', 1000)->simplepaginate('1');
        
		return view('teo/teoin', compact('cap'));
		
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create($id,$id_interno_dues)
	{
		  /*$c=  DB::table('captaciones')
            ->join('captaciones_exitosas', 'captaciones.id', '=', 'captaciones_exitosas.id')
			->where('captaciones_exitosas.n_interno_dues','=', $id_interno_dues)
            ->get();*/
			
			$c = DB::table('captaciones_exitosas')
		    ->where('n_dues','=', $id_interno_dues)->get();
			
		    $capta = captaciones::findOrFail($id);
	    
		return view('teo/mandatoRegistrado',compact('capta'),compact('c'));
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
	

}
