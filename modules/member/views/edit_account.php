<?php $this->load->view("top_application");?>
<!-- Breadcrumb --> 
<div class="breadcrumb_outer">
<div class="container">
<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="<?php echo base_url();?>">Home</a></li>
  <li class="breadcrumb-item"><a href="<?php echo site_url("member");?>">Dashboard</a></li>
  <li class="breadcrumb-item active">Edit Profile</li>
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
  <h1>Edit Profile</h1>    	
  
  <div class="row">
  <div class="col-md-6 no_pad">
  <?php echo form_open("member/edit_account");?>
  <div class="acc_form">
  <?php echo error_message();?>
  <p class="clearfix"></p>
  <div class="form_field"><input name="name" type="text" placeholder="Name" value="<?php echo set_value('name',$mres['name']);?>"></div>
  <div class="form_field"><input name="mobile" type="text" placeholder="Contact No." value="<?php echo set_value('mobile',$mres['mobile']);?>"></div>
  <p class="clearfix"></p>
  <p class="form_field mt-2"><input name="" type="submit" class="btn btn-yel" value="Update">
  <input type="hidden" name="action" value="Edit">
  </p>
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

<?php $this->load->view("bottom_application");?>