<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Homepagebannere_model extends MY_Model{

     public function __construct(){
	 
	    parent::__construct();
		
	 }
	public function gethomebanner($offset=FALSE,$per_page=FALSE){
		
		$keyword = $this->db->escape_str($this->input->post('keyword'));
		
		$condtion ="status !='2' ";
		
		$fetch_config = array(
							  'condition'   => $condtion,
							  'order'       => "id DESC",
							  'limit'       => $per_page,
							  'start'       => $offset,							 
							  'debug'       => FALSE,
							  'return_type'=> "array"							  
							  );		
		$result = $this->findAll('tbl_home_banner',$fetch_config);
		return $result;	
	
	}
	
	public function gethomebanner_by_id($id){
		
		$id = (int) $id;
		
		if($id!='' && is_numeric($id))
		{
			
			$condtion = "id = $id";
			$fetch_config = array(
							  'condition'=>$condtion,							 					 							  'debug'=>FALSE,
							  'return_type'=>"object"							  
							  );
			
			$result = $this->find('tbl_home_banner',$fetch_config);
			return $result;	
			
		}		
	
	}
	
}