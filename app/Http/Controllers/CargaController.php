<?php namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use App\Http\Requests;
use Carbon\Carbon;
use Storage;
use Excel;
use App\CaptacionesExitosa;
use App\CoberturaRegiones;
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

public function exportReportCampana($id){
	$campana = Campana::find($id);

	Excel::create('Reporte Campaña'.$campana->nombre_Campana,function($excel) use($campana){
		$excel->sheet('reporte',function($sheet)use($campana){

			$sheet->row(2,['','id','ID Fundacion','Fono 1','Fono 2','Fono 3','Fono 4','Nombre','Apellidos',
			'Correo 1','Correo 2','Firma Inscripcion','Otro Antecedente','Estado','Observacion','LLamado 1',
			'Estado llamado 1','llamado 2','Estado llamado 2','llamado 3','estado llamado 3','Fecha Ultimo Llamado','']);//asignamos los titulos en la fila 7
//establecemos los encabezados para esta hoja de excel
			$data=[];//creamos un nuevo arreglo vacio al cual le concatenaremos el arreglo row con la data, de esta forma creamos una matriz con la data
			$i =0;//asignamos un contador para asignar las filas en la data
			foreach ($campana->registrosCampana as $c){//recorremos la data obtenida atravez de la relacion
				$row=[];//creamos el arregklo row para obtener los valores de la data
				$row[0]  = "     ";//dejamos el primer campo en blanco para darnos espacio al borde izquierdo
				$row[1]  = $c->id;//agregamos los campos a una posicion del arreglo
				$row[2]  = $c->id_fundacion;
				$row[3]  = $c->fono_1;
				$row[4]  = $c->fono_2;
				$row[5]  = $c->fono_3;
				$row[6]  = $c->fono_4;
				$row[7]  = $c->nombre;
				$row[8]  = $c->apellido;
				$row[9]  = $c->correo_1;
				$row[10] = $c->correo_2;
				$row[11] = $c->firma_inscripcion;
				$row[12] = $c->otro_antecedente;
				$row[13] = $c->estado;
				$row[14] = $c->observacion;
				$row[15] = $c->primer_llamado;
				$row[16] = $c->estado_llamada1;
				$row[17] = $c->segundo_llamado;
				$row[18] = $c->estado_llamada2;
				$row[19] = $c->tercer_llamado;
				$row[20] = $c->estado_llamada3;
				$row[21] = $c->f_ultimo_llamado;
				$data[] = $row;//una vez recorrido el primer ciclo concatenamos con append el valor de row a nuestro arreglo Data
				//de  esta forma montamos la matriz con cada iteracio del ciclo
				$sheet->appendRow($row);
				$i++;//sumamos uno al contador por cada fila que tenga la data
			}

		});
		$excel->sheet('Detalle',function($sheet) use($campana){
			//creamos una segunda hoja de excel en donde tendremos el detalle de el reporte
			//Agendamientos en santiago    contamos los registros de agendamiento en los tres instancias de llamadas
			$s1 = Captaciones::where('campana_id','=',$campana->id)->where('estado_llamada1','=','Acepta Agendamiento')->count();
			$s2 = Captaciones::where('campana_id','=',$campana->id)->where('estado_llamada2','=','Acepta Agendamiento')->count();
			$s3 = Captaciones::where('campana_id','=',$campana->id)->where('estado_llamada3','=','Acepta Agendamiento')->count();
			$santiago = $s1+$s2+$s3;
			//Grabaciones  contamos los registros de grabacion en los tres instancias de llamadas
			$g1 = Captaciones::where('campana_id','=',$campana->id)->where('estado_llamada1','=','Acepta Grabacion')->count();
			$g2 = Captaciones::where('campana_id','=',$campana->id)->where('estado_llamada2','=','Acepta Grabacion')->count();
			$g3 = Captaciones::where('campana_id','=',$campana->id)->where('estado_llamada3','=','Acepta Grabacion')->count();
			$grabacion = $g1+$g2+$g3;

			//delivery   contamos los registros de delivery en los tres instancias de llamadas
			$d1 = Captaciones::where('campana_id','=',$campana->id)->where('estado_llamada1','=','Acepta Delivery')->count();
			$d2 = Captaciones::where('campana_id','=',$campana->id)->where('estado_llamada2','=','Acepta Delivery')->count();
			$d3 = Captaciones::where('campana_id','=',$campana->id)->where('estado_llamada3','=','Acepta Delivery')->count();
			$delivery = $d1+$d2+$d3;

			//CHILEXPRESS    contamos los registros de chilexpress en los tres instancias de llamadas
			$C1 = Captaciones::where('campana_id','=',$campana->id)->where('estado_llamada1','=','Acepta Chilexpress')->count();
			$C2 = Captaciones::where('campana_id','=',$campana->id)->where('estado_llamada2','=','Acepta Chilexpress')->count();
			$C3 = Captaciones::where('campana_id','=',$campana->id)->where('estado_llamada3','=','Acepta Chilexpress')->count();
			$chilexpress = $C1+$C2+$C3;

		//CU+    establecemos el valor de cu- en base  a la consulta realizada en la BD
		$cumenos = Captaciones::where('campana_id','=',$campana->id)->where('estado','=','cu-')->count();
		//CNU    hacemos lo mismo con cnu
		$cnu = Captaciones::where('campana_id','=',$campana->id)->where('estado','=','cnu')->count();
			//header
				//titulo
					$sheet->mergeCells('B2:j2');
					$sheet->row(2,['    ','Resumen Campaña']);

				//CU+ CU- CNU
					$sheet->mergeCells('B4:D4');
					$sheet->row(4,['','CU+','','','    ','    ','CU-','    ','    ','CNU']);
					$sheet->row(5,['','Agendamiento','Grabaciones','Regiones','','','Total CU-','','','Total CNU']);
					$sheet->row(6,['',$santiago,$grabacion,$delivery+$chilexpress,'','',$cumenos,'','',$cnu]);
				//Estilos para las Celdas
						$sheet->setBorder('B4:D6', 'thin');//establecemos border

						$sheet->setBorder('G4:G6', 'thin');//establecemos bordes

						$sheet->setBorder('J4:J6', 'thin');//establecemos bordes

						$sheet->cellS('A1:K7',function($cells){
							$cells->setAlignment('center');//centramos los elementos entre las celdas
						});

						$sheet->cellS('A1:K4',function($cells){
							$cells->setFontSize('12'); //establecemos el tamaño del texto para las seldas seleccionadas
							$cells->setFontWeight('bold');//establecemos texto en negritas para las seldas seleccionadas
						});


						$sheet->cellS('A2:K2',function($cells){
							$cells->setFontSize('19');//establecemos el tamaño de fuente para las seldas seleccionadas
						});


		});
	})->export('xlsx');//finalmente exportamos el archivo excel con las dos hojas establecidas
}

public function loadCoberturaView(){
	return view('Delivery.loadCobertura');
}

public function loadCobertura(Request $request)
{
	$archivo = $request->file('archivo');//seleccionamos el archivo de nuestro request
	$nombre_original=$archivo->getClientOriginalName();//obtenemos el nombre del archivo
	$extension=$archivo->getClientOriginalExtension();//obtenemos la extencion del archivos
	$r1=Storage::disk('archivos')->put($nombre_original,  \File::get($archivo) );//guardamos el archivo en un disco local
	$ruta  =  storage_path('archivos') ."/". $nombre_original;//guardamos la ruta en la cual se encuentra guardado nuestro archivo

	if($r1){//si el archivo se guarda correctamente  ejecutamos el siguiente bloque de codigo
		Excel::selectSheetsByIndex(0)->load($ruta, function($hoja)  {
			$hoja->each(function($fila) {

				if($fila->sucursal != null){
					$Cobertura = new CoberturaRegiones;//por cada fila de nuestro archivo excel creamos una instancia de captacion

					$Cobertura-> sucursal      = $fila -> sucursal;//asignamos los valores para cada instancia
					$Cobertura-> region        =$fila-> region;
					$Cobertura-> comuna        =$fila -> comuna;//ya sean valores provenientes de nuestro archivo excel
					$Cobertura-> cobertura  	 = $fila -> cobertura;

					$Cobertura-> semana_1_lunes  = $fila -> semana_1_lunes;
					$Cobertura-> semana_1_martes  = $fila -> semana_1_martes;
					$Cobertura-> semana_1_miercoles  = $fila -> semana_1_miercoles;
					$Cobertura-> semana_1_jueves  = $fila -> semana_1_jueves;
					$Cobertura-> semana_1_viernes  = $fila -> semana_1_viernes;

					$Cobertura-> semana_2_lunes  = $fila -> semana_2_lunes;
					$Cobertura-> semana_2_martes  = $fila -> semana_2_martes;
					$Cobertura-> semana_2_miercoles  = $fila -> semana_2_miercoles;
					$Cobertura-> semana_2_jueves  = $fila -> semana_2_jueves;
					$Cobertura-> semana_2_viernes  = $fila -> semana_2_viernes;

					$Cobertura-> semana_3_lunes  = $fila -> semana_3_lunes;
					$Cobertura-> semana_3_martes  = $fila -> semana_3_martes;
					$Cobertura-> semana_3_miercoles  = $fila -> semana_3_miercoles;
					$Cobertura-> semana_3_jueves  = $fila -> semana_3_jueves;
					$Cobertura-> semana_3_viernes  = $fila -> semana_3_viernes;

					$Cobertura-> semana_4_lunes  = $fila -> semana_4_lunes;
					$Cobertura-> semana_4_martes  = $fila -> semana_4_martes;
					$Cobertura-> semana_4_miercoles  = $fila -> semana_4_miercoles;
					$Cobertura-> semana_4_jueves  = $fila -> semana_4_jueves;
					$Cobertura-> semana_4_viernes  = $fila -> semana_4_viernes;

					$Cobertura-> save();//guardamos el registro
				}
			});
		});

	}
	Session::flash('success', 'Felicidades! los registros de la Cobertura Fueron agregados Con Exito');
	return view('admin/loadCobertura');
}

public function exportDeliveryDaily(){
$date = Carbon::now()->subDay()->format('d/m/Y');//seleccionamos el dia anterior al actual

	$delivery = CaptacionesExitosa::where('tipo_retiro','=','Acepta Delivery')//seleccionamos los deliverys
	->where('estado_captacion','=','OK')//que esten aprobados por operaciones
	->where('fecha_Captacion','=',$date)->get();//que correspondan al dia anterior al actual

	Excel::create('Fundacion ', function($excel) use($delivery){
		//creamos el archivo de excel y le asignamos el nombre, en este caso suamos el nombre de la fundacion mas el numero de carta para nombrar el archivo
		$excel->sheet('carta ', function($sheet) use($delivery){
			//creamos la hoja de excel y le asignamos el nombre, en este caso usamos el numero de la carta como nombre para la hoja
			//header
				/*en el header le damos estilos a las celdas que componen la cabecera de nuestr archivo excel*/
				$sheet->row(1,['RUT','DV','SEGMENTO','CUPO_ACTUAL','CUPO_FINAL','ESTADO_CUPO','NOMBRE_TARJETA'
				,'NUMERO_TARJETA_FINAL','NOMBRE_BANDA_MAGNETICA','TARJETA','PUNTOS A REBAJAR','ESTADO_CANJE','GENERO','DIRECCION_PARTICULAR',
				'REGION_PARTICULAR','COMUNA_PARTICULAR','DIRECCION_COMERCIAL','REGION_COMERCIAL'
				,'CODIGO_SUCURSAL_OPERACION','COD_SUCURSAL_DESPAHO','TELEFONO_PARTICULAR2','TELEFONO_COMERCIAL2'
				,'TELEFONO_CELULAR2','TELEFONO_PARTICULAR1','TELEFONO_COMERCIAL2','TELEFONO_CELULAR1','OBSERVACIONES'
				,'FECHA VISITA','HORARIO','DEALER','FECHA VENTA','FECHA CALIDAD','AUX 4','AUX 5']);//textos que componen el header del documento
				//creamos los textos del encabezados hubicados en la fila 1
				$sheet->cells('A1:AH1',function($cells){
					$cells->setFontSize('9');
					$cells->setFontWeight('bold');
					$cells->setFontColor('#004c8c');
					$cells->setFontFamily('Arial');
				});
				//damos los estilos generales a los encabezados
				$sheet->cells('A1:B1',function($cells){
						$cells->setBackground('#9ccc65');
				});
				$sheet->cell('G1',function($cell){
						$cell->setBackground('#9ccc65');
				});
				$sheet->cell('N1',function($cell){
						$cell->setBackground('#9ccc65');
				});
				$sheet->cell('P1',function($cell){
						$cell->setBackground('#9ccc65');
				});
				$sheet->cell('U1',function($cell){
						$cell->setBackground('#9ccc65');
				});
				$sheet->cells('AA1:AG1',function($cells){
						$cells->setBackground('#9ccc65');
				});
					//AGREGAMOS LOS BACKGROUNDS A LOS ENCABEZADOS
				//fin Header

			//data

			/* en la data agregamos la informacion de obtenida mediante las consultas sql realizadas a la base de datos con eloquent*/
			$data=[];//creamos un nuevo arreglo vacio al cual le concatenaremos el arreglo row con la data, de esta forma creamos una matriz con la data
			$i =0;//asignamos un contador para asignar las filas en la data
			foreach ($delivery as $d){

				$dv = substr($d->rut,-1);//tomamos del rut el ultimo numero (dv)
				$ru=strlen($d->rut)-1;//establecemos el largo del rut
				$rut = substr($d->rut,0,$ru);//tomamos del rut todos los numeros anteriores al dv
				//la fecha de agendamiento tiene un fotmato diferente al requerido por el formato excel, es por esto que la descomponemos y rearmamos con el formato indicado
				$day =substr($d->fecha_agendamiento,8,2);//tomamos el dias
				$month =substr($d->fecha_agendamiento,5,2);//tomamos el mes
				$year =substr($d->fecha_agendamiento,0,4);//tomamos el año
				$fecha_agendamiento=$day."/".$month."/".$year;
				//concatenamos las variables y cambiamos el formato de fecha de año-mes-dia por el formato dia/mes/año

				$row=[];
				$row[0] = $rut;
				$row[1] = $dv;
				$row[2] = "";$row[3] = "";$row[4] = "";$row[5] = "";
				$row[6] = $d->nombre." ".$d->apellido;
				$row[7] = "";$row[8] = "";$row[9] = "";$row[10] = "";$row[11] = "";$row[12] = "";
				$row[13] = $d->direccion;
				$row[14] = $d->region;
				$row[15] = $d->comuna;
				$row[16] = "";$row[17] = "";$row[18] = "";$row[19] = "";
				$row[20] = $d->fono_1;
				$row[21] = "";$row[22] = "";$row[23] = "";$row[24] = "";$row[25] = "";
				$row[26] = $d->observaciones;
				$row[27] = $fecha_agendamiento;
				$row[28] = $d->horario;
				$row[29] = "Dues-".$d->nom_campana;
				$row[30] = $d->fecha_captacion;
				$row[31] = "";
				$row[32] = $d->correo_1;
				$row[33] = $d->monto;

				$data[] = $row;//una vez recorrido el primer ciclo concatenamos con append el valor de row a nuestro arreglo Data
				//de  esta forma montamos la matriz con cada iteracio del ciclo
				$sheet->appendRow($row);
				$i++;//sumamos uno al contador por cada fila que tenga la data
			}
			$i = $i+1;
			$sheet->setBorder('A1:AH'.$i,'thin');//le damos bordes a todo el area con datos en el documento


		});

	})->export('xlsx');//finalmente exportamos el archivo en formato xlsx

}




public function exportDeliveryHistory(){
$date = Carbon::now()->subDay()->format('d/m/Y');//seleccionamos el dia anterior al actual

	$delivery = CaptacionesExitosa::where('tipo_retiro','=','Acepta Delivery')//seleccionamos los deliverys
	->where('estado_captacion','=','OK')//que esten aprobados por operaciones
	->get();

	Excel::create('Fundacion ', function($excel) use($delivery){
		//creamos el archivo de excel y le asignamos el nombre, en este caso suamos el nombre de la fundacion mas el numero de carta para nombrar el archivo
		$excel->sheet('carta ', function($sheet) use($delivery){
			//creamos la hoja de excel y le asignamos el nombre, en este caso usamos el numero de la carta como nombre para la hoja
			//header
				/*en el header le damos estilos a las celdas que componen la cabecera de nuestr archivo excel*/
				$sheet->row(1,['RUT','DV','SEGMENTO','CUPO_ACTUAL','CUPO_FINAL','ESTADO_CUPO','NOMBRE_TARJETA'
				,'NUMERO_TARJETA_FINAL','NOMBRE_BANDA_MAGNETICA','TARJETA','PUNTOS A REBAJAR','ESTADO_CANJE','GENERO','DIRECCION_PARTICULAR',
				'REGION_PARTICULAR','COMUNA_PARTICULAR','DIRECCION_COMERCIAL','REGION_COMERCIAL'
				,'CODIGO_SUCURSAL_OPERACION','COD_SUCURSAL_DESPAHO','TELEFONO_PARTICULAR2','TELEFONO_COMERCIAL2'
				,'TELEFONO_CELULAR2','TELEFONO_PARTICULAR1','TELEFONO_COMERCIAL2','TELEFONO_CELULAR1','OBSERVACIONES'
				,'FECHA VISITA','HORARIO','DEALER','FECHA VENTA','FECHA CALIDAD','AUX 4','AUX 5']);//textos que componen el header del documento
				//creamos los textos del encabezados hubicados en la fila 1
				$sheet->cells('A1:AH1',function($cells){
					$cells->setFontSize('9');
					$cells->setFontWeight('bold');
					$cells->setFontColor('#004c8c');
					$cells->setFontFamily('Arial');
				});
				//damos los estilos generales a los encabezados
				$sheet->cells('A1:B1',function($cells){
						$cells->setBackground('#9ccc65');
				});
				$sheet->cell('G1',function($cell){
						$cell->setBackground('#9ccc65');
				});
				$sheet->cell('N1',function($cell){
						$cell->setBackground('#9ccc65');
				});
				$sheet->cell('P1',function($cell){
						$cell->setBackground('#9ccc65');
				});
				$sheet->cell('U1',function($cell){
						$cell->setBackground('#9ccc65');
				});
				$sheet->cells('AA1:AG1',function($cells){
						$cells->setBackground('#9ccc65');
				});
					//AGREGAMOS LOS BACKGROUNDS A LOS ENCABEZADOS
				//fin Header

			//data

			/* en la data agregamos la informacion de obtenida mediante las consultas sql realizadas a la base de datos con eloquent*/
			$data=[];//creamos un nuevo arreglo vacio al cual le concatenaremos el arreglo row con la data, de esta forma creamos una matriz con la data
			$i =0;//asignamos un contador para asignar las filas en la data
			foreach ($delivery as $d){

				$dv = substr($d->rut,-1);//tomamos del rut el ultimo numero (dv)
				$ru=strlen($d->rut)-1;//establecemos el largo del rut
				$rut = substr($d->rut,0,$ru);//tomamos del rut todos los numeros anteriores al dv
				//la fecha de agendamiento tiene un fotmato diferente al requerido por el formato excel, es por esto que la descomponemos y rearmamos con el formato indicado
				$day =substr($d->fecha_agendamiento,8,2);//tomamos el dias
				$month =substr($d->fecha_agendamiento,5,2);//tomamos el mes
				$year =substr($d->fecha_agendamiento,0,4);//tomamos el año
				$fecha_agendamiento=$day."/".$month."/".$year;
				//concatenamos las variables y cambiamos el formato de fecha de año-mes-dia por el formato dia/mes/año

				$row=[];
				$row[0] = $rut;
				$row[1] = $dv;
				$row[2] = "";$row[3] = "";$row[4] = "";$row[5] = "";
				$row[6] = $d->nombre." ".$d->apellido;
				$row[7] = "";$row[8] = "";$row[9] = "";$row[10] = "";$row[11] = "";$row[12] = "";
				$row[13] = $d->direccion;
				$row[14] = $d->region;
				$row[15] = $d->comuna;
				$row[16] = "";$row[17] = "";$row[18] = "";$row[19] = "";
				$row[20] = $d->fono_1;
				$row[21] = "";$row[22] = "";$row[23] = "";$row[24] = "";$row[25] = "";
				$row[26] = $d->observaciones;
				$row[27] = $fecha_agendamiento;
				$row[28] = $d->horario;
				$row[29] = "Dues-".$d->nom_campana;
				$row[30] = $d->fecha_captacion;
				$row[31] = "";
				$row[32] = $d->correo_1;
				$row[33] = $d->monto;

				$data[] = $row;//una vez recorrido el primer ciclo concatenamos con append el valor de row a nuestro arreglo Data
				//de  esta forma montamos la matriz con cada iteracio del ciclo
				$sheet->appendRow($row);
				$i++;//sumamos uno al contador por cada fila que tenga la data
			}
			$i = $i+1;
			$sheet->setBorder('A1:AH'.$i,'thin');//le damos bordes a todo el area con datos en el documento


		});

	})->export('xlsx');//finalmente exportamos el archivo en formato xlsx

}



}
