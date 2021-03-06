<?php $this->load->view('includes/header'); ?>
<div id="content">
 <div class="breadcrumb"><?php echo anchor('sitepanel/dashbord','Home'); ?> &raquo; <?php echo anchor('sitepanel/currency','Back To Listing'); ?> &raquo;  <?php echo $heading_title; ?></div>
 <div class="box">
  <div class="heading">
   <h1><img src="<?php echo base_url(); ?>assets/sitepanel/image/category.png" alt="" /> <?php echo $heading_title; ?></h1>
   <div class="buttons">&nbsp;</div>
  </div>
  <div class="content">
   <?php echo validation_message('');
   echo form_open_multipart('sitepanel/currency/add/');?>
   <div id="tab_pinfo">
    <table width="90%"  class="form"  cellpadding="3" cellspacing="3">
     <tr><th colspan="2" align="center" > </th></tr>
     <tr class="trOdd">
      <td width="28%" height="26" align="right" ><span class="required">*</span> Currency Title:</td>
      <td width="72%" align="left"><input type="text" name="title" size="40" maxlength="32" value="<?php echo set_value('title');?>"></td>
     </tr>
     <tr class="trOdd">
      <td width="28%" height="26" align="right" ><span class="required">*</span> Currency Code:</td>
      <td width="72%" align="left"><input type="text" name="code" size="40"  maxlength="3" value="<?php echo set_value('code');?>"></td>
     </tr>
     <tr class="trOdd">
      <td width="28%" height="26" align="right" ><span class="required">*</span> Currency Symbol:</td>
      <td width="72%" align="left"><input type="text" name="symbol" size="40" value="<?php echo set_value('symbol');?>"></td>
     </tr>
     <tr class="trOdd">
      <td width="28%" height="26" align="right" ><span class="required">*</span> Currency Value:</td>
      <td width="72%" align="left"><input type="text" name="value" size="40" value="<?php echo set_value('value');?>"> = 1 USD</td>
     </tr>
     <tr class="trOdd">
      <td align="left">&nbsp;</td>
      <td align="left">
       <input type="submit" name="sub" value="Add Currency" class="button2" />
       <input type="hidden" name="action" value="addcurrency" />
      </td>
     </tr>
    </table>
   </div>
   <?php echo form_close(); ?>
  </div>
 </div> 
</div>
<script type="text/javascript">
function change_ban_postions(){
	var section = $('[name="section"]').val();
	if(section != '' && section != 'undefined')
	{
		$.ajax({
				  type: "POST",
				  url: "<?php echo base_url();?>sitepanel/banners/ajx_ban_postions",
				  data: { banner_section : section }
				}).done(function( data ) {
				  $('#ban_postion').html(data);
				});
	}
	return false;
}
</script>
<?php $this->load->view('includes/footer'); ?>