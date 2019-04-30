<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Subadmin_model extends MY_Model
{

	public $tbl_name;
	public function __construct()
	{
		parent::__construct();
		$this->tbl_name="tbl_users";
	}
	
	
	public function get_record($opts=array())
	{
		$status = $this->db->escape_str($this->input->get_post('status',TRUE));
		
		if(!array_key_exists('condition',$opts) || $opts['condition']=='')
		{
			$opts['condition']= "status !='2' AND user_type='2'";
			
		}else
		{
			$opts['condition']= "status !='2' AND user_type='2' ".$opts['condition'];
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
			$condtion = "status !='2' AND user_type='2' AND id=$id";
			$fetch_config = array(
														'condition'=>$condtion,							 					 
														'debug'=>FALSE,
														'return_type'=>"object"							  
													 );
			$result = $this->find($this->tbl_name,$fetch_config);
			return $result;
		}
	}
	
	public function add()
	{
		$access_key=random_string('alnum', 15);
		
		$data=array(
								'name'			=>$this->input->post('name',TRUE),
								'email'				=>$this->input->post('email',TRUE),
								'username'			=>$this->input->post('username',TRUE),
								'password'			=>$this->input->post('password',TRUE),
								'status'							=>'1',
								'user_type'		=>'2',
								'access_key'						=>$access_key,
								'created_at'						=>$this->config->item('date_format')
								);
		$insId =  $this->safe_insert($this->tbl_name,$data,FALSE);
		
		$section_id=$this->input->post('sec_id');
		if(is_array($section_id) && count($section_id) > 0)
		{
			foreach($section_id as $val)
			{
				$sec_parent_id	=get_db_field_value("tbl_admin_sections","parent_id",array("id"=>$val));
				
				$data1=array(
											'subadmin_id'			=>$insId,
											'sec_parent_id'		=>$sec_parent_id,
											'sec_id'					=>$val,
											'permission'			=>'1,2,3,4,5,6'
										);
										
				$subadminId =  $this->safe_insert("tbl_admin_allowed_sections",$data1,FALSE);	
			}
		}
						
		return $insId;	
	}
	
	public function edit($pre_edit_data)
	{
		
		$id =  $this->input->post('id');		
		
		$data=array(
								'name'			=>$this->input->post('name',TRUE),
								'email'				=>$this->input->post('email',TRUE),
								'username'			=>$this->input->post('username',TRUE),
								'password'			=>$this->input->post('password',TRUE),
								);
		
		
		$where = "id ='".$id."' "; 
		$this->safe_update($this->tbl_name,$data,$where,FALSE);
		
		$section_id=$this->input->post('sec_id');
		if(is_array($section_id) && count($section_id) > 0)
		{
			$this->safe_delete('tbl_admin_allowed_sections',array('subadmin_id'=>$pre_edit_data->id));
			
			foreach($section_id as $val)
			{
				$sec_parent_id	=get_db_field_value("tbl_admin_sections","parent_id",array("id"=>$val));
				
				$data1=array(
											'subadmin_id'			=>$pre_edit_data->id,
											'sec_parent_id'		=>$sec_parent_id,
											'sec_id'					=>$val,
											'permission'			=>'1,2,3,4,5,6'
										);
										
				$subadminId =  $this->safe_insert("tbl_admin_allowed_sections",$data1,FALSE);	
			}
		}
		else
		{
			$this->safe_delete('tbl_admin_allowed_sections',array('subadmin_id'=>$pre_edit_data->id));	
		}
		
		
	}
	
	public function get_allocated_sections($subadmin_id)
	{
		$res=array();
		$this->db->select('sec_id');
		$this->db->where('subadmin_id',$subadmin_id);
		$qry=$this->db->get('tbl_admin_allowed_sections');
		
		if($qry->num_rows() > 0)
		{
			$arr=$qry->result_array();
			if(is_array($arr) && count($arr)> 0)
			{
				foreach($arr as $val)
				{
					
					$res[]=$val['sec_id'];
				}	
			}
				
			
		}
		return $res;
	}
	
	
}
// model end here