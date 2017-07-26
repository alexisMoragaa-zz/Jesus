<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

//use Request;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
//use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use app\User;
//use Illuminate\Http\Request;

class AdminController extends Controller {


	public function index(Request $request)
	{

		$usuarios = User::all()->sortByDesc('created_at');


		return view('admin/adminUser',compact('usuarios'));

/** 1 */

	}

	public function create()
	{

			return view('admin/registrar');
		
	}


	public function store(Request $request)
	{


			$usuarios = $request::all();

			$rules = array(

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

		if($v->fails()){

			return redirect()->back()
				->withErrors($v->errors())
				->withInput(Request::except('password'));
		}

/** 3 */
		$date = Carbon::now()->format('d-m-Y');


			User::create([
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
/** 4 */
	}


	public function show($id)
	{

	}
 
	public function edit($id)
	{

		$user = User::findOrFail($id);

		return view('admin.editar', compact('user'));

/** 5 */
    }


	public function update( Request $request, $id)

	{

		$usuario =User::findOrFail($id);

		$usuario->fill(Request::all());

		$usuario->save();

		$usuarios= User::all();
		return view('admin/adminUser',compact('usuarios'));
/** 6 */
	}
	public function updatePass(Request $request, $id){

		$pass=$request::input('in_pass');

		$update= DB::table('users')
			->where('id','=',$id)
			->update([
				'password'=>bcrypt($pass)
			]);

		$usuarios= User::all();
		return view('admin/adminUser', compact('usuarios'));
/** 7 */
		}
	public function destroy($id)
	{
		//METODO PARA ELIMINAR UN USUARIO
		 /** EN FUTURAS MODIFICACIONES SE IMPLEMENTARA EL BORRADO LOGICO Y FISICO DE LOS USUARUIOS PARA MAYOR SEFGURIDAD
		 **/
		$usuarios =User::findOrFail($id);

		$usuarios->delete();

		Session::flash('message', $usuarios->name.' '.'Fue Eliminad@');

		return redirect()->route('admin.user.index');
/** 8 */
	}

/**
 * 1. function index() guardamos el valor de todos los usuarios en la variable users, y los enviamos a la vista mediante el metodo compact()
 * 2. function store se establece un array con las reglas de validacion que devera cumplir el usuario
 * 3. function store creams una variable v y la igualamos a la valudacion usando el objeto validate, y el metodo make ($v=Validator::make($usuarios, $rules);)
  	  	con un if consultamos el resultado de la validacion, y retornamos los errores enn caso de que existan. de lo contrario continuamos con la
    	la ejecucion del programa.
 * 4. function store despues de validar usando el metodo create obtenemos la informacion del formulario y la enviamos a la basxe de datos. y repetipos el punto 1
 * 5. function edit usando el metodo findOrFail() encontramos el usuario espesifico que deseamos actualizar y lo retornamos a la vista de update
 * 6. function update capturamos la informacion del formulario con fillrequest, y con save guardamos la informacion en el usuario seleccionado con el metodo findOrFail
 * 7. function updatePass usando query builder seleccionamos la tabla y el medoto que deseamos realizar, luego mediannte la sentencia where
 		seleccionamos el objeto y los campos que deseamos actualizar. luego repetimos el punto 1
 * 8. function destroy seleccionamos el usuario con findOrFail() y luefo con el metodo delete() eliminamos el usuario.
  		finalmente con Sesion enviamos un mensaje a la vista, y  finalmente redireccionamos a index
 */

}
