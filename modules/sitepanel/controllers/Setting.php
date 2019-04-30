<?php
class Setting extends Admin_Controller {
	public function __construct() {

		parent::__construct();
		$this->load->helper('ckeditor');
		$this->load->model(array('sitepanel/setting_model'));
		$this->config->set_item('menu_highlight', 'miscellaneous');

	}

	public function index($page = null) {
		$data['heading_title'] = 'Admin Setting';
		$data['admin_info'] = $this->setting_model->get_admin_info(1);
		
		$data["site_info"]=get_db_single_row('tbl_admin_settings','*', array('id'=>1));
		if($this->input->post('action')=='Update Password'){
			$this->edit();
		}else{
			$this->edit_info();
		}
		$this->load->view('dashboard/setting_edit_view', $data);
	}

	public function edit() {

		
		$this->form_validation->set_rules('old_pass', 'Old Password', 'required');
		$this->form_validation->set_rules('new_pass', 'New Password', 'required|valid_password');
		$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[new_pass]');

		if ($this->form_validation->run() == TRUE) {
			$this->setting_model->update_password($this->input->post('old_pass'), '1');
			redirect('sitepanel/setting/', '');
		}
	}

	public function edit_info(){

		
		$img_allow_size =  $this->config->item('allow.file.size');
		$img_allow_dim  =  $this->config->item('allow.imgage.dimension');
		
		
		$this->form_validation->set_rules('header_logo','Header Logo',"file_allowed_type[image]|file_size_max[$img_allow_size]|check_dimension[$img_allow_dim]");
		$this->form_validation->set_rules('footer_logo','Footer Logo',"file_allowed_type[image]|file_size_max[$img_allow_size]|check_dimension[$img_allow_dim]");
		$this->form_validation->set_rules('invoice_logo','Invoice Logo',"file_allowed_type[image]|file_size_max[$img_allow_size]|check_dimension[$img_allow_dim]");
		$this->form_validation->set_rules('copy_right', 'Copy Right',  'required');
		$this->form_validation->set_rules('company_name', 'Company Name',  'required');
		
		$this->form_validation->set_rules('admin_email', 'Email ID', 'required|valid_email');
				
		$this->form_validation->set_rules('phone', 'phone', 'trim|required|max_length[30]|min_length[8]');		
		$this->form_validation->set_rules('facebook', 'Facebook', 'trim|prep_url|max_length[255]');
		$this->form_validation->set_rules('twitter', 'twitter', 'trim|prep_url|max_length[255]');
		$this->form_validation->set_rules('linkdin', 'linkdin', 'trim|prep_url|max_length[255]');
		$this->form_validation->set_rules('gplus', 'gplus', 'trim|prep_url|max_length[255]');
		$this->form_validation->set_rules('youtube', 'youtube', 'trim|prep_url|max_length[255]');
		$this->form_validation->set_rules('instagram', 'Instagram', 'trim|prep_url|max_length[255]');
		$this->form_validation->set_rules('google_anylitical_code', 'Google anylitical code', 'trim|max_length[500]');

		if ($this->form_validation->run() == TRUE) {
			//trace($this->input->post("copy_right"));
			//exit;
		$rowdata=$this->setting_model->get_info_data();					
	$unlink_image1 = array('source_dir'=>"logo",'source_file'=>$rowdata[0]['header_logo']);
	 $unlink_image2 = array('source_dir'=>"logo",'source_file'=>$rowdata[0]['footer_logo']);
	  $unlink_image3 = array('source_dir'=>"logo",'source_file'=>$rowdata[0]['invoice_logo']); 
	  
	
						
			$uploaded_file = $rowdata[0]['header_logo'];				
			 if( !empty($_FILES) && $_FILES['header_logo']['name']!='' )
			 {
				$this->load->library('upload');
				$uploaded_data =  $this->upload->my_upload('header_logo','logo');
				if( is_array($uploaded_data)  && !empty($uploaded_data) )
				{
						$uploaded_file = $uploaded_data['upload_data']['file_name'];
						removeImage($unlink_image1);
				}
	
			}	
		
			$uploaded_file1 = $rowdata[0]['footer_logo'];		
			 if( !empty($_FILES) && $_FILES['footer_logo']['name']!='' )
			 {
				$this->load->library('upload');
				$uploaded_data1 =  $this->upload->my_upload('footer_logo','logo');
				if( is_array($uploaded_data1)  && !empty($uploaded_data1) )
				{
						$uploaded_file1 = $uploaded_data1['upload_data']['file_name'];
						removeImage($unlink_image2);
				}
	
			}		
						
			$uploaded_file2 = $rowdata[0]['invoice_logo'];	
			if( !empty($_FILES) && $_FILES['invoice_logo']['name']!='' ){
				$this->load->library('upload');
				$uploaded_data2 =  $this->upload->my_upload('invoice_logo','logo');
				if( is_array($uploaded_data2)  && !empty($uploaded_data2) ){
					$uploaded_file2 = $uploaded_data2['upload_data']['file_name'];
					removeImage($unlink_image3);
				}
			}	 

					
			$dataval=array(
					  'header_logo' =>$uploaded_file,
					  'footer_logo' =>$uploaded_file1,
					  'invoice_logo' =>$uploaded_file2,
					  'copy_right'   => $this->input->post("copy_right"),
					  'company_name' => $this->input->post("company_name"),
					  'facebook'	=> $this->input->post("facebook"),
					  'twitter'		=> $this->input->post("twitter"),
					  'facebook'	=> $this->input->post("facebook"),
					  'linkdin'		=> $this->input->post("linkdin"),
					  'gplus'		=> $this->input->post("gplus"),
					  'youtube'		=> $this->input->post("youtube"),
					  'google_anylitical_code'=> $this->input->post("google_anylitical_code"),
					  'admin_commission'  => $this->input->post("admin_commission"),
					  'toll_free_no'	  => $this->input->post("phone"),
					  'tax'				  => $this->input->post("vat_percent")
				  );	  
				  			
		$this->setting_model->update_info('1');					
		$this->setting_model->safe_update('tbl_admin_settings',$dataval,array("id"=>1));

			redirect('sitepanel/setting/', '');

		}
	}



	public function update_setting() {

		$res = $this->setting_model->get_setting_data();



		$posted_data = $this->input->post('post_data');



		if (is_array($posted_data) && count($posted_data) > 0) {



			foreach ($posted_data as $key => $val) {

				$label = get_db_field_value("tbl_settings", "setting_title", array("id" => $key));

				$this->form_validation->set_rules("post_data[$key]", "$label", 'trim|required|is_natural');

			}

		}



		if ($this->form_validation->run() == TRUE) {

			if (is_array($posted_data) && count($posted_data) > 0) {



				foreach ($posted_data as $key => $val) {

					$settingval=$val;

						

					$settingtitle=get_db_field_value("tbl_settings","setting_title",array("id"=>$key));

					if(strstr($settingtitle,'Days'))

					{

						$settingval=$val*30;

					}

					$data = array("setting_value" => $settingval);

					$where = "id ='" . $key . "'";

					$this->setting_model->safe_update("tbl_settings", $data, $where, true);

				}

			}



			$this->session->set_userdata(array('msg_type' => 'success'));

			$this->session->set_flashdata('success', lang('successupdate'));



			redirect('sitepanel/setting/update_setting', '');

		}

		$data['res'] = $res;

		$data['heading_title'] = 'Manage Setting';





		$data['includes'] = 'dashboard/update_setting_view';



		$this->load->view('includes/sitepanel_container', $data);

	}



	public function homebanner(){

		 

		$img_allow_size =  $this->config->item('allow.file.size');

		$img_allow_dim  =  $this->config->item('allow.imgage.dimension');

			

		$data['includes'] = 'dashboard/homebanner_view';

		$data['heading_title'] = 'Manage Home Banner';

		$rwdata=get_db_single_row("tbl_home_banner","*","");

		$data['rwdata']=$rwdata;

		 

		if($this->input->post('action')=='addbanner'){



		 $this->form_validation->set_rules('url','Banner Url',"trim|xss_clean|valid_url|max_length[200]");

		 $this->form_validation->set_rules('image1','Banner image',"file_allowed_type[image]|file_size_max[$img_allow_size]|check_dimension[$img_allow_dim]");

		 $this->form_validation->set_rules('youtube_code','Embaded Code',"trim|xss_clean|max_length[4000]|callback_one_added");

		 	

		 if($this->form_validation->run()==TRUE)

		 {

		 	 

		 	$uploaded_file = ($rwdata['web_img']!='')?$rwdata['web_img']:"";

		 	if($this->input->post('youtube_code')!=''){

		 		$youtube_code=get_Youtube_Id($this->input->post('youtube_code'));

		 	}else{

		 		$youtube_code="";

		 	}

		 	$googel_code=($this->input->post('youtube_code')!='')?$this->input->post('youtube_code')!='':'';

		 	$unlink_image = array('source_dir'=>"banner",'source_file'=>$rwdata['web_img']);

		 	if($this->input->post('delban')=='Y'){

					removeImage($unlink_image);

					$uploaded_file ="";

				}

				if( !empty($_FILES) && $_FILES['image1']['name']!='' )

				{



					$this->load->library('upload');

					$uploaded_data =  $this->upload->my_upload('image1','banner');



					if( is_array($uploaded_data)  && !empty($uploaded_data) )

					{

						$uploaded_file = $uploaded_data['upload_data']['file_name'];

						removeImage($unlink_image);

					}

						

				}



				$posted_data = array(

										  'web_url'        => $this->input->post('url'),

										  'youtube_code'   => $youtube_code,

										  'googel_code'    => $googel_code,

										  'web_img'        => $uploaded_file				

				);

					

				$where = "id = '1'";

				$this->setting_model->safe_update('tbl_home_banner',$posted_data,$where,FALSE);

					

		 }

		 $this->session->set_userdata(array('msg_type'=>'success'));

		 $this->session->set_flashdata('success',lang('successupdate'));

		 redirect('sitepanel/setting/homebanner/', '');

		}

		 

		$this->load->view('dashboard/homebanner_view', $data);

	}



	public function one_added(){

		 

		$st=$this->input->post('st');

		$youtube_code=$this->input->post('youtube_code');

		$googel_code=$this->input->post('googel_code');

		 

		if($_FILES['image1']['name']=='' && $youtube_code=='' && $googel_code==''){

			$this->form_validation->set_message('one_added', 'Please select atleast one banner/embeded code/google ads');

			return FALSE;

		}

		if($_FILES['image1']['name']!='' && $youtube_code!='' && $googel_code!=''){

			$this->form_validation->set_message('one_added', 'Please select only one banner/embeded code/google ads ');

			return FALSE;

		}

		 

	}



}



// End of controller