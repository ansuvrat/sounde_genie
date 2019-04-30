<?php 
	$this->load->view('project_footer'); 

	if ($this->config->item('bottom.debug')){
		?>
	 	<p class="mt5 mb5" align="center"><?php $this->output->enable_profiler($this->config->item('bottom.debug')); ?><p>
		<?php
	 }
  ?>
  <script type="text/javascript">var Page='home';</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script type="text/javascript">var Page='home';</script> 
<script type="text/javascript" src="<?php echo resource_url(); ?>Scripts/script.int.dg.js"></script>
</body>
</html>