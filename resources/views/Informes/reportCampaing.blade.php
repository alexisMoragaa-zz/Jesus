@extends('app')
@section('content')
  <style>
  .center{
    text-align: center;
  }
  </style>

<script>

</script>

<div class="container">
  <div class="row">

    <div class="col-md-12">
      @if(Auth::user()->perfil==1)
        <a href="{{url('/admin/export/report/campana',$campana->id)}}" class="btn btn-success right btn1">Exportar a Excel</a>
      @elseif (Auth::user()->perfil==6)
        <a href="{{url('/informes/export/report/campana',$campana->id)}}" class="btn btn-success right btn1">Exportar a Excel</a>
      @endif
      <h2 class="text-muted center">Reporte Campaña {{$campana->nombre_campana}}</h2>
      <div class="col-md-4">
        <h4 class="btn1">Registros llamados <span class="badge">{{$llamados}}</span></h4>
      </div>
      <div class="col-md-4">
        <h4 class="btn1">Total Registros <span class="badge">{{$campana->registrosCampana->count()}}</span></h4>
      </div>
      <div class="col-md-4">
          <h4 class="right btn1">Registros Pendientes <span class="badge">{{$pendientes}}</span></h4>
      </div>
    </div>

  </div>

  <div class="row">
    <div class="col-md-12">
      <div class="table table-responsive">
        <table class="table">
          <thead>
            <th>ID</th>
            <th>Fono</th>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>correo</th>
            <th>Estado</th>
            <th>call 01</th>
            <th>Estado</th>
            <th>call 02</th>
            <th>Estado</th>
            <th>call 03</th>
            <th>estado</th>
            <th>N° llamados</th>
          </thead>
          <tbody>
            @foreach($campana->registrosCampana as $c)
              <tr>
                <td>{{$c->id}}</td>
                <td>{{$c->fono_1}}</td>
                <td>{{$c->nombre}}</td>
                <td>{{$c->apellido}}</td>
                <td>{{$c->correo_1}}</td>
                <td>{{$c->estado}}</td>
                <td>{{$c->primer_llamado}}</td>
                <td>{{$c->estado_llamada1}}</td>
                <td>{{$c->segundo_llamado}}</td>
                <td>{{$c->estado_llamada2}}</td>
                <td>{{$c->tercer_llamado}}</td>
                <td>{{$c->estado_llamada3}}</td>
                <td>{{$c->n_llamados}}</td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection
