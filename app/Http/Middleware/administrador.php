<?php namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Session;
class administrador {



protected $auth;
public function __construct(Guard $auth)
{

	$this->auth = $auth;
}

	/**
	 *EL Middleware funciona como una especia de filtro entre la vista y el controlador.
	 * por ejemplo en este caso estamos restringiendo el acceso de usuarios a rutas del webside a las que pos sus privilegios
	 * no estan autorizados para ingresar
	 *
	 * 		*para esto planteamos un switch en el cvual especificamos donde nos redireccionara en caso de no  tener privilegios para
	 * 		visitar dicha ruta.
	 *
	 * 		en este caso si el usuario tiene el perfil 1(administrador) la linea se comenta. esto es para evitar un bucle infinito en el cual
	 * 		el middleware pregunta que usuario es, y al ser usuario 1 redirecciona, y luego repite la pregunta.
	 * 		es por esto que en cada caso se deve dejar comentado segun corresponda
	 */
	public function handle($request, Closure $next)
	{
		switch ($this->auth->user()->perfil) {

			case '1':
				# code...
				//return redirect()->to('administradorr');
				break;
			case '2':

				return redirect()->to('teo');

				break;
			case '3':
				return redirect()->to('sup');
				break;
			case '4':
				return redirect()->to('ope');
				break;
			case '5':
				return redirect()->to('rutas');
				break;
			default:
			return 'Usuario no autorizado';
				# code...
				break;
		}

		return $next($request);

	}

}
