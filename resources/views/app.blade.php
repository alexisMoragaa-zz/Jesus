<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Dues Ltda</title>

	<link href="{{ asset('/css/app.css') }}" rel="stylesheet">
	<link href="{{ asset('/css/style.css') }}" rel="stylesheet">
	<link href="{{ asset('/css/tablas.css') }}" rel="stylesheet">
	<link href='//fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>

	<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>

	<script src="{{asset('plugins/jquery/jquery-3.2.1.js')}}"></script>

	<script src="{{asset('plugins/tablesorter/jquery.tablesorter.min.js')}}"></script>
	<script src="{{asset('plugins/jqueryRut/jquery.rut.js')}}"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>
	<![endif]-->
</head>


<nav class="navbar navbar-default">
	<div class="container-fluid">
		<!-- Brand and toggle get grouped for better mobile display -->
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="#">Dues</a>
		</div>

		<!-- Collect the nav links, forms, and other content for toggling -->
		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

			<!-- podrian ser utiles mas adelante
			<ul class="nav navbar-nav">
				<li class="active"><a href="#">Link <span class="sr-only">(current)</span></a></li>
				<li><a href="#">Link</a></li>

			</ul>-->

			<ul class="nav navbar-nav navbar-right">
				@if (Auth::guest())
					<li><a href="{{ url('/auth/login') }}">Ingresar</a></li>

				@else
					@if(Auth::user()->perfil==1)
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Administrador <span class="caret"></span></a>
							<ul class="dropdown-menu">
								<li><a href="{{ url('/admin/rutas') }}">Modificar Rutas</a></li>
								<li><a href="{{ url('/admin/adminconfig') }}">Añadir Estados</a></li>
							</ul>
						</li>
						<li><a href="{{ url('/admin/user') }}">Usuarios</a></li>
						<li><a href="{{ url('/admin/teoHome') }}">TeleOperador</a></li>
						<li><a href="{{ url('/admin/sup') }}">Supervisor</a></li>

						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Operaciones <span class="caret"></span></a>
							<ul class="dropdown-menu">
								<li><a href="{{ url('/admin/ope') }}">Captaciones</a></li>
								<li><a href="{{ url('/admin/verRutas')}}">Rutas</a></li>
							</ul>

						</li>

						<li><a href="{{ url('/admin/verRutas') }}">Ruteros</a></li>
						<li><a href="{{ url('/admin/cargas') }}">Cargas</a></li>

					@elseif(Auth::user()->perfil==2)
						<li><a href="{{ url('/teo/call') }}">TeleOperador</a></li>

					@elseif(Auth::user()->perfil==3)
						<li><a href="{{ url('/sup/user') }}">Usuarios</a></li>
						<li><a href="{{ url('/sup/sup') }}">Supervisor</a></li>
						<li><a href="{{ url('/sup/call') }}">TeleOperador</a></li>

					@elseif(Auth::user()->perfil==4)
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Operaciones <span class="caret"></span></a>
							<ul class="dropdown-menu">
								<li><a href="{{ url('/ope/ope') }}">Captaciones</a></li>
								<li><a href="{{ url('/ope/verRutas')}}">Rutas</a></li>
							</ul>

						</li>
						<li><a href="{{ url('/ope/call') }}">TeleOperador</a></li>
						<li><a href="{{ url('/ope/sup') }}">Supervisor</a></li>

					@elseif(Auth::user()->perfil==5)

						<li><a href="{{ url('/rutas') }}">Rutas</a></li>
					@endif
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{{ Auth::user()->name }}<span class="caret"></span></a>
							<ul class="dropdown-menu">
								<li><a href="{{ url('/auth/logout') }}">Salir</a></li>
							</ul>
						</li>
					@endif
			</ul>

		</div><!-- /.navbar-collapse -->
	</div><!-- /.container-fluid -->
</nav>
<div >
	<img class="logo" src="/imagenes/imgdues1.png"> </img>
</div>
@yield('content')
<footer >
	<p class="textoFooter">Dues Limitada Todos Los Derechos Reservados</p>
	<p class="textoFooter">Programador y Desarrollador <strong>Alexis Moraga Gallardo</strong></p>

</footer>
		<!-- Scripts -->

</body>
</html>