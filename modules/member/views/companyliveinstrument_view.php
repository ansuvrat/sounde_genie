<?php $this->load->view("top_application");?>

<!-- Breadcrumb --> 
<div class="breadcrumb_outer">
<div class="container">
<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="<?php echo base_url();?>">Home</a></li>
  <li class="breadcrumb-item"><a href="<?php echo site_url("member/companyservice");?>">Company Services</a></li>
  <li class="breadcrumb-item"><a href="<?php echo site_url("member/companymusicproduction");?>">Music Production</a></li>
  <li class="breadcrumb-item active">Live Real Instrument</li>
</ol>
</div>
</div>
<!-- Breadcrumb End -->

<!-- MIDDLE STARTS -->
<div class="live_inst_bg">
<div class="container">
<div class="cms">

<h1 class="mb-2 text-center">Live Real Instrument</h1>
<?php echo form_open_multipart("member/companyliveinstrument");?>
<div class="reg_box">
<div>
<div class="row">
<p class="col-md-12 no_pad mt-2 mb-1 white weight600">Select Instrument Type</p>
<div class="col-md-12 no_pad">
<div class="row">
<?php if(is_array($rwtesttype) && count($rwtesttype)){
	   foreach($rwtesttype as $val){
	?>
<div class="col-md-6 no_pad"><label class="cust_radio"><?php echo $val['title'];?><input type="radio" name="instype" onchange="getliveinstrumentduration(this.value);" value="<?php echo $val['id'];?>" <?php if($this->input->post('instype')==$val['id']){ echo "checked";}?>><span class="checkmark"></span></label></div>
<?php }
 }
 ?>

</div>
<?php echo form_error('instype');?>
</div>
<?php
$instype=@$this->input->post('instype');
$rwdata=get_db_multiple_row("tbl_virtual_instru_price","price_id,duration","instrument_type ='$instype' ORDER BY duration ASC");
?>
<div class="col-md-12 no_pad mt-2" ><select name="duration" id="liveinsID" onchange="getliveinstrumentprice(this.value);">
  <option value="">Duration</option>
<?php if(is_array($rwdata) && count($rwdata) > 0 ){
			 foreach($rwdata as $insVal){
				 ?>
            <option value="<?php echo $insVal['price_id'];?>" <?php if($this->input->post('duration')==$insVal['price_id']){ echo "Selected";}?>><?php echo $insVal['duration'];?> Minutes</option>     
<?php }
}?>
</select>
<?php echo form_error('duration');?>
</div>
<div class="col-md-12 no_pad mt-2" id="livepriceID"><input name="price" type="text" value="<?php echo set_value('price');?>" placeholder="Price" readonly>
<?php echo form_error('price');?>
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
<p class="mt-3"><input name="" type="submit" class="btn btn-yel" value="Pay Now" >
<input type="hidden" name="action" value="Add" />
</p>

</div>
<?php echo form_close();?>
</div>
</div>
</div>
<!-- MIDDLE ENDS -->

<?php $this->load->view("bottom_application");