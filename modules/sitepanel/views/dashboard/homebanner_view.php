
<?php $this->load->view('includes/header'); ?>  
 <div id="content">
  
  <div class="breadcrumb">
  
      <?php echo anchor('sitepanel/dashbord','Home'); ?>
 &raquo; <?php echo anchor('sitepanel/banners','Back To Listing'); ?> &raquo;  <?php echo $heading_title; ?> 
             
   </div>      
       
 <div class="box">
 
    <div class="heading">
    
      <h1><img src="<?php echo base_url(); ?>assets/sitepanel/image/category.png" alt="" /> <?php echo $heading_title; ?></h1>
      
      <div class="buttons">&nbsp;</div>
      
    </div>
   
<div class="content">       
<?php echo validation_message();?>
<?php echo error_message(); ?> 
<?php echo form_open_multipart(current_url_query_string());?>    
<table width="90%"  class="form"  cellpadding="3" cellspacing="3">
<tr>
	<th colspan="2" align="center" > </th>
</tr>

    <tr class="trOdd">
        <td width="28%" height="26" align="right"> Banner Url:</td>
        <td align="left"><input type="text" name="url" value="<?php echo set_value('url',$rwdata['web_url']);?>" size="40" /> ( ie.http://www.yahoo.com )</td>
    </tr>
<tr class="trOdd">
<td width="28%" height="26" align="right" > Banner Image:</td>
	<td align="left">
		<input type="file" name="image1" id="image1" />                 
		<?php
		 $j=1;
		 if($rwdata['web_img']!='' && file_exists(UPLOAD_DIR."/banner/".$rwdata['web_img']))
		{
		 $product_path = "banner/".$rwdata['web_img'];
		?>
         <a href="#"  onclick="$('#dialog_<?php echo $j;?>').dialog();">View</a>
         <div id="dialog_<?php echo $j;?>" title="Banner Image" style="display:none;">
         <img src="<?php echo base_url().'uploaded_files/'.$product_path;?>"  /> </div>
         <input type="hidden" name="st" value="Y">
         <input type="checkbox" name="delban" value="Y">
      <?php }else{ ?>
       <input type="hidden" name="st" value="N">
      <?php } ?>  
		
        <br />
	</td>
</tr>
<tr class="trOdd">
        <td width="28%" height="26" align="right"> </td>
        <td align="left"><strong>OR</strong></td>
    </tr>
    <tr class="trOdd">
        <td width="28%" height="26" align="right"> Paste Embaded Code:</td>
        <td align="left">
        <textarea name="youtube_code" rows="5" cols="70"><?php echo set_value('youtube_code',$rwdata['youtube_code']);?></textarea>
       </td>
    </tr>
    <tr class="trOdd">
        <td width="28%" height="26" align="right"> </td>
        <td align="left"><strong>OR</strong></td>
    </tr>
    <tr class="trOdd">
        <td width="28%" height="26" align="right"> Google Ads:</td>
        <td align="left">
        <textarea name="googel_code" rows="5" cols="70"><?php echo set_value('googel_code',$rwdata['googel_code']);?></textarea><br /><strong>Size : 381X186</strong>
       </td>
    </tr>
<tr class="trOdd">
	<td align="left">&nbsp;</td>
	<td align="left">
		<input type="submit" name="sub" value="Update" class="button2" />
		<input type="hidden" name="action" value="addbanner" />
	</td>
</tr>
</table>    
</div>
</div>
<?php $this->load->view('includes/footer'); ?>