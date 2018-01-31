@extends('app')
@section('content')
  <style>


  .row{
    margin: 1em;
  }

  .texto-titulo{
    font-size: 1.3em;
  }
  .texto{
    font-size: 1.1em;
  }
  .badge{
    font-size: 0.9em;
  }
  .nav-stacked{
    margin-bottom: 1.5em;
  }
  </style>

  <script>
    $(document).ready(function(){
      $(".atrasados").hide();
      $(".finalizados").hide();
      $(".llamados").hide();

      $("#Pendientes").click(function(){
        $(".atrasados").fadeOut(600);
        $(".finalizados").fadeOut(600);
        $(".llamados").fadeOut(600);
        $(".pendientes").delay(600).fadeIn(600);
      });

      $("#atrasados").click(function(){
        $(".pendientes").fadeOut(600);
        $(".finalizados").fadeOut(600);
          $(".llamados").fadeOut(600);
        $(".atrasados").delay(600).fadeIn(600);
      });

      $("#finalizados").click(function(){
        $(".atrasados").fadeOut(600);
        $(".pendientes").fadeOut(600);
          $(".llamados").fadeOut(600);
        $(".finalizados").delay(600).fadeIn(600);
      });

      $("#llamados").click(function(){
        $(".atrasados").fadeOut(600);
        $(".pendientes").fadeOut(600);
          $(".finalizados").fadeOut(600);
        $(".llamados").delay(600).fadeIn(600);
      });

    });
  </script>


<div class="row ">
  <div class="col-xs-12 col-md-2"> {{--Inicio Filtros De Busqueda--}}
      <ul class="nav nav-pills nav-stacked">
          <li class="active">
              <a href="#" class=" texto-titulo">
                Buscar Por
              </a>
          </li>
          <li class="bg-info">
              <a href="#" class="text-muted texto" id="Pendientes">
                <span class="badge pull-right">{{$pendientes->count()}}</span>
                Pendientes
              </a>
          </li>
          <li class="bg-warning">
              <a href="#" class="text-muted texto" id="atrasados">
                <span class="badge pull-right">{{$atrasados->count()}}</span>
                Atrasados
              </a>
          </li>
          <li class="bg-success">
              <a href="#" class="text-muted texto" id="llamados">
                <span class="badge pull-right">{{$llamados->count()}}</span>
                Llamados
              </a>
          </li>
          <li class="bg-danger">
              <a href="#" class="text-muted texto" id="finalizados">
                <span class="badge pull-right">{{$finalizados->count()}}</span>
                No Llamados
              </a>
          </li>
      </ul>
    </div>
{{--Fin Filtros de Busqueda--}}
{{-- Inicio Panel pendientes--}}
  <div class="col-xs-12 col-md-10 col-m pendientes">
    <div class="panel panel-info">
        <div class="panel-heading">
            <p> Agendamientos pendientes por llamar </p>
        </div>

        <div class="panel-body">
          <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <th>Nombre</th>
                    <th>Telefono</th>
                    <th>Correo</th>
                    <th>Fecha Llamado</th>
                    <th>Comentario</th>
                    <th>Teleoperador</th>

                </thead>
                <tbody>
                  @foreach ($pendientes as $pen)
                    <tr>
                        <td>{{$pen->llamadosAgendados->nombre}}</td>
                        <td>{{$pen->llamadosAgendados->fono_1}}</td>
                        <td>{{$pen->llamadosAgendados->correo_1}}</td>
                        <td>{{$pen->llamadosAgendados->observacion}}</td>
                        <td>{{$pen->fecha_llamado}}</td>
                        <td>{{$pen->teo_agenda->name}}</td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

{{-- Fin Panel pendientes--}}
{{-- Inicio Panel Atrasados--}}
  <div class="col-xs-12 col-md-10 atrasados">
      <div class="panel panel-warning">
          <div class="panel-heading">
            <p>llamados Atrasados </p>
          </div>

          <div class="panel-body">
            <div class="table-responsive">
              <table class="table table-hover ">
                  <thead>
                      <th>Nombre</th>
                      <th>Telefono</th>
                      <th>Correo</th>
                      <th>Fecha Llamado</th>
                      <th>Comentario</th>
                      <th>Teleoperador</th>
                      <th>Accion</th>
                  </thead>
                  <tbody>
                    @foreach ($atrasados as $atrasado)
                      <tr>
                          <td>{{$atrasado->llamadosAgendados->nombre}}</td>
                          <td>{{$atrasado->llamadosAgendados->fono_1}}</td>
                          <td>{{$atrasado->llamadosAgendados->correo_1}}</td>
                          <td>{{$atrasado->fecha_llamado}}</td>
                          <td>{{$atrasado->llamadosAgendados->observacion}}</td>
                          <td>{{$atrasado->teo_agenda->name}}</td>
                          <td>
                            <a href="{{url('ope/agendamiento/llamada/finalizar',$atrasado->id)}}">Finalizar </a>
                          </td>
                      </tr>
                    @endforeach
                  </tbody>
              </table>
          </div>
        </div>
    </div>
  </div>
{{-- Fin Panel Atrasasdos--}}
{{-- Inicio Panel Finalizados--}}
  <div class="col-xs-12 col-md-10 finalizados" >
    <div class="panel panel-danger">
      <div class="panel-heading">
        <p class="">llamados Finalizados</p>

      </div>
      <div class="panel-body">
        <div class="table table-responsive">
          <table class="table table-hover ">
            <thead>
              <th>Nombre</th>
              <th>Telefono</th>
              <th>Correo</th>
              <th>Fecha Llamado</th>
              <th>Comentario</th>
              <th>Teleoperador</th>
            </thead>
            <tbody>
              @foreach($finalizados as $fin)
                <tr>
                  <td>{{$fin->llamadosAgendados->nombre}}</td>
                  <td>{{$fin->llamadosAgendados->fono_1}}</td>
                  <td>{{$fin->llamadosAgendados->correo_1}}</td>
                  <td>{{$fin->fecha_llamado}}</td>
                  <td>{{$fin->llamadosAgendados->observacion}}</td>
                  <td>{{$fin->teo_agenda->name}}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
{{-- Fin Panel NoLlamado--}}
{{-- Inicio Panel Llamados --}}
    <div class="col-xs-12 col-md-10 llamados">
      <div class="panel panel-success">
          <div class="panel-heading">
            <p>llamados Realizados </p>
          </div>

          <div class="panel-body">
            <div class="table-responsive">
              <table class="table table-hover ">
                  <thead>
                      <th>Nombre</th>
                      <th>Telefono</th>
                      <th>Correo</th>
                      <th>Fecha Llamado</th>
                      <th>Comentario</th>
                      <th>Teleoperador</th>
                  </thead>
                  <tbody>
                    @foreach ($llamados as $llamado)
                      <tr>
                        <td>{{$llamado->llamadosAgendados->nombre}}</td>
                        <td>{{$llamado->llamadosAgendados->fono_1}}</td>
                        <td>{{$llamado->llamadosAgendados->correo_1}}</td>
                        <td>{{$llamado->fecha_llamado}}</td>
                        <td>{{$llamado->llamadosAgendados->observacion}}</td>
                        <td>{{$llamado->teo_agenda->name}}</td>
                      </tr>
                    @endforeach
                  </tbody>
              </table>
          </div>
        </div>
    </div>
    </div>
{{-- Inicio Panel Llamados --}}

</div>{{--Fin Row--}}



  <div class="container">  </div>

@endsection
