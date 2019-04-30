<?php $this->load->view('includes/header');?>

<div id="content">
 <div class="breadcrumb"><?php echo anchor('sitepanel/dashbord','Home');?> &raquo; <?php echo $heading_title;?></a></div>
 <div class="box">
  <div class="heading">
   <h1><img src="<?php echo base_url(); ?>assets/sitepanel/image/category.png" alt="" /> <?php echo $heading_title;?></h1>
   <div class="buttons"> <?php echo anchor("sitepanel/instrument_type/add/",'<span>Add Instrument Type</span>','class="button"');?></div>
  </div>
  <div class="content">
   <?php echo validation_message();
   echo error_message();
   echo form_open("sitepanel/instrument_type/",'id="search_form" method="get"');?>
   <div align="right" class="breadcrumb"> Records Per Page : <?php echo display_record_per_page();?> </div>
   <table width="100%"  border="0" cellspacing="3" cellpadding="3">
    <tr>
      <td align="center" >Search [ Instrument ] 
        <input type="text" name="keyword" value="<?php echo $this->input->get_post('keyword');?>"  />&nbsp; 
        <select name="type">
          <option value="">Type</option>
          <option value="1" <?php if($this->input->get_post('type')==1){ echo "Selected";}?>>Live Instrument</option>
          <option value="2" <?php if($this->input->get_post('type')==2){ echo "Selected";}?>>Virtual Instrument</option>
        </select>
        <a  onclick="$('#search_form').submit();" class="button"><span> GO </span></a> <?php if($this->input->get_post('keyword')!='' || $this->input->get_post('type')!=''){ echo anchor("sitepanel/instrument_type/",'<span>Clear Search</span>'); }?></td></tr>
   </table>

   <?php echo form_close();
   if( is_array($res) && !empty($res)){
	   echo form_open("sitepanel/instrument_type/",'id="data_form"');?>
	   <table class="list" width="100%" id="my_data">
	    <thead>
	     <tr>
	      <td width="5%" style="text-align: center;"><input type="checkbox" onclick="$('input[name*=\'arr_ids\']').attr('checked', this.checked);" /></td>
          <td width="40%" class="left">Type</td>
	      <td width="40%" class="left">Instrument</td>
	      <td width="10%" class="center">Status</td>
	      <td width="10%" class="center">Action</td>
	     </tr>
	    </thead>
	    <tbody>
	     <?php
	     $j=1;
	     foreach($res as $catKey=>$pageVal){
		     ?>
		     <tr>
		      <td style="text-align: center;"><input type="checkbox" name="arr_ids[]" value="<?php echo $pageVal['id'];?>" /></td>
              <td class="left"><?php echo ($pageVal['ins_type']==1)?'Live Instrument':'Virtual Instrument';?></td>
		      <td class="left"><?php echo $pageVal['title'];?></td>
		      <td class="center"><?php echo ($pageVal['status']==1)?"Active":"In-active";?></td>
		      <td class="center"><?php echo anchor("sitepanel/instrument_type/edit/$pageVal[id]/".query_string(),'Edit'); ?></td>
		     </tr>
		     <?php
		     $j++;
	     }?>
	     <tr><td colspan="5" align="right" height="30"><?php echo $page_links;?></td></tr>
	    </tbody>
	    <tr>
	     <td align="left" colspan="5" style="padding:2px" height="35">
	      <input name="status_action" type="submit"  value="Activate" class="button2" id="Activate" onClick="return validcheckstatus('arr_ids[]','Activate','Record','u_status_arr[]');"/>
	      <input name="status_action" type="submit" class="button2" value="Deactivate" id="Deactivate"  onClick="return validcheckstatus('arr_ids[]','Deactivate','Record','u_status_arr[]');"/>
	      <input name="status_action" type="submit" class="button2" id="Delete" value="Delete"  onClick="return validcheckstatus('arr_ids[]','delete','Record');"/>
	     </td>
	    </tr>
	   </table>
	   <?php echo form_close();
   }else{
	   echo "<center><strong> No record(s) found !</strong></center>";
   }?>
  </div>
 </div>
</div>
<?php $this->load->view('includes/footer');?>