<?php $this->load->view("top_application");?>

<!-- Breadcrumb --> 
<div class="breadcrumb_outer">
<div class="container">
<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="<?php echo base_url();?>">Home</a></li>
  <li class="breadcrumb-item"><a href="<?php echo site_url('member');?>">Individual Services</a></li>
  <li class="breadcrumb-item"><a href="<?php echo site_url('member/musicproduction');?>">Music Production</a></li>
  <li class="breadcrumb-item"><a href="<?php echo site_url('member/mastering');?>">Mastering</a></li>
  <li class="breadcrumb-item active">Full Album Masteringddd</li>
</ol>
</div>
</div>
<!-- Breadcrumb End -->

<!-- MIDDLE STARTS -->
<div class="live_inst_bg">
<div class="container">
<div class="cms">

<h1 class="mb-2 text-center purple2">Full Album Mastering</h1>
<?php echo form_open_multipart("member/fullalbummastering");?>
<div class="reg_box">

<div>
<div class="row">
<div class="col-md-12 no_pad mt-2"><input name="title" type="text" placeholder="Album Title *" value="<?php echo set_value('title');?>">
<?php echo form_error('title');?>
</div>
<div class="col-md-12 no_pad mt-2 mb-1 white weight600">Select No. of Tracks</div>
<div class="col-md-12 no_pad">
<div class="row">
<?php 
$trackArr=@$this->input->post('track');
if(is_array($rwdata) && count($rwdata) > 0 ){
	   foreach($rwdata as $val){
		   if(is_array($trackArr) && count($trackArr) > 0){
			   if(in_array($val['price_id'],$trackArr)){
				   $chkvl="checked"; 
			   }else{
				  $chkvl="";  
			   }
		   }else{
			$chkvl="";   
		   }
		    ?>
<div class="col-md-6 no_pad"><label class="check_cust">Track <?php echo $val['duration'];?><input type="checkbox" name="track[]" value="<?php echo $val['price_id'];?>" <?php echo $chkvl;?> onChange="getfullalbummasteringprice(this.value)" id="trackID"><span class="checkmark"></span></label></div>
<?php
   }
}?>
</div>
<?php echo form_error('track[]');?>
</div>
<?php
$price='';
$track=@$this->input->post('track');
if(is_array($track) && count($track) > 0 ){
			  foreach($track as $val){
				 $rwliveinsprice=get_db_single_row("tbl_mastring_price","price"," AND price_id ='$val'"); 
				 if(is_array($rwliveinsprice) && count($rwliveinsprice) > 0 ){
					$price=$price+$rwliveinsprice['price']; 
				 }
			  }
			}
?>
<div class="col-md-12 no_pad mt-2" id="fullalbummasteringpriceID"><input name="price" type="text" placeholder="Price *" value="<?php echo set_value('price',$price);?>" readonly>
<?php echo form_error('price');?>
</div>
<div class="col-md-12 no_pad mt-2">
  <textarea name="comment" rows="5" placeholder="Leave Comment *"><?php echo set_value('comment');?></textarea>
  <?php echo form_error('comment');?>
</div>
<div class="col-md-12 no_pad mt-2">Upload File<br><input name="image1" type="file"><p class="fs12 yel">File Format: PDF, Doc, Mp4</p></div>
<?php echo form_error('image1');?>
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