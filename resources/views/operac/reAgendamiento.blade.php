@extends('app')
@section('content')
    <style>

        .m1{
            margin:1px;

        }
        .center{
            text-align: center;
        }
        #margin_right{
            border-right:1px solid gray;
            min-height: 200px;

        }
        #margin_left{
            border-left:1px solid gray;
            min-height: 200px;
        }
        #reagendado{
            min-height: 300px;
         }
    </style>
    <script>
        $(document).ready(function(){


        });
    </script>

    <div class="row m1">
        <div class="col-md-6">
            <h1 class="center"><small>Por Reagendar</small></h1>
            <div class="col-md-12" id="margin_right">
                <table class="table table-hover">
                    <thead>
                        <th>Nombre</th>
                        <th>Fono</th>
                        <th>Comuna</th>
                        <th>Campaña</th>
                         <th>Monto</th>
                        <th>Teleoperador</th>
                        <th>Detalle</th>
                     </thead>
                    <tbody>
                        @forelse($reagendar as $re)
                        <tr>
                           <td>{{$re->nombre}} {{$re->apellido}}</td>
                           <td>{{$re->fono_1}}</td>
                           <td>{{$re->comuna}}</td>
                           <td>{{$re->nom_campana}}</td>
                           <td>{{$re->monto}}</td>
                           <td>{{$re->user->name}} {{$re->user->last_name}}</td>
                           <td>
                               @if(Auth::user()->perfil==1)
                                   <a href="{{url('admin/detalleReAgendamiento')}}/{{$re->id}}">Cambiar Teo<span class=""></span></a>
                               @elseif(Auth::user()->perfil==4)
                                   <a href="{{url('/ope/detalleReAgendamiernto')}}/{{$re->id}}">Cambiar Teo<span class=""></span></a>
                               @endif
                             </td>
                        </tr>
                        @empty
                        @endforelse
                    </tbody>
                </table>
            </div>
    </div>
    <div class="col-md-6" id="reagendado">
        <h1 class="center"><small>Reagendado</small></h1>
        <div class="col-md-12" id="margin_left">
           <table class="table table-hover" >
                <thead>
                    <th>Nombre</th>
                    <th>Fono</th>
                    <th>Comuna</th>
                    <th>Campaña</th>
                    <th>Monto</th>
                    <th>Teleoperador</th>
                    <th>Detalle</th>
               </thead>
                <tbody>
                    @forelse($reagendado as $rea)
                        <tr>
                            <td>{{$rea->nombre}} {{$rea->apellido}}</td>
                            <td>{{$rea->fono_1}}</td>
                            <td>{{$rea->comuna}}</td>
                            <td>{{$rea->nom_campana}}</td>
                            <td>{{$rea->monto}}</td>
                            <td>{{$rea->user->name}} {{$rea->user->last_name}}</td>
                            <td>
                                @if(Auth::user()->perfil==1)
                                    <a href="{{route('admin.call.show',$rea->id)}}">Validar Ruta<span class=""></span></a>
                               @elseif(Auth::user()->perfil==4)
                                    <a href="{{route('/ope.call.show',$rea->id)}}">Validar Ruta<span class=""></span></a>
                                @endif
                            </td>
                        </tr>
                    @empty
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div><!--[fin row]-->

@endsection