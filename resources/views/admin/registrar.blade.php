------++@extends('app')

@section('content')

<div class="container-fluid">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">REGISTRAR TELEOPERADOR</div>
				<div>
 <img style="width:10%;margin-bottom:2%;" 
      class="logore" src="/imagenes/registroUs.png"  >
</div>
				
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
					{!! Form::open(['route' => ['admin.user.store'], 'method' => 'POST', 'class' =>'form-horizontal']) !!}

						<input type="hidden" name="_token" value="{{ csrf_token() }}">
							<!--este campo es requerido en larabel para evitar ataques de tipo csrf-->

						@include('admin.partials.login')<!--inluimos el parcial de login -->

						<div class="form-group">
							<label class="col-md-4 control-label">Password</label>
							<div class="col-md-6">
								{!! form::password('password',['class'=>'form-control']) !!}
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">Confirmar Password</label>
							<div class="col-md-6">
								<input type="password" class="form-control" name="password_confirmation">
							</div>
						</div>


						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								<button type="submit" class="btn btn-primary"><!-- enviamos la informacion del formulario -->
									Registrar
								</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
