@extends('app')

@section('content')

    <script src="http://code.jquery.com/jquery-migrate-1.0.0.js"></script>
    <script>
        $(document).ready(function(){

            $("#add-status").hide();
            $("#add-status-retiro").hide();
            $("#add-payment-methods").hide();
            $(".form_dialog_cap").hide();



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

            $("#addMiMaxCap").click(function(){

                $(".form_dialog_cap").dialog({
                    heigh:"auto",
                    width:"auto",
                    buttons: [{
                        text: "Cancelar","class":'btn btn-danger space',"id":'space',click: function () {

                            $(this).dialog("close");
                        }},{
                        text:"Aceptar","class":'btn btn-success',"id":'space2',click : function(){
                            var diaq =$("#day").val();
                            var amq=$("#am").val();
                            var pmq=$("#pm").val();
                            var am=parseInt(amq);
                            var pm =parseInt(pmq);
                            var dia=parseInt(diaq);

                            var ampm = am + pm;

                             if(ampm === dia){
                                 $("#form_max_cap").submit();
                             }else{

                                 alert("La summa  de agendamientos Am y Pm no pueden superar ni ser menores a la cantidad diaria");
                             }


                        }
                    }]
                });
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
    <div class="col-md-12">

        <div class="col-md-2">
            <input type="button" class="btn btn-info" value="Agregar Estado Llamada" id="add-campain-stats">
        </div>

        <div class="col-md-2">
            <input type="button" class="btn btn-info" value="Agregar Estado Retiro" id="btn-add-status-retiro">
        </div>

        <div class="col-md-2">
            <input type="button" class="btn btn-info" value="Agregar Formas de Pago" id="btn-add-payment-methods">
        </div>
        <div class="col-md-2">
            <input type="button" id="addMiMaxCap" value="N° Agendamientos Diarios" class="btn btn-info">
        </div>



    </div>

    <div class="form_dialog_cap">
        @if(Auth::user()->perfil==1)
            {!! Form::open(['url'=>['admin/addMinMaxCap'],'method'=>'post','id'=>'form_max_cap']) !!}
        @elseif(Auth::user()->perfil==4)
            {!! Form::open(['url'=>['ope/addMinMaxCap'],'method'=>'post','id'=>'form_max_cap']) !!}
        @endif

            <label for="maxDayCap" class="control-label">Agendamientos diarios</label>
            <input type="text" class="form-control" name="maxDayCap" id="day">

            <label for="maxAmCap" class="control-label">Agendamientos AM</label>
            <input type="text" class="form-control" name="maxAmCap" id="am">

            <label for="maxPmCap" class="control-label">Agendamientos PM</label>
            <input type="text" class="form-control" name="maxPmCap" id="pm">

        {!! Form::close() !!}
    </div>

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

    <div class="coniatner" id="comuna">
        {!! Form::open(['url'=>['admin/comuna'],'method'=>'post']) !!}

        {!! Form::close() !!}
    </div>

    <!-[ falta crear las funciones necesarias en los controladores para los fomularios de  add-status-retiro
    y add-payment-methods.
    adicionalmente falta crear las migraciones y en las vistas cargar la informacion desde la migracion]->


@endsection    

