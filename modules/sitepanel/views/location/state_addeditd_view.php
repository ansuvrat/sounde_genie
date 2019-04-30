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
							<td width="28%" height="26" align="right" ><span class="required">*</span> State Name:</td>
							<td width="72%" align="left"><input type="text" name="title" size="40" value="<?php echo set_value('title',@$row->title);?>"></td>
						</tr>
						
                        <tr class="trOdd">
                            <td align="left">&nbsp;</td>
                            <td align="left">
                                <input type="hidden" name="action" value="addcategory" />
                                <input type="submit" name="sub" value="Update" class="button2" />
                                <input type="hidden" name="id" value="<?php echo @$row->id;?>" />
                            </td>
                        </tr>
					</table>
				</div>
				<?php echo form_close(); ?>
			</div>
		</div>
		
	</div>
</div>	