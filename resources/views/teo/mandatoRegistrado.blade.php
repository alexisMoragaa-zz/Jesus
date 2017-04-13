@extends('app')

@section('content')
<link href="{{ asset('/css/style.css') }}" rel="stylesheet">

			<div class="container">

			<div  class="panel panel-default ">
            <div class="panel-heading">Agendamiento</div>
				   <form class="form-horizontal" role="form" method="POST" action="@if(Auth::user()->perfil==1){{ url('admin/agregado') }}@elseif(Auth::user()->perfil==2){{ url('teo/agregado')}}@endif " >
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

			            @foreach($c as $ca)
						@if ($ca->n_dues==$ca->n_dues)
					    <h2>Mandato Registrado Anteriormente</h2>
						@endif
						@endforeach

					   <div>
						   <input type="hidden" class="form-control" name="fundacion" value="{{$capta->fundacion}}">
					   </div>

						<div  class="col-md-4 ">
								<input type="hidden" class="form-control" name="n_dues" value="{{$capta->n_dues}}">
						</div>

						<div  class="col-md-4 ">
								<input type="hidden" class="form-control" name="id_fundacion" value="{{$capta->id_fundacion}}">
						</div>

						<div  class="col-md-4 ">
								<input type="hidden" class="form-control" name="fecha_captacion" value="<?php echo date("y/m/d")?>">
						</div>

					  <div class="col-md-3">
						   <label class=" control-label">Fecha Agendamiento</label>
								<div class="">
								   <input type="date" class="form-control" name="fecha_agendamiento" value="">
								</div>
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
						   <label class="control-label" >Jornada</label>

							   <select name="jornada" class="form-control">
								   <option>--Seleccione--</option>
								   <option>AM</option>
								   <option>PM</option>
							   </select>
					   </div>

					   <div class="col-md-3">
						   <label class=" control-label">Horario .</label>
								   <input type="time" class="form-control" name="horario" value="">
					   </div>


					   <div class="col-md-3">
						   <label class=" control-label">Rut</label>
								   <input type="text" class="form-control" name="rut" placeholder="Ej: 76459578">
                        </div>

					   <div class="col-md-1">
						   <label class="control-label">Dv</label>
							   <input type="text"  class="form-control" name="dv" placeholder="Dv">
					   </div>

					   <div class="col-md-2"></div>

					   <div class="col-md-3">
						   <label class=" control-label">Comuna</label>
						     	 <input type="text" class="form-control" name="comuna" placeholder="Ingrese Comuna">
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
						   <input type="text" class="form-control" name="rutero">
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
						   <input type="hidden" class="form-control" name="teleoperador" value="{{auth::user()->name}}">
					   </div>

					   <div class="col-md-6">
						   <label class="control-label">.</label>
								<button type="submit" class="btn btn-primary form-control">
									Ingresar Agendamiento
								</button>
							</div>
					   <div class="form-group ">
						</div>
					</form>
 					</div>
			</div>


  
@endsection