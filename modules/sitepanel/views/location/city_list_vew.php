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
			
			<div class="buttons"><?php echo anchor("sitepanel/".$this->current_controller."/city_add_edit","<span>Add City</span>",'class="button" ' );?></div>
		</div>
		
		<div class="content">
			<?php  echo error_message(); ?>
			
			<?php echo form_open("sitepanel/".$this->current_controller."/city",'id="search_form" method="get" '); ?>
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
						&nbsp;
					<?php               	
                    $arr=array("tbl_name"=>"tbl_country","select_fld"=>"id,country_name","where"=>"and status='1'");
                    echo common_dropdown('country_id',$this->input->get_post('country_id'),$arr,'style="width:135px;" onchange="bind_data(this.value,\'sitepanel/location/bind_state\',\'state_list\',\'loader_state\',\'neighborhood_country\');"');
                    ?>
          	&nbsp;
						<span id="loader_state"></span>
								<span id="state_list">
							<?php
                            if($this->input->get_post('country_id')>0)
                            {               	
                            $arr=array("tbl_name"=>"tbl_states","select_fld"=>"id,title","where"=>"and status='1' and country_id ='".$this->input->get_post('country_id')."'");
                            echo common_dropdown('state_id',$this->input->get_post('state_id'),$arr,'style="width:135px;" onchange="bind_data(this.value,\'sitepanel/location/bind_city\',\'city_list\',\'loader_city\',\'city_section\');"');
                            }
                            else
                            {
                            $arr=array("tbl_name"=>"tbl_states","select_fld"=>"id,title","where"=>"and status='1' and country_id ='0'");
                            echo common_dropdown('state_id',$this->input->get_post('state_id'),$arr,'style="width:135px;"');
                            }
                            ?>
                         	</span>
					
					</td>
				</tr>
                <tr>
                	<td align="center">
                    <input type="checkbox" name="is_city_popular" value="1" <?php echo ($this->input->get_post('is_city_popular')==1)?'checked':'';?> /> Select City Popular&nbsp;<input type="checkbox" name="is_othercity_popular" value="1" <?php echo ($this->input->get_post('is_othercity_popular')==1)?'checked':'';?> /> Other City Popular&nbsp;
                    
                    <a  onclick="$('#search_form').submit();" class="button"><span> GO </span></a>
						<?php
						if( $this->input->get_post('keyword')!='' || $this->input->get_post('status')!='' || $this->input->get_post('country_id')!='' || $this->input->get_post('state_id')!='' || $this->input->get_post('is_city_popular')!='' || $this->input->get_post('is_othercity_popular')!='' )
						{
							echo anchor("sitepanel/".$this->current_controller."/city",'<span>Clear Search</span>');
						}
						?>
                    </td>
                </tr>
			</table>
			<?php echo form_close();?>
			
			<?php
			if(is_array($res) && ! empty($res))
			{
				echo form_open("sitepanel/".$this->current_controller."/city",'id="data_form"');?>
				
				<table class="list" width="100%" id="my_data">
					<thead>
						<tr>
							<td width="20" style="text-align: center;">
								<input type="checkbox" onclick="$('input[name*=\'arr_ids\']').attr('checked', this.checked);" />
							</td>
							<td width="239" class="left">City Name </td>
							<td width="69" class="left">State </td>	
							<td width="69" class="left">Country </td>
							<td width="100" align="left" >Status</td>
							<td width="131" align="center">Action</td>
						</tr>
					</thead>
					<tbody>
					<?php
					
					$atts = array(
					'width'      => '650',
					'height'     => '600',
					'scrollbars' => 'yes',
					'status'     => 'yes',
					'resizable'  => 'yes',
					'screenx'    => '0',
					'screeny'    => '0'
					);
					
					foreach($res as $catKey=>$pageVal)
					{
						$imgdisplay=FALSE;
						
						?>
						<tr>
							<td style="text-align: center;">
								<input type="checkbox" name="arr_ids[]" value="<?php echo  $pageVal['id'];?>" />
							</td>
							<td class="left">
								<?php echo $pageVal['title'];
								
								if($pageVal['is_city_popular']=="1")
								{
									echo '<div class="required">Select City Popular</div>';	
								}
								if($pageVal['is_othercity_popular']=="1")
								{
									echo '<div class="required">Other City Popular</div>';	
								}
								?>
								<?php
								if($pageVal['premimum_ads_avl']==1)
								{
									//echo '<div class="required">Premimum Ads Available</div>';	
								}
								?>	
								
								<div class="mt5">
									<?php echo anchor_popup('sitepanel/'.$this->current_controller.'/set_city_group/'.$pageVal['id'].'/'.$pageVal['state_id'], 'Set/View City Group', $atts);?>
								</div>					
							</td>
							<td class="left">
								<?php echo get_db_field_value("tbl_states","title",array("id"=>$pageVal['state_id']));?>								
							</td>	
							<td class="left">
								<?php echo get_db_field_value("tbl_country","country_name",array("id"=>$pageVal['country_id']));?>								
							</td>
														
							<td align="left" ><?php echo ($pageVal['status']==1)? "Active":"In-active";?></td>
							<td align="center" >
								<?php echo anchor("sitepanel/".$this->current_controller."/city_add_edit/$pageVal[id]/".query_string(),'Edit'); ?>
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
						
						<input name="status_action" type="submit"  value="Set Popular" class="button2" id="setpopular" onClick="return validcheckstatus('arr_ids[]','Set Popular','Record','u_status_arr[]');"/>
						<input name="status_action" type="submit"  value="Unset Popular" class="button2" id="unsetpopular" onClick="return validcheckstatus('arr_ids[]','Unset Popular','Record','u_status_arr[]');"/>
                        
                        <input name="status_action" type="submit"  value="Set Othercity Popular" class="button2" id="setothercitypopular" onClick="return validcheckstatus('arr_ids[]','Set Othercity Popular','Record','u_status_arr[]');"/>
						<input name="status_action" type="submit"  value="Unset Othercity Popular" class="button2" id="unsetothercitypopular" onClick="return validcheckstatus('arr_ids[]','Unset Othercity Popular','Record','u_status_arr[]');"/>
						
						<input name="status_action" type="submit" class="button2" id="Delete" value="Delete"  onClick="return validcheckstatus('arr_ids[]','delete','Record');"/> 
                        
                        <!--<input name="status_action" type="submit"  value="Available Premimum Ads" class="button2" id="set" onClick="return validcheckstatus('arr_ids[]','Set Available Premimum Ads','Record','u_status_arr[]');"/>
						<input name="status_action" type="submit"  value="Not Available Premimum Ads" class="button2" id="unset" onClick="return validcheckstatus('arr_ids[]','Set Not Available Premimum Ads','Record','u_status_arr[]');"/>-->
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