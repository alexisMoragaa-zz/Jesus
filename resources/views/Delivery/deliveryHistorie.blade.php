@extends('app')
@section('content')
<script>
  $(document).ready(function(){
    $("#filtro").click(function(){
      if($("#teo").val()==""){
        alert("El campo Teleoperador es Requerido");
      }else if($("#date").val()==""){
        alert("El Campo Fecha Retiro es Requerido");
      }else{
        window.location="/ope/delivery/history/filter/"+$("#teo").val()+"/"+$("#date").val();
      }
    });
  });
</script>

<div class="container">
  <div class="row">
    <div class="col-md-10">
      <h2 class="text-center text-muted">{{$breadcrum}}</h2>
    </div>

    <div class=" col-xs-12 col-md-2">
      @if(Auth::user()->perfil==1)
        <a href="{{url('admin/export/delivery/history')}}" class="btn btn-success btn1 right col-xs-12">Exportar A excel</a>
      @elseif(Auth::user()->perfil==4)
        <a href="{{url('ope/export/delivery/history')}}" class="btn btn-success btn1 right col-xs-12">Exportar A excel</a>
      @endif
    </div>

    <div class="col-md-3">
      <label for="" class="control-label">Teleoperador</label>
      <select name="teo" id="teo" class="form-control" required>
        <option value="">--Seleccione--</option>
        @foreach ($teos as $teo)
          <option value="{{$teo->id}}">{{$teo->name}} {{$teo->last_name}}</option>
        @endforeach
      </select>
    </div>
    <div class="col-md-3">
      <label for="" class="control-label">Fecha Retiro</label>
      <input type="Date" class="form-control" name="date" id="date" required>
    </div>
    <div class="col-md-3">
      <input type="submit" class="btn btn-primary btn1" value="Filtrar" id="filtro">
    </div>

    <div class="col-md-3">
      <h5 class="right mt-2">Total Registros <span class="badge">{{$data->count()}}</span></h5>
    </div>

  </div>

    <div class="row mt-1">
    <div class="panel panel-default">
      <div class="panel-body">
        <div class="col-md-12 table-responsive">
          <table class="table table-hover">
            <thead>
              <th>id</th>
              <th>Nombre</th>
              <th>Rut</th>
              <th>Fecha Venta</th>
              <th>Fecha retiro</th>
              <th>Direccion</th>
              <th>Comuna</th>
              <th>Detalle</th>
              <th>Teo</th>
              <th id="mdt" ><span id="mdtspan" class=" glyphicon glyphicon-list-alt "></span></th>
            </thead>
            <tbody>
              @if(isset($data))

              @foreach ($data as $d)
                <tr>
                  <td>{{$d->id}}</td>
                  <td>{{$d->nombre}} {{$d->apellido}}</td>
                  <td>{{$d->rut}}</td>
                  <td>{{$d->fecha_captacion}}</td>
                  <td>{{$d->fecha_agendamiento}}</td>
                  <td>{{$d->direccion}}</td>
                  <td>{{$d->comuna}}</td>
                  <td><a href="{{url('/ope/dely/'.$d->id.'/edit')}}">Detalle</a></td>
                  <td>{{$d->user->name}}</td>
                  @if($d->estado_mandato == "OK")
                    <td class="center"><span class="glyphicon glyphicon-ok"></span></td>
                  @endif
                </tr>
              @endforeach
            @endif
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>{{--row del encabezado--}}
</div>
@endsection
