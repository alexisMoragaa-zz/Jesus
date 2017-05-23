
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
     <th>Correo</th>
     <th>Perfil</th>
     <th>Accion</th>
    </tr>
    @foreach($usuarios as $User)
     <tr data-id="{{$User->id}}">
      <td>{{  $User->name }}</td>
      <td>{{ $User->campana }}</td>
      <td>{{ $User->perfil }}</td>
      <td style="text-align: center">

       <a href="{{ route('admin.user.edit',$User->id)}}">Editar/Eliminar</a>


      </td>
     </tr>

    @endforeach
   </table>
      </div>

 </div>

@endsection