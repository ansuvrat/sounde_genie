<?php
class Managedesignation extends Admin_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('designation_model'));
		$this->config->set_item('menu_highlight','other');
	}

	public  function index()
	{
		
		$pagesize               =  (int) $this->input->get_post('pagesize');
		$config['limit']		 =  ( $pagesize > 0 ) ? $pagesize : $this->config->item('pagesize');
		$offset                 =  ( $this->input->get_post('per_page') > 0 ) ? $this->input->get_post('per_page') : 0;
		$base_url               =  current_url_query_string(array('filter'=>'result'),array('per_page'));
		$parent_id              =   (int) $this->uri->segment(4,0);

		$keyword = trim($this->input->get_post('keyword',TRUE));
		$keyword = $this->db->escape_str($keyword);
		$condtion = " ";

		$condtion_array = array(
								'field' =>"*",
								'condition'=>$condtion,
								'limit'=>$config['limit'],
								'offset'=>$offset	,
								'debug'=>FALSE
								);
		$res_array              =  $this->designation_model->getdesignation($condtion_array);
		$config['total_rows']	=  $this->designation_model->total_rec_found;
		$data['page_links']     =  admin_pagination($base_url,$config['total_rows'],$config['limit'],$offset);
		$data['heading_title']  =  'Manage Designation';

		$data['res']            =  $res_array;

		$data['parent_id']      =  $parent_id;
        
		if( $this->input->post('status_action')!='')
		{

			
			if($this->input->post('status_action')=='Activate'){
			
				$arr_ids=$this->input->post('arr_ids');
				
				if(is_array($arr_ids) && count($arr_ids) > 0){
					foreach($arr_ids as $value){
					
						$this->db->query("UPDATE tbl_designation SET status='1' WHERE id ='$value'");	
						
					}
					$this->session->set_userdata(array('msg_type'=>'success'));
					$this->session->set_flashdata('success',"Selected record(s) has been Activated successfully." );
				}
				redirect($_SERVER['HTTP_REFERER']);
			
			}
			if($this->input->post('status_action')=='Deactivate'){
				
				$arr_ids=$this->input->post('arr_ids');
				
				if(is_array($arr_ids) && count($arr_ids) > 0){
					
					foreach($arr_ids as $value){
					
						$this->db->query("UPDATE tbl_designation SET status='0' WHERE id ='$value'");	
					}
					$this->session->set_userdata(array('msg_type'=>'success'));
					$this->session->set_flashdata('success',"Selected record(s) has been de-activated successfully." );
					
				}
				redirect($_SERVER['HTTP_REFERER']);
				
			}
			
			if($this->input->post('status_action')=='Delete'){
				
				$arr_ids=$this->input->post('arr_ids');
				
				if(is_array($arr_ids) && count($arr_ids) > 0){
					
					foreach($arr_ids as $value){
					   
					 
					   $this->db->query("DELETE FROM tbl_designation  WHERE id ='$value'");	
					   $this->session->set_userdata(array('msg_type'=>'success'));
					   $this->session->set_flashdata('success',"Selected record(s) has been deleted successfully." );
					   
					}
					
				}
				redirect($_SERVER['HTTP_REFERER']);
			
			}
			
		
		}
		$this->load->view('designation/view_designation_list',$data);

	}

	public function add()
	{
		$data['heading_title'] = 'Add Designation';

		$this->form_validation->set_rules('designation','Designation',"trim|required|max_length[32]|unique[tbl_designation.designation='".$this->db->escape_str($this->input->post('designation'))."' AND status!='2']");
		

		if($this->form_validation->run()===TRUE)
		{
			$posted_data = array(
			'designation'=>$this->input->post('designation'),
			'status'=>1
			);
			$posted_data=$this->security->xss_clean($posted_data);
			$this->designation_model->safe_insert('tbl_designation',$posted_data,FALSE);

			$this->session->set_userdata(array('msg_type'=>'success'));
			$this->session->set_flashdata('success',lang('success'));
			redirect('sitepanel/managedesignation', '');

		}
		$this->load->view('designation/view_designation_add',$data);

	}

	public function edit()
	{
		$designationId = (int) $this->uri->segment(4);

		$rowdata=$this->designation_model->get_designation_by_id($designationId);

		$designationId = $rowdata['id'];

		$data['heading_title'] = 'Edit Designation';

		if( !is_array($rowdata) )
		{
		  $this->session->set_flashdata('message', lang('idmissing'));
		  redirect('sitepanel/managedesignation', '');
		}
		$this->form_validation->set_rules('designation','Designation',"trim|required|max_length[32]|unique[tbl_designation.designation='".$this->db->escape_str($this->input->post('designation'))."' AND status!='2' AND id != ".$designationId."]");
	

		if($this->form_validation->run()==TRUE)
		{
			$posted_data = array(
			'designation'=>$this->input->post('designation')
			);
            $posted_data=$this->security->xss_clean($posted_data);
			$where = "id = '".$designationId."'";
			$this->designation_model->safe_update('tbl_designation',$posted_data,$where,FALSE);

			$this->session->set_userdata(array('msg_type'=>'success'));
			$this->session->set_flashdata('success',lang('successupdate'));

			redirect('sitepanel/managedesignation'.'/'.query_string(), '');

		}

		$data['res']=$rowdata;
		$this->load->view('designation/view_designation_edit',$data);

	}

}
// End of controller