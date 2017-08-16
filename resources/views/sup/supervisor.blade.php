
@extends('app')

@section('content')

    <script src="{{asset('plugins/jquery/jquery-3.2.1.js')}}"></script>
    <script src="{{asset('plugins/tablesorter/jquery.tablesorter.min.js')}}"></script>

    <script type="text/javascript">
        $(document).ready(function()
        {
            $("#table_campana").tablesorter();
            /**para establecer un orden inicial usamos sortlist, y le pasamos como parametro 2 arrays con dos campos cada uno, el primero
             * corresponde a la fila que deseamos ordenar partiendo desde el 0 y el segundo al order, siendo 0 acendente. y 1 decendente*/
        });

    </script>

<link href="{{ asset('/css/style.css') }}" rel="stylesheet">
<div class="col-md-1">
 <img class="logosu" src="/imagenes/supervisor.png"  >
</div>

 <div class="container ">

  <div class="table-responsive">
       <table id="table_campana" class="table table-bordered">
          <thead>
              <tr>
                 <th>Nombre</th>
                 <th>Apellido</th>
                 <th>Correo</th>
                 <th>Campaña actual</th>
                 <th>Turno</th>
                 <th>Accion</th>
              </tr>
          </thead>
         <tbody>
             @foreach($User_Campana as $user_campana)

                  <tr data-id="{{$user_campana->id}}">

                     <td>{{ $user_campana->name }}</td>
                     <td>{{$user_campana->last_name}}</td>
                     <td>{{$user_campana->email}}</td>
                     <td>{{ $user_campana->nombre_campana }}</td>
                     <td>{{ $user_campana->turno }}</td>
                     <td>
                         @if(Auth::User()->perfil==1)
                            <a href="{{url('admin/detalle')}}{{$user_campana->id}}">Detalle</a>
                        @elseif(Auth::User()->perfil==3)
                             <a href="{{url('sup/detalle')}}{{$user_campana->id}}">Detalle</a>
                        @endif
                      </td>
                  </tr>
             @endforeach
       </tbody>
   </table>
    </div>
</div>
@endsection