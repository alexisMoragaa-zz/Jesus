<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Excel;
use Illuminate\Http\Request;
use Storage;
use App\captaciones;
use Illuminate\Support\Facades\Session;

class CargaController extends Controller {


	public function index()
	{
		return view('admin/cargaExcel');
	}


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
						$captaciones -> nom_fundacion     = $fila -> fundacion;
						$captaciones -> estado_registro   = '0';
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
						$captaciones -> volver_llamar     = $fila -> volver_llamar;
						$captaciones -> observacion       = $fila -> observacion;
						$captaciones -> f_ultimo_llamado  = '00-00-00';
						$captaciones -> save();
					}
				});
			});
		}

		return view('admin/cargaExcel')->with('campa�a agregada con exito');

	}


	public function create()
	{

		return('funcion store');
	}


	public function store()
	{


	}


	public function show($id)
	{

	}


	public function edit($id)
	{

	}


	public function update($id)
	{

	}


	public function destroy($id)
	{

	}

}
