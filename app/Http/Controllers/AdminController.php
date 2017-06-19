<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

//use Request;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
//use Illuminate\Http\Request;
use app\User;


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
		//

			$usuarios = $request::all();

			$rules = array(

				'name'=>'required',
				'email'=>'required|unique:users,email',
				'perfil'=>'required',
				'estado' => 'required',
				'password'=>'required'
			);
		/*creamos una regla de validacion en al cual especificamos los campos obligatorios*/

		$v=Validator::make($usuarios, $rules);

		/*instanciamos la variable " V " y declaramos que es igual a la validacion de la regla
		que creamos arriba a la cual llamamos $regla*/

		if($v->fails()){

			return redirect()->back()
				->withErrors($v->errors())
				->withInput(Request::except('password'));
		}
			/*preguntamos con un if si la validacion falla.
				si la validacion falla nos retorna de regreso a la pagina con los errores de validacion
				pero obviando el password.

				si la validacion no falla continua con el codigo y crea un nuevo usuario*/

			User::create([
			'name' => $usuarios['name'],
			'email' => $usuarios['email'],
			'perfil'=> $usuarios['perfil'],
			'estado' => $usuarios['estado'],
			'password' => bcrypt($usuarios['password']),
		]);

		$usuarios = User::all();
		return view('admin/adminUser',compact('usuarios'));

	}


	public function show($id)
	{
		//


	}
 
	public function edit($id)
	{

		$user = User::findOrFail($id);

		return view('admin.editar', compact('user'));


    }


	public function update($id)

	{

		$usuarios =User::findOrFail($id);
		$usuarios->fill(Request::all());

		$usuarios->save();

		$usuarios= User::all();
		return view('admin/adminUser',compact('usuarios'));

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
	}

}
