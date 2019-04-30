<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('CI'))
{
	function CI()
	{
		if (!function_exists('get_instance')) return FALSE;
		$CI =& get_instance();
		return $CI;
	}
}


function get_section_data($admin_id,$admin_type,$parent_id=0)
{
	$ci = CI();
	if($admin_type==1)
	{
		$sql="select * from tbl_admin_sections where 1 and parent_id='".$parent_id."' order by disp_order";	
	}
	else
	{
		if($parent_id>0)
		{
			$sql="select asec.* from tbl_admin_sections as asec JOIN  tbl_admin_allowed_sections as sasec ON asec.id=sasec.sec_id where 1 and asec.parent_id='".$parent_id."' and sasec.subadmin_id='".$admin_id."' order by disp_order";
		}
		else
		{
			$sql="select asec.* from tbl_admin_sections as asec JOIN  tbl_admin_allowed_sections as sasec ON asec.id=sasec.sec_parent_id where 1 and asec.parent_id='".$parent_id."' and sasec.subadmin_id='".$admin_id."' group by asec.id order by asec.disp_order asc";	
		}
	}
	
	$qry=$ci->db->query($sql);
	
	if($qry->num_rows() > 0)
	{
		$res=$qry->result_array();
		return $res;	
	}
	
}


if ( ! function_exists('admin_pagination'))
{
	function admin_pagination($base_uri, $total_rows, $record_per, $uri_segment,$refresh = FALSE)
	{
			$ci = CI();			
			$config['per_page']			= $record_per;
		  $config['num_links']        = 8;	
			$config['next_link']        = 'Next';
			$config['prev_link']        = 'Prev';	 	  
			$config['total_rows']		= $total_rows;
		    $config['uri_segment']		= $uri_segment;		
			$ci->load->library('pagination');		
			$config['cur_tag_open']	= '&nbsp;<strong>';
		    $config['cur_tag_close']	    = '</strong>';
			$config['page_query_string']	= TRUE;
			$config['base_url']             = $base_uri;
			$ci->pagination->initialize($config);
			$data = $ci->pagination->create_links();		
		 
		   return $data;	
		  
	}
}


function display_record_per_page()
{	
$ci = CI();
$post_per_page =  $ci->input->get_post('pagesize');

?>

<select name="pagesize" id="pagesize" class="p1" style="width:60px;" onchange="this.form.submit();">
    <?php
    foreach($ci->config->item('adminPageOpt') as $val)
    {
		
    ?>
    <option value="<?php echo $val;?>" <?php echo $post_per_page==$val ? "selected" : "";?>>
	  <?php echo $val;?></option>
    <?php
    }
    ?>
</select>

<?php
}
if ( ! function_exists('admin_category_breadcrumbs'))
{
	function admin_category_breadcrumbs($catid,$segment='')
	{
		$link_cat=array();	
		$ci = CI();		  
		$sql="SELECT category_name,category_id,parent_id
		FROM tbl_categories WHERE category_id='$catid' AND status='1' ";		 
		$query=$ci->db->query($sql);		
		$num_rows     =  $query->num_rows();
		$segment      = $ci->uri->segment($segment,3);
			 
		  if ($num_rows > 0)
		  {
			 			  
				  foreach( $query->result_array() as $row )
				  {
							 
						if ( has_child( $row['parent_id'] ) )
						{
								
								$condtion_product   =  "AND category_id='".$row['category_id']."'";				
								$product_count      = count_products($condtion_product);
								
								if($product_count>0)
								{
									$link_url = base_url()."sitepanel/products?category_id=".$row['category_id'];
									
								}else
								{							
									$link_url = base_url()."sitepanel/category/index/".$row['category_id'];								
								}
								
								if( $segment!='' && ( $row['category_id']==$segment ) )
								{
									
									$link_cat[]=' <span class="pr2 fs14">»</span> '.$row['category_name'];
									
								}else
								{
									
								  $link_cat[]=' <span class="pr2 fs14">»</span> <a href='.$link_url.'>'.$row['category_name'].'</a>';
								  
								}
								
								$link_cat[] = admin_category_breadcrumbs($row['parent_id'],$segment);
							 
						  }else
						  {	
							$link_url = base_url()."sitepanel/category/index/".$row['category_id'];				  
							$link_cat[] ='<a href='.$link_url.'>'.$row['category_name'].'</a>';	
									   
						  }     
					}    
		 }else
		 {
			  $link_url = base_url()."sitepanel/category";
			  $link_cat[]='<span class="pr2 fs14">»</span> <a href='.$link_url.'>Category</a>';
			
		 }
		 
		 $link_cat = array_reverse($link_cat);
		 $var=implode($link_cat);
		 return $var;
		
	}
	
}

function createMenu($arr_items,$level='top')
{
  $menu_items_count =  count($arr_items);
  if($menu_items_count > 0)
  {
	 foreach($arr_items as $key1=>$val1)
	 {
		 $menu_id = trim(strtolower($key1));
		 ?>
		 <li<?php echo $level=='top' ? ' id="'.$menu_id.'"' : '';?>>
		 <?php
		 if(is_array($val1) && !empty($val1))
		 {
			 
			?>
		   <a class="<?php echo $level;?>"><?php echo $key1; ?></a> <ul><?php createMenu($val1,'parent');?></ul>
		  <?php 
		 }
		 else
		 {
		 ?>
			<a href="<?php echo base_url().$val1; ?>"<?php echo $level=='top' ? ' class="top"' : '';?>><?php echo $key1; ?></a>
			
		 <?php 
		 }
		 ?>
		 </li>
		<?php
	 }
  }
}

function make_selection_box($id,$attrlebel=FALSE)
{
	$ci = CI();
	$var ='';
	
	$input_fld_type=get_db_field_value('tbl_cat_attr','input_fld_type',array("id"=>$id));
	
	if($input_fld_type>2)	
	{
		$sql=$ci->db->query("select * from tbl_cat_attr_value where cat_attr_id ='".$id."' order by cat_attr_value asc");
		$total_rec=$sql->num_rows();
		if($total_rec>0)
		{
			$res=$sql->result_array();
			if(is_array($res) && count($res) > 0)
			{
				$name="checkbox_".$id."[]";
				$dyclsall="selall_atrval".$id;

				$var.='<div class="mt5"><input type="checkbox" class="'.$dyclsall.'" name="selall_atrval" >All</div>';
				$countID=($ci->input->get_post('attrcountryID') > 0 )?$ci->input->get_post('attrcountryID'):99;
				foreach($res as $value)
				{
			     $lebelarr=get_mapedattribute_value($attrlebel,99,$ci->uri->segment(4));
					
					$chlval=(in_array($value['cat_attr_value'],$lebelarr))?'checked':'';
					$var.='<div class="mt5"><input type="checkbox" name="'.$name.'" value="'.$value['id'].'" class="'.$dyclsall.'" '.$chlval.'> '.$value['cat_attr_value'].'</div>';
				}
			}
		}
	}
	
	return $var;
			  
}

if( ! function_exists('gads_position_dropdown'))
{
	function gads_position_dropdown($page_address='',$selval='')
	{
		$ci = CI();
		
		$page_cntr_mtd			= $page_address;	
		$gads_page_position_arr	= $ci->config->item('gads_page_position');
		$googlebannersz_arr		= $ci->config->item('googlebannersz');
		
		$positionids=@$gads_page_position_arr[$page_cntr_mtd];
		$arr=array(""=>"Select");
		if($positionids!='')
		{
			$positionids_arr=explode(',',$positionids);
			foreach($positionids_arr as $val)
			{
				$arr[$val]=	$googlebannersz_arr[$val];
			}
		}
		return form_dropdown('ban_position', $arr, $selval, 'style="width:235px;"');
					
	}
}

function get_mapedattribute_value($selattrlevel,$countID,$catID){
	
	$ci = CI();
	$newlebelarr=array();
	$attrID=get_db_field_value("tbl_cat_attr","id",array('country_id'=>$countID,"input_fld_label"=>$selattrlevel));
	
	$attrmapvalids=get_db_field_value("tbl_cat_attr_map","cat_attr_value_ids",array('cat_id'=>$catID,"cat_attr_id"=>$attrID));
	//echo $ci->db->last_query();
	if($attrmapvalids!=''){
	 
	  	$query=$ci->db->query("SELECT cat_attr_value FROM tbl_cat_attr_value WHERE id IN($attrmapvalids)");
		if($query->num_rows()  > 0){
		    	
			$resdata=$query->result_array();
			
			if(is_array($resdata) && count($resdata) > 0 ){
				
				foreach($resdata as $resVal){
					
					$newlebelarr[]=$resVal['cat_attr_value'];
				}
				
				
			}
			
		}
		
		
	}
	
	return $newlebelarr;
}

function get_mapedattribute($selattrlevel,$countID,$catID){
	
	$ci = CI();
	$newlebelarr=array();
	$attrID=get_db_field_value("tbl_cat_attr","id",array('country_id'=>$countID,"input_fld_label"=>$selattrlevel));
	
		$attrmapvalids=get_db_field_value("tbl_cat_attr_map","id",array('cat_id'=>$catID,"cat_attr_id"=>$attrID));
		
		/*echo $attrmapvalids;
		echo $ci->db->last_query();
		echo '<br>';*/
		
		if($attrmapvalids>0){
			return 1;	
		}
		else
		{
			return 2;
		}
	
	
	
}

function has_children_customercare($catid) {
	
		 $ci = CI();
		 
		if( is_numeric($catid) &&($catid!="") ){
		
			$sql="SELECT parent_id FROM tbl_customer_care_category
			      WHERE parent_id=$catid AND status !='2' ";
			$sqlResult     = $ci->db->query($sql);
			$num_rows     =  $sqlResult->num_rows();
			
		}
		
		//echo $num_rows;
		return $num_rows >= 1 ? true : false;
	
	}
	
	
 function get_nlevel_drop_down_customercare($parent,$selectId="",$cat_type,$pad="|__"){

	 $ci = CI();
	 $selId =($selectId!="") ? $selectId : "";
	 
	 $var="";
	 
	 $sql="SELECT * FROM tbl_customer_care_category  
		WHERE parent_id=$parent AND status !='2' and cat_type ='".$cat_type."'  ";
		
		
		$sql .=" order by display_order";
	 
	 $query=$ci->db->query($sql);
	 
	 $res_arr = $query->result_array();
	
		$num_rows      =  count($res_arr);
		
	 if ($num_rows > 0 && is_array($res_arr) ) {
		 
		 foreach( $res_arr as $rkey =>$row ) {
			 $catname=ucfirst(strtolower($row['cat_name']));	
		 
			 if ( has_children_customercare($row['id']) || $row['parent_id']==0 ) {
				
				$var .= '<optgroup label="'.$pad.'&nbsp;'.$catname.'" >'.$catname.'</optgroup>'; 
				
				$var .= get_nlevel_drop_down_customercare($row['id'],$selId,$cat_type,'&nbsp;&nbsp;&nbsp;'.$pad); 
				 
				}else{
					
				 $sel=($selectId==$row['id']) ? "selected='selected'" : "";
				 
				$var .= '<option value="'.$row['id'].'" '.$sel.'>'.$pad.$catname.'  </option>'; 
				 
				}     
			}    
		 }
 
		return $var;
 }
 
if (!function_exists('newsletter_header')) {

  function newsletter_header($template_id) {
    $CI = CI();
		$var =get_newsletter_header($template_id);
		
		return $var;
		
	}
 }
 
 if (!function_exists('newsletter_footer')) {

  function newsletter_footer($template_id) {
    $CI = CI();
		$var =get_newsletter_footer($template_id);
		
		return $var;
		
	}
}

if (!function_exists('get_newsletter_header')) {

  function get_newsletter_header($template_id) {
    $CI = CI();		
		$var='';
		
		$cat_res=custom_result_set("select id,cat_name from tbl_categories where parent_id ='0' AND status ='1' order by disp_order limit 0,4");
		
		$image_path=base_url().'assets/developers/newsletter/newsletter-'.$template_id.'/';
		if($template_id==1)
		{
			$var='<html>
							<head>
							<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
							<title>newsletter template1</title>
							</head>
							<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,600,700" rel="stylesheet" type="text/css">
							<link href="http://fonts.googleapis.com/css?family=Droid+Sans:400,600,700" rel="stylesheet" type="text/css">
							<body style="color:#3d3d3d; background:#0a3151; margin:0px; padding:0px;">
							<div style="margin:0px auto; width:700px;">
								<table width="700" border="0" cellspacing="0" cellpadding="0" style="background:#fff;">
								<tr>
									<td><a href="'.site_url().'"><img src="'.$image_path.'images/logo.jpg" style="float:left; border:0px; margin:12px 0 18px 18px;" alt=""></a>
									<div style="clear:both;"></div>
									</td>
									</tr>
								<tr>
									<td style="font-family: Arial, Helvetica, sans-serif; text-transform:uppercase; font-size:12px; background:#0a3151; height:43px;"><div style="font-family:Arial, Helvetica, sans-serif; font-size:11px; font-weight:600; float:left; line-height:43px;">';
									if(is_array($cat_res) && count($cat_res) > 0)
									{
									
									foreach($cat_res as $catval)
									{
										$link1=get_links($catval['id'],'product_category');
									$var .='
									 <a href="'.$link1.'" style="padding:14px 15px 14px 15px; text-align:center; text-transform:uppercase; text-decoration:none; color:#fff;  border-right:1px #59788c solid; ">'.$catval['cat_name'].'</a> ';
									}
									 
									 $var .='
									  <a href="'.site_url('category').'" style="padding:14px 16px; text-align:center; text-transform:uppercase; text-decoration:none; color:#fff;">MORE STORES</a>';
									}
										
										$var .='
												<div style=" clear:both;"></div>
											</div>
											<div style="line-height:43px; float:right;"> <a href="javascript:void(0)" style="padding:14px 10px; text-align:center; text-transform:uppercase; text-decoration:none; color:#fff;  border-right:1px #59788c solid; "><img src="'.$image_path.'images/whole_sale.jpg" style="border:0px; vertical-align:middle;" alt=""></a> <a href="'.site_url('offer-zone').'" style="padding:14px 10px; text-align:center; text-transform:uppercase; text-decoration:none; color:#fff;  border-right:1px #59788c solid; "><img src="'.$image_path.'images/offer-zone.jpg" style="border:0px; vertical-align:middle;" alt=""></a>
												<div style=" clear:both;"></div>
											</div></td>
								</tr>
								
								<tr>
									<td><div style="padding:10px 24px 24px 24px; min-height:250px;">';
		}
		
		return $var;
	}
}
if (!function_exists('get_newsletter_footer')) {

  function get_newsletter_footer($template_id) {
    $CI = CI();
		
		$var='';
		
		$image_path=base_url().'assets/developers/newsletter/newsletter-'.$template_id.'/';
		if($template_id==1)
		{
			$var ='</div></td>
						</tr>
						<tr>
								<td style="text-align:center; padding:20px 0 16px 0;"><table width="95%" border="0" cellspacing="0" cellpadding="0" style="margin:0 auto;">
										<tr>
											<td><img src="'.$image_path.'images/hundred.jpg" alt=""></td>
											<td><img src="'.$image_path.'images/card-1.jpg" alt=""></td>
											<td><img src="'.$image_path.'images/card-2.jpg" alt=""></td>
											<td><img src="'.$image_path.'images/card-3.jpg" alt=""></td>
											<td><img src="'.$image_path.'images/card-4.jpg" alt=""></td>
											<td><img src="'.$image_path.'images/card-5.jpg" alt=""></td>
											<td><img src="'.$image_path.'images/card-6.jpg" alt=""></td>
										</tr>
									</table></td>
							</tr>
							<tr>
								<td style="text-align:center;"><table width="650" border="0" cellspacing="0" cellpadding="0" style="margin:0 auto;">
										<tr>
											<td><img src="'.$image_path.'images/download_apps.jpg" width="138" height="12"></td>
											<td style="text-align:right;"><img src="'.$image_path.'images/google_play.jpg" alt=""></td>
											<td style="text-align:right;"><img src="'.$image_path.'images/google_appstroe.jpg" alt=""></td>
											<td style="text-align:right;"><img src="'.$image_path.'images/windows-store.jpg" alt=""></td>
										</tr>
									</table></td>
							</tr>
							<tr>
								<td style="text-align:center; font-size:11px; font-family:Open Sans, Arial, Helvetica, sans-serif; line-height:60px;">Copyright © 2014, EBIZY.com, All rights reserved. Developed and Managed by <a href="http://www.weblinkindia.net/" target="_blank" style="color:#3d3d3d; text-decoration:none;">WeblinkIndia.NET</a></td>
							</tr>
						</table>
					
					</div>
					</body>
					</html>

					';
		}
		
		return $var;
	}
}

if( ! function_exists('operation_allowed') )
{
	function operation_allowed($tbl,$recId,$autoFld='id',$whereFld='created_by')
	{
		$ci=CI();
		$allowed=FALSE;
		if($ci->admin_type==2)
		{
			$qry=$ci->db->query("select $autoFld from $tbl where $autoFld='".$recId."' and $whereFld='".$ci->admin_id."'");
			if($qry->num_rows() > 0 )
			{
				$allowed=TRUE;
			}
		}
		else
		{
			$allowed=TRUE;
		}
		return $allowed;
	}
}

if( ! function_exists('seller_shipping_bear') )
{
	function seller_shipping_bear($seller_id)
	{
		$ci=CI();
		$sql="select SUM(admin_ship_charge) as total from tbl_shipping_bear where seller_id ='".$seller_id."' group by seller_id limit 1 ";
		$row=$ci->db->query($sql)->row();
		if(is_object($row)){
			return $row->total;
		}else{
			return '0';
		}
	}
}
if( ! function_exists('seller_warehouse_total') )
{
	function seller_warehouse_total($seller_id)
	{
		$ci=CI();
		$sql="select SUM(charges) as total from tbl_warehouse_product as a LEFT JOIN tbl_warehouse_product_log as b ON a.id=b.warehouse_id where seller_id ='".$seller_id."' group by seller_id limit 1 ";
		$row=$ci->db->query($sql)->row();
		
		if(is_object($row)){
			return $row->total;
		}else{
			return '0';
		}
	}
}