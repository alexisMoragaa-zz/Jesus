@extends('app')
@section('content')
<style>
.center{
  text-align: center;
}
.t td{
  font-size: 1em;
  padding: 0.5em;
}
#second-container{
  margin-top: 1.5em;
}
.btn-success{
  margin-bottom: 2em;
}
</style>


  <div class="container">
    <h2 class="text-muted center">Fundacion {{$letter->letterByFoundation->nombre}}</h2>
    <h4 class="text-muted center ">Carta Numero 0{{$letter->number}} / {{$letter->estado}}</h4>
    <div class="table table-responsive">
      <table class="table table-hover">
        <thead>
          <th>Rut</th>
          <th>Nombre</th>
          <th>Apellidos</th>
          <th>Campaña</th>
          <th>Medio Aporte</th>
          <th>Monto</th>
        </thead>
        <tbody>
          @foreach ($registros as $registro)
            <tr>
              <td>{{$registro->rut}}</td>
              <td>{{$registro->nombre}}</td>
              <td>{{$registro->apellido}}</td>
              <td>{{$registro->nom_campana}}</td>
              <td>{{$registro->forma_pago}}</td>
              <td>{{$registro->monto}}</td>
            </tr>
          @endforeach
        </tbody>
      </table>
      <h4 class="text-muted center">Total Mandatos <span> - {{$registros->count()}} -</span></h4>
    </div>
  </div>{{--fin Container--}}
  <div class="container" id="second-container">
    @if($letter->estado == "En Dues")
      <div class="col-md-12">
        <form action="/ope/add/PostMan" method="Post">
          <input type="hidden" name="_token" value="{{csrf_token()}}">
          <div class="col-md-3">
            <h4 class="center">Carta Preparada Por </h4>
            <h4 class="center">{{Auth::user()->name}} {{Auth::user()->last_name}}</h4>
          </div>

          <div class="col-md-3">
            <h4 class="center">Fecha Envio</h4>
            <h4 class="center">{{$hoy}}</h4>
          </div>

          <div class="col-md-3">
            <labe class="control-label">Entrega Carta</labe>
            <select name="postMan" id="" class="form-control" required>
              <option value="">Seleccione</option>
              @foreach ($users as $user)
                <option value="{{$user->id}}">{{$user->name}} {{$user->last_name}}</option>
              @endforeach
            </select>
          </div>
          <div class="col-md-3">
            <input type="submit" name="" value="Guardar Y enviar Carta" class="btn btn-primary btn1" >
          </div>
          <input type="hidden" name="id" value="{{$letter->id}}">
        </form>
      </div>
    @else
      <a href="{{url('/ope/export/letter/'.$letter->id.'/excel')}}" class="btn btn-success right">Exportar a Excel</a>
    @endif
  </div>{{--fin Container2--}}

@endsection
