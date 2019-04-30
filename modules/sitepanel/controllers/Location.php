<?php
class Location extends Admin_Controller {

  public $view_path;
  public $current_controller;

  public function __construct() {
   
    parent::__construct();
    $this->current_controller = $this->router->fetch_class();
    $this->load->model(array('location_model'));
	$this->load->helper(array('download'));
    $this->config->set_item('menu_highlight', 'location');
    $this->view_path = $this->current_controller . "/";
	
  }

  //Country 
	public function index() {
	
		$pagesize        = (int) $this->input->get_post('pagesize');
		$config['limit'] = ( $pagesize > 0 ) ? $pagesize : $this->config->item('pagesize');
		$offset          = ( $this->input->get_post('per_page') > 0 ) ? $this->input->get_post('per_page') : 0;
		$base_url        = current_url_query_string(array('filter' => 'result'), array('per_page'));
		$keyword         = trim($this->input->get_post('keyword', TRUE));
		$keyword         = $this->db->escape_str($keyword);
		$condtion        = " ";
		
		if ($keyword != '') {
			$condtion = "AND country_name like '%" . $keyword . "%'";
		}
		
		$condtion_array = array(
								'condition' => $condtion,
								'limit'     => $config['limit'],
								'offset'    => $offset,
								'debug'     => FALSE
		                       );
		
		$res_array             = $this->location_model->get_record($condtion_array);
		$config['total_rows']  = $this->location_model->total_rec_found;
		$data['page_links']    = admin_pagination($base_url, $config['total_rows'], $config['limit'], $offset);
		$data['heading_title'] = "Manage Country";
		$data['res']           = $res_array;
		
		
		if ($this->input->post('status_action') != '') {
		
			if ($this->input->post('status_action') == "Available Premimum Ads") {
				
				$arr_ids = $this->input->post('arr_ids');
				if (is_array($arr_ids)) {
				
					$id_str = implode(',', $arr_ids);
					$data = array("premimum_ads_avl" => "1");
					$where = "id IN($id_str)";
					$this->location_model->safe_update("tbl_country", $data, $where, TRUE);
				
				}
				
				$this->session->set_userdata(array('msg_type' => 'success'));
				$this->session->set_flashdata('success', lang('successupdate'));
				redirect($this->input->server('HTTP_REFERER'));
			} elseif ($this->input->post('status_action') == "Not Available Premimum Ads") {
			
				$arr_ids = $this->input->post('arr_ids');
				//trace($arr_ids);exit;
				if (is_array($arr_ids)) {
					
					//trace($arr_ids);exit;
					$id_str = implode(',', $arr_ids);
					$data = array("premimum_ads_avl" => "0");
					$where = "id IN($id_str)";
					$this->location_model->safe_update("tbl_country", $data, $where, TRUE);
					
				}
				$this->session->set_userdata(array('msg_type' => 'success'));
				$this->session->set_flashdata('success', lang('successupdate'));
				redirect($this->input->server('HTTP_REFERER'));
				
			} else {
			$this->update_status('tbl_country', 'id');
			}
		
		}
		$data['includes'] = $this->view_path . 'list_vew';
		$this->load->view('includes/sitepanel_container', $data);
	
	}

	public function add_edit() {
	
		$id       = (int) $this->uri->segment(4, 0);
		$row_data = '';
		
		if ($id > 0) {
			$row_data = $this->location_model->get_record_by_id($id);
		}
		$data['row']           = $row_data;
		$data['parentData']    = '';
		$data['heading_title'] = ($id > 0) ? 'Edit Country' : 'Add Country';
		
		if (is_object($row_data)) {
		
			$this->form_validation->set_rules('country_name', 'Country Name', "trim|required|max_length[100]|xss_clean|unique[tbl_country.country_name='" . $this->db->escape_str($this->input->post('country_name')) . "' AND tbl_country.status!='2' AND tbl_country.id !=$id]");
		
		} else {
			
			$this->form_validation->set_rules('country_name', 'Country Name', "trim|required|max_length[100]|xss_clean|unique[tbl_country.country_name='" . $this->db->escape_str($this->input->post('country_name')) . "' AND tbl_country.status!='2']");
		
		}
		
		if ($this->form_validation->run() === TRUE) {
		
			if ($id > 0) {
			
				$posted_data = array(
					                  'country_name' => $this->input->post('country_name'),
				                      'country_temp_name' => str_replace("-","",url_title($this->input->post('country_name'))),
				                      'cont_currency' => $this->input->post('cont_currency')
				);
				
				$this->location_model->safe_update('tbl_country', $posted_data, "id ='" . $id . "'", FALSE);
				$this->session->set_userdata(array('msg_type' => 'success'));
				$this->session->set_flashdata('success', lang('successupdate'));
			
			} else {
				
				$posted_data = array(
				                      'country_name' => $this->input->post('country_name'),
				                      'country_temp_name' => str_replace("-","",url_title($this->input->post('country_name'))),
				                     'cont_currency' => $this->input->post('cont_currency')
				                    );
				
				$this->location_model->safe_insert('tbl_country', $posted_data, FALSE);
				$this->session->set_userdata(array('msg_type' => 'success'));
				$this->session->set_flashdata('success', lang('success'));
			
			}
			
			$redirect_path = 'location';
			redirect('sitepanel/' . $redirect_path, '');
		
		}
		$data['includes'] = $this->view_path . 'addedit_view';
		$this->load->view('includes/sitepanel_container', $data);
	
	}

  //State
	public function state() {
	
		$pagesize        = (int) $this->input->get_post('pagesize');
		$config['limit'] = ( $pagesize > 0 ) ? $pagesize : $this->config->item('pagesize');
		$offset          = ( $this->input->get_post('per_page') > 0 ) ? $this->input->get_post('per_page') : 0;
		$base_url        = current_url_query_string(array('filter' => 'result'), array('per_page'));
		
		$keyword         = $this->db->escape_str(trim($this->input->get_post('keyword', TRUE)));
		$country_id      = $this->db->escape_str(trim($this->input->get_post('country_id', TRUE)));
		$condtion        = " ";
		
		if ($keyword != '') {
			
			$condtion .= "AND title like '%" . $keyword . "%'";
			
		}
		if ($country_id > 0) {
			
			$condtion .= "AND country_id ='" . $country_id . "'";
			
		}
		
		$condtion_array = array(
								'condition' => $condtion,
								'limit'     => $config['limit'],
								'offset'    => $offset,
								'debug'     => FALSE
								);
		
		$res_array             = $this->location_model->get_states($condtion_array);
		$config['total_rows']  = $this->location_model->total_rec_found;
		$data['page_links']    = admin_pagination($base_url, $config['total_rows'], $config['limit'], $offset);
		$data['heading_title'] = "Manage States";
		$data['res']           = $res_array;
		
		
		if ($this->input->post('status_action') != '') {
		
			if ($this->input->post('status_action') == "Set Popular") {
			
				$arr_ids = $this->input->post('arr_ids');
				if (is_array($arr_ids)) {
					
					$id_str = implode(',', $arr_ids);
					$data   = array("is_state_popular" => "1");
					$where  = "id IN($id_str)";
					$this->location_model->safe_update("tbl_states", $data, $where, TRUE);
					
				}
				$this->session->set_userdata(array('msg_type' => 'success'));
				$this->session->set_flashdata('success', lang('successupdate'));
				redirect($this->input->server('HTTP_REFERER'));
			
			} elseif ($this->input->post('status_action') == "Unset Popular") {
			
				$arr_ids = $this->input->post('arr_ids');
				//trace($arr_ids);exit;
				if (is_array($arr_ids)) {
					
					//trace($arr_ids);exit;
					$id_str = implode(',', $arr_ids);
					$data   = array("is_state_popular" => "0");
					$where  = "id IN($id_str)";
					$this->location_model->safe_update("tbl_states", $data, $where, TRUE);
					
				}
				$this->session->set_userdata(array('msg_type' => 'success'));
				$this->session->set_flashdata('success', lang('successupdate'));
				redirect($this->input->server('HTTP_REFERER'));
			
			} else {
				
				$this->update_status('tbl_states', 'id');
				
			}
		
		}
		
		$data['includes'] = $this->view_path . 'state_list_vew';
		$this->load->view('includes/sitepanel_container', $data);
	
	}

	public function state_add_edit() {
	
		$id       = (int) $this->uri->segment(4, 0);
		$row_data = '';
		if ($id > 0) {
			
			$row_data = $this->location_model->get_single_row("tbl_states", $id);
			
		}
		$data['row']           = $row_data;
		$data['parentData']    = '';
		$data['heading_title'] = ($id > 0) ? 'Edit State' : 'Add State';
		
		if (is_object($row_data)) {
			
			$this->form_validation->set_rules('country_id', 'Country', "trim|required|max_length[11]");
			$this->form_validation->set_rules('title', 'State Name', "trim|required|max_length[100]|unique[tbl_states.title='" . $this->db->escape_str($this->input->post('title')) . "' AND tbl_states.status!='2' AND tbl_states.country_id='" . $this->db->escape_str($this->input->post('country_id')) . "' AND tbl_states.id !=$id]");
			
		} else {
			
			$this->form_validation->set_rules('country_id', 'Country', "trim|required|max_length[11]");
			$this->form_validation->set_rules('title', 'State Name', "trim|required|max_length[100]|unique[tbl_states.title='" . $this->db->escape_str($this->input->post('title')) . "' AND tbl_states.status!='2' AND tbl_states.country_id='" . $this->db->escape_str($this->input->post('country_id')) . "']");
			
		}
		
		if ($this->form_validation->run() === TRUE) {
		
			if ($id > 0) {
			
				$url_title=str_replace("-","",url_title($this->input->post('title')));
				$posted_data = array(
				                     'title'      => $this->input->post('title'),
					                 'temp_title' => $url_title,
				                     'country_id' => url_title($this->input->post('country_id'))
				                    );
				
				$this->location_model->safe_update('tbl_states', $posted_data, "id ='" . $id . "'", FALSE);
				$this->session->set_userdata(array('msg_type' => 'success'));
				$this->session->set_flashdata('success', lang('successupdate'));
				$redirect_path = 'location/state';
			
			} else {
				
				$url_title=str_replace("-","",url_title($this->input->post('title')));
				$posted_data = array(
				                      'title'      => $this->input->post('title'),
					                  'temp_title' => $url_title,
				                      'country_id' => $this->input->post('country_id')
				                    );
				
				$this->location_model->safe_insert('tbl_states', $posted_data, FALSE);
				$this->session->set_userdata(array('msg_type' => 'success'));
				$this->session->set_flashdata('success', lang('success'));
				$redirect_path = 'location/state/?county='.$this->input->post('country_id');
			}
			redirect('sitepanel/' . $redirect_path, '');
		
		}
		$data['includes'] = $this->view_path . 'state_addedit_view';
		$this->load->view('includes/sitepanel_container', $data);
	
	}

  //City
	public function city() {
		
		$pagesize        = (int) $this->input->get_post('pagesize');
		$config['limit'] = ( $pagesize > 0 ) ? $pagesize : $this->config->item('pagesize');
		$offset          = ( $this->input->get_post('per_page') > 0 ) ? $this->input->get_post('per_page') : 0;
		$base_url        = current_url_query_string(array('filter' => 'result'), array('per_page'));
		
		$keyword         = $this->db->escape_str(trim($this->input->get_post('keyword', TRUE)));
		$country_id      = $this->db->escape_str(trim($this->input->get_post('country_id', TRUE)));
		$state_id        = $this->db->escape_str(trim($this->input->get_post('state_id', TRUE)));
		$is_city_popular = $this->db->escape_str(trim($this->input->get_post('is_city_popular', TRUE)));
		$is_othercity_popular = $this->db->escape_str(trim($this->input->get_post('is_othercity_popular', TRUE)));
		
		$condtion = " ";
		
		if ($keyword != '') {
			
			$condtion .= "AND title like '%" . $keyword . "%'";
			
		}
		if ($state_id > 0) {
			
			$condtion .= "AND state_id ='" . $state_id . "'";
			
		}
		if ($country_id > 0) {
			
			$condtion .= "AND country_id ='" . $country_id . "'";
			
		}
		if ($is_city_popular > 0) {
			
			$condtion .= "AND is_city_popular ='" . $is_city_popular . "'";
			
		}
		if ($is_othercity_popular > 0) {
			
			$condtion .= "AND is_othercity_popular ='" . $is_othercity_popular . "'";
			
		}
		
		$condtion_array = array(
								'condition' => $condtion,
								'limit'     => $config['limit'],
								'offset'    => $offset,
								'debug'     => FALSE
								);
		
		$res_array             = $this->location_model->get_city($condtion_array);
		$config['total_rows']  = $this->location_model->total_rec_found;
		$data['page_links']    = admin_pagination($base_url, $config['total_rows'], $config['limit'], $offset);
		$data['heading_title'] = "Manage City";
		$data['res']           = $res_array;
		
		if ($this->input->post('status_action') != '') {
			
			if ($this->input->post('status_action') == "Set Popular") {
				
				$arr_ids = $this->input->post('arr_ids');
				if (is_array($arr_ids)) {
					
					$id_str = implode(',', $arr_ids);
					$data   = array("is_city_popular" => "1");
					$where  = "id IN($id_str)";
					$this->location_model->safe_update("tbl_city", $data, $where, TRUE);
					
				}
				$this->session->set_userdata(array('msg_type' => 'success'));
				$this->session->set_flashdata('success', lang('successupdate'));
				redirect($this->input->server('HTTP_REFERER'));
			
			} elseif ($this->input->post('status_action') == "Unset Popular") {
			
				$arr_ids = $this->input->post('arr_ids');
				//trace($arr_ids);exit;
				if (is_array($arr_ids)) {
					
					//trace($arr_ids);exit;
					$id_str = implode(',', $arr_ids);
					$data   = array("is_city_popular" => "0");
					$where  = "id IN($id_str)";
					$this->location_model->safe_update("tbl_city", $data, $where, TRUE);
					
				}
				$this->session->set_userdata(array('msg_type' => 'success'));
				$this->session->set_flashdata('success', lang('successupdate'));
				redirect($this->input->server('HTTP_REFERER'));
			
			}
			elseif ($this->input->post('status_action') == "Set Othercity Popular") {
				
				$arr_ids = $this->input->post('arr_ids');
				if (is_array($arr_ids)) {
					
					$id_str = implode(',', $arr_ids);
					$data   = array("is_othercity_popular" => "1");
					$where  = "id IN($id_str)";
					$this->location_model->safe_update("tbl_city", $data, $where, TRUE);
					
				}
				$this->session->set_userdata(array('msg_type' => 'success'));
				$this->session->set_flashdata('success', lang('successupdate'));
				redirect($this->input->server('HTTP_REFERER'));
				
			}
			elseif ($this->input->post('status_action') == "Unset Othercity Popular") {
				
				$arr_ids = $this->input->post('arr_ids');
				if (is_array($arr_ids)) {
					
					$id_str = implode(',', $arr_ids);
					$data   = array("is_othercity_popular" => "0");
					$where  = "id IN($id_str)";
					$this->location_model->safe_update("tbl_city", $data, $where, TRUE);
					
				}
				$this->session->set_userdata(array('msg_type' => 'success'));
				$this->session->set_flashdata('success', lang('successupdate'));
				redirect($this->input->server('HTTP_REFERER'));
				
			}
			elseif ($this->input->post('status_action') == "Available Premimum Ads") {
			
				$arr_ids = $this->input->post('arr_ids');
				//trace($arr_ids);exit;
				if (is_array($arr_ids)) {
					
					//trace($arr_ids);exit;
					$id_str = implode(',', $arr_ids);
					$data   = array("premimum_ads_avl" => "1");
					$where  = "id IN($id_str)";
					$this->location_model->safe_update("tbl_city", $data, $where, TRUE);
					
				}
				$this->session->set_userdata(array('msg_type' => 'success'));
				$this->session->set_flashdata('success', lang('successupdate'));
				redirect($this->input->server('HTTP_REFERER'));
			
			} elseif ($this->input->post('status_action') == "Not Available Premimum Ads") {
			
				$arr_ids = $this->input->post('arr_ids');
				//trace($arr_ids);exit;
				if (is_array($arr_ids)) {
					
					//trace($arr_ids);exit;
					$id_str = implode(',', $arr_ids);
					$data   = array("premimum_ads_avl" => "0");
					$where  = "id IN($id_str)";
					$this->location_model->safe_update("tbl_city", $data, $where, TRUE);
					
				}
				$this->session->set_userdata(array('msg_type' => 'success'));
				$this->session->set_flashdata('success', lang('successupdate'));
				redirect($this->input->server('HTTP_REFERER'));
			
			} else {
				$this->update_status('tbl_city', 'id');
			}
		
		}
		
		$data['includes'] = $this->view_path . 'city_list_vew';
		$this->load->view('includes/sitepanel_container', $data);
	
	}

	public function city_add_edit() {
	
		$id       = (int) $this->uri->segment(4, 0);
		$row_data = '';
		if ($id > 0) {
			
			$row_data = $this->location_model->get_single_row("tbl_city", $id);
			
		}
		$data['row']           = $row_data;
		$data['parentData']    = '';
		$data['heading_title'] = ($id > 0) ? 'Edit City' : 'Add City';
		
		if (is_object($row_data)) {
		
			$this->form_validation->set_rules('country_id', 'Country', "trim|required|max_length[11]|xss_clean");
			$this->form_validation->set_rules('state_id', 'State', "trim|required|max_length[11]|xss_clean");
			
			$this->form_validation->set_rules('title', 'City Name', "trim|required|max_length[100]|xss_clean|unique[tbl_city.title='" . $this->db->escape_str($this->input->post('title')) . "' AND tbl_city.status!='2' and tbl_city.state_id='".$this->db->escape_str($this->input->post('state_id'))."' and tbl_city.country_id='".$this->db->escape_str($this->input->post('country_id'))."' AND tbl_city.id !=$id]");
		
		} else {
		
			$this->form_validation->set_rules('country_id', 'Country', "trim|required|max_length[11]|xss_clean");
			$this->form_validation->set_rules('state_id', 'State', "trim|required|max_length[11]|xss_clean");
			
			$this->form_validation->set_rules('title', 'City Name', "trim|required|max_length[100]|xss_clean|unique[tbl_city.title='" . $this->db->escape_str($this->input->post('title')) . "' AND tbl_city.status!='2' and tbl_city.state_id='".$this->db->escape_str($this->input->post('state_id'))."' and tbl_city.country_id='".$this->db->escape_str($this->input->post('country_id'))."' ]");
		
		}
		
		if ($this->form_validation->run() === TRUE) {
		
			$country_id=$this->input->post('country_id');
			$state_id=$this->input->post('state_id');
			if ($id > 0) {
			
				$url_title=str_replace("-","",url_title($this->input->post('title')));
				$posted_data = array(
									  'title'      => $this->input->post('title'),
									  'temp_title' => $url_title,
									  'country_id' => $this->input->post('country_id'),
									  'state_id'   => $this->input->post('state_id')
									);
				
				$this->location_model->safe_update('tbl_city', $posted_data, "id ='" . $id . "'", FALSE);
				$this->session->set_userdata(array('msg_type' => 'success'));
				$this->session->set_flashdata('success', lang('successupdate'));
				$redirect_path = 'location/city';
			
			} else {
			
				$url_title=str_replace("-","",url_title($this->input->post('title')));
				$posted_data = array(
									'title'      => $this->input->post('title'),
									'temp_title' => $url_title,
									'country_id' => $this->input->post('country_id'),
									'state_id'   => $this->input->post('state_id')
				                   );
				
				$city_id = $this->location_model->safe_insert('tbl_city', $posted_data, FALSE);
				$data  = array("city_group_id" => $city_id);
				$where = "id ='" . $city_id . "'";
				$this->location_model->safe_update('tbl_city', $data, $where, FALSE);
				$this->session->set_userdata(array('msg_type' => 'success'));
				$this->session->set_flashdata('success', lang('success'));
				$redirect_path = 'location/city_add_edit/?country_id='.$country_id.'&state_id='.$state_id;
			
			}
			redirect('sitepanel/' . $redirect_path, '');
		
		}
		$data['includes'] = $this->view_path . 'city_addedit_view';
		$this->load->view('includes/sitepanel_container', $data);
	
	}

	public function set_city_group() {
	
		$city_id          = (int) $this->uri->segment('4');
		$state_id         = (int) $this->uri->segment('5');
		$data['city_id']  = $city_id;
		$data['state_id'] = $state_id;
		
		$condtion = "AND state_id ='" . $state_id . "' AND id !='" . $city_id . "'";
		$condtion_array = array(
								 'condition' => $condtion,
								 'limit' => FALSE,
								 'offset' => FALSE,
								 'debug' => FALSE
								);
		$res_array   = $this->location_model->get_city($condtion_array);
		$data['res'] = $res_array;
		
		if ($this->input->post('action') == "Add in Group") {
		
			$arr_ids = $this->input->post('arr_ids');
			if (is_array($arr_ids) && count($arr_ids) > 0) {
				array_push($arr_ids, $city_id);
			} else {
				$arr_ids = array($city_id);
			}
			
			$id_str = implode(",", $arr_ids);
			$data   = array('city_group_id' => $id_str);
			$where  = "id ='" . $city_id . "'";
			$this->location_model->safe_update("tbl_city", $data, $where, FALSE);
			$this->session->set_userdata(array('msg_type' => 'success'));
			$this->session->set_flashdata('success', lang('successupdate'));
			$redirect_path = 'location/set_city_group/' . $city_id . "/" . $state_id;
			redirect('sitepanel/' . $redirect_path, '');
		
		}
		$this->load->view("location/set_city_group_view", $data);
	
	}

  //Neighborhood
	public function neighborhood() {
	
		$pagesize        = (int) $this->input->get_post('pagesize');
		$config['limit'] = ( $pagesize > 0 ) ? $pagesize : $this->config->item('pagesize');
		$offset          = ( $this->input->get_post('per_page') > 0 ) ? $this->input->get_post('per_page') : 0;
		$base_url        = current_url_query_string(array('filter' => 'result'), array('per_page'));
		$keyword         = $this->db->escape_str(trim($this->input->get_post('keyword', TRUE)));
		$country_id      = $this->db->escape_str(trim($this->input->get_post('country_id', TRUE)));
		$state_id        = $this->db->escape_str(trim($this->input->get_post('state_id', TRUE)));
		$city_id         = $this->db->escape_str(trim($this->input->get_post('city_id', TRUE)));
		$condtion        = " ";
		if ($keyword != '') {
			
			$condtion .= "AND title like '%" . $keyword . "%'";
			
		}
		if ($city_id > 0) {
			
			$condtion .= "AND city_id ='" . $city_id . "'";
			
		}
		if ($state_id > 0) {
			
			$condtion .= "AND state_id ='" . $state_id . "'";
			
		}
		if ($country_id > 0) {
			
			$condtion .= "AND country_id ='" . $country_id . "'";
			
		}
		$condtion_array = array(
								 'condition' => $condtion,
								 'limit'     => $config['limit'],
								 'offset'    => $offset,
								 'debug'     => FALSE
								);
		
		$res_array             = $this->location_model->get_neighborhood($condtion_array);
		$config['total_rows']  = $this->location_model->total_rec_found;
		$data['page_links']    = admin_pagination($base_url, $config['total_rows'], $config['limit'], $offset);
		$data['heading_title'] = "Manage Neighborhood";
		$data['res']           = $res_array;
		
		if ($this->input->post('status_action') != '') {
			$this->update_status('tbl_neighborhood', 'id');
		}
		$data['includes'] = $this->view_path . 'neighborhood_list_vew';
		$this->load->view('includes/sitepanel_container', $data);
	
	}

	public function neighborhood_add_edit() {
	
		$id           = (int) $this->uri->segment(4, 0);
		$row_data     = '';
		
		if ($id > 0) {
			
			$row_data = $this->location_model->get_single_row("tbl_neighborhood", $id);
			
		}
		$data['row']           = $row_data;
		$data['parentData']    = '';
		$data['heading_title'] = ($id > 0) ? 'Edit Neighborhood' : 'Add Neighborhood';
		
		if (is_object($row_data)) {
		
			$this->form_validation->set_rules('country_id', 'Country', "trim|required|max_length[11]|xss_clean");
			$this->form_validation->set_rules('state_id', 'State', "trim|required|max_length[11]|xss_clean");
			$this->form_validation->set_rules('city_id', 'City', "trim|required|max_length[11]|xss_clean");
			
			$this->form_validation->set_rules('title', 'Neighborhood', "trim|required|max_length[100]|xss_clean|unique[tbl_neighborhood.title='" . $this->db->escape_str($this->input->post('title')) . "' AND tbl_neighborhood.status!='2' AND tbl_neighborhood.country_id='" . $this->db->escape_str($this->input->post('country_id')) . "' AND tbl_neighborhood.state_id='" . $this->db->escape_str($this->input->post('state_id')) . "' AND tbl_neighborhood.city_id='" . $this->db->escape_str($this->input->post('city_id')) . "' AND tbl_neighborhood.id !=$id]");
		
		} else {
			
			$this->form_validation->set_rules('country_id', 'Country', "trim|required|max_length[11]|xss_clean");
			$this->form_validation->set_rules('state_id', 'State', "trim|required|max_length[11]|xss_clean");
			$this->form_validation->set_rules('city_id', 'City', "trim|required|max_length[11]|xss_clean");
			
			$this->form_validation->set_rules('title', 'Neighborhood', "trim|required|max_length[100]|xss_clean|unique[tbl_neighborhood.title='" . $this->db->escape_str($this->input->post('title')) . "' AND tbl_neighborhood.status!='2' AND tbl_neighborhood.country_id='" . $this->db->escape_str($this->input->post('country_id')) . "' AND tbl_neighborhood.state_id='" . $this->db->escape_str($this->input->post('state_id')) . "' AND tbl_neighborhood.city_id='" . $this->db->escape_str($this->input->post('city_id')) . "']");
		}
		
		if ($this->form_validation->run() === TRUE) {
			
			$country_id=$this->input->post('country_id');
			$state_id=$this->input->post('state_id');
			$city_id=$this->input->post('city_id');
			
			if ($id > 0) {
				
				$posted_data = array(
									'title'      => $this->input->post('title'),
									'country_id' => $this->input->post('country_id'),
									'state_id'   => $this->input->post('state_id'),
									'city_id'    => $this->input->post('city_id')
									);
				
				$this->location_model->safe_update('tbl_neighborhood', $posted_data, "id ='" . $id . "'", FALSE);
				
				$this->session->set_userdata(array('msg_type' => 'success'));
				$this->session->set_flashdata('success', lang('successupdate'));
				$redirect_path = 'location/neighborhood';
				
			} else {
			$posted_data = array(
									'title'      => $this->input->post('title'),
									'country_id' => $this->input->post('country_id'),
									'state_id'   => $this->input->post('state_id'),
									'city_id'    => $this->input->post('city_id')
								);
			$this->location_model->safe_insert('tbl_neighborhood', $posted_data, FALSE);
			$this->session->set_userdata(array('msg_type' => 'success'));
			$this->session->set_flashdata('success', lang('success'));
			$redirect_path = 'location/neighborhood_add_edit/?country_id='.$country_id.'&state_id='.$state_id.'&city_id='.$city_id;
			}
			redirect('sitepanel/' . $redirect_path, '');
		
		}
		$data['includes'] = $this->view_path . 'neighborhood_addedit_view';
		$this->load->view('includes/sitepanel_container', $data);
	
	}

  //Online List Ajax Methods
	public function bind_state() {
	
		$parent_id    = $this->input->post('parent_id');
		$from_section = $this->input->post('from_section');
		$arr          = array("tbl_name" => "tbl_states", "select_fld" => "id,title", "where" => "and status='1' and country_id ='" . $parent_id . "'");
		if ($from_section == "neighborhood_country") {
			
			echo common_dropdown('state_id', '', $arr, 'style="width:235px;" onchange="bind_data(this.value,\'sitepanel/location/bind_city\',\'city_list\',\'loader_city\',\'city_section\');"');
			
		} else {
			
			echo common_dropdown('state_id', '', $arr, 'style="width:235px;"');
			
		}
	
	}

  public function bind_city() {
    
	$parent_id = $this->input->post('parent_id');
    $arr       = array("tbl_name" => "tbl_city", "select_fld" => "id,title", "where" => "and status='1' and state_id ='" . $parent_id . "'");
    echo common_dropdown('city_id', '', $arr, 'style="width:235px;"');
	
  }
   
   
   public function uploadstate(){
	  
	  $data['heading_title'] = "Upload State in Excel"; 
	  $rwstatexl=get_db_single_row("tbl_statecity_xl","xl_file"," AND type='S'");
	  $data['rwstatexl']=$rwstatexl;
	  if($this->input->post('action')=='Add'){
		  
		   $this->form_validation->set_rules('image1','State Excel file',"required|file_allowed_type[xlfile]"); 
		   if($this->form_validation->run()==TRUE)
		{
			
			    $uploaded_file = "";	
				
			    if( !empty($_FILES) && $_FILES['image1']['name']!='' )
				{			  
					$this->load->library('upload');	
						
					$uploaded_data =  $this->upload->my_upload('image1','location_data');
				
					if( is_array($uploaded_data)  && !empty($uploaded_data) )
					{ 								
						$uploaded_file = $uploaded_data['upload_data']['file_name'];
					
					}		
					
				}
				
			$posted_data = array(
								  'type'          => 'S',
								  'status'        => '1',
								  'xl_file'       => $uploaded_file				
								);
								
		    $this->location_model->safe_insert('tbl_statecity_xl',$posted_data,FALSE);
			$this->session->set_userdata(array('msg_type'=>'success'));			
			$this->session->set_flashdata('success',lang('success'));			
			redirect('sitepanel/location/uploadstate', '');	
		}
		  
	  }
	  $data['includes'] = $this->view_path .'uploadstate_xl_view';
      $this->load->view('includes/sitepanel_container', $data); 
   }
   
	public function uploadcity(){
	
		$data['heading_title'] = "Upload City in Excel"; 
		$rwstatexl             = get_db_single_row("tbl_statecity_xl","xl_file"," AND type='C'");
		$data['rwstatexl']     = $rwstatexl;
		if($this->input->post('action')=='Add'){
		
			$this->form_validation->set_rules('image1','State Excel file',"required|file_allowed_type[xlfile]"); 
			if($this->form_validation->run()==TRUE)
			{
			
				$uploaded_file = "";	
				if( !empty($_FILES) && $_FILES['image1']['name']!='' )
				{			  
					
					$this->load->library('upload');	
					$uploaded_data =  $this->upload->my_upload('image1','location_data');

					if( is_array($uploaded_data)  && !empty($uploaded_data) )
					{ 								
						
						$uploaded_file = $uploaded_data['upload_data']['file_name'];
					
					}		
				
				}
				
				$posted_data = array(
										'type'     => 'C',
										'status'   => '1',
										'xl_file'  => $uploaded_file				
									);
				
				$this->location_model->safe_insert('tbl_statecity_xl',$posted_data,FALSE);
				$this->session->set_userdata(array('msg_type'=>'success'));			
				$this->session->set_flashdata('success',lang('success'));			
				redirect('sitepanel/location/uploadcity', '');	
			
			}
		
		}
		$data['includes'] = $this->view_path .'uploadcity_xl_view';
		$this->load->view('includes/sitepanel_container', $data); 
		
	}
   
   public function uploadlocation(){
	  
	  $data['heading_title'] = "Upload Location in Excel"; 
	  
	  $rwstatexl=get_db_single_row("tbl_statecity_xl","xl_file"," AND type='L'");
	  $data['rwstatexl']=$rwstatexl;
	  if($this->input->post('action')=='Add'){
		  
		   $this->form_validation->set_rules('image1','State Excel file',"required|file_allowed_type[xlfile]"); 
		   if($this->form_validation->run()==TRUE)
		{
			
			    $uploaded_file = "";	
				
			    if( !empty($_FILES) && $_FILES['image1']['name']!='' )
				{			  
					$this->load->library('upload');	
						
					$uploaded_data =  $this->upload->my_upload('image1','location_data');
				
					if( is_array($uploaded_data)  && !empty($uploaded_data) )
					{ 								
						$uploaded_file = $uploaded_data['upload_data']['file_name'];
					
					}		
					
				}
			$posted_data = array(
								  'type'          => 'L',
								  'status'        => '1',
								  'xl_file'       => $uploaded_file				
								);
								
		    $this->location_model->safe_insert('tbl_statecity_xl',$posted_data,FALSE);
			$this->session->set_userdata(array('msg_type'=>'success'));			
			$this->session->set_flashdata('success',lang('success'));			
			redirect('sitepanel/location/uploadlocation', '');	
		}
		  
	  }	  
	  $data['includes'] = $this->view_path .'uploadlocation_xl_view';
      $this->load->view('includes/sitepanel_container', $data); 
   }
   
	public function downloadxl(){
	
		$flType=$this->uri->segment(4); 
		
		if($flType == 'S'){
			
			$data = file_get_contents(UPLOAD_DIR.'/location_data_sample/state.xls'); // Read the file's contents
			$name = 'state.xls';
		}
		
		if($flType == 'C'){
			
			$data = file_get_contents(UPLOAD_DIR.'/location_data_sample/city.xls'); // Read the file's contents
			$name = 'city.xls';
		}
		
		if($flType == 'L'){
			
			$data = file_get_contents(UPLOAD_DIR.'/location_data_sample/location.xls'); // Read the file's contents
			$name = 'location.xls';
		}
			force_download($name, $data);
			 
		}
	
	public function downloaduploadxl(){
		
		$flType=$this->uri->segment(4); 
		$rwstatexl=get_db_single_row("tbl_statecity_xl","xl_file"," AND type='$flType'");
		
		if(is_array($rwstatexl) && count($rwstatexl) > 0 ){
			
			$data = file_get_contents(UPLOAD_DIR.'/location_data/'.$rwstatexl['xl_file']); // Read the file's contents
			$name = $rwstatexl['xl_file'];
			force_download($name, $data);
		}
		
	}
   
   public function deleteuploadxl(){
	   
	    $flType=$this->uri->segment(4); 
		$rwstatexl=get_db_single_row("tbl_statecity_xl","xl_file"," AND type='$flType'");
		
		   if(is_array($rwstatexl) && count($rwstatexl) > 0 ){
			   
			  
			   if(($rwstatexl['xl_file']!='') && (file_exists(UPLOAD_DIR.'/location_data/'.$rwstatexl['xl_file']))){
				   
			     unlink(UPLOAD_DIR.'/location_data/'.$rwstatexl['xl_file']);
			     $this->db->query("DELETE FROM tbl_statecity_xl WHERE type='$flType' ");
				 	   
			   }
		   }
			   if($flType == 'S'){
				
				 redirect('sitepanel/location/uploadstate','');   
				   
			   }
			   if($flType == 'C'){
				 
				 redirect('sitepanel/location/uploadcity','');     
				   
			   }
			   if($flType == 'L'){
				 echo "sdfsdfsdf";
				 redirect('sitepanel/location/uploadlocation','');     
				   
			   }
		  
   }
   
   
	public function uploadindatabase(){
	
		$this->load->library('excel_reader'); 
		$flType=$this->uri->segment(4);  
		
		if ($flType == 'S') {
		
			$rwstatexl=get_db_single_row("tbl_statecity_xl","xl_file"," AND type='$flType'");
			
			if(is_array($rwstatexl) && count($rwstatexl) > 0 ){
			
				$path = UPLOAD_DIR ."/location_data/".$rwstatexl['xl_file'];
				$this->excel_reader->read($path);
				$worksheet = $this->excel_reader->worksheets[0];
				
				if (is_array($worksheet) && count($worksheet) > 0) {
				
					$total = count($worksheet);
				
					for ($i = 1; $i < $total; $i++) {
						
						$state_name = trim($worksheet[$i][0]);
						$country_name = trim($worksheet[$i][1]);
						//echo $country_name . "<br>";
						if($state_name !=''){
						$country_id=get_db_field_value("tbl_country","id",array("country_name"=>$country_name));
						
						
						if($country_id>0){
						
							$is_avl_state = count_record("tbl_states","title ='".$state_name."' and status !='2' and country_id ='".$country_id."'");
							
							if($is_avl_state>0){
								$url_title=str_replace("-","",url_title($state_name));
								$this->location_model->safe_update("tbl_states",array("status"=>"1","temp_title"=>$url_title),"title ='".$state_name."' and country_id ='".$country_id."'",FALSE);
								
							}else{
								$url_title=str_replace("-","",url_title($state_name));
								$data=array("title"=>$state_name,"temp_title"=>$url_title,"country_id"=>$country_id,"created_at"=>$this->config->item('date_time_format'));
							   $this->location_model->safe_insert("tbl_states",$data,FALSE);
							
							}
						
						}
						
						
					}
					}
				
				}
				 unlink(UPLOAD_DIR.'/location_data/'.$rwstatexl['xl_file']);
			     $this->db->query("DELETE FROM tbl_statecity_xl WHERE type='$flType' ");
				 $this->session->set_userdata(array('msg_type'=>'success'));			
			     $this->session->set_flashdata('success','State information has been added successfully.');	
			
				 redirect('sitepanel/location/uploadcity');
			}  
		 
		}
		// City data added in xl format.......
		if ($flType == 'C') {
			
		
			$rwstatexl=get_db_single_row("tbl_statecity_xl","xl_file"," AND type='$flType'");
			
			if(is_array($rwstatexl) && count($rwstatexl) > 0 ){
			
				$path = UPLOAD_DIR ."/location_data/".$rwstatexl['xl_file'];
				$this->excel_reader->read($path);
				
				$worksheet = $this->excel_reader->worksheets[0];
				
				if(is_array($worksheet) && count($worksheet) > 0){
				   
					$total=count($worksheet);
					//trace($worksheet);exit;
					for($i=1;$i<$total;$i++){
						
						$city_name		= trim($worksheet[$i][0]);
						$state_name	= trim($worksheet[$i][1]);
						$country_name	= trim($worksheet[$i][2]);
						//echo $country_name."<br>";
						$rwcont=get_db_single_row("tbl_country","id"," AND country_name='".$country_name."'");
						
						$rwstate=get_db_single_row("tbl_states","id,country_id"," AND title='".$state_name."' AND country_id='".$rwcont['id']."'");
						
						
						$state_id=$rwstate['id'];
						$country_id=$rwstate['country_id'];
						
						if($state_id>0)
						{
						//and state_id ='".$state_id."' and country_id ='".$country_id."'
							$is_avl_city = count_record("tbl_city","title ='".$city_name."' and status !='2' and country_id='".$country_id."' and state_id='".$state_id."' ");
							
							if($is_avl_city>0)
							{
								$this->location_model->safe_update("tbl_city",array("status"=>"1"),"title ='".$city_name."' and state_id ='".$state_id."' and country_id ='".$country_id."'",FALSE);
								
							}
							else
							{
								$url_title=url_title($city_name);
								$url_title=str_replace("-","",$url_title);
							  $data=array("title"=>$city_name,"temp_title"=>$url_title,"state_id"=>$state_id,"country_id"=>$country_id,"created_at"=>$this->config->item('config.date.time'));
							  $this->location_model->safe_insert("tbl_city",$data,false);
							
							}
						
						}
					
					}
				}
				 unlink(UPLOAD_DIR.'/location_data/'.$rwstatexl['xl_file']);
			     $this->db->query("DELETE FROM tbl_statecity_xl WHERE type='$flType' ");
				 $this->session->set_userdata(array('msg_type'=>'success'));			
			     $this->session->set_flashdata('success','City information has been added successfully.');	
				 redirect('sitepanel/location/uploadcity');
			}
		
		}
	// Location data is added in xl format....	
	if ($flType == 'L') {
	
		$rwstatexl=get_db_single_row("tbl_statecity_xl","xl_file"," AND type='$flType'");
		
		if(is_array($rwstatexl) && count($rwstatexl) > 0 ){
				 
			$path = UPLOAD_DIR ."/location_data/".$rwstatexl['xl_file'];
			$this->excel_reader->read($path);
			$worksheet = $this->excel_reader->worksheets[0];
			//trace($worksheet);exit;
			if(is_array($worksheet) && count($worksheet) > 0){
				
				$total=count($worksheet);
				//trace($worksheet);exit;
				for($i=1;$i<$total;$i++){
					
					$location_name	= trim($worksheet[$i][0]);
					$city_name		= trim($worksheet[$i][1]);
					$state_name		= trim($worksheet[$i][2]);
					
					$rwstate=get_db_single_row("tbl_states","id,country_id"," AND title='".$state_name."' ");
					
					$rwcity=get_db_single_row("tbl_city","id,state_id,country_id"," AND title='".$city_name."' AND state_id='".$rwstate['id']."' ");
					
					$city_id	=	$rwcity['id'];
					$state_id	=	$rwcity['state_id'];
					$country_id	=	$rwcity['country_id'];
					
					if($city_id>0)
					{
						$is_avl_loc = count_record("tbl_neighborhood","title ='".$location_name."' and status !='2' and state_id ='".$state_id."' and country_id ='".$country_id."' and city_id ='".$city_id."'");
						if($is_avl_loc>0){
							
							$this->location_model->safe_update("tbl_neighborhood",array("status"=>"1"),"title ='".$location_name."' and state_id ='".$state_id."' and country_id ='".$country_id."' and city_id ='".$city_id."'",FALSE);
							
						}else{
						
							$data=array("title"=>$location_name,"state_id"=>$state_id,"country_id"=>$country_id,"city_id"=>$city_id,"created_at"=>$this->config->item('config.date.time'));
							$this->location_model->safe_insert("tbl_neighborhood",$data,FALSE);
						
						}
					
					}
				
				}
			
			}
			unlink(UPLOAD_DIR.'/location_data/'.$rwstatexl['xl_file']);
			$this->db->query("DELETE FROM tbl_statecity_xl WHERE type='$flType' ");
			
			$this->session->set_userdata(array('msg_type'=>'success'));			
			$this->session->set_flashdata('success','Location information has been added successfully.');	
			
			redirect('sitepanel/location/uploadlocation');
		}
	  }
	
	}
   
  public function bulk_data() {
    echo $this->session->flashdata('msg');

    $this->load->library('excel_reader');

    $type = (int) $this->uri->segment('4');
    if ($type == 1) {
      $path = FCROOT . "uploaded_files/location_data/Country.xls";
      $this->excel_reader->read($path);
      $worksheet = $this->excel_reader->worksheets[0];
      if (is_array($worksheet) && count($worksheet) > 0) {
        $total = count($worksheet);
        for ($i = 1; $i < $total; $i++) {
          $country_name = trim($worksheet[$i][0]);
          $url_name = str_replace("-","",url_title($country_name));

          $is_avl_country = count_record("tbl_country", "country_name ='" . $country_name . "' and status !='2'");
          if ($is_avl_country > 0) {
            $this->location_model->safe_update("tbl_country", array("status" => "1"), "country_name ='" . $country_name . "'", FALSE);
          } else {
            $data = array("country_name" => $country_name, "country_temp_name" => $url_name);
            $this->location_model->safe_insert("tbl_country", $data, FALSE);
          }
        }
      }

      $this->session->set_flashdata('msg', 'Country data successfully added.');
      redirect('sitepanel/location/bulk_data');
    }

    if ($type == 2) {
      $path = FCROOT . "uploaded_files/location_data/Country_State.xls";
      $this->excel_reader->read($path);
      $worksheet = $this->excel_reader->worksheets[0];
      if (is_array($worksheet) && count($worksheet) > 0) {
        $total = count($worksheet);

        trace($worksheet);
        exit;
        for ($i = 1; $i < $total; $i++) {
          $state_name = trim($worksheet[$i][0]);
          $country_name = trim($worksheet[$i][1]);
              echo $country_name . "<br>";
          /*
            $country_id=get_db_field_value("tbl_country","id",array("country_name"=>$country_name));

            if($country_id>0)
            {

            $is_avl_state = count_record("tbl_states","title ='".$state_name."' and status !='2' and country_id ='".$country_id."'");
            if($is_avl_state>0)
            {
            $this->location_model->safe_update("tbl_states",array("status"=>"1"),"title ='".$state_name."' and country_id ='".$country_id."'",FALSE);
            }
            else
            {
            $data=array("title"=>$state_name,"country_id"=>$country_id,"created_at"=>$this->config->item('date_time_format'));
            $this->location_model->safe_insert("tbl_states",$data,FALSE);
            }
            }
           */
        }
        exit;
      }

      $this->session->set_flashdata('msg', 'State data successfully added.');
      redirect('sitepanel/location/bulk_data');
    }
  }

  /*
    public function bulk_data()
    {
    echo $this->session->flashdata('msg');

    $this->load->library('excel_reader');

    $type=(int) $this->uri->segment('4');
    if($type==1)
    {
    $path=FCROOT."uploaded_files/location_data/Country.xls";
    $this->excel_reader->read($path);
    $worksheet = $this->excel_reader->worksheets[0];
    if(is_array($worksheet) && count($worksheet) > 0)
    {
    $total=count($worksheet);
    for($i=1;$i<$total;$i++)
    {
    $country_name	=trim($worksheet[$i][0]);
    $url_name			=url_title($country_name);

    $is_avl_country = count_record("tbl_country","country_name ='".$country_name."' and status !='2'");
    if($is_avl_country>0)
    {
    $this->location_model->safe_update("tbl_country",array("status"=>"1"),"country_name ='".$country_name."'",FALSE);
    }
    else
    {
    $data=array("country_name"=>$country_name,"country_temp_name"=>$url_name);
    $this->location_model->safe_insert("tbl_country",$data,FALSE);
    }

    }
    }

    $this->session->set_flashdata('msg','Country data successfully added.');
    redirect('sitepanel/location/bulk_data');
    }

    if($type==2)
    {
    $path=FCROOT."uploaded_files/location_data/Country_State.xls";
    $this->excel_reader->read($path);
    $worksheet = $this->excel_reader->worksheets[0];
    if(is_array($worksheet) && count($worksheet) > 0)
    {
    $total=count($worksheet);

    //trace($worksheet);exit;
    for($i=1;$i<$total;$i++)
    {
    $state_name		= rtrim($worksheet[$i][0]);
    $country_name	= trim($worksheet[$i][1]);
    //echo $country_name."<br>";

    $country_id=get_db_field_value("tbl_country","id",array("country_name"=>$country_name));

    if($country_id>0)
    {

    $is_avl_state = count_record("tbl_states","title ='".$state_name."' and status !='2' and country_id ='".$country_id."'");
    if($is_avl_state>0)
    {
    $this->location_model->safe_update("tbl_states",array("status"=>"1"),"title ='".$state_name."' and country_id ='".$country_id."'",FALSE);
    }
    else
    {
    $data=array("title"=>$state_name,"country_id"=>$country_id,"created_at"=>$this->config->item('config.date.time'));
    $this->location_model->safe_insert("tbl_states",$data,FALSE);
    }
    }


    }
    //exit;
    }

    $this->session->set_flashdata('msg','State data successfully added.');
    redirect('sitepanel/location/bulk_data');
    }

    if($type==3)
    {
    $path=FCROOT."uploaded_files/location_data/State_City_Part19.xls";
    $this->excel_reader->read($path);
    $worksheet = $this->excel_reader->worksheets[0];
    //trace($worksheet);exit;
    if(is_array($worksheet) && count($worksheet) > 0)
    {
    $total=count($worksheet);

    //trace($worksheet);exit;
    for($i=1;$i<$total;$i++)
    {
    $city_name		= trim($worksheet[$i][0]);
    $state_name	= trim($worksheet[$i][1]);
    //echo $country_name."<br>";

    $state_res=get_db_single_row("tbl_states","id,country_id",array("title"=>$state_name));
    $state_id=$state_res['id'];
    $country_id=$state_res['country_id'];


    if($state_id>0)
    {

    $is_avl_city = count_record("tbl_city","title ='".$city_name."' and status !='2' and state_id ='".$state_id."' and country_id ='".$country_id."'");
    if($is_avl_city>0)
    {
    $this->location_model->safe_update("tbl_city",array("status"=>"1"),"title ='".$city_name."' and state_id ='".$state_id."'",FALSE);
    }
    else
    {
    $data=array("title"=>$city_name,"state_id"=>$state_id,"country_id"=>$country_id,"created_at"=>$this->config->item('config.date.time'));
    $this->location_model->safe_insert("tbl_city",$data,FALSE);
    }
    }


    }
    //exit;
    }

    $this->session->set_flashdata('msg','City data successfully added.');
    redirect('sitepanel/location/bulk_data');
	
	
	
	//sv
    }
    if($type==4)
    {
    $path=FCROOT."uploaded_files/location_data/City_Location_Part10.xls";
    $this->excel_reader->read($path);
    $worksheet = $this->excel_reader->worksheets[0];
    //trace($worksheet);exit;
    if(is_array($worksheet) && count($worksheet) > 0)
    {
    $total=count($worksheet);

    //trace($worksheet);exit;
    for($i=1;$i<$total;$i++)
    {
    $location_name		= trim($worksheet[$i][0]);
    $city_name				= trim($worksheet[$i][1]);
    //echo $country_name."<br>";

    $city_res=get_db_single_row("tbl_city","id,state_id,country_id",array("title"=>$city_name));
    $city_id			=	$city_res['id'];
    $state_id		=	$city_res['state_id'];
    $country_id	=	$city_res['country_id'];


    if($city_id>0)
    {

    $is_avl_loc = count_record("tbl_neighborhood","title ='".$location_name."' and status !='2' and state_id ='".$state_id."' and country_id ='".$country_id."' and city_id ='".$city_id."'");
    if($is_avl_loc>0)
    {
    $this->location_model->safe_update("tbl_neighborhood",array("status"=>"1"),"title ='".$location_name."' and state_id ='".$state_id."' and country_id ='".$country_id."' and city_id ='".$city_id."'",FALSE);
    }
    else
    {
    $data=array("title"=>$location_name,"state_id"=>$state_id,"country_id"=>$country_id,"city_id"=>$city_id,"created_at"=>$this->config->item('config.date.time'));
    $this->location_model->safe_insert("tbl_neighborhood",$data,FALSE);
    }
    }


    }
    //exit;
    }

    $this->session->set_flashdata('msg','City data successfully added.');
    redirect('sitepanel/location/bulk_data');
    }

    }

   */
   
   public function aa(){
	        
			$this->load->library('excel_reader');
	        $path = UPLOAD_DIR ."/location_data/pty_addr.xls";
			$this->excel_reader->read($path);
			$worksheet = $this->excel_reader->worksheets[0];
			
			
			 $total = count($worksheet);
			for ($i = 1; $i < $total; $i++) {
               $comp_name = trim($worksheet[$i][1]);
               $client_name = trim($worksheet[$i][2]);
			   $mobile = trim($worksheet[$i][3]);
			   
		      $this->db->query("INSERT INTO  tbl_client(comp_name,client_name,mobile)Values('$comp_name','$client_name','$mobile')");
			}
			
			echo "Record Inserted";
   }
   
   public function existstate(){
	   
	  $data['includes'] = $this->view_path .'existstate_view';
	  $data['heading_title']="View duplicate state";
	  $sql="SELECT title,country_id,id FROM tbl_states WHERE status !='2' GROUP BY title HAVING COUNT(1) > 1";
	  
	  $data['res'] = custom_result_set($sql);
      $this->load->view('includes/sitepanel_container', $data);  
   }
   
   public function state_add_editd() {
    $id = (int) $this->uri->segment(4, 0);
    $row_data = '';
    if ($id > 0) {
      $row_data = $this->location_model->get_single_row("tbl_states", $id);
    }
    $data['row'] = $row_data;
    $data['parentData'] = '';
    $data['heading_title'] = 'Edit State';

      $this->form_validation->set_rules('title', 'State Name', "trim|required|max_length[100]|xss_clean|unique[tbl_states.title='" . $this->db->escape_str($this->input->post('title')) . "' AND tbl_states.status!='2' AND tbl_states.country_id='" . $this->db->escape_str($this->input->post('country_id')) . "' AND tbl_states.id !=$id]");
    

    if ($this->form_validation->run() === TRUE) {
      
		$url_title=str_replace("-","",url_title($this->input->post('title')));
        $posted_data = array(
            'title' => $this->input->post('title'),
						'temp_title' => $url_title
        );

        $this->location_model->safe_update('tbl_states', $posted_data, "id ='" . $id . "'", FALSE);

        $this->session->set_userdata(array('msg_type' => 'success'));
        $this->session->set_flashdata('success', lang('successupdate'));
      

      $redirect_path = 'location/existstate';
      redirect('sitepanel/' . $redirect_path, '');
    }
    $data['includes'] = $this->view_path . 'state_addeditd_view';
    $this->load->view('includes/sitepanel_container', $data);
  }
  
  public function existcity(){
	  
	  $data['includes'] = $this->view_path .'existcitye_view';
	  $data['heading_title']="View duplicate state";
	  $sql="SELECT  a.*, b.title AS Duplicate
FROM    tbl_city a
        INNER JOIN
        (
            SELECT  title, COUNT(*) totalCount
            FROM    tbl_city
            GROUP   BY title
            HAVING  COUNT(*) >= 2
        ) b ON a.title = b.title ORDER BY title ";
	  $data['res'] = custom_result_set($sql);
      $this->load->view('includes/sitepanel_container', $data);  
	  
  }
  
  public function city_add_editd(){
	   $id = (int) $this->uri->segment(4, 0);
    $row_data = '';
    if ($id > 0) {
      $row_data = $this->location_model->get_single_row("tbl_city", $id);
    }
    $data['row'] = $row_data;
    $data['parentData'] = '';
    $data['heading_title'] = 'Edit City';

      $this->form_validation->set_rules('title', 'City Name', "trim|required|max_length[100]|xss_clean");
    

    if ($this->form_validation->run() === TRUE) {
      
		$url_title=str_replace("-","",url_title($this->input->post('title')));
        $posted_data = array(
            'title' => $this->input->post('title'),
						'temp_title' => $url_title
        );

        $this->location_model->safe_update('tbl_city', $posted_data, "id ='" . $id . "'", FALSE);

        $this->session->set_userdata(array('msg_type' => 'success'));
        $this->session->set_flashdata('success', lang('successupdate'));
      

      $redirect_path = 'location/existcity';
      redirect('sitepanel/' . $redirect_path, '');
    }
    $data['includes'] = $this->view_path . 'citye_addeditd_view';
    $this->load->view('includes/sitepanel_container', $data); 
  }
   
}

// End of controller