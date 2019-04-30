<?php $this->load->view('includes/header'); ?>  
<div id="content">
  <div class="breadcrumb">
       <?php echo anchor('sitepanel/dashbord','Home'); ?>
        &raquo; Static Pages </a>
      </div>
      <div class="box">
    <div class="heading">
      <h1><img src="<?php echo base_url(); ?>assets/sitepanel/image/category.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons">&nbsp;</div>
    </div>
    <div class="content">
    
      <script type="text/javascript">function serialize_form() { return $('#pagingform').serialize(); } </script> 
      
       <?php  echo error_message(); ?>
		
        
        <?php echo form_open("sitepanel/staticpages/",'id="search_form" method="get" '); ?>
        
		<table width="100%"  border="0" cellspacing="3" cellpadding="3" >
		  
          <tr>
			<td align="center" >Search [ page name ] 
            
				<input type="text" name="keyword" value="<?php echo $this->input->get_post('keyword');?>"  />&nbsp;
                
				<a  onclick="$('#search_form').submit();" class="button"><span> GO </span></a>
                
			
				<?php 
				if($this->input->get_post('keyword')!='')
				{ 
				  echo anchor("sitepanel/staticpages/",'<span>Clear Search</span>');
				} 
				?>
			</td>
		</tr>     
        <div align="right" class="breadcrumb"> Records Per Page : <?php echo display_record_per_page();?> </div>
		</table>
		<?php echo form_close();?>
   <?php
    if( is_array($pagelist) && !empty($pagelist) )
	{
    echo form_open("sitepanel/staticpages/",'id="data_form" ');?>
      <table class="list" width="100%" id="my_data">
          <thead>
            <tr>
              <td width="1" style="text-align: center;">S.No.</td>
              <td class="left">Page Name
                </td>
              <td class="right">Details</td>
              <td class="left">Status </td>
              <td class="right">Action</td>
            </tr>
          </thead>
          <tbody>
          <?php
		  	$ctr=1;
			foreach($pagelist as $val)
			{ 
          ?>
            <tr>
              <td style="text-align: center;"><?php echo $ctr;?></td>
              <td class="left"><?php echo $val['page_name'];?></td>    
              <td class="right"><a href="javascript:void(0);"  onclick="$('#dialog_<?php echo $val['page_id'];?>').dialog({ width: 650 });">view</a>
			  <div id="dialog_<?php echo $val['page_id'];?>" title="Description" style="display:none;">
			    <?php echo $val['page_description'];?>
               </div>             
              </td>
              <td class="left"><?php echo ($val['status']==1)? "Active":"In-active";?></td>
              <td class="right">    [ <?php echo anchor("sitepanel/staticpages/edit/$val[page_id]/".query_string(),'Edit'); ?> ]
              </td>
            </tr>
            <?php
			  $ctr++;
			}
		  ?>
        </tbody>
        	<tr><td colspan="6" align="right" height="30"><?php echo $page_links; ?></td></tr>     
        </table>
    <?php echo form_close();
	 }else{
	    echo "<center><strong> No record(s) found !</strong></center>" ;
	 }
	?> 
  </div>
</div>
<?php $this->load->view('includes/footer'); ?>