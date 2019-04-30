<?php

class Category extends Admin_Controller
{

	public $view_path;
	public $current_controller;
	
	public function __construct()
	{		
		
		parent::__construct();
		$this->current_controller	=$this->router->fetch_class();
		$this->load->model(array($this->current_controller.'/category_model'));  
		$this->load->helper($this->current_controller.'/category');
		$this->config->set_item('menu_highlight','category');				
		$this->view_path = $this->current_controller."/";		
	
	}

	

	public  function index()
	{
		
		$pagesize           =  (int) $this->input->get_post('pagesize');
		$config['limit']	=  ( $pagesize > 0 ) ? $pagesize : $this->config->item('pagesize');
		$offset             =  ( $this->input->get_post('per_page') > 0 ) ? $this->input->get_post('per_page') : 0;
		$base_url           =  current_url_query_string(array('filter'=>'result'),array('per_page'));
		$parent_id          =  (int) $this->uri->segment(4,0);
		$keyword            = trim($this->input->get_post('keyword',TRUE));
		$keyword            = $this->db->escape_str($keyword);
		$condtion           = "AND parent_id = '$parent_id'";
		$condtion_array     = array(
									'field' =>"*,( SELECT COUNT(category_id) FROM tbl_categories AS b
									WHERE b.parent_id=a.category_id ) AS total_subcategories",
									'condition'=>$condtion,
									'limit'=>$config['limit'],
									'offset'=>$offset	,
									'debug'=>FALSE
									);
		$res_array              =  $this->category_model->get_category($condtion_array);
		//echo_sql();
		$config['total_rows']	=  $this->category_model->total_rec_found;
		$data['page_links']     =  admin_pagination($base_url,$config['total_rows'],$config['limit'],$offset);
		
		$data['heading_title']  =  ( $parent_id > 0 ) ? (($parent_id==7)?'Gift items':'Subcategory') :  'Category';
		$data['res']            =  $res_array;
		$data['parent_id']      =  $parent_id;
		
		if( $this->input->post('status_action')!='')
		{
		
			if( $this->input->post('status_action')=='Delete')
			{
				$prod_id=$this->input->post('arr_ids');
				
				
				if($this->input->post('set_as')!=''){
		
			$set_as    = $this->input->post('set_as',TRUE);
			$this->set_as('wl_categories','category_id',array($set_as=>1));
		
		}
		
		if( $this->input->post('unset_as')!='' ){
		
			$unset_as   = $this->input->post('unset_as',TRUE);
			$this->set_as('wl_categories','category_id',array($unset_as=>'0'));
		
		}
				
				
				
				
				foreach($prod_id as $v){
				
					$rowdata=$this->category_model->get_category_by_id($v);
					$total_category  = count_category("AND parent_id='$v' ");
					$total_product   = count_products("AND category_id='$v' ");
					if( $total_category>0 || $total_product > 0 )
					{
					}else
					{
						$where = array('entity_type'=>'category/index','entity_id'=>$v);
						$this->category_model->safe_delete('tbl_meta_tags',$where,TRUE);
					}
				
				}
			
			}
			$this->update_status('tbl_categories','category_id');
		
		}
		
		if( $this->input->post('update_order')!='')
		{
		
			$this->update_displayOrder('tbl_categories','sort_order','category_id');
		
		}
		// category set as a
		
		if( $this->input->post('set_as')!='' )
		{
		
			$set_as    = $this->input->post('set_as',TRUE);
			$this->set_as('tbl_categories','category_id',array($set_as=>'1'));
		
		}
		
		if( $this->input->post('unset_as')!='' )
		{
		
			$unset_as   = $this->input->post('unset_as',TRUE);
			$this->set_as('tbl_categories','category_id',array($unset_as=>'0'));
		}
		// End category set as a
		$data['includes']		= $this->view_path.'view_category_list';		
		$this->load->view('includes/sitepanel_container',$data);
		
	}

	

	public function add()
	{
		
		$data['ckeditor']    = set_ck_config(array('textarea_id'=>'cat_desc'));
		$parent_id           = (int) $this->uri->segment(4,0);
		$img_allow_size      = $this->config->item('allow.file.size');
		$img_allow_dim       = $this->config->item('allow.imgage.dimension');
		$category_name       = $this->db->escape_str($this->input->post('category_name'));
		$posted_friendly_url = $this->input->post('category_name');
		
		if( $parent_id!='' && $parent_id > 0 )
		{
			
			$parent_id = applyFilter('NUMERIC_GT_ZERO',$parent_id);
			$data['heading_title'] = 'Add Subcategory';
			if($parent_id<=0)
			{
				
				redirect("sitepanel/category");
				
			}
			$parentdata=$this->category_model->get_category_by_id($parent_id);
			if(!is_array($parentdata))
			{
				
				$this->session->set_flashdata('message', lang('invalidRecord'));
				redirect('sitepanel/category', '');
				
			}
		/*	$this->cbk_friendly_url = 	$parentdata['friendly_url']."/".seo_url_title(url_title($this->input->post("category_name")));
			$data['parentData'] = $parentdata;*/
			
			
			
			$seo_cat_name = seo_url_title($parentdata['category_name']);
			
			$this->cbk_friendly_url = 	$seo_cat_name."/".seo_url_title($posted_friendly_url);
			$data['parentData'] = $parentdata;
		
		}else
		{
			$seo_cat_name = '';
			$this->cbk_friendly_url = seo_url_title(url_title($this->input->post("category_name")));
			$data['parentData'] = '';
			$data['heading_title'] = 'Add Category';
			
		}
	
		$seo_url_length = $this->config->item('seo_url_length');
		$this->form_validation->set_rules('category_name','Category Name',"trim|required|max_length[100]");
		$this->form_validation->set_rules('category_image','Image',"file_allowed_type[image]|file_size_max[$img_allow_size]|check_dimension[$img_allow_dim]");
		
		$this->form_validation->set_rules('friendly_url','Page URL',"trim|required|max_length[$seo_url_length]|callback_checkurl[$seo_cat_name]");
		
		//$this->form_validation->set_rules('category_image_alt','Alt',"trim|max_length[100]");
		$this->form_validation->set_rules('category_description','Description',"max_length[6000]");
		
		if($this->form_validation->run()===TRUE)
		{
		 
			$uploaded_file = "";
			if( !empty($_FILES) && $_FILES['category_image']['name']!='' )
			{
				$this->load->library('upload');
				$uploaded_data =  $this->upload->my_upload('category_image','category');
				if( is_array($uploaded_data)  && !empty($uploaded_data) )
				{
					
					$uploaded_file = $uploaded_data['upload_data']['file_name'];
					
				}
			}
			$redirect_url = "category/index";
			$category_alt = $this->input->post('category_alt');
			if($category_alt =='')
			{
			
				$category_alt = $this->input->post('category_name');
			
			}
			
			
			#-------------------MAX SORT ORDER------------#
			
			$this->db->select_max('sort_order');
			$query = $this->db->get('tbl_categories');
			$max_sort_order= $query->row_array();
			$max_sort_orders=$max_sort_order['sort_order']+1;
			#--------------------------------------------#
			
			$posted_data = array(
								'category_name'        => $this->input->post('category_name'),
								
								'parent_id'            => $parent_id,
								'friendly_url'         => $this->cbk_friendly_url,
								'date_added'           => $this->config->item('config.date.time'),
								'display_top_menu'     => $this->input->post('display_top_menu'),
								'category_description' => $this->input->post('category_description'),
								'category_image'       =>   $uploaded_file,
								'sort_order'           => $max_sort_orders
								);
							
			$posted_data = $this->security->xss_clean($posted_data);
			$insertId = $this->category_model->safe_insert('tbl_categories',$posted_data,FALSE);
			if( $insertId > 0 )
			{
			
			$meta_array  = array(
									'entity_type'      => $redirect_url,
									'entity_id'        => $insertId,
									'page_url'         => $this->cbk_friendly_url,
									'meta_title'       => get_text($this->input->post('category_name'),80),
									'meta_description' => get_text($this->input->post('category_name')),
									'meta_keyword'     => get_keywords($this->input->post('category_name')),
									'meta_date_added'  => $this->config->item('config.date.time'),
									);
			create_meta($meta_array);
			}
			
			$this->session->set_userdata(array('msg_type'=>'success'));
			$this->session->set_flashdata('success',lang('success'));
			$redirect_path= isset($parentdata) && is_array($parentdata) ? 'category/index/'.$parentdata['category_id'] : 'category';
			redirect('sitepanel/'.$redirect_path, '');
		
		}
		$data['parent_id'] = $parent_id;
		$data['includes']		= $this->view_path.'view_category_add';		
		$this->load->view('includes/sitepanel_container',$data);
		//$this->load->view($this->default_view.'/view_category_add',$data);
	
	}

	public function edit()
	{
		$data['ckeditor']      = set_ck_config(array('textarea_id'=>'cat_desc'));
		$catId                 = (int) $this->uri->segment(4);
		$rowdata               = $this->category_model->get_category_by_id($catId);
		$data['heading_title'] = ($rowdata['parent_id'] > 0 ) ? 'Subcategory' : 'Category';
		$img_allow_size        = $this->config->item('allow.file.size');
		$img_allow_dim         = $this->config->item('allow.imgage.dimension');
		
		
		if( !is_array($rowdata) )
		{
			
			$this->session->set_flashdata('message', lang('idmissing'));
			redirect('sitepanel/category', '');
			
		}
		$categoryId = $rowdata['category_id'];
		
		$this->form_validation->set_rules('category_name','Category Name',"trim|required|max_length[100]|unique[tbl_categories.category_name='".$this->db->escape_str($this->input->post('category_name'))."' AND status!='2' AND parent_id='".$rowdata['parent_id']."' AND category_id!='".$categoryId."']");
		$seo_url_length = $this->config->item('seo_url_length');
		$this->cbk_friendly_url = seo_url_title(url_title($this->input->post("category_name")));
		//$this->form_validation->set_rules('friendly_url','Page URL',"trim|required|max_length[$seo_url_length]|unique[tbl_meta_tags.page_url='".$this->cbk_friendly_url."' AND entity_id!='".$categoryId."'] ");
		$this->form_validation->set_rules('category_description','Description',"max_length[6000]");
		$this->form_validation->set_rules('category_image','Image',"file_allowed_type[image]|file_size_max[$img_allow_size]|check_dimension[$img_allow_dim]");
		//$this->form_validation->set_rules('category_alt','Alt',"trim|max_length[100]");
		
		if($this->form_validation->run()==TRUE)
		{
		    
			$parentdata=$this->category_model->get_category_by_id($rowdata['parent_id']);
			if(is_array($parentdata) && count($parentdata) > 0 ){
			$this->cbk_friendly_url = 	url_title($parentdata['category_name'])."/".seo_url_title(url_title($this->input->post("category_name")));
			
			}else
			{
			
			$this->cbk_friendly_url = seo_url_title(url_title($this->input->post("category_name")));
			}
			
			
			$uploaded_file = $rowdata['category_image'];
			$unlink_image  = array('source_dir'=>"category",'source_file'=>$rowdata['category_image']);
			if($this->input->post('cat_img_delete')==='Y')
			{
				removeImage($unlink_image);
				$uploaded_file = NULL;
			}
			
			if( !empty($_FILES) && $_FILES['category_image']['name']!='' )
			{
				
				$this->load->library('upload');
				$uploaded_data =  $this->upload->my_upload('category_image','category');
				if( is_array($uploaded_data)  && !empty($uploaded_data) )
				{
					
					$uploaded_file = $uploaded_data['upload_data']['file_name'];
					removeImage($unlink_image);
					
				}
			
			}
			$category_alt = $this->input->post('category_alt');
			if($category_alt ==''){
			
				$category_alt = $this->input->post('category_name');
			
			}
			
			$is_featured=($this->input->post('display_top_menu')!='')?$this->input->post('display_top_menu'):1;
			$posted_data = array(
									'category_name'        => $this->input->post('category_name'),
									//'friendly_url'         => $this->cbk_friendly_url,
									'category_description' => $this->input->post('category_description'),
									'category_image'       => $uploaded_file,
									'display_top_menu'     => $is_featured,
									);
			$posted_data = $this->security->xss_clean($posted_data);
			$where = "category_id = '".$categoryId."'";
			$this->category_model->safe_update('tbl_categories',$posted_data,$where,FALSE);
			//update_meta_page_url('category/index',$categoryId,$this->cbk_friendly_url);
			$this->session->set_userdata(array('msg_type'=>'success'));
			$this->session->set_flashdata('success',lang('successupdate'));
			$redirect_path= $rowdata['parent_id']>0 ? 'category/index/'. $rowdata['parent_id'] : 'category';
			redirect('sitepanel/'.$redirect_path.'/'.query_string(), '');
		
		}
		$data['catresult']=$rowdata;
		$data['includes']		= $this->view_path.'view_category_edit';		
		$this->load->view('includes/sitepanel_container',$data);
		//$this->load->view($this->default_view.'/view_category_edit',$data);
		
	}

	

	public function delete()
	{
	  

	  
	  $catId = (int) $this->uri->segment(4,0);
	  $rowdata=$this->category_model->get_category_by_id($catId);
	  if( !is_array($rowdata) )
	  {
			$this->session->set_flashdata('message', lang('idmissing'));
			redirect('sitepanel/category', '');
		}
		else
		{
			$total_category  = count_category("AND parent_id='$catId' ");
		  $total_product   = count_products("AND category_id='$catId' ");
		  if( $total_category>0 || $total_product > 0 )
		  {

			  $this->session->set_userdata(array('msg_type'=>'error'));
			  $this->session->set_flashdata('error',lang('child_to_delete'));

		  }else
		  {

			  $where = array('category_id'=>$catId);
			  $this->category_model->safe_delete('tbl_categories',$where,TRUE);
			  $entity_type = "category/index";
			  $where = array('entity_id'=>$catId,"entity_type"=>$entity_type);
			  $this->utils_model->safe_delete('tbl_meta_tags',$where,FALSE); 
			  $this->session->set_userdata(array('msg_type'=>'success'));
			  $this->session->set_flashdata('success',lang('deleted') );
		  }

		  redirect($_SERVER['HTTP_REFERER'], '');
	  }

	}

	

		public function checkurl($friendly_url='',$parent_category_url=''){
		
			$category_id=(int)$this->input->post('category_id');
			
			if($category_id!=''){
				$cont='and entity_id !='.$category_id;
			}else{
				$cont='';
			}
			
			$posted_friendly_url = $this->input->post('friendly_url');
			
			
			$cbk_friendly_url = seo_url_title($posted_friendly_url);
			
			if($parent_category_url!=''){
				 $final_url = $parent_category_url."/".$cbk_friendly_url;
			}else{
				 $final_url = $cbk_friendly_url;
			}
			
			$urlcount=$this->db->query("select * from tbl_meta_tags where page_url='".$final_url."'".$cont."")->num_rows();
		
			if($urlcount>0)
			{
				$this->form_validation->set_message('checkurl', 'Record with this url already exists.');
				return FALSE;
			}else
			{
				return TRUE;
			}
		
	}
}

// End of controller