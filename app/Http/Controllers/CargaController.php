<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Excel;
use Illuminate\Http\Request;
use Storage;
use App\captaciones;
use App\fundacion;
use App\Campana;
use Illuminate\Support\Facades\Session;

class CargaController extends Controller {

	public function index()
	{

	}

	public function form_cargar_datos(){
		//funcion que retorna la vista que suaremos para cargar nuestros archivos excel
		$fundaciones = fundacion::all();//seleccionamos todas las fundaciones
		return view('admin/cargaExcel',[//retornamos la vista con las fundaciones
			'fundaciones'=>$fundaciones,
		]);
	}

	public function cargar_datos(Request $request)
	{//funcion que inserta los datos de una hoja excel en la base de datos

		$archivo = $request->file('archivo');//seleccionamos el archivo de nuestro request
		$nombre_original=$archivo->getClientOriginalName();//obtenemos el nombre del archivo
		$extension=$archivo->getClientOriginalExtension();//obtenemos la extencion del archivos
		$r1=Storage::disk('archivos')->put($nombre_original,  \File::get($archivo) );//guardamos el archivo en un disco local
		$ruta  =  storage_path('archivos') ."/". $nombre_original;//guardamos la ruta en la cual se encuentra guardado nuestro archivo

		$foundation = $request->foundation;//tomamos la fundacion a la cuel pertenecen estos registros desde el request
		$campana = $request->campanas;//tomaos la campaña a la cual perteneceran estos registros desde el request
		if($r1){//si el archivo se guarda correctamente  ejecutamos el siguiente bloque de codigo
			$ct=0;//establecemos la bariable ct o contador en 0
			Excel::selectSheetsByIndex(0)->load($ruta, function($hoja) use($foundation,$campana) {

				$hoja->each(function($fila) use($foundation,$campana) {
					$captaciones_dues=captaciones::where("n_dues","=",$fila->n_dues)->first();
					if(count( $captaciones_dues)==0){
						$captaciones = new captaciones;//por cada fila de nuestro archivo excel creamos una instancia de captacion

						$captaciones -> fundacion      		= $foundation;//asignamos los valores para cada instancia
						$captaciones -> campana_id        =$campana;//ya sean valores provenientes de nuestro archivo excel
						$captaciones -> estado_registro   = '0';//o como en el caso de fundacion y campana id de el request
						$captaciones -> n_dues            = $fila -> n_dues;//asi como tambien otros valores como estado o
						$captaciones -> id_fundacion      = $fila -> id_fundacion;//fecha ultimo llamado los cuales son
						$captaciones -> fono_1            = $fila -> fono_1;//valore estaticos y no varian en ninguna campaña
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
						$captaciones -> save();//guardamos el registro
					}
				});
			});
		}
		$fundaciones = fundacion::all();//seleccionamos todas las fundaciones
		return view('admin/cargaExcel',[
			'fundaciones'=>$fundaciones,
			])->with('campa�a agregada con exito');

	}

public function byFoundation($id){
	//esta funcion nos retorna las campañas que pertenecena una fundacion para cargar_datos
	//un select anidado en la vista mediante una peticion AJAX
	return Campana::where('fundacion','=',$id)->get();//retornamos la coleccion
}
	public function create(){


		return('funcion store');
	}


	public function store(){



	}


	public function show($id){


	}


	public function edit($id){


	}


	public function update($id){


	}


	public function destroy($id){


	}

}
