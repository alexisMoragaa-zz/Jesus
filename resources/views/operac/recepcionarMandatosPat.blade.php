@extends('app')
@section('content')
  <style>
    .center{
      text-align: center;
    }

  </style>
  <script src="{{asset('plugins/jquery-validator/jquery.validate.js')}}"></script>
  <script>
    $(document).ready(function(){
      $(".addmdt-dialog").hide();//ocultamos la ventana modal
        $(".addmdt").click(function(){//cuando damos click al enlace agragar Mandato
          var row = $(this).parents('tr');//tomamos el valor de la fina en la que hicimos click
          var id = row.data('id');//tomamos el id del registro obtenido desde la fila
          var name = row.data('name');//seleccionamos el nombre del registro desde la fila
          row.fadeOut();
        $.get('/ope/addMdt/status/pat',{id},function(data){
          alert(data);
        }).fail(function(){
          alert("Error al Recepcionar Mandato");
          row.fadeIn();
        });

      });

    });



  </script>
  <div class="container">
    <div class="row">
      <div class="col-md-12">

          <h3 class="text-muted">Buscando Agendamiento por
            @if(isset($filtroPor))
              <span>{{$filtroPor}}</span>
            @endif
          </h3>

      <div class="col-md-12">
        <div class="table-responsive">
          <table class="table table-hover">
            <thead>
              <th>Nombre</th>
              <th>Telefono</th>
              <th>Rut</th>
              <th>Direccion</th>
              <th>Comuna</th>
              <th>Detalle</th>
            </thead>
            <tbody>
              @if(isset($registros))
                @foreach ($registros as $registro)
                  <tr data-id="{{$registro->id}}" data-name="{{$registro->nombre}}">
                    <td>{{$registro->nombre}}</td>
                    <td>{{$registro->fono_1}}</td>
                    <td>{{$registro->rut}}</td>
                    <td>{{$registro->direccion}}</td>
                    <td>{{$registro->comuna}}</td>
                    <td><a href="#" class="addmdt">Agregar Mandato Ok</a></td>
                  </tr>
                @endforeach
              @endif
            </tbody>
          </table>
        </div>
      </div>
<input type="hidden" name="" value="" id="id">
<div class="addmdt-dialog">
  <h4 class="text-muted center">Recepcionar Mandato de</h4>
  <h4 class="center"><span id="nameSocio" class="text-muted"></span></h4>
  <label for="" class="control-label">Seleccione Estado</label>
  <select name="status" id="status" class="form-control">
    <option value="">Seleccione</option>
    <option value="OK">OK</option>
  </select>
  <button class="btn btn-danger btn1" id="cancel">Cancelar</button>
<button class="btn btn-success btn1 right" id="success">Recepcionar</button>
</div>

    </div>
  </div>
  </div>{{--Fin Cointainer--}}

@endsection
