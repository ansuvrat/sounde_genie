<?php $this->load->view('includes/face_header'); ?>

<table width="100%"  border="0" cellspacing="5" cellpadding="5" class="list" style="line-height:20px">

<thead>
<tr >
	<td colspan="3" height="30"><?php echo $heading_title; ?></td>
</tr>
</thead>

<tr class="trOdd">
	<td>Category</td>
	<td>:</td>
	<td>
	<?php echo get_db_field_value('tbl_categories','category_name',array('category_id'=>$res->category_id));?> 
	</td>

</tr>



<tr class="trOdd">

	<td width="19%">Product Name</td>

	<td width="3%">: </td>

	<td width="78%"><?php echo $res->product_name;?> </td>

</tr>

<tr class="trOdd">

	<td width="19%">Product Code</td>

	<td width="3%">: </td>

	<td width="78%"><?php echo $res->product_code;?> </td>

</tr>

<tr class="trOdd">

	<td width="19%">Product Price</td>

	<td width="3%">: </td>

	<td width="78%"><?php echo display_price($res->product_price);?> </td>

</tr>

<?php



if((int)$res->product_discounted_price>0){

	?>

	<tr class="trOdd">

		<td width="19%">Product Discount Price</td>

		<td width="3%">: </td>

		<td width="78%"><?php echo display_price($res->product_discounted_price);?> </td>

	</tr>
	<?php 
	}
?>
<?php if($brandname!=''){ ?>
<tr class="trOdd">
	<td>Brand</td>
	<td>: </td>
	<td><?php echo $brandname;?> </td>
</tr>
<?php } ?>

<?php if($product_type!=''){ ?>
<tr class="trOdd">
	<td>Product Type </td>
	<td>: </td>
	<td><?php echo $product_type;?> </td>
</tr>
<?php } ?>
<?php if($matarial!=''){ ?>
<tr class="trOdd">
	<td>Material </td>
	<td>: </td>
	<td><?php echo $matarial;?> </td>
</tr>
<?php } ?>

<?php if($polish!=''){ ?>
<tr class="trOdd">
	<td>Polish </td>
	<td>: </td>
	<td><?php echo $polish;?> </td>
</tr>
<?php } ?>
<?php if($weight!=''){ ?>
<tr class="trOdd">
	<td>Weight </td>
	<td>: </td>
	<td><?php echo $weight;?> </td>
</tr>
<?php } ?>
<?php if($height!=''){ ?>
<tr class="trOdd">
	<td>Height </td>
	<td>: </td>
	<td><?php echo $height;?> </td>
</tr>
<?php } ?>
<?php if($depth!=''){ ?>
<tr class="trOdd">
	<td>Depth </td>
	<td>: </td>
	<td><?php echo $depth;?> </td>
</tr>
<?php } ?>

<?php if($bedback_type!=''){ ?>
<tr class="trOdd">
	<td>Bed Back Type  </td>
	<td>: </td>
	<td><?php echo $bedback_type;?> </td>
</tr>
<?php } ?>

<?php if($res->bed_box_type!=''){ ?>
<tr class="trOdd">
	<td>Bed Box Type  </td>
	<td>: </td>
	<td><?php echo ($res->bed_box_type==1)?"With Box":"Without Box";?> </td>
</tr>
<?php } ?>
<?php if($res->no_of_box!=''){ ?>
<tr class="trOdd">
	<td>No Of Box  </td>
	<td>: </td>
	<td><?php echo $res->no_of_box;?> </td>
</tr>
<?php } ?>

<?php if($bedsize_type!=''){ ?>
<tr class="trOdd">
	<td>Bed Size Type </td>
	<td>: </td>
	<td><?php echo $bedsize_type;?> </td>
</tr>
<?php } ?>




<tr class="trOdd">

	<td>Description</td>

	<td>: </td>

	<td><?php echo $res->products_description;?> </td>

</tr>



<tr>

<td>Image</td>

	<td>: </td>

		<td colspan="1">

<?php 



foreach($res_photo_media as $val)

{   

	

	$media_name = $val["media"];

	?>		

	<img src="<?php echo get_image('products',$media_name,50,50,'AR');?>" />		

	<?php

}

?>

</td>

	</tr>

</table>

</body>

</html>