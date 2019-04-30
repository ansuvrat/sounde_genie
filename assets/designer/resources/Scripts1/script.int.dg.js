!window.jQuery && document.write(unescape('%3Cscript src="http://ajax.aspnetcdn.com/ajax/jquery/jquery-1.8.3.min.js"%3E%3C/script%3E')); 
/*$('meta[name="viewport"]').prop('content', 'width=1280'); */

function include(url){ 
document.write('<script src="'+ url + '" type="text/javascript"></script>'); 
}

include('//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js');
include(resource_url+'Scripts/helpers.min.js');
include(resource_url+'ddmenu/ddmenu.js');
include(resource_url+'Scripts/addthis_widget.js');

if(Page=='home'){
include(resource_url+'Scripts/fluid_dg.min.js');
include(resource_url+'gs-carousel/gs.carousel.min.js');
}

if(Page=='details'){
include(resource_url+'zoom/magiczoomplus.js');
}

else{
}
$(window).load(function(e) {
	$("table").addClass("table table-bordered table-striped table-hover");
$('.fancybox').fancybox();
$('.mygallery').fancybox({/*use class 'mygallery' and rel 'gallery' in 'A tag' */
wrapCSS : 'fancybox-custom',closeClick : true, openEffect : 'none',
helpers : {
title : {type : 'inside'},
overlay : {css : {'background' : 'rgba(0,0,0,0.6)'}}
}
});

$('.pop1').fancybox({'width':395,'height':235,'type':'iframe',title:{type:'outside'}});
$('.newsletter').fancybox({'width':395,'height':235,'type':'iframe',title:{type:'outside'}});
$('.forgot').fancybox({'width':395,'height':135,'type':'iframe',title:{type:'outside'}});
$('.enq').fancybox({'width':500,'height':400,'type':'iframe',title:{type:'outside'}});
$('.pre-pop').fancybox({'width':500,'height':400,'type':'iframe',title:{type:'outside'}});
$('.address').fancybox({'width':500,'height':400,'type':'iframe',title:{type:'outside'}});
$('.invoice1').fancybox({'width':900,'height':680,'type':'iframe',title:{type:'outside'}});

$('.showhide').click(function(){$(this).next().slideToggle();});

$('.shownext').click(function(){$('.subdd').hide('fast'); $(this).next().slideToggle('fast');});
$('.c_tog').click(function(){$(this).toggleClass('c_tog2');})
$('.dd_next').click(function(){$(this).next().slideToggle('fast');$(this).toggleClass('dd_next_act');})
$('.mystar').on('click', function(){$(this).toggleClass('act')})
$('.d_c_tag a').click(function(){$('.d_c_tag a').removeClass('act');$(this).addClass('act'); return false;})
$('.d_c_tag2 a').click(function(){$('.d_c_tag2 a').removeClass('act');$(this).addClass('act'); return false;})
$('.scroll_bar_2').slimscroll({height:'200px',size:'5px',color:"#ffffff"});

$(function(){$(".scroll_brand").jCarouselLite({btnPrev:".prev",btnNext:".next",vertical: false,hoverPause:true,visible:4,auto:2000,speed:400});});
$(function(){$(".news_sc").jCarouselLite({btnPrev:".prev_nw",btnNext:".next_nw",vertical: false,hoverPause:true,visible:3,auto:2000,speed:400});});
$(function(){$(".scroll_2").jCarouselLite({btnPrev:".prev2",btnNext:".next2",vertical: false,hoverPause:true,visible:6,auto:2000,speed:400});});
$(function(){$(".scroll_3").jCarouselLite({btnPrev:".prev3",btnNext:".next3",vertical: false,hoverPause:true,visible:6,auto:2000,speed:400});});
$(function(){$(".scroll_4").jCarouselLite({btnPrev:".prev4",btnNext:".next4",vertical: false,hoverPause:true,visible:1,auto:2000,speed:400});});
$(function(){$(".scroll_5").jCarouselLite({btnPrev:".prev5",btnNext:".next5",vertical: false,hoverPause:true,visible:4,auto:2000,speed:400});});

$('.rm_link').live('click',function(){
	$(this).prev().toggleClass('t_text_1_auto');$(this).toggleClass('rm_link_x');
	return false;
})


$(".scroll").click(function(event){
event.preventDefault();
$('html,body').animate({scrollTop:$(this.hash).offset().top-85}, 1000);
});

$("#back-top").hide();	
$(function () {$(window).scroll(function(){if ($(this).scrollTop() > 100) {$('#back-top').fadeIn();} else {$('#back-top').fadeOut();}});
$('#back-top a').click(function () {$('body,html').animate({scrollTop: 0}, 800);return false;});
});
if($(window).width()>=1020){
	setTimeout(function(){$('#opener_DG').fancybox({'width': 665, 'height': 340, 'autoScale': false, 'hideOnOverlayClick':false, 'centerOnScroll':true, 'type':'iframe'}).trigger('click');},5000)
}else{}

$(window).scroll(function(){if($(this).scrollTop() > 1)
{$('.top1').addClass('shadow2');} else{$('.top1').removeClass('shadow2');}

if($(this).scrollTop()>25){$('.reg_r').css({'position':'fixed','z-index':'99','top':'120px'})}
else{$('.reg_r').css({'position':'static','z-index':'0','top':'auto'})}


});


$("#owl-example").owlCarousel({autoPlay: 3000,items : 5,itemsDesktop : [1151,4],itemsDesktopSmall : [991,3]});
$("#owl-example2").owlCarousel({autoPlay: 3000,items : 5,itemsDesktop : [1151,4],itemsDesktopSmall : [991,3]});
$("#owl-example3").owlCarousel({autoPlay: 3000,items : 5,itemsDesktop : [1151,4],itemsDesktopSmall : [991,3]});



if(Page=='home'){
	
$(function(){$('#fluid_dg_wrap_1').fluid_dg({thumbnails: false,height:"39%",minHeight:'100',transPeriod: 4000,fx:'simpleFade',navigation:0,playPause:0,loader:'none',hover:0,time:3000});})
}
/*$(function (){jwplayer("video-area1").setup({file: "video/video.mp4",image: "images/video_bg.jpg",width:'100%',height:'220px'});});*/
});

