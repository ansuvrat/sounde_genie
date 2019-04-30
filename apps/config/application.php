<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config['admin_store_name']							= 'Sound Genie';
$config['site_name']								= 'Sound Genie';
$config['site_url']									= 'Sound Genie';

$config['per_page'] 								= 12;
$config['image_upload_limit']						= 5;
$config['bottom.debug'] 							= 0;
$config['site.status']								= '1';

$config['auth.password_min_length']					= '6';
$config['auth.password_force_numbers']				= '0';
$config['auth.password_force_symbols']				= '0';
$config['auth.password_force_mixed_case']			= '0';
$config['admin_id']              					= "1";

$config['allow.imgage.dimension']					= '3000x3000';
$config['allow.file.size']	        				= '99999999999';   //In KB
$config['allow.image.width']						= '3000';
$config['allow.image.height']						= '3000';


$config['demo_data_value_array']= array('14.140.19.35','123.63.161.122','123.63.161.125');
//echo $_SERVER['SERVER_ADDR'];
$config['demo_data_value']= $_SERVER['REMOTE_ADDR']; 

$config['demodataValueMsg'] = "Access Denied !! You are not authorised to make changes at present";

$config['ffmpeg_path'] 								= '/usr/bin/ffmpeg';
//$config['ffmpeg_path'] = 'C:\\ffmpegwin\\bin\\ffmpeg';

$config['allow_video_size']	       					= '100';   //In MB
$config['allow_video_ext']	 						= array('avi','mov','flv','mp4','mpeg','wmv','mpg','mpeg4','3gp');

$config['allow_discount_option']    				= 1;
$config['config.date.time']	        				= date('Y-m-d H:i:s');
$config['config.date']	            				= date('Y-m-d');
$config['admin.path']	           					= 'sitepanel';

$config['analytics_id']	           					= '';
$config['total_product_images']    					= "4";
$config['total_event_images']      					= "4";
$config['allow_browse']            					= "4";
$config['currency_symbol']         					= "Rs.";
$config['currency']         			 			= "INR";
$config['currency_code']         			 		= "INR";

$config['product.best.image.view']          		= "( File should be .jpg, .png, .gif format and file size should not be more then 2 MB (2048 KB)) ( Best image size 800X800 )";

$config['testimonial_post_success']    				= "Thank you for your testimonial to <site_name>. Your message will be posted after review by the <site_name> team.";

$config['exists_user_id']              				= "Email id  already exists. Please use different email id.";
$config['email_not_exist']             				= "Email id does not exist.";
$config['forgot_password_success']     				= "Your password has been send to your email address.Please check your email account.";

$config['register_thanks']            				= "Thanks for registering with <site_name>. We look forward to serving you. ";
$config['register_thanks_activate']   				= "Thanks for registering with <website name>.Please Check your mail account to activate your account on the <website name>. ";

$config['enquiry_success']              			= "Your enquiry has been submitted successfully.We will revert back to you soon.";
$config['feedback_success']             			= "Your Feedback has been submitted successfully.We will revert back to you soon.";
$config['product_enquiry_success']      			= "Your product enquiry  has been submitted successfully.We will revert back to you soon.";
$config['product_referred_success']     			= "This product has been referred to your friend successfully.";

$config['site_referred_success']        			= "Site has been referred to your friend successfully.";
$config['forgot_password_success']      			= "Your password has been send to your email address.Please check your email account.";
$config['exists_user_id']              				= "Email id  already exists. Please use different email id.";
$config['email_not_exist']             				= "Email id does not exist.";

$config['login_failed']             				= "Invalid Username/Password";
$config['newsletter_subscribed']        			= "You have been subscribed successfully for our newsletter service.";

$config['newsletter_already_subscribed']   			= "This Email address already exist.";
$config['newsletter_unsubscribed']         			= "You have been unsubscribed from our newsletter service.";
$config['newsletter_not_subscribe']        			= "You are not the subscribe member of our news letter service.";
$config['newsletter_already_unsubscribed']   		= "You have already un-subscribed the newsletter service.";

$config['testimonial_post_success']     			= "Thank you for your testimonial to <site_name>. Your message will be posted after review by the <site_name> team.";
$config['advertisement_request']          			= "Your advertisement request has been submitted successfully.We will revert back to you soon.";
$config['myaccount_update']               			= "Your account information has been updated successfully.";
$config['myaccount_password_changed']     			= "Password has been changed successfully.";
$config['myaccount_password_not_match']   			= "Old Password does  not match.Please try again.";
$config['member_logout']                  			= "Logout successful.";

$config['wish_list_add']               				= "Product has been added to your wishlist successfully.";
$config['wish_list_delete']            				= "Product has been deleted from your wishlist.";
$config['wish_list_product_exists']    				= "This product already exists in your wishlist.";

$config['cart_add']                  				= "Product has been added to your Shopping Basket.";
$config['cart_quantity_update']      				= "Product quantity has been updated successfully.";
$config['cart_product_exist']        				= "Product is already exist in your cart.";
$config['cart_delete_item']          				= "Product(s) has been deleted successfully.";
$config['cart_empty']                 				= "Basket has been cleared successfully.";
$config['cart_available_quantity']   				= "Maximum available quantity  is <quantity>.You can not add  more then available Quantity.";
$config['shipping_required']         				= "Shipping selection is required.";

$config['payment_success']           				= "Your Order has been placed successfully. A confirmation email and invoice have been sent to your email id";
$config['payment_failed']            				= "Your transaction is canceled.";

$config['min_image_height'] 						= '250';
$config['min_image_width'] 							= '250';
$config["default_country_id"]						= '99';

$config['catimgarr']  = array(
                               '1'=>7,
							   '2'=>7,
							   '3'=>7,
							   '4'=>7,
							   '5'=>7,
							   '6'=>7,
							   '7'=>7,
							   '11'=>7	
							 );
$config['catlparr']=array('1','4',5);

$config['hearfor']  = array(
                               '1'=>'Form Google',
							   '2'=>'From Social Media',
							   '3'=>'From Newspaper'
							 );
							
$config['tasktyprArr']=array(
                             '1'=>'Sound Recording',
							 '2'=>'Sound Designing',
							 '3'=>'Virtual Instrument',
							 '4'=>'Single Lyrics',
							 '5'=>'Full Album Lyrics',
							 '6'=>'Mixing',
							 '7'=>'Single Song Mastering',
							 '8'=>'Full Album Mastering',
							 '9'=>'Live Instrument',
							 '10'=>'Company Sound Design'
							);							 

							 