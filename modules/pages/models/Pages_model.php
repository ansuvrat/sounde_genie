<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Pages_model extends MY_Model
{
	public  function get_cms_page($page=array())
	{		
		if( is_array($page) && !empty($page) )
		{			
			$result =  $this->db->get_where('tbl_cms_pages',$page)->row_array();

			if( is_array($result) && !empty($result) )
			{
				return $result;
			}
			
		}	
			
	}
	
	
	public function get_all_cms_page($offset='0',$limit='10')
	{
		
		$keyword = $this->db->escape_str($this->input->get_post('keyword'));
		
		$condtion = ($keyword!='') ? "status !='2' AND page_name LIKE '%".$keyword."%'" :
		"status !='2' ";
		
		$fetch_config = array(
							  'condition'=>$condtion,
							  'order'=>"page_name DESC",
							  'limit'=>$limit,
							  'start'=>$offset,							 
							  'debug'=>FALSE,
							  'return_type'=>"array"							  
							  );		
		$result = $this->findAll('tbl_cms_pages',$fetch_config);
		return $result;	
	
	}
	
	public function get_testimonial($limit='10',$offset='0',$param=array())
	 {
			$where		= @$param['where'];			
			$orderby 	= @$param['orderby'];
			
			
			if($where!='')
			{
				$this->db->where($where);
			}
			$this->db->select("SQL_CALC_FOUND_ROWS *",FALSE);
			$this->db->from('tbl_testimonial');
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