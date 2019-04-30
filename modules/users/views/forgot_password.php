<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no;user-scalable=0;"/>
<title>Welcome to :: Sound Genie</title>
<link rel="shortcut icon" href="favicon.ico">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.6/css/all.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<link href="https://fonts.googleapis.com/css?family=Titillium+Web:300,400,600,700" rel="stylesheet">
<link href="<?php echo theme_url();?>css/conditional-preet.css" type="text/css" rel="stylesheet">
<link href="<?php echo base_url(); ?>assets/developers/css/proj.css" rel="stylesheet" type="text/css" />
</head>
<body>
<?php echo form_open();
echo error_message();
?>
<div class="p-3">
<h1>Forgot Password</h1>
<div class="mt-2"><input name="email" id="name" type="text" placeholder="Email ID *" class="p-2 w-100" value="<?php echo set_value('email');?>"><?php echo form_error('email');?></div>
<div class="mt-2">
  <div><input name="verification_code" type="text" style="width:100px" class="p-2" placeholder="Enter Code *"> <img src="<?php echo site_url('captcha/normal'); ?>" alt="" class="vam" id="captchaimage"><a href="javascript:void(0);" onclick="document.getElementById('captchaimage').src='<?php echo base_url().'captcha/normal'; ?>/<?php echo uniqid(time()); ?>'+Math.random(); document.getElementById('verification_code').focus();"><img src="<?php echo theme_url();?>images/ref.png" alt="" class="vam"></a>
  <?php echo form_error('verification_code');?>
  </div>
  <div class="mt-2 fs13">Type the characters shown above.</div>
</div>
<div class="mt-2"><input name="" type="submit" class="btn btn-yel" value="Send" > </div>
</div>
<?php echo form_close();?>
</body>
</html>