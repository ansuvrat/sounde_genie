<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_Controller extends MY_Controller
{	
	public $admin_id;
	public $admin_type;
	public $admin_name;
	public function __construct()
	{

		 parent::__construct();	
		 $this->load->library(array('sitepanel/jquery_pagination'));

		 $this->load->model(array('utils_model'));	
		 $this->admin_lib->is_admin_logged_in();	 

		 $this->admin_type	=	$this->session->userdata('admin_type');
		 $this->admin_id		=	$this->session->userdata('admin_id');
		 $this->admin_name		=	$this->session->userdata('admin_name');

		 if($this->admin_type==2)
		 {

			 $seg2=$this->uri->segment('2');
			 $seg3=$this->uri->segment('3');
			 $final_url=$seg2;

			 if($seg2!='' && $seg2!="logout" && $seg2!='dashbord')
			 {
				 if($seg2=="location" && ($seg3=="state" OR $seg3=="city"))
				 {
						 $final_url=$seg2."/".$seg3;
				 }	
				 elseif($seg2=="setting" && ($seg3=="update_setting"))
				 {
						 $final_url=$seg2."/".$seg3;
				 }	

				 $access_sec_id=get_db_field_value("tbl_admin_sections","id",array('section_controller'=>$final_url));
		 		$this->admin_lib->is_section_allowed($this->admin_id,$access_sec_id);
	 		 }

	 	 }

		   $current_controller    = $this->router->fetch_class();
		   $current_method    = $this->router->fetch_method();  
		//exit;
		 //if(($current_controller!='dashbord' && $current_method!='index') && ($current_method=='add' || $current_method=='edit' || $current_method=='post' || $current_method=='change' || $current_method=='adddata' || $current_method=='editdata' )) {
//		if($this->input->post('action')!='') {
//		$demo_data_value_array=$this->config->item('demo_data_value_array');		 
//		$demo_data_value=$this->config->item('demo_data_value');		
//		if(!in_array($demo_data_value,$demo_data_value_array))
//			{			
//			$this->session->set_userdata(array('msg_type'=>'error'));
//			$this->session->set_flashdata('error',$this->config->item('demodataValueMsg') );				
//			redirect('sitepanel/dashbord');				
//				
//			}
//		  }
//	    }

	}

	

	public function update_status($table,$auto_field='id')

	{		

		$action                = $this->input->post('status_action',TRUE);	

		$arr_ids               = $this->input->post('arr_ids',TRUE);

		$category_count        = $this->input->post('category_count',TRUE);

		$product_count         = $this->input->post('product_count',TRUE);	

		$current_controller=$this->current_controller;
		
		//if($current_controller!='dashbord') {
//		$demo_data_value_array=$this->config->item('demo_data_value_array');		 
//		$demo_data_value=$this->config->item('demo_data_value');		
//		if(!in_array($demo_data_value,$demo_data_value_array))
//			{
//							
//			$this->session->set_userdata(array('msg_type'=>'error'));
//			$this->session->set_flashdata('error',$this->config->item('demodataValueMsg') );				
//				redirect('sitepanel/dashbord');				
//				
//			}
//		 }
		

		 if( is_array($arr_ids) )

         {

			  $str_ids = implode(',', $arr_ids);

			  

			  if($action=='Activate')

			  {				 

					  foreach($arr_ids as $k=>$v )

					  {


						   $total_category  = ( $category_count!='' ) ?  count_category("AND parent_id='$v' AND status='0'")     : '0';


		
						   $total_product   = ( $product_count!='' && $current_controller!='category' )  ?  count_products("AND category_id='$v' AND status='0'")   : '0';

						

							if( $total_category>0 || $total_product > 0 )

							{

								$this->session->set_userdata(array('msg_type'=>'error'));

								$this->session->set_flashdata('error',lang('child_to_activate'));

							

							}else

							{  

								$data = array('status'=>'1');								

								$where = "$auto_field ='$v'";					

								$this->utils_model->safe_update($table,$data,$where,FALSE);

								//echo_sql();								

								$this->session->set_userdata(array('msg_type'=>'success'));

								$this->session->set_flashdata('success',lang('activate') );

							

							}

						  

					  }	

				

			  }

			  

			  if($action=='Deactivate')

			  {	  

				    foreach($arr_ids as $k=>$v )

					  {

						  $total_category  = ( $category_count!='' ) ?  count_category("AND parent_id='$v' AND status ='1'")     : '0';

							//echo $this->db->last_query();

						  $total_product   = ( $product_count!='' )  ?  count_products("AND category_id='$v' AND status ='1'")   : '0';


													

						

							if( $total_category>0 || $total_product > 0 )

							{

								

								$this->session->set_userdata(array('msg_type'=>'error'));

								$this->session->set_flashdata('error',lang('child_to_deactivate'));

							

							}else

							{								

								

								$data = array('status'=>'0');

								$where = "$auto_field ='$v'";					

								$this->utils_model->safe_update($table,$data,$where,FALSE);

								$this->session->set_userdata(array('msg_type'=>'success'));

								$this->session->set_flashdata('success',lang('deactivate') );

							

							}

						  

					  }	

			  }

			  

			  if($action=='Delete')

			  {

				  

				  

				      foreach($arr_ids as $k=>$v )

					  {

								$where = array($auto_field=>$v);

								$this->utils_model->safe_delete($table,$where,TRUE);

								

								$this->session->set_userdata(array('msg_type'=>'success'));

								$this->session->set_flashdata('success',lang('deleted') );

							

													  

					  }	

				

			  }			

			

			  if($action=='Tempdelete')

			  {	

			  			 

					$data = array('status'=>'2');

					$where = "$auto_field IN ($str_ids)";

					$this->utils_model->safe_update($table,$data,$where,FALSE);

					$this->session->set_userdata(array('msg_type'=>'success'));

					$this->session->set_flashdata('success',lang('deleted'));	

				

			  }

			  

			  

			 

			  

			  if($action=="Payment Received")

			  {

					$this->load->helper('invoice');

					foreach($arr_ids as $k=>$v )

				  {

					  $data = array('payment_status'=>'1');

					  $where = "$auto_field ='$v'";

					  $this->utils_model->safe_update($table,$data,$where,FALSE);

						

						$order_no=get_title_by_id("tbl_orders","order_id",array("id"=>$v));

						update_seller_payment_stats($order_no);

						

					  $this->session->set_userdata(array('msg_type'=>'success'));

					  $this->session->set_flashdata('success',lang('successupdate') );

				  }

			  }				 

			  

			  if($action=="Payment Pending")

			  {

				  

				  foreach($arr_ids as $k=>$v )

				  {					  

					  $data = array('payment_status'=>'0');

					  $where = "$auto_field ='$v'";

					  $this->utils_model->safe_update($table,$data,$where,FALSE);

					  $this->session->set_userdata(array('msg_type'=>'success'));

					  $this->session->set_flashdata('success',lang('successupdate') );

				  }

			  }

			  if($action=="Reject")

			  {

				  

				  foreach($arr_ids as $k=>$v )

				  {					  

					  $data = array('paid_status'=>'2');

					  $where = "$auto_field ='$v'";

					  $this->utils_model->safe_update($table,$data,$where,FALSE);

					  $this->session->set_userdata(array('msg_type'=>'success'));

					  $this->session->set_flashdata('success',lang('successupdate') );

				  }

			  }	

				

				if($action=='Set Feature')

				{

					$data = array('is_feature'=>'1');

					$where = "$auto_field IN ($str_ids)";

					$this->utils_model->safe_update($table,$data,$where,FALSE);

					$this->session->set_userdata(array('msg_type'=>'success'));

					$this->session->set_flashdata('success',lang('successupdate'));

				}

				if($action=='Unset Feature')

				{

					$data = array('is_feature'=>'0');

					$where = "$auto_field IN ($str_ids)";

					$this->utils_model->safe_update($table,$data,$where,FALSE);

					$this->session->set_userdata(array('msg_type'=>'success'));

					$this->session->set_flashdata('success',lang('successupdate'));

				}

				if($action=='Set New')

				{

					$data = array('is_new'=>'1');

					$where = "$auto_field IN ($str_ids)";

					$this->utils_model->safe_update($table,$data,$where,FALSE);

					$this->session->set_userdata(array('msg_type'=>'success'));

					$this->session->set_flashdata('success',lang('successupdate'));

				}

				if($action=='Unset New')

				{

					$data = array('is_new'=>'0');

					$where = "$auto_field IN ($str_ids)";

					$this->utils_model->safe_update($table,$data,$where,FALSE);

					$this->session->set_userdata(array('msg_type'=>'success'));

					$this->session->set_flashdata('success',lang('successupdate'));

				}

				if($action=='Paid')

				{

					$data = array('payment_status'=>'1');

					$where = "$auto_field IN ($str_ids)";

					$this->utils_model->safe_update($table,$data,$where,FALSE);

					$this->session->set_userdata(array('msg_type'=>'success'));

					$this->session->set_flashdata('success',lang('successupdate'));

				}

				if($action=='Unpaid')

				{

					$data = array('payment_status'=>'0');

					$where = "$auto_field IN ($str_ids)";

					$this->utils_model->safe_update($table,$data,$where,FALSE);

					$this->session->set_userdata(array('msg_type'=>'success'));

					$this->session->set_flashdata('success',lang('successupdate'));

				}

				if($action=='Resolved')

				{

					$data = array('resolved_status'=>'1');

					$where = "$auto_field IN ($str_ids)";

					$this->utils_model->safe_update($table,$data,$where,FALSE);

					$this->session->set_userdata(array('msg_type'=>'success'));

					$this->session->set_flashdata('success',lang('successupdate'));

				}  



				

				

			  		 	  

     }

		  

	

		redirect($_SERVER['HTTP_REFERER'], '');

		

	}

	
 public function set_as($table,$auto_field='id',$data=array())
  {
	  
    $arr_ids               = $this->input->post('arr_ids',TRUE);
    if( is_array($arr_ids ) )
    {

      $str_ids = implode(',', $arr_ids);

      if( is_array($data) && !empty($data) )
      {
        $data = $data;
        $where = "$auto_field IN ($str_ids)";
        $this->utils_model->safe_update($table,$data,$where,FALSE);


        $current_controller    = $this->router->fetch_class();

        if($current_controller=="orders" && $this->input->post("ord_status")!="" && ($this->input->post("ord_status")!="Pending" && $this->input->post("ord_status")!="Closed")){
          $this->load->library("dmailer");
          $mail_subject =$this->config->item('site_name')." Order overview";
          $from_email   = $this->admin_info->admin_email;
          $from_name    = $this->site_setting['company_name'];

          foreach($arr_ids as $key=>$val){
            $order=get_db_single_row("tbl_orders",'*',array('order_id'=>$val));
            $courier_details="";
            if($this->input->post("ord_status")=="Dispatched"){
              if($order['courier_company_name']!=""){
                $courier_details.="<br/>Shipping Company Name : ".$order['courier_company_name'];
              }
              if($order['bill_number']!=""){
                $courier_details.="<br/>Shipment Tracking No. : ".$order['bill_number'];
              }
            }

            $mail_to      = $order["email"];
            $body         = "Dear ".ucwords($order["first_name"]." ".$order["last_name"]);
            $body           .=",<br /><br />";

            $body           .="This is to notify you that your order is ".$this->input->post("ord_status")."  successfully .<br /><br />Here are the details<br /> Order Number: $order[invoice_number] <br/>".$this->input->post("ord_status")." Date/Time: ".date("d-m-Y h:i:s").$courier_details."<br /><br />Regards,<br />Customer Support Team<br />".$this->config->item('site_name');
            $mail_conf =  array(
            'subject'=>$this->site_setting['company_name']." Order ".$this->input->post("ord_status"),
            'to_email'=>$mail_to,
            'from_email'=>$from_email,
            'from_name'=> $this->site_setting['company_name'],
            'body_part'=>$body );
            $this->dmailer->mail_notify($mail_conf);

          }
        }

        $this->session->set_userdata(array('msg_type'=>'success'));
        $this->session->set_flashdata('success',"Record has been updated/deleted successfully.");
      }
       redirect($_SERVER['HTTP_REFERER'], '');

    }
  } 

	

	//public function set_as($table,$auto_field='id',$data=array())
//	{	
//	$arr_ids               = $this->input->post('arr_ids',TRUE);	
//		if( is_array($arr_ids ) ){
//			$str_ids = implode(',', $arr_ids); 
//
//			if( is_array($data) && !empty($data) )
//			{
//				$data = $data;
//				$where = "$auto_field IN ($str_ids)";
//				$this->utils_model->safe_update($table,$data,$where,FALSE);              
//				$this->session->set_userdata(array('msg_type'=>'success'));
//				$this->session->set_flashdata('success',"Record has been updated/deleted successfully.");			
//			}	
//		   redirect($_SERVER['HTTP_REFERER'], '');
//		 }	
//	}

	/*

	

	$tblname = name of table 

	$fldname = order column name  of table 

	$fld_id  =  auto increment column name of table

			

	*/	

	

  public function update_displayOrder($tblname,$fldname,$fld_id)

	{

		$posted_order_data=$this->input->post('ord');

		

		while(list($key,$val)=each($posted_order_data))

		{

			if( $val!='' )

			{

				 $val = (int) $val;

				 $data = array($fldname=>$val);

				 $where = "$fld_id=$key";

				 $this->utils_model->safe_update($tblname,$data,$where,TRUE);			

			

			}

				

		}

		$this->session->set_userdata(array('msg_type'=>'success'));

		$this->session->set_flashdata('success',lang('order_updated'));		

		redirect($_SERVER['HTTP_REFERER'], '');

	}

	

	function get_max_disp_order($tbl,$cond)

	{

		$this->db->select_max('disp_order');

		$this->db->where($cond);

		$qry=$this->db->get($tbl);

		

		$dsorder=0;

		if($qry->num_rows() > 0)

		{

			$res=$qry->row();

			$dsorder= $res->disp_order;

		}

		return $dsorder+1;

	}

	

		

	

	

}