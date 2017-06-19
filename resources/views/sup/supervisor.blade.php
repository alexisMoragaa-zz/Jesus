
@extends('app')

@section('content')




<link href="{{ asset('/css/style.css') }}" rel="stylesheet">
<div>
 <img class="logosu" src="/imagenes/supervisor.png"  >
</div>



 <div class="container">

  <div class="table-responsive">
   <table class="table table-bordered">
    <tr>
     <th>Nombres</th>
     <th>Campaña actual</th>

     <th>Turno</th>
     <th>Accion</th>
     <th>Ver Usuario</th>

    </tr>

    @foreach($User_Campana as $user_campana)

      <tr data-id="{{$user_campana->id}}">

          <td>{{ $user_campana->name }}</td>
          <td>{{ $user_campana->nombre_campana }}</td>
          <td>{{ $user_campana->turno }}</td>
          <td>
              @if(Auth::User()->perfil==1)
                  <a href="{{url('admin/detalle')}}{{$user_campana->id}}">Detalle</a>
              @elseif(Auth::User()->perfil==3)
                  <a href="{{url('sup/detalle')}}{{$user_campana->id}}">Detalle</a>
              @endif
          </td>
          <td style="text-align: center">
              @if(Auth::User()->perfil==1)
                  <a href="{{ route('admin.sup.edit',$user_campana->id)}}">Asignar Campaña</a>
              @elseif(Auth::User()->perfil==3)
                  <a href="{{ route('sup.sup.edit',$user_campana->id)}}">Asignar Campaña</a>
              @endif
          </td>

     </tr>

    @endforeach
   </table>
      </div>

 </div>

@endsection