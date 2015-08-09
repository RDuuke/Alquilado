$(".contenedor-btn a").on('click', function(){
    var data = $(this).attr('data');

    $.ajax({
        url:"partial/input-new.php",
        data:{opcion:data},
        method: "POST",
        cache: false
    }).done(function(data){
        $('.zona-trabajo').html(data);
    });
});
$(".zona-trabajo").on('change keyup','.search',function(){
    var codigo = $(this).val();
    $.ajax({
        url: "../lib/AppController.php",
        data:{accion:'busqueda-propiedad',codigo:codigo},
        method:"POST",
        cache: false
    }).done(function (data){
       $("#resultado").html(data);
    });
});
$(".zona-trabajo").on('click', '.operaciones', function(){
    var tr,dato,opcion;
    opcion = $(this).attr('data');
    $('input[type=radio]:checked').each(function(){
        tr = $(this).parents('tr');
    });
    dato = tr.children('td').eq(2).html();
    $.ajax({
        url:'../lib/AppController.php',
        data:{accion:opcion,codigo:dato},
        method:'POST',
        cache:false
    }).done(function (data){
        if(opcion == 'eliminar-propiedad'){
            $('.mensajes-flash').addClass(data['color']).html(data['mensaje']);
            $(".contenedor-btn a:last").trigger('click');
            $('.mensajes-flash').delay(5000).fadeOut();
        }else{
            $('#manto').fadeIn();
            $('.modal').fadeIn().html(data);
        }
    });
});
$('.mensajes-flash').delay(3000).fadeOut();
$(".contenedor-btn a:last").trigger('click');
$('#manto').click(function(){
    $('#manto').fadeOut();
    $('.modal').fadeOut()
});
$('.modal').on('change','.updateFoto',function(){
    if($(this).is(':checked')){
        $('.contenedor-input').fadeIn();
        $('input[type=file]').prop('required',true);
    } else {
        $('.contenedor-input').fadeOut();
        $('input[type=file]').prop('required',false);

    }
});
/*
Slider
 */
var ca = $('.slide-alquiler'),cv = $('.slide-venta');
var sa = ca.find('section'), sv = cv.find('section');
var na = sa.length, nv = sv.length;
ca.wrapInner('<div class="slide-inner-alquiler" />');
cv.wrapInner('<div class="slide-inner-venta" />');
cia = $('.slide-inner-alquiler'), civ = $('.slide-inner-venta');
cia.css('width', 100*na+'%'),civ.css('width', 100*nv+'%');
sa.css('width', 100/na+'%'),sv.css('width', 100/nv+'%');
var ia = 0;
var iv = 0;
function mover(index, objeto){
    var i = index, obj = objeto;
    if(i == 0){
        obj.css('left',0);
    } else if(i > 0){
        obj.css('left','-'+100*i+'%');
    }
}
$('.next').on('click',function(){
    data = $(this).attr('data');
    if(data == 1){
        if(iv < nv-1){
            iv++;
            mover(iv,civ);
        }else{
            iv = 0
            mover(iv,civ);
        }
    }else{
        if(ia < na-1){
            ia++;
            mover(ia,cia);
        }else{
            ia = 0;
            mover(ia,cia);
        }
    }
});
$('.after').on('click',function(){
    data = $(this).attr('data');
    if(data == 1){
        if(iv > 0){
            iv--;
            mover(iv,civ);
        }else{
            iv = nv-1;
            mover(iv,civ);
        }
    }else{
        if(ia > 0){
            ia--;
            mover(ia,cia);
        }else{
            ia = na-1
            mover(ia,cia);
        }
    }
});
/*
fin Slide
 */
$(".btn-buscar").on('click', function(e){
    e.preventDefault();
    var data = $("#form-buscador").serialize();
    $.ajax({
        url:'lib/AppController.php',
        data:data,
        method:'POST',
        cache:false
    })
    .done(function(data){
        $('.resultado').html(data);
    });
});