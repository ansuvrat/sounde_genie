<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Feedback_model extends MY_Model
{

	public function __construct()
	{
		parent::__construct();
	}

	public function get_feedback($offset,$per_page,$condition='')
	{
		$status_flag=FALSE;
		
		$fetch_config = array(
							  'condition'=>$condition,
							  'order'=>"id DESC",
							  'limit'=>$per_page,
							  'start'=>$offset,							 
							  'debug'=>FALSE,
							  'return_type'=>"array"							  
							  );		
		$result = $this->findAll('tbl_contactus',$fetch_config);
		return $result;	
		
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
			$result = $this->find("tbl_contactus",$fetch_config);
			return $result;
		}
	}


	
}
// model end here