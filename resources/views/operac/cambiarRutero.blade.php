@extends('app')
@section('content')
<style type="text/css">
	.modal-tittle{

		text-align: center;
	}
</style>
<script type="text/javascript">
$(document).ready(function(){
			$("#select-rutero").change(function(){
			//funcion que se desencadena al evento change sobre el select de fundaciones
				var rutero_id = $(this).val();
				//tomamos el id de la fundacion cuando se desencadene la funcion change

				//AJAX
				$.get('/ope/byRutero/'+rutero_id,function(data){
					//metodo de ajax para realizar una peticion asincrona al servidor y con esto traer las campañas de una fundacion
					var html_select ='<option value="">Seleccione Comuna</option>';//etiqueta html que insertaremos en la pagina
					for(var i=0;i<data.length;i++){//recorremos el largo de la data retornada por el servidor

						html_select+='<option value="'+data[i].id+'">'+data[i].comuna+'</option>';
						//por cada elemento que tenga la data le concatenamos un option a nuestro elemento html_select
					}
						$("#select-comuna").html(html_select);
						//una vez recorridos todos los elementos insertamos nuestro html_select en el select correspondiente con el metodo html
				});
			});


			$(".modal-rutero").hide();

			$(".change").click(function(){
				var row = $(this).parents('tr');//seleccionamos el contenido de la row
				var id = row.data('id');//seleccionamos el id
				var name = row.data('name');//seleccionamos el nombre
				var socio = row.data('socio');
				$("#name_rutero").text(name);//asignamos el nombre del ruteroa la etiqueta h3 name_rutero
				$("#name_socio").text(socio);//asignamos el nombre del ruteroa la etiqueta h3 name_socio
				$(".modal-rutero").dialog();//desplegamos la modal con el nombre del rutero


					$("#btn-change").click(function(){
						var row = $(".change").parents('tr');//seleccionamos el contenido de la row
						var id = row.data('id');//seleccionamos el id
						var rutero =$("#newRutero").val();
						window.location ='/ope/change/rutero/'+id+'/'+rutero
					});
			});
		});
</script>

<div class="row">
	<div class="container">
		<form action="/ope/cambiarRutero" method="post">
			<input type="hidden" value="{{csrf_token()}}" name="_token">
			<div class="col-md-4">
				<label for="" class="control-label">Rutero</label>
				<select name="rutero" id="select-rutero" class="form-control">
					<option value="">Seleccione Rutero</option>
						@foreach ($ruteros as $rutero)
							<option value="{{$rutero->id}}">{{$rutero->name}} {{$rutero->last_name}}</option>
						@endforeach
				</select>
			</div>
			<div class="col-md-4">
				<label for="" class="control-label">Comuna</label>
				<select name="comuna" id="select-comuna" class="form-control">
					<option value="">Seleccione Comuna</option>

				</select>
			</div>
			<input type="submit" class="btn1 btn btn-primary" value="Buscar Rutas">
		</form>
	</div>

</div>

<div class="row">
	<div class="container">
		<h3 class="text-muted">{{$breadCrum}}</h3>
	</div>
	<div class="container">
		<div class="table table-responsive">
			<table class="table table-hover">
				<thead>
					<th>Rutero</th>
					<th>Comuna</th>
					<th>Nombre Socio</th>
					<th>Rut</th>
					<th>Telefono</th>
					<th>Direccion</th>
					<th>Fecha Retiro</th>
					<th><a href="#">Cambiar Rutero</a></th>
				</thead>
				<tbody>
					@if(isset($registros))
							@foreach($registros as $registro)
								<tr data-id="{{$registro->id}}" data-name="{{$registro->rutero}}"
									data-socio="{{$registro->cap->nombre}} {{$registro->cap->apellido}}">

									<td id="rutero">{{$registro->cap->rutero}}</td>
									<td>{{$registro->cap->comuna}}</td>
									<td>{{$registro->cap->nombre}} {{$registro->cap->apellido}}</td>
									<td>{{$registro->cap->rut}}</td>
									<td>{{$registro->cap->fono_1}}</td>
									<td>{{$registro->cap->direccion}}</td>
									<td>{{$registro->fecha_agendamiento}}</td>
									<td><a href="#" class="change">Cambiar</a></td>
								</tr>
							@endforeach
					@endif
				</tbody>
			</table>
		</div>
	</div>
</div>

<div class="modal-rutero">
	<h3 class="modal-tittle text-muted">Nombre Socio</h3>
	<h4 class="modal-tittle text-muted" id="name_socio"></h4>
	<h3 class="modal-tittle text-muted">Rutero Actual</h3>
	<h4 class="modal-tittle text-muted" id="name_rutero"></h4>
	<label for="" class="control-label">Seleccione Un Nuevo Rutero</label>
	<select name="newRutero" id="newRutero" class="form-control">
		<option value="">Seleccione</option>
		@foreach ($ruteros as $rutero)
			<option value="{{$rutero->id}}">{{$rutero->name}}  {{$rutero->last_name}}</option>
		@endforeach
	</select>
<a href="#" class="btn btn1 btn-success col-md-12" id="btn-change">Cambiar Rutero</a>
	{{-- <input type="button" class="btn btn1 btn-success col-md-12" value="Cambiar Rutero" id="change_rutero"> --}}
</div>
@endsection
