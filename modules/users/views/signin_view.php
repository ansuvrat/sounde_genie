<?php $this->load->view("top_application");?>
<div class="clearfix"></div>
<div class="breadcrumb-bg">

<div class="container">
<ul class="breadcrumb">
<li><a href="<?php echo base_url();?>">Home</a></li> <li class="active">Checkout</li></ul></div>
</div>

<div class="container">
<div class="row">
<div class="cms_area">
<h1>Checkout</h1>

<div class="row">
<div class="col-lg-7 col-md-7 col-sm-12">
<p class="mt10 hidden-xs"><img src="<?php echo theme_url();?>images/step1.png" alt="" class="mw_98"></p>
<div class="check_login_l mt10">


<?php echo form_open("users/signin?ref=".$ref,array('class'=>'form-horizontal'));
	    echo validation_message();
		echo error_message();
	 ?>
<div class="form-group">
<label for="email" class="col-xs-12 control-label">Enter Your Email Address<span class="star">*</span></label>  
<div class="col-lg-6 col-md-6 col-sm-6 mt5">
<input type="text" class="form-control" id="email" name="user_name"  value=""></div>
</div>

<p class="mt15 fs14">
<label>
<input name="registeration_password" type="radio" class="fl lg_tabs" value="N" title="form_1" <?php if($this->input->post('registeration_password')=='N' || $this->input->post('registeration_password')==''){ echo "checked";}?> style="margin-right:10px"> <b>Continue as Guest</b></label></p>

<small>(No password or registration required)</small>
<p class="mt10">
<label><input type="radio" name="registeration_password" class="fl lg_tabs" value="Y" title="form_2" style="margin-right:10px" <?php if($this->input->post('registeration_password')=='Y'){ echo "checked";}?>>
<b>I have a <span class="orange">Askidinya</span> account and password</b></label></p>
<small>(Sign in to your account for a faster checkout)</small>

<div class="form_box form_1 dn"></div>

<div <?php if($this->input->post('registeration_password')!='Y'){ ?>class="form_box form_2 dn" <?php }else{ ?> class="form_box form_2" <?php } ?>>
<p class="col-lg-6 col-md-6 col-sm-6 p0 mt5"><input type="password" class="form-control w96" id="password" name="password"  value=""></p>
<p class="clearfix"></p>
<p class="red mt10"><a href="<?php echo site_url("users/forgotten_password")?>" class="uu forgot">Forgot Password?</a></p>
<p class="mt10">
<label>
<input name="remember" type="checkbox" value="Y" <?php if(get_cookie('userName')!=""){?>checked="checked"<?php }?>> Remember Me</label></p>
</div>

<p class="mt10">
<input name="" type="submit" class="btn btn3" value="Continue &gt;&gt;" >
<input type="hidden" name="action" value="Add">
        </p>
      <?php echo form_close();?>
      </div>
    </div>
<!-- left ends -->
    
<!-- right Starts -->
<?php $this->load->view("cart/right");?>
<!-- right ends --> 
  </div>
</div>
</div>
<div class="clearfix"></div>
</div>

<div class="clearfix"></div>

<?php $this->load->view("bottom_application");?>