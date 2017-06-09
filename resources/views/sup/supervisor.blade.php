
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
              <a href="{{url('admin/detalle')}}{{$user_campana->id}}">Detalle</a>
          </td>

          <td style="text-align: center">

       <a href="{{ route('admin.user.edit',$user_campana->id)}}">Asignar Campaña</a>


      </td>

     </tr>

    @endforeach
   </table>
      </div>

 </div>

@endsection