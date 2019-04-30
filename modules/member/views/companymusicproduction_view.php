<?php $this->load->view("top_application");?>
<!-- Breadcrumb --> 
<div class="breadcrumb_outer">
<div class="container">
<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="<?php echo base_url();?>">Home</a></li>
  <li class="breadcrumb-item"><a href="<?php echo site_url("member/companyservice");?>">Company Services</a></li>
  <li class="breadcrumb-item active">Music Production</li>
</ol>
</div>
</div>
<!-- Breadcrumb End -->

<!-- MIDDLE STARTS -->
<div class="composition_bg">
<div class="container">
<div class="cms">
<h1 class="text-center purple2">Music Production</h1>

<div class="">
<div class="row">
<div class="col-lg-6 no_pad">
  <div class="comp_music_pic"><figure><img src="<?php echo theme_url();?>images/comp-music-img.jpg" alt=""></figure></div>
</div>

<div class="col-lg-6 no_pad">
<div class="row">
<div class="col-md-6 no_pad">
    <div class="comp_btn"><a href="<?php echo site_url("member/companyliveinstrument");?>"><p class="ico_box"><span class="fas fa-drum"></span></p><br>Live Real<br>Instrument<i class="fas fa-angle-double-right"></i></a></div>
</div>
<div class="col-md-6 no_pad">
    <div class="comp_btn"><a href="<?php echo site_url("member/companyvirtualinstrument");?>"><p class="ico_box"><span class="fas fa-robot"></span></p><br>Virtual Sampled<br>Instrument<i class="fas fa-angle-double-right"></i></a></div>
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