<?php $this->load->view("top_application");?>

<!-- Breadcrumb --> 
<div class="breadcrumb_outer">
<div class="container">
<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="<?php echo base_url();?>">Home</a></li>
  <li class="breadcrumb-item"><a href="<?php echo site_url('member');?>">Individual Services</a></li>
  <li class="breadcrumb-item"><a href="<?php echo site_url('member/musicproduction');?>">Music Production</a></li>
  <li class="breadcrumb-item active">Mastering</li>
</ol>
</div>
</div>
<!-- Breadcrumb End -->

<!-- MIDDLE STARTS -->
<div class="mastering_bg">
<div class="container">
<div class="cms">
<h1 class="text-center">Mastering</h1>

<div class="sound_box">
<div class="row">
<div class="col-lg-12 no_pad">
<div class="row">
<div class="col-md-6 no_pad">
    <div class="comp_btn"><a href="<?php echo site_url('member/singlesongmastering');?>"><p class="ico_box"><span class="far fa-file-audio"></span></p><br>Single Song<br>Mastering<i class="fas fa-angle-double-right"></i></a></div>
	
</div>
<div class="col-md-6 no_pad">
    
    <div class="comp_btn"><a href="<?php echo site_url('member/fullalbummastering');?>"><p class="ico_box"><span class="fas fa-compact-disc"></span></p><br>Full Album<br>Mastering<i class="fas fa-angle-double-right"></i></a></div>
    
	
</div>
</div>
</div>
</div>
</div>

</div>
</div>
</div>
<!-- MIDDLE ENDS -->

<?php $this->load->view("bottom_application");