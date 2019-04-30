<?php $this->load->view('includes/header');?>
<div class="content">
 <div id="content">
  <div class="breadcrumb">
   <?php echo anchor('sitepanel/dashbord','Home');
   $segment=4;
   $catid = (int)$this->input->get_post('category_id');
   if($catid ){
	   echo admin_category_breadcrumbs($catid,$segment);
   }else{
	   echo '<span class="pr2 fs14">»</span> Products ';
   }
	$seg=$this->uri->rsegment(2);
   ?>
  </div>
  <div class="box">
   <div class="heading">
    <h1><img src="<?php echo base_url(); ?>assets/sitepanel/image/category.png" alt="" /> <?php echo $heading_title; ?></h1>
    <div class="buttons"><a href="<?php echo base_url();?>sitepanel/products/add/<?php echo $this->input->get('category_id');?>" class="button">Add product</a></div>
   </div>
   <div class="content">
    <?php
    if(error_message() !=''){
	    echo error_message();
    }?>
    <script type="text/javascript">function serialize_form() { return $('#pagingform').serialize();   } </script>
    <?php echo form_open("",'id="search_form" method="get" ');
    if($this->input->get_post('category_id') > 0 ){
		$category_id=$this->input->get_post('category_id');
		$rwbrand=$rsdata=get_db_multiple_row("tbl_brand","id,brand_name","status ='1' AND FIND_IN_SET('$category_id',cat_ids)");
	}else{
		$rwbrand=$rsdata=get_db_multiple_row("tbl_brand","id,brand_name","status ='1' ");
	}
	?>
    <div align="right" class="breadcrumb"> Records Per Page : <?php echo display_record_per_page();?> </div>
    <table width="100%"  border="0" cellspacing="3" cellpadding="3" >
     <tr>
      <td align="center" >
        <table width="50%" border="0">
            <tr>
            	<td width="40%">Search [ product name,product code ]</td>
                <td width="60%"><input type="text" name="keyword" value="<?php echo $this->input->get_post('keyword');?>" size="60"  /></td>
            </tr>
            <tr>
            	<td>Status</td>
                <td><select name="status">
        <option value="">Status</option>
        <option value="1" <?php echo $this->input->get_post('status')==='1' ? 'selected="selected"' : '';?>>Active</option>
        <option value="0" <?php echo $this->input->get_post('status')==='0' ? 'selected="selected"' : '';?>>In-active</option>
       </select></td>
            </tr>
            <tr>
            	<td>Brand</td>
                <td><select name="brandID">
        <option value="">Select Brand</option>
         <?php if(is_array($rwbrand) && count($rwbrand) > 0 ){
			  foreach($rwbrand as $brVal){ ?>
                <option value="<?php echo $brVal['id'];?>" <?php if($this->input->get_post('brandID')==$brVal['id']){ echo "Selected";}?>><?php echo $brVal['brand_name'];?></option>
         <?php }
		 }
		 ?>
       </select></td>
            </tr>
            
            <tr>
            	<td>Product for sale</td>
                <td><select name="prdsaleID">
                    <option value="">Select Product for sale</option>
                    <option value="1" <?php if($this->input->get_post('prdsaleID')==1){ echo "Selected";}?>>No</option>
                    <option value="2" <?php if($this->input->get_post('prdsaleID')==2){ echo "Selected";}?>>Yes</option>
                   </select></td>
            </tr>
            
            <tr>
            	<td>Product for gift</td>
                <td><select name="prdgiftID">
                    <option value="">Select Product for gift</option>
                    <option value="1" <?php if($this->input->get_post('prdgiftID')==1){ echo "Selected";}?>>No</option>
                    <option value="2" <?php if($this->input->get_post('prdgiftID')==2){ echo "Selected";}?>>Yes</option>
                   </select></td>
            </tr>
            
            <tr>
            	<td></td>
                <td><input type="hidden" name="category_id" value="<?php echo $this->input->get_post('category_id');?>"  />
       <input type="hidden" name="brand_id" value="<?php echo $this->input->get_post('brand_id');?>"  />
       <a  onclick="$('#search_form').submit();" class="button"><span> GO </span></a>
       <?php
       if( $this->input->get_post('keyword')!='' || $this->input->get_post('status')!='' || $this->input->get_post('category_id')!='' || $this->input->get_post('brand_id')!='' ){
	       if($this->input->get_post('category_id')!=''){
		       $search_category=$this->input->get_post('category_id');
		       //echo anchor("sitepanel/products?category_id=".$search_category,'<span>Clear Search</span>');
	       }else{
		       echo anchor("sitepanel/products/$seg",'<span>Clear Search</span>');
	       }
       }?></td>
            </tr>
        </table>

      
       &nbsp;
       
      
       
      </td>
		</tr>
		</table>

		<?php echo form_close();?>
		<div class="required"> <?php echo $category_result_found; ?></div>
		<?php
		if( is_array($res) && !empty($res) ){
			echo form_open(current_url_query_string(),'id="data_form"');
			?>
			<table class="list" width="100%" id="my_data">
			 <thead>
			  <tr>
			   <td width="4%" style="text-align: center;"><input type="checkbox" onclick="$('input[name*=\'arr_ids\']').attr('checked', this.checked);" /></td>
			   <td width="23%"  class="left">Product Name</td>
			   <td width="16%" class="left">Product Code</td>
               <!--<td width="12%" class="left">No. of<br />Product</td>-->
			   <td width="11%" class="right">Price</td>			
			   <td width="13%" class="left">Product Picture</td>
			   <td width="12%" class="left">Details</td>
			   <td width="9%" class="center">Status</td>
			   <td width="12%" class="center">Action</td>
			  </tr>
			 </thead>
			 <tbody>
			  <?php
			  $atts = array(
				'width'      => '740',
				'height'     => '600',
				'scrollbars' => 'yes',
				'status'     => 'yes',
				'resizable'  => 'yes',
				'screenx'    => '0',
				'screeny'    => '0'
				);
			  $atts_edit = array(
			  'width'      => '525',
			  'height'     => '375',
			  'scrollbars' => 'no',
			  'status'     => 'no',
			  'resizable'  => 'no',
			  'screenx'    => '0',
			  'screeny'    => '0'
			  );
			  $bgc='';
			  foreach($res as $catKey=>$pageVal){
				  $postdt=explode(' ',$pageVal['product_added_date']);
                                   $cond="AND products_id='".$pageVal['products_id']."'";
                                   
								 //$productImage = productFirstImage($pageVal['products_id']); 
								 $productImage =$pageVal['media'];	
				  ?>
                  <tr>
				   <td style="text-align: center;"><input type="checkbox" name="arr_ids[]" value="<?php echo $pageVal['products_id'];?>" />
				   </td>
				   <td class="left" valign="top">
                   
				    <?php echo $pageVal['product_name'];?>
                 
                    <?php
				    $product_set_in = array();
				    if($pageVal['featured_product']!="" && $pageVal['featured_product']!='0')
				    $product_set_in[]="<b>Featured  : </b> Yes";
					if($pageVal['hot_deals']!="" && $pageVal['hot_deals']!='0')
				    $product_set_in[]="<b>Hot Products  : </b> Yes";
					if($pageVal['new_arrival']!="" && $pageVal['new_arrival']!='0')
				    $product_set_in[]="<b>New Arrivals  : </b> Yes";
				    
				     if($pageVal['is_sale']==2 )
				     $product_set_in[]="<b>Product for sale : </b> Yes";
                    
					if($pageVal['is_gift']==2)
				    $product_set_in[]="<b>Product for gift : </b> Yes";
				    if(!empty($product_set_in))
				    {
					    echo "<br /><br />";
					    echo implode("<br>",$product_set_in)."<br />";
				    }?>
				    <div id="dialog_<?php echo $pageVal['products_id'];?>" title="Description" style="display:none;"><?php echo $pageVal['products_description'];?></div>
				   </td>
				   <td class="left" valign="top"><?php echo $pageVal['product_code'];?>
                   <?php
					 if($pageVal['quantity']==0){
					      echo "<br><br><span class='red b'>Out of stock</span>";	
					}?>
                   </td>
                   <!--<td class="left" valign="top"><?php echo ($stock_cnt>0)?$stock_cnt:0;?></td>-->
				   <td align="right" valign="top">
				    <?php if($pageVal['product_discounted_price']>0){?>
				    <span style="text-decoration: line-through;"><?php echo $pageVal['product_price'];?></span><br>
				    <span style="color: #b00;"><?php echo $pageVal['product_discounted_price'];?></span>
				    <?php }else{?>
				    <span><?php echo $pageVal['product_price'];?></span>
				    <?php }?>
                    
				   <?php if($pageVal['gifywrap_price'] > 0 ){
					  echo "<br><strong><font color='#0000FF'>Gift wrap price :</font></strong>".$pageVal['gifywrap_price']; 
				   }?>
				   </td>
				   
				   <td align="center" valign="top"><img src="<?php echo get_image('products',$productImage,50,50,'AR');?>" /></td>
				   <td class="left" valign="top">
				    <a href="#"  onclick="$('#dialog_<?php echo $pageVal['products_id'];?>').dialog( {width: 650} );">View Details</a>
				    <?php /*?><br />	<br /><a href="<?php echo base_url().'sitepanel/products/prd_stock_list/'.$pageVal['products_id']?>">Manage Stock</a>
				    <br /><br />
				    <a href="<?php echo base_url();?>sitepanel/products/colorimg/<?php echo $pageVal['products_id']?>/?category_id=<?php echo $pageVal['category_id'];?>">View Color Image</a><?php */?>
				   </td> 
				   <td class="center" valign="top"><?php echo ($pageVal['status']==1)? "Active":"In-active";?>
					
				   </td>
				   <td align="center" valign="top">
				    <p><?php echo anchor("sitepanel/products/edit/$pageVal[products_id]/".query_string(),'Edit');?></p>
				    <p><?php echo anchor_popup('sitepanel/products/related/'.$pageVal['products_id'], 'Add Related Products', $atts);?></p>
				    <p><?php echo anchor_popup('sitepanel/products/view_related/'.$pageVal['products_id'], 'View Related Products', $atts);?></p>
				   </td>
				  </tr>
                  
				  <?php
			  }?>
			 </tbody>
			</table>
			<?php if($page_links!=''){?>
			<table class="list" width="100%">
			 <tr><td align="right" height="30"><?php echo $page_links; ?></td></tr>
			</table>
			<?php }?>
			<table class="list" width="100%">
			 <tr>
			  <td align="left" colspan="11" style="padding:2px" height="35">
			   
			   <input name="status_action" type="submit"  value="Activate" class="button2" id="Activate" onclick="return validcheckstatus('arr_ids[]','Activate','Record','u_status_arr[]');"/>
			   
			   <input name="status_action" type="submit" class="button2" value="Deactivate" id="Deactivate"  onclick="return validcheckstatus('arr_ids[]','Deactivate','Record','u_status_arr[]');"/>

			    

			   
			   <input name="status_action" type="submit" class="button2" id="Delete" value="Delete"  onclick="return validcheckstatus('arr_ids[]','delete','Record');"/>
               
               
               
               
			   <?php 
				   echo form_dropdown("set_as",$this->config->item('product_set_as_config'),$this->input->post('set_as'),'style="width:120px;" onchange="return onclickgroup()"');
				   echo form_dropdown("unset_as",$this->config->item('product_unset_as_config'),$this->input->post('unset_as'),'style="width:120px;" onchange="return onclickgroup()"');
			   ?>
			  </td>
			 </tr>
			</table>
			<?php
			echo form_close();
		}else{
			echo "<center><strong> No record(s) found !</strong></center>" ;
		}?>
	 </div>
	</div>
 </div>	 
</div>
<script type="text/javascript">
function onclickgroup(){
	if(validcheckstatus('arr_ids[]','set','record','u_status_arr[]')){
		$('#data_form').submit();
	}
}
</script>
<?php $this->load->view('includes/footer');?>