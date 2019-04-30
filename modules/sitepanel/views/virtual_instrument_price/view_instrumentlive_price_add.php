<?php $this->load->view('includes/header');?>
<script language="javascript" src="<?php echo base_url();?>assets/sitepanel/jsinstrument_type/jsinstrument_type.js"></script>
<div id="content">
 <div class="breadcrumb">
  <?php echo anchor('sitepanel/dashbord','Home');?> &raquo; <?php echo anchor('sitepanel/manage_prices/live_instrument_price','Back To Listing'); ?> &raquo; <?php echo $heading_title;?>
 </div>
 <div class="box">
  <div class="heading">
   <h1><img src="<?php echo base_url(); ?>assets/sitepanel/image/category.png" alt="" /> <?php echo $heading_title;?></h1>
   <div class="buttons">&nbsp;</div>
  </div>
  <div class="content">
   <?php echo validation_message();
   echo error_message();
   echo form_open_multipart('sitepanel/manage_prices/add_live_price');?>

   <table width="90%"  class="tableList" align="center">
    <tr><th colspan="2" align="center" > </th></tr>
    
    
    <tr class="trOdd">
     <td width="253" height="26" align="right"> Instrument Type : <span class="required">*</span></td>
     <td width="597">
     <?php
	 $tbl_arr = array('select_fld'=>'id,title','tbl_name'=>'tbl_instrument_type',"where"=>" AND status ='1' AND ins_type='1' ");
     echo common_dropdown("instrument_type", set_value('instrument_type'), $tbl_arr, " style='width:250px;' ", '', '')
	 ?>
     </td>
    </tr>
    
    
    <tr class="trOdd">
     <td width="253" height="26" align="right"> Duration : <span class="required">*</span></td>
     <td width="597">
     
      <?php
	 $tbl_arr = array('select_fld'=>'duration_id,duration','tbl_name'=>'tbl_duration',"where"=>" AND status ='1' ");
     echo common_dropdown("duration", set_value('duration'), $tbl_arr, " style='width:250px;' ", '', '')
	 ?>
      (In Minutes)
     
     </td>
    </tr>
    
    
    <tr class="trOdd">
     <td width="253" height="26" align="right"> Price : <span class="required">*</span></td>
     <td width="597"><input type="text" name="price" size="40" value="<?php echo set_value('price');?>"></td>
    </tr>
    
   
    <tr class="trOdd">
     <td align="left">&nbsp;</td>
     <td align="left">
      <input type="submit" name="sub" value="Add" class="button2" />
      <input type="hidden" name="action" value="add" />
     </td>
    </tr>
   </table>
   <?php echo form_close();?>
  </div>
 </div>
</div>
<?php $this->load->view('includes/footer');?>