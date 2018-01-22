@extends('app')
@section('content')
  <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <style>
  #titulo {
    text-align: center;
    color: gray;
  }
  #ocultar{
    color: white;
  }
  #enviar{

    margin-top: 23px;
  }
  .formulario .checkbox label {
    display: inline-block;
    cursor: pointer;
    color: #111111;
    position: relative;
    padding: 5px 15px 5px 37px;
    font-size: 1em;
    border-radius: 5px;
    -webkit-transition: all 0.3s ease;
    -o-transition: all 0.3s ease;
    transition: all 0.3s ease;
  }

  .formulario .checkbox label:before {
    content: "";
    display: inline-block;
    width: 17px;
    height: 17px;
    position: absolute;
    left: 10px;
    border-radius: 40%;
    background: none;
    border: 3px solid #AAAAAA;
  }


  .formulario .checkbox label:before {
    border-radius: 3px; }
    .formulario .checkbox input[type="checkbox"] {
      display: none; }
      .formulario .checkbox input[type="checkbox"]:checked + label:before {
        display: none; }
        .formulario .checkbox input[type="checkbox"]:checked + label {
          background:gray;
          color: #fff;
          padding: 5px 15px; }

          .table-hover tbody tr:hover td, .table-hover tbody tr:hover th {
            background-color: #caecff;
          }

        </style>

        <script>
          $(document).ready(function(){

            // $("#enviar").click(function(){
            //
            //     if($("#comunas").val()!=""){
            //
            //         $("#comerror").css('color','black');
            //
            //         if($("#rutero").val()!=""){
            //
            //             $("#ruterror").css('color','black');
            //
            //             $('form').submit(function(e){
            //
            //                 if ($('input[type=checkbox]:checked').length === 0) {
            //                     e.preventDefault();
            //                     $("#checkerror").css('color','red');
            //
            //                 }else{
            //                     $("#checkerror").css('color','black');
            //                 }
            //             });
            //
            //         }else{
            //             $("#ruterror").css('color','red');
            //             return false;
            //         }
            //     }else{
            //         $("#comerror").css('color','red');
            //         return false;
            //     }
            //
            // });

          });
        </script>

<div class="container">
<h1 class="center text-muted">Cobertura Recsa</h1>
@if(Auth::user()->perfil==1)
  {!! Form::open(['url'=>['admin/edit/cobertura'],'method'=>'post','class'=>'formulario']) !!}
@elseif(auth::user()->perfil==4)
  {!! Form::open(['url'=>['ope/edit/cobertura'],'method'=>'post','class'=>'formulario']) !!}
@endif
<div class="row">
  <div class="col-md-12"></div>
  <div class="col-md-4">
    <label for="" class="control-label" id="comerror">Seleccione Comuna</label>
    <select name="comunas" id="comunas" class="form-control" required>
      <option value="">-- seleccione --</option>
      @foreach($comunas as $com)
        <option value="{{$com->id}}">{{$com->comuna}}</option>
      @endforeach
    </select>
  </div>

  <div class="col-md-2">
    <input type="submit" class="btn btn-success" id="enviar">
  </div>

</div>

<div class="col-xs-12 col-md-3">
  <div class="list-group">
    <a href="#" class="list-group-item active" data-toggle="collapse" data-target="#firstWeek">
      Primera Semana
    </a>
    <div class="collapse" id="firstWeek">
      <div class="checkbox">
        <p id="checkerror"></p>
        <fieldset class="">
          <input type="checkbox" name="checkbox1" id="checkbox1">
          <label for="checkbox1">Lunes</label>
          <input type="checkbox" name="checkbox2" id="checkbox2">
          <label for="checkbox2">Martes</label>
          <input type="checkbox" name="checkbox3" id="checkbox3">
          <label for="checkbox3">Miercoles</label>
          <input type="checkbox" name="checkbox4" id="checkbox4">
          <label for="checkbox4">Jueves</label>
          <input type="checkbox" name="checkbox5" id="checkbox5">
          <label for="checkbox5">Viernes</label>
        </fieldset>
      </div>
    </div>
  </div>
</div>

<div class="col-xs-12 col-md-3">
  <div class="list-group">
    <a href="#" class="list-group-item active" data-toggle="collapse" data-target="#secondWeek">
      Primera Semana
    </a>
    <div class="collapse" id="secondWeek">
      <div class="checkbox">
        <p id="checkerror"></p>
        <fieldset class="">
          <input type="checkbox" name="checkbox6" id="checkbox6">
          <label for="checkbox6">Lunes</label>
          <input type="checkbox" name="checkbox7" id="checkbox7">
          <label for="checkbox7">Martes</label>
          <input type="checkbox" name="checkbox8" id="checkbox8">
          <label for="checkbox8">Miercoles</label>
          <input type="checkbox" name="checkbox9" id="checkbox9">
          <label for="checkbox9">Jueves</label>
          <input type="checkbox" name="checkbox10" id="checkbox10">
          <label for="checkbox10">Viernes</label>
        </div>
      </div>
    </div>
  </div>

  <div class="col-xs-12 col-md-3">
    <div class="list-group">
      <a href="#" class="list-group-item active" data-toggle="collapse" data-target="#thirdWeek">
        Primera Semana
      </a>
      <div class="collapse" id="thirdWeek">
        <div class="checkbox">
          <p id="checkerror"></p>
          <fieldset class="">
            <input type="checkbox" name="checkbox11" id="checkbox11">
            <label for="checkbox11">Lunes</label>
            <input type="checkbox" name="checkbox12" id="checkbox12">
            <label for="checkbox12">Martes</label>
            <input type="checkbox" name="checkbox13" id="checkbox13">
            <label for="checkbox13">Miercoles</label>
            <input type="checkbox" name="checkbox4" id="checkbox14">
            <label for="checkbox14">Jueves</label>
            <input type="checkbox" name="checkbox15" id="checkbox15">
            <label for="checkbox15">Viernes</label>
          </fieldset>
        </div>
      </div>
    </div>
  </div>

  <div class="col-xs-12 col-md-3">
    <div class="list-group">
      <a href="#" class="list-group-item active" data-toggle="collapse" data-target="#forWeek">
        Primera Semana
      </a>
      <div class="collapse" id="forWeek">
        <div class="checkbox">
          <p id="checkerror"></p>
          <fieldset class="">
            <input type="checkbox" name="checkbox16" id="checkbox16">
            <label for="checkbox16">Lunes</label>
            <input type="checkbox" name="checkbox17" id="checkbox17">
            <label for="checkbox17">Martes</label>
            <input type="checkbox" name="checkbox18" id="checkbox18">
            <label for="checkbox18">Miercoles</label>
            <input type="checkbox" name="checkbox19" id="checkbox19">
            <label for="checkbox19">Jueves</label>
            <input type="checkbox" name="checkbox20" id="checkbox20">
            <label for="checkbox20">Viernes</label>
          </fieldset>
        </div>
      </div>
    </div>
  </div>

  {!! Form::close() !!}
</div> {{-- fin container--}}

<div class="container">
  <div class="col-md-12 table-responsive">
    <table class="table  table-hover">
      <thead>
        <th>Comuna</th>
        <th>x</th>
        <th>S1 Lunes</th>
        <th>S1 Martes</th>
        <th>S1 Miercoles</th>
        <th>S1 Jueves</th>
        <th>S1 Viernes</th>

        <th>S2 Lunes</th>
        <th>S2 Martes</th>
        <th>S2 Miercoles</th>
        <th>S2 Jueves</th>
        <th>S2 Viernes</th>

        <th>S3 Lunes</th>
        <th>S3 Martes</th>
        <th>S3 Miercoles</th>
        <th>S3 Jueves</th>
        <th>S3 Viernes</th>

        <th>S4 Lunes</th>
        <th>S4 Martes</th>
        <th>S4 Miercoles</th>
        <th>S4 Jueves</th>
        <th>S4 Viernes</th>
      </thead>
      <tbody>
        @foreach($comunas as $comuna )
          <tr>
            <td>{{$comuna->comuna}}</td>
            <td>{{$comuna->cobertura}}</td>
            @if($comuna->semana_1_lunes != null) <td>X</td>@else <td><span>-</span></td>@endif
            @if($comuna->semana_1_martes != null) <td>X</td>@else <td><span>-</span></td>@endif
            @if($comuna->semana_1_miercoles != null) <td>X</td>@else <td><span>-</span></td>@endif
            @if($comuna->semana_1_jueves != null) <td>X</td>@else <td><span>-</span></td>@endif
            @if($comuna->semana_1_viernes != null) <td>X</td>@else <td><span>-</span></td>@endif

            @if($comuna->semana_2_lunes != null) <td>X</td>@else <td><span>-</span></td>@endif
            @if($comuna->semana_2_martes != null) <td>X</td>@else <td><span>-</span></td>@endif
            @if($comuna->semana_2_miercoles != null) <td>X</td>@else <td><span>-</span></td>@endif
            @if($comuna->semana_2_jueves != null) <td>X</td>@else <td><span>-</span></td>@endif
            @if($comuna->semana_2_viernes != null) <td>X</td>@else <td><span>-</span></td>@endif

            @if($comuna->semana_3_lunes != null) <td>X</td>@else <td><span>-</span></td>@endif
            @if($comuna->semana_3_martes != null) <td>X</td>@else <td><span>-</span></td>@endif
            @if($comuna->semana_3_miercoles != null) <td>X</td>@else <td><span>-</span></td>@endif
            @if($comuna->semana_3_jueves != null) <td>X</td>@else <td><span>-</span></td>@endif
            @if($comuna->semana_3_viernes != null) <td>X</td>@else <td><span>-</span></td>@endif

            @if($comuna->semana_4_lunes != null) <td>X</td>@else <td><span>-</span></td>@endif
            @if($comuna->semana_4_martes != null) <td>X</td>@else <td><span>-</span></td>@endif
            @if($comuna->semana_4_miercoles != null) <td>X</td>@else <td><span>-</span></td>@endif
            @if($comuna->semana_4_jueves != null) <td>X</td>@else <td><span>-</span></td>@endif
            @if($comuna->semana_4_viernes != null) <td>X</td>@else <td><span>-</span></td>@endif
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>{{--fin container table --}}
@endsection
