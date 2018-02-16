@extends('app')
@section('content')
  <script>
  $(document).ready(function(){

    $("#buscar").click(function(){
      if($("#ruteros").val()==""||$("#semana").val()==""){
          alert("Ingrese Criterios de Busqueda");

      }else{
          window.location ="/ope/rutas/semana/"+$("#semana").val()+"/"+$("#ruteros").val();
      }
    });
  });
  </script>
<div class="container">

  <div class="col-md-8 col-md-offset-2">
    <div class="col-md-4">
      <label for="" class="control-label">Seleccione Rutero</label>
      <select name="rutero" id="ruteros" class="form-control">
        <option value="">-Seleccione-</option>
        @foreach ($ruteros as $rutero)
          <option value="{{$rutero->name}}">{{$rutero->name}}</option>
        @endforeach
      </select>
    </div>
    <div class="col-md-4">
      <label for="semana" class="control-label">Seleccione Semana</label>
      <select name="semana" id="semana" class="form-control">
        <option value="">-Seleccione-</option>
        <option value="pasada">Semana Pasada</option>
        <option value="actual">Semana Actual</option>
        <option value="siguiente">Semana Siguiente</option>
      </select>
    </div>
    <div class="col-md-4">
      <input type="button" class="btn btn-success btn1" value="Buscar" id="buscar">
    </div>
  </div>

  <div class="col-md-12">
    <div class="table-responsive">
      <h3 class="text-muted text-center">Rutas a realizarse  los proximos 7 dias a partir de hoy // -> <span class=""> {{$rutas->count()}}</span></h3>
      <table class="table table-hover">
        <thead>
          <th>Nombre</th>
          <th>Rut</th>
          <th>Telefono</th>
          <th>Direccion</th>
          <th>Fecha Visita</th>
          <th>Rutero</th>
          <th>Ver Mas</th>
        </thead>
        <tbody>

          @foreach ($rutas as $r)
            <tr>
              <td>{{$r->nombre}} {{$r->apellido}}</td>
              <td>{{$r->rut}}</td>
              <td>{{$r->fono_1}}</td>
              <td>{{$r->direccion}}</td>
              <td>{{$r->fecha_agendamiento}}</td>
              <td>{{$r->rutero}}</td>

              <td><a href="{{url('/ope/detalleRuta',$r->id)}}">Ver Mas</a></td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>

</div>

@endsection()
