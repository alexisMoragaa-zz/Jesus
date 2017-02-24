<!DOCTYPE html>
<html lang="en">
<header>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Laravel</title>
    
	<link href="{{ asset('/css/app.css') }}" rel="stylesheet">

	<!-- Fonts -->
	<link href='//fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
<style>	
	
body {
	 background: #CCCACA;	 
}
header {
	 background: #CCCACA;	
}

ul .nav{
	background: #F96400;
}	 
nav .nav{
	background: #F96400;
}
div .collapse {
	background: #F96400;	
}	
div .navbar-brand {
	background: #F96400;
}	
div .navbar-header {
	background: #F96400;	
}	
nav{
    background: #F96400;
    padding:10px;
    margin-bottom: 20px;
    border-radius:10px;/*El estandar por defecto*/
    background-image: -webkit-gradient(linear, left top, left bottom, from(#F96400), to(#F96400));/*Para chrome y Safari*/
    /*Degradados*/
    background-image: -moz-linear-gradient(top, #F96400, #F96400);/*Para Firefox*/
    background-image: -o-linear-gradient(top, #F96400, #F96400);/*Para Opera*/
    background-image: linear-gradient(top, #F96400, #F96400);/*El estandar por defecto*/	
}
footer{
width:100%;
margin-top:2%; 
background:#F96400;
display: block;
}

div .logo{
	width:10%;
    margin:0%0%2%42%;
 }

}
</style>
<nav class="">
		<div class="container-fluid">
			<div class="navbar-header">
				<a class="navbar-brand" href="#">Dues</a>
			</div>

			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav">
					<li><a href="{{ url('/') }}">Inicio</a></li>
				</ul>

				<ul class="nav navbar-nav navbar-right">
					@if (Auth::guest())
						<li><a href="{{ url('/auth/login') }}">Ingresar</a></li>

					@else

						@if(Auth::user()->perfil==1)

								<ul class="nav navbar-nav">
					        		<li><a href="{{ url('/admin/user') }}">Usuarios</a></li>
					         		<li><a href="{{ url('/admin/call') }}">TeleOperador</a></li>
				       		 		<li><a href="{{ url('/admin/sup') }}">Supervisor</a></li>
				            		<li><a href="{{ url('/admin/ope') }}">Operaciones</a></li>
				            		<li><a href="{{ url('/admin/rutas') }}">Ruteros</a></li>
									<li><a href="{{ url('/admin/cargas') }}">Cargas</a></li>
								</ul>

							@elseif(Auth::user()->perfil==2)

								<ul class="nav navbar-nav">
					         		<li><a href="{{ url('/admin/call') }}">TeleOperador</a></li>
				            	</ul>

							@elseif(Auth::user()->perfil==3)

								<ul class="nav navbar-nav">
					         		<li><a href="{{ url('/sup/sup') }}">Supervisor</a></li>
					         		<li><a href="{{ url('/sup/call') }}">TeleOperador</a></li>
				           	 	</ul>

				            @elseif(Auth::user()->perfil==4)

				            	<ul class="nav navbar-nav">
				            		<li><a href="{{ url('/ope') }}">Operaciones</a></li>
				            		<li><a href="{{ url('/ope/call') }}">TeleOperador</a></li>
				       		 		<li><a href="{{ url('/ope/sup') }}">Supervisor</a></li>
				            	</ul>

				            @elseif(Auth::user()->perfil==5)

				            	<ul class="nav navbar-nav">
				            		<li><a href="{{ url('/rutas') }}">Rutas</a></li>
				            	</ul>
				        @endif

						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{ Auth::user()->name }} <span class="caret"></span></a>
							<ul class="dropdown-menu" role="menu">
								<li><a href="{{ url('/auth/logout') }}">Salir</a></li>
							</ul>
						</li>
					@endif
				</ul>
			</div>
		</div>
	</nav>
	<div >
    <img class="logo" src="../../imagenes/imgDues.png"> </img>
    
    </div>
	
</header>
<body>
@yield('content')



	<!-- Scripts -->
	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>

</body>


<footer>
<p></br></p>
<p></br></p>
<p></br></p>
<p></br></p>
<p></br></p>
</footer>
</html>
