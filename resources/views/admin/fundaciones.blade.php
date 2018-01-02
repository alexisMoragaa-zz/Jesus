@extends('app')
@section('content')
  <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">

  <style>
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
    .row{
      margin-top: 5px;
    }
  </style>
  <script src="{{asset('plugins/jquery-validator/jquery.validate.js')}}"></script>
  <script src="{{asset('js/validarAgendamiento.js')}}"></script>
  <div class="row">
    <div class="container">

      <div class="col-md-8" id="registrar-fundacion">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h4 class="text-muted">Agregar Nueva fundacion</h4>
          </div>
          <div class="panel-body">
            <form action="/admin/create/foundation" method="Post" class="formulario" id="fundacion">
                <input type="hidden" name="_token" value="{{csrf_token()}}">
              <div class="row">
                <div class="col-md-6">
                  <label for="" class="control-label">Nombre Fundacion</label>
                  <input type="text" name="name_foundation" value="" class="form-control">
                </div>

                <div class="col-md-6">
                  <label for="" class="control-label">Fono</label>
                  <input type="text" name="fono" value="" class="form-control">
                </div>
              </div>{{--fin primera row--}}

              <div class="row">
                <div class="col-md-10">
                  <label for="" class="control-label">direccion</label>
                  <input type="text" name="adress" value="" class="form-control">
                </div>

                <div class="col-md-2">
                  <label for="" class="control-label">Numeracion</label>
                  <input type="text" name="number" class="form-control">
                </div>


              </div>{{--fin segunda row--}}

            <div class="row">
              <div class="col-md-6">
                <label for="" class="control-label">Rut</label>
                <input type="text" name="dni" value="" class="form-control">
              </div>

              <div class="col-md-6">
                <label for="" class="control-label">email</label>
                <input type="text" name="email" value="" class="form-control">
              </div>
            </div>{{--fin tercera row--}}

            <div class="row">
              <div class="col-md-5">
                <label for="" class="control-label">Razon Social</label>
                <input type="text" name="socialReason" value="" class="form-control">
              </div>

              <div class="checkbox col-md-7">
                    <p id="checkerror">Acciones de fundacion</p>
                    <fieldset>
                      <input type="checkbox" name="agendamiento" id="agendamiento">
                      <label for="agendamiento">Agendamientos</label>
                      <input type="checkbox" name="upgrade" id="upgrade">
                      <label for="upgrade">Upgrade</label>
                      <input type="checkbox" name="regiones" id="regiones">
                      <label for="regiones">Regiones</label>
                    </fieldset>
              </div>
            </div>{{--fin cuarta row--}}
            <div class="row">
              <div class="col-md-4 right">
                <input type="submit" value="Agregar Nueva fundacion" class="btn btn-success btn1 right">
              </div>
            </div>
          </form>


          </div>
        </div>
      </div>{{--fin registrar-fundacion--}}

      <div class="col-md-4" id="fundaciones">
        @foreach ($fundaciones as $fundacion)
          <div class="list-group ">
            <a href="#" class="list-group-item active">
              Fundacion {{$fundacion->nombre}}
              <span class="badge">{{$fundacion->misCampanas->count()}}</span>
            </a>
            <a href="{{url('/admin/foundation/show',$fundacion->id)}}" class="list-group-item"><span class="btn btn-primary">Ver mas</span></a>
          </div>

        @endforeach
      </div>{{--fin fundacines--}}

    </div>{{--fin container--}}
  </div>{{--fin row--}}
@endsection
