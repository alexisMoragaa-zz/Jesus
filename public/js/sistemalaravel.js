


$(document).on("submit",".formarchivo",function(e){


    e.preventDefault();
    var formu=$(this);
    var nombreform=$(this).attr("id");
    var rs=false; //leccion 10
    var seccion_sel=  $("#seccion_seleccionada").val();
    if(nombreform=="form_cargar_datos" ){ var miurl="cargar_datos";  var divresul="notificacion_resul_fcdu"; rs=true; }
    if(nombreform=="form_cargar_datos_campana2" ){ var miurl="cargar_datos";  var divresul="notificacion_resul_fcdu"; rs=true; }

    //información del formulario
    var formData = new FormData($("#"+nombreform+"")[0]);

    //hacemos la petición ajax
    $.ajax({
        url: miurl,
        type: 'POST',

        // Form data
        //datos del formulario
        data: formData,
        //necesario para subir archivos via ajax
        cache: false,
        contentType: false,
        processData: false,
        //mientras enviamos el archivo
        beforeSend: function(){
            $("#"+divresul+"").html($("#cargador_empresa").html());
        },
        //una vez finalizado correctamente
        success: function(data){
            $("#"+divresul+"").html(data);
            if(rs ){
                $('#'+nombreform+'').trigger("reset");
                mostrarseccion(seccion_sel);
            }
        },
        //si ha ocurrido un error
        error: function(data){
            alert("ha ocurrido un error") ;

        }
    });

    irarriba();

});
