<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
|--------------------------------------------------------------------------
| Global
|--------------------------------------------------------------------------
*/               

$ci= &get_instance();
$config['site_admin']              	= $ci->config->item("site_name")." Administrator Area";
$config['site_admin_name']         	= $ci->config->item("site_name");
$config['url_suffix'] = '';                  
$config['category.best.image.view'] = "( File should be .jpg, .png, .gif format and file size should not be more then 2 MB (2048 KB)) ( Best image size 280X280 )";
$config['category.best.icon.view']  = "( File should be .jpg, .png, .gif format and file size should not be more then 2 MB (2048 KB)) ( Best image size 340px X 234px )";
$config['product.best.image.view']  = "( File should be .jpg, .png, .gif format and file size should not be more then 2 MB (2048 KB)) ( Best image size 800X1020 )";

$config['header_logo.best.image.view'] = "( File should be .jpg, .png, .gif format and file size should not be more then 1 MB (1024 KB)) ( Best image size 123X81 )";

$config['footer_logo.best.image.view'] = "( File should be .jpg, .png, .gif format and file size should not be more then 1 MB (1024 KB)) ( Best image size 77X51 )";

$config['invoice_logo.best.image.view'] = "( File should be .jpg, .png, .gif format and file size should not be more then 1 MB (1024 KB)) ( Best image size 417X109 )";

$config['pagesize']                	= "50";
$config['total_product_images']    	= "4";

$config['adminPageOpt']    	 		= array( 
										$config['pagesize'],
										2*$config['pagesize'],
										3*$config['pagesize'],
										4*$config['pagesize'],
										5*$config['pagesize']);

$config['bannersz'] =  array(
							 '1'   => "Middle of homepage - Best Size ( 401x334)",
							 '2'   => "Left side of page - Best Size ( 400x334)",
							 '3'   => "Right side of page - Best Size ( 400x334)",
							);	
							
							
$config['hpbannersz'] =  array(
							 '2'   => "Homepage Top Banner - Best Size( 610x282)",
							 '3'   => "Homepage Bottom Banner - Best Size ( 610x282)"
							);								


$config['product_set_as_config'] 	= array(''=>"Product Set As",													
		'featured_product'=>'Featured Products',
		'hot_deals'=>'Hot Products',
		'new_arrival'=>'New Arrival'
		);

$config['product_unset_as_config']		= array(
		''=>"Product Unset As",
		'featured_product'=>'Featured Products',
		'hot_deals'=>'Hot Products',
		'new_arrival'=>'New Arrival'
		);
						

$config['category_set_as_config'] 					= array(''=>"Category Set As",													
		'set_home'=>'Featured Category',
		
		);

$config['category_unset_as_config']					= array(
		''=>"Category Unset As",
		'set_home'=>'Featured Category'
	
		);
 
/* End of file account.php */

/* Location: ./application/modules/sitepanel/config/sitepanel.php */