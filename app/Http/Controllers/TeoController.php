<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\captaciones;
use App\CaptacionesExitosa;
use Illuminate\Http\Request;
use DB;


class TeoController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
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

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
		//	
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

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
	 
	 

	}
	
	

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function editar($id)
	{
		//
		$capta = captaciones::findOrFail($id);
		return view('teo/modificar', compact('capta'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
    public function actualizar(Request $request,$id)
	{

		$capta = captaciones::findOrFail($id);
		$capta->fono_1 = $request->fono_1;
		$capta->fono_2 = $request->fono_2;
		$capta->nombre = $request->nombre;
		$capta->apellido = $request->apellido;
        $capta->estado = $request->estado;
        $capta->volver_llamar = $request->volver_llamar;
        $capta->observacion = $request->observacion;
		$capta->save();
		
        return view('teo/actualizado');
	} 
	 
	 


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}
	

}
