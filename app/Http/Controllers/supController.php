<?php namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;
//use Illuminate\Support\Facades\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Campana;
//use DB;

use Illuminate\Http\Request;

class supController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$usuarios=User::all();
		/*guardamos en la variable usuario toda la data correspondiente al modelo usuario*/


		$User_Campana = DB::table('campanas')
			->join('users','campanas.id','=','users.campana')
			->select('campanas.*','users.*')
			->get();
			/*en la variable user_campana guardamos la informacionnresultante de la consulta join realizada con query builder
			la cual pasamos a la vista con el metodo compact al igual que la variable usuarios*/
		return view('sup/supervisor',compact('User_Campana','usuarios'));
		//
	}
	public function detalleUser($id)
	{
		$usuarios = User::findOrFail($id);//encontramos el usuario mediante el id

		$campanas = Campana::all();//enviamos toda la data de campaña

		return view('sup/detalleUser', compact('usuarios','campanas'));
		/*este metodo se encarga de retornar a la vista detalleUser las campañas en las
		cuales trabajo un usuario en particular*/
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create($id)
	{

		$usuarios = User::findOrFail($id);

		return view('sup/detalleUser', compact('usuarios'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store($id)
	{
		//


		$usuarios = User::findOrFail($id);

		return view('sup/detalleUser', compact('usuarios'));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(Request $request,$id)
	{
			/*creamos una variable usuario en la cual guardamos toda la informacin de
		 	la data correspondiente al id que enviamos como parametro atraves de la url*/
		$usuarios = User::findOrFail($id);
		
			/*almacenamos en la variable id_camapana el id de la campaña que deseamos incluir
			el cual enviamos atracves de un formulario con el metodo put. y lo rescatamos e}con el objeto request
			y hacemos lo mismo para la variable fecha_inicio*/

		$id_campana = $request->input('campanas');
		$fecha = $request->input('fecha_inicio');

			/*usando la variable user. que igualamos al objeto usuario de el modelo User accedenos al metodo "campanitas"
			el cual se encuentra declarado ebn el modelo user para la relacion many to many y con el metodo atach enviamos los valores correspondientes
			mediante un array de datos en el caso de que existan datos adicionales en la tavbla pivote, como es el caso*/

		 $usuarios->campanitas()->attach($id_campana,['fecha_inicio'=>$fecha]);


			/*Originalmente luego de procesar el la informacion del formulario nos redireccionabha ala misma pagina con los datos actualizados
			pero al hacer esto teniamos un bug el cual insertaba el registro inmediatamente anterior cada vez quye se refrescaba la pagina.
			es decir: si nosotros insertabamos un registro y despues refrescabamos la pagina  el ultimo registro se insdertaba nuevamente.
			y al no insertar registros la pagina se refresca con normalidad. es pro ersto que ahora nos redirige a la pagina de sup/supervisor. y con esto evitamos este bug*/

		$User_Campana = DB::table('campanas')
			->join('users','campanas.id','=','users.campana')
			->select('campanas.*','users.*')
			->get();

		return view('sup/supervisor',compact('User_Campana','usuarios'));
		
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}
