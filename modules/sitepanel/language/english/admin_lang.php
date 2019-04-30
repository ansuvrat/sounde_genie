<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');



/*

|--------------------------------------------------------------------------

| Global

|--------------------------------------------------------------------------

*/


$lang['activate']             = "Record has been activated successfully.";
$lang['deactivate']           = "Record has been de-activated successfully.";

$lang['deleted']              = "Record has been deleted successfully.";

$lang['successupdate']        = "Record has been updated successfully.";

$lang['order_updated']        = "Record(s) has been re-ordered.";

$lang['password_incorrect']   = "The Old Password is incorrect";

$lang['recordexits']          = "Record address already exists.";

$lang['success']              = "Record added successfully.";

$lang['paysuccess']           = "Payment added successfully.";

$lang['admin_logout_msg']     = "Logout successfully ..";

$lang['admin_mail_msg']       = "Mail sent Successfully...";

$lang['forgot_msg']           = "Email Id does not exist in database";

$lang['admin_reply_msg']      = "Enquiry reply sent Successfully...";

$lang['pic_uploaded']         = 'Photos has been uploaded successfully.';

$lang['pic_uploaded_err']	  = 'Please upload at least one photo.';

$lang['pic_delete']	= 'Photo has been deleted successfully.';



$lang['child_to_deactivate']  =  "The selected record(s) has some sub-category/product.Please de-activate them first";

$lang['child_to_activate']=  "The selected record(s) has some sub-category/product.Please activate them first";

$lang['child_to_delete']  =  "The selected record(s) has some sub-category/ads.Please delete them first";





$lang['marked_paid']           = "The selected record(s) has been marked as Paid";
$lang['payment_succeeded']     = "The payment has been made successfully.";
$lang['payment_failed']        = "The payment has been canceled.";
$lang['email_sent']	     	   = "The Email has been sent successfully to the selected Users/Members.";
$lang['setsearch']			   = "Selected fields have been set for search field successfully.";
$lang['unsetsearch']		   = "Selected fields have been unset for search field successfully.";	
$lang['expired']			   = "Selected ads have been expired successfully."; 
$lang['unexpired']		       = "Selected ads have been unexpired successfully."; 
$lang['set_in_group']		   = "Selected members have been added in group successfully."; 
$lang['operation_not_allowed'] = "OOPS!! Operation not allowed for selected record."; 

$lang['top_menu_list'] = array( "Dashboard"=>"sitepanel/dashbord/",
  
  "Category"=>    array( "Manage Categories"        => "sitepanel/category/",
                          "Manage Products"      => "sitepanel/products",
						  "Manage Color"         => "sitepanel/color",
						  "Manage Size"         => "sitepanel/managesize",
							 "Manage Brand"         => "sitepanel/managebrand"
							),
  
  "Member" =>        array( 
                             "Manage Member" => "sitepanel/members/",
                           ),
  "Order" =>        array( 
                            "Manage Order" => "sitepanel/orders/",
                           ),						   
  "Coupon" =>        array( "Manage Coupon" => "sitepanel/coupon/"
                           ),
  "Location" =>        array( "Manage State" => "sitepanel/location/state/"
                           ),						   						   							
  "Other"  =>array(           
							"Static Pages"      => "sitepanel/staticpages/",
							"Manage Homepage Banner"     => "sitepanel/homepagebanner/" ,
							"Manage Faq"        => "sitepanel/faq/" ,
							"Manage Newsletter" => "sitepanel/newsletter/" ,
							"Contact us Enquiry"           => "sitepanel/enquiry/" , 
							"Manage Testimonial"=> "sitepanel/testimonial/" , 	 
							"Manage  Meta Tags" => "sitepanel/meta/"   , 
							"Admin Settings"    => "sitepanel/setting/"                      
                      ),
                    
                    
 );	
 	
$lang['top_menu_icon'] = array(   
								"Category"   => "products.png", 
								"Member"     => "manage-sec.png",  					  	
								"Manage Sound"     => "order2.png",
								"Instruments"      => "order2.png",
								"Order"      => "order2.png",
								"Recording"      => "order2.png",
								"Company/Member Sound Production" => "order2.png",
								"Sound Design"      => "order2.png",
								"Music Production"      => "order2.png",
								"Company Music Production"      => "order2.png",
								"Enquiry"      => "order2.png",
								"Newsletter" => "news-lt-.png",  
								"Manage Prices"   => "management.png", 
								"Other"      => "management.png",
								);		  



/* Location: ./application/modules/sitepanel/language/admin_lang.php */