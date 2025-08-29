function include(scriptUrl) {
    document.write('<script src="' + scriptUrl + '"></script>');
}

function isIE() {
    var myNav = navigator.userAgent.toLowerCase();
    return (myNav.indexOf('msie') != -1) ? parseInt(myNav.split('msie')[1]) : false;
};


/* Bootstrap 3.3.7 Core JavaScript
=============================================*/

include('js/bootstrap-3.3.7/bootstrap.min.js');


/* camera
=============================================*/

include('js/camera-1.3.4/camera.min.js');
include('js/camera-1.3.4/jquery.easing.1.3.js');

/* Owl Carousel
=============================================*/

include('js/owlcarousel-2.2.0/owl.carousel.min.js');

/* elevate Zoom
=============================================*/

include('js/elevateZoom-3.0.8/jquery.elevatezoom.js');

/* Wait for Images
=============================================*/

include('js/waitforimages/jquery.waitforimages.js');

/* Isotope
=============================================*/

include('js/isotope/isotope.pkgd.min.js');

/* File Upload
=============================================*/

include('js/fileupload/vendor/jquery.ui.widget.js');
include('js/fileupload/jquery.iframe-transport.js');
include('js/fileupload/jquery.fileupload.js');


/* Parallax
=============================================*/
;
(function ($) {
    include('js/parallax/jquery.rd-parallax.js');
})(jQuery);



$(document).ready(function(){

ocultarMostrarCamposTodos();

agregarAsteriscoRequeridos();

$(".spinner").hide();
$(".alert").hide();


   

/* Elevate zoom
=============================================*/




$(".destacados-imagen img").mouseover(function(){
        $(this).elevateZoom({
            zoomType: "inner",
            cursor: "crosshair"
        });
}) 
  



/* Ajuste de affix
=============================================*/
ajusteAffix();


/* Inicio Owl Carousel
=============================================*/
$(".owl-carousel").owlCarousel({
    items : 4,
    loop:true,
    nav:false,
    autoplay:false,
    navText:["Anterior","Siguiente"],
    responsive:{
        0:{
            items:1,
            nav:false
        },
        479:{
            items:1,
            nav:false
        },
        600:{
            items:1,
            nav:false
        },
        979:{
            items:3,
            nav:false
        },
        1199:{
            items:4,
            nav:false
        }                        
    }        
});

contadorCesta();
favoritosLateral();
cestaLateral();
contadorMensajes();

/* Dropdown Menú
=============================================*/

    $('.navbar-nav .dropdown').hover(function() {
        $(this).find('.dropdown-menu').first().stop(true, true).delay(0).slideDown();
    }, function() {
        $(this).find('.dropdown-menu').first().stop(true, true).delay(100).slideUp();
    });

    $('.navbar-nav .dropdown > a').click(function(){
        location.href = this.href;
    });

/* File Upload
=============================================*/

    $(function () {


        'use strict';
        var url = './img/';

        $('#fileupload1').fileupload({
            url: url,
            dataType: 'json',
            done: function (e, data) {
                $(".spinner").hide();

                $.each(data.result.files, function (index, file) {                 

                    if (typeof file["error"] != 'undefined') {
                        $("#files1").html('<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="fa fa-exclamation fa-fw"></i>'+file["error"]+'.</div>');
                        $('#progress1 .progress-bar').css('width',0);
                    }else{

                        var unidad='B'

                        if (file.size>1024) {
                            file.size=(file.size/1024).toFixed(2);
                            unidad='Kb'
                        };

                        if (file.size>1024) {
                            file.size=(file.size/1024).toFixed(2);
                            unidad='Mb'
                        };

                        if (file.size>1024) {
                            file.size=(file.size/1024).toFixed(2);
                            unidad='Gb'
                        };                                                      

                        var html='';
                        html += '<div class="row">';
                        html += '<div class="col-sm-6">';
                        html += '<span><i class="fa fa-file-o" aria-hidden="true"></i> Archivo: '+file.name+'</span><br />';
                        html += '<span><i class="fa fa-file-o" aria-hidden="true"></i> Tamaño: '+file.size+' '+unidad+'</span>';
                        html += '</div>';
                        html += '<div class="col-sm-6">';
                        html += '<a style="margin-left:10px" class="btn btn-default" onclick="eliminar(1)"><i class="fa fa-trash" aria-hidden="true"></i> Eliminar</a>';
                        html += '</div>';
                        html += '<input type="hidden" id="archivo"  class="form-control" value="'+file.name+'">';
                        html += '</div>';

                        $("#files1").html(html);

                    };
                });
            },
            progressall: function (e, data) {
                $(".spinner").show();

                var progress = parseInt(data.loaded / data.total * 100, 10);
                $('#progress1 .progress-bar').css(
                    'width',
                    progress + '%'
                    );
            },
        });
    });                

});

/* File Upload
=============================================*/

function eliminar(orden){

    $('#progress'+orden+' .progress-bar').css('width',0);
    $("#files"+orden).html("");

    if (orden==2) {
        $("#previsualizacion-imagen").empty();
    };

}


function aplicaElevateZoom(elemento){

    if (($(window).width()+17)<768 || $(elemento).parents($(".productos-contenedor")).hasClass("grilla")) {
        $(elemento).removeData('elevateZoom');
        $('.zoomWrapper img.zoomed').unwrap();
        $('.zoomContainer').remove();

        $(elemento).elevateZoom({
            zoomType: "inner",
            cursor: "crosshair"          
        });        
    }else{
        $(elemento).removeData('elevateZoom');
        $('.zoomWrapper img.zoomed').unwrap();
        $('.zoomContainer').remove();


        if ($(elemento).prop("naturalWidth")<400) {
            var ancho = $(elemento).prop("naturalWidth");
        }else{
            var ancho=400;
        };

        if ($(elemento).prop("naturalHeight")<400) {
            var alto = $(elemento).prop("naturalHeight");
        }else{
            var alto=400;
        };

        console.log(ancho);

        $(elemento).elevateZoom({
            zoomWindowWidth:ancho,
            zoomWindowHeight:alto
        });
    };    
   
}


/* Ajuste de affix
=============================================*/

function ajusteAffix(){
    $(window).off('.affix')
    $('#encabezado-fijo').removeData('bs.affix').removeClass('affix affix-top affix-bottom')
    $('#encabezado-fijo').affix({
        offset: {
            top: function () {
                return (this.top = $("#encabezado-ocultable").innerHeight())
            }
        },
    })    
}

$('#encabezado-fijo').on('affix.bs.affix', function () {
    $(".container-fluid:eq(2)").css("padding-top",$('#encabezado-fijo').innerHeight());
});

$('#encabezado-fijo').on('affix-top.bs.affix', function () {
    $(".container-fluid:eq(2)").css("padding-top","0");
});

$( window ).resize(function() {

    ajusteAffix();

    grillaOLista();

});

/* Ver Catálogo
=============================================*/

function verCatalogo(categoria){
    $("#subcategorias .modal-title").empty().html(categoria);
    $("#subcategorias .modal-body").empty();

    var accion="retornar-lineas"

    $.ajax({
        url: "./api/api.php",
        type: "get",
        //crossDomain: true,
        data: {accion:accion, categoria:categoria},
        dataType: "json",
        success: function (response) {
            if (response["error"]==false) {
                var html='';
                html+='<ul class="fa-ul">';
                for (var i = 0; i < Object.keys(response["exito"]).length; i++) {
                    html+='<li><i class="fa fa-check cl-color-1" aria-hidden="true"></i><a href="productos.php?categoria='+categoria+'&favoritos=false&linea='+response["exito"][i]["linea"]+'"> '+response["exito"][i]["linea"]+'</a></li>';
                };
                html+='</ul>';                
                $("#subcategorias .modal-body").append(html);

                $("#subcategorias").modal();                    
            }else{
                var content="";         
                for (var i = 0; i < Object.keys(response["errores"]["coderror"]).length; i++) {
                    content+=response["errores"]["mensajeerror"][i];
                    content+="<br>";
                };
                mostrarMensaje(content);
            };
        },
        error: function(jqXHR, textStatus, errorThrown) {
           console.log(textStatus, errorThrown);
        }
    });    

}

/* Grilla y Lista
=============================================*/

function grillaOLista(){
    if (($(window).width()+17)<992) {
        productosMostrarGrilla(); 
    }else{
        if (localStorage.getItem("trama_solutions_ecommerce_mostrarproducto")=="grilla") {
            productosMostrarGrilla();
        }else{
            productosMostrarLista();
        }
    };    
}

function MostrarGrilla(){
    localStorage.setItem("trama_solutions_ecommerce_mostrarproducto", "grilla");    
    productosMostrarGrilla();
}

function MostrarLista(){
    localStorage.setItem("trama_solutions_ecommerce_mostrarproducto", "lista");    
    productosMostrarLista();
}


function productosMostrarGrilla(){
    $(".collapse").addClass("no-display");
    $(".productos-imagen").removeData('elevateZoom');
    $('.zoomWrapper img.zoomed').unwrap();
    $('.zoomContainer').remove();    
    $(".panel-group").addClass("row");
    $(".productos-contenedor").addClass("col-lg-4 col-sm-6");
    $(".productos-contenedor").addClass("grilla");
    $(".productos-contenedor").removeClass("lista");
    $(".productos-contenedor-detalles").removeClass("col-xs-10")    
    $(".productos-contenedor-detalles").addClass("col-xs-12");
    $(".productos-titulo").addClass("col-xs-12 no-padding");
    $(".productos-titulo").removeClass("col-md-6 col-sm-5");
    $(".productos-contenedor-imagen").addClass("col-xs-12 no-padding");
    $(".productos-contenedor-imagen").removeClass("col-sm-2");
    $(".productos-precio").addClass("col-xs-12 no-padding");
    $(".productos-precio").removeClass("col-md-3 col-sm-4");
    $(".productos-controles").addClass("col-xs-12 no-padding");
    $(".productos-controles").removeClass("col-md-3 col-sm-3");
    $(".contenedor-descripcion").addClass("no-padding");

    var elementos = [
        ".productos-contenedor-imagen",
        ".productos-contenedor-detalles",
        ".productos-titulo",
        ".productos-precio",
        ".productos-controles",
        ".contenedor-descripcion",
        ".productos-contenedor"
    ]

    igualarAlto(elementos);


}

function productosMostrarLista(){
    $(".collapse").removeClass("no-display");
    $(".productos-imagen").removeData('elevateZoom');
    $('.zoomWrapper img.zoomed').unwrap();
    $('.zoomContainer').remove();
    $(".panel-group").removeClass("row");
    $(".productos-contenedor").removeClass("col-lg-4 col-sm-6");
    $(".productos-contenedor").removeClass("grilla");
    $(".productos-contenedor").addClass("lista");
    $(".productos-contenedor-detalles").removeClass("col-xs-12")    
    $(".productos-contenedor-detalles").addClass("col-xs-10");    
    $(".productos-titulo").removeClass("col-xs-12 no-padding");
    $(".productos-titulo").addClass("col-md-6 col-sm-5");
    $(".productos-contenedor-imagen").removeClass("col-xs-12 no-padding");
    $(".productos-contenedor-imagen").addClass("col-sm-2");
    $(".productos-precio").removeClass("col-xs-12 no-padding");
    $(".productos-precio").addClass("col-md-3 col-sm-4");
    $(".productos-controles").removeClass("col-xs-12 no-padding");
    $(".productos-controles").addClass("col-md-3 col-sm-3");
    $(".contenedor-descripcion").removeClass("no-padding");

    var elementos = [
        ".productos-contenedor-imagen",
        ".productos-contenedor-detalles",
        ".productos-titulo",
        ".productos-precio",
        ".productos-controles",
        ".contenedor-descripcion",
        ".productos-contenedor"
    ]

    resetearAlto(elementos);

    localStorage.setItem("trama_solutions_ecommerce_mostrarproducto", "lista");
                       
}


/* Ocultar y Mostrar campos en un Formulario
=============================================*/

$("[data-elemento-dependiente='true']").change(function(){
    ocultarMostrarCampos($(this));
})

function ocultarMostrarCamposTodos(){
    $("[data-elemento-dependiente='true']").each(function( index ) {
        ocultarMostrarCampos($(this));
    });
}

function ocultarMostrarCampos(elemento){
    $("[data-dependiente='"+$(elemento).attr("id")+"']").each(function( index ) {
        if ($(this).data("visible")[$(elemento).val()]==false) {
            $(this).addClass("no-display");
            if ($(this).find(".form-control").attr("required")) {
                $(this).find(".form-control").attr("data-required",true);
                $(this).find(".form-control").removeAttr("required");
            };
        }else{
            $(this).removeClass("no-display");
            if ($(this).find(".form-control").attr("data-required")) {
                $(this).find(".form-control").removeAttr("data-required",true);
                $(this).find(".form-control").attr("required",true);
            };            
        };
    });    
}


/* Agregar * a campos Requeridos
=============================================*/

function agregarAsteriscoRequeridos(){
    $("[required]").each(function(index){
        $("label[for='"+$(this).attr("id")+"']").append('<span class="required"> *</span>'); 
    });
}


/* Login
=============================================*/

$("input").focus(function(){
    $("a").popover('destroy');
})

function login(elemento){

    var contenidoOriginal=$(elemento).html();
    $(elemento).html('<i class="fa fa-spinner fa-pulse fa-fw"></i> Ingresar');
    bloquearBoton(elemento);


    var accion="login";
    var elementoUsuario=$(elemento).parents("form").find('.login-usuario');
    var elementoContrasena=$(elemento).parents("form").find('.login-contrasena');

    var usuario=$(elementoUsuario).val();
    var contrasena=$(elementoContrasena).val();


    $.ajax({
        url: "./api/api.php",
        type: "get",
        //crossDomain: true,
        data: {accion:accion, usuario:usuario, contrasena:contrasena},
        dataType: "json",
        success: function (response) {
            if (response["error"]==false) {
                window.location.href = "bienvenido.php";
            }else{
                var content="";         
                for (var i = 0; i < Object.keys(response["errores"]["coderror"]).length; i++) {
                      content+=response["errores"]["mensajeerror"][i];
                      content+="<br>";
                  };
                $(elemento).popover({
                    content:content,
                    html:true,
                    trigger:"click",
                    placement:"bottom",
                    delay: { "show": 100, "hide": 100 }
                })
                $(elemento).popover('toggle')
                
                setTimeout(function(){  
                    $(elemento).html(contenidoOriginal);
                    desbloquearBoton(elemento);                                
                },300);

            };
        },
        error: function(jqXHR, textStatus, errorThrown) {
           console.log(textStatus, errorThrown);
        }
    });

}


function logout(){

    var accion="logout";

    $.ajax({
        url: "./api/api.php",
        type: "get",
        //crossDomain: true,
        data: {accion:accion},
        dataType: "json",
        success: function (response) {
            location.reload()
        },
        error: function(jqXHR, textStatus, errorThrown) {
           console.log(textStatus, errorThrown);
        }
    });
}


/* Retornar Novedades
=============================================*/

function retornarNovedades(){

    $loading.show();
    $(".cargarmas a").html('<i class="fa fa-spinner fa-pulse fa-fw"></i> Cargando...');
    $(".cargarmas a").attr("disabled", true);
    $(".cargarmas a").bind('click', false);    

  var accion="paginanovedades";
  var offset=$("#novedadesoffset").val();  

  $.ajax({
      url: "./api/api.php",
      type: "get",
      //crossDomain: true,
      data: {accion:accion, offset:offset},
      dataType: "json",
      success: function (response) {
          if (response["error"]==false) {
            var html="";
            for (var i = 0; i < Object.keys(response["exito"]).length; i++) {
              html+='<div class="row novedad">';
              html+='<div class="col-md-12">';
              html+='<h3 class="bold mayuscula titulo2">'+response["exito"][i]["titulo"]+'</h3>';
              html+='<img src="'+response["adicionales"]["carpetaupload"]+response["exito"][i]["imagen"]+'" alt="">';
              html+='<p>'+response["exito"][i]["contenidocorto"]+'</p>';
              html+='<a class="btn btn-danger btn-lg" href="novedad.php?novedad='+response["exito"][i]["id"]+'">Ver Más</a>'        
              html+='</div>';
              html+='</div>';
            };
            $("#paginanovedades").append(html);

            $("#novedadesoffset").val(parseInt(parseInt($("#novedadesoffset").val())+Object.keys(response["exito"]).length))
          
            $(".cargarmas a").html("Cargar Más");

            desbloquearBoton($(".cargarmas a"));
          }else{
            $(".cargarmas a").html(response["errores"]["mensajeerror"][0]);
            bloquearBoton($(".cargarmas a"));
          };
      },
      error: function(jqXHR, textStatus, errorThrown) {
         console.log(textStatus, errorThrown);
      }
  });      
}

/* Retornar Portfolio
=============================================*/

function retornarPortfolio(){

  $loading.show();

  var accion="paginaportfolio";

  $.ajax({
      url: "./api/api.php",
      type: "get",
      //crossDomain: true,
      data: {accion:accion},
      dataType: "json",
      success: function (response) {
          if (response["error"]==false) {
            var html="";
            for (var i = 0; i < Object.keys(response["exito"]).length; i++) {

                html+='<div class="element-item col-xs-12 portfolio-contenedor grilla col-lg-4 col-sm-6 categoria'+response["exito"][i]["fkCategoriaPortfolio"]+'">';
                html+='<div class="portfolio-inner">';
                html+='<div class="portfolio-contenedor-imagen col-xs-12 no-padding">';
                if (response["exito"][i]["imagen"]!="") {
                    html+='<img class="portfolio-imagen" src="'+response["adicionales"]["carpetaupload"]+response["exito"][i]["imagen"]+'" alt="">';
                };
                html+='</div>';
                html+='<div class="portfolio-contenedor-detalles no-padding col-xs-12">';
                html+='<div class="portfolio-titulo mayuscula col-xs-12 no-padding">';
                html+='<h5>'+response["exito"][i]["denominacion"]+'</h5>';
                html+='</div>';
                html+='<div class="text-center col-xs-12 no-padding">';
                html+='<a class="btn btn-danger" href="obra.php?obra='+response["exito"][i]["id"]+'">Ver Más</a>';
                html+='</div>';
                html+='</div>';
                html+='</div>';
                html+='</div>';

            };
            $("#paginaportfolio .grid").append(html);

            $("#paginaportfolio .grid").hide();
            $loading.show();

            $('.grid').waitForImages(function() {
                $loading.hide();
                $("#paginaportfolio .grid").show();
                var $grid = $('.grid').isotope({
                  itemSelector: '.element-item'
                });
                $('#filters').on( 'click', 'button', function() {
                  var filterValue = $( this ).attr('data-filter');
                  $grid.isotope({ filter: filterValue });
                });
                $('.button-group').each( function( i, buttonGroup ) {
                  var $buttonGroup = $( buttonGroup );
                  $buttonGroup.on( 'click', 'button', function() {
                    $buttonGroup.find('.is-checked').removeClass('is-checked');
                    $( this ).addClass('is-checked');
                  });
                });             
            });

          }
      },
      error: function(jqXHR, textStatus, errorThrown) {
         console.log(textStatus, errorThrown);
      }
  });      
}


/* Preloader
=============================================*/

var $loading = $('#preloader').hide();
$(document)
.ajaxStart(function () {
   
})
.ajaxStop(function () {
    $loading.hide();
});



/* Borrar Error
=============================================*/

function borrarError(elemento){
    $(elemento).removeClass("inputerror");
    $(elemento).parent("div").find(".help-block").hide();
}

$(".form-control").keypress(function(){
    //borrarError($(this));
})

$("select.form-control").change(function(){
    borrarError($(this));
})

/* Enviar Formulario con Captcha
=============================================*/

function enviarFormularioCaptcha(elemento){
    $(".spinner").show();
    limpiarAlert();

    if ($(".g-recaptcha").length>0) {
        
        var response=grecaptcha.getResponse();
        var accion="captcha";

        $.ajax({
            url: "./api/api.php",
            type: "get",
            //crossDomain: true,
            data: {accion:accion, response:response},
            dataType: "json",
            success: function (response) {                              
                if (response["success"]==true) {
                    enviarformulario(elemento);
                }else{
                   $(".spinner").hide();
                    mostrarMensaje("Debe marcar la casilla");                    
                };
            },
            error: function(jqXHR, textStatus, errorThrown) {
               console.log(textStatus, errorThrown);
            }
        });        
    }else{
        enviarformulario(elemento);
    };    
}


/* Enviar Formulario
=============================================*/

function enviarformulario(elemento){

    $(".spinner").show();
    limpiarAlert();



    var content=""; 

    var nombreformulario=$(elemento).attr("data-formulario");

    var cabecera={};
    var errores=0;


    $( "#"+nombreformulario+" .form-control" ).each(function( index ) {

        borrarError($(this));


        if ($(this).attr("tagName")=="textarea") {
            var id=$(this).attr("id");
            var valor=$(this).text();
        }else{
            var id=$(this).attr("id");
            var valor=$(this).val();
        };

        if($(this).prop('required') && valor==""){
            $(this).addClass("inputerror");
            $(this).parent("div").find(".help-block").show();
            errores ++;
        } else {
            
        }

        cabecera[id]=valor;

    });

    if (errores==0) {
        
        $(".spinner").show();

        var accion=nombreformulario;

        $.ajax({
          url: "./api/api.php",
          type: "get",
          //crossDomain: true,
          data: {accion:accion, cabecera:cabecera},
          dataType: "json",
          success: function (response) {
            if (response["error"]==false) {
                $(".spinner").hide();

                if (response["adicionales"]==undefined) {

                    mostrarMensaje(response["exito"],"volverhome()");
                    limpiarFormulario(elemento);

                }else{

                    window.location.href = response["adicionales"]["redirigir"];

                };
            }else{
                for (var i = 0; i < Object.keys(response["errores"]["coderror"]).length; i++) {
                      content+=response["errores"]["mensajeerror"][i];
                      content+="<br>";
                };
               $(".spinner").hide();

                mostrarMensaje(content);
                grecaptcha.reset();
            };
            
          },
          error: function(jqXHR, textStatus, errorThrown) {
             console.log(textStatus, errorThrown);
          }
        });

    }else{
        $(".spinner").hide();
        mostrarMensaje("Verifique los campos con errores");
        grecaptcha.reset();
    };


} 


/* Limpiar Formulario
=============================================*/

function limpiarFormulario(elemento){

    $(".spinner").hide();

    var nombreformulario=$(elemento).attr("data-formulario");

    $( "#"+nombreformulario+" .form-control" ).each(function( index ) {

        borrarError($(this));


        if ($(this).attr("tagName")=="textarea") {
            $(this).text("");
        }else if ($(this).attr("tagName")=="input"){
            $(this).val("");
        };

    });    

} 

/* Limpiar Alert
=============================================*/


function limpiarAlert(){
    $(".alert").removeClass("alert-success");
    $(".alert").removeClass("alert-danger");
    $(".alert").html("");

}

/* Bloquear botón
=============================================*/

function bloquearBoton(elemento){
    $(elemento).attr("disabled", true);
    $(elemento).bind('click', false);    
}

/* Desbloquear botón
=============================================*/

function desbloquearBoton(elemento){
    $(elemento).removeAttr("disabled");
    $(elemento).unbind('click', false);    
}

/* Restaurar Contraseña
=============================================*/


function restaurarContrasena(elemento){

    var email=$("#olvide-contrasena-email").val();

    var contenidoOriginal=$(elemento).html();
    $(elemento).html('<i class="fa fa-spinner fa-pulse fa-fw"></i> Restaurar Contraseña');
    bloquearBoton(elemento);


    var accion="restaurarcontrasena";
    var email=$("#olvide-contrasena-email").val();

    $.ajax({
        url: "./api/api.php",
        type: "get",
        //crossDomain: true,
        data: {accion:accion, email:email},
        dataType: "json",
        success: function (response) {
            if (response["error"]==false) {
                $("#olvide-contrasena").modal('hide');
                mostrarMensaje(response["exito"]);
                
                $(elemento).html(contenidoOriginal);
                desbloquearBoton(elemento);                                             
            }else{
                var content="";         
                for (var i = 0; i < Object.keys(response["errores"]["coderror"]).length; i++) {
                      content+=response["errores"]["mensajeerror"][i];
                      content+="<br>";
                  };
                $(elemento).popover({
                    content:content,
                    html:true,
                    trigger:"click",
                    placement:"bottom",
                    delay: { "show": 100, "hide": 100 }
                })
                $(elemento).popover('toggle')
                
                setTimeout(function(){  
                    $(elemento).html(contenidoOriginal);
                    desbloquearBoton(elemento);                                
                },300);

            };
        },
        error: function(jqXHR, textStatus, errorThrown) {
           console.log(textStatus, errorThrown);
        }
    });

}


/* Mostrar Mensaje
=============================================*/

function mostrarMensaje(mensaje,accioncerrar){    
    $('#modal-mensajes').modal('toggle');
    $('#modal-mensajes').attr("data-accion-cerrar",accioncerrar);
    $('#modal-mensaje-texto').html(mensaje);
}

$('#modal-mensajes').on('hidden.bs.modal', function (e) {
    var accioncerrar=$(this).attr("data-accion-cerrar");
    eval(accioncerrar);
})


function volverhome(){
    window.location.href = "index.php";
}

function invitarlogin(){
    window.location.href = "registro.php"; 
}

/* Bug fix modal
=============================================*/

$('.modal').on('hidden.bs.modal', function (e) {
    $("body").css("padding-right",0);
})

/* Contraseña
=============================================*/

var delay = (function(){
  var timer = 0;
  return function(callback, ms){
    clearTimeout (timer);
    timer = setTimeout(callback, ms);
  };
})();


function comprobarContrasena(elemento){

    var accion="seguridad-password";
    var password=$(elemento).val();

    $.ajax({
        url: "./api/api.php",
        type: "get",
        //crossDomain: true,
        data: {accion:accion, password:password},
        dataType: "json",
        success: function (response) {
            if (response["error"]==false) {
                content=response["exito"];
                $(elemento).addClass("inputexito");
                $(elemento).parent("div").find(".help-block").html(content);
                $(elemento).parent("div").find(".help-block").removeClass("error").removeClass("exito").removeClass("info");
                $(elemento).parent("div").find(".help-block").addClass("exito").show();                                                            
            }else{
                var content="";         
                for (var i = 0; i < Object.keys(response["errores"]["coderror"]).length; i++) {
                      content+=response["errores"]["mensajeerror"][i];
                      content+="<br>";
                  };
                
                $(elemento).addClass("inputerror");
                $(elemento).parent("div").find(".help-block").html(content);
                $(elemento).parent("div").find(".help-block").removeClass("error").removeClass("exito").removeClass("info");
                $(elemento).parent("div").find(".help-block").addClass("error").show();
            };
        },
        error: function(jqXHR, textStatus, errorThrown) {
           console.log(textStatus, errorThrown);
        }
    });
}

function comprobarRepetirContrasena(elemento){

    var password=$("#contrasena").val();
    var repetirpassword=$(elemento).val();

    if (repetirpassword==password) {
        $(elemento).addClass("inputexito");
        $(elemento).parent("div").find(".help-block").html("La contraseña es Correcta");
        $(elemento).parent("div").find(".help-block").removeClass("error").removeClass("exito").removeClass("info");
        $(elemento).parent("div").find(".help-block").addClass("exito").show();                                                            
    }else{       
        $(elemento).addClass("inputerror");
        $(elemento).parent("div").find(".help-block").html("La contraseña no Coincide");
        $(elemento).parent("div").find(".help-block").removeClass("error").removeClass("exito").removeClass("info");
        $(elemento).parent("div").find(".help-block").addClass("error").show();
    };
}

$("#contrasena").keyup(function(){
    var elemento=$(this);

    $(elemento).removeClass("inputerror");
    $(elemento).parent("div").find(".help-block").empty();
    $(elemento).parent("div").find(".help-block").removeClass("error").removeClass("exito");
    $(elemento).parent("div").find(".help-block").addClass("info").show();    
    $(elemento).parent("div").find(".help-block").html("Procesando..");

    delay(function(){
        comprobarContrasena($(elemento));
    }, 500);

})


$("#repetir-contrasena").keyup(function(){
    var elemento=$(this);

    $(elemento).removeClass("inputerror");
    $(elemento).parent("div").find(".help-block").empty();
    $(elemento).parent("div").find(".help-block").removeClass("error").removeClass("exito");
    $(elemento).parent("div").find(".help-block").addClass("info").show();    
    $(elemento).parent("div").find(".help-block").text("Procesando..");

    delay(function(){
        comprobarRepetirContrasena($(elemento));
    }, 500);

})


/* Newsletter
=============================================*/

function suscribirsenewsletter(elemento){

    var email=$(elemento).parents("div").find("#newsletter").val();

    var contenidoOriginal=$(elemento).html();
    $(elemento).html('<i class="fa fa-spinner fa-pulse fa-fw"></i> SUSCRIBIRSE');
    bloquearBoton(elemento);


    var accion="suscribirse-newsletter";

    $.ajax({
        url: "./api/api.php",
        type: "get",
        //crossDomain: true,
        data: {accion:accion, email:email},
        dataType: "json",
        success: function (response) {
            if (response["error"]==false) {
                mostrarMensaje(response["exito"],"volverhome()");
                $(elemento).html(contenidoOriginal);
                desbloquearBoton(elemento);
                $(elemento).parents("div").find("#newsletter").val("");                                        
            }else{
                var content="";         
                for (var i = 0; i < Object.keys(response["errores"]["coderror"]).length; i++) {
                      content+=response["errores"]["mensajeerror"][i];
                      content+="<br>";
                  };
                $(elemento).popover({
                    content:content,
                    html:true,
                    trigger:"click",
                    placement:"bottom",
                    delay: { "show": 100, "hide": 100 }
                })
                $(elemento).popover('toggle')
                
                setTimeout(function(){  
                    $(elemento).html(contenidoOriginal);
                    desbloquearBoton(elemento);                                
                },300);

            };
        },
        error: function(jqXHR, textStatus, errorThrown) {
           console.log(textStatus, errorThrown);
        }
    });    
    
}


/* Filtros Productos
=============================================*/

function rangoprecios(elemento){
    $(elemento).parent("div").find("label .label-valor").text($(elemento).val());
    $("#precio-minimo").attr("max",$("#precio-maximo").val());
    $("#precio-maximo").attr("min",$("#precio-minimo").val());

    delay(function(){
        filtrarProductos($(elemento));
    }, 1000);            
}

function seleccionamarca(elemento){
    filtrarProductos(elemento);
}

function cambiaorden(elemento){
    filtrarProductos(elemento);
}

function seleccionaLinea(){
    window.location = $("#lineas option:selected" ).attr("data-link");
}

function filtrarProductos(elemento){

    var favoritos=$("#favoritos").val();

    var accion="configuracion";

    $.ajax({
        url: "./api/api.php",
        type: "get",
        //crossDomain: true,
        data: {accion:accion},
        dataType: "json",
        success: function (response) {
            
            var filtros={};
            for (var i = 0; i < Object.keys(response["productos"]["filtros"]).length; i++) {
                filtros[response["productos"]["filtros"][i]["id"]]=$("#"+response["productos"]["filtros"][i]["id"]).val();
            };
            if ($("#formasordenamiento").length) {
                var ordenamiento=$("#formasordenamiento").val();
            }else{
                var ordenamiento=0;
            };

            if ($(elemento).attr("id")!="cargarmas") {
                var offset=0;
            }else{
                var offset=$(".productos-contenedor").length;
            };
            mostrarProductos(filtros,ordenamiento,offset,favoritos);
        },
        error: function(jqXHR, textStatus, errorThrown) {
           console.log(textStatus, errorThrown);
        }
    });     
}

function mostrarProductos(filtros,ordenamiento,offset,favoritos){

    $loading.show();
    $(".cargarmas a").html('<i class="fa fa-spinner fa-pulse fa-fw"></i> Cargando...');
    $(".cargarmas a").attr("disabled", true);
    $(".cargarmas a").bind('click', false);    
    
    accion="productos";
    
    $.ajax({
        url: "./api/api.php",
        type: "get",
        //crossDomain: true,
        data: {accion:accion, filtros:filtros, ordenamiento:ordenamiento, offset:offset, favoritos:favoritos},
        dataType: "json",
        success: function (response) {
            if (offset==0) {
                $("#productos-contenedor .panel-group").empty();
            };

            if (response["error"]==false) {

                if (localStorage.getItem("trama_solutions_ecommerce_mostrarproducto")=="grilla") {
                    var mostrar="grilla";
                }else if(localStorage.getItem("trama_solutions_ecommerce_mostrarproducto")=="lista"){
                    var mostrar="lista";
                }else{
                    var mostrar=response["adicionales"]["mostrardefault"];
                };
                

                for (var i = 0; i < Object.keys(response["exito"]).length; i++) {
                    var html="";
                    
                    html+='<div class="col-xs-12 ' +mostrar+ ' productos-contenedor producto panel" data-origen="principal" data-codigo-producto="'+response["exito"][i]["CodInternoArti"]+'" data-codigo-producto-atributo="">'
                    html+='<div class="productos-inner">'
                    html+='<div class="productos-contenedor-imagen col-sm-2 no-padding">'
                    html+='<img class="productos-imagen" onmouseover="aplicaElevateZoom(this)" src="'+response["adicionales"]["carpetaupload"]+response["exito"][i]["NombreFotoArti"]+'" style="display:none" alt="">'
                    html+='<div class="spinner-producto">'
                    html+='<i class="fa fa-spinner fa-pulse fa-fw"></i>'
                    html+='</div>'
                    html+='</div>'
                    html+='<div class="col-xs-10 productos-contenedor-detalles no-padding">'
                    html+='<div class="col-md-6 col-sm-5 productos-titulo mayuscula">'
                        if (response["adicionales"] ["detallemodal"]==true) {
                            html+='<a onclick="mostrarProducto('+"'"+response["exito"][i]["CodInternoArti"]+"'"+')" href="javascript:void(0)">'
                            html+='<h5>'+response["exito"][i]["DescripcionArti"]+'</h5>'
                            html+='</a>'
                            html+='<a class="btn btn-default btn-sm" onclick="mostrarProducto('+"'"+response["exito"][i]["CodInternoArti"]+"'"+')" href="javascript:void(0)">'
                            html+='Ver Más...'
                            html+='</a>'           
                        }else{
                            html+='<h5>'+response["exito"][i]["DescripcionArti"]+'</h5>'                            
                        };
                    html+='</div>'                           
                    html+='<div class="col-md-3 col-sm-4 cl-color-1 productos-precio">'
                    if (Object.keys(response["exito"][i]["atributos"]).length>0) {
                        html+='<h3><span style="font-size:10pt">'+ response["exito"][i]["palabraminimo"]+' </span><span style="white-space: nowrap">'+response["exito"][i]["minimo"]+'</span></h3>'                    
                    }else{
                        html+='<h3>'+response["exito"][i]["PrecioVta1_PreArti"]+'</h3>'
                    }                    
                    html+='</div>'
                    html+='<div class="col-md-3 col-sm-3 productos-controles">'
                    
                    if (Object.keys(response["exito"][i]["atributos"]).length>0) {
                        html+='<div class="text-center input-group">';
                        html+='<a style="width:100%" class="btn btn-danger" onclick="mostrarProducto('+"'"+response["exito"][i]["CodInternoArti"]+"'"+')" href="javascript:void(0)">';
                        html+='<h6 style="margin:4px"><i class="fa fa-filter" aria-hidden="true"></i> Seleccione</h6>';
                        html+='</a>';
                        html+='</div>';
                    }else{
                        html+='<div class="input-group">'
                            if (response["adicionales"]["comprarsinexistencia"]===false) {
                                if (response["exito"][i]["Stock1_StkArti"]>0) {
                                    html+='<input onchange="valorCantidad(this)" id="cantidad-pedida" name="" class="form-control" placeholder="" type="number" min="1" max="'+parseFloat(response["exito"][i]["Stock1_StkArti"]+1)+'" value="1">'
                                    html+='<span class="input-group-addon"><a onclick="agregarCesta(this)" class="btn btn-danger" href="javascript:void(0);"><i class="fa fa-cart-plus" aria-hidden="true"></i></a></span>'
                                }else{
                                    html+='<h4>'+response["adicionales"]["textosinexistencia"]+'</h4>';
                                };
                            }else{
                                if (response["adicionales"]["avisopocaexistencia"]===true) {
                                    if (parseFloat(response["exito"][i]["Stock1_StkArti"])<response["adicionales"]["cantidadpocaexistencia"]) {
                                        html+='<input onchange="valorCantidad(this)" id="cantidad-pedida" name="" class="form-control" placeholder="" type="number" min="1" max="9999999" value="1">'
                                        html+='<span class="input-group-addon"><a onclick="agregarCesta(this)" class="btn btn-danger" href="javascript:void(0);"><i class="fa fa-cart-plus" aria-hidden="true"></i></a></span>'
                                        html+='</div>'
                                        html+='<div>'
                                        html+='<h6 class="cl-color-1">'+response["adicionales"]["textopocaexistencia"]+'</h6>'
                                    }else{
                                        html+='<input onchange="valorCantidad(this)" id="cantidad-pedida" name="" class="form-control" placeholder="" type="number" min="1" max="999999" value="1">'
                                        html+='<span class="input-group-addon"><a onclick="agregarCesta(this)" class="btn btn-danger" href="javascript:void(0);"><i class="fa fa-cart-plus" aria-hidden="true"></i></a></span>'
                                    };                                    
                                }else{
                                    html+='<input onchange="valorCantidad(this)" id="cantidad-pedida" name="" class="form-control" placeholder="" type="number" min="1" max="999999" value="1">'
                                    html+='<span class="input-group-addon"><a onclick="agregarCesta(this)" class="btn btn-danger" href="javascript:void(0);"><i class="fa fa-cart-plus" aria-hidden="true"></i></a></span>'
                                };
                            };
                        html+='</div>'                                          
                    }                     
                        html+='<div class="contenedor-favoritos">'
                            if (response["exito"][i]["id"]=="") {
                                html+='<h6><a class="favoritos" onclick="agregarFavoritos(this)" href="javascript:void(0);"><i class="fa fa-heart" aria-hidden="true"></i> Agregar a favoritos</a></h6>'
                            }else{
                                html+='<h6><a class="favoritos" onclick="borrarFavoritos(this)" href="javascript:void(0);"><i class="fa fa-trash-o fa-fw"></i> Eliminar de Favoritos</a></h6>'                            
                            };
                        html+='</div>'                          
                    html+='</div>'                                           
                    html+='<div class="col-md-6 contenedor-descripcion text-justify">'
                    html+='# '+response["exito"][i]["CodInternoArti"]
                    html+='<br>'
                    html+='Referencia: '+response["exito"][i]["CodBarraArti"]
                    html+='</div>'
                    html+='</div>'
                    html+='</div>'
                    html+='</div>'

                $("#productos-contenedor .panel-group").append(html);

                if (response["limit"]==true) {
                    $(".cargarmas a").html("No hay más productos");
                }else{
                    $(".cargarmas a").html("Cargar Más Productos");
                    desbloquearBoton($(".cargarmas a"));                
                };


                if ($(".productos-contenedor").hasClass("grilla")) {
                   productosMostrarGrilla(); 
                }else{
                    productosMostrarLista();    
                };

                };

                
                 $('.productos-contenedor').waitForImages(function() {
                    if ($(".productos-contenedor").hasClass("grilla")) {
                       $(".spinner-producto").hide();
                       $(".productos-imagen").show();
                       productosMostrarGrilla();
                    }else{
                        $(".spinner-producto").hide();
                        $(".productos-imagen").show();
                        productosMostrarLista();    
                    };             
                });
                
            }else{
                $(".cargarmas a").html(response["errores"]["mensajeerror"][0]);
            };


        },
        error: function(jqXHR, textStatus, errorThrown) {
           console.log(textStatus, errorThrown);
        }
    });    
}

/* Producto
=============================================*/

function mostrarProducto(codigo){

    var accion="productos";
    var filtros={
        marca:"",
        linea:"",
        descripcion:"",
        codigo:codigo,
        categoria:""            
    }
    var ordenamiento=0;
    var offset=0;
    var favoritos=false;

    $.ajax({
        url: "./api/api.php",
        type: "get",
        //crossDomain: true,
        data: {accion:accion, filtros:filtros, ordenamiento:ordenamiento, offset:offset, favoritos:favoritos},
        dataType: "json",
        success: function (response) {
            $("#producto-contenedor").empty();
            $("#modalproducto .modal-body").empty();
            $("#modalproducto .modal-title").empty();
            $("#modalproducto .modal-title").append(response["exito"][0]["DescripcionArti"]);         

            var html='';

            html+='<h3 class="bold titulo">Detalle del Producto</h3>'          
            html+='<div class="col-xs-12 no-padding producto" id="producto" data-origen="principal" data-codigo-producto="'+ response["exito"][0]["CodInternoArti"]+'" data-codigo-producto-atributo="">'
            html+='<div class="productos-inner">'
            html+='<div class="col-sm-4 no-padding">'
            html+='<img class="productos-imagen" onmouseover="aplicaElevateZoom(this)" src="'+ response["adicionales"]["carpetaupload"]+response["exito"][0]["NombreFotoArti"]+'" alt="">'
            html+='</div>'
            html+='<div class="col-xs-8">'
            html+='<div class="mayuscula">'
            html+='<h1>'+ response["exito"][0]["DescripcionArti"]+'</h1>'
            html+='</div>'
            html+='<div class="cl-color-1">'
            if (Object.keys(response["exito"][0]["atributos"]).length>0) {
                html+='<h3><span style="font-size:10pt">'+ response["exito"][0]["palabraminimo"]+'</span><span style="white-space: nowrap">'+ response["exito"][0]["minimo"]+'</span></h3>'
            }else{
                html+='<h3>'+ response["exito"][0]["PrecioVta1_PreArti"]+'</h3>'
            }
            html+='</div>'
            html+='<div class="">'
            if (Object.keys(response["exito"][0]["atributos"]).length>0) {
                html+='<h6>Seleccione los siguientes atributos para continuar con la compra</h6>';
                
                $.each(response["exito"][0]["atributos"], function(key, value) {

                    html+='<div class="form-group">';
                    html+='<label class="cotrol-label mayuscula" for="tipo-cliente">'+ key +'</label>';
                    html+='<div class="">';
                    html+='<select onchange="seleccionaAtributo(this)" id="atributo-'+ value[0]["idtipoarticulo"] +'" class="form-control atributo" data-orden-atributo="'+value[0]["orden"]+'">';
                    html+='<option value="0">Seleccione '+ value[0]["nombreatributo"] +'</option>';
                    for (var i = 0; i < Object.keys(value).length; i++) {
                        html+='<option value="'+ value[i]["id"] +'">'+ value[i]["valor"] +'</option>';
                    }                  
                    html+='</select>'
                    html+='</div>'
                    html+='</div>'
                });
                html+='<div id="panel-comprar-atributos">'
                html+='</div>'                                          
            }else{
                html+='<div class="input-group">'
                if (response["exito"][0]["Stock1_StkArti"]>0) {
                    html+='<input onchange="valorCantidad(this)" id="cantidad-pedida" name="" class="form-control" placeholder="" type="number" min="1" max="'+ response["exito"][0]["Stock1_StkArti"]+1+'" value="1">'
                    html+='<span class="input-group-addon"><a onclick="agregarCesta(this)" class="btn btn-danger" href="javascript:void(0);"><i class="fa fa-cart-plus" aria-hidden="true"></i></a></span>'
                }else{
                    html+='<h4>'+ response["adicionales"]["textosinexistencia"]+'</h4>'
                };
                html+='</div>'
            }                     
            html+='<div>'
            if (response["exito"][0]["id"]=="") {
                html+='<h6><a class="favoritos" onclick="agregarFavoritos(this)" href="javascript:void(0);"><i class="fa fa-heart" aria-hidden="true"></i> Agregar a favoritos</a></h6>'
            }else{
                html+='<h6><a class="favoritos" onclick="borrarFavoritos(this)" href="javascript:void(0);"><i class="fa fa-trash-o fa-fw"></i> Eliminar de Favoritos</a></h6>'
            };                
            html+='</div>'
            html+='</div>'                                          
            html+='<div class="text-justify">'
            html+='# '+ response["exito"][0]["CodInternoArti"]
            html+='<br>'
            html+='Referencia: '+ response["exito"][0]["CodBarraArti"]
            html+='</div>'
            html+='</div>'
            html+='</div>'
            html+='</div>'

            if (response["adicionales"]["detalleproducto"]["mostrardetalle"]===true) {
                html+='<div class="row col-xs-12 detalleproducto">'
                html+='<ul class="nav nav-tabs" role="tablist">'
                    if (response["adicionales"]["detalleproducto"]["descripcion"]===true) {
                        html+='<li role="presentation" class="sin-borde"><a href="#desc" aria-controls="descripcion" role="tab" data-toggle="tab">Descripción</a></li>'
                    };
                html+='</ul>'
                html+='<div class="tab-content">'
                    if (response["adicionales"]["detalleproducto"]["descripcion"]===true) {
                        html+='<div role="tabpanel" class="tab-pane borde" id="desc">'
                        html+=response["exito"][0]["detalle"];
                        html+='</div>'
                    };                                   
                html+='</div>'
                html+='</div>'

            };

            $("#producto-contenedor").append(html);
            $("#modalproducto .modal-body").append(html);

            $(".nav-tabs li:first-child").addClass("active");
            $(".tab-content .tab-pane:first-child").addClass("active");            

            $('#modalproducto').modal();           
            
        },
        error: function(jqXHR, textStatus, errorThrown) {
           console.log(textStatus, errorThrown);
        }
    });


}

/* Selecciona Atributo
=============================================*/

function seleccionaAtributo(elemento){
    
    var codigo=$(elemento).parents("#producto").attr("data-codigo-producto");
    var atributos={}; 

    $(".atributo").each(function(index) {
        atributos[parseInt($(this).attr("data-orden-atributo"))]=$(this).val();
    });

    var accion="precio-por-atributo";

    $.ajax({
        url: "./api/api.php",
        type: "get",
        //crossDomain: true,
        data: {accion:accion, codigo:codigo, atributos:atributos},
        dataType: "json",
        success: function (response) {

            $("#panel-comprar-atributos").empty();

            if (response["error"]==false) {

            var html='';
            html+='<div class="cl-color-1">'
            html+='<h3>'+ response["exito"][0]["precio"]+'</h3>'
            html+='</div>'
            html+='<div class="input-group">'
            if (response["exito"][0]["stock"]>0) {
                html+='<input onchange="valorCantidad(this)" id="cantidad-pedida" name="" class="form-control" placeholder="" type="number" min="1" max="'+ response["exito"][0]["stock"]+1+'" value="1">'
                html+='<span class="input-group-addon"><a onclick="agregarCesta(this)" class="btn btn-danger" href="javascript:void(0);"><i class="fa fa-cart-plus" aria-hidden="true"></i></a></span>'
            }else{
                html+='<h4>'+ response["adicionales"]["textosinexistencia"]+'</h4>'
            };
            html+='</div>'

            $(elemento).parents(".producto").attr("data-codigo-producto-atributo",response["exito"][0]["id"]);

            $("#panel-comprar-atributos").append(html);
                
            };
            
        },
        error: function(jqXHR, textStatus, errorThrown) {
           console.log(textStatus, errorThrown);
        }
    });


}

/* Favoritos
=============================================*/

function favoritosLateral(){

    accion="favoritos-lateral";
    
    $.ajax({
        url: "./api/api.php",
        type: "get",
        //crossDomain: true,
        data: {accion:accion},
        dataType: "json",
        success: function (response) {
            $("#mensajes-panel-favoritos").empty();
            if (response["error"]==false) {

                $("#contenedor-panel-favoritos").empty();

                for (var i = 0; i < Object.keys(response["exito"]).length; i++) {
                    var html="";
                    html+='<div class="row lista producto panel" data-origen="menulateral" data-codigo-producto="'+response["exito"][i]["CodInternoArti"]+'">'
                    html+='<div style="background-image:url('+"'"+response["adicionales"]["carpetaupload"]+response["exito"][i]["NombreFotoArti"]+"'"+')" class="panel-favoritos-imagen col-xs-4">'
                    html+='</div>'
                    html+='<div class="col-xs-8 text-left">'
                    html+='<a type="button" onclick="borrarFavoritos(this)" class="close"><span>&times;</span></a>'
                    html+='<a data-toggle="modal" data-target="#modalproducto" href="#"><h6>'+response["exito"][i]["DescripcionArti"]+'</h6></a>'                   
                    html+='<h6 class="cl-color-1">'+response["exito"][i]["PrecioVta1_PreArti"]+'</h6>'                   
                    html+='</div>'
                    html+='</div>'

                    $("#contenedor-panel-favoritos").append(html);
                };
                $("#mensajes-panel-favoritos").append('<a class="text-center mayuscula btn btn-danger" href="productos.php?categoria=&favoritos=true">Ver Más</a>');
            }else{
                $("#mensajes-panel-favoritos").append(response["errores"]["mensajeerror"][0]);
            };

        },
        error: function(jqXHR, textStatus, errorThrown) {
           console.log(textStatus, errorThrown);
        }
    });       

}

function agregarFavoritos(elemento){
    var codigo=$(elemento).parents(".producto").attr("data-codigo-producto");
    var contenidoOriginal=$(elemento).html();
    var origen=$(elemento).parents(".producto").attr("data-origen");
    var funcionOriginal=$(elemento).attr("onclick");
    
    $(elemento).html('<i class="fa fa-spinner fa-pulse fa-fw"></i> Agregando...');
    $(elemento).attr("disabled", true);
    $(elemento).bind('click', false);
    $(elemento).removeAttr('onclick');
    
    var accion="agregar-favoritos";

    $.ajax({
        url: "./api/api.php",
        type: "get",
        //crossDomain: true,
        data: {accion:accion, codigo:codigo},
        dataType: "json",
        success: function (response) {
            if (response["error"]==true) {
                var errores="";
                for (var i = 0; i < Object.keys(response["errores"]["coderror"]).length; i++) {
                    errores+=response["errores"]["mensajeerror"][i]+'<br>';
                }
                mostrarMensaje(errores,"invitarlogin()");
                $(elemento).html(contenidoOriginal);
                $(elemento).removeAttr("disabled");
                $(elemento).unbind("click");                
                $(elemento).attr("onclick",funcionOriginal);
            }else{
                $(elemento).html('<i class="fa fa-trash-o fa-fw"></i> Eliminar de Favoritos');
                $(elemento).attr("onclick","borrarFavoritos(this)");
                favoritosLateral();                            
            };
        },
        error: function(jqXHR, textStatus, errorThrown) {
           console.log(textStatus, errorThrown);
        }
    });     
}


function borrarFavoritos(elemento){
    var codigo=$(elemento).parents(".producto").attr("data-codigo-producto");
    var contenidoOriginal=$(".producto[data-origen='principal'][data-codigo-producto='"+codigo+"'] .favoritos").html();
    var origen=$(elemento).parents(".producto").attr("data-origen");    
    var funcionOriginal=$(elemento).attr("onclick");
    $(".producto[data-origen='principal'][data-codigo-producto='"+codigo+"'] .favoritos").html('<i class="fa fa-spinner fa-pulse fa-fw"></i> Eliminando...');
    $(".producto[data-origen='principal'][data-codigo-producto='"+codigo+"'] .favoritos").attr("disabled", true);
    $(".producto[data-origen='principal'][data-codigo-producto='"+codigo+"'] .favoritos").bind('click', false);
    $(".producto[data-origen='principal'][data-codigo-producto='"+codigo+"'] .favoritos").removeAttr('onclick');
    $("#panel-favoritos .producto[data-origen='menulateral'][data-codigo-producto='"+codigo+"'] .close").removeAttr('onclick');
    
    var accion="borrar-favoritos";

    $.ajax({
        url: "./api/api.php",
        type: "get",
        //crossDomain: true,
        data: {accion:accion, codigo:codigo},
        dataType: "json",
        success: function (response) {
            if (response["error"]==true) {
                var errores="";
                for (var i = 0; i < Object.keys(response["errores"]["coderror"]).length; i++) {
                    errores+=response["errores"]["mensajeerror"][i]+'<br>';
                }
                mostrarMensaje(errores);
                $(".producto[data-origen='principal'][data-codigo-producto='"+codigo+"'] .favoritos").html(contenidoOriginal);
                $(".producto[data-origen='principal'][data-codigo-producto='"+codigo+"'] .favoritos").attr("onclick",funcionOriginal);
                $("#panel-favoritos .producto[data-origen='menulateral'][data-codigo-producto='"+codigo+"'] .close").attr("onclick",funcionOriginal);
            }else{
                $(".producto[data-origen='principal'][data-codigo-producto='"+codigo+"'] .favoritos").html('<i class="fa fa-heart fa-fw"></i> Agregar a favoritos');
                $(".producto[data-origen='principal'][data-codigo-producto='"+codigo+"'] .favoritos").attr("onclick","agregarFavoritos(this)");                            
                $("#panel-favoritos .producto[data-origen='menulateral'][data-codigo-producto='"+codigo+"']").remove();
                favoritosLateral();
            };
        },
        error: function(jqXHR, textStatus, errorThrown) {
           console.log(textStatus, errorThrown);
        }
    });     
}


/* Favoritos
=============================================*/

function agregarCesta(elemento){

    var codigo=$(elemento).parents(".producto").attr("data-codigo-producto");
    var codigoProductoAtributo=$(elemento).parents(".producto").attr("data-codigo-producto-atributo");
    var cantidad=$(elemento).parents(".producto").find("#cantidad-pedida").val();
    var contenidoOriginal=$(elemento).html();
    var funcionOriginal=$(elemento).attr("onclick");
    $(elemento).html('<i class="fa fa-spinner fa-pulse fa-fw"></i>');
    $(elemento).attr("disabled", true);
    $(elemento).bind('click', false);
    $(elemento).removeAttr('onclick');
    
    var accion="agregar-cesta";

    $.ajax({
        url: "./api/api.php",
        type: "get",
        //crossDomain: true,
        data: {accion:accion, codigo:codigo, cantidad:cantidad, codigoProductoAtributo:codigoProductoAtributo},
        dataType: "json",
        success: function (response) {
            if (response["error"]==true) {
                var errores="";
                for (var i = 0; i < Object.keys(response["errores"]["coderror"]).length; i++) {
                    errores+=response["errores"]["mensajeerror"][i]+'<br>';
                }
                mostrarMensaje(errores,"invitarlogin()");
                $(elemento).html(contenidoOriginal);
                $(elemento).removeAttr("disabled");
                $(elemento).unbind("click");                
                $(elemento).attr("onclick",funcionOriginal);
            }else{
                $(elemento).html('<i class="fa fa-check fa-fw"></i>');
                $(elemento).removeClass("btn-danger");
                $(elemento).addClass("btn-success");
                cestaLateral();
                contadorCesta();
                setTimeout(function(){  
                    $(elemento).html(contenidoOriginal);
                    $(elemento).removeClass("btn-success");                    
                    $(elemento).addClass("btn-danger");
                    $(elemento).removeAttr("disabled");
                    $(elemento).unbind("click");                    
                    $(elemento).attr("onclick","agregarCesta(this)");                            
                },1000);                

            };
        },
        error: function(jqXHR, textStatus, errorThrown) {
           console.log(textStatus, errorThrown);
        }
    });     
}


function borrarCesta(elemento){
    var codigo=$(elemento).parents(".producto").attr("data-codigo-producto");
    var codigoProductoAtributo=$(elemento).parents(".producto").attr("data-codigo-producto-atributo");
    var origen=$(elemento).parents(".producto").attr("data-origen");    
    var funcionOriginal=$(elemento).attr("onclick");
    $("#panel-cesta .producto[data-origen='menulateral'][data-codigo-producto='"+codigo+"'][data-codigo-producto-atributo='"+codigoProductoAtributo+"'] .close").removeAttr('onclick');
    
    var accion="borrar-cesta";

    $.ajax({
        url: "./api/api.php",
        type: "get",
        //crossDomain: true,
        data: {accion:accion, codigo:codigo, codigoProductoAtributo:codigoProductoAtributo},
        dataType: "json",
        success: function (response) {
            if (response["error"]==true) {
                var errores="";
                for (var i = 0; i < Object.keys(response["errores"]["coderror"]).length; i++) {
                    errores+=response["errores"]["mensajeerror"][i]+'<br>';
                }
                mostrarMensaje(errores);
                $("#panel-cesta .producto[data-origen='menulateral'][data-codigo-producto='"+codigo+"'][data-codigo-producto-atributo='"+codigoProductoAtributo+"'] .close").attr("onclick",funcionOriginal);
            }else{                           
                $("#panel-cesta .producto[data-origen='menulateral'][data-codigo-producto='"+codigo+"'][data-codigo-producto-atributo='"+codigoProductoAtributo+"']").remove();
                $("#cesta .producto[data-origen='menulateral'][data-codigo-producto='"+codigo+"'][data-codigo-producto-atributo='"+codigoProductoAtributo+"']").remove();                
                $("#mis-pedidos .producto[data-codigo-producto='"+codigo+"'][data-codigo-producto-atributo='"+codigoProductoAtributo+"']").remove();                                
                cestaLateral();
                contadorCesta();
                miCarrito();
            };
        },
        error: function(jqXHR, textStatus, errorThrown) {
           console.log(textStatus, errorThrown);
        }
    });     
}
function cestaLateral(){

    accion="cesta-lateral";
    
    $.ajax({
        url: "./api/api.php",
        type: "get",
        //crossDomain: true,
        data: {accion:accion},
        dataType: "json",
        success: function (response) {
            $("#mensajes-panel-cesta").empty();
            $("#cesta").empty();
            if (response["error"]==false) {

                $("#contenedor-panel-cesta").empty();

                for (var i = 0; i < Object.keys(response["exito"]).length; i++) {
                    var html="";
                    html+='<div class="row lista producto panel" data-origen="menulateral" data-codigo-producto="'+response["exito"][i]["CodInternoArti"]+'" data-codigo-producto-atributo ="'+response["exito"][i]["idArticulosValores"]+'">'
                    html+='<div style="background-image:url('+"'"+response["adicionales"]["carpetaupload"]+response["exito"][i]["NombreFotoArti"]+"'"+')" class="panel-favoritos-imagen col-xs-4">'
                    html+='</div>'
                    html+='<div class="col-xs-8 text-left">'
                    html+='<a type="button" onclick="borrarCesta(this)" class="close"><span>&times;</span></a>'
                    html+='<a data-toggle="modal" data-target="#modalproducto" href="#"><h6>'+response["exito"][i]["DescripcionArti"]+'<strong> '+response["exito"][i]["valor1"]+' '+response["exito"][i]["valor2"]+response["exito"][i]["valor3"]+' '+response["exito"][i]["valor4"]+' '+response["exito"][i]["valor5"]+' '+response["exito"][i]["valor6"]+' '+response["exito"][i]["valor7"]+' '+response["exito"][i]["valor8"]+' '+response["exito"][i]["valor9"]+'</strong>'+'</h6></a>'                   
                    html+='<h6 class="cl-color-1">'+response["exito"][i]["precio"]+'</h6>'                   
                    html+='</div>'
                    html+='</div>'                                        

                    $("#contenedor-panel-cesta").append(html);

                    $("#cesta").append(html);
                };
                $("#cesta").append('<a class="text-center mayuscula btn btn-danger" href="carrito.php">Ver Más</a>');
                $("#mensajes-panel-cesta").append('<a class="text-center mayuscula btn btn-danger" href="carrito.php">Ver Más</a>');

            }else{
               
               $("#cesta").append(response["errores"]["mensajeerror"][0]);
               $("#mensajes-panel-cesta").append(response["errores"]["mensajeerror"][0]);


            };

        },
        error: function(jqXHR, textStatus, errorThrown) {
           console.log(textStatus, errorThrown);
        }
    });       

}


/* Mis Pedidos
=============================================*/

function editarCantidad(elemento){

    var valorInicial=$(elemento).parents("tr").find(".cantidad").text();
    $(elemento).parents("tr").find(".cantidad").html('<input onkeypress="if (event.keyCode==13){ actualizarCantidad(this);return false;}" type="number" class="form-control input-sm" value="'+valorInicial+'">');
    $(elemento).parents("tr").find(".cantidad input").focus();
    var td=$(elemento).parent("td");
    td.empty();
    td.html('<span><a onclick="actualizarCantidad(this)"><i class="fa fa-check" aria-hidden="true"></i></a></span><span>   <a onclick="cancelarCantidad(this,'+valorInicial+')"><i class="fa fa-times" aria-hidden="true"></i></a></span>');

}

function cancelarCantidad(elemento,valorInicial){

    var td=$(elemento).parents("tr").find("td.editar");
    $(elemento).parents("tr").find(".cantidad").html(valorInicial);
    td.empty();
    td.html('<a onclick="editarCantidad(this)"><i class="fa fa-pencil" aria-hidden="true"></i></a>');

}

function actualizarCantidad(elemento){

    var cantidad = $(elemento).parents("tr").find(".cantidad input").val();
    var codigo = $(elemento).parents("tr").attr("data-codigo-producto");
    var codigoProductoAtributo=$(elemento).parents(".producto").attr("data-codigo-producto-atributo");

    var accion="actualizar-cesta";

    $.ajax({
        url: "./api/api.php",
        type: "get",
        //crossDomain: true,
        data: {accion:accion, codigo:codigo, cantidad:cantidad, codigoProductoAtributo:codigoProductoAtributo},
        dataType: "json",
        success: function (response) {
            if (response["error"]==true) {
                var errores="";
                for (var i = 0; i < Object.keys(response["errores"]["coderror"]).length; i++) {
                    errores+=response["errores"]["mensajeerror"][i]+'<br>';
                }
                mostrarMensaje(errores);
            }else{
                var nuevaCantidad=$(elemento).parents("tr").find(".cantidad input").val();
                var td=$(elemento).parents("tr").find("td.editar");
                $(elemento).parents("tr").find(".cantidad").html(nuevaCantidad);
                td.empty();
                td.html('<a onclick="editarCantidad(this)"><i class="fa fa-pencil" aria-hidden="true"></i></a>');
            };
        contadorCesta();
        miCarrito();
        },
        error: function(jqXHR, textStatus, errorThrown) {
           console.log(textStatus, errorThrown);
        }
    });
}

function miCarrito(){
    $(".spinner").show();

    var accion="carrito";

    $.ajax({
        url: "./api/api.php",
        type: "get",
        //crossDomain: true,
        data: {accion:accion},
        dataType: "json",
        success: function (response) {
            if (response["error"]==true) {
                var errores="";
                for (var i = 0; i < Object.keys(response["errores"]["coderror"]).length; i++) {
                    errores+=response["errores"]["mensajeerror"][i]+'<br>';
                }
                mostrarMensaje(errores);
                $(elemento).html(contenidoOriginal);
                $(elemento).attr("onclick",funcionOriginal);
            }else{
                $("#mis-pedidos tbody").empty();

                for (var i = 0; i < Object.keys(response["exito"]).length; i++) {
                    var html="";

                    html+='<tr class="producto" data-origen="listapedido" data-codigo-producto="'+response["exito"][i]["CodInternoArti"]+'" data-codigo-producto-atributo="'+response["exito"][i]["idArticulosValores"]+'">'
                    html+='<td>'
                    html+='<a onclick="borrarCesta(this)">'
                    html+='<i class="fa fa-trash-o" aria-hidden="true"></i>'
                    html+='</a>'
                    html+='</td>'
                    html+='<td class="editar">'
                    html+='<a onclick="editarCantidad(this)">'
                    html+='<i class="fa fa-pencil" aria-hidden="true"></i>'
                    html+='</a>'
                    html+='</td>'
                    html+='<td class="cantidad">'+response["exito"][i]["cantidad"]+'</td>'
                    html+='<td>'+response["exito"][i]["CodInternoArti"]+'</td>'                    
                    html+='<td>'+response["exito"][i]["DescripcionArti"]+'<strong> '+response["exito"][i]["valor1"]+' '+response["exito"][i]["valor2"]+response["exito"][i]["valor3"]+' '+response["exito"][i]["valor4"]+' '+response["exito"][i]["valor5"]+' '+response["exito"][i]["valor6"]+' '+response["exito"][i]["valor7"]+' '+response["exito"][i]["valor8"]+' '+response["exito"][i]["valor9"]+'</strong>'+'</td>'
                    html+='<td class="text-nowrap">'+response["exito"][i]["PrecioVta1_PreArti"]+'</td>'
                    html+='<td class="text-nowrap">'+response["exito"][i]["subtotal"]+'</td>'
                    if (response["adicionales"]["CalculaIvaC"] == 1 && response["adicionales"]["DiscriminaIvaC"] == 1) {
                        html+='<td class="text-nowrap">'+response["exito"][i]["iva"]+' (% '+response["exito"][i]["TasaIva"]+') </td>'
                    };                    
                    html+='</tr>'               

                    $("#mis-pedidos tbody").append(html);
                };

                var html="";

                html+='<tr class="bg-gray-5 cl-color-3"'
                html+='<td></td>'
                html+='<td></td>'
                html+='<td></td>'                
                html+='<td></td>'
                html+='<td></td>'                    
                html+='<td></td>'
                html+='<td class="bold">TOTAL</td>'
                html+='<td class="text-nowrap">'+response["adicionales"]["acumulado"]+'</td>'
                if (response["adicionales"]["CalculaIvaC"] == 1 && response["adicionales"]["DiscriminaIvaC"] == 1) {
                    html+='<td class="text-nowrap">'+response["adicionales"]["ivaacumulado"]+'</td>'
                };                    
                html+='</tr>'

                $("#mis-pedidos tbody").append(html);

                $(".spinner").hide();
            };

            seleccionaMediosEntrega();      

        },
        error: function(jqXHR, textStatus, errorThrown) {
           console.log(textStatus, errorThrown);
        }
    });    
}

function contadorCesta(){
    accion="contador-cesta";

    $.ajax({
        url: "./api/api.php",
        type: "get",
        //crossDomain: true,
        data: {accion:accion},
        dataType: "json",
        success: function (response) {
            if (response["error"]==true) {
                
            }else{
                $("#contador-cesta").text(response["exito"][0]["cantidad"]);
            };
        },
        error: function(jqXHR, textStatus, errorThrown) {
           console.log(textStatus, errorThrown);
        }
    });
}

function misPedidos(){
    $(".spinner").show();

    var accion="pedidos";

    $.ajax({
        url: "./api/api.php",
        type: "get",
        //crossDomain: true,
        data: {accion:accion},
        dataType: "json",
        success: function (response) {
            if (response["error"]==true) {
                var errores="";
                for (var i = 0; i < Object.keys(response["errores"]["coderror"]).length; i++) {
                    errores+=response["errores"]["mensajeerror"][i]+'<br>';
                }
                mostrarMensaje(errores);
                $(elemento).html(contenidoOriginal);
                $(elemento).attr("onclick",funcionOriginal);
            }else{
                $("#mis-pedidos tbody").empty();

                for (var i = 0; i < Object.keys(response["exito"]).length; i++) {
                    var html="";

                    html+='<tr data-codigo-pedido="'+response["exito"][i]["idPedido"]+'">'
                    if (response["exito"][i]["vencido"]==true) {
                        html+='<td><i class="fa fa fa-dot-circle-o blink" style="color:red" aria-hidden="true"></i></td>'                                        
                    }else{
                        html+='<td><i class="fa fa fa-dot-circle-o" style="color:green" aria-hidden="true"></i></td>'                                                                    
                    };
                    html+='<td>'
                    html+='<a onclick="verDetallePedido(this)">'
                    html+='<i class="fa fa-eye" aria-hidden="true"></i>'
                    html+=' Ver</a>'
                    html+='</td>'
                    html+='<td>'+response["exito"][i]["idPedido"]+'</td>'                    
                    html+='<td>'+response["exito"][i]["estado"]+'</td>'
                    html+='<td>'+response["exito"][i]["fechaEstado"]+'</td>'
                    html+='<td>'+response["exito"][i]["fechaFacturacion"]+'</td>'
                    if (response["exito"][i]["linkpdf"]!="") {
                        html+='<td><a target="_blank" href="'+response["exito"][i]["linkpdf"]+'">'+response["exito"][i]["factura"]+'</a></td>'                   
                    }else{
                        html+='<td>'+response["exito"][i]["factura"]+'</td>'
                    };                                          
                    html+='</tr>'               

                    $("#mis-pedidos tbody").append(html);
                };


                $(".spinner").hide();
            };
        },
        error: function(jqXHR, textStatus, errorThrown) {
           console.log(textStatus, errorThrown);
        }
    });
        
}

function verDetallePedido(elemento){

    $(".spinner").show();

    var idPedido=$(elemento).parents("tr").attr("data-codigo-pedido");

    var accion="detalle-pedido"

    $.ajax({
        url: "./api/api.php",
        type: "get",
        //crossDomain: true,
        data: {accion:accion, idPedido:idPedido},
        dataType: "json",
        success: function (response) {
            if (response["error"]==true) {
                var errores="";
                for (var i = 0; i < Object.keys(response["errores"]["coderror"]).length; i++) {
                    errores+=response["errores"]["mensajeerror"][i]+'<br>';
                }
                mostrarMensaje(errores);
                $(elemento).html(contenidoOriginal);
                $(elemento).attr("onclick",funcionOriginal);
            }else{
                $("#detalle-pedido tbody").empty();

                for (var i = 0; i < Object.keys(response["exito"]).length; i++) {
                    var html="";

                    html+='<tr>'
                    html+='<td>'+response["exito"][i]["cantidad"]+'</td>'
                    html+='<td>'+response["exito"][i]["CodInternoArti"]+'</td>'                    
                    html+='<td>'+response["exito"][i]["DescripcionArti"]+'</td>'
                    html+='<td class="text-nowrap">'+response["exito"][i]["precio"]+'</td>'
                    html+='<td class="text-nowrap">'+response["exito"][i]["subtotal"]+'</td>'
                    if (response["adicionales"]["CalculaIvaC"] == 1 && response["adicionales"]["DiscriminaIvaC"] == 1) {
                        html+='<td class="text-nowrap">'+response["exito"][i]["iva"]+' (% '+response["exito"][i]["TasaIva"]+') </td>'
                    };                    
                    html+='</tr>'               

                    $("#detalle-pedido tbody").append(html);
                };

                var html="";

                html+='<tr class="bg-gray-5 cl-color-3"'
                html+='<td></td>'                
                html+='<td></td>'
                html+='<td></td>'                    
                html+='<td></td>'
                html+='<td class="bold">TOTAL</td>'
                html+='<td class="text-nowrap">'+response["adicionales"]["acumulado"]+'</td>'
                if (response["adicionales"]["CalculaIvaC"] == 1 && response["adicionales"]["DiscriminaIvaC"] == 1) {
                    html+='<td class="text-nowrap">'+response["adicionales"]["ivaacumulado"]+'</td>'
                };                    
                html+='</tr>'

                $("#detalle-pedido tbody").append(html);
                $(".spinner").hide();
                $("#detalle-pedido-modal").modal();
            };
        },
        error: function(jqXHR, textStatus, errorThrown) {
           console.log(textStatus, errorThrown);
        }
    })         
}


function ultimosComprados(){
    $(".spinner").show();

    var accion="ultimos-comprados";

    $.ajax({
        url: "./api/api.php",
        type: "get",
        //crossDomain: true,
        data: {accion:accion},
        dataType: "json",
        success: function (response) {
            if (response["error"]==true) {
                var errores="";
                for (var i = 0; i < Object.keys(response["errores"]["coderror"]).length; i++) {
                    errores+=response["errores"]["mensajeerror"][i]+'<br>';
                }
                mostrarMensaje(errores);
                $(elemento).html(contenidoOriginal);
                $(elemento).attr("onclick",funcionOriginal);
            }else{
                $("#ultimos-comprados tbody").empty();

                for (var i = 0; i < Object.keys(response["exito"]).length; i++) {
                    var html="";

                    html+='<tr class="producto" data-origen="listapedido" data-codigo-producto="'+response["exito"][i]["CodInternoArti"]+'">'
                    html+='<td>'+response["exito"][i]["CodInternoArti"]+'</td>'                    
                    html+='<td>'+response["exito"][i]["DescripcionArti"]+'</td>'
                    html+='<td>'+response["exito"][i]["PrecioVta1_PreArti"]+'</td>'
                    html+='<td>'+response["exito"][i]["fechacompra"]+'</td>'                    
                    html+='<td><a style="width:100%" class="btn btn-danger" onclick="mostrarProducto('+"'"+response["exito"][i]["CodInternoArti"]+"'"+')" href="javascript:void(0)"><h6 style="margin:4px"><i class="fa fa-cart-plus" aria-hidden="true"></i> Comprar</h6></a></td>'                                  
                    html+='</tr>'               

                    $("#ultimos-comprados tbody").append(html);
                };

                $(".spinner").hide();
            };
        },
        error: function(jqXHR, textStatus, errorThrown) {
           console.log(textStatus, errorThrown);
        }
    });    
}

function estadoCuenta(){

    $(".spinner").show();

    var accion="estado-cuenta";

    $.ajax({
        url: "./api/api.php",
        type: "get",
        //crossDomain: true,
        data: {accion:accion},
        dataType: "json",
        success: function (response) {
            if (response["error"]==true) {
                var errores="";
                for (var i = 0; i < Object.keys(response["errores"]["coderror"]).length; i++) {
                    errores+=response["errores"]["mensajeerror"][i]+'<br>';
                }
                mostrarMensaje(errores);
            }else{
                $("#estado-cuenta tbody").empty();

                for (var i = 0; i < Object.keys(response["exito"]).length; i++) {
                    var html="";

                    html+='<tr>'
                    html+='<td>'
                    html+='<input onchange="cargaImporteAbonar(this)" type="checkbox" value="'+response["exito"][i]["ImportePes_CliVto"]+'"/>'
                    html+='</td>'
                    html+='<td>'+response["exito"][i]["FechaVto_CliVto"]+'</td>'                    
                    html+='<td>'+response["exito"][i]["Fecha_CliTra"]+'</td>'
                    html+='<td>'+response["exito"][i]["dias"]+'</td>'
                    html+='<td>'+response["exito"][i]["Regis_Emp"]+'</td>'
                    if (response["exito"][i]["linkpdf"]!="") {
                        html+='<td><a target="_blank" href="'+response["exito"][i]["linkpdf"]+'">'+response["exito"][i]["NroComprob_CliTra"]+'</a></td>'                   
                    }else{
                        html+='<td>'+response["exito"][i]["NroComprob_CliTra"]+'</td>'
                    };                    
                    html+='<td>'+response["exito"][i]["moneda"]+'</td>'                   
                    html+='<td class="text-right">'+response["exito"][i]["pendiente"]+'</td>'                   
                    html+='<td class="text-right">'+response["exito"][i]["acumulado"]+'</td>'                                       
                    html+='</tr>'               

                    $("#estado-cuenta tbody").append(html);
                };


                $(".spinner").hide();
            };
        },
        error: function(jqXHR, textStatus, errorThrown) {
           console.log(textStatus, errorThrown);
        }
    });    
}

function cargaImporteAbonar(elemento){
    var importe=0;
    $('#estado-cuenta tbody tr input[type="checkbox"]:checked').each(function(key, element){
        importe+=parseFloat($(element).val());
    });

    $("#monto-seleccionado").val(importe.toFixed(2));
    $("#monto-abonar").val(importe.toFixed(2));

    calculaImporteFinal();
}

function buscador(){
    window.location.href = "productos.php?categoria=&favoritos=false&descripcion="+$("#search").val();
}

$('#search').keyup(function(e){
    if(e.keyCode == 13)
    {
        buscador();
    }
});


function valorCantidad(elemento){
    if (parseFloat($(elemento).val()) >= parseFloat($(elemento).attr("max"))) {
        $(elemento).attr("disabled", true);
        mostrarMensaje("El máximo de compra de este artículo es "+(parseFloat($(elemento).attr("max"))-1));
        $(elemento).val(parseFloat($(elemento).attr("max"))-1);
        $(elemento).removeAttr("disabled");        
    };
    if (parseFloat($(elemento).val()) < parseFloat($(elemento).attr("min"))) {
        $(elemento).attr("disabled", true);        
        mostrarMensaje("El mínimo de compra de este artículo es "+(parseFloat($(elemento).attr("min"))));
        $(elemento).val(parseFloat($(elemento).attr("min")));
        $(elemento).removeAttr("disabled");        
    };    
}

function igualarAlto(elementos){
  
  for (i=0; i<elementos.length; i++) {
    $(elementos[i]).height('auto');        
    var alto = 0;
    $(elementos[i]).each(function(key, element){
      if($(this).innerHeight()>alto){
        alto=$(this).innerHeight();
    }
    });
    $(elementos[i]).height(alto);    
  }

}

function resetearAlto(elementos){
  
  for (i=0; i<elementos.length; i++) {
    $(elementos[i]).height('auto');   
  }

}


/* Checkout
=============================================*/

function seleccionaMediosEntrega(){

    if ($("#medio-entrega").length) {
        var idEntrega=$("#medio-entrega").val();
    }else{
        var idEntrega=0;
    };

    $(".spinner").show();

    var accion = "pagos-por-entregas";

    $.ajax({
        url: "./api/api.php",
        type: "get",
        //crossDomain: true,
        data: {accion:accion, idEntrega:idEntrega},
        dataType: "json",
        success: function (response) {

            if (idEntrega==0) {

                $("#medio-pago").empty();
                var html='<option value="0">No existen medios de pago disponibles</option>';
                $("#medio-pago").append(html).attr("disabled","true");

            }else{

                if (response["error"]==true) {
                    $("#medio-pago").empty();
                    var html='<option value="0">'+response["errores"]["mensajeerror"][0]+'</option>';
                    $("#medio-pago").append(html).attr("disabled","true");

                    $(".spinner").hide();

                }else{
                    $("#medio-pago").empty();

                    for (var i = 0; i < Object.keys(response["exito"]).length; i++) {
                        var html="";

                        html+='<option value="'+response["exito"][i]["id"]+'">'+response["exito"][i]["denominacion"]+'</option>'              

                        $("#medio-pago").append(html).removeAttr("disabled");
                    };

                    $(".spinner").hide();

                };
            }
        
            seleccionaMediosPago();
        
        },
        error: function(jqXHR, textStatus, errorThrown) {
           console.log(textStatus, errorThrown);
        }
    });

    $("#medio-pago").removeAttr("disabled");

}

function seleccionaMediosPago(elemento){

    if ($("#medio-pago").length) {
        var idPago=$("#medio-pago").val();
    }else{
        var idPago=0;
    };

    $(".spinner").show();

    $("#cuotas").empty();

    var accion = "cuotas-por-pagos";

    $.ajax({
        url: "./api/api.php",
        type: "get",
        //crossDomain: true,
        data: {accion:accion, idPago:idPago},
        dataType: "json",
        success: function (response) {
            if (idPago==0) {
                
                $("#contenedor-cuotas").hide();
                var html='<option value="0">No hay cuotas para este medio de pago</option>';
                $("#cuotas").append(html);

                $("#datos-todopago").hide();        

                $(".spinner").hide();
                
            }else{

                if (response["error"]==true) {

                    $("#contenedor-cuotas").hide();
                    var html='<option value="0">No hay cuotas para este medio de pago</option>';
                    $("#cuotas").append(html);

                    $("#datos-todopago").hide();                    

                    $(".spinner").hide();   

                }else{

                    if (Object.keys(response["exito"]).length==1) {
                        $("#contenedor-cuotas").hide();
                        $("#recargo-pago").val(response["exito"][0]["recargo"]);

                        $(".spinner").hide();                         
                    }else{

                        for (var i = 0; i < Object.keys(response["exito"]).length; i++) {
                            var html="";

                            html+='<option value="'+response["exito"][i]["id"]+'">'+response["exito"][i]["cuotas"]+'</option>'              
                            $("#cuotas").append(html);
                        };

                        $("#contenedor-cuotas").show();

                        $(".spinner").hide();

                    };

                    if (response["exito"][0]["pasarelaPago"]==1) {
                        $("#datos-todopago").show();                    
                    };

                };
            }    
            
            calculaImporteCheckout();
        },
        error: function(jqXHR, textStatus, errorThrown) {
           console.log(textStatus, errorThrown);
        }
    });       
}

function calculaImporteCheckout(){
    $(".spinner").show();

    var accion="importe-checkout";

    if ($("#cuotas").length) {
        var idCuota=$("#cuotas").val();
    }else{
        var idCuota=0;
    };


    $.ajax({
        url: "./api/api.php",
        type: "get",
        //crossDomain: true,
        data: {accion:accion,idCuota:idCuota},
        dataType: "json",
        success: function (response) {
           
            $("#recargomedioentrega").html(response["exito"]["recargoentrega"]);
            $("#recargomedioentregaiva").html(response["exito"]["recargoentregaiva"]);

            $("#recargomediopago").html(response["exito"]["recargopago"]);
            $("#recargomediopagoiva").html(response["exito"]["recargopagoiva"]);

            $("#importefinal").html(response["exito"]["total"]);
            $("#importefinaliva").html(response["exito"]["totaliva"]);

            $(".spinner").hide();


        },
        error: function(jqXHR, textStatus, errorThrown) {
           console.log(textStatus, errorThrown);
        }
    }); 
}

function recargoMedioPago(elemento){

    var medioPago = $(elemento).val();

    var accion = "recargo-medio-pago";

    $.ajax({
        url: "./api/api.php",
        type: "get",
        //crossDomain: true,
        data: {accion:accion, medioPago:medioPago},
        dataType: "json",
        success: function (response) {
            if (response["error"]==true) {
                
                $("#recargo-medio-pago").val(0);
                calculaImporteFinal();

            }else{

                $("#recargo-medio-pago").val(parseFloat(response["exito"]));
                calculaImporteFinal();                    

            }            
        },
        error: function(jqXHR, textStatus, errorThrown) {
           console.log(textStatus, errorThrown);
        }
    });    

}

function calculaImporteFinal(){

    $("#importe-final").val(
        (parseFloat( $("#recargo-medio-pago").val() ) * parseFloat( $("#monto-abonar").val() ) / 100 + parseFloat( $("#monto-abonar").val() )).toFixed(2)
    );

}

function confirmarPedido(elemento){

    var contenidoOriginal=$(elemento).html();
    var funcionOriginal=$(elemento).attr("onclick");
    $(elemento).html('<i class="fa fa-spinner fa-pulse fa-fw"></i>Procesando...');
    $(elemento).bind('click', false);
    $(elemento).removeAttr('onclick');

    accion="confirmar-pedido";
    var comentario=$("#comentario").text();

    if ($("#medio-entrega").length) {
        var idEntrega=$("#medio-entrega").val();
    }else{
        var idEntrega=0;
    };

    if ($("#medio-pago").length) {
        var idPago=$("#medio-pago").val();
    }else{
        var idPago=0;
    }; 

    if ($("#cuotas").length) {
        var idCuota=$("#cuotas").val();
    }else{
        var idCuota=0;
    };

    if ($("#medioenvio").length) {
        var medioenvio=$("#medioenvio").val();
    }else{
        var medioenvio="";
    };    

    var datostodopago={};
    var errores=0;

    if ($("#datos-todopago").css('display') != 'none') {

        $( "#datos-todopago .form-control" ).each(function( index ) {

            borrarError($(this));

            if ($(this).attr("tagName")=="textarea") {
                var id=$(this).attr("id");
                var valor=$(this).text();
            }else{
                var id=$(this).attr("id");
                var valor=$(this).val();
            };

            if($(this).prop('required') && valor==""){
                $(this).addClass("inputerror");
                $(this).parent("div").find(".help-block").show();
                $(this).focus();
                errores ++;
            }

            datostodopago[id]=valor;

        });
    };


    if (errores==0) {                 
    
        $.ajax({
            url: "./api/api.php",
            type: "get",
            //crossDomain: true,
            data: {accion:accion, comentario:comentario, idEntrega:idEntrega, medioenvio:medioenvio, idPago:idPago, idCuota:idCuota, datostodopago:datostodopago},
            dataType: "json",
            success: function (response) {
                if (response["error"]==true) {
                    var errores="";

                    if (response["errores"]["coderror"][0]=="confirmar-pedido4") {
                        mostrarMensaje(response["errores"]["mensajeerror"][0], "volverhome()");
                    }else if (response["errores"]["coderror"][0]=="confirmar-pedido0") {
                        mostrarMensaje(response["errores"]["mensajeerror"][0], "invitarlogin()");
                    }else{
                        for (var i = 0; i < Object.keys(response["errores"]["coderror"]).length; i++) {
                            errores+=response["errores"]["mensajeerror"][i]+'<br>';
                        }
                        mostrarMensaje(errores);
                        $(elemento).html(contenidoOriginal);
                        $(elemento).attr("onclick",funcionOriginal);
                    };
                }else{
                    if (response["adicionales"]["formulario"]==0) {
                        $(elemento).html(contenidoOriginal);
                        $(elemento).attr("onclick",funcionOriginal);
                        miCarrito();
                        contadorCesta();
                        mostrarMensaje(response["exito"],"volverhome()");                
                    }else{
                        window.location.href = response["adicionales"]["formulario"];
                    };
                }            
            },
            error: function(jqXHR, textStatus, errorThrown) {
               console.log(textStatus, errorThrown);
            }
        });
    }else{
        $(elemento).html(contenidoOriginal);
        $(elemento).attr("onclick",funcionOriginal);
        mostrarMensaje("Debe completar los campos requeridos");       
    }     
}

/* Redes Sociales
=============================================*/

function feedinstagram(){

    var accion="feedinstagram"
    $.ajax({
        url: "./api/api.php",
        type: "get",
        //crossDomain: true,
        data: {accion:accion},
        dataType: "json",
        success: function (response) {
            if (response["error"]==false) {
                var html='<div class="owl-carousel">';
                for (var i = 0; i < Object.keys(response["exito"]["data"]).length; i++) {
                    if (response["exito"]["data"][i]["type"]=="image") {
                        html+='<div class="instagram-publicacion">';
                        html+='<a target="_blank" href="'+response["exito"]["data"][i]["link"]+'" >';
                        html+='<div style="background-image:url('+response["exito"]["data"][i]["images"]["low_resolution"]["url"]+')">';
                        html+='</div>';
                        html+='</a>';
                        html+='</div>';
                    };
                    
                };               
                html+='</div>';
                $("#instagram").append(html);

                $('.owl-carousel').owlCarousel({
                    loop:true,
                    responsiveClass:true,
                    autoplay:true,
                    autoplayTimeout:1000,
                    autoplayHoverPause:true,                   
                    responsive:{
                        0:{
                            items:1,
                            nav:false,
                            loop:true
                        },
                        600:{
                            items:2,
                            nav:false,
                            loop:true
                        },
                        1000:{
                            items:3,
                            nav:false,
                            loop:true
                        }
                    }
                })
            }            
        },
        error: function(jqXHR, textStatus, errorThrown) {
           console.log(textStatus, errorThrown);
        }
    });

}


/* Remitos
=============================================*/

function misRemitos(){
    $(".spinner").show();

    var accion="remitos";

    $.ajax({
        url: "./api/api.php",
        type: "get",
        //crossDomain: true,
        data: {accion:accion},
        dataType: "json",
        success: function (response) {
            if (response["error"]==true) {
                var errores="";
                for (var i = 0; i < Object.keys(response["errores"]["coderror"]).length; i++) {
                    errores+=response["errores"]["mensajeerror"][i]+'<br>';
                }
                mostrarMensaje(errores);
                $(elemento).html(contenidoOriginal);
                $(elemento).attr("onclick",funcionOriginal);
            }else{
                $("#mis-pedidos tbody").empty();

                for (var i = 0; i < Object.keys(response["exito"]).length; i++) {
                    var html="";

                    html+='<tr data-codigo-remito="'+response["exito"][i]["Id_Remito"]+'">'
                    html+='<td>'
                    html+='<a onclick="verDetalleRemito(this)">'
                    html+='<i class="fa fa-eye" aria-hidden="true"></i>'
                    html+=' Ver</a>'
                    html+='</td>'
                    html+='<td>'+response["exito"][i]["estado"]+'</td>'                                                             
                    html+='<td>'+response["exito"][i]["Fecha"]+'</td>'                                                             
                    html+='<td>'+response["exito"][i]["Transporte"]+'</td>'                                                             
                    html+='<td>'+response["exito"][i]["NumeroDeBultos"]+'</td>'                                                             
                    html+='<td>'+response["exito"][i]["Importe"]+'</td>'                                                             
                    html+='<td>'+response["exito"][i]["observacionesInternas"]+'</td>'                                                             
                    html+='</tr>'               

                    $("#mis-pedidos tbody").append(html);
                };


                $(".spinner").hide();
            };
        },
        error: function(jqXHR, textStatus, errorThrown) {
           console.log(textStatus, errorThrown);
        }
    });
        
}

function verDetalleRemito(elemento){

    $(".spinner").show();

    var idRemito=$(elemento).parents("tr").attr("data-codigo-remito");

    var accion="detalle-remito"

    $.ajax({
        url: "./api/api.php",
        type: "get",
        //crossDomain: true,
        data: {accion:accion, idRemito:idRemito},
        dataType: "json",
        success: function (response) {
            if (response["error"]==true) {
                var errores="";
                for (var i = 0; i < Object.keys(response["errores"]["coderror"]).length; i++) {
                    errores+=response["errores"]["mensajeerror"][i]+'<br>';
                }
                mostrarMensaje(errores);
                $(elemento).html(contenidoOriginal);
                $(elemento).attr("onclick",funcionOriginal);
            }else{
                $("#detalle-pedido tbody").empty();

                for (var i = 0; i < Object.keys(response["exito"]).length; i++) {
                    var html="";

                    html+='<tr>'
                    html+='<td>'+response["exito"][i]["cantidad"]+'</td>'
                    html+='<td>'+response["exito"][i]["denominacion"]+'</td>'                                       
                    html+='</tr>'               

                    $("#detalle-pedido tbody").append(html);
                };

                $(".spinner").hide();
                $("#detalle-pedido-modal").modal();
            };
        },
        error: function(jqXHR, textStatus, errorThrown) {
           console.log(textStatus, errorThrown);
        }
    })         
}


/* Lista de Precios
=============================================*/

function listaprecios(){

    $(".spinner").show();

    var accion="lista-precios"

    $.ajax({
        url: "./api/api.php",
        type: "get",
        //crossDomain: true,
        data: {accion:accion},
        dataType: "json",
        success: function (response) {
            if (response["error"]==true) {
                var errores="";
                for (var i = 0; i < Object.keys(response["errores"]["coderror"]).length; i++) {
                    errores+=response["errores"]["mensajeerror"][i]+'<br>';
                }
                mostrarMensaje(errores);
                $(elemento).html(contenidoOriginal);
                $(elemento).attr("onclick",funcionOriginal);
            }else{
                $("#lista-precios tbody").empty();

                for (var i = 0; i < Object.keys(response["exito"]).length; i++) {
                    var html="";

                    html+='<tr>'
                    html+='<td>'+response["exito"][i]["CodInternoArti"]+'</td>'
                    html+='<td>'+response["exito"][i]["CodBarraArti"]+'</td>'
                    html+='<td>'+response["exito"][i]["DescrNivelInt4"]+'</td>'                                       
                    html+='<td>'+response["exito"][i]["DescrNivelInt3"]+'</td>'                                       
                    html+='<td>'+response["exito"][i]["DescrNivelInt2"]+'</td>'                                       
                    html+='<td>'+response["exito"][i]["DescripcionArti"]+'</td>'                                       
                    html+='<td class="text-nowrap">'+response["exito"][i]["PrecioVta1_PreArti"]+'</td>'                                       
                    if (response["adicionales"]["CalculaIvaC"] == 1 && response["adicionales"]["DiscriminaIvaC"] == 1) {
                        html+='<td class="text-nowrap">'+response["exito"][i]["importeIva"]+' (% '+response["exito"][i]["TasaIva"]+') </td>'
                    };                      
                    html+='</tr>'               

                    $("#lista-precios tbody").append(html);
                };

                $(".spinner").hide();

            };
        },
        error: function(jqXHR, textStatus, errorThrown) {
           console.log(textStatus, errorThrown);
        }
    })         
}

/* Exportar
=============================================*/

function exportarExcel(){
    $('[data-exportar="true"]').tableExport({
        headings: true,
        footers: true,         
        type: 'excel'
    });         
}

function exportarPdf(){
    $('[data-exportar="true"]').tableExport({
        headings: true,
        footers: true,          
        type: 'pdf',
        jspdf: {
            orientation: 'l',
            margins: {
                right: 20,
                left: 20,
                top: 30,
                bottom: 30
            },
            autotable: {
                tableWidth: 'wrap'
            }
        }
    });
}

/* Mensajes
=============================================*/

function listarMensajes(){
    $(".spinner").show();

    var accion="listar-mensajes";

    $.ajax({
        url: "./api/api.php",
        type: "get",
        //crossDomain: true,
        data: {accion:accion},
        dataType: "json",
        success: function (response) {
            if (response["error"]==true) {

            }else{
                $("#mensajes tbody").empty();

                for (var i = 0; i < Object.keys(response["exito"]).length; i++) {
                    var html="";

                    html+='<tr data-mensajetipo="'+response["exito"][i]["espublico"]+'" data-mensajeid="'+response["exito"][i]["idOferta"]+'" data-mensajecompleto="'+response["exito"][i]["oferta"]+'">'
                    html+='<td class="text-nowrap">'
                    if (response["exito"][i]["id"]=="" || response["exito"][i]["id"]==0) {
                        html+='<a class="mensajeboton" onclick="marcarLeido(this)">'
                        html+='<i title="Marcar como Leido" class="fa fa-envelope-o" aria-hidden="true"></i>'
                        html+='</a>'
                    }else{
                        html+='<a class="mensajeboton" onclick="marcarNoLeido(this)">'
                        html+='<i title="Marcar como No Leido" class="fa fa-envelope-open-o" aria-hidden="true"></i>'
                        html+='</a>'
                    };
                    html+='</td>'
                    html+='<td class="text-nowrap">'+response["exito"][i]["fecha"]+'</td>'                                                             
                    if (response["exito"][i]["id"]=="" || response["exito"][i]["id"]==0) {
                        html+='<td class="bold mensajeprevio"><a title="Ver Mensaje" onclick="leerMensaje(this)">'+response["exito"][i]["textoprevio"]+'</a></td>'
                    }else{
                        html+='<td class="mensajeprevio"><a title="Ver Mensaje" onclick="leerMensaje(this)">'+response["exito"][i]["textoprevio"]+'</a></td>'
                    }

                    html+='</tr>'               

                    $("#mensajes tbody").append(html);
                };

                $(".spinner").hide();
            };
        },
        error: function(jqXHR, textStatus, errorThrown) {
           console.log(textStatus, errorThrown);
        }
    });
        
}

function leerMensaje(elemento){
    var mensaje=$(elemento).parents("tr").attr("data-mensajecompleto");

    $("#mensaje .modal-body").empty();
    $("#mensaje .modal-body").append(mensaje);

    $('#mensaje').modal();

    if ($(elemento).parents("tr").find(".mensajeboton").attr('onclick')=="marcarLeido(this)") {
        marcarLeido(elemento);
    };
}

function marcarLeido(elemento){
    var id=$(elemento).parents("tr").attr("data-mensajeid");
    var tipo=$(elemento).parents("tr").attr("data-mensajetipo");

    var contenidoOriginal=$(elemento).parents("tr").find(".mensajeboton").html();
    var funcionOriginal=$(elemento).parents("tr").find(".mensajeboton").attr("onclick");
    $(elemento).parents("tr").find(".mensajeboton").html('<i class="fa fa-spinner fa-pulse fa-fw"></i>');
    $(elemento).parents("tr").find(".mensajeboton").attr("disabled", true);
    $(elemento).parents("tr").find(".mensajeboton").bind('click', false);
    $(elemento).parents("tr").find(".mensajeboton").removeAttr('onclick');    

    var accion="cambiar-estado-mensaje";

    var estadonuevo="leido";

    $.ajax({
        url: "./api/api.php",
        type: "get",
        //crossDomain: true,
        data: {accion:accion, id:id, tipo:tipo, estadonuevo:estadonuevo},
        dataType: "json",
        success: function (response) {
            if (response["error"]==true) {

                $(elemento).parents("tr").find(".mensajeboton").html(contenidoOriginal);
                $(elemento).parents("tr").find(".mensajeboton").removeAttr("disabled");                           
                $(elemento).parents("tr").find(".mensajeboton").unbind("click");                
                $(elemento).parents("tr").find(".mensajeboton").attr("onclick",funcionOriginal);

            }else{               

                $(elemento).parents("tr").find(".mensajeboton").html('<i title="Marcar como No Leido" class="fa fa-envelope-open-o" aria-hidden="true"></i>');
                $(elemento).parents("tr").find(".mensajeboton").removeAttr("disabled");                           
                $(elemento).parents("tr").find(".mensajeboton").unbind("click");                
                $(elemento).parents("tr").find(".mensajeboton").attr("onclick","marcarNoLeido(this)");
                $(elemento).parents("tr").find(".mensajeprevio").removeClass("bold");

            };

            contadorMensajes();

        },
        error: function(jqXHR, textStatus, errorThrown) {
           console.log(textStatus, errorThrown);
        }
    });
}

function marcarNoLeido(elemento){
    var id=$(elemento).parents("tr").attr("data-mensajeid");
    var tipo=$(elemento).parents("tr").attr("data-mensajetipo");

    var contenidoOriginal=$(elemento).parents("tr").find(".mensajeboton").html();
    var funcionOriginal=$(elemento).parents("tr").find(".mensajeboton").attr("onclick");
    $(elemento).parents("tr").find(".mensajeboton").html('<i class="fa fa-spinner fa-pulse fa-fw"></i>');
    $(elemento).parents("tr").find(".mensajeboton").attr("disabled", true);
    $(elemento).parents("tr").find(".mensajeboton").bind('click', false);
    $(elemento).parents("tr").find(".mensajeboton").removeAttr('onclick');    


    var accion="cambiar-estado-mensaje";

    var estadonuevo="noleido";

    $.ajax({
        url: "./api/api.php",
        type: "get",
        //crossDomain: true,
        data: {accion:accion, id:id, tipo:tipo, estadonuevo:estadonuevo},
        dataType: "json",
        success: function (response) {
            if (response["error"]==true) {

                $(elemento).parents("tr").find(".mensajeboton").html(contenidoOriginal);
                $(elemento).parents("tr").find(".mensajeboton").removeAttr("disabled");                           
                $(elemento).parents("tr").find(".mensajeboton").unbind("click");                
                $(elemento).parents("tr").find(".mensajeboton").attr("onclick",funcionOriginal);

            }else{

                $(elemento).parents("tr").find(".mensajeboton").html('<i title="Marcar como Leido" class="fa fa-envelope-o" aria-hidden="true"></i>');
                $(elemento).parents("tr").find(".mensajeboton").removeAttr("disabled");                           
                $(elemento).parents("tr").find(".mensajeboton").unbind("click");                
                $(elemento).parents("tr").find(".mensajeboton").attr("onclick","marcarLeido(this)");
                $(elemento).parents("tr").find(".mensajeprevio").addClass("bold");
            
            };

            contadorMensajes();
        },
        error: function(jqXHR, textStatus, errorThrown) {
           console.log(textStatus, errorThrown);
        }
    });
}

function contadorMensajes(){

    var accion="contador-mensajes";

    $.ajax({
        url: "./api/api.php",
        type: "get",
        //crossDomain: true,
        data: {accion:accion},
        dataType: "json",
        success: function (response) {
            if (response["error"]==false) {
                if (response["exito"]>0) {
                    $("#contador-mensajes").html(response["exito"]+' <i class="fa fa-envelope-o" aria-hidden="true"></i>');
                    $("#contador-mensajes").css("display","inline-block");
                    $("#alerta-mensajes").css("display","inline-block");

                }else{
                    $("#contador-mensajes").css("display","none");
                    $("#alerta-mensajes").css("display","none");                    
                };
            }else{
                $("#contador-mensajes").css("display","none");
                $("#alerta-mensajes").css("display","none");
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
           console.log(textStatus, errorThrown);
        }
    });
}
