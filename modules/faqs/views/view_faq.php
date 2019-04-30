<?php $this->load->view("top_application");?>

<!-- Breadcrumb --> 
<div class="breadcrumb_outer">
<div class="container">
<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="<?php echo base_url();?>">Home</a></li>
  <li class="breadcrumb-item active">FAQ's</li>
</ol>
</div>
</div>
<!-- Breadcrumb End -->

<!-- MIDDLE STARTS -->
<div class="container">
<div class="cms">
<h1>FAQ's</h1>

<div class="accordion mt-4">
<div class="card mb-0">
<?php if(is_array($res) && count($res) > 0 ){
	$ctr=1;
	foreach($res as $val){
	 ?>
<div class="card-header collapsed" data-toggle="collapse" href="#collapse<?php echo $ctr;?>"><a class="card-title"><?php echo $val['question'];?></a></div>
<div id="collapse<?php echo $ctr;?>" class="card-body collapse" data-parent="#accordion" >
<div  class="p-3"><?php echo $val['answer'];?></div>
</div>
<?php 
     $ctr++;
   } 
}else{
?>
<div  align="center"><div > No records found...</div>
<?php } ?>


</div>
</div>


</div>
</div>
<!-- MIDDLE ENDS -->

<?php $this->load->view("bottom_application");?>