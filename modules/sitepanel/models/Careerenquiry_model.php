<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Careerenquiry_model extends MY_Model

{

	public function __construct()
	{
		parent::__construct();
	}

	public function get_enquiry($offset,$per_page,$condition='')
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

		$result = $this->findAll('tbl_career',$fetch_config);
		return $result;	

	}
	
	public function get_liveinsenquiry($offset,$per_page,$condition='')
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

		$result = $this->findAll('tbl_live_instrument_enquiry',$fetch_config);
		return $result;	

	}





	

}

// model end here