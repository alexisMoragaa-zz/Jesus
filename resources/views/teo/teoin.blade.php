@extends('app')

@section('content')
	<style>
		#name{

			margin-left: 90%;


		}
		#contenedor{

			min-height: 400px;

		}
	</style>

<link href="{{ asset('/css/style.css') }}" rel="stylesheet">
<div class="container " id="contenedor">
<h1 id="name" class="">{{Auth::user()->name}}</h1>

	@foreach($cap as $c)
	<p>{{$c->nombre}}</p>









	@endforeach






















<!-- codigo anterior
<div class="table-responsive">
	<div class="panel panel-default">
		<table class="table">
    			<tr>
					<th>FONO</th>
					<th>FONO</th>
					<th>NOMBRE</th>
   				 	<th>APELLIDO</th>
    				<th>CORREO</th>
					<th>OTROS ANTECEDENTES</th>
					<th>ESTADO</th>
					<th>FECHA VOLVER A LLAMAR</th>
					<th>ACCION</th>
    			</tr>
			 @foreach ($cap as $c)

    			<tr>

					<td>{{ $c->fono_1 }}</td>
					<td>{{ $c->fono_2 }}</td>
					<td>{{ $c->nombre }}</td>
					<td>{{ $c->apellido }}</td>
					<td>{{ $c->correo_1 }}</td>
					<td>{{ $c->otro_antecedente }}</td>
					<td>
						<select name="estado" class="form-control col-md-3" >
							<option>--Seleccione--</option>
								<option></option>
						</select>
					</td>
					<td>{{ $c->fecha_volver_allamar }}</td>

					@if(Auth::user()->perfil==1)
						<td><a href="{{ url('admin/edit&')}}{{$c->id}}">MODIFICAR</a></td>

    				@elseif(Auth::user()->perfil==2)
						<td><a href="{{ url('teo/edit&')}}{{$c->id}}">MODIFICAR</a></td>
    				@endif

					@if(Auth::user()->perfil==1)
						<td><a href="{{ url('admin/mandatoExitoso&')}}{{$c->id}}&{{$c->n_dues}}">AGREGAR MANDATO EXITOSO</a></td>

					@elseif(Auth::user()->perfil==2)
						<td><a href="{{ url('teo/mandatoExitoso&')}}{{$c->id}}&{{$c->n_dues}}">AGREGAR MANDATO EXITOSO</a></td>
					@endif

	
   				 </tr>
			@endforeach
			</table>
	  </div>
  {!!$cap->render()!!}
  </div>
 fin codigo anterior-->
	</div>
@endsection