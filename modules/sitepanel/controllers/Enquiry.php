<?php

class Enquiry extends  Admin_Controller{



	public function __construct()

	{		

		parent::__construct(); 			

		$this->load->model(array('sitepanel/enquiry_model'));  

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
		 $condition               =  "status !='2' AND type ='2' ";
		 $keyword                 = $this->db->escape_str( $keyword );
		if($keyword!='')
		{
		   $condition.=" AND  ( email like '%$keyword%' OR  first_name like '%$keyword%' OR  last_name like '%$keyword%' OR CONCAT_WS(' ',first_name,last_name) LIKE '%".$keyword."%'  ) ";
		}	
		$res_array              = $this->enquiry_model->get_enquiry($offset,$config['limit'],$condition);	
		$config['total_rows']	= $this->enquiry_model->total_rec_found;	
		$data['page_links']     =  admin_pagination($base_url,$config['total_rows'],$config['limit'],$offset);	

		if( $this->input->post('status_action')!='')
		{			
		  $this->update_status('tbl_enquiry','id');			
		}
		$data['heading_title']  = 'Manage Contact us Enquiry';
		$data['inq_type']       = 'General';	
		$data['res']            = $res_array; 			
		$this->load->view('enquiry/view_enquiry_list',$data);

	}

	

	public function send_reply()

	{

		$rid =  (int) $this->uri->segment(4);

		$this->db->select("*",FALSE);

		$res_data =  $this->db->get_where('tbl_enquiry', array('id' =>$rid))->row();

	   

		if( is_object( $res_data ) )

		{

			$this->form_validation->set_rules('subject', 'Subject', 'required');	

			$this->form_validation->set_rules('message', 'Message', 'required');

			

			if ($this->form_validation->run() == TRUE)

			{

				//Reply mail to Sender

				

				$this->enquiry_model->safe_update('tbl_enquiry',array("reply_status"=>"Y"),array("id"=>$rid));

				

				//$content    =  get_content('tbl_auto_respond_mails','23');

				//$body       =  $content->email_content;



				$body=$this->input->post("message");

				

				$name=$res_data->first_name." ".($res_data->last_name?$res_data->last_name:"");

				$subject  =  $this->input->post('subject'); 

				$body=$this->input->post("message");

				

				

				$mail_to=$res_data->email;

				
				$mail_conf =  array(
									'subject'    => $subject,
									'to_email'   => $mail_to,
									'from_email' => $this->admin_info->email,
									'from_name'  => $this->site_setting['company_name'],
									'body_part'  => $body
				                   );
				$this->dmailer->mail_notify($mail_conf);

				// End mailing				

				

				$this->session->set_userdata(array('msg_type'=>'success'));

				$this->session->set_flashdata('success',lang('admin_mail_msg'));

									

				redirect('sitepanel/enquiry/send_reply/'.$res_data->id, '');			

							

		}

		$data['heading_title'] = "Send Reply";

		$this->load->view('enquiry/view_send_enq_reply',$data);

		

	}

	else

	{

		redirect('sitepanel/enquiry/','');

	}

	

	

 }

	

	

	

		

}

// End of controller