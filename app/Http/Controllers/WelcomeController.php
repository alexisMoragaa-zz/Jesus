<?php namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\CaptacionesExitosa;
class WelcomeController extends Controller
{


	/**
	 *este controlador funciona como filtro, cada vez que se ingrese una url
	 * vacia este controlador se encargara a redirigirlo a una pagina en particular
	 * segun el perfil de cada usuario
	 */

	public function __construct()
	{
		$this->middleware('auth');
	}



	public function index()
	{
		$captaciones =CaptacionesExitosa::where('teleoperador','=',Auth::user()->id);


		if (Auth::User()->perfil == 1) {

			return view('administradorr');

		} elseif (Auth::User()->perfil == 2) {

			return redirect('teo/teoHome');

		} elseif (Auth::User()->perfil == 3) {
			return view('home');

		} elseif (Auth::User()->perfil == 4) {
			return redirect('/home');

		} elseif (Auth::User()->perfil == 5) {
			return view('home');

		}

	}
}
