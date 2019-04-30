<?php
class Users extends Public_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->model(array('users/users_model'));
		$this->load->library(array("auth","safe_encrypt"));
		$this->load->library("dmailer");
		$this->form_validation->set_error_delimiters("<div class='required'>","</div>");
	}


	public function login(){
		
		if ( $this->auth->is_user_logged_in() ){
			redirect('member', '');
		}

		$this->load->library("user_agent");
        $ref=@$this->input->get_post('ref');
		if($ref!=''){
		  $this->session->set_userdata(array('ref'=>$ref));	
		}
		
		$user_type=0;

		$this->form_validation->set_rules('user_name', 'Username','required|valid_email');
		$this->form_validation->set_rules('password', 'Password', 'required');

		if ($this->form_validation->run() == TRUE){

			$username  =  $this->input->post('user_name');
			$password  =  $this->input->post('password');
			$rember    =  ($this->input->post('remember')!="") ? TRUE : FALSE;

			if( $this->input->post('remember')=="Y" ) {
				
				set_cookie('userName',$this->input->post('user_name'), time()+60*60*24*30 );
				set_cookie('pwd',$this->input->post('password'), time()+60*60*24*30 );
				
			}else{
				
				delete_cookie('userName');
				delete_cookie('pwd');
				
			}

			$this->auth->verify_user($username,$password,1,$user_type);
				
			if( $this->auth->is_user_logged_in() ){

				if( $this->session->userdata('ref')!=""  ){
					$rurl=$this->session->userdata('ref');
				}else{
					$rurl=site_url('member');				
				}
				$this->session->set_userdata('ref',"");
				$this->session->unset_userdata("ref");
				redirect($rurl, '');
			}else{
				$this->session->unset_userdata("ref");
				redirect('login', '');

			}
		}

		$data["title"]="Login";
		$data["user_type"]=$user_type;
		$this->load->view("login",$data);

	}
	
	



	public function forgotten_password(){

		$email = $this->input->post('email',TRUE);
		$this->form_validation->set_rules('email', ' Email ID', 'required|valid_email');
		$this->form_validation->set_rules('verification_code','Verification code','trim|required|valid_captcha_code');

		if ($this->form_validation->run() == TRUE){

			$condtion = array('field'=>"email,password,name,is_verified",'condition'=>"username ='$email' AND status ='1' ");
			$res = $this->users_model->find('tbl_users',$condtion);
			
			if( is_array($res) && !empty($res))	{
               if($res['is_verified']==1){
				$name  = $res['name'];
				$email    = $res['email'];
				$password    = $res['password'];
				$password = $this->safe_encrypt->decode($password);
				
				/* Send  mail to user */
				$content    =  get_content('tbl_auto_respond_mails','2');
				$subject    =  $content->email_subject;
				$body       =  $content->email_content;

				$verify_url = "<a href=".base_url()."login>Click here </a>";
				

				$body			=	str_replace('{mem_name}',$name,$body);
				$body			=	str_replace('{username}',$email,$body);
				$body			=	str_replace('{password}',$password,$body);
				$body			=	str_replace('{admin_email}',$this->admin_info->admin_email,$body);
				$body			=	str_replace('{site_name}',$this->site_setting['company_name'],$body);				
				$body			=	str_replace('{url}',base_url(),$body);
				$body			=	str_replace('{link}',$verify_url,$body);
               
				$mail_conf =  array(
								'subject'=>$subject,
								'to_email'=>$email,
								'from_email'=>$this->admin_info->admin_email,
								'from_name'=> $this->site_setting['company_name'],
								'body_part'=>$body
						);
						
				$this->dmailer->mail_notify($mail_conf);
				$this->session->set_userdata(array('msg_type'=>'success'));
				$this->session->set_flashdata('success',$this->config->item('forgot_password_success'));
				redirect('users/forgotten_password', '');
			   }else{
				   $this->session->set_userdata(array('msg_type'=>'error'));
				   $this->session->set_flashdata('error','Your account is not verified.Please try after some time.');
				   redirect('users/forgotten_password', '');
			   }
				
			}else{
				$this->session->set_userdata(array('msg_type'=>'error'));
				$this->session->set_flashdata('error',$this->config->item('email_not_exist'));
				redirect('users/forgotten_password', '');
			}
		}

		$data['heading_title'] = "Forgot Password";
		$this->load->view('forgot_password',$data);
	}

	public function logout()

	{

		$this->session->unset_userdata('user_id');
		$this->session->unset_userdata(array("ref"=>'0'));
		$this->session->unset_userdata('login_type');
		$this->session->unset_userdata('logged_in');
		$this->session->unset_userdata('username');
		$this->session->unset_userdata('shippingID');
		$this->session->unset_userdata('coupon_id',0);
		$this->session->unset_userdata('coupon_code',0);
		$this->session->unset_userdata('discount_amount',0);
		$this->cart->destroy();

		$this->auth->logout();

		$this->session->set_userdata(array('msg_type'=>'success'));

		$this->session->set_flashdata('success',$this->config->item('member_logout'));

		redirect("login", '');



	}



	public function thanks(){
		$data['include']='user_thanks';
		$this->load->view('container',$data);
	}

	public function register(){
		if($this->auth->is_user_logged_in()){
			$redirect_url=site_url("member");
			redirect($redirect_url, 'refresh');
		}
		
		
		$this->form_validation->set_rules('email','Email','trim|required|valid_email|max_length[80]|callback_email_check');
		$this->form_validation->set_rules('password','Password','trim|required|min_length[6]|max_length[10]|valid_password');
		$this->form_validation->set_rules('confirm_password', 'Confirm password', 'required|matches[password]');
		$this->form_validation->set_rules('name','Name','trim|required|max_length[50]');
		$this->form_validation->set_rules('mobile','Mobile','trim|required|max_length[30]');
		$this->form_validation->set_rules('verification_code','Verification code','trim|required|valid_captcha_code');
		$this->form_validation->set_rules('remember','Terms and Conditions','trim|required');
		
		if ($this->form_validation->run() === TRUE){
			$password  =  $this->safe_encrypt->encode($this->input->post('password'));
			$email  =  $this->input->post('email');
			
			
			$posted_data=array(
			                'user_type'	    => $this->input->post("user_type"),
							'email'			=> $email,
							'access_key'    => md5($email),
							'username'		=> $email,
							'password'		=> $password,
							"name"          => $this->input->post("name"),
							"mobile"	    => $this->input->post("mobile"),
							'created_at'	=> $this->config->item('config.date.time'),
							'last_login_date' => $this->config->item('config.date.time'),
							'status'		=> '1',
							'is_verified'	=> '0',
							'verify_code'	=>random_string('numeric',4),
							'ip_address'  	=> $this->input->ip_address());

			$posted_data = $this->security->xss_clean($posted_data);
			$registerId=$this->users_model->safe_insert('tbl_users',$posted_data);
			$this->session->set_userdata("register_verify_id",$registerId);
			$mrid=md5($registerId);
			$this->users_model->safe_update('tbl_users',array('access_key'=>$mrid),array("id"=>$registerId),FALSE);

			if($registerId !=''){
				
				$content    =  get_content('tbl_auto_respond_mails','1');
				$subject    =  str_replace('{site_name}',$this->site_setting['company_name'],$content->email_subject);
				$body       =  $content->email_content;
				$ack_key    = md5($email);

				$verify_url = "<a href='".site_url('users/verify/'.$mrid)."'>Click here Verify Your account </a>";

				$body			=	str_replace('{mem_name}','Member',$body);
				$body			=	str_replace('{username}',$this->input->post('email'),$body);
				$body			=	str_replace('{password}',$this->input->post('password'),$body);
				$body			=	str_replace('{admin_email}',$this->admin_info->admin_email,$body);
				$body			=	str_replace('{site_name}',$this->site_setting['company_name'],$body);
				$body			=	str_replace('{url}',base_url(),$body);
				$body			=	str_replace('{link}',$verify_url,$body);

				$mail_conf =  array(
								'subject'=>$subject,			
								'to_email'=>$this->input->post('email'),			
								'from_email'=>$this->admin_info->admin_email,			
								'from_name'=> $this->site_setting['company_name'],			
								'body_part'=>$body);
					
                
				$this->dmailer->mail_notify($mail_conf);

				$data=array();
				$mess="";
				$data["config"]['mailtype']="html";
				$data["subject"]="New  Registration :: ".$this->site_setting['company_name'];
				$mess='';

				$mess.="Hello Administrator,"."<br><br><br>";
				$mess.="New User Registration. User login details are as follow: "."<br><br>";
				$mess.="Email ID - ".$email."<br>";
				$mess.="Password - ".$this->input->post('password')."<br><br>";
				$mess.="<a href='".base_url()."' target='_blank' >".$this->site_setting['company_name']."</a><br>";
				$data["mess"]=$mess."";
				$this->dmailer->send($data);
				/* End send  mail to user */

				$redirect_url=($ref_url!='')?$ref_url:site_url('member');

				$this->session->set_userdata(array('msg_type'=>'success'));
				$this->session->set_flashdata('success',"Thanks for registration. The welcome Email from '".$this->site_setting['company_name']."' with the link to confirm your registration was sent to your email.<br>
				 Click on the link in the email to confirm your registration. If you don't receive the email within 30 minutes, please check your Spam mailbox.");

				redirect('users/thankyou/');
			}
		}

		$data["title"]="Register";
		$this->load->view("register",$data);
	}
	
	

	public function register_verify(){
		$data["title"]="Register Verify";

		$registerId=(int)$this->session->userdata("register_verify_id");
		if($registerId==0)redirect('register');
		$this->form_validation->set_rules('verify_code','verify code','trim|required|max_length[5]|callback_check_verify_code');

		if ($this->form_validation->run() === TRUE){
				
			$this->users_model->safe_update('tbl_users',array('is_mobile_verify'=>1),array("id"=>$registerId),FALSE);
				
			$this->session->unset_userdata("register_verify_id");
				
			$this->session->set_userdata(array('msg_type'=>'success'));
			$this->session->set_flashdata('success',"Thanks for verification mobile.");
			redirect('users/thankyou');
				
		}

		$data["registerId"]=$registerId;
		$this->load->view("register_verify",$data);
	}

	public function check_verify_code(){
		$registerId=(int)$this->session->userdata("register_verify_id");
		$verify_code=get_db_field_value('tbl_users','verify_code', array("id"=>$registerId));

		if($verify_code == $this->input->post("verify_code"))return TRUE;
		$this->form_validation->set_message('check_verify_code',"Invalid Verification Code");
		return FALSE;
	}

	public function email_check()

	{

		$email = $this->input->post('email');

		if ($this->users_model->is_email_exits(array('email' => $email,"id !="=>1)))

		{

			$this->form_validation->set_message('email_check', lang('exists_user_id'));

			return FALSE;

		}

		else

		{

			return TRUE;

		}

	}





	public function valid_captcha_code($verification_code)

	{

		if($this->securimage_library->check($verification_code) == true)

		{

			return TRUE;

		}

		else

		{

			$this->form_validation->set_message('valid_captcha_code', 'The Word verification code you have entered is invalid.');

			return FALSE;

		}

	}



	public function verify()

	{

		$this->users_model->activate_account($this->uri->segment(3) );

	}


	
	
	public function thankyou(){
	   
	   $data['page_title']="Thank you";	
	   $this->load->view("thankyou_view",$data);
	   	
	}
	
	public function resendemail(){
	  
	     $data['page_title']="Resend email";
		 
		 if($this->input->post('action')=='Add'){
			
	        
			$this->form_validation->set_rules('email', ' Email ID', 'required|valid_email|callback_validmem');
			if ($this->form_validation->run() == TRUE)
				{
			  $rsdata=get_db_single_row("tbl_users","username,name,password,id"," AND username='".$this->input->post('email')."'");
			$content    =  get_content('tbl_auto_respond_mails','1');

				$subject    =  str_replace('{site_name}',$this->site_setting['company_name'],$content->email_subject);
				$body       =  $content->email_content;
				
				$password = $this->safe_encrypt->decode($rsdata['password']);

				$verify_url = "<a href='".site_url('users/verify/'.md5($rsdata['id']))."'>Click here Verify Your account </a>";

				$body			=	str_replace('{mem_name}',$rsdata['name'],$body);
				$body			=	str_replace('{username}',$rsdata['username'],$body);
				$body			=	str_replace('{password}',$password,$body);
				$body			=	str_replace('{admin_email}',$this->admin_info->admin_email,$body);
				$body			=	str_replace('{site_name}',$this->site_setting['company_name'],$body);
				$body			=	str_replace('{url}',base_url(),$body);
				$body			=	str_replace('{link}',$verify_url,$body);

				$mail_conf =  array(
								'subject'=>$subject,			
								'to_email'=>$this->input->post('email'),			
								'from_email'=>$this->admin_info->admin_email,			
								'from_name'=> $this->site_setting['company_name'],			
								'body_part'=>$body);
					
				$this->dmailer->mail_notify($mail_conf);
				$this->session->set_userdata(array('msg_type'=>'success'));
			    $this->session->set_flashdata('success',"Account activation link has been sent to your email.");
				redirect('users/resendemail');
				}
		 }
		 $this->load->view("resend_email",$data);
	}
	
	public function validmem(){
	  $email=$this->input->post('email');
	  if($email){
		
		$rwdata=get_db_single_row("tbl_users","id"," AND username ='$email'");
		if(!is_array($rwdata) && count($rwdata)==0){
		  $this->form_validation->set_message('validmem','Email id is not exists.Please try again!!!');	
		  return false;
		}
		  
	  }
	}


}

/* End of file user.php */

/* Location: ./application/modules/user/controller/user.php */