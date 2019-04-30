<div class="content">
	<div id="content">
		<div class="breadcrumb">
			<?php echo anchor('sitepanel/dashbord','Home'); ?> &raquo; <?php echo $heading_title; ?> </a>
		</div>
		
		<div class="box">
			<div class="heading">
				<h1><img src="<?php echo base_url(); ?>assets/sitepanel/image/category.png" alt="" /> <?php echo $heading_title; ?></h1>
				
				<div class="buttons">
					<a href="javascript:void(0);" onclick="history.back();" class="button">Cancel</a> 
				</div>
			</div>
			<div class="content">
				<?php echo validation_message();?>
				<?php echo error_message(); ?>
				<?php echo form_open_multipart("");?>
				<div id="tab_pinfo">
					<table width="90%"  class="form"  cellpadding="3" cellspacing="3">
						<tr>
							<th colspan="2" align="center" > </th>
						</tr>
						<tr class="trOdd">
							<td width="28%" height="26" align="right" ><span class="required">*</span> Country:</td>
							<td width="72%" align="left">
			<?php 
			    $country_id=(@$this->input->get_post('country_id')!='')?@$this->input->get_post('country_id'):@$row->country_id;
				              	
              	$arr=array("tbl_name"=>"tbl_country","select_fld"=>"id,country_name","where"=>"and status='1'");
              	echo common_dropdown('country_id',set_value('country_id',$country_id),$arr,'style="width:235px;" onchange="bind_data(this.value,\'sitepanel/location/bind_state\',\'state_list\',\'loader_state\',\'city_section\');"');
              	?>
							</td>
						</tr>
						<tr class="trOdd">
							<td width="28%" height="26" align="right" ><span class="required">*</span> State:</td>
							<td width="72%" align="left">
								<span id="loader_state"></span>
								<span id="state_list">
								<?php
						$state_id=(@$this->input->get_post('state_id')!='')?@$this->input->get_post('state_id'):@$row->state_id;
								if($country_id>0)
								{               	
	              	$arr=array("tbl_name"=>"tbl_states","select_fld"=>"id,title","where"=>"and status='1' and country_id ='".$country_id."'");
	              	echo common_dropdown('state_id',set_value('state_id',$state_id),$arr,'style="width:235px;"');
            		}
            		elseif($country_id>0)
            		{
	            		$arr=array("tbl_name"=>"tbl_states","select_fld"=>"id,title","where"=>"and status='1' and country_id ='".$country_id."'");
	              	echo common_dropdown('state_id',set_value('state_id',$state_id),$arr,'style="width:235px;"');
            		}
            		else
            		{
	            		$arr=array("tbl_name"=>"tbl_states","select_fld"=>"id,title","where"=>"and status='1' and country_id ='0'");
	              	echo common_dropdown('state_id',set_value('state_id',$state_id),$arr,'style="width:235px;"');
            		}
              	?>
              	</span>
							</td>
						</tr>
						<tr class="trOdd">
							<td width="28%" height="26" align="right" ><span class="required">*</span> City Name:</td>
							<td width="72%" align="left"><input type="text" name="title" size="40" value="<?php echo set_value('title',@$row->title);?>"></td>
						</tr>
						
						<tr class="trOdd">
							<td align="left">&nbsp;</td>
							<td align="left">
								
								<input type="hidden" name="action" value="addcategory" />
								<?php
								$id  =  (int) $this->uri->segment(4);
								if($id>0)
								{
									?>
									<input type="submit" name="sub" value="Update" class="button2" />
									<input type="hidden" name="id" value="<?php echo $id;?>" />
									<?php	
								}
								else
								{
									?>
									<input type="submit" name="sub" value="Add" class="button2" />
									<?php	
								}
								?>
							
							</td>
						</tr>
					</table>
				</div>
				<?php echo form_close(); ?>
			</div>
		</div>
		
	</div>
</div>	