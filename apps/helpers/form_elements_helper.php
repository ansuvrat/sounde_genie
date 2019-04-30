<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
/* Created by Anand */

function db_drop_down($tbl_name,$condition,$varg=array())
{	
	$CI = CI();	
	$var="";	
	$varg['default_text']=!array_key_exists('default_text',$varg) ? "Select" : $varg['default_text'];
	$varg['id']=!array_key_exists('id',$varg) ? $varg['name'] : $varg['id'];
	$opt_val_fld = $varg['opt_val_fld'];
	$opt_txt_fld = $varg['opt_txt_fld']; 
	
	$var.='<select name="'.$varg['name'].'" id="'.$varg['id'].'" '.$varg['format'].'>';
	if($varg['default_text']!="")
	{
		$var.='<option value="" selected="selected">'.$varg['default_text'].'</option>';
	}	
	
	$CI->db->select("$opt_val_fld,$opt_txt_fld");
	$CI->db->from("$tbl_name");
	if(!empty($condition))
	$CI->db->where($condition);

	if(isset($varg["orderby"]) && !empty($varg["orderby"])){
		$CI->db->order_by($varg["orderby"]);
	}
	
	$contry_res=$CI->db->get()->result_array();
	
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






if(!function_exists('gender_radio_group'))
{
	function gender_radio_group($varg=array())
	{
		$_defaults = array('name'=>'gender',
						   'id'=>'gender',
						   'current_selected_val'=>'M',
						   'format'=>''
						   );
						   
		$controls_param = array_merge($_defaults,$varg);
						   
		$ci = &get_instance();
		
		$gender_list = $ci->config->item('gender');
		
		foreach($gender_list as $gen_key=>$gen_val)
		{
			$is_checked = ($controls_param['current_selected_val'] == $gen_key) ? 'checked="checked"' : '';
			?>
			 <label>
             <input name="<?=$controls_param['name'];?>" id="<?=$controls_param['id'];?>" type="radio" value="<?php echo $gen_key;?>" <?php echo $is_checked;?> <?php echo $controls_param['format'];?>>
             <?php echo $gen_key;?></label>
            &nbsp;
            <?php
		}
	}
}



function CitySelectBox($varg=array())
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
	$varg['default_text']=!array_key_exists('default_text',$varg) ? "Select City" : $varg['default_text'];
	$varg['id']=!array_key_exists('id',$varg) ? 'title' : $varg['id'];
	$opt_val_fld=!array_key_exists('opt_val_fld',$varg) ? "title" : $varg['opt_val_fld'];
	$opt_txt_fld=!array_key_exists('opt_txt_fld',$varg) ? "title" : $varg['opt_txt_fld']; 
	$condition=!array_key_exists('cond',$varg) ? "":"and ".$varg['cond']; 
	
	
	$var.='<select name="'.$varg['name'].'" id="'.$varg['id'].'" '.$varg['format'].'>';
	if($varg['default_text']!="")
	{
		$var.='<option value="" selected="selected">'.$varg['default_text'].'</option>';
	}	
	$contry_res=$CI->db->query("SELECT * FROM tbl_city WHERE status ='1'  $condition")->result_array();
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