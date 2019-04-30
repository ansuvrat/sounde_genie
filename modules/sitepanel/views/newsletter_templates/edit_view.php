<script type="text/javascript" src="<?php echo site_url();?>assets/developers/js/jscolor/jscolor.js"></script>
<div id="content">
  
  <div class="breadcrumb">
  
      <?php echo anchor('sitepanel/dashbord','Home'); ?>
 &raquo; <?php echo anchor('sitepanel/newsletter_templates','Back To Listing'); ?> &raquo;  <?php echo $heading_title; ?> 
             
   </div>      
       
 <div class="box">
 
    <div class="heading">
    
      <h1><img src="<?php echo base_url(); ?>assets/sitepanel/image/category.png" alt="" /> <?php echo $heading_title; ?></h1>
      
      <div class="buttons"><?php echo anchor($cancel_url,'<span>Cancel</span>','class="button" ' );?></div>
      
    </div>
   
    <div class="content">       
    <?php echo validation_message();
		echo error_message(); 
		echo form_open_multipart(current_url_query_string());?>  
      
    <table width="90%"  class="form"  cellpadding="3" cellspacing="3">
      <tr>
        <th colspan="2" align="center" > </th>
      </tr>

			<tr class="trOdd">
				<td width="28%" height="26" align="right"> Template title:</td>
				<td align="left"><input type="text" name="template_title" value="<?php echo set_value('template_title',$row->template_title);?>" size="40" /> </td>
			</tr>
      
      <tr class="trEven">
			<td width="187" height="26" align="right">Content : </td>
			<td width="648">
			<textarea name="template_text" rows="5" cols="50" id="page_desc" ><?php echo html_entity_decode($row->template_text);?></textarea>
			<?php
			echo display_ckeditor($ckeditor); 
			?>
			</td>
		</tr>
      
      <tr class="trOdd">
        <td align="left">&nbsp;</td>
        <td align="left">
          <input type="submit" name="sub" value="Update Template" class="button2" />
          <input type="hidden" name="action" value="edit" />
        </td>
      </tr>
      </table>    
</div>
</div>