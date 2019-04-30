<div id="content">

  

  <div class="breadcrumb">

  

       <?php echo anchor('sitepanel/dashbord','Home'); ?> &raquo; <?php echo $heading_title; ?> </a>   

             

   </div>      

       

 <div class="box">

 

    <div class="heading">

    

      <h1><img src="<?php echo base_url(); ?>assets/sitepanel/image/category.png" alt="" /> <?php echo $heading_title; ?></h1>

      

      <div class="buttons"> <?php echo anchor("sitepanel/testimonial/add/",'<span>Add Testimonial</span>','class="button" ' );?> </div>

      

    </div>

		<div class="content">

		    <?php

				if(error_message() !='')

				{

					echo error_message();

				}

				echo form_open("sitepanel/testimonial/",'id="form" method="get" ');

				?>

        

         <div align="right" class="breadcrumb"> Records Per Page : <?php echo display_record_per_page();?> </div>

          

		<table width="100%"  border="0" cellspacing="3" cellpadding="3" >

		<tr>

			<td align="center" >Search [ Name ]

				<input type="text" name="keyword" value="<?php echo $this->input->get_post('keyword');?>"  />

        &nbsp;

       

				<a  onclick="$('#form').submit();" class="button"><span> GO </span></a>

			

				<?php 

				if($this->input->get_post('keyword')!='' || $this->input->get_post('section_type')!=''){ 

					echo anchor("sitepanel/testimonial/",'<span>Clear Search</span>');

				} 

				?>

			</td>

		</tr>

		</table>

		<?php

		echo form_close();

		$j=0;

		if( is_array($res) && !empty($res) )

		{

			echo form_open("sitepanel/testimonial/",'id="myform"');

			?>

			<table class="list" width="100%" id="my_data">

			<thead>

			<tr>

				<td width="20" style="text-align: center;"><input type="checkbox" onclick="$('input[name*=\'arr_ids\']').attr('checked', this.checked);" /></td>

				<td width="191" class="left">Name</td>

        <td width="300" class="left">Description</td>

				<td width="80" class="right">Status</td>

				<td width="57" class="center">Action</td>

			</tr>

			</thead>

			<tbody>

			<?php	

		foreach($res as $catKey=>$pageVal)

		{

			$operation_allowed=operation_allowed("tbl_testimonial",$pageVal['id']);  

		?> 

			<tr>

				<td style="text-align: center;">

        	<?php if($operation_allowed){ ?>

					<input type="checkbox" name="arr_ids[]" value="<?=$pageVal['id'];?>" />

          <?php } ?>

				</td>

				<td class="left"><?php echo $pageVal['name'];?><br />
                <?php echo $pageVal['email'];?>

        

        <div style="padding-top:5px; font-weight:bold;">

        	Added on : <?php echo getDateFormat($pageVal['created_at'],1);?>

        </div>

        </td>

        <td class="left"><?php echo $pageVal['testimonial_desc'];?></td>

     

        

				<td class="right"><?php echo ($pageVal['status']==1)? "Active":"In-active";?></td>

				<td align="center" ><?php

				if($operation_allowed){

					echo anchor("sitepanel/testimonial/edit/$pageVal[id]/".query_string(),'Edit');

				}

				else

				{

					echo '<span class="required">Operation not allowed</span>';

				}

				?></td>

			</tr>

		<?php

		$j++;

		}		   

		?> 

		<tr><td colspan="6" align="right" height="30"><?php echo $page_links; ?></td></tr>     

		</tbody>

		<tr>

			<td align="left" colspan="6" style="padding:2px" height="35">

				<input name="status_action" type="submit"  value="Activate" class="button2" id="Activate" onClick="return validcheckstatus('arr_ids[]','Activate','Record','u_status_arr[]');"/>

				<input name="status_action" type="submit" class="button2" value="Deactivate" id="Deactivate"  onClick="return validcheckstatus('arr_ids[]','Deactivate','Record','u_status_arr[]');"/>             

				<input name="status_action" type="submit" class="button2" id="Delete" value="Delete"  onClick="return validcheckstatus('arr_ids[]','delete','Record');"/>

			</td>

		</tr>

		</table>

		<?php

		echo form_close();

	}else

	{

		echo "<center><strong> No record(s) found !</strong></center>" ;

	}

	?> 

	</div>

</div>

