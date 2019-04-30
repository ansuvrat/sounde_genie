/***********************************************************
This utility is used for dependency dropdown with the help of 
simple data attributes interface.

@data-class attribute is the engine of this utility

@data-url attribute denotes request url for data binding

@data-fld-key attribute denotes the param name to be sent for data binding

@data-next-sel-val attribute denotes the dependent dropdn selected value(note only single value supported)

@autotrigger_deferreds argument denote your ui interface thats need to be passed

@auto_trigger argument determines the auto triggering change event.(possible values:Y/N)

@decorator determines to convert your dropdn to list items(<ul>).(possible values:Y/N)
***Note:decorator will work if value Y & element has class lt_selectbox

***Note:all the dependent dropdn must be exist in your page

***********************************************************/
(function($){
$.multichange_selectbox = function(autotrigger_deferreds,auto_trigger,decorator){
  $.each(autotrigger_deferreds,function(m,n){
	$('[data-class="'+m+'"]').change(function(e){
	  var curObj = $(this);
	  var frmObj = curObj.prop('form');
	  var dselector = curObj.data('class');
	  var def = autotrigger_deferreds[dselector]['def'];
	  var index = $( 'select[data-class="'+dselector+'"]',frmObj ).index( curObj );
	  data_url = curObj.data('url') || '';
	  //alert(data_url);
	  
	  if(data_url!=''){
		var data_url = site_url+data_url;
		var param_obj = {};
		param_obj[curObj.data('fld-key')] = curObj.val();
		param_obj['current_selected'] = curObj.data('next-sel-val');

		$('select[data-class="'+dselector+'"]:lt('+index+')',frmObj ).each(function(m,n){
		  loopObj = $(n);
		  param_obj[loopObj.data('fld-key')] = loopObj.val();
		});
		
		var next_all_ele = $('select[data-class="'+dselector+'"]:gt('+index+')',frmObj );

		next_all_ele.find('option:gt(0)').remove();

		if(decorator=='Y' && !def && curObj.hasClass('lt_selectbox')){
			next_all_ele.selectBoxIt("refresh");
		}


		$.post(data_url,param_obj,function(data1){

		  var next_ele = $('select[data-class="'+dselector+'"]:eq('+(index+1)+')',frmObj );
		  if(decorator=='N' || def || !next_ele.hasClass('lt_selectbox')){
			next_ele.append(data1);
		  }else{
			next_ele.append(data1).selectBoxIt("refresh");
		  }
		  
		  
		  if(def){
			request_length = --autotrigger_deferreds[dselector]['request_length'];
			
			//alert(request_length+"==="+next_ele.data('class'));
			
			if(!request_length){
			  def.resolve();
			}else{
				next_ele.trigger('change');
			}
		  }
		})
	  }
	});
  });

  if(auto_trigger=='Y'){
	$.each(autotrigger_deferreds,function(m,n){
  
	  autotrigger_deferreds[m]['def'] = $.Deferred();
	  autotrigger_deferreds[m]['request_length']=$('[data-class="'+m+'"][data-url][data-url!=""]').length;
	  //alert(autotrigger_deferreds[m]['request_length']);
	  autotrigger_deferreds[m]['def'].then(function(){
		//alert(m+" completed");
		dec_obj = $('[data-class="'+m+'"]');
		dec_obj.data('next-sel-val','');
		autotrigger_deferreds[m]['def'] = null;
		if(decorator=='Y' && dec_obj.hasClass('lt_selectbox')){
			dec_obj.selectBoxIt({autoWidth:false}); 
		}
	  });
	  $('[data-class="'+m+'"]:eq(0)').trigger('change');
	  
	});
  }else{
	if(decorator == 'Y'){
		$.each(autotrigger_deferreds,function(m,n){
			dec_obj = $('[data-class="'+m+'"]');
			if(dec_obj.hasClass('lt_selectbox')){
				dec_obj.selectBoxIt({autoWidth:false}); 
			}
		});
	}
  }

}
})(jQuery);