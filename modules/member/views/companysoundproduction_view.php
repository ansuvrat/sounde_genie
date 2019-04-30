<?php $this->load->view("top_application");?>

<!-- Breadcrumb --> 
<div class="breadcrumb_outer">
<div class="container">
<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="<?php echo base_url();?>">Home</a></li>
  <li class="breadcrumb-item"><a href="<?php echo site_url("member/companyservice");?>">Company Services</a></li>
  <li class="breadcrumb-item active">Sound Design</li>
</ol>
</div>
</div>
<!-- Breadcrumb End -->

<!-- MIDDLE STARTS -->
<div class="live_inst_bg">
<div class="container">
<div class="cms">

<h1 class="mb-2 text-center">Sound Design</h1>
<?php echo form_open_multipart('member/companysoundproduction');?>
<div class="reg_box">
<div>
<div class="row">
<div class="col-md-12 no_pad mt-2"><select name="cat_id" onChange="getcompanysounddesign(this.value)">
  <option value="">Select Sound Design Category</option>
<?php
 if(is_array($rwcatArr) && count($rwcatArr) > 0 ){
	 foreach($rwcatArr as $catVal){
?>  
  <option value="<?php echo $catVal['id'];?>" <?php if($this->input->post('cat_id')==$catVal['id']){ echo "Selected";}?>><?php echo $catVal['sounddegn_category'];?></option>
  <?php }
 }?>
</select>
<?php echo form_error("cat_id");?>
</div>
<?php
$cat_id=@$this->input->post('cat_id');
$rwdesigndurArr=get_db_multiple_row("tbl_sound_designing","duration,id","cat_id ='$cat_id'");
?>
<div class="col-md-12 no_pad mt-2"><select name="duration" id="compsdesignID" onChange="getcompanysounddesignprice(this.value)">
  <option value="">Duration</option>
  <?php
		 if(is_array($rwdesigndurArr) && count($rwdesigndurArr) > 0 ){
			 foreach($rwdesigndurArr as $durVal){ ?>
            <option value="<?php echo $durVal['id'];?>" <?php if($this->input->post('duration')==$durVal['id']){ echo "Selected";}?>><?php echo $durVal['id'];?> Minutes</option>   
       <?php }
		 }?>
</select>
<?php echo form_error("duration");?>
</div>
<div class="col-md-12 no_pad mt-2" id="compsdesignpriceID"><input name="price"  type="text" value="<?php echo set_value('price');?>" placeholder="Price *" readonly >
<?php echo form_error("price");?>
</div>

<div class="col-md-12 no_pad mt-2">
  <textarea name="comment" rows="5" placeholder="Leave Comment *"><?php echo set_value('comment');?></textarea>
  <?php echo form_error("comment");?>
</div>
<div class="col-md-12 no_pad mt-2">Upload File<br><input name="image1" type="file"><p class="fs12 yel">File Format: PDF, Doc, Mp4</p>
<?php echo form_error("image1");?>
</div>

</div>    
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

<?php $this->load->view("bottom_application");