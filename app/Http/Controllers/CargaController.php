<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Excel;
use Illuminate\Http\Request;
use Storage;
use App\captaciones;
use Illuminate\Support\Facades\Session;

class CargaController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return view('admin/cargaExcel');
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */


	public function form_cargar_datos(){
		return view('admin/cargaExcel');
	}

	public function cargar_datos(Request $request)
	{
		$archivo = $request->file('archivo');
		$nombre_original=$archivo->getClientOriginalName();
		$extension=$archivo->getClientOriginalExtension();
		$r1=Storage::disk('archivos')->put($nombre_original,  \File::get($archivo) );
		$ruta  =  storage_path('archivos') ."/". $nombre_original;

		if($r1){
			$ct=0;
			Excel::selectSheetsByIndex(0)->load($ruta, function($hoja) {

				$hoja->each(function($fila) {
					$captaciones_dues=captaciones::where("n_interno_dues","=",$fila->n_interno_dues)->first();
					if(count( $captaciones_dues)==0){
						$captaciones=new captaciones;
						$captaciones->n_interno_dues= $fila->n_interno_dues;
						$captaciones->id_interno_funda= $fila->id_interno_funda;
						$captaciones->origen= $fila->origen;
						$captaciones->fono1= $fila->fono1;
						$captaciones->fono2= $fila->fono2;
						$captaciones->fono3= $fila->fono3;
						$captaciones->fono4= $fila->fono4;
						$captaciones->nombre= $fila->nombre;
						$captaciones->apellido=$fila->apellido;
						$captaciones->correo1=$fila->correo1;
						$captaciones->correo2=$fila->correo2;
						$captaciones->fecha_firma_inscripcion=$fila->fecha_firma_inscripcion;
						$captaciones->otro_antecedente= $fila->otro_antecedente;
						$captaciones->monto_original= $fila->monto_original;
						$captaciones->monto_aporte= $fila->monto_aporte;
						$captaciones->monto_final= $fila->monto_final;
						$captaciones->estado= $fila->estado;
						$captaciones->fecha_volver_allamar=$fila->fecha_volver_allamar;
						$captaciones->mensaje=$fila->mensaje;
						$captaciones->observacion=$fila->observacion;
						$captaciones->fecha_primer_llamado=$fila->fecha_primer_llamado;
						$captaciones->fecha_segundo_llamado=$fila->fecha_segundo_llamado;
						$captaciones->fecha_tercer_llamado=$fila->fecha_tercer_llamado;
						$captaciones->save();
					}

				});

			});



		}

		return view('admin/cargaExcel')->with('campaña agregada con exito');



	}


	public function create()
	{
		//
		return('funcion store');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//

	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
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
