<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Order_model extends MY_Model{

	public function get_orders($limit='',$offset='',$condition=''){

		$condition="order_status !='Deleted' $condition ";
		$where =$condition;

		$this->db->select("SQL_CALC_FOUND_ROWS tbl_orders.*",FALSE);

		$this->db->from("tbl_orders");
		
		if($limit)
		$this->db->limit($limit,$offset);
		$this->db->where($where,"",FALSE);
		$this->db->order_by('order_id DESC');
		$qry=$this->db->get();
		$res=array();
		if($qry->num_rows() > 0){
			$res=$qry->result_array();
		}
		return $res;	
	}
	
	
	public function get_sellerorders($limit='',$offset='',$condition=''){

		$wherecond="sord.seller_id='".$this->session->userdata('user_id')."' $condition ";
		$this->db->where($wherecond);
			
        if($limit)
		$this->db->limit($limit,$offset);
		$this->db->select('SQL_CALC_FOUND_ROWS sord.*,ord.order_id,ord.invoice_number,ord.order_received_date,ord.order_status,ord.payment_status',FALSE);
		$this->db->from('tbl_orders as ord');
        
		$q=$this->db->get();
		//echo_sql();
		$result =  $q->result_array() ;
		return $result;	
	}



	public function get_order_master($ordId)

	{

		$id = (int) $ordId;

		if($id!='' && is_numeric($id))

		{

			$condtion = "order_id =$id";

			$fetch_config = array(

			'condition'=>$condtion,

			'debug'=>FALSE,

			'return_type'=>"array"

			);



			$result = $this->find('tbl_orders',$fetch_config);

			return $result;

		}

	}



	public function get_order_detail($ordno,$vendorID=FALSE)

	{

		$condtion = "order_id ='$ordno' ";
        if($vendorID){
			$condtion.=" AND seller_id ='$vendorID'";
		}
		$fetch_config = array(

		'condition'=>$condtion,
		'order'=>'NULL',
		'limit'=>'NULL',
		'start'=>'NULL',
		'debug'=>FALSE,
		'field'=>'*',
		'return_type'=>"array"

		);



		$result = $this->findAll('tbl_order_details',$fetch_config);

		return $result;

	}

	

	public function is_order_exist($param=array()){

		$where=@$param["where"];

		$this->db->select('wo.order_id');

		$this->db->from('tbl_orders as wo');

		$this->db->join('tbl_order_details as wop','wo.order_id=wop.order_id');

		//$this->db->where('wo.payment_status','Paid');

		if($where)

		$this->db->where($where);

		$q=$this->db->get();

		return $q->num_rows();

	}



	public function get_order_products($userId)

	{



		$this->db->select('wop.orders_products_id, wop.products_id, wop.product_name, wop.product_code, wop.product_color, wop.product_size, wop.product_price, wop.quantity, wo.invoice_number, wo.currency_code, wo.currency_symbol');

		$this->db->from('tbl_orders as wo');

		$this->db->join('tbl_order_details as wop','wo.order_id=wop.order_id');

		$this->db->where('wop.is_return','0');

		$this->db->where('wo.order_status','Delivered');

		$this->db->where('wo.payment_status','Paid');

		$this->db->where('wo.customers_id',$userId);

		//$this->db->group_by('wo.order_id');

		$q=$this->db->get();

		$result = $q->result_array();

		//echo_sql();

		return $result;



	}



	public function get_return_products($offset='0',$per_page='10',$condition='')

	{



		$keyword   = $this->db->escape_str(trim($this->input->get_post('keyword',TRUE)));

		$from_date = $this->db->escape_str(trim($this->input->get_post('from_date',TRUE)));

		$to_date   = $this->db->escape_str(trim($this->input->get_post('to_date',TRUE)));

		$customers_id   = $this->db->escape_str(trim($this->input->get_post('customers_id',TRUE)));

		$where="order_status !='Deleted' $condition ";



		if($from_date!='' ||  $to_date!='')

		{



			$condition_date=array();

			$where.=" AND (";

			if($from_date!='')

			{

				$condition_date[] = "DATE(wop.return_date)>='$from_date'";

			}if($to_date!='')

			{

				$condition_date[] ="DATE(wop.return_date)<='$to_date'";

			}



			$where.=implode(" AND ",$condition_date)." )";

		}



		if($keyword!='')

		{

			$where.=" AND ( wo.invoice_number LIKE '%".$keyword."%' OR  CONCAT_WS(' ',wo.first_name,wo.last_name) LIKE '%".$keyword."%' OR  wo.email LIKE '%".$keyword."%' ) ";

		}

		if($customers_id!=""){

			$where.=" AND ( wo.customers_id = '".$customers_id."' ) ";

		}



		$this->db->select('wop.orders_products_id, wop.products_id, wop.product_name, wop.product_code, wop.product_color, wop.product_size, wop.product_price, wop.quantity, wop.return_date, wop.is_stock_back, wo.order_id, wo.invoice_number, wo.order_received_date, wo.first_name, wo.last_name, wo.mobile_number, wo.email, wo.currency_code, wo.currency_symbol');

		$this->db->from('tbl_order_details as wop');

		$this->db->join('tbl_orders as wo','wo.order_id=wop.order_id','right');

		$this->db->where('wop.is_return','1');

		$this->db->where($where);

		$q=$this->db->get();

		$result = $q->result_array();

		//echo_sql();

		return $result;



	}



	public function get_vendor_orders($offset='0',$limit='10',$param=array()){

		$return_type = array_key_exists('return_type',$param) ?   $param['return_type']:"result_array" ;

		$orderby			=	@$param['orderby'];

		$where			    =	@$param['where'];

		$where ="order_status !='Deleted' ".$where;



		$jwhere			    =	@$param['jwhere'];



		if($where!=''){

			$this->db->where($where);

		}

		if($orderby!='')

		{

			$this->db->order_by($orderby);

		}else{

			$this->db->order_by('tbl_orders.order_id ','desc');

		}



		$this->db->group_by("tbl_orders.order_id");



		if($limit)$this->db->limit($limit,$offset);



		$this->db->select('SQL_CALC_FOUND_ROWS sum(product_price) as total_product_price,tbl_orders.*,tbl_order_details.id as odid,product_delivery_status',FALSE);

		$this->db->from('tbl_orders');

		$this->db->join('tbl_order_details','tbl_order_details.order_id=tbl_orders.order_id'.$jwhere,'INNER');

		$q=$this->db->get();

		//echo_sql();

		$result =  ($return_type!='')  ? $q->$return_type()  :  $q->result_array() ;

		return $result;

	}

	public function get_transaction($limit='',$offset='',$where=''){				

		$this->db->select("SQL_CALC_FOUND_ROWS tbl_transactions.*",FALSE);

		$this->db->from("tbl_transactions");
		
		if($limit)
		$this->db->limit($limit,$offset);
		if($where)
		$this->db->where($where,"",FALSE);
		$this->db->order_by('id DESC');
		$qry=$this->db->get();
		$res=array();
		if($qry->num_rows() > 0){
			$res=$qry->result_array();
		}
		return $res;	
	}

	public function get_vendor_orders_result($offset='0',$limit='10',$param=array()){

		$return_type = array_key_exists('return_type',$param) ?   $param['return_type']:"result_array" ;
		$orderby			=	@$param['orderby'];
		$where			    =	@$param['where'];
		$select			    =	@$param['select'];
		
		$where ="order_status !='Deleted' ".$where;

		$jwhere			    =	@$param['jwhere'];

		if($where!=''){
			$this->db->where($where);
		}

		if($orderby!=''){
			$this->db->order_by($orderby);
		}else{
			$this->db->order_by('tbl_orders.order_id ','desc');
		}

		$this->db->group_by("tbl_orders.order_id");

		if($limit)$this->db->limit($limit,$offset);

		if($select=='')$select	= " tbl_orders.*,tbl_order_details.id as odid";
		$this->db->select('SQL_CALC_FOUND_ROWS '.$select,FALSE);
		$this->db->from('tbl_orders');

		$this->db->join('tbl_order_details','tbl_order_details.order_id=tbl_orders.order_id'.$jwhere,'INNER');
		$this->db->join('tbl_users','tbl_orders.seller_id=tbl_users.id','INNER');
		$q=$this->db->get();
		//echo_sql();
		$result =  ($return_type!='')  ? $q->$return_type()  :  $q->result_array() ;
		return $result;
	}
	
	public function get_enquiry($offset='0' , $limit='10'){
		
		$keyword  = $this->db->escape_str( $this->input->get_post('keyword') );
		$where ="pd.status ='1' AND penq.status='1' ";
		
		if($keyword != ''){
			$where.=" AND  ( penq.email like '%$keyword%' OR  penq.name like '%$keyword%' OR  pd.product_name like '%$keyword%' OR  pd.product_code like '%$keyword%' )";
		}
		
		$order="penq.id desc";
		$this->db->limit($limit,$offset);
		$this->db->select("SQL_CALC_FOUND_ROWS penq.*,pd.product_name,pd.product_code",FALSE);
		$this->db->from('tbl_product_enquiry as penq');
		$this->db->join("tbl_products as pd","pd.products_id=penq.pid");
		if($where)$this->db->where($where,"",FALSE);
		$this->db->order_by($order);
		$q=$this->db->get();
		//echo $this->db->last_query();
		$result = $q->result_array();
		return $result;
	
	}
	
	
	public function get_admincommission($offset='0' , $limit='10'){
		
		$sellerID  = $this->db->escape_str( $this->input->get_post('seller_id') );
		$from_date  = $this->db->escape_str( $this->input->get_post('from_date') );
		$to_date  = $this->db->escape_str( $this->input->get_post('to_date') );
		
		$where ="comm.status ='1' AND usr.status='1' ";
		if($sellerID !=''){
			
			$where.=" AND comm.vendor_id='$sellerID'";
		}
		if($from_date !='' && $to_date == ''){
			$where.=" AND comm.post_date='$from_date'";
		}
		if($from_date =='' && $to_date != ''){
			$where.=" AND comm.post_date='$to_date'";
		}
		if($from_date !='' && $to_date != ''){
			$where.=" AND comm.post_date BETWEEN '$from_date' AND '$to_date' ";
		}
		$order="comm.id desc";
		$this->db->limit($limit,$offset);
		$this->db->select("SQL_CALC_FOUND_ROWS comm.*,usr.name,usr.shop_name",FALSE);
		$this->db->from('tbl_admin_commission as comm');
		$this->db->join("tbl_users as usr","usr.id=comm.vendor_id");
		if($where)$this->db->where($where,"",FALSE);
		$this->db->order_by($order);
		$q=$this->db->get();
		//echo $this->db->last_query();
		$result = $q->result_array();
		return $result;
	
	}
}