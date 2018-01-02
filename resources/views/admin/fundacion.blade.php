@extends('app')
@section('content')
<style>
.center{
  text-align: center;
}
tr{
  margin-top: 3px;
  margin-bottom: 3px;
}
</style>
<script>
  $(document).ready(function(){
    $(".modal_campana").hide();

    $("#addCampana").click(function(){
      $(".modal_campana").dialog();
    });
  });
</script>

  <div class="row">
    <div class="container">
      <div class="col-md-12">
        <h2 class="text-muted center">{{$registro->nombre}}</h2>
      </div>
      <div class="col-md-8">
        <div class=" panel panel-default">
          <div class="panel-heading">
            <h4> Fundacion {{$registro->nombre}}</h4>
          </div>
          <div class="panel-body">

              <table class="table">
                <tr>
                  <td>Razon Social </td>
                  <td class="td-r">: {{$registro->razon_social}}</td>
                  <td>Email</td>
                  <td>: {{$registro->email}}</td>
                </tr>

                <tr>
                  <td>Direccion</td>
                  <td>: {{$registro->direccion}}</td>

                  <td>Agendamiento</td>
                  @if ($registro->agendamiento == 1)
                    <td>: Si</td>
                  @else
                    <td>: No</td>
                  @endif
                </tr>

                <tr>
                  <td>Regiones</td>
                  @if ($registro->regiones == 1)
                    <td>: Si</td>
                  @else
                    <td>: No</td>
                  @endif
                  <td>Upgrade</td>
                  @if ($registro->upgrade == 1)
                    <td>: Si</td>
                  @else
                    <td>: No</td>
                  @endif
                </tr>
                <tr>
                  <td>Campañas</td>
                  <td>: <span class="badge">{{$registro->misCampanas->count()}}</span></td>
                  <td></td>
                  <td></td>
                </tr>

              </table>
                <button type="button" name="button" class="btn btn-primary right" id="addCampana">Agregar Campaña</button>
            </div>
          </div>
        </div>

      @foreach ($campanas as $campana)
        <div class="col-md-4">
          <div class="panel panel-info">
            <div class="panel-heading">
              <h5 class="text-muted">
                {{$campana->nombre_campana}}
                  <a href="{{url('/admin/campana',$campana->id)}}" class="right">Detalle</a>
              </h5>

            </div>
            <div class="panel-body">
              <p>Registros <span class="badge right">{{$campana->registrosCampana->count()}}</span></p>
              <p>Ubicacion <span class="right">{{$campana->ubicacion}}</span></p>

            </div>
          </div>
        </div>
    @endforeach
    </div>
  </div>
  <div class="modal_campana">
    <form action="/admin/create/campana" method="post">
      <input type="hidden" name="_token" value="{{csrf_token()}}">
  <h4 class="text-muted center"> Agregar Campaña en </h4>
  <h4 class="text-muted center">{{$registro->nombre}}</h4>
      <label for="" class="control-label">Nombre de la campaña</label>
      <input type="text" name="nombre" value="" class="form-control" required>

      <label for="" class="control-label">Ubicacion</label>
      <select class="form-control" name="ubicacion" required>
        <option value="">Seleccione</option>
        <option value="RM">Region Metropolitana</option>
        <option value="OR">Otras Regiones</option>
      </select>
      <input type="hidden" name="fundacion" value="{{$registro->id}}">
      <input type="submit" class="btn btn1  btn-success col-md-12" value="Agregar Campaña" >
    </form>
  </div>

@endsection
