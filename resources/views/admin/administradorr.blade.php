
@extends('app')

@section('content')
<h1 style="text-align: center">Administrar</h1>

        @if(Session::has('message'))

            <p class="alert alert-success">{{Session::get('message')}}</p>
        @endif

	<div class="container">
		<a class="btn btn-info" href="{{ route('admin.user.create') }}" role="button" style="margin:5px; margin-left: 88%;">Registrar Usuario</a>
	
<div class="panel panel-default">
<div class="panel-heading">DATOS DEL USUARIO</div> 
			<div class="table-responsive">
  			<table class="table table-bordered">
   				<tr>
   					<th>Nombres</th>
   					<th>Correo</th>
   					<th>Perfil</th>
   					<th>Accion</th>
   				</tr>
		@foreach($usuarios as $User)
   				<tr data-id="{{$User->id}}">
   					<td>{{  $User->name }}</td>
   					<td>{{ $User->email }}</td>
   					<td>{{ $User->perfil }}</td>
   					<td style="text-align: center">

                        <a href="{{ route('admin.user.edit',$User->id)}}">Editar/Eliminar</a>


   					</td>
   				</tr>

		@endforeach
  			</table>
</div>
</div>
</div>

@endsection