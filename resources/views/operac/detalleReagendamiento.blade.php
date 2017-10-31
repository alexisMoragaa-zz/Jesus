@extends('app')
@section('content')
    <style>
        #contenedor{
            margin-top: 30px;
        }

        #ocultar{
            margin-top: 10px;
        }
        #colum2{
            margin-top: 15px;
        }
        #border_detalle_reagendamiento{
            border: gray 1px solid;
            min-height: 120px;

        }
        .mt{
            margin-top: 20px;
        }
    </style>


    <script>
        $(document).ready(function(){


        });
    </script>
    
    <div class="container" id="contenedor">
        <div class="row">
            @include('partials.partialDetalleReagendamiento')

           <!--[Fin primera columna (la culumna esta en un partial)]-->
            @if($reage->reagendar==1)
            <div class="col-md-4"><!--[Inicio segunda columna]-->
                <div class="col-md-12" id="colum2">
                  @if(Auth::user()->perfil==1)
                    {!! Form::open(['url'=>['admin/reagendar'],'method'=>'POST','id'=>'reagendado']) !!}
                  @elseif(Auth::user()->perfil==4)
                    {!! Form::open(['url'=>['ope/reagendar'],'method'=>'POST','id'=>'reagendado']) !!}
                  @endif

                                <input type="hidden" name="originalTeo" value=" {{$reage->user->id}}"/>


                        <div id="ocultar">
                            <label for="">Seleccionar Teleoperador</label>
                            <select name="newTeo" id="newTeo" class="form-control">
                                <option value="">--Seleccione --</option>
                                @foreach($teos as $t)
                                    <option value="{{$t->id}}">{{$t->name}} {{$t->last_name}}</option>
                                @endforeach
                            </select>
                        </div>

                      <input type="hidden" name="id" value="{{$reage->id}}">
                        <input type="submit" class="btn btn-success btn1" value="Solicitar Reagendamento" id="btn_reagendar">

                    {!! Form::close() !!}
                </div>
             @endif
                @if($reage->reagendar==2)
                    <div class="col-md-4">
                        <h3>Detalles Reagendamiento</h3>
                        <div class="col-md-12">
                        <div class="row" id="border_detalle_reagendamiento">
                            <div class="col-md-6 mt">
                                <label for="date" class="control-label ">Fecha Visita</label>
                                <input type="text" class="form-control " value="{{$reage->fecha_agendamiento}}" >
                            </div>
                            <div class="col-md-6 mt">
                                <label for="teo" class="comtrol-label">
                                    Teleoperador
                                </label>
                                <input type="text" class="form-control" value="{{$reage->user->name}}">
                            </div>

                        </div>
                        </div>
                    </div>
                @endif
            </div>
        </div><!--[Fin Row]-->
    </div><!--[Fin Conteiner]-->

@endsection
    