<?php $this->load->view("top_application");?>
<script type="text/javascript">function serialize_form() { return $('#ord_frm').serialize(); } </script>
<div class="breadcrumb_outer hidden-xs">
<div class="container">
<ul class="breadcrumb">
<li><a href="<?php echo base_url();?>">Home</a></li>
<li><a href="<?php echo site_url("member");?>">My Account</a></li>
<li class="active">Order History</li>
</ul>
</div>
</div>
<!-- TREE ENDS --> 
<!-- MIDDLE STARTS -->
<?php echo form_open("",'id="ord_frm"'); ?>
<div class="container acc_container" id="my_data">
<div class="row">
<?php $this->load->view("account_left");?>
    
<div class="col-xs-12 col-md-9 acc_right">
<div>
<h1>Order History</h1>
<div class="border2 bg-gray1 p10 pl15 acc_odh_filter">
<p class="one">
<input name="order_no" type="text" placeholder="Order/Invoice No." value="<?php echo $this->input->get_post('order_no');?>">
</p>
<p>
<input name="from_date" type="text" placeholder="Pick From Date" class="start_date1" value="<?php echo $this->input->get_post('from_date');?>"></p>
<p>
<input name="end_date" type="text" class="p6 radius-3 vam end_date1" placeholder="Pick To Date" value="<?php echo $this->input->get_post('end_date');?>">
<img src="<?php echo theme_url();?>images/clndr.png" alt=""></p>
<div>
<input name="input" type="submit" class="btn btn-danger btn-sm radius-3" value="Search">
</div>
<div class="cb"></div>
</div>
<div class="app_container inr_addresses">
<div class="row hidden-xs b ttu gray fs14">
<div class="col-xs-12 col-sm-1"> S.No. </div>
<div class="col-xs-12 col-sm-9"> Order/Invoice </div>
<div class="col-xs-12 col-sm-2 text-center"> View </div>
</div>
<!-- row 1 -->
<?php if(is_array($res) && count($res) > 0 ){
	$ctr=1;
	foreach ($res as $key=>$val){
			$print_url="cart/print_pginvoice/".$val['order_id'];
	?>          
<div class="row fs13">
<div class="col-xs-12 col-sm-1 hidden-xs"><?php echo $ctr;?>.</div>
<div class="col-xs-12 col-sm-9">
<p class="fs16 mb5 ttu">Invoice No.: <b class="black"><a href="<?php echo base_url().$print_url;?>" class="u" target="_blank" title="Invoice"><?php echo $val['invoice_number'];?></a></b></p>
<p class="fs14"><b>Purchased On:</b> <?php echo getdateFormat($val['order_received_date'],1);?> / <b>Amount Paid:</b> <span class="red"><?php echo display_price($val['total_amount']);?></span><br>
<b>Order Status:</b> <em class="fs16 pink"><?php echo $val['order_status'];?></em></p>
</div>
<div class="col-xs-12 col-sm-2 text-center black ttu fs14 hidden-xs"> <b class="visible-xs-inline">View Invoice :</b> <a href="<?php echo base_url().$print_url;?>" target="_blank" title="Invoice"> <img src="<?php echo theme_url();?>images/view.png" alt=""></a> </div>
</div>
          <!-- row 2 -->
<?php 
     $ctr++;
	}
}else{ ?>
 <div align="center">No records found...</div>
<?php } ?>          

<!-- row 3 -->
          

          <!-- row 4 --> 
          
</div>
<div class="text-center">
<?php echo $page_links; ?>
</div>
</div>
</div>
<!-- right ends --> 
</div>
</div>
<?php echo form_close();?>

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