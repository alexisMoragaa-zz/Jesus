@extends('app')

@section('content')
<link href="{{ asset('/css/style.css') }}" rel="stylesheet">
<script src="{{asset('js/optimizar.js')}}"></script>
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

                  <div class="col-md-12">
                    @include('admin.partials.login')

                  </div>

             <div class=" col-md-2">

                 <button style="margin: 15px;"type="submit" class="btn btn-primary">Editar</button>
             </div>



    {!! form::close() !!}

   @include('admin.partials.delete')

                                @if(Auth::user()->perfil==1)
                                    <div class="form-group">
                                        <div class="col-md-4" style="padding:15px;">

                                            <a id="edit_pass" > Editar Pass</a>

                                            <label for="" id="error" style="text-align: center; color: red"></label>
                                        </div>

                    <div id="newpass" class="form-group">

                        {!!  Form::model($user,['url'=>['admin/updatePass',$user],'method'=>'POST','class' =>'form-horizontal', 'id'=>'form']) !!}

                                        <div class="col-md-3" class="newpass">
                                             <label for="" class="control-label">Contraseña</label>

                                                <input type="password" class="form-control" id="in_pass" name="in_pass">
                                        </div>

                                        <div class="col-md-3" class="newpass">

                                            <label for="" class="control-label" id="error">Confirmar</label>

                                            <input type="password" class="form-control" id="confirm_pass" name="confirm_password">
                                        </div>

                                        <div class="col-md-2">
                                            <label for="">.</label>
                                            <input type="button" class="btn btn-info form-control" id="btn_enviar" value="Actualizar">
                                        </div>
                        {!! Form::close() !!}
                    </div>
                                    </div>
                                @endif
                        </div>


                    </div><!--fin panel body-->
                </div><!--finnpanel default-->
            </div>

        </div><!--fin row-->
    </div><!--FIN DIV CONTAINER-->
@endsection