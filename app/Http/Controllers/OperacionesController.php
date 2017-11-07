<?php namespace App\Http\Controllers;

use App\CaptacionesExitosa;
use App\estadoRuta;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;
use Monolog\Handler\ElasticSearchHandler;
use Illuminate\Support\Facades\Auth;
use App\maxCap;
use App\estado;
use App\comunaRetiro;

class OperacionesController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $hoy = Carbon::now()->format('d/m/Y');
        $teos = User::where('perfil', '=', 2)->get();
        $ruteros = User::where('perfil', '=', 5)->get();
        $datos = CaptacionesExitosa::where('fecha_captacion','=',$hoy)->where('reagendar','=',"")->get();
        return view('operac/agendamiento', compact('datos', 'teos', 'ruteros'));

    }

    public function show($id)
    {

      $detalle =CaptacionesExitosa::where('id','=',$id)->get();
        return view('teo/detalle', compact('detalle'));
    }

    public function create()
    {

        return 'accion create';
    }


    public function store()
    {
        //
    }


    public function edit($id)
    {
        //
    }

    public function update($id)
    {
        //
    }


    public function destroy($id)
    {
        //
    }


    public function showDay(Request $request)
    {

        $option = Input::get('dia');
        $hoy = Carbon::now()->format('d/m/Y');
        $last_week = Carbon::now()->startOfWeek()->format('d/m/Y');
        $last_month = Carbon::now()->startOfMonth()->format('d/m/Y');
        if ($option == 1) {

            $today = DB::table('captaciones_exitosas')->where('fecha_captacion', '=', $hoy)->get();
            return Response::json($today);

        } elseif ($option == 2) {

            $dias = DB::table('captaciones_exitosas')->whereBetween('fecha_captacion', [$last_week, $hoy])->get();
            return Response::json($dias);
        } elseif ($option == 3) {
            $captacion = DB::table('captaciones_exitosas')->whereBetween('fecha_captacion', [$last_month, $hoy])->get();

            return Response::json($captacion);

        } else {
        }
    }

    public function showDay1(Request $request)
    {
        $teos = User::where('perfil', '=', 2)->get();
        $ruteros = User::where('perfil', '=', 5)->get();
        $hoy = Carbon::now()->format('d/m/Y');
        $last_week = Carbon::now()->startOfWeek()->format('d/m/Y');
        $last_month = Carbon::now()->startOfMonth()->format('d/m/Y');

        $dia=$request->dias;
        $teo=$request->teo;
        $rutero=$request->rutero;



       if ($dia == 1 and $teo != "" and $rutero != "") {
            $datos=CaptacionesExitosa::where('fecha_captacion', '=', $hoy)->where('teleoperador', '=', $teo)
                ->where('rutero', '=', $rutero)->get();


          return view('operac/agendamiento', compact('datos','teos','ruteros'));

        } elseif ($dia == 1 and $teo != "") {

            $datos =CaptacionesExitosa::where('fecha_captacion', '=', $hoy)->where('teleoperador', '=', $teo)
                ->get();
            return view('operac/agendamiento', compact('datos', 'teos', 'ruteros'));

        } elseif ($dia == 1 and $rutero != "") {

            $datos = CaptacionesExitosa::where('fecha_captacion', '=', $hoy)->where('rutero', '=', $rutero)->get();
            return view('operac/agendamiento', compact('datos','teos','ruteros'));

        } elseif ($dia == 1) {
           $datos=CaptacionesExitosa::where('fecha_captacion', '=', $hoy)->get();
           return view('operac/agendamiento', compact('datos','teos','ruteros'));
        }
/**Fin filtros dia actual*/

/**Comienzo filñtros semana en curso*/

        if ($dia == 2 and $teo != "" and $rutero != "") {

          $datos = CaptacionesExitosa::whereBetween('fecha_captacion', [$last_week, $hoy])
                ->where('teleoperador','=',$teo)
                ->where('rutero','=',$rutero)->get();

            return view('operac/agendamiento', compact('datos','teos','ruteros'));

        } elseif ($dia == 2 and $teo != "") {

            $datos = CaptacionesExitosa::whereBetween('fecha_captacion', [$last_week, $hoy])
                ->where('teleoperador', '=', $teo)->get();
            return view('operac/agendamiento', compact('datos','teos','ruteros'));

        } elseif ($dia == 2 and $rutero != "") {

            $datos = CaptacionesExitosa::whereBetween('fecha_captacion', [$last_week, $hoy])
                ->where('rutero', '=', $rutero)->get();
            return view('operac/agendamiento', compact('datos','teos','ruteros'));

        } elseif ($dia == 2) {


        $datos = CaptacionesExitosa::whereBetween('fecha_captacion',[$last_week,$hoy])->get();


            return view('operac/agendamiento', compact('datos','teos','ruteros'));

        }
/**Fin filtro semana en curso*/

/**Inicio filtro mes en curso*/

        if ($dia == 3 and $teo != "" and $rutero != "") {

            $datos = CaptacionesExitosa::whereBetween('fecha_captacion', [$last_month, $hoy])
                ->where('teleoperador', '=', $teo)->where('rutero', '=', $rutero)->get();
            return view('operac/agendamiento', compact('datos','teos','ruteros'));

        } elseif ($dia == 3 and $teo != "") {

            $datos = CaptacionesExitosa::whereBetween('fecha_captacion', [$last_month, $hoy])
                ->where('teleoperador', '=', $teo)->get();
            return view('operac/agendamiento', compact('datos','teos','ruteros'));

        } elseif ($dia == 3 and $rutero != "") {

            $datos = CaptacionesExitosa::whereBetween('fecha_captacion', [$last_month, $hoy])
                ->where('rutero', '=', $rutero)->get();
            return view('operac/agendamiento', compact('datos','teos','ruteros'));



        } elseif ($dia == 3) {

            $datos = CaptacionesExitosa::whereBetween('fecha_captacion', [$last_month, $hoy])->get();

            return view('operac/agendamiento', compact('datos','teos','ruteros'));


        }



    }

    public function filtrarpor()
    {

        $opcion = isset($_GET['op']) ? $_GET['op'] : $_POST['op'];
        $dato = isset($_GET['dato']) ? $_GET['dato'] : $_POST['dato'];

        if ($opcion == 1) {
            $data = DB::table('captaciones_exitosas')->where('nombre', '=', $dato)->get();
            return Response::json($data);

        } elseif ($opcion == 2) {

            $data = DB::table('captaciones_exitosas')->where('apellido', '=', $dato)->get();
            return Response::json($data);

        } elseif ($opcion == 3) {

            $data = DB::table('captaciones_exitosas')->where('rut', '=', $dato)->get();
            return Response::json($data);

        } elseif ($opcion == 4) {

            $data = DB::table('captaciones_exitosas')->where('fono_1', '=', $dato)->get();
            return Response::json($data);
        }


    }

    public function validarSocio()
    {
        $rut = isset($_GET['rut']) ? $_GET['rut'] : $_POST['rut'];
        $fundacion = isset($_GET['fundacion']) ? $_GET['fundacion'] : $_POST['fundacion'];

        $consulta = DB::table('captaciones_exitosas')->where('rut', '=', $rut)->where('fundacion', '=', $fundacion)->get();

        if ($consulta == null) {

            $data = 1;
            return Response::json($data);
        } else {
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
        $datos = DB::table('captaciones_exitosas')->where('id','=','1')->get();


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

        $dia=$request->maxDayCap;
        $am=$request->maxAmCap;
        $pm=$request->maxPmCap;

        DB::table('max_caps')
            ->where('id', 1)
            ->update(['maxDay' => $dia,'maxAm'=>$am,'maxPm'=>$pm]);


        if(Auth::user()->perfil==1){
            return redirect('admin/adminconfig');

        }else if(Auth::user()->perfil==4){
            return redirect('ope/adminconfig');
        }


    }

    public function reAgendamiento(){

        $reagendar = CaptacionesExitosa::where('reagendar','=','1')->get();
        $reagendado = CaptacionesExitosa::where('reagendar','=','2')->get();

        return view('operac.reAgendamiento',[
            'reagendar'=>$reagendar,
            'reagendado'=>$reagendado]);

    }
    public function detalleReagendamiento($id){

        $detalleReagendamiento = CaptacionesExitosa::find($id);
            $teos= User::where('perfil','=',2)->get();

        return view('operac/detalleReagendamiento',
            ['reage'=>$detalleReagendamiento, 'teos'=>$teos,
            ]);

    }

    public function reagendar(Request $request){

        $newTeo= User::find($request->newTeo);
            $cap= CaptacionesExitosa::find($request->id);
            $cap->user()->associate($newTeo);
            $cap->save();

        if(Auth::user()->perfil==1){
            return redirect('admin/reAgendamiento');
        }elseif(Auth::user()->perfil==4){
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
    public function rutasSemanaActual(){

        $diaLunes =Carbon::now()->startOfWeek()->format('Y-m-d');
        $diaMartes =Carbon::now()->startOfWeek()->addDay(1)->format('Y-m-d');
        $diaMiercoles =Carbon::now()->startOfWeek()->addDay(2)->format('Y-m-d');
        $diaJueves =Carbon::now()->startOfWeek()->addDay(3)->format('Y-m-d');
        $diaViernes =Carbon::now()->startOfWeek()->addDay(4)->format('Y-m-d');
        $diaSabado =Carbon::now()->startOfWeek()->addDay(5)->format('Y-m-d');
        $diaDomingo =Carbon::now()->startOfWeek()->addDay(6)->format('Y-m-d');
        $inicio = Carbon::now()->startOfWeek()->format('d/m/Y');
        $fin = Carbon::now()->startOfWeek()->addDay(6)->format('d/m/Y');

        $lunes =CaptacionesExitosa::where('fecha_agendamiento','=',$diaLunes)->get();
        $martes =CaptacionesExitosa::where('fecha_agendamiento','=',$diaMartes)->get();
        $miercoles =CaptacionesExitosa::where('fecha_agendamiento','=',$diaMiercoles)->get();
        $jueves =CaptacionesExitosa::where('fecha_agendamiento','=',$diaJueves)->get();
        $viernes =CaptacionesExitosa::where('fecha_agendamiento','=',$diaViernes)->get();
        $sabado =CaptacionesExitosa::where('fecha_agendamiento','=',$diaSabado)->get();
        $domingo =CaptacionesExitosa::where('fecha_agendamiento','=',$diaDomingo)->get();

        return view('operac.ruta',[
          'lunes'=>$lunes,
          'martes'=>$martes,
          'miercoles'=>$miercoles,
          'jueves'=>$jueves,
          'viernes'=>$viernes,
          'sabado'=>$sabado,
          'domingo'=>$domingo,
          'inicio'=>$inicio,
          'fin'=>$fin,
        ]);
    }

    public function rutas(){

      $ruteros =User::where('perfil','=',5)->get();
      return view('operac.filtroRutasSemanales',['ruteros'=>$ruteros]);
    }
}//fin controlador

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
