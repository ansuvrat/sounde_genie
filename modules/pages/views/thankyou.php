<?php $this->load->view("top_application"); ?><div class="container"><div class="inner-cont">	<?php frontend_breadcrumb('Thankyou')?>    	<div class="fs14 text-center mb20"> <img src="<?php echo theme_url()?>images/th.png" class="mt10 img-responsive" alt="">    	<p class="mt10 fs16"><?php echo error_message()?></p>    	<p class="mt15"><a href="<?php echo base_url()?>" class="btn btn-lg btn-default radius-3">Go Back</a></p>  	</div></div></div>
<?php $this->load->view("bottom_application"); 