<?php $this->load->view('includes/face_header'); ?>
<table width="100%" border="0" cellspacing="4" cellpadding="0" class="grey">
	<tr valign="top" >
		<td colspan="4" align="right" >
			<table width="100%"  border="0" cellspacing="2" cellpadding="2">
				<tr align="left" bgcolor="#1588BB" class="white">
					<td height="20" bgcolor="#CCCCCC" ><strong> City Group Details : </strong></td>
				</tr>
				</table>
				
					<?php  echo error_message(); ?>
				
				<?php echo form_open("sitepanel/".$this->current_controller."/set_city_group/$city_id/$state_id");?>
				
				<table width="100%" class="list"  border="0" cellspacing="2" cellpadding="2">
				<?php
				if(is_array($res) && count($res) > 0)
				{
					$prev_group_arr=array();
					$prev_group=get_db_field_value("tbl_city","city_group_id",array("id"=>$city_id));
					if($prev_group!='')
					{
						$prev_group_arr=explode(",",$prev_group);	
					}
					
					foreach($res as $value)
					{
						?>
						<tr valign="top" >
							<td width="19%" align="left"><input type="checkbox" name="arr_ids[]" value="<?php echo $value['id'];?>" <?php echo (@in_array($value['id'],$prev_group_arr))?"checked":"";?>></td>
							<td width="25%" align="left"><?php echo $value['title'];?></td>
						</tr>
						<?php
					}
					?>
				<tr>
					<td colspan="2">&nbsp;</td>
				</tr>	
				<tr>
					<td colspan="2">
						<input type="submit" name="action" id="action" value="Add in Group" >
						</td>
						<!-- onClick="return validcheckstatus('arr_ids[]','Set Group','Record','u_status_arr[]');" -->
				</tr>
				<?php
				}
				?>
				<tr>
					<td colspan="2">&nbsp;</td>
				</tr>
			</table>
			<?php echo form_close();?>
			
		</td>
	</tr>
	
  <tr align="left" valign="top" >
    <td colspan="4" align="left">&nbsp;</td>
  </tr>
  <tr align="left" valign="top" bgcolor="#FFFFFF" >
  	<td colspan="4" ><span class="b white"><strong></strong></span></td>
  </tr>
 </table>
</body>
</html>