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

		$usuarios =User::all();
		return view('admin/adminUser', compact('usuarios'));
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
		/*creamos una regla de validacion en al cual especificamos los campos obligatorios*/

		$v=Validator::make($usuarios, $rules);

		/*instanciamos la variable " V " y declaramos que es igual a la validacion de la reglaque creamos arriba a la cual llamamos $regla*/


		if($v->fails()){

			return redirect()->back()
				->withErrors($v->errors())
				->withInput(Request::except('password'));
		}
			/*preguntamos con un if si la validacion falla.
				si la validacion falla nos retorna de regreso a la pagina con los errores de validacionpero obviando el password.
				si la validacion no falla continua con el codigo y crea un nuevo usuario*/


		$date = Carbon::now();
			User::create([
				'name' => $usuarios['name'],
				'last_name' => $usuarios['last_name'],
				'rut' => $usuarios['rut'],
				'dv' => $usuarios['dv'],
				'perfil'=> $usuarios['perfil'],
				'email' => $usuarios['email'],
				'direccion' =>$usuarios['direccion'],
				'telefono' => $usuarios['telefono'],
				'afp' => $usuarios['afp'],
				'previcion'=>$usuarios['previcion'],
				'nombre_isapre' =>$usuarios['nombre_isapre'],
				'turno' =>$usuarios['turno'],
				'estado' => $usuarios['estado'],
				'tipo_cuenta'=>$usuarios['tipo_cuenta'],
				'n_cuenta' =>$usuarios['n_cuenta'],
				'fecha_ingreso'=>$date,
				'password' => bcrypt($usuarios['password']),
		]);

		$usuarios = User::all();
		
		return view('admin/adminUser',compact('usuarios'));

	}


	public function show($id)
	{
		


	}
 
	public function edit($id)
	{

		$user = User::findOrFail($id);

		return view('admin.editar', compact('user'));


    }


	public function update( Request $request, $id)

	{

		$usuario =User::findOrFail($id);

		$usuario->fill(Request::all());

		$usuario->save();

		$usuarios= User::all();
		return view('admin/adminUser',compact('usuarios'));

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
		}



		/*$usuario->fill(Request::all());

		$usuario->save();

		$usuarios= User::all();
		return view('admin/adminUser',compact('usuarios'));
		*/


	public function destroy($id)
	{
		//METODO PARA ELIMINAR UN USUARIO
		 /** EN FUTURAS MODIFICACIONES SE IMPLEMENTARA EL BORRADO LOGICO Y FISICO DE LOS USUARUIOS PARA MAYOR SEFGURIDAD
		 **/
		$usuarios =User::findOrFail($id);

		$usuarios->delete();

		Session::flash('message', $usuarios->name.' '.'Fue Eliminad@');

		return redirect()->route('admin.user.index');
	}

}
