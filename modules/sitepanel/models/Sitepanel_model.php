<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sitepanel_model extends CI_Model{

	

	public $tbl_name;

  public function __construct(){

	  

		  parent::__construct(); 

		  $this->tbl_name="tbl_users";

 }  

 public function check_admin_login($data)

 {

	 $query = $this->db->get_where($this->tbl_name,$data,1);
     

	 if ($query->num_rows() > 0)

	 {

		 $row = $query->row_array();
         $name=$row['name'];
		 $sess_arr = array(

				           'admin_user' => $row['username'],

				           'adm_key'    => $row['access_key'],

				           'admin_type' => $row['user_type'],

				           'admin_id' 	=> $row['id'],

							'admin_name' 	=> $name,

				           'admin_logged_in' => TRUE

				           );

	 

	   $this->session->set_userdata($sess_arr);	  

	   

	 }else{	

	   $this->session->set_userdata(array('msg_type'=>'error'));		

	   $this->session->set_flashdata('error', 'Invalid username/password');

	   redirect('sitepanel');	

	

	 }

	 

 }

 



 



}

/* End of file mstudent.php */

/* Location: ./system/application/models/mstudent.php */