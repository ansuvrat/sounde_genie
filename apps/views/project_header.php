<header>
<div class="container position-relative">
<div class="row">
<div class="col-md-5 no_pad bb"><div class="call"><i class="fas fa-phone"></i> Phone Enquiries: <span class="yel">+<?php echo $this->admin_info->mobile;?></span><i class="yel"><a href="tel:+<?php echo $this->admin_info->mobile;?>">+<?php echo $this->admin_info->mobile;?></a></i></div></div>
<div class="col-md-2 no_pad"><p class="logo"><a href="<?php echo base_url();?>" title="Sound Genie"><img src="<?php echo theme_url();?>images/soundgenie.png" alt="Sound Genie"></a></p></div>
<div class="col-md-5 no_pad bb d-none d-md-block"><p class="social_top">
<?php
$admin_res = $this->site_setting;
$facebook =	$admin_res['facebook']?$admin_res['facebook']:'javascript:void(0)';
$twitter =	$admin_res['twitter']?$admin_res['twitter']:'javascript:void(0)';
$link_linkedin		=	$admin_res['linkdin']?$admin_res['linkdin']:'javascript:void(0)';
$youtube =	$admin_res['youtube']?$admin_res['youtube']:'javascript:void(0)';
$link_google_plus	=	$admin_res['gplus']?$admin_res['gplus']:'javascript:void(0)';
?>
<a href="<?php echo $facebook;?>" title="Facebook" target="_blank"><span class="fab fa-facebook-f"></span></a>
<a href="<?php echo $twitter;?>" title="Twitter" target="_blank"><span class="fab fa-twitter"></span></a>
<a href="<?php echo $link_linkedin;?>" title="Linkedin" target="_blank"><span class="fab fa-linkedin-in"></span></a>
<a href="<?php echo $link_google_plus;?>" title="Google Plus" target="_blank"><span class="fab fa-google-plus-g"></span></a>
<a href="<?php echo $youtube;?>" title="Youtube" target="_blank"><span class="fab fa-youtube"></span></a>
</p></div>
</div>

<div class="navbar">
<div class="navbar-inner">
  <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse"> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span></button>
 
  <div class="nav-collapse collapse">
    <ul class="nav">
      <li><a href="<?php echo base_url();?>" title="Home" <?php if($this->uri->segment(1)=='' || $this->uri->segment(1)=='home'){?> class="act" <?php } ?>>Home</a></li>
      <li><a href="<?php echo site_url('about-us');?>" title="About Us" <?php if($this->uri->segment(1)=='about-us'){?> class="act" <?php } ?>>About Us</a></li>
      <li><a href="<?php echo site_url('services');?>" title="Services" <?php if($this->uri->segment(1)=='services'){?> class="act" <?php } ?>>Services</a></li>
      <li><a href="<?php echo site_url('career');?>" title="Career" <?php if($this->uri->segment(1)=='career'){?> class="act" <?php } ?>>Career</a></li>
      <li><a href="<?php echo site_url("contact-us");?>" title="Contact Us" <?php if($this->uri->segment(1)=='contact-us'){?> class="act" <?php } ?>>Contact Us</a></li>     
    </ul>
  </div>
</div>
</div>
<?php 
if($this->session->userdata('user_id')==''){?>
<div class="log_reg">

<a href="<?php echo site_url("login");?>" title="Login">Login</a> <a href="<?php echo site_url("register");?>" title="Register">Register</a>
</div>
<?php }else{
	$rwmemhdArr=get_db_single_row("tbl_users","user_type,name"," AND id ='".$this->session->userdata('user_id')."' ");
	$userType='';
	$usenam="";
	if(is_array($rwmemhdArr) && count($rwmemhdArr) > 0 ){
		$userType=$rwmemhdArr['user_type'];
	    $usenam=$rwmemhdArr['name'];
	}
	 ?>
<div class="acc_log_reg">
    <p class="dropdown-toggle yel fs15 pointer" data-toggle="dropdown"><?php echo $usenam;?> <i class="fas fa-caret-down"></i></p>
    <div class="dropdown-menu">
    <?php if($userType ==3){?>  
    <a class="dropdown-item" href="<?php echo site_url("member/indivisualservice");?>">Individual Services</a>
   <?php } else{ ?> 
    <a class="dropdown-item" href="<?php echo site_url("member/companyservice");?>">Company Services</a>
   <?php } ?> 
    <a class="dropdown-item" href="<?php echo site_url("member");?>">Dashboard</a>
    <a class="dropdown-item" href="<?php echo site_url("users/logout");?>">Logout</a>
  </div>
    </div>
<?php } ?>
<p class="clearfix"></p>

</div>
</header>
<p class="topfix"></p>
