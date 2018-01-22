@extends('app')
@section('content')
  <div class="container">
    @if(Session::has('message'))
      <div class="col-md-12 alert alert-success">
        {{Session::get('message')}}
      </div>
    @endif
    <div class="col-md-10">
      <h2 class="center">{{$breadcrum}}</h2>
    </div>
    <div class="col-md-2">
      <a href="{{url('ope/add/mandate/delivery',$data->id)}}" class="btn btn-primary mt-2 mb-2">Recepcionar Mandato</a>
    </div>

    <div class="panel panel-default">
      <div class="panel-body">
        <div class="table-responsive col-md-6 text-center">
          <table class="table table-striped">
            <tr>
              <td>Nombre</td>
              <td>{{$data->nombre}}</td>
            </tr>
            <tr>
              <td>Fono</td>
              <td>{{$data->fono_1}}</td>
            </tr>
            <tr>
              <td>Rut</td>
              <td>{{$data->rut}}</td>
            </tr>
            <tr>
              <td>region</td>
              <td>{{$data->region}}</td>
            </tr>
            <tr>
              <td>Fecha Calidad</td>
              <td>{{$data->fecha_captacion}}</td>
            </tr>
            <tr>
              <td>Fecha Retiro</td>
              <td>{{$data->fecha_agendamiento}}</td>
            </tr>
            <tr>
              <td>Estado Mandato</td>
              @if($data->estado_mandato =="")
                <td>Desconocido</td>
              @else
                <td>{{$data->estado_mandato}}</td>
              @endif
            </tr>
          </table>
        </div>


        <div class="table-responsive col-md-6 text-center ">
          <table class="table table-striped">
            <tr>
              <td>Apellido</td>
              <td>{{$data->apellido}}</td>
            </tr>

            <tr>
              <td>Correo</td>
              <td>{{$data->correo_1}}</td>
            </tr>

            <tr>
              <td>Comuna</td>
              <td>{{$data->comuna}}</td>
            </tr>


              <tr>
                <td>Direccion</td>
                <td>{{$data->direccion}}</td>
              </tr>
              <tr>
                <td>Fecha Venta</td>
                <td>{{$data->fecha_captacion}}</td>
              </tr>
              <tr>
                <td>Teleoperador</td>
                <td>{{$data->user->name}} {{$data->user->last_name}}</td>
              </tr>

              <tr>
                <td>Observaciones</td>
                <td>{{$data->observaciones}}</td>
              </tr>
          </table>
        </div>
      </div>
    </div>
  </div>

@endsection
