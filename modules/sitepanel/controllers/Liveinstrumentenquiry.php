<?php
class Liveinstrumentenquiry extends  Admin_Controller{

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
	     $pagesize                =  (int) $this->input->get_post('pagesize');
	     $config['limit']		  =  ( $pagesize > 0 ) ? $pagesize : $this->config->item('pagesize');
		 $offset                  =  ( $this->input->get_post('per_page') > 0 ) ? $this->input->get_post('per_page') : 0;	
		 $base_url                =  current_url_query_string(array('filter'=>'result'),array('per_page'));		
		 $condition               =  "status !='2' ";
		 $keyword                 = $this->db->escape_str( $keyword );
		if($keyword!='')
		{
		   $condition.=" AND  ( email like '%$keyword%' OR  name like '%$keyword%' ) ";
		}	
		$res_array              = $this->careerenquiry_model->get_liveinsenquiry($offset,$config['limit'],$condition);	
		$config['total_rows']	= $this->careerenquiry_model->total_rec_found;	
		$data['page_links']     =  admin_pagination($base_url,$config['total_rows'],$config['limit'],$offset);	

		if( $this->input->post('status_action')!='')
		{			
		  $this->update_status('tbl_live_instrument_enquiry','id');			
		}
		$data['heading_title']  = 'Manage Live Instrument Enquiry';
		$data['inq_type']       = 'General';	
		$data['res']            = $res_array; 			
		$this->load->view('enquiry/view_liveinscareer_list',$data);

	}
	
	public function downloadfile(){
		
		$this->load->helper('download');
		$id=(int)$this->uri->segment(4);
		$condition               =  "status !='2' AND id='$id' ";
		$res_array              = $this->careerenquiry_model->get_liveinsenquiry(0,1,$condition);
		$res=$res_array[0];
		if(is_array($res) && count($res) > 0 ){
			
			if($res['upd_file']!='' && file_exists(UPLOAD_DIR.'/order_file/'.$res['upd_file'])){
				$pth    =   file_get_contents(base_url()."uploaded_files/order_file/".$res['upd_file']);
				$nme    =   $res['upd_file'];
				force_download($nme, $pth);  
			}
		}
	}
	
	public function send_reply(){
		$id=(int)$this->uri->segment(4);
		$condition               =  "status !='2' AND id='$id' ";
		$res  = $this->careerenquiry_model->get_liveinsenquiry(0,1,$condition);
		
		$data['res']  = $res[0];
		$data['id']=$id;
		if($this->input->post('action')=='Add'){
			$this->form_validation->set_rules('admin_reply', 'Admin Reply', 'trim|required|max_length[888850]');
			if($this->form_validation->run()==TRUE)
			{
			  $admin_reply=$this->input->post('admin_reply',TRUE);
			  
			  $postdata=array(
			                  'admin_reply'=>$this->input->post('admin_reply',TRUE)
							 );
				$postdata=$this->security->xss_clean($postdata);
				$where = "id = '".$id."'";
				$this->careerenquiry_model->safe_update('tbl_live_instrument_enquiry',$postdata,$where,FALSE);
			 $this->session->set_userdata(array('msg_type'=>'success'));
			 $this->session->set_flashdata('success','Reply has been sent successfully.');
			 ?>
             <script>
			 window.opener.location.reload();
			 window.close();
			 </script>
			 <?php
			}
		}
		$this->load->view('enquiry/view_livesendreply_list',$data);
	}


	
}

// End of controller