<?php 
	if(!empty($res) && is_array($res)){
		$ctr=1;
		foreach ($res as $key=>$val){
			$print_url="cart/print_pginvoice/".$val['order_id']
 ?>
<div class="odr-his text listpager">  
<div class="row">
<div class="col-lg-1 col-md-1 col-sm-1 p0"> <?php echo $ctr;?>.</div>
<div class="col-lg-6 col-md-6 col-sm-6 p0"> 
<p class="inv_ttl">Order ID.: <b class="black"><a href="<?php echo base_url().$print_url;?>" class="u " title="Invoice"><?php echo $val['invoice_number'];?></a></b></p>
<p class=""><b>Purchased On:</b> <?php echo getdateFormat($val['order_received_date'],1);?> / <br class="visible-sm visible-xs"><b>Amount <?php echo display_price($val['total_amount']);?>:</b> <span class="red"><?php echo $val['payment_status'];?></span></p>
</div>
<div class="col-lg-3 col-md-3 col-sm-3 p0">
<p><b>Order Status:</b> <em class="green"><?php echo $val['order_status'];?></em></p>
<p><b>Payment Status:</b> <em class="red"><?php echo $val['payment_status'];?></em></p></div>
<div class="col-lg-2 col-md-2 col-sm-2 p0 text-center black ttu"> <a href="<?php echo base_url().$print_url;?>" title="Invoice" class="invoice1"> <img src="<?php echo theme_url();?>images/view.png" alt=""></a> </div>
<div class="clearfix"></div>
</div>
</div>
<?php 
     $ctr++;
	}
}else{ ?>
<div align="center"><strong>No records found...</strong></div>	
<?php } ?> 