@extends('app')
@section('content')
  <script>
  $(document).ready(function(){

    $("#buscar").click(function(){
      if($("#semana").val()==""){
          alert("Ingrese Criterios de Busqueda");
      }else{
          window.location ="/rutas/semana/"+$("#semana").val()+"/"+$("#rutero").val();
      }
    });
  });
  </script>
  <div class="container">
    <div class="col-xs-12 col-md-7 col-md-offset-2">
      <div class="input-group">
        <label for="" class="control-label">Seleccionar Semana</label>
          <select name="" id="semana" class="form-control">
            <option value="">-Seleccione-</option>
            <option value="pasada">Semana Pasada</option>
            <option value="actual">Semana Actual</option>
            <option value="siguiente">Semana Siguiente</option>
          </select>
          <span class="input-group-btn">
            <input type="button" class="btn btn-success btn1" value="Buscar" id="buscar">
            <input type="hidden" id="rutero" value="{{Auth::User()->name}}">
          </span>
      </div>
    </div>
  </div>
@endsection
