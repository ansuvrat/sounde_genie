<script type="text/javascript" src="<?php echo base_url();?>assets/jquery_ui_flick/jquery-ui-1.8.18.custom.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/jquery_ui_flick/jquery-ui-timepicker-addon.js"></script>
<link rel="stylesheet" href="<?php echo base_url();?>assets/jquery_ui_flick/jquery-ui-1.8.18.custom.css">
<div id="delete_confirm_dialog" title="Confirmation Required" style="display:none;">
  Are you sure to delete this ?
</div>

<script type="text/javascript">
  $(document).ready(function() {
    $("#delete_confirm_dialog").dialog({
      autoOpen: false,
      modal: true
    });

  $(".confirm_delete").live('click',function(e) {
    e.preventDefault();
    var targetUrl = $(this).attr("href");

    $("#delete_confirm_dialog").dialog({
      buttons : {
        "Confirm" : function() {
          window.location.href = targetUrl;
        },
        "Cancel" : function() {
          $(this).dialog("close");
        }
      }
    });

    $("#delete_confirm_dialog").dialog("open");
  });
  }); // end of $(document).ready


$(function() {
	$( ".datepicker").attr("readonly","readonly").datepicker({
		showOn: "both",
		buttonImage: "<?php echo theme_url();?>images/clndr.png",
		dateFormat: 'yy-mm-dd',
		changeMonth: true,
		changeYear: true,
		defaultDate: 'y',
		buttonText:'Pick a date',
		yearRange: "c-20:c+20",
		buttonImageOnly: true
	});
});


$(function() {
	$( ".meetgreetarvdatepicker").attr("readonly","readonly").datepicker({
		showOn: "both",
		buttonImage: "<?php echo theme_url();?>images/clndr.png",
		dateFormat: 'yy-mm-dd',
		changeMonth: true,
		changeYear: true,
		defaultDate: 'y',
		buttonText:'Pick a date',
		minDate:'<?php echo date('Y-m-d',strtotime(date('Y-m-d',time())));?>',
		maxDate:'<?php echo date('Y-m-d',strtotime(date('Y-m-d',time())."18 years"));?>',
		yearRange: "c-20:c+20",
		buttonImageOnly: true,
		onSelect: function(dateText, inst) {
				
				//chaeckflight(dateText);

			}
	});
});


$(function() {
	$( ".meetgreetdeptdatepicker").attr("readonly","readonly").datepicker({
		showOn: "both",
		buttonImage: "<?php echo theme_url();?>images/clndr.png",
		dateFormat: 'yy-mm-dd',
		changeMonth: true,
		changeYear: true,
		defaultDate: 'y',
		buttonText:'Pick a date',
		minDate:'<?php echo date('Y-m-d',strtotime(date('Y-m-d',time())));?>',
		maxDate:'<?php echo date('Y-m-d',strtotime(date('Y-m-d',time())."18 years"));?>',
		yearRange: "c-20:c+20",
		buttonImageOnly: true,
		onSelect: function(dateText, inst) {
				
				//dchaeckflight(dateText);

			}
	});
});

$(function() {
	if($( ".datetimepicker").length){
	$( ".datetimepicker").attr("readonly","readonly").datetimepicker({
		showOn: "button",
		buttonImage: "<?php echo theme_url();?>images/clndr.png",
		dateFormat: 'yy-mm-dd',
		timeFormat: 'hh:mm',
		changeMonth: true,
		changeYear: true,
		defaultDate: 'y',
		buttonText:'Pick a date',
		yearRange: "c-20:c+20",
		buttonImageOnly: true,
		ampm:true
	});
	}
});

$(function() {
	if($( ".istart_date").length){
	$( ".istart_date").attr("readonly","readonly").datetimepicker({
		showOn: "both",
		buttonImage: "<?php echo theme_url();?>images/clndr.png",
	//	buttonImage: "<?php echo theme_url();?>images/calendar.jpg",
		dateFormat: 'yy-mm-dd',
		timeFormat: 'hh:mm',
		changeMonth: true,
		changeYear: true,
		defaultDate: 'y',
		buttonText:'Pick a date',
		minDate:'<?php echo date('Y-m-d',strtotime(date('Y-m-d',time())));?>',
		maxDate:'<?php echo date('Y-m-d',strtotime(date('Y-m-d',time())."18 years"));?>',
		yearRange: "c-20:c+20",
		buttonImageOnly: true,
		ampm:true
	});
	}
});

$(function() {
	if($( ".today_or_less").length){
	$( ".today_or_less").attr("readonly","readonly").datepicker({
		showOn: "both",
		buttonImage: "<?php echo theme_url();?>images/clndr.png",
		dateFormat: 'yy-mm-dd',
		changeMonth: true,
		changeYear: true,
		defaultDate: 'y',
		buttonText:'Pick a date',
		minDate:'<?php echo date('Y-m-d',strtotime(date('Y-m-d',time())."-100 years"));?>',
		maxDate:'<?php echo date('Y-m-d',time());?>',
		yearRange: "c-100:c+100",
		buttonImageOnly: true,
		onClose: function(dateText, inst) { 
		var dateObject = $(".today_or_less").datepicker("getDate"); // get the date object
		var dateString = new Date(dateObject.getFullYear(),dateObject.getMonth(),dateObject.getDate());// Y-n-j in php date() format
		var date=$.datepicker.formatDate('d MM yy',dateString);
		$('#datepicker_date').text(date);
		//alert(date); 
		}

	})}});


$(function() {
	if($( ".dob").length){
	$( ".dob").attr("readonly","readonly").datepicker({
		showOn: "button",
		buttonImage: "<?php echo theme_url();?>images/clndr.png",
		dateFormat: 'yy-mm-dd',
		changeMonth: true,
		changeYear: true,
		defaultDate: 'y',
		buttonText:'Pick a date',
		minDate:'<?php echo date('Y-m-d',strtotime(date('Y-m-d',time())."-100 years"));?>',
		maxDate:'<?php echo date('Y-m-d',strtotime(date('Y-m-d',time())."-18 years"));?>',
		yearRange: "c-100:c+100",
		buttonImageOnly: true,
		onClose: function(dateText, inst) { 
		var dateObject = $(".dob").datepicker("getDate"); // get the date object
		var dateString = new Date(dateObject.getFullYear(),dateObject.getMonth(),dateObject.getDate());// Y-n-j in php date() format
		var date=$.datepicker.formatDate('d MM yy',dateString);
		$('#datepicker_date').text(date);
		//alert(date); 
		}

	});
	}
});


</script>
<style>
.ui-datepicker-trigger
{
	margin-left:1px;
	margin-right:2px;
	margin-top:2px;
	position:absolute;
	cursor:pointer;
}
</style>