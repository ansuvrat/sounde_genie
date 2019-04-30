<?php $this->load->view('includes/header');?>
<script language="javascript" src="<?php echo base_url();?>assets/sitepanel/jsinstrument_type/jsinstrument_type.js"></script>

<div id="content">
 <div class="breadcrumb"><?php echo anchor('sitepanel/dashbord','Home');?> &raquo; <?php echo anchor('sitepanel/manage_prices/sound_recording_price','Back To Listing'); ?> &raquo; <?php echo $heading_title;?></div>
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
   <tr class="trOdd">
     <td width="253" height="26" align="right"> Sound Recording Category : <span class="required">*</span></td>
     <td width="597">
     <?php
	 $tbl_arr = array('select_fld'=>'id,cat_name','tbl_name'=>'tbl_sound_category',"where"=>" AND status ='1' ");
     echo common_dropdown("sound_recording_category", set_value('sound_recording_category',$res['sound_recording_category']), $tbl_arr, " style='width:250px;' ", '', '')
	 ?>
     </td>
    </tr>
    
    
    <tr class="trOdd">
     <td width="253" height="26" align="right"> Price : <span class="required">*</span></td>
     <td width="597"><input type="text" name="price" size="40" value="<?php echo set_value('price',$res['price']);?>"></td>
    </tr>
    
    <tr class="trOdd">
      <td align="left">&nbsp;</td>
      <td align="left">
        <input type="submit" name="sub" value="Update" class="button2" />
        <input type="hidden" name="id" value="<?php echo $res['price_id'];?>" />
        <input type="hidden" name="action" value="add" />
        </td>
    </tr>
   </table>
   <?php echo form_close();?>
  </div>
 </div>
</div> 
<?php $this->load->view('includes/footer');?>