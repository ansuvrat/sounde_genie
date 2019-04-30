<div id="content">
	<div class="breadcrumb">
		<?php
		echo anchor('sitepanel/dashbord','Home');
		
		echo '<span class="pr2 fs14">»</span> '.$heading_title;
		
		?>
		
	</div>
	
	<div class="box">
		<div class="heading">
			<h1><img src="<?php echo base_url(); ?>assets/sitepanel/image/category.png" alt="" /> <?php echo $heading_title; ?></h1>
			<!--
			<div class="buttons"><?php echo anchor("sitepanel/".$this->current_controller."/add_edit","<span>Add Country</span>",'class="button" ' );?></div> -->
		</div>
		
		<div class="content">
			<?php  echo error_message(); ?>
			
			<?php echo form_open("sitepanel/".$this->current_controller."/",'id="search_form" method="get" '); ?>
			<div align="right" class="breadcrumb"> Records Per Page : <?php echo display_record_per_page();?> </div>
			
			<table width="100%"  border="0" cellspacing="3" cellpadding="3" >
				<tr>
					<td align="center" >
						Search [ Name ] <input type="text" name="keyword" value="<?php echo $this->input->get_post('keyword');?>"  />&nbsp;
						<select name="status">
							<option value="">Status</option>
							<option value="1" <?php echo $this->input->get_post('status')==='1' ? 'selected="selected"' : '';?>>Active</option>
							<option value="0" <?php echo $this->input->get_post('status')==='0' ? 'selected="selected"' : '';?>>In-active</option>
						</select>
						
						<a  onclick="$('#search_form').submit();" class="button"><span> GO </span></a>
						
						<?php
						if( $this->input->get_post('keyword')!='' || $this->input->get_post('status')!='' )
						{
							echo anchor("sitepanel/".$this->current_controller."/",'<span>Clear Search</span>');
						}
						?>
					</td>
				</tr>
			</table>
			<?php echo form_close();?>
			
			<?php
			if(is_array($res) && ! empty($res))
			{
				echo form_open("sitepanel/".$this->current_controller."/",'id="data_form"');?>
				
				<table class="list" width="100%" id="my_data">
					<thead>
						<tr>
							<td width="20" style="text-align: center;">
								<input type="checkbox" onclick="$('input[name*=\'arr_ids\']').attr('checked', this.checked);" />
							</td>
							<td width="239" class="left">Name </td>
							<?php /*?><td width="69" class="center">Flags </td>
                            <td width="69" class="center">Currency </td>	<?php */?>										
							<td width="100" align="left" >Status</td>
							<td width="131" align="center">Action</td>
						</tr>
					</thead>
					<tbody>
					<?php
					foreach($res as $catKey=>$pageVal)
					{
						$imgdisplay=FALSE;
						
						?>
						<tr>
							<td style="text-align: center;">
								<input type="checkbox" name="arr_ids[]" value="<?php echo  $pageVal['id'];?>" />
							</td>
							<td class="left">
								<?php echo $pageVal['country_name'];?>
								<?php
								/*if($pageVal['premimum_ads_avl']==1)
								{
									echo '<div class="required">Premimum Ads Available</div>';	
								}*/
								?>					
							</td>	
                            <?php /*?><td class="center">
								<img src="<?php echo theme_url();?>images/flags/<?php echo $pageVal['id']?>.gif" alt=""/>							
							</td>
                            <td class="left"><?php echo ($pageVal['cont_currency']!='')?'<strong>'.$pageVal['cont_currency'].'</strong>':'N/A';?></td><?php */?>
							<td align="left" ><?php echo ($pageVal['status']==1)? "Active":"In-active";?></td>
							<td align="center" >
								<?php echo anchor("sitepanel/".$this->current_controller."/add_edit/$pageVal[id]/".query_string(),'Edit'); ?>
							</td>
						</tr>
						<?php
					}
					?>
					<tr><td colspan="6" align="right" height="30"><?php echo $page_links; ?></td></tr>
				</tbody>
				<tr>
					<td align="left" colspan="6" style="padding:2px" height="35">
						<input name="status_action" type="submit"  value="Activate" class="button2" id="Activate" onClick="return validcheckstatus('arr_ids[]','Activate','Record','u_status_arr[]');"/>
						<input name="status_action" type="submit" class="button2" value="Deactivate" id="Deactivate"  onClick="return validcheckstatus('arr_ids[]','Deactivate','Record','u_status_arr[]');"/>
						
						<?php /*?><input name="status_action" type="submit"  value="Available Premimum Ads" class="button2" id="set" onClick="return validcheckstatus('arr_ids[]','Set Available Premimum Ads','Record','u_status_arr[]');"/>
						<input name="status_action" type="submit"  value="Not Available Premimum Ads" class="button2" id="unset" onClick="return validcheckstatus('arr_ids[]','Set Not Available Premimum Ads','Record','u_status_arr[]');"/><?php */?>
						
						<!--
						<input name="status_action" type="submit" class="button2" id="Delete" value="Delete"  onClick="return validcheckstatus('arr_ids[]','delete','Record');"/> -->
					</td>
				</tr>
			</table>
			<?php
			echo form_close();
		}
		else
		{
			echo "<center><strong> No record(s) found !</strong></center>" ;
		}
		?>
		</div>
	</div>
</div>	