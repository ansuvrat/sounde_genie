<?php
class Servicecontent extends Admin_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('servicecontent_model'));
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
		$res_array              =  $this->servicecontent_model->getservicecontent($condtion_array);
		$config['total_rows']	=  $this->servicecontent_model->total_rec_found;
		$data['page_links']     =  admin_pagination($base_url,$config['total_rows'],$config['limit'],$offset);
		$data['heading_title']  =  'Manage Service Contents';
		$data['res']            =  $res_array;
		$data['parent_id']      =  $parent_id;
		$this->load->view('servicecontent/view_content_list',$data);

	}

	

	public function edit()
	{
		$id = (int) $this->uri->segment(4);
		$rowdata=$this->servicecontent_model->get_servicecontent_by_id($id);
		$data['heading_title'] = 'Edit Service Contents';
       
		if( !is_array($rowdata) )
		{
		  $this->session->set_flashdata('message', lang('idmissing'));
		  redirect('sitepanel/servicecontent', '');
		}
		$this->form_validation->set_rules('youtube_url','Youtube Url/Embeded code',"trim|required|max_length[88850]");
		$this->form_validation->set_rules('description','Description',"trim|required|max_length[888850]");
	

		if($this->form_validation->run()==TRUE)
		{
			$youtube_url = get_Youtube_Id($this->input->post('youtube_url'));
			$posted_data = array(
			                     'youtube_url'=>$youtube_url,
			                     'description'=>$this->input->post('description')
			                    );
            $posted_data=$this->security->xss_clean($posted_data);
			$where = "id = '".$id."'";
			$this->servicecontent_model->safe_update('tbl_cms_youtube',$posted_data,$where,FALSE);
			$this->session->set_userdata(array('msg_type'=>'success'));
			$this->session->set_flashdata('success',lang('successupdate'));
			redirect('sitepanel/servicecontent'.'/'.query_string(), '');
		}
		$data['res']=$rowdata;
		$this->load->view('servicecontent/view_content_edit',$data);

	}

}
// End of controller