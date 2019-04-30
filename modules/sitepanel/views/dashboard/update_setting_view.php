<div id="content">
	<div class="breadcrumb">
		<?php echo anchor('sitepanel/dashbord','Home'); ?> &raquo; <?php echo $heading_title; ?></div>
		
		<div class="box">
			<div class="heading">
				<h1><img src="<?php echo base_url(); ?>assets/sitepanel/image/category.png" alt="" /> <?php echo $heading_title; ?></h1>
				
				<div class="buttons">
					&nbsp;
				</div>
				
		</div>
			
		<div class="content">
			<?php echo validation_message('alert');?>
			<?php echo error_message(); ?>
			
			<?php echo form_open('sitepanel/setting/update_setting/');?>
			<table width="90%"  class="tableList" align="center">
				<tr>
					<th colspan="2" align="center" > </th>
				</tr>
				<?php
				if(is_array($res) && count($res) >0)
				{
					foreach($res as $key=>$val)
					{
						$settingval=$val['setting_value'];
						if(strstr($val['setting_title'],'Days'))
						{
							$settingval=(int) ($val['setting_value']/30);
						}
						
						
						
						?>
						<tr class="trOdd">
							<td width="217" height="26"> <?php echo str_replace('Days','Months',$val['setting_title'])?>:</td>
							<td width="633">
								<input type="text" name="post_data[<?php echo $val['id'];?>]" size="10" value="<?php echo $settingval?>">
							</td>
						</tr>
						<?php
					}
					?>
					<tr class="trOdd">
						<td height="26">&nbsp;&nbsp;</td>
						<td>
							<input type="submit" class="button2" value="Update"  />
						</td>
					</tr>
					<?php
				}
				?>
			</table>
			<?php echo form_close(); ?>
		</div>
	</div>