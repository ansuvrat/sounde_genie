<?php
class Faqs extends Public_Controller
{

	public function __construct()
	{
		parent::__construct(); 
		$this->load->model(array('faqs/faq_model'));
		$this->load->helper(array('query_string'));		

	}

	public function index()
	{  
        
		$data['rwbanarr']=get_db_multiple_row("tbl_banners","banner_url,banner_image","status ='1' AND banner_position='3' ORDER BY RAND() LIMIT 0,2");
		
		$record_per_page        = (int) $this->input->post('per_page');
		$parent_segment         = (int) $this->uri->segment(3);
		$page_segment           = find_paging_segment();
		$config['per_page']		= 100;//( $record_per_page > 0 ) ? $record_per_page :$this->config->item('per_page');
		$offset                 = (int) $this->input->post('offset');
		//$offset               =  (int) $this->uri->segment($page_segment,0);
		$parent_id              = ( $parent_segment > 0 ) ?  $parent_segment : '0';
		$base_url               = ( $parent_segment > 0 ) ?  "faq/index/$parent_id" : "faq/index";
		$param = array("where"=>"status = '1'","orderby"=>'display_order ASC');
		$res_array               = $this->faq_model->get_faq($config['per_page'],$offset,$param);
		$total_rows = get_found_rows();
		$config['total_rows']	= $total_rows;
		$data['totalProduct'] = $total_rows;
		//$data['page_links']      = front_pagination("$base_url",$config['total_rows'],$config['per_page'],$page_segment);
		$data['title'] = "FAQ's";
		$data['res'] = $res_array;
		$data['frm_url'] = $base_url;
		if($this->input->is_ajax_request())
		{
			$this->load->view('faqs/faq_data',$data);
		}
		else
		{
			$this->load->view('faqs/view_faq',$data);
		}
	}

}

?>