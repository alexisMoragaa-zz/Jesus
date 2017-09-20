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
use Illuminate\Support\Facades\Auth;


class OperacionesController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $teos = User::where('perfil', '=', 2)->get();
        $ruteros = User::where('perfil', '=', 5)->get();
        $datos = CaptacionesExitosa::all()->sortByDesc('created_at');
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

        $dia=$request->input('dias');
        $teo=$request->input('teo');
        $rutero=$request->input('rutero');

       /* $dia = isset($_GET['dias']) ? $_GET['dias'] : $_POST['dias'];
        $teo = isset($_GET['teo']) ? $_GET['teo'] : $_POST['teo'];
        $rutero = isset($_GET['rutero']) ? $_GET['rutero'] : $_POST['rutero'];
*/

       if ($dia == 1 and $teo != "" and $rutero != "") {

            $datos = DB::table('captaciones_exitosas')->where('fecha_captacion', '=', $hoy)->where('teleoperador', '=', $teo)
                ->where('rutero', '=', $rutero)->get();
            return view('operac/agendamiento', compact('datos','teos','ruteros'));

        } elseif ($dia == 1 and $teo != "") {

            $datos = DB::table('captaciones_exitosas')->where('fecha_captacion', '=', $hoy)->where('teleoperador', '=', $teo)
                ->get();
            return view('operac/agendamiento', compact('datos', 'teos', 'ruteros'));

        } elseif ($dia == 1 and $rutero != "") {

            $datos = DB::table('captaciones_exitosas')->where('fecha_captacion', '=', $hoy)->where('rutero', '=', $rutero)->get();
            return view('operac/agendamiento', compact('datos','teos','ruteros'));

        } elseif ($dia == 1) {
            $datos = DB::table('captaciones_exitosas')->where('fecha_captacion', '=', $hoy)->get();
            return view('operac/agendamiento', compact('datos','teos','ruteros'));
        }


        if ($dia == 2 and $teo != "" and $rutero != "") {

          $datos = DB::table('captaciones_exitosas')->whereBetween('fecha_captacion', [$last_week, $hoy])
                ->where('teleoperador', '=', $teo)->where('rutero', '=', $rutero)->get();


            return view('operac/agendamiento', compact('datos','teos','ruteros'));

        } elseif ($dia == 2 and $teo != "") {

            $datos = DB::table('captaciones_exitosas')->whereBetween('fecha_captacion', [$last_week, $hoy])
                ->where('teleoperador', '=', $teo)->get();
            return view('operac/agendamiento', compact('datos','teos','ruteros'));

        } elseif ($dia == 2 and $rutero != "") {

            $datos = DB::table('captaciones_exitosas')->whereBetween('fecha_captacion', [$last_week, $hoy])
                ->where('rutero', '=', $rutero)->get();
            return view('operac/agendamiento', compact('datos','teos','ruteros'));

        } elseif ($dia == 2) {


        $datos = DB::table('captaciones_exitosas')->whereBetween('fecha_captacion',[$last_week,$hoy])->get();


            return view('operac/agendamiento', compact('datos','teos','ruteros'));

        }


        if ($dia == 3 and $teo != "" and $rutero != "") {

            $datos = DB::table('captaciones_exitosas')->whereBetween('fecha_captacion', [$last_month, $hoy])
                ->where('teleoperador', '=', $teo)->where('rutero', '=', $rutero)->get();
            return view('operac/agendamiento', compact('datos','teos','ruteros'));

        } elseif ($dia == 3 and $teo != "") {

            $datos = DB::table('captaciones_exitosas')->whereBetween('fecha_captacion', [$last_month, $hoy])
                ->where('teleoperador', '=', $teo)->get();
            return view('operac/agendamiento', compact('datos','teos','ruteros'));

        } elseif ($dia == 3 and $rutero != "") {

            $datos = DB::table('captaciones_exitosas')->whereBetween('fecha_captacion', [$last_month, $hoy])
                ->where('rutero', '=', $rutero)->get();
            return view('operac/agendamiento', compact('datos','teos','ruteros'));



        } elseif ($dia == 3) {

            $datos = DB::table('captaciones_exitosas')->whereBetween('fecha_captacion', [$last_month, $hoy])->get();

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

        $cap = CaptacionesExitosa::find($id);
        $cap->estado_captacion=$capStatus;
        $cap->motivo_cap=$reason;
        $cap->save();


        if(Auth::user()->perfil==1){
            return redirect()->route('admin.ope.index');
        }elseif(Auth::user()->perfil==4){
            return redirect()->route('ope.ope.index');
        }


    }

    public function addStatusMdt(Request $request)
    {

        $id= $request->cap_id;
        $statusMdt=$request->status_mdt;
        $reasonMdt=$request->motivoMdt;

        $cap=CaptacionesExitosa::find($id);

        $cap->estado_mandato=$statusMdt;
        $cap->motivo_mdt=$reasonMdt;
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
}//fin controlador

