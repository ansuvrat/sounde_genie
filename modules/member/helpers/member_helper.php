<?php
function get_invoice($rwdta,$print=FALSE){
	$CI =& get_instance();
	
	?>
<div style="background:#090015; padding:20px; border-radius:10px;">
<div style="float:left; width:70%;">
<div><b style="display:block; font-size:18px; line-height:22px; text-transform:uppercase; color:#fff;">Sound Genie</b> </div>
<div style="margin-top:10px;"><?php echo $CI->admin_info->address;?></div>
<div style="margin-top:10px;"><b>Ph No. :</b> <?php echo $CI->admin_info->mobile;?></div>
</div>   
<div style="float:right;"><img src="<?php echo theme_url();?>images/soundgenie.png" width="130" alt=""></div>
<div style="clear:both;"></div>
</div>

<div style="margin-top:20px;">
<div style="float:left; width:48%;">
<div style="background:#13022a; padding:15px;min-height:110px; margin-top:15px; border-radius:10px;height:147px;">
<div style="font-size:15px;  margin-bottom:5px; color:#fff;">Order Summary</div>
<div style="margin-top:5px; line-height:20px; font-size:13px;">
<div style="margin-top:5px;"><b>Invoice ID:</b> <?php echo $rwdta['order_id'];?></div>
<div style="margin-top:5px;"><b>Order Date:</b> <?php echo getdateFormat($rwdta['order_date'],1);?></div>
<div style="margin-top:5px;"><b>Total Payable Amount</b> : <?php echo display_price($rwdta['price']);?></div>
<div style="margin-top:5px;"><b>Payment Status</b> : <?php echo ($rwdta['pay_status']==1)?'Pending':'Paid';?></div>
</div>
</div>
</div>

<div style="float:right; width:48%;">
<div style="background:#13022a; padding:15px;min-height:110px; margin-top:15px; border-radius:10px; height:147px;" >
<div style="margin-top:5px; line-height:20px; font-size:13px;">
<div style="font-weight:bold; color:#fff;"><?php echo $rwdta['name'];?></div>
<div>Phone No. : <?php echo $rwdta['phone'];?></div>
<div>Email ID : <?php echo $rwdta['email'];?></div>
</div>
</div>
</div>

<div style="clear:both;"></div>

</div>

<div style="background:#13022a; padding:15px;min-height:110px; margin-top:25px; border-radius:10px;">
<div style="float:left; width:33%; margin-top:25px;">
<div style="color:#fff; font-size:15px;">Product/Title</div>
<div style="margin-top:5px;"><?php echo $rwdta['product'];?></div>
</div>
<?php if($rwdta['prefer_date']!=''){?>
<div style="float:left; width:33%; margin-top:25px;">
<div style="color:#fff; font-size:15px;">Prefer Date</div>
<div style="margin-top:5px;"><?php echo getdateFormat($rwdta['prefer_date'],1);?></div>
</div>
<?php }
if($rwdta['duration'] > 0){
 ?>
<div style="float:left; width:33%; margin-top:25px;">
<div style="color:#fff; font-size:15px;">Duration</div>
<div style="margin-top:5px;">
<?php 
if($rwdta['duration'] > 0 ){
  $durArr = explode('.',$rwdta['duration']);
  echo $durArr[0];
  if($durArr[1] > 0 ){
	echo ":".$durArr[1];  
  }
}
?>
 Minutes</div>
</div>
<?php }
if($rwdta['album_track']!=''){
 ?>
 <div style="float:left; width:33%; margin-top:25px;">
<div style="color:#fff; font-size:15px;">Tracks</div>
<div style="margin-top:5px;"><?php echo $rwdta['album_track'];?> </div>
</div>
<?php } ?> 
<div style="float:right; width:33%; margin-top:25px;">
<div style="color:#fff; font-size:15px;">Price</div>
<div style="margin-top:5px;"><?php echo display_price($rwdta['price']);?></div>
</div>
<div style="clear:both;"></div>
<div style="color:#fff; font-size:15px; margin-top:25px;">Comment</div>
<div style="margin-top:5px;"><?php echo $rwdta['comment'];?></div>
</div>  
<div style=" padding:15px;min-height:10px; margin-top:25px; border-radius:10px;" align="center">
<?php if($print){?>
<p class="text-center white mt-4 d-none d-lg-block"><a data-fancybox data-type="iframe" data-src="<?php echo site_url("member/printinvoice/".md5($rwdta['order_id']));?>" href="javascript:void(0);" class="pop2"><b class="fas fa-print"></b> Print Invoice</a></p>
<?php }else{?>
<p align="center"><a href="#" onClick="window.print();" ><b class="fas fa-print"></b> <font color="#FFFFFF">Print Invoice</font></a></p>
<?php } ?>
</div>
<?php	
}

?>