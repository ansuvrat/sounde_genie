<?php $this->load->view("top_application",array("is_header"=>FALSE))?>
<div class="pt5 pb5">
  <h3>Advanced Search</h3>
  <?php echo form_open('products',array("target"=>"_parent"))?>
  <div class="mt7">
      <input type="text" name="suggestion" class="p8 w100" autocomplete="off" id="suser" placeholder="Member" onkeyup="lookup_member(this.value);"  >
      <div class="suggestionsBox" id="suggestions" style="display:none;margin-top:10px"><img src="<?php echo theme_url()?>images/upArrow.png" style="position: relative; top: -18px; left: 100px;" alt="upArrow">
	  <div class="suggestionList" id="autoSuggestionsList"></div>
	  </div>
	  <input type="hidden" name="user_id" value="" id="suser_id"> 
   </div>
  <p class="mt7">
    <select name="category_id" id="category_id" class="p8 w100" data-fld-key="category_id" data-next-sel-val="<?php echo $this->input->post("scategory_id")?>" data-class="ajx" data-url="category/show_category">
     <option value="">Category</option>
     <?php 
		echo db_option_value(array(
						"table_name"=>"tbl_categories",
						"opt_val_fld"=>"category_id",
						"opt_txt_fld"=>"category_name",
						"current_selected_val"=>'',
						"default_text"=>'',
						"orderby"=>'sort_order ASC',
						"cond"=>'status = "1" AND parent_id = 0'));
		?>
    </select>
  </p>
  <p class="mt7">
    <select name="scategory_id" id="scategory_id" class="p8 w100" data-class="ajx">
      <option value="">Sub Category</option>
    </select>
  </p>
  <p class="mt7">
    <input name="keyword" id="keyword" type="text" placeholder="Keyword" class="p8 w100">
  </p>
  <p class="mt7">
  <?php 
			if(is_array($this->config->item("buy_type_array"))){						
				$i=1;
				$buy_type=$this->input->get_post("buy_type");
				foreach ($this->config->item("buy_type_array") as $key=>$val){
					?>
					<label class='<?php echo $i==1?'':'ml20'?>'><input name="buy_type" type="radio" value="<?php echo $key?>" <?php echo $key==$buy_type?'checked="checked"':""?> > <?php echo $key?></label>
					<?php 
					$i++;
				}
			}
			
		?>  
  </p>
   
  <p class="mt10"><input name="input" type="submit"  value="Search" class="button-style"  ></p>
  <?php echo form_close()?>
</div>

<script src="<?php echo base_url()?>assets/developers/js/multichange_dn.js"></script>
<script type="text/javascript" src="<?php echo resource_url(); ?>Scripts/script.int.dg.js"></script>

<?php $data_trigger = $this->input->post('category_id') ? 'Y' : 'N';?>
<script type="text/javascript">
	jQuery(document).ready(function($){
 		 var jq_dn_group = {'ajx':{}};
  		$.multichange_selectbox(jq_dn_group,'<?php echo $data_trigger;?>','N');
	});
</script>

</body>
</html>
