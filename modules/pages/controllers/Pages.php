<?php
class Pages extends Public_Controller{

	public function __construct()
	{

		parent::__construct();
		$this->load->model(array('pages/pages_model'));
		$this->load->helper(array('file'));
		$this->load->library(array('Dmailer'));
		$this->form_validation->set_error_delimiters("<div class='required'>","</div>");

	}

	public function index()

	{
		$friendly_url = ($this->uri->segment(1)=="pages")?$this->uri->segment(2):$this->uri->segment(1);
		$condition       = array('friendly_url'=>$friendly_url,'status'=>'1');
		$content         =  $this->pages_model->get_cms_page( $condition );
		$data['content'] = $content;
		$this->load->view('pages/cms_page_view',$data);

	}

	public function error_404()
	{
		$data['include']='error_404_view';
		$this->load->view('error_404_view',$data);
	}



	public function clear_cache()
	{
		$path = UPLOAD_DIR.'/thumb_cache';
		$dir_handle = @opendir($path) or die("Unable to open folder");
		while (false !== ($file = readdir($dir_handle)))
		{
			if($file!='.' && $file!='..')
			{
				unlink($path.'/'.$file);
			}
		}
		closedir($dir_handle);
		echo 'All cached data have been removed.';
	}



	public function unauthorize_access()
	{
		$data['page_name'] = 'OOPS!';
		$data['page_description'] 		= "<span style='color:red;'>OOPS! You are not authorized to access ".base_url().". For access please contact to website administrator.</span>";
		$data['include']='cms_page_view';
		$this->load->view('cms_page_view',$data);
	}



	public function thankyou()
	{
		$data['page_heading'] = 'Thanks';
		$this->load->view('thankyou',$data);
	}



	public function contactus()
	{
		$data['title'] = 'Contact Us';
		$this->form_validation->set_rules('first_name','First name','trim|required|max_length[90]');
		$this->form_validation->set_rules('email','Email id','trim|required|valid_email|max_length[80]');
		$this->form_validation->set_rules('mobile_number','Mobile no.','trim|required|max_length[15]|numeric');
		$this->form_validation->set_rules('comment','Comment/Messsage','trim|required|max_length[8500]');
		$this->form_validation->set_rules('verification_code','Verification code','trim|required|valid_captcha_code');


		if($this->form_validation->run()==TRUE)
		{

			$name=$this->input->post('first_name').' '.$this->input->post('last_name');
			$posted_data=array(
								'type'		 	=> '2',	
								'first_name'    => $this->input->post('first_name'),
								'email'        	=> $this->input->post('email'),
								'mobile_number' => $this->input->post('mobile_number'),
								'message'      	=> $this->input->post('comment'),		
								'receive_date'  => $this->config->item('config.date.time')
							 );
			$posted_data = $this->security->xss_clean($posted_data);
			$this->pages_model->safe_insert('tbl_enquiry',$posted_data,FALSE);
			$content  =  get_content('tbl_auto_respond_mails','5');
			$subject  =  $content->email_subject;
			$subject  =	str_replace('{site_name}',$this->site_setting['company_name'],$subject);
			$body     =  $content->email_content;
			
			$body	  =	str_replace('{mem_name}',"Admin",$body);
			$body	  =	str_replace('{name}',$name,$body);
			$body	  =	str_replace('{email}',$this->input->post('email'),$body);
			$body	  =	str_replace('{mobile}',$this->input->post('mobile_number'),$body);
			$body	  =	str_replace('{comments}',$this->input->post('comment'),$body);
			$body	  =	str_replace('{admin_email}',$this->admin_info->email,$body);
			$body	  =	str_replace('{site_name}',$this->config->item('site_name'),$body);
			$body	  =	str_replace('{base_url}',base_url(),$body);
			
			$mail_conf =  array(
								 'subject'    => $subject,
								 'to_email'   => $this->admin_info->admin_email,
								 'from_email' => $this->input->post('email'),
								 'from_name'  => $name,
								 'body_part'  => $body
							   );
            
			$this->dmailer->mail_notify($mail_conf);

			//Confirmation to visitor
			$body   =  $content->email_content;
			$body	=  str_replace('{mem_name}',$name,$body);
			$body	  =	str_replace('{name}',$name,$body);
			$body	=  str_replace('{email}',$this->input->post('email'),$body);
			$body	=  str_replace('{mobile}',$this->input->post('mobile_number'),$body);
			$body	=  str_replace('{comments}',$this->input->post('comment'),$body);
			$body	=  str_replace('{admin_email}',$this->admin_info->email,$body);
			$body	  =	str_replace('{site_name}',$this->config->item('site_name'),$body);
			$body	=  str_replace('{base_url}',base_url(),$body);

			$mail_conf =  array(
								'subject'    => $subject,
								'to_email'   => $this->input->post('email'),
								'from_email' => $this->admin_info->admin_email,
								'from_name'  => $this->site_setting['company_name'],												                                'body_part'  => $body
			                  );

			$this->dmailer->mail_notify($mail_conf);
			$this->session->set_userdata("msg_type","success");
			$this->session->set_flashdata('success', lang('enquiry_success'));
			redirect('contact-us', '');

		}
		
		$this->load->view('contactus',$data);

	}

	public function newsletter(){

		
		$data['page_heading'] = 'Newsletter';
		$this->form_validation->set_rules('subscriber_name','Name','trim|required|max_length[50]');
		$this->form_validation->set_rules('subscriber_email','Email id','trim|required|valid_email|max_length[100]');
		$this->form_validation->set_rules('verification_code','Verification code','trim|required|valid_captcha_code');

		if($this->form_validation->run()==TRUE){

			$sub_type=$this->input->post('sub_type')=='N'?'unsub':"sub";
            
			if($sub_type=="sub"){
				$is_email_exists=count_record("tbl_newsletters","subscriber_email ='".$this->input->post('subscriber_email')."' AND status ='1'");

				if($is_email_exists>0){
					$this->session->set_userdata(array('msg_type'=>'error'));
					$this->session->set_flashdata('error', 'You are already exist in our subscriber list');
				}else{
					$subscr_name=$this->input->post('subscriber_name');
					$posted_data=array(
					'subscriber_name'   => $this->input->post('subscriber_name'),
					'subscriber_email'  => $this->input->post('subscriber_email'),
					'subscribe_date'    => $this->config->item('config.date.time')
				);

					$posted_data = $this->security->xss_clean($posted_data);
					$this->pages_model->safe_insert('tbl_newsletters',$posted_data,FALSE);

					//Confirmation to visitor
					$body    = read_file(FCROOT."assets/email-template/confirmation.htm");
					$subject =  "Thanks for subscribe our newletter service";
					$content =	 "Thanks for subscribe our newletter service";
					$body	 =	str_replace('{mem_name}',$subscr_name,$body);
					$body	 =	str_replace('{content}',$content,$body);
					$body	 =	str_replace('{site_name}',$this->site_setting['company_name'],$body);
					$body	 =	str_replace('{admin_email}',$this->admin_info->email,$body);
					$body	 =	str_replace('{base_url}',base_url(),$body);

					$mail_conf =  array(
									'subject'    => $subject,
									'to_email'   => $this->input->post('subscr_email'),
									'from_email' => $this->admin_info->email,
									'from_name'  => $this->site_setting['company_name'],
									'body_part'  => $body);

					$this->dmailer->mail_notify($mail_conf);
					$this->session->set_userdata(array('msg_type'=>'success'));
					$this->session->set_flashdata('success', lang('sub_newsletter'));
				}
			}elseif($sub_type=="unsub"){

				$is_email_exists=count_record("tbl_newsletters","subscriber_email ='".$this->input->post('subscr_email')."' AND status ='1'");

				if($is_email_exists>0){
					$this->db->query("delete from tbl_newsletters where subscriber_email ='".$this->input->post('subscr_email')."'");
					$this->session->set_userdata(array('msg_type'=>'success'));
					$this->session->set_flashdata('success', lang('unsub_newsletter'));
				}
				else
				{
					$this->session->set_userdata(array('msg_type'=>'error'));
					$this->session->set_flashdata('error', 'You are not available in our subscriber list for unsubscribe.');
				}
			}
			redirect('pages/newsletter', '');
		}
		$this->load->view('newsletter_view',$data);
	}

	public function refer_to_friends(){
		 
		$productId        = (int) $this->uri->segment(3);
		$product_link_url =  base_url()."products/detail/$productId";

		$data['heading_title'] = "Refer to a Friend";
		$this->form_validation->set_rules('your_name','Name','trim|required|alpha|max_length[100]');
		$this->form_validation->set_rules('your_email','Email','trim|required|valid_email|max_length[100]');
		$this->form_validation->set_rules('friend_name','Friend\'s Name','trim|required|alpha|max_length[100]');
		$this->form_validation->set_rules('friend_email','Friend\'s Email','trim|required|valid_email|max_length[100]');

		if($this->form_validation->run()==TRUE){

			$your_name     = $this->input->post('your_name',TRUE);
			$your_email    =  $this->input->post('your_email',TRUE);
			$friend_name   = $this->input->post('friend_name',TRUE);
			$friend_email  = $this->input->post('friend_email',TRUE);
			$content    =  get_content('tbl_auto_respond_mails','3');
			$body       =  $content->email_content;

			if($productId > 0 )
			{
				$link_url = $product_link_url;
				$link_url= "<a href=".$link_url.">Click here </a>";
				$text ="Product";
				$this->session->set_userdata(array('msg_type'=>'success'));
				$this->session->set_flashdata('success',$this->config->item('product_referred_success'));

			}else
			{
				$link_url = base_url();
				$link_url= "<a href=".$link_url.">Click here </a>";
				$text ="Site";
				$this->session->set_userdata(array('msg_type'=>'success'));
				$this->session->set_flashdata('success',$this->config->item('site_referred_success'));
			}
			$body			=	str_replace('{friend_name}',$friend_name,$body);
			$body			=	str_replace('{your_name}',$your_name,$body);
			$body			=	str_replace('{site_name}',$this->site_setting['company_name'],$body);
			$body			=	str_replace('{text}',$text,$body);
			$body			=	str_replace('{site_link}',$link_url,$body);

			$mail_conf =  array(
							'subject'=>"Invitation from ".$your_name." to see",
							'to_email'=>$friend_email,
							'from_email'=>$your_email,
							'from_name'=>$your_name,
							'body_part'=>$body);
			$this->dmailer->mail_notify($mail_conf);
			$this->session->set_userdata(array('msg_type'=>'success'));
			$this->session->set_flashdata('success',$this->config->item('product_referred_success'));
			redirect('pages/refer_to_friends', '');
			$this->load->view('pages/view_refer_to_friend',$data);

		}
		$this->load->view('pages/view_refer_to_friend',$data);
	}


	public function invoice_pop()
	{

		$this->load->helper('invoice');
		$order_no=$this->input->get_post('order_no');
		echo get_invoice($order_no);

	}

	public function join_newsletter()
	{

		$subscriber_name        = $this->input->post('subscriber_name',TRUE);
		$subscriber_email       = $this->input->post('subscriber_email',TRUE);
		$subscribe_me           = $this->input->post('subscribe_me',TRUE);
		$this->form_validation->set_error_delimiters("<div class='red fs12 b' >","</div>");
		$this->form_validation->set_rules('subscriber_name', 'Name', "trim|required|alpha|max_length[32]");
		$this->form_validation->set_rules('subscriber_email', 'Email ID', "trim|required|valid_email|max_length[80]");

		if ($this->form_validation->run() == TRUE)

		{

			$posted_data = array( 'subscriber_name'=>$subscriber_name,'subscriber_email'=>$subscriber_email,'subscribe_me'=>$subscribe_me);
			$result      =  $this->subscribe_newsletter($posted_data);

			if( $result )

			{

				echo '<div style="color:#FF0000; font-weight:bold;">'.$result.'</div>';

			}

		}else

		{

			header('Content-type: text/json');
			echo json_encode(array('error'=>validation_errors()));

			//echo '<div style="color:#FF0000"><font size="-1">'.validation_errors().'</font></div>';

		}

	}
	
	
	public function join_newslettermb()

	{

		$subscriber_name        = $this->input->post('subscriber_name1',TRUE);
		$subscriber_email       = $this->input->post('subscriber_email1',TRUE);
        $subscribe_me           = $this->input->post('subscribe_me',TRUE);
		
		$this->form_validation->set_error_delimiters("<div class='red fs12 b' >","</div>");

		$this->form_validation->set_rules('subscriber_name1', 'Name', "trim|required|alpha|max_length[32]");

		$this->form_validation->set_rules('subscriber_email1', 'Email ID', "trim|required|valid_email|max_length[80]");
       $this->form_validation->set_rules('verificationcodemb','Verification code','trim|required|valid_captcha_code');
		if ($this->form_validation->run() == TRUE)

		{

			$posted_data = array( 'subscriber_name'=>$subscriber_name,'subscriber_email'=>$subscriber_email,'subscribe_me'=>$subscribe_me);

			$result      =  $this->subscribe_newsletter($posted_data);

			if( $result )

			{

				echo '<div style="color:#0000FF; font-weight:bold;">'.$result.'</div>';

			}

		}else
		{

			header('Content-type: text/json');
			echo json_encode(array('error'=>validation_errors()));
			//echo '<div style="color:#FF0000"><font size="-1">'.validation_errors().'</font></div>';
		}
	}

	private function subscribe_newsletter($posted_data)

	{

		$query = $this->db->query("SELECT subscriber_email,status FROM  tbl_newsletters WHERE subscriber_email='$posted_data[subscriber_email]'");

		$subscribe_me  = $posted_data['subscribe_me'];



		if( $query->num_rows() > 0 )

		{

			$row = $query->row_array();

			if( $row['status']=='0' && ($subscribe_me=='Y') )

			{

				$where = "subscriber_email = '".$row['subscriber_email']."'";

				$this->pages_model->safe_update('tbl_newsletters',array('status'=>'1'),$where,FALSE);

				$msg =  $this->config->item('newsletter_subscribed');

				return $msg;

			}else if($row['status']=='0' && ($subscribe_me=='N'))

			{

				$msg =  $this->config->item('newsletter_not_subscribe');

				return $msg;

			}else if($row['status']=='1' && ($subscribe_me=='Y'))

			{

				$msg =  $this->config->item('newsletter_already_subscribed');

				return $msg;

			}else if($row['status']=='1' && ($subscribe_me=='N'))

			{

				$where = "subscriber_email = '".$row['subscriber_email']."'";

				$this->pages_model->safe_update('tbl_newsletters',array('status'=>'0'),$where,FALSE);

				$msg =  $this->config->item('newsletter_unsubscribed');

				return $msg;

			}

		}else

		{

			if($subscribe_me=='N' )

			{

				$msg =  $this->config->item('newsletter_not_subscribe');

				return $msg;

			}else

			{

				$data =  array('status'=>'1', 'subscriber_name'=>$posted_data['subscriber_name'], 'subscriber_email'=>$posted_data['subscriber_email']);

				$this->pages_model->safe_insert('tbl_newsletters',$data);

				$msg =  $this->config->item('newsletter_subscribed');

				return $msg;

			}

		}

	}



	public function unsubscribe(){

		$subscribe_id=$this->uri->segment(3);



		$this->pages_model->safe_update('tbl_newsletters',array('status'=>'0'),array("md5(subscriber_id)"=>$subscribe_id),FALSE);



		$msg =  $this->config->item('newsletter_unsubscribed');

		$this->session->set_userdata(array('msg_type'=>'success'));

		$this->session->set_flashdata('success',$msg);

		redirect("pages/thanks");

	}
	public function thanks(){

		$this->load->view('thanks')	;

	}
	public function sitemap(){
		$this->load->view('sitemap')	;

	}
	
	public function career(){
		
		$data['page_heading']="Career";
		$data['rwcontArr']=get_db_multiple_row("tbl_country","id,country_name","status ='1' ORDER BY country_name ASC");
		$data['rwdesArr']=get_db_multiple_row("tbl_designation","id,designation","status ='1' ORDER BY designation ASC");
		$data['rwnatArr']=get_db_multiple_row("tbl_nationality","id,nationality","status ='1' ORDER BY nationality ASC");
		
		if($this->input->post('action')=='Add'){
			
			$this->form_validation->set_rules('name','Name','trim|required|alpha|max_length[100]');
			$this->form_validation->set_rules('family_name','Family Name','trim|max_length[100]');
			$this->form_validation->set_rules('contact_no','Contact No.','trim|required|max_length[100]');
			$this->form_validation->set_rules('email','Email','trim|required|max_length[100]|valid_email');
			$this->form_validation->set_rules('dob','Date of birth','trim|required|max_length[100]');
			$this->form_validation->set_rules('gnder','Gender','trim|required|max_length[100]');
			$this->form_validation->set_rules('nationality','Nationality','trim|required|max_length[100]');
			$this->form_validation->set_rules('country','Country of Residence','trim|required|max_length[100]');
			$this->form_validation->set_rules('marital_status','Marital Status','trim|required|max_length[100]');
			$this->form_validation->set_rules('hear_from_us','How did you hear from us','trim|required|max_length[100]');
			$this->form_validation->set_rules('designation','Designation Applying For','trim|required|max_length[100]');
			$this->form_validation->set_rules('image1','Resume',"file_required|file_allowed_type[document]");
			$this->form_validation->set_rules('verification_code','Verification code','trim|required|valid_captcha_code');
			if ($this->form_validation->run() == TRUE){
			    
				$uploaded_file = "";
				if( !empty($_FILES) && $_FILES['image1']['name']!='' )
				{
				
					$this->load->library('upload');
					$uploaded_data =  $this->upload->my_upload('image1','resume');
					if( is_array($uploaded_data)  && !empty($uploaded_data) )
					{
						$uploaded_file = $uploaded_data['upload_data']['file_name'];
					}
				}
				
				$posted_data = array(
								'post_date'   => $this->config->item('config.date.time'),
								'name'       => $this->input->post('name'),
								'family_name'       => $this->input->post('family_name'),
								'contact_no'       => $this->input->post('contact_no'),
								'email'       => $this->input->post('email'),
								'dob'       => $this->input->post('dob'),
								'gnder'       => $this->input->post('gnder'),
								'nationality'       => $this->input->post('nationality'),
								'country'       => $this->input->post('country'),
								'marital_status'       => $this->input->post('marital_status'),
								'hear_from_us'       => $this->input->post('hear_from_us'),
								'designation'       => $this->input->post('designation'),
								'resume'      => $uploaded_file,
								'status'        =>1
								);
				$this->pages_model->safe_insert('tbl_career',$posted_data,FALSE);
				$this->session->set_userdata(array('msg_type'=>'success'));
				$this->session->set_flashdata('success',"Information has been added successfully.We will back to you soon.");
				redirect('career', '');
			
		    }
			
		}
		$this->load->view("career",$data);
	}
	
	public function services(){
	  
	  $data['page_title']="Services";
	  
		$composition         = '';
		$lyrics              = '';
		$mixing              = '';
		$mastering           = '';
		$composition_youtube = '';
		$lyrics_youtube      = '';
		$mixing_youtube      = '';
		$mastering_youtube   = '';
	  
	    $rwdata=get_db_multiple_row("tbl_cms_youtube","youtube_url,description,type","status ='1' ");
		if(is_array($rwdata) && count($rwdata) > 0 ){
		  foreach($rwdata as $mVal){
			  if($mVal['type']==1){
				 $composition=$mVal['description'];  
				 $composition_youtube=$mVal['youtube_url']; 
			  }
			  if($mVal['type']==2){
				 $lyrics=$mVal['description']; 
				 $lyrics_youtube=$mVal['youtube_url'];  
			  }
			  if($mVal['type']==3){
				 $mixing=$mVal['description']; 
				 $mixing_youtube=$mVal['youtube_url'];   
			  }
			  if($mVal['type']==6){
				 $mastering=$mVal['description'];  
				 $mastering_youtube=$mVal['youtube_url'];  
			  }
		  }
		}
		
		$data['composition']         = $composition;
		$data['composition_youtube'] = $composition_youtube;
		$data['lyrics']              = $lyrics;
		$data['lyrics_youtube']      = $lyrics_youtube;
		$data['mixing']              = $mixing;
		$data['mixing_youtube']      = $mixing_youtube;
		$data['mastering']           = $mastering;
		$data['mastering_youtube']   = $mastering_youtube;
		
		$recording_desc='';
		$recording_youtube='';
		$designing_desc='';
		$designing_youtube='';
		
		if(is_array($rwdata) && count($rwdata) > 0){
			foreach($rwdata as $cval){
				if($cval['type']==4){
					
					$recording_desc=$cval['description'];
		            $recording_youtube=$cval['youtube_url'];
				}
				if($cval['type']==5){
					
					$designing_desc=$cval['description'];
		            $designing_youtube=$cval['youtube_url'];
				}
			}
		}
		$data['recording_desc']=$recording_desc;
		$data['recording_youtube']=$recording_youtube;
		$data['designing_desc']=$designing_desc;
		$data['designing_youtube']=$designing_youtube;
		
		
	  $this->load->view("services_view",$data);
		
	}
 
	
}