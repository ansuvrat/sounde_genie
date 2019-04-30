<?php
class Homepagebanner extends Admin_Controller
 {

	public function __construct() {
		
		parent::__construct(); 			  
		$this->load->model(array('sitepanel/homepagebannere_model'));  
		$this->config->set_item('menu_highlight','other');	
	
	}
	
	
	 public  function index()
	   {		
		
		$pagesize               =  (int) $this->input->get_post('pagesize');
		$config['limit']		=  ( $pagesize > 0 ) ? $pagesize : $this->config->item('pagesize');
		$offset                 =  ( $this->input->get_post('per_page') > 0 ) ? $this->input->get_post('per_page') : 0;	
		$base_url               =  current_url_query_string(array('filter'=>'result'),array('per_page'));
		$res_array              =  $this->homepagebannere_model->gethomebanner($offset,$config['limit']);	
		$total_record        	=  $this->homepagebannere_model->total_rec_found;	
		$data['page_links']     =  admin_pagination($base_url,$total_record,$config['limit'],$offset);	
		$data['heading_title']  = 'Manage Homepage Banner';
		if( $this->input->post('status_action')!='')
		{
			
			if($this->input->post('status_action')=='Activate'){
			
				$arr_ids=$this->input->post('arr_ids');
				if(is_array($arr_ids) && count($arr_ids) > 0){
					foreach($arr_ids as $value){
					
						$this->db->query("UPDATE tbl_home_banner SET status='1' WHERE id='$value'");	
					}
					$this->session->set_userdata(array('msg_type'=>'success'));
					$this->session->set_flashdata('success',"Selected record(s) has been Activated successfully." );
				}
				redirect($_SERVER['HTTP_REFERER']);
			
			}
			if($this->input->post('status_action')=='Deactivate'){
				
				$arr_ids=$this->input->post('arr_ids');
				if(is_array($arr_ids) && count($arr_ids) > 0){
					
					foreach($arr_ids as $value){
					
						$this->db->query("UPDATE tbl_home_banner SET status='0' WHERE id='$value'");	
					}
					$this->session->set_userdata(array('msg_type'=>'success'));
					$this->session->set_flashdata('success',"Selected record(s) has been de-activated successfully." );
					
				}
				redirect($_SERVER['HTTP_REFERER']);
				
			}
			if($this->input->post('status_action')=='Delete'){
				
				$arr_ids=$this->input->post('arr_ids');
				
				if(is_array($arr_ids) && count($arr_ids) > 0){
					foreach($arr_ids as $value){
					
						$this->db->query("DELETE FROM tbl_home_banner WHERE id='$value'");
					}
					$this->session->set_userdata(array('msg_type'=>'success'));
					$this->session->set_flashdata('success',"Selected record(s) has been deleted successfully." );
				}
				redirect($_SERVER['HTTP_REFERER']);
				
			}
		}
		$data['pagelist']      	= $res_array; 	
		$this->load->view('banners/homepage_banner_index_view',$data); 
				
	}
	
	public function add()
		{
			
			$this->load->library('upload');	
			$data['heading_title'] = 'Add Homepage Banner';						
			$this->form_validation->set_rules('heading1','Heading 1',"trim|max_length[223]");
			$this->form_validation->set_rules('heading2','Heading 2',"trim|max_length[223]");
			$this->form_validation->set_rules('image1','Image',"required|file_allowed_type[image]");
			
			
			if($this->form_validation->run()==TRUE)
			{
				
				$uploaded_file1 = "";	
			    if( !empty($_FILES) && $_FILES['image1']['name']!='' )
				{			  
					
					$uploaded_data1 =  $this->upload->my_upload('image1','upd_files');
					if( is_array($uploaded_data1)  && !empty($uploaded_data1) )
					{ 								
						$uploaded_file1 = $uploaded_data1['upload_data']['file_name'];
					}		
				}

				$posted_data = array(
					'image'        => $uploaded_file1,
					'heading1'        => $this->input->post('heading1'),
					'heading2'        => $this->input->post('heading2'),
					'status'       => 1
				);
				$this->homepagebannere_model->safe_insert('tbl_home_banner',$posted_data,FALSE);			  
			    $this->session->set_userdata('msg_type',"success" ); 
			    $this->session->set_flashdata('success',lang('success') ); 
				redirect('sitepanel/homepagebanner', '');
			}   
			 $this->load->view('banners/homepage_banner_add_view',$data);	
	   }
	   
	   public function edit()
	   {
		    
	        $this->load->library('upload');	
			$data['heading_title'] = 'Edit Homepage Banner';			
			$Id        = (int) $this->uri->segment(4);	
			$condtion  = "id ='$Id' ";	
			$res       =   $this->homepagebannere_model->gethomebanner_by_id($Id);	
			
		 if( is_object($res) )
		 { 
			$this->form_validation->set_rules('heading1','Heading 1',"trim|max_length[223]");
			$this->form_validation->set_rules('heading2','Heading 2',"trim|max_length[223]");
			$this->form_validation->set_rules('image1','Image',"file_allowed_type[image]");
			
						
					if($this->form_validation->run()==TRUE)
					{
					
					$uploaded_file1 = $res->image;				 
					$unlink_image1 = array('source_dir'=>"upd_files",'source_file'=>$res->image);
					if( !empty($_FILES) && $_FILES['image1']['name']!='' )
					{			  
						$uploaded_data1 =  $this->upload->my_upload('image1','upd_files');
						if( is_array($uploaded_data1)  && !empty($uploaded_data1) )
						{ 								
						   $uploaded_file1 = $uploaded_data1['upload_data']['file_name'];
						   removeImage($unlink_image1);	
						}
				    }	
					$posted_data = array(
										  'image' =>$uploaded_file1,
										  'heading1'        => $this->input->post('heading1'),
					                      'heading2'        => $this->input->post('heading2')
										);
						$where = "id = '".$res->id."'"; 						
						$this->homepagebannere_model->safe_update('tbl_home_banner',$posted_data,$where,FALSE);	
						
						$this->session->set_userdata('msg_type',"success" ); 
						$this->session->set_flashdata('success',lang('successupdate') ); 
						redirect('sitepanel/homepagebanner/'.query_string(), ''); 	
					}
					$data['pageresult']=$res;
					$this->load->view('banners/homepage_banner_edit_view',$data);
		   }
		   else
		   {
			  redirect('sitepanel/homepagebanner', ''); 	 
		   }
		   
	   }
	
 }