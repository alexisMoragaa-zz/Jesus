@extends('app')
@section('content')
  <style media="screen">
    .float-right{
      float: right;

    }
  </style>
  <script>

    $(document).ready(function(){
      $(".modal_cambio_estado_mandato").hide();
      $(".detalle").click(function(){
        var row =$(this).parents('tr');
        var id = row.data('id');
        var nombre = row.data('name');
        $("#id_cap").val(id);
        $("#nombre_socio").text(nombre);
          $(".modal_cambio_estado_mandato").dialog({width:"25%"});
      });
    });
  </script>
  <div class="container">
    <div class="row">
      <div class="col-xs-12">

      <h2>Mandatos Con Reparo <span class="badge">{{$registros->count()}}</span></h2>
      <div class="table table-responsive">
        <table class="table table-hover">
          <thead>
            <th>Nombre</th>
            <th>Fono</th>
            <th>Rut</th>
            <th>Direccion</th>
            <th>Observacion</th>
            <th>Monto</th>
            <th>Rutero</th>
            <th>Estado Mandato</th>
            <th>Motivo</th>
            <th>Detalle</th>
          </thead>
          <tbody>
            @foreach ($registros as $registro)
              <tr data-id="{{$registro->id}}" data-name="{{$registro->nombre}}">
                  <td>{{$registro->nombre}} {{$registro->apellido}}</td>
                  <td>{{$registro->fono_1}}</td>
                  <td>{{$registro->rut}}</td>
                  <td>{{$registro->direccion}}</td>
                  <td>{{$registro->observacion}}</td>
                  <td>{{$registro->monto}}</td>
                  <td>{{$registro->rutero}}</td>
                  <td>{{$registro->estado_mandato}}</td>
                  <td>{{$registro->motivo_mdt}}</td>
                  <td><a href="#" class="detalle">Detalles</a></td>
                </tr>
              @endforeach
          </tbody>
        </table>
      </div>
    </div> {{--fin col-md-12--}}

    <div class="modal_cambio_estado_mandato" title="Actualizar Mandato">{{--ventana modal que se despliega para cambiar el estado de los madatos--}}
      <form action="/ope/conReparo/cambiarEstado" method="post">
        <input type="hidden" name="_token" value="{{csrf_token()}}">
        <h3 class="text-muted" id="nombre_socio"></h3>

        <label for="" class="control-label">Seleccione</label>
        <select name="estado_mandato" id="" class="form-control">
          <option value="OK">OK</option>
          <option value="rechazado">Rechazado</option>
        </select>

        <label for="" class="control-label">Comentario</label>
        <input type="text" class="form-control" name="comentario">

        <input type="hidden" id="id_cap" name="id_cap">
        <input type="submit" class="btn btn-success btn1 float-right" value="Agregar estado">
      </form>
    </div>{{--fin modal carmbiar estado mandato--}}

  </div>{{--fin row--}}
</div>{{--fin container--}}

@endsection
