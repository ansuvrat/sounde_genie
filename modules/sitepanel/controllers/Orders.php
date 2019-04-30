<?php

class Orders extends Admin_Controller {

	public $view_path;
	public $current_controller;

	public function __construct()
	{

		parent::__construct();
		$this->current_controller = $this->router->fetch_class();
		$this->load->model(array('order_model'));
		$this->load->helper(array('file','member/member'));
		$this->config->set_item('menu_highlight', 'orders');
		$this->load->library(array('Dmailer'));
		$this->view_path = $this->current_controller . "/";
		$this->form_validation->set_error_delimiters("<div class='required'>","</div>");

	}

	public  function index($page = NULL)

	{
		$pagesize               =  (int) $this->input->get_post('pagesize');
		$config['limit']		=  ( $pagesize > 0 ) ? $pagesize : $this->config->item('pagesize');
		$offset                 =  ( $this->input->get_post('per_page') > 0 ) ? $this->input->get_post('per_page') : 0;
		$base_url               =  current_url_query_string(array('filter'=>'result'),array('per_page'));
		$condition=" ";
		$keyword   = $this->db->escape_str(trim($this->input->get_post('keyword',TRUE)));
		$from_date = $this->db->escape_str(trim($this->input->get_post('from_date',TRUE)));
		$to_date   = $this->db->escape_str(trim($this->input->get_post('to_date',TRUE)));
		$order_status   = $this->db->escape_str(trim($this->input->get_post('order_status',TRUE)));
		$pay_status   = $this->db->escape_str(trim($this->input->get_post('pay_status',TRUE)));
		
		
			
		if($from_date!='' ||  $to_date!='')
		{
			$condition_date=array();
			$condition.=" AND (";
			if($from_date!='')
			{
				$condition_date[] = "DATE(order_date)>='$from_date'";
					
			}if($to_date!=''){
				$condition_date[] ="DATE(order_date)<='$to_date'";
			}
			$condition.=implode(" AND ",$condition_date)." )";
		}

		if($keyword!=''){
			$condition.=" AND ( order_id LIKE '%".$keyword."%' OR name LIKE '%".$keyword."%' OR email LIKE '%".$keyword."%'  ) ";
		}
		if($pay_status!=''){
			$condition.=" AND pay_status ='$pay_status' ";
		}
		if($order_status!=''){
			$condition.=" AND confirm_status ='$order_status' ";
		}
		
		$res_array              =  $this->order_model->get_orders($offset,$config['limit'],$condition);
		$config['total_rows']   =  get_found_rows();
		$data['page_links']     =  admin_pagination($base_url,$config['total_rows'],$config['limit'],$offset);
		/* Order oprations  */
		/* End order oprations  */
		$data['heading_title']  = 'Order Lists';
		$data['res_count']  = $config['total_rows'];
		$data['res']            = $res_array;
        $data["type"]			="";
		$data['includes']		= $this->view_path.'view_order_list';
		$this->load->view('includes/sitepanel_container',$data);
		//$this->load->view('order/view_order_list',$data);
	}


	public function make_paid($order_id){
		
		$order_id = $order_id;
		$where    = "order_id = '".$order_id."'";
		$this->order_model->safe_update('tbl_order',array('pay_status'=>'2'),$where,FALSE);
		$ordmaster = get_db_single_row("tbl_order","*"," AND order_id ='$order_id' ");	
		/* Start  send mail */
		ob_start();
		$mail_subject =$this->site_setting['company_name']." Order Details";
		$from_email   = $this->admin_info->admin_email;
		$from_name    = $this->site_setting['company_name'];
		$mail_to      = $ordmaster['email'];
		$body         = get_invoice($ordmaster);
		$msg          = ob_get_contents();
		$mail_conf =  array(
		'subject'=>$this->site_setting['company_name']." Order Details",
		'to_email'=>$mail_to,
		'from_email'=>$from_email,
		'from_name'=> $this->site_setting['company_name'],
		'body_part'=>$msg);
		$this->dmailer->mail_notify($mail_conf);
		
		/* End  send mail */
		$this->session->set_userdata(array('msg_type'=>'success'));
		$this->session->set_flashdata('success', lang('marked_paid'));		
		$type=$ordmaster["order_type"]==1?'wallet':'';
		redirect('sitepanel/orders/'.$type, '');
	}
	
	
   public function confirm_order($order_id){

		$order_id = $order_id;
		$where = "order_id = '".$order_id."'";
		$this->order_model->safe_update('tbl_order',array('confirm_status'=>'2'),$where,FALSE);
		$ordmaster = get_db_single_row("tbl_order","*"," AND order_id ='$order_id' ");
		
		/* Start  send mail */
		ob_start();
		$mail_subject =$this->site_setting['company_name']." Order Details";
		$from_email   = $this->admin_info->admin_email;
		$from_name    = $this->site_setting['company_name'];
		$mail_to      = $ordmaster['email'];
		$body         = get_invoice($ordmaster,$orddetail);
		$msg          = ob_get_contents();
		
     	$mail_conf =  array(
		'subject'=>$this->site_setting['company_name']." Order Details",
		'to_email'=>$mail_to,
		'from_email'=>$from_email,
		'from_name'=> $this->site_setting['company_name'],
		'body_part'=>$msg);
        
		$this->dmailer->mail_notify($mail_conf);
		/* End  send mail */
		$this->session->set_userdata(array('msg_type'=>'success'));
		$this->session->set_flashdata('success', "Order has been confirmed successfully.");		
		redirect('sitepanel/orders/'.$type, '');
	}


	public function make_unpaid($order_id)
	{

		$order_id = $order_id;
		$ordmaster = $this->order_model->get_order_master( $order_id );
		$orddetail = $this->order_model->get_order_detail($order_id);
		$where = "id = '".$order_id."'";
		$this->order_model->safe_update('tbl_order',array('pay_status'=>'1'),$where,FALSE);
		$this->session->set_userdata(array('msg_type'=>'success'));
		$this->session->set_flashdata('success', lang('marked_unpaid'));
		redirect('sitepanel/orders/'.$type, '');

	}



	public function invoice()
	{
		$order_no=$this->uri->segment('4');
		echo get_invoice($order_no);

	}
	public function print_invoice()
	{
		$order_id=$this->uri->segment(4);
		if(!$order_id)redirect('');
		$data['rworder']=get_db_single_row("tbl_order","*"," AND order_id ='$order_id' ");
		$this->load->view('orders/view_invoice_print',$data);
	}
	
	public function download(){
		
		$this->load->helper("download");
		$orderID=$this->uri->segment(4);
		$rwdata=get_db_single_row("tbl_order","upd_file"," AND order_id='$orderID'");
		if(is_array($rwdata) && count($rwdata) > 0 ){
			
			if($rwdata['upd_file']!='' && file_exists(UPLOAD_DIR.'/order_file/'.$rwdata['upd_file'])){
				$pth    =   file_get_contents(base_url()."uploaded_files/order_file/".$rwdata['upd_file']);
				$nme    =   $rwdata['upd_file'];
				force_download($nme, $pth);     
			}
			
		}
	}
	
}



// End of controller