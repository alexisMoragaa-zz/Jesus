@extends('app')
@section('content')
<style>
  .table{
    margin-bottom: 0px;
  }
  .btn-danger{
    margin-bottom: 0.4em;
  }

  .left{
    float: left;
  }
  .right{
    float: right;
  }
</style>
<script>
  $().ready(function(){
    $(".modal-finalizados").hide();
    $(".modal-realizados").hide();

    $("#mostrarFinalizados").click(function(){
      $(".modal-finalizados").dialog({height:"auto", width:"auto"});
    });

    $("#mostrarRealizados").click(function(){
      $(".modal-realizados").dialog({height:"auto", width:"auto"});
    });

  });
</script>

<div class="container">
    <div class="modal-realizados">
      <div class=" panel panel-success">
        <div class="panel-heading">
            <p>Llamados Realizados</p>
        </div>
        <div class="panel-body">
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <th>Nombre</th>
                <th>Telefono</th>
                <th>Correo</th>
                <th>Fecha Llamado</th>
                <th>Comentario</th>
                <th>Estado</th>
              </thead>
              <tbody>
                @foreach ($realizados as $realizado)
                  <tr>
                    <td>{{$realizado->llamadosAgendados->nombre}}</td>
                    <td>{{$realizado->llamadosAgendados->fono_1}}</td>
                    <td>{{$realizado->llamadosAgendados->correo_1}}</td>
                    <td>{{$realizado->fecha_llamado}}</td>
                    <td>{{$realizado->llamadosAgendados->observacion}}</td>
                    <td>{{$realizado->estado_llamado}}</td>

                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <div class="modal-finalizados">
      <div class=" panel panel-danger">
        <div class="panel-heading">
            <p>Llamados Finalizados Sin Llamar</p>
        </div>
        <div class="panel-body">
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <th>Nombre</th>
                <th>Telefono</th>
                <th>Correo</th>
                <th>Fecha Llamado</th>
                <th>Comentario</th>
                <th>Estado</th>
              </thead>
              <tbody>
                @foreach ($finalizados as $fin)
                  <tr>
                    <td>{{$fin->llamadosAgendados->nombre}}</td>
                    <td>{{$fin->llamadosAgendados->fono_1}}</td>
                    <td>{{$fin->llamadosAgendados->correo_1}}</td>
                    <td>{{$fin->fecha_llamado}}</td>
                    <td>{{$fin->llamadosAgendados->observacion}}</td>
                    <td>{{$fin->estado_llamado}}</td>

                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>


<div class="row">
    <button type="button" name="button" class="btn btn-danger right" id="mostrarFinalizados">
      No Llamados <span class="badge">{{$finalizados->count()}}</span>
    </button>
    <button type="button" name="button" class="btn btn-success left" id="mostrarRealizados">
      Llamados <span class="badge">{{$realizados->count()}}</span>
    </button>
</div>
<div class="row">
  @if($nollamados->count() !=0)
    <div class="panel panel-warning">
      <div class="panel-heading col-xs-12">

          <div class=" left">
            <p>Olvidaste llamar algunos contactos</p>
          </div>
          <div class=" right">
            llamados no Realizados  <span class="badge">{{$nollamados->count()}}</span>
          </div>

      </div>

      <div class="panel-body">
        <div class="table table-responsive">
          <table class="table ">
            <thead>
              <th>Nombre</th>
              <th>Telefono</th>
              <th>Correo</th>
              <th>Fecha Llamado</th>

              <th>Comentario</th>
              <th>Accion</th>
            </thead>
            <tbody>
              @foreach ($nollamados as $dontcall)
              <tr>
                <td>{{$dontcall->llamadosAgendados->nombre}} {{$dontcall->llamadosAgendados->apellido}}</td>
                <td>{{$dontcall->llamadosAgendados->fono_1}}</td>
                <td>{{$dontcall->llamadosAgendados->correo_1}}</td>
                <td>{{$dontcall->fecha_llamado}}</td>

                <td>{{$dontcall->llamadosAgendados->observacion}}</td>
                <td><a href="{{url('teo/agendamiento/llamada/llamar',$dontcall->id)}}">Llamar</a></td>
              </tr>
            @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>{{--fin primer panel--}}
  </div>
  @endif
  <div class="row">
      <div class="panel panel-info">
        <div class="panel-heading col-xs-12">

          @if($callAgain->count()!=0)
            <div class=" left">
              <p>Recuerda llamar a los Siguientes Contactos</p>
            </div>
            <div class=" right">
              Llamados pendientes <span class="badge">{{$callAgain->count()}}</span>
            </div>
        @else
          <p>Actualmente no tienes Llamadas Agendada</p>
        @endif
        </div>

        <div class="panel-body">
          <div class="table table-responsive">
            <table class="table ">
              <thead>
                <th>Nombre</th>
                <th>Telefono</th>
                <th>Correo</th>
                <th>Fecha Llamado</th>

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

                  <td>{{$call->llamadosAgendados->observacion}}</td>
                  <td><a href="{{url('teo/agendamiento/llamada/llamar',$call->id)}}">Llamar</a></td>
                </tr>
              @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>{{--fin primer panel--}}
    </div>


  </div>{{--Fin Container--}}
</div>
@endsection
