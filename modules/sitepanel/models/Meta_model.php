<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Meta_model extends MY_Model
{

	public $tbl_name;
	public function __construct()
	{
		parent::__construct();
		$this->tbl_name="tbl_meta_tags";
	}
	
	
	public function get_record($opts=array())
	{
		$status = $this->db->escape_str($this->input->get_post('status',TRUE));
		
		if(!array_key_exists('condition',$opts) || $opts['condition']=='')
		{
			$opts['condition']= "meta_id !='0' ";
			
		}else
		{
			$opts['condition']= "meta_id !='0' ".$opts['condition'];
		}
		
		
	 	$opts['order']= "meta_id DESC ";		
		
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
		return $result;
	}
	
	
	public function get_record_by_id($id)
	{
		$id = applyFilter('NUMERIC_GT_ZERO',$id);
		
		if($id>0)
		{
			$condtion = "meta_id =$id";
			$fetch_config = array(
														'condition'=>$condtion,							 					 
														'debug'=>FALSE,
														'return_type'=>"object"							  
													 );
			$result = $this->find($this->tbl_name,$fetch_config);
			return $result;
		}
	}
	
	
}