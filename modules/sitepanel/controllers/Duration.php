<?php
class Duration extends Admin_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('duration_model'));
		$this->config->set_item('menu_highlight','category');
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
		$res_array              =  $this->duration_model->getduration($condtion_array);
		$config['total_rows']	=  $this->duration_model->total_rec_found;
		$data['page_links']     =  admin_pagination($base_url,$config['total_rows'],$config['limit'],$offset);
		$data['heading_title']  =  'Duration';

		$data['res']            =  $res_array;

		$data['parent_id']      =  $parent_id;
        
		if( $this->input->post('status_action')!='')
		{

			
			if($this->input->post('status_action')=='Activate'){
			
				$arr_ids=$this->input->post('arr_ids');
				
				if(is_array($arr_ids) && count($arr_ids) > 0){
					foreach($arr_ids as $value){
					
						$this->db->query("UPDATE tbl_duration SET status='1' WHERE duration_id ='$value'");	
						
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
					
						$this->db->query("UPDATE tbl_duration SET status='0' WHERE duration_id ='$value'");	
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
					   
					 
					   $this->db->query("DELETE FROM tbl_duration  WHERE duration_id ='$value'");	
					   $this->session->set_userdata(array('msg_type'=>'success'));
					   $this->session->set_flashdata('success',"Selected record(s) has been deleted successfully." );
					   
					}
					
				}
				redirect($_SERVER['HTTP_REFERER']);
			
			}
			
		
		}
		$this->load->view('duration/view_duration_list',$data);

	}

	public function add()
	{
		$data['heading_title'] = 'Add Duration';

		$this->form_validation->set_rules('duration','Duration',"trim|required|max_length[32]|unique[tbl_duration.duration='".$this->db->escape_str($this->input->post('duration'))."' AND status!='2']|numeric");
		

		if($this->form_validation->run()===TRUE)
		{
			$posted_data = array(
			'duration'=>$this->input->post('duration'),
			'status'=>1
			);
			$posted_data=$this->security->xss_clean($posted_data);
			$this->duration_model->safe_insert('tbl_duration',$posted_data,FALSE);

			$this->session->set_userdata(array('msg_type'=>'success'));
			$this->session->set_flashdata('success',lang('success'));
			redirect('sitepanel/duration', '');

		}
		$this->load->view('duration/view_duration_add',$data);

	}

	public function edit()
	{
		$durationId = (int) $this->uri->segment(4);

		$rowdata=$this->duration_model->get_duration_by_id($durationId);

		$durationId = $rowdata['duration_id'];

		$data['heading_title'] = 'Duration';

		if( !is_array($rowdata) )
		{
		  $this->session->set_flashdata('message', lang('idmissing'));
		  redirect('sitepanel/duration', '');
		}
		$this->form_validation->set_rules('duration','Duration',"trim|required|max_length[32]|unique[tbl_duration.duration='".$this->db->escape_str($this->input->post('duration'))."' AND status!='2' AND duration_id != ".$durationId."]");
	

		if($this->form_validation->run()==TRUE)
		{
			$posted_data = array(
			'duration'=>$this->input->post('duration')
			);
            $posted_data=$this->security->xss_clean($posted_data);
			$where = "duration_id = '".$durationId."'";
			$this->duration_model->safe_update('tbl_duration',$posted_data,$where,FALSE);

			$this->session->set_userdata(array('msg_type'=>'success'));
			$this->session->set_flashdata('success',lang('successupdate'));

			redirect('sitepanel/duration'.'/'.query_string(), '');

		}

		$data['res']=$rowdata;
		$this->load->view('duration/view_duration_edit',$data);

	}

}
// End of controller