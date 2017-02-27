@extends('app')

@section('content')
<link href="{{ asset('/css/style.css') }}" rel="stylesheet">
            <h1>Agregar Mandato Exitoso </h1>
			<div class="container">
			<div  class="panel panel-default ">
            <div class="panel-heading">AGREGAR MANDATO</div> 
				   <form class="form-horizontal" role="form" method="POST" action="@if(Auth::user()->perfil==1){{ url('admin/agregado') }}@elseif(Auth::user()->perfil==2){{ url('teo/agregado')}}@endif " >
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
	<div>
    <img class="iconoReg" src="/imagenes/RegistroMandato.png"></img>
    </div>
			            @foreach($c as $ca)
						@if($ca->n_interno_dues==$ca->n_interno_dues)
					    <h2>Mandato Registrado Anteriormente</h2>
						@endif
						@endforeach
						
							
						<div  class="col-md-4 ">
								<input type="hidden" class="form-control" name="n_interno_dues" value="{{$capta->n_interno_dues}}">
						</div>
							
						<div  class="col-md-4 ">
								<input type="hidden" class="form-control" name="id_interno_funda" value="{{$capta->id_interno_funda}}">
						</div>

						<div  class="col-md-4 ">
								<input type="hidden" class="form-control" name="origen" value="{{$capta->origen}}">
						</div>
						
						
						<div id="" class="">
							<label class="col-md-2 control-label">Fono 1</label>
							<div  class="col-md-4 ">
								<input type="text" class="form-control" name="fono1" value="{{$capta->fono1}}">
							</div>
						</div>

						<div id="" class="">
							<label class="col-md-2 control-label">Fono 2</label>
							<div class="col-md-4">
								<input type="text" class="form-control" name="fono2" value="{{$capta->fono2}}">
							</div>
						</div>
						
						<div class="">
							<label class="col-md-2 control-label">Fono 3</label>
							<div class="col-md-4">
								<input type="text" class="form-control" name="fono3" value="">
							</div>
						</div>
						
						<div class="">
							<label class="col-md-2 control-label">Fono 4</label>
							<div class="col-md-4">
								<input type="text" class="form-control" name="fono4" value="">
							</div>
						</div>
						 
						<div class="">
							<label class="col-md-2 control-label">Nombre</label>
							<div class="col-md-4">
								<input type="text" class="form-control" name="nombre" value="{{$capta->nombre}}">
							</div>
						</div>
						
						<div class="">
							<label class="col-md-2 control-label">Apellido</label>
							<div class="col-md-4">
								<input type="text" class="form-control" name="apellido" value="">
							</div>
						</div>
						
						<div class="">
							<label class="col-md-2 control-label">Correo 1</label>
							<div class="col-md-4">
								<input type="text" class="form-control" name="correo1" value="">
							</div>
						</div>
						
						<div class="">
							<label class="col-md-2 control-label">Correo 2</label>
							<div class="col-md-4">
								<input type="text" class="form-control" name="correo2" value="">
							</div>
						</div>
                        
						<div class="">
							<label class="col-md-2 control-label">Fecha Firma Inscripcion</label>
							<div class="col-md-4">
							<input type="date" class="form-control" name="fecha_firma_inscripcion"  value="">
							</div>
						</div> 

						<div class="">
							<label class="col-md-2 control-label">Otro Antecedente</label>
							<div class="col-md-4">
								<input type="text" class="form-control" name="otro_antecedente" value="{{$capta->otro_antecedente}}">
							</div>
						</div>
							
						<div class="">
							<label class="col-md-2 control-label">Monto Original</label>
							<div class="col-md-4">
								<input type="text" class="form-control"  name="monto_original" value="@if($capta->monto_original==0 or $capta->monto_aporte==null) ingrese monto original @else{{ $capta->monto_original }}@endif">
							</div>
						</div>
						
						
						<div class="">
							<label class="col-md-2 control-label">Monto Aporte</label>
							<div class="col-md-4">
								<input type="text" class="form-control" name="monto_aporte"  value="@if($capta->monto_aporte==0 or $capta->monto_aporte==null) ingrese monto aporte @else{{ $capta->monto_aporte }}@endif">
							</div>
						</div>	
						
                        <div class="">
							<label class="col-md-2 control-label">Monto Final</label>
							<div class="col-md-4">
								<input type="text" class="form-control" name="monto_final"  value="@if($capta->monto_final==0 or $capta->monto_final==null) ingrese monto aporte @else{{ $capta->monto_final }}@endif">
							</div>
						</div>
						
				     <div class="">
                        <label class="col-md-2 control-label">Estado</label>
						<div class="col-md-4">
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
                    </div>
					
					<div class="">
                      <label class="col-md-2 control-label">Fecha Volver a Llamar</label>
					  <div class="col-md-4">
                      <input  type="date" name="fecha_volver_allamar" class="form-control" value="{{$capta->fecha_volver_allamar}}" />
                      </div>
					</div>
					<div class="">
							<label class="col-md-2 control-label">Mensaje</label>
							<div class="col-md-4">
								<input type="text" class="form-control" name="mensaje" value="@if($capta->mensaje==null) ingrese un mensaje @else{{ $capta->mensaje }}@endif">
							</div>
						</div>
						<div class="">
							<label class="col-md-2 control-label">Observacion</label>
							<div class="col-md-4">
								<input type="text" class="form-control" name="observacion" value="@if($capta->observacion==null) ingrese un observacion @else{{ $capta->observacion }}@endif">
							</div>
						</div>	
						
					<div class="">
							<label class="col-md-2 control-label">N° llamados</label>
							<div class="col-md-4">
							<select  name="n_llamados" class="form-control">
                            <option>--Seleccione--</option>
                            <option "@if( $capta->n_llamados==1)" value="1" selected "@endif">1</option>
                            <option "@if( $capta->n_llamados==2)" value="2" selected "@endif">2</option>
                            <option "@if( $capta->n_llamados==3)" value="3" selected "@endif">3</option>
                        </select>
							</div>
						</div>						
						
					<div class="">
                      <label class="col-md-2 control-label">Fecha Primer Llamado</label>
					  <div class="col-md-4">
                      <input   type="date" name="fecha_primer_llamado" class="form-control" value="{{$capta->fecha_primer_llamado}}" />

					  </div>
					</div>
					
					<div class="">
                      <label class="col-md-2 control-label">Fecha Segundo Llamado</label>
					  <div class="col-md-4">
                      <input  type="date" name="fecha_segundo_llamado" class="form-control" value="{{$capta->fecha_segundo_llamado}}" />
                      </div>
					</div>
					
					<div class="">
                      <label class="col-md-2 control-label">Fecha Tercer Llamado</label>
					  <div class="col-md-4">
                      <input  type="date" name="fecha_tercer_llamado" class="form-control"  value="{{$capta->fecha_tercer_llamado}}" />
                      </div>
					</div>					
						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								<button type="submit" class="btn btn-primary">
									AGREGAR MANDATO EXITOSO
								</button>
							</div>
						</div>
					</form>
 					</div>
			</div>


  
@endsection