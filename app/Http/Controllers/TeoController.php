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
        $dato = Campana::findOrFail(Auth::user()->campana)->nombre_campana;

        $cap = captaciones::where('id', '>=', 1)
            ->where('campana', '=', $dato)->where('f_ultimo_llamado', '!=', $date)->where('estado', '!=', 'cu-')->where('estado', '!=', 'cu+')->where('estado_registro', '=', 0)
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

        $detalle =CaptacionesExitosa::where('id','=',$id)->get();
        
        return view('teo/detalle', compact('detalle'));

    }

    public function capFilter(Request $request){

        $hoy =Carbon::now()->format('d/m/Y');
        $option =$request->input('searchFor');
        $date =$request->input('date');

        if($option==1){
            $captaciones = CaptacionesExitosa::where('teleoperador','=',Auth::user()->id)->where('fecha_captacion','=',$hoy)->get()->sortByDesc('created_at');
            return view('teo/teoHome', compact('captaciones'));

        }else if($option == 2){
            $captaciones = CaptacionesExitosa::where('teleoperador','=',Auth::user()->id)->where('fecha_captacion','=',$date)->get()->sortByDesc('created_at');
            return view('teo/teoHome', compact('captaciones'));
        }elseif($option == 3){
            $captaciones = CaptacionesExitosa::where('teleoperador','=',Auth::user()->id)->where('estado_captacion','=','OK')->get()->sortByDesc('created_at');
            return view('teo/teoHome', compact('captaciones'));
        }elseif($option == 4){
            $captaciones = CaptacionesExitosa::where('teleoperador','=',Auth::user()->id)->where('estado_captacion','=','rechazada')->get()->sortByDesc('created_at');
            return view('teo/teoHome', compact('captaciones'));
        }elseif($option == 5){
            $captaciones = CaptacionesExitosa::where('teleoperador','=',Auth::user()->id)->where('estado_captacion','=','conReparo')->get()->sortByDesc('created_at');
            return view('teo/teoHome', compact('captaciones'));
        }else if($option == 6){

            $captaciones = CaptacionesExitosa::where('teleoperador','=',Auth::user()->id)->get()->sortByDesc('created_at');
                return view('teo/teoHome', compact('captaciones'));

    }
        return($date);
    }

    public function siguiente(Request $request, $id)
    {

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

        if ($llamado1 == null) {

            $name_status = 'estado_llamada1';


        } elseif ($llamado2 == null) {
            $llamado = 'segundo_llamado';
            $name_status = 'estado_llamada2';


        } else {
            $llamado = 'tercer_llamado';
            $name_status = 'estado_llamada3';

        }

        DB::table('captaciones')
            ->where('id', '=', $id)
            ->update([
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
    {
        /**Primera parte*/
        $data = $request->all();
        $date = Carbon::now()->format('d/m/Y');


        $comunas=comunaRetiro::where('comuna','=',$request->comuna)->get()->first();
        $ciudad =$comunas->ciudad;
        $region =$comunas->region;
        if($request->tipo_retiro=="Acepta Grabacion"){

            CaptacionesExitosa::create([
                'n_dues' => $data['n_dues'],
                'id_fundacion' => $data['id_fundacion'],
                'fecha_captacion' => $date,
                'fecha_agendamiento' => $date,
                'tipo_retiro' => $data['tipo_retiro'],
                'horario' => $data['jornada'],
                'rut' => $data['rut'],
                'fono_1' => $data['fono_1'],
                'nombre' => $data['nombre'],
                'apellido' => $data['apellido'],
                'direccion' => $data['direccion'],
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
            CaptacionesExitosa::create([
                'n_dues' => $data['n_dues'],
                'id_fundacion' => $data['id_fundacion'],
                'fecha_captacion' => $date,
                'fecha_agendamiento' => $data['fecha_agendamiento'],
                'tipo_retiro' => $data['tipo_retiro'],
                'horario' => $data['jornada'],
                'rut' => $data['rut'],
                'fono_1' => $data['fono_1'],
                'nombre' => $data['nombre'],
                'apellido' => $data['apellido'],
                'direccion' => $data['direccion'],
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
            ->update([
                'estado_registro' => 0,
                'estado' => 'cu+',
                $name_status=>$t_retiro


            ]);
    /**Tercera Parte*/
        if ($data['tipo_retiro'] == "Acepta Agendamiento") {

           $id =DB::table('estado_rutas')->insertGetId([
                'primer_agendamiento' => $data['fecha_agendamiento'],
                'estado_primer_agendamiento' => 'Visita Pendiente',
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
    public function destroy($id)
    {
        //
    }
    public function editCap($id){

        $function="editar";
        $f_pago = estado::where('modulo','=','pago')->get();
        $status = estado::where('modulo', '=', 'llamado')->get();
        $estado = estado::where('modulo','=','agendamiento')->get();
        $comunas = comunaRetiro::where('region', '=', 'metropolitana')->where('ciudad', '=', 'santiago')->get();

        $minmax=maxCap::find(1);
        $capta = captacionesExitosa::findOrFail($id);
      
        return view('teo/mandatoRegistrado', compact('capta', 'comunas','status','function','estado','f_pago','minmax'));

    }
    
    public function editCapPost(Request $request){
        
        $id =$request->id_captacion;
        $editCap =CaptacionesExitosa::find($id);

            $editCap->tipo_retiro= $request->tipo_retiro;
            $editCap->comuna=$request->comuna;
            $editCap->fecha_agendamiento =$request->fecha_agendamiento;
            $editCap->horario =$request->horario;
            $editCap->rut = $request->rut;
            $editCap->jornada = $request->jornada;
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
            $editCap->edit ="editado";
        $editCap->save();

        if(Auth::user()->perfil==1){
            return redirect(url('admin/teoHome'));
        }elseif (Auth::user()->perfil==2){
            return redirect(url('teo/teoHome'));
        }

    }

    public function dispRutas(){
        $rutero= $_GET['rutero'];
        $date =$_GET['fecha'];


        $info = CaptacionesExitosa::where('fecha_agendamiento','=',$date)
                                    ->where('rutero','=',$rutero)
                                    ->where('estado_captacion','!=','rechazada')->get();

    return Response::json($info);

    }
    public function PorReagendar(){

        $porReagendar = CaptacionesExitosa::where('reagendar','=',1)->where('teleoperador','=',Auth::User()->id)->get();

        return view('teo/porReagendar',['reage'=>$porReagendar]);
    }
    public function detalleReagendamiento($id){
        $reagendamiento=CaptacionesExitosa::find($id);
        $minmax =maxCap::find(1);

        return view('teo.detalleReagendamientoTeo',['reage'=>$reagendamiento,'minmax'=>$minmax]);
    }
    public function reagendado(Request $request){

        $date =$request->fecha_reagendamiento;
        $time =$request->horario;

        $visit = estadoRuta::find($request->id_captacion);

        $visit_capta=CaptacionesExitosa::find($request->id_captacion);

        if($visit->estado_segundo_agendamiento == "noRetirado"){
            if($visit->estado_tercer_agendamiento==""){

                $visit->tercer_agendamiento = $date;
                $visit->save();

                $visit_capta->fecha_agendamiento=$date;
                $visit_capta->horario =$time;
                $visit_capta->reagendar =2;
                $visit_capta->estado_captacion="";
                $visit_capta->save();

                if(Auth::user()->perfil==1){
                    return redirect('/admin/PorReagendar');
                }elseif (Auth::user()->perfil==2){
                    return redirect('/teo/PorReagendar');
                }
            }
        }elseif($visit->estado_primer_agendamiento=="noRetirado"){
            if($visit->estado_segundo_agendamiento==""){

                $visit->segundo_agendamiento = $date;
                $visit->save();

                $visit_capta->fecha_agendamiento=$date;
                $visit_capta->horario =$time;
                $visit_capta->reagendar =2;
                $visit_capta->estado_captacion="";
                $visit_capta->save();

                if(Auth::user()->perfil==1){
                    return redirect('/admin/PorReagendar');
                }elseif (Auth::user()->perfil==2){
                    return redirect('/teo/PorReagendar');
                }
            }
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

}
