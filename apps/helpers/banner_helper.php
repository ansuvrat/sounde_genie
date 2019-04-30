<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
if ( ! function_exists('get_banner'))
{
	function get_banner($cond=array(),$limit){
		$ci		= &get_instance();
		$where	= @$cond['where'];			
		$ci->db->where('status','1');
		if($where)$ci->db->where($where);
		$ci->db->select('SQL_CALC_FOUND_ROWS *',FALSE);
		$ci->db->order_by('banner_id','random');
		$ci->db->limit($limit,'0');
		$ci->db->from('tbl_banners');
		
		$result=$ci->db->get();	
		//echo_sql();
		if($result->num_rows() > 0){
			return $result->result_array();
		}	
	}
}

function banner_display($cond,$w=50,$h=50,$class='',$prefix="",$suffix="",$limit=""){
	$flag=FALSE;
	$banner = get_banner($cond,$limit);
	
	if(is_array($banner) && !empty($banner)){
		
		$i=0;
		$banner_path=base_url().'uploaded_files/banner/';
		foreach($banner as $key_ban=>$val_ban){
			echo $prefix[$i];
			if($val_ban['banner_image']!="" && file_exists(UPLOAD_DIR."/banner/".$val_ban['banner_image'])){
			?>
	      <a href="<?php echo prep_url($val_ban['banner_url']);?>" target="_blank">
	      	<img src="<?php echo $banner_path.$val_ban['banner_image'];?>" width="<?php echo $w;?>" height="<?php echo $h;?>" class="<?php echo $class;?>" />
	      </a>
      <?php 
			}
			echo $suffix;
			$i++;
		}
	}
	else{
		$flag=TRUE;
	}
	return $flag;
}
 ?>