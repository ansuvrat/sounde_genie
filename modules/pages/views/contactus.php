<?php $this->load->view('top_application');?>

<!-- Breadcrumb --> 
<div class="breadcrumb_outer">
<div class="container">
<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="<?php echo base_url();?>">Home</a></li>
  <li class="breadcrumb-item active">Contact Us</li>
</ol>
</div>
</div>
<!-- Breadcrumb End -->

<!-- MIDDLE STARTS -->
<div class="rel">
<div class="contact_bg">
<div class="container">
<div class="cms_area">
<div class="row">
<div class="col-lg-6">
<div class="contact_list">
  <ul>
    <li>
        <div class="circle_sec"><span class="fas fa-map-marker-alt"></span></div>
        <div class="contact_desc"> 
        <p class="cnt_heading">Address</p>
        <div class="sec_cnt"><?php echo $this->admin_info->address;?></div>
        </div>
        <p class="clearfix"></p> 
      </li>
    
    <li>
        <div class="circle_sec"><span class="fas fa-mobile-alt"></span></div>
        <div class="contact_desc"> 
        <p class="cnt_heading">Call Customer Service Team</p>
        <p><span class="fa fa-phone mr8"></span><?php echo $this->admin_info->mobile;?></p>
        </div>
      <p class="clearfix"></p>
      </li>
    <li>
        <div class="circle_sec"><span class="far fa-envelope"></span></div>
        <div class="contact_desc"> 
        <p class="cnt_heading">Email</p>
        <div class="sec_cnt">
          <p class=""><a href="mailto:<?php echo $this->admin_info->admin_email;?>"><?php echo $this->admin_info->admin_email;?></a></p>
          </div>
          </div>
      <p class="clearfix"></p>
      </li>
    </ul>
  <div class="clearfix"></div>
</div>
</div>

<div class="col-lg-6">
<?php echo form_open('',array("name"=>"myForm"))?>
     <?php echo error_message();?>
<div class="contact_form_cont">
    <p class="fs16 lh20px mb-3">Still need help?<br class="visible-xs-block"> <b class="white">Just Fill the Below Information:</b></p>    
    <div class="mt-2"><input type="text" id="first_name" name="first_name"  value="<?php echo set_value("first_name")?>" placeholder="Name *">
    <?php echo form_error('first_name');?>
    </div>
    <div class="mt-2"><input type="text" id="email" name="email" value="<?php echo set_value("email")?>" placeholder="E-mail ID *">
    <?php echo form_error('email');?>
    </div>
    <div class="mt-2"><input type="text" id="mobile_number" name="mobile_number"  value="<?php echo set_value("mobile_number")?>" placeholder="Mobile No. *">
    <?php echo form_error('mobile_number');?>
    </div> 
    <div class="mt-2"><textarea name="comment" rows="4" id="comment" placeholder="Message  *"><?php echo set_value("comment")?></textarea>
    <?php echo form_error('comment');?>
    </div>
    <div class="mt-2"><input type="text" id="verification" name="verification_code" placeholder="Enter Code  *" style="width:90px;"> 
    
    <img src="<?php echo site_url('captcha/normal'); ?>" alt="" class="vam" id="captchaimage"><a href="javascript:void(0);" onclick="document.getElementById('captchaimage').src='<?php echo base_url().'captcha/normal'; ?>/<?php echo uniqid(time()); ?>'+Math.random(); document.getElementById('verification_code').focus();"><img src="<?php echo theme_url();?>images/ref.png" alt="" class="vam"></a>
    <?php echo form_error('verification_code');?>
    </div>
    <p class="fs12 mt-1">Type the characters shown above.</p>    
    <p class="mt-3"><input id="submit" name="submit" type="submit" value="Submit" class="btn btn-yel" >
      <input name="input" type="reset" value="Reset" class="btn"></p>
</div>
<?php echo form_open();?>
</div>

</div>

<p class="clearfix"></p>
</div>

<div class="clearfix"></div>
</div>
</div>

<div class="contact_map"><iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3500.980284678312!2d77.14930131516456!3d28.660308982407003!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x390d047b9ac873eb%3A0x8ba67479adbb2ee8!2sWeblinkIndia.Net!5e0!3m2!1sen!2sin!4v1503996801817" frameborder="0" style="border:0" allowfullscreen></iframe></div>

</div>
<!-- MIDDLE ENDS -->

<?php $this->load->view('bottom_application');?>