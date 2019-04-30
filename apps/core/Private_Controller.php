<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Private_Controller extends MY_Controller{

	public $userId;
	public $name;
	public $user_type;	

	 public function __construct(){
		 parent::__construct();	    
		 $this->load->library(array('Auth'));
    	 $this->auth->is_auth_user();	 		 		 

		 $this->userId = (int) $this->session->userdata('user_id');
		 $this->name = $this->session->userdata('name');	
		 $this->username = $this->session->userdata('username'); 
		 $this->userType = $this->session->userdata('sessuser_type');
		 $this->mobile = $this->session->userdata('mobile');
		 $this->last_login = $this->session->userdata('last_login_date');
	 }
} 