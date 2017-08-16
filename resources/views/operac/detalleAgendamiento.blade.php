@extends('app')
@section('content')

    <style>
        .contenedor{
            margin: auto;
            margin-top: 40px;
            max-width: 1350px;

        }
    </style>

    <script>
        $(document).ready(function(){

            $(".detalle").hide();
             $(".ocultar").css('color','white');

            $("#vista").change(function(){

                if($("#vista").val()==2){

                    $(".detalle").fadeIn(1200);
                }else{
                    $(".detalle").fadeOut(800);
                }
            });
        });
    </script>

    <div class="contenedor">

        <div class="col-md-3">
            <label for="" class="control-label">Tipo de Vista</label>
            <select name="tipo_vista" id="vista" class="form-control">
                <option value="1">Simple</option>
                <option value="2">Detallada</option>
            </select>
        </div>

        <table class="table table-responsive">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Fono</th>
                    <th>Rut</th>
                    <th class="detalle">Correo</th>
                    <th>Direccion</th>
                    <th class="detalle">Comuna</th>
                    <th>Observaciones</th>
                    <th class="detalle" >Rutero</th>
                    <th class="detalle">TeleOperador</th>
                    <th class="detalle">Fundacion</th>
                    <th class="detalle">Forma De Pago</th>
                    <th>Monto</th>
                </tr>
            </thead>
            <tbody>
                @foreach($datos as $dato)
                    <tr>
                        <td>{{$dato->nombre}}<span class="ocultar">----</span>{{$dato->apellido}}</td>

                        <td>{{$dato->fono_1}}</td>
                        <td>{{$dato->rut}} - {{$dato->dv}}</td>
                        <td class="detalle">{{$dato->correo_1}}</td>
                        <td>{{$dato->direccion}}</td>
                        <td class="detalle">{{$dato->comuna}}</td>
                        <td>{{$dato->observaciones}}</td>
                        <td class="detalle">{{$dato->rutero}}</td>
                        <td class="detalle">{{$dato->teleoperador}}</td>
                        <td class="detalle">{{$dato->fundacion}}</td>
                        <td class="detalle">{{$dato->forma_pago}}</td>
                        <td>{{$dato->monto}}</td>

                    </tr>
                @endforeach
            </tbody>

        </table>





    </div>




@endsection