<?php $this->load->view("top_application");?>

<!-- Breadcrumb --> 
<div class="breadcrumb_outer">
<div class="container">
<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="index.htm">Home</a></li>
  <li class="breadcrumb-item active">Thank You</li>
</ol>
</div>
</div>
<!-- Breadcrumb End -->

<!-- MIDDLE STARTS -->
<div class="container">
<div class="cms">

<div class="mt-4 text-center">
<p><img src="<?php echo theme_url();?>images/thanks-img2.png" class="mw_96" alt=""></p>
<p class="mt-4 b">Thanks for registration.</p> 
<p class="mt-2 white">The welcome Email from <?php echo $this->site_setting['company_name'];?> with the link to confirm your registration was sent to your email.<br>
				 Click on the link in the email to confirm your registration. If you don't receive the email within 30 minutes, please check your Spam mailbox.</p>

</div>

</div>
</div>
<!-- MIDDLE ENDS -->

<?php $this->load->view("bottom_application");