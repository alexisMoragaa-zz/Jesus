@extends('app')
@section('content')



    <link href="{{ asset('/css/style.css') }}" rel="stylesheet">
   <!-- <div>
        <img class="logosu" src="/imagenes/supervisor.png"  >
    </div> -->
    {!! Form::Open(['route'=>['admin.sup.update',$usuarios->id],'method'=>'Put'])!!}

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

        {!! Form::Close() !!}

    </div><!--fin container-->

@endsection