@extends('app')

@section('content')

<link href="{{ asset('/css/style.css') }}" rel="stylesheet">
<h1>Actualizar el registro </h1>
          <div class="container">
			<div class="panel panel-default">
            <div class="panel-heading">ACTUALIZAR MANDATO</div> 
					<form class="form-horizontal" role="form" method="POST" action="@if(Auth::user()->perfil==1){{ url('admin/actualizado&') }}{{$capta->id}}@elseif(Auth::user()->perfil==2){{ url('teo/actualizado&') }}{{$capta->id}}@endif" >
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
   <div>
    <img class="iconoActu" src="/imagenes/iconoActu.png"> </img>
    </div>
						
						
						<!--<div class="col-md-3">
							<label class="control-label">Monto Aporte</label>
								<input type="text" class="form-control" name="monto_aporte"  value="@if($capta->monto_aporte==0 or $capta->monto_aporte==null) ingrese monto aporte @else{{ $capta->monto_aporte }}@endif">

						</div>	-->
						<div class="col-md-2">
							<label for="" class="control-label">Fono 1</label>
							<input type="text" name="fono_1" value="{{$capta->fono_1}}" class="form-control">
						</div>

						<div class="col-md-2">
							<label  class="control-label">Fono 2</label>
							<input type="text" name="fono_2" value="{{$capta->fono_2}}" class="form-control">
						</div>

						<div class="col-md-2">
							<label class="control-label">Nombre</label>
							<input type="text" class="form-control" value="{{$capta->nombre}}" name="nombre">
						</div>

						<div class="col-md-2">
							<label class="control-label">Apellido</label>
							<input type="text" name="apellido" value="{{$capta->apellido}}" class="form-control">
						</div>

						<div class=" col-md-2">
                        <label class="control-label">Estado</label>
						 <select  name="estado" class="form-control">
						
                            <option>--Seleccione--</option>
                            <option "@if($capta->estado=='ACEPTA UPGRADE') " value="ACEPTA UPGRADE"  selected "@endif">ACEPTA UPGRADE</option>
                            <option "@if($capta->estado=='PERSONA CUELGA') " value="PERSONA CUELGA"  selected "@endif">PERSONA CUELGA</option>
                            <option "@if( $capta->estado=='NO CONTESTA')" value="NO CONTESTA " selected   "@endif">NO CONTESTA</option>
							<option "@if( $capta->estado=='VOLVER A LLAMAR')" value="VOLVER A LLAMAR  "  selected "@endif">VOLVER A LLAMAR</option>
							<option "@if( $capta->estado=='OTRA PERSONA')" value="OTRA PERSONA  " selected "@endif">OTRA PERSONA</option>
							<option "@if( $capta->estado=='FUERA DE SERVICIO')" value="FUERA DE SERVICIO"  selected "@endif">FUERA DE SERVICIO</option>
							<option "@if( $capta->estado=='GRABADORA')" value="GRABADORA"  selected "@endif">GRABADORA</option>
                        </select>
					 </div>
					
					<div class="col-md-2">
                      <label class="control-label">Fecha Volver a Llamar</label>
						<input  type="date" name="volver_llamar" class="form-control" value="{{$capta->fecha_volver_allamar}}" />
					</div>

						<div class="col-md-9">
							<label class="control-label">Observacion</label>
							<input type="text" class="form-control" name="observacion" value="@if($capta->observacion==null) ingrese un observacion @else{{ $capta->observacion }}@endif">
						</div>
						
					<!--<div class="col-md-2">
							<label class="control-label">N° llamados</label>
						<select  name="n_llamados" class="form-control">
                            <option>--Seleccione--</option>
                            <option "@if( $capta->n_llamados==1)" value="1" selected "@endif">1</option>
                            <option "@if( $capta->n_llamados==2)" value="2" selected "@endif">2</option>
                            <option "@if( $capta->n_llamados==3)" value="3" selected "@endif">3</option>
                        </select>
					</div>
						
					<div class="col-md-2">
                      <label class="control-label">Fecha Primer Llamado</label>
						<input   type="date" name="fecha_primer_llamado" class="form-control" value="{{$capta->fecha_primer_llamado}}" />
					  </div>

					
					<div class="col-md-2">
                      <label class="control-label">Fecha Segundo Llamado</label>
						<input  type="date" name="fecha_segundo_llamado" class="form-control" value="{{$capta->fecha_segundo_llamado}}" />
					</div>

					
					<div class="col-md-2">
                      <label class="control-label">Fecha Tercer Llamado</label>

                      <input  type="date" name="fecha_tercer_llamado" class="form-control"  value="{{$capta->fecha_tercer_llamado}}" />
                      </div>

-->
							<div class="col-md-3">
								<label class="control-label">.</label>
								<button type="submit" class="btn btn-primary form-control">
									ACTUALIZAR
								</button>
							</div>
						<div class="form-group"></div>


					</form>

					</div>


  
@endsection