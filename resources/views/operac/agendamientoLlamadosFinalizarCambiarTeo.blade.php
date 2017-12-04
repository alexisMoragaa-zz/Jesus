@extends('app')
@section('content')
  <style>
    button{
      margin-top: 0.6em;
    }
    .badge{
      font-size: 1em;

    }
    span{
      float: right;
      margin-right: 10%;
    }
    .finalizar{
      float:right;
      margin-bottom: 1em;
    }
    .row{
      margin-top: 1em;
    }
  </style>

  <script>
    $().ready(function(){

    });
  </script>

  <div class="container">
  {!!Form::open(['url'=>['ope/agendamiento/llamado/Finalizar'],'method'=>'POST' ])!!}
    <div class="row">
      <div class="col-xs-12 col-md-10 col-md-offset-1">
        <div class="panel panel-info">
          <div class="panel-heading">
             Agendado Para Llamarse el {{$reage->fecha_llamado}}
          </div>
          <div class="panel-body">
            <div class="col-xs-12 col-md-6">
              <div class="col-xs-12 col-md-6">
                <label for="" class="control-label ">Nombre:</label>
              </div>
              <div class="col-xs-12 col-md-6">
                <span class="badge ">{{$reage->llamadosAgendados->nombre}} {{$reage->llamadosAgendados->apellido}}</span>
              </div>
            </div>

            <div class=" col-xs-12  col-md-6">
              <div class="col-xs-12 col-md-6">
                <label for="" class="control-label">telefono: </label>
              </div>

              <div class="col-xs-12 col-md-6">
                <span class="badge">{{$reage->llamadosAgendados->fono_1}}</span>
              </div>
            </div>

            <div class="col-md-6">
              <div class="col-xs-12 col-md-6">
                <label for="" class="control-label">Correo:</label>
              </div>
              <div class="col-xs-12 col-md-6">
                <span class="badge">{{$reage->llamadosAgendados->correo_1}} </span>
              </div>
            </div>

            <div class="col-md-6">
              <div class="col-xs-12 col-md-6">
                <label for="" class="control-label">Fecha Llamado:  </label>
              </div>
              <div class="col-xs-12 col-md-6">
                <span class="badge">{{$reage->fecha_llamado}}</span>
              </div>
            </div>

            <div class="col-md-6">
              <div class="col-xs-12 col-md-6">
                <label for="" class="control-label">Comentario:  </label>
              </div>

              <div class="col-xs-12 col-md-6">
                <span class="badge">{{$reage->llamadosAgendados->observacion}} </span>
              </div>
            </div>

            <div class="col-md-6">
              <div class="col-xs-12 col-md-6">
                <label for="" class="control-label">Teleoperador:</label>
              </div>

              <div class="col-xs-12 col-md-6">
                <span class="badge">{{$reage->teo_agenda->name}} {{$reage->teo_agenda->last_name}}</span>
              </div>
            </div>
          </div>

          <div class=" col-xs-12 col-md-3 finalizar">
            <button type="submit" name="button" class=" form-control btn btn-danger">Finalizar</button>
          </div>

      </div>
          <input type="hidden" value="{{$reage->id}}" name="id">
        {!!Form::close()!!}

    </div>
  </div>
</div>
@endsection
