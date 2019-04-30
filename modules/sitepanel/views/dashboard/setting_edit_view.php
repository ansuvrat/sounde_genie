<?php $this->load->view('includes/header'); ?>

<div id="content">

  

  <div class="breadcrumb">

    

  <?php echo anchor('sitepanel/dashbord','Home'); 
  ?>

 &raquo; <?php echo $heading_title; ?>

 

   </div>      

       

 <div class="box">

 

    <div class="heading">

    

      <h1><img src="<?php echo base_url(); ?>assets/sitepanel/image/category.png" alt="" /> <?php echo $heading_title; ?></h1>

      

      <div class="buttons">&nbsp;</div>

      

    </div>

       <div class="content">  

       

        <?php echo validation_message();?>

        

        

       

       <table width="90%" border="0" class="tableList" align="center">

		<tr>

			<th colspan="2" align="center" > <?php echo error_message(); ?></th>

		</tr>

    </table>

             



  <?php echo form_open('sitepanel/setting/');?>  

	<table width="90%" border="0" class="tableList" align="center">

		<tr>

			<th colspan="2" align="center" > </th>

		</tr>

		<tr class="trOdd">

			<td width="217" height="26"> Old Password:</td>

			<td width="633">

            <input type="password" name="old_pass" id="old_pass" size="40" value=''>

            </td>

		</tr>

		<tr class="trEven">

			<td height="26"> New Password:</td>

			<td>

            <input type="password" name="new_pass" size="40" value=''>

           

            </td>

		</tr>

		<tr class="trOdd">

			<td height="26"> Confirm Password:</td>

			<td><input type="password" name="confirm_password" size="40" value="" />  

            </td>

		</tr>

    <tr class="trOdd">

			<td height="26">&nbsp;&nbsp;</td>

			<td>
            <input type="submit" name="action" class="button2" value="Update Password"  />  

            </td>

		</tr>

    </table>

    <?php echo form_close(); ?>

    

    <?php echo form_open_multipart('sitepanel/setting/');?>

    <table width="90%" border="0" class="tableList" align="center">

		<tr>

			<th colspan="2" align="center" > </th>

		</tr>
		
         <tr class="trOdd">
		  <td width="282" height="26" align="left">Header Logo : </td>
		  <td width="818"  align="left">
         <input type="file" name="header_logo" /><?php if($site_info['header_logo']!='' && file_exists(UPLOAD_DIR."/logo/".$site_info['header_logo'])){?><a href="javascript:void(0);"  onclick="$('#dialog').dialog({width:'auto'});">View</a>   <?php }?><br />[ <?php echo $this->config->item('header_logo.best.image.view');?> ] <div id="dialog" title="Header Logo" style="display:none;"> <img src="<?php echo base_url().'uploaded_files/logo/'.$site_info['header_logo'];?>"  /> </div>
        </td>
	    </tr>
      <tr class="trOdd">
		  <td width="282" height="26" align="left">Footer Logo : </td>
		  <td width="818"  align="left">
          <input type="file" name="footer_logo" /><?php if($site_info['footer_logo']!='' && file_exists(UPLOAD_DIR."/logo/".$site_info['footer_logo'])){?><a href="javascript:void(0);"  onclick="$('#dialog1').dialog({width:'auto'});">View</a>   <?php }?><br />[ <?php echo $this->config->item('footer_logo.best.image.view');?> ] <div id="dialog1" title="Footer Logo" style="display:none;"> <img src="<?php echo base_url().'uploaded_files/logo/'.$site_info['footer_logo'];?>"  /> </div>
        </td>
	    </tr>
		
         <tr class="trOdd">
		  <td width="282" height="26" align="left">Invoice Logo : </td>
		  <td width="818"  align="left">
          <input type="file" name="invoice_logo" /><?php if($site_info['invoice_logo']!='' && file_exists(UPLOAD_DIR."/logo/".$site_info['invoice_logo'])){?><a href="javascript:void(0);"  onclick="$('#dialog2').dialog({width:'auto'});">View</a>   <?php }?><br />[ <?php echo $this->config->item('invoice_logo.best.image.view');?> ] <div id="dialog2" title="Invoice Logo" style="display:none;"> <img src="<?php echo base_url().'uploaded_files/logo/'.$site_info['invoice_logo'];?>"  /> </div>
        </td>
	    </tr>
        
        <tr class="trOdd">
		  <td width="282" height="26" align="left">Copy Right @ = : </td>
		  <td width="818"  align="left">
         <input type="text" name="copy_right" style="width:325px;" value="<?php echo set_value('copy_right',$site_info['copy_right']);?>" /></td>
	    </tr>  
        
        <tr class="trOdd">
		  <td width="282" height="26" align="left">Company Name : </td>
		  <td width="818"  align="left">
         <input type="text" name="company_name" style="width:325px;" value="<?php echo set_value('company_name',$site_info['company_name']);?>" /></td>
	    </tr>  
        
		<tr class="trOdd">
		  <td width="282" height="26" align="left">Email : </td>
		  <td width="818"  align="left">
         <input type="text" name="admin_email" size="40" value="<?php echo set_value('admin_email',$admin_info->email);?>" /></td>
	    </tr>        

        <tr class="trOdd">
		  <td align="left"> Address :</td>
		  <td align="left">
          <textarea name="address" cols="55" rows="6"><?php echo set_value('address',$admin_info->address);?></textarea></td>

	  </tr>		

        
        <tr class="trOdd">

		  <td width="282" height="26" align="left">Contact no. : </td>

		  <td width="818"  align="left">

         <input type="text" name="phone" size="40" value="<?php echo set_value('toll_free_no',$this->site_setting['toll_free_no']);?>" /></td>

	    </tr>
	     
		 
	    
	    
	    
	     <tr class="trOdd">

		  <td width="282" height="26" align="left">Vat(%) : </td>

		  <td width="818"  align="left">

         <input type="text" name="vat_percent" size="40" value="<?php echo set_value('vat_percent',$site_info['tax']);?>" /></td>

	    </tr>

		 
	    
	    <tr class="trOdd">

		  <td width="282" height="26" align="left">Facebook : </td>

		  <td width="818"  align="left">

         <input type="text" name="facebook" size="40" value="<?php echo set_value('facebook',$site_info['facebook']);?>" /></td>

	    </tr>
	    <tr class="trOdd">

		  <td width="282" height="26" align="left">Twitter : </td>

		  <td width="818"  align="left">

         <input type="text" name="twitter" size="40" value="<?php echo set_value('twitter',$site_info['twitter']);?>" /></td>

	    </tr>
	   <!-- <tr class="trOdd">

		  <td width="282" height="26" align="left">Linkdin : </td>

		  <td width="818"  align="left">

         <input type="text" name="linkdin" size="40" value="<?php echo set_value('linkdin',$site_info['linkdin']);?>" /></td>

	    </tr>-->
	    <tr class="trOdd">

		  <td width="282" height="26" align="left">Google Plus : </td>

		  <td width="818"  align="left">

         <input type="text" name="gplus" size="40" value="<?php echo set_value('gplus',$site_info['gplus']);?>" /></td>

	    </tr>
	    <tr class="trOdd">

		  <td width="282" height="26" align="left">Youtube : </td>

		  <td width="818"  align="left">

         <input type="text" name="youtube" size="40" value="<?php echo set_value('youtube',$site_info['youtube']);?>" /></td>

	    </tr>
        <tr class="trOdd">

		  <td width="282" height="26" align="left">Linkdin : </td>

		  <td width="818"  align="left">

         <input type="text" name="linkdin" size="40" value="<?php echo set_value('linkdin',$site_info['linkdin']);?>" /></td>

	    </tr>
        
	    <tr class="trOdd">

		  <td width="282" height="26" align="left">Google Analiytical Code : </td>

		  <td width="818"  align="left">

         <textarea  name="google_anylitical_code" cols='60' ><?php echo set_value('google_anylitical_code',$site_info['google_anylitical_code']);?></textarea></td>

	    </tr>
	    
		
		<tr class="trOdd">

			<td height="26">&nbsp;&nbsp;</td>

			<td>
            <input type="submit" name="action" class="button2" value="Update Info"  />  

            </td>

		</tr>

	</table>

<?php echo form_close(); ?>

  </div>

</div>

<?php $this->load->view('includes/footer'); ?>