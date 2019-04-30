<?php $this->load->view('includes/header'); ?>
<div class="content">
 <div id="content">
  <div class="breadcrumb"><?php echo anchor('sitepanel/dashbord','Home'); ?>&raquo;<?php echo anchor('sitepanel/products?category_id='.$this->input->get_post('category_id').'','Products'); ?> &raquo; <?php echo $heading_title; ?></div>
  <div class="box">
   <div class="heading">
    <h1><img src="<?php echo base_url(); ?>assets/sitepanel/image/category.png" alt="" /> <?php echo $heading_title; ?></h1>
    <div class="buttons"><?php echo anchor("sitepanel/products/add_color_img/".$this->uri->segment(4).'/'.$this->uri->segment(5),'<span>Add Color Image</span>','class="button" ' );?></div>
   </div>
   <div class="content">
    <?php
    if(error_message() !=''){
	    echo error_message();
    }?>
    <script type="text/javascript">function serialize_form() { return $('#myform').serialize();   } </script>
    <?php echo form_open("",'id="myform" ');?>
    <div align="right" class="breadcrumb"> Records Per Page : <?php echo display_record_per_page();?> </div>
    <?php
    echo form_close();
    echo form_open("sitepanel/products/change_color_status/".$this->uri->segment(4),'id="" ');
    if( is_array($res) && !empty($res) )
    {
	    ?>
	    <table class="list" width="100%" id="my_data">
	     <thead>
	      <tr>
	       <td width="20" style="text-align: center;"><input type="checkbox" onclick="$('input[name*=\'arr_ids\']').attr('checked', this.checked);" /></td>
	       <td width="202" align="left" class="left">Color Name</td>
	       <td width="202" class="center">Image</td>
	       <td width="134" class="center">Edit</td>
	       <!--<td width="134" class="right">Status</td>-->
	      </tr>
	     </thead>
	     <tbody>
	      <?php
	      $i=0;
	      foreach($res as $catKey=>$pageVal)
	      {
		      $i++;
		      ?>
		      <tr>
		       <td style="text-align: center;"><input type="checkbox" name="arr_ids[]" value="<?=$pageVal['id'];?>" /></td>
		       <td align="left"><?php echo get_db_field_value('tbl_colors','color_name',array('id'=>$pageVal['color_id']));?></td>
		       <td align="center"><img src="<?php echo get_image('products',$pageVal['media'],'100','100','R'); ?>" alt="" class="fl mr8 bdr"></td>
		       <td class="center"><a href="<?php echo base_url()."sitepanel/products/edit_color_img/".$this->uri->segment(4).'/'.$pageVal['products_id'].'/'.$pageVal['id'];?>" >Edit</a></td>
		       <!--<td class="right"><?php echo ($pageVal['color_status']==1)? "Active":"In-active";?></td>-->
		      </tr>
		      <?php
	      }?>
	      <tr><td class="list" colspan="9" align="right" height="30"><?php echo $page_links; ?></td></tr>
	     </tbody>
	     <tr>
	      <td align="left" colspan="9" style="padding:2px" height="35">
	       <!--<input name="Activate" type="submit"  value="Activate" class="button2" id="Activate" onClick="return validcheckstatus('arr_ids[]','Activate','Record','u_status_arr[]');"/>
	       <input name="Deactivate" type="submit" class="button2" value="Deactivate" id="Deactivate"  onClick="return validcheckstatus('arr_ids[]','Deactivate','Record','u_status_arr[]');"/>    -->
	       <input name="Delete" type="submit" class="button2" id="Delete" value="Delete"  onClick="return validcheckstatus('arr_ids[]','delete','Record');"/>
	      </td>
	     </tr>
	    </table>
	    <?php
    }else
    {
	    echo "<center><strong> No record(s) found !</strong></center>" ;
    }
    echo form_close();
    ?>
   </div>
  </div>
 </div>  
</div>
<?php $this->load->view('includes/footer'); ?>