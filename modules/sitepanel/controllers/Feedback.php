<?php

class Feedback extends  Admin_Controller{



	public function __construct()

	{		

		parent::__construct(); 			

		$this->load->model(array('sitepanel/feedback_model'));

		$this->load->helper(array('file'));	 

		$this->load->library(array('Dmailer'));  

		$this->config->set_item('menu_highlight','miscellaneous');	

	}



	public  function index()

	{

		$keyword                 =  trim($this->input->post('keyword',TRUE));

	  $pagesize                =  (int) $this->input->get_post('pagesize');

	  $config['limit']		  	 =  ( $pagesize > 0 ) ? $pagesize : $this->config->item('pagesize');

		$offset                  =  ( $this->input->get_post('per_page') > 0 ) ? $this->input->get_post('per_page') : 0;	

		$base_url                =  current_url_query_string(array('filter'=>'result'),array('per_page'));		

		$condition               =  "status !='2' AND enq_type ='2'";

		$keyword                 = $this->db->escape_str( $keyword );

		if($keyword!='')

		{

			$condition.=" AND  ( email like '%$keyword%' OR  name like '%$keyword%') ";

		}	

		$res_array              = $this->feedback_model->get_feedback($offset,$config['limit'],$condition);	

		$config['total_rows']		= $this->feedback_model->total_rec_found;	

		$data['page_links']     =  admin_pagination($base_url,$config['total_rows'],$config['limit'],$offset);	

		

		if( $this->input->post('status_action')!='')

		{			

		  $this->update_status('tbl_contactus','id');			

		}

			

		$data['heading_title']  = 'Manage Feedback';

		$data['inq_type']       = 'General';	

		$data['res']            = $res_array; 			

		$this->load->view('feedback/view_feedback_list',$data);

	

	}

	

	public function send_reply()

	{

		$rid =  (int) $this->uri->segment(4);

		$this->db->select("*,name",FALSE);

		$res_data =  $this->db->get_where('tbl_contactus', array('id' =>$rid))->row();

	   

		if( is_object( $res_data ) )

		{

			$this->form_validation->set_rules('subject', 'Subject', 'required');	

			$this->form_validation->set_rules('message', 'Message', 'required');

			

			if ($this->form_validation->run() == TRUE)

			{

				//Reply mail to Sender

				$body = read_file(FCROOT."assets/email-template/confirmation.htm");

				$subject  =  $this->input->post('subject'); 

				$content	=	 $this->input->post('message');

				$body			=	str_replace('{mem_name}',$res_data->name,$body);

				$body			=	str_replace('{content}',$content,$body);

				

				$body			=	str_replace('{site_name}',$this->site_setting['company_name'],$body);

				$body			=	str_replace('{admin_email}',$this->admin_info->email,$body);

				$body			=	str_replace('{base_url}',base_url(),$body);

				

				$mail_conf =  array(

													'subject'    => $subject,

													'to_email'   => $mail_to,

													'from_email' => $from_email,

													'from_name'  => $from_name,

													'body_part'  => $body

													);

				$this->dmailer->mail_notify($mail_conf);

				// End mailing				

				

				$this->session->set_userdata(array('msg_type'=>'success'));

				$this->session->set_flashdata('success',lang('admin_mail_msg'));

									

				redirect('sitepanel/feedback/send_reply/'.$res_data->id, '');			

							

		}

		$data['heading_title'] = "Send Reply";

		$this->load->view('feedback/view_send_enq_reply',$data);

		

	}

	else

	{

		redirect('sitepanel/feedback/','');

	}

	

	

 }

		

}

// End of controller