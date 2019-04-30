<?php $this->load->view('includes/header');?>
<div id="content">

 <div class="breadcrumb"><?php echo anchor('sitepanel/dashbord','Home'); ?> &raquo; <?php echo anchor('sitepanel/banners','Back To Listing'); ?> &raquo;  <?php echo $heading_title; ?> </div>

 <div class="box">

  <div class="heading">

   <h1><img src="<?php echo base_url(); ?>assets/sitepanel/image/category.png" alt="" /> <?php echo $heading_title; ?></h1>

   <div class="buttons"><?php echo anchor('sitepanel/banners','<span>Cancel</span>','class="button" ' );?></div>

  </div>

  <div class="content">

   <?php echo validation_message();

   echo error_message();

   echo form_open_multipart(current_url_query_string());?>

   <table width="90%"  class="form"  cellpadding="3" cellspacing="3">

    <tr><th colspan="2" align="center" > </th></tr>

    <tr class="trEven">
     <td width="197" height="26"> <span class="left">Heading 1</span>:</td>
     <td width="667" style="f"><input type="text" name="heading1" value="<?php echo set_value('heading1',$pageresult->heading1);?>" size="80" />
     </td>
    </tr>
    <tr class="trEven">
     <td width="197" height="26"> <span class="left">Heading 2</span>:</td>
     <td width="667" style="f"><input type="text" name="heading2" value="<?php echo set_value('heading2',$pageresult->heading2);?>" size="80" />
     </td>
    </tr>
    
    <tr class="trOdd">
     <td width="28%" height="26" align="right" ><span class="required">*</span> Banner Image:</td>
     <td align="left">
      <input type="file" name="image1" id="image1" />
      <?php
      $j=1;
      $product_path = "upd_files/".$pageresult->image;
      ?>
      <a href="javascript:void(0);"  onclick="$('#dialog_<?php echo $j;?>').dialog({width:'auto'});">View</a>
      <div id="dialog_<?php echo $j;?>" title="Banner Image" style="display:none;"><img src="<?php echo base_url().'uploaded_files/'.$product_path;?>"  /> </div><br />
     </td>
    </tr>
    <tr class="trOdd">
     <td align="left">&nbsp;</td>
     <td align="left">
      <input type="submit" name="sub" value="Update Banner" class="button2" />
      <input type="hidden" name="action" value="addbanner" />
     </td>
    </tr>
   </table>
  </div>

 </div> 

</div>
<?php $this->load->view('includes/footer');?>