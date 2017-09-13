@extends('app')

@section('content')
	<style>
		#name{
			margin-left: 0%;display: block;}#contenedor{min-height: 400px;}#btn_siguiente{margin-top: 23px;}
		#btn-edit{margin-top: 23px;}#btn_agendar{float:left;}.div-name{float:left;}#contenedor1{clear: both;}
		#observation-error{padding-left: 60%;color: red;}#status-error{padding-left: 30px;color: red;}
		#color{background: red;margin-top: 30px;margin-bottom: 15px;}#btn-exit{ margin-top:23px;}
	</style>

	<script>
		$(document).ready(function(){

		$(".btn-ajax").click(function(e){

			var info =$("#form-cap").serialize();
			var option =$("#call_status").val();
			if(option =="Acepta Agendamiento"||option=="Acepta Grabacion"||option=="Acepta Delivery"||option=="Acepta Upgrade"||option=="Acepta Chilexpress"||option=="Acepta ir a Dues"){

				$.post('addStatusCapAjax',info,processData)

				function processData(data) {
					console.log(data);
					if(data =="exito"){

					}
				}
			}else{
				alert("Ingrese una opcion Valida");
				return false;
			}


		});
			$("#btn_siguiente").click(function(e){
				var option =$("#call_status").val();
				e.preventDefault();
				if(option =="Acepta Agendamiento"||option=="Acepta Grabacion"||option=="Acepta Delivery"||option=="Acepta Upgrade"||option=="Acepta Chilexpress"||option=="Acepta ir a Dues") {

				alert("ingrese una opcion Valida")
				}else {
					$("#form-cap").submit();
				}
			});


			$("#v_llamar").hide();

			$("#call_status").change(function(){

				if($("#call_status").val()=='Volver a llamar'){

					$("#observ").removeClass('col-md-6');
					$("#observ").addClass('col-md-3');
					$("#v_llamar").fadeIn(550);
				}else{
					$("#v_llamar").hide()
					$("#observ").removeClass('col-md-3');
					$("#observ").addClass('col-md-6');
				}
			});
		});

	</script>

	<link href="{{ asset('/css/style.css') }}" rel="stylesheet">
	<script src="{{asset('js/optimizar.js')}}"></script>

<div class="container " id="contenedor">

	<div class="div-name col-md-10 col-sm-10 col-xs-10">
		<h1 id="name" class="col-md-10">{{Auth::user()->name}} {{Auth::user()->last_name}}</h1>
	</div>

	<div id="btn_agendar">
		@if(Auth::user()->perfil==1)
			<a href="{{url('admin/mandatoExitoso&')}}{{$cap->id}}&{{$cap->n_dues}}" ><h1 class="btn btn-success btn-ajax">Agendar</h1></a>
		@elseif(Auth::user()->perfil==2)
			<a href="{{url('teo/mandatoExitoso&')}}{{$cap->id}}&{{$cap->n_dues}}" ><h1 class="btn btn-success btn-ajax">Agendar</h1></a>
		@endif
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
				<option value="{{$cap->correo_2}}" id="correo2">Correo 2</option>
			</select>
		</div>

		<div class="col-md-4">
			<label for="" id="otro_antecedente-l" class="control-label">Otro Antecedente</label>
			<input type="text" value="{{$cap->otro_antecedente}}" id="otro_antecedente" class="form-control">
		</div>

{!! Form::open(['url'=>['admin/siguiente',$cap->id],'method'=>'POST','id'=>'form-cap']) !!}

		<div class="col-md-3">
			<label for="" class="control-label">Estado Llamado</label>
			<label for="" class="control-label" id="status-error">*Ingrese Un Valor</label>

			<select name="call_status" id="call_status" class="form-control">
				<option value="">--Seleccione--</option>
				@foreach($status as $sta)
					<option value="{{$sta->Estado}}">{{$sta->Estado}}</option>
				@endforeach
			</select>
		</div>

		<div class="col-md-3" id="v_llamar">
			<label for="" class="control-label">Volver a llamar</label>

			<input type="date" class="form-control" name="call_again" value="{{$cap->volver_llamar}}">
		</div>

		<div class="col-md-6" id="observ">
			<label for="" class="control-label">Observaciones</label>
			<label for="" class="control-label" id="observation-error">*Ingrese Un Valor</label>

			<input type="text" class="form-control" id="observation" name="observation1" value="{{$cap->observacion}}">
		</div>


		<div class="col-md-1">
			<a href="{{url('admin/edit&')}}{{$cap->id}}" class="btn btn-warning" id="btn-edit"> Edit</a>
		</div>

		<div class="col-md-1">
			<input type="submit" id="btn_siguiente" class="btn btn-info" value="Next">
		</div>
		<input type="hidden" name="id_captacion" value="{{$cap->id}}">

{!! Form::close() !!}

@if($cap->n_llamados != null)
		<div id="color" class="col-md-12" ></div>

		<div class="col-md-3">
			<label for="" class="control-label">Estado Anterior</label>

			@if($cap->n_llamados == 1)
				<input type="text" class="form-control"  id="last_status" value="{{$cap->estado_llamada1}}">
			@elseif($cap->n_llamados == 2)
				<input type="text" class="form-control"  id="last_status" value="{{$cap->estado_llamada2}}">
			@else
				<input type="text" class="form-control"  id="last_status" value="{{$cap->estado_llamada3}}">
			@endif
		</div>

		<div class="col-md-1">
			<label for="" class="control-label">Llamadas</label>

			<input type="text" class="form-control" value="{{$cap->n_llamados}}">
		</div>

		<div class="col-md-3">
			<label for="" class="control-label">Fecha Ultimo Llamado</label>

			<input type="text" class="form-control" value="{{$cap->f_ultimo_llamado}}">
		</div>
@endif
</div><!-[fin contenedor 1]->
</div><!-[fin contentainer]->
@endsection