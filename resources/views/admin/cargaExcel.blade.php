@extends('app')

@section('content')
<script>
  $(document).ready(function(){
    $("#foundation").change(function(){
      var foundation = $(this).val();
      $.get('/admin/byfoundation/'+foundation, function(data){
        console.log(data);
          var foundation_select = '<option value="">Seleccione Campaña</option>'
            for (var i=0; i<data.length;i++)
              foundation_select+='<option value="'+data[i].id+'">'+data[i].nombre_campana+'</option>';

            $("#campanas").html(foundation_select);

      });
    });
  });
</script>
<link href="{{ asset('/css/style.css') }}" rel="stylesheet">
<div class="container">
  <div class="col-md-12">

    <div class="col-md-2">
      <h3 class="box-title text-muted">Cargar Campaña</h3>
    </div>

      @if(Session::has('message'))
        <div class="col-md-9 alert alert-danger btn1">
          {{Session::get('message')}}
        </div>
      @endif

      @if(Session::has('success'))
        <div class="col-md-9 alert alert-success btn1">
        {{Session::get('success')}}
      </div>
      @endif

      <form id="form_cargar_datos" name="form_cargar_datos" method="post" action="cargar_datos" class="formarchivo" enctype="multipart/form-data">
      {{-- <form action="/admin/loadCampaing" method="Post" enctype="multipart/form-data"> --}}
        <input type="hidden" name="_token" id="_token" value="{{csrf_token()}}">

            <div class="row">
              <div class="col-md-3">
                <img class="iconoEx" src="/imagenes/excelIcono.png"> </img>
              </div>
            </div>

            <div class="col-md-4">
              <label for="" class="control-label">Seleccione Archivo Excel</label>
              <input name="archivo" id="archivo" type="file" class="archivo form-control"  required/>
  {{-- <input type="file" name="file"> --}}
            </div>
            <div class="col-md-3">
              <label for="" class="control-label">Seleccione Fundacion</label>
              <select name="foundation" id="foundation" class="form-control">
                <option value="">Seleccione</option>
                @foreach ($fundaciones as $fundacion)
                  <option value="{{$fundacion->id}}">{{$fundacion->nombre}}</option>
                @endforeach
              </select>
            </div>

            <div class="col-md-3">
              <label for="" class="control-label">Seleccione Campaña</label>
              <select name="campanas" id="campanas" class="form-control">
                  <option value="">Seleccione Campaña</option>
              </select>
            </div>

            <div class="col-md-2">
              <button type="submit" class="btn btn-primary btn1">Cargar Datos</button>
            </div>
        </form>




  </div>{{--fin col-md-12--}}
</div>{{--fin Container--}}

@endsection
