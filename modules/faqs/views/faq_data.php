<?php
if(is_array($res) && !empty($res) ){
  foreach($res as $val){
  	?>
  	<li class="listpager"><a href="javascript:void(0)"><img src="<?php echo theme_url()?>images/fq-r.png" class="fl mr5" alt=""><?php echo $val['question'];?></a>
	<div class="faq-text">
	   <?php echo $val['answer'];?>
	   <div class="cb"></div>
	</div>
	</li>
	<?php
  }
}else{
	echo '<div class="red b">'.lang("no_record_found").'</div>';
}