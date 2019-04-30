<?php $this->load->view('top_application');?>

<!-- Breadcrumb --> 
<div class="breadcrumb_outer">
<div class="container">
<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="<?php echo base_url();?>">Home</a></li>
  <li class="breadcrumb-item active">Login</li>
</ol>
</div>
</div>
<!-- Breadcrumb End -->

<!-- MIDDLE STARTS -->
<div class="register_bg">
<div class="container">
<div class="cms">

<p class="text-center display-4 yel"><i class="fas fa-user-circle"></i></p>
<p class="mb-2 text-center white fs20 text-uppercase merriweather">Login to Sound Genie</p>
<?php echo form_open("login");
            ?>
<div class="reg_box">

<div>
<div class="row">
<?php echo error_message(); ?>
<div class="col-md-12 no_pad"><input name="user_name" type="text" placeholder="Email ID *" value="<?php echo set_value("user_name",get_cookie('userName')) ?>"><?php echo form_error("user_name")?></div>
<div class="col-md-12 no_pad mt-2"><input name="password" type="password" placeholder="Password *" value="<?php echo set_value("password",get_cookie('pwd'))?>"><?php echo form_error("password")?></div>
</div> 
<p class="float-left mt-3 white"><label class="check_cust">Remember me<input type="checkbox" name="remember" value="Y" <?php if(get_cookie('userName')!=""){ echo 'checked'; } ?>> <span class="checkmark"></span></label></p>
<p class="float-right mt-3 fs13 yel"><a data-fancybox data-type="iframe" data-src="<?php echo site_url("users/forgotten_password");?>" href="javascript:void(0);" class="pop1" title="Forgot password?">Forgot password?</a></p>
<p class="clearfix"></p>
</div>
<p class="mt-2 text-center"><input name="" type="submit" class="btn btn-yel" value="Login" ></p>

<div class="create_acc text-center">
  <p class="mt-2 mb-1 float-md-left fs16 text-uppercase oswald">Don't have an account</p>
  <p class="float-md-right"><input name="" type="button" class="btn btn-purple" value="Create an Account" onClick="window.location.href=('<?php echo site_url('register');?>')"></p> 
  <p class="clearfix"></p> 
  </div>

</div>
<?php echo form_close();?>
</div>
</div>
</div>
<!-- MIDDLE ENDS -->
<?php $this->load->view('bottom_application');