{!! form::open(['route' => ['admin.user.destroy',$user], 'method' => 'delete']) !!}

    <button type="submit" class="btn btn-danger"> Eliminar Usuario </button>
    <!--este parcial tiene como funcion hacer mas versatil el parcial de login, ya que de otra forma
     en la ventana de login tendriamos el boton eliminar, o tendriamos que crear otro formulario igual al anterior-->
{!! form::close() !!}