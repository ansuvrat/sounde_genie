<?php $this->load->view("top_application");?>

<!-- Breadcrumb --> 
<div class="breadcrumb_outer">
<div class="container">
<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="<?php echo base_url();?>">Home</a></li>
  <li class="breadcrumb-item active">Make Payment</li>
</ol>
</div>
</div>
<!-- Breadcrumb End -->

<!-- MIDDLE STARTS -->
<div class="container">
<div class="cms">
<h1 class="text-center">Make Payment</h1>
<?php echo form_open('member/paymentmethod');?>
<div class="reg_box">
<div class="text-center">
<p class="fs16">Payable Amount : <b class="yel"><?php echo display_price($rworder['price']);?></b></p>
<p class="bb mt-4"></p>
<div class="mt-4">
<div class="row">

<div class="col-6 col-md-3 p-3">
<label class="cust_radio mr-4"><img src="<?php echo theme_url();?>images/c1.png" alt="">
  <input  type="radio" name="paynow" value="1" checked>
  <span class="checkmark"></span>
</label>
</div>

<div class="col-6 col-md-3 p-3">
<label class="cust_radio mr-4"><img src="<?php echo theme_url();?>images/c2.png" alt="">
  <input type="radio" name="paynow" value="1" >
  <span class="checkmark"></span>
</label>
</div>

<div class="col-6 col-md-3 p-3">
<label class="cust_radio mr-4"><img src="<?php echo theme_url();?>images/c3.png" alt="">
  <input type="radio" name="paynow" value="1">
  <span class="checkmark"></span>
</label>
</div>

<div class="col-6 col-md-3 p-3">
<label class="cust_radio mr-4"><img src="<?php echo theme_url();?>images/c4.png" alt="">
  <input type="radio" name="paynow" value="1">
  <span class="checkmark"></span>
</label>
</div>

</div>
</div>
<p class="mt-4 bb"></p>
<p class="mt-4"><input name="register_me" type="submit" value="Complete My Order >>" class="btn btn-yel" >
<input type="hidden" name="action" value="Add">
</p>

</div>
</div>
<?php echo form_close();?>
</div>
</div>
<!-- MIDDLE ENDS -->

<?php $this->load->view("bottom_application");
