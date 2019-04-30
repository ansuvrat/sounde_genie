<div id="content">

 <div class="breadcrumb"><?php echo anchor('sitepanel/dashbord','Home');?> &raquo; <?php echo $heading_title;?></a></div>

 <div class="box">

  <div class="heading">

   <h1><img src="<?php echo base_url(); ?>assets/sitepanel/image/category.png" alt="" /> <?php echo $heading_title;?></h1>

   <div class="buttons"> &nbsp;</div>
  </div>
  <div class="content">

   <?php echo form_open("sitepanel/orders/$type",'id="pagingform"');?>

   <input type="hidden" name="keyword" value="<?php echo $this->input->post('keyword');?>"  />

   <input type="hidden" name="status" value="<?php echo $this->input->post('status');?>"  />

   <input type="hidden" name="per_page" value="<?php echo $this->input->post('per_page');?>"  />

   <?php echo form_close();

   echo validation_message();

   echo error_message();

   echo form_open("sitepanel/orders/$type",'id="search_form" method="get" ');?>

   <div align="right" class="breadcrumb">Records Per Page : <?php echo display_record_per_page();?></div>

   <table width="80%"  border="0" cellspacing="3" cellpadding="3" align="center">

    <tr>

     <td width="22%" align="right" >Search By</td>

     <td width="78%"><input type="text" name="keyword" placeholder="Keywords" value="<?php echo $this->input->get_post('keyword');?>" style="width:240px;" /> &nbsp;

     <?php
     	$order_status=$this->input->get_post('order_status');
     ?>
        <select name="order_status"  >
            <option value="">Order Status</option>	  
            <option value="1" <?php echo ($order_status=="1")?" selected='selected'":"" ?>>Pending </option>
            <option value="2"  <?php echo ($order_status=="2")?" selected='selected'":"" ?>>Confirmed</option>
           
        </select>
        &nbsp;
        <select name="pay_status"  >
            <option value="">Payment Status</option>	  
            <option value="1" <?php echo ($this->input->get_post('pay_status')=="1")?" selected='selected'":"" ?>>Pending </option>
            <option value="2"  <?php echo ($this->input->get_post('pay_status')=="2")?" selected='selected'":"" ?>>Paid</option>
           
        </select>
     </td>
    </tr>

    <tr>
     <td>&nbsp;</td>
     <td><input name="from_date" type="text" id="textfield3" class="start_date1 input-bdr2 radius-5" placeholder="From Date" style="width:165px;" value="<?php echo $this->input->get_post('from_date');?>">&nbsp;&nbsp;<input name="to_date" type="text" id="textfield4" class="end_date1 input-bdr2 radius-5" placeholder="To Date"  style="width:165px;" value="<?php echo $this->input->get_post('to_date');?>"></td>
    </tr>
    <tr>
     <td>&nbsp;</td>
     <td>&nbsp;<a  onclick="$('#search_form').submit();" class="button"><span> GO </span></a>&nbsp; Keywords Like : Invoice Number , name , email <?php if( $this->input->get_post('keyword')!='' || $this->input->get_post('from_date')!='' || $this->input->get_post('to_date')!='' || $this->input->get_post('order_status')!='' || $this->input->get_post('pay_status')!=''  ){ echo anchor("sitepanel/orders/$type",'<span>Clear Search</span>'); }?> </td>
    </tr>
   </table>

   <?php echo form_close(); 

   //trace($res);

   if( is_array($res) && !empty($res)){

	   echo form_open("sitepanel/orders/$type",'id="data_form"');

	   ?>
       <div><strong>Total No. of Records:</strong> <?php echo $res_count;?></div>
       <table class="list" width="100%" id="my_data">
	    <thead>
	     <tr>
	      <td width="4%" style="text-align: center;"><input type="checkbox" onclick="$('input[name*=\'arr_ids\']').attr('checked', this.checked);" /></td>
				<td width="27%" class="left">Invoice Details</td>
                <td width="24%" class="left">Uploaded File</td>
				<td width="17%" class="left">Invoice Amount</td>
				<td width="16%" class="left">Payment Status</td>
				<td width="12%" class="left">Order Status</td>
			 </tr>
			</thead>
			<tbody>
			 <?php
				$atts = array(
								'width'      => '950',
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

			 foreach($res as $catKey=>$pageVal){

				 $invoice_amount=$pageVal['price'];
				 ?>
				 <tr>
				  <td style="text-align: center;"><input type="checkbox" name="arr_ids[]" value="<?php echo $pageVal['id'];?>" /></td>
				  <td class="left">
				   <strong><?php echo $pageVal['order_id'];?></strong><br />
				   
				   <?php echo $pageVal['order_date'];?><br />
				   <?php echo $pageVal['name'];?> <br />
				   <?php echo ($pageVal['phone'])?($pageVal['phone']."<br />"):"";?> 
				   <?php 
				   echo $pageVal['email'];?><br />
				   <?php 
				   		echo anchor_popup('sitepanel/orders/print_invoice/'.$pageVal['order_id'], 'View Invoice', $atts);
				   ?>

				  </td>
                  <td class="left">
                  <?php if($pageVal['upd_file']!='' && file_exists(UPLOAD_DIR.'/order_file/'.$pageVal['upd_file'])){ ?>
                  <a href="<?php echo site_url("sitepanel/orders/download/".$pageVal['order_id']);?>">View/Download</a>
                  <?php } ?>
                  </td>
				  <td class="left"><?php echo display_price($invoice_amount);?><br />
				  <td class="left"><?php echo ($pageVal['pay_status']==1)?'Pending':'Paid';?><br />
				   <?php
				   if($pageVal['pay_status']=='1'){
					   ?>
					   <a  onclick="return confirm('Are you sure you want to make this order paid');" href="<?php echo base_url();?>sitepanel/orders/make_paid/<?php echo $pageVal['order_id'];?><?php echo query_string();?>">Make Paid</a>
					   <?php
				   }else{
					   ?>
					   <?php
					   if($pageVal['confirm_status']==1){?>
						  <a  href="<?php echo base_url();?>sitepanel/orders/confirm_order/<?php echo $pageVal['order_id'];?><?php echo query_string();?>"><strong>Confirm payment</strong></a>  
					  <?php  }else{
						  echo "<br>Payment Confirmed";   
					   }
				   }
					?>
				  </td>
				    <td class="left"><?php echo ($pageVal['confirm_status']==1)?'Pending':'Confirmed';?></td>
				 </tr>

				 <?php

			 }?>

			</tbody>

		 </table>

		 <?php

		 if($page_links!=''){

			 ?>

			 <table class="list" width="100%">

			  <tr><td align="right" height="30"><?php echo $page_links;?></td></tr>

			 </table>

			 <?php

		 }?>

		 

		 

		 <?php

		 echo form_close();

	 }else{

		 echo "<center><strong> No record(s) found !</strong></center>" ;

	 }?>

	</div>

 </div>

</div> 

<?php
//$default_date = '2013-08-12';
$default_date = date('Y-m-d');
?>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/developers/js/jquery/ui/jquery-ui.js"></script>
<link type="text/css" href="<?php echo base_url(); ?>assets/developers/js/jquery/ui/themes/ui-lightness/jquery.ui.all.css" rel="stylesheet" />
<script type="text/javascript">
$(document).ready(function(){

$(".start_date1").datepicker({
showOn: "both",
dateFormat: 'yy-mm-dd',
changeMonth: true,
changeYear: true,
defaultDate: 'y',
buttonText:'',
minDate:'' ,
buttonImage: '<?php echo theme_url();?>images/cald.png',
maxDate:'',
yearRange: "c-100:c+100",
buttonImageOnly: true,
onSelect: function(dateText, inst) {
$('#prefer_date').val(dateText);
$( ".end_date1").datepicker("option",{
minDate:dateText ,
});
}
});

$(".end_date1").datepicker({
showOn: "both",
dateFormat: 'yy-mm-dd',
changeMonth: true,
changeYear: true,
defaultDate: 'y',
buttonText:'',
minDate:'' ,
buttonImage: '<?php echo theme_url();?>images/cald.png',
maxDate:'',
yearRange: "c-100:c+100",
buttonImageOnly: true,
onSelect: function(dateText, inst) {
$( ".end_date1").datepicker("option",{
maxDate:dateText ,
});
}
});

});
</script>



<script type="text/javascript">

	function onclickgroup(){

		if(validcheckstatus('arr_ids[]','Update order status','record','u_status_arr[]')){

			$('#data_form').submit();

		}

	}

</script>