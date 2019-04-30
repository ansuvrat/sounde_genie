<?php

class Dashbord extends Admin_Controller {



  public function __construct() {

	

	 parent::__construct();	

	

	  $this->load->model(array('sitepanel/sitepanel_model'));	 

	  $this->config->set_item('menu_highlight','dashboard');

  }

	

	public  function index()

	{

		

		$data['title'] =  $this->config->item("site_name");

		

		//$total_revenue=custom_result_set(" select SUM(order_price) as total_revenue from tbl_orders where payment_status ='1'");

		

		$curr_year=date('Y');

		

		if($this->input->get_post('change_year')!=''){

			$curr_year=date($this->input->get_post('change_year'));

		}

		

		//$this_year_revenue=custom_result_set(" select SUM(order_price) as this_year_revenue from tbl_orders where payment_status ='1' AND YEAR(order_date)=".$curr_year."");

		

		$total_sellers=0;

		

		$total_buyers=0;

		

		//$orders_list=custom_result_set(" select order_id,order_price,payment_status  from tbl_orders   order by order_date desc limit 0,10");

		

		//$low_qty_prd=custom_result_set(" select COUNT(products_id) as low_prd_cnt  from tbl_products where quantity<=low_qty_limit and status!='2' ");

		

		//$data['total_revenue'] = $total_revenue[0]['total_revenue'] ;

		$data['total_sellers'] = $total_sellers[0]['total_seller'] ;

		$data['total_buyers'] = $total_buyers[0]['total_buyers'] ;

		//$data['this_year_revenue'] = $this_year_revenue[0]['this_year_revenue'] ;

		//$data['low_prd_cnt'] = $low_qty_prd[0]['low_prd_cnt'] ;

		//$data['orders_list'] = $orders_list ;

		$data['total_ads_order']  = 0;

		$data['total_pkg_order']  = 0;

		$data['total_member'] = 0;

		

		$this->load->view('dashboard/dashbord_index_view',$data);	

	 

   }		

	

   public function count_record ($table,$condition="")

   {

				

		if($table!="" && $condition!="")

		{

			

			  $this->db->from($table);

			  $this->db->where($condition);	        

			  $num = $this->db->count_all_results();

			

		 }else

		 {			

			 $num = $this->db->count_all($table);

			

		}

		

		return $num;

	

    }

  

		 	 

	public function remove_thumb_cache()

	{			

		$path = IMG_CACH_DIR;	

		$this->load->helper("file");

        delete_files($path);

				

	}	

	

	public function php_info()

	{			

		phpinfo();

		

	}

	

	public function make_folder($name='')

	{			

		if($name!='')

		{						

			make_missing_folder($name);			

		}

				

	}

	

	public function get_ini()

	{



		trace(ini_get_all());

		

	}

	

	private function table_info($table_name)

    {

        $fields = array();



        // check that the table exists in this database

        if ($this->db->table_exists($table_name))

        {



            $query_string = "SHOW COLUMNS FROM ".$this->db->dbprefix.$table_name;

            if($query = $this->db->query($query_string))

            {

                // We have a title - Edit it

                foreach($query->result_array() as $field)

                {

                    $field_array = array();



                    $field_array['name'] = $field['Field'];



                    $type = '';

                    if(strpos($field['Type'], "("))

                    {

                        list($type, $max_length) = explode("--", str_replace("(", "--", str_replace(")", "", $field['Type'])));

                    }

                    else

                    {

                        $type = $field['Type'];

                    }



                    $field_array['type'] = strtoupper($type);



                    $values = '';

                    if(is_numeric($max_length))

                    {

                        $max_length = $max_length;

                    }

                    else

                    {

                        $values = $max_length;

                        $max_length = 1;

                    }



                    $field_array['max_length'] = $max_length;

                    $field_array['values'] = $values;



                    $primary_key = 0;

                    if($field['Key'] == "PRI") {

                        $primary_key = 1;

                    }

                    $field_array['primary_key'] = $primary_key;



                    $field_array['default'] = $field['Default'];



                    $fields[] = $field_array;

                } // end foreach



                return $fields;



            }//end if

        }//end if



        return FALSE;



    }//end table_info()

		

		

		

	



}

/* End of file student.php */

/* Location: ./system/application/controllers/student.php */