@extends('app')
@section('content')
<style>

</style>

<script>

</script>

<div class="container">
  <h1 class="text-center text-muted">Fundacion {{$fundacion->nombre}}</h1>
    @foreach ($campanas as $campana)
      <div class="col-md-3">
        <div class="panel panel-primary text-center">
          <div class="panel-heading">{{$campana->nombre_campana}}</div>
            <div class="panel-body">Total Registros {{$campana->registrosCampana->count()}}</div>
            <div class="panel-footer">
              <a href="{{url('/informes/campana',$campana->id)}}">Detalle</a>
            </div>
        </div>

      </div>


    @endforeach


</div>

@endsection
