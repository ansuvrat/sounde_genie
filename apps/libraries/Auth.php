<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Auth{

	public function __construct()
	{
		if (!isset($this->ci)){
			$this->ci =& get_instance();
		}
		$this->ci->load->library('session','safe_encrypt');
		$this->ci->load->helper('cookie');
	}

	public function is_user_logged_in(){
		if ($this->ci->session->userdata('logged_in') == TRUE){

			$user_data = array(
			   'username'=>$this->ci->session->userdata('username'),	  
			   'status'=>'1'	
			   );

			   $num = $this->ci->db->get_where('tbl_users',$user_data)->num_rows();
			   return ($num) ? true : false;
		}else{
			return false;
		}
	}

	public function is_auth_user()
	{
		if ($this->is_user_logged_in()!= TRUE){
			$this->logout();
			$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
			$this->ci->session->set_userdata('ref',$actual_link);
			redirect('login', '');
		}
	}

	public function update_last_login($login_data)
	{
		$data = array('last_login_date'=>$login_data['last_login_date'],'last_login_date'=>$this->ci->config->item('config.date.time') );
		$this->ci->db->where('id', $this->ci->session->userdata('user_id'));
		$this->ci->db->update('tbl_users', $data);
	}

	public function verify_user($username,$password,$status='1'){

		$password = $this->ci->safe_encrypt->encode($password);

		$this->ci->db->select("id,username,name,user_type,last_login_date,status,mobile",FALSE);

		$this->ci->db->where('username', $username);
		$this->ci->db->where('password', $password);
		$this->ci->db->where("(status ='".$status."' ) ");
		$this->ci->db->where('is_verified','1');
		$this->ci->db->where('is_block','0');
		$query = $this->ci->db->get('tbl_users');

		if ($query->num_rows() == 1){

			$row  = $query->row_array();

			$name = ucwords($row['name']);
			
			$data = array(
						'sessuser_type'=>$row['user_type'],
						'user_id'=>$row['id'],
						'username'=>$row['username'],
						'name'=>$name,
						'mobile'=>$row['mobile'],
						'last_login_date'=>$row['last_login_date'],
						'logged_in' => TRUE
			);
			$login_data = array('last_login_date'=>$row['last_login_date']);
			$this->ci->session->set_userdata($data);
			$this->ci->session->set_userdata('session_id', session_id());	
			$this->update_last_login($login_data);
			return true;
		}else{
			$this->ci->session->set_userdata(array('msg_type'=>'error'));
			$this->ci->session->set_flashdata('error',lang('invalid_user_password'));
		}
	}
	/**

	* Logout - logs a user out

	* @access public

	*/


	public function logout(){
		
		$userId = $this->ci->session->userdata('id');
		$this->ci->session->unset_userdata('session_id');
		$data = array(		
					'id' => 0,
					'type'=> 0,
					'login_type'=>0,
					 'username' => 0,
					 'name'=>0,
					 'mkey'=>0,
					 'blocked_time'=>0,
					 'logged_in' => FALSE
		);
		$this->ci->session->unset_userdata($data);
		//$this->ci->session->sess_destroy();
	}
}