<?php $this->load->view("top_application");?>

<!-- Breadcrumb --> 
<div class="breadcrumb_outer">
<div class="container">
<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="<?php echo base_url();?>">Home</a></li>
  <li class="breadcrumb-item active">Page Now Found!</li>
</ol>
</div>
</div>
<!-- Breadcrumb End -->

<!-- MIDDLE STARTS -->
<div class="container">
<div class="cms">

<div class="text-center"><img src="<?php echo theme_url();?>images/404.jpg" class="mw_96" alt=""></div>

</div>
</div>
<!-- MIDDLE ENDS -->

<?php $this->load->view("bottom_application");