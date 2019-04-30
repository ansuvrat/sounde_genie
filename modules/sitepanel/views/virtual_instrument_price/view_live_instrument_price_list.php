<?php $this->load->view('includes/header');?>

<div id="content">
 <div class="breadcrumb"><?php echo anchor('sitepanel/dashbord','Home');?> &raquo; <?php echo $heading_title;?></a></div>
 <div class="box">
  <div class="heading">
   <h1><img src="<?php echo base_url(); ?>assets/sitepanel/image/category.png" alt="" /> <?php echo $heading_title;?></h1>
   <div class="buttons"> <?php echo anchor("sitepanel/manage_prices/add_live_price",'<span>Add Price</span>','class="button"');?></div>
  </div>
  <div class="content">
   <?php echo validation_message();
   echo error_message();
   echo form_open("sitepanel/manage_prices/live_instrument_price",'id="search_form" method="get"');?>
   <div align="right" class="breadcrumb"> Records Per Page : <?php echo display_record_per_page();?> </div>
   <table width="100%"  border="0" cellspacing="3" cellpadding="3">
    <tr>
      <td align="center" >Search 
        <?php
	 $tbl_arr = array('select_fld'=>'id,title','tbl_name'=>'tbl_instrument_type',"where"=>" AND status ='1' AND ins_type='1' ");
     echo common_dropdown("instrument_type",$this->input->get('instrument_type'), $tbl_arr, " style='width:200px;' ", '', '')
	 ?>&nbsp;
     
     
      <?php
	 $tbl_arr = array('select_fld'=>'duration_id,duration','tbl_name'=>'tbl_duration',"where"=>" AND status ='1' ");
     echo common_dropdown("duration", $this->input->get('duration'), $tbl_arr, " style='width:200px;' ", '', '')
	 ?>
      (In Minutes)
     
     
      <a  onclick="$('#search_form').submit();" class="button"><span> GO </span></a> <?php if($this->input->get_post('search')!=''){ echo anchor("sitepanel/manage_prices/live_instrument_price/",'<span>Clear Search</span>'); }?>
      
      <input type="hidden" name="search" value="1" />
      
      
      </td></tr>
   </table>

   <?php echo form_close();
   if( is_array($res) && !empty($res)){
	   echo form_open("sitepanel/manage_prices/live_instrument_price",'id="data_form"');?>
	   <table class="list" width="100%" id="my_data">
	    <thead>
	     <tr>
	      <td width="10%" style="text-align: center;"><input type="checkbox" onclick="$('input[name*=\'arr_ids\']').attr('checked', this.checked);" /></td>
	      <td width="24%" class="left">Price</td>
	      <td width="24%" class="left">Instrument Type</td>
	      <td width="23%" class="left">Duration</td>
	      <td width="8%" class="center">Status</td>
	      <td width="11%" class="center">Action</td>
	     </tr>
	    </thead>
	    <tbody>
	     <?php
	     $j=1;
	     foreach($res as $catKey=>$pageVal){
			 
			 $instrument_type = get_title_by_id("tbl_instrument_type", "title", array('id'=>$pageVal['instrument_type']));
			 
			 $duration = get_title_by_id("tbl_duration", "duration", array('duration_id'=>$pageVal['duration']))
			 
		 ?>
		     <tr>
		      <td style="text-align: center;"><input type="checkbox" name="arr_ids[]" value="<?php echo $pageVal['price_id'];?>" /></td>
		      <td class="left"><?php echo $pageVal['price'];?></td>
		      <td class="left"><?php echo $instrument_type;?></td>
		      <td class="left"><?php echo $duration;?> Minutes</td>
		      <td class="center"><?php echo ($pageVal['status']==1)?"Active":"In-active";?></td>
		      <td class="center"><?php echo anchor("sitepanel/manage_prices/edit_live_price/$pageVal[price_id]/".query_string(),'Edit'); ?></td>
		     </tr>
		     <?php
		     $j++;
	     }?>
	     <tr><td colspan="7" align="right" height="30"><?php echo $page_links;?></td></tr>
	    </tbody>
	    <tr>
	     <td align="left" colspan="7" style="padding:2px" height="35">
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