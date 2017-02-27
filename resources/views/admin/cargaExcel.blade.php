@extends('app')

@section('content')

 <link href="{{ asset('/css/style.css') }}" rel="stylesheet">
<div class="container">
  <div class="col-md-12">
  
      <div class="box box-primary">
                      <div class="box-header">
                        <h3 class="box-title">Cargar Datos de Captaciones</h3>
                      </div><!-- /.box-header -->

      <form  id="form_cargar_datos" name="form_cargar_datos" method="post"  action="cargar_datos" class="formarchivo" enctype="multipart/form-data" >                
      
       <input type="hidden" name="_token" id="_token"  value="<?= csrf_token(); ?>"> 

      <div class="box-body">

      <div class="form-group col-xs-12"  >
             <label>Agregar Archivo de Excel </label>
	<div >
    <img class="iconoEx" src="/imagenes/excelIcono.png"> </img>
    </div>
              <input name="archivo" id="archivo" type="file"   class="archivo form-control"  required/><br /><br />
      </div>
      <div class="box-footer">
                          <button type="submit" class="btn btn-primary">Cargar Datos</button>
      </div>
	  
      </div>

      </form>
      </div>
 
</div>
</div>

@endsection
