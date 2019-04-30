<?php $this->load->view('includes/header'); ?>
<div class="content">
 <div id="content">
  <div class="breadcrumb"><?php echo anchor('sitepanel/dashbord','Home'); ?>&raquo;&raquo; <?php echo anchor('sitepanel/products/','Product'); ?> &raquo;  <?php echo anchor('sitepanel/products/colorimg/'.$this->uri->segment(4).'/'.$this->uri->segment(5),'Back to Listing'); ?> &raquo;<?php echo $heading_title; ?></div>
  <div class="box">
   <div class="heading">
    <h1><img src="<?php echo base_url(); ?>assets/sitepanel/image/category.png" alt="" /> <?php echo $heading_title; ?></h1>
    <div class="buttons"><?php echo anchor("sitepanel/products/add_color_img/".$this->uri->segment(4).'/'.$this->uri->segment(5),'<span>Add Color Image</span>','class="button" ' );?></div>
   </div>
   <div class="content">
    <span class="required"><?php echo validation_errors();?></span>
    <?php echo form_open_multipart('sitepanel/products/add_color_img/'.$this->uri->segment(4).'/'.$this->uri->segment(5));?>
    <table width="90%"   cellpadding="3" cellspacing="3">
     <tr><th colspan="2" align="center" > </th></tr>
     <?php $color_list=$rowdata; ?>
     <tr >
      <td height="26" align="right" ><span class="required">*</span> Select Color:</td>
      <td align="left">
       <select name="color_id" style="width:150px;">
        <option value="">Select Color</option>
        <?php
		if(is_array($color_list) && count($color_list) > 0 ){
           foreach($color_list as $key=>$val){
	        ?>
	        <option value="<?php echo $val['color_id']?>"><?php echo get_db_field_value('tbl_colors','color_name',"WHERE id ='".$val['color_id']."'");?></option>
	        <?php
           }
		}
		?>
       </select>
      </td>
     </tr>
     <tr >
      <td width="28%" height="26" align="right" ><span class="required">*</span> Color Image :</td>
      <td align="left"><input type="file" name="media" id="image" /><br />[ <?php echo $this->config->item('product.best.image.view');?> ] </td>
     </tr>
     <tr >
      <td align="left">&nbsp;</td>
      <td align="left">
       <input type="submit" name="sub" value="Add" class="button2" />
       <input type="hidden" name="action" value="addimage" />
       <input type="hidden" name="product_id" value="<?php echo $this->uri->segment(4);?>" />
      </td>
     </tr>
    </table>
    <?php echo form_close(); ?>
   </div>
  </div>
 </div>  
</div>
<?php $this->load->view('includes/footer');?>