

$(document).ready(function(){
    $(".send_data").attr("disabled", true);
    $("#f_agendamiento").change(function(){
        $("#jornada").val("");


        info={fecha:$("#f_agendamiento").val(),rutero:$("#rutero").val()} //creamos un literal con la informacion que enviaremos al servidor

        $.get('/admin/dispRutas',info,procDatos); //enviamos la informacion del literal y asignam,os la funcion encargada de procesar la ifnormacion con el metodo get
        console.log(info);
        /**limpiamos la tabla que usaremos para mostrar la informacion
         * asignamos la variable fila segun el largo del array que tiene la informacion
         * con un ciclo for recorremos la informacion y guardamos los datos en una bariable la cual contiene el formato para mostrar la tabla
         * usamos la funcio append para mostra el contenido de la variable en la tabla
         * por ultimo mostramos la tabla en una ventamos modal usando la funcion dialog
         * si el largo de el array es igual o mayor que la cantidad maxima asignada se bloquea el boton agendar y salta una alerta idnicando que se exedio el maximo
         * de agendamientos para el dia y ruteros seleccionado*/
        function procDatos(data){
            console.log(data);
            $("#rutas_dias_table > tbody").empty();
            $("#rutas_dias_tablePm > tbody").empty();
            var fila = data.length;
            $("#numero_Rutas").text(fila);
            var countAm=0;
            var countPm=0;
            for(var i = 0;i<fila;i++){

                var nuevaFilaAm = "<tr><td>"+
                    data[i].rutero+"</td><td>"+
                    data[i].comuna+"</td><td>"+
                    data[i].horario+"</td><td>"+
                    data[i].estado_captacion+"</td></tr>"

                if(data[i].horario=="AM"){

                    $("#rutas_dias_table").append(nuevaFilaAm);
                    countAm++;

                }else{
                    $("#rutas_dias_tablePm").append(nuevaFilaAm);
                    countPm++;
                }

            }/***Fin for*/

            $("#tituloam").text("Agendamientos AM :"+countAm);
            $("#titulopm").text("Agendamientos PM :"+countPm);
            $(".modal_form_rutas").dialog({heigh:"auto",width:"auto"});
            var day= parseInt($("#max_day").val());
            var am= parseInt($("#max_am").val());
            var pm= parseInt($("#max_pm").val());

            $("#jornada").change(function(){
                if(fila >= day){

                    $(".send_data").attr("disabled",true);
                    alert("Excede maximo de rutas diarias");
                }else{

                if($("#jornada").val()=="AM"){
                    if(countAm >=am) {
                        $(".send_data").attr("disabled", true);
                        alert("Excede maximo de rutas AM");
                    }else{
                        $(".send_data").attr("disabled", false);
                    }
                }else if($("#jornada").val()=="PM"){
                    if(countPm >=pm){
                        $(".send_data").attr("disabled",true);
                        alert("Excede maximo de rutas PM");
                    }else{
                        $(".send_data").attr("disabled", false);
                    }
                }
            }
            });
        }/**Fin ProcDatos*/
        });
    });/**Fin Funcion Ver  las Rutas*/
    
