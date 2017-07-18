
$(document).ready(function(){
/*inicio */
    $("#newpass").hide();/** 1*/

    $("#edit_pass").click(function(){/**inicio 2*/

        $("#newpass").fadeIn(1000).show();

    });/**fin 2*/

    $("#error").hide() /** 3*/

    $("#btn_enviar").click(function(){/** inicio 4 */

        if($("#in_pass").val()== $("#confirm_pass").val()) {
                
            $("#form").submit();
        }else{
            $("#error").text("las contraseñas no  coinciden").fadeIn(800).show();
        }
    });/** fin 4 */

    /**
     *  1.ocultamos el contenedor new pass que contiene dos input de tipo password para actualizar la contraseña
     *  2. dejamos el link editar pass a la escucha dek evento click, para mostrar el contenedor con los inputs
     *  3. ocultamos el label de error
     *  4. dejamos el boton de enviar a la espera del evento click / valida que el password sea igual en ambos casos
     *      si los campos son iguales ejecuta el evento submit del formulario y envia los datos al controlador.
     *      si los passwords no son iguales muestra el label, y le añade el texto las contraseñas no son iguales.
     *
      */

/*fin*/
});