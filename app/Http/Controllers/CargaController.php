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
					$captaciones_dues=captaciones::where("n_dues","=",$fila->n_dues)->first();
					if(count( $captaciones_dues)==0){
						$captaciones = new captaciones;
						$captaciones -> campana           = $fila -> campana;
						$captaciones -> nom_fundacion     = $fila -> nom_fundacion;
						$captaciones -> estado_registro   = $fila -> estado_registro;
						$captaciones -> n_dues            = $fila -> n_dues;
						$captaciones -> id_fundacion      = $fila -> id_fundacion;
						$captaciones -> fono_1            = $fila -> fono_1;
						$captaciones -> fono_2            = $fila -> fono_2;
						$captaciones -> fono_3            = $fila -> fono_3;
						$captaciones -> fono_4            = $fila -> fono_4;
						$captaciones -> nombre            = $fila -> nombre;
						$captaciones -> apellido          = $fila -> apellido;
						$captaciones -> correo_1          = $fila -> correo_1;
						$captaciones -> correo_2          = $fila -> correo_2;
						$captaciones -> firma_inscripcion = $fila -> firma_inscripcion;
						$captaciones -> otro_antecedente  = $fila -> otro_antecedente;
						$captaciones -> monto             = $fila -> monto;
						$captaciones -> estado            = $fila -> estado;
						$captaciones -> volver_llamar     = $fila -> volver_llamar;
						$captaciones -> mensaje           = $fila -> mensaje;
						$captaciones -> observacion       = $fila -> observacion;
						$captaciones -> primer_llamado    = $fila -> primer_llamado;
						$captaciones -> segundo_llamado   = $fila -> segundo_llamado;
						$captaciones -> tercer_llamado    = $fila -> tercer_llamado;
						$captaciones -> save();
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
