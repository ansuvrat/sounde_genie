<?php $this->load->view('includes/header');?>
<div id="content">
 <div class="breadcrumb"><?php echo anchor('sitepanel/dashbord','Home');?> &raquo; <?php echo anchor('sitepanel/homepagebanner','Back To Listing');?> &raquo; <?php echo $heading_title;?></div>
 <div class="box">
  <div class="heading">
   <h1><img src="<?php echo base_url();?>assets/sitepanel/image/category.png" alt="" /> <?php echo $heading_title;?></h1>
   <div class="buttons">&nbsp;</div>
  </div>
  <div class="content">
   <?php echo validation_message();
   echo error_message();
   echo form_open_multipart('sitepanel/homepagebanner/add/');?>
   <table width="90%"  class="tableList" align="center">
    <tr><th colspan="2" align="center" > </th></tr>
    <tr class="trOdd">
   <tr class="trEven">
     <td width="197" height="26"> <span class="left">Heading 1</span>:</td>
     <td width="667" style="f"><input type="text" name="heading1" value="<?php echo set_value('heading1');?>" size="80" />
     </td>
    </tr>
    <tr class="trEven">
     <td width="197" height="26"> <span class="left">Heading 2</span>:</td>
     <td width="667" style="f"><input type="text" name="heading2" value="<?php echo set_value('heading2');?>" size="80" />
     </td>
    </tr>
    <tr class="trEven">
     <td width="197" height="26">* <span class="left">Image</span>:</td>
     <td width="667" style="f"><input type="file" name="image1">
     <br /><strong>(Best Size : 1600X585)</strong>
     </td>
    </tr>
    <tr class="trOdd">
     <td align="left">&nbsp;</td>
     <td align="left">
      <input type="submit" name="sub" value="Add" class="button2" />
      <input type="hidden" name="action" value="addnews" />
     </td>
    </tr>
   </table>
   <?php echo form_close();?>
  </div>
 </div>
</div> 
<?php $this->load->view('includes/footer');?>