<?php
class Newsletter_templates extends Admin_Controller {

  public $view_path;
  public $current_controller;

  public function __construct()
	{
    parent::__construct();

    $this->current_controller = $this->router->fetch_class();

    $this->load->model(array('newsletter_templates_model'));
    $this->config->set_item('menu_highlight', 'miscellaneous');

    $this->view_path = $this->current_controller . "/";
  }

  public function index()
	{
    $pagesize = (int) $this->input->get_post('pagesize');
    $config['limit'] = ( $pagesize > 0 ) ? $pagesize : $this->config->item('pagesize');
    $offset = ( $this->input->get_post('per_page') > 0 ) ? $this->input->get_post('per_page') : 0;
    $base_url = current_url_query_string(array('filter' => 'result'), array('per_page'));

    $condtion = " ";
    $condtion_array = array(
        'condition' => $condtion,
        'limit' => $config['limit'],
        'offset' => $offset,
        'debug' => FALSE
    );

    $res_array = $this->newsletter_templates_model->get_record($condtion_array);
    $config['total_rows'] = $this->newsletter_templates_model->total_rec_found;
    $data['page_links'] = admin_pagination($base_url, $config['total_rows'], $config['limit'], $offset);
    $data['heading_title'] = "Manage Newsletter Templates";
    $data['res'] = $res_array;


    if ($this->input->post('status_action') != '') {
      $this->update_status('tbl_newsletter_templates', 'id');
    }

    $data['includes']		= $this->view_path.'list_view';
		
		$this->load->view('includes/sitepanel_container',$data);	
  }


  public function edit()
	{
		$id = (int) $this->uri->segment(4, 0);
    $row_data = '';
    if ($id > 0) {
      $row_data = $this->newsletter_templates_model->get_record_by_id($id);
			
			if($this->admin_type==2)
			{
				$this->session->set_userdata(array('msg_type'=>'error'));
				$this->session->set_flashdata('error',lang('operation_not_allowed'));
				redirect('sitepanel/newsletter_templates');
			}
    }
		
		$data['ckeditor']  =  set_ck_config(array('textarea_id'=>'template_text'));		
    $data['row'] = $row_data;    
    $data['heading_title'] = "Edit Templates";
		$data['cancel_url'] 	 = "sitepanel/".$this->current_controller;
		
		$this->form_validation->set_rules('template_title', 'Size Title', "trim|required|unique[tbl_newsletter_templates.template_title='".$this->db->escape_str($this->input->post('template_title'))."' AND status!='2' AND id !=$id]");
		
		$this->form_validation->set_rules('template_text', 'Content', "trim|required_stripped");
		

    if ($this->form_validation->run() === TRUE)
		{
			$posted_data = array(				
				'template_title' => $this->input->post('template_title'),
				'template_text'  => $this->input->post('template_text'),
				'update_date'  	 => $this->config->item('config.date.time')
				);
			$posted_data = $this->security->xss_clean($posted_data);
			$this->newsletter_templates_model->safe_update('tbl_newsletter_templates', $posted_data, "id ='" . $id . "'", FALSE);
	
			$this->session->set_userdata(array('msg_type' => 'success'));
			$this->session->set_flashdata('success', lang('successupdate'));
	
			$redirect_path = 'newsletter_templates';
			redirect('sitepanel/' . $redirect_path, '');
    }
    $data['includes'] = $this->view_path . 'edit_view';
    $this->load->view('includes/sitepanel_container', $data);
  }
	
	public function template_view()
	{
		$id=(int) $this->uri->segment(4);
		$template_dtl=get_db_single_row("tbl_newsletter_templates","template_text",array("id"=>$id));
		
		$data['template_text']	='';
		
		if(is_array($template_dtl) && count($template_dtl) > 0)
		{
			$data['template_text']=$template_dtl['template_text'];
		}
		
		$data['template_id']=$id;
		
		$this->load->view($this->view_path.'template_view',$data);		
		
	}
  

}

// End of controller