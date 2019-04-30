<?php $this->load->view('includes/header'); 

$block_path="careerenquiry/";

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

        

		<?php echo form_open("sitepanel/careerenquiry/",'id="search_form"');?>

        <div align="right" class="breadcrumb"> Records Per Page : <?php echo display_record_per_page();?> </div>

		<table width="100%"  border="0" cellspacing="3" cellpadding="3" >

		  

         <tr>

			<td align="center" ><strong>Search</strong> [  name,email,phone ] 

			  <input type="text" name="keyword" value="<?php echo $this->input->get_post('keyword');?>"  />&nbsp;
              <input type="hidden" name="st" value="1" />
              <input name="from_date" type="text" id="textfield3" class="start_date1 input-bdr2 radius-5" placeholder="From Date" style="width:165px;" value="<?php echo $this->input->get_post('from_date');?>">&nbsp;<input name="to_date" type="text" id="textfield4" class="end_date1 input-bdr2 radius-5" placeholder="To Date"  style="width:165px;" value="<?php echo $this->input->get_post('to_date');?>">			

			<a  onclick="$('#search_form').submit();" class="button"><span> GO </span></a>			

			<?php

			if($this->input->get_post('st')!='')

			{ 

				echo anchor("sitepanel/careerenquiry/",'<span>Clear Search</span>');

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

			<?php echo form_open("sitepanel/careerenquiry/",'id="data_form"');?>

          

			<table class="list" width="100%" id="my_data">

			<thead>

			<tr>

				<td width="23" style="text-align: center;"><input type="checkbox" onclick="$('input[name*=\'arr_ids\']').attr('checked', this.checked);" /></td>
                <td width="105" class="left">Date</td>
				<td width="320" class="left">Sender info</td>
				<td width="143" class="left">Resume</td>
			</tr>

			</thead>
			<tbody>
			<?php
			foreach($res as $catKey=>$res)
			{

				$address_details=array();
				?> 

				<tr>

					<td style="text-align: center;" valign="top">

                    <input type="checkbox" name="arr_ids[]" value="<?php echo $res['id'];?>" /></td>

					<td class="left" valign="top"><?php echo getdateFormat($res["post_date"],1);?></td>
                    <td class="left" valign="top">
					<?php
					if($res['name']!="" && $res['name']!='0')
					{ 
						$address_details[]="<b>Name : </b>".$res['name']; 
					}
					if($res['family_name']!="" && $res['family_name']!='0')
					{ 
						$address_details[]="<b>Family name : </b>".$res['family_name']; 
					}
					if($res['gnder']!="" && $res['gnder']!='0')
					{ 
						$address_details[]="<b>Gender : </b>".$res['gnder']; 
					} 
					if($res['country']!="" && $res['country']!='0')
					{ 
						$address_details[]="<b>Country : </b>".$res['country']; 
					} 
					if($res['nationality']!="" && $res['nationality']!='0')
					{ 
						$address_details[]="<b>Nationality : </b>".$res['nationality']; 
					} 
					if($res['marital_status']!="" && $res['marital_status']!='0')
					{ 
						$address_details[]="<b>Marital status : </b>".$res['marital_status']; 
					} 
					if($res['email']!="" && $res['email']!='0')
					{ 
						$address_details[]="<b>Email : </b>".$res['email']; 
					}
					if($res['dob']!="" && $res['dob']!='0')
					{ 
						$address_details[]="<b>Date of birth : </b>".getdateFormat($res['dob'],1);
					}
					if($res['contact_no']!="" && $res['contact_no']!='0')
					{ 
						$address_details[]="<b>Phone : </b>".$res['contact_no'];  
					}
					if($res['hear_from_us']!="" && $res['hear_from_us']!='0')
					{ 
						$address_details[]="<b>How did you hear from us : </b>".$res['hear_from_us'];  
					}
					if($res['designation']!="" && $res['designation']!='0')
					{ 
						$address_details[]="<b>Designation Applying For : </b>".$res['designation'];  
					}
					if(!empty($address_details))
					{
						echo implode("<br>",$address_details)."<br /><br />"; 
					}

					?>
					</td>
					<td class="left" valign="top">
                    <?php if($res['resume']!='' && file_exists(UPLOAD_DIR.'/resume/'.$res['resume'])){ ?>
                   <a href="<?php echo site_url("sitepanel/careerenquiry/viewresume/".$res['id']);?>"> <strong>View/Download</strong> </a></td>            
         <?php } ?>
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
<?php
//$default_date = '2013-08-12';
$default_date = date('Y-m-d');
?>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/developers/js/jquery/ui/jquery-ui.js"></script>
<link type="text/css" href="<?php echo base_url(); ?>assets/developers/js/jquery/ui/themes/ui-lightness/jquery.ui.all.css" rel="stylesheet" />
<script type="text/javascript">
$(document).ready(function(){

$(".start_date1").datepicker({
showOn: "both",
dateFormat: 'yy-mm-dd',
changeMonth: true,
changeYear: true,
defaultDate: 'y',
buttonText:'',
minDate:'' ,
buttonImage: '<?php echo theme_url();?>images/cald.png',
maxDate:'',
yearRange: "c-100:c+100",
buttonImageOnly: true,
onSelect: function(dateText, inst) {
$('.start_date1').val(dateText);
$( ".end_date1").datepicker("option",{
minDate:dateText ,
});
}
});

$(".end_date1").datepicker({
showOn: "both",
dateFormat: 'yy-mm-dd',
changeMonth: true,
changeYear: true,
defaultDate: 'y',
buttonText:'',
minDate:'' ,
buttonImage: '<?php echo theme_url();?>images/cald.png',
maxDate:'',
yearRange: "c-100:c+100",
buttonImageOnly: true,
onSelect: function(dateText, inst) {
$('.end_date1').val(dateText);
$( ".start_date1").datepicker("option",{
maxDate:dateText ,
});
}
});

});
</script>
<?php $this->load->view('includes/footer'); ?>