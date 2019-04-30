<div id="content">

  <div class="breadcrumb">

       <?php echo anchor('sitepanel/dashbord','Home'); ?>
        &raquo; <?php echo anchor('sitepanel/category'.($catresult['parent_id']==0 ? '' : '/index/'.$catresult['parent_id']),'Back To Listing'); ?> &raquo; <?php echo $heading_title; ?> </a>
      </div>
      <div class="box">
    <div class="heading">
      <h1><img src="<?php echo base_url(); ?>assets/sitepanel/image/category.png" alt="" /> <?php echo $heading_title; ?></h1>
     <div class="buttons"><?php echo anchor('sitepanel/category'.($catresult['parent_id']==0 ? '' : '/index/'.$catresult['parent_id']),'<span>Cancel</span>','class="button" ' );?></div>
    </div>
    <div class="content">
	<?php echo error_message(); ?>  
	<?php echo form_open_multipart(current_url_query_string(),array('id'=>'catfrm','name'=>'catfrm'));?>  
		<div id="tab_pinfo">
			<table width="90%"  class="form"  cellpadding="3" cellspacing="3">
			<tr>
				<th colspan="2" align="center" > </th>
			</tr>
          
          
         <?php
     $default_params = array(
			'heading_element' => array(
			'field_heading'=>$heading_title." Name",
			'field_name'=>"category_name",
			'field_value'=>$catresult['category_name'],
			'field_placeholder'=>"Your Category Name",
			'exparams' => 'size="40"'
			),
			'url_element'  => array(
			'field_heading'=>"Page URL",
			'field_name'=>"friendly_url",
			'field_value'=>$catresult['friendly_url'],			  
			'field_placeholder'=>"Your Page URL",
			'exparams' => 'size="40" readonly',
			)
		 );
		 seo_edit_form_element($default_params);?>
			

			<tr class="trOdd">

				<td width="28%" height="26" align="right" >Image :</td>

				<td align="left">

					<input type="file" name="category_image" />

					<?php

					if($catresult['category_image']!='' && file_exists(UPLOAD_DIR."/category/".$catresult['category_image']))

					{ 

					?>
                     <img src="<?php echo get_image('category',$catresult['category_image'],100,89,'AR');?>" />
						 <input type="checkbox" name="cat_img_delete" value="Y" />Delete

					<?php	

					}

					?>

					<br />

                    <br />

					[ <?php echo $this->config->item('category.best.image.view');?> ]

					

				  <?php echo form_error('category_image');?>

				</td>

			</tr>
            <tr class="trOdd">

			 <td height="26" align="right"> Description :</td>

			 <td><textarea name="category_description" rows="5" cols="50" id="cat_desc" ><?php echo $catresult['category_description'];?></textarea> <?php  echo display_ckeditor($ckeditor); ?></td>

			</tr>

			<?php /*?><tr class="trOdd">

				<td width="28%" height="26" align="right" >Alt :</td>

				<td align="left">

					<input type="text" name="category_alt" value="<?php echo set_value('category_alt',$catresult['category_image_alt']);?>" />

					<br />

				</td>
			</tr><?php */?>
            
            <?php if($catresult['parent_id']==0){ ?>  
            <tr class="trOdd">
			 <td width="28%" height="26" align="right" >Is Display in top menu :</td>
			 <td align="left"><input type="radio" name="display_top_menu" value="1"  <?php if($catresult['display_top_menu']=='1'){ echo "checked";}?>/> <strong>No</strong>
             <input type="radio" name="display_top_menu" value="2" <?php if($catresult['display_top_menu']=='2' ){ echo "checked";}?>/> <strong>Yes</strong>
             </td>
			</tr>
         <?php } ?>

			<tr class="trOdd">
				<td align="left">&nbsp;</td>
				<td align="left">
					<input type="submit" name="sub" value="Update" class="button2" />
					<input type="hidden" name="action" value="editcategory" />
					<input type="hidden" name="category_id" id="pg_recid" value="<?php echo $catresult['category_id'];?>">
				</td>
			</tr>
			</table>
		</div>
	<?php echo form_close(); ?>
	</div>
</div>