<?php
class Testimonial extends Admin_Controller {

  public $view_path;
  public $current_controller;

  public function __construct()
	{
    parent::__construct();

    $this->current_controller = $this->router->fetch_class();

    $this->load->model(array('testimonial_model'));
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

    $res_array = $this->testimonial_model->get_record($condtion_array);
    $config['total_rows'] = $this->testimonial_model->total_rec_found;
    $data['page_links'] = admin_pagination($base_url, $config['total_rows'], $config['limit'], $offset);
    $data['heading_title'] = "Manage Testimonial";
    $data['res'] = $res_array;


    if ($this->input->post('status_action') != '') {
      $this->update_status('tbl_testimonial', 'id');
    }

    $data['includes']		= $this->view_path.'list_view';
		
		$this->load->view('includes/sitepanel_container',$data);	
  }

  public function add()
	{
    $id = (int) $this->uri->segment(4, 0);
    $row_data = '';

    $data['heading_title'] = "Add Testimonial";
		$data['cancel_url'] 	 = "sitepanel/".$this->current_controller;

		$this->form_validation->set_rules('name', 'name', "trim|required|max_length[100]");
		$this->form_validation->set_rules('testimonail_desc', 'testimonial description', "trim|required|max_length[10000]");
		

    if($this->form_validation->run() === TRUE)
		{
			$posted_data = array(
				'created_at'  			=> $this->config->item('config.date.time'),
				'name' 							=> $this->input->post('name'),
				'testimonial_desc' 	=> $this->input->post('testimonail_desc'),
			  'status' 						=> '1',
				'created_by'				=> $this->admin_id
		  );
			
			$posted_data = $this->security->xss_clean($posted_data);
			$this->testimonial_model->safe_insert('tbl_testimonial', $posted_data, FALSE);
		 	$this->session->set_userdata(array('msg_type' => 'success'));
		 	$this->session->set_flashdata('success', lang('success'));
		 
		 $redirect_path = 'testimonial';
		 redirect('sitepanel/' . $redirect_path, '');
    }
    $data['includes'] = $this->view_path . 'add_view';
    $this->load->view('includes/sitepanel_container', $data);
  }

  public function edit()
	{
		$id = (int) $this->uri->segment(4, 0);
    $row_data = '';
    if ($id > 0) {
      $row_data = $this->testimonial_model->get_record_by_id($id);
			
			$operation_allowed=operation_allowed("tbl_testimonial",$id); 
			if(!$operation_allowed)
			{
				$this->session->set_userdata(array('msg_type'=>'error'));
				$this->session->set_flashdata('error',lang('operation_not_allowed'));
				redirect('sitepanel/testimonial');
			}
    }
    $data['row'] = $row_data;    
    $data['heading_title'] = "Edit Testimonial";
		$data['cancel_url'] 	 = "sitepanel/".$this->current_controller;
		
		$this->form_validation->set_rules('name', 'name', "trim|required|max_length[100]");
		$this->form_validation->set_rules('testimonail_desc', 'testimonial description', "trim|required|max_length[10000]");
		

    if ($this->form_validation->run() === TRUE)
		{
			$posted_data = array(				
				'name' 							=> $this->input->post('name'),
				'testimonial_desc' 	=> $this->input->post('testimonail_desc'),
				);
			$posted_data = $this->security->xss_clean($posted_data);
			$this->testimonial_model->safe_update('tbl_testimonial', $posted_data, "id ='" . $id . "'", FALSE);
	
			$this->session->set_userdata(array('msg_type' => 'success'));
			$this->session->set_flashdata('success', lang('successupdate'));
	
			$redirect_path = 'testimonial';
			redirect('sitepanel/' . $redirect_path, '');
    }
    $data['includes'] = $this->view_path . 'edit_view';
    $this->load->view('includes/sitepanel_container', $data);
  }
  

}

// End of controller