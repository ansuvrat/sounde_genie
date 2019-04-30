<?php
class Sound_category extends Admin_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('soundcat_model'));
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
		$res_array              =  $this->soundcat_model->getsoundcategory($condtion_array);
		$config['total_rows']	=  $this->soundcat_model->total_rec_found;
		$data['page_links']     =  admin_pagination($base_url,$config['total_rows'],$config['limit'],$offset);
		$data['heading_cat_name']  =  'Sound Recording Category';

		$data['res']            =  $res_array;

		$data['parent_id']      =  $parent_id;
        
		if( $this->input->post('status_action')!='')
		{

			
			if($this->input->post('status_action')=='Activate'){
			
				$arr_ids=$this->input->post('arr_ids');
				
				if(is_array($arr_ids) && count($arr_ids) > 0){
					foreach($arr_ids as $value){
					
						$this->db->query("UPDATE tbl_sound_category SET status='1' WHERE id ='$value'");	
						
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
					
						$this->db->query("UPDATE tbl_sound_category SET status='0' WHERE id ='$value'");	
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
					   
					 
					   $this->db->query("DELETE FROM tbl_sound_category  WHERE id ='$value'");	
					   $this->session->set_userdata(array('msg_type'=>'success'));
					   $this->session->set_flashdata('success',"Selected record(s) has been deleted successfully." );
					   
					}
					
				}
				redirect($_SERVER['HTTP_REFERER']);
			
			}
			
		
		}
		$this->load->view('sound_category/view_sound_category_list',$data);

	}

	public function add()
	{
		$data['heading_cat_name'] = 'Add Sound Category';

		$this->form_validation->set_rules('cat_name','Category Name',"trim|required|max_length[32]|unique[tbl_sound_category.cat_name='".$this->db->escape_str($this->input->post('cat_name'))."' AND status!='2']");
		

		if($this->form_validation->run()===TRUE)
		{
			$posted_data = array(
			'cat_name'=>$this->input->post('cat_name'),
			'created_at'=>$this->config->item('config.date.time'),
			'status'=>1
			);
			$posted_data=$this->security->xss_clean($posted_data);
			$this->soundcat_model->safe_insert('tbl_sound_category',$posted_data,FALSE);

			$this->session->set_userdata(array('msg_type'=>'success'));
			$this->session->set_flashdata('success',lang('success'));
			redirect('sitepanel/sound_category', '');

		}
		$this->load->view('sound_category/view_sound_category_add',$data);

	}

	public function edit()
	{
		$instrumenttypeId = (int) $this->uri->segment(4);

		$rowdata=$this->soundcat_model->get_sound_category_by_id($instrumenttypeId);

		$instrumenttypeId = $rowdata['id'];

		$data['heading_cat_name'] = 'Category Name';

		if( !is_array($rowdata) )
		{
		  $this->session->set_flashdata('message', lang('idmissing'));
		  redirect('sitepanel/sound_category', '');
		}
		$this->form_validation->set_rules('cat_name','Category Name',"trim|required|max_length[32]|unique[tbl_sound_category.cat_name='".$this->db->escape_str($this->input->post('cat_name'))."' AND status!='2' AND id != ".$instrumenttypeId."]");
	

		if($this->form_validation->run()==TRUE)
		{
			$posted_data = array(
			'cat_name'=>$this->input->post('cat_name')
			);
            $posted_data=$this->security->xss_clean($posted_data);
			$where = "id = '".$instrumenttypeId."'";
			$this->soundcat_model->safe_update('tbl_sound_category',$posted_data,$where,FALSE);

			$this->session->set_userdata(array('msg_type'=>'success'));
			$this->session->set_flashdata('success',lang('successupdate'));

			redirect('sitepanel/sound_category'.'/'.query_string(), '');

		}

		$data['res']=$rowdata;
		$this->load->view('sound_category/view_sound_category_edit',$data);

	}

}
// End of controller