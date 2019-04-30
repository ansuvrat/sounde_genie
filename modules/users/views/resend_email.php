<!DOCTYPE HTML>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Askidinya</title>
<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0">
<link rel="shortcut icon" href="favicon.ico">
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Droid+Sans:400,700">
<link href="<?php echo theme_url();?>css/main.css" rel="stylesheet" type="text/css">
<link href="<?php echo theme_url();?>css/conditional-preet.css" rel="stylesheet" type="text/css">
<link href="<?php echo theme_url();?>css/fluid_dg.css" rel="stylesheet" type="text/css">
<link href="<?php echo base_url(); ?>assets/developers/css/proj.css" rel="stylesheet" type="text/css" />
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
</head>
<body class="bgw">
<div class="pop-inr"> 
<h1>Resend email</h1>
<?php echo form_open("users/resendemail");
echo error_message();
?>
<div class="form-group">
<div class="row">
<div>
<label for="email" class=" control-label">Your Email ID <span class="star">*</span></label>  
<input type="text" class="form-control" id="email" name="email" value="<?php echo set_value('email');?>"><?php echo form_error('email');?></div>
</div>
</div>

<input name="" type="submit" class="btn btn3 trans_eff" value="Send">
<input type="hidden" name="action" value="Add">
</p>

<?php echo form_close();?>
 
  </div>

</body>
</html>
