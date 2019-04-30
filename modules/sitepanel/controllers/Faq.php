<?php
class Faq extends Admin_Controller
{
	public $view_path;
	public $current_controller;
	public function __construct()
	{		
		parent::__construct();
		
		$this->current_controller = $this->router->fetch_class();
		 				
		$this->load->model(array('faq_model'));
		$this->config->set_item('menu_highlight','miscellaneous');				
		
		$this->view_path = $this->current_controller."/";
		
	}
	 
	public  function index()
	{
		$pagesize            =  (int) $this->input->get_post('pagesize');
		$config['limit']		 =  ( $pagesize > 0 ) ? $pagesize : $this->config->item('pagesize');
		$offset              =  ( $this->input->get_post('per_page') > 0 ) ? $this->input->get_post('per_page') : 0;
		$base_url            =  current_url_query_string(array('filter'=>'result'),array('per_page'));
		
		
		$keyword = trim($this->input->get_post('keyword',TRUE));
		$cat_id  = trim($this->input->get_post('cat_id',TRUE));
		$keyword = $this->db->escape_str($keyword);
		$condtion = " ";
		
		if($keyword!='')
		{
			$condtion = "AND question like '%".$keyword."%'";
		}
		if($cat_id!='')
		{
			$condtion = "AND cat_id = '".$cat_id."'";
		}
		
		$condtion_array = array(
											 'condition'=>$condtion,
											 'limit'=>$config['limit'],
											  'offset'=>$offset	,
											  'debug'=>FALSE
											 );
											 							 						 	
		$res_array              =  $this->faq_model->get_record($condtion_array);
		
		$config['total_rows']   =  $this->faq_model->total_rec_found;
		$data['page_links']     =  admin_pagination($base_url,$config['total_rows'],$config['limit'],$offset);
		$data['heading_title']  =  "Manage Faq's";
		$data['res']            =  $res_array;
		
		
		if( $this->input->post('status_action')!='')
		{			
			$this->update_status('tbl_faq','id');			
		}
		if( $this->input->post('update_order')!='')
		{			
			$this->update_displayOrder('tbl_faq','display_order','id');			
		}
		
		$data['includes']		= $this->view_path.'list_vew';
		
		$this->load->view('includes/sitepanel_container',$data);		
		
		
	}	
	
	public function add()
	{
		$data['cancel_url'] 	 = base_url()."sitepanel/".$this->current_controller;
		$data['ckeditor']  =  set_ck_config(array('textarea_id'=>'answer'));	
		
		$id         			 =  (int) $this->uri->segment(4,0);
		$row_data='';
		
		$data['heading_title'] = "Add Faq's";
		$this->form_validation->set_rules('question','question',"trim|required|max_length[223]|unique[tbl_faq.question='".$this->db->escape_str($this->input->post('question'))."' AND tbl_faq.cat_id='".$this->db->escape_str($this->input->post('cat_id'))."' AND tbl_faq.status!='2' ] ");
		$this->form_validation->set_rules('answer','answer',"trim|required");
			
		if($this->form_validation->run()===TRUE)
		{
			$posted_data = array('question'		  => $this->input->post('question'),
									'answer'	  		=> $this->input->post('answer'),
									'status'	      => '1',
									'created_by'		=> $this->admin_id
									);
			$posted_data = $this->security->xss_clean($posted_data);			 
			$this->faq_model->safe_insert('tbl_faq',$posted_data,FALSE);
			
			$this->session->set_userdata(array('msg_type'=>'success'));
			$this->session->set_flashdata('success',lang('success'));	
			
			
			$redirect_path= 'faq';			
			redirect('sitepanel/'.$redirect_path, '');
			
		}
		$data['includes']		= $this->view_path.'add_view';
		$this->load->view('includes/sitepanel_container',$data);
		
	}
	
	
	public function edit()
	{
		$data['cancel_url'] 	 = base_url()."sitepanel/".$this->current_controller;
		$data['ckeditor']  =  set_ck_config(array('textarea_id'=>'answer'));
		$id         			 =  (int) $this->uri->segment(4,0);
		$row_data='';
		if($id>0)
		{
			$row_data=$this->faq_model->get_record_by_id($id);
			$operation_allowed=operation_allowed("tbl_faq",$id); 
			if(!$operation_allowed)
			{
				$this->session->set_userdata(array('msg_type'=>'error'));
				$this->session->set_flashdata('error',lang('operation_not_allowed'));
				redirect('sitepanel/faq');
			}	
		}
		$data['row']=$row_data;
		
		$data['parentData'] = '';
		$data['heading_title'] = "Edit Faq's";
		
		$this->form_validation->set_rules('question','question',"trim|required|max_length[223]|unique[tbl_faq.question='".$this->db->escape_str($this->input->post('question'))."' AND tbl_faq.cat_id='".$this->db->escape_str($this->input->post('cat_id'))."' AND tbl_faq.status!='2' AND id!='$id' ]");
		$this->form_validation->set_rules('answer','answer',"trim|required|required_stripped|max_length[8500]");
		
		
		if($this->form_validation->run()===TRUE)
		{
			$posted_data = array('question'		  => $this->input->post('question'),
												'answer'	  		=> $this->input->post('answer')
												);
			$posted_data = $this->security->xss_clean($posted_data);			 		 
			$this->faq_model->safe_update('tbl_faq',$posted_data,"id ='".$id."'",FALSE);
			
			$this->session->set_userdata(array('msg_type'=>'success'));
			$this->session->set_flashdata('success',lang('successupdate'));
			
			$redirect_path= 'faq';			
			redirect('sitepanel/'.$redirect_path, '');
		}
		$data['includes']		= $this->view_path.'edit_view';
		$this->load->view('includes/sitepanel_container',$data);
		
	}
	
	
	
}
// End of controller