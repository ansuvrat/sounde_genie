function validcheckstatus(name,action,text)
{
	var chObj	=	document.getElementsByName(name);
	var result	=	false;	
	for(var i=0;i<chObj.length;i++){
	
		if(chObj[i].checked){
		  result=true;
		  break;
		}
	}
 
	if(!result){
		 alert("Please select atleast one "+text+" to "+action+".");
		 return false;
	}else if(action=='delete'){
			 if(!confirm("Are you sure you want to delete this.")){
			   return false;
			 }else{
				return true;
			 }
	}else{
		return true;
	}
}

function showloader(id)
{
	$("#"+id).after("<span id='"+id+"_loader'><img src='"+site_url+"/assets/developers/images/loader.gif'/></span>");
}


function hideloader(id)
{
	$("#"+id+"_loader").remove();
}
												
												
function load_more(base_uri,more_container,formid)
{	
  showloader(more_container);
  $("#more_loader_link"+more_container).remove();
   if(formid!='0')
   {
	   form_data=$('#'+formid).serialize();
   }
   else
   {
	   form_data=null;
   }
  $.post
	  (
		  base_uri,
		  form_data,
		  function(data)
		  { 
		  
		  
			 var dom = $(data);
			
			dom.filter('script').each(function(){
			$.globalEval(this.text || this.textContent || this.innerHTML || '');
			});
			
			var currdata = $( data ).find('#'+more_container).html(); 
			$('#'+more_container).append(currdata);
			hideloader(more_container);
		  }
	  );
}

$(document).ready(function() {	
	$(':checkbox.ckblsp').click(function(){	 
		$(':input','#ship_container').val('');		
		if($(this).attr('checked')){
			$('#ship_container').hide();			
		}else{			
			$('#ship_container').show();				
		}	
	});
		
});

function onclickcategory(ajax_url,response_id,category_value){
	$.ajax({type: "POST",
			url: ajax_url,
			dataType: "html",
			data: {"category_id":category_value},
			cache:false,
			success:function(data){$("#"+response_id).html(data);}    
    }); 	
}

function multisearch(srchkey,chkname)
{			
	var arrval=new Array();
	$('[name='+chkname+']:checked').each(function(mkey,mval)
	{		
            arrval.push($(mval).val());		
	})
	
	$('#'+srchkey).val(arrval.join(","));		
	$("#myform").submit();
}

function join_newsletter()
{
	var form = $("#chk_newsletter");
	showloader('newsletter_loder');
	$(".btn-style").attr('disabled', true);

	$.post(site_url+"pages/join_newsletter",
	$(form).serialize(),
	function(data){
		$("#refresh").click();
		$(".btn-style").attr('disabled', false);
		hideloader('newsletter_loder');
		if(data.error!=undefined){
			$("#my_newsletter_msg").html(data.error);
		}else{
			$("#my_newsletter_msg").html(data);
			clearForm("#chk_newsletter");
		}
	});
	
	return false;
}


function join_newslettermb()
{
	var form = $("#chk_newsletter");
	showloader('newsletter_loder');
	$(".btn-style").attr('disabled', true);

	$.post(site_url+"pages/join_newslettermb",
	$(form).serialize(),
	function(data){
		$("#refresh").click();
		$(".btn-style").attr('disabled', false);
		hideloader('newsletter_loder');
		if(data.error!=undefined){
			$("#my_newsletter_msgmb").html(data.error);
		}else{
			$("#my_newsletter_msgmb").html(data);
			clearForm("#chk_newsletter");
		}
	});
	
	return false;
}



function bidnow()
{
	$(".bidnow").attr('disabled', true);
	$.post(site_url+"products/add_bid",$('#bidnowform').serialize(),
	function(data){
		if(data.error!=undefined){
			$(".bidnow").attr('disabled', false);
			$(".bid_msg").html(data.error);
		}else{		
			$("#biddata").hide();
			$(".bid_msg").html(data);
		}
	});	
	return false;
}

function bargainnow()
{
	$(".bargainnow").attr('disabled', true);
	$.post(site_url+"products/add_bargain",$('#bargainnowform').serialize(),
	function(data){
		if(data.error!=undefined){
			$(".bargainnow").attr('disabled', false);
			$(".bargain_msg").html(data.error);
		}else{		
			$("#bargaindata").hide();
			$("input[name='offer_price']").val('');
			$("textara[name='message']").val('');
			$(".bargain_msg").html(data);
		}
	});	
	return false;
}

function clearForm(frm)
{
	$(frm).find(':input').each(function() {
		switch(this.type) {
			case 'password':
			case 'select-multiple':
			case 'select-one':
			case 'text':
			case 'textarea':
			$(this).val('');
			break;
			case 'checkbox':
			case 'radio':
			//this.checked = false;
		}
	});
}

function increase_quantity(fldName,maxQty) {
	
	var qty=document.getElementById(fldName).value;
	if (parseInt(maxQty) <= qty) {
		alert("Total available quantity of this product is only "+maxQty+" at the moment");
	}else {
		qty++;
		document.getElementById(fldName).value=qty;
	}	
}


function decrease_quantity(fldName) {
	var qty=document.getElementById(fldName).value;
	if (parseInt(qty) >1) {
		qty--;
	}
	document.getElementById(fldName).value=qty;
}

function displaychildproduct(){
	
	var catID = ($( "#selcatid option:selected" ).val());
	alert('sdfsfsd');
	return false;
	var ajax_url=site_url+'pages/getsubcategory';
	$.ajax({
		  type:"POST",
		  url:ajax_url,
		  dataType:'html',
		  data:"catID="+catID,
		  cache:false,
		  success:
		        function(data){
				 alert(data);
				 // $("#prdID").html(data);	
				}
		});
}

function changeprdcolimg(colID,productID){
	
	var ajax_url=site_url+"products/fetcolorImg";
	$.ajax({
	    type:"POST",
		url:ajax_url,
		dataType:"html",
		data:"colID="+colID+"&productID="+productID,
		cache:"false",
		success:function(data){
			
			$("#formtxt").html(data);
					MagicZoomPlus.refresh();
		}
	});
	
}

function applyshippingcharge(){
   
   var zipcode=$("#zipcodeID").val();
   if(zipcode.length < 6){
	  alert("Please enter minimum 6 digit in pincode.");
	  return false;   
   }
   var ajax_url=site_url+"products/applyshippingcharge";
   $.ajax({
	       type:"POST",
		   url:ajax_url,
		   dataType:"html",
		   data:"zipcodeID="+zipcode,
		   cache:false,
		   success:function(data){
			   
			   $("#shipID").html(data);  
		   }
	   });
	
}


function setPaymentInfo(isChecked)
{
	
	with (window.document.checkoutfrm) {
	if (isChecked) {
		billing_first_name.value  = shipping_first_name.value;
		billing_last_name.value   = shipping_last_name.value;
		billing_address.value   = shipping_address.value;
		billing_state.value   = shipping_state.value;
		billing_city.value      = shipping_city.value;
		billing_pin_code.value      = shipping_pin_code.value;
		billing_mobile.value      = shipping_mobile.value;
		billing_phone.value      = shipping_phone.value;
		billing_country.value      = shipping_country.value;
		
	} else {
		billing_first_name.value  = "";
		billing_last_name.value   = "";
		billing_address.value   = "";
		billing_state.value   = "";
		billing_city.value      = "";
		billing_pin_code.value      = "";
		billing_mobile.value      = "";
		billing_phone.value      = "";
		billing_country.value  = "";
	}
  }
}
	  var custom_color_code = "";
	  var custom_bed_polish = "";
	function updatecustomprice(colcode){
	  $("#submitbtnID").show();
	  
	  var hardboardID = $("input[type='radio'][name='hardboard']:checked").val();
	  var bedtype = $("input[type='radio'][name='bedtype']:checked").val();
	  var boxtype = $("input[type='radio'][name='boxtype']:checked").val();
	  
	  if(arguments.length && colcode!='undefined'){
		if($(colcode).hasClass('xcolors')){
			custom_color_code = colcode.getAttribute('data-color');
		}
		else if($(colcode).hasClass('xpolish')){
			custom_bed_polish = colcode.getAttribute('data-value');	
		}
	  }
	  
	  
	  if(custom_color_code !=''){
		  $("#colcodeID").val(custom_color_code);
	  }
	  if(custom_bed_polish !=''){
		  $('#polishcodeID').val(custom_bed_polish);
	  }
	  if(boxtype == 2){
		  $("#noboxid").show();
		  //var nofobeds = $('select[name=no_of_box]').val();
		  var nofobeds = $('#nofoboxid').val();
	  }else{
		  $("#noboxid").hide();
		  var nofobeds =1;
	  }
	 
	  var showpriceval=$("#showpriceval").html();
	  var ajax_utl = site_url+"customizebed/updateberprice"
	  
	   $.ajax({
	          type : "POST",
			  url :ajax_utl,
			  dataType:"html",
			  data:"hardboardID="+hardboardID+"&bedtype="+bedtype+"&boxtype="+boxtype+"&nofobeds="+nofobeds+"&bed_polish="+custom_bed_polish+'&color_code='+custom_color_code,
			  cache:false,
			  success:function(data){
				  
				  $('#showpriceval').html(data);
				  var aa = $('#metalsizeesvID1').html();
				  $('#suvrat').show().html(aa);
			  }
			  
	   });
	}
	
  function updateprdprice(fldName,pid){
	 
	 var qty=document.getElementById(fldName).value;
	 
	 var ajax_utl = site_url+"products/updateprdprice"
	  $.ajax({
	          type : "POST",
			  url :ajax_utl,
			  dataType:"html",
			  data:"qty="+qty+"&pid="+pid,
			  cache:false,
			  success:function(data){
				 
				  $('#disppriceID').html(data);
			  }
			  
	   });
	 
 }	
 
 
 function bind_data(parent_id,method_url,container_id,loader_container,from_section)
{
	
	showloader(loader_container);
	$("#"+container_id).hide();  
	
	var ajax_url=site_url+method_url;
	
	if(from_section=='from_country')
	{
		$('#city_list').html('<select name="city_id" class="txtbox w40 p4 b"><option value="">Select One</option></select>');
		$('#neighborhood_list').html('<select name="location" class="txtbox w40 p4 b"><option value="">Select One</option></select>');
	}
	
	else if(from_section=='from_state')
	{
		//$('#neighborhood_list').html('<select name="location" class="txtbox w40 p4 b"><option value="">Select One</option></select>');
		//$('#neighborhood_list').html('<div style="width: 310px; height: 50px; overflow-y: scroll;" class="txtbox p4 b">');
		$('#neighborhood_list').html('');
	}
	else if(from_section=='from_left_country')
	{
		$('#city_list').html('<select name="city_id" class="fr p2 fs11 w140p"><option value="">Select One</option></select>');
		$('#state_list').html('<select name="state_id" class="fr p2 fs11 w140p"><option value="">Select One</option></select>');
	}
	else if(from_section=='from_left_state')
	{
		$('#city_list').html('<select name="city_id" class="fr p2 fs11 w140p"><option value="">Select One</option></select>');
	}
	
	
	$.ajax({
			type: "POST",
			url: ajax_url,
			dataType: "html",
			data: "parent_id="+parent_id+"&from_section="+from_section,
			cache:false,
			success:
				function(data)
				{
					$("#"+container_id).show();
					$("#"+container_id).html(data);
					hideloader(loader_container);
					
				}
				
	}); 
}

function getsubcategory(catID){
    	
		var ajax_utl = site_url+"pages/getsubcategory"
	  $.ajax({
	          type : "POST",
			  url :ajax_utl,
			  dataType:"html",
			  data:"catID="+catID,
			  cache:false,
			  success:function(data){
				 
				  $('#dispsubcatID').html(data);
			  }
			  
	   });
}
function addproductlike(pid){
    	
		var ajax_utl = site_url+"products/plike"
	  $.ajax({
	          type : "POST",
			  url :ajax_utl,
			  dataType:"html",
			  data:"pid="+pid,
			  cache:false,
			  success:function(data){
				 
				  $('#productlikeID').html(data);
				  $('#clicklikeid').hide();
			  }
			  
	   });
}



function displayprd(){
	

var matches = [];
$("#catID:checked").each(function() {
    matches.push(this.value);
});
   var ajax_utl = site_url+"pages/getcouponcategoryprd"
	  $.ajax({
	          type : "POST",
			  url :ajax_utl,
			  dataType:"html",
			  data:"ids="+matches,
			  cache:false,
			  success:function(data){
				 
				  $('#dispcatprd').html(data);
			  }
			  
	   }); 
}



function shareFB(url)
	{
		 window.open(
				'https://www.facebook.com/sharer/sharer.php?u='+encodeURIComponent(url), 
				'facebook-share-dialog', 
				'width=626,height=436'); 
	} 
	function shareTwitter(url,text)
	{
		 window.open(
				'https://www.twitter.com/share?text='+text+'&url='+encodeURIComponent(url), 
				'twitter-share-dialog', 
				'width=626,height=436'); 
	}
	
	function shareIn(url,title,summary)
	{
		 window.open(
				'https://www.linkedin.com/shareArticle?title='+title+'&summary='+summary+'&mini=true&url='+encodeURIComponent(url), 
				'linkedin-share-dialog', 
				'width=626,height=436'); 
	}
	
	function shareGplus(url)
	{
		 window.open(
				'https://plus.google.com/share?url='+encodeURIComponent(url), 
				'Google-share-dialog', 
				'width=626,height=436'); 
	}
	
	function sharePinterest(url,full_image_path)
	{
		 window.open(
				'https://pinterest.com/pin/create/button/?url='+encodeURIComponent(url)+'&amp;media='+full_image_path, 
				'Pinterest-share-dialog', 
				'width=626,height=436'); 
}

function updategiftwrap(rowID,pid,fldName) {
	
	var ajax_utl = site_url+"cart/addgift"
	  $.ajax({
	          type : "POST",
			  url :ajax_utl,
			  dataType:"html",
			  data:"rowID="+rowID+'&pid='+pid+'&fldName='+fldName,
			  cache:false,
			  success:function(data){
				 
				  $('#suvID').html(data);
			  }
			  
	   }); 
	
}


function validcompare(name,action,text)
{
	
	var chObj	=	document.getElementsByName(name);
	var result	=	false;	
	var ctr=1;
	for(var i=0;i<chObj.length;i++){
	
		if(chObj[i].checked){
		  
		 ctr++
		}
	}
   
	if(ctr < 3){
		 alert("Please select atleast two "+text+" to "+action+".");
		 return false;
	}
	
	if(ctr > 4){
		 alert("Please select maximum three "+text+" to "+action+".");
		 return false;
	} 
		
}

function validchkcompare(name,action,text)
{
	
	var chObj	=	document.getElementsByName(name);
	var result	=	false;	
	var ctr=1;
	for(var i=0;i<chObj.length;i++){
	
		if(chObj[i].checked){
		  
		 ctr++
		}
	}
	if(ctr > 4){
		 alert("Please select maximum three "+text+" to "+action+".");
		 return false;
	}
}

	function getliveinstrumentduration(inval){
	  var ajax_utl = site_url+"member/getliveinstrumentduration"
	  $.ajax({
	          type : "POST",
			  url :ajax_utl,
			  dataType:"html",
			  data:"inval="+inval,
			  cache:false,
			  success:function(data){
				 
				  $('#liveinsID').html(data);
			  }
			  
	   }); 	
	}
	
	function getliveinstrumentprice(priceID){
	  var ajax_utl = site_url+"member/getliveinstrumentprice"
	  $.ajax({
	          type : "POST",
			  url :ajax_utl,
			  dataType:"html",
			  data:"priceID="+priceID,
			  cache:false,
			  success:function(data){
				 
				  $('#livepriceID').html(data);
			  }
			  
	   }); 	
	}
	
	function getcompanysounddesign(catID){
	  var ajax_utl = site_url+"member/getcompanysounddesign"
	  $.ajax({
	          type : "POST",
			  url :ajax_utl,
			  dataType:"html",
			  data:"catID="+catID,
			  cache:false,
			  success:function(data){
				 
				  $('#compsdesignID').html(data);
			  }
			  
	   }); 	
	}
	
	
	function getcompanysounddesignprice(priceID){
		
	  var ajax_utl = site_url+"member/getcompanysounddesignprice"
	  $.ajax({
	          type : "POST",
			  url :ajax_utl,
			  dataType:"html",
			  data:"priceID="+priceID,
			  cache:false,
			  success:function(data){
				  $('#compsdesignpriceID').html(data);
			  }
			  
	   }); 	
	}
	
	
	function getrecordingcategorypeice(catID){
		
	  var ajax_utl = site_url+"member/getrecordingcategorypeice"
	  $.ajax({
	          type : "POST",
			  url :ajax_utl,
			  dataType:"html",
			  data:"catID="+catID,
			  cache:false,
			  success:function(data){
				  $('#recordingcategorypeiceID').html(data);
			  }
			  
	   }); 	
	}
	
	function getsounddesignprice(priceID){
		
	  var ajax_utl = site_url+"member/getsounddesignprice"
	  $.ajax({
	          type : "POST",
			  url :ajax_utl,
			  dataType:"html",
			  data:"priceID="+priceID,
			  cache:false,
			  success:function(data){
				  $('#sounddesignpriceID').html(data);
			  }
			  
	   }); 	
	}
	
	function getmixingduration(trackID){
		
	  var ajax_utl = site_url+"member/getmixingduration"
	  $.ajax({
	          type : "POST",
			  url :ajax_utl,
			  dataType:"html",
			  data:"trackID="+trackID,
			  cache:false,
			  success:function(data){
				  $('#mixingdurationID').html(data);
			  }
			  
	   }); 	
	}
	
	function getmixingprice(priceID){
		
	  var ajax_utl = site_url+"member/getmixingprice"
	  $.ajax({
	          type : "POST",
			  url :ajax_utl,
			  dataType:"html",
			  data:"priceID="+priceID,
			  cache:false,
			  success:function(data){
				  $('#mixingdurationpriceID').html(data);
			  }
			  
	   }); 	
	}
	
	function getvirtualinstrumentduration(instypeID){
		
	  var ajax_utl = site_url+"member/getvirtualinstrumentduration"
	  $.ajax({
	          type : "POST",
			  url :ajax_utl,
			  dataType:"html",
			  data:"instypeID="+instypeID,
			  cache:false,
			  success:function(data){
				  $('#virtualinstrumentduration').html(data);
			  }
			  
	   }); 	
	}
	
	function getvirtualinstrumentdurationprice(priceID){
		
	  var ajax_utl = site_url+"member/getvirtualinstrumentdurationprice"
	  $.ajax({
	          type : "POST",
			  url :ajax_utl,
			  dataType:"html",
			  data:"priceID="+priceID,
			  cache:false,
			  success:function(data){
				  $('#virtualinstrumentpriceID').html(data);
			  }
			  
	   }); 	
	}
	
	function getsinglemusicalpieceprice(priceID){
		
	  var ajax_utl = site_url+"member/getsinglemusicalpieceprice"
	  $.ajax({
	          type : "POST",
			  url :ajax_utl,
			  dataType:"html",
			  data:"priceID="+priceID,
			  cache:false,
			  success:function(data){
				  $('#singlemusicalpiecepriceID').html(data);
			  }
			  
	   }); 	
	}
	
	function getfullmusicalpieceprice(priceID){
		
	  var ajax_utl = site_url+"member/getfullmusicalpieceprice"
	  $.ajax({
	          type : "POST",
			  url :ajax_utl,
			  dataType:"html",
			  data:"priceID="+priceID,
			  cache:false,
			  success:function(data){
				  $('#fullmusicalpiecepriceID').html(data);
			  }
			  
	   }); 	
	}
	
	function getsinglesongmasteringprice(priceID){
		
	  var ajax_utl = site_url+"member/getsinglesongmasteringprice"
	  $.ajax({
	          type : "POST",
			  url :ajax_utl,
			  dataType:"html",
			  data:"priceID="+priceID,
			  cache:false,
			  success:function(data){
				  $('#singlesongmasteringpriceID').html(data);
			  }
			  
	   }); 	
	}
	
	function getfullalbummasteringprice(priceID){
	  
		var ids = [];
		$('input[id="trackID"]:checked').each(function() {
		ids.push(this.value); 
		});
	  var ajax_utl = site_url+"member/getfullalbummasteringprice"
	  $.ajax({
	          type : "POST",
			  url :ajax_utl,
			  dataType:"html",
			  data:"ids="+ids,
			  cache:false,
			  success:function(data){
				  $('#fullalbummasteringpriceID').html(data);
			  }
			  
	   }); 	
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	



