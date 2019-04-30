<?php $this->load->view('includes/header');

//trace($res);
?>
<div class="content">
 <div id="content">
  <div class="breadcrumb"><?php echo anchor('sitepanel/dashbord','Home'); ?> &raquo; <?php echo anchor('sitepanel/products','Back To Listing'); ?> &raquo;  <?php echo $heading_title;?></div>
  <div class="box">
   <div class="heading">
    <h1><img src="<?php echo base_url(); ?>assets/sitepanel/image/category.png" alt="" /> <?php    echo $heading_title;?></h1>
    <div class="buttons">
     <a href="javascript:void(0);" onclick="$('#form').submit();" class="button">Save</a>
     <?php echo anchor("sitepanel/products",'<span>Cancel</span>','class="button"');?>
    </div>
   </div>
   <div class="content">
    <div id="tabs" class="htabs">
     <a href="#tab-general">General</a>
     <a href="#tab-image">Image</a>
    </div>
    <?php //echo validation_message();
    echo error_message();
    echo form_open_multipart(current_url_query_string(),array('id'=>'form'));?>

    <div id="tab-general">
     <table width="90%"  class="form"  cellpadding="3" cellspacing="3">
      <tr><th colspan="2" align="right"><span class="required">*Required Fields</span><br><span class="required">**Conditional Fields</span></th></tr>
      <tr><th colspan="2" align="center" > </th></tr>
      
      <tr class="trOdd">
       <td height="26" align="right" valign="top" ><span class="required">*</span> Category:</td>
       <td align="left"><select name="category_id" style="width:350px;"  size="8" onchange="validatebrand(this.value)"><?php echo get_nested_dropdown_menu(0,$res['category_id']);?></select><?php echo form_error('category_id'); ?></td>
      </tr>
    <?php
			$default_params = array(
							'heading_element' => array(
													  'field_heading'=>$heading_title." Name",
													  'field_name'=>"product_name",
													  'field_value'=>$res['product_name'],
													  'field_placeholder'=>"Your Product Name",
													  'exparams' => 'size="40" readonly'
													)
							/*'url_element'  => array(
													  'field_heading'=>"Page URL",
													  'field_name'=>"friendly_url",
													  'field_value'=>$res['product_friendly_url'],			  
													  'field_placeholder'=>"Your Page URL",
													  'exparams' => 'size="40"',
												   )*/

						  );
			seo_edit_form_element($default_params);
			?>
			<tr class="trOdd">
			 <td height="26" align="right" ><span class="required">*</span> Product Code:</td>
			 <td align="left"><input type="text" name="product_code" size="40" value="<?php echo set_value('product_code',$res['product_code']);?>" /><?php echo form_error('product_code'); ?></td>
			</tr>
		<?php $category_id=($this->input->post('category_id') > 0 )?$this->input->post('category_id'):$res['category_id'];?>	
			<tr class="trOdd">
       <td align="right" valign="top" ><span class="required">*</span> Brand :</td>
       <td align="left">
        <select name="brand_id" style="width:380px;"  size="1" id="carbrandID">
         <option value="">Select</option>
         <?php
		 if($category_id > 0 ){
			 $rsdata=get_db_multiple_row("tbl_brand","id,brand_name","status ='1' AND FIND_IN_SET('$category_id',cat_ids)"); 
         if(is_array($rsdata) && !empty($rsdata)){
	         foreach($rsdata as $brval){
				 $brandID=($this->input->post('brand_id')!='')?$this->input->post('brand_id'):$res['brand'];
		         ?>
		         <option value=" <?php echo $brval['id'];?>" <?php if($brandID==$brval['id']){ echo "Selected";}?>><?php echo $brval['brand_name'];?></option>
		         <?php
	         }
		   }
         }?>
        </select><?php echo form_error('brand_id'); ?>
       </td>
      </tr>
     
      <!-- <tr class="trOdd">
       <td align="right" ><span class="required">*</span> Low Stock :</td>
       <td align="left"><input name="low_stock" id="low_stock" type="text" value="<?php echo set_value("low_stock",$res["low_stock"])?>" maxlength="3">
       </td>
      </tr>-->
       <tr class="trOdd">
       <td align="right" ><span class="required">*</span> Stock Avilable:</td>
       <td align="left"><input name="stock_value" id="stock_value" type="text" value="<?php echo set_value("stock_value",$res["quantity"])?>" maxlength="3"><?php echo form_error('stock_value'); ?>
       </td>
      </tr>
      
			<tr class="trOdd buyp">
			 <td height="26" align="right" ><span class="required">*</span> Price:</td>
			 <td align="left"><input type="text" name="product_price" size="40" maxlength=8 value="<?php echo $res['product_price'];?>"> Maximum of 5 digits<?php echo form_error('product_price'); ?></td>
			</tr>
           
			<tr class="trOdd buyp">
			 <td height="26" align="right" ><span class="required">**</span> Discounted price:</td>
			 <td align="left"><input type="text" name="product_discounted_price" size="40" maxlength=8 value="<?php echo $res['product_discounted_price'];?>"> Maximum of 5 digits</td>
			</tr>
            
         <?php
		 $is_gift=($this->input->post('is_gift')!='')?$this->input->post('is_gift'):$res['is_gift'];
		 ?>   
            <tr class="trOdd buyp">
			 <td align="right"><span class="required">**</span>Set as Gift :</td>
			 <td align="left"><input type="radio" name="is_gift" value="1" <?php if($is_gift==1 ){ echo "checked";}?> />No&nbsp;
             <input type="radio" name="is_gift" value="2" <?php if($is_gift==2 ){ echo "checked";}?>/>Yes
             </td>
			</tr>
           <?php
		 $is_sale=($this->input->post('is_sale')!='')?$this->input->post('is_sale'):$res['is_sale'];
		 ?>  
            <tr class="trOdd buyp">
			 <td align="right"><span class="required">**</span>Product for sale :</td>
			 <td align="left"><input type="radio" name="is_sale" value="1" <?php if($is_sale==1 ){ echo "checked";}?> />No&nbsp;
             <input type="radio" name="is_sale" value="2" <?php if($is_sale==2 ){ echo "checked";}?>/>Yes
             </td>
			</tr>
            <?php
		 $gifywrap_price=($this->input->post('gifywrap_price')!='')?$this->input->post('gifywrap_price'):(($res['gifywrap_price']>0)?$res['gifywrap_price']:'');
		 ?> 
            <tr class="trOdd buyp">
			 <td align="right"><span class="required">**</span>Gift Wrap price :</td>
			 <td align="left"><input name="gifywrap_price" id="gifywrap_price" type="text" value="<?php echo set_value("gifywrap_price",$gifywrap_price)?>" maxlength="7">
             </td>
			</tr>
            
            <?php
			 $featured_product=($this->input->post('featured_product')!='')?$this->input->post('featured_product'):$res['featured_product'];
			 ?>
			
            <tr class="trOdd buyp">
			 <td align="right"><span class="required">**</span>Featured product :</td>
			 <td align="left"><input type="radio" name="featured_product" value="0" <?php if($featured_product==0 ){ echo "checked";}?> />No&nbsp;
             <input type="radio" name="featured_product" value="1" <?php if($featured_product==1 ){ echo "checked";}?>/>Yes
             </td>
			</tr>
            
            <?php
			 $hot_deals=($this->input->post('hot_deals')!='')?$this->input->post('hot_deals'):$res['hot_deals'];
			 ?>
            <tr class="trOdd buyp">
			 <td align="right"><span class="required">**</span>Hot Products :</td>
			 <td align="left"><input type="radio" name="hot_deals" value="0" <?php if($hot_deals==0 ){ echo "checked";}?> />No&nbsp;
             <input type="radio" name="hot_deals" value="1" <?php if($hot_deals==1 ){ echo "checked";}?>/>Yes
             </td>
			</tr>
            <?php
			 $new_arrival=($this->input->post('new_arrival')!='')?$this->input->post('new_arrival'):$res['new_arrival'];
			 ?>
            <tr class="trOdd buyp">
			 <td align="right"><span class="required">**</span>New Arrivals :</td>
			 <td align="left"><input type="radio" name="new_arrival" value="0" <?php if($new_arrival==0 ){ echo "checked";}?> />No&nbsp;
             <input type="radio" name="new_arrival" value="1" <?php if($new_arrival==1 ){ echo "checked";}?>/>Yes
             </td>
			</tr>
            
			<tr class="trOdd">
			 <td align="right"> Product Sizes :</td>
			 <td align="left">
			  <div style='width:380px; height:100px; overflow-x:hidden; overflow-y:scroll; border:1px solid gray'>
			   <table width="100%" cellpadding="0" cellspacing="0">
			    <?php
			    $sarray=array();
			    if(is_array($size_array)){
					foreach($size_array as $key=>$val){
						$sarray[]=$val["id"];
					}
				}
			    $sarray=($sarray)?$sarray:array();
			    if(is_array($sizes) && !empty($sizes)){
				    foreach($sizes as $val){
					    ?>
					    <tr><td width="95%"> <input type="checkbox" name="size_id[]" id="size_id" value="<?php echo $val['id'];?>" <?php echo in_array($val['id'],$sarray) ? ' checked="checked"' : '';?>  /><?php echo $val['size_name'];?></td></tr>
					    <?php
				    }
			    }?>
			   </table>
			  </div>
			 </td>
			</tr>
			<tr class="trOdd">
			 <td align="right"> Product Colors :</td>
			 <td align="left">
			  <div style='width:380px; height:100px; overflow-x:hidden; overflow-y:scroll; border:1px solid gray'>
			   <table width="100%" cellpadding="0" cellspacing="0">
			    <?php
			    $carray=array();
			    if(is_array($color_array)){
					foreach($color_array as $key=>$val){
						$carray[]=$val["id"];
					}
				}
			    $carray=($carray)?$carray:array();
			    if(is_array($colors) && !empty($colors)){
				    foreach($colors as $val){
					    ?>
					    <tr><td width="95%"> <input type="checkbox" name="color_id[]" id="color_id" value="<?php echo $val['id'];?>" <?php echo in_array($val['id'],$carray) ? ' checked="checked"' : '';?>  /><?php echo $val['color_name'];?></td></tr>
					    <?php
				    }
			    }?>
			   </table>
			  </div>
			 </td>
			</tr>
                       
            
            
			<tr class="trOdd">
			 <td height="26" align="right" ><span class="required">*</span> Description:</td>
			 <td align="left"><textarea name="products_description" rows="5" cols="50" id="description"><?php echo $res['products_description'];?></textarea> <?php  echo display_ckeditor($ckeditor);?><?php echo form_error('products_description'); ?></td>
			</tr>
			 <?php /*?><tr class="trOdd">
			 <td align="right" >Return Policy :</td>
			 <td align="left"><textarea name="return_policy" rows="5" cols="50" id="return_policy"><?php echo set_value('return_policy',$res['return_policy']!=0)?$res['return_policy']:"";?></textarea><?php echo display_ckeditor($ckeditor1);?></td>
			</tr><?php */?>
			<tr class="trOdd">
			 <td align="left">&nbsp;</td>
			 <td align="left"><input type="hidden" name="products_id" value="<?php echo $res['products_id'];?>">
              <input type="hidden" name="action" value="editproduct" />
             </td>
			</tr>
		 </table>
		</div>
		<div id="tab-image">
		 <input type="hidden" name="product_exclude_images_ids" value="" id="product_exclude_images_ids" />
		 <table id="images" class="list">
		  <thead><tr><td class="left">Image</td></tr></thead>
		  <table id="images" class="form">
		   <?php
		   //trace($res_photo_media);
		   $j=0;
		   for($i=1;$i<=$this->config->item('total_product_images');$i++){
			   $product_img  = @$res_photo_media[$j]['media'];
			   $product_path = "products/".$product_img;
			   $product_img_auto_id  = @$res_photo_media[$j]['id'];
			   ?>
			   <tr>
			    <td width="28%" align="right" ><span class="required">**</span> Image <?php echo $i;?></td>
			    <td width="2%" height="26" align="center" >:</td>
			    <td align="left">
			     <input type="file" name="product_images<?php echo $i;?>" />
			     <?php
			     if( $product_img!='' && file_exists(UPLOAD_DIR."/".$product_path) ){
				     ?>
				     <a href="javascript:void(0);"  onclick="$('#dialog_<?php echo $j;?>').dialog({width:'auto'});">View</a>
				     | <input type="checkbox" name="product_img_delete[<?php echo $product_img_auto_id;?>]" value="Y" />Delete <?php 
			     }?><br /><br />[ <?php echo $this->config->item('product.best.image.view');?> ]

			     <div id="dialog_<?php echo $j;?>" title="Product Image" style="display:none;"><img src="<?php echo base_url().'uploaded_files/'.$product_path;?>"  /> </div>
			     <input type="hidden" name="media_ids[]" value="<?php echo $product_img_auto_id;?>" />
			    </td>
			   </tr>
			   <?php
			   $j++;
		   }?>
		  
		  </table>
		  <tfoot></tfoot>
		 </table>
		</div>
		<?php echo form_close();?>
	 </div>
	</div>
 </div>
</div>

<script type="text/javascript"><!--
$('#tabs a').tabs();
$('#languages a').tabs();
$('#vtab-option a').tabs();
//-->
$('#product_exclude_images_ids').val('');
function delete_product_images(img_id)
{
	//alert($('#product_exclude_images_ids').val());
	img_id = img_id.toString();
	exclude_ids1 = $('#product_exclude_images_ids').val();
	exclude_ids1_arr = exclude_ids1=='' ? Array() : exclude_ids1.split(',');

	if($.inArray(img_id,exclude_ids1_arr)==-1){
		exclude_ids1_arr.push(img_id);
	}

	exclude_ids1 =  exclude_ids1_arr.join(',');

	$('#product_exclude_images_ids').val(exclude_ids1);
	$('#product_image'+img_id).remove();
	$('#del_img_link_'+img_id).remove();

	alert($('#product_exclude_images_ids').val());
}

</script>
<?php $default_date = date('Y-m-d',strtotime(date('Y-m-d',time())));?>
<script type="text/javascript">
$(document).ready(function(){
  $('.start_date,.end_date').live('click',function(e){
		e.preventDefault();
		cls = $(this).hasClass('start_date') ? 'start_date1' : 'end_date1';
		$('.'+cls+':eq(0)').focus();
	});
	$( ".start_date1").live('focus',function(){
		$(this).datepicker({
			showOn: "focus",
			dateFormat: 'yy-mm-dd',
			changeMonth: true,
			changeYear: true,
			defaultDate: 'y',
			buttonText:'',
			minDate:'<?php echo $default_date;?>' ,
			maxDate:'<?php echo date('Y-m-d',strtotime(date('Y-m-d',time())."+180 days"));?>',
			yearRange: "c-100:c+100",
			buttonImageOnly: true,
			onSelect: function(dateText, inst) {
				$('.start_date1').val(dateText);
				$( ".end_date1").datepicker("option",{
					minDate:dateText ,
					maxDate:'<?php echo date('Y-m-d',strtotime(date('Y-m-d',time())."+180 days"));?>',
				});			
			}
		});
	});
	$( ".end_date1").live('focus',function(){
		$(this).datepicker({
			showOn: "focus",
			dateFormat: 'yy-mm-dd',
			changeMonth: true,
			changeYear: true,
			defaultDate: 'y',
			buttonText:'',
			minDate:'<?php echo $default_date;?>' ,
			maxDate:'<?php echo date('Y-m-d',strtotime(date('Y-m-d',time())."+365 days"));?>',
			yearRange: "c-100:c+100",
			buttonImageOnly: true,
			onSelect: function(dateText, inst) {
				$('.end_date1').val(dateText);
			}
		});
	});
});
</script>
<?php $this->load->view('includes/footer');?>