<div class="acc_lft">
    <div class="acc_box p-3">
        <p class="fs16 yel"><?php echo $this->name;?> </p>
        <p class="mt-1"><?php echo $this->username;?></p>
        <?php if($this->last_login !=''){?>
        <p class="mt-1">Last Login: <?php echo getdateFormat($this->last_login,1);?> </p>
       <?php } ?> 
    </div>
    <p class="d-block d-lg-none acc_tab_mob shownext"><span class="fas fa-bars"></span> Account Links</p>
    <div class="acc_box acc_box_hide">
      <ul class="acc_links">
        <li <?php if($this->uri->segment(1)=='member' && $this->uri->segment(2)==''){?>class="acc_act" <?php } ?>><a href="<?php echo site_url("member");?>"><span class="far fa-folder-open"></span> Dashboard</a> </li>
        <li <?php if($this->uri->segment(1)=='member' && $this->uri->segment(2)=='edit_account'){?>class="acc_act" <?php } ?>><a href="<?php echo site_url("member/edit_account");?>"><span class="far fa-id-card"></span> Edit Profile</a></li>
        <li <?php if($this->uri->segment(1)=='member' && $this->uri->segment(2)=='changepassword'){?>class="acc_act" <?php } ?>><a href="<?php echo site_url("member/changepassword");?>"><span class="fas fa-key"></span> Change Password</a></li>
    <?php if($this->session->userdata('sessuser_type')==3){?>     
        <li <?php if($this->uri->segment(1)=='member' && $this->uri->segment(2)=='enquiry'){?>class="acc_act" <?php } ?> ><a href="<?php echo site_url("member/enquiry");?>"><span class="far fa-envelope"></span> My Enquiries</a></li>
     <?php } ?>   
        <li <?php if($this->uri->segment(1)=='member' && $this->uri->segment(2)=='orders'){?>class="acc_act" <?php } ?>><a href="<?php echo site_url("member/orders");?>"><span class="far fa-list-alt"></span> My Orders</a></li>
        <li><a href="<?php echo site_url("users/logout");?>"><span class="fas fa-sign-out-alt"></span> Logout</a></li>
      </ul>
    </div>
  </div>