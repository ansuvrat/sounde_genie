<?php 
	if(!empty($res) && is_array($res)){
		foreach ($res as $key=>$val){
?>
<div class="t_monial listpager">
<p class="testi_name"><?php echo $val['name'];?></p>
<p class="testi_date"><span class="far fa-calendar-alt"></span> <?php echo getdateFormat($val['created_at'],1);?></p>
<div class="t_text_12">
<p><?php echo $val['testimonial_desc'];?></p>
</div>

<?php
$strln=strlen(strip_tags($val['testimonial_desc']));
if($strln > 400){
?>
<a href="#" class="rm_link">&nbsp;</a>
<?php } ?>
<p class="clearfix"></p>
</div>
<?php }
	}else{ ?>
    <div align="center">No record found...</div>
<?php } ?>  