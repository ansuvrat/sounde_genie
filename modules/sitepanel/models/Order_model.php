<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Order_model extends MY_Model{

	public function get_orders($limit='',$offset='',$condition=''){

		$condition="status !='2' $condition ";
		$where =$condition;
		$this->db->select("SQL_CALC_FOUND_ROWS tbl_order.*",FALSE);
		$this->db->from("tbl_order");
		
		if($limit)
		$this->db->limit($limit,$offset);
		$this->db->where($where,"",FALSE);
		$this->db->order_by('id DESC');
		$qry=$this->db->get();
		$res=array();
		if($qry->num_rows() > 0){
			$res=$qry->result_array();
		}
		return $res;	
	}
	
	
	public function get_sellerorders($limit='',$offset='',$condition=''){}



	public function get_order_master($ordId)

	{

		$id = (int) $ordId;
		if($id!='' && is_numeric($id))
		{
			$condtion = "id =$id";
			$fetch_config = array(
									'condition'   => $condtion,
									'debug'       => FALSE,
									'return_type' => "array"
								  );
			$result = $this->find('tbl_order',$fetch_config);
			return $result;

		}

	}

}