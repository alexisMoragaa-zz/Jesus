<?php namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
//use Request;
//use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\User;
use App\comunaRetiro;
use App\fundacion;
use App\Campana;

//use Illuminate\Http\Request;

class AdminController extends Controller {


	public function index(Request $request)
	{//funcion que nos retorna los usuarios registrados en el sistema
		$usuarios = User::all()->sortByDesc('created_at');//seleccionamos todos los usuarios
		return view('admin/adminUser',compact('usuarios'));//retornamos la vista con los usuarios
/** 1 */
	}

	public function create()
	{//funcion con la cual retornamos la vista para registrar usuarios
			return view('admin/registrar');//retornamos la vista
	}

	public function store(Request $request)
	{//funcion con la cual registramos un nuevo usuario en la plataforma

			$usuarios = $request::all();//asignamos todo el request a la variable usuarios

			$rules = array(//establecemos reglas de validacion para nuestro request
//si alguna de estas reglas no se cumple se nos retornara a la pagina anterior con la notificacion
				'name'=>'required',
				'last_name'=>'required',
				'rut'=>'required|max:8',
				'dv'=>'required|max:2',
				'perfil'=>'required',
				'email'=>'required|unique:users,email',
				'direccion'=>'required',
				'telefono'=>'required','numeric',
				'afp' =>'required|min:4',
				'previcion'=>'required',
				'nombre_isapre'=>'required_if:previcion,isapre',
				'turno'=>'required',
				'estado'=>'required',
				'tipo_cuenta'=>'required',
				'n_cuenta' =>'required|numeric',
				'password'=>'required'
			);

/** 2  */

		$v=Validator::make($usuarios, $rules);
//una vez terminada las reglas de validacion las ejecutamos con validator::make pasandole
//como parametro el request y las reglas
		if($v->fails()){
		//preguntamos si la validacion falla y ejecutamos el bloque de codigo en caso de que falle
			return redirect()->back()//retornamos a la pagina anterior
				->withErrors($v->errors())//retornamos con los errores
				->withInput(Request::except('password'));//retornamos el contenido exceptuando el password
		}

/** 3 */
		$date = Carbon::now()->format('d-m-Y');//seleccionamos la fecha actual con el formato dia mes año


			User::create([//usamos el metodo create para crear un nuevo usauario una vez pasada las validaciones
				'name' 				=> $usuarios['name'],
				'last_name' 		=> $usuarios['last_name'],
				'rut' 				=> $usuarios['rut'],
				'dv' 				=> $usuarios['dv'],
				'perfil'			=> $usuarios['perfil'],
				'email' 			=> $usuarios['email'],
				'direccion' 		=> $usuarios['direccion'],
				'telefono' 			=> $usuarios['telefono'],
				'afp' 				=> $usuarios['afp'],
				'previcion'			=> $usuarios['previcion'],
				'nombre_isapre' 	=> $usuarios['nombre_isapre'],
				'turno' 			=> $usuarios['turno'],
				'estado' 		   	=> $usuarios['estado'],
				'fecha_nacimiento' 	=> $usuarios['fecha_nacimiento'],
				'tipo_cuenta'		=> $usuarios['tipo_cuenta'],
				'n_cuenta' 			=> $usuarios['n_cuenta'],
				'fecha_ingreso'		=> $date,
				'password' 			=> bcrypt($usuarios['password']),
		]);

		return redirect()->route('admin.user.index');
		//redireccionamos al index, que nos retornara la pagina con el listado de usuarios
/** 4 */
	}

	public function show($id)
	{
	}

	public function edit($id)
	{//funcion con la que seleccionamos el usuario que deseamos editar
		$user = User::findOrFail($id);//seleccionamos el usuario
		return view('admin.editar', compact('user'));//retornamos el usuario a la vista para actualizarlo
/** 5 */
    }

	public function update( Request $request, $id)
	{//funcion con la cul actualizamoa el usuario
		$usuario =User::findOrFail($id);//seleccionamos el usuario
		$usuario->fill(Request::all());//con el metodo fill pareamos todos los campos con el request
		$usuario->save();//guardamos los cambios
		$usuarios= User::all();
		return redirect()->route('admin.user.index');
		//redireccionamos al index, que nos retornara la pagina con el listado de usuarios

/** 6 */
	}

	public function updatePass(Request $request, $id){
//funion para actualizar el password de un usuario
		$pass=$request::input('in_pass');//tomamos el valor del password enviado en el request

		$update= DB::table('users')//usamos el metodo update para actualizar el password
			->where('id','=',$id)//seleccionamos el regitro que deseamos actualizar
			->update([//actualizamos los campos deseados
				'password'=>bcrypt($pass)//seleccionamos el campo y añadimos el valor,
			]);//en este caso pasamos la contraseña por un hash para de esta forma guardarla encriptada en la base de datos

			return redirect()->route('admin.user.index');
			//redireccionamos al index, que nos retornara la pagina con el listado de usuarios
/** 7 */
		}
	public function destroy($id)
	{//funcion para eliminar un usuarios
		//no se recomeinda usar esta funcion ya que acarrea problemas en las relaciones
		$usuarios =User::findOrFail($id);//selecionamos el usuario

		$usuarios->delete();//eliminamos el usuario usando el metodo delete

		Session::flash('message', $usuarios->name.' '.'Fue Eliminad@');
		//pasamos un mensaje a la session en la cual mostramos el nombre del usuario eliminado con un mensaje de exito
		return redirect()->route('admin.user.index');
		//redireccionamos a index donde se retornara la lista de usuarios registrados
/** 8 */
	}

	public function adminConfig(){
//funcion que nos retorna la vista para las configuraciones de administrador
		return view('admin/configAdmin');
	}
/** 9 */
	public function create_status(Request $request){
	//funcion que nos permite crear un estado
		$estado=Request::input('name-status');//seleccionamos el valor de name-status del request
		$tipo=Request::input('tipo');//seleccionamos el tipo de estado del request

		DB::table('estados')->insert(//usamos el metodo insert para crear un nuevo estadp
		['estado'=>$estado,//asignamos el valor de la variable estado al campo estado
		  'modulo'=>'llamado',//asignamos el valor de lamado al campo modulo
		   'tipo'=>$tipo]//asignamos el valor de la variable tipo al campo tipo
		);
		return view('administradorr');//retornamos la vista de administradorr
	}
/** 10 */

	public function create_status_retirement(){
//funcion para crear estados de retiro
		$estado=Request::input('name-status');//seleccionamos el estdo del request

		DB::table('estados')->insert(//usamos el metodo insert para crar un nuevo estado
			['estado'=>$estado,//le pasamos los valores
				'tipo'=>'Estado de Retiros']
		);
		return view('administradorr');//retornamos la vista
	}
/** 11 */
	public function create_status_payment_method(){

		$estado=Request::input('name-method');

		DB::table('estados')->insert(
			['estado'=>$estado,
				'tipo'=>'Forma de Pago']
		);
		return view('administradorr');
	}

	public function admin(){

		return view('administradorr');
	}


	public function rutas(){

		$comunas = comunaRetiro::where('region','=','metropolitana')->where('ciudad','=','santiago')->get();
		$ruteros =User::where('perfil','=','5')->get();

		return view('operac/crearRutas',compact('comunas','ruteros'));
	}

	public function addcomuna(){

		$id=Request::input('comunas');
		$rutero = Request::input('name_rutero');
		$lunes = Request::input('checkbox1');
		$martes =Request::input('checkbox2');
		$miercoles=Request::input('checkbox3');
		$jueves=Request::input('checkbox4');
		$viernes=Request::input('checkbox5');

		$update =  comunaRetiro::find($id);

		if($lunes){
			$update->lunes=1;
			$update->h_lunes=Request::input('lunes_de')." - ".Request::input('lunes_a');
		}else{
			$update->lunes=0;

		}
		if($martes){
			$update->martes=1;
			$update->h_martes=Request::input('martes_de')." - ".Request::input('martes_a');
		}else{
			$update->martes=0;

		}
		if($miercoles){
			$update->miercoles=1;
			$update->h_miercoles=Request::input('miercoles_de')." - ".Request::input('miercoles_a');

		}else{
			$update->miercoles=0;

		}
		if($jueves){
			$update->jueves=1;
			$update->h_jueves=Request::input('jueves_de')." - ".Request::input('jueves_a');
		}else{
			$update->jueves=0;

		}
		if($viernes){
			$update->viernes=1;
			$update->h_viernes=Request::input('viernes_de')." - ".Request::input('viernes_a');
		}else{
			$update->viernes=0;
		}


		$update->rutero=$rutero;

		$update->save();

if(Auth::user()->perfil==4){
	return redirect()->to('ope/createRutas');

}elseif (Auth::user()->perfil==1) {
	# code...
	return redirect()->to('admin/createRutas');
}

}


public function foundations(){
//funcion que retorna una pagina con todas las fundaciones actualmente registradas
	$fundaciones = fundacion::where('id','!=',1)->get()->sortByDesc('created_at');//seleccionamos todas las fundaciones
	return view('admin.fundaciones',[//retornamos la vista con las fundaciones
		'fundaciones'=>$fundaciones
	]);
}

public function createFoundation(Request $request){
	//funcion para crear o registrar una nueva fundacion
	$fundacion = new fundacion;//creamos una nueva instancia del modelo fundacion
	$fundacion->nombre = $request::get('name_foundation');//asignamos los valores con los obtenidos del request
	// dd($request::get('name_foundation'));
	$fundacion->fono = $request::get('fono');
	$fundacion->email = $request::get('email');
	$fundacion->razon_social =$request::get('socialReason');
	$fundacion->rut = $request::get('dni');
	$fundacion->direccion =$request::get('adress')." #".$request::get('number');
	if($request::get('agendamiento')) //validamos si el campo esta checkeado y agregamos un 1
		$fundacion->agendamiento = 1;//si no esta checkeado pasamos a la siguiente validacion dejando en blanco

	if($request::get('upgrade'))
		$fundation->upgrade = 1;

	if($request::get('regiones'))
		$fundacion->regiones =1;

		$fundacion->save();//guardamos los cambios en el modelo de fundacion y etornamos la funcion fundations

		return redirect('admin/foundations');
	}

public function showFoundation($id){
//funcion que retorna una vista con todos los datos detallados de una fundacion
	$registro = fundacion::find($id);//seleccionamos la fundacion que deseamos registrar
	$campanas = Campana::where('fundacion','=',$registro->id)->get()->sortByDesc('created_at');
	return view('admin.fundacion',[//enviamos los datos a la vista
		'registro'=>$registro,
		'campanas'=>$campanas,
	]);
}

public function createCampana(Request $request){//tomamos el request de datos desde el formulario
	//funcion para crear una nueva campaña asociada a la fundacion desde la cual creamos la campaña
	$campana = new Campana;//creamos una nueva instancia de la clase campana
	$campana->fundacion = $request::get('fundacion');//asignamos el id de la fundacion
	$campana->nombre_campana = $request::get('nombre');//asignamos el nombre d ela campana
	$campana->ubicacion = $request::get('ubicacion');//asignamos la ubicacion
	$campana->save();//guardamos los cambios

	return redirect('/admin/foundation/show/'.$request::get('fundacion'));
	//retornamos la funcion fundaciones la cual nos retornara una vista con todas las fundaciones
}

/**
 * 1. function index() guardamos el valor de todos los usuarios en la variable users, y los enviamos a la vista mediante el metodo compact()
 * 2. function store se establece un array con las reglas de validacion que devera cumplir el usuario
 * 3. function store creams una variable v y la igualamos a la valudacion usando el objeto validate, y el metodo make ($v=Validator::make($usuarios, $rules);)
  	  	*con un if consultamos el resultado de la validacion, y retornamos los errores enn caso de que existan. de lo contrario continuamos con la
    	*la ejecucion del programa.
 * 4. function store despues de validar usando el metodo create obtenemos la informacion del formulario y la enviamos a la basxe de datos. y repetipos el punto 1
 * 5. function edit usando el metodo findOrFail() encontramos el usuario espesifico que deseamos actualizar y lo retornamos a la vista de update
 * 6. function update capturamos la informacion del formulario con fillrequest, y con save guardamos la informacion en el usuario seleccionado con el metodo findOrFail
 * 7. function updatePass usando query builder seleccionamos la tabla y el medoto que deseamos realizar, luego mediannte la sentencia where
 		*seleccionamos el objeto y los campos que deseamos actualizar. luego repetimos el punto 1
 * 8. function destroy seleccionamos el usuario con findOrFail() y luego con el metodo delete() eliminamos el usuario.
  		*finalmente con Sesion enviamos un mensaje a la vista, y redireccionamos a index
 * 9. 10. 11.
 * 		los metodos del 9 al 11 insertan cada uno un valor respectivo a la tabla estados, y con esto conseguimos que el usuario
 * 		de tipo administrador pueda añadir nuevos estados  a los formularios ya existentes sin necesidad de reprogramar o
 * 		añadir codigo.
 */

}
