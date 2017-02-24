{!! form::open(['route' => ['admin.user.destroy',$user], 'method' => 'delete']) !!}

    <button type="submit" class="btn btn-danger"> Eliminar Usuario </button>

{!! form::close() !!}