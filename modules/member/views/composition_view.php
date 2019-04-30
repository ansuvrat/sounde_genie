<?php $this->load->view("top_application");?>
<!-- Breadcrumb --> 
<div class="breadcrumb_outer">
<div class="container">
<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="<?php echo base_url();?>">Home</a></li>
  <li class="breadcrumb-item"><a href="<?php echo site_url("member/indivisualservice");?>">Individual Services</a></li>
  <li class="breadcrumb-item"><a href="<?php echo site_url("member/musicproduction");?>">Music Production</a></li>
  <li class="breadcrumb-item active">Composition</li>
</ol>
</div>
</div>
<!-- Breadcrumb End -->

<!-- MIDDLE STARTS -->
<div class="composition_bg">
<div class="container">
<div class="cms">
<h1 class="text-center purple2">Composition</h1>

<div class="sound_box">
<div class="row">

<div class="col-lg-12 no_pad">
<div class="row">
<div class="col-md-6 no_pad">
 <div class="comp_btn"><a href="<?php echo site_url("member/liveinstrument");?>"><p class="ico_box"><span class="fas fa-drum"></span></p><br>Live<br>Instrument<i class="fas fa-angle-double-right"></i></a></div>
</div>
<div class="col-md-6 no_pad">
    <div class="comp_btn"><a href="<?php echo site_url("member/virtualinstrument");?>"><p class="ico_box"><span class="fas fa-robot"></span></p><br>Virtual<br>Instrument<i class="fas fa-angle-double-right"></i></a></div>
</div>
</div>
</div>
</div>
</div>

</div>
</div>
</div>
<!-- MIDDLE ENDS -->

<?php $this->load->view("bottom_application");?>