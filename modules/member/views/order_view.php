<?php $this->load->view("top_application");?>
<script type="text/javascript">function serialize_form() { return $('#ads_frm').serialize(); } </script>

<!-- Breadcrumb --> 
<div class="breadcrumb_outer">
<div class="container">
<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="<?php echo base_url();?>">Home</a></li>
  <li class="breadcrumb-item"><a href="<?php echo site_url('member');?>">Dashboard</a></li>
  <li class="breadcrumb-item active">My Orders</li>
</ol>
</div>
</div>
<!-- Breadcrumb End -->

<!-- MIDDLE STARTS -->
<div class="bg_img">
<div class="container">
<div class="cms"><?php $this->load->view("account_left");?>
<?php echo form_open("",'id="ads_frm"');
$tasktyprArr=$this->config->item('tasktyprArr');
?>
<div class="acc_rgt" id="my_data">
  <h1>My Orders</h1>
  <div class="row mt-3">
<div class="col-md-4 no_pad mb-2"><input type="text" name="from_date" class="p-2 w-80" placeholder="From" id="from_date" value="<?php echo $this->input->get_post('from_date');?>"> </div>
<div class="col-md-4 no_pad mb-2"><input type="text" name="to_date" class="p-2 w-80" placeholder="To" id="to_date" value="<?php echo $this->input->get_post('to_date');?>"> </div>
<div class="col-md-1 no_pad"><input name="" type="submit" value="Go" class="btn btn-yel">
<input type="hidden" name="st" value="1">
</div>
<div>
<?php
  if($this->input->post('from_date')!="" || $this->input->post('to_date')!="" ){
?>
<a href="<?php echo site_url('member/orders');?>"><font color="#FFFFFF">Clear Search</font></a>
<?php } ?>
</div>
</div>
  
  <div class="bgBk bb weight600 d-none d-md-block mt-3">
  <div class="row">
  <p class="col-md-1 p-2">S. No.</p>
  <p class="col-md-4 p-2">Order Details</p>
  <p class="col-md-2 p-2">Amount</p>
  <p class="col-md-3 p-2">Status</p>
  <p class="col-md-2 p-2">Invoice</p>
  </div>
  </div>
  <?php if(is_array($res) && count($res) > 0 ){
	   if($offset>0){
		$ctr=$offset+1;
		}else{
			$ctr=1;
		}
	   foreach($res as $val){
	?>  
  <div class="acc_row">
  <div class="row">
  <p class="col-md-1 p-2"><?php echo $ctr;?></p>
  <div class="col-md-4 p-2 fs13">
  <p class="d-block d-md-none purple weight600 text-uppercase">Order Details</p>
  <p class="yel fs15"><?php echo $tasktyprArr[$val['order_type']];?></p>
  <p class="white"><a href="<?php echo site_url("member/invoice/".md5($val['order_id']));?>"><b>Order ID:</b> <?php echo $val['order_id'];?></a></p>
  <p><b>Order Date:</b> <?php echo getdateFormat($val['order_date'],1);?></p>
  </div>
  <div class="col-4 col-md-2 p-2 fs13">
  <p class="d-block d-md-none purple weight600 text-uppercase">Amount</p>
  <p class="mt-1"><?php echo display_price($val['price']);?></p>
  </div>
  <div class="col-5 col-md-3 p-2 fs13">
  <p class="d-block d-md-none purple weight600 text-uppercase">Status</p>
  <p class="mt-1"><b>Order:</b> <?php echo ($val['confirm_status']==1)?'In-process':'Completed';?><br><b>Payment:</b> <?php echo ($val['pay_status']==1)?'Pending':'Paid';?><br></p>
  </div>
  <div class="col-3 col-md-2 p-2 fs13">
  <p class="d-block d-md-none purple weight600 text-uppercase">Invoice</p>
  <p class="mt-1 white fs18"><a href="<?php echo site_url("member/invoice/".md5($val['order_id']));?>"><i class="fas fa-search"></i></a>
  <?php if($val['upd_file']!='' && file_exists(UPLOAD_DIR.'/order_file/'.$val['upd_file'])){?>
  <a href="<?php echo site_url("member/downloadordfile/".$val['order_id']);?>"><i class="fas fa-download"></i></a>
 <?php } ?> 
  </p>
  </div>    
  </div>  
  </div>
  
  <?php
     $ctr++; 
	}
	?>
    <div align="center"><div class="clearfix mt-4 mb-4"></div>
<div class="mt-3 text-center"><?php echo $page_links; ?></div></div>
	<?php
}else{ ?>
 <div class="acc_row"><div class="row" align="center">No records found...</div></div>
<?php } ?>  
  
</div>
<?php echo form_close();?>  
  <p class="clearfix"></p>
</div>
</div>
</div>
<!-- MIDDLE ENDS -->
<?php
//$default_date = '2013-08-12';
$default_date = date('Y-m-d');
$posted_start_date = $this->input->post('date_birth');
?>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/developers/js/jquery/ui/jquery-ui.js"></script>
<link type="text/css" href="<?php echo base_url(); ?>assets/developers/js/jquery/ui/themes/ui-lightness/jquery.ui.all.css" rel="stylesheet" />
<script type="text/javascript">
$(document).ready(function(){

$("#from_date").datepicker({
showOn: "both",
dateFormat: 'yy-mm-dd',
changeMonth: true,
changeYear: true,
defaultDate: 'y',
buttonText:'',
minDate:'' ,
maxDate:'<?php echo $default_date;?>',
buttonImage: '<?php echo theme_url();?>images/calendar.png',
yearRange: "c-100:c+100",
buttonImageOnly: true,
onSelect: function(dateText, inst) {
$('#from_date').val(dateText);
$( "#to_date").datepicker("option",{
minDate:dateText ,
});
}
});

$("#to_date").datepicker({
showOn: "both",
dateFormat: 'yy-mm-dd',
changeMonth: true,
changeYear: true,
defaultDate: 'y',
buttonText:'',
minDate:'' ,
maxDate:'<?php echo $default_date;?>',
buttonImage: '<?php echo theme_url();?>images/calendar.png',
yearRange: "c-100:c+100",
buttonImageOnly: true,
onSelect: function(dateText, inst) {
$('#to_date').val(dateText);
$( "#from_date").datepicker("option",{
maxDate:dateText ,
});
}
});

});
</script>
<?php $this->load->view("bottom_application");