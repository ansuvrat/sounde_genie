<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**

 * SSL Helpers

 *

 * @author		dkmaurya 

 * @version		1.0

 * @license		MIT License Copyright (c) 2010

 */



// ------------------------------------------------------------------------



if ( ! function_exists('Image_thumb'))

{

	/*	

		

	R - Image Resizing

    C - Image Cropping

    X - Image Rotation

    W - Image Watermarking		

	

	 $config['master_dim']  options = auto, width, height

	 

	 echo $this->image_lib->display_errors();

	 

	 $this->image_lib->display_errors('<p>', '</p>');	 

	 

	 echo get_image('album_images',$row->photo1,200,150,'R'); 

	 R, AR 	 

	  

   */

	

	function Image_thumb($thumb=array(),$perform='R')

	{			

		

		$ci = &get_instance();	

		$ci->load->library('image_lib');

		

			$config['image_library']   =  'gd2';

			$config['create_thumb']    =  TRUE;

			$config['thumb_marker']    =  FALSE;	

			$config['source_image']    =  $thumb['source_path'].$thumb['org_image'];

			$config['width']  =  $thumb['width'];

			$config['height'] =  $thumb['height'];

			$config["quality"]	= isset($thumb['quality'])?$thumb['quality']:"70%";
			$thum_img_name          =   "thumb_".$thumb['width']."_".$thumb['height']."_".$thumb['org_image'];	

			$config['new_image']    =   IMG_CACH_DIR."/".$thum_img_name; 	

			

        if(!file_exists(IMG_CACH_DIR."/".$thum_img_name) )

		{

			if ( $perform=='C')

			{

				

			    list($original_width, $original_height, $file_type, $attr) = @getimagesize($config['source_image']);	

				

				/*	

				use if you want to crop image from centre 

													

			    $crop_x = ($original_width / 2) - ($thumb['width'] / 2);

			    $crop_y = ($original_height / 2) - ($thumb['height'] / 2);			

				$config['x_axis'] = $thumb['width'];

				$config['y_axis'] = $thumb['height'];	

							

				*/	

							

			    $ratio       =  $original_width/$original_height;

				$thumbRatio  =  $thumb['width'] / $thumb['height'];

				

				if( $ratio < $thumbRatio )

				{					

				   $srcHeight        = round($original_height*$ratio/$thumbRatio);				

				   $config['y_axis'] = round(($original_height-$srcHeight)/2);

				

				} else

				{

					

				  $srcWidth          = round($original_width*$thumbRatio/$ratio);

				  $config['x_axis']  = round(($original_width-$srcWidth)/2);

				  

				}

								

				$config['maintain_ratio'] = FALSE;				

				$ci->image_lib->initialize($config); 

		     	$ci->image_lib->crop();

				$ci->image_lib->clear();

			

			}	

			

			if ( $perform=='AR')

			{

			    $config['ar_width']       = $thumb['width']; 

			    $config['ar_height']      = $thumb['height'];	

				$config['maintain_ratio'] = FALSE;	

				$config['master_dim']     = "height";

												

				if ($thumb['width'] > $thumb['height'] )

				{					

				   $config['master_dim'] = "width";

				  

				}			

				$ci->image_lib->initialize($config); 

		     	$ci->image_lib->adaptive_resize();

				$ci->image_lib->clear();

			

			}	

						

			if ( $perform=='R')

			{

				

				list($original_width, $original_height, $file_type, $attr) = @getimagesize($config['source_image']);				 

				$config['width']   = ( $thumb['width'] >=$original_width ) ? $original_width     : $thumb['width'] ;		

				$config['height']  = ( $thumb['height'] >=$original_height ) ? $original_height  : $thumb['height'] ;				

				$config['maintain_ratio'] = TRUE;	

				$ci->image_lib->initialize($config); 

		     	$ci->image_lib->resize();

				$ci->image_lib->clear(); 

			

			}

					   

		}

	   

	}

   	

}





if ( ! function_exists('get_image'))

{

  function get_image($dir="",$image="",$w=50,$h=50,$option='R',$watermark=FALSE,$watermarktext='askidinya')

  {	 

   	 

		$ci  = &get_instance();

		$ci->load->helper(array('thumbnail'));		

		//$the_img = theme_url()."images/noimg1.gif"; 	

		$the_img = base_url()."assets/developers/images/noimg.jpg"; 	

			

	 	if($dir!='')

		{

			    $thumbc                 =  array();				

				$thumbc['width']        =  $w;

				$thumbc['height']       =  $h;

				$thumbc['source_path']  = UPLOAD_DIR.'/'.$dir.'/';					

				$file_path  = UPLOAD_DIR.'/'.$dir."/$image";	

			    

			   if($image!="" && file_exists($file_path))

			   {		   

					$thumbc['org_image']   =   $image;  				

					Image_thumb($thumbc,$option);			

					$cache_file = "thumb_".$thumbc['width']."_".$thumbc['height']."_".$image;

					 $imgbCachePath = UPLOAD_DIR."/thumb_cache/".$cache_file;

					

					if( ($image!='') && ( file_exists($imgbCachePath) ) ) 

					{

						 //$the_img = thumb_cache_url().$cache_file; 
                         if($watermark ==1){
							watermark($imgbCachePath,$watermarktext); 
							//watermark_text($imgbCachePath,'suvrat');
						 }
						 $the_img = thumb_cache_url().$cache_file; 
						

					}

					

			   }

				 else

			   {

				   		

					$thumbc                 =  array();				

					$thumbc['width']        =  $w;

					$thumbc['height']       =  $h;

					$thumbc['source_path']  =  FCROOT."assets/developers/images/";	

					$thumbc['org_image']    =  "noimg.jpg";  				

					Image_thumb($thumbc,$option);			

					$cache_file = "thumb_".$thumbc['width']."_".$thumbc['height']."_".$thumbc['org_image'];

					$imgbCachePath = UPLOAD_DIR."/thumb_cache/".$cache_file;
                 
					

					if(  file_exists($imgbCachePath)  ) 

					{

						  $the_img = thumb_cache_url().$cache_file; 

						

					}

				   

			   }

			   

		 }

		 

	   return $the_img;

	

	}

	

	
   
    function watermark($filename,$textname='askidinya'){
		    
			$ci  = &get_instance();
		    $ci->load->library("image_lib");
			
			$config["manipulation"]['source_image'] = $filename;
			$config["manipulation"]['wm_type'] = 'overlay';
			$config["manipulation"]['wm_opacity']        = 50;
			$config["manipulation"]['wm_overlay_path'] = UPLOAD_DIR.'/watermark.png';
			
			$config["manipulation"]['wm_vrt_alignment'] = 'bottom';
			$config["manipulation"]['wm_hor_alignment'] = 'right';
			
			$ci->image_lib->initialize($config["manipulation"]);
			$ci->image_lib->watermark();
			
			$fontsize = 13;
			$image_cfg['source_image']   = $filename;
			$image_cfg['wm_text']        = $textname;
			$image_cfg['wm_type']        = 'text';
			$image_cfg['wm_font_path']   = FCROOT.'codeigniter/fonts/texb.ttf';
			$image_cfg['wm_font_size']   = $fontsize;
			$image_cfg['wm_font_color']  = 'ffffff';
			//$image_cfg['wm_vrt_alignment'] = $vrt_align;
			//$image_cfg['wm_hor_alignment'] = $hrt_align;
			//$image_cfg['wm_padding'] = '20';
			//$image_cfg['rotation_angle'] = 270;		
			$image_cfg['create_thumb'] = FALSE;
			$ci->image_lib->initialize($image_cfg);
			$ci->image_lib->watermark();
			$ci->image_lib->clear();	
	}
	
	
	function watermark_text($filename,$textname='askidinya'){
		    
		$ci = &get_instance();
		$ci->load->library('image_lib');
		//echo $filename;exit;	
		//$img_dim_arr = getimagesize($filename);
		//$img_w = $img_dim_arr[0];
		//trace($img_dim_arr);
		$fontsize = 13;
		$image_cfg['source_image']   = $filename;
		$image_cfg['wm_text']        = $textname;
		$image_cfg['wm_type']        = 'text';
		$image_cfg['wm_font_path']   = FCROOT.'codeigniter/fonts/texb.ttf';
		$image_cfg['wm_font_size']   = $fontsize;
		$image_cfg['wm_font_color']  = 'ffffff';
		//$image_cfg['wm_vrt_alignment'] = $vrt_align;
		//$image_cfg['wm_hor_alignment'] = $hrt_align;
		//$image_cfg['wm_padding'] = '20';
		//$image_cfg['rotation_angle'] = 270;		
		$image_cfg['create_thumb'] = FALSE;
		$ci->image_lib->initialize($image_cfg);
		$ci->image_lib->watermark();
		$ci->image_lib->clear();
	
	}
	

	



} 



/* End of file thumbnail_helper.php */

/* Location: ./application/helpers/thumbnail_helper.php */