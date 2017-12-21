$(document).ready(function () {
      /**Ocultar ventanas al Inicio*/
      $(".modal-form").hide();
      $(".modal_form_rutas").hide();
      $(".v_llamar").hide();
       $("#fixedPhone").hide();
      $(".send_data").attr("disabled",true);
      $(".agendamientoConValidacionReducida").hide();


      /**Si esl estado es Volver a Llamar despliega un input oculto*/
      $("#status").change(function(){
          if($(this).val()=="Volver a llamar"){
              $(".v_llamar").fadeIn();
          }else{
              $(".v_llamar").fadeOut();
          }
      });

      /**si se apreta cancelar despliega una ventana modal para regresar*/
      $("#btn-cancel").click(function(){
          $( ".modal-form" ).dialog({
              buttons: [{
                 text: "Cancelar","class":'btn btn-danger space',"id":'space',click: function () {

                      $(this).dialog("close");
                  }},{
                  text:"Aceptar","class":'btn btn-success',"id":'space2',click : function(){
                      $("#form-cap").submit();
                  }
              }]
          });
      });

  /**Funcion ajax para mostrar el rutero que corresponde segun la comuna seleccionada*/
  $("#comuna").on('change', function (e) {
      console.log(e);
      var rutero_id = e.target.value;
      $.get('/teo/ajax-rutero?ruteroid=' + rutero_id, function (data) {
          console.log(data);
          $.each(data, function (index, obj) {
              $("#rutero").val(obj.rutero);
              $("#comunatable").text(obj.comuna);
              $("#voluntario").text(obj.rutero);
              $("#lunes").text(obj.h_lunes);
              $("#martes").text(obj.h_martes);
              $("#miercoles").text(obj.h_miercoles);
              $("#jueves").text(obj.h_jueves);
              $("#viernes").text(obj.h_viernes);
          });
      });
  });

  /**llamado a una funcion rut, la cual valida si el es chileno, y marca el input en rojo
   * de no ser unrut valido para chile*/

  $("#rut").rut({validateOn: 'keyup change'})
          .on('rutInvalido', function () {
              $(this).addClass("error")
              res = false;
          })
          .on('rutValido', function () {

              $(this).removeClass("error")
              res = true;
          });



// validacion personalizada con jquery validator
var response;
$.validator.addMethod(
  "validarSocio",
  function(value, element){

      var datos = {rut: $("#rut").val(), fundacion: $("#fundacion").val()}
        $.get('validarSocio', datos, procesarDatos);
          function procesarDatos(data)
          {

            if (data == 2)
            {
            response = false;

            }else if(data == 1)
            {
           response = true;
            }
        };
    return response;
  },
  "el usuario ya es socio o tiene una visita pendiente"
);

$("#senddPassCode").validate({
  rules:{
    tipo_retiro:{
      required:true,
    },
    comuna:{
      required:true,
    },
    jornada:{
      required:true,
    },
     c_movistar:{
       required:function(element){
         return $("#forma_pago").val()=="Movistar";
       }
     },
    fono_1:{
      required:true,
    },
    nombre:{
      required:true,
    },
    apellido:{
      required:true,
    },

    lugarRetiro:{
      required:true,
    },
    off_depto:{
      required:true,
    },
    direccion:{
      required:true,
     },
    numero:{
      required:true,

    },
    correo_1:{
      required:true,
      email:true,
    },
    rutero:{
      required:true,
    },
    nom_campana:{
      required:true,
    },
    monto:{
      required:true,
      minlength:4,
      number:true,
      range:[4000,999999]
    },
    forma_pago:{
      required:true,
     },
    observaciones:{
      required:true,
      minlength:100,
    },
  },
  messages:{
    tipo_retiro:{
        required:"Seleccione una opcion",
    },
    comuna:{
        required:"Seleccione una opcion",
    },

    jornada:{
        required:"Seleccione una opcion",
    },

    fono_1:{
      required:"Campo Obligatorio",
    },
    nombre:{
      required:"Campo Obligatorio",
    },
    apellido:{
      required:"Campo Obligatorio",
    },
    lugarRetiro:{
      required:"Campo Obligatorio",
    },
    off_depto:{
      required:"Campo Obligatorio",
    },
    direccion:{
      required:"Campo Obligatorio",
    },
    numero:{
      required:"Campo Obligatorio",
    },
    correo_1:{
      required:"Campo Obligatorio",
    },
    rutero:{
      required:"Campo Obligatorio",
    },
    nom_campana:{
      required:"Campo Obligatorio",
    },
    c_movistar:{
      required:"este campo es obligatorio por que se selecciono movistar como forma de pago",
    },
    monto:{
      required:"Campo Obligatorio",
      minlength:"Minimo 4 caracteres",
      number:"Solo Numeros",
      range:"ingrese un valor entre 4.000 y 9.999.999"
    },
    forma_pago:{
      required:"Seleccione una opcion",
    },
    observaciones:{
      required:"Campo Obligatorio",
      minlength:"Minimo 100 caracteres",
    },
  }
});

$("#sendd").validate({
    rules:{
      tipo_retiro:{
        required:true,
      },
      comuna:{
        required:true,
      },
      jornada:{
        required:true,
      },
       c_movistar:{
         required:function(element){
           return $("#forma_pago").val()=="Movistar";
         }
       },
      rut:{
        required:true,
        validarSocio:true,
        // validarRut:true
      },
      fono_1:{
        required:true,
      },
      nombre:{
        required:true,
      },
      apellido:{
        required:true,
      },
      lugarRetiro:{
        required:true,
      },
      off_depto:{
        required:function(element){
          return $("#lugarRetiro").val()!="Casa";
        }

      },
      direccion:{
        required:true,
       },
      numero:{
        required:true,

      },
      correo_1:{
        required:true,
        email:true,
      },
      rutero:{
        required:true,
      },
      nom_campana:{
        required:true,
      },
      monto:{
        required:true,
        minlength:4,
        number:true,
        range:[3000,999999]

      },
      forma_pago:{
        required:true,
       },
      observaciones:{
        required:true,
        minlength:100,
      },

    },
    messages:{
      tipo_retiro:{
          required:"Seleccione una opcion",
      },
      comuna:{
          required:"Seleccione una opcion",
      },

      jornada:{
          required:"Seleccione una opcion",
      },
      rut:{
        required:"Campo Obligatorio",
      },
      fono_1:{
        required:"Campo Obligatorio",
      },
      nombre:{
        required:"Campo Obligatorio",
      },
      apellido:{
        required:"Campo Obligatorio",
      },
      lugarRetiro:{
        required:"Campo Obligatorio",
      },
      off_depto:{
        required:"Campo Obligatorio para Oficina y departamento",
      },
      direccion:{
        required:"Campo Obligatorio",
      },
      numero:{
        required:"Campo Obligatorio",
      },
      correo_1:{
        required:"Campo Obligatorio",
      },
      rutero:{
        required:"Campo Obligatorio",
      },
      nom_campana:{
        required:"Campo Obligatorio",
      },
      c_movistar:{
        required:"este campo es obligatorio por que se selecciono movistar como forma de pago",
      },
      monto:{
        required:"Campo Obligatorio",
        minlength:"Minimo 4 caracteres",
        number:"Solo Numeros",
        range:"ingrese un valor entre 4.000 y 9.999.999"
      },
      forma_pago:{
        required:"Seleccione una opcion",
      },
      observaciones:{
        required:"Campo Obligatorio",
        minlength:"Minimo 100 caracteres",
      },
    }
  });


  if($("#tipo_retiro").val()=="Acepta Grabacion"){
      $("#fixedPhone").show();
      $(".send_data").attr("disabled",false);
  }

  $("#tipo_retiro").change(function(){

    if($(this).val()=="Acepta Grabacion"||$(this).val()=="Acepta Upgrade"){
          $(".grabacion").fadeOut();
          $("#fixedPhone").show();
          $(".send_data").attr("disabled",false);
          $("#btn_rutas").hide();
    }else{
          $(".grabacion").fadeIn();
          $("#fixedPhone").hide();
          $("#btn_rutas").show();
          $(".send_data").attr("disabled",true);
    }
  });


  /**funncion que desbloquea un boton para ver la disponivilidad de ruta*/
  $("#comuna").change(function(){
       $("#f_agendamiento").change(function(){
           $("#jornada").change(function(){

               $("#btn_rutas").attr("disabled",false);
           });
       });
  });

  /**esta funcion mediante ajax nos muestra la disponivilidad de rutas para el dia y el rutero seleccionados*/
  $("#btn_rutas").click(function(){

      info={fecha:$("#f_agendamiento").val(),rutero:$("#rutero").val()} //creamos un literal con la informacion que enviaremos al servidor

      $.get('/teo/dispRutas',info,procDatos); //enviamos la informacion del literal y asignam,os la funcion encargada de procesar la ifnormacion con el metodo get
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
      $("#titulo").text("Agendamientos "+fila);
      var countAm=0;
      var countPm=0;
      for(var i = 0;i<fila;i++){

          var nuevaFilaAm = "<tr><td>"+
              data[i].rutero+"</td><td>"+
              data[i].comuna+"</td><td>"+
              data[i].horario+"</td><td>"+
              data[i].estado_captacion+"</td></td>"

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
      }/**Fin ProcDatos*/
  });/**Fin Funcion para validar Rutas*/


  // fin funcion para validar el passcode
  });/**fin document.ready*/
