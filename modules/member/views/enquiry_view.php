<?php $this->load->view("top_application");?>
<script type="text/javascript">function serialize_form() { return $('#ads_frm').serialize(); } </script>
<!-- Breadcrumb --> 
<div class="breadcrumb_outer">
<div class="container">
<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="<?php echo base_url();?>">Home</a></li>
  <li class="breadcrumb-item"><a href="<?php echo site_url('member');?>">Dashboard</a></li>
  <li class="breadcrumb-item active">My Enquiries</li>
</ol>
</div>
</div>
<!-- Breadcrumb End -->

<!-- MIDDLE STARTS -->
<div class="bg_img">
<div class="container">
<div class="cms"><?php $this->load->view("account_left");?>
<?php echo form_open("",'id="ads_frm"');?>
  <div class="acc_rgt" id="my_data">
  <h1>My Enquiries</h1>
  
  <div class="bgBk bb weight600 d-none d-md-block mt-3">
  <div class="row">
  <p class="col-md-1 p-2">S. No.</p>
  <p class="col-md-8 p-2">Enquries Details</p>
  <p class="col-md-3 p-2">Preferred Date</p>
  </div>
  </div>
<?php if(is_array($res) && count($res) > 0 ){
	   if($offset>0){
		$ctr=$offset+1;
		}else{
			$ctr=1;
		}
	   foreach($res as $val){
		   $categoetname=get_db_field_value("tbl_instrument_type","title","WHERE id ='".$val['category']."'");
	?>  
  <div class="acc_row">
  <div class="row">
  <p class="col-md-1 p-2"><?php echo $ctr;?></p>
  <div class="col-md-8 p-2 fs13">
  <p class="d-block d-md-none red weight600 text-uppercase">Enquries Details</p>
  <p class="white"><b>Category:</b> <?php echo $categoetname;?></p>
  <p class="mt-1"><?php echo $val['comment'];?></p>
  </div>
  <div class="col-md-3 p-2 fs13">
  <p class="d-block d-md-none red weight600 text-uppercase">Preferred Date</p>
  <p class="mt-1"><?php 
  if($val['preffered_date'] !=''){
 		 echo getdateFormat($val['preffered_date'],1);
  }
		 ?></p>
  </div>    
  </div>
 <?php if($val['admin_reply']!=''){?> 
  <div class="reply_box"><b class="yel">Admin Reply:</b> <?php echo $val['admin_reply'];?></div>
 <?php } ?> 
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

<?php $this->load->view("bottom_application");