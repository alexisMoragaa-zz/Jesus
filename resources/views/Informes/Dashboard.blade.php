@extends('app')
@section('content')
<style>
.txt{
  color: black;
}
</style>

<script>

</script>

  <div class="container">
    <h2 class="text-muted">Datos sobre la base <span class="txt">{{$name}}</span> de  <span class="txt">{{$fundacion}}</span></h2>
    <div class="col-md-12">
      <div class="col-md-4">
        <h3>Total Base</h3>
        <h4>{{$total}}</h4>
      </div>
      <div class="col-md-4">
        <h3>Total LLamados</h3>
        <h4>{{$llamados}}</h4>
      </div>
      <div class="col-md-4">
        <h3>Total Sin Llamar</h3>
        <h4>{{$pendientes}}</h4>
      </div>
    </div>

    <div class="col-md-12">
      <div class="col-md-9">
        <h2>Contactados</h2>

        <div class="col-md-6">
          <h3>CU+</h3>
          <h4>{{$cumas}}</h4>
        </div>
        <div class="col-md-6">
          <h3>CU-</h3>
          <h4>{{$cumenos}}</h4>
        </div>
      </div>
      <div class="col-md-3">
        <h2>No Contactados</h2>
        <div class="col-md-12">
          <h3>CNU</h3>
          <h4>{{$cnu}}</h4>
        </div>
      </div>
    </div>
    <div class="col-md-12">
      <div class="col-md-4">
        <h3>Penetracion</h3>
        <h4>{{$penetracion}}</h4>
      </div>
      <div class="col-md-4">
        <h3>Contactavilidad</h3>
        <h4>{{$contactavilidad}}</h4>
      </div>
      <div class="col-md-4">
        <h3>Penetracion Total de la Base</h3>
        <h4>{{$penetracionTotal}}</h4>
      </div>
    </div>

  </div>
@endsection
