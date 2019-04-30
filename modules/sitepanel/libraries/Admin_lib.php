<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Admin_lib
{
	// Constructor
	public function __construct()
	{
		if (!isset($this->CI))
		{
			$this->CI =& get_instance();
		}
		
		
	}
	
		
	public function is_admin_logged_in()
	{
		if ( $this->CI->session->userdata('admin_logged_in') != TRUE )
		{
			redirect('sitepanel/', 'refresh');
			
			exit();
			
		}else
		
		{
			$num = $this->CI->db->get_where('tbl_users',
					array('access_key'=>$this->CI->session->userdata('adm_key'),'user_type !='=>'3' ))->num_rows();
			
			if(!$num )
			{
				
				$sess_arr = array(
				           'admin_user' =>0,
				           'adm_key' =>0,
				           'admin_logged_in' => FALSE
				           );
				
				$this->CI->session->unset_userdata($sess_arr);				
				$this->CI->session->set_flashdata('error', 'Logout successfully ..');
				redirect('sitepanel', '');				
				
			}else
			{
				
				
			}
			
			
		}
		
		
	}
	
	public function display_set_msg()
	{
		if ($this->CI->session->flashdata('message') )
		{
			echo '<div class="warning ac " style="padding: 3px;">';
			echo $this->CI->session->flashdata('message');
			echo "</div>";
		}
		
	}
	
	
	
	public function is_section_allowed($admin_id,$access_sec_id)
	{
		$res=array();
		
		$this->CI->db->select('sec_id');
		$this->CI->db->where('subadmin_id',$admin_id);
		$qry=$this->CI->db->get('tbl_admin_allowed_sections');
		//echo $this->CI->db->last_query();
		if($qry->num_rows() > 0)
		{
			$arr=$qry->result_array();
			foreach($arr as $value)
			{
				$res[]=$value['sec_id'];	
			}	
		}
		
		if(!in_array($access_sec_id,$res))
		{
			redirect('sitepanel', '');				
		}
	}
	
	public function get_menu_item()
	{
		
		$admin_id=$this->CI->session->userdata('admin_id');
		$admin_type=$this->CI->session->userdata('admin_type');
		
		$menu=array("Dashboard"=>"sitepanel/dashbord/");
		
		$sql="select a.section_title AS sec_heading ,b.section_title,b.id,b.parent_id,b.section_controller FROM tbl_admin_sections AS a, tbl_admin_sections AS b WHERE a.id=b.parent_id AND a.status='1' AND b.status='1' order by a.disp_order,b.disp_order";
		if($admin_type==2)
		{
			$sql="select a.section_title AS sec_heading ,b.section_title,b.id,b.parent_id,b.section_controller FROM tbl_admin_sections AS a, tbl_admin_sections AS b ,tbl_admin_allowed_sections as allowedsec WHERE a.id=b.parent_id AND b.id=allowedsec.sec_id AND a.status='1' AND b.status='1' AND allowedsec.subadmin_id='".$admin_id."' group by allowedsec.sec_id  order by a.disp_order,b.disp_order";
		}
		
		$qry=$this->CI->db->query($sql);
		if($qry->num_rows() > 0)
		{
			$res=$qry->result_array();
			//trace($res);
			
			if(is_array($res) && count($res) > 0)
			{
				foreach($res as $value)
				{
					if(! array_key_exists($value['sec_heading'],$menu))
					{
						$menu[$value['sec_heading']]=array($value['section_title']=>"sitepanel/".$value['section_controller']);
					}
					else
					{
						$menu[$value['sec_heading']][$value['section_title']]="sitepanel/".$value['section_controller'];
					}
				}
			}
			
		}
		
		return $menu;
	}
	
	
	
}

/* End of file Access_library.php */
/* Location: ./application/libraries/Access_library.php */