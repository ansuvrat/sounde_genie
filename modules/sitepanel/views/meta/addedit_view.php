<div class="content">
	<div id="content">
		<div class="breadcrumb">
			<?php echo anchor('sitepanel/dashbord','Home'); ?> &raquo; <?php echo $heading_title; ?> </a>
		</div>
		
		<div class="box">
			<div class="heading">
				<h1><img src="<?php echo base_url(); ?>assets/sitepanel/image/category.png" alt="" /> <?php echo $heading_title; ?></h1>
				
				<div class="buttons">
					<a href="<?php echo site_url('sitepanel/meta')?>" onclick="" class="button">Cancel</a> 
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
							<td width="28%" height="26" align="right" ><span class="required">*</span> Page Url:</td>
							<td width="72%" align="left"><input type="text" readonly="readonly" name="page_url" size="40" value="<?php echo set_value('page_url',@$row->page_url);?>"> [Eg. about-us]</td>
						</tr>
						<tr class="trOdd">
							<td width="28%" height="26" align="right" ><span class="required">*</span> Meta Title:</td>
							<td width="72%" align="left"><input type="text" name="meta_title" size="40" value="<?php echo set_value('meta_title',@$row->meta_title);?>"></td>
						</tr>
						<tr class="trOdd">
							<td width="28%" height="26" align="right" ><span class="required">*</span> Meta Keyword:</td>
							<td width="72%" align="left"><input type="text" name="meta_keyword" size="40" value="<?php echo set_value('meta_keyword',@$row->meta_keyword);?>"></td>
						</tr>
						<tr class="trOdd">
							<td width="28%" height="26" align="right" ><span class="required">*</span> Meta Description:</td>
							<td width="72%" align="left"><textarea name="meta_description" rows="5" cols="80"><?php echo set_value('meta_description',@$row->meta_description);?></textarea></td>
						</tr>
						
						<tr class="trOdd">
							<td align="left">&nbsp;</td>
							<td align="left">
								
								<input type="hidden" name="action" value="addcategory" />
								<?php
								$id         			 =  (int) $this->uri->segment(4);
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