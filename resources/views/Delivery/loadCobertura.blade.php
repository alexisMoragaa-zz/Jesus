@extends('app')

@section('content')

<link href="{{ asset('/css/style.css') }}" rel="stylesheet">
<div class="container">
  <div class="col-md-12">


      <form  method="post" action="/admin/load/cobertura" enctype="multipart/form-data">
      {{-- <form action="/admin/loadCampaing" method="Post" enctype="multipart/form-data"> --}}
        <input type="hidden" name="_token" id="_token" value="{{csrf_token()}}">


            <div class="col-md-4">
              <label for="" class="control-label">Seleccione Archivo Excel</label>
              <input name="archivo" id="archivo" type="file" class="archivo form-control"  required/>
  {{-- <input type="file" name="file"> --}}
            </div>


            <div class="col-md-2">
              <button type="submit" class="btn btn-primary btn1">Cargar Datos</button>
            </div>
        </form>




  </div>{{--fin col-md-12--}}
</div>{{--fin Container--}}

@endsection
