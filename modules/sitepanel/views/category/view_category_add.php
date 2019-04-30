<div class="content">

 <div id="content">

  <div class="breadcrumb"><?php echo anchor('sitepanel/dashbord','Home'); ?> &raquo; <?php echo anchor('sitepanel/category'.($parent_id==0 ? '' : '/index/'.$parent_id),'Back To Listing'); ?> &raquo; <?php echo $heading_title; ?> </a></div>

  <div class="box">

   <div class="heading">

    <h1><img src="<?php echo base_url(); ?>assets/sitepanel/image/category.png" alt="" /> <?php echo $heading_title; ?></h1>

    <div class="buttons"><?php echo anchor('sitepanel/category'.($parent_id==0 ? '' : '/index/'.$parent_id),'<span>Cancel</span>','class="button" ' );?></div>

   </div>

   <div class="content">

    <?php echo validation_message();

    echo error_message();

    echo form_open_multipart("sitepanel/category/add/".$parent_id);?>

    <div id="tab_pinfo">

     <table width="90%"  class="form"  cellpadding="3" cellspacing="3">

      <tr><th colspan="2" align="center" > </th></tr>
          <?php
      $default_params = array(
				'heading_element' => array(
				'field_heading'=>"Name",
				'field_name'=>"category_name",
				'field_placeholder'=>"Your Category Name",
				'exparams' => 'size="40"'
				),
				'url_element'  => array(
				'field_heading'=>"Page URL",
				'field_name'=>"friendly_url",
				'field_placeholder'=>"Your Page URL",
				'exparams' => 'size="40"',
				'pre_seo_url' =>'',
				'pre_url_tag'=>FALSE
				)
			);

			if(is_array($parentData))
			{
			  $pre_seo_url  = base_url().$parentData['friendly_url']."/";
			  $default_params['url_element']['pre_seo_url'] = $pre_seo_url;
			  $default_params['url_element']['pre_url_tag'] = FALSE;
			  $default_params['url_element']['exparams'] = 'size="30"';
			}

			seo_add_form_element($default_params);?>
     			

		
          <?php if($this->uri->segment(4)==0){ ?>  
            <tr class="trOdd">
			 <td width="28%" height="26" align="right" >Is Display in top menu :</td>
			 <td align="left"><input type="radio" name="display_top_menu" value="1"  <?php if($this->input->post('display_top_menu')=='' || $this->input->post('display_top_menu')=='1'){ echo "checked";}?>/> <strong>No</strong>
             <input type="radio" name="display_top_menu" value="2" <?php if($this->input->post('display_top_menu')=='2' ){ echo "checked";}?>/> <strong>Yes</strong>
             </td>
			</tr>
         <?php } ?>
         <tr class="trOdd">

			 <td width="28%" height="26" align="right" >Image :</td>

			 <td align="left"><input type="file" name="category_image" /><br /><br />[ <?php echo $this->config->item('category.best.image.view');?> ]</td>

			</tr>
			<tr class="trOdd">

			 <td height="26" align="right"> Description :</td>

			 <td><textarea name="category_description" rows="5" cols="50" id="cat_desc" ><?php echo $this->input->post('category_description');?></textarea> <?php  echo display_ckeditor($ckeditor); ?></td>

			</tr>



			<tr class="trOdd">

			 <td align="left">&nbsp;</td>

			 <td align="left">

			  <input type="submit" name="sub" value="Add" class="button2" />

			  <input type="hidden" name="action" value="addcategory" />

			  <?php

			  if(is_array($parentData)){

				  ?>

				  <input type="hidden" name="parent_id" value="<?php echo $parentData['category_id'];?>" />

				  <?php

			  }?>

			 </td>

			</tr>

		 </table>

		</div>

		<?php echo form_close(); ?>

	 </div>

	</div>

 </div>

</div>