@extends('app')

@section('content')

<link href="{{ asset('/css/style.css') }}" rel="stylesheet">
<h1>esta es la vista de teleoperador</h1>
<div>
 <img class="logoto" src="/imagenes/Teleoperadores.png"  >
</div>
<div class="table-responsive">
<div class="panel panel-default">
<div class="panel-heading">DATOS DEL CLIENTE</div>  
  <table class="table">
    
	<tr>

	<th>FONO1</th>
	<th>FONO2</th>
	<th>NOMBRE</th>
    <th>APELLIDO</th>
    <th>CORREO1</th>
	<th>OTROS ANTECEDENTES</th>
	<th>ESTADO</th>
	<th>FECHA VOLVER A LLAMAR</th>
	<th>ACCION</th>
    </tr>
	
@foreach ($cap as $c)

	
    <tr>

	<td>{{ $c->fono1 }}</td>
	<td>{{ $c->fono2 }}</td>
	<td>{{ $c->nombre }}</td>
	<td>{{ $c->apellido }}</td>
	<td>{{ $c->correo1 }}</td>
	<td>{{ $c->otro_antecedente }}</td>
	<td>{{ $c->estado }}</td>
	<td>{{ $c->fecha_volver_allamar }}</td>
	@if(Auth::user()->perfil==1)
	<td><a href="{{ url('admin/edit&')}}{{$c->id}}">MODIFICAR</a>
    @elseif(Auth::user()->perfil==2)
	<td><a href="{{ url('teo/edit&')}}{{$c->id}}">MODIFICAR</a>
    @endif
	@if(Auth::user()->perfil==1)
	<td><a href="{{ url('admin/mandatoExitoso&')}}{{$c->id}}&{{$c->n_interno_dues}}">AGREGAR MANDATO EXITOSO</a>

	@elseif(Auth::user()->perfil==2)
	<td><a href="{{ url('teo/mandatoExitoso&')}}{{$c->id}}">AGREGAR MANDATO EXITOSO</a>
	@endif
	</td>
	
    </tr>
	
   @endforeach
  </table>
  </div>
  {!!$cap->render()!!}
  </div>
 

@endsection