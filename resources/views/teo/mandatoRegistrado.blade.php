@extends('app')

@section('content')
	<style>

	.error {

		border-color: red;
	}
	.succes{
		border-color: green;
	}
	</style>
	<script>
		$(document).ready(function() {

			$("#comuna").on('change', function (e) {

				console.log(e);
				var rutero_id = e.target.value;


				$.get('ajax-rutero?ruteroid=' + rutero_id, function (data) {
					console.log(data);
					$.each(data, function (index, obj) {

						$("#rutero").val(obj.rutero);

						$("#comunatable").text(obj.comuna);
						$("#voluntario").text(obj.rutero);
						$("#lunes").text(obj.h_lunes);
						$("#martes").text(obj.h_martes);
						$("#miercoles").text(obj.h_miercoles);
						$("#jueves").text(obj.h_jueves);
						$("#viernes").text(obj.h_viernes);


					});

				});


			});

		$("#rut").rut({validateOn: 'keyup change'})
					.on('rutInvalido', function(){
						$(this).addClass("error")


					})
					.on('rutValido', function(){

						$(this).removeClass("error")
					});

		$("#enviar").click(function(){

			var datos ={rut:$("#rut").val(),fundacion:$("#fundacion").val()}

			$.get('validarSocio',datos,procesarDatos);
			console.log(datos);

			function procesarDatos(data){

				console.log(data);
				 if(data == 2){
					 alert("este usuarios ya es socio o tiene uina visita pendiente de greenpeace");



				 }else{

					 $("#send").submit();
				 }

			}

		});

		});

	</script>
<link href="{{ asset('/css/style.css') }}" rel="stylesheet">

			<div class="container">

			<div  class="panel panel-default ">
            <div class="panel-heading">Agendamiento</div>
				   <form class="form-horizontal" role="form" id="send" method="POST" action="@if(Auth::user()->perfil==1){{ url('admin/agregado') }}@elseif(Auth::user()->perfil==2){{ url('teo/agregado')}}@endif " >
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">



					   <div>

						   <input type="hidden" class="form-control" name="fundacion" value="{{$capta->nom_fundacion}}" id="fundacion">
					   </div>

						<div  class="col-md-4 ">
								<input type="hidden" class="form-control" name="n_dues" value="{{$capta->n_dues}}">
						</div>

						<div  class="col-md-4 ">
								<input type="hidden" class="form-control" name="id_fundacion" value="{{$capta->id_fundacion}}">
						</div>

						<div  class="col-md-4 ">

						</div>



					   <div class="col-md-3">
						   <label class=" control-label">Tipo Retiro</label>
						   <div class="">
							   <select name="tipo_retiro" class="form-control">
								   <option>--seleccione--</option>

								   <option>Garabacion</option>
								   <option>Agendamiento</option>
								   <option>Captacion Propia</option>
								   <option>Dialogo Directo</option>
								   <option>Delivery</option>
								   <option>Chilexpress</option>
								   <option>Ir A Dues</option>
								   <option>Ir A Fundacion</option>


							   </select>
						   </div>
					   </div>

					   <div class="col-md-3">
						   <label class=" control-label">Comuna</label>
						   <select name="comuna" id="comuna" class="form-control">
							   <option value="a">-- Seleccione --</option>
							   @foreach($comunas as $comuna)
								   <option value="{{$comuna->comuna}}">{{$comuna->comuna}}</option>
							   @endforeach
						   </select>
					   </div>

					   <div class="col-md-3">
						   <label class=" control-label">Fecha Agendamiento</label>
						   <div class="">
							   <input type="date" class="form-control" name="fecha_agendamiento" value="">
						   </div>
					   </div>

					   <div class="col-md-3">
						   <label class=" control-label">Horario .</label>
								   <input type="time" class="form-control" name="horario" value="">
					   </div>


					   <div class="col-md-3">
						   <label class=" control-label">Rut</label>
						   <input type="text" class="form-control" id="rut" name="rut" placeholder="18.202.912-2">
                        </div>




					   <div class="col-md-3">
						   <label class="control-label" >Jornada</label>

						   <select name="jornada" class="form-control">
							   <option>--Seleccione--</option>
							   <option>AM</option>
							   <option>PM</option>
						   </select>
					   </div>





					   <div  class="col-md-3">
							<label class=" control-label">Fono</label>

								<input type="text" class="form-control" name="fono_1" value="{{$capta->fono_1}}">


						</div>

						 
						<div class="col-md-3">
							<label class=" control-label">Nombre</label>

								<input type="text" class="form-control" name="nombre" value="{{$capta->nombre}}">

						</div>
						
						<div class="col-md-3">
							<label class=" control-label">Apellido</label>

								<input type="text" class="form-control" name="apellido" value="{{$capta->apellido}}">

						</div>

					   <div class="col-md-6">
						   <label class="control-label">Direccion</label>

								   <input type="text" name="direccion" class="form-control" placeholder="Ej: Santa Magdalena #10">

					   </div>

						<div class="col-md-3">
							<label class="control-label">Correo</label>

								<input type="text" class="form-control" name="correo_1" value="{{$capta->correo_1}}">

						</div>
						


					   <div class="col-md-3">
						   <label  class="control-label">Voluntario Ruta</label>
						   <input type="text" class="form-control" name="rutero" id="rutero">
					   </div>

					   
					   <div class="col-md-2">
						   <label class="control-label">Campaña</label>
						   <input type="text" class="form-control" name="nom_campana" value="{{$capta->campana}}">
					   </div>
					   
					   <div class="col-md-2">
						   <label class="control-label">Monto</label>
						   <input type="text" class="form-control" name="monto">
					   </div>
					   
					   <div class="col-md-2">

						   <label class="control-label">Forma Pago</label>


						   <select name="forma_pago" class="form-control">
							   <option>--Seleccione--</option>
							   <option >Cuenta Vista</option>
							   <option >Cuenta Corriente</option>
							   <option >Cuenta Rut</option>
							   <option >Tarjeta De Credito</option>
							   <option >Cuenta Rut</option>
						   </select>
					   </div>

					   <div class="col-md-6">
						   <label class=" control-label">Observaciones</label>

						   <input type="text" class="form-control" name="observaciones" >

					   </div>
					   <div  class=" ">
						   <input type="hidden" class="form-control" name="teleoperador" value="{{auth::user()->id}}">
					   </div>

					   <div class="col-md-6">
						   <label class="control.label">.</label>
								<button type="button" class="btn btn-primary form-control" id="enviar">
									Ingresar Agendamiento
								</button>
							</div>
					   <div class="form-group ">
						</div>
					</form>


 					</div>

				<table class="table table-responsive">
					<thead>
						<tr>
							<th>Comuna</th>
							<th>Voluntario</th>
							<th>Lunes</th>
							<th>Martes</th>
							<th>Miercoles</th>
							<th>Jueves</th>
							<th>Viernes</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td id="comunatable">x</td>
							<td id="voluntario">x</td>
							<td id="lunes">x</td>
							<td id="martes">x</td>
							<td id="miercoles">x</td>
							<td id="jueves">x</td>
							<td id="viernes">x</td>

						</tr>
					</tbody>
				</table>
			</div>


  
@endsection