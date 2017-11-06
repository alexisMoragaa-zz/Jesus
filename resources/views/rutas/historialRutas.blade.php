@extends('app')
@section('content')
    <style>
        .container{
            margin-top: 40px;
        }
    </style>
    <script>
        $(document).ready(function(){

        });
    </script>
    <div class="container">
        <div class="col-xs-12">
            {!!Form::open(['url'=>['rutas/historialRutasFiltrado'],'method'=>'POST'])!!}
                <div class="col-xs-4">
                    <label for="" class="control-label">Filtrar Por</label>
                    <select name="estado" id="" class="form-control">
                        <option value="">--Seleccione--</option>
                        <option value="1">Exitosas</option>
                        <option value="2">Rechazadas</option>
                    </select>
                </div>

                <div class="col-xs-5 col-md-3">
                    <label for="" class="control-label">Buscar Por dia</label>
                    <input type="date" class="form-control" name="dia">
                </div>

                <div class="col-xs-2">
                    <input type="submit" class="btn btn-primary btn1" value="Buscar" name="">
                </div>

            {!!Form::close()!!}
        </div>
        <div class="col-xs-12">
            <div class="hidden-xs">
                <div class="col-md-8">
                    <h3>Historial Rutas</h3>
                </div>
                <div class="col-md-4">
                    <h3>Rutas Realizadas {{$rutas->count()}}</h3>
                </div>
                @if(!empty($filtro))
                    <h3>Filtrado por {{$filtro}}</h3>
                @endif
            </div>

            <div class="visible-xs">
                <h4>Historial Rutas Realizadas {{$rutas->count()}}</h4>
                @if(!empty($filtro))
                    <h5>Filtrado por {{$filtro}}</h5>
                @endif
            </div>



            <div class="table table-responsive">
            <table class="table table-hover">
                <thead>
                <th>ID</th>
                <th>Nombre</th>
                <th>Telefono</th>
                <th>Rut</th>
                <th>Direccion</th>
                <th>Fecha Retiro</th>
                <th>Estado Ruta</th>
                <th>Estado Mandato</th>
                <th>Detalle</th>
                </thead>
                <tbody>

                    @foreach($rutas as $ruta)
                        <tr>
                            <td>{{$ruta->id}}</td>
                            <td>{{$ruta->nombre}} {{$ruta->apellido}}</td>
                            <td>{{$ruta->fono_1}}</td>
                            <td>{{$ruta->rut}}</td>
                            <td>{{$ruta->direccion}}</td>
                            <td>{{$ruta->fecha_agendamiento}}</td>
                            <td>{{$ruta->estadoRuta->estado}}</td>
                            <td>{{$ruta->estado_mandato}}</td>
                            <td><a href="{{url('rutas/detalleRuta',$ruta->id)}}">Ver Mas</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
        </div>


    </div>
@endsection
