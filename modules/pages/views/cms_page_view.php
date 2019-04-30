<?php $this->load->view("top_application"); ?>

<!-- Breadcrumb --> 
<div class="breadcrumb_outer">
<div class="container">
<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="<?php echo base_url();?>">Home</a></li>
  <li class="breadcrumb-item active"><?php echo $content["page_name"]?></li>
</ol>
</div>
</div>
<!-- Breadcrumb End -->
<!-- MIDDLE STARTS -->
<div class="bg1">
<div class="container">
<div class="cms">
<h1><?php echo $content["page_name"]?></h1>
<div class="mt-2">
<?php echo $content["page_description"]?>
</div>
</div>
</div>
</div>
<!-- MIDDLE ENDS -->

<?php $this->load->view("bottom_application");
