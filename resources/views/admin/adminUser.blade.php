
@extends('app')

@section('content')
<link href="{{ asset('/css/style.css') }}" rel="stylesheet">



        @if(Session::has('message'))

            <div class="container alert alert-success"> <p style="text-align: center">{{Session::get('message')}}</p></div>
        @endif

	
		
<div class="container">

<a class="btn btn-info" href="{{ route('admin.user.create') }}" role="button" style="margin:5px; margin-left: 85%;">Registrar Usuario</a>
		
<div class="panel panel-default">
<div class="panel-heading">DATOS DEL USUARIO</div> 
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
   							<td>{{ $User->perfil }}</td>
   							<td style="text-align: center">
                        		<a href="{{ route('admin.user.edit',$User->id)}}">Editar/Eliminar</a>
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