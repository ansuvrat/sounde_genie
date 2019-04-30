<?php $this->load->view("top_application");?>

<!-- Breadcrumb --> 
<div class="breadcrumb_outer">
<div class="container">
<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="<?php echo base_url();?>">Home</a></li>
  <li class="breadcrumb-item"><a href="<?php echo site_url("member/indivisualservice");?>">Individual Services</a></li>
  <li class="breadcrumb-item"><a href="<?php echo site_url('member/soundproduction');?>">Sound Production</a></li>
  <li class="breadcrumb-item active">Sound Recording</li>
</ol>
</div>
</div>
<!-- Breadcrumb End -->

<!-- MIDDLE STARTS -->
<div class="live_inst_bg">
<div class="container">
<div class="cms">

<h1 class="mb-2 text-center purple2">Sound Recording</h1>
<?php echo form_open_multipart("member/soundrecording");?>
<div class="reg_box">
<div>
<div class="row">
<p class="col-md-12 no_pad mt-2 mb-1 white weight600">Select Recording Category</p>
<div class="col-md-12 no_pad">
<div class="row">
<?php if(is_array($rwcat) && count($rwcat) > 0 ){
	   foreach($rwcat as $catVal){
	?>
<div class="col-md-6 no_pad"><label class="cust_radio mr-4"><?php echo $catVal['cat_name'];?> <input type="radio" name="cat_id" value="<?php echo $catVal['id'];?>" <?php if($this->input->post('cat_id')==$catVal['id']){ echo "checked";}?> onChange="getrecordingcategorypeice(this.value)"> <span class="checkmark"></span></label></div>
<?php }
}
 ?>
<?php echo form_error('cat_id');?>
</div>
</div>
<div class="col-md-12 no_pad mt-2"><input name="prefer_date" type="text" placeholder="Prefered Date *" style="width:88%;" id="prefer_date" readonly="readonly" value="<?php echo $this->input->post('prefer_date');?>">
<?php echo form_error('prefer_date');?>
 </div>
<div class="col-md-12 no_pad mt-2" id="recordingcategorypeiceID">
  <input name="price" type="text" readonly value="<?php echo set_value('price');?>" placeholder="Price *">
  <?php echo form_error('cat_id');?>
</div>
<div class="col-md-12 no_pad mt-2">
  <textarea name="comment" rows="5" placeholder="Leave Comment *"><?php echo set_value('comment');?></textarea>
  <?php echo form_error('comment');?>
</div>
<div class="col-md-12 no_pad mt-2">Upload File<br><input name="image1" type="file"><p class="fs12 yel">File Format: PDF, Doc, Mp4</p></div>
</div>    
<?php echo form_error('image1');?>
</div>
<p class="mt-1 fs13">Type the characters shown above.</p>
<p class="mt-3"><input name="" type="submit" class="btn btn-yel" value="Pay Now" >
<input type="hidden" name="action" value="Add">
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
<?php $this->load->view("bottom_application");