<script type="text/javascript" src="<?php echo site_url();?>assets/developers/js/jscolor/jscolor.js"></script>
<div id="content">
  <div class="breadcrumb">
  
      <?php echo anchor('sitepanel/dashbord','Home'); ?>
 &raquo; <?php echo anchor('sitepanel/testimonial','Back To Listing'); ?> &raquo;  <?php echo $heading_title; ?> 
   </div>      
 <div class="box">
    <div class="heading">
      <h1><img src="<?php echo base_url(); ?>assets/sitepanel/image/category.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons"><?php echo anchor($cancel_url,'<span>Cancel</span>','class="button" ' );?></div>
    </div>
	<div class="content">
		<?php echo validation_message();
		echo error_message();
		echo form_open_multipart('sitepanel/testimonial/add/');
		?>  
		<div id="tab_pinfo">
			<table width="90%"  class="form"  cellpadding="3" cellspacing="3">
			<tr>
				<th colspan="2" align="center" > </th>
			</tr>
			
			<tr class="trOdd">
				<td width="28%" height="26" align="right"><span class="required">*</span> Name:</td>
				<td align="left"><input type="text" name="name" value="<?php echo set_value('name');?>" size="40" /> </td>
			</tr>
      
      
      
      	<tr class="trOdd">
				<td width="28%" height="26" align="right"><span class="required">*</span> Testimonial Description :</td>
				<td align="left"><textarea name="testimonail_desc" rows="4" cols="70"><?php echo set_value('testimonail_descs	');?></textarea> </td>
			</tr>
     
      
			<tr class="trOdd">
				<td align="left">&nbsp;</td>
				<td align="left">
					<input type="submit" name="sub" value="Add Testimonial" class="button2" />
					<input type="hidden" name="action" value="add" />
				</td>
			</tr>
			</table>
		</div>
		<?php echo form_close(); ?>
	</div>
</div>