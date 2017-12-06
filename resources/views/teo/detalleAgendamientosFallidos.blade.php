@extends('app')
@section('content')
<style>
</style>
<script>
  $(document).ready(function(){
    $("#ancho").removeClass('col-md-8');
    $("#ancho").addClass('col-xs-12');

    $(".modal-imagen1").hide();
    $(".modal-imagen2").hide();
    $(".modal-imagen3").hide();

    $("#verimagen1").click(function(){
      $(".modal-imagen1").dialog({width:"80%"});
    });
    $("#verimagen2").click(function(){
      $(".modal-imagen3").dialog({width:"80%"});
    });
    $("#verimagen3").click(function(){
      $(".modal-imagen3").dialog({width:"80%"});
    });

  });
</script>
  <div class="container">
    @include('partials.partialDetalleReagendamiento')
  </div>

@endsection()
