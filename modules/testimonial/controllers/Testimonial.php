<?php
class Testimonial extends Public_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('testimonial/testimonial_model'));
		$this->form_validation->set_error_delimiters("<div class='required'>","</div>");

	}



	public function index()
	{
		$data['rwbanarr']=get_db_multiple_row("tbl_banners","banner_url,banner_image","status ='1' AND banner_position='3' ORDER BY RAND() LIMIT 0,2");
		$record_per_page    = (int) $this->input->post('per_page');
		$config['per_page']	= ( $record_per_page > 0 ) ? $record_per_page : $this->config->item('per_page');
		$offset             = (int) $this->uri->segment(3,0);
		//$next				= $offset+$config['per_page'];
		$offset             = (int) $this->input->post('offset');
		$base_url           = "testimonial";
		$param              = array('status'=>'1');
		$res_array          = $this->testimonial_model->get_testimonial($config['per_page'],$offset,$param);
		$total_rows	        = get_found_rows();
		$sconfig['is_ajax_replace_data']=true;
		//$data['page_links']      = front_pagination("$base_url",$total_rows	,$config['per_page'],3,$sconfig);
		$data['title'] = 'Testimonials';
		$data['totalProduct'] = $total_rows;
		$data['res'] = $res_array;
		$data['frm_url'] = $base_url;
		if($this->input->is_ajax_request())
			$this->load->view('testimonial/testimonial_data',$data);
		else
			$this->load->view('testimonial/view_testimonials',$data);
	}

	public function post()
	{

		$this->form_validation->set_rules('email','Email','trim|required|valid_email|max_length[80]');
		$this->form_validation->set_rules('name','Name','trim|required|alpha|max_length[30]');
		$this->form_validation->set_rules('testimonial_desc','Description','trim|required|max_length[8500]');
		$this->form_validation->set_rules('verification_code','Verification code','trim|required|valid_captcha_code');

		if($this->form_validation->run()==TRUE)
		{

			$posted_data=array(
			'name'             => $this->input->post('name'),
			'email'            => $this->input->post('email'),
			'testimonial_desc' => $this->input->post('testimonial_desc'),						
			'created_at'       => $this->config->item('config.date.time')
			);
			$testimonial_id=$this->testimonial_model->safe_insert('tbl_testimonial',$posted_data,FALSE);
			$message = $this->config->item('testimonial_post_success');
			$message = str_replace('<site_name>',$this->site_setting['company_name'],$message);
			$this->session->set_userdata(array('msg_type'=>'success'));
			$this->session->set_flashdata('success',$message);			
			redirect('testimonial/post');

		}
		$this->load->view("view_post_testimonial");
	}
   
	public function details()
	{
		$id      = (int) $this->uri->segment(3);
		$param   = array('status'=>'1','where'=>"id ='$id' ");
		$res     = $this->testimonial_model->get_testimonial(1,0,$param);

		if(is_array($res) && !empty($res))
		{
			$data['title'] = 'Testimonials';
			$data['res']   = $res[0];
			$this->load->view('testimonial/testimonials_details_view',$data);

		}else
		{
			redirect('testimonial', '');
		}
	}
}
/* End of file pages.php */
?>