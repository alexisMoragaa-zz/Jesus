
@extends('app')

@section('content')
<link href="{{ asset('/css/style.css') }}" rel="stylesheet">



        @if(Session::has('message'))

            <div class="container alert alert-success"> <p style="text-align: center">{{Session::get('message')}}</p></div>
        @endif

	
		
<div class="container">

	@if(Auth::user()->perfil==1)
		<a class="btn btn-info" href="{{ route('admin.user.create') }}" role="button" style="margin:5px; margin-left: 85%;">Registrar Usuario</a>

	@elseif(Auth::user()->perfil==3)
		<a class="btn btn-info" href="{{route('sup.user.create')}}" style="margin:5px; margin-left: 89%;">Registrar</a>
	@endif

<div class="panel panel-default">

			<div class="table-responsive">

				<!--creamos un atabla para mostrar la informacuion de los usuarios registrados en nuestro sistema -->
  			<table class="table table-bordered">
   				<tr>
   					<th>Nombres</th>
   					<th>Correo</th>
   					<th>Perfil</th>
   					<th>Accion</th>
   				</tr>
						<!--con un foreach recorremos todos los usuarios  y los mostramos en la tabla a continuacion -->

					@foreach($usuarios as $User)
   						<tr data-id="{{$User->id}}">
   							<td>{{  $User->name }}</td>
   							<td>{{ $User->email }}</td>
   							<td>@if($User->perfil ==1)
										Administrador
									@elseif($User->perfil ==2)
										TeleOperador
									@elseif($User->perfil ==3)
										Supervisor
									@elseif($User->perfil ==4)
										Operaciones
									@elseif($User->perfil ==5)
										Ruteros
									@else
									{{$User->perfil}}
									@endif
								</td>
   							<td style="text-align: center">
								@if(Auth::user()->perfil==1)
                        			<a href="{{ route('admin.user.edit',$User->id)}}">Editar/Eliminar</a>
								@elseif(Auth::user()->perfil==3)
									<a href="{{ route('sup.user.edit',$User->id)}}">Editar/Eliminar</a>
								@endif
								<!-- agragamos un ling para editar o eliminar un usuario  y en el link enviamos el id
								del usuario al controlador para solo ese registro y no todos-->
   							</td>
   						</tr>

					@endforeach
  			</table>
</div><!--fin table responsive-->
</div> <!-- din panel default-->
</div><!--fin container -->


@endsection