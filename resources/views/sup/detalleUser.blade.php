@extends('app')
@section('content')



    <link href="{{ asset('/css/style.css') }}" rel="stylesheet">
   <!-- <div>
        <img class="logosu" src="/imagenes/supervisor.png"  >
    </div> -->
    <div class="container">

        <div class="form-group">
            <div class="col-md-8">
                <p style="font-size: 2.7em">
                    {{$usuarios->name}}
                </p>
            </div>

            <div class="col-md-4" >
                @if(Auth::User()->perfil==1)
                        <a style="margin-left: 68% " href="{{route('admin.sup.edit',$usuarios->id)}}" class="btn btn-info">Añadir Campaña</a>
                 @elseif(Auth::User()->perfil==3)
                        <a style="margin-left: 68% " href="{{route('sup.sup.edit',$usuarios->id)}}" class="btn btn-info">Añadir Campaña</a>
                 @endif
            </div>
        </div>

        <div class="table-responsive" style="clear: left">
            <table class="table table-bordered">
                <tr>
                    <th>Campañas</th>
                    <th>Inicio Campaña</th>
                    <th>Termino Campaña</th>
                    <th>Motivo Termino</th>
                </tr>
                    @foreach($usuarios->campanitas as $campana)
                         <tr data-id="{{$usuarios->id}}">
                             <td>{{$campana->nombre_campana}}</td>
                             <td>{{$campana->pivot->fecha_inicio}}</td>
                             <td>{{$campana->pivot->fecha_termino}}</td>
                             <td>{{$campana->pivot->motivo_termino}}</td>
                         </tr>
                    @endforeach
                <!--en una tabla mostramos el usuario seleccionado en la vista sup/supervisor y con el foreach recorremos
                    todas las campañas que tenga en la tabla pivote ese usurio-->
            </table>

        </div><!--fin table resposibe-->

    </div><!--fin container-->

@endsection