<?php
class Careerenquiry extends  Admin_Controller{

	public function __construct()

	{		
		parent::__construct(); 			
		$this->load->model(array('sitepanel/careerenquiry_model'));  
		$this->load->helper(array('file'));	 
		$this->load->library(array('Dmailer'));
		$this->config->set_item('menu_highlight','miscellaneous');	

	}

	public  function index()
	{	

	     $keyword                 =  trim($this->input->post('keyword',TRUE));
		 $from_date = $this->db->escape_str(trim($this->input->get_post('from_date',TRUE)));
		 $to_date   = $this->db->escape_str(trim($this->input->get_post('to_date',TRUE)));
	     $pagesize                =  (int) $this->input->get_post('pagesize');
	     $config['limit']		  =  ( $pagesize > 0 ) ? $pagesize : $this->config->item('pagesize');
		 $offset                  =  ( $this->input->get_post('per_page') > 0 ) ? $this->input->get_post('per_page') : 0;	
		 $base_url                =  current_url_query_string(array('filter'=>'result'),array('per_page'));		
		 $condition               =  "status !='2' ";
		 $keyword                 = $this->db->escape_str( $keyword );
		if($keyword!='')
		{
		   $condition.=" AND  ( email like '%$keyword%' OR  name like '%$keyword%' OR  contact_no like '%$keyword%' ) ";
		}
		if($from_date!='' && $to_date ==''){
			$condition.=" AND DATE(post_date) ='$from_date'";
		}
		if($from_date=='' && $to_date !=''){
			$condition.=" AND DATE(post_date) ='$to_date'";
		}
		if($from_date!='' && $to_date !=''){
			$condition.=" AND DATE(post_date) BETWEEN '$from_date' AND '$to_date' ";
		}
		
		$res_array              = $this->careerenquiry_model->get_enquiry($offset,$config['limit'],$condition);	
		$config['total_rows']	= $this->careerenquiry_model->total_rec_found;	
		$data['page_links']     =  admin_pagination($base_url,$config['total_rows'],$config['limit'],$offset);	

		if( $this->input->post('status_action')!='')
		{			
		  $this->update_status('tbl_career','id');			
		}
		$data['heading_title']  = 'Manage Career Enquiry';
		$data['inq_type']       = 'General';	
		$data['res']            = $res_array; 			
		$this->load->view('enquiry/view_career_list',$data);

	}

	public function viewresume(){
		
		$this->load->helper('download');
		$id=(int)$this->uri->segment(4);
		$condition               =  "status !='2' AND id='$id' ";
		$res_array              = $this->careerenquiry_model->get_enquiry(0,1,$condition);
		$res=$res_array[0];
		if(is_array($res) && count($res) > 0 ){
			
			if($res['resume']!='' && file_exists(UPLOAD_DIR.'/resume/'.$res['resume'])){
				$pth    =   file_get_contents(base_url()."uploaded_files/resume/".$res['resume']);
				$nme    =   $res['resume'];
				force_download($nme, $pth);  
			}
		}
	}

	
}

// End of controller