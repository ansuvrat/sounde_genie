!window.jQuery && document.write(unescape('%3Cscript src="http://ajax.aspnetcdn.com/ajax/jquery/jquery-1.8.3.min.js"%3E%3C/script%3E')); 
/*$('meta[name="viewport"]').prop('content', 'width=1280'); */

function include(url){ 
document.write('<script src="'+ url + '" type="text/javascript"></script>'); 
}

!function(e,t,r){function n(){for(;d[0]&&"loaded"==d[0][f];)c=d.shift(),c[o]=!i.parentNode.insertBefore(c,i)}for(var s,a,c,d=[],i=e.scripts[0],o="onreadystatechange",f="readyState";s=r.shift();)a=e.createElement(t),"async"in i?(a.async=!1,e.body.appendChild(a)):i[f]?(d.push(a),a[o]=n):e.write("<"+t+' src="'+s+'" defer></'+t+">"),a.src=s}(document,"script",['//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js',resource_url+'Scripts/helpers.min.js'])

if(Page=='home'){
!function(e,t,r){function n(){for(;d[0]&&"loaded"==d[0][f];)c=d.shift(),c[o]=!i.parentNode.insertBefore(c,i)}for(var s,a,c,d=[],i=e.scripts[0],o="onreadystatechange",f="readyState";s=r.shift();)a=e.createElement(t),"async"in i?(a.async=!1,e.body.appendChild(a)):i[f]?(d.push(a),a[o]=n):e.write("<"+t+' src="'+s+'" defer></'+t+">"),a.src=s}(document,"script",[resource_url+'Scripts/fluid_dg.min.js'])
}

else{
}

if(Page=='details'){}

$(window).load(function(e) {		
$('.pop1').fancybox({iframe:{css:{width:'400'}}}); 
$('.pop2').fancybox({iframe:{css:{width:'800'}}}); 

$('.showhide').click(function(){$(this).next().slideToggle();});
$('.slide-srch').click(function(dg){dg.stopPropagation();$('.srch_pop').slideToggle('fast');}); 

$('.fancybox').fancybox();
$('.mygallery').fancybox({wrapCSS:'fancybox-custom',closeClick : true, openEffect : 'none',helpers : {title : {type : 'inside'},overlay : {css : {'background' : 'rgba(0,0,0,0.6)'}}}});

$('.dd_next').click(function(){
$(this).next().slideToggle('fast');$(this).toggleClass('dd_next_act');
});

$('.shownext').click(function(e){var DG=$(this).data('closed');$(DG).hide();$('.subdd').hide('fast');$(this).next().slideToggle('fast');e.stopPropagation()})
$('body').click(function(){$('.cart-div-box,.serch-div,.user-det,.subdd').hide()})
$('.serch-div').click(function(e){e.stopPropagation()})

$(".scroll").click(function(event){
event.preventDefault();
$('html,body').animate({scrollTop:$(this.hash).offset().top-55}, 1000);
});

$('.rm_link').click(function(){
$(this).prev().toggleClass('t_text_1_auto');$(this).toggleClass('rm_link_x');return false;
})


$("#back-top").hide();	
$(function () {$(window).scroll(function () {if ($(this).scrollTop() > 100) {$('#back-top').fadeIn();} else {$('#back-top').fadeOut();}});
$('#back-top a').click(function () {$('body,html').animate({scrollTop: 0}, 800);return false;});
});

if(Page=='home'){
$(function(){$('#fluid_dg_wrap_1').fluid_dg({thumbnails: false,height:"38%",navigation:'false',minHeight:'120',fx:'simpleFade,scrollRight,scrollLeft',navigationHover:'false',playPause:'false',loader:'none',hover:'false',time:3000,onLoaded:function(){$('#Page_loader').fadeOut()}});})
$("#owl-work").owlCarousel({autoplay:true,dots:true,loop:0,items:4,responsive:{0:{items:2},767:{items:2},991:{items:3},1151:{items:3},1279:{items:4}}});
}

});