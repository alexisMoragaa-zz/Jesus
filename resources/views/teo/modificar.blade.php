@extends('app')

@section('content')
	<script>
		$(document).ready(function(){

		});
	</script>

<link href="{{ asset('/css/style.css') }}" rel="stylesheet">
<h1 style="text-align: center">Actualizar el registro </h1>

          <div class="container">

					<form class="form-horizontal" role="form" method="POST" action="@if(Auth::user()->perfil==1){{ url('admin/actualizado&') }}{{$capta->id}}@elseif(Auth::user()->perfil==2){{ url('teo/actualizado&') }}{{$capta->id}}@endif" >
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

						<div class="col-md-4">
							<label class="control-label">Nombre</label>
							<input type="text" class="form-control"  name="nombre" value="{{$capta->nombre}}">
						</div>


						<div class="col-md-4">
							<label class="control-label">Apellido</label>
							<input type="text" class="form-control" name="apellido"  value="{{$capta->apellido}}">
						</div>

                        <div class="col-md-4">
							<label class=" control-label">Fono 1</label>
							<input type="text" class="form-control" name="fono1"  value="{{$capta->fono_1}}">
						</div>

						<div class="col-md-4" id="fono_2">
							<label class=" control-label">Fono 2</label>
							<input type="text" class="form-control" name="fono2" id="fono2" value="{{$capta->fono_2}}">
						</div>

						<div class="col-md-4" id="fono_3">
							<label class=" control-label">Fono 3</label>
							<input type="text" class="form-control" name="fono3"  id="fono3" value="{{$capta->fono_3}}">
						</div>

						<div class="col-md-4" id="fono_4">
							<label class=" control-label">Fono 4</label>
							<input type="text" class="form-control" name="fono4" id="fono4" value="{{$capta->fono_4}}">
						</div>

						<div class="col-md-6">
							<label class=" control-label">Corro 1</label>
							<input type="text" class="form-control" name="correo1"  value="{{$capta->correo_1}}">
						</div>

						<div class="col-md-6">
							<label class=" control-label">Correo 2</label>
							<input type="text" class="form-control" name="correo2"  value="{{$capta->correo_2}}">

						</div>

						<div class="col-md-2" style="margin-top: 23px; margin-left:88%">
								<button type="submit" class="btn btn-primary">
									ACTUALIZAR
								</button>
						</div>
					</form>
					</div>
					</div>



@endsection
