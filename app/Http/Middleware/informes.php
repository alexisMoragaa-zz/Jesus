<?php namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Session;
class informes {

	protected $auth;
	public function __construct(Guard $auth)
	{

		$this->auth = $auth;
	}
	public function handle($request, Closure $next)
	{
		switch ($this->auth->user()->perfil) {

			case '1':

				return redirect()->to('administradorr');
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
			case '6':

				// return redirect()->to('informes');
				break;
			default:
			return 'Usuario no autorizado';
				# code...
				break;
		}

		return $next($request);

	}
	}
