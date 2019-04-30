<?php
class Instrument_type extends Admin_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('instrumenttype_model'));
		$this->config->set_item('menu_highlight','category');
	}

	public  function index()
	{
		
		$pagesize               =  (int) $this->input->get_post('pagesize');
		$config['limit']		 =  ( $pagesize > 0 ) ? $pagesize : $this->config->item('pagesize');
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
		$res_array              =  $this->instrumenttype_model->getinstrumenttypes($condtion_array);
		$config['total_rows']	=  $this->instrumenttype_model->total_rec_found;
		$data['page_links']     =  admin_pagination($base_url,$config['total_rows'],$config['limit'],$offset);
		$data['heading_title']  =  'Instrument Types';

		$data['res']            =  $res_array;

		$data['parent_id']      =  $parent_id;
        
		if( $this->input->post('status_action')!='')
		{

			
			if($this->input->post('status_action')=='Activate'){
			
				$arr_ids=$this->input->post('arr_ids');
				
				if(is_array($arr_ids) && count($arr_ids) > 0){
					foreach($arr_ids as $value){
					
						$this->db->query("UPDATE tbl_instrument_type SET status='1' WHERE id ='$value'");	
						
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
					
						$this->db->query("UPDATE tbl_instrument_type SET status='0' WHERE id ='$value'");	
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
					   
					 
					   $this->db->query("DELETE FROM tbl_instrument_type  WHERE id ='$value'");	
					   $this->session->set_userdata(array('msg_type'=>'success'));
					   $this->session->set_flashdata('success',"Selected record(s) has been deleted successfully." );
					   
					}
					
				}
				redirect($_SERVER['HTTP_REFERER']);
			
			}
			
		
		}
		$this->load->view('instrument_type/view_instrument_type_list',$data);

	}

	public function add()
	{
		$data['heading_title'] = 'Add Instrument Type';
        
		$this->form_validation->set_rules('ins_type','Types',"trim|required|max_length[32]");
		$this->form_validation->set_rules('title','Instrument',"trim|required|max_length[32]|unique[tbl_instrument_type.title='".$this->db->escape_str($this->input->post('title'))."' AND ins_type='".$this->db->escape_str($this->input->post('ins_type'))."' AND status!='2']");
		

		if($this->form_validation->run()===TRUE)
		{
			$posted_data = array(
			'ins_type'=>$this->input->post('ins_type'),
			'title'=>$this->input->post('title'),
			'created_at'=>$this->config->item('config.date.time'),
			'status'=>1
			);
			$posted_data=$this->security->xss_clean($posted_data);
			$this->instrumenttype_model->safe_insert('tbl_instrument_type',$posted_data,FALSE);

			$this->session->set_userdata(array('msg_type'=>'success'));
			$this->session->set_flashdata('success',lang('success'));
			redirect('sitepanel/instrument_type', '');

		}
		$this->load->view('instrument_type/view_instrument_type_add',$data);

	}

	public function edit()
	{
		$instrumenttypeId = (int) $this->uri->segment(4);

		$rowdata=$this->instrumenttype_model->get_instrument_type_by_id($instrumenttypeId);

		$instrumenttypeId = $rowdata['id'];

		$data['heading_title'] = 'Instrument Type';

		if( !is_array($rowdata) )
		{
		  $this->session->set_flashdata('message', lang('idmissing'));
		  redirect('sitepanel/instrument_type', '');
		}
		$this->form_validation->set_rules('ins_type','Types',"trim|required|max_length[32]");
		$this->form_validation->set_rules('title','Instrument',"trim|required|max_length[32]|unique[tbl_instrument_type.title='".$this->db->escape_str($this->input->post('title'))."' AND status!='2' AND ins_type='".$this->db->escape_str($this->input->post('ins_type'))."' AND id != ".$instrumenttypeId."]");
	

		if($this->form_validation->run()==TRUE)
		{
			$posted_data = array(
			'title'=>$this->input->post('title'),
			'ins_type'=>$this->input->post('ins_type')
			);
            $posted_data=$this->security->xss_clean($posted_data);
			$where = "id = '".$instrumenttypeId."'";
			$this->instrumenttype_model->safe_update('tbl_instrument_type',$posted_data,$where,FALSE);

			$this->session->set_userdata(array('msg_type'=>'success'));
			$this->session->set_flashdata('success',lang('successupdate'));

			redirect('sitepanel/instrument_type'.'/'.query_string(), '');

		}

		$data['res']=$rowdata;
		$this->load->view('instrument_type/view_instrument_type_edit',$data);

	}

}
// End of controller