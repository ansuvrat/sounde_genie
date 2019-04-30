<?php $this->load->view("top_application");?>
<!--Banner-->
<?php if(is_array($rwbanner) && count($rwbanner) > 0 ){?>
<div class="fluid_container">
  <div id="Page_loader">
    <div class="AniDG"></div>
  </div>
  <div class="fluid_dg_wrap fluid_dg_charcoal_skin fluid_container" id="fluid_dg_wrap_1" >
<?php foreach($rwbanner as $banVal){
	  if($banVal['image']!='' && file_exists(UPLOAD_DIR.'/upd_files/'.$banVal['image'])){
	?>  
<div data-src="<?php echo base_url();?>uploaded_files/upd_files/<?php echo $banVal['image'];?>">
      <div class="fluid_dg_caption moveFromBottom">
        <div>
          <div class="bnr-txt1"><span><?php echo $banVal['heading1'];?></span></div>
          <div class="bnr-txt2"><?php echo $banVal['heading2'];?></div>
        </div>
      </div>
    </div>
<?php } 
}
?>    
 
</div>
</div>
<p class="clearfix"></p>
<!--Banner end-->
<?php } ?>
<!--Welcome-->
<div class="welc_area">
<a id="welcome"></a>
<p class="arr_down"><a href="#welcome" class="scroll"><i class="fas fa-angle-double-down"></i></a></p>
<div class="container welc_bg">
<h1>Welcome to Sound Genie</h1>
<p class="welc_desc">
<?php echo strip_tags(character_limiter($content['page_description'],300));?>
</p>
<p><a href="<?php echo site_url('about-us');?>" class="readmore" title="Read More">Read More</a></p>
</div>
</div>
<!--Welcome End-->

<?php 
$soundproduction="member/soundproduction";
if($this->session->userdata('user_id')!='' && $this->session->userdata('sessuser_type')==2){
	
	$soundproduction="member/companysoundproduction";
}
?>

<!--Sound Music-->
<div class="sound_music_area">
<a id="sound"></a>
<p class="arr_down"><a href="#sound" class="scroll"><i class="fas fa-angle-double-down"></i></a></p>
<div class="sound_line"><div><p></p></div></div>
<div class="container">
<div class="row">

<div class="col-6 no_pad"><a href="<?php echo site_url($soundproduction);?>" title="View More">
<div class="hwork_item">
<div class="hw_img">
<div class="circle" style="background:#000;">
<p class="sound_ico"><img src="<?php echo theme_url();?>images/sound-img.png" alt="Sound Production"></p>
<p class="sound_name">Sound<br>Production</p>
<p class="viewmore">Click Here</p>
</div>
<svg x="0px" y="0px" viewBox="0 0 179 179"><circle class="outer" cx="90" cy="90" r="88"></circle></svg>            
</div>          
</div>
</a>
</div>
<?php 
$musicproduction="member/musicproduction";
if($this->session->userdata('user_id')!='' && $this->session->userdata('sessuser_type')==2){
	
	$musicproduction="member/companymusicproduction";
}
?>
<div class="col-6 no_pad"><a href="<?php echo site_url($musicproduction);?>" title="View More">
<div class="hwork_item">
<div class="hw_img">
<div class="circle" style="background:#4c1071;">
<p class="sound_ico"><img src="<?php echo theme_url();?>images/music-img.png" alt="Music Production"></p>
<p class="sound_name">Music<br>Production</p>
<p class="viewmore">Click Here</p>
</div>
<svg x="0px" y="0px" viewBox="0 0 179 179"><circle class="outer" cx="90" cy="90" r="88"></circle></svg>            
</div>          
</div>
</a>
</div>

</div>
</div>
</div>
<!--Sound Music End-->

<!--WE WOULD LOVE TO WORK WITH YOU-->
<div class="work_area">
<a id="work"></a>
<p class="arr_down"><a href="#work" class="scroll"><i class="fas fa-angle-double-down"></i></a></p>
<div class="container">
<p class="heading">WE WOULD LOVE TO WORK WITH YOU</p>

<div id="owl-work" class="owl-carousel owl-theme mt-4">

<div class="item">
<a href="<?php echo site_url('member/composition');?>" title="Composition">
<div class="work_box">
<div class="circle-container">
  <div class="quarter top-left"></div>
  <div class="quarter top-right"></div>
  <div class="quarter bottom-left"></div>
  <div class="quarter bottom-right"></div>
  <div class="fill-circle"><svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" viewBox="0 0 60 60"><path d="M56.4 0.3c-0.4-0.3-1-0.4-1.5-0.3L20.6 11c-0.7 0.2-1.2 0.9-1.2 1.6v33.6c-1.8-1.2-4.1-1.9-6.5-1.9 -2.5 0-5 0.8-6.8 2.1 -2 1.5-3.1 3.5-3.1 5.7 0 2.2 1.1 4.2 3.1 5.7C8 59.2 10.4 60 13 60c2.6 0 5-0.8 6.8-2.1 2-1.5 3.1-3.5 3.1-5.7V25.4l30.8-9.8v19.7c-1.8-1.2-4.1-1.9-6.5-1.9 -2.5 0-5 0.8-6.8 2.1 -2 1.5-3.1 3.5-3.1 5.7s1.1 4.2 3.1 5.7c1.8 1.4 4.3 2.1 6.8 2.1s5-0.8 6.8-2.1c2-1.5 3.1-3.5 3.1-5.7V13.2c0 0 0 0 0 0V1.7C57.1 1.2 56.8 0.7 56.4 0.3zM13 56.6c-3.5 0-6.5-2-6.5-4.5 0-2.4 3-4.5 6.5-4.5 3.5 0 6.5 2 6.5 4.5C19.5 54.6 16.5 56.6 13 56.6zM22.8 21.8v-8l30.8-9.8v8L22.8 21.8zM47.2 45.7c-3.5 0-6.5-2-6.5-4.5s3-4.5 6.5-4.5c3.5 0 6.5 2.1 6.5 4.5C53.7 43.6 50.7 45.7 47.2 45.7z" fill="#FFF"/></svg></div>
</div>
<p class="work_title">Composition</p>
<p class="work_desc"><?php echo $composition;?></p>
</div></a>
</div>

<div class="item">
<a href="<?php echo site_url('member/lyrics');?>" title="Lyrics">
<div class="work_box">
<div class="circle-container">
  <div class="quarter top-left"></div>
  <div class="quarter top-right"></div>
  <div class="quarter bottom-left"></div>
  <div class="quarter bottom-right"></div>
  <div class="fill-circle"><svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" viewBox="0 0 60 60"><path d="M56.2 3.9c-5.2-5.2-13.6-5.2-18.7 0L3.1 38.2c-0.3 0.3-0.4 0.6-0.5 1l-2.5 18.8C0 58.6 0.2 59.1 0.6 59.5 0.9 59.8 1.3 60 1.8 60c0.1 0 0.2 0 0.2 0l11.4-1.5c0.9-0.1 1.6-1 1.5-1.9 -0.1-0.9-1-1.6-1.9-1.5l-9.1 1.2 1.8-13.1 13.8 13.8c0.3 0.3 0.8 0.5 1.2 0.5s0.9-0.2 1.2-0.5l34.3-34.3c2.5-2.5 3.9-5.8 3.9-9.4C60.1 9.7 58.7 6.4 56.2 3.9zM6.8 39.4L38.1 8.1l5.8 5.8L12.5 45.2 6.8 39.4zM20.6 53.3L15 47.7l31.3-31.3 5.6 5.6L20.6 53.3zM54.4 19.5L40.6 5.7c1.8-1.4 3.9-2.2 6.2-2.2 2.6 0 5.1 1 6.9 2.9 1.9 1.8 2.9 4.3 2.9 6.9C56.6 15.6 55.8 17.7 54.4 19.5z" fill="#FFF"/></svg></div>
</div>
<p class="work_title">Lyrics</p>
<p class="work_desc"><?php echo $lyrics;?></p>
</div>
</a>
</div>

<div class="item">
<a href="<?php echo site_url('member/mixing');?>" title="Mixing">
<div class="work_box">
<div class="circle-container">
  <div class="quarter top-left"></div>
  <div class="quarter top-right"></div>
  <div class="quarter bottom-left"></div>
  <div class="quarter bottom-right"></div>
  <div class="fill-circle"><svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" viewBox="0 0 60 60"><path d="M31.7 29.2V1.7C31.7 0.7 31 0 30.1 0c-0.9 0-1.7 0.7-1.7 1.7v27.6c-3.9 0.8-6.8 4.2-6.8 8.4s2.9 7.6 6.8 8.4v12.3c0 0.9 0.7 1.7 1.7 1.7 0.9 0 1.7-0.7 1.7-1.7V46c3.9-0.8 6.8-4.2 6.8-8.4C38.6 33.5 35.6 30 31.7 29.2zM30.1 42.8c-2.8 0-5.2-2.3-5.2-5.2s2.3-5.2 5.2-5.2c2.8 0 5.2 2.3 5.2 5.2S32.9 42.8 30.1 42.8zM11.2 15.1V1.7C11.2 0.7 10.4 0 9.5 0S7.8 0.7 7.8 1.7v13.4C3.9 15.9 1 19.4 1 23.5c0 4.1 2.9 7.6 6.8 8.4v26.4c0 0.9 0.7 1.7 1.7 1.7s1.7-0.7 1.7-1.7V31.9c3.9-0.8 6.8-4.2 6.8-8.4S15.1 15.9 11.2 15.1zM9.5 28.7c-2.8 0-5.2-2.3-5.2-5.2 0-2.9 2.3-5.2 5.2-5.2s5.2 2.3 5.2 5.2C14.7 26.4 12.3 28.7 9.5 28.7zM52.2 15.1V1.7C52.2 0.7 51.4 0 50.5 0s-1.7 0.7-1.7 1.7v13.4c-3.9 0.8-6.8 4.2-6.8 8.4 0 4.1 2.9 7.6 6.8 8.4v26.4c0 0.9 0.7 1.7 1.7 1.7s1.7-0.7 1.7-1.7V31.9C56.1 31.1 59 27.6 59 23.5S56.1 15.9 52.2 15.1zM50.5 28.7c-2.8 0-5.2-2.3-5.2-5.2 0-2.9 2.3-5.2 5.2-5.2s5.2 2.3 5.2 5.2C55.6 26.4 53.3 28.7 50.5 28.7z" fill="#FFF"/></svg></div>
</div>
<p class="work_title">Mixing</p>
<p class="work_desc"><?php echo $mixing;?></p>
</div>
</a>
</div>

<div class="item">
<a href="<?php echo site_url('member/mastering');?>" title="Recording">
<div class="work_box">
<div class="circle-container">
  <div class="quarter top-left"></div>
  <div class="quarter top-right"></div>
  <div class="quarter bottom-left"></div>
  <div class="quarter bottom-right"></div>
  <div class="fill-circle"><svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" viewBox="0 0 60 60"><path d="M45.9 29c-0.6 0-1 0.5-1 1v6.2c0 8-6.5 14.5-14.4 14.5s-14.4-6.5-14.4-14.5V30c0-0.6-0.5-1-1-1S14 29.4 14 30v6.2c0 8.8 6.9 16 15.5 16.5v5.2h-5.2c-0.6 0-1 0.5-1 1 0 0.6 0.5 1 1 1h12.4c0.6 0 1-0.5 1-1 0-0.6-0.5-1-1-1H31.5v-5.2c8.6-0.5 15.5-7.7 15.5-16.5V30C47 29.4 46.5 29 45.9 29zM30.5 47.6c6.3 0 11.3-5.1 11.3-11.4V11.4C41.8 5.1 36.7 0 30.5 0S19.1 5.1 19.1 11.4v24.8C19.1 42.5 24.2 47.6 30.5 47.6zM21.3 37.3c0-0.3-0.1-0.7-0.1-1v-3.1c0.6 0 1-0.5 1-1s-0.5-1-1-1v-4.1c0.6 0 1-0.5 1-1 0-0.6-0.5-1-1-1v-4.1c0.6 0 1-0.5 1-1 0-0.6-0.5-1-1-1v-4.1c0.6 0 1-0.5 1-1s-0.5-1-1-1v-1c0-1.2 0.2-2.3 0.6-3.3 0.2-0.2 0.4-0.5 0.4-0.8 0 0 0 0 0-0.1 0.4-0.8 0.9-1.5 1.5-2.2 0.2 0.1 0.3 0.2 0.5 0.2 0.6 0 1-0.5 1-1 0-0.2 0-0.3-0.1-0.4 1.5-1 3.3-1.6 5.3-1.6 2 0 3.8 0.6 5.3 1.6 -0.1 0.1-0.1 0.3-0.1 0.4 0 0.6 0.5 1 1 1 0.2 0 0.4-0.1 0.5-0.2 0.6 0.6 1.1 1.4 1.5 2.2 0 0 0 0.1 0 0.1 0 0.3 0.2 0.6 0.4 0.8 0.4 1 0.6 2.2 0.6 3.3v1c-0.6 0-1 0.5-1 1s0.5 1 1 1v4.1c-0.6 0-1 0.5-1 1 0 0.6 0.5 1 1 1v4.1c-0.6 0-1 0.5-1 1 0 0.6 0.5 1 1 1v4.1c-0.6 0-1 0.5-1 1s0.5 1 1 1v3.1c0 0.4 0 0.7-0.1 1 -0.5 0-1 0.5-1 1 0 0.4 0.2 0.7 0.5 0.9 -0.8 2.4-2.5 4.3-4.7 5.4 0 0 0 0 0-0.1 0-0.6-0.5-1-1-1 -0.6 0-1 0.5-1 1 0 0.3 0.1 0.5 0.3 0.7 -0.8 0.2-1.5 0.3-2.4 0.3 -0.8 0-1.6-0.1-2.4-0.3 0.2-0.2 0.3-0.4 0.3-0.7 0-0.6-0.5-1-1-1s-1 0.5-1 1c0 0 0 0 0 0.1 -2.2-1.1-3.9-3-4.7-5.4 0.3-0.2 0.5-0.5 0.5-0.9C22.2 37.7 21.8 37.3 21.3 37.3zM30.5 5.2c0.6 0 1-0.5 1-1s-0.5-1-1-1c-0.6 0-1 0.5-1 1S29.9 5.2 30.5 5.2zM27.4 8.3c0.6 0 1-0.5 1-1s-0.5-1-1-1c-0.6 0-1 0.5-1 1S26.8 8.3 27.4 8.3zM27.4 14.5c0.6 0 1-0.5 1-1s-0.5-1-1-1c-0.6 0-1 0.5-1 1S26.8 14.5 27.4 14.5zM24.3 11.4c0.6 0 1-0.5 1-1s-0.5-1-1-1c-0.6 0-1 0.5-1 1S23.7 11.4 24.3 11.4zM30.5 11.4c0.6 0 1-0.5 1-1s-0.5-1-1-1c-0.6 0-1 0.5-1 1S29.9 11.4 30.5 11.4zM24.3 17.6c0.6 0 1-0.5 1-1s-0.5-1-1-1c-0.6 0-1 0.5-1 1S23.7 17.6 24.3 17.6zM30.5 17.6c0.6 0 1-0.5 1-1s-0.5-1-1-1c-0.6 0-1 0.5-1 1S29.9 17.6 30.5 17.6zM33.6 8.3c0.6 0 1-0.5 1-1s-0.5-1-1-1c-0.6 0-1 0.5-1 1S33 8.3 33.6 8.3zM33.6 14.5c0.6 0 1-0.5 1-1s-0.5-1-1-1c-0.6 0-1 0.5-1 1S33 14.5 33.6 14.5zM36.7 11.4c0.6 0 1-0.5 1-1s-0.5-1-1-1c-0.6 0-1 0.5-1 1S36.1 11.4 36.7 11.4zM36.7 17.6c0.6 0 1-0.5 1-1s-0.5-1-1-1c-0.6 0-1 0.5-1 1S36.1 17.6 36.7 17.6zM27.4 20.7c0.6 0 1-0.5 1-1s-0.5-1-1-1c-0.6 0-1 0.5-1 1S26.8 20.7 27.4 20.7zM27.4 26.9c0.6 0 1-0.5 1-1 0-0.6-0.5-1-1-1 -0.6 0-1 0.5-1 1C26.4 26.4 26.8 26.9 27.4 26.9zM24.3 23.8c0.6 0 1-0.5 1-1s-0.5-1-1-1c-0.6 0-1 0.5-1 1S23.7 23.8 24.3 23.8zM30.5 23.8c0.6 0 1-0.5 1-1s-0.5-1-1-1c-0.6 0-1 0.5-1 1S29.9 23.8 30.5 23.8zM24.3 30c0.6 0 1-0.5 1-1 0-0.6-0.5-1-1-1 -0.6 0-1 0.5-1 1C23.3 29.5 23.7 30 24.3 30zM30.5 30c0.6 0 1-0.5 1-1 0-0.6-0.5-1-1-1 -0.6 0-1 0.5-1 1C29.4 29.5 29.9 30 30.5 30zM33.6 20.7c0.6 0 1-0.5 1-1s-0.5-1-1-1c-0.6 0-1 0.5-1 1S33 20.7 33.6 20.7zM33.6 26.9c0.6 0 1-0.5 1-1 0-0.6-0.5-1-1-1 -0.6 0-1 0.5-1 1C32.5 26.4 33 26.9 33.6 26.9zM36.7 23.8c0.6 0 1-0.5 1-1s-0.5-1-1-1c-0.6 0-1 0.5-1 1S36.1 23.8 36.7 23.8zM36.7 30c0.6 0 1-0.5 1-1 0-0.6-0.5-1-1-1 -0.6 0-1 0.5-1 1C35.6 29.5 36.1 30 36.7 30zM27.4 33.1c0.6 0 1-0.5 1-1s-0.5-1-1-1c-0.6 0-1 0.5-1 1S26.8 33.1 27.4 33.1zM27.4 39.3c0.6 0 1-0.5 1-1s-0.5-1-1-1c-0.6 0-1 0.5-1 1S26.8 39.3 27.4 39.3zM24.3 36.2c0.6 0 1-0.5 1-1s-0.5-1-1-1c-0.6 0-1 0.5-1 1S23.7 36.2 24.3 36.2zM30.5 36.2c0.6 0 1-0.5 1-1s-0.5-1-1-1c-0.6 0-1 0.5-1 1S29.9 36.2 30.5 36.2zM24.3 42.4c0.6 0 1-0.5 1-1s-0.5-1-1-1c-0.6 0-1 0.5-1 1S23.7 42.4 24.3 42.4zM30.5 42.4c0.6 0 1-0.5 1-1s-0.5-1-1-1c-0.6 0-1 0.5-1 1S29.9 42.4 30.5 42.4zM33.6 33.1c0.6 0 1-0.5 1-1s-0.5-1-1-1c-0.6 0-1 0.5-1 1S33 33.1 33.6 33.1zM33.6 39.3c0.6 0 1-0.5 1-1s-0.5-1-1-1c-0.6 0-1 0.5-1 1S33 39.3 33.6 39.3zM36.7 36.2c0.6 0 1-0.5 1-1s-0.5-1-1-1c-0.6 0-1 0.5-1 1S36.1 36.2 36.7 36.2zM36.7 42.4c0.6 0 1-0.5 1-1s-0.5-1-1-1c-0.6 0-1 0.5-1 1S36.1 42.4 36.7 42.4z" fill="#FFF"/></svg></div>
</div>
<p class="work_title">Mastering</p>
<p class="work_desc"><?php echo $recording;?></p>
</div>
</a>
</div>

</div>
</div>
</div>
<!--WE WOULD LOVE TO WORK WITH YOU End-->


<?php $this->load->view("bottom_application");?>