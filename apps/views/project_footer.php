<footer>
<div class="container foot_bg">
<div class="foot_sec1">
<p class="foot_logo"><a href="<?php echo base_url();?>" title="<?php echo $this->config->item('site_name');?>"><?php echo $this->config->item('site_name');?></a><br><span>Granting All Your Audio wishes</span></p>
<p class="copyright">Copyright&copy; <?php echo date('Y');?>, <?php echo $this->config->item('site_name');?>. <br>All Rights Reserved</p>

<?php
$admin_res = $this->site_setting;
$facebook =	$admin_res['facebook']?$admin_res['facebook']:'javascript:void(0)';
$twitter =	$admin_res['twitter']?$admin_res['twitter']:'javascript:void(0)';
$link_linkedin		=	$admin_res['linkdin']?$admin_res['linkdin']:'javascript:void(0)';
$youtube =	$admin_res['youtube']?$admin_res['youtube']:'javascript:void(0)';

$link_google_plus	=	$admin_res['gplus']?$admin_res['gplus']:'javascript:void(0)';
?>

<p class="bot_social">
<a href="<?php echo $facebook;?>" title="Facebook" target="_blank"><span class="fab fa-facebook-f"></span></a> 
<a href="<?php echo $twitter;?>" title="Twitter" target="_blank"><span class="fab fa-twitter"></span></a> 
<a href="<?php echo $link_linkedin;?>" title="Linkedin" target="_blank"><span class="fab fa-linkedin-in"></span></a> 
<a href="<?php echo $youtube;?>" title="Youtube" target="_blank"><span class="fab fa-youtube"></span></a> 
<a href="<?php echo $link_google_plus;?>" title="Google Plus" target="_blank"><span class="fab fa-google-plus-g"></span></a></p>

</div>

<div class="foot_sec2">
<p class="d-none d-md-block bot_heading">Quick Links</p>
<p class="d-block d-md-none dd_next hand bot_heading">Quick Links</p>
<div class="bot_cont">
<p class="botlink"><a href="<?php echo base_url();?>" title="Home">Home</a>
<a href="<?php echo site_url('about-us');?>" title="About Us">About Us</a>
<a href="<?php echo site_url('services');?>" title="Services">Services</a>
<a href="<?php echo site_url('career');?>" title="Career">Career</a>
<a href="<?php echo site_url('contact-us');?>" title="Contact Us">Contact Us</a>
<a data-fancybox data-type="iframe" data-src="<?php echo site_url('pages/newsletter');?>" href="javascript:void(0);" class="pop1" title="Newsletter">Newsletter</a></p>
</div>
</div>

<div class="foot_sec3">
<p class="d-none d-md-block bot_heading">Music Production</p>
<p class="d-block d-md-none dd_next hand bot_heading">Music Production</p>
<div class="bot_cont">
<p class="botlink"><a href="<?php echo site_url('member/composition');?>" title="Composition">Composition</a>
<a href="<?php echo site_url('member/lyrics');?>" title="Lyrics">Lyrics</a>
<a href="<?php echo site_url('member/mixing');?>" title="Mixing">Mixing</a>
<a href="<?php echo site_url('member/mastering');?>" title="Mastering">Mastering</a></p>
</div>
<p class="d-none d-md-block bot_heading">Sound Production</p>
<p class="d-block d-md-none dd_next hand bot_heading">Sound Production</p>
<div class="bot_cont">
<p class="botlink"><a href="<?php echo site_url('member/soundrecording');?>" title="Sound Recording">Sound Recording</a><a href="<?php echo site_url('member/sounddesigning');?>" title="Sound Designing">Sound Designing</a></p>
</div>
</div>

<div class="foot_sec4">
<p class="d-none d-md-block bot_heading">Information Links</p>
<p class="d-block d-md-none dd_next hand bot_heading">Information Links</p>
<div class="bot_cont">
<p class="botlink"><a href="<?php echo site_url("faqs");?>" title="FAQ's">FAQ's</a>
<a href="<?php echo site_url("testimonial");?>" title="Testimonials">Testimonials</a>
<a href="<?php echo site_url("privacy-policy");?>" title="Privacy Policy">Privacy Policy</a>
<a href="<?php echo site_url("terms-conditions");?>" title="Terms and Conditions">Terms and Conditions</a>
<a href="<?php echo site_url("legal-disclaimer");?>" title="Legal Disclaimer">Legal Disclaimer</a>
<a href="<?php echo site_url("sitemap");?>" title="Sitemap">Sitemap</a></p>
</div>
</div>

<div class="foot_sec5">
<p class="d-none d-md-block bot_heading">Contact Details</p>
<p class="d-block d-md-none dd_next hand bot_heading">Contact Details</p>
<div class="bot_cont">
<p><span class="bot_ico fas fa-envelope"></span> <span class="foot_addr yel"><a href="mailto:<?php echo $this->admin_info->admin_email;?>"><?php echo $this->admin_info->admin_email;?></a></span></p>
<p class="clearfix"></p>
<p><span class="bot_ico fas fa-phone"></span> <span class="foot_addr">+<?php echo $this->admin_info->mobile;?></span></p>
<p class="clearfix"></p>
<p><span class="bot_ico fas fa-map-marker-alt"></span> <span class="foot_addr"><?php echo $this->admin_info->address;?></span></p>
<p class="clearfix"></p>
</div>
</div>

<p class="clearfix"></p>
</div>

<div class="foot2">
<div class="container">
<p class="vision"><img src="<?php echo theme_url();?>images/vision.png" alt="Vision 2030"></p>

<p class="clearfix"></p>
</div>
</div>
</footer>