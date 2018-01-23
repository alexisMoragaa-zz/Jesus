@extends('app')
@section('content')

<div class="container">
  <h1 class="text-center text-muted">{{$user->name }}  {{$user->last_name}}</h1>
  <div class="col-md-4">
    <div class=" panel panel-default">
      <div class="panel-heading">Campañas</div>
      <div class="list-group">
        @foreach ($user->campanitas as $c)
          <a href="#" class="list-group-item">{{$c->nombre_campana}}</a>

        @endforeach

      </div>
    </div>
  </div>

<div class="col-md-4">
  <div class=" panel panel-default">
    <div class="panel-heading">Campaña Actual</div>
    <ul class="list-group">
      <li class="list-group-item">Llamados <span class="badge">4</span></li>
      <li class="list-group-item">No Contactados (CNU) <span class="badge">2</span></li>
    </ul>
  </div>

  <div class="panel panel-default">
    <div class="panel-heading">Contactados <span class="badge right">2</span></div>
    <ul class="list-group">
      <li class="list-group-item">Cu+ <span class="badge">1</span></li>
      <li class="list-group-item">Cu- <span class="badge">1</span></li>
    </ul>
  </div>

</div>




<div class="col-md-4">
  <div class=" panel panel-default">
    <div class="panel-heading">Agendamiento Llamados</div>
    <ul class="list-group">
      <li class="list-group-item">Total Agendamientos <span class="badge"></span></li>
      <li class="list-group-item">Llamados realizados <span class="badge"></span></li>
      <li class="list-group-item">No Realizado <span class="badge"></span></li>
    </ul>
  </div>
</div>

</div>

@endsection
