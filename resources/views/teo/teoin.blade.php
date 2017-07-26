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
		#btn_agendar{
			float:left;
		}
		.div-name{
			float:left;
		}
		#contenedor1{

			clear: both;

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
			<option  value="{{$cap->fono_1}}" id="fono1">Fono 1</option>
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

	<div class="col-md-1">

		<a href="{{url('admin/siguiente')}}{{$cap->id}}" class="btn btn-info col-md-12" id="btn_siguiente">Next</a>
	</div>

</div>


</div>

	</div>
@endsection