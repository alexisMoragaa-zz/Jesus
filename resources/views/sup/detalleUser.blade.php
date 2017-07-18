@extends('app')
@section('content')





    <script type="text/javascript">
        $(document).ready(function() {
            $("#table_campana").tablesorter({sortList:[[4,1],[1,0]]});

            /**para establecer un orden inicial usamos sortlist, y le pasamos como parametro 2 arrays con dos campos cada uno, el primero
             * corresponde a la fila que deseamos ordenar partiendo desde el 0 y el segundo al order, siendo 0 acendente. y 1 decendente*/


        });

    </script>
    <link href="{{ asset('/css/style.css') }}" rel="stylesheet">

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

        <div class="table-responsive" style="clear: left;">
            <table id="table_campana" class="table table-bordered ">
                <thead>
                    <tr>
                        <th class ="colorhead">Campañas</th>
                        <th>Inicio Campaña</th>
                        <th>Termino Campaña</th>
                        <th>Motivo Termino</th>
                        <th>Fecha asignacion</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($usuarios->campanitas as $campana)

                         <tr data-id="{{$campana->id}}">
                             <td>{{$campana->nombre_campana}}</td>
                             <td>{{$campana->pivot->fecha_inicio}}</td>
                             <td>{{$campana->pivot->fecha_termino}}</td>
                             <td>{{$campana->pivot->motivo_termino}}</td>
                             <td>{{$campana->pivot->created_at}}</td>
                             @if($campana->pivot->motivo_termino =="")
                              <td style="border:0"><a href="{{url('admin/updatePivot')}}{{$usuarios->id}}/{{$campana->pivot->id}}" >Finalizar</a></td>
                             @else
                                <td>Finalizada</td>
                             @endif
                         </tr>

                    @endforeach
                </tbody>
                <!--en una tabla mostramos el usuario seleccionado en la vista sup/supervisor y con el foreach recorremos
                    todas las campañas que tenga en la tabla pivote ese usurio-->
            </table>

        </div><!--fin table resposibe-->

    </div><!--fin container-->





@endsection