<?php
class Googleads extends Admin_Controller {

  public $view_path;
  public $current_controller;

  public function __construct()
	{
    parent::__construct();

    $this->current_controller = $this->router->fetch_class();

    $this->load->model(array('googleads/googleads_model'));
    $this->config->set_item('menu_highlight','miscellaneous');

    $this->view_path = $this->current_controller . "/";		
		
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

		$res_array              =  $this->googleads_model->getgoogleads($condtion_array);

		$config['total_rows']	=  $this->googleads_model->total_rec_found;

		$data['page_links']     =  admin_pagination($base_url,$config['total_rows'],$config['limit'],$offset);

		$data['heading_title']  =  'Google Ads';
		$data['res']            =  $res_array;
		$data['parent_id']      =  $parent_id;

		if( $this->input->post('status_action')!='')
		{
			$this->update_status('tbl_google_ads','gad_id');
		}
		if( $this->input->post('update_order')!='')
		{
			$this->update_displayOrder('tbl_google_ads','sort_order','gad_id');
		}

		$data['includes']		= $this->view_path.'view_googleads_list';
		$this->load->view('includes/sitepanel_container',$data);	
		//$this->load->view('googleads/view_googleads_list',$data);

	}

	public function add()
	{
		$data['heading_title'] = 'Add Google Ad';
		
		$this->form_validation->set_rules('gad_content','Google Ad Content',"trim|required");
		
		if($this->form_validation->run()===TRUE)
		{
			#-------------------MAX SORT ORDER------------#
			$this->db->select_max('sort_order');
			$query = $this->db->get('tbl_google_ads');
			$max_sort_order= $query->row_array();
			$max_sort_orders=$max_sort_order['sort_order']+1;
			#--------------------------------------------#
			$posted_data = array(
			'gad_content'=>$this->input->post('gad_content'),
			'sort_order'=>$max_sort_orders,			
			'gad_date_added'=>$this->config->item('config.date.time')
			);
			
			$this->googleads_model->safe_insert('tbl_google_ads',$posted_data,FALSE);
			
			$this->session->set_userdata(array('msg_type'=>'success'));
			$this->session->set_flashdata('success',lang('success'));
			redirect('sitepanel/googleads', '');

		}
		
		$data['includes']		= $this->view_path.'view_googleads_add';
		$this->load->view('includes/sitepanel_container',$data);	
		//$this->load->view('googleads/view_googleads_add',$data);
		
	}

	public function edit()
	{
		$gadId = (int) $this->uri->segment(4);
		
		$rowdata=$this->googleads_model->get_googlead_by_id($gadId);
		$gadId = $rowdata['gad_id'];
		$data['heading_title'] = 'Google Ad';

		if( !is_array($rowdata) )
		{
			$this->session->set_flashdata('message', lang('idmissing'));
			redirect('sitepanel/googleads', '');
		}

		$this->form_validation->set_rules('gad_content','Google Ad Content',"trim|required");
		
		if($this->form_validation->run()==TRUE)
		{
			$posted_data = array(
			'gad_content'=>$this->input->post('gad_content'),
			'gad_date_updated'=>$this->config->item('config.date.time')
			);
			
			$where = "gad_id = '".$gadId."'";
			$this->googleads_model->safe_update('tbl_google_ads',$posted_data,$where,FALSE);
			
			$this->session->set_userdata(array('msg_type'=>'success'));
			$this->session->set_flashdata('success',lang('successupdate'));
			
			redirect('sitepanel/googleads'.'/'.query_string(), '');
			
		}

		$data['res']=$rowdata;
		
		$data['includes']		= $this->view_path.'view_googleads_edit';
		$this->load->view('includes/sitepanel_container',$data);	
		//$this->load->view('googleads/view_googleads_edit',$data);

	}

}
// End of controller