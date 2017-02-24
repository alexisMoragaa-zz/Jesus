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
		    ->where('n_interno_dues','=', $id_interno_dues)->get();
			
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
			'n_interno_dues' => $data['n_interno_dues'],
			'id_interno_funda' => $data['id_interno_funda'],
			'origen'=> $data['origen'],
			'fono1' => $data['fono1'],
			'fono2' => $data['fono2'],
			'fono3' => $data['fono3'],
			'fono4'=> $data['fono4'],
			'nombre'=> $data['nombre'],
			'apellido'=> $data['apellido'],
			'correo1' => $data['correo1'],
			'correo2'=> $data['correo2'],
			'fecha_firma_inscripcion' => $data['fecha_firma_inscripcion'],
			'otro_antecedente' => $data['otro_antecedente'],
			'monto_original' => $data['monto_original'],
			'monto_aporte'=> $data['monto_aporte'],
			'monto_final' => $data['monto_final'],
			'estado' => $data['estado'],
			'fecha_volver_allamar' => $data['fecha_volver_allamar'],
			'mensaje'=> $data['mensaje'],
			'observacion' => $data['observacion'],			
			'n_llamados' => $data['n_llamados'],
			'fecha_primer_llamado' => $data['fecha_primer_llamado'],
			'fecha_segundo_llamado'=> $data['fecha_segundo_llamado'],
			'fecha_tercer_llamado' => $data['fecha_tercer_llamado'],			
			
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
