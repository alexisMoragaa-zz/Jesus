@extends('app')
@section('content')
  <script>
    $(document).ready(function(){
      $("#buscar").click(function(){
        window.location='/ope/liberar/registros/show/'+$("#campana").val();
        //funcion que nos redirecciona a una pagina donde se recopilaran los registros tomados de una campaña
        //en concreto mediante el id que le enviamos por la url
      });
      $(".liberar").click(function(){//funcion que se desencadena al evento click del enlace para liberar registro
        var row = $(this).parents('tr');//definimos el valor de la bariable row  al elemento tr padre del elemento
        //que desencadeno la funcion click, para eso usamos el this
        var id = row.data('id');//asignamos a la variable id el valor de el atributo id del elemento tr que obtenemos mediante la row

        row.fadeOut();//ocultamos el elemento apenas damos click a la funcion

        $.get('/ope/liberar/registro/ajax?id='+id,function(resultado){
        //peticion ajax que libera el registro

      }).fail(function(){//si la peticion falla o el registro no es liberado correctamente se desencadena la funcion fail
          alert("Error el Registro no se libero Correctamente");//mensaje de alerta ante el fallo
          row.fadeIn();//regresamos la row que ocultamos si la liberacion del registro falla
        });


      });
    });
  </script>
  {{-- <form action="/ope/liberar/registro/ajax:user_id" method="post" id="liberarAjax">
    <input type="hidden" name="_token" value="{{csrf_token()}}">
  </form> --}}
  <div class="row">
    <div class="container">
      <h2 class="text-muted">Liberar Registros
        @if(isset($registros))
          <span class="badge">{{$registros->count()}}</span>
        @endif
      </h2>

      <div class="col-md-4">
        <label for="" class="control-label">Seleccione Campaña</label>
        <select name="campana" id="campana" class="form-control">
          <option value="">Seleccione</option>
          @if(isset($campanas))
            @foreach ($campanas  as $campana)
              <option value="{{$campana->id}}">{{$campana->nombre_campana}}</option>
            @endforeach
          @endif
        </select>
      </div>
      <div class="col-md-3">
        <a href="#" class="btn btn-primary btn1" id="buscar">Buscar</a>
      </div>

    </div>
  </div>{{--fin primera row--}}

  <div class="row">
    <div class="container">
      <div class="table table-responsive">
        <table class="table table-hover">
          <thead>
            <th>Nombre</th>
            <th>Telefono</th>
            <th>Campaña</th>
            <th>Accion</th>

          </thead>
          <tbody>
            @if(isset($registros))
              @foreach ($registros as $registro)
                <tr data-id="{{$registro->id}}">
                  <td>{{$registro->nombre}}</td>
                  <td>{{$registro->fono_1}}</td>
                  <td>{{$registro->campanas->nombre_campana}}</td>
                  <td><a href="#" class="liberar">liberar Registro</a></td>
                </tr>
              @endforeach
            @endif
          </tbody>
        </table>
      </div>
    </div>
  </div>{{--fin segunda row--}}

@endsection
