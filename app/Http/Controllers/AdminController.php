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

		$v=Validator::make($usuarios, $rules);

		if($v->fails()){

			return redirect()->back()
				->withErrors($v->errors())
				->withInput(Request::except('password'));
		}

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
		//
		$usuarios =User::findOrFail($id);
		$usuarios->fill(Request::all());

		$usuarios->save();

		$usuarios= User::all();
		return view('admin/adminUser',compact('usuarios'));

	}

	public function destroy($id)
	{
		//
		$usuarios =User::findOrFail($id);

		$usuarios->delete();

		Session::flash('message', $usuarios->name.' '.'Fue Eliminad@');

		return redirect()->route('admin.user.index');
	}
	
}
