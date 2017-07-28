@extends('app')

@section('content')

	<style>
		#name{

			margin-left: 0%;
			display: block;

		}
		#contenedor{

			min-height: 400px;

		}
		#btn_siguiente{
			margin-top: 23px;
		}
		#btn-edit{
			margin-top: 23px;
		}
		#btn_agendar{
			float:left;
		}
		.div-name{
			float:left;
		}
		#contenedor1{

			clear: both;

		}
		#observation-error{
			padding-left: 60%;
			color: red;
		}
		#status-error{
			padding-left: 30px;
			color: red;
		}
	</style>
	<script>
		$(document).ready(function(){


		});


	</script>

<link href="{{ asset('/css/style.css') }}" rel="stylesheet">
	<script src="{{asset('js/optimizar.js')}}"></script>

<div class="container " id="contenedor">

<div class="div-name col-md-10 col-sm-10 col-xs-10">
	<h1 id="name" class="col-md-10">{{Auth::user()->name}} {{Auth::user()->last_name}}</h1>

</div>

<div id="btn_agendar">

	<a href="{{url('admin/mandatoExitoso&')}}{{$cap->id}}&{{$cap->n_dues}}" ><h1 class="btn btn-success">Agendar</h1></a>
</div>
	


	<div id="contenedor1" class="form-group">
		<div class="col-md-3">

		<label for="" class="control-label">Nombre</label>
		<input type="text" value="{{$cap->nombre}}" class="form-control">
	</div>

	<div class="col-md-3">
		<label for="" class="control-label">Apellido</label>
		<input type="text" value="{{$cap->apellido}}" class="form-control">
	</div>

	<div class="col-md-3">
		<label for="" class="control-label">Fono</label>
		<input type="text" class="form-control" id="fono_seleccionado" value="">
	</div>

	<div class="col-md-2">
		<label for="" class="control-label">Fono</label>
		<select  class="form-control" id="fon_selector">
			<option value="{{$cap->fono_1}}" id="fono1">Fono 1</option>
			<option value="{{$cap->fono_2}}" id="fono2">Fono 2</option>
			<option value="{{$cap->fono_3}}" id="fono3">Fono 3</option>
			<option value="{{$cap->fono_4}}" id="fono4">Fono 4</option>

		</select>
	</div>

	<div class="col-md-4">
		<label for="" class="control-label">Correo</label>
		<input type="text" class="form-control" id="correo_seleccionado">

	</div>

	<div class="col-md-2">
		<label for="" class="control-label">Correo</label>
		<select name="" id="correo_selector" class="form-control">
			<option value="{{$cap->correo_1}}" id="correo1">Correo 1</option>
			<option value="{{$cap->correo_2}}" id="correo2">Correo 1</option>
		</select>
	</div>

	<div class="col-md-4">
		<label for="" id="otro_antecedente-l" class="control-label">Otro Antecedente</label>
		<input type="text" value="{{$cap->otro_antecedente}}" id="otro_antecedente" class="form-control">
	</div>

		{!! Form::open(['url'=>['admin/siguiente',$cap->id],'method'=>'POST']) !!}

		<div class="col-md-6">

			<label for="" class="control-label">Observaciones</label>
			<label for="" class="control-label" id="observation-error">*Ingrese Un Valor</label>
			<input type="text" class="form-control" id="observation" name="observation1">
		</div>

		<div class="col-md-3">
			<label for="" class="control-label">Estado Llamado</label>
			<label for="" class="control-label" id="status-error">*Ingrese Un Valor</label>
			<select name="call_status" id="call_status" class="form-control">
				<option value="">Seleccione una Opcion</option>
				<option value="1">No Contesta</option>
				<option value="2">Fono Ocuopado</option>
				<option value="3">Mala Conexion</option>
				<option value="4">Fuera de servicio</option>
				<option value="5">No interesado</option>
				<option value="6">Sin dinero</option>
				<option value="7">Sin Trabajo</option>
				<option value="8">Volver a Llamar</option>
				<option value="9">Molesto por Llamado</option>
				<option value="0">No interesado</option>
			</select>
		</div>

		<div class="col-md-1">
			<a href="{{url('admin/edit&')}}{{$cap->id}}" class="btn btn-warning" id="btn-edit"> Edit</a>
		</div>
		<div class="col-md-1">

			<!--[<a href="{{url('admin/siguiente')}}{{$cap->id}}" class="btn btn-info col-md-12" id="btn_siguiente">Next</a>]-->
			<input type="submit" id="btn_siguiente" class="btn btn-info">
		</div>
		{!! Form::close() !!}
</div>


</div>

</div>
@endsection