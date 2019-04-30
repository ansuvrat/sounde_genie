<?php $this->load->view("top_application");?>

<!-- Breadcrumb --> 
<div class="breadcrumb_outer">
<div class="container">
<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="<?php echo base_url();?>">Home</a></li>
  <li class="breadcrumb-item"><a href="<?php echo site_url('member');?>">Individual Services</a></li>
  <li class="breadcrumb-item"><a href="<?php echo site_url('member/musicproduction');?>">Music Production</a></li>
  <li class="breadcrumb-item"><a href="<?php echo site_url('member/lyrics');?>">Lyrics</a></li>
  <li class="breadcrumb-item active">Full Album Lyrics</li>
</ol>
</div>
</div>
<!-- Breadcrumb End -->

<!-- MIDDLE STARTS -->
<div class="live_inst_bg">
<div class="container">
<div class="cms">

<h1 class="mb-2 text-center purple2">Full Album Lyrics</h1>
<?php echo form_open_multipart("member/fullalbumlyrics");?>
<div class="reg_box">
<div>
<div class="row">
<div class="col-md-12 no_pad mt-2"><input name="title" type="text" placeholder="Title *" value="<?php echo set_value('title');?>">
<?php echo form_error('title');?></div>
<div class="col-md-12 no_pad mt-2"><select name="duration" onChange="getfullmusicalpieceprice(this.value)">
  <option value="">Duration</option>
<?php
 if(is_array($rwdata) && count($rwdata) > 0){
	 foreach($rwdata as $val){
?>  
   <option value="<?php echo $val['price_id'];?>" <?php if($this->input->post('duration')==$val['price_id']){ echo "Selected";}?>><?php echo $val['duration'];?> Minutes</option>
 <?php
	 }
 }?>
</select>
<?php echo form_error('duration');?></div>
<div class="col-md-12 no_pad mt-2" id="fullmusicalpiecepriceID"><input name="price" type="text" placeholder="Price *" value="<?php echo set_value('price');?>" readonly>
<?php echo form_error('price');?></div>
<div class="col-md-12 no_pad mt-2">
  <textarea name="comment" rows="5" placeholder="Leave Comment *"><?php echo set_value('comment');?></textarea>
  <?php echo form_error('comment');?>
</div>
<div class="col-md-12 no_pad mt-2">Upload File<br><input name="image1" type="file"><p class="fs12 yel">File Format: PDF, Doc, Mp4</p></div>
<?php echo form_error('image1');?>
</div>    
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
