<div id="content">

 <div class="breadcrumb"><?php echo anchor('sitepanel/dashbord','Home'); ?> &raquo; <?php echo anchor('sitepanel/banners','Back To Listing'); ?> &raquo;  <?php echo $heading_title; ?> </div>

 <div class="box">

  <div class="heading">

   <h1><img src="<?php echo base_url(); ?>assets/sitepanel/image/category.png" alt="" /> <?php echo $heading_title; ?></h1>

   <div class="buttons"><?php echo anchor('sitepanel/banners','<span>Cancel</span>','class="button" ' );?></div>

  </div>

  <div class="content">

   <?php echo validation_message();

   echo error_message();

   echo form_open_multipart(current_url_query_string());?>

   <table width="90%"  class="form"  cellpadding="3" cellspacing="3">

    <tr><th colspan="2" align="center" > </th></tr>

    
     
    <tr class="trOdd">

     <td width="28%" height="26" align="right" ><span class="required">*</span> Banner Position:</td>

     <td width="72%" align="left">

      <select name="banner_position" >

       <option value="">Select position</option>

       <?php

       $bann_arr = $this->config->item('bannersz');

       foreach ($bann_arr  as $key=>$val){

	       ?>

	       <option value="<?php echo $key;?>" <?php if($res->banner_position==$key){ echo "Selected";}?>><?php echo $val; ?></option>

	       <?php

       }?>

      </select>

     </td>

    </tr>

    <tr class="trOdd">

     <td width="28%" height="26" align="right"> Banner Url:</td>

     <td align="left"><input type="text" name="banner_url" value="<?php echo set_value('banner_url',$res->banner_url);?>" size="40" /> ( ie.http://www.yahoo.com )</td>

    </tr>

    <tr class="trOdd">
     <td width="28%" height="26" align="right" ><span class="required">*</span> Banner Image:</td>
     <td align="left"><input type="file" name="image1" id="image1" />
      <br />
      <?php

      $j=1;

      $product_path = "banner/".$res->banner_image;

      ?>

      <a href="javascript:void(0);"  onclick="$('#dialog_<?php echo $j;?>').dialog({width:'auto'});">View</a>

      <div id="dialog_<?php echo $j;?>" title="Banner Image" style="display:none;"><img src="<?php echo base_url().'uploaded_files/'.$product_path;?>"  /> </div><br />

     </td>
    </tr>
    <tr class="trOdd">
     <td align="left">&nbsp;</td>
     <td align="left">
      <input type="submit" name="sub" value="Update Banner" class="button2" />
      <input type="hidden" name="action" value="addbanner" />
     </td>
    </tr>
   </table>
  </div>

 </div> 

</div>
<script src="<?php echo base_url()?>assets/developers/js/multichange_dn.js"></script>

<script type="text/javascript">

	jQuery(document).ready(function($){

 		 var jq_dn_group = {'ajx':{}};

  $.multichange_selectbox(jq_dn_group,'Y','N');



});

</script>