<?php $this->load->view('includes/header'); 

$w=($this->admin_type==1)?'100':'100';

?>   

<div id="content">
	<?php  echo error_message(); ?>
    <div style="display: inline-block; width: 100%; margin-bottom: 15px; clear: both;">

     <div style="width: <?php echo $w;?>%;">

        <div style="background: #666464; color: #FFF; border-bottom: 1px solid #303030; padding: 5px; font-size: 14px; font-weight: bold;">Easy Navigation   </div>

        <div style="background:#f8f8f8; border: 1px solid #d9d9d9; padding: 8px; float:left">		 

	

         <?php $this->load->view('dashboard/admin_welcome_view'); ?>  

        </div>

      </div>

    </div>

    <div>

     

  </div>

</div>



<?php $this->load->view('includes/footer'); ?>