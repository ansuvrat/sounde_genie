<?php $this->load->view('top_application');?>

<!-- Breadcrumb --> 
<div class="breadcrumb_outer">
<div class="container">
<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="<?php echo base_url();?>">Home</a></li>
  <li class="breadcrumb-item active">Register</li>
</ol>
</div>
</div>
<!-- Breadcrumb End -->

<!-- MIDDLE STARTS -->
<div class="register_bg">
<div class="container">
<div class="cms">

<p class="text-center display-4 yel"><i class="fas fa-user-circle"></i></p>
<p class="mb-2 text-center white fs20 text-uppercase merriweather">Create An Account</p>
<?php echo form_open("register");?>
<div class="reg_box">
<div class="text-center white text-uppercase font-weight-bold"><label class="cust_radio mr-4">User
  <input type="radio" checked="checked" name="user_type" value="3" <?php if($this->input->post('user_type')==3){ echo "checked";}?>>
  <span class="checkmark"></span>
</label>
<label class="cust_radio">Company
  <input type="radio" name="user_type" value="2" <?php if($this->input->post('user_type')==2){ echo "checked";}?>>
  <span class="checkmark"></span>
</label>
<?php echo form_error("user_type");?>
</div>
  <div>
  
  <p class="fs16 text-uppercase font-weight-bold yel merriweather">Login Details</p>
<div class="row">
<div class="col-md-12 no_pad mt-2"><input name="email" type="text" placeholder="Email ID *" value="<?php echo set_value("email");?>">
<?php echo form_error("email");?>
</div>
<div class="col-md-12 no_pad mt-2"><input name="password" type="password" placeholder="Password *" value="<?php echo set_value("password");?>">
<?php echo form_error("password");?>
</div>
<div class="col-md-12 no_pad mt-2"><input name="confirm_password" type="password" placeholder="Confirm Password *" value="<?php echo set_value("confirm_password");?>">
<?php echo form_error("confirm_password");?>
</div>
</div>
<p class="mt-4 fs16 text-uppercase font-weight-bold yel merriweather">Personal Details</p>
<div class="row">
<div class="col-md-12 no_pad mt-2"><input name="name" type="text" placeholder="Name *" value="<?php echo set_value("name");?>">
<?php echo form_error("name");?>
</div>
<div class="col-md-12 no_pad mt-2"><input name="mobile" type="text" placeholder="Contact No. *" value="<?php echo set_value("mobile");?>">
<?php echo form_error("mobile");?>
</div>

<div class="col-md-6 no_pad mt-2"><input name="verification_code" type="text" placeholder="Enter Code *">
<?php echo form_error("verification_code");?>
</div>  
<p class="col-md-6 no_pad mt-2"> <img src="<?php echo site_url('captcha/normal'); ?>" alt="" class="vam" id="captchaimage"><a href="javascript:void(0);" onclick="document.getElementById('captchaimage').src='<?php echo base_url().'captcha/normal'; ?>/<?php echo uniqid(time()); ?>'+Math.random(); document.getElementById('verification_code').focus();"><img src="<?php echo theme_url();?>images/ref.png" alt="" class="vam"></a></p>
<p class="mt-1 fs13">Type the characters shown above.</p>

<div class="col-md-12 no_pad mt-3">
<div><label class="check_cust">I Accept <span class="white"><a href="<?php echo site_url("terms-conditions");?>" target="_blank">Terms &amp; Conditions</a></span><input type="checkbox" name="remember" value="1" <?php if($this->input->post('remember')==1){ echo "checked";}?>><span class="checkmark"></span></label>
<?php echo form_error("remember");?>
</div>
</div>

</div>    
</div>

<p class="mt-4"><input name="" type="submit" class="btn btn-yel" value="Register" ></p>

</div>
<?php echo form_close();?>
</div>
</div>
</div>
<!-- MIDDLE ENDS -->

<?php $this->load->view('bottom_application');?>