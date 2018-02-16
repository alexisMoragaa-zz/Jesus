<?php namespace App\Http\Controllers;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use DB;
use App\CaptacionesExitosa;
use App\CoberturaRegiones;
use App\AgendarLlamados;
use App\comunaRetiro;
use App\informeRuta;
use App\captaciones;
use App\estadoRuta;
use App\fundacion;
use Carbon\Carbon;
use App\Campana;
use App\Letter;
use App\estado;
use App\maxCap;
use App\User;

class TeoController extends Controller
{

    public function home()
    {//esta funcion nos retorna la vista prinsipal de los usuarios en conjunto de sus captaciones correspondientes al dia en curso
        $captaciones = CaptacionesExitosa::where('teleoperador','=',Auth::User()->id)->get()->sortByDesc('created_at');
//seleccionamos las captaciones en la variable $captaciones
        return view('teo/teoHome', compact('captaciones'));//retornamos la vista
    }

    public function index()
    {/*en la funcion index le retornamos al usuario un registro para llamar, y para evitar que otros usuarios adquieran el mismo registro mientras
      este usuario esta hablando con el el registro queda "tomado", y nadie mas lo puede usar*/
        $status = estado::where('modulo', '=', 'llamado')->get();//seleccionamos los estado de la base de datos
        $date = Carbon::now()->format('d-m-Y');//seleccionamos la fecha de hoy y la almacenamos en $date
        $dato = Campana::findOrFail(Auth::user()->campana)->id;//seleccionamos la campaña a la cual este usuario esta asignado

        // $cap = captaciones::where('campana_id', '=', $dato)//seleccionamo el registro que se le entragara mediante una seria de filtros
        //     ->where('f_ultimo_llamado', '!=', $date)->where('estado', '!=', 'cu-')
        //     ->where('estado', '!=', 'cu+')->where('estado_registro', '=', 0)->where('estado', '!=', 'ca')
        //     ->where('tercer_llamado','=',null)
        //     ->first();
        $cap = captaciones::where('campana_id',$dato)
              ->where('f_ultimo_llamado','!=',$date)
              ->where('estado_registro','0')
              ->where('estado','!=','cu+')
              ->where('estado','!=','cu-')
              ->where('estado','!=','ca')
              ->where('estado1',null)->get()->first();

              if(empty($cap)){
                $cap = captaciones::where('campana_id',$dato)
                      ->where('f_ultimo_llamado','!=',$date)
                      ->where('estado_registro','0')
                      ->where('estado','!=','cu+')
                      ->where('estado','!=','cu-')
                      ->where('estado','!=','ca')
                      ->where('estado2',null)->get()->first();

                if(empty($cap)){
                  $cap = captaciones::where('campana_id',$dato)
                        ->where('f_ultimo_llamado','!=',$date)
                        ->where('estado_registro','0')
                        ->where('estado','!=','cu+')
                        ->where('estado','!=','cu-')
                        ->where('estado','!=','ca')
                        ->where('estado3',null)->get()->first();
                  if(empty($cap)){
                    return view('teo/teoError');
                    }
                }
              }

/*el registro que se le entregara al usuario tiene que pertenecer a la campaña a la cual el esta asignado
la fecha de ultimo llamado no puede ser mayor al dia anterior respecto del dia en  curso su estado tiene que ser diferente de cnu
su estado tiene que ser diferente de cu+ y defirente de ca (call_again) */
        // if (empty($cap)) {//evaluamos el resultado de la busqueda y si es nullo retornamos una vista con el error
        //   // $cap = captaciones::where('campana_id', '=', $dato)//seleccionamo el registro que se le entragara mediante una seria de filtros
        //
        //       // ->where('estado', '!=', 'cu-')
        //       // ->where('estado', '!=', 'cu+')->where('estado_registro', '=', 0)->where('estado', '!=', 'ca')
        //       // ->where('tercer_llamado','=',null)
        //       // ->first();
        //
        //   Session::flash('message','Atencion! No Quedan registros Disponibles. Los numeros a continuacion ya fueron llamados el dia de Hoy');
        // }
/*si el resultado de la busqueda nos retorna un registro ese registro lo actualizamos con el estadp de registro 1
lo cual implica que el registro esta reservado y ningun otro teleoperador podra acceder a el.
cuando el teleoperador determine el estado de la llamada el registro sera liberado,
pero se atualizara la fecha de ultimo llamado con lo cual es registro no estara disponible durante el dia en que se realizo la llamada*/
        DB::table('captaciones')//usamos update de queru builder para actuualizar
            ->where('id', '=', $cap->id)//seleccionamos el registro
            ->update([//actualizamos el registro y lo dejamos tomado
                'estado_registro' => 1,
              ]);
            //finalmente retornamos la vista de llamados con el registro ya tomado
        return view('teo/teoin', compact('cap', 'status'));
    }

    public function show($id)
    {//funcion que nos pemite ver una captacion exitosa o un agendamiento en detalle
        $detalle = CaptacionesExitosa::find($id);//seleccionamos el agendamieto
        $foundation = fundacion::find($detalle->fundacion)->nombre;//seleccionamos la funcacion a la que pertenece
        return view('teo/detalle', compact('detalle','foundation'));//retornamoa la vista
    }


    public function capFilter(Request $request){
//funcion qe nos permite filtrar nuestras busquedas por una serie de parametros
        $hoy =Carbon::now()->format('d/m/Y');
        $option =$request->input('searchFor');
        $date =$request->input('date');

        if($option==1){
            $captaciones = CaptacionesExitosa::where('teleoperador','=',Auth::user()->id)
            ->where('fecha_captacion','=',$hoy)->where('estado_mandato','!=','AgendamientoFallido')->get()->sortByDesc('created_at');
            return view('teo/teoHome', compact('captaciones'));

        }else if($option == 2){
            $captaciones = CaptacionesExitosa::where('teleoperador','=',Auth::user()->id)
            ->where('estado_mandato','!=','AgendamientoFallido')->where('fecha_captacion','=',$date)->get()->sortByDesc('created_at');
            return view('teo/teoHome', compact('captaciones'));
        }elseif($option == 3){
            $captaciones = CaptacionesExitosa::where('teleoperador','=',Auth::user()->id)
            ->where('estado_mandato','!=','AgendamientoFallido')->where('estado_captacion','=','OK')->get()->sortByDesc('created_at');
            return view('teo/teoHome', compact('captaciones'));
        }elseif($option == 4){
            $captaciones = CaptacionesExitosa::where('teleoperador','=',Auth::user()->id)
            ->where('estado_mandato','!=','AgendamientoFallido')->where('estado_captacion','=','rechazada')->get()->sortByDesc('created_at');
            return view('teo/teoHome', compact('captaciones'));
        }elseif($option == 5){
            $captaciones = CaptacionesExitosa::where('teleoperador','=',Auth::user()->id)
            ->where('estado_mandato','!=','AgendamientoFallido')->where('estado_captacion','=','conReparo')->get()->sortByDesc('created_at');
            return view('teo/teoHome', compact('captaciones'));
        }else if($option == 6){

            $captaciones = CaptacionesExitosa::where('teleoperador','=',Auth::user()
            ->where('estado_mandato','!=','AgendamientoFallido')->id)->get()->sortByDesc('created_at');
                return view('teo/teoHome', compact('captaciones'));

    }
        return($date);
    }


    public function siguiente(Request $request, $id)
    {
/*Esta es una de las funcioes mas importantes de un teleoperador,
Esta funcion nos permite avanzara l siguiente registro de llamada bloqueando el nuevo registro,
y desbloqueando el registro inmediatamente anterior al nuevo, de esta forma los teleoperadores
no vuelven a llamar a los mismos registros que otros lalmaron el mismo dia*/
      $ejem =$request->llamado_agendado;//tomamos el valor de llamado_agendado del request
        if(isset($ejem)){//preguntamos si la variable esta vacia
          //si la variable no esta vacia buscamos el agendamiento con el id del request
            $llamado = AgendarLlamados::find($request->llamado_agendado_id);
            $llamado->estado_llamado ="llamado";//actualizamos el campo estado_llamado
            $llamado->save();//guardamos los cambios,
            /*este bloque se aplica cuando realizamos la llamada de nuestros registros agendados*/
        }

        $user = Auth::user()->id;//seleccionamos el id del usuario con session iniciada
        $date = Carbon::now()->format('d-m-Y');//tomamos la fecha del dia de hoy con carbon
        $observation = $request->input('observation1');//tomamos el valor de observacion desde el request
        $call_status = $request->input('call_status');//tomamos el valor de call_status desde el request
        $call_again = $request->input('call_again');//tomamos el valor de call_again desde el request
        $type = estado::where('estado', '=', $call_status)->pluck('tipo');//seleccionamos los estados de llamada que retornaremos a la vista
        $llamado1 = captaciones::where('id', '=', $id)->pluck('primer_llamado');//seleccionamos la captacion y el campo primer llamado en concreto
        $llamado2 = captaciones::where('id', '=', $id)->pluck('segundo_llamado');//hacsmos lo mismo con el campo segundo llamado, estos son campos de la misma captacion

        if ($llamado1 == null) {//si primer llamado en nuestra captacion es null asignamos los  valores
            $llamado = 'primer_llamado';//llamado lo asignamos como primer llamado
            $name_status = 'estado_llamada1';//name status lo asignamos conmo estado_llamada1
            $n_llamado = '1';//y numero de llamado como 1, hacemos los mismo con el llamado 2
            $teocall = 'teo1';
            $callstatus= 'estado1';
            //y usamos un else para referenciar el llamado 3
        } elseif ($llamado2 == null) {
            $llamado = 'segundo_llamado';
            $name_status = 'estado_llamada2';
            $n_llamado = '2';
            $teocall = 'teo2';
            $callstatus= 'estado2';
        } else {
            $llamado = 'tercer_llamado';
            $name_status = 'estado_llamada3';
            $n_llamado = '3';
            $teocall = 'teo3';
            $callstatus= 'estado3';
        }
//actualizamos la tabla captaciones con los datos que asignamos mediante los if,
        DB::table('captaciones')
            ->where('id', '=', $id)//seleccionamos la captacion que deseamos actualizar
            ->update([//actualizamos los registros
                'estado_registro' => 0,//dejamos el estado de registro en 0, para liberar el registro que bloqueamos
                //en la funcion index, cuando recibimos el registro
                'f_ultimo_llamado' => $date,//asignamos los valores obtenidos del request
                'observacion' => $observation,//y seleccionamos el campo a actualizar mediante los if
                $name_status => $call_status,
                'estado' => $type,
                $llamado => $date,
                'n_llamados' => $n_llamado,
                'volver_llamar' => $call_again,
                'teoFinal' => $user,
                $teocall => $user,
                $callstatus => $type,
            ]);
//si el call status es igual a agendar llamado creamos una nueva instancia de agendarLlamado
      if($call_status == "Agendar Llamado"){
          $callAgains = new AgendarLlamados;
          $callAgains->id_llamado =$id;//asignamos el id de llamado con el id de la captacion
          $callAgains->teleoperador=$user;//asignamos el teleoperador que realiza el agendamiento
          $callAgains->fecha_llamado=$call_again;//agregamos la fecha de el call_again
          $callAgains->save();//guardamos los cambios
      }
/*finalmente seleccionamos el perfil que esta logeado y redireccionamos segun corresponda*/
      if(Auth::user()->perfil==1){
          return redirect()->route('admin.call.index');
      }elseif (Auth::user()->perfil==2){
          return redirect()->route('teo.call.index');
      }
  }



    public function addStatusCapAjax(){

        $estado = $_POST['call_status'];
        $id =$_POST['id_captacion'];
        $llamado1 = captaciones::where('id', '=', $id)->pluck('primer_llamado');
        $llamado2 = captaciones::where('id', '=', $id)->pluck('segundo_llamado');

        if ($llamado1 == null)
        {
            $name_status = 'estado_llamada1';

        } elseif ($llamado2 == null)
        {
            $llamado = 'segundo_llamado';
            $name_status = 'estado_llamada2';
        } else
        {
            $llamado = 'tercer_llamado';
            $name_status = 'estado_llamada3';
        }

        DB::table('captaciones')
            ->where('id', '=', $id)
            ->update(
              [
                'estado_registro' => 0,
                'estado' => 'cu+',
                $name_status=>$estado
              ]);

        return Response::json('exito');
    }

    public function create($id, $estado)
    {
        $status = estado::where('modulo', '=', 'llamado')->get();
        $estado = estado::where('modulo','=','agendamiento')
        ->where('Estado','!=','Acepta Delivery')
        ->where('Estado','!=','Acepta Chilexpress')
        ->where('Estado','!=','Acepta Upgrade')->get();
        $f_pago = estado::where('modulo','=','pago')->get();
        $capta = captaciones::findOrFail($id);
        $minmax =maxCap::find(1);

        $comunas = comunaRetiro::where('region', '=', 'metropolitana')->where('ciudad', '=', 'santiago')->get();
        $function="nada";

        return view('teo/mandatoRegistrado', compact('capta', 'comunas','status','function','estado','f_pago','minmax'));
    }

    public function store(Request $request)
    {   /**Primera parte*/
      /*la funcion store se divide en tres partes prinsipales, esta que es la primera se encarga de generar una captacion exitosas
      pero como la tabla de captaciones exitosas tiene otras relaciones ademas de otras instancias como esa¿tado de ruta que dependen de ella*/

      //en la funcion store creamos una captacion exitosa
        $data = $request->all();//seleccionamos todo el request y lo asignamos a data|
        $ruteroo = User::where('perfil','=',5)->where('name','=',$data['rutero'])->get()->first();
        //seleccionamos el rutero por el nombre
        $id_rutero =$ruteroo->id;//tomamos el id del rutero y lo asignamos a la variable id_rutero

        $date = Carbon::now()->format('d/m/Y');//seleccionamos la fecha de hoy y la guardamos en la variable hoy
        $direccion = $request->direccion." #".$request->numero." / ".$request->lugarRetiro." #".$request->off_depto." / ".$request->comuna;
        // usando el request concatenamos los diferentes campos que conforman la direccion y le damos el formato que guardaremos enb la bd

        $letter = Letter::where('id_fundacion','=',$request->fundacion)->where('number','=',0)->get()->first();
        $letter_id = $letter->id;

        if($request->tipo_retiro=="Acepta Grabacion"){
  //si el tipo de retiro es grabacion, solo guardamos los campos competentes a las grabaciones
        $cap = CaptacionesExitosa::create([//creamos una captacion exitosa usando el metodo create de eloquent
                'letter' => $letter_id,
                'n_dues' => $data['n_dues'],
                'fecha_captacion' => $date,
                'fecha_agendamiento' => $date,
                'tipo_retiro' => $data['tipo_retiro'],
                'horario' => $data['jornada'],
                'rut' => $data['rut'],
                'fono_1' => $data['fono_1'],
                'nombre' => $data['nombre'],
                'apellido' => $data['apellido'],
                'direccion' => $direccion,
                'comuna' => $data['comuna'],
                'region' => $data['region'],
                'correo_1' => $data['correo_1'],
                'monto' => $data['monto'],
                'teleoperador' => $data['teleoperador'],
                'originalTeo'=> $data['teleoperador'],
                'nom_campana' => $data['nom_campana'],
                'fundacion' => $data ['fundacion'],
                'observaciones' => $data['observaciones'],
                'forma_pago' => $data['forma_pago'],
                'cuenta_movistar' => $data['c_movistar'],

            ]);
        }else{
          $comunas=comunaRetiro::where('comuna','=',$request->comuna)->get()->first();
          //seleccionamos la comuna por su nombre
          $ciudad =$comunas->ciudad;//asignamos el valor de la propiedad ciudad del objeto comuna a la variable ciudad
          $region =$comunas->region;//asignamos el valor de la propiedad region del objeto comuna a la variable region
          //si el registro es diferente de grabacion guardamos los campos respectivos  aun agendamiento
        $cap= CaptacionesExitosa::create([//creamos una captaion exitosa usando el metodo create de eloquent
                'letter'=>$letter_id,
                'n_dues' => $data['n_dues'],
                'fecha_captacion' => $date,
                'fecha_agendamiento' => $data['fecha_agendamiento'],
                'tipo_retiro' => $data['tipo_retiro'],
                'horario' => $data['jornada'],
                'rut' => $data['rut'],
                'fono_1' => $data['fono_1'],
                'nombre' => $data['nombre'],
                'apellido' => $data['apellido'],
                'direccion' => $direccion,
                'comuna' => $data['comuna'],
                'ciudad' =>$ciudad,
                'region' =>$region,
                'correo_1' => $data['correo_1'],
                'monto' => $data['monto'],
                'rutero' => $data['rutero'],
                'teleoperador' => $data['teleoperador'],
                'originalTeo'=>$data['teleoperador'],
                'nom_campana' => $data['nom_campana'],
                'fundacion' => $data ['fundacion'],
                'observaciones' => $data['observaciones'],
                'forma_pago' => $data['forma_pago'],
                // 'cuenta_movistar' => $data['c_movistar'],
            ]);
        }
        /**Segunda Parte
            en esta parte vemo a que numero de llamado corresponde  y asignamos variables para posteriormente agregar el estado donde corresponda
        */

        $id = $request->id_captacion;
        //tomamos el id de captacion y con eso luego tomamos el valor del primer y el segundo llamado
        $llamado1 = captaciones::where('id', '=', $id)->pluck('primer_llamado');//tomamos el valor del primer llamado
        $llamado2 = captaciones::where('id', '=', $id)->pluck('segundo_llamado');//tomamos el valor del segundo llamado

        if ($llamado1 == null){//si llamado1 es nulo o vacio
            $name_status = 'estado_llamada1';//agregamos el estado en el campo promer llamado
            $f_llamado ='primer_llamado';
            $n_llamado ="1";
            $teocall ="teo1";
            $callstatus="estado1";
        } elseif ($llamado2 == null) {//si llamado2 es nulo o vacio
            $name_status = 'estado_llamada2';//agregamos el estado en segundo llamado
              $f_llamado ='segundo_llamado';
              $n_llamado ="2";
              $teocall ="teo2";
              $callstatus="estado2";
        } else {//si ninguna de las anteriores se cumple
            $name_status = 'estado_llamada3';//agregamos el estado en el tercer llamado
            $f_llamado ='tercer_llamado';
            $n_llamado ="3";
            $teocall ="teo3";
            $callstatus="estado3";
        }

        $t_retiro=$request->tipo_retiro;//guardamos en la variable t_retiro el tipo de retiro obtenido del request
        $dateCall =Carbon::now()->format('d-m-Y');
        DB::table('captaciones')//usamos el metodo update de query builder
            ->where('id', '=', $id)//usamos where para buscar el registro que dseseamos actualizar por id
            ->update(//usamos el metodo update y le pasamos los datos que deseamos actualizar
              [
                'estado_registro' => 0,//ponemos es estado de registro en 0
                'estado' => 'cu+',//y el estado en cu+
                'n_llamados'=> $n_llamado,
                $f_llamado=>$dateCall,
                $name_status=>$t_retiro,// asignamos el nombre de estado como el tipo de retiro
                'teoFinal'=>Auth::user()->id,
                $teocall=>Auth::user()->id,
                $callstatus=>"cu+",
                'f_ultimo_llamado' => $dateCall,//asignamos los valores obtenidos del request
              ]);

      /*Finalmente en el metodo update usamos las variables que fueron asignadas en la primera parte de este metodo*/
    /**Tercera Parte
        esta es la parte encargada de crear los nuevos estados de rutas, relacionados con las captaciones mediante una relacion uno a uno
    */
        if ($data['tipo_retiro'] == "Acepta Agendamiento") {
          //si el tipo de retiro es un agendamiento agregamos la informacion correspondiente a los estados de ruta
           $id =DB::table('estado_rutas')->insertGetId([
               'id'=>$cap->id,//asignamos e id de la captacion exitosa recien creada al id de el registro, ya que es la foreign key
                'primer_agendamiento' => $data['fecha_agendamiento'],//en primer agendamiento agregamos la fecha para el primer agendamiento
                'estado_primer_agendamiento' => 'Visita Pendiente',//como estado_primer_agendamiento agregamos visita pendiente
               'estado'=>'Esperando Aprobacion ',//como estado agregams esperando aprobacion, ya que falta que operqciones vaoide los datos y libere la ruta
            ]);

  /*Usamos el metodo create de eloquent para crear un nuevo registro en l atabla informe ruta.
  Esta tabla es la encargada de generar las rutas, ya que un mismo agendamiento puede tener hasta tres rutas y cada una de las rutas es una ruta independiente
   sin importar si es o no la misma captacion, por esta razon creamos esta tabla para gestionarlas y reflejarlas en los informes
*/
            informeRuta::create([
              'id_captacion'=>$cap->id,//asignamos al id de captacion el id de la captacion recien creada
              'id_ruta'=>$id,//asignamos el id obtenido del estado de ruta recien creqado
              'rutero_id'=>$id_rutero,//asignamos el id de ruteri
              'fecha_agendamiento'=>$data['fecha_agendamiento'],//agregamos la feca de agendamiento
              'estado'=>'visita pendiente',//agregamoc como estado de visita pendiente
              'comuna'=>$data['comuna'],//agregamos la comuna
              'horario'=>$data['jornada'],//la jornada
              'num_retiro'=>1,//el numero de retiro, y como es el primer agendamiento ponemos 1
              'rutero'=>$data['rutero'],//y agregamos el nombre de rutero
            ]);

        }else{
          //por el contrario si el tipo de retiro es grabacion u otro se agrega el campo no aplica  a esta relacion,
            $id =DB::table('estado_rutas')->insertGetId([
               'id'=>$cap->id,
                'primer_agendamiento' =>'no aplica',
                'estado_primer_agendamiento' => 'no aplica',
            ]);
        }

         if(Auth::user()->perfil==1){//verificamos el perfil de el usuario que realiza la accion y redireccionamos segun corresponda
            return redirect(url('admin/teoHome'));
         }elseif (Auth::user()->perfil==2){
            return redirect(url('teo/teoHome'));
         }
    }

    public function editar($id)
    {//editar nos retorna una vista y nos envia una captacion en base al id que le enviamos como parametro en la url
        $capta = captaciones::findOrFail($id);
        return view('teo/modificar', compact('capta'));
    }

    public function actualizar(Request $request, $id)
    {//funcion que nos permite actualizar una captacion, antes de que esta se comvierta en agendamiento
        $cap = captaciones::findOrFail($id);//seleccionamos la captacion
          $cap->nombre = $request->nombre;//seleccionamos los campos que deseamos actualizar
          $cap->apellido = $request->apellido;//y los valores que deseamos añadir
          $cap->fono_1 = $request->fono1;
          $cap->fono_2 = $request->fono2;
          $cap->fono_3 = $request->fono3;
          $cap->fono_4 = $request->fono4;
          $cap->correo_1 = $request->correo1;
          $cap->correo_2 = $request->correo2;
        $cap->save();//guardamos los cambios
        $status = estado::where('modulo', '=', 'llamado')->get();//seleccionamos los estado de la base de datos
        //retornamos la vista de llamados con los datos del registro ya actualizado
        return view('teo/teoin', compact('cap', 'status'));
      }



    public function homeBack(Request $request){
//funcion con la cual liberamos el registro de llamadas para que otros teleoperadores puedan llamar a ese numero
        $id=$request->id;//seleccionamos el id del request
        DB::table('captaciones')//usamos el metodo update de querybuilder
            ->where('id', '=', $id)//usamos where para seleccionar la captacion o registro que deseamos liberar
            ->update([//usamos el metodo update pasandole como parametros los campos y los valores que deseamos actualizar
                'estado_registro' => 0
              ]);

//verificamos el perfil del usuario que realiza la accion y redireccionamos segun corresponda
        if(Auth::user()->perfil==1){
            return redirect(url('admin/teoHome'));
        }elseif (Auth::user()->perfil==2){
            return redirect(url('teo/teoHome'));
        }
    }

    public function editCap($id){
      //editCap es una funcion para editar los agendamientos ya sea solicitado por operaciones o no
        $function="editar";
        $f_pago = estado::where('modulo','=','pago')->get();//seleccionamos los medios de pagos que mostraremos en la vista
        $status = estado::where('modulo', '=', 'llamado')->get();//seleccionamoos los estados de llamados que mostraremos en le vista
        $estado = estado::where('modulo','=','agendamiento')->get();//seleccionamos los estados de agendamiento que mosraremos en la vista
        $comunas = comunaRetiro::where('region', '=', 'metropolitana')->where('ciudad', '=', 'santiago')->get();
        //seleccionamos las comunas que mostraremos con sus respectivas rutas en la vista

        $minmax=maxCap::find(1);//seleccionamos el maximo de captaciones por dia
        $reage = captacionesExitosa::findOrFail($id);//seleccionamos el agendamiento y lo guardamos en la variable reage

        return view('teo/editarAgendamiento', compact('reage', 'comunas','status','function','estado','f_pago','minmax'));
        //retornamos la vista con todas las variables recopiladas
    }

    public function editCapPost(Request $request){
      //editar la informacion de los agendamientos
        if($request->tipo_retiro == "Acepta Agendamiento"){
          $ruteroo = User::where('perfil','=',5)->where('name','=',$request->rutero)->get()->first();//obtenemos el rutero
          $id_rutero =$ruteroo->id;//seleccionamos su id
        }

        $id =$request->id_captacion;//seleccionamos el id de la captacion o agendamiento
        $editCap =CaptacionesExitosa::find($id);//selecionamos la captacion o agendamiento y la guardamos como objeto en la variable $editCap

            $editCap->tipo_retiro= $request->tipo_retiro;//asignamos los valores a los campos de la base de datos
            $editCap->comuna=$request->comuna;
            $editCap->fecha_agendamiento =$request->fecha_agendamiento;
            $editCap->horario =$request->horario;
            $editCap->rut = $request->rut;
            // $editCap->jornada = $request->jornada;
            $editCap->fono_1 = $request->fono_1;
            $editCap->nombre = $request->nombre;
            $editCap->apellido = $request->apellido;
            $editCap->direccion = $request->direccion;
            $editCap->correo_1 =$request->correo_1;
            $editCap->rutero = $request->rutero;
            $editCap->monto = $request->monto;
            $editCap->forma_pago = $request->forma_pago;
            $editCap->observaciones = $request->observaciones;
            $editCap->cuenta_movistar =$request->c_movistar;
            $editCap->edit ="editado";//añadimos el estado editado para que reconoscamos cuando el teleoperador edite el registro y asi lo pueda ver operaciones

        if($request->reagendamiento ==1){//si el campo de la tabla captaciones exitosas reagendamiento es igual a 1 se añaden los datos de reagendamiento

                $date =$request->fecha_reagendamiento;//asignamos la fecha de reagendamiento desde el request
                $time =$request->horario;//asignamos el horario desde el request
                $visit = estadoRuta::find($request->id_captacion);//seleccionamos el estado de ruta con el id, y lo guardamos el la variable $visit
                $visit_capta=CaptacionesExitosa::find($request->id_captacion);//seleccionamos la captacion o agendamiento y lo guardamos en la variable $visit_Capta

                if($visit->estado_segundo_agendamiento == "noRetirado"){//si el estao_Segundo agendamientos es igual a no retirado verificamos si el estado_tercer agendamiento es vacio
                    if($visit->estado_tercer_agendamiento==""){//una vez verificado que es vacio guardamos la informacion en el estado_tercer_agendamiento

                        $visit->tercer_agendamiento = $date;
                        $visit->estado="";
                        $visit->save();//guardamos la informacion de la captacion o agendamiento

                        $visit_capta->fecha_agendamiento=$date;
                        $visit_capta->horario =$time;
                        $visit_capta->reagendar =3;
                        $visit_capta->estado_captacion="";
                        $visit_capta->save();//guardamos la informacion de el estado de ruta

                        informeRuta::create([//y creamos una nueva ruta en la tabla informe rutas, la cual trata cada visita de una captacion o agendamiento como una ruta individual
                          'id_captacion'=>$request->id_captacion,
                          'id_ruta'=>$request->id_captacion,
                          'rutero_id'=>$id_rutero,
                          'fecha_agendamiento'=>$date,
                          'estado'=>'visita pendiente',
                          'num_retiro'=>3,//asignamos el numero de retiro o ruta para nuestra captacion/agendamiento en este caso el numero 3
                          'rutero'=>$data['rutero'],
                          'comuna'=>$data['comuna'],
                          'horario'=>$data['jornada'],
                        ]);
                    }
                }elseif($visit->estado_primer_agendamiento=="noRetirado"){//si la sentencia anterior es falsa preguntamos lo mismo para el estado_primer agendamiento y luego consultamos si el estado_segundo agendaiento es vacio
                    if($visit->estado_segundo_agendamiento==""){//nuevamente si el estado es vacio se guarda la misma informacion, pero esta vez es almacenada en estado_segundo_agendamiento

                        $visit->segundo_agendamiento = $date;
                        $visit->estado="";
                        $visit->save();//guardamos la informacion de la captacion
                        $visit_capta->fecha_agendamiento=$date;
                        $visit_capta->horario =$time;
                        $visit_capta->reagendar =2;
                        $visit_capta->estado_captacion="";
                       $visit_capta->save();//guardamos la informacion del estado de ruta

                       informeRuta::create([//creamos una ruta en el informe de rutas
                         'id_captacion'=>$request->id_captacion,
                         'id_ruta'=>$request->id_captacion,
                         'rutero_id'=>$id_rutero,
                         'fecha_agendamiento'=>$date,
                         'estado'=>'visita pendiente',
                         'num_retiro'=>2,//guardamos el numero de visita correspondiente a el numero de retiro que se realizo en esta captacion agendamiento, en este caso 2
                         'rutero'=>$data['rutero'],
                         'comuna'=>$data['comuna'],
                         'horario'=>$data['jornada'],
                       ]);

                    }
                }
        }elseif ($request->reagendamiento ==2){

        }
        $editCap->save();//finalmente luego de las sentencias logicas que guardan una utra cosa dependiendo de la ruta guardamos la informacion en la base de datos

        if(Auth::user()->perfil==1){//si el perfil que realizo esta accion es administrador se redirecciona por las rutas de administrador
            return redirect(url('admin/teoHome'));
        }elseif (Auth::user()->perfil==2){//por el contrario si es teleoperador se redirecciona por las rutas de teleoperador, pero ambos legan a la misma vista
            return redirect(url('teo/teoHome'));
        }
    }

    public function dispRutas()
    {//esta es una funcion accesada desde ajax, la cual nos permite ver la disponivilidad de retiro para un rutero un dia seleccionado
        $rutero= $_GET['rutero'];//obtenemos el valor del rutero
        $date =$_GET['fecha'];//obtenemos el dia que se revisara

        $info = CaptacionesExitosa::where('fecha_agendamiento','=',$date)//seleccionamos los agendamientos para el dia a revisar
                                    ->where('rutero','=',$rutero)//ademas seleccionamos solo los que correspondan al rutero deseado
                                    ->where('estado_captacion','!=','rechazada')->get();//y por ultimo verificamos que el estado de la captacion sea diferente a rechazado

        return Response::json($info);//retornamos en formato json la informacion
    }

    public function PorReagendar()
    {
        $porReagendar = CaptacionesExitosa::where('reagendar','=',1)->where('teleoperador','=',Auth::User()->id)->get();
        return view('teo/porReagendar',['reage'=>$porReagendar]);
    }

    public function detalleReagendamiento($id){
        $reagendamiento=CaptacionesExitosa::find($id);
        $status = estado::where('modulo', '=', 'llamado')->get();
        $estado = estado::where('modulo','=','agendamiento')->get();
        $f_pago = estado::where('modulo','=','pago')->get();
        $comunas = comunaRetiro::where('region', '=', 'metropolitana')->where('ciudad', '=', 'santiago')->get();
        $minmax =maxCap::find(1);

        return view('teo.detalleReagendamientoTeo',
                ['reage'=>$reagendamiento,
                'minmax'=>$minmax,
                'status'=>$status,
                'estado'=>$estado,
                'f_pago'=>$f_pago,
                'comunas'=>$comunas]);
    }

    public function reagendarConEdicion($id){
        $reagendamiento=CaptacionesExitosa::find($id);
        $status = estado::where('modulo', '=', 'llamado')->get();
        $estado = estado::where('modulo','=','agendamiento')->get();
        $f_pago = estado::where('modulo','=','pago')->get();
        $comunas = comunaRetiro::where('region', '=', 'metropolitana')->where('ciudad', '=', 'santiago')->get();
        $minmax =maxCap::find(1);

        return view('teo.reagWithEdition',
            ['reage'=>$reagendamiento,
                'minmax'=>$minmax,
                'status'=>$status,
                'estado'=>$estado,
                'f_pago'=>$f_pago,
                'comunas'=>$comunas,
               ]);
    }
    public function reagendado(Request $request){
        $ruteroo = User::where('perfil','=',5)->where('name','=',$request->rutero)->get()->first();
        $id_rutero =$ruteroo->id;
        $date =$request->fecha_reagendamiento;
        $time =$request->horario;

        $visit = estadoRuta::find($request->id_captacion);
        $visit_capta=CaptacionesExitosa::find($request->id_captacion);

        if($visit->estado_segundo_agendamiento == "noRetirado"){
            if($visit->estado_tercer_agendamiento==""){

                $visit->tercer_agendamiento = $date;
                $visit->estado="";
                $visit->save();

                $visit_capta->fecha_agendamiento=$date;
                $visit_capta->horario =$time;
                $visit_capta->reagendar =2;
                $visit_capta->estado_captacion="";
                $visit_capta->save();

                informeRuta::create([
                  'id_captacion'=>$request->id_captacion,
                  'id_ruta'=>$request->id_captacion,
                  'rutero_id'=>$id_rutero,
                  'fecha_agendamiento'=>$date,
                  'estado'=>'visita pendiente',
                  'num_retiro'=>3,
                  'rutero'=>$request->rutero,
                  'comuna'=>$request->comuna,
                  'horario'=>$time,
                ]);

                if(Auth::user()->perfil==1){
                    return redirect('/admin/PorReagendar');
                }elseif (Auth::user()->perfil==2){
                    return redirect('/teo/PorReagendar');
                }
            }
        }elseif($visit->estado_primer_agendamiento=="noRetirado"){
            if($visit->estado_segundo_agendamiento==""){

                $visit->segundo_agendamiento = $date;
                $visit->estado="";
                $visit->save();

                $visit_capta->fecha_agendamiento=$date;
                $visit_capta->horario =$time;
                $visit_capta->reagendar =2;
                $visit_capta->estado_captacion="";
                $visit_capta->save();

                informeRuta::create([
                  'id_captacion'=>$request->id_captacion,
                  'id_ruta'=>$request->id_captacion,
                  'rutero_id'=>$id_rutero,
                  'fecha_agendamiento'=>$date,
                  'estado'=>'visita pendiente',
                  'num_retiro'=>2,
                  'rutero'=>$request->rutero,
                  'comuna'=>$request->comuna,
                  'horario'=>$time,
                ]);
                if(Auth::user()->perfil==1){
                    return redirect('/admin/PorReagendar');
                }elseif (Auth::user()->perfil==2){
                    return redirect('/teo/PorReagendar');
                }
            }
        }
  }

  public function fallidos()
  {
    $fallidos = CaptacionesExitosa::where('estado_mandato','=','AgendamientoFallido')
    ->orWhere('estado_mandato','=','retracta')->get();
    return view('teo.fallidos',['fallidos'=>$fallidos,]);
  }

  public function detalleFallidos($id)
  {
    $fallido = CaptacionesExitosa::find($id);
    $img1 = informeRuta::where('id_captacion','=',$id)->where('num_retiro','=',1)->get()->first();
    $img2 = informeRuta::where('id_captacion','=',$id)->where('num_retiro','=',2)->get()->first();
    $img3 = informeRuta::where('id_captacion','=',$id)->where('num_retiro','=',3)->get()->first();


    return view('teo.detalleAgendamientosFallidos',
      [
        'reage'=>$fallido,
        'img1'=>$img1,
        'img2'=>$img2,
        'img3'=>$img3,
      ]);
  }

  public function validatePassCode(Request $request){
        $passCodeUser= $request->pass;
        $passCodeBd= maxCap::find('1');
            $status = estado::where('modulo', '=', 'llamado')->get();
            $estado = estado::where('modulo','=','agendamiento')->get();
            $f_pago = estado::where('modulo','=','pago')->get();
            $capta = captaciones::findOrFail($request->id);
            $minmax =maxCap::find(1);

            $comunas = comunaRetiro::where('region', '=', 'metropolitana')->where('ciudad', '=', 'santiago')->get();
            $function="nada";

      if($passCodeUser == $passCodeBd->passcode){
            $code= rand(1000,9999);
            $minmax->passcode=$code;
            $minmax->save();
          return view('partials.agendamientoConPassCode',['capta'=>$capta,
            'comunas'=>$comunas, 'status'=>$status, 'function'=>$function,
            'estado'=>$estado,'f_pago'=>$f_pago,'minmax'=>$minmax,
            ]);
        }else{
          return view('teo/mandatoRegistrado', compact('capta', 'comunas','status','function',
          'estado','f_pago','minmax'));
      }
    }

public function llamadasAgendadas(){
  //funcion que nos retorna los estados de los agendamientos de llamados
  $hoy = Carbon::now()->format('Y-m-d');//seleccionamos la fecha de hoy,

    $callAgain = AgendarLlamados::where('teleoperador','=',Auth::User()->id)
    ->where('fecha_llamado','>=',$hoy)->where('estado_llamado','=',"")
    ->orderBy('fecha_llamado')->get();
//seleccionamos los llamados que tienen que realizarse el dia de hoy donde el estado de llamados esta null y la sordenamos por fecha de llamado

    $no_llamados= AgendarLlamados::where('teleoperador','=',Auth::User()->id)
    ->where('fecha_llamado','<',$hoy)->where('estado_llamado','=',"")
    ->orderBy('fecha_llamado')->get();
//seleccionamos los registros no llamados

    $finalizados = AgendarLlamados::where('teleoperador','=',Auth::User()->id)
    ->where('estado_llamado','=',"no llamado")->orderBy('fecha_llamado')->get();
//seleccionamos los registros $finalizados / estos registros ya no pueden ser llamados por el teleoperadores

    $realizados =AgendarLlamados::where('teleoperador','=',Auth::User()->id)
    ->where('estado_llamado','=',"llamado")->orderBy('fecha_llamado')->get();
//seleccionamos los registros realmente llamados

  return view('teo/VolverALlamar',[
    'callAgain'=>$callAgain,
    'nollamados'=>$no_llamados,
    'finalizados'=>$finalizados,
    'realizados'=>$realizados
    ]);
}

public function agendamientoLlamadoLlamar($id){
  //funcion que nos retorna el registro qu deseamos llamar dentro de los agendamientos a la vista de llamados
    $id_registro=AgendarLlamados::find($id);//seleccionamos el registro de los agendamientos
    $registro = captaciones::find($id_registro->llamadosAgendados->id);//seleccionamos la captacion
    $estado = estado::where('modulo','=','llamado')->get();//seleccionamos los estados de llamado
    $function=$id_registro;//asignamos a la variable function el valor correspondiente al id registro,
    //en la vista realizamos una validacion y si esta valor se encuentra presente se redirecciona por otra funcion
    //retornamos la vsta con las variables
    return view('teo.teoin',['cap'=>$registro,'status'=>$estado,'function'=>$function]);

}

public function agendamientoLlamadaLlamadoExitoso($id,$tipe){
  //funcion para gestionar los registros llamados exitosos  dentro de los agendamientos de llamados creados por el teleoperador
    $ll = AgendarLlamados::find($id);//seleccionamos el agendamiento en cuestion

    $ll->estado_llamado="llamado";//le asignamos el valor de llamado
    $ll->save();//guardamos os cambios
    $cap = captaciones::find($ll->llamadosAgendados->id);//Seleccionamos la captacion a la cual pertenece el agendamiento
    $cap->estado= "cu+";//asignamos el valor de cu+
    $cap->save();//guardamos los cambios y finalmente redireccionamos  al modulo para tomar los datos correspondientes al
    if($tipe==1){
      return redirect('/teo/regiones/'.$cap->id);
    }elseif($tipe == 2){
      return redirect('/teo/agendar/grabacion/'.$cap->id);
    }else{
      return redirect('teo/mandatoExitoso&'.$ll->llamadosAgendados->id."&".$ll->llamadosAgendados->n_dues);
    }
  }

  public function agendarGrabacion($id){
    $status = estado::where('modulo', '=', 'llamado')->get();
    $f_pago = estado::where('modulo','=','pago')->get();
    $capta = captaciones::findOrFail($id);
    $minmax =maxCap::find(1);
    $comunas = CoberturaRegiones::all();

    return view('teo/agendamientoGrabacion',
    ['capta'=>$capta,
    'comunas'=>$comunas,
    'status'=>$status,
    'f_pago'=>$f_pago,
    'minmax'=>$minmax]);
  }


}


    /** comentarios del controlador
     *
     * home: home nos retorna una vista previa antes de la vista de llamados, en la cual adicionalmente podemos ver las captacioens
     *          y filtrarlas segun unos sensillos parametroas. para la parte del filtro nos valemos del metodo capFilter, el cual se
     *          explicara en detalle mas adelante
     *
     *index:    selecciona el primer registro de la base de datos que cumpla con las condiciones establecidas en los where
     *              luego inserta acontinuacion inserta un 1 en estado para vbloquear el registro a los demas usuarios. finalmente
     *             envia la informacion a la vista
     *
     *Siguiente: toma el registro entregado por la vista, inserta un 0 para desbloquear el registro, he inserta la fecha correspondiente
     *             al dia, para que de esta forma no se llamena los mismos registros el mismo dia. luego redirecciona al index y se repite el proceso
     *
     *Store    : Esta funcion se divide en tres partes fundamentales.
     *          parte 1: inserta los datos rescatados del formulario en la tabla captaciones_exitosas
     *          parte 2: con un if identifica el numero de llamados he inserta el estado de la captacion en la tabla captaciones
     *          parte 3: si el tipod e retiro es 1, o agendamiento inserta la fecha de agendamiento en la tabla estado_ruta y el estado
     *                  del primer agendamiento como visita pendiente
     *
     * capFilter: en este metodo de tipo post, evaluamos  los valores obtenidos del campo select searchFor, y con un grupo de if anidados
     *              determinamos la informacion que enviaremos a la vista teo Home segun corresponda
     *
     * show:    busca una captacion por id,(id  enviado desde la vista) y muestra la informacuion completa y detallada de esa captacion en particular
     *
     * dispRutas => consulta la disponivilidad del de rutas con el rutero y fechas que se pasan como parametros
     *
     * PorReagendar => retorna una vista con todos los registros disponibles para el teleoperador que tenga a session iniciada
     *
     * detalleReagendamiento => retorna la captacion seleccionada y la vista muestra el detalle de esa captacion,
     *          ademas entrega un formulario para reagendar la visita
     *
     * reagedado => actualiza la fecha de agendamiento, he inserta la nueva fecha de visita en la tabla estado de rutas
     *          actualiza el campo reagendar con el numero 2, el cual significa que el teleoperador ya realizo el reagendamiento
     *
     *
     */
