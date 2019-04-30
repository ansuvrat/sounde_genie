<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Testimonial_model extends MY_Model
 {

		 
	 public function get_testimonial($limit='10',$offset='0',$param=array())
	 {		
		
		$status			    =   @$param['status'];
		$orderby		    =   @$param['orderby'];	
		$where		        =   @$param['where'];	
		$result		        =   @$param['result'];
		
		$keyword = $this->db->escape_str(trim($this->input->get_post('keyword',TRUE)));
			
	    if($status!='')
		{
			$this->db->where("status","$status");
		}
		
	    if($where!='')
		{
			$this->db->where($where);
		}
		
		
		if($keyword!='')
		{
						
			$this->db->where("(poster_name LIKE '%".$keyword."%' OR email LIKE '%".$keyword."%'
			                                                     OR testimonial_title LIKE '%".$keyword."%' )");
				
		}
		if($orderby!='')
		{
			 $this->db->order_by($orderby);
			
		}else
		{
		  $this->db->order_by('id','desc');
		}
		
		$this->db->limit($limit,$offset);
		$this->db->select('SQL_CALC_FOUND_ROWS*',FALSE);
		$this->db->from('tbl_testimonial');
		$q=$this->db->get();
		
		return ($result=='row') ?  $q->row_array():  $q->result_array();
				
	}
}