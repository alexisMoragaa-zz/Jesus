@extends('app')
@section('content')
<style>
.center{
  text-align: center;
}
#id{
  margin-top: -1em;
}
.badge-warning {
  background-color: #FFA500;
}
.badge-warning:hover {
  background-color: #c67605;
}
</style>


<div class="row" id="id">
  <div class="container">
    <h2 class="text-muted center">Agregar Mandatos a la carta  0{{$letter->number}} de {{$letter->letterByFoundation->nombre}}</h2>
    <div class="col-md-12 ">


      <input type="hidden" id="letter_id" value="{{$letter->id}}">
      <input type="button" name="" value="Ver Carta" class="btn btn-warning  center-block" id="showLetter">


    </div>

    <div class="col-md-10 col-md-offset-1">
      <div class="table-responsive">
        <table class="table">
          <thead>
            <th>ID</th>
            <th>Nombre</th>
            <th>Fono</th>
            <th>Rut</th>
            <th>Direccion</th>
            <th>Añadir</th>
          </thead>
          <tbody>
            @foreach ($registros as $registro)
              <tr data-id="{{$registro->id}}">
                <td>{{$registro->id}}</td>
                <td>{{$registro->nombre}}</td>
                <td>{{$registro->fono_1}}</td>
                <td>{{$registro->rut}}</td>
                <td>{{$registro->direccion}}</td>
                <td><a href="#" class="btn-add">Agregar</a></td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>{{--fin container--}}
</div>{{--fin Row--}}

<script>
  $(document).ready(function(){
    $(".btn-add").click(function(){

      var row = $(this).parents('tr');//seleccionamos la fila
      var cap_id = row.data('id');
      var letter_id = $("#letter_id").val();
        row.fadeOut();//ocultamos la row
      $.get('/ope/addRecords/letterAjax',{cap_id,letter_id},function(data){
          alert('Registro Agregado');

      }).fail(function(){//si la peticion falla o el registro no es liberado correctamente se desencadena la funcion fail
          alert("Error el Registro no se Agrego Correctamente a la carta");//mensaje de alerta ante el fallo
          row.fadeIn();//regresamos la row que ocultamos si la liberacion del registro falla
        });
    });

    $("#showLetter").click(function(){
      window.location="/ope/show/letter/"+$("#letter_id").val();
    });
  });
</script>
@endsection
