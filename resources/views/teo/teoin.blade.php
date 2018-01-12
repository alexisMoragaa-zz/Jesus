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
		.btn_siguiente{
			margin-top: 23px;
		}
	#btn-edit{
		margin-top: 23px;
		}
	.btn_agendar{
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
		#color{
			background: red;
			margin-top: 30px;
			margin-bottom: 15px;
			}
			#btn-exit{
				 margin-top:23px;
			 }
		#btn-back{
			margin-top: -3%
		}
	</style>

	<script>
		$(document).ready(function(){

			$("#v_llamar").hide();

			$("#call_status").change(function(){

				if($("#call_status").val()=='Agendar Llamado'){
					$(".btn_siguiente").val("Agendar Llamado");
					$("#observ").removeClass('col-md-6');
					$("#observ").addClass('col-md-3');
					$("#v_llamar").fadeIn(550);
				}else{
						$(".btn_siguiente").val("Next");
					$("#v_llamar").hide()
					$("#observ").removeClass('col-md-3');
					$("#observ").addClass('col-md-6');
				}
			});

			$("#btn-back").click(function () {
				$("#form-back").submit();
			});
		});

	</script>

	<link href="{{ asset('/css/style.css') }}" rel="stylesheet">
	<script src="{{asset('js/optimizar.js')}}"></script>

<div class="container " id="contenedor">
	<div class="col-md-3" id="btn-back">

		{!! Form::open(['url'=>['teo/homeBack'],'method'=>'POST','id'=>'form-back']) !!}
				<input type="hidden" name="id" value="{{$cap->id}}">
		{!! Form::close() !!}

		<button type="button" class="btn  btn-default or" id="btn-back" ><span class="glyphicon glyphicon-arrow-left"></span> Regresar</button>
	</div>



	<div class="div-name col-md-7 col-sm-10 col-xs-10">
		<h1 id="name" class="col-md-10">{{Auth::user()->name}} {{Auth::user()->last_name}}</h1>
	</div>

	<div class="col-md-2 btn_agendar">
		<a href="{{url('/teo/regiones',$cap->id)}}" class=""><h1 class="btn btn-primary" >Agendar Regiones</h1></a>
	</div>

	<div id="" class="col-md-2 btn_agendar">
		@if (isset($function))
			<a href="{{url('teo/agendamiento/llamada/llamadoExitoso',$function->id)}}" ><h1 class="btn btn-success">Agendar Santiago</h1></a>
		@else
			<a href="{{url('teo/mandatoExitoso&')}}{{$cap->id}}&{{$cap->n_dues}}" ><h1 class="btn btn-success btn-ajax">Agendar Santiago</h1></a>
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

			{!! Form::open(['url'=>['teo/siguiente',$cap->id],'method'=>'POST','id'=>'form-cap']) !!}

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

		@if (isset($function))

			<div class="col-md-1">
				<input type="submit"  class="btn btn-info btn_siguiente" value="Resultado Agendamiento">
			</div>
			<input type="hidden" name="llamado_agendado" value="no llamado">
			<input type="hidden" name="llamado_agendado_id" value="{{$function->id}}">
		@else

			<div class="col-md-1">
					<a href="{{url('teo/edit&')}}{{$cap->id}}" class="btn btn-warning" id="btn-edit"> Edit</a>
			</div>

			<div class="col-md-1">
				<input type="submit" id="" class="btn btn-info btn_siguiente" value="Next">
			</div>


		@endif
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
</div>{{--<!-[fin contenedor 1]-> --}}
</div>{{--<!-[fin contentainer]->--}}
@endsection
