<?php $this->load->view("top_application"); 
$hearfor=$this->config->item('hearfor');
?>

<!-- Breadcrumb --> 
<div class="breadcrumb_outer">
<div class="container">
<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="<?php echo base_url();?>">Home</a></li>
  <li class="breadcrumb-item active">Career</li>
</ol>
</div>
</div>
<!-- Breadcrumb End -->

<!-- MIDDLE STARTS -->
<div class="career_bg">
<div class="container">
<div class="cms">

<h1 class="mb-2 text-center black"><i class="far fa-address-card fs18 mr-2 align-middle"></i> Career</h1>
<?php echo form_open_multipart("career");?>
<div class="reg_box">
  <div>
<div class="row">
<?php echo error_message();?>
<div class="col-md-12 no_pad mt-2"><input name="name" type="text" placeholder="Name *" value="<?php echo set_value("name");?>"><?php echo form_error("name");?></div>
<div class="col-md-12 no_pad mt-2"><input name="family_name" type="text" placeholder="Family Name" value="<?php echo set_value("family_name");?>"><?php echo form_error("family_name");?></div>
<div class="col-md-12 no_pad mt-2"><input name="contact_no" type="text" placeholder="Contact No. *" value="<?php echo set_value("contact_no");?>"><?php echo form_error("contact_no");?></div>
<div class="col-md-12 no_pad mt-2"><input name="email" type="text" placeholder="Email ID *" value="<?php echo set_value("email");?>"><?php echo form_error("email");?></div>
<div class="col-md-12 no_pad mt-2"><input name="dob" type="text" placeholder="Date of Birth *" style="width:88%;" value="<?php echo set_value("dob");?>" id="dateofbirth"> <?php echo form_error("dob");?></div>
<div class="col-md-12 no_pad mt-2"><select name="gnder">
  <option value="">Gender</option>
  <option value="Male" <?php if($this->input->post('gnder')=='Male'){ echo "Selected";}?>>Male</option>
  <option value="Female" <?php if($this->input->post('gnder')=='Female'){ echo "Selected";}?>>Female</option>
</select><?php echo form_error("gnder");?></div>
<div class="col-md-12 no_pad mt-2"><select name="nationality">
  <option value="">Nationality</option>
<?php if(is_array($rwnatArr) && count($rwnatArr) > 0 ){
	foreach($rwnatArr as $natVal){?>  
  <option value="<?php echo $natVal['nationality'];?>" <?php if($this->input->post('nationality')==$natVal['nationality']){ echo "Selected";}?>><?php echo $natVal['nationality'];?></option>
  <?php }
}?>
</select><?php echo form_error("nationality");?></div>
<div class="col-md-12 no_pad mt-2"><select name="country">
  <option value="">Country of Residence</option>
 <?php
 if(is_array($rwcontArr) && count($rwcontArr) > 0 ){
	 foreach($rwcontArr as $contVal){
 ?> 
   <option value="<?php echo $contVal['country_name'];?>" <?php if($this->input->post('country')==$contVal['country_name']){ echo "Selected";}?>><?php echo $contVal['country_name'];?></option>
 <?php }
 }?>
</select><?php echo form_error("country");?></div>
<div class="col-md-12 no_pad mt-2"><select name="marital_status">
  <option value="">Marital Status</option>
  <option value="Married" <?php if($this->input->post('marital_status')=='Married'){ echo "Selected";}?>>Married</option>
  <option value="Unmarried" <?php if($this->input->post('marital_status')=='Unmarried'){ echo "Selected";}?>>Unmarried</option>
</select>
<?php echo form_error("marital_status");?>
</div>
<div class="col-md-12 no_pad mt-2"><select name="hear_from_us">
  <option value="">How did you hear from us?</option>
<?php if(is_array($hearfor) && count($hearfor) > 0 ){  
       foreach($hearfor as $hvl){ ?>
       <option value="<?php echo $hvl;?>" <?php if($this->input->post('hear_from_us')==$hvl){ echo "Selected";}?>><?php echo $hvl;?></option>
<?php }
}?>
</select>
<?php echo form_error("hear_from_us");?>
</div>


<div class="col-md-12 no_pad mt-2"><select name="designation">
  <option value="">Designation Applying For</option>
  <?php
 if(is_array($rwdesArr) && count($rwdesArr) > 0 ){
	 foreach($rwdesArr as $desVal){
 ?> 
   <option value="<?php echo $desVal['designation'];?>" <?php if($this->input->post('designation')==$desVal['designation']){ echo "Selected";}?>><?php echo $desVal['designation'];?></option>
 <?php }
 }?>
</select>
<?php echo form_error("designation");?>
</div>
<div class="col-md-12 no_pad mt-2">
<div>Upload Resume<br><input name="image1" type="file"></div>
<div class="fs12 yel">(File Frmat: doc, pdf) (Max size: 1 mb)</div>
<?php echo form_error("image1");?>
</div>
<div class="col-md-6 no_pad mt-2"><input name="verification_code" type="text" placeholder="Enter Code *">
<?php echo form_error("verification_code");?>
</div>  
<div class="col-md-6 no_pad mt-2"><img src="<?php echo site_url('captcha/normal'); ?>" alt="" class="vam" id="captchaimage"><a href="javascript:void(0);" onclick="document.getElementById('captchaimage').src='<?php echo base_url().'captcha/normal'; ?>/<?php echo uniqid(time()); ?>'+Math.random(); document.getElementById('verification_code').focus();"><img src="<?php echo theme_url();?>images/ref.png" alt="" class="vam"></a>

</div>
</div>    
</div>
<div class="mt-1 fs13">Type the characters shown above.</div>
<div class="mt-4"><input name="" type="submit" class="btn btn-yel" value="Send">
<input type="hidden" name="action" value="Add">
</div>

</div>
<?php echo form_close();?>
</div>
</div>
</div>

<?php
//$default_date = '2013-08-12';
$default_date = date('Y-m-d');
$posted_start_date = $this->input->post('date_birth');
?>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/developers/js/jquery/ui/jquery-ui.js"></script>
<link type="text/css" href="<?php echo base_url(); ?>assets/developers/js/jquery/ui/themes/ui-lightness/jquery.ui.all.css" rel="stylesheet" />
<script type="text/javascript">
$(document).ready(function(){

$("#dateofbirth").datepicker({
showOn: "both",
dateFormat: 'yy-mm-dd',
changeMonth: true,
changeYear: true,
defaultDate: 'y',
buttonText:'',
buttonImage: '<?php echo theme_url();?>images/calendar.png',
<?php /*?>minDate:'<?php echo $posted_start_date!='' ? $posted_start_date :  $default_date;?>' ,<?php */?>
maxDate:'',
yearRange: "1950:<?php echo date('Y')-18;?>",
buttonImageOnly: true,
onSelect: function(dateText, inst) {
$('#dateofbirth').val(dateText);
}
});
});
</script>
<!-- MIDDLE ENDS -->
<?php $this->load->view("bottom_application");