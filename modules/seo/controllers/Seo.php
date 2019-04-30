<?php

Class Seo extends CI_Controller

{

	public function __construct()

	{

		ob_start();

	    parent::__construct(); 

		$this->load->helper(array('xml','seo/seo'));		 		

		

	}		



     public  function sitemap()

     {



        $data['result'] = array('url'=>"http://localhost/hundia_ecommerce/contactus");

		header("Content-Type: text/xml;charset=iso-8859-1");

        $this->load->view("seo/sitemap",$data);

     }

	 

	 public function rss_feed()

	 {

		

		    $data['encoding'] = 'utf-8';

	        $data['feed_name'] = 'www.xyz.com';

	        $data['feed_url'] = 'http://www.xyz.com';

	        $data['page_description'] = 'Welcome to www.xyz.com feed page';

	        $data['page_language'] = 'en-us';

	        $data['creator_email'] = 'abc@gmail.com';

						

	        $data['result'] = array('0'=>array(

						'title'=>'Create Feed Controller',			

						'url'=>"http://localhost/hundia_ecommerce/contactus",

						'description'=>"Create Feed Controller Create Feed ControllerCreate Feed ControllerCreate Feed ControllerCreate Feed ControllerCreate Feed Controller"

						

				)

	        );	

				

		    header("Content-Type: application/rss+xml");

	        $this->load->view('rss', $data);

		

	}

	

	public function create_seo_url()

	{

	  $msg_arr = array();

	  $rec_id = (int) $this->input->post('rec_id');

	  $pg_title = $this->input->post('title',TRUE);

	  $pg_title = str_replace(base_url(),"",$pg_title);

	  $pre_title = $this->input->post('pre_title',TRUE);

	  $pre_title = str_replace(base_url(),"",$pre_title);

	  $pg_title = seo_url_title($pg_title);

	  

	  if($pre_title!=''){

		  

		$friendly_url = $pre_title.$pg_title;

	  }

	  else

	  {

		$friendly_url = $pg_title;

	  }

	  $this->db->select('meta_id');

	  $this->db->from('tbl_meta_tags');

	  $this->db->where('page_url',$friendly_url);

	  if($rec_id > 0)

	  {

		$this->db->where('entity_id !=',$rec_id);

	  }

	  $meta_qry = $this->db->get();



	  if($meta_qry->num_rows() > 0)

	  {

		  $msg_arr['error'] = 1;

		  $msg_arr['msg'] = 'URL already exists';

	  }

	  else

	  {

		$msg_arr['error'] = 0;

		$msg_arr['msg'] = 'URL passed';

	  }

	  $msg_arr['friendly_name'] = $pg_title;

	  echo json_encode($msg_arr);

	}

	
	public function update_product_meta(){
		
		$sql="select product_name,category_id,product_friendly_url,products_id from tbl_products ";
		$row = $this->db->query($sql)->result_array();
		if(!empty($row)){
			foreach($row as $val){
				$cat_name = get_db_field_value("tbl_categories","category_name"," WHERE category_id ='".$val['category_id']."'");
				
				
				$seo_cat_name = seo_url_title($cat_name);
				$seo_prd_name = seo_url_title($val['product_name']);
				
				$if_already_exists_url = $seo_cat_name."/".$seo_prd_name;
				
				$final_url = $seo_cat_name."/".$val['product_friendly_url'];
				
				if($if_already_exists_url!=$val['product_friendly_url']){
				
					
					$sql_prd= "update tbl_products set product_friendly_url ='$final_url' WHERE products_id ='".$val['products_id']."'";
					$this->db->query($sql_prd);
					
					$sql_meta= "update 	tbl_meta_tags set page_url ='$final_url' WHERE entity_id ='".$val['products_id']."' AND entity_type ='products/detail'";
					$this->db->query($sql_meta);
				
				}
				
				
			}
		}
		
	}
	
	
	public function update_category_meta(){
		
		$sql="select category_name,category_id,friendly_url,parent_id from tbl_categories ";
		$row = $this->db->query($sql)->result_array();
		if(!empty($row)){
			foreach($row as $val){
			
				$seo_cat_name = seo_url_title($val['category_name']);
				
				if($val['parent_id']>0){
				
					$parent_cat = get_db_field_value("tbl_categories","category_name"," WHERE category_id ='".$val['parent_id']."'");
					
					$seo_parent_cat_name = seo_url_title($parent_cat);
					
					$final_url = $seo_parent_cat_name.'/'.$seo_cat_name;
					
					if($final_url!=$val['friendly_url']){
							
							
						$sql_cat= "update tbl_categories set friendly_url ='$final_url' WHERE category_id ='".$val['category_id']."'";
						$this->db->query($sql_cat);
					
						$sql_meta= "update 	tbl_meta_tags set page_url ='$final_url' WHERE entity_id ='".$val['category_id']."' AND entity_type ='category/index'";
						$this->db->query($sql_meta);
							
							
							
					}
				
				}
				
				
			}
		}
		
	}
	

}