<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Products_model extends MY_Model
{

	public $tbl_name;
	public function __construct()
	{
		parent::__construct();
		$this->tbl_name="tbl_products";
	}
	
	
	public function get_record_dump($opts=array())
	{
		$status 	= $this->db->escape_str($this->input->get_post('status',TRUE));
		$keyword 	= $this->db->escape_str($this->input->get_post('keyword',TRUE));
		
		if(!array_key_exists('condition',$opts) || $opts['condition']=='')
		{
			$opts['condition']= "status !='2' ";
			
		}else
		{
			$opts['condition']= "status !='2' ".$opts['condition'];
		}
		
		if($status!='')
		{
			$opts['condition'].= " AND status='$status' ";
		}
		if($keyword!='')
		{
			$opts['condition'].= " AND (product_name like '%".$keyword."%' OR product_code like '%".$keyword."%') ";
		}
		
		
	 	$opts['order']= "id DESC ";		
		
		$opts['condition'].= " ";
		
		$fetch_config = array('condition'=>$opts['condition'],
								'order'=>$opts['order'],
								'return_type'=>"array" );	
								
		if(array_key_exists('debug',$opts) )
		{			
			$fetch_config['debug']=$opts['debug'];
		}
		
		
		if(array_key_exists('field',$opts) && $opts['field']!='' )
		{			
			$fetch_config['field']=$opts['field'];
		}
												
		if(array_key_exists('limit',$opts) && applyFilter('NUMERIC_GT_ZERO',$opts['limit'])>0)
		{
			
			$fetch_config['limit']=$opts['limit'];
		}	
		if(array_key_exists('offset',$opts) && applyFilter('NUMERIC_WT_ZERO',$opts['offset'])!=-1)
		{
			$fetch_config['start']=$opts['offset'];
		}		
		$result = $this->findAll($this->tbl_name,$fetch_config);
		
		//echo $this->db->last_query();
		return $result;
	}
	public function get_deal_products($offset=FALSE,$per_page=FALSE,$condition)
	{
		
	$opts=array(
				'condition'=>$condition,
				'limit'=>$per_page,
				'orderby'=>"prod.id DESC",
				'offset'=>$offset,
				'fromcond'=>'tbl_offer_zone as oz',
				'selectcond'=>'oz.*,prod.*,u.name,u.email,oz.status as offerstatus',
				'joins'=>array(
					array('tblname'=>'tbl_products as prod','jclause'=>'prod.id=oz.product_id'),
					array('tblname'=>'tbl_users as u','jclause'=>'prod.member_id=u.id')
					)
				);	
		return $this->myCustomJoin($opts);
		
	}
	
	
	public function get_record($offset=FALSE,$per_page=FALSE,$condition)
	{
		$opts=array(
								'condition'=>$condition,
								'limit'=>$per_page,
								'orderby'=>"prod.id DESC",
								'offset'=>$offset,
								'fromcond'=>'tbl_products as prod',
								'selectcond'=>'prod.*,u.name,u.email',
								'joins'=>array(
									array('tblname'=>'tbl_users as u','jclause'=>'prod.member_id=u.id')
									)
								);	
		return $this->myCustomJoin($opts);
	}
	
	public function get_record_by_id($id)
	{
		$id = applyFilter('NUMERIC_GT_ZERO',$id);
		
		if($id>0)
		{
			$condtion = "status !='2' AND id=$id";
			$fetch_config = array(
														'condition'=>$condtion,							 					 
														'debug'=>FALSE,
														'return_type'=>"object"							  
													 );
			$result = $this->find($this->tbl_name,$fetch_config);
			return $result;
		}
	}
	
	
	public function get_reviews($offset=FALSE,$per_page=FALSE,$opts)
	{
		$status 	= $this->db->escape_str($this->input->get_post('status',TRUE));
		
		if(!array_key_exists('condition',$opts) || $opts['condition']=='')
		{
			$opts['condition']= "status !='2' ";
			
		}else
		{
			$opts['condition']= "status !='2' ".$opts['condition'];
		}
		
		if($status!='')
		{
			$opts['condition'].= " AND status='$status' ";
		}
		
	 	$opts['order']= "id DESC ";		
		
		$opts['condition'].= " ";
		
		$fetch_config = array('condition'=>$opts['condition'],
								'order'=>$opts['order'],
								'return_type'=>"array" );	
								
		
												
		if(array_key_exists('limit',$opts) && applyFilter('NUMERIC_GT_ZERO',$opts['limit'])>0)
		{
			
			$fetch_config['limit']=$opts['limit'];
		}	
		if(array_key_exists('offset',$opts) && applyFilter('NUMERIC_WT_ZERO',$opts['offset'])!=-1)
		{
			$fetch_config['start']=$opts['offset'];
		}		
		$result = $this->findAll("tbl_product_review",$fetch_config);
		
		//echo $this->db->last_query();
		return $result;
	}
	
}
// model end here