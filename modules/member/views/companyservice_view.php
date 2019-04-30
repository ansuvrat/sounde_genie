<?php $this->load->view("top_application");?>

<!-- Breadcrumb --> 
<div class="breadcrumb_outer">
<div class="container">
<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="<?php echo base_url();?>">Home</a></li>
  <li class="breadcrumb-item active">Company Services</li>
</ol>
</div>
</div>
<!-- Breadcrumb End -->

<!-- MIDDLE STARTS -->
<div class="container">
<div class="cms">
<h1 class="text-center">Company Services</h1>

<div class="mb-4">
<div class="row">

<div class="col-6 no_pad">
<a href="<?php echo site_url("member/companymusicproduction");?>">
<div class="hwork_item">
<div class="hw_img">
<div class="circle" style="background:#4c1071;">
<p class="sound_ico"><img src="<?php echo theme_url();?>images/music-img.png" alt="Music Production"></p>
<p class="sound_name">Music<br>Production</p>
<p class="viewmore">Click Here</p>
</div>
<svg x="0px" y="0px" viewBox="0 0 179 179"><circle class="outer" cx="90" cy="90" r="88"></circle></svg>            
</div>          
</div>
</a>
</div>

<div class="col-6 no_pad">
<a href="<?php echo site_url("member/companysoundproduction");?>">
<div class="hwork_item">
<div class="hw_img">
<div class="circle" style="background:#000;">
<p class="sound_ico"><img src="<?php echo theme_url();?>images/sound-img.png" alt="Sound Production"></p>
<p class="sound_name">Sound<br>Design</p>
<p class="viewmore">Click Here</p>
</div>
<svg x="0px" y="0px" viewBox="0 0 179 179"><circle class="outer" cx="90" cy="90" r="88"></circle></svg>            
</div>          
</div>
</a>
</div>

</div>
</div>

</div>
</div>
<!-- MIDDLE ENDS -->

<?php $this->load->view("bottom_application");