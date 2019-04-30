<p class="show-hide text-center fs16 b orange bg-gray visible-xs"><img src="<?php echo theme_url();?>images/accmenu_ico.png" alt="" class="vam mr5"> Account Links</p>
<ul class="emp_acc_link"> 
<li><a href="<?php echo site_url("member");?>" <?php if($this->uri->segment(1)=='member' && $this->uri->segment(2)==''){ ?>class="act" <?php } ?> title="Dashboard">Dashboard</a></li>
<li><a href="<?php echo site_url('member/viewfavoriteproduct');?>" <?php if($this->uri->segment(1)=='member' && $this->uri->segment(2)=='viewfavoriteproduct'){ ?>class="act" <?php } ?> title="Favorite Products">Favorite Products</a></li>
<li><a href="<?php echo site_url('member/followseller');?>" <?php if($this->uri->segment(1)=='member' && $this->uri->segment(2)=='followseller'){ ?>class="act" <?php } ?> title="Followed Seller">Followed Seller</a></li>
<li><a href="<?php echo site_url("member/orders");?>" <?php if($this->uri->segment(1)=='member' && $this->uri->segment(2)=='orders'){ ?>class="act" <?php } ?> title="Order History">Order History</a></li>
<li><a href="<?php echo site_url('member/edit_account');?>" <?php if($this->uri->segment(1)=='member' && $this->uri->segment(2)=='edit_account'){ ?>class="act" <?php } ?>  title="Manage Account">Manage Account</a></li>
</ul>
<div class=" clearfix"></div>
<div class="acc_top_box "> <img src="<?php echo theme_url();?>images/usr.png" width="60" height="60" alt="" class="pull-left mr10 hidden-xs">
<div class="mt5 rel"><span class="acc_title">Welcome <?php echo $this->session->userdata('name');?>!

</span>
  <p class="mt5">
 <?php if($this->session->userdata('last_login_date')!='0000-00-00 00:00:00'){;?>
  Last Login : <?php echo getDateFormat($this->session->userdata('last_login_date'),7);?> 
  <?php } ?>
  <br class="visible-xs"><span class="red"><a href="<?php echo site_url('users/logout');?>" class="uu"> <img src="<?php echo theme_url();?>images/lgt.png" width="17" height="17" alt=""> Logout!</a></span></p>
 
<div class="btn_pos">
<?php 
if($this->is_seller == 2 || $this->userType == 4 ){?> 
  <a href="<?php echo site_url('seller');?>" class="btn btn3">Go to Seller Account</a>
<?php }else{ ?>
  <a href="<?php echo site_url('member/becomeseller');?>" class="btn btn3">Become A Seller</a>
<?php } ?>
</div>

</div>
<div class=" clearfix"></div>
</div>