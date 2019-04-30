<?php $this->load->view("top_application");?>
<!-- Breadcrumb --> 
<div class="breadcrumb_outer">
<div class="container">
<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="<?php echo base_url();?>">Home</a></li>
  <li class="breadcrumb-item"><a href="<?php echo site_url('member');?>">Individual Services</a></li>
  <li class="breadcrumb-item"><a href="<?php echo site_url('member/musicproduction');?>">Music Production</a></li>
  <li class="breadcrumb-item"><a href="<?php echo site_url('member/composition');?>">Composition</a></li>
  <li class="breadcrumb-item active">Virtual Instrument</li>
</ol>
</div>
</div>
<!-- Breadcrumb End -->
<!-- MIDDLE STARTS -->
<div class="live_inst_bg">
<div class="container">
<div class="cms">

<h1 class="mb-2 text-center purple2">Virtual Instrument</h1>
<?php echo form_open_multipart('member/virtualinstrument');?>
<div class="reg_box">

<div>
<div class="row">
<p class="col-md-12 no_pad mt-2 mb-1 white weight600">Select Instrument Type</p>
<div class="col-md-12 no_pad">
<div class="row">
<?php if(is_array($rwinstypeArr) && count($rwinstypeArr) > 0 ){
	  foreach($rwinstypeArr as $val){
	 ?>
<div class="col-md-6 no_pad"><label class="cust_radio mr-4"><?php echo $val['title'];?> <input  name="instype" type="radio" value="<?php echo $val['id'];?>" <?php if($this->input->post('instype')==$val['id']){ echo "checked";}?> onChange="getvirtualinstrumentduration(this.value)"><span class="checkmark"></span></label></div>
<?php }
}
?>
<?php echo form_error('instype');?>
</div>
</div>
<?php
$instype=$this->input->get_post('instype');
$rwdesigndurArr=get_db_multiple_row("tbl_virtual_instru_price","duration,price_id","instrument_type ='$instype'");
?>
<div class="col-md-12 no_pad mt-2"><select name="duration" id="virtualinstrumentduration" onChange="getvirtualinstrumentdurationprice(this.value)">
  <option value="">Duration</option>
<?php if(is_array($rwdesigndurArr) && count($rwdesigndurArr) > 0 ){
	foreach($rwdesigndurArr as $cVal){ ?>
     <option value="<?php echo $cVal['price_id'];?>" <?php if($this->input->post('duration')==$cVal['price_id']){ echo "Selected";}?>><?php echo $cVal['duration'];?></option> 
<?php }
}?>
</select>
<?php echo form_error('duration');?>
</div>
<div class="col-md-12 no_pad mt-2" id="virtualinstrumentpriceID"><input name="price" type="text" placeholder="Price *" value="<?php echo set_value("price");?>"></div>
<div class="col-md-12 no_pad mt-2">
  <textarea name="comment" rows="5" placeholder="Leave Comment *"><?php echo set_value('comment');?></textarea>
  <?php echo form_error('comment');?>
</div>
<div class="col-md-12 no_pad mt-2">Upload File<br><input name="image1" type="file"><p class="fs12 yel">File Format: PDF, Doc, Mp4</p>
<?php echo form_error('image1');?>
</div>
</div>    
</div>
<div class="mt-3"><input name="" type="submit" class="btn btn-yel" value="Pay Now" >
<input type="hidden" name="action" value="Add">
</div>
</div>
<?php echo form_close();?>
</div>
</div>
</div>
<!-- MIDDLE ENDS -->

<?php $this->load->view("bottom_application");