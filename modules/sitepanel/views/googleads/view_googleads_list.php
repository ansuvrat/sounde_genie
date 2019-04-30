<div id="content">
 <div class="breadcrumb"><?php echo anchor('sitepanel/dashbord','Home'); ?> &raquo; <?php echo $heading_title; ?> </a></div>
 <div class="box">
  <div class="heading">
   <h1><img src="<?php echo base_url(); ?>assets/sitepanel/image/category.png" alt="" /> <?php echo $heading_title; ?></h1>
   <div class="buttons">  <?php echo anchor("sitepanel/googleads/add/",'<span>Add Google Ad</span>','class="button" ' );?></div>
  </div>
  <div class="content">
   <?php echo validation_message();?>
   <?php echo error_message();

   if( is_array($res) && !empty($res) ){
	   echo form_open("sitepanel/googleads/",'id="data_form"');?>
	   <table class="list" width="100%" id="my_data">
	    <thead>
	     <tr>
	      <td width="21" style="text-align: center;"><input type="checkbox" onclick="$('input[name*=\'arr_ids\']').attr('checked', this.checked);" /></td>
	      <td width="405" class="left">Google Ad</td>
	      <td width="94" class="left">Display Order</td>
	      <td width="73" class="center">Status</td>
	      <td width="92" class="center">Action</td>
	     </tr>
	    </thead>
	    <tbody>
	     <?php
	     $j=1;
	     foreach($res as $catKey=>$pageVal){
		     $displayorder       = ($pageVal['sort_order']!='') ? $pageVal['sort_order']: "0";
		     ?>
		     <tr>
		      <td style="text-align: center;"><input type="checkbox" name="arr_ids[]" value="<?php echo $pageVal['gad_id'];?>" /></td>
		      <td class="left"><?php echo $pageVal['gad_content'];?></td>
		      <td><input type="text" name="ord[<?php echo $pageVal['gad_id'];?>]" value="<?php echo $displayorder;?>" size="5" /></td>
		      <td class="center"><?php echo ($pageVal['status']==1)?"Active":"In-active";?></td>
		      <td class="center"><?php echo anchor("sitepanel/googleads/edit/$pageVal[gad_id]/".query_string(),'Edit'); ?></td>
		     </tr>
		     <?php
		     $j++;
	     }?>
	     <tr><td colspan="6" align="right" height="30"><?php echo $page_links; ?></td></tr>
	    </tbody>
	    <tr>
	     <td align="left" colspan="6" style="padding:2px" height="35">
	      <input name="status_action" type="submit"  value="Activate" class="button2" id="Activate" onClick="return validcheckstatus('arr_ids[]','Activate','Record','u_status_arr[]');"/>
	      <input name="status_action" type="submit" class="button2" value="Deactivate" id="Deactivate"  onClick="return validcheckstatus('arr_ids[]','Deactivate','Record','u_status_arr[]');"/>
	      <input name="status_action" type="submit" class="button2" id="Delete" value="Delete"  onClick="return validcheckstatus('arr_ids[]','delete','Record');"/>
	      <input name="update_order" type="submit"  value="Update Order" class="button2" />
	     </td>
	    </tr>
	   </table>
	   <?php
	   echo form_close();
   }else{
	   echo "<br/><br/><center><strong> No record(s) found !</strong></center>" ;
   }?>
  </div>
 </div> 
</div>