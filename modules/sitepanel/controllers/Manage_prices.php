<?php
class Manage_prices extends Admin_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('price_model'));
		$this->config->set_item('menu_highlight','category');
	}

	public  function virtual_instrument_price()
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
		$res_array              =  $this->price_model->get_virtual_instrument_price($condtion_array);
		$config['total_rows']	=  $this->price_model->total_rec_found;
		$data['page_links']     =  admin_pagination($base_url,$config['total_rows'],$config['limit'],$offset);
		$data['heading_title']  =  'Virtural Instrument Price';

		$data['res']            =  $res_array;

		$data['parent_id']      =  $parent_id;
        
		if( $this->input->post('status_action')!='')
		{

			
			if($this->input->post('status_action')=='Activate'){
			
				$arr_ids=$this->input->post('arr_ids');
				
				if(is_array($arr_ids) && count($arr_ids) > 0){
					foreach($arr_ids as $value){
					
						$this->db->query("UPDATE tbl_virtual_instru_price SET status='1' WHERE price_id ='$value'");	
						
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
					
						$this->db->query("UPDATE tbl_virtual_instru_price SET status='0' WHERE price_id ='$value'");	
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
					   
					 
					   $this->db->query("DELETE FROM tbl_virtual_instru_price  WHERE price_id ='$value'");	
					   $this->session->set_userdata(array('msg_type'=>'success'));
					   $this->session->set_flashdata('success',"Selected record(s) has been deleted successfully." );
					   
					}
					
				}
				redirect($_SERVER['HTTP_REFERER']);
			
			}
			
		
		}
		$this->load->view('virtual_instrument_price/view_virtual_instrument_price_list',$data);

	}

	public function add_virtual_price()
	{
		$data['heading_title'] = 'Add Price';

		
		$this->form_validation->set_rules('instrument_type','Instrument Type',"trim|required");
		$this->form_validation->set_rules('duration','Duration',"trim|required|unique[tbl_virtual_instru_price.duration='".$this->db->escape_str($this->input->post('duration'))."' AND status!='2' AND  tbl_virtual_instru_price.instrument_type='".$this->db->escape_str($this->input->post('instrument_type'))."'    ]");
		
		$this->form_validation->set_rules('price','Price',"trim|required|max_length[32] ");
		if($this->form_validation->run()===TRUE)
		{
			$posted_data = array(
			'price'=>$this->input->post('price'),
			'type'=>1,
			'duration'=>$this->input->post('duration'),
			'instrument_type'=>$this->input->post('instrument_type'),
			'status'=>1
			);
			$posted_data=$this->security->xss_clean($posted_data);
			$this->price_model->safe_insert('tbl_virtual_instru_price',$posted_data,FALSE);

			$this->session->set_userdata(array('msg_type'=>'success'));
			$this->session->set_flashdata('success',lang('success'));
			redirect('sitepanel/manage_prices/virtual_instrument_price', '');

		}
		$this->load->view('virtual_instrument_price/view_instrument_price_add',$data);

	}

	public function edit_virtual_price()
	{
		$priceId = (int) $this->uri->segment(4);

		$rowdata=$this->price_model->get_instrument_price_by_id($priceId);

		$priceId = $rowdata['price_id'];

		$data['heading_title'] = 'Manage Price';

		if( !is_array($rowdata) )
		{
		  $this->session->set_flashdata('message', lang('idmissing'));
		  redirect('sitepanel/manage_price/virtual_instrument_price', '');
		}
		$this->form_validation->set_rules('instrument_type','Instrument Type',"trim|required");
		$this->form_validation->set_rules('duration','Duration',"trim|required|unique[tbl_virtual_instru_price.duration='".$this->db->escape_str($this->input->post('duration'))."' AND status!='2' AND  tbl_virtual_instru_price.instrument_type='".$this->db->escape_str($this->input->post('instrument_type'))."' AND price_id != ".$priceId."   ]");
		$this->form_validation->set_rules('price','Price',"trim|required|max_length[32]");

		if($this->form_validation->run()==TRUE)
		{
			$posted_data = array(
			'price'=>$this->input->post('price'),
			'duration'=>$this->input->post('duration'),
			'type'=>1,
			'instrument_type'=>$this->input->post('instrument_type')
			);
            $posted_data=$this->security->xss_clean($posted_data);
			$where = "price_id = '".$priceId."'";
			$this->price_model->safe_update('tbl_virtual_instru_price',$posted_data,$where,FALSE);

			$this->session->set_userdata(array('msg_type'=>'success'));
			$this->session->set_flashdata('success',lang('successupdate'));

			redirect('sitepanel/manage_prices/virtual_instrument_price'.'/'.query_string(), '');

		}

		$data['res']=$rowdata;
		$this->load->view('virtual_instrument_price/view_instrument_price_edit',$data);

	}
	
	
	public  function live_instrument_price()
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
		$res_array              =  $this->price_model->get_live_instrument_price($condtion_array);
		$config['total_rows']	=  $this->price_model->total_rec_found;
		$data['page_links']     =  admin_pagination($base_url,$config['total_rows'],$config['limit'],$offset);
		$data['heading_title']  =  'Live Instrument Price';

		$data['res']            =  $res_array;

		$data['parent_id']      =  $parent_id;
        
		if( $this->input->post('status_action')!='')
		{

			
			if($this->input->post('status_action')=='Activate'){
			
				$arr_ids=$this->input->post('arr_ids');
				
				if(is_array($arr_ids) && count($arr_ids) > 0){
					foreach($arr_ids as $value){
					
						$this->db->query("UPDATE tbl_virtual_instru_price SET status='1' WHERE price_id ='$value'");	
						
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
					
						$this->db->query("UPDATE tbl_virtual_instru_price SET status='0' WHERE price_id ='$value'");	
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
					   
					 
					   $this->db->query("DELETE FROM tbl_virtual_instru_price  WHERE price_id ='$value'");	
					   $this->session->set_userdata(array('msg_type'=>'success'));
					   $this->session->set_flashdata('success',"Selected record(s) has been deleted successfully." );
					   
					}
					
				}
				redirect($_SERVER['HTTP_REFERER']);
			
			}
			
		
		}
		$this->load->view('virtual_instrument_price/view_live_instrument_price_list',$data);

	}
	
	
	public function add_live_price()
	{
		$data['heading_title'] = 'Add Price';

		
		$this->form_validation->set_rules('instrument_type','Instrument Type',"trim|required");
		$this->form_validation->set_rules('duration','Duration',"trim|required|unique[tbl_virtual_instru_price.duration='".$this->db->escape_str($this->input->post('duration'))."' AND status!='2' AND  tbl_virtual_instru_price.instrument_type='".$this->db->escape_str($this->input->post('instrument_type'))."'    ]");
		
		$this->form_validation->set_rules('price','Price',"trim|required|max_length[32] ");
		if($this->form_validation->run()===TRUE)
		{
			$posted_data = array(
			'price'=>$this->input->post('price'),
			'type'=>2,
			'duration'=>$this->input->post('duration'),
			'instrument_type'=>$this->input->post('instrument_type'),
			'status'=>1
			);
			$posted_data=$this->security->xss_clean($posted_data);
			$this->price_model->safe_insert('tbl_virtual_instru_price',$posted_data,FALSE);
			$this->session->set_userdata(array('msg_type'=>'success'));
			$this->session->set_flashdata('success',lang('success'));
			redirect('sitepanel/manage_prices/live_instrument_price', '');

		}
		$this->load->view('virtual_instrument_price/view_instrumentlive_price_add',$data);
	}
	
	
	public function edit_live_price()
	{
		$priceId = (int) $this->uri->segment(4);

		$rowdata=$this->price_model->get_instrument_price_by_id($priceId);

		$priceId = $rowdata['price_id'];

		$data['heading_title'] = 'Manage Price';

		if( !is_array($rowdata) )
		{
		  $this->session->set_flashdata('message', lang('idmissing'));
		  redirect('sitepanel/manage_price/live_instrument_price', '');
		}
		$this->form_validation->set_rules('instrument_type','Instrument Type',"trim|required");
		$this->form_validation->set_rules('duration','Duration',"trim|required|unique[tbl_virtual_instru_price.duration='".$this->db->escape_str($this->input->post('duration'))."' AND status!='2' AND  tbl_virtual_instru_price.instrument_type='".$this->db->escape_str($this->input->post('instrument_type'))."' AND price_id != ".$priceId."   ]");
		$this->form_validation->set_rules('price','Price',"trim|required|max_length[32]");

		if($this->form_validation->run()==TRUE)
		{
			$posted_data = array(
			'price'=>$this->input->post('price'),
			'duration'=>$this->input->post('duration'),
			'type'=>2,
			'instrument_type'=>$this->input->post('instrument_type')
			);
            $posted_data=$this->security->xss_clean($posted_data);
			$where = "price_id = '".$priceId."'";
			$this->price_model->safe_update('tbl_virtual_instru_price',$posted_data,$where,FALSE);

			$this->session->set_userdata(array('msg_type'=>'success'));
			$this->session->set_flashdata('success',lang('successupdate'));

			redirect('sitepanel/manage_prices/live_instrument_price'.'/'.query_string(), '');

		}

		$data['res']=$rowdata;
		$this->load->view('virtual_instrument_price/view_instrumentlive_price_edit',$data);

	}
	
	
	//////////////////////////////////////// Virtual instrument price end ////////////////
	
	/////////////////////////////////////// Lyrics Price ///////////////////////////////
	public  function lyrics_price()
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
		$res_array              =  $this->price_model->get_lyrics_price($condtion_array);
		$config['total_rows']	=  $this->price_model->total_rec_found;
		$data['page_links']     =  admin_pagination($base_url,$config['total_rows'],$config['limit'],$offset);
		$data['heading_title']  =  'Lyrics Price';

		$data['res']            =  $res_array;

		$data['parent_id']      =  $parent_id;
        
		if( $this->input->post('status_action')!='')
		{

			
			if($this->input->post('status_action')=='Activate'){
			
				$arr_ids=$this->input->post('arr_ids');
				
				if(is_array($arr_ids) && count($arr_ids) > 0){
					foreach($arr_ids as $value){
					
						$this->db->query("UPDATE tbl_lyrics_price SET status='1' WHERE price_id ='$value'");	
						
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
					
						$this->db->query("UPDATE tbl_lyrics_price SET status='0' WHERE price_id ='$value'");	
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
					   
					 
					   $this->db->query("DELETE FROM tbl_lyrics_price  WHERE price_id ='$value'");	
					   $this->session->set_userdata(array('msg_type'=>'success'));
					   $this->session->set_flashdata('success',"Selected record(s) has been deleted successfully." );
					   
					}
					
				}
				redirect($_SERVER['HTTP_REFERER']);
			
			}
			
		
		}
		$this->load->view('lyrics_price/view_lyrics_price_list',$data);

	}

	public function add_lyrics_price()
	{
		$data['heading_title'] = 'Add Price';

		
		$this->form_validation->set_rules('lyrics_type','Lyrics Type',"trim|required");
		$this->form_validation->set_rules('duration','Duration',"trim|required|unique[tbl_lyrics_price.duration='".$this->db->escape_str($this->input->post('duration'))."' AND status!='2' AND  tbl_lyrics_price.lyrics_type='".$this->db->escape_str($this->input->post('lyrics_type'))."' ]");
		
		$this->form_validation->set_rules('price','Price',"trim|required|max_length[32] ");
		
		
		

		if($this->form_validation->run()===TRUE)
		{
			$posted_data = array(
			'price'=>$this->input->post('price'),
			'duration'=>$this->input->post('duration'),
			'lyrics_type'=>$this->input->post('lyrics_type'),
			'status'=>1
			);
			$posted_data=$this->security->xss_clean($posted_data);
			$this->price_model->safe_insert('tbl_lyrics_price',$posted_data,FALSE);

			$this->session->set_userdata(array('msg_type'=>'success'));
			$this->session->set_flashdata('success',lang('success'));
			redirect('sitepanel/manage_prices/lyrics_price', '');

		}
		$this->load->view('lyrics_price/view_lyrics_price_add',$data);

	}

	public function edit_lyrics_price()
	{
		$priceId = (int) $this->uri->segment(4);

		$rowdata=$this->price_model->get_lyrics_price_by_id($priceId);

		$priceId = $rowdata['price_id'];

		$data['heading_title'] = 'Manage Lyrics Price';

		if( !is_array($rowdata) )
		{
		  $this->session->set_flashdata('message', lang('idmissing'));
		  redirect('sitepanel/manage_price/lyrics_price', '');
		}
		
		$this->form_validation->set_rules('lyrics_type','Lyrics Type',"trim|required");
		$this->form_validation->set_rules('duration','Duration',"trim|required|unique[tbl_lyrics_price.duration='".$this->db->escape_str($this->input->post('duration'))."' AND lyrics_type='".$this->db->escape_str($this->input->post('lyrics_type'))."' AND status!='2' AND price_id != ".$priceId."]");
		$this->form_validation->set_rules('price','Price',"trim|required|max_length[32]");
	

		if($this->form_validation->run()==TRUE)
		{
			$posted_data = array(
			'price'=>$this->input->post('price'),
			'duration'=>$this->input->post('duration'),
			'lyrics_type'=>$this->input->post('lyrics_type')
			);
            $posted_data=$this->security->xss_clean($posted_data);
			$where = "price_id = '".$priceId."'";
			$this->price_model->safe_update('tbl_lyrics_price',$posted_data,$where,FALSE);

			$this->session->set_userdata(array('msg_type'=>'success'));
			$this->session->set_flashdata('success',lang('successupdate'));

			redirect('sitepanel/manage_prices/lyrics_price'.'/'.query_string(), '');

		}

		$data['res']=$rowdata;
		$this->load->view('lyrics_price/view_lyrics_price_edit',$data);

	}
	//////////////////////////////// end lyrics price /////////////////////////////
	
	
	
	/////////////////////////////Mixing Price///////////////////////////////////////
	
	public  function mixing_price()
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
		$res_array              =  $this->price_model->get_mixing_price($condtion_array);
		$config['total_rows']	=  $this->price_model->total_rec_found;
		$data['page_links']     =  admin_pagination($base_url,$config['total_rows'],$config['limit'],$offset);
		$data['heading_title']  =  'Mixing Price';

		$data['res']            =  $res_array;

		$data['parent_id']      =  $parent_id;
        
		if( $this->input->post('status_action')!='')
		{

			
			if($this->input->post('status_action')=='Activate'){
			
				$arr_ids=$this->input->post('arr_ids');
				
				if(is_array($arr_ids) && count($arr_ids) > 0){
					foreach($arr_ids as $value){
					
						$this->db->query("UPDATE tbl_mixing_price SET status='1' WHERE price_id ='$value'");	
						
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
					
						$this->db->query("UPDATE tbl_mixing_price SET status='0' WHERE price_id ='$value'");	
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
					   
					 
					   $this->db->query("DELETE FROM tbl_mixing_price  WHERE price_id ='$value'");	
					   $this->session->set_userdata(array('msg_type'=>'success'));
					   $this->session->set_flashdata('success',"Selected record(s) has been deleted successfully." );
					   
					}
					
				}
				redirect($_SERVER['HTTP_REFERER']);
			
			}
			
		
		}
		$this->load->view('mixing_price/view_mixing_price_list',$data);

	}

	public function add_mixing_price()
	{
		$data['heading_title'] = 'Add Price';

		
		$this->form_validation->set_rules('track_id','Track',"trim|required");
		$this->form_validation->set_rules('duration','Duration',"trim|required|unique[tbl_mixing_price.duration='".$this->db->escape_str($this->input->post('duration'))."' AND status!='2' AND  tbl_mixing_price.track_id='".$this->db->escape_str($this->input->post('track_id'))."' ] ");
		$this->form_validation->set_rules('price','Price',"trim|required|max_length[32]");

		if($this->form_validation->run()===TRUE)
		{
			$posted_data = array(
			'price'=>$this->input->post('price'),
			'duration'=>$this->input->post('duration'),
			'track_id'=>$this->input->post('track_id'),
			'status'=>1
			);
			$posted_data=$this->security->xss_clean($posted_data);
			$this->price_model->safe_insert('tbl_mixing_price',$posted_data,FALSE);

			$this->session->set_userdata(array('msg_type'=>'success'));
			$this->session->set_flashdata('success',lang('success'));
			redirect('sitepanel/manage_prices/mixing_price', '');

		}
		$this->load->view('mixing_price/view_mixing_price_add',$data);

	}

	public function edit_mixing_price()
	{
		$priceId = (int) $this->uri->segment(4);

		$rowdata=$this->price_model->get_mixing_price_by_id($priceId);

		$priceId = $rowdata['price_id'];

		$data['heading_title'] = 'Manage Price';

		if( !is_array($rowdata) )
		{
		  $this->session->set_flashdata('message', lang('idmissing'));
		  redirect('sitepanel/manage_price/mixing_price', '');
		}
		
		$this->form_validation->set_rules('track_id','Track',"trim|required");
		$this->form_validation->set_rules('duration','Duration',"trim|required|unique[tbl_mixing_price.duration='".$this->db->escape_str($this->input->post('duration'))."' AND  tbl_mixing_price.track_id='".$this->db->escape_str($this->input->post('track_id'))."' AND status!='2' AND price_id != ".$priceId."]");
		$this->form_validation->set_rules('price','Price',"trim|required|max_length[32]");
		if($this->form_validation->run()==TRUE)
		{
			$posted_data = array(
			'price'=>$this->input->post('price'),
			'duration'=>$this->input->post('duration'),
			'track_id'=>$this->input->post('track_id')
			);
            $posted_data=$this->security->xss_clean($posted_data);
			$where = "price_id = '".$priceId."'";
			$this->price_model->safe_update('tbl_mixing_price',$posted_data,$where,FALSE);
			$this->session->set_userdata(array('msg_type'=>'success'));
			$this->session->set_flashdata('success',lang('successupdate'));
			redirect('sitepanel/manage_prices/mixing_price'.'/'.query_string(), '');

		}

		$data['res']=$rowdata;
		$this->load->view('mixing_price/view_mixing_price_edit',$data);

	}
	
	
	////////////////////////////Mixing Price End ///////////////////////////////////
	
	/////////////////////////// Mastring prices ////////////////////////////////////
	
		public  function mastring_price()
	    {
		
		$pagesize               =  (int) $this->input->get_post('pagesize');
		$config['limit']		=  ( $pagesize > 0 ) ? $pagesize : $this->config->item('pagesize');
		$offset                 =  ( $this->input->get_post('per_page') > 0 ) ? $this->input->get_post('per_page') : 0;
		$base_url               =  current_url_query_string(array('filter'=>'result'),array('per_page'));
		$parent_id              =   (int) $this->uri->segment(4,0);

		$keyword = trim($this->input->get_post('keyword',TRUE));
		$keyword = $this->db->escape_str($keyword);
		$condtion = " AND mastring_type='1' ";

		$condtion_array = array(
								'field' =>"*",
								'condition'=>$condtion,
								'limit'=>$config['limit'],
								'offset'=>$offset	,
								'debug'=>FALSE
								);
		$res_array              =  $this->price_model->get_mastring_price($condtion_array);
		
		$config['total_rows']	=  $this->price_model->total_rec_found;
		$data['page_links']     =  admin_pagination($base_url,$config['total_rows'],$config['limit'],$offset);
		$data['heading_title']  =  'Single Song Mastering';

		$data['res']            =  $res_array;

		$data['parent_id']      =  $parent_id;
        
		if( $this->input->post('status_action')!='')
		{

			
			if($this->input->post('status_action')=='Activate'){
			
				$arr_ids=$this->input->post('arr_ids');
				
				if(is_array($arr_ids) && count($arr_ids) > 0){
					foreach($arr_ids as $value){
					
						$this->db->query("UPDATE tbl_mastring_price SET status='1' WHERE price_id ='$value'");	
						
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
					
						$this->db->query("UPDATE tbl_mastring_price SET status='0' WHERE price_id ='$value'");	
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
					   
					 
					   $this->db->query("DELETE FROM tbl_mastring_price  WHERE price_id ='$value'");	
					   $this->session->set_userdata(array('msg_type'=>'success'));
					   $this->session->set_flashdata('success',"Selected record(s) has been deleted successfully." );
					   
					}
					
				}
				redirect($_SERVER['HTTP_REFERER']);
			
			}
			
		
		}
		$this->load->view('mastring_price/view_mastring_price_list',$data);

	}

	public function add_mastring_price()
	{
		$data['heading_title'] = 'Add Single Song Mastering';
		$this->form_validation->set_rules('duration','Duration',"trim|required|unique[tbl_mastring_price.duration='".$this->db->escape_str($this->input->post('duration'))."' AND tbl_mastring_price.mastring_type='1' AND status!='2']");
		$this->form_validation->set_rules('price','Price',"trim|required|max_length[32] ");

		if($this->form_validation->run()===TRUE)
		{
			$posted_data = array(
			'price'=>$this->input->post('price'),
			'duration'=>$this->input->post('duration'),
			'mastring_type'=>1,
			'status'=>1
			);
			$posted_data=$this->security->xss_clean($posted_data);
			$this->price_model->safe_insert('tbl_mastring_price',$posted_data,FALSE);

			$this->session->set_userdata(array('msg_type'=>'success'));
			$this->session->set_flashdata('success',lang('success'));
			redirect('sitepanel/manage_prices/mastring_price', '');

		}
		$this->load->view('mastring_price/view_mastring_price_add',$data);

	}

	public function edit_mastring_price()
	{
		$priceId = (int) $this->uri->segment(4);

		$rowdata=$this->price_model->get_mastring_price_by_id($priceId);

		$priceId = $rowdata['price_id'];

		$data['heading_title'] = 'Edit Single Song Mastering';

		if( !is_array($rowdata) )
		{
		  $this->session->set_flashdata('message', lang('idmissing'));
		  redirect('sitepanel/manage_price/mastring_price', '');
		}
		$this->form_validation->set_rules('duration','Duration',"trim|required|unique[tbl_mastring_price.duration='".$this->db->escape_str($this->input->post('duration'))."' AND mastring_type='1' AND status!='2' AND price_id != ".$priceId."]");
		$this->form_validation->set_rules('price','Price',"trim|required|max_length[32]");
		if($this->form_validation->run()==TRUE)
		{
			$posted_data = array(
			'price'=>$this->input->post('price'),
			'duration'=>$this->input->post('duration'),
			);
            $posted_data=$this->security->xss_clean($posted_data);
			$where = "price_id = '".$priceId."'";
			$this->price_model->safe_update('tbl_mastring_price',$posted_data,$where,FALSE);

			$this->session->set_userdata(array('msg_type'=>'success'));
			$this->session->set_flashdata('success',lang('successupdate'));

			redirect('sitepanel/manage_prices/mastring_price'.'/'.query_string(), '');

		}

		$data['res']=$rowdata;
		$this->load->view('mastring_price/view_mastring_price_edit',$data);

	}
	
	
	public  function fullmastring_price()
	    {
		
		$pagesize               =  (int) $this->input->get_post('pagesize');
		$config['limit']		=  ( $pagesize > 0 ) ? $pagesize : $this->config->item('pagesize');
		$offset                 =  ( $this->input->get_post('per_page') > 0 ) ? $this->input->get_post('per_page') : 0;
		$base_url               =  current_url_query_string(array('filter'=>'result'),array('per_page'));
		$parent_id              =   (int) $this->uri->segment(4,0);

		$keyword = trim($this->input->get_post('keyword',TRUE));
		$keyword = $this->db->escape_str($keyword);
		$condtion = " AND mastring_type='2' ";

		$condtion_array = array(
								'field' =>"*",
								'condition'=>$condtion,
								'limit'=>$config['limit'],
								'offset'=>$offset	,
								'debug'=>FALSE
								);
		$res_array              =  $this->price_model->get_mastring_price(
		$condtion_array);
		
		$config['total_rows']	=  $this->price_model->total_rec_found;
		$data['page_links']     =  admin_pagination($base_url,$config['total_rows'],        $config['limit'],$offset);
		$data['heading_title']  =  'Full Album Mastering';
		$data['res']            =  $res_array;
		$data['parent_id']      =  $parent_id;
		if( $this->input->post('status_action')!='')
		{
			if($this->input->post('status_action')=='Activate'){
				$arr_ids=$this->input->post('arr_ids');
				if(is_array($arr_ids) && count($arr_ids) > 0){
					foreach($arr_ids as $value){
					
						$this->db->query("UPDATE tbl_mastring_price SET status='1' WHERE price_id ='$value'");	
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
					
						$this->db->query("UPDATE tbl_mastring_price SET status='0' WHERE price_id ='$value'");	
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
					   $this->db->query("DELETE FROM tbl_mastring_price  WHERE price_id ='$value'");	
					   $this->session->set_userdata(array('msg_type'=>'success'));
					   $this->session->set_flashdata('success',"Selected record(s) has been deleted successfully." );
					}
				}
				redirect($_SERVER['HTTP_REFERER']);
			}
		}
		$this->load->view('mastring_price/view_fullmastring_price_list',$data);
	}
	
	
	public function add_fullmastring_price()
	{
		$data['heading_title'] = 'Add Full Album Mastering';
		$this->form_validation->set_rules('duration','Track',"trim|required|unique[tbl_mastring_price.duration='".$this->db->escape_str($this->input->post('duration'))."' AND tbl_mastring_price.mastring_type='2' AND status!='2']");
		$this->form_validation->set_rules('price','Price',"trim|required|max_length[32] ");

		if($this->form_validation->run()===TRUE)
		{
			$posted_data = array(
			'price'=>$this->input->post('price'),
			'duration'=>$this->input->post('duration'),
			'mastring_type'=>2,
			'status'=>1
			);
			$posted_data=$this->security->xss_clean($posted_data);
			$this->price_model->safe_insert('tbl_mastring_price',$posted_data,FALSE);

			$this->session->set_userdata(array('msg_type'=>'success'));
			$this->session->set_flashdata('success',lang('success'));
			redirect('sitepanel/manage_prices/fullmastring_price', '');

		}
		$this->load->view('mastring_price/view_fullmastring_price_add',$data);
	}
	
	
	public function edit_fullmastring_price()
	{
		$priceId = (int) $this->uri->segment(4);

		$rowdata=$this->price_model->get_mastring_price_by_id($priceId);

		$priceId = $rowdata['price_id'];

		$data['heading_title'] = 'Edit Full Album Mastering';

		if( !is_array($rowdata) )
		{
		  $this->session->set_flashdata('message', lang('idmissing'));
		  redirect('sitepanel/manage_price/fullmastring_price', '');
		}
		$this->form_validation->set_rules('duration','Duration',"trim|required|unique[tbl_mastring_price.duration='".$this->db->escape_str($this->input->post('duration'))."' AND mastring_type='2' AND status!='2' AND price_id != ".$priceId."]");
		$this->form_validation->set_rules('price','Price',"trim|required|max_length[32]");
		if($this->form_validation->run()==TRUE)
		{
			$posted_data = array(
			'price'=>$this->input->post('price'),
			'duration'=>$this->input->post('duration'),
			);
            $posted_data=$this->security->xss_clean($posted_data);
			$where = "price_id = '".$priceId."'";
			$this->price_model->safe_update('tbl_mastring_price',$posted_data,$where,FALSE);

			$this->session->set_userdata(array('msg_type'=>'success'));
			$this->session->set_flashdata('success',lang('successupdate'));

			redirect('sitepanel/manage_prices/fullmastring_price'.'/'.query_string(), '');

		}

		$data['res']=$rowdata;
		$this->load->view('mastring_price/view_fullmastring_price_edit',$data);

	}
	
	/////////////////////////// End mastring prices ///////////////////////////////
	
	
	
	
	/////////////////////////////Sound Recording Price///////////////////////////////////////
	
	public  function sound_recording_price()
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
		$res_array              =  $this->price_model->get_sound_recording_price($condtion_array);
		$config['total_rows']	=  $this->price_model->total_rec_found;
		$data['page_links']     =  admin_pagination($base_url,$config['total_rows'],$config['limit'],$offset);
		$data['heading_title']  =  'Sound Recording Price';

		$data['res']            =  $res_array;

		$data['parent_id']      =  $parent_id;
        
		if( $this->input->post('status_action')!='')
		{

			
			if($this->input->post('status_action')=='Activate'){
			
				$arr_ids=$this->input->post('arr_ids');
				
				if(is_array($arr_ids) && count($arr_ids) > 0){
					foreach($arr_ids as $value){
					
						$this->db->query("UPDATE tbl_sound_recording_price SET status='1' WHERE price_id ='$value'");	
						
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
					
						$this->db->query("UPDATE tbl_sound_recording_price SET status='0' WHERE price_id ='$value'");	
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
					   
					 
					   $this->db->query("DELETE FROM tbl_sound_recording_price  WHERE price_id ='$value'");	
					   $this->session->set_userdata(array('msg_type'=>'success'));
					   $this->session->set_flashdata('success',"Selected record(s) has been deleted successfully." );
					   
					}
					
				}
				redirect($_SERVER['HTTP_REFERER']);
			
			}
			
		
		}
		$this->load->view('sound_recording_price/view_sound_recording_price_list',$data);

	}

	public function add_sound_recording_price()
	{
		$data['heading_title'] = 'Add Price';

		
		$this->form_validation->set_rules('sound_recording_category','Sound Recording Category',"trim|required|unique[tbl_sound_recording_price.sound_recording_category='".$this->db->escape_str($this->input->post('sound_recording_category'))."' AND status!='2' ]");
		$this->form_validation->set_rules('price','Price',"trim|required|max_length[32] ");
		
		
		

		if($this->form_validation->run()===TRUE)
		{
			$posted_data = array(
			'price'=>$this->input->post('price'),
			'sound_recording_category'=>$this->input->post('sound_recording_category'),
			'status'=>1
			);
			$posted_data=$this->security->xss_clean($posted_data);
			$this->price_model->safe_insert('tbl_sound_recording_price',$posted_data,FALSE);

			$this->session->set_userdata(array('msg_type'=>'success'));
			$this->session->set_flashdata('success',lang('success'));
			redirect('sitepanel/manage_prices/sound_recording_price', '');

		}
		$this->load->view('sound_recording_price/view_sound_recording_price_add',$data);

	}

	public function edit_sound_recording_price()
	{
		$priceId = (int) $this->uri->segment(4);

		$rowdata=$this->price_model->get_sound_recording_price_by_id($priceId);

		$priceId = $rowdata['price_id'];

		$data['heading_title'] = 'Manage Price';

		if( !is_array($rowdata) )
		{
		  $this->session->set_flashdata('message', lang('idmissing'));
		  redirect('sitepanel/manage_price/sound_recording_price', '');
		}
		
		$this->form_validation->set_rules('sound_recording_category','Sound Recording Category',"trim|required|unique[tbl_sound_recording_price.sound_recording_category='".$this->db->escape_str($this->input->post('sound_recording_category'))."' AND status!='2'  AND price_id != ".$priceId."]");
		$this->form_validation->set_rules('price','Price',"trim|required|max_length[32]");

		if($this->form_validation->run()==TRUE)
		{
			$posted_data = array(
			'price'=>$this->input->post('price'),
			'sound_recording_category'=>$this->input->post('sound_recording_category')
			);
            $posted_data=$this->security->xss_clean($posted_data);
			$where = "price_id = '".$priceId."'";
			$this->price_model->safe_update('tbl_sound_recording_price',$posted_data,$where,FALSE);

			$this->session->set_userdata(array('msg_type'=>'success'));
			$this->session->set_flashdata('success',lang('successupdate'));

			redirect('sitepanel/manage_prices/sound_recording_price'.'/'.query_string(), '');

		}

		$data['res']=$rowdata;
		$this->load->view('sound_recording_price/view_sound_recording_price_edit',$data);

	}
	
	
	////////////////////////////Sound Recording Price End ///////////////////////////////////
	
	
	/////////////////////////////Desisnging Price///////////////////////////////////////
	
	public  function designing_price()
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
		$res_array              =  $this->price_model->get_designing_price($condtion_array);
		$config['total_rows']	=  $this->price_model->total_rec_found;
		$data['page_links']     =  admin_pagination($base_url,$config['total_rows'],$config['limit'],$offset);
		$data['heading_title']  =  'Designing Price';

		$data['res']            =  $res_array;

		$data['parent_id']      =  $parent_id;
        
		if( $this->input->post('status_action')!='')
		{

			
			if($this->input->post('status_action')=='Activate'){
			
				$arr_ids=$this->input->post('arr_ids');
				
				if(is_array($arr_ids) && count($arr_ids) > 0){
					foreach($arr_ids as $value){
					
						$this->db->query("UPDATE tbl_designing_price SET status='1' WHERE price_id ='$value'");	
						
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
					
						$this->db->query("UPDATE tbl_designing_price SET status='0' WHERE price_id ='$value'");	
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
					   
					 
					   $this->db->query("DELETE FROM tbl_designing_price  WHERE price_id ='$value'");	
					   $this->session->set_userdata(array('msg_type'=>'success'));
					   $this->session->set_flashdata('success',"Selected record(s) has been deleted successfully." );
					   
					}
					
				}
				redirect($_SERVER['HTTP_REFERER']);
			
			}
			
		
		}
		$this->load->view('designing_price/view_designing_price_list',$data);

	}

	public function add_designing_price()
	{
		$data['heading_title'] = 'Add Price';
		$this->form_validation->set_rules('duration','Duration',"trim|required|unique[tbl_designing_price.duration='".$this->db->escape_str($this->input->post('duration'))."' AND status!='2' ]");
		
		$this->form_validation->set_rules('price','Price',"trim|required|max_length[32] ");
		
		
		

		if($this->form_validation->run()===TRUE)
		{
			$posted_data = array(
			'price'=>$this->input->post('price'),
			'duration'=>$this->input->post('duration'),
			'status'=>1
			);
			$posted_data=$this->security->xss_clean($posted_data);
			$this->price_model->safe_insert('tbl_designing_price',$posted_data,FALSE);

			$this->session->set_userdata(array('msg_type'=>'success'));
			$this->session->set_flashdata('success',lang('success'));
			redirect('sitepanel/manage_prices/designing_price', '');

		}
		$this->load->view('designing_price/view_designing_price_add',$data);

	}

	public function edit_designing_price()
	{
		$priceId = (int) $this->uri->segment(4);

		$rowdata=$this->price_model->get_designing_price_by_id($priceId);

		$priceId = $rowdata['price_id'];

		$data['heading_title'] = 'Manage Price';

		if( !is_array($rowdata) )
		{
		  $this->session->set_flashdata('message', lang('idmissing'));
		  redirect('sitepanel/manage_price/designing_price', '');
		}
		
		$this->form_validation->set_rules('duration','Duration',"trim|required|unique[tbl_designing_price.duration='".$this->db->escape_str($this->input->post('duration'))."' AND status!='2'   AND price_id != ".$priceId."]");
		
		$this->form_validation->set_rules('price','Price',"trim|required|max_length[32]");
	

		if($this->form_validation->run()==TRUE)
		{
			$posted_data = array(
			'price'=>$this->input->post('price'),
			'duration'=>$this->input->post('duration')
			);
            $posted_data=$this->security->xss_clean($posted_data);
			$where = "price_id = '".$priceId."'";
			$this->price_model->safe_update('tbl_designing_price',$posted_data,$where,FALSE);

			$this->session->set_userdata(array('msg_type'=>'success'));
			$this->session->set_flashdata('success',lang('successupdate'));

			redirect('sitepanel/manage_prices/designing_price'.'/'.query_string(), '');

		}

		$data['res']=$rowdata;
		$this->load->view('designing_price/view_designing_price_edit',$data);

	}
	
	
	////////////////////////////Mixing Price End ///////////////////////////////////
	
	

}
// End of controller