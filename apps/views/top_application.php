<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no;user-scalable=0;"/>
<?php 
$meta_rec = getMeta();

if( array_key_exists('dynamic_meta',$meta_rec) && @is_array($meta_array) && !empty($meta_array) )
{
	if(  array_key_exists('meta_title',$meta_array) && $meta_array['meta_title']!='')
	{
		echo '<title>'.$meta_array['meta_title'].'</title>';
	}
	if( array_key_exists('meta_description',$meta_array) && $meta_array['meta_description']!='')
	{
		echo '<meta name="description" content="'.$meta_array['meta_description'].'" />';
	}
	if( array_key_exists('meta_keyword',$meta_array) && $meta_array['meta_keyword']!='')
	{
	   echo '<meta  name="keywords" content="'.$meta_array['meta_keyword'].'" />';
	}
	
}else
{	
?>
<title><?php echo $meta_rec['meta_title'];?> </title>
<meta name="description" content="<?php echo $meta_rec['meta_description'];?>" />
<meta  name="keywords" content="<?php echo $meta_rec['meta_keyword'];?>" />
<?php
}
?>
<script src="https://ajax.aspnetcdn.com/ajax/jquery/jquery-1.10.2.min.js"></script> 
<link href="<?php echo base_url(); ?>assets/developers/css/proj.css" rel="stylesheet" type="text/css" />
<link rel="shortcut icon" href="<?php echo base_url();?>favicon.ico">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<link href="https://fonts.googleapis.com/css?family=Titillium+Web:300,400,600,700" rel="stylesheet">
<link href="<?php echo theme_url();?>css/conditional-preet.css" type="text/css" rel="stylesheet">
<link rel="stylesheet" href="<?php echo theme_url();?>css/fluid_dg.css">

<script type="text/javascript">var _siteRoot='<?php echo base_url()?>',_root='<?php echo base_url()?>';</script>
<script type="text/javascript" > var site_url = '<?php echo site_url();?>';</script>
<script type="text/javascript" > var theme_url = '<?php echo theme_url();?>';</script>
<script type="text/javascript" > var resource_url = '<?php echo resource_url(); ?>';</script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/developers/js/common.js"></script>

<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
<?php 
if ($this->site_setting["google_anylitical_code"]!="" ){
	 echo $this->site_setting["google_anylitical_code"];
 }
 ?>
</head>
<noscript>
	<div style="height:30px;border:3px solid #6699ff;text-align:center;font-weight: bold;padding-top:10px">
		Java script is disabled , please enable your browser java script first.
	</div>
</noscript>
<?php $this->load->view('project_header');?>
<body>