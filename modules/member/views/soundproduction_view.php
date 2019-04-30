<?php $this->load->view("top_application");?>

<!-- Breadcrumb --> 
<div class="breadcrumb_outer">
<div class="container">
<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="<?php echo base_url();?>">Home</a></li>
  <li class="breadcrumb-item"><a href="<?php echo site_url('member/indivisualservice');?>">Individual Services</a></li>
  <li class="breadcrumb-item active">Sound Production</li>
</ol>
</div>
</div>
<!-- Breadcrumb End -->

<!-- MIDDLE STARTS -->
<div class="work_area">
<div class="container">
<div class="cms">
<h1 class="text-center">Sound Production</h1>

<div class="mt-4 sound_box">
<div class="row">

<div class="col-md-12 col-lg-6 no_pad">
<div class="work_box">
<p class="youtube_icon"><a data-fancybox="" data-type="iframe" data-src="https://www.youtube.com/embed/<?php echo $recording_youtube;?>" href="javascript:void(0);" class="pop2" title=""><i class="fab fa-youtube"></i></a></p>
<a href="<?php echo site_url("member/soundrecording");?>">
<div class="circle-container">
  <div class="quarter top-left"></div>
  <div class="quarter top-right"></div>
  <div class="quarter bottom-left"></div>
  <div class="quarter bottom-right"></div>
  <div class="fill-circle"><svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" viewBox="0 0 60 60"><path d="M56.4 0.3c-0.4-0.3-1-0.4-1.5-0.3L20.6 11c-0.7 0.2-1.2 0.9-1.2 1.6v33.6c-1.8-1.2-4.1-1.9-6.5-1.9 -2.5 0-5 0.8-6.8 2.1 -2 1.5-3.1 3.5-3.1 5.7 0 2.2 1.1 4.2 3.1 5.7C8 59.2 10.4 60 13 60c2.6 0 5-0.8 6.8-2.1 2-1.5 3.1-3.5 3.1-5.7V25.4l30.8-9.8v19.7c-1.8-1.2-4.1-1.9-6.5-1.9 -2.5 0-5 0.8-6.8 2.1 -2 1.5-3.1 3.5-3.1 5.7s1.1 4.2 3.1 5.7c1.8 1.4 4.3 2.1 6.8 2.1s5-0.8 6.8-2.1c2-1.5 3.1-3.5 3.1-5.7V13.2c0 0 0 0 0 0V1.7C57.1 1.2 56.8 0.7 56.4 0.3zM13 56.6c-3.5 0-6.5-2-6.5-4.5 0-2.4 3-4.5 6.5-4.5 3.5 0 6.5 2 6.5 4.5C19.5 54.6 16.5 56.6 13 56.6zM22.8 21.8v-8l30.8-9.8v8L22.8 21.8zM47.2 45.7c-3.5 0-6.5-2-6.5-4.5s3-4.5 6.5-4.5c3.5 0 6.5 2.1 6.5 4.5C53.7 43.6 50.7 45.7 47.2 45.7z" fill="#FFF"></path></svg></div>
</div>
<p class="work_title">Recording</p>
<p class="work_desc"><?php echo $recording_desc;?></p>
<p><span class="readmore">Read More</span></p>
</a>
</div>
</div>

<div class="col-md-12 col-lg-6 no_pad">
<div class="work_box">
<p class="youtube_icon"><a data-fancybox="" data-type="iframe" data-src="https://www.youtube.com/embed/<?php echo $designing_youtube;?>" href="javascript:void(0);" class="pop2" title=""><i class="fab fa-youtube"></i></a></p>
<a href="<?php echo site_url("member/sounddesigning");?>">
<div class="circle-container">
  <div class="quarter top-left"></div>
  <div class="quarter top-right"></div>
  <div class="quarter bottom-left"></div>
  <div class="quarter bottom-right"></div>
  <div class="fill-circle"><svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" viewBox="0 0 60 60"><path d="M56.2 3.9c-5.2-5.2-13.6-5.2-18.7 0L3.1 38.2c-0.3 0.3-0.4 0.6-0.5 1l-2.5 18.8C0 58.6 0.2 59.1 0.6 59.5 0.9 59.8 1.3 60 1.8 60c0.1 0 0.2 0 0.2 0l11.4-1.5c0.9-0.1 1.6-1 1.5-1.9 -0.1-0.9-1-1.6-1.9-1.5l-9.1 1.2 1.8-13.1 13.8 13.8c0.3 0.3 0.8 0.5 1.2 0.5s0.9-0.2 1.2-0.5l34.3-34.3c2.5-2.5 3.9-5.8 3.9-9.4C60.1 9.7 58.7 6.4 56.2 3.9zM6.8 39.4L38.1 8.1l5.8 5.8L12.5 45.2 6.8 39.4zM20.6 53.3L15 47.7l31.3-31.3 5.6 5.6L20.6 53.3zM54.4 19.5L40.6 5.7c1.8-1.4 3.9-2.2 6.2-2.2 2.6 0 5.1 1 6.9 2.9 1.9 1.8 2.9 4.3 2.9 6.9C56.6 15.6 55.8 17.7 54.4 19.5z" fill="#FFF"></path></svg></div>
</div>
<p class="work_title">Designing</p>
<p class="work_desc"><?php echo $designing_desc;?></p>
<p><span class="readmore">Read More</span></p>
</a>
</div>
</div>




</div>
</div>

</div>
</div>
</div>
<!-- MIDDLE ENDS -->

<?php $this->load->view("bottom_application");