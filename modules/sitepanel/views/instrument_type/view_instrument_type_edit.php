<?php $this->load->view('includes/header');?>
<script language="javascript" src="<?php echo base_url();?>assets/sitepanel/jsinstrument_type/jsinstrument_type.js"></script>

<div id="content">
 <div class="breadcrumb"><?php echo anchor('sitepanel/dashbord','Home');?> &raquo; <?php echo anchor('sitepanel/instrument_type','Back To Listing'); ?> &raquo; <?php echo $heading_title;?></div>
 <div class="box">
  <div class="heading">
   <h1><img src="<?php echo base_url(); ?>assets/sitepanel/image/category.png" alt="" /> <?php echo $heading_title;?></h1>
   <div class="buttons">&nbsp;</div>
  </div>
  
  <div class="content">
   <?php echo validation_message();
   echo error_message();
   echo form_open_multipart(current_url_query_string());?>
   
   <table width="90%"  class="tableList" align="center">
    <tr><th colspan="2" align="center" > </th></tr>
 <?php
   $ins_type=($this->input->post('ins_type')!='')?$this->input->post('ins_type'):$res['ins_type'];
 ?>   
    <tr class="trOdd">
     <td width="253" height="26"> Instrument Type : <span class="required">*</span></td>
     <td width="597"><select name="ins_type">
       <option value="">Select Type</option>
       <option value="1" <?php if($ins_type==1){ echo "Selected";}?>>Live Instrument</option>
       <option value="2" <?php if($ins_type==2){ echo "Selected";}?>>Virtual Instrument</option>
     </select>
     </td>
    </tr>
    <tr class="trOdd">
     <td width="253" height="26"> Instrument Type Name : <span class="required">*</span></td>
     <td width="597"><input type="text" name="title" size="40" value="<?php echo set_value('title',$res['title']);?>"></td>
    </tr>
    
    <tr class="trOdd">
      <td align="left">&nbsp;</td>
      <td align="left">
        <input type="submit" name="sub" value="Update" class="button2" />
        <input type="hidden" name="id" value="<?php echo $res['id'];?>" />
        <input type="hidden" name="action" value="add" />
        </td>
    </tr>
   </table>
   <?php echo form_close();?>
  </div>
 </div>
</div> 
<?php $this->load->view('includes/footer');?>