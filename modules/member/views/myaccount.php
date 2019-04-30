<?php $this->load->view("top_application");
$tasktyprArr=$this->config->item('tasktyprArr');
?>
<!-- Breadcrumb --> 
<div class="breadcrumb_outer">
<div class="container">
<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="<?php echo base_url();?>">Home</a></li>
  <li class="breadcrumb-item active">Dashboard</li>
</ol>
</div>
</div>
<!-- Breadcrumb End -->
<!-- MIDDLE STARTS -->
<div class="bg_img">
<div class="container">
<div class="cms">
<?php $this->load->view("account_left");?>
  <div class="acc_rgt">
  <div class="text-center mt-2">
  <p>
<?php if($this->userType ==3){?>  
    <a href="<?php echo site_url("member/indivisualservice");?>" class="btn btn-yel">Start a Individual Services</a>
<?php }else{ ?>
    <a href="<?php echo site_url("member/companyservice");?>" class="btn btn-yel">Start a Company Services</a>
<?php } ?>

  </p>
  <div><?php echo error_message();?></div>
  <p class="mt-4 mb-4 bb"></p>
  <p class="fs20 white text-uppercase">WELCOME TO<br><img src="<?php echo theme_url();?>images/soundgenie.png" alt="" width="120" class="align-middle"></p>
  <p class="mt-2">What do you want to do today?</p>
  </div>
  <div class="mt-4">
  <div class="row">
 <?php if($this->session->userdata('sessuser_type')==3){?> 
  <div class="col-6 col-md-3 no_pad">
  <div class="acc_ico_box">
    <a href="<?php echo site_url("member/enquiry");?>"><span class="far fa-envelope acc_ico" style="color:#ff7c55;"></span></a>
    <p class="white acc_ico_title"><a href="<?php echo site_url("member/enquiry");?>">My Enquiries</a></p>
    </div>
  </div>
<?php } ?>  
  <div class="col-6 col-md-3 no_pad">
  <div class="acc_ico_box">
    <a href="<?php echo site_url("member/edit_account");?>"><span class="far fa-id-card acc_ico" style="color:#10bccd;"></span></a>
    <p class="white acc_ico_title"><a href="<?php echo site_url("member/edit_account");?>">Edit Details</a></p>
    </div>
  </div>
  <div class="col-6 col-md-3 no_pad">
  <div class="acc_ico_box">
    <a href="<?php echo site_url("member/orders");?>"><span class="far fa-list-alt acc_ico" style="color:#4291c9;"></span></a>
    <p class="white acc_ico_title"><a href="<?php echo site_url("member/orders");?>">My Orders</a></p>
    </div>
  </div>
  <div class="col-6 col-md-3 no_pad">
  <div class="acc_ico_box">
    <a href="<?php echo site_url("member/changepassword");?>"><span class="fas fa-key acc_ico" style="color:#17c76f;"></span></a>
    <p class="white acc_ico_title"><a href="<?php echo site_url("member/changepassword");?>">Change Password</a></p>
    </div>
  </div>
  </div>
  </div>
<p class="fs20 white text-uppercase text-center mt-5">My Orders</p>

 <?php if(is_array($orderArr) && count($orderArr) > 0 ){
	   $ctr=1;
	   foreach($orderArr as $val){
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
  <p class="mt-1 white fs18"><a  href="<?php echo site_url("member/invoice/".md5($val['order_id']));?>" ><i class="fas fa-search"></i></a>
  <?php if($val['upd_file']!='' && file_exists(UPLOAD_DIR.'/order_file/'.$val['upd_file'])){?>
  <a href="<?php echo site_url("member/downloadordfile/".$val['order_id']);?>"><i class="fas fa-download"></i></a>
 <?php } ?> 
  </p>
  </div>    
  </div>  
  </div>
<?php 
   $ctr++;
} ?>  
  <p class="mt-3 text-center"><a href="<?php echo site_url("member/orders");?>" class="btn btn-yel">View All</a></p>
<?php }else{ ?>
  <div align="center">No records found...</div>
<?php } ?>  
  
</div>
  <p class="clearfix"></p>
</div>
</div>
</div>
<!-- MIDDLE ENDS -->
<?php $this->load->view("bottom_application");