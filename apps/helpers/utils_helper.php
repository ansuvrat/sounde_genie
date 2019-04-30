<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

/**

* The global CI helpers */



if ( ! function_exists('CI'))

{

	function CI()

	{

		if (!function_exists('get_instance')) return FALSE;

		

		$CI = &get_instance();		

		return $CI;

	}

}



if ( ! function_exists('getDateFormat')){	



	function getDateFormat($date,$format,$seperator1=",")

	{

		switch($format)

		{

			case 1: // (Ymd)->(dmY) 06 Dec, 2010 

				$arr_date=explode($seperator1,$date);			 

				$arr_date=strtotime($arr_date[0]);

				return $ret_date=date("d M".$seperator1." Y",$arr_date);           

			break;

		

			case 2: // (Ymd)->(dmY) 06 December, 2010

				$arr_date=explode($seperator1,$date);			 

				$arr_date=strtotime($arr_date[0]);

				return $ret_date=date("d F".$seperator1." Y",$arr_date);           

			break;

			

			case 3: // (Ymd)->(dmY) Mon Dec 06, 2010 

				$arr_date=explode($seperator1,$date);			 

				$arr_date=strtotime($arr_date[0]);

				return $ret_date=date("D M d".$seperator1." Y",$arr_date);           

			break;

			

			case 4: // (Ymd)->(dmY) Monday December 06, 2010 

				$arr_date=explode($seperator1,$date);			 

				$arr_date=strtotime($arr_date[0]);

				return $ret_date=date("l F d".$seperator1." Y",$arr_date);           

			break;

			

			case 5: // (Ymd)->(dmY) Monday December 06, 2010, 03:04:00 

				

				$arr_time1=explode(" ",$date);			 

				$arr_date=strtotime($date);

				return $ret_date=date("l F d".$seperator1." Y".$seperator1." h:i:s",$arr_date);

				break;

			

			case 6: // (Ymd)->(dmY) Monday December 06, 2010, 15:03:PM 

				$arr_time1=explode(" ",$date);			 

				$arr_date=strtotime($date);

				return $ret_date=date("l F d".$seperator1." Y".$seperator1." H:i:A",$arr_date);           

			break;

			

			case 7: // (Ymd)->(dmY) Monday December 06, 2010, 15:03:PM 

				$arr_time1=explode(" ",$date);			 

				$arr_date=strtotime($date);

				return $ret_date=date("d M".$seperator1." Y".$seperator1." H:i:A",$arr_date);           

			break;

			

			case 8: // (Ymd)->(dmY) Monday December 06, 2010, 03:04:00 

				$arr_time1=explode(" ",$date);			 

				$arr_date=strtotime($date);

				return $ret_date=date("d M".$seperator1." Y".$seperator1." h:i",$arr_date);           

			break;

			case 9: // (Ymd)->(dmY) Monday December 06, 2010, 03:04:00 

				$arr_time1=explode(" ",$date);			 

				$arr_date=strtotime($date);

				return $ret_date=date("d".$seperator1."m".$seperator1."Y h:i",$arr_date);           

			break;

			

			case 10: // (Ymd)->(dmY) Monday December 06, 2010, 03:04:00 

				$arr_time1=explode(" ",$date);			 

				$arr_date=strtotime($date);

				return $ret_date=date("d".$seperator1."m".$seperator1."Y",$arr_date);           

			break;

			

			case 11: // (Ymd)->(dmY) Monday December 06, 2010, 03:04:00 

				$arr_time1=explode(" ",$date);			 

				$arr_date=strtotime($date);

				return $ret_date=date("d".$seperator1."m".$seperator1."Y h:i:sA",$arr_date);           

			break;



			

		}

		return date("d/m/Y",strtotime($date));

		//return $ret_date;

	}

}





if ( ! function_exists('humanTiming'))

{	

	function humanTiming($time)

	{

		$CI = CI();

		$p="";

		$currtent_time = strtotime($CI->config->item('config.date.time'));

		

		$diff = (int) abs( $currtent_time - $time); 

		

		$tokens = array(

			31536000 => lang('year'),

			2592000 => lang('month'),

			604800 => lang('weeks'),

			86400 => lang('day'),

			3600 => lang('hour'),

			60 => lang('minute'),

			1 => lang('second')

		);

		foreach ($tokens as $unit => $text) {

			if ($diff < $unit) continue;

			$numberOfUnits = round($diff / $unit);

			return $p= $numberOfUnits.' '.$text.(($numberOfUnits>1)?'s':'');

		}

		return ($p=='' ? '1 seconds' : $p);

		

	}

}





/************************************************************

1.Convert Nested Array to Single Array

2.If $key is not empty then key will be preserved but 

value will be overwrite if occur more than once



************************************************************/



if ( ! function_exists('array_flatten'))

{

	function array_flatten($array,$return,$key='')

	{

		if(is_array($array))

		{

			foreach($array as $ky=>$val)

			{

				$key=($key!=='' ? $ky : '');

				

				$return = array_flatten($val,$return,$key);

			}

		}else

		{

			if($key!='')

			{

				$return[$key]=$array;

			}else

			{

				$return[]=$array;

			}

		}

		return $return;

	} 

}



/*

find one array 

$arr1 =  array('0'=>'1','1'=>'2')

$arr2 =  = array('1' =>'Boarding Job','2' =>'Night Job','3'=>'Daily Job');

$result ==> Boarding Job,Night Job

*/ 

function getArrayValueBykey($arr1,$arr2)

{

    $res =array();

	if( is_array($arr1) && is_array($arr2) ){

		

		foreach($arr1 as $key=>$val){

			

		  if($val!="" )

		  {

			  

		    $res[] = $arr2[$val];

			

		   }

		  		

		}		

	

	}

	

  return $res;

}





if ( ! function_exists('getAge'))

{

	function getAge($dob)

	{

		$age = 31536000;  //days secon 86400X365

		$birth = strtotime($dob); // Start as time

		$current = strtotime(date('Y')); // End as time

		if($current > $birth)

		{

			$finalAge = round(($current - $birth) /$age)+1;

		}

		return $finalAge;

	}

}





//$in_string = " hi  this dkmphp  net india  wenlink india  development fun company php delhi";

//$spam_word_arr = array('php','net','fun');



if ( ! function_exists('check_spam_words'))

{

	function check_spam_words($spam_word_arr,$in_string)

	{

		$is_spam_found = false;

		if( is_array($spam_word_arr) && $in_string!="" )

		{ 

			foreach($spam_word_arr as $val)

			{   

				if( preg_match("/\b$val\b/i",$in_string) )

				{

					$is_spam_found = true;

					break;

				}

			}

		}

		return $is_spam_found;

	}

}



if ( ! function_exists('file_ext'))

{

	function file_ext($file)

	{

		$file_ext = strtolower(strrchr($file,'.'));

		$file_ext = substr($file_ext,1);

		return $file_ext;

	}

}





if ( ! function_exists('applyFilter'))

{

	function applyFilter($type,$val)

	{

		switch($type)

		{

			case 'NUMERIC_GT_ZERO':

				$val=preg_replace("~^0*~","",trim($val));

				return preg_match("~^[1-9][0-9]*$~i",$val) ? $val : 0;

			break;

			case 'NUMERIC_WT_ZERO':

				return preg_match("~^[0-9]*$~i",trim($val)) ? $val : -1;

			break;

		}

	}

}



if( ! function_exists('removeImage'))

{

	function removeImage($cfgs)

	{	

		if($cfgs['source_dir']!='' && $cfgs['source_file']!='')

		{

			$pathImage=UPLOAD_DIR."/".$cfgs['source_dir']."/".$cfgs['source_file'];

			if(file_exists($pathImage))

			{

				unlink($pathImage);

			}

		}

	}	

}





if( ! function_exists('trace'))

{

	function trace()

	{

		list($callee) = debug_backtrace();

		$arguments = func_get_args();

		$total_arguments = count($arguments);



		echo '<fieldset style="background: #fefefe !important; border:3px red solid; padding:5px; font-family:Courier New,Courier, monospace;font-size:12px">';

	    echo '<legend style="background:lightgrey; padding:6px;">'.$callee['file'].' @ line: '.$callee['line'].'</legend><pre>';

	    $i = 0;

	    foreach ($arguments as $argument)

	    {

			echo '<br/><strong>Debug #'.(++$i).' of '.$total_arguments.'</strong>: ';



			if ( (is_array($argument) || is_object($argument)) && count($argument))

			{

				print_r($argument);

			}

			else

			{

				var_dump($argument);

			}

		}



		echo '</pre>' . PHP_EOL;

		echo '</fieldset>' . PHP_EOL;

	

	}

}



if( ! function_exists('find_paging_segment'))

{ 

	 function find_paging_segment($debug=FALSE)

	 {

		 $ci=  CI();

		 $segment_array = $ci->uri->segments;

		 

		 if($debug)

		 {

		   trace($ci->uri->segments);

		 }

		 

		 $key =  array_search('pg',$segment_array);

		

		return $key+1;

		 

	 } 

}







if ( ! function_exists('make_missing_folder'))

{

	function make_missing_folder($dir_to_create="")

	{

		if(empty($dir_to_create))

		return;

			

		$dir_path=UPLOAD_DIR;

		$subdirs=explode("/",$dir_to_create);

		foreach($subdirs as $dir)

		{

		  if($dir!="")

		  {

			  $dir_path = $dir_path."/".$dir;	

			  if(!file_exists($dir_path) )

			  {

					//echo $dir_path;

					mkdir($dir_path,0755);

			  }else

			  {

				   chmod($dir_path,0755);

			  }

			  

		  }

		}

	}

}



if ( ! function_exists('char_limiter'))

{

  function char_limiter($str,$len,$suffix='...')

  {

	  $str = strip_tags($str);

	  if(strlen($str)>$len)

	  {

		  //$str=substr($str,0,$len,'utf-8').$suffix;

		   $str = mb_substr($str,0,$len,'utf-8');

	  }

	  return $str;

  }

}  



if ( ! function_exists('redirect_top'))

{

	function redirect_top($url='')

	{

			if(!strpos($url,'ttp://') && !strpos($url,'ttps://') && ($url!='') ) $url=base_url().$url;			

			if($url==''):

			?>

			<script>

			 top.$.fancybox.close();

			 window.top.location.reload();

			</script>

			<?php

			else:			

			?>

			<script>

			 top.$.fancybox.close();

			 window.top.location.href="<?php echo $url?>";

			</script>

			<?php

			endif;

			exit;

	}

}



if ( ! function_exists('confirm_js_box'))

{	

	function confirm_js_box($txt='delete')

	{		

		$var = "onclick=\"return confirm('Are you sure you want to $txt this record');\" ";

	    return $var;	

	}

}







  if( ! function_exists('getMeta'))

  {

	function getMeta()

	{

		$CI=CI();

		$uri_page = $CI->uri->uri_string!='' ? $CI->uri->uri_string : "home";	

		$default_txt = $CI->site_setting['company_name'];

		if($_SERVER['QUERY_STRING']!='')

		{

			 $uri_page.="?".$_SERVER['QUERY_STRING'];

		}

		

		$res=$CI->db->query("SELECT * FROM tbl_meta_tags WHERE page_url='".$uri_page."' ")->row();

		

		if( is_object($res) )

		{

			return array(

			

				"meta_title"=>$res->meta_title,

				"meta_keyword"=>$res->meta_keyword,

				"meta_description"=>$res->meta_description

			 );

									

									

		}else

		{			

				   return array("meta_title"=>$default_txt,

				   "meta_keyword"=>$default_txt,

				   "meta_description"=>$default_txt,

				   'dynamic_meta'=>TRUE );

		}

	}

		

}



function get_coupon_dtl_meta(){

	$ci=&get_instance();

	$ci->load->model('coupons/coupons_model');	

	$couponsId  = (int) $ci->uri->segment(3);	

	$section  =  $ci->uri->segment(2);

	$res="";

	if($section=='coupon_detail' && $couponsId!=''){	

	    $res =  $ci->coupons_model->get_coupon(1,0,array('coupon_id'=>$couponsId,'where'=>"(coupm.media_type ='photo' OR coupm.media_type ='embed' OR coupm.media_type ='video' OR coupm.media_type IS NULL)"));

		return $res;

	}

	return $res;



}





if ( ! function_exists('share_with_box'))

{

	function share_with_box($userId)

	{

		$ci=&get_instance();		

		$box_arr1 = array('public'=>lang('Public'),'friend'=>lang('Friends'),'private'=>lang('Private'));

		return ($box_arr1);

		

	}

}



 if ( ! function_exists('share_with_box_shop'))

{

	function share_with_box_shop($userId)

	{

		$ci=&get_instance();		

		$box_arr1 = array('public'=>'Public','friend'=>'Followers','private'=>'Private');

		return ($box_arr1);

		

	}

} 





if ( ! function_exists('get_site_email'))

{

	function get_site_email()

	{

		$CI = CI( );		

		$CI->db->select('*');

		$CI->db->from('tbl_admin');

		$CI->db->where('admin_id','1');		

		$query = $CI->db->get();

		if($query->num_rows() > 0) return $query->row(); 

	}

}





if ( ! function_exists('get_content')){

	

	function get_content($tbl="tbl_auto_respond_mails",$pageId)

	{

		$CI = CI();	

		

		if( $pageId > 0 )

		{ 

			$res =  $CI->db->get_where($tbl,array('id'=>$pageId))->row();



			if( is_object($res) )

			{

				return $res;

			}

		}

	}

}

if( ! function_exists('multid_array_search'))

{

	function multid_array_search($k,$v,$array)

	{

	   foreach ($array as $key => $val)

	   {

		   if ($val[$k] === $v)

		    {

			   return $key;

		   }

	   }

	   return null;

	}

}


function get_Youtube_Id( $Youtubesource ) { 

  

    $youtube_id = "";

	

    $Youtubesource = trim($Youtubesource);

	

    if(strlen($Youtubesource) === 11) {

		 

        $youtube_id = $Youtubesource;

        return $Youtubesource;

		

		

    }else{

 

        # Try to get all Cases

		

		$pattern1 = '~(?:youtube\.com/(?:user/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})~i';

		$pattern2 = '~http://www.youtube.com/v/([A-Za-z0-9\-_]+).+?|embed\/([0-9A-Za-z-_]{11})|watch\?v\=([0-9A-Za-z-_]{11})|#.*/([0-9A-Za-z-_]{11})~si';

		

        if (preg_match($pattern1, $Youtubesource, $match)) {

			

            $youtube_id = $match[1];

            return $youtube_id;

        }

        # Try to get some other channel codes, and fallback extractor

        elseif(preg_match($pattern2, $Youtubesource, $match)) {

 

            for ($i=1; $i<=4; $i++) {

				

                if (strlen($match[$i])==11) {

					

                    $youtube_id = $match[$i];

                    break;

                }

				

            }

			

            return $youtube_id;

        }

        else {

			

            $youtube_id = "No valid YoutubeId extracted";

			

            return $youtube_id;

        }

    }

} 

