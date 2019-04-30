<?php echo $this->load->view("top_application");?>

<!-- Breadcrumb --> 
<div class="breadcrumb_outer">
<div class="container">
<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="<?php echo base_url();?>">Home</a></li>
  <li class="breadcrumb-item"><a href="<?php echo site_url("member");?>">Dashboard</a></li>
  <li class="breadcrumb-item active">Change Password</li>
</ol>
</div>
</div>
<!-- Breadcrumb End -->

<!-- MIDDLE STARTS -->
<div class="bg_img">
<div class="container">
<div class="cms"><?php $this->load->view("account_left");?>
<div class="acc_rgt">
  <h1>Change Password</h1>    	
  
  <div class="row">
  <div class="col-md-6 no_pad">
  <?php echo form_open("member/changepassword");?>
  <div class="acc_form">
  <?php echo error_message();?>
  <div class="form_field"><input name="old_password" type="password" placeholder="Old Password *">
  <?php echo form_error("old_password");?>
  </div>
  <div class="form_field"><input name="new_password" type="password" placeholder="New Password *">
  <?php echo form_error("new_password");?>
  </div>
  <div class="form_field"><input name="confirm_password" type="password" placeholder="Confirm Password *">
  <?php echo form_error("confirm_password");?>
  </div>
  <p class="clearfix"></p>
  <p class="form_field mt-2"><input name="" type="submit" class="btn btn-yel" value="Update"></p>
  <p class="clearfix"></p>
  </div>
  <?php echo form_close();?>
  </div>
  </div>
    
</div>
  
  <p class="clearfix"></p>
</div>
</div>
</div>
<!-- MIDDLE ENDS -->

<?php echo $this->load->view("bottom_application");
