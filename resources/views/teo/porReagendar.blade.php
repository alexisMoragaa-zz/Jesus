@extends('app')
@section('content')
   <div class="container">
       <div class="row">
           <div class="col-md-10 col-md-offset-1">
               <div class="table table-responsive">
                   <table class="table table-hover">
                       <thead>
                           <th>Nombre</th>
                           <th>Telefono</th>
                           <th>Rut</th>
                           <th>Correo</th>
                           <th>Direccion</th>
                           <th>Rutero</th>
                           <th>Fecha Agendamiento</th>
                           <th>Detalle</th>
                       </thead>
                       <tbody>
                            @foreach($reage as $r)
                                <tr>
                                    <td>{{$r->nombre}} {{$r->apellido}}</td>
                                    <td>{{$r->fono_1}}</td>
                                    <td>{{$r->rut}}</td>
                                    <td>{{$r->correo_1}}</td>
                                    <td>{{$r->direccion}}</td>
                                    <td>{{$r->rutero}}</td>
                                    <td>{{$r->fecha_agendamiento}}</td>
                                    <td>
                                        @if(Auth::user()->perfil==1)
                                            <a href="{{url('admin/detalleReagendamientoTeo')}}/{{$r->id}}">Detalle</a>
                                        @elseif(Auth::user()->perfil==2)
                                            <a href="{{url('teo/detalleReagendamientoTeo')}}/{{$r->id}}">Detalle</a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                       </tbody>
                   </table>
               </div>
           </div>
       </div>
   </div>

@endsection