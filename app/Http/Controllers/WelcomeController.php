<?php namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
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

		if (Auth::User()->perfil == 1) {

			return view('administradorr');

		} elseif (Auth::User()->perfil == 2) {

			return view('teo/teoin');

		} elseif (Auth::User()->perfil == 3) {
			return view('home');

		} elseif (Auth::User()->perfil == 4) {
			return view('home');

		} elseif (Auth::User()->perfil == 5) {
			return view('home');

		}

	}
}