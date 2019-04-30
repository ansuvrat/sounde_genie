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
    
   </div>
   <div class="content">
    <?php
    if(error_message() !=''){
	    echo error_message();
    }?>
    <script type="text/javascript">function serialize_form() { return $('#pagingform').serialize();   } </script>
    
		<div class="required"> <?php echo $category_result_found; ?></div>
		<?php
		if( is_array($res) && !empty($res) ){
			echo form_open(current_url_query_string(),'id="data_form"');
			?>
			<table class="list" width="100%" id="my_data">
			 <thead>
			  <tr>
			   <td width="4%" style="text-align: center;">Sn.</td>
			   <td width="23%"  class="left">Product Name</td>
			   <td width="16%" class="left">Product Code</td>
			   <td width="11%" class="right">Price</td>			
			   <td width="13%" class="left">Product Picture</td>
			   <td width="12%" class="left">Details</td>
			   <td width="9%" class="center">Status</td>
			  </tr>
			 </thead>
			 <tbody>
			  <?php
			  $atts = array(
				'width'      => '540',
				'height'     => '400',
				'scrollbars' => 'yes',
				'status'     => 'yes',
				'resizable'  => 'yes',
				'screenx'    => '0',
				'screeny'    => '0'
				);
			  
			  $bgc='';
			  $ctr=1;
			  
			  foreach($res as $catKey=>$pageVal){
				  $postdt=explode(' ',$pageVal['product_added_date']);
                                   $cond="AND products_id='".$pageVal['products_id']."'";
                                   
								 //$productImage = productFirstImage($pageVal['products_id']); 
								 $productImage =$pageVal['media'];	
				  ?>
                  <tr>
				   <td style="text-align: center;"><?php echo $ctr;?>
				   </td>
				   <td class="left" valign="top">
                   
				    <?php echo $pageVal['product_name'];?>
                 
                    
				   </td>
				   <td class="left" valign="top"><?php echo $pageVal['product_code'];?>
                   <?php
					
					      echo "<br><br><span class='red b'>Stock : </span>".$pageVal['quantity'];	
					?>
                    <br /><?php echo anchor_popup('sitepanel/products/updatestock/'.$pageVal['products_id'], 'Update Stock!', $atts);?>
                   </td>
                   
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
				    <a href="<?php echo site_url("products/detail/".$pageVal['products_id']);?>" target="_blank">View Details</a>
				   
				   </td> 
				   <td class="center" valign="top"><?php echo ($pageVal['status']==1)? "Active":"In-active";?>
					
				   </td>
				   
				  </tr>
                  
				  <?php
			      $ctr++;
				 }?>
			 </tbody>
			</table>
			<?php if($page_links!=''){?>
			<table class="list" width="100%">
			 <tr><td align="right" height="30"><?php echo $page_links; ?></td></tr>
			</table>
			<?php }?>
			
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