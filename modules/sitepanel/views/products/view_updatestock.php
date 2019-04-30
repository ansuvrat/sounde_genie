<?php
	$this->load->view('includes/face_header');
	echo form_open("sitepanel/products/updatestock/".$pid);
?>

<table width="100%"  border="0" cellspacing="5" cellpadding="5" class="form">
 <tr align="left" bgcolor="#1588BB" class="white"><td colspan="2" bgcolor="#CCCCCC" ><strong> Update stock : </strong></td></tr>
 <tr><td colspan="2">
 <?php validation_message();?>
 </td></tr>
 <tr valign="top"  >
  <td>Quantity :</td><td> <input type="text" name="stock_value" value="<?php echo $this->input->post('stock_value');?>"></td>
  </tr>
  <tr valign="top"  >
  <td></td><td> <input type="submit" name="submit1" value="Update">
  <input type="hidden" name="action" value="Add">
  </td>
  </tr>
  </table>
<?php echo form_close();?>  