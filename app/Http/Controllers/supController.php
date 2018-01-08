<?php namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
//use Illuminate\Support\Facades\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Campana;
use Carbon\Carbon;
//use DB;

use Illuminate\Http\Request;

class supController extends Controller {


	public function index(Request $request)
	{



		$User_Campana = DB::table('campanas')
			->join('users','campanas.id','=','users.campana')
			->select('campanas.*','users.*')
			->get();
			/*en la variable user_campana guardamos la informacionnresultante de la consulta join realizada con query builder
			la cual pasamos a la vista con el metodo compact al igual que la variable usuarios*/
		return view('sup/supervisor',compact('User_Campana'));

	}
	public function detalleUser($id)
	{
		$usuarios = User::findOrFail($id);//encontramos el usuario mediante el id



		//$campanas = Campana::orderBy('created_at','ASC');

		//$campanas = \DB::table('campanas')->orderBy('created_at');
		return view('sup/detalleUser', compact('usuarios','campanas'));


		/*este metodo se encarga de retornar a la vista detalleUser las campañas en las
		cuales trabajo un usuario en particular*/
	}

	public function create($id)
	{

		$usuarios = User::findOrFail($id);

		return view('sup/detalleUser', compact('usuarios'));
	}


	public function store($id)
	{

		$usuarios = User::findOrFail($id);

		return view('sup/detalleUser', compact('usuarios'));
	}


	public function show($id)
	{
		//
	}


	public function edit(Request $request,$id)
	{
		$usuarios =User::findOrFail($id);
		$campanas =Campana::all();
		return view('sup/addCampain',compact('usuarios','campanas'));
	}


	public function updatePivot(Request $request,$user_id, $pivot_id){

		/*
		 * $pivote=1;
			$valor ="yo se";
			$usuarios =User::findOrFail($user_id);

			$motivo=$request->input('motivo_termino');

			$usuarios->campanitas()->updateExistingPivot($pivote,array( $valor));

			$motivo=$request->input('motivo');
			$updates = DB::table('campana_user')
						->where('id', '=',$pivot_id)
						->update([
							'motivo_termino' => $motivo

							]);
		 * return"hola mundo";
		 */
		return view('sup/UpdatePivot',compact('pivot_id','user_id'));
	}

	public function updatepivot2(Request $request){

			$user_id = $request->input("user_id");
			$id = $request->input('pivote');
			$motivo = $request->input('motivo');

			$num =1;

			$date = Carbon::now();

			$updates = DB::table('campana_user')
				->where('id', '=',$id)
				->update([
					'motivo_termino' => $motivo,
					'fecha_termino' =>$date

				]);

			$usuario = User::findOrFail($user_id);
			$usuario->campana = 1;
			$usuario->save();

	if(Auth::User()->perfil==1){
		return redirect('admin/detalle'.$user_id);
	}elseif (Auth::User()->perfil==3) {
		return redirect('sup/detalle'.$user_id);
	}


	}

	public function update(Request $request,  $id)
	{
			/*creamos una variable usuario en la cual guardamos toda la informacin de
		 	la data correspondiente al id que enviamos como parametro atraves de la url*/
		$usuarios = User::findOrFail($id);

			/*almacenamos en la variable id_camapana el id de la campaña que deseamos incluir
			el cual enviamos atracves de un formulario con el metodo put. y lo rescatamos con el objeto request
			y hacemos lo mismo para la variable fecha_inicio*/

		$id_campana = $request->input('campanas');
		$fecha = $request->input('fecha_inicio');

			/**usando la variable user. que igualamos al objeto usuario de el modelo User accedenos al metodo "campanitas"
			el cual se encuentra declarado ebn el modelo user para la relacion many to many y con el metodo atach enviamos los valores
			correspondientes mediante un array de datos en el caso de que existan datos adicionales en la tavbla pivote, como es el caso*/

		 $usuarios->campanitas()->attach($id_campana,['fecha_inicio'=>$fecha]);

		/**luego de guardar la informacion de la relacion actualizamos el campo campana actual de la tabla usuarios para que refleje la campaña
		 recien agregada.*/
		$usuarios->campana=$id_campana;
		$usuarios->save();

		/**por ultimo si el perfil de usuario es 1 redireccionamos al grupo de rutas admin. por el contrario si el perfil es 3
		 se le redirecciona al grupo de rutas supervisor*/

		if(Auth::User()->perfil==1) {
			return redirect('admin/detalle' . $usuarios->id);
		}
		elseif(Auth::User()->perfil==3) {
			return redirect('sup/detalle' . $usuarios->id);
		}
	}


	public function destroy($id)
	{
		//
	}

}
