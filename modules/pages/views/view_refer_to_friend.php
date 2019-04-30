<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<link rel="shortcut icon" href="fav.ico">
<title>PinkAvenue.store</title>
<link rel="stylesheet" href="<?php echo theme_url();?>css/main.css">
<link rel="stylesheet" href="<?php echo theme_url();?>css/conditional_preet.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:300,400,700">
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
<link href="<?php echo base_url(); ?>assets/developers/css/proj.css" rel="stylesheet" type="text/css" />
</head>
<body style="padding:0">
<?php 
  	echo form_open();
  	echo error_message();
  ?>
<div>
  <h3>Refer to a Friend</h3>
  <div class="mt7">
    <input name="your_name" id="email" type="text" placeholder="Name *" class="p8 w100 radius-3" value="<?php echo set_value('your_name');?>"><?php echo form_error('your_name')?>
  </div>
  <div class="mt7">
    <input name="your_email" id="email" type="text" placeholder="Email ID *" class="p8 w100 radius-3" value="<?php echo set_value('your_email');?>"><?php echo form_error('your_email')?>
  </div>
  <div class="mt7">
    <input name="friend_name" id="email" type="text" placeholder="Friend's Name *" class="p8 w100 radius-3" value="<?php echo set_value('friend_name')?>"><?php echo form_error('friend_name')?>
  </div>
  <p class="mt7">
    <input name="friend_email" id="email" type="text" placeholder="Friend's Email ID *" class="p8 w100 radius-3" value="<?php echo set_value('friend_email')?>"><?php echo form_error('friend_email')?>
  </p>
  <div class="mt10">
    <input name="input" type="submit" value="Submit" class="btn1b">
  </div>
</div>
<?php echo form_close();?>
</body>
</html>