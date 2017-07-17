@extends('app')
@section('content')



@if(Auth::User()->perfil==1)

    {!! Form::Open(['route'=>['admin.sup.update',$usuarios->id],'method'=>'Put'])!!}

@elseif(Auth::User()->perfil==3)

    {!! Form::Open(['route'=>['sup.sup.update',$usuarios->id],'method'=>'Put'])!!}

@endif



<input type="hidden" name="_token" value="{{ csrf_token() }}"  >
<input type="hidden" name="usuario" value="{{$usuarios->name}}">
<div class="container">

    <div class="form-group" >
        <div class="col-md-4">
            <p style="font-size: 2.2em;">
                {{$usuarios->name}}
            </p>
        </div>

        <div class="col-md-4">
            <select name="campanas"  class="form-control">

                @foreach($campanas as $campana)
                    <option value="{{$campana->id}}" name="seleccion">{{$campana->nombre_campana}}</option>
                @endforeach
                <!--recorremos con un foreach las campañas y guardamos en el atributo value el id correspondiente
                    mientras mostramos el nombre de la campaña en la vista-->
            </select>
        </div>

        <div class="col-md-2">
            <input type="date" name="fecha_inicio" value="{{date('Y-m-d')}}" class=" form-control ">
        </div><!--fin col md2-->

        <div class="col-md-2">
            <input type="submit" class="btn btn-info" value="Añadir Campaña">
        </div><!--fin col md2-->

    </div><!--fin form group-->
</div> <!--fin container-->

{!! Form::Close() !!}
@endsection