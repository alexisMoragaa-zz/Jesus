<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\captaciones;
use App\CaptacionesExitosa;
use App\maxCap;
use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;
use App\estado;
use App\Campana;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use App\comunaRetiro;
use App\estadoRuta;
use App\informeRuta;
use App\AgendarLlamados;
use App\User;

class TeoController extends Controller
{

    public function home()
    {
        $captaciones = CaptacionesExitosa::where('teleoperador','=',Auth::User()->id)->get()->sortByDesc('created_at');
        return view('teo/teoHome', compact('captaciones'));
    }

    public function index()
    {
        $status = estado::where('modulo', '=', 'llamado')->get();
        $date = Carbon::now()->format('d-m-Y');
        $dato = Campana::findOrFail(Auth::user()->campana)->id;

        $cap = captaciones::where('id', '>=', 1)
            ->where('campana_id', '=', $dato)->where('f_ultimo_llamado', '!=', $date)->where('estado', '!=', 'cu-')
            ->where('estado', '!=', 'cu+')->where('estado_registro', '=', 0)->where('estado', '!=', 'ca')
            ->where('f_ultimo_llamado', '!=', $date)->first();

        if (empty($cap)) {
            return view('teo/teoError');
        }

        DB::table('captaciones')
            ->where('id', '=', $cap->id)
            ->update([
                'estado_registro' => 1
            ]);
        return view('teo/teoin', compact('cap', 'status'));
    }


    public function show($id)
    {
        $detalle = CaptacionesExitosa::where('id','=',$id)->get();
        return view('teo/detalle', compact('detalle'));
    }


    public function capFilter(Request $request){

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
      $ejem =$request->llamado_agendado;
        if(isset($ejem)){
            $llamado = AgendarLlamados::find($request->llamado_agendado_id);
            $llamado->estado_llamado ="llamado";
            $llamado->save();
      }

        $user = Auth::user()->id;
        $date = Carbon::now()->format('d-m-Y');
        $observation = $request->input('observation1');
        $call_status = $request->input('call_status');
        $call_again = $request->input('call_again');
        $type = estado::where('estado', '=', $call_status)->pluck('tipo');
        $llamado1 = captaciones::where('id', '=', $id)->pluck('primer_llamado');
        $llamado2 = captaciones::where('id', '=', $id)->pluck('segundo_llamado');

        if ($llamado1 == null) {
            $llamado = 'primer_llamado';
            $name_status = 'estado_llamada1';
            $n_llamado = '1';

        } elseif ($llamado2 == null) {
            $llamado = 'segundo_llamado';
            $name_status = 'estado_llamada2';
            $n_llamado = '2';

        } else {
            $llamado = 'tercer_llamado';
            $name_status = 'estado_llamada3';
            $n_llamado = '3';
        }

        DB::table('captaciones')
            ->where('id', '=', $id)
            ->update([
                'estado_registro' => 0,
                'f_ultimo_llamado' => $date,
                'observacion' => $observation,
                $name_status => $call_status,
                'estado' => $type,
                $llamado => $date,
                'n_llamados' => $n_llamado,
                'volver_llamar' => $call_again
            ]);

      if($call_status == "Agendar Llamado"){
          $callAgains = new AgendarLlamados;
          $callAgains->id_llamado =$id;
          $callAgains->teleoperador=$user;
          $callAgains->fecha_llamado=$call_again;
          $callAgains->save();
      }



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
        $estado = estado::where('modulo','=','agendamiento')->get();
        $f_pago = estado::where('modulo','=','pago')->get();
        $capta = captaciones::findOrFail($id);
        $minmax =maxCap::find(1);

        $comunas = comunaRetiro::where('region', '=', 'metropolitana')->where('ciudad', '=', 'santiago')->get();
        $function="nada";

        return view('teo/mandatoRegistrado', compact('capta', 'comunas','status','function','estado','f_pago','minmax'));
    }

    public function store(Request $request)
    {   /**Primera parte*/

        $data = $request->all();
        $ruteroo = User::where('perfil','=',5)->where('name','=',$data['rutero'])->get()->first();
        $id_rutero =$ruteroo->id;

        $date = Carbon::now()->format('d/m/Y');
        $comunas=comunaRetiro::where('comuna','=',$request->comuna)->get()->first();
        $ciudad =$comunas->ciudad;
        $region =$comunas->region;
        $direccion = $request->direccion." #".$request->numero." / ".$request->lugarRetiro." #".$request->off_depto." / ".$request->comuna;
        // dd($direccion);

        if($request->tipo_retiro=="Acepta Grabacion"){

            CaptacionesExitosa::create([
                'n_dues' => $data['n_dues'],
                // 'id_fundacion' => $data['id_fundacion'],
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
                'ciudad' =>$ciudad,
                'region' =>$region,
                'correo_1' => $data['correo_1'],
                'monto' => $data['monto'],
                'teleoperador' => $data['teleoperador'],
                'originalTeo'=>$data['teleoperador'],
                'nom_campana' => $data['nom_campana'],
                'fundacion' => $data ['fundacion'],
                'observaciones' => $data['observaciones'],
                'forma_pago' => $data['forma_pago'],
                'cuenta_movistar' => $data['c_movistar'],

            ]);
        }else{
        $cap= CaptacionesExitosa::create([
                'n_dues' => $data['n_dues'],
                // 'id_fundacion' => $data['id_fundacion'],
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
                'cuenta_movistar' => $data['c_movistar'],
            ]);
        }
        /**Segunda Parte*/

        $id = $request->id_captacion;
        $llamado1 = captaciones::where('id', '=', $id)->pluck('primer_llamado');
        $llamado2 = captaciones::where('id', '=', $id)->pluck('segundo_llamado');

        if ($llamado1 == null) {
            $name_status = 'estado_llamada1';
        } elseif ($llamado2 == null) {
            $name_status = 'estado_llamada2';
        } else {
            $name_status = 'estado_llamada3';
        }

        $t_retiro=$request->tipo_retiro;

        DB::table('captaciones')
            ->where('id', '=', $id)
            ->update(
              [
                'estado_registro' => 0,
                'estado' => 'cu+',
                $name_status=>$t_retiro
              ]);
    /**Tercera Parte*/
        if ($data['tipo_retiro'] == "Acepta Agendamiento") {

           $id =DB::table('estado_rutas')->insertGetId([
                'primer_agendamiento' => $data['fecha_agendamiento'],
                'estado_primer_agendamiento' => 'Visita Pendiente',
               'estado'=>'Esperando Aprobacion ',
            ]);


            informeRuta::create([
              'id_captacion'=>$cap->id,
              'id_ruta'=>$id,
              'rutero_id'=>$id_rutero,
              'fecha_agendamiento'=>$data['fecha_agendamiento'],
              'estado'=>'visita pendiente',
              'comuna'=>$data['comuna'],
              'horario'=>$data['jornada'],
              'num_retiro'=>1,
              'rutero'=>$data['rutero'],
            ]);

        }else{

            $id =DB::table('estado_rutas')->insertGetId([
                'primer_agendamiento' =>'no aplica',
                'estado_primer_agendamiento' => 'no aplica',
            ]);
        }

         if(Auth::user()->perfil==1){
            return redirect(url('admin/teoHome'));
         }elseif (Auth::user()->perfil==2){
            return redirect(url('teo/teoHome'));
         }
    }

    public function editar($id)
    {
        $capta = captaciones::findOrFail($id);
        return view('teo/modificar', compact('capta'));
    }

    public function actualizar(Request $request, $id)
    {
        $capta = captaciones::findOrFail($id);

        $capta->nombre = $request->nombre;
        $capta->apellido = $request->apellido;
        $capta->fono_1 = $request->fono1;
        $capta->fono_2 = $request->fono2;
        $capta->fono_3 = $request->fono3;
        $capta->fono_4 = $request->fono4;
        $capta->correo_1 = $request->correo1;
        $capta->correo_2 = $request->correo2;

        $capta->save();

        return view('teo/actualizado');
    }

    public function homeBack(Request $request){

        $id=$request->id;
        DB::table('captaciones')
            ->where('id', '=', $id)
            ->update([
                'estado_registro' => 0

            ]);

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
        $ruteroo = User::where('perfil','=',5)->where('name','=',$request->rutero)->get()->first();//obtenemos el rutero
        $id_rutero =$ruteroo->id;//seleccionamos su id
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
    {
        $rutero= $_GET['rutero'];
        $date =$_GET['fecha'];

        $info = CaptacionesExitosa::where('fecha_agendamiento','=',$date)
                                    ->where('rutero','=',$rutero)
                                    ->where('estado_captacion','!=','rechazada')->get();

        return Response::json($info);
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
  $hoy = Carbon::now()->format('Y-m-d');

    $callAgain = AgendarLlamados::where('teleoperador','=',Auth::User()->id)
    ->where('fecha_llamado','>=',$hoy)->where('estado_llamado','=',"")
    ->orderBy('fecha_llamado')->get();

    $no_llamados= AgendarLlamados::where('teleoperador','=',Auth::User()->id)
    ->where('fecha_llamado','<',$hoy)->where('estado_llamado','=',"")
    ->orderBy('fecha_llamado')->get();

    $finalizados = AgendarLlamados::where('teleoperador','=',Auth::User()->id)
    ->where('estado_llamado','=',"no llamado")->orderBy('fecha_llamado')->get();

    $realizados =AgendarLlamados::where('teleoperador','=',Auth::User()->id)
    ->where('estado_llamado','=',"llamado")->orderBy('fecha_llamado')->get();


  return view('teo/VolverALlamar',[
    'callAgain'=>$callAgain,
    'nollamados'=>$no_llamados,
    'finalizados'=>$finalizados,
    'realizados'=>$realizados
    ]);
}

public function agendamientoLlamadoLlamar($id){
    $id_registro=AgendarLlamados::find($id);
    $registro = captaciones::find($id_registro->llamadosAgendados->id);
    $estado = estado::where('modulo','=','llamado')->get();
    $function=$id_registro;

    return view('teo.teoin',['cap'=>$registro,'status'=>$estado,'function'=>$function]);

}

public function agendamientoLlamadaLlamadoExitoso($id){
    $ll =AgendarLlamados::find($id);
    $ll->estado_llamado="llamado";
    $ll->save();
    $cap = captaciones::find($ll->llamadosAgendados->id);
    $cap->estado= "cu+";
    $cap->save();
// "{{url('teo/mandatoExitoso&')}}{{$cap->id}}&{{$cap->n_dues}}"
    return redirect('teo/mandatoExitoso&'.$ll->llamadosAgendados->id."&".$ll->llamadosAgendados->n_dues);

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

}
