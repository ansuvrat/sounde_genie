<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Users_model extends MY_Model

{



	/**

	* Get account by id

	*

	* @access public

	* @param string $account_id

	* @return object account object

	*/

	public function create_seller()

	{

		   

		   

		  $step1_data=unserialize($this->session->userdata('step1'));

		  $step2_data=unserialize($this->session->userdata('step2'));

		  $step3_data=unserialize($this->session->userdata('step3'));

		  $step4_data=unserialize($this->session->userdata('step4'));

		  $step5_data=unserialize($this->session->userdata('step5'));

		  $step6_data=unserialize($this->session->userdata('step6'));

		  $step7_data=unserialize($this->session->userdata('step7'));

		  $step8_data=unserialize($this->session->userdata('step8'));

		  $step9_data=unserialize($this->session->userdata('step9')); 

		   

		  $password = $this->safe_encrypt->encode($step1_data['password']);

		  $cat_id=implode(",",$step1_data['category_id']);

		  $name = $step4_data['first_name']." ".$step4_data['last_name'];	

			$register_array1 = array

			( 					

				'user_type'        => '3',

				'access_key'       => md5($step1_data['email']),

				'category_id'      => $cat_id,

				'email'            => $step1_data['email'],

				'username'         => $step1_data['email'],

				'password'         => $password,

				'mem_nature'	   => '1',

				'first_name'       => $step4_data['first_name'],

				'last_name'        => $step4_data['last_name'],

				'name'        	   => $name,

				'mobile'           => $step2_data['mobile_no'],

				'verify_code'      => $this->session->userdata('smspin'),

				'last_login_date'  => $this->config->item('config.date.time'),

				'status'		   => '1',

				'is_verified'	   => '0',									

				'ip_address'  	   => $this->input->ip_address()

				

			);

			

			$insId =  $this->safe_insert('tbl_users',$register_array1,FALSE);

			

			

			if(file_exists('uploaded_files/temp_docs/'.$this->session->userdata('pan_register'))){

				

			copy('uploaded_files/temp_docs/'.$this->session->userdata('pan_register'), 'uploaded_files/user_documents/'.$this->session->userdata('pan_register'));

			

			}

			

			

			if(file_exists('uploaded_files/temp_docs/'.$this->session->userdata('company_register'))){

				

			copy('uploaded_files/temp_docs/'.$this->session->userdata('company_register'), 'uploaded_files/user_documents/'.$this->session->userdata('company_register'));

			

			}

			

			if($this->input->post('same_pickup')==''){

				$step4_data['bill_address']    =$step4_data['pick_address'];

				$step4_data['bill_landmark']   =$step4_data['pick_landmark'];

				$step4_data['bill_city_id']    =$step4_data['pick_city_id'];

				$step4_data['bill_state_id']   =$step4_data['pick_state_id'];

				$step4_data['bill_country_id'] =$step4_data['pick_country_id'];

				$step4_data['bill_pincode']    =$step4_data['pick_pincode'];

			}

			

			$register_array2 = array

			( 					

				'seller_id'       	  => $insId,

				'salutation'      	  => $step4_data['title'],

				'first_name'      	  => $step4_data['first_name'],

				'last_name'       	  => $step4_data['last_name'],

				'company_name'     	  => $step4_data['company_name'],

				'company_display_name'=> $step4_data['company_display_name'],

				'communication_email' => $step4_data['communication_email'],

				'pick_address'        => $step4_data['pick_address'],

				'pick_landmark'       => $step4_data['pick_landmark'],

				'pick_city'           => $step4_data['pick_city_id'],

				'pick_state'          => $step4_data['pick_state_id'],

				'pick_country'        => $step4_data['pick_country_id'],

				'pick_pincode'        => $step4_data['pick_pincode'],

				'bill_address'        => $step4_data['bill_address'],

				'bill_landmark'       => $step4_data['bill_landmark'],

				'bill_city'           => $step4_data['bill_city_id'],

				'bill_state'          => $step4_data['bill_state_id'],

				'bill_country'        => $step4_data['bill_country_id'],

				'bill_pincode'        => $step4_data['bill_pincode'],

				'know_trinity_employee'=> $step4_data['do_you_know'],

				'tan_no'			  => $step6_data['tan_number'],

				'comp_reg_no'		  => $step6_data['company_registration'],

				'website_url'		  => $step6_data['website'],

				'tan_reg_copy'		  => $this->session->userdata('pan_register'),

				'comp_reg_copy'		  => $this->session->userdata('company_register')

				

				

			);

			$insId2 =  $this->safe_insert('tbl_seller_company_details',$register_array2,FALSE);

			

			if(file_exists('uploaded_files/temp_docs/'.$this->session->userdata('pan_registration_copy'))){

				

			copy('uploaded_files/temp_docs/'.$this->session->userdata('pan_registration_copy'), 'uploaded_files/user_documents/'.$this->session->userdata('pan_registration_copy'));

			

			}

			

			

			if(file_exists('uploaded_files/temp_docs/'.$this->session->userdata('vat_tin_cst'))){

				

			copy('uploaded_files/temp_docs/'.$this->session->userdata('vat_tin_cst'), 'uploaded_files/user_documents/'.$this->session->userdata('vat_tin_cst'));

			

			}

			

			if(file_exists('uploaded_files/temp_docs/'.$this->session->userdata('cancelled_cheque'))){

				

			copy('uploaded_files/temp_docs/'.$this->session->userdata('cancelled_cheque'), 'uploaded_files/user_documents/'.$this->session->userdata('cancelled_cheque'));

			

			}

			

			$register_array3 = array

			( 					

				'pan_no'       		=> $step5_data['pan_number'],

				'vat_gct_no'        => $step5_data['vat_gst'],

				'tin_no'        	=> $step5_data['tin_no'],

				'cst_no'     		=> $step5_data['cst_no'],

				'neft_ifsc_code'	=> $step5_data['ifsc_code'],

				'bank_name' 		=> $step5_data['bank_name'],

				'bank_code'         => $step5_data['bank_code'],

				'branch_name'       => $step5_data['branch_name'],

				'beneficiary_name'  => $step5_data['beneficiary_name'],

				'account_no'        => $step5_data['account_number'],

				'account_type'      => $step5_data['accuont_type'],

				'pan_reg_copy'      => $this->session->userdata('pan_registration_copy'),

				'vat_tin_cst_copy'  => $this->session->userdata('vat_tin_cst'),

				'cancel_cheque_copy'=> $this->session->userdata('cancelled_cheque')

				

			);

			$insId3 =  $this->safe_insert('tbl_seller_bank_details',$register_array3,FALSE);

			return $insId;

			   

	}

	

	

	

	public function create_buyer()

	{

		    $password = $this->safe_encrypt->encode($this->input->post('password'));

			$register_array1 = array

			( 					

				'user_type'        => '3',

				'access_key'       => md5($this->input->post('email')),

				'email'            => $this->input->post('email'),

				'username'         => $this->input->post('email'),

				'password'         => $password,

				'mem_nature'	   => '2',

				'last_login_date'  => $this->config->item('config.date.time'),

				'status'		   => '1',

				'is_verified'	   => '1',									

				'ip_address'  	   => $this->input->ip_address()

				

			);

			

			$insId =  $this->safe_insert('tbl_users',$register_array1,FALSE);

			return $insId;

	}





	public function is_email_exits($data)

	{

		$this->db->select('id');

		$this->db->from('tbl_users');

		$this->db->where($data);	

		$this->db->where('status !=', '2');

		

		$query = $this->db->get();

		if ($query->num_rows() == 1)

		{

			return TRUE;

			

		}else

		{

			return FALSE;

	

		}

		

	}	

	public function is_mobile_exits($data)

	{

		$this->db->select('id');

		$this->db->from('tbl_users');

		$this->db->where($data);	

		$this->db->where('status !=', '2');

		

		$query = $this->db->get();

		if ($query->num_rows() == 1)

		{

			return TRUE;

			

		}else

		{

			return FALSE;

	

		}

		

	}	



	public function logout()

	{

		$data = array(

		'user_id' => 0,

		'email' => 0,

		'name'=>0,

		'user_photo'=>0,

		'logged_in' => FALSE

		);		

		$this->session->sess_destroy();

		$this->session->unset_userdata($data);

	}

	

	public function activate_account($key)

	{		

		$is_verified=get_db_field_value('tbl_users','is_verified', array('access_key'=>$key));

		

		if($is_verified==0){		

	   	 	$this->db->query("update tbl_users set is_verified='1' where access_key='".$key."'");	

			$this->session->set_userdata(array('msg_type'=>'success'));

			$this->session->set_flashdata('success',"Your account has been activated successfully.");

		}else{

			$this->session->set_userdata(array('msg_type'=>'success'));

			$this->session->set_flashdata('success',"Your account has been already activated.");

		}

		redirect('login');		

	}

	

	

}

/* End of file users_model.php */

/* Location: ./application/modules/users/models/users_model.php */