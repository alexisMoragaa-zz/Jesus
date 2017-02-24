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
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
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
