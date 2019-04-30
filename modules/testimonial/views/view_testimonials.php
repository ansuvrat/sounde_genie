<?php $this->load->view('top_application');?>
	<script type="text/javascript">function serialize_form() { return $('#myform').serialize(); } </script>

<!-- Breadcrumb --> 
<div class="breadcrumb_outer">
<div class="container">
<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="<?php echo base_url();?>">Home</a></li>
  <li class="breadcrumb-item active">Testimonials</li>
</ol>
</div>
</div>
<!-- Breadcrumb End -->

<!-- MIDDLE STARTS -->
<div class="container">
<?php echo form_open('',array("id"=>"myform","name"=>"myform"))?>
  <input type="hidden" name="per_page" value="<?php echo $this->input->get_post('per_page');?>">
  <input type="hidden" name="offset" value="0">
<div class="cms" id="my_data">
<h1>Testimonials</h1>
<p class="rgt_btn"><a data-fancybox data-type="iframe" data-src="<?php echo site_url("testimonial/post");?>" href="javascript:void(0);" class="pop1 btn">Post Testimonials</a></p>

<div class="mt10">
    
    <div id="prodListingContainer">     
    	<?php $this->load->view("testimonial_data",array("res"=>$res))?>
    </div>



    </div>
    
    <p class="mt-4 text-center" style="display:none;padding:10px;"><img src="<?php echo theme_url();?>images/loader.gif" alt=""></p>
</div>
<?php echo form_close();?>
</div>
<!-- MIDDLE ENDS -->
<script type="text/javascript">

  var page = 1;

  var triggeredPaging = 0;



  $(window).scroll(function (){

	var scrollTop = $( window ).scrollTop();

	var scrollBottom = (scrollTop + $( window ).height());

	// alert(scrollTop+scrollBottom);

	var containerTop = $('#prodListingContainer').offset().top;

	var containerHeight = $('#prodListingContainer').height();

	var containerBottom = Math.floor(containerTop + containerHeight);

	var scrollBuffer = 0;



	//  if($(window).scrollTop() + $(window).height() == $(document).height()) {

		

		if((containerBottom - scrollBuffer) <= scrollBottom) {

		  page = $('.listpager').length;

		  $(':hidden[name="offset"]').val(page);

		  var actual_count = <?php echo $totalProduct; ?>;		 

		  if(!triggeredPaging && page < actual_count){

			triggeredPaging=1;

			

			data_frm = serialize_form();

			$.ajax({

				  type: "POST",

				  url: "<?php echo base_url().$frm_url;?>",

				  data:data_frm,

				  error: function(res) {

					triggeredPaging = 0;

				  },

				  beforeSend: function(jqXHR, settings){

					$('#loadingdiv').show();

				  },

				  success: function(res) {

					  

					$('#loadingdiv').hide();

					$("#prodListingContainer").append(res);

					triggeredPaging = 0;
					//console.log(res);
					$('.listpager').fadeTo(500, 0.5, function() {
					  $(this).fadeTo(100, 1.0);
					});
				  }
				});
		  }
		}
});
</script>
<?php $this->load->view('bottom_application'); ?>