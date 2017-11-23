@extends('app')
@section('content')
<style>
.table{
  margin-bottom: 0px;
}
.panel-headin{
  margin-bottom: 0px;
}
.panel-info{
  margin-top: 1em;
}
.left{
  float: left;
}
.right{
  float: right;
}
</style>

  <div class="container">

      <div class="panel panel-success">
        <div class="panel-heading col-xs-12">
          <div class=" left">
            <p>Recuerda llamar a los Siguientes Contactos</p>
          </div>
          <div class=" right">Tienes {{$callAgain->count() }} Contactos por Llamar</div>
        </div>
        <div class="panel-body">
          <div class="table table-responsive">
            <table class="table ">
              <thead>
                <th>Nombre</th>
                <th>Telefono</th>
                <th>Correo</th>
                <th>Fecha Llamado</th>
                <th>Info</th>
                <th>Comentario</th>
                <th>Accion</th>
              </thead>
              <tbody>
                @foreach ($callAgain as $call)
                <tr>
                  <td>{{$call->llamadosAgendados->nombre}} {{$call->llamadosAgendados->apellido}}</td>
                  <td>{{$call->llamadosAgendados->fono_1}}</td>
                  <td>{{$call->llamadosAgendados->correo_1}}</td>
                  <td>{{$call->fecha_llamado}}</td>
                  <td>no</td>
                  <td>{{$call->llamadosAgendados->observacion}}</td>
                  <td><a href="">Llamar</a></td>
                </tr>
              @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>{{--fin primer panel--}}


  </div>{{--Fin Container--}}

@endsection
