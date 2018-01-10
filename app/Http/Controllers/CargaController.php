<?php namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use App\Http\Requests;
use Storage;
use Excel;
use App\captaciones;
use App\fundacion;
use App\Campana;
use App\Letter;
use App\User;

class CargaController extends Controller {

	public function index()
	{

	}

	public function form_cargar_datos(){
		//funcion que retorna la vista que suaremos para cargar nuestros archivos excel
		$fundaciones = fundacion::where('id','!=',1)->get();//seleccionamos todas las fundaciones
		return view('admin/cargaExcel',[//retornamos la vista con las fundaciones
			'fundaciones'=>$fundaciones,
		]);
	}

	public function cargar_datos(Request $request)
	{//funcion que inserta los datos de una hoja excel en la base de datos
		$fundaciones = fundacion::all();//seleccionamos todas las fundaciones
		$archivo = $request->file('archivo');//seleccionamos el archivo de nuestro request
		$nombre_original=$archivo->getClientOriginalName();//obtenemos el nombre del archivo
		$extension=$archivo->getClientOriginalExtension();//obtenemos la extencion del archivos
		$r1=Storage::disk('archivos')->put($nombre_original,  \File::get($archivo) );//guardamos el archivo en un disco local
		$ruta  =  storage_path('archivos') ."/". $nombre_original;//guardamos la ruta en la cual se encuentra guardado nuestro archivo

		$foundation = $request->foundation;//tomamos la fundacion a la cuel pertenecen estos registros desde el request
		$campana = $request->campanas;//tomaos la campaña a la cual perteneceran estos registros desde el request
		if($r1){//si el archivo se guarda correctamente  ejecutamos el siguiente bloque de codigo
			$registros_campana  = Campana::find($campana);
			if($registros_campana->registrosCampana->count() == 0){

			Excel::selectSheetsByIndex(0)->load($ruta, function($hoja) use($foundation,$campana) {

				$hoja->each(function($fila) use($foundation,$campana) {

					if($fila->n_dues != null){
						$captaciones = new captaciones;//por cada fila de nuestro archivo excel creamos una instancia de captacion

						$captaciones -> fundacion      		= $foundation;//asignamos los valores para cada instancia
						$captaciones -> campana_id        =$campana;//ya sean valores provenientes de nuestro archivo excel
						$captaciones -> estado_registro   = '0';//o como en el caso de fundacion y campana id de el request
						$captaciones -> n_dues            = $fila -> n_dues;//asi como tambien otros valores como estado o
						$captaciones -> id_fundacion      = $fila -> id_fundacion;//fecha ultimo llamado los cuales son
						$captaciones -> fono_1            = $fila -> fono_1;//valores estaticos y no varian en ninguna campaña
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
		}else{
				Session::flash('message', 'Error! los registros de la campaña '.' '.$registros_campana->nombre_campana.' '.' Ya fueron agregados previamente');
				return view('admin/cargaExcel',[
					'fundaciones'=>$fundaciones,
				]);
		}

	}
	Session::flash('success', 'Felicidades! los registros de la campaña '.' '.$registros_campana->nombre_campana.' '.' Fueron agregados Con Exito');

		return view('admin/cargaExcel',[
			'fundaciones'=>$fundaciones,
			]);

	}

public function byFoundation($id){
	//esta funcion nos retorna las campañas que pertenecena una fundacion para cargar_datos
	//un select anidado en la vista mediante una peticion AJAX
	return Campana::where('fundacion','=',$id)->get();//retornamos la coleccion
}



public function exportLetter($id){
		/*Esta funcion exporta la carga seleccionada a un archivo excel con los $datos
		respectivos a la carta seleccionada */
		$let = Letter::find($id);//seleccionamos la carte correspondiente al id enviado como parametro

		Excel::create('Fundacion '.$let->letterByFoundation->nombre.' Carta 0'.$let->number, function($excel) use($let) {
		//creamos el archivo de excel y le asignamos el nombre, en este caso suamos el nombre de la fundacion mas el numero de carta para nombrar el archivo
			$excel->sheet('carta '.$let->number, function($sheet) use($let){
				//creamos la hoja de excel y le asignamos el nombre, en este caso usamos el numero de la carta como nombre para la hoja
				//header

					/*en el header le damos estilos a las celdas que componen la cabecera de nuestr archivo excel*/
					$sheet->row(2,['','','','Entrega de Documentos',]);//textos que componen el header del documento
					$sheet->cell('D2',function($cell){
						$cell->setAlignment('center');//estilos para el header del documento
						$cell->setFontSize('12');
						$cell->setFontWeight('bold');
						$cell->setFontFamily('Calibri');
					});

					$sheet->mergeCells('C3:E3');//fucionamos las celdas desde c3 a e3
					$sheet->row(3,['','',$let->letterByFoundation->nombre]);//nombre de la fundacion
					$sheet->cell('C3',function($cell){
						$cell->setAlignment('center');//estilos para el nombre de la fundacion
						$cell->setFontSize('28');
						$cell->setFontWeight('bold');
						$cell->setFontFamily('Calibri');
					});

					$sheet->row(5,['','Fecha',$let->fecha_entrega,'','','Carta ',' 0'.$let->number]);//fecha de entrega y numero de carta
					$sheet->setBorder('B5:C5','medium');//añadimos los bordes para fecha de entrega
					$sheet->setBorder('F5:G5','medium');//añadimos los border para numero de carta

					$sheet->cells('B5:G5',function($cells){ //Asignamos estilos en negrita para la fila 5 que contiene fecha de entrega y numero de carta
						$cells->setFontWeight('bold');
					});

					$sheet->cells('B7:G7',function($cells){//asignamos estilos de negrita y texto centrado para la fila 7 que contiene
						$cells->setFontWeight('bold');//los titulos de la data correspondiente a la carta
						$cells->setAlignment('center');
					});
					$sheet->row(7,['','Rut','Nombre','Apellidos','Campaña','Medio Aporte','Monto']);//asignamos los titulos en la fila 7
				//fin Header

				//data

				/* en la data agregamos la informacion de obtenida mediante las consultas sql realizadas a la base de datos con eloquent*/
				$data=[];//creamos un nuevo arreglo vacio al cual le concatenaremos el arreglo row con la data, de esta forma creamos una matriz con la data
				$i =0;//asignamos un contador para asignar las filas en la data
				foreach ($let->mandatesByLetter as $mandates){//recorremos la data obtenida atravez de la relacion
					$row=[];//creamos el arregklo row para obtener los valores de la data
					$row[0] = "     ";//dejamos el primer campo en blanco para darnos espacio al borde izquierdo
					$row[1] = $mandates->rut;//agregamos los campos a una posicion del arreglo
					$row[2] = $mandates->nombre;
					$row[3] = $mandates->apellido;
					$row[4] = $mandates->nom_campana;
					$row[5] = $mandates->forma_pago;
					$row[6] = $mandates->monto;
					$data[] = $row;//una vez recorrido el primer ciclo concatenamos con append el valor de row a nuestro arreglo Data
					//de  esta forma montamos la matriz con cada iteracio del ciclo
					$sheet->appendRow($row);
					$i++;//sumamos uno al contador por cada fila que tenga la data
				}
				//Footer

				/*en el footer agragamos la informacion que esta inmediatamente despues de la data,
				y damos estilos a la data, como por ejemplo bordes que organicen el contenido de mejor forma en el
				archivo excel*/
				$i = $i+7;//le sumamos 7 filas al conteo, ya que son las filas que usa el header
				$sheet->setBorder('B7:G'.$i, 'thin');//usando el contador i definimos donde termina la data, y agregamos
				//los border hasta el final de la data

				$i = $i+1;//sumamos uno mas y agragamos un recuadro con el conteo de mandatos en la carta
				$sheet->row($i,['','','Total Mandatos',$let->mandatesByLetter->count()]);
					$sheet->setBorder('C'.$i.':D'.$i, 'medium');//usando el contador i nos posicionamos al final de la data y agregamos el recuadro
					$sheet->cells('B'.$i.':G'.$i,function($cells){//le agregamos estilos al recuadro
						$cells->setFontWeight('bold');
						$cells->setAlignment('center');
					});

				$i = $i+3; //sumamos tres a i para agregar la informacion de entrega y recibo
				$g = $i;	//Asignamos el valor inicial de i a g, y con esto podemos obtemer el principio y el final de esta seccion usando g como inicio y el valor final de i com termino
				$createdBy = User::find($let->creadaPor);//tomamos el valor de el creador de la carta y lo asignamos a createdBy para usarlo en la informacion de envio correspondente al footer
				$postMan = User::find($let->entregadaPor);//hacemos lo mismo con entregado por
				$sheet->row($i,['','ENTREGA','',$postMan->name.' '.$postMan->last_name]);
				$sheet->cells('C'.$i.':G'.$i,function($cells){//asignamos bordes en la parte inferior a la fila de entrega
					$cells->setBorder('none', 'none', 'thin', 'none');
				});

				$i = $i+2; //sumamos dos a i para agregar la informacion de entrega y recibo
				$sheet->row($i,['','RECIBIDO']);
				$sheet->cells('C'.$i.':G'.$i,function($cells){//asignamos bordes en la parte inferior a la fila de recibido
					$cells->setBorder('none', 'none', 'thin', 'none');
				});

				$i = $i+2; //sumamos dos a i para agregar la informacion de entrega y recibo
				$sheet->row($i,['','FECHA']);
				$sheet->cells('C'.$i.':G'.$i,function($cells){//asignamos bordes en la parte inferior a la fila de fecha
					$cells->setBorder('none', 'none', 'thin', 'none');
				});

				$i = $i+2; //sumamos dos a i para agregar la informacion de entrega y recibo
				$sheet->row($i,['','FIRMA']);
				$sheet->cells('C'.$i.':G'.$i,function($cells){//asignamos bordes en la parte inferior a la fila de firma
					$cells->setBorder('none', 'none', 'thin', 'none');
				});

				$i = $i+3; //sumamos tres a i para agregar la informacion de entrega y recibo
				$sheet->row($i,['','PREPARADO POR','',$createdBy->name.' '.$createdBy->last_name,'','DUES LTDA']);
				//agragamos la informacion de la persona que creo la carta

				$sheet->cells('B'.$g.':G'.$i,function($cells){//seleccionamos como bold todo el cuadro 	que comprende la informacion del footer
					$cells->setFontWeight('bold');
				});
				$sheet->cells('C'.$g.':G'.$i,function($cells){//seleccionamos como center el mismo recuardo que tiene bold, exceptuando la columna b que contiene los titulos
					$cells->setAlignment('center');
				});

			});

		})->export('xlsx');//finalmente exportamos toda la data con el formato creado a un archivo xsls

	}/*Fin ExportLetter*/

public function loadCampaing(Request $request){

	$archivo = $request->file('file');//seleccionamos el archivo de nuestro request
	$nombre_original=$archivo->getClientOriginalName();//obtenemos el nombre del archivo
	$extension=$archivo->getClientOriginalExtension();//obtenemos la extencion del archivos
	$r1=Storage::disk('archivos')->put($nombre_original,  \File::get($archivo) );//guardamos el archivo en un disco local
	$ruta  =  storage_path('archivos') ."/". $nombre_original;//guardamos la ruta en la cual se encuentra guardado nuestro archivo

	$foundation = $request->foundation;//tomamos la fundacion a la cuel pertenecen estos registros desde el request
	$campana = $request->campanas;//tomaos la campaña a la cual perteneceran estos registros desde el request
	if($r1){//si el archivo se guarda correctamente  ejecutamos el siguiente bloque de codigo
		$campana  = Campana::find($campana);
		if($campana->registrosCampana->count() == 0){

		Excel::selectSheetsByIndex(0)->load($ruta, function($hoja) use($foundation,$campana) {

			$hoja->each(function($fila) use($foundation,$campana) {


					$captaciones = new captaciones;//por cada fila de nuestro archivo excel creamos una instancia de captacion
					$captaciones -> fundacion      		= $foundation;//asignamos los valores para cada instancia
					$captaciones -> campana_id        =$campana;//ya sean valores provenientes de nuestro archivo excel
					$captaciones -> estado_registro   = '0';//o como en el caso de fundacion y campana id de el request
					$captaciones -> n_dues            = $fila -> n_dues;//asi como tambien otros valores como estado o
					$captaciones -> id_fundacion      = $fila -> id_fundacion;//fecha ultimo llamado los cuales son
					$captaciones -> fono_1            = $fila -> fono_1;//valores estaticos y no varian en ninguna campaña
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

			});
		});
	}else{
		return("ya se agregaron los registros para esta campaña");
	}
	}
	$fundaciones = fundacion::all();//seleccionamos todas las fundaciones
	return view('admin/cargaExcel',[
		'fundaciones'=>$fundaciones,
		])->with('campa�a agregada con exito');



}



public function cargar_datos_safe(Request $request)
{//funcion que inserta los datos de una hoja excel en la base de datos

	$archivo = $request->file('archivo');//seleccionamos el archivo de nuestro request
	$nombre_original=$archivo->getClientOriginalName();//obtenemos el nombre del archivo
	$extension=$archivo->getClientOriginalExtension();//obtenemos la extencion del archivos
	$r1=Storage::disk('archivos')->put($nombre_original,  \File::get($archivo) );//guardamos el archivo en un disco local
	$ruta  =  storage_path('archivos') ."/". $nombre_original;//guardamos la ruta en la cual se encuentra guardado nuestro archivo

	$foundation = $request->foundation;//tomamos la fundacion a la cuel pertenecen estos registros desde el request
	$campana = $request->campanas;//tomaos la campaña a la cual perteneceran estos registros desde el request
	if($r1){//si el archivo se guarda correctamente  ejecutamos el siguiente bloque de codigo

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
					$captaciones -> fono_1            = $fila -> fono_1;//valores estaticos y no varian en ninguna campaña
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

}
