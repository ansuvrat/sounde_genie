<?php $this->load->view("top_application");?> 

<!--Hot Seller-->
<div class="container">
<div class="row">
<p class="bb"></p>

<ul class="breadcrumb">
<li><a href="<?php echo base_url();?>">Home</a></li>
<li class="active">Email ID Verification</li>
</ul>

<div class="inner-cont">
<h1>Email ID Verification</h1>
        
<div class="fs14 text-center">
      <p><img src="<?php echo theme_url();?>images/thankyou.jpg" alt=""></p>
      <p class="mt10 pink fs16 ttu">A verification link has been sent to your email id <br>
          (<?php echo get_db_field_value('tbl_users','email', array("id"=>$registerId))?>)</p>
          <p class="mt20 fs14">Click the <b class="red">Verification Link</b> to active your account</p>
     
    </div>
    
</div>
</div>
</div>
<!--Hot Seller end-->

<?php $this->load->view("bottom_application");