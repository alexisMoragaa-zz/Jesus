
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
    
    /** inicio 5 */
    
    $('#fono_seleccionado').val($("#fon_selector").val());

    $("#fon_selector").change(function(){

        $('#fono_seleccionado').val($("#fon_selector").val());
    });

    $('#correo_seleccionado').val($("#correo_selector").val());

    $("#correo_selector").change(function(){

        $('#correo_seleccionado').val($("#correo_selector").val());
    });
    /** fin 5 */
    
    /** inicio 6 */

   if( $("#fono2").val()==""){
       $("#fono2").hide();
       }
    if( $("#fono3").val()==""){
        $("#fono3").hide();
    }
    if( $("#fono4").val()==""){
        $("#fono4").hide();
    }

    if( $("#correo2").val()==""){
        $("#correo2").hide();
    }/** fin 6 */
   
    /** inicio 7 */
/*fin*/
});
/**
 *  1.ocultamos el contenedor new pass que contiene dos input de tipo password para actualizar la contraseña
 *  2. dejamos el link editar pass a la escucha del evento click, para mostrar el contenedor con los inputs
 *  3. ocultamos el label de error
 *  4. dejamos el boton de enviar a la espera del evento click / valida que el password sea igual en ambos casos
 *      si los campos son iguales ejecuta el evento submit del formulario y envia los datos al controlador.
 *      si los passwords no son iguales muestra el label, y le añade el texto las contraseñas no son iguales.
 *  5. asignamos el valor de un select a una input de tipo text, para que luego el teleoperador pueda copiar y
 *      pegar ehn zoiper
 *     luego con el evento change volvemos a asignar el valor seleccionado en el select cada vez que este cambie.
 *     hacemos lo mismo con el correo.
 * 6. consultamos con una sentencia if el valor de el campo option, y si el campo esta vacio lo ocultamos.
 */