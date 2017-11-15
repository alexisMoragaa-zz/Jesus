@extends('app')
@section('content')
<style>
.bordes{
  border:5px double #ECECEC;
  padding: 10px;
}
.titulo{
  text-align: center;


}
.link{
  margin-left: 75%;
}
.resaltar{
  color: gray;
  font-size: 1.1em;
  font-family: monospace;
}
</style>
<script>
  $(document).ready(function(){
    if($("#sab").text() =="" ){
      $("#sabado").hide();
    }
    if($("#dom").text() ==""){
      $("#domingo").hide();
    }


  });
</script>
<div class="container">
  <h3 class="titulo">Rutas Para <span class="resaltar">{{$rutero}}</span>  la Semana del
    <span class="resaltar">{{$diaLunes}}</span>  - Al -  <span class="resaltar">{{$diaDomingo}}</span> </h3>
  <div class="col-md-12">
    <div class="row">
      <div class="col-md-4">
        <div class="bordes">
          <h4 class="titulo">Lunes <br>{{$diaLunes}}</h4>
            <table class=" table table-hover">
              <thead>
                <th>Nombre</th>
                <th>Comuna</th>
                <th>Horario</th>
              </thead>
              <tbody>
                @foreach ($lunes as $lun)
                  <tr>
                    <td>{{$lun->cap->nombre}}</td>
                    <td>{{$lun->cap->comuna}}</td>
                    <td>{{$lun->cap->horario}}</td>
                  </tr>
                @endforeach
              </tbody>
            </table>
            @if(Auth::User()->perfil==4)
              <a href="{{url('/ope/rutas/dia',$rutero)}}/{{$diaLunes}}" class="link">Detalles</a>
            @elseif(Auth::User()->perfil==5)
                <a href="{{url('/rutas/dia',$rutero)}}/{{$diaLunes}}" class="link">Detalles</a>
            @endif
        </div>
      </div>

  <div class="col-md-4">
      <div class="bordes">
        <h4 class="titulo">Martes <br>{{$diaMartes}}</h4>
        <table class=" table table-hover">
          <thead>
            <th>Nombre</th>
            <th>Comuna</th>
            <th>Horario</th>
          </thead>
          <tbody>
            @foreach ($martes as $mar)
              <tr>
                <td>{{$mar->cap->nombre}}</td>
                <td>{{$mar->cap->comuna}}</td>
                <td>{{$mar->cap->horario}}</td>
              </tr>
            @endforeach
          </tbody>
        </table>
        @if(Auth::User()->perfil==4)
          <a href="{{url('/ope/rutas/dia',$rutero)}}/{{$diaMartes}}" class="link">Detalles</a>
        @elseif(Auth::User()->perfil==5)
            <a href="{{url('/rutas/dia',$rutero)}}/{{$diaMartes}}" class="link">Detalles</a>
        @endif
      </div>
    </div>
    <div class="col-md-4">
        <div class="bordes">
          <h4 class="titulo">Miercoles <br>{{$diaMiercoles}}</h4>
          <table class=" table table-hover">
            <thead>
              <th>Nombre</th>
              <th>Comuna</th>
              <th>Horario</th>
            </thead>
            <tbody>
              @foreach ($miercoles as $mier)
                <tr>
                  <td>{{$mier->cap->nombre}}</td>
                  <td>{{$mier->cap->comuna}}</td>
                  <td>{{$mier->cap->horario}}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
          @if(Auth::User()->perfil==4)
            <a href="{{url('/ope/rutas/dia',$rutero)}}/{{$diaMiercoles}}" class="link">Detalles</a>
          @elseif(Auth::User()->perfil==5)
              <a href="{{url('/rutas/dia',$rutero)}}/{{$diaMiercoles}}" class="link">Detalles</a>
          @endif
        </div>
      </div>

    </div>
<div class="row">

      <div class="col-md-4">
          <div class="bordes">
            <h4 class="titulo">Jueves <br>{{$diaJueves}}</h4>
            <table class=" table table-hover">
              <thead>
                <th>Nombre</th>
                <th>Comuna</th>
                <th>Horario</th>
              </thead>
              <tbody>
                @foreach ($jueves as $jue)
                  <tr>
                    <td>{{$jue->nombre}}</td>
                    <td>{{$jue->comuna}}</td>
                    <td>{{$jue->horario}}</td>
                  </tr>
                @endforeach
              </tbody>
            </table>
            @if(Auth::User()->perfil==4)
              <a href="{{url('/ope/rutas/dia',$rutero)}}/{{$diaJueves}}" class="link">Detalles</a>
            @elseif(Auth::User()->perfil==5)
                <a href="{{url('/rutas/dia',$rutero)}}/{{$diaJueves}}" class="link">Detalles</a>
            @endif
          </div>
        </div>

        <div class="col-md-4">
            <div class="bordes">
              <h4 class="titulo">Viernes <br>{{$diaViernes}}</h4>
              <table class=" table table-hover">
                <thead>
                  <th>Nombre</th>
                  <th>Comuna</th>
                  <th>Horario</th>
                </thead>
                <tbody>
                  @foreach ($viernes as $vier)
                    <tr>
                      <td>{{$vier->cap->nombre}}</td>
                      <td>{{$vier->cap->comuna}}</td>
                      <td>{{$vier->cap->horario}}</td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
              @if(Auth::User()->perfil==4)
                <a href="{{url('/ope/rutas/dia',$rutero)}}/{{$diaViernes}}" class="link">Detalles</a>
              @elseif(Auth::User()->perfil==5)
                  <a href="{{url('/rutas/dia',$rutero)}}/{{$diaViernes}}" class="link">Detalles</a>
              @endif
            </div>
          </div>

          <div class="col-md-4" id="sabado">
              <div class="bordes">
                <h4 class="titulo">sabado <br>{{$diaSabado}}</h4>
                <table class=" table table-hover">
                  <thead>
                    <th>Nombre</th>
                    <th>Comuna</th>
                    <th>Horario</th>
                  </thead>
                  <tbody>
                    @foreach ($sabado as $sab)
                      <tr>
                        <td id="sab">{{$sab->cap->nombre}}</td>
                        <td>{{$sab->cap->comuna}}</td>
                        <td>{{$sab->cap->horario}}</td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
                @if(Auth::User()->perfil==4)
                  <a href="{{url('/ope/rutas/dia',$rutero)}}/{{$diaSabado}}" class="link">Detalles</a>
                @elseif(Auth::User()->perfil==5)
                    <a href="{{url('/rutas/dia',$rutero)}}/{{$diaSabado}}" class="link">Detalles</a>
                @endif
              </div>
            </div>

          </div>
          <div class="row">

            <div class="col-md-4" id="domingo">
                <div class="bordes">
                  <h4 class="titulo">Domingo <br>{{$diaDomingo}}</h4>
                  <table class=" table table-hover">
                    <thead>
                      <th>Nombre</th>
                      <th>Comuna</th>
                      <th>Horario</th>
                    </thead>
                    <tbody>
                      @foreach ($domingo as $dom)
                        <tr>
                          <td id="dom">{{$dom->cap->nombre}}</td>
                          <td>{{$dom->cap->comuna}}</td>
                          <td>{{$dom->cap->horario}}</td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                  @if(Auth::User()->perfil==4)
                    <a href="{{url('/ope/rutas/dia',$rutero)}}/{{$diaDomingo}}" class="link">Detalles</a>
                  @elseif(Auth::User()->perfil==5)
                      <a href="{{url('/rutas/dia',$rutero)}}/{{$diaDomingo}}" class="link">Detalles</a>
                  @endif
                </div>
            </div>
          </div>

</div>
</div>

@endsection()
