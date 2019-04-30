<?php $this->load->view('includes/header'); 

$block_path="liveinstrumentenquiry/";

?>  



 <div id="content">

  <div class="breadcrumb">

     <?php echo anchor('sitepanel/dashbord','Home'); ?> &raquo; <?php echo $heading_title;?>        

      </div>

      

      <div class="box">

    <div class="heading">

      <h1><img src="<?php echo base_url(); ?>assets/sitepanel/image/category.png" alt="" /> <?php echo $heading_title; ?></h1>

      <div class="buttons">&nbsp;</div>

    </div>

    <div class="content">

     <?php  echo error_message(); ?>

        

		<?php echo form_open("sitepanel/liveinstrumentenquiry/",'id="search_form"');?>

        <div align="right" class="breadcrumb"> Records Per Page : <?php echo display_record_per_page();?> </div>

		<table width="100%"  border="0" cellspacing="3" cellpadding="3" >

		  

         <tr>

			<td align="center" ><strong>Search</strong> [  name,email ] 

			  <input type="text" name="keyword" value="<?php echo $this->input->get_post('keyword');?>"  />&nbsp;			

			<a  onclick="$('#search_form').submit();" class="button"><span> GO </span></a>			

			<?php

			if($this->input->get_post('keyword')!='')

			{ 

				echo anchor("sitepanel/liveinstrumentenquiry/",'<span>Clear Search</span>');

			} 

			?>
		   </td>
		</tr>
		</table>
		<?php echo form_close();?>
		<?php 
		if( is_array($res) && !empty($res) )
		{
		?>
			<?php echo form_open("sitepanel/liveinstrumentenquiry/",'id="data_form"');?>
			<table class="list" width="100%" id="my_data">
			<thead>
			<tr>
				<td width="22" style="text-align: center;"><input type="checkbox" onclick="$('input[name*=\'arr_ids\']').attr('checked', this.checked);" /></td>
                <td width="61" class="left">Date</td>
				<td width="168" class="left">Sender info</td>
				<td width="319" class="left">Enquiry</td>
			</tr>

			</thead>
			<tbody>
			<?php
			$atts = array(
						'width'      => '600',
						'height'     => '300',
						'scrollbars' => 'yes',
						'status'     => 'yes',
						'resizable'  => 'yes',
						'screenx'    => '0',
						'screeny'    => '0'
					 );
			foreach($res as $catKey=>$res)
			{

				$address_details=array();
				$catname=get_db_field_value('tbl_instrument_type',"title","WHERE id ='".$res['category']."'");
				?> 
				<tr>
					<td style="text-align: center;" valign="top">
                    <input type="checkbox" name="arr_ids[]" value="<?php echo $res['id'];?>" /></td>
					<td class="left" valign="top"><?php echo getdateFormat($res["post_date"],1);?></td>
                    <td class="left" valign="top">
					 <br>
					<?php
					if($res['name']!="" && $res['name']!='0')
					{ 
						$address_details[]="<b>Name : </b>".$res['name']; 
					}
					if($res['email']!="" && $res['email']!='0')
					{ 
						$address_details[]="<b>Email : </b>".$res['email']; 
					} 
					if($res['mobile']!="" && $res['mobile']!='0')
					{ 
						$address_details[]="<b>Mobile : </b>".$res['mobile']; 
					} 
					if($res['category']!="" && $res['category']!='0')
					{ 
						$address_details[]="<b>Category : </b>".$catname; 
					} 
					if($res['preffered_date']!="" && $res['preffered_date']!='0')
					{ 
						$address_details[]="<b>Preferred Date : </b>".getdateFormat($res['preffered_date'],1); 
					} 
					if(!empty($address_details))
					{
						echo implode("<br>",$address_details)."<br /><br />"; 
					}

					?><BR />
                     <?php if($res['upd_file']!='' && file_exists(UPLOAD_DIR.'/order_file/'.$res['upd_file'])){ ?>
                   <a href="<?php echo site_url("sitepanel/liveinstrumentenquiry/downloadfile/".$res['id']);?>"> <strong>View/Download</strong> </a></td>            
         <?php } ?>
					
					<td width="17" valign="top" class="left"><?php echo $res['comment'];?>
                    <br />
                 <?php if($res['admin_reply']!=''){?>
                 <strong> Admin Reply : </strong><?php echo $res['admin_reply'];?>
                 <?php } ?> <br />
                 <?php echo anchor_popup('sitepanel/liveinstrumentenquiry/send_reply/'.$res['id'], 'Send Reply', $atts);  ?>
                   </td>
				</tr>

			<?php
			}		  
			?> 
			<tr><td colspan="6" align="right" height="30"><?php echo $page_links; ?></td></tr>     
			</tbody>
			<tr>
				<td align="left" colspan="6" style="padding:2px" height="35">
        	<?php
          if($this->admin_type==1){

					?>

					<input name="status_action" type="submit" class="button2" id="Delete" value="Delete"  onClick="return validcheckstatus('arr_ids[]','delete','Record');"/>

          <?php } ?>

				</td>

			</tr>

			</table>

			<?php echo form_close();

		}else{

			echo "<center><strong> No record(s) found !</strong></center>" ;

		}

		?> 

	</div>

</div>

<?php $this->load->view('includes/footer'); ?>