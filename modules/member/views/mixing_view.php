<?php $this->load->view("top_application");?>

<!-- Breadcrumb --> 
<div class="breadcrumb_outer">
<div class="container">
<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="<?php echo base_url();?>">Home</a></li>
  <li class="breadcrumb-item"><a href="<?php echo site_url('member/indivisualservice');?>">Individual Services</a></li>
  <li class="breadcrumb-item"><a href="<?php echo site_url('member/musicproduction');?>">Music Production</a></li>
 
  <li class="breadcrumb-item active">Mixing</li>
</ol>
</div>
</div>
<!-- Breadcrumb End -->

<!-- MIDDLE STARTS -->
<div class="live_inst_bg">
<div class="container">
<div class="cms">

<h1 class="mb-2 text-center purple2">Mixing</h1>
<?php echo form_open_multipart("member/mixing");?>
<div class="reg_box">
<div>
<div class="row">
<p class="col-md-12 no_pad mt-2 mb-1 white weight600">Select One Of Track</p>
<div class="col-md-12 no_pad">
<div class="row"> <span class="checkmark"></span></label>
<?php for($i=1;$i<=16;$i++){?>
<div class="col-md-6 no_pad"><label class="cust_radio mr-4">Track <?php echo $i;?><input type="radio" name="track_id" value="<?php echo $i;?>" <?php if($this->input->post('track_id')==$i){ echo "checked";}?> onChange="getmixingduration(this.value)"><span class="checkmark"></span></label></div>
<?php }?>

</div>
<?php echo form_error('track_id');?>
</div>
<?php
$track_id=@$this->input->post('track_id');
$rwtrackArr=get_db_multiple_row("tbl_mixing_price","price_id,duration","track_id ='$track_id' ORDER BY duration ASC");
?>
<div class="col-md-12 no_pad mt-2"><select name="duration" id="mixingdurationID" onChange="getmixingprice(this.value)">
  <option value="">Duration</option>
<?php
 if(is_array($rwtrackArr) && count($rwtrackArr) > 0){
	 foreach($rwtrackArr as $dVal){
?>  
  <option value="<?php echo $dVal['price_id'];?>" <?php if($this->input->post('duration')==$dVal['price_id']){ echo "Selected";}?>><?php echo $dVal['duration'];?> Minute</option>
<?php 
	 }
 }?>
</select>
<?php echo form_error('duration');?>
</div>
<div class="col-md-12 no_pad mt-2" id="mixingdurationpriceID"><input name="price" type="text" placeholder="Price *" value="<?php echo set_value('price');?>" readonly>
<?php echo form_error('price');?>
</div>
<div class="col-md-12 no_pad mt-2">
  <textarea name="comment" rows="5" placeholder="Leave Comment *"><?php echo set_value('comment');?></textarea>
  <?php echo form_error('comment');?>
</div>
<div class="col-md-12 no_pad mt-2">Upload File<br><input name="image1" type="file"><p class="fs12 yel">File Format: PDF, Doc, Mp4</p></div>
</div> 
<?php echo form_error('image1');?>   
</div>
<p class="mt-3"><input name="" type="submit" class="btn btn-yel" value="Pay Now" >
<input type="hidden" name="action" value="Add">
</p>
</div>
<?php echo form_close();?>
</div>
</div>
</div>
<!-- MIDDLE ENDS -->

<?php $this->load->view("bottom_application");