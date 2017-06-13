@extends('app')

@section('content')
<link href="{{ asset('/css/style.css') }}" rel="stylesheet">

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Editar Usuario {{$user->name}}</div>

                        <div>
                             <img style="width:10%; margin-left:2%;" src="/imagenes/iditarIcono.png"> </img>
                        </div>

					    <div class="panel-body">
                            @if (count($errors) > 0)
                                <div class="alert alert-danger">
                                    <strong>Whoops!</strong>Por favor corrige los siguientes errores.<br><br>
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                </div>
                            @endif

    {!! Form::model($user,['route' => ['admin.user.update',$user], 'method' => 'PUT', 'class' =>'form-horizontal']) !!}
                           
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    @include('admin.partials.login')

             <div class="col-md-6 col-md-offset-4">

                 <button type="submit" class="btn btn-primary">Editar</button>
                 <img style="width:15%;margin-left:15%;" src="/imagenes/EliminarUsu.png"> </img>

		        @include('admin.partials.delete')
             </div>
		 
    {!! form::close() !!}
        
		 
           
                        
                    </div><!--fin panel body-->
                </div><!--finnpanel default-->
            </div>

        </div><!--fin row-->
    </div><!--FIN DIV CONTAINER-->
@endsection