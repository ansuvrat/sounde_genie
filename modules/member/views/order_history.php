<?php $this->load->view("top_application");?>
<script type="text/javascript">function serialize_form() { return $('#ord_frm').serialize(); } </script>


<div class="container">
<div class="row">
<p class="bb"></p>

<ul class="breadcrumb">
<li><a href="<?php echo base_url();?>">Home</a></li>
<li><a href="<?php echo site_url("member");?>">My Account</a></li>
<li class="active">Order History</li>
</ul>
<?php echo form_open("",'id="ord_frm"'); ?>
<?php
$memshipclass=(@$this->session->userdata('membership')!='')?@strtolower($this->session->userdata('membership')):'crystal';
?>
<div class="<?php echo $memshipclass;?>">
<h1 class="text-center">Order History</h1>
        
<div><?php $this->load->view("top");?>
<div class="mt15" id="my_data">
        
    <div>
	<div class="order-search">
	<p><input name="order_no" value="<?php echo set_value('order_no',$this->input->post('order_no'));?>" type="text" class="txtbox w90" placeholder="Order/Invoice No."></p>
	<p>
    <input name="from_date" id="from_date" type="text" class="txtbox w70 start_date1" placeholder="From date"> 
    </p>
	<p>
    <input name="end_date" type="text" class="txtbox w70 end_date1" placeholder="To date"> 
    <input type="hidden" name="st" value="1">
    </p>
	<p><input name="input" type="button" class="btn btn-info btn-sm orderbtn" value="Search">
    <?php if($this->input->post('st')==1){ ?>
		<a href="<?php echo site_url("member/orders");?>">Clear All</a>
	<?php }?>
    </p>
	<p class="cb"></p>
	</div>
    <p class="cb"></p>
    </div>
	<?php 
    error_message();
    if(is_array($res) && !empty($res)){
        ?>
    <div>
    <div class="order-head">
	<p class="sno">S. No.</p>
	<p class="invoice">Order No.</p>
	<p class="date">Date</p>
	<p class="amount">Amount</p>
	<p class="status">Delivery Status</p>
    <p class="payment">Payment Status</p>
	<p class="cb"></p>
	</div>
	<?php 
	
    $i=$this->uri->segment(3,0);
    $ctr=1;
	foreach ($res as $key=>$val){				
        $i++;				
        $inv_url=site_url("cart/print_invoice/".$val["order_id"]);				
        ?>  
        <div class="order-list">
            <p class="sno"><?php echo $ctr;?>.</p>	
            <p class="blue ttu uu invoice"><span class="mob_only red">Order No.<br></span><a href="<?php echo $inv_url?>" ><?php echo $val["invoice_number"]?></a></p>
            <p class="date"><span class="mob_only red">Date<br></span><?php echo getDateFormat($val["order_received_date"],1)?></p>
            <p class="amount"><span class="mob_only red mt10">Amount<br></span><?php echo display_price($val["total_amount"]);?></p>
            <p class="status"><span class="mob_only red mt10">Delivery <?php echo ($val["order_status"]!='')?$val["order_status"]:"In-process";?> <br />
            <strong>Comp:</strong> <?php echo $val["courier_company_name"];?><br />
            <strong>Track No.:</strong><?php echo $val["bill_number"];?><br />
            <strong>Url :</strong><?php echo $val["tracking_url"];?><br />
            <br></span><?php echo ($val["order_status"]!='')?$val["order_status"]:"In-process";?><br /><strong>Comp:</strong> <?php echo $val["courier_company_name"];?><br />
            <strong>Track No.:</strong><?php echo $val["bill_number"];?><br />
            <strong>Url :</strong><?php echo $val["tracking_url"];?><br /></p>  
            <p class="status"><span class="mob_only red mt10">Payment Status<br></span><?php echo $val["payment_status"] ?></p> 
            <p class="cb"></p>
        </div>
      <?php 
	   $ctr++;
	  } ?>
</div>
<?php }else{ ?>
  <div align="center">No records found...</div>
<?php } ?>
   <div class="text-center">
          <?php echo $page_links; ?>
        </div>
      </div>
      
</div>
    
</div>
<input type="hidden" name="keyword" value="<?php echo $this->input->post('keyword');?>" />
<input type="hidden" name="from_date" value="<?php echo $this->input->post('from_date');?>" />
<input type="hidden" name="to_date" value="<?php echo $this->input->post('to_date');?>" />
<input type="hidden" name="per_page" value="<?php echo $per_page;?>" />
<?php echo form_close();?>
</div>
</div>
<!--Hot Seller end-->
<script type="text/javascript" src="<?php echo base_url();?>assets/developers/js/ui/jquery-ui-1.8.16.custom.min.js"></script>
<link type="text/css" href="<?php echo base_url();?>assets/developers/js/ui/themes/ui-lightness/jquery-ui-1.8.16.custom.css" rel="stylesheet" />
<?php 
$default_date = '2013-01-01';
$posted_start_date = $this->input->post('from_date');
?>
<script type="text/javascript">
  $(document).ready(function(){
	$('.orderbtn').on('click',function(e){
		e.preventDefault();
		$start_date = $('.start_date1:eq(0)').val();
		$end_date = $('.end_date1:eq(0)').val();
		$start_date = $start_date=='From' ? '' : $start_date;
		$end_date = $end_date=='To' ? '' : $end_date;
		$(':hidden[name="keyword"]','#ord_frm').val($('input[type="text"][name="keyword"]').val());
		$(':hidden[name="from_date"]','#ord_frm').val($start_date);
		$(':hidden[name="to_date"]','#ord_frm').val($end_date);
		$("#ord_frm").submit();
	});
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
							maxDate:'<?php echo date('Y-m-d',strtotime(date('Y-m-d',time())."+180 days"));?>'
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
					  minDate:'<?php echo $posted_start_date!='' ? $posted_start_date :  $default_date;?>' ,
					  maxDate:'<?php echo date('Y-m-d',strtotime(date('Y-m-d',time())."+180 days"));?>',
					  yearRange: "c-100:c+100",
					  buttonImageOnly: true,
					  onSelect: function(dateText, inst) {
						$('.end_date1').val(dateText);
					  }
				  });
	  });
	  
  });
</script> 
<?php $this->load->view("bottom_application");?>