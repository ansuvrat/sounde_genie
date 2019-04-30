<?php $this->load->view("top_application");?>

<!-- Breadcrumb --> 
<div class="breadcrumb_outer">
<div class="container">
<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="<?php echo site_url();?>">Home</a></li>
  <li class="breadcrumb-item"><a href="<?php echo site_url('member/indivisualservice');?>">Individual Services</a></li>
  <li class="breadcrumb-item"><a href="<?php echo site_url('member/musicproduction');?>">Music Production</a></li>
  <li class="breadcrumb-item"><a href="<?php echo site_url('member/composition');?>">Composition</a></li>
  <li class="breadcrumb-item active">Live Instrument</li>
</ol>
</div>
</div>
<!-- Breadcrumb End -->

<!-- MIDDLE STARTS -->
<div class="live_inst_bg">
<div class="container">
<div class="cms">

<h1 class="mb-2 text-center purple2">Live Instrument</h1>
<?php echo form_open_multipart("member/liveinstrument");?>
<div class="reg_box">
<?php echo error_message();?>

<div>
<div class="row">
<p class="col-md-12 no_pad mt-2 mb-1 white weight600">Select Category</p>
<div class="col-md-12 no_pad">
<div class="row">
<?php 
$instype=@$this->input->post('instype');

if(is_array($rwdata) && count($rwdata) > 0 ){
	  foreach($rwdata as $instpVal){
		  if(is_array($instype) && count($instype)){
			  if(in_array($instpVal['id'],$instype)){
				   $chkvl='checked';
			  }else{
				 $chkvl='';   
			  }
		  }else{
			$chkvl='';  
		  }
		  ?>
<div class="col-md-6 no_pad"><label class="check_cust"><?php echo $instpVal['title'];?><input type="checkbox" name="instype[]" value="<?php echo $instpVal['id'];?>" <?php echo $chkvl;?>><span class="checkmark"></span></label></div>
<?php }
}
  ?>
</div>
<?php echo form_error('instype[]');?>
</div>
<div class="col-md-12 no_pad mt-2"><input name="prefer_date" type="text" placeholder="Preferred Date *" style="width:88%;" id="prefer_date" readonly value="<?php echo $this->input->post('prefer_date');?>"> 
<?php echo form_error('prefer_date');?>
</div>

<div class="col-md-12 no_pad mt-2">
  <textarea name="comment" rows="5" placeholder="Leave Comment *"><?php echo set_value('comment');?></textarea>
  <?php echo form_error('comment');?>
</div>
<div class="col-md-12 no_pad mt-2">Upload File<br><input name="image1" type="file"><p class="fs12 yel">File Format: PDF, Doc, Mp4</p>
<?php echo form_error('image1');?>
</div>
</div>    
</div>
<p class="mt-1 fs13">Type the characters shown above.</p>
<p class="mt-4"><input name="" type="submit" class="btn btn-yel" value="Send">
<input type="hidden" name="action" value="Add" />
</p>

</div>
<?php echo form_close();?>
</div>
</div>
</div>
<!-- MIDDLE ENDS -->
<?php
//$default_date = '2013-08-12';
$default_date = date('Y-m-d');
?>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/developers/js/jquery/ui/jquery-ui.js"></script>
<link type="text/css" href="<?php echo base_url(); ?>assets/developers/js/jquery/ui/themes/ui-lightness/jquery.ui.all.css" rel="stylesheet" />
<script type="text/javascript">
$(document).ready(function(){

$("#prefer_date").datepicker({
showOn: "both",
dateFormat: 'dd-mm-yy',
changeMonth: true,
changeYear: true,
defaultDate: 'y',
buttonText:'',
minDate:'<?php echo $default_date;?>' ,
buttonImage: '<?php echo theme_url();?>images/calendar.png',
maxDate:'',
yearRange: "c-100:c+100",
buttonImageOnly: true,
onSelect: function(dateText, inst) {
$('#prefer_date').val(dateText);
}
});

});
</script>
<?php $this->load->view("bottom_application");?>