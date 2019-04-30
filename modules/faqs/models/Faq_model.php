<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Faq_model extends MY_Model
 {

		 
	 public function get_faq($limit='10',$offset='0',$param=array())
	 {
			$where		= @$param['where'];
			$cat_id		= @$param['catid'];
			$orderby 	= @$param['orderby'];
			
			if($cat_id>0)
			{		
				$this->db->where("cat_id",$cat_id);		 
			}
			if($where!='')
			{
				$this->db->where($where);
			}
			$this->db->select("SQL_CALC_FOUND_ROWS *",FALSE);
			$this->db->from('tbl_faq');
			$this->db->where('status','1');
			
			if($orderby!='')
			{
				$this->db->order_by($orderby);
			}
			else
			{
				$this->db->order_by("id", "desc");
			}
			$this->db->limit($limit,$offset);		
			$query=$this->db->get();
			//echo_sql();		
			if($query->num_rows() > 0)
			{
				return $query->result_array();
			}
		
	}
	 
}
?>