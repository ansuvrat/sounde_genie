<?php $this->load->view('includes/header');?>
<div id="content">
 <div class="breadcrumb"><?php echo anchor('sitepanel/dashbord','Home'); ?> &raquo; <?php echo $heading_title; ?> </a></div>
 <div class="box">
  <div class="heading"><h1><img src="<?php echo base_url(); ?>assets/sitepanel/image/category.png" alt="" /> <?php echo $heading_title; ?></h1>
  <div class="buttons"> <?php echo anchor("sitepanel/homepagebanner/add/",'<span>Add banner</span>','class="button" ' );?></div>
  </div>
  <div class="content">
   <?php
   validation_message();
   error_message();
   echo form_open("sitepanel/homepagebanner/",'id="form" method="get" ');?>
   <div align="right" class="breadcrumb"> Records Per Page : <?php echo display_record_per_page();?> </div>
   
   <?php echo form_close();
   if( is_array($pagelist) && !empty($pagelist) ) {
	   echo form_open("sitepanel/homepagebanner/",'id="myform"');?>
	   <table class="list" width="100%" id="my_data">
	    <thead>
	     <tr>
         <td width="21" style="text-align: center;"><input type="checkbox" onclick="$('input[name*=\'arr_ids\']').attr('checked', this.checked);" /></td>
          <td width="369" class="left">Images</td>
          <td width="125" class="right">Status</td>
          <td width="125" class="right">Action</td>
	     </tr>
	    </thead>
	    <tbody>
	     <?php
	     foreach($pagelist as $catKey=>$pageVal){
		     ?>
		     <tr>
              <td style="text-align: center;"><input type="checkbox" name="arr_ids[]" value="<?php echo $pageVal['id'];?>" /></td>
              <td class="left">
			   <?php 
                if($pageVal['image']!='' && file_exists(UPLOAD_DIR.'/upd_files/'.$pageVal['image'])){
                ?>
                <img src="<?php echo base_url();?>uploaded_files/upd_files/<?php echo $pageVal['image'];?>" width="1000" height="170" />
                <?php }
				 ?>
                <?php if($pageVal['ban_url']!=''){?>
					<br /><br /><a href="<?php echo $pageVal['ban_url'];?>" target="_blank"><?php echo $pageVal['ban_url'];?></a>
				<?php }?>
                 
              </td>
              <td align="right" ><?php echo ($pageVal['status']==1)?'Active':'In-active';?></td>
		      <td align="center" ><?php echo anchor("sitepanel/homepagebanner/edit/$pageVal[id]/".query_string(),'Edit'); ?></td>
             </tr>
		     <?php
	     }?>
	    </tbody>
	   </table>
	   <?php
	   if($page_links!=''){
		   ?>
		   <table class="list" width="100%">
		    <tr><td align="right" height="30"><?php echo $page_links; ?></td></tr>
		   </table>
		   <?php
	   }?>
	  </table>
       <table class="list" width="100%">
	    <tr>
	     <td align="left" style="padding:2px" height="35">
	      <?php
	     // if($this->activatePrvg===TRUE){
		      ?>
		      <input name="status_action" type="submit"  value="Activate" class="button2" id="Activate" onClick="return validcheckstatus('arr_ids[]','Activate','Record','u_status_arr[]');"/>
		      <?php
	      //}
	      //if($this->deactivatePrvg===TRUE){
		      ?>
		      <input name="status_action" type="submit" class="button2" value="Deactivate" id="Deactivate"  onClick="return validcheckstatus('arr_ids[]','Deactivate','Record','u_status_arr[]');"/>
		      <?php
	     // }
	     // if($this->orderPrvg===TRUE){
		      ?>
		      <!--<input name="update_order" type="submit"  value="Update Order" class="button2" />-->
		      <?php
	     // }
	     // if($this->deletePrvg===TRUE){
		      ?>
		      <input name="status_action" type="submit" class="button2" id="Delete" value="Delete"  onClick="return validcheckstatus('arr_ids[]','delete','Record');"/>
		      <?php
	     // }?>
	     </td>
	    </tr>
	   </table>
	  <?php echo form_close();
  }else{
	  echo "<center><strong> No record(s) found !</strong></center>" ;
  }?>
 </div>
</div>
<?php $this->load->view('includes/footer');?>