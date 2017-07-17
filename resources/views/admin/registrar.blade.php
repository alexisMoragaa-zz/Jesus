@extends('app')

@section('content')
	<script src="{{asset('js/optimizar.js')}}"></script>
<div class="container-fluid">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">

				<div class="">
					<img style="width:10%;margin-bottom:2%;" class="logore" src="/imagenes/registroUs.png">

				<div class="panel-body">
					@if (count($errors) > 0)<!--creamos un if para verificar si no hay errores-->
						<div class="alert alert-danger">
							<strong>Por Favor </strong>Corrige los siguientes errores.<br><br>
							<ul>
								@foreach ($errors->all() as $error)<!--si hay errores lso recorremos con un foreach-->
									<li>{{ $error }}</li> <!--imprimimos los errores en pantalla-->
								@endforeach
							</ul>
						</div>
					@endif
						@if(Auth::user()->perfil==1)
							{!! Form::open(['route' => ['admin.user.store'], 'method' => 'POST', 'class' =>'form-horizontal','id'=>'form']) !!}
						@elseif(Auth::user()->perfil==3)
							{!! Form::open(['route'=>['sup.user.store'],'method'=> 'POST','class'=>'form-horizontal','id'=>'form']) !!}
						@endif
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
							<!--este campo es requerido en laravel para evitar ataques de tipo csrf-->

						@include('admin.partials.login')<!--inluimos el parcial de login -->


						<div class="col-md-3">
							<label class=" control-label">Password</label>

								{!! form::password('password',['class'=>'form-control','id'=>'in_pass']) !!}

						</div>

						<div class="col-md-3">
							<label class=" control-label">Confirmar Password</label>

								<input type="password" class="form-control" name="password_confirmation" id="confirm_pass">

						</div>



							<div class=" col-md-3">
								<label for="" class="control-label"></label>
								<button type="button" class="btn btn-primary form-control" id="btn_enviar"><!-- enviamos la informacion del formulario -->
									Registrar
								</button>
							</div>
					<div class="col-md-5" style="padding-top: 25px;">
						<label for="" id="error"style="color:red;"></label>
					</div>


					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
