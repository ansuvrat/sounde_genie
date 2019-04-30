<?php
class Members extends Admin_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->model(array('member/member_model'));
		$this->load->library(array('safe_encrypt'));
		$this->config->set_item('menu_highlight','members');

	}


	public  function index(){
	
		$mem_type = $this->input->get_post('mem_type');
		
		if( $this->input->post('status_action')!=''){
		

			if($this->input->post('status_action')=='Verify'){
				
			
				foreach($this->input->post('arr_ids') as $v){
				
					$where = array('id'=>$v);
					$this->utils_model->safe_update('tbl_users',array('is_verified'=>1),$where,FALSE);
				
				}
				$this->session->set_flashdata('success',"selected Account has been successfully verfied");
				redirect($_SERVER['HTTP_REFERER'], '');
			
			}else if($this->input->post('status_action')=='Not Verify'){
				
				foreach($this->input->post('arr_ids') as $v){
					
					$where = array('id'=>$v);
					$this->utils_model->safe_update('tbl_users',array('is_verified'=>0),$where,FALSE);
					
				}
				$this->session->set_flashdata('success',"selected Account has been successfully unverfied");
				redirect($_SERVER['HTTP_REFERER'], '');
			}
			if($this->input->post('status_action')=='Activate'){
				
				$this->update_status('tbl_users','id');
				
			}elseif($this->input->post('status_action') == 'Delete'){
				
				foreach($this->input->post('arr_ids') as $v){
					
					$where  = array('id'=>$v);
					$where1 = array('user_id'=>$v);
					$this->utils_model->safe_update('tbl_users',array('status'=>'2'),$where,TRUE);
					
				}
				$this->session->set_flashdata('success',lang('deleted'));
				redirect($_SERVER['HTTP_REFERER'], '');
				
			}else{
				$this->update_status('tbl_users','id');
			}
		
		}
		
		$pagesize           =  (int) $this->input->get_post('pagesize');
		$config['limit']	=  ( $pagesize > 0 ) ? $pagesize : $this->config->item('pagesize');
		$offset             =  ( $this->input->get_post('per_page') > 0 ) ? $this->input->get_post('per_page') : 0;
		$base_url           =  current_url_query_string(array('filter'=>'result'),array('per_page'));
		$mem_type= trim($this->db->escape_str($this->input->get_post('mem_type',TRUE)));
		$where				=  " and id !='".$this->admin_id."' ";
		if($mem_type !=''){
			$where.=" AND user_type ='$mem_type' ";
		}else{
			$where.=" AND user_type >='1'";
		}
		
		$keyword			=   trim($this->db->escape_str($this->input->get_post('keyword',TRUE)));
		$gender			=   trim($this->db->escape_str($this->input->get_post('gender',TRUE)));
		$mem_type			=   trim($this->db->escape_str($this->input->get_post('mem_type',TRUE)));
		$status			    =   $this->input->get_post('status',TRUE);
		if($status!=''){
			$where .= " AND status = '$status' ";
		}
		
		if($keyword!=''){
			$where .=" and (name like '%$keyword%'  or username like '%$keyword%'  )"; 
		}
		
		
		
		if($where!=''){
			$condition['cond'] = $where;
		}
		
		$res_array              = $this->member_model->get_members($config['limit'],$offset,$condition);
		
		$total_record           = get_found_rows();
		$data['page_links']     =  admin_pagination($base_url,$total_record,$config['limit'],$offset);
		$data['heading_title']  = 'Manage Members';
		$data['pagelist']       = $res_array;
		$data['total_rec']      = $total_record  ;
		$data['mem_type'] = $mem_type;
		$this->load->view('members/buyer_list_view',$data);
		
	}

	public function details()

	{
		$seller_id   = (int) $this->uri->segment(4);
		$options=array('status!='=>'2','id'=>$seller_id);
		$mres=$this->member_model->get_members(1,0,$options);
		$data['heading_title']  = 'Member Details';
		$data['mres']      = $mres;
		$this->load->view('members/view_member_detail',$data);


	}


}

// End of controller