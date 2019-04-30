<?php

function validation_message($style="")// by default On Page - set 'alert' for pop-up

{	

  

	$processing_result=validation_errors();

	

	if($processing_result!='')

	{	

	

	   if($style=="alert")

	   {	   

		  ?>



<div id="alert_box">

  <div class="alert_area">

    <div class="close"> <span onclick="$('#alert_box').remove();" class="txt">Close [x]</span> </div>

    <div style=" width:100%; text-align:left;">

      <?php

	      }

         ?>

      <div class="validation" >

        <div style="margin-bottom:6px;"> <strong><span class="red"> <?php echo lang('ERROR'); ?>!</span> <br />

          <?php echo lang('INVALID_ENTRIES'); ?></strong> </div>

        <div class="validation_msg" ><?php echo $processing_result; ?></div>

      </div>

      <?php 

		

		if($style=="alert")

		{

		  ?>

    </div>

  </div>

</div>

<?php

		}

		

     } 

	 

 }

 

 function error_message($style="")// by default On Page - set 'alert' for pop-up

 {  

 

	  $ci = &get_instance();

	  $msgtypes=array('success','warning','error');

	  $msgtype='';

	  $msg='';

	  

	  foreach($msgtypes as $msgt)

	  {

		  $msg=$ci->session->flashdata($msgt);

		  

		  if($msg!='')

		  {

			  $msgtype=$msgt;

			  break;

		  }

	  }

  

  

   if( $msgtype!='' && $msg!='' )

   {	 

   

	 if($style=="alert")

	  {

		 

		  ?>

<div id="alert_box">

  <div class="alert_area">

    <div class="close"> <span onclick="$('#alert_box').remove();" class="txt">Close [x]</span> </div>

    <div style=" width:100%; text-align:left;">

      <?php

	  }

 ?>

      <div class="<?php echo $msgtype;?>" >

        <?php echo $msg;?>

        </div>

      <?php if($style=="alert")

		{

			

		  ?>

    </div>

  </div>

</div>

<?php

		}

  

    }   

  } 

  

function frontend_breadcrumb($title="",$crumbs=""){
	  $ci = CI();
	$title=@ucfirst($title);
	?>	
    <p class="bb"></p>
    <ul class="breadcrumb">
  	<li><a href="<?php echo base_url();?>">Home</a></li>
		<?php
		
			if(@is_array($crumbs)){
				
				foreach($crumbs as $key=>$val){ 
					?>
					<li><a href="<?php echo site_url($val)?>" title="<?php echo $key?>"><?php echo $key?></a></li>
					<?php
				}
			}else if($crumbs!=""){
				echo $crumbs;
			}
		?>		
		<li class="active"><?php echo $title?></li>
	</ul>
	<?php 
}

function print_no_record($len=0,$mess=""){			

	if($len==0){

		echo '<div class=" b pt5 red" style=\'text-align:center\'>';

		echo ($mess=="")?"No record found.":$mess;

		echo "</div>";

	}

}

