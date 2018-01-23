@extends('app')
@section('content')
<style>
.mt-2{
  margin-top: 2em;
}
</style>

<script>

</script>

<div class="container mt-2">
<div class="row">
  <div class="col-xs-12 col-md-4">
    <div class="list-group">
      <a href="#" class="list-group-item active" data-toggle="collapse" data-target="#teleoperadores">
        TeleOperadores <span class="badge">{{$teos->count()}}</span>
      </a>
      <div class="collapse" id="teleoperadores">
        @foreach ($teos as $teo)
          <a href="{{url('/informes/user',$teo->id)}}" class="list-group-item">{{$teo->name}} {{$teo->last_name}}</a>
        @endforeach
      </div>
    </div>
  </div>


  <div class="col-xs-12 col-md-4">
    <div class="list-group">
      <a href="#" class="list-group-item active" data-toggle="collapse" data-target="#fundaciones">
        Fundaciones <span class="badge">{{$fundaciones->count()}}</span>
      </a>
      <div class="collapse" id="fundaciones">
          @foreach ($fundaciones as $fund)
            <a href="{{url('/informes/fundacion',$fund->id)}}" class="list-group-item">{{$fund->nombre}} <span class="badge">{{$fund->misCampanas->count()}}</span></a>
          @endforeach
      </div>
    </div>
  </div>

  <div class="col-xs-12 col-md-4">
    <div class="list-group">
      <a href="#" class="list-group-item active" data-toggle="collapse" data-target="#campanas">
        Campañas <span class="badge">{{$campanas->count()}}</span>
      </a>
      <div class="collapse" id="campanas">
          @foreach ($campanas as $camp)
            <a href="{{url('/informes/campana',$camp->id)}}" class="list-group-item">{{$camp->nombre_campana}} <span class="badge">{{$camp->registrosCampana->count()}}</span></a>
          @endforeach
      </div>
    </div>
  </div>

</div>

<div class="row">

  <div class="col-xs-12 col-md-4">
    <div class="list-group">
      <a href="#" class="list-group-item active" data-toggle="collapse" data-target="#ruteros">
        Ruteros <span class="badge">{{$ruteros->count()}}</span>
      </a>
      <div class="collapse" id="ruteros">
        @foreach ($ruteros as $rutero)
          <a href="{{url('/informes/rutero',$rutero->id)}}" class="list-group-item">{{$rutero->name}} {{$rutero->last_name}}</a>
        @endforeach
      </div>
    </div>
  </div>
</div>
</div>
@endsection
