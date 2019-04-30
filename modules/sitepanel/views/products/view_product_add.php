<?php $this->load->view('includes/header');
$pcatID =($this->uri->segment(4) > 0)? $this->uri->segment(4):"0";
$pcatID = (int) $pcatID;

$values_posted_back=(is_array($this->input->post())) ? TRUE : FALSE;
$availability_till_date = $this->input->post('availability_till_date');
?>

<div class="content">
 <div id="content">
  <div class="breadcrumb"><?php echo anchor('sitepanel/dashbord','Home'); ?> &raquo; <?php echo anchor('sitepanel/products','Back To Listing');?> &raquo; <?php echo $heading_title;?></div>
  <div class="box">
   <div class="heading">
    <h1><img src="<?php echo base_url(); ?>assets/sitepanel/image/category.png" alt="" /> <?php echo $heading_title;?></h1>
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
    echo form_open_multipart('sitepanel/products/add/',array('id'=>'form'));?>

    <div id="tab-general">
     <table width="100%"  class="form"  cellpadding="3" cellspacing="3">
      <tr><th colspan="3" align="right"><span class="required">*Required Fields</span><br><span class="required">**Conditional Fields</span></th></tr>
      <tr><th colspan="3" align="center" > </th></tr>
      <?php
      $selcatID = ($this->input->post('category_id')!='') ? $this->input->post('category_id'): $pcatID;
      $selcatID = (int) $selcatID;
      ?>
      
      <tr class="trOdd">
       <td align="right" valign="top" ><span class="required">*</span> Category :</td>
       <td align="left">
       
        <select name="category_id" style="width:380px;"  size="10" onchange="validatebrand(this.value)">
         <?php echo get_nested_dropdown_menu(0,$selcatID);?>
        </select><?php echo form_error('category_id'); ?>
       </td>
      </tr>
      
      <?php
			$default_params = array(
								'heading_element' => array(
														  'field_heading'=>"Name",
														  'field_name'=>"product_name",
														  'field_placeholder'=>"Your Product Name",
														  'exparams' => 'size="40"'
														),
								'url_element'  => array(
														  'field_heading'=>"Page URL",
														  'field_name'=>"friendly_url",
														  'field_placeholder'=>"Your Page URL",
														  'exparams' => 'size="40"',
														  'pre_seo_url' =>'',
														  'pre_url_tag'=>FALSE
													   )

							  );
			
			seo_add_form_element($default_params);
			?>
			
			
      
      <tr class="trOdd">
       <td align="right" ><span class="required">*</span> Product Code :</td>
       <td align="left"><input type="text" name="product_code" size="70" value="<?php echo set_value('product_code');?>" /><?php echo form_error('product_code'); ?></td>
      </tr>        
	<tr class="trOdd">
       <td align="right" valign="top" ><span class="required">*</span> Brand :</td>
       <td align="left" >
        <select name="brand_id" style="width:380px;"  size="1" id="carbrandID">
         <option value="">Select</option>
         <?php
		 if($this->input->post('category_id') > 0 ){
			 $categoryID=$this->input->post('category_id');
			 $rsdata=get_db_multiple_row("tbl_brand","id,brand_name","status ='1' AND FIND_IN_SET('$categoryID',cat_ids)"); 
         if(is_array($rsdata) && !empty($rsdata)){
	         foreach($rsdata as $brval){
		         ?>
		         <option value=" <?php echo $brval['id'];?>" <?php if($this->input->post('brand_id')==$brval['id']){ echo "Selected";}?>><?php echo $brval['brand_name'];?></option>
		         <?php
	         }
		   }
         }?>
        </select><?php echo form_error('brand_id'); ?>
       </td>
      </tr>
      <!--<tr class="trOdd stock_section">
       <td align="right" ><span class="required">*</span>Low Stock: :</td>
       <td align="left"><input name="low_stock" id="low_stock" type="text" value="<?php echo set_value("low_stock")?>" maxlength="3"><?php echo form_error('low_stock'); ?></td>
      </tr> -->
      <tr class="trOdd stock_section">
       <td align="right" ><span class="required">*</span>Stock Avilable:</td>
       <td align="left"><input name="stock_value" id="stock_value" type="text" value="<?php echo set_value("stock_value")?>" maxlength="3"><?php echo form_error('stock_value'); ?></td>
      </tr>
    
    
      <tr class="trOdd buyp">
       <td align="right" ><span class="required">*</span> Price :</td>
       <td align="left"><input type="text" name="product_price" size="70" maxlength=8 value="<?php echo set_value('product_price');?>"> Maximum of 5 digits <?php echo form_error('product_price'); ?></td>
      </tr>
			<tr class="trOdd buyp">
			 <td align="right"><span class="required">**</span> Discounted Price :</td>
			 <td align="left"><input type="text" name="product_discounted_price" size="70" maxlength=8 value="<?php echo set_value('product_discounted_price');?>"> Maximum of 5 digits</td>
			</tr>
            
            <tr class="trOdd buyp">
			 <td align="right"><span class="required">**</span>Set as Gift :</td>
			 <td align="left"><input type="radio" name="is_gift" value="1" <?php if($this->input->post('is_gift')==1 || $this->input->post('is_gift') ==''){ echo "checked";}?> />No&nbsp;
             <input type="radio" name="is_gift" value="2" <?php if($this->input->post('is_gift')==2 ){ echo "checked";}?>/>Yes
             </td>
			</tr>
                       
            
            <tr class="trOdd buyp">
			 <td align="right"><span class="required">**</span>Gift Wrap price :</td>
			 <td align="left"><input name="gifywrap_price" id="gifywrap_price" type="text" value="<?php echo set_value("gifywrap_price")?>" maxlength="7">
             </td>
			</tr>
            
            
            <tr class="trOdd buyp">
			 <td align="right"><span class="required">**</span>Product for sale :</td>
			 <td align="left"><input type="radio" name="is_sale" value="1" <?php if($this->input->post('is_sale')==1 || $this->input->post('is_sale') ==''){ echo "checked";}?> />No&nbsp;
             <input type="radio" name="is_sale" value="2" <?php if($this->input->post('is_sale')==2 ){ echo "checked";}?>/>Yes
             </td>
			</tr>
            
            <tr class="trOdd buyp">
			 <td align="right"><span class="required">**</span>Featured product :</td>
			 <td align="left"><input type="radio" name="featured_product" value="0" <?php if($this->input->post('featured_product')==0 || $this->input->post('featured_product') ==''){ echo "checked";}?> />No&nbsp;
             <input type="radio" name="featured_product" value="1" <?php if($this->input->post('featured_product')==1 ){ echo "checked";}?>/>Yes
             </td>
			</tr>
            
            
            <tr class="trOdd buyp">
			 <td align="right"><span class="required">**</span>Hot Products :</td>
			 <td align="left"><input type="radio" name="hot_deals" value="0" <?php if($this->input->post('hot_deals')==0 || $this->input->post('hot_deals') ==''){ echo "checked";}?> />No&nbsp;
             <input type="radio" name="hot_deals" value="1" <?php if($this->input->post('is_sale')==1 ){ echo "checked";}?>/>Yes
             </td>
			</tr>
            
            <tr class="trOdd buyp">
			 <td align="right"><span class="required">**</span>New Arrivals :</td>
			 <td align="left"><input type="radio" name="new_arrival" value="0" <?php if($this->input->post('new_arrival')==0 || $this->input->post('new_arrival') ==''){ echo "checked";}?> />No&nbsp;
             <input type="radio" name="new_arrival" value="1" <?php if($this->input->post('new_arrival')==1 ){ echo "checked";}?>/>Yes
             </td>
			</tr>
			
			<tr class="trOdd">
			 <td align="right"> Product Sizes :</td>
			 <td align="left">
			  <div style='width:380px; height:100px; overflow-x:hidden; overflow-y:scroll; border:1px solid gray'>
			   <table width="100%" cellpadding="0" cellspacing="0">
			    <?php
			    $selected_size=($this->input->post('size_id'))?$this->input->post('size_id'):array();
			    if(is_array($sizes) && !empty($sizes)){
				    foreach($sizes as $val){
					    ?>
					    <tr><td width="95%"> <input type="checkbox" class="checkb" name="size_id[]" id="size_id" value="<?php echo $val['id'];?>" <?php echo in_array($val['id'],$selected_size) ? ' checked="checked"' : '';?>  /><?php echo $val['size_name'];?></td></tr>
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
			    $selected_color=($this->input->post('color_id'))?$this->input->post('color_id'):array();
			    if(is_array($colors) && !empty($colors)){
				    foreach($colors as $val){
					    ?>
					    <tr><td width="95%"> <input type="checkbox" class="checkb" name="color_id[]" id="color_id" value="<?php echo $val['id'];?>" <?php echo in_array($val['id'],$selected_color) ? ' checked="checked"' : '';?>  /><?php echo $val['color_name'];?></td></tr>
					    <?php
				    }
			    }?>
			   </table>
			  </div>
			 </td>
			</tr>
            
            
			<tr class="trOdd">
			 <td align="right" ><span class="required">*</span>Description :</td>
			 <td align="left"><textarea name="products_description" rows="5" cols="50" id="description"><?php echo set_value('products_description');?></textarea><?php echo display_ckeditor($ckeditor);?><?php echo form_error('products_description'); ?></td>
			</tr>
			<tr class="trOdd">
			 <td align="left">&nbsp;</td>
			 <td align="left">&nbsp;</td>
			 <td align="left">
			  <input type="hidden" name="action" value="addnews" />
			  <input type="hidden" name="pcatID" value="<?php echo $pcatID;?>" />
			 </td>
			</tr>
     </table>
    </div>
    <div id="tab-image">
     <table id="images" class="form">
      <?php for($i=1;$i<=$this->config->item('total_product_images');$i++){?>
      <tr>
       <td width="28%" align="right" ><span class="required">**</span>Image <?php echo $i;?></td>
       <td width="2%" height="26" align="center" >:</td>
       <td align="left"><input type="file" name="product_images<?php echo $i;?>" /><br />[ <?php echo $this->config->item('product.best.image.view');?> ] </td>
      </tr>
      <?php }?>
      <tr class="trOdd">
			 <td height="26" align="right" >Alt Tag Text</td>
			 <td height="26" align="center" >:</td>
			 <td align="left"><input type="text" name="product_alt" size="40" value="<?php echo set_value('product_alt');?>"></td>
			</tr>
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
//--></script>
<?php
$default_date = date('Y-m-d',strtotime(date('Y-m-d',time())));
$selected_date = $availability_till_date=='' ? $default_date : $availability_till_date;
?>
<script type="text/javascript">
$(document).ready(function(){
    $('input.checkb')
    var checked_length = $('input.checkb:checked').length;
     if(checked_length > 0)
        {
            $('.stock_section').hide();
        }
        else
        {
             $('.stock_section').show();
        }
   $('.checkb').change(function(){
       checked_length = $('input.checkb:checked').length;
       if(checked_length > 0)
       {
           $('.stock_section').hide();
       }
       else
       {
            $('.stock_section').show();
       }
   });
  var checkedlength = 
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