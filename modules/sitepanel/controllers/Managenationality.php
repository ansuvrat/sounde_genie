<?php
class Managenationality extends Admin_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('nationality_model'));
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
		$res_array              =  $this->nationality_model->getnationality($condtion_array);
		$config['total_rows']	=  $this->nationality_model->total_rec_found;
		$data['page_links']     =  admin_pagination($base_url,$config['total_rows'],$config['limit'],$offset);
		$data['heading_title']  =  'Manage Nationality';

		$data['res']            =  $res_array;

		$data['parent_id']      =  $parent_id;
        
		if( $this->input->post('status_action')!='')
		{

			
			if($this->input->post('status_action')=='Activate'){
			
				$arr_ids=$this->input->post('arr_ids');
				
				if(is_array($arr_ids) && count($arr_ids) > 0){
					foreach($arr_ids as $value){
					
						$this->db->query("UPDATE tbl_nationality SET status='1' WHERE id ='$value'");	
						
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
					
						$this->db->query("UPDATE tbl_nationality SET status='0' WHERE id ='$value'");	
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
					   
					 
					   $this->db->query("DELETE FROM tbl_nationality  WHERE id ='$value'");	
					   $this->session->set_userdata(array('msg_type'=>'success'));
					   $this->session->set_flashdata('success',"Selected record(s) has been deleted successfully." );
					}
				}
				redirect($_SERVER['HTTP_REFERER']);
			}
		}
		$this->load->view('nationality/view_nationality_list',$data);
	}

	public function add()
	{
		$data['heading_title'] = 'Add Nationality';

		$this->form_validation->set_rules('nationality','Nationality',"trim|required|max_length[32]|unique[tbl_nationality.nationality='".$this->db->escape_str($this->input->post('nationality'))."' AND status!='2']");
		

		if($this->form_validation->run()===TRUE)
		{
			$posted_data = array(
			'nationality'=>$this->input->post('nationality'),
			'status'=>1
			);
			$posted_data=$this->security->xss_clean($posted_data);
			$this->nationality_model->safe_insert('tbl_nationality',$posted_data,FALSE);
			$this->session->set_userdata(array('msg_type'=>'success'));
			$this->session->set_flashdata('success',lang('success'));
			redirect('sitepanel/managenationality', '');

		}
		$this->load->view('nationality/view_nationality_add',$data);

	}

	public function edit()
	{
		$designationId = (int) $this->uri->segment(4);

		$rowdata=$this->nationality_model->get_nationality_by_id($designationId);

		$designationId = $rowdata['id'];

		$data['heading_title'] = 'Edit Nationality';

		if( !is_array($rowdata) )
		{
		  $this->session->set_flashdata('message', lang('idmissing'));
		  redirect('sitepanel/managenationality', '');
		}
		$this->form_validation->set_rules('nationality','Nationality',"trim|required|max_length[32]|unique[tbl_nationality.nationality='".$this->db->escape_str($this->input->post('nationality'))."' AND status!='2' AND id != ".$designationId."]");
	

		if($this->form_validation->run()==TRUE)
		{
			$posted_data = array(
			'nationality'=>$this->input->post('nationality')
			);
            $posted_data=$this->security->xss_clean($posted_data);
			$where = "id = '".$designationId."'";
			$this->nationality_model->safe_update('tbl_nationality',$posted_data,$where,FALSE);
			$this->session->set_userdata(array('msg_type'=>'success'));
			$this->session->set_flashdata('success',lang('successupdate'));
			redirect('sitepanel/managenationality'.'/'.query_string(), '');
		}
		$data['res']=$rowdata;
		$this->load->view('nationality/view_nationality_edit',$data);

	}

}
// End of controller