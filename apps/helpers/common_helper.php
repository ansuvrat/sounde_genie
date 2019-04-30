<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * The global CI helpers
 */
if ( ! function_exists('CI'))
{
	function CI()
	{
		if (!function_exists('get_instance')) return FALSE;
		$CI = &get_instance();
		return $CI;
	}
}

if (!function_exists('common_dropdown')) {

	function common_dropdown($name, $selval, $tbl_arr, $extra = '', $stval = '', $multiselect = FALSE) {

		$CI = CI();
		$select_fld = $tbl_arr['select_fld'];
		$tbl_name = $tbl_arr['tbl_name'];
		$where = $tbl_arr['where'];
		$fld_arr = explode(",", $select_fld);
		$id = $fld_arr[0];
		$title = $fld_arr[1];
		$query = $CI->db->query("select $select_fld from $tbl_name where 1 $where order by $title");
		$arr = array();
		if ($stval != 'no') {
			if ($stval != '') {
				$arr = array('' => $stval);
			} else {
				$arr = array('' => "Select One");
			}
		}
		if ($query->num_rows() > 0) {

			$res = $query->result();
			foreach ($res as $val) {
				$cid = $val->$id;
				$arr[$cid] = $val->$title;
			}
		}
		return ($multiselect) ? form_multiselect($name, $arr, $selval, $extra) : form_dropdown($name, $arr, $selval, $extra);
		//return form_dropdown($name,$arr,$selval,$extra);
	}
}

if (!function_exists('get_title_by_id')) {

	function get_title_by_id($tbl_name, $getfld, $condarr) {

		if(count($condarr) > 0 && is_array($condarr)) {

			$ci = CI();

			$cond = "where 1";

			foreach ($condarr as $key => $value) {

				$cond .=" and $key='" . $value . "'";

			}

			$qry = $ci->db->query("select `$getfld` from $tbl_name $cond");

			// echo $ci->db->last_query();exit;



			if ($qry->num_rows() > 0) {



				$res = $qry->row();

				return $res->$getfld;

			}

		}

	}



}


if (!function_exists('substring')) {

	function substring($string, $len) {

		$string = strip_tags($string);
		$string = character_limiter($string, $len, '...');
		return $string;
	}
}



if (!function_exists('get_banners')) {

	function get_banners($position='0', $limit='1')
	{

		$CI = CI();
		$CI->db->select("ban_image,url");
		$CI->db->where("ban_type",'0');
		$CI->db->where("status",'1');
		$CI->db->where("banr_postion",$position);
		$CI->db->order_by('disp_order');
		$CI->db->limit($limit);
		$qry=$CI->db->get('tbl_banners');
		$res=array();
		if($qry->num_rows() > 0)
		{
			$res=$qry->result_array();

		}

		return $res;

	}



}



if (!function_exists('get_cms_page')) {



	function get_cms_page($Id)

	{

		$CI = CI();

		$CI->db->select("page_name,page_description,page_short_description");

		$CI->db->where("status",'1');

		$CI->db->where("page_type",'1');

		$CI->db->where("page_id",$Id);

		$qry=$CI->db->get('tbl_cms_pages');

		$res=array();

		if($qry->num_rows() > 0)

		{

			$res=$qry->row_array();

		}

		return $res;

	}

}







if(!function_exists('get_expiry_date'))

{

	function get_expiry_date($no_of_days, $rttype = 'DAY')

	{

		$CI = CI();



		$currdate = $CI->config->item('config.date.time');

		$rs = $CI->db->query("SELECT DATE_ADD('" . $currdate . "', INTERVAL $no_of_days $rttype) as expdate ");



		$res = $rs->row_array();



		$expdate = $res['expdate'];

		return $expdate;

	}

}
function CountrySelectBox($varg=array())

{

	$CI = CI();
	$var="";
	/**********************************************************

	 default_text 		=>Default Option Text

	 name 		=> 			Dropdn name

	 id 		=> 			Dropdn id (default to name)

	 format      		=>	all extra attributes for the dpdn(style,class,event...)

	 opt_val_fld     =>      DpDn option value field to be fetched from database

	 opt_txt_fld     =>      DpDn option text field to be fetched from database



	 ***********************************************************/

	$varg['default_text']=!array_key_exists('default_text',$varg) ? "Select Country" : $varg['default_text'];

	$varg['id']=!array_key_exists('id',$varg) ? $varg['name'] : $varg['id'];

	$opt_val_fld=!array_key_exists('opt_val_fld',$varg) ? "country_name" : $varg['opt_val_fld'];

	$opt_txt_fld=!array_key_exists('opt_txt_fld',$varg) ? "country_name" : $varg['opt_txt_fld'];



	$var.='<select name="'.$varg['name'].'" id="'.$varg['id'].'" '.$varg['format'].'>';

	if($varg['default_text']!="")

	{

		$var.='<option value="" selected="selected">'.$varg['default_text'].'</option>';

	}

	$contry_res=$CI->db->query("SELECT * FROM tbl_country WHERE 1 AND status ='1' order by country_name")->result_array();

	foreach($contry_res as $key=>$val)

	{

		if(is_array($varg['current_selected_val']))

		{

			$select_element=in_array($val[$opt_val_fld],$varg['current_selected_val']) ? "selected" : "";

		}else

		{

			$select_element=( $varg['current_selected_val']==$val[$opt_val_fld] ) ? "selected" : "";

		}

		$var.='<option value="'.$val[$opt_val_fld].'" '.$select_element.'>'.ucfirst($val[$opt_txt_fld]).'</option>';

	}

	$var.='</select>';

	return $var;

}





if (!function_exists('get_category_list_by_str')) {

	function get_category_list_by_str($category_id)

	{

		$CI=CI();

		$categories=get_db_multiple_row("tbl_category","cat_name"," id in ($category_id)");

		$cat_name=array();

		$cat_str='';

		if(is_array($categories) && !empty($categories)){

			foreach($categories as $val){

				$cat_name[]=$val['cat_name'];

			}

			$cat_str=implode(",",$cat_name);

		}

		return $cat_str;

	}

}



if (!function_exists('get_product_name_by_str'))

{

	function get_product_name_by_str($product_id)
	{

		$CI=CI();
		$products=get_db_multiple_row("tbl_products","product_name"," products_id in ($product_id)");

		$product_name = array();
		$prd_str      = '';
		
		if(is_array($products) && !empty($products)){

			foreach($products as $val){

				$product_name[]=$val['product_name'];

			}
			$prd_str=implode(", ",$product_name);
		}
		return $prd_str;
	}

}

if (!function_exists('get_next_auto_id')) {


	function get_next_auto_id($tblname, $prefix = 'DOM-') {

		$ci             = CI();
		$ddsql          = $ci->db->query("select DATABASE()");
		$ddres          = $ddsql->row_array();
		$dbname         = $ddres['DATABASE()'];
		$sql            = "SHOW table status from $dbname where name = '" . $tblname . "' ";
		$query          = $ci->db->query($sql);
		$result         = $query->row_array();
		$auto_increment = $prefix.$result["Auto_increment"];
		return $auto_increment;

	}



}





if ( ! function_exists('has_child_nested'))

{

	function has_child_nested($catid,$condtion="AND status='1'")

	{

		$ci = CI();

		$sql="SELECT id FROM tbl_category WHERE parent_id=$catid $condtion ";

		$query 				= $ci->db->query($sql);

		$num_rows     =  $query->num_rows();

		return $num_rows >= 1 ? TRUE : FALSE;

	}

}



if ( ! function_exists('get_nested_dropdown_menu_withoutoptgroup'))

{

	function get_nested_dropdown_menu_withoutoptgroup($parent,$selectId="",$pad="|__")

	{



		$ci = CI();

		$selId =( $selectId!="" ) ? $selectId : "";

		$var="";

		$sql="SELECT * FROM tbl_category WHERE parent_id=$parent AND status='1' ";

		$query=$ci->db->query($sql);

		$num_rows     =  $query->num_rows();

			

		if ($num_rows > 0  )

		{



			foreach( $query->result_array() as $row )

			{

				$cat_name=ucfirst(strtolower($row['cat_name']));

				 

				if ( has_child_nested($row['id']) )

				{

						

					//$var .= '<optgroup label="'.$pad.'&nbsp;'.$cat_name.'" >'.$cat_name.'</optgroup>';

					if(is_array($selectId)){

						$sel=( in_array($row['id'],$selectId) ) ? "selected='selected'" : "";

					}else{

						$sel=( $selectId==$row['id'] ) ? "selected='selected'" : "";

					}



					$var .= '<option value="'.$row['id'].'" '.$sel.'>'.$pad.$cat_name.'  </option>';



					$var .= get_nested_dropdown_menu_withoutoptgroup($row['id'],$selId,'&nbsp;&nbsp;&nbsp;'.$pad);



				}else

				{



					if(is_array($selectId)){

						$sel=( in_array($row['id'],$selectId) ) ? "selected='selected'" : "";

					}else{

						$sel=( $selectId==$row['id'] ) ? "selected='selected'" : "";

					}

					$var .= '<option value="'.$row['id'].'" '.$sel.'>'.$pad.$cat_name.'  </option>';

						

				}

			}

		}



		return $var;

	}

	 

}



function db_option_value($varg=array()){

	$varg['default_text']=!array_key_exists('default_text',$varg) ? "Select " : $varg['default_text'];

	$opt_val_fld=!array_key_exists('opt_val_fld',$varg) ? "id" : $varg['opt_val_fld'];

	$opt_txt_fld=!array_key_exists('opt_txt_fld',$varg) ? "" : $varg['opt_txt_fld'];

	$cond=!array_key_exists('cond', $varg)?"":$varg["cond"];

	$table_name=!array_key_exists('table_name',$varg) ? "" : $varg['table_name'];

	$orderby=!array_key_exists('orderby',$varg) ? "id ASC" : $varg['orderby'];



	$selected_val=!array_key_exists('current_selected_val',$varg) ? "" : $varg['current_selected_val'];

	$CI = CI();

	$CI->db->select('*');

	if($cond!="")$CI->db->where($cond);

	$CI->db->order_by($orderby);

	$query=$CI->db->get($table_name);



	$option='';

	$arr=array();

	if($varg['default_text']!=""){

		$option .='<option value="">'.$varg['default_text'].'</option>';

	}

	if($query->num_rows() > 0){

		$res=$query->result();

		$opt_txt_fld=explode(",",$opt_txt_fld);

		foreach($res as $val){

			$cid=$val->$opt_val_fld;
			$sel="";
			
			if((is_array($selected_val) && in_array($cid,$selected_val)) || $selected_val==$cid) {
				$sel='selected="selected"';			
			}
			$option .='<option value="'.$cid.'" '.($sel).'>'.char_limiter($val->$opt_txt_fld[0],80).(isset($opt_txt_fld[1])?" ( ".$val->$opt_txt_fld[1]." ) ":"").'</option>';

		}

	}

	return $option;

}

