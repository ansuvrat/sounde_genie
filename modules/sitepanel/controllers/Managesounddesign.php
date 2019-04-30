<?php
class Managesounddesign extends Admin_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('sounddesign_model'));
		$this->config->set_item('menu_highlight','category');
	}

	public  function index()
	{
		
		$pagesize               =  (int) $this->input->get_post('pagesize');
		$config['limit']		=  ( $pagesize > 0 ) ? $pagesize : $this->config->item('pagesize');
		$offset                 =  ( $this->input->get_post('per_page') > 0 ) ? $this->input->get_post('per_page') : 0;
		$base_url               =  current_url_query_string(array('filter'=>'result'),array('per_page'));
		$parent_id              =   (int) $this->uri->segment(4,0);

		$keyword = trim($this->input->get_post('keyword',TRUE));
		$keyword = $this->db->escape_str($keyword);
		$condtion = " ";

		$condtion_array = array(
								'field' =>"*",
								'condition'=>$condtion,
								'limit'=>$config['limit'],
								'offset'=>$offset	,
								'debug'=>FALSE
								);
		$res_array              =  $this->sounddesign_model->getsounddesigncategory($condtion_array);
		$config['total_rows']	=  $this->sounddesign_model->total_rec_found;
		$data['page_links']     =  admin_pagination($base_url,$config['total_rows'],$config['limit'],$offset);
		$data['heading_cat_name']  =  'Sound Design Category';

		$data['res']            =  $res_array;

		$data['parent_id']      =  $parent_id;
        
		if( $this->input->post('status_action')!='')
		{

			
			if($this->input->post('status_action')=='Activate'){
			
				$arr_ids=$this->input->post('arr_ids');
				
				if(is_array($arr_ids) && count($arr_ids) > 0){
					foreach($arr_ids as $value){
					
						$this->db->query("UPDATE tbl_sounddesign_category SET status='1' WHERE id ='$value'");	
						
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
					
						$this->db->query("UPDATE tbl_sounddesign_category SET status='0' WHERE id ='$value'");	
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
					   
					 
					   $this->db->query("DELETE FROM tbl_sounddesign_category  WHERE id ='$value'");	
					   $this->session->set_userdata(array('msg_type'=>'success'));
					   $this->session->set_flashdata('success',"Selected record(s) has been deleted successfully." );
					   
					}
					
				}
				redirect($_SERVER['HTTP_REFERER']);
			
			}
			
		
		}
		$this->load->view('sounddesign_category/view_sound_category_list',$data);

	}

	public function add()
	{
		$data['heading_cat_name'] = 'Add Sound Design';

		$this->form_validation->set_rules('sounddegn_category','Category Name',"trim|required|max_length[32]|unique[tbl_sounddesign_category.sounddegn_category='".$this->db->escape_str($this->input->post('sounddegn_category'))."' AND status!='2']");
		

		if($this->form_validation->run()===TRUE)
		{
			$posted_data = array(
			'sounddegn_category'=>$this->input->post('sounddegn_category'),
			'status'=>1
			);
			$posted_data=$this->security->xss_clean($posted_data);
			$this->sounddesign_model->safe_insert('tbl_sounddesign_category',$posted_data,FALSE);

			$this->session->set_userdata(array('msg_type'=>'success'));
			$this->session->set_flashdata('success',lang('success'));
			redirect('sitepanel/managesounddesign', '');

		}
		$this->load->view('sounddesign_category/view_sound_category_add',$data);

	}

	public function edit()
	{
		$instrumenttypeId = (int) $this->uri->segment(4);

		$rowdata=$this->sounddesign_model->get_sounddesign_category_by_id($instrumenttypeId);

		$instrumenttypeId = $rowdata['id'];

		$data['heading_cat_name'] = 'Category Name';

		if( !is_array($rowdata) )
		{
		  $this->session->set_flashdata('message', lang('idmissing'));
		  redirect('sitepanel/managesounddesign', '');
		}
		$this->form_validation->set_rules('sounddegn_category','Category Name',"trim|required|max_length[32]|unique[tbl_sounddesign_category.sounddegn_category='".$this->db->escape_str($this->input->post('sounddegn_category'))."' AND status!='2' AND id != ".$instrumenttypeId."]");
	

		if($this->form_validation->run()==TRUE)
		{
			$posted_data = array(
			'sounddegn_category'=>$this->input->post('sounddegn_category')
			);
            $posted_data=$this->security->xss_clean($posted_data);
			$where = "id = '".$instrumenttypeId."'";
			$this->sounddesign_model->safe_update('tbl_sounddesign_category',$posted_data,$where,FALSE);

			$this->session->set_userdata(array('msg_type'=>'success'));
			$this->session->set_flashdata('success',lang('successupdate'));

			redirect('sitepanel/managesounddesign'.'/'.query_string(), '');

		}

		$data['res']=$rowdata;
		$this->load->view('sounddesign_category/view_sound_category_edit',$data);
	}
	
	
	public  function soundlist()
	{
		
		$pagesize               =  (int) $this->input->get_post('pagesize');
		$config['limit']		=  ( $pagesize > 0 ) ? $pagesize : $this->config->item('pagesize');
		$offset                 =  ( $this->input->get_post('per_page') > 0 ) ? $this->input->get_post('per_page') : 0;
		$base_url               =  current_url_query_string(array('filter'=>'result'),array('per_page'));
		$parent_id              =   (int) $this->uri->segment(4,0);

		$keyword = trim($this->input->get_post('keyword',TRUE));
		$keyword = $this->db->escape_str($keyword);
		$condtion = " ";

		$condtion_array = array(
								'field' =>"*",
								'condition'=>$condtion,
								'limit'=>$config['limit'],
								'offset'=>$offset	,
								'debug'=>FALSE
								);
		$res_array              =  $this->sounddesign_model->getsounddesign($condtion_array);
		$config['total_rows']	=  $this->sounddesign_model->total_rec_found;
		$data['page_links']     =  admin_pagination($base_url,$config['total_rows'],$config['limit'],$offset);
		$data['heading_title']  =  'Manage Sound Design Price';

		$data['res']            =  $res_array;

		$data['parent_id']      =  $parent_id;
        
		if( $this->input->post('status_action')!='')
		{

			
			if($this->input->post('status_action')=='Activate'){
			
				$arr_ids=$this->input->post('arr_ids');
				
				if(is_array($arr_ids) && count($arr_ids) > 0){
					foreach($arr_ids as $value){
					
						$this->db->query("UPDATE tbl_sound_designing SET status='1' WHERE id ='$value'");	
						
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
					
						$this->db->query("UPDATE tbl_sound_designing SET status='0' WHERE id ='$value'");	
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
					   
					 
					   $this->db->query("DELETE FROM tbl_sound_designing  WHERE id ='$value'");	
					   $this->session->set_userdata(array('msg_type'=>'success'));
					   $this->session->set_flashdata('success',"Selected record(s) has been deleted successfully." );
					   
					}
				}
				redirect($_SERVER['HTTP_REFERER']);
			}
		}
		$this->load->view('sounddesign_category/view_sound_desiginig_list',$data);
	}
	
	public function add_price(){
		$data['heading_title']  =  'Add Sound Design Price';
		
		$this->form_validation->set_rules('cat_id','Category',"trim|required");
		$this->form_validation->set_rules('duration','Duration',"trim|required|unique[tbl_sound_designing.duration='".$this->db->escape_str($this->input->post('duration'))."' AND status!='2' AND  tbl_sound_designing.cat_id='".$this->db->escape_str($this->input->post('cat_id'))."' ]");
		$this->form_validation->set_rules('price','Price',"trim|required|max_length[32] ");
		if($this->form_validation->run()===TRUE)
		{
			$posted_data = array(
			'price'=>$this->input->post('price'),
			'duration'=>$this->input->post('duration'),
			'cat_id'=>$this->input->post('cat_id'),
			'status'=>1
			);
			$posted_data=$this->security->xss_clean($posted_data);
			$this->sounddesign_model->safe_insert('tbl_sound_designing',$posted_data,FALSE);

			$this->session->set_userdata(array('msg_type'=>'success'));
			$this->session->set_flashdata('success',lang('success'));
			redirect('sitepanel/managesounddesign/soundlist', '');
		}
		$this->load->view('sounddesign_category/view_sound_desiginig_add',$data);
	}
	
	public function edit_price()
	{
		$priceId = (int) $this->uri->segment(4);

		$rowdata=$this->sounddesign_model->get_sounddesign_price_by_id($priceId);

		$priceId = $rowdata['id'];

		$data['heading_title'] = 'Edit Sound Design Price';

		if( !is_array($rowdata) )
		{
		  $this->session->set_flashdata('message', lang('idmissing'));
		  redirect('sitepanel/managesounddesign/soundlist', '');
		}
		$this->form_validation->set_rules('cat_id','Category',"trim|required");
		$this->form_validation->set_rules('duration','Duration',"trim|required|unique[tbl_sound_designing.duration='".$this->db->escape_str($this->input->post('duration'))."' AND status!='2' AND  tbl_sound_designing.cat_id='".$this->db->escape_str($this->input->post('cat_id'))."' AND id != ".$priceId."   ]");
		
		$this->form_validation->set_rules('price','Price',"trim|required|max_length[32]");

		if($this->form_validation->run()==TRUE)
		{
			$posted_data = array(
			'price'=>$this->input->post('price'),
			'duration'=>$this->input->post('duration'),
			'cat_id'=>$this->input->post('cat_id')
			);
            $posted_data=$this->security->xss_clean($posted_data);
			$where = "id = '".$priceId."'";
			$this->sounddesign_model->safe_update('tbl_sound_designing',$posted_data,$where,FALSE);

			$this->session->set_userdata(array('msg_type'=>'success'));
			$this->session->set_flashdata('success',lang('successupdate'));

			redirect('sitepanel/managesounddesign/soundlist'.'/'.query_string(), '');

		}

		$data['res']=$rowdata;
		$this->load->view('sounddesign_category/view_sound_desiginig_edit',$data);

	}

}
// End of controller