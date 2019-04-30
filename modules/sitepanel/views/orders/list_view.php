<?php $this->load->view('datepicker_js_include');?>
<script type="text/javascript">
$(function() {
$( ".from_date" ).datepicker({
		dateFormat: "yy-mm-dd",
		minDate: "-10y +0w",
		maxDate:"+0m +0w"
});
$( ".to_date" ).datepicker({
		dateFormat: "yy-mm-dd",
		minDate: "-10y +0w",
		maxDate:"+0m +0w"
});
});
</script>

<div id="content">
  
  <div class="breadcrumb">
  
       <?php echo anchor('sitepanel/dashbord','Home'); ?> &raquo; <?php echo $heading_title; ?> </a>   
             
   </div>      
       
 <div class="box">
 
    <div class="heading">
    
      <h1><img src="<?php echo base_url(); ?>assets/sitepanel/image/category.png" alt="" /> <?php echo $heading_title; ?></h1>
      
      
    </div>
		<div class="content">
		    <?php
				if(error_message() !='')
				{
					echo error_message();
				}
				echo form_open("sitepanel/orders/",'id="form" method="get" ');
				?>
        
         <div align="right" class="breadcrumb"> Records Per Page : <?php echo display_record_per_page();?> </div>
          
		<table width="100%"  border="0" cellspacing="3" cellpadding="3" >
		<tr>
			<td align="center" >Search [ Order No. ]
				<input type="text" name="keyword" value="<?php echo $this->input->get_post('keyword');?>"  />
        &nbsp;
        <input type="text" name="from_date" class="from_date" value="<?php echo $this->input->get_post('from_date');?>" style="width:100px;" placeholder="From Date"  />
        &nbsp;
        <input type="text" name="to_date" class="to_date" value="<?php echo $this->input->get_post('to_date');?>" style="width:100px;" placeholder="To Date"  />
        &nbsp;
        <select name="pay_mode">
        	<option value="">Payment Mode</option>
          <option value="COD" <?php echo ($this->input->get_post('pay_mode')=='COD')?'selected':'';?>>COD Orders</option>
          <option value="Net Banking"  <?php echo ($this->input->get_post('pay_mode')=='Net Banking')?'selected':'';?>>Net Banking Orders</option>
        </select>
        &nbsp;
        <select name="payment_status">
        	<option value="">Payment Status</option>
          <option value="0" <?php echo ($this->input->get_post('payment_status')==='0')?'selected':'';?>>Pending Orders</option>
          <option value="1"  <?php echo ($this->input->get_post('payment_status')=='1')?'selected':'';?>>Paid Orders</option>
        </select>
        
        <input type="hidden" name="couponcode" value="<?php echo $this->input->get_post('couponcode'); ?>" />
        
        &nbsp;
				<a  onclick="$('#form').submit();" class="button"><span> GO </span></a>
			
				<?php 
				if($this->input->get_post('keyword')!='' || $this->input->get_post('from_date')!='' || $this->input->get_post('to_date')!='' || $this->input->get_post('pay_mode')!='' || $this->input->get_post('payment_status')!=''){ 
					echo anchor("sitepanel/orders/",'<span>Clear Search</span>');
				} 
				?>
			</td>
		</tr>
		</table>
		<?php
		echo form_close();
		$j=0;
		if( is_array($res) && !empty($res) )
		{
			echo form_open("sitepanel/orders/",'id="myform"');
			?>
			<table class="list" width="100%" id="my_data">
			<thead>
			<tr>
				<td width="20" style="text-align: center;"><input type="checkbox" onclick="$('input[name*=\'arr_ids\']').attr('checked', this.checked);" /></td>
				<td width="191" class="left">Order Details</td>
        <td width="191" class="left">Shipping Address</td>
				<td width="80" class="right">Payment Status</td>
        <td width="80" class="right">Payment Mode</td>
				<td width="57" class="center">Order Date</td>
			</tr>
			</thead>
			<tbody>
			<?php
			$atts = array(
		'width'      => '900',
		'height'     => '500',
		'scrollbars' => 'yes',
		'status'     => 'yes',
		'resizable'  => 'yes',
		'screenx'    => '0',
		'screeny'    => '0'
		);	
			//trace($res);
		foreach($res as $catKey=>$pageVal)
		{ 
		 $email =get_db_field_value("tbl_users","username"," where  id ='".$pageVal['member_id']."'");
		?> 
			<tr>
				<td style="text-align: center;" valign="top">
					<input type="checkbox" name="arr_ids[]" value="<?=$pageVal['id'];?>" />
				</td>
				<td class="left" valign="top">
					<div><?php echo $pageVal['order_no'];?></div>
          <div style="padding-top:5px;">Order Price : <?php echo display_price($pageVal['order_price']);?></div>
          <div style="padding-top:5px;">Shipping Charge : <?php echo ($pageVal['shipping_charges']>0)?display_price($pageVal['shipping_charges']):'Free';?></div>
          <div style="padding-top:5px;">Coupon Discount : <?php echo ($pageVal['total_coupon_discount']>0)?display_price($pageVal['total_coupon_discount']):'NA';?></div>
          <div style="padding-top:5px;">Availed Points  : <?php echo ($pageVal['avail_credit_points_value']>0)?display_price($pageVal['avail_credit_points_value']):'NA';?></div>
          <?php
          if($pageVal['total_cod_charges']>0){
					?>
           <div style="padding-top:5px;">COD Charge  : <?php echo display_price($pageVal['total_cod_charges']);?></div>
           <?php
					}
					 ?>
          
          <div style="padding-top:5px;">          
          <?php echo anchor_popup('sitepanel/orders/invoice/'.$pageVal['order_id'], 'View Detail Invoice!', $atts);?> 
          </div>
          
           <div style="padding-top:10px; font-weight:bold;">          
          	<?php echo anchor_popup('sitepanel/orders/edit_invoice/'.$pageVal['order_id'], 'Edit Order', $atts);?> 
          </div>
          
         <?php /*?> <br />
          <fieldset style="width:200px; ">
          <legend style="font-weight:bold;">Send Notification:</legend>          
            <div style="padding-top:5px;"><input type="checkbox" name="byemail-<?php echo $pageVal['id'];?>" id="byemail-<?php echo $pageVal['id'];?>" class="ord<?php echo $pageVal['id'];?>" value="<?php echo $pageVal['id'];?>" /> By Email</div>
            
            <div style="padding-top:5px;"><input type="checkbox" name="bysms-<?php echo $pageVal['id'];?>" id="bysms-<?php echo $pageVal['id'];?>" class="ord<?php echo $pageVal['id'];?>" value="<?php echo $pageVal['id'];?>" /> By SMS</div>
            
            <div style="padding-top:5px;"><input type="button" name="button" value="Send" onclick="send_order_notification('<?php echo $pageVal['id'];?>');" /> </div>
          
          </fieldset><?php */?>
          
        </td>
        <td valign="top">
          <div style="padding-top:5px; color:#06F" >Email : <?php echo $email;?></div>
		  <div style="padding-top:5px;"><?php echo $pageVal['ship_name'];?></div>
          <div style="padding-top:5px;"><?php echo $pageVal['ship_mobile'];?></div>
          <div style="padding-top:5px;"><?php echo $pageVal['ship_phone'];?></div>
          <div style="padding-top:5px;"><?php echo $pageVal['ship_address'];?></div>
          <div style="padding-top:5px;"><?php echo $pageVal['ship_landmark'];?></div>
          <div style="padding-top:5px;"><?php echo city_name($pageVal['ship_city']);?></div>
          <div style="padding-top:5px;"><?php echo state_name($pageVal['ship_state']);?></div>
          <div style="padding-top:5px;"><?php echo country_name($pageVal['ship_country']);?></div>
          <div style="padding-top:5px;"><?php echo $pageVal['ship_pin_code'];?></div>
        </td>
        <td class="right" valign="top"><?php echo $pageVal['payment_mode'];?></td>
				<td class="right" valign="top"><?php echo ($pageVal['payment_status']==1)? "Paid":"Pending";?></td>
        <td class="right" valign="top"><?php echo getDateFormat($pageVal['order_date'],7);?></td>
				
			</tr>
		<?php
		$j++;
		}		   
		?> 
		<tr><td colspan="6" align="right" height="30"><?php echo $page_links; ?></td></tr>     
		</tbody>
		<tr>
			<td align="left" colspan="6" style="padding:2px" height="35">
				<input name="status_action" type="submit"  value="Payment Received" class="button2" id="Paid" onClick="return validcheckstatus('arr_ids[]','Payment Received','Record','u_status_arr[]');"/>
				<input name="status_action" type="submit" class="button2" value="Payment Pending" id="Unpaid"  onClick="return validcheckstatus('arr_ids[]','Payment Pending','Record','u_status_arr[]');"/>
        <?php
        if($this->admin_type==1){
				?>             
				<input name="status_action" type="submit" class="button2" id="Delete" value="Delete"  onClick="return validcheckstatus('arr_ids[]','delete','Record');"/>
        <?php } ?>
			</td>
		</tr>
		</table>
		<?php
		echo form_close();
	}else
	{
		echo "<center><strong> No record(s) found !</strong></center>" ;
	}
	?> 
	</div>
</div>