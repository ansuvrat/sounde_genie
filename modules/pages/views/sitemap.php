<?php $this->load->view("top_application"); ?>

<!-- Breadcrumb --> 
<div class="breadcrumb_outer">
<div class="container">
<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="<?php echo base_url();?>">Home</a></li>
  <li class="breadcrumb-item active">Sitemap</li>
</ol>
</div>
</div>
<!-- Breadcrumb End -->

<!-- MIDDLE STARTS -->
<div class="container">
<div class="cms">
<h1>Sitemap</h1>

<p class="fs16 purple2 text-uppercase mt-4">Quick Links</p>
<p class="sitemap_links"><a href="<?php echo base_url();?>" title="Home">Home</a>
<a href="<?php echo site_url('about-us');?>" title="About Us">About Us</a>
<a href="<?php echo site_url('services');?>" title="Services">Services</a>
<a href="<?php echo site_url('career');?>" title="Career">Career</a>
<a href="<?php echo site_url('contact-us');?>" title="Contact Us">Contact Us</a></p>
<p class="clearfix"></p>

<p class="bb mt-4"></p>

<p class="fs16 purple2 text-uppercase mt-4">Music Production</p>
<p class="sitemap_links"><a href="<?php echo site_url('member/composition');?>">Composition</a>
<a href="<?php echo site_url('member/lyrics');?>" title="Lyrics">Lyrics</a>
<a href="<?php echo site_url('member/mixing');?>" title="Mixing">Mixing</a>
<a href="<?php echo site_url('member/mastering');?>" title="Mastering">Mastering</a></p>
<p class="clearfix"></p>

<p class="bb mt-4"></p>

<p class="fs16 purple2 text-uppercase mt-4">Sound Production</p>
<p class="sitemap_links"><a href="<?php echo site_url('member/soundrecording');?>" title="Sound Recording">Sound Recording</a><a href="<?php echo site_url('member/sounddesigning');?>" title="Sound Designing">Sound Designing</a></p>
<p class="clearfix"></p>

<p class="bb mt-4"></p>

<p class="fs16 purple2 text-uppercase mt-4">Information Links</p>
<p class="sitemap_links"><a href="<?php echo site_url('faqs');?>" title="FAQ's">FAQ's</a>
<a href="<?php echo site_url('testimonial');?>" title="Testimonials">Testimonials</a>
<a href="<?php echo site_url('privacy-policy');?>" title="Privacy Policy">Privacy Policy</a>
<a href="<?php echo site_url('terms-conditions');?>" title="Terms and Conditions">Terms and Conditions</a>
<a href="<?php echo site_url('legal-disclaimer');?>" title="Legal Disclaimer">Legal Disclaimer</a></p>
<p class="clearfix"></p>

</div>
</div>
<!-- MIDDLE ENDS -->

<?php $this->load->view("bottom_application");