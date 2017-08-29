<?php namespace App\Http\Controllers;

use App\CaptacionesExitosa;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;
use Monolog\Handler\ElasticSearchHandler;


class OperacionesController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $dias = CaptacionesExitosa::all();
        $teos = User::where('perfil', '=', 2)->get();
        $ruteros = User::where('perfil', '=', 5)->get();
        $datos = CaptacionesExitosa::all();
        return view('operac/agendamiento', compact('datos', 'teos', 'ruteros'));

    }

    public function show($id)
    {

        $datos = CaptacionesExitosa::all();
        return view('operac/detalleAgendamiento', compact('datos'));
    }

    public function create()
    {

        return 'accion create';
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
     * @param  int $id
     * @return Response
     */


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
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

    public function showDay1()
    {
        $hoy = Carbon::now()->format('d/m/Y');
        $last_week = Carbon::now()->startOfWeek()->format('d/m/Y');
        $last_month = Carbon::now()->startOfMonth()->format('d/m/Y');



        $dia = isset($_GET['dias']) ? $_GET['dias'] : $_POST['dias'];
        $teo = isset($_GET['teo']) ? $_GET['teo'] : $_POST['teo'];
        $rutero = isset($_GET['rutero']) ? $_GET['rutero'] : $_POST['rutero'];


        if ($dia == 1 and $teo != "" and $rutero != "") {

            $today = DB::table('captaciones_exitosas')->where('fecha_captacion', '=', $hoy)->where('teleoperador', '=', $teo)
                ->where('rutero', '=', $rutero)->get();
            return Response::json($today);

        } elseif ($dia == 1 and $teo != "") {

            $today = DB::table('captaciones_exitosas')->where('fecha_captacion', '=', $hoy)->where('teleoperador', '=', $teo)
                ->get();
            return Response::json($today);

        } elseif ($dia == 1 and $rutero != "") {

            $today = DB::table('captaciones_exitosas')->where('fecha_captacion', '=', $hoy)->where('rutero', '=', $rutero)->get();
            return Response::json($today);

        } elseif ($dia == 1) {
            $today = DB::table('captaciones_exitosas')->where('fecha_captacion', '=', $hoy)->get();
            return Response::json($today);
        }


        if ($dia == 2 and $teo != "" and $rutero != "") {

            $dias = DB::table('captaciones_exitosas')->whereBetween('fecha_captacion', [$last_week, $hoy])
                ->where('teleoperador', '=', $teo)->where('rutero', '=', $rutero)->get();
            return Response::json($dias);

        } elseif ($dia == 2 and $teo != "") {

            $dias = DB::table('captaciones_exitosas')->whereBetween('fecha_captacion', [$last_week, $hoy])
                ->where('teleoperador', '=', $teo)->get();
            return Response::json($dias);

        } elseif ($dia == 2 and $rutero != "") {

            $dias = DB::table('captaciones_exitosas')->whereBetween('fecha_captacion', [$last_week, $hoy])
                ->where('rutero', '=', $rutero)->get();
            return Response::json($dias);

        } elseif ($dia == 2) {


            $dias = DB::table('captaciones_exitosas')->whereBetween('fecha_captacion', [$last_week, $hoy])->get();
            return Response::json($dias);

        }


        if ($dia == 3 and $teo != "" and $rutero != "") {

            $dias = DB::table('captaciones_exitosas')->whereBetween('fecha_captacion', [$last_month, $hoy])
                ->where('teleoperador', '=', $teo)->where('rutero', '=', $rutero)->get();
            return Response::json($dias);

        } elseif ($dia == 3 and $teo != "") {

            $dias = DB::table('captaciones_exitosas')->whereBetween('fecha_captacion', [$last_month, $hoy])
                ->where('teleoperador', '=', $teo)->get();
            return Response::json($dias);

        } elseif ($dia == 3 and $rutero != "") {

            $dias = DB::table('captaciones_exitosas')->whereBetween('fecha_captacion', [$last_month, $hoy])
                ->where('rutero', '=', $rutero)->get();
            return Response::json($dias);


        } elseif ($dia == 3) {

            $dias = DB::table('captaciones_exitosas')->whereBetween('fecha_captacion', [$last_month, $hoy])->get();

            return Response::json($dias);

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

    public function verRutas(){

        $hoy = Carbon::now()->format('Y-m-d');
        $rutas =DB::table('captaciones_exitosas')->where('fecha_agendamiento','=',$hoy)->get();
        $ruteros = DB::table('users')->where('perfil','=',5)->get();

        return view("rutas/rutas", compact('rutas','ruteros'));
    }
    
    public function verRutasFiltradas(Request $request)
    {
        $rutero = $request->voluntario;
        $ruteros = DB::table('users')->where('perfil','=',5)->get();

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
                return view("rutas/rutas", compact('rutas','ruteros'));
            }

        }elseif ($request->buscarPor == 'rutas futuras'){

            if($request->rutas_para =='mañana'){

                if($request->voluntario =='todos'){

                    $rutas = DB::table('captaciones_exitosas')->whereBetween('fecha_agendamiento',[$hoy,$mañana])->get();
                    return view("rutas/rutas", compact('rutas','ruteros'));
                }else{
                    $rutas = DB::table('captaciones_exitosas')->whereBetween('fecha_agendamiento',[$hoy,$mañana])->where('rutero','=',$rutero)->get();
                    return view("rutas/rutas", compact('rutas','ruteros'));
                }

            }else if($request->rutas_para =='la semana'){

                if($request->voluntario =='todos'){

                    $rutas = DB::table('captaciones_exitosas')->whereBetween('fecha_agendamiento',[$hoy,$final_semana])->get();
                    return view("rutas/rutas", compact('rutas','ruteros'));
                }else{
                    $rutas = DB::table('captaciones_exitosas')->whereBetween('fecha_agendamiento',[$hoy,$final_semana])->where('rutero','=',$rutero)->get();
                    return view("rutas/rutas", compact('rutas','ruteros'));
                }

            }else if($request->rutas_para =='el mes'){

                if($request->voluntario =='todos'){

                    $rutas = DB::table('captaciones_exitosas')->whereBetween('fecha_agendamiento',[$hoy,$final_mes])->get();
                    return view("rutas/rutas", compact('rutas','ruteros'));
                }else{
                    $rutas = DB::table('captaciones_exitosas')->whereBetween('fecha_agendamiento',[$hoy,$final_mes])->where('rutero','=',$rutero)->get();
                    return view("rutas/rutas", compact('rutas','ruteros'));
                }

            }else if($request->rutas_para =='elInfinitoYMasAlla'){

                if($request->voluntario =='todos'){

                    $rutas = DB::table('captaciones_exitosas')->whereBetween('fecha_agendamiento',[$hoy,$finDeLosTiempos])->get();
                    return view("rutas/rutas", compact('rutas','ruteros'));
                }else{
                    $rutas = DB::table('captaciones_exitosas')->whereBetween('fecha_agendamiento',[$hoy,$finDeLosTiempos])->where('rutero','=',$rutero)->get();
                    return view("rutas/rutas", compact('rutas','ruteros'));
                }
            }


        }elseif($request->buscarPor == 'rutas pasadas') {//fin rutas futuras, comienzo rutas pasadas

            if ($request->rutasDe == 'ayer') {

                if ($request->voluntario == 'todos') {
                    $rutas = DB::table('captaciones_exitosas')->where('fecha_agendamiento', '=', $ayer)->get();
                    return view("rutas/rutas", compact('rutas', 'ruteros'));
                } else {
                    $rutas = DB::table('captaciones_exitosas') -> where('fecha_agendamiento', '=', $ayer)->where('rutero', '=', $rutero)->get();
                    return view("rutas/rutas", compact('rutas', 'ruteros'));
                }

            } elseif ($request->rutasDe == 'la semana') {

                if ($request->voluntario == 'todos') {

                    $rutas = DB::table('captaciones_exitosas')->whereBetween('fecha_agendamiento',[$startWeek,$hoy])->get();
                    return view("rutas/rutas", compact('rutas', 'ruteros'));
                } else {
                    $rutas = DB::table('captaciones_exitosas') -> whereBetween('fecha_agendamiento',[$startWeek,$hoy])->where('rutero', '=', $rutero)->get();
                    return view("rutas/rutas", compact('rutas', 'ruteros'));
                }

            } elseif($request->rutasDe =='el mes'){

                if($request->voluntario =='todos'){
                    $rutas = DB::table('captaciones_exitosas')->whereBetween('fecha_agendamiento',[$startMonth,$hoy])->get();
                    return view("rutas/rutas", compact('rutas', 'ruteros'));
                }else{
                    $rutas = DB::table('captaciones_exitosas') ->whereBetween('fecha_agendamiento',[$startMonth,$hoy])->where('rutero', '=', $rutero)->get();
                    return view("rutas/rutas", compact('rutas', 'ruteros'));
                }

            }elseif ($request->rutasDe =='elOrigenDeLosTiempos'){

                if($request->voluntario =='todos'){
                    $rutas =DB::table('captaciones_exitosas')->whereBetween('fecha_agendamiento',[$origenDeLosTiempos,$hoy])->get();
                    return view('rutas/rutas', compact('rutas','ruteros'));
                }else{
                    $rutas =DB::table('captaciones_exitosas')->whereBetween('fecha_agendamiento',[$origenDeLosTiempos,$hoy])->where('rutero','=',$rutero)->get();
                    return view('rutas/rutas', compact('rutas','ruteros'));
                }
            }


        }elseif($request->buscarPorDia != ""){//FIN RUTAS PASADAS comienzo rutas por dia

            if($request->voluntario =='todos'){
                $rutas =DB::table('captaciones_exitosas')->where('fecha_agendamiento','=',$request->buscarPorDia)->get();
                return view('rutas/rutas', compact('rutas','ruteros'));
            }else{
                $rutas =DB::table('captaciones_exitosas')->where('fecha_agendamiento','=',$request->buscarPorDia)->where('rutero','=',$rutero)->get();
                return view('rutas/rutas', compact('rutas','ruteros'));
            }
        }
        
    }//fin metodo verRutasFiltradas
}//fin controlador

