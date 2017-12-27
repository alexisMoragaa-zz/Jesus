@extends('app')
@section('content')
  <script>
    $(document).ready(function(){
      $("#select-fundation").change(function(){
      //funcion que se desencadena al evento change sobre el select de fundaciones
        var foundation_id = $(this).val();
        //tomamos el id de la fundacion cuando se desencadene la funcion change

        //AJAX
        $.get('/ope/byFoundation/'+foundation_id,function(data){
          //metodo de ajax para realizar una peticion asincrona al servidor y con esto traer las campañas de una fundacion
          var html_select ='<option value="">Seleccione Campaña</option>';//etiqueta html que insertaremos en la pagina
          for(var i=0;i<data.length;i++){//recorremos el largo de la data retornada por el servidor

            html_select+='<option value="'+data[i].id+'">'+data[i].nombre_campana+'</option>';
            //por cada elemento que tenga la data le concatenamos un option a nuestro elemento html_select
          }
            $("#select-campana").html(html_select);
            //una vez recorridos todos los elementos insertamos nuestro html_select en el select correspondiente con el metodo html
        });
      });
    });
  </script>
  <div class="container">
    <div class="row">
      <form action="/ope/mandatos/exitosos/filtrado" method="post">
        <input type="hidden" name="_token" value="{{csrf_token()}}">

        <div class="col-md-4">
          <label for="" class="control-label">seleccione Fundacion</label>
          <select name="selectFoundation" id="select-fundation" class="form-control">
            <option value="">Seleccione</option>
            @if(isset($fundaciones))
              @foreach ($fundaciones as $found)
                <option value="{{$found->id}}">{{$found->nombre}}</option>
              @endforeach
            @endif
          </select>
        </div>
        <div class="col-md-4">
          <label for="" class="control-label">Seleccione Campaña</label>
          <select name="selectcampana" id="select-campana" class="form-control">
            <option value="">Seleccione Campaña</option>
            @if(isset($fundacion))
              @foreach ($fundacion as $found)
                <option value=""></option>
              @endforeach
            @endif
          </select>
        </div>
        <input type="submit" value="Buscar" class="btn btn-primary btn1">
      </form>

    </div>{{--Segunda row--}}
    <div class="row">
      <h3 class="text-muted">@if(isset($breadCrum)){{$breadCrum}}@endif</h3>
      <div class="table table-responsive">
          <table class="table table-hover">
            <thead>
              <th>ID</th>
              <th>Nombre</th>
              <th>Rut</th>
              <th>Fono</th>
              <th>Direccion</th>
              <th>Comuna</th>
              <th>observaciones</th>
              <th>Rutero</th>
              <th>Agendamiento</th>
              <th>Detalle</th>
            </thead>
            <tbody>
              @if(isset($registros))
                @foreach ($registros as $registro)
                  <tr>
                    <td>{{$registro->id}}</td>
                    <td>{{$registro->nombre}}</td>
                    <td>{{$registro->rut}}</td>
                    <td>{{$registro->fono_1}}</td>
                    <td>{{$registro->direccion}}</td>
                    <td>{{$registro->comuna}}</td>
                    <td>{{str_limit($registro->observaciones,20)}}</td>
                    <td>{{$registro->rutero}}</td>
                    <td>{{$registro->fecha_agendamiento}}</td>
                    <td><a href="{{route('ope.call.show',$registro->id)}}">Ver Mas</a></td>
                  </tr>
                @endforeach
              @endif
            </tbody>
          </table>
      </div>
    </div>{{--fin segunda row--}}
  </div>
@endsection
