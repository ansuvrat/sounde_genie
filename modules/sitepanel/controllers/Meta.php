<?php
class Meta extends Admin_Controller
{
	public $view_path;
	public $current_controller;
	public function __construct()
	{		
		parent::__construct();
		
		$this->current_controller	=$this->router->fetch_class();
		 				
		$this->load->model(array($this->current_controller.'_model'));
		$this->config->set_item('menu_highlight','miscellaneous');				
		
		$this->view_path					=$this->current_controller."/";
		
	}
	
	//Country 
	public  function index()
	{
		$pagesize            =  (int) $this->input->get_post('pagesize');
		$config['limit']		 =  ( $pagesize > 0 ) ? $pagesize : $this->config->item('pagesize');
		$offset              =  ( $this->input->get_post('per_page') > 0 ) ? $this->input->get_post('per_page') : 0;
		$base_url            =  current_url_query_string(array('filter'=>'result'),array('per_page'));
		
		
		$keyword = trim($this->input->get_post('keyword',TRUE));
		$keyword = $this->db->escape_str($keyword);
		$condtion = " ";
		
		if($keyword!='')
		{
			$condtion = "AND page_url like '%".$keyword."%'";
		}
		
		$condtion_array = array(
											 'condition'=>$condtion,
											 'limit'=>$config['limit'],
											  'offset'=>$offset	,
											  'debug'=>FALSE
											 );
											 							 						 	
		$res_array              =  $this->meta_model->get_record($condtion_array);
		$config['total_rows']		=  $this->meta_model->total_rec_found;
		$data['page_links']     =  admin_pagination($base_url,$config['total_rows'],$config['limit'],$offset);
		$data['heading_title']  =  "Manage Meta Tags";
		$data['res']            =  $res_array;
		
		
		if( $this->input->post('status_action')!='')
		{			
			$this->update_status('tbl_meta_tags','meta_id');			
		}
		
		$data['includes']		= $this->view_path.'list_vew';
		
		$this->load->view('includes/sitepanel_container',$data);		
		
		
	}	
	
	
	public function add_edit()
	{
		$id         			 =  (int) $this->uri->segment(4,0);
		$row_data='';
		if($id>0)
		{
			$row_data=$this->meta_model->get_record_by_id($id);	
		}
		$data['row']=$row_data;
		
		$data['parentData'] = '';
		$data['heading_title'] = ($id>0)?'Edit Meta Tags':'Add Meta Tags';
		
		if(is_object($row_data))
		{
			
			$this->form_validation->set_rules('page_url','Page Url',"trim|required|max_length[200]|unique[tbl_meta_tags.page_url='".$this->db->escape_str($this->input->post('page_url'))."' AND tbl_meta_tags.meta_id !=$id]");
			$this->form_validation->set_rules('meta_title','Meta Title',"trim|required|max_length[80]");
			$this->form_validation->set_rules('meta_keyword','Meta Keyword',"trim|required|max_length[160]");
			$this->form_validation->set_rules('meta_description','Meta Description',"trim|required|max_length[160]");
		}
		else
		{
			$this->form_validation->set_rules('page_url','Page Url',"trim|required|max_length[200]|unique[tbl_meta_tags.page_url='".$this->db->escape_str($this->input->post('page_url'))."']");
			$this->form_validation->set_rules('meta_title','Meta Title',"trim|required|max_length[80]");
			$this->form_validation->set_rules('meta_keyword','Meta Keyword',"trim|required|max_length[160]");
			$this->form_validation->set_rules('meta_description','Meta Description',"trim|required|max_length[160]");
		}
		
		if($this->form_validation->run()===TRUE)
		{
			if($id >0)
			{
				$posted_data = array(
														'page_url'				=>$this->input->post('page_url'),
														'meta_title'			=>$this->input->post('meta_title'),
														'meta_keyword'		=>$this->input->post('meta_keyword'),
														'meta_description'				=>$this->input->post('meta_description')
														);
														
				$posted_data = $this->security->xss_clean($posted_data);	 
				$this->meta_model->safe_update('tbl_meta_tags',$posted_data,"meta_id ='".$id."'",FALSE);
				
				$this->session->set_userdata(array('msg_type'=>'success'));
				$this->session->set_flashdata('success',lang('successupdate'));
			}
			else
			{
				$posted_data = array(
														'page_url'				=>$this->input->post('page_url'),
														'meta_title'			=>$this->input->post('meta_title'),
														'meta_keyword'		=>$this->input->post('meta_keyword'),
														'meta_description'				=>$this->input->post('meta_description'),
														'meta_date_added'	=>$this->config->item('config.date.time')
														);
				$posted_data = $this->security->xss_clean($posted_data);		 
				$this->meta_model->safe_insert('tbl_meta_tags',$posted_data,FALSE);
				
				$this->session->set_userdata(array('msg_type'=>'success'));
				$this->session->set_flashdata('success',lang('success'));	
			}
			
			$redirect_path= 'meta';			
			redirect('sitepanel/'.$redirect_path, '');
			
		}
		$data['includes']		= $this->view_path.'addedit_view';
		$this->load->view('includes/sitepanel_container',$data);
		
	}
	
}