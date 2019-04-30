<?php
	$this->load->model('member/member_model');
	$this->load->view('includes/face_header');
?>
<table width="100%"  border="0" cellspacing="5" cellpadding="5" class="form">
 <tr align="left" bgcolor="#1588BB" class="white"><td colspan="7" bgcolor="#CCCCCC" ><strong> Personal Details : </strong></td></tr>
 <tr valign="top"  >
  <td width="18%" align="left" ><strong>User Id : </strong></td>
  <td width="27%" align="left" ><?php echo $mres['username'];?></td>
  <td width="25%" align="left" ><strong>Password :</strong></td>
  <td width="30%" align="left" ><?php echo $this->safe_encrypt->decode($mres['password']);?></td>
 </tr>
 <tr valign="top"  >
	<td align="left" ><strong> Name :</strong></td>
	<td align="left" ><?php echo ucwords($mres['name']);?></td>
	<td align="left" ><strong>Mobile :</strong></td>
	<td align="left" ><?php echo $mres['mobile'];?></td>
 </tr>
 <tr valign="top"  >
	<td align="left" ><strong>Register Date : </strong></td>
	<td align="left" ><?php echo $mres['created_at'];?></td>
	<td align="left" >&nbsp;</td>
	<td align="left" >&nbsp;</td>
 </tr> 
 <tr>
	<td align="left" >&nbsp;</td>
	<td align="left" >&nbsp;</td>
	<td align="left" ><strong></strong></td>
	<td align="left" ></td>
</tr>

</table>
</body>
</html>