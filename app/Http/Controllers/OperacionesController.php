<?php namespace App\Http\Controllers;

use Monolog\Handler\ElasticSearchHandler;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests;
use Carbon\Carbon;


use App\CaptacionesExitosa;
use App\AgendarLlamados;
use App\comunaRetiro;
use App\estadoRuta;
use App\informeRuta;
use App\captaciones;
use App\fundacion;
use App\Campana;
use App\maxCap;
use App\estado;
Use App\Letter;
use App\User;

class OperacionesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {//funcion que nos retorna una vista con las captaciones del dia en curso
        $code="";//asignamos el valor de code en ""
        $hoy = Carbon::now()->format('d/m/Y');//asignamos el dia actual en la variable hoy
        $teos = User::where('perfil', '=', 2)->get();//seleccionamos los usuarios de tipo teleoperador
        $ruteros = User::where('perfil', '=', 5)->get();//seleccionamos los usuarios de tipo rutero
        $datos = CaptacionesExitosa::where('fecha_captacion','=',$hoy)->where('reagendar','=',"")->get()->sortByDesc('created_at');
        //seleccionamos todas las captaciones del dia en curso que no tengan estado de reagendamiento y las ordenamos por orden decendente a su creacion
        return view('operac/agendamiento', compact('datos', 'teos', 'ruteros','code'));
        //retornamos la vista con las variables antes mencionadas
    }

    public function show($id)//recibimos el id de la captacion como parametro en la url
    {//funcion que nos retoena una captacion en particular para verla en detalle

      $detalle =CaptacionesExitosa::where('id','=',$id)->get();//seleccionamos la captacion por el id
        return view('teo/detalle', compact('detalle'));//retornamos la vista con el detalle de la captacion
    }


    public function showDay(Request $request)
    {

        $option = Input::get('dia');
        $hoy = Carbon::now()->format('d/m/Y');
        $last_week = Carbon::now()->startOfWeek()->format('d/m/Y');
        $last_month = Carbon::now()->startOfMonth()->format('d/m/Y');
        if ($option == 1) {

            $today = DB::table('captaciones_exitosas')->where('fecha_captacion', '=', $hoy)->get()->sortByDesc('created_at');
            return Response::json($today);

        } elseif ($option == 2) {

            $dias = DB::table('captaciones_exitosas')->whereBetween('fecha_captacion', [$last_week, $hoy])->get()->sortByDesc('created_at');
            return Response::json($dias);
        } elseif ($option == 3) {
          $captacion = DB::table('captaciones_exitosas')->whereBetween('fecha_captacion', [$last_month, $hoy])->get()->sortByDesc('created_at');
          return Response::json($captacion);
        } else {
        }
    }



  public function showDay1(Request $request)
    {
      $teos = User::where('perfil', '=', 2)->get()->sortByDesc('created_at');
      $ruteros = User::where('perfil', '=', 5)->get()->sortByDesc('created_at');
      $hoy = Carbon::now()->format('d/m/Y');
      $ayer = Carbon::now()->subDay()->format('d/m/Y');
      $last_week = Carbon::now()->startOfWeek()->format('d/m/Y');
      $last_month = Carbon::now()->startOfMonth()->format('d/m/Y');


      if($request->filtterBy == 1){
        $data = CaptacionesExitosa::where('teleoperador',$request->teo)->get()->sortByDesc('created_at');
          $teo = User::find($request->teo);
          $breadCrum="Filtro / Teleoperador: ".$teo->name." ".$teo->last_name;

      }elseif($request->filtterBy == 2){
        $data = CaptacionesExitosa::where('rutero',$request->rutero)->get()->sortByDesc('created_at');
          $breadCrum="Filtro / Rutero: ".$request->rutero;

      }elseif($request->filtterBy == 3){
        //la fecha decaptacion tiene un fotmato diferente al requerido por el formato excel, es por esto que la descomponemos y rearmamos con el formato indicado
        $day   = substr($request->catchDate,8,2);//tomamos el dias
        $month = substr($request->catchDate,5,2);//tomamos el mes
        $year  = substr($request->catchDate,0,4);//tomamos el año
        $catchDate = $day."/".$month."/".$year;

        $data = CaptacionesExitosa::where('fecha_captacion',$catchDate)->get()->sortByDesc('created_at');
          $breadCrum="Filtro / Fecha Captacion: ".$catchDate;

      }elseif($request->filtterBy == 4){
        $data = CaptacionesExitosa::where('fecha_agendamiento',$request->dateBook)->get()->sortByDesc('created_at');
          $breadCrum="Filtro / Fecha Agendamiento: ".$request->dateBook;
      }elseif($request->filtterBy == 5){
        $data = CaptacionesExitosa::where('nombre','LIKE','%'.$request->memberName.'%')
        ->orWhere('apellido','LIKE','%'.$request->memberName.'%')->get()->sortByDesc('created_at');
          $breadCrum="Filtro / Nombre\Apellido: ".$request->memberName;

      }elseif($request->filtterBy == 6){
        $data = CaptacionesExitosa::where('rut',$request->memberDni)->get()->sortByDesc('created_at');
          $breadCrum="Filtro / Rut : ".$request->memberDni;

      }elseif($request->filtterBy == 7){
        $data = CaptacionesExitosa::where('fono_1',$request->memberPhone)->get()->sortByDesc('created_at');
          $breadCrum="Filtro / Telefono : ".$request->memberPhone;

      }elseif($request->filtterBy == 8){
        $data = CaptacionesExitosa::where('fecha_captacion',$ayer)->get()->sortByDesc('created_at');
          $breadCrum="Filtro / Captaciones de Ayer";

      }  elseif($request->filtterBy == 9){
        $data = CaptacionesExitosa::whereBetween('fecha_captacion', [$last_week, $hoy])->get()->sortByDesc('created_at');
        $breadCrum="Filtro / Captaciones de la Semana";

        }elseif($request->filtterBy == 10){
          $data = CaptacionesExitosa::whereBetween('fecha_captacion', [$last_month, $hoy])->get()->sortByDesc('created_at');
            $breadCrum="Filtro / Captaciones del mes";

        }

      return view('operac/agendamiento',[
        'datos'=>$data,
        'teos'=>$teos,
        'ruteros'=>$ruteros,
        'code'=>'',
        'breadCrum'=>$breadCrum,

      ]);

    }


    public function filtrarpor()
    {

        $opcion = isset($_GET['op']) ? $_GET['op'] : $_POST['op'];
        $dato = isset($_GET['dato']) ? $_GET['dato'] : $_POST['dato'];

        if ($opcion == 1) {
            $data = DB::table('captaciones_exitosas')->where('nombre', '=', $dato)->get()->sortByDesc('created_at');
            return Response::json($data);

        } elseif ($opcion == 2) {

            $data = DB::table('captaciones_exitosas')->where('apellido', '=', $dato)->get()->sortByDesc('created_at');
            return Response::json($data);

        } elseif ($opcion == 3) {

            $data = DB::table('captaciones_exitosas')->where('rut', '=', $dato)->get()->sortByDesc('created_at');
            return Response::json($data);

        } elseif ($opcion == 4) {

            $data = DB::table('captaciones_exitosas')->where('fono_1', '=', $dato)->get()->sortByDesc('created_at');
            return Response::json($data);
        }
    }

    public function validarSocio()
    {
        $rut = isset($_GET['rut']) ? $_GET['rut'] : $_POST['rut'];
        $fundacion = isset($_GET['fundacion']) ? $_GET['fundacion'] : $_POST['fundacion'];

        $consulta = DB::table('captaciones_exitosas')->where('rut','=', $rut)->where('fundacion', '=', $fundacion)->get();
      // $consulta =CaptacionesExitosa::where('rut', '=', $rut)->get();
        if ($consulta == null) {
            $data = 1;
            return Response::json($data);
        } else if($rut =="") {
            $data = 3;
            return Response::json($data);
        }else{
          $data = 2;
          return Response::json($data);
        }
    }

    public function addStatusCap(Request $request){

        $capStatus = $request->status_cap;
        $reason = $request->motivo_cap;
        $id = $request->cap_id;
        $ruta=estadoRuta::find($id);
        $cap = CaptacionesExitosa::find($id);
        if($capStatus=="OK"){
            if($cap->reagendar==2){
                $ruta->estado ="Reagendado Visita Pendiente";
                $ruta->save();
            }else{
                $ruta->estado ="Visita Pendiente";
                $ruta->save();
            }

        }


        $cap->estado_captacion=$capStatus;
        $cap->motivo_cap=$reason;
        $cap->edit="revisado";
        $cap->save();


        if(Auth::user()->perfil==1){
            return redirect()->route('admin.ope.index');
        }elseif(Auth::user()->perfil==4){
            return redirect()->route('ope.ope.index');
        }


    }

    public function addStatusMdt(Request $request)
    {
        $id= $request->id_captacion;
            $statusMdt=$request->status_mdt;
                $reasonMdt=$request->motivoMdt;
                $cap=CaptacionesExitosa::find($id);
            $cap->estado_mandato=$statusMdt;
        $cap->motivo_mdt=$reasonMdt;

        if($request->reagendamiento==1){

            $cap->tipo_retiro= $request->tipo_retiro;
            $cap->comuna=$request->comuna;
            $cap->fecha_agendamiento =$request->fecha_agendamiento;
            $cap->horario =$request->horario;
            $cap->rut = $request->rut;
            $cap->jornada = $request->jornada;
            $cap->fono_1 = $request->fono_1;
            $cap->nombre = $request->nombre;
            $cap->apellido = $request->apellido;
            $cap->direccion = $request->direccion;
            $cap->correo_1 =$request->correo_1;
            $cap->rutero = $request->rutero;
            $cap->monto = $request->monto;
            $cap->forma_pago = $request->forma_pago;
            $cap->observaciones = $request->observaciones;
            $cap->cuenta_movistar =$request->c_movistar;
        }
        $cap->save();

        if(Auth::user()->perfil==1){
        return redirect()->route('admin.ope.index');
        }elseif(Auth::user()->perfil==4){
            return redirect()->route('ope.ope.index');
        }

    }

    public function verRutas(){

        $hoy = Carbon::now()->format('Y-m-d');
        $rutas =DB::table('captaciones_exitosas')->where('fecha_agendamiento','=',$hoy)->get();
        $ruteros = DB::table('users')->where('perfil','=',5)->get();
        $estado=DB::table('estado_rutas')->where('primer_agendamiento','!=','no aplica')->get();
       //$datos = DB::table('captaciones_exitosas')->where('id','=','1')->get();


        return view("rutas/rutas", compact('rutas','ruteros','estado','url'));
    }


    public function verRutasFiltradas(Request $request)
    {
        $rutero = $request->voluntario;
        $ruteros = DB::table('users')->where('perfil','=',5)->get();
        $estado=DB::table('estado_rutas')->where('primer_agendamiento','!=','no aplica')->get();

        $hoy = Carbon::now()->format('Y-m-d');
        $mañana =Carbon::now()->addDay(1)->format('Y-m-d');
        $final_semana=Carbon::now()->endOfWeek()->format('Y-m-d');
        $final_mes=Carbon::now()->endOfMonth()->format('Y-m-d');
        $finDeLosTiempos =Carbon::now()->endOfCentury()->format('Y-m-d');
        $ayer =Carbon::now()->subDay(1)->format('Y-m-d');
        $startWeek =Carbon::now()->startOfWeek()->format('Y-m-d');
        $startMonth =Carbon::now()->startOfMonth()->format('Y-m-d');
        $origenDeLosTiempos =Carbon::now()->startOfCentury()->format('Y-m-d');;


        if($request->buscarPor == 'hoy'){

            if($request->voluntario =='todos'){
                $rutas = DB::table('captaciones_exitosas')->where('fecha_agendamiento','=',$hoy)->get();
                return view("rutas/rutas", compact('rutas','ruteros'));
            }else{
                $rutas = DB::table('captaciones_exitosas')->where('fecha_agendamiento','=',$hoy)->where('rutero','=',$rutero)->get();
                return view("rutas/rutas", compact('rutas','ruteros','estado'));
            }

        }elseif ($request->buscarPor == 'rutas futuras'){

            if($request->rutas_para =='mañana'){

                if($request->voluntario =='todos'){

                    $rutas = DB::table('captaciones_exitosas')->whereBetween('fecha_agendamiento',[$hoy,$mañana])->get();
                    return view("rutas/rutas", compact('rutas','ruteros','estado'));
                }else{
                    $rutas = DB::table('captaciones_exitosas')->whereBetween('fecha_agendamiento',[$hoy,$mañana])->where('rutero','=',$rutero)->get();
                    return view("rutas/rutas", compact('rutas','ruteros','estado'));
                }

            }else if($request->rutas_para =='la semana'){

                if($request->voluntario =='todos'){

                    $rutas = DB::table('captaciones_exitosas')->whereBetween('fecha_agendamiento',[$hoy,$final_semana])->get();
                    return view("rutas/rutas", compact('rutas','ruteros','estado'));
                }else{
                    $rutas = DB::table('captaciones_exitosas')->whereBetween('fecha_agendamiento',[$hoy,$final_semana])->where('rutero','=',$rutero)->get();
                    return view("rutas/rutas", compact('rutas','ruteros','estado'));
                }

            }else if($request->rutas_para =='el mes'){

                if($request->voluntario =='todos'){

                    $rutas = DB::table('captaciones_exitosas')->whereBetween('fecha_agendamiento',[$hoy,$final_mes])->get();
                    return view("rutas/rutas", compact('rutas','ruteros','estado'));
                }else{
                    $rutas = DB::table('captaciones_exitosas')->whereBetween('fecha_agendamiento',[$hoy,$final_mes])->where('rutero','=',$rutero)->get();
                    return view("rutas/rutas", compact('rutas','ruteros','estado'));
                }

            }else if($request->rutas_para =='elInfinitoYMasAlla'){

                if($request->voluntario =='todos'){

                    $rutas = DB::table('captaciones_exitosas')->whereBetween('fecha_agendamiento',[$hoy,$finDeLosTiempos])->get();
                    return view("rutas/rutas", compact('rutas','ruteros','estado'));
                }else{
                    $rutas = DB::table('captaciones_exitosas')->whereBetween('fecha_agendamiento',[$hoy,$finDeLosTiempos])->where('rutero','=',$rutero)->get();
                    return view("rutas/rutas", compact('rutas','ruteros','estado'));
                }
            }


        }elseif($request->buscarPor == 'rutas pasadas') {//fin rutas futuras, comienzo rutas pasadas

            if ($request->rutasDe == 'ayer') {

                if ($request->voluntario == 'todos') {
                    $rutas = DB::table('captaciones_exitosas')->where('fecha_agendamiento', '=', $ayer)->get();
                    return view("rutas/rutas", compact('rutas','ruteros','estado'));
                } else {
                    $rutas = DB::table('captaciones_exitosas') -> where('fecha_agendamiento', '=', $ayer)->where('rutero', '=', $rutero)->get();
                    return view("rutas/rutas", compact('rutas','ruteros','estado'));
                }

            } elseif ($request->rutasDe == 'la semana') {

                if ($request->voluntario == 'todos') {

                    $rutas = DB::table('captaciones_exitosas')->whereBetween('fecha_agendamiento',[$startWeek,$hoy])->get();
                    return view("rutas/rutas", compact('rutas','ruteros','estado'));
                } else {
                    $rutas = DB::table('captaciones_exitosas') -> whereBetween('fecha_agendamiento',[$startWeek,$hoy])->where('rutero', '=', $rutero)->get();
                    return view("rutas/rutas", compact('rutas','ruteros','estado'));
                }

            } elseif($request->rutasDe =='el mes'){

                if($request->voluntario =='todos'){
                    $rutas = DB::table('captaciones_exitosas')->whereBetween('fecha_agendamiento',[$startMonth,$hoy])->get();
                    return view("rutas/rutas", compact('rutas','ruteros','estado'));
                }else{
                    $rutas = DB::table('captaciones_exitosas') ->whereBetween('fecha_agendamiento',[$startMonth,$hoy])->where('rutero', '=', $rutero)->get();
                    return view("rutas/rutas", compact('rutas','ruteros','estado'));
                }

            }elseif ($request->rutasDe =='elOrigenDeLosTiempos'){

                if($request->voluntario =='todos'){
                    $rutas =DB::table('captaciones_exitosas')->whereBetween('fecha_agendamiento',[$origenDeLosTiempos,$hoy])->get();
                    return view("rutas/rutas", compact('rutas','ruteros','estado'));
                }else{
                    $rutas =DB::table('captaciones_exitosas')->whereBetween('fecha_agendamiento',[$origenDeLosTiempos,$hoy])->where('rutero','=',$rutero)->get();
                    return view("rutas/rutas", compact('rutas','ruteros','estado'));
                }
            }


        }elseif($request->buscarPorDia != ""){//FIN RUTAS PASADAS comienzo rutas por dia

            if($request->voluntario =='todos'){
                $rutas =DB::table('captaciones_exitosas')->where('fecha_agendamiento','=',$request->buscarPorDia)->get();
                return view("rutas/rutas", compact('rutas','ruteros','estado'));
            }else{
                $rutas =DB::table('captaciones_exitosas')->where('fecha_agendamiento','=',$request->buscarPorDia)->where('rutero','=',$rutero)->get();
                return view("rutas/rutas", compact('rutas','ruteros','estado'));
            }
        }

    }//fin metodo verRutasFiltradas

    public function adminMaxMinCap(Request $request){
  //funcion que nos permite modificar el numero de agendamientos permitidos para las rutas
        $dia=$request->maxDayCap;//seleccionamos el valor d maxdaycap
        $am=$request->maxAmCap;//seleccionamos el valor de maxamcap
        $pm=$request->maxPmCap;//seleccionamos el valor de maxpmcap

        DB::table('max_caps')//usamos el metodo update de querybuilder para actualizar el registro
            ->where('id', 1)//seleccionamos el registro que deseamos actualizar por su id
            ->update(['maxDay' => $dia,'maxAm'=>$am,'maxPm'=>$pm]);//actualizamos los datos obtenidos del request


        if(Auth::user()->perfil==1){//si el perfil de usuario es administrador retornamos por las rutas de administrador
            return redirect('admin/adminconfig');

        }else if(Auth::user()->perfil==4){//si el perfil de usuarios es operaciones retornamos por las rutas de operaciones
            return redirect('ope/adminconfig');
        }


    }

    public function reAgendamiento(){
    //funcion que nos retoena una vista donde podemos ver las captaciones por reagendar, y las ya reagendadas
        $reagendar = CaptacionesExitosa::where('reagendar','=','1')->get();//seleccionamos las por reagendar
        $reagendado = CaptacionesExitosa::where('reagendar','=','2')->get();//sekeccionamos las reagendadas

        return view('operac.reAgendamiento',[//retornamos la vista con las variables antes mencionadas
            'reagendar'=>$reagendar,
            'reagendado'=>$reagendado]);

    }
    public function detalleReagendamiento($id){
      //funcion que nos retorna una captacion espesifica que seleccionamos por un id
      //enviado como parametro en la url ademas de los usuarios de tipo teleoperador
        $detalleReagendamiento = CaptacionesExitosa::find($id);//seleccionamos la captacion por su id
            $teos= User::where('perfil','=',2)->get();//seleccionamos los usuaris de tipo teleoperador

        return view('operac/detalleReagendamiento',//retornamos la vista con la svariables antes mensionadas
            ['reage'=>$detalleReagendamiento, 'teos'=>$teos,
            ]);

    }

    public function reagendar(Request $request){
//funcion para asignarle un reagendamiento a otro teleoperador
        $newTeo= User::find($request->newTeo);//seleccionamos el nuevo teleoperador
            $cap= CaptacionesExitosa::find($request->id);//seleccionamos la captacion que deseamos reagendar
            $cap->user()->associate($newTeo);//asocioamos el nuevo usuario al agendamiento
            $cap->save();//guardamos cambios

        if(Auth::user()->perfil==1){//si el perfil es administrador retornamos por las rutas de administrador
            return redirect('admin/reAgendamiento');
        }elseif(Auth::user()->perfil==4){//si el perfil es de teleoperador retornamos por las rutas de teleoperador
            return redirect('ope/reAgendamiento');
        }


    }

    public function mdtWithEdition($id){

        $reagendamiento=CaptacionesExitosa::find($id);
        $status = estado::where('modulo', '=', 'llamado')->get();
        $estado = estado::where('modulo','=','agendamiento')->get();
        $f_pago = estado::where('modulo','=','pago')->get();
        $comunas = comunaRetiro::where('region', '=', 'metropolitana')->where('ciudad', '=', 'santiago')->get();
        $minmax =maxCap::find(1);

        return view('operac.mdtWithEdition',
            ['reage'=>$reagendamiento,
                'minmax'=>$minmax,
                'status'=>$status,
                'estado'=>$estado,
                'f_pago'=>$f_pago,
                'comunas'=>$comunas]);
    }

    public function rutas(){
    //funcion que nos redirecciona a una vista donde seleccionamos las rutas de deseamos ver
      if(Auth::User()->perfil==5){
        //si el perfil es rutero lo redireccionamos a una vista donde podra seleccionar la semana que desea ver
        return view('rutas.filtroSemana');
      }else{
        $ruteros =User::where('perfil','=',5)->get();//seleccionamos los usuarios de tipo rutero
        //si el perfil es diferente a rutero redirecconamos a una vista donde puede seleccionar
        //la semana y el rutero sobre el cual se desea ver las rutas
        return view('operac.filtroRutasSemanales',['ruteros'=>$ruteros]);
      }
    }

    public function rutasSemanaActual($rutero){
      //ruta semana actual es una funcion que nos retorna todas ls rutas de la semana  actual separada por dias
        $diaLunes =Carbon::now()->startOfWeek()->format('Y-m-d');//seleccionamos el dia lunes
        $diaMartes =Carbon::now()->startOfWeek()->addDay(1)->format('Y-m-d');//seleccionamos el dia martes
        $diaMiercoles =Carbon::now()->startOfWeek()->addDay(2)->format('Y-m-d');//seleccionamos el dia miercoles
        $diaJueves =Carbon::now()->startOfWeek()->addDay(3)->format('Y-m-d');//seleccionamos el dia jueves
        $diaViernes =Carbon::now()->startOfWeek()->addDay(4)->format('Y-m-d');//seleccionamos el dia viernes
        $diaSabado =Carbon::now()->startOfWeek()->addDay(5)->format('Y-m-d');//seleccionamos el dia sabado
        $diaDomingo =Carbon::now()->startOfWeek()->addDay(6)->format('Y-m-d');//seleccionamos el dia domingo

        $lunes =informeRuta::where('fecha_agendamiento','=',$diaLunes)->where('rutero','=',$rutero)->get();//seleccionamos la ruta del lunes
        $martes = informeRuta::where('fecha_agendamiento','=',$diaMartes)->where('rutero','=',$rutero)->get();//seleccionamos las rutas del martes
        $miercoles = informeRuta::where('fecha_agendamiento','=',$diaMiercoles)->where('rutero','=',$rutero)->get();//seleccionamos la ruta del miercoles
        $jueves = informeRuta::where('fecha_agendamiento','=',$diaJueves)->where('rutero','=',$rutero)->get();//seleccionamos la ruta del jueves
        $viernes = informeRuta::where('fecha_agendamiento','=',$diaViernes)->where('rutero','=',$rutero)->get();//seleccionamos la ruta del viernes
        $sabado = informeRuta::where('fecha_agendamiento','=',$diaSabado)->where('rutero','=',$rutero)->get();//seleccionamos la ruta del sabado
        $domingo = informeRuta::where('fecha_agendamiento','=',$diaDomingo)->where('rutero','=',$rutero)->get();//seleccionamos la ruta del domingo


        return view('operac.ruta',[//retornamos la vista con las rutas correspondiente a la semana en curso separada poor dias
          'lunes'=>$lunes,
          'martes'=>$martes,
          'miercoles'=>$miercoles,
          'jueves'=>$jueves,
          'viernes'=>$viernes,
          'sabado'=>$sabado,
          'domingo'=>$domingo,
          'diaLunes'=>$diaLunes,
          'diaMartes'=>$diaMartes,
          'diaMiercoles'=>$diaMiercoles,
          'diaJueves'=>$diaJueves,
          'diaViernes'=>$diaViernes,
          'diaSabado'=>$diaSabado,
          'diaDomingo'=>$diaDomingo,
          'rutero'=>$rutero,
          'semana'=>'actual',
        ]);
    }

    public function rutasSemanaPasada($rutero){
    //rutasSemanaPasada es una funcion que nos reorna todas las generadas la semana previa a la actual semana en curso
        $diaLunes = Carbon::now()->startOfWeek()->subWeek()->format('Y-m-d');//seleccionamos el dia lunes
        $diaMartes =Carbon::now()->startOfWeek()->subWeek()->addDay(1)->format('Y-m-d');//seleccionamos el dia martes
        $diaMiercoles =Carbon::now()->startOfWeek()->subWeek()->addDay(2)->format('Y-m-d');//seleccionamos el dia miercoles
        $diaJueves =Carbon::now()->startOfWeek()->subWeek()->addDay(3)->format('Y-m-d');//seleccionamos el dia jueves
        $diaViernes =Carbon::now()->startOfWeek()->subWeek()->addDay(4)->format('Y-m-d');//seleccionamos el dia viernes
        $diaSabado =Carbon::now()->startOfWeek()->subWeek()->addDay(5)->format('Y-m-d');//seleccionamos el dia sabado
        $diaDomingo =Carbon::now()->startOfWeek()->subWeek()->addDay(6)->format('Y-m-d');//seleccionamos el dia domingo
      //dd($diaLunes." ".$diaMartes." ".$diaMiercoles." ".$diaJueves." ".$diaViernes." ".$diaSabado." ".$diaDomingo);


          $lunes =informeRuta::where('fecha_agendamiento','=',$diaLunes)->where('rutero','=',$rutero)->orderBy('horario')->get();//seleccionmos la ruta del lunes
          $martes = informeRuta::where('fecha_agendamiento','=',$diaMartes)->where('rutero','=',$rutero)->orderBy('horario')->get();//seleccionamos la ruta del martes
          $miercoles = informeRuta::where('fecha_agendamiento','=',$diaMiercoles)->where('rutero','=',$rutero)->orderBy('horario')->get();//seleccionamos la ruta del dia mircoles
          $jueves = informeRuta::where('fecha_agendamiento','=',$diaJueves)->where('rutero','=',$rutero)->orderBy('horario')->get();//seleccionamos la ruta del dia jueves
          $viernes = informeRuta::where('fecha_agendamiento','=',$diaViernes)->where('rutero','=',$rutero)->orderBy('horario')->get();//seleccionamos la ruta del dia viernes
          $sabado = informeRuta::where('fecha_agendamiento','=',$diaSabado)->where('rutero','=',$rutero)->orderBy('horario')->get();//seleccionamos la ruta del dia sabado
          $domingo = informeRuta::where('fecha_agendamiento','=',$diaDomingo)->where('rutero','=',$rutero)->orderBy('horario')->get();//seleccionamos la ruta del dia domingo

            return view('operac.ruta',[//retornamos la vista con la ruta de toda la semana separada en variables por dias
              'lunes'=>$lunes,
              'martes'=>$martes,
              'miercoles'=>$miercoles,
              'jueves'=>$jueves,
              'viernes'=>$viernes,
              'sabado'=>$sabado,
              'domingo'=>$domingo,
              'diaLunes'=>$diaLunes,
              'diaMartes'=>$diaMartes,
              'diaMiercoles'=>$diaMiercoles,
              'diaJueves'=>$diaJueves,
              'diaViernes'=>$diaViernes,
              'diaSabado'=>$diaSabado,
              'diaDomingo'=>$diaDomingo,
              'rutero'=>$rutero,
              'semana'=>'pasada',
            ]);
    }

    public function rutasSemanaSiguiente($rutero){
        //rutasSemanaPasada es una funcion que nos reorna todas las generadas la semana previa a la actual semana en curso
        $diaLunes = Carbon::now()->startOfWeek()->addWeek()->format('Y-m-d');//seleccionamos el dia lunes
        $diaMartes =Carbon::now()->startOfWeek()->addWeek()->addDay(1)->format('Y-m-d');//seleccionamos el dia martes
        $diaMiercoles =Carbon::now()->startOfWeek()->addWeek()->addDay(2)->format('Y-m-d');//seleccionamos el dia miercoles
        $diaJueves =Carbon::now()->startOfWeek()->addWeek()->addDay(3)->format('Y-m-d');//seleccionamos el dia jueves
        $diaViernes =Carbon::now()->startOfWeek()->addWeek()->addDay(4)->format('Y-m-d');//seleccionamos el dia viernes
        $diaSabado =Carbon::now()->startOfWeek()->addWeek()->addDay(5)->format('Y-m-d');//seleccionamos el dia sabado
        $diaDomingo =Carbon::now()->startOfWeek()->addWeek()->addDay(6)->format('Y-m-d');//seleccionamos el dia domingo
      //dd($diaLunes." ".$diaMartes." ".$diaMiercoles." ".$diaJueves." ".$diaViernes." ".$diaSabado." ".$diaDomingo);


      $lunes =informeRuta::where('fecha_agendamiento','=',$diaLunes)->where('rutero','=',$rutero)->orderBy('horario')->get();//seleccionamos la ruta del dia lunes
      $martes = informeRuta::where('fecha_agendamiento','=',$diaMartes)->where('rutero','=',$rutero)->orderBy('horario')->get();//seleccionamos el dia martes
      $miercoles = informeRuta::where('fecha_agendamiento','=',$diaMiercoles)->where('rutero','=',$rutero)->orderBy('horario')->get();//seleccionamos el dia miercoles
      $jueves = informeRuta::where('fecha_agendamiento','=',$diaJueves)->where('rutero','=',$rutero)->orderBy('horario')->get();//seleccionamos el dia jueves
      $viernes = informeRuta::where('fecha_agendamiento','=',$diaViernes)->where('rutero','=',$rutero)->orderBy('horario')->get();//seleccionamos el dia viernes
      $sabado = informeRuta::where('fecha_agendamiento','=',$diaSabado)->where('rutero','=',$rutero)->orderBy('horario')->get();//seleccionamos el dia sabado
      $domingo = informeRuta::where('fecha_agendamiento','=',$diaDomingo)->where('rutero','=',$rutero)->orderBy('horario')->get();//seleccionamos el dia domingo


        return view('operac.ruta',[//retornamos la vista con la informacion de las rutas correspondientes a la semana siguiente
          'lunes'=>$lunes,//separada por dias
          'martes'=>$martes,
          'miercoles'=>$miercoles,
          'jueves'=>$jueves,
          'viernes'=>$viernes,
          'sabado'=>$sabado,
          'domingo'=>$domingo,
          'diaLunes'=>$diaLunes,
          'diaMartes'=>$diaMartes,
          'diaMiercoles'=>$diaMiercoles,
          'diaJueves'=>$diaJueves,
          'diaViernes'=>$diaViernes,
          'diaSabado'=>$diaSabado,
          'diaDomingo'=>$diaDomingo,
          'rutero'=>$rutero,
          'semana'=>'siguiente',
        ]);
    }



    public function detalleRutasPorDia($rutero, $dia){
      //detalle ruta por dia es una funcion que nos retorna todas las rutas de un rutero y un dia en concreto
      $ruta= informeRuta::where('rutero','=',$rutero)->where('fecha_agendamiento','=',$dia)->get();//seleccionamos las rutas de un rutero x un dia x
      return view('operac.detalleRutaPorDia',[//retornamos la vista con la informacion recopilada
        'rutero'=>$rutero,
        'dia'=>$dia,
        'ruta'=>$ruta,
      ]);
    }

public function passcode(Request $request){
  //passcode es un metodo para generar un codigo numerico dinamico para saltar validaciones
     $pass=$request->pass;//recibimos el password de operaciones mediante el request

      if (Hash::check($pass, Auth::user()->password))//verificamos que el password de operaciones sea valido
      //si el password de operaciones es valido continuamos con este bloque de codigo
      {
        $code= rand(1000,9999);//generamos un cofigo aleatorio entre 1000 y 9999
        $passcode =maxCap::find('1');//buscamos el registro en el cual guardaremos el passcode
        $passcode->passcode=$code;//asignamos el valor del passcode a el campo en la base de datos
        $passcode->save();//guardamos los cambios realizados en la base de datos
        return view('operac.passcode',['passcode'=>$code]);//retornamos la vista con el passcode valido por 60 segundos


      }else{//si es password de operaciones no es valido asignamos a la variable code el valor de fail
          // y retornamos a la vista de la cual veniamos
        $code="fail";
        $hoy = Carbon::now()->format('d/m/Y');
        $teos = User::where('perfil', '=', 2)->get();
        $ruteros = User::where('perfil', '=', 5)->get();
        $datos = CaptacionesExitosa::where('fecha_captacion','=',$hoy)->where('reagendar','=',"")->get()->sortByDesc('created_at');
        return view('operac/agendamiento', compact('datos', 'teos', 'ruteros','code'));
      }
}


public function resetPassCode(){//resetPassCode es una funcion que resetea el passcode generado anteriormente,
        //de esta forma el passcode anteriormente usado no se puede reutilizar
    $code= rand(1000,9999);//asignamos a la variable code un valor random entre 1000 y 9999
    $passcode =maxCap::find('1'); //seleccionamos el registro en el cual guardaremos el passcode
    $passcode->passcode=$code;//asignamos el valor del passcode al campo de la base de datos
    $passcode->save();//guardamos loc cambios realizados en la base de datos

    if(Auth::user()->perfil==4){// a diferencia del caso anterior no retornamos la vista con el passcode,
                //ya que en esta ocacion el passcode es secreto para evitar que se reutilice
      return redirect('ope/ope');
    }elseif (Auth::user()->perfil==2) {
    return redirect('teo/teo');
    }
}

public function agendamientoLlamado(){//agendamientoLlamado es una funcion que muestra los agendamientos de llamados
  // realizados por los teleoperadores en sus distintas etapas como pendientes, finalizados y llamados
  $hoy = Carbon::now()->format('Y-m-d');

  $llamados_pendientes= AgendarLlamados::where('fecha_llamado','>=',$hoy)
  ->where('estado_llamado','!=',"no llamado")->get();//seleccionamos los llamados pendientes

  $atrasados= AgendarLlamados::where('fecha_llamado','<',$hoy)
  ->where('estado_llamado','!=',"no llamado")->where('estado_llamado','!=','llamado')->get();//seleccionamos los llamados atrasados

  $finalizados = AgendarLlamados::where('estado_llamado','=',"no llamado")->get();//seleccionamos los ya finalizados

  $llamados = AgendarLlamados::where('estado_llamado','=',"llamado")->get();//seleccionamos los que fueron llamados
  return view('operac.AgendamientoLlamados',[//retornamos la vista con la informacion de los agendamientos recopilada
    'pendientes'=>$llamados_pendientes,
    'atrasados'=>$atrasados,
    'finalizados'=>$finalizados,
    'llamados'=>$llamados,
    ]);
}

public function AgendamientoLlamadoFinalizar($id){//AgendamientoLlamadoFinalizar es una funcion que nos retorna
  //los teleoperadores y un agendamiento de llamado en espesifico
  $reage = AgendarLlamados::find($id);//seleccionamos el agendamiento de llamados
  $teos = User::where('perfil','=',2)->get();//seleccionamos los teleoperadores
  return view('operac.agendamientoLlamadosFinalizarCambiarTeo',
  ['reage'=>$reage,'teos'=>$teos]);//retornamos la vista con la informacion antes recopilada
}

public function AgendamientoLlamadosFinalizarRegistro(Request $request){
  //AgendamientoLlamadosFinalizarRegistro es una funcion que finaliza un agendamiento de llamados por que el llamado en cuestiomno fue realizado
    $llamado =AgendarLlamados::find($request->id);//seleccionamos el agendamiento de llamado por su id
    $llamado->estado_llamado="no llamado";//actualizamos el estado del agendamiento
    $llamado->save();//gusrdamos los cambios

    $registro = captaciones::find($llamado->id_llamado);//seleccionamos el registro desde la tabla
    $registro->estado="cnu";//cambiamos el estado de ca a cnu, ya que el registro no fue contactado
    $registro->save();//guardamos los cambios

  return redirect('ope/agendamiento/llamados');//retornamos la vista
}

public function mandatos(){//metodo que retorna una vista para seleccionar las captaciones o rutas a las cuales se les agregara un estadp de mandato
  $ruteros = User::where('perfil','=',5)->get();//seleccionamos los ruteros que mostraremos en la vista
  $teleoperador = User::where('perfil','=',2)->get();//seleccionamos los teleoperadores que mostraremos en la vista
  return view('operac.recepcionarMandatos',[//retornamos la vista con la infoemacion seleccionada
    'ruteros'=>$ruteros,
    'teleoperador'=>$teleoperador
  ]);
}
public function registrarMandatoCaptacion(Request $request){
  $ruteros = User::where('perfil','=',5)->get();//seleccionamos los ruteros
  $teleoperador = User::where('perfil','=',2)->get();//seleccionamos los teleoperadores
  $nameTeo = User::find($request->teleoperador)->name;//nombre del teleoperador por el cual se realiza la busqueda

  if($request->nombre != ""){//filtro que se activa cuando se selecciona nombre como criterio de busqueda desde la vista
    $filtro ="Captaciones de ".$nameTeo." con nombre ".$request->nombre;//pequeño breadcrum que nos indica que filtro reallizamoa en la vista
    $registros  = CaptacionesExitosa::where('teleoperador','=',$request->teleoperador)
    ->where('nombre','=',$request->nombre)->where('estado_mandato','=',"")->get();//filtro realizado por el id de un teleoperador mas el nombre de una persona en la tabla de captaciones exitosas
    return view('operac.recepcionarMandatos',[ //retorno de la vista con la informacion recopilada
      'ruteros'=>$ruteros,
      'teleoperador'=>$teleoperador,
      'registros'=>$registros,
      'filtroPor'=>$filtro,
    ]);

  }elseif($request->lastName!=""){//filtro que se activa cuando se selecciona apellido como criterio de busqueda en la vista
    $filtro ="Captaciones de ".$nameTeo." con apellido ".$request->apellido;//pequeño breadcrum que nos indica que filtro reallizamoa en la vista
    $registros  = CaptacionesExitosa::where('teleoperador','=',$request->teleoperador)
    ->where('apellido','=',$request->apellido)->where('estado_mandato','=',"")->get();//filtro realizado por el id de un teleoperador mas el apellido de una persona en la tabla de captaciones exitosas

    return view('operac.recepcionarMandatos',[ //retorno de la vista con la informacion recopilada
      'ruteros'=>$ruteros,
      'teleoperador'=>$teleoperador,
      'registros'=>$registros,
      'filtroPor'=>$filtro,
      ]);
  }elseif ($request->rut!="") {//filtro que se activa cuando usamos el rut como criterio de bsuqueda en la vista
    $filtro ="Captaciones de ".$nameTeo." con rut ".$request->rut;//pequeño breadcrum que nos indica que filtro reallizamoa en la vista
    $registros  = CaptacionesExitosa::where('teleoperador','=',$request->teleoperador)
    ->where('rut','=',$request->rut)->where('estado_mandato','=',"")->get();//filtro realizado por el id de un teleoperador mas el rut de una persona en la tabla de captaciones exitosas

    return view('operac.recepcionarMandatos',[ //retorno de la vista con la informacion recopilada
      'ruteros'=>$ruteros,
      'teleoperador'=>$teleoperador,
      'registros'=>$registros,
      'filtroPor'=>$filtro,
    ]);

  }elseif ($request->fecha!="") {
    $filtro ="Captaciones de ".$nameTeo." con fecha ".$request->fecha;//pequeño breadcrum que nos indica que filtro reallizamoa en la vista
    $registros  = CaptacionesExitosa::where('teleoperador','=',$request->teleoperador)
    ->where('fecha_agendamiento','=',$request->fecha)->where('estado_mandato','=',"")->get();//filtro realizado por el id de un teleoperador mas la fecha de agendamiento en la tabla de captaciones exitosas

    return view('operac.recepcionarMandatos',[ //retorno de la vista con la informacion recopilada
      'ruteros'=>$ruteros,
      'teleoperador'=>$teleoperador,
      'registros'=>$registros,
      'filtroPor'=>$filtro,
    ]);
  }
//todos estos filtros son accesados mediante el id de un teleoperador seleccionado mas un segundo campo el cual es obligatorio y no puede faltar
}

public function registrarMandatoRuta(Request $request){
  $ruteros = User::where('perfil','=',5)->get();//seleccionamos los ruteros
  $teleoperador = User::where('perfil','=',2)->get();//seleccionamos los teleoperadores
  $nameRutero = User::find($request->rutero)->name;//nombre del rutero por el cual se realiza la busqueda
  $filtro ="Rutas de ".$nameRutero." con fecha ".$request->fecha;//pequeño breadcrum que nos indica que filtro reallizamoa en la vista

  $registros = CaptacionesExitosa::where('rutero','=',$nameRutero)
  ->where('fecha_agendamiento','=',$request->fecha)->where('estado_mandato','=',"")->get();
  return view('operac.recepcionarMandatos',[ //retorno de la vista con la informacion recopilada
    'ruteros'=>$ruteros,
    'teleoperador'=>$teleoperador,
    'registros'=>$registros,
    'filtroPor'=>$filtro,
  ]);
}


public function registrarMandatoRutaConReparo(Request $request){
  $ruteros = User::where('perfil','=',5)->get();//seleccionamos los ruteros
  $teleoperador = User::where('perfil','=',2)->get();//seleccionamos los teleoperadores
  $nameRutero = User::find($request->rutero)->name;//nombre del rutero por el cual se realiza la busqueda
  $filtro ="Rutas  con Reparo de ".$nameRutero;//pequeño breadcrum que nos indica que filtro reallizamoa en la vista

   $registros = CaptacionesExitosa::where('rutero','=',$nameRutero)->whereHas('estadoRuta',function($query){
    $query->where('estado','=','conReparo');
  })->get(); //creamos una consulta relacional en la cual seleccionamos las captaciones exitosas o agendamientos
      //con un rutero que pasamos como parametro pero que ademas en la tabla estadoRuta tenga el estado conReparo

   return view('operac.recepcionarMandatos',[ //retorno de la vista con la informacion recopilada
     'ruteros'=>$ruteros,
     'teleoperador'=>$teleoperador,
     'registros'=>$registros,
     'filtroPor'=>$filtro,
   ]);
 }

public function mandatosPat(){
  $filtro ="Captaciones Mediante Grabacion";//añadimos un filtro para mostrar en la vista la busqueda realizada
  $registros = CaptacionesExitosa::where('tipo_retiro','=','Acepta Grabacion')//seleccionamos los registros correspondientes a las
  ->where('estado_captacion','=','OK')//captaciones por rabacion que esten validada en operaciones como captaciones ok, para recepcionar sus mandatos
  ->where('estado_mandato','!=','OK')->get();
   return view('operac.recepcionarMandatosPat',[//retornamos la vista con la infoemacion seleccionada

    'registros'=>$registros,
    'filtroPor'=>$filtro,
  ]);
}

public function addMandatosPat(){
//funcion con la cual mediante ajax agregamos un estado de mandato exitoso a las captaciones provenientes de las grabaciones
  $id = input::get('id');//seleccionamos el id que enviamos desde ajax
  $cap = CaptacionesExitosa::find($id);
  $cap->estado_mandato ="OK";
  $cap->save();

  if($cap->estado_mandato == "OK")
  {
    return"El mandato de ".$cap->nombre." ".$cap->apellido." se Recepciono Con Exito";
  }else{
    abort(500);
  }

}

public function agregarMandato1(Request $request){//agragar estado de mandato para la primera visita
  $captacion = CaptacionesExitosa::find($request->id);//selecionamos la captacion que deseamos modificar
  $captacion->estado_mandato = $request->mandato;//asignamos el valor a estado_mandato de datos
  $captacion ->motivo_mdt = $request->comentario;//asignamos el valor a motivo_mdt
  $captacion->save();//guardamos los valores en la tabla de captaciones exitosas

  $ruta  = informeRuta::where('id_captacion','=',$request->id)->where('num_retiro','=',1)->get()->first();
//seleccionamos la ruta que deseamos modificar
  $ruta->mandato = $request->mandato;//asignamos el valor de madatos
  $ruta->save();//guardamos los cambios

    return redirect('ope/mandatos');
}

public function agregarMandato2(Request $request){//agregar estado de mandato para la segunda visita

  $captacion = CaptacionesExitosa::find($request->id);//seleccionamos la captacion que deseamos modificar
  $captacion->estado_mandato = $request->mandato;//asignamos el valor a estado_mandato de datos
  $captacion ->motivo_mdt = $request->comentario;//asignamos el valor a motivo_mdt
  $captacion->save();//guardamos los valores en la tabla de captaciones exitosas

  $ruta  = informeRuta::where('id_captacion','=',$request->id)->where('num_retiro','=',2)->get()->first();
//seleccionamos la ruta que deseamos modificar
  $ruta->mandato = $request->mandato;//asignamos el valor de madatos
  $ruta->save();//guardamos los cambios

    return redirect('ope/mandatos');
}

public function agregarMandato3(Request $request){//agragar estado de mandato para la tercera visita

  // dd($request->mandato.$request->comentario);
$captacion = CaptacionesExitosa::find($request->id);//seleccionamos la captacion que deseamos modificar
$captacion->estado_mandato = $request->mandato;//asignamos el valor a estado_mandato de datos
$captacion ->motivo_mdt = $request->comentario;//asignamos el valor a motivo_mdt
$captacion->save();//guardamos los valores en la tabla de captaciones exitosas

$ruta  = informeRuta::where('id_captacion','=',$request->id)->where('num_retiro','=',3)->get()->first();
//seleccionamos la ruta que deseamos modificar
$ruta->mandato = $request->mandato;//asignamos el valor de madatos
$ruta->save();//guardamos los cambios

  return redirect('ope/mandatos');//retornamos el metodo mandatos para regresar la vista de registro mandatos

}

public function mandatosConReparo(){//mandatos con reparo es una funcion que nos muestra todos los mandatos que
  //recepcionamos con el estado de conReparo por falta de ci
  $registros = CaptacionesExitosa::where('estado_mandato','=','conReparo')->get();//seleccionamos todas las captaciones que tengam en estado de mandato con reparo
  return view('operac.mandatosConReparo',['registros'=>$registros]);//retornamos la vista con los retiros guardados coo conReparo
}

public function ConReparoAgregarEstado(Request $request){//ConReparoAgregarEstado es una funcion que nos permite cambiar
  //el estado de los mandatos de con reparo a ok o rechazado dependiendo del caso

  $registro = CaptacionesExitosa::find($request->id_cap);//identificamos el agendamiento que deseamos modificar
  $registro->estado_mandato = $request->estado_mandato;//modificamos el estado de mandato
  $registro->motivo_mdt = $request->comentario;//modificamos el motivo del mandato
  $registro->save();//guardamos los cambios en la base de datos

  $retiro= estadoRuta::find($request->id_cap);//seleccionamos el estado de ruta por id
  $retiro->estado = $request->estado_mandato;//añadimos el estado de mandato
  if($retiro->estado_primer_agendamiento="conReparo"){

    $retiro->estado_primer_agendamiento=$request->estado_mandato;//añadimos el estado de mandato en el tercer agendamineto
    $retiro->observacion_primer_agendamiento=$request->comentario;

  }elseif($retiro->estado_segundo_agendamiento="conReparo"){

    $retiro->estado_segundo_agendamiento=$request->estado_mandato;//añadimos el estado de mandato en el tercer agendamineto
    $retiro->observacion_segundo_agendamiento=$request->comentario;//agragamos la observacion

  }elseif($retiro->estado_tercer_agendamiento="conReparo"){

    $retiro->estado_tercer_agendamiento=$request->estado_mandato;//añadimos el estado de mandato en el tercer agendamineto
    $retiro->observacion_tercer_agendamiento=$request->comentario;//agragamos la observacion
  }
  $retiro->save();//guardamos cambios

  return redirect('ope/mandatos/conReparo');
  //retornamos a la funcion mandatos con reparo para que esta nos retorne la vista con todos los registros con estado de mandato conReparo
}

public function liberarRegistros(){//liberarRegistros nos retorna una vista en la cual podemos buscar los registros que quedan
  //tomados erroneamente por los teleoperadores
    $campanas = Campana::all();//seleccionamos las campañas
  return view('operac.liberarRegistros',[//retornamos la vista con las campañas
    'campanas'=>$campanas,
  ]);
}

public function liberarRegistrosShow($id){
  $campanas = Campana::all();//seleccionamos las campañas
  $registros = captaciones::where('campana_id','=',$id)->where('estado_registro','=','1')->get();

  return view('operac.liberarRegistros',[//retornamos la vista con las campañas
    'campanas'=>$campanas,
    'registros'=>$registros,
  ]);
}

public function liberarAjax(){//liberar ajax libera los registros que quedan tomados por los teleoperadores
  //esto lo hacemos mediante ajax, para evitar recargar la pagina cada vez que liberamos un registro

  $id = Input::get('id');//seleccionamos el id que enviamos desde la peticion ajax
  $cap = captaciones::find($id);//seleccionamos la captacion correspondiente al id
    $cap->estado_registro =0;//agregarmos el estado 0 a los registros seleccionados con los cuales los dejamos libres
      if($cap->teo1 != ""){
        if($cap->teo2 == ""){
          $cap->teo1 = null;
        }elseif($cap->teo2!=""){
          if($cap->teo3 == ""){
            $cap->teo2 = null;
          }else{
            $cap->teo3 = null;
          }
        }
      }
    $cap->save();//guardamos los cambios
    if($cap->estado_registro==0){//validamos que el registro se libero correctamente
      return Response::json("success");//si el registro s elibero correctamente retornamos success
    }else {
      abort(500);//si el registro no se libero correctamente  retornamos un error 500
    }
}

public function mandatosExitosos(){
//funcion que nos retorna los registros correspondientes a los mandatos exitosos
$registros = CaptacionesExitosa::where('estado_mandato','=','OK')->get();//Seleccionamos los registros
$breadCrum ="Sin Filtros/ Actualmente se muestran todos los mandatos exitosos";
//breadcrum que nos muestra el filtro que tenemos aplicado sobre los datos
$fundaciones = fundacion::all();//seleccionamos las fundaciones
  return view('operac.mandatosExitosos',[
     'registros'=>$registros,
     'breadCrum'=>$breadCrum,
     'fundaciones'=>$fundaciones,
   ]);

}

public function mandatosExitososFiltrados(Request $request){//funcion que retorna los mandatos exitosos filtrados por fundacion y campaña
$campana = campana::find($request->selectcampana)->nombre_campana;//seleccionamos la campaña y tomamos el nombre
$fundacion = fundacion::find($request->selectFoundation)->nombre;//seleccionamos la fundacion y tomamos el nombre

  $registros = CaptacionesExitosa::where('fundacion','=',$request->selectFoundation)//seleccionamos los registros que complan con la fundacion
    ->where('nom_campana','=',$campana)->where('estado_mandato','=','OK')->get();//la campaña seleccionada y el estado de mandato OK

  $breadCrum ="Filtrado por Fundacion/".$fundacion." | Campaña/".$campana;//breadCrum en el que mostramos el filtro realizado
  $fundaciones = fundacion::all();//seleccionamos las fundaciones para retornar a la vista

    return view('operac.mandatosExitosos',[//retornamos la vista y le enviamos las variables con la informacion prosesada
       'registros'=>$registros,
       'breadCrum'=>$breadCrum,
       'fundaciones'=>$fundaciones,
     ]);
}

public function cambiarRutero(){//cambiarRutero es una funcion que nos retorna solo las rutas que estan por retirar desde el dia en curso en adelante para posterior cambiar el rutero
    $hoy = Carbon::now()->format('Y-m-d');//seleccionamos el dia de hoy y le asignamos el formato dia mes año
    $ruteros = User::where('perfil','=',5)->orwhere('perfil','=',2)->get();//seleccionamos los ruteros para enviarlos a la vista
    $comunas = comunaRetiro::where('ciudad','=','santiago')->get();//seleccionamos todas las comunas de santiago
    $registros =informeRuta::where('fecha_agendamiento','>=',$hoy)->get();//seleccionamos los registros
    $breadCrum="Sin filtros/ se muestran todas las rutas a partir de hoy";//breadcrum que nos muestra el iltro realizado
    return view('operac.cambiarRutero',[
        'registros'=>$registros,
        'ruteros'=>$ruteros,
        'comunas'=>$comunas,
        'breadCrum'=>$breadCrum,
        ]);
}

public function cambiarRuteroPost(Request $request){
  //esta funcion nos retorna los resultados de la busqueda de rutas filtradas por rutero y por comunas
  $hoy  = Carbon::now()->format('Y-m-d');//identificamos el dia en curso
  $rutero = User::find($request->rutero);//seleccionamos el rutero para el breadCrum
  $comuna = comunaRetiro::find($request->comuna);//selecionamos la comuna enviada desde la vista con el id
  $ruteros = User::where('perfil','=',5)->get();//seleccionamos los ruteros para enviarlos a la vista
  $comunas = comunaRetiro::where('ciudad','=','santiago')->get();//seleccionamos todas las comunas de santiago

 $breadCrum="Se muestran las rutas de ".$rutero->name." ".$rutero->last_name. " / En la comuna ".$comuna->comuna;//breadcrum que nos muestra el iltro realizado dd($comuna->comuna);
  $registros = informeRuta::where('rutero_id','=',$request->rutero)//seleccionamos los registros que tengan como rutero el id que sacamos del request
    ->where('fecha_agendamiento','>=',$hoy)//culla fecha de agendamiento sea igual o mallor que hoy
    ->where('estado','=','visita pendiente')//y que el estado de llamado sea igual a visita pendiente, esto para no reasignar rutas a realizadas
    ->whereHas('cap',function($query) use($comuna){//usamos el where has para adicionalmente consultar que su relacion en la tabla captaciones_exitosas
    $query->where('comuna','=',$comuna->comuna);//tenga como comuna la comuna que tomamos del request
    })->get();

  return view('operac.cambiarRutero',[//retornamos la vista con los datos
      'registros'=>$registros,
      'ruteros'=>$ruteros,
      'comunas'=>$comunas,
      'breadCrum'=>$breadCrum,
      ]);
}

public function changeRutero($id,$rutero){
  //funcion que cambia el rutero correspondiente a una ruta mediante ajax
  $rutero = User::find($rutero);//seleccionamos el rutero que se nos envia como id desde la peticion ajax

  $registro = informeRuta::find($id);//seleccionamos el registro a modificar desde informe ruta
    $registro->rutero_id = $rutero->id;//asignamos el id del rutero obtenido con ajax al id de rutero de la tabla informeRutas
    $registro->save();//guardamos el cambio

  $agendamiento = CaptacionesExitosa::find($registro->id_captacion);//seleccionamos el registro a modificaz en captaciones
    $agendamiento->rutero = $rutero->name;//asignamos el nombre del rutero al campo rutero de la tabla captaciones_exitosas
    $agendamiento->save();//guardamos los cambios
    return redirect('/ope/cambiarRutero');
}

public function createLetter(){
  //funcion que nos retornara una vista en la cual seleccionaremos la fundacion, y las campañas sobre las
  //cuales generaremos las cartas para enviar los mandatos a las fundaciones
  $foundations = fundacion::where('id','!=',1)->get();//seleccionamos todas las fundaciones
  return view('letter.createLetter',[//retornamos la vista con las fundaciones
    'foundations'=>$foundations,
  ]);
}

public function addLetter(Request $request){
  //funcion con la cual creamos una nueva carta para las deferentes fundaciones
  $letters = Letter::where('id_fundacion','=',$request->id_foundation)->get()->last();
  //seleccionamos el la ultima carta creada por una fundacion señalada en el id obtenid del Request

    if($letters){//si la consulta tiene registros ejecutamos este bloque
      $let = $letters->number+1;//tomamos el numero de la ultimacarta creada y le sumamos uno
      $letter = new Letter;//creamos un nueva instancia de letter
      $letter->number = $let;//asignamos el valor de let, el cual corresponde a la ultima carta +1
      $letter->estado = "En Dues";//asignamos el valor en dues correspondiente a una carta recien creada
      $letter->id_fundacion = $request->id_foundation;//asignamos el id de fundacion que a su ves es llave foranea esesta tabla
      $letter->save();//guardams los cambios
    }else {//si la consulta no arroja registros ejecutamos este bloque
      $letter = new Letter;//creamos una nueva instancia del objeto letter
      $letter->number = 1;//como no hay cartas anteriores le asignamos el valor 1
      $letter->estado = "En Dues";//agregamos en dues correspondiente a una cara recien creada
      $letter->id_fundacion = $request->id_foundation;//agregamos el id de fundacion que  asu vez es foreign
      $letter->save();//guardamos los cambios
      }
  return redirect('/ope/create/letter');//retornamo a la funcion create letter, la cual nos retorna una
  //vista con las fundaciones y sus respectivas cartas ya creadas
}

public function addRecordsCampaing($id_letter){
  //funcion que nos retoena una vista en la cual podremos agragar mandatos auna carta en concreto
  $letter = Letter::find($id_letter);//seleccionamos la carta
  $registros = CaptacionesExitosa::where('fundacion','=',$letter->id_fundacion)
    ->where('estado_mandato','=','OK')
    ->whereHas('myLetter',function($query){
      $query->where('number','=','0');
    })->get();

  /*seleccionamos los registros que podremos ingresar a la carta mediante mediante los siguientes criterios
  1. que los rgistros pertenescan a la misma fundacion que la carta
  2. que los registros tengan el estado de mandato como exitoso, ya que son los mandatos los que se agregana  ala carta
  3. que los registros pertenescan a la carta 0, esto es para que una vez que se añadan registros a una carta
  estos no esten disponibles para agregarse a otra cartas*/
  return view('letter.addRecordsLetter',[//retornamos la vista con las variables
    'letter'=>$letter,
    'registros'=>$registros,
  ]);
}

public function addRecodsLetterAjax()
{//funcion que ira realizando updates a los registros para ingresarlos a la carta seleccionada
  //mediante el uso de la tecologia ajax
  $cap_id= input::get('cap_id');//seleccionamos el id del mandato
  $letter_id = input::get('letter_id');//seleccionamos el id de la carta

    $cap = CaptacionesExitosa::find($cap_id);//seleccionamos la captacion
    $cap->letter = $letter_id;//asignamos el valor de la carta al mandato
    $cap->save();//guardamos los cambios

  // return("esta vaina funciono".$cap_id." y la letter ".$letter_id);
}

public function showLetter($id ){
  //funcion que nos muestra una carta seleccionada por el id que obteneos como parametro de la url
  $hoy = Carbon::now()->format('d-m-Y');//seleccionamos la fecha de hoy
  $users = User::all()->sortByDesc('perfil');//seleccionamos
  $letter = Letter::find($id);//seleccionamos la carta
  $registros =CaptacionesExitosa::where('letter','=',$letter->id)->get();//Seleccionamos los registros de la carta
  return view('letter.letter',[//retoenamos la vista con las variables
    'letter'=>$letter,
    'registros'=>$registros,
    'hoy' =>$hoy,
    'users'=>$users,
  ]);
}

public function postMan(Request $request)
{//funcion con la cual mediante el metodo post agregamos un encargado de enviar la carta a la fundacion entre otras cosas
  $hoy = Carbon::now()->format('d-m-Y');
  $let = Letter::find($request->id);
  $let->entregadaPor = $request->postMan;
  $let->creadaPor = Auth::user()->id;
  $let->estado = "Carta Enviada a la Fundacion";
  $let->mandatos = $let->mandatesByLetter->count();
  $let->fecha_entrega = $hoy;
  $let->save();
  return redirect('/ope/show/letter/'.$let->id);
}

public function byFoundation($id){
  //funcion que retorna las campañas de una fundacion en espesifico que le pasamos como parametro en el id
  return Campana::where('fundacion','=',$id)->get();
  //retornamos la informacion , y en la vista la recepcionamos con AJAX
}

public function byRutero($id){
  //funcion que retorna las comunas asignadas a un rutero en concreto para ser mostradas de forma dinamica
  //en un input de tipo select en la vista, de esta forma cuando seleccionen un rutero solo se me mostraran
  //las comunas asignadas al mismo
  $rutero = User::find($id);//seleccionamos al rutero correspondiente al id enviado
  return comunaRetiro::where('rutero','=',$rutero->name)->get();
  //selecionamos las comunas que le corresponden al rutero y las retornamos en json
}





}
//fin controlador

/**CONTROLADOR OPERACIONES
*
 *  reagendado => este metodo cambia el valor de el campo reagendar de 1, que significa que el registro debe ser reagendado
 *                 a 2, que significa que el reagendado ya fue solicitado al teleoperador correspondiente
 *                  si el teleoperador seleccionado para reagendar es diferente al original ademas actualiza este campo
 *
 * detalleReagendamiento => este metodo muestra informacion detallada de un registro en particular sacado de la lista de los
 *                  registros que estan para ser reagendados
 *
 * reAgendamiento => este metodo retorna todos los registros que deven ser reagendados en resultado de lo que informan los ruteros
 *
 * adminMaxMinCap => este metodo modifica el la cantidad maxima de captaciones diarias establecidas por defalul(8, 4 am, 4pm)
 *
 * verRutasFiltradas => este metodo es basicamente una coleccion de filtros para mostrar informacion mas espesifica de as rutas
 *
 * verRutas => este metodo retorna una coleccion de las rutas disponibles para el dia en curso
 *
 */
