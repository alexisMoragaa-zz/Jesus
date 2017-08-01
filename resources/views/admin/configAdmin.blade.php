@extends('app')

@section('content')

    <script src="http://code.jquery.com/jquery-migrate-1.0.0.js"></script>
    <script>
        $(document).ready(function(){

           $("#add-status").hide();
            $("#add-status-retiro").hide();
            $("#add-payment-methods").hide();


            $("#add-campain-stats").toggle(function(){

                $("#add-status").fadeIn(1000);

            },function(){

                $("#add-status").fadeOut(1000);
            });


            $("#btn-add-status-retiro").toggle(function(){

                    $("#add-status-retiro").fadeIn(1000);
            }, function(){
                    $("#add-status-retiro").fadeOut(1000);
            });


            $("#btn-add-payment-methods").toggle(function(){

                $("#add-payment-methods").fadeIn(1000);
            },function(){
                $("#add-payment-methods").fadeOut(1000);
            });

        });
    </script>
    <style>
        .send-btn{
            margin-top: 24px;;

        }
        .container{
          margin:auto;
        }
    </style>
<div class="container">
    <input type="button" class="btn btn-info" value="Agregar Estado Llamada" id="add-campain-stats">
    <input type="button" class="btn btn-info" value="Agregar Estado Retiro" id="btn-add-status-retiro">
    <input type="button" class="btn btn-info" value="Agregar Formas de Pago" id="btn-add-payment-methods">

</div>
    <div class="container" id="add-status">
     {!!Form::open(['url'=>['admin/createstatus'],'method'=>'post']) !!}

            <div class="col-md-3">
                 <label for="" class="control-label">Nombre</label>
                <input type="text" class="form-control" id="name-status" name="name-status">
             </div>
        <div class="col-md-2">
            <label for="" class="control-label">Tipo</label>

            <select name="tipo" id="" class="form-control">
                <option value="cu+">CU+</option>
                <option value="cu-">CU-</option>
                <option value="cnu">CNU</option>
            </select>
        </div>

            <input type="submit" class="btn btn-success send-btn" id="" value="Agregar">

     {!! Form::close() !!}
    </div>

    <div class="container" id="add-status-retiro">
     {!!Form::open(['url'=>['admin/createcallstatus'],'method'=>'post']) !!}

            <div class="col-md-3">
                <label for="" class="control-label">Estado Retiro</label>
                <input type="text" class="form-control" id="name-status" name="name-status">
             </div>

            <input type="submit" class="btn btn-success send-btn" id="" value="Agregar">

      {!! Form::close() !!}
    </div>

    <div class="container" id="add-payment-methods">
      {!!Form::open(['url'=>['admin/createpaymentstatus'],'method'=>'post']) !!}

            <div class="col-md-3">
                <label for="" class="control-label">Forma de Pago</label>
                <input type="text" class="form-control" id="name-method" name="name-method">
            </div>

            <input type="submit" class="btn btn-success send-btn" id="" value="Agregar">

       {!! Form::close() !!}
    </div>

    <!-[ falta crear las funciones necesarias en los controladores para los fomularios de  add-status-retiro
    y add-payment-methods.
    adicionalmente falta crear las migraciones y en las vistas cargar la informacion desde la migracion]->


@endsection    

