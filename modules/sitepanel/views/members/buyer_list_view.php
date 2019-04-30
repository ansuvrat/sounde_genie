<?php $this->load->view('includes/header'); ?>
<div id="content">
 <div class="breadcrumb"><?php echo anchor('sitepanel/dashbord','Home'); ?> &raquo; <?php echo $heading_title;?></div>
 <div class="box">
  <div class="heading">
   <h1><img src="<?php echo base_url(); ?>assets/sitepanel/image/category.png" alt="" /> <?php echo $heading_title; ?></h1>
   <div class="buttons">&nbsp;</div>
  </div>
  <div class="content">
   
   <?php   echo form_open("",'id="search_form" method="get" ');    ?>
   <div align="right" class="breadcrumb"> Records Per Page : <?php echo display_record_per_page();?> </div>
   <?php if(error_message() !=''){echo error_message();}?>
   <table width="100%"  border="0" align="center" cellspacing="3" cellpadding="3">   
    <tr>
    <td align="left">
      <div class="required"><strong> Total Record(s) Found : <?php echo $total_rec; ?></strong></div>
    </td>
    </tr>
    <tr>
     <td width="100%" align="right" >     
        <table width="100%" border="0">
            <tr>
           		 <td align="right"><strong>Keywords</strong> [ name, username ]</td>
                 <td><input name="keyword" type="text" value="<?php echo trim($this->input->get_post('keyword'));?>" size="40" placeholder="Keyword"  />
                 &nbsp;<select name="mem_type">
       <option value="">Select Member Company</option>
       <option value="2" <?php if($this->input->get_post('mem_type')=='2'){ echo "Selected";}?>>Company</option>
       <option value="3" <?php if($this->input->get_post('mem_type')=='3'){ echo "Selected";}?>>Member</option>
      </select>&nbsp;
                 &nbsp;<select name="status">
       <option value="">Status</option>
       <option value="1" <?php echo $this->input->get_post('status')==='1' ? 'selected="selected"' : '';?>>Active</option>
       <option value="0" <?php echo $this->input->get_post('status')==='0' ? 'selected="selected"' : '';?>>In-active</option>
      </select>&nbsp;
      <input type="hidden" name="st" value="1" />
      <a  onclick="$('#search_form').submit();" class="button"><span>GO </span></a>&nbsp;
      <?php
    if( $this->input->get_post('keyword')!='' ||  $this->input->get_post('mem_type')!='' || $this->input->get_post('status')!='' ){ 

	      echo anchor(current_url(),'<span>Clear Search</span>');
      }
      ?>
                 </td>
            </tr>
        </table>
     </td>
    </tr>
   </table>
   <?php   
   echo form_close();
   echo form_open("sitepanel/members?mem_type=$mem_type",'id="data_form"');?>   
   <table class="list" width="100%" id="my_data">
    <?php
		$atts = array(
					'width'      => '900',
					'height'     => '500',
					'scrollbars' => 'yes',
					'status'     => 'yes',
					'resizable'  => 'yes',
					'screenx'    => '0',
					'screeny'    => '0'
					);
					
		$atts1 = array(
					'width'      => '500',
					'height'     => '400',
					'scrollbars' => 'yes',
					'status'     => 'yes',
					'resizable'  => 'yes',
					'screenx'    => '0',
					'screeny'    => '0'
					);						

		if( count($pagelist) > 0 ){
			?>
			<thead>
			 <tr>
			  <td width="5%" style="text-align: center;"><input type="checkbox" onclick="$('input[name*=\'arr_ids\']').attr('checked', this.checked);" /></td>
			  <td width="25%" class="left">Name</td>
			  <td class="left">Login details</td>
			  <td width="12%" align="right" >Reg. Date </td>
			  <td width="15%" class="center">Status</td>
			  <td width="8%" class="center">Details</td>
			 </tr>
			</thead>
			<tbody>
			 <?php
			 foreach($pagelist as $catKey=>$pageVal){				
				 ?>
				 <tr>
				  <td style="text-align: center;"><input type="checkbox" name="arr_ids[]" value="<?php echo $pageVal['id'];?>" /></td>
				  <td class="left"><?php echo ucwords($pageVal['name']);?>
                  <sup><strong><span class="red">(<?php echo ($pageVal['user_type']==3)?'User':'Company';?>)</span></strong></sup>
                    </td>
				  <td class="left"><?php echo $pageVal['username'];?><br />
                  <?php echo $this->safe_encrypt->decode($pageVal['password']);?>
                  </td>
				  <td class="right"><?php echo getDateFormat($pageVal['created_at'],7);?></td>
				  <td class="center"><?php echo ($pageVal['status']=='1')?"Active":"Inactive";?>		
				   <br /><strong> Email : <?php echo ($pageVal['is_verified']==1)?"<span style='color:green'>Verified</span>":"<span style='color:red;'>Not Verified</span>";?>     </strong>	
				  </td>
				   <td class="center">
			  <?php echo anchor_popup('sitepanel/members/details/'.$pageVal['id'], 'View Details!', $atts);?>
			  </td>
				 </tr>
				 <?php
			 }
			 ?>
			 <tr><td colspan="7" align="right" height="30"><?php echo $page_links; ?></td></tr>
			 <tr>
			  <td colspan="7" align="left" style="padding:5px">
			   <input name="status_action" type="submit"  value="Activate" class="button2" id="Activate" onClick="return validcheckstatus('arr_ids[]','Activate','Record','u_status_arr[]');"/>
			   <input name="status_action" type="submit" class="button2" value="Deactivate" id="Deactivate"  onClick="return validcheckstatus('arr_ids[]','Deactivate','Record','u_status_arr[]');"/>
			   <?php if($this->admin_type==1){ ?>
			   <input name="status_action" type="submit" class="button2" id="Delete" value="Delete"  onClick="return validcheckstatus('arr_ids[]','delete','Record');"/>
			   <?php } ?>
			 <input name="status_action" type="submit"  value="Verify" class="button2" id="Verify" onClick="return validcheckstatus('arr_ids[]','Verify','Record','u_status_arr[]');"/>
            <input name="status_action" type="submit"  value="Not Verify" class="button2" id="NotVerify" onClick="return validcheckstatus('arr_ids[]','Not Verify','Record','u_status_arr[]');"/>
			  </td>
			 
			 </tr>
			</tbody>
			<?php
		}else{
			echo "<div class='ac b'> No record(s) found !</div>" ;
		}
		?>
	 </table>
	 <?php echo form_close(); ?>
	</div>

 </div>	
</div>
<?php $this->load->view('includes/footer'); 