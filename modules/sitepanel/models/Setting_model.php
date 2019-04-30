<?php
if (!defined('BASEPATH'))
  exit('No direct script access allowed');

class Setting_model extends MY_Model {
  public $tbl_name;

  public function __construct() {
    parent::__construct();
    $this->tbl_name = "tbl_users";

  }

  public function get_admin_info($id) {
    $id = (int) $id;
    if ($id != '' && is_numeric($id)) {
      $condtion = "user_type = 1";
      $fetch_config = array(
          'condition' => $condtion,
          'debug' => FALSE,
          'return_type' => "object"
      );
      $result = $this->find($this->tbl_name, $fetch_config);
      return $result;
    }
  }


	public function update_password($old_pass, $id) {
    $cond = "id =$id AND password ='$old_pass' ";
    $num_row = $this->findCount($this->tbl_name, $cond);
    if ($num_row > 0) {
      $data = array(
          'password' => $this->input->post('new_pass', TRUE)          

      );
      $where = "id =" . $id . " ";
      $this->safe_update($this->tbl_name, $data, $where, FALSE);
      $this->session->set_userdata('msg_type', "success");
      $this->session->set_flashdata('success', lang('successupdate'));
    } else {

      $this->session->set_userdata(array('msg_type' => 'error'));
      $this->session->set_flashdata('error', lang('password_incorrect'));
    }
  }


  public function update_info($id) {	
	$data = array(
				'email' => $this->input->post('admin_email', TRUE),
				'address' => $this->input->post('address', TRUE),		
				'mobile' =>$this->input->post('phone', TRUE),	
				);
      $where = "user_type =1";
      $this->safe_update($this->tbl_name, $data, $where, FALSE);
      $this->session->set_userdata('msg_type', "success");
      $this->session->set_flashdata('success', lang('successupdate'));   

  }
  public function get_setting_data() {
    $this->db->order_by("id", "DESC");
    $qry = $this->db->get("tbl_settings");
    if ($qry->num_rows() > 0) {
      $res = $qry->result_array();
      return $res;
    }

  }
  
	public function get_info_data() {
		
	$this->db->where("id", "1");     
    $qry = $this->db->get("tbl_admin_settings");	
    if ($qry->num_rows() > 0) {
      $res = $qry->result_array();
      return $res;
    }

  }


}



// model end here