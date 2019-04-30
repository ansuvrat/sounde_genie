<?php $this->load->view('includes/header');?>
<div id="content">
 <div class="breadcrumb"><?php echo anchor('sitepanel/dashbord','Home');?> &raquo; <?php echo $heading_title;?></a></div>
 <div class="box">
  <div class="heading">
   <h1><img src="<?php echo base_url(); ?>assets/sitepanel/image/category.png" alt="" /> <?php echo $heading_title;?></h1>
  </div>
  <div class="content">
   <?php echo validation_message();
   echo error_message();
   echo form_open("sitepanel/servicecontent/",'id="search_form" method="get"');?>
   <div align="right" class="breadcrumb"> Records Per Page : <?php echo display_record_per_page();?> </div>
   <table width="100%"  border="0" cellspacing="3" cellpadding="3">
    <tr>
      <td align="center" >Search [ Service ] 
        <input type="text" name="keyword" value="<?php echo $this->input->get_post('keyword');?>"  />&nbsp; <a  onclick="$('#search_form').submit();" class="button"><span> GO </span></a> <?php if($this->input->get_post('keyword')!=''){ echo anchor("sitepanel/servicecontent/",'<span>Clear Search</span>'); }?></td></tr>
   </table>

   <?php echo form_close();
   if( is_array($res) && !empty($res)){
	   echo form_open("sitepanel/servicecontent/",'id="data_form"');?>
	   <table class="list" width="100%" id="my_data">
	    <thead>
	     <tr>
	      <td width="5%" style="text-align: center;">Sn.</td>
	      <td width="40%" class="left">Service</td>
          <td width="40%" class="left">Description</td>
          <td width="40%" class="left">Video</td>
	      <td width="10%" class="center">Action</td>
	     </tr>
	    </thead>
	    <tbody>
	     <?php
	     $j=1;
		 $atts = array(
						'width'      => '670',
						'height'     => '500',
						'scrollbars' => 'yes',
						'status'     => 'yes',
						'resizable'  => 'yes',
						'screenx'    => '0',
						'screeny'    => '0'
					 );
	     foreach($res as $catKey=>$pageVal){
		     ?>
		     <tr>
		      <td style="text-align: center;"><?php echo $j;?></td>
		      <td class="left"><?php echo $pageVal['name'];?></td>
              <td class="left"><?php echo $pageVal['description'];?></td>
              <td class="left">
              <?php echo anchor_popup("https://www.youtube.com/embed/".$pageVal['youtube_url'], 'View', $atts);?>
              </td>
		      <td class="center"><?php echo anchor("sitepanel/servicecontent/edit/$pageVal[id]/".query_string(),'Edit'); ?></td>
		     </tr>
		     <?php
		     $j++;
	     }?>
	     <tr><td colspan="5" align="right" height="30"><?php echo $page_links;?></td></tr>
	    </tbody>
	   </table>
	   <?php echo form_close();
   }else{
	   echo "<center><strong> No record(s) found !</strong></center>";
   }?>
  </div>
 </div>
</div>
<?php $this->load->view('includes/footer');?>