<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Orders_model extends MY_Model

{



	public $tbl_name;

	public function __construct()

	{

		parent::__construct();

		$this->tbl_name="tbl_orders";

	}

	

	

	public function get_record($opts=array())

	{

		$status 	= $this->db->escape_str($this->input->get_post('status',TRUE));

		$keyword 	= $this->db->escape_str($this->input->get_post('keyword',TRUE));

		

		$from_date 	= $this->db->escape_str($this->input->get_post('from_date',TRUE));

		$to_date 		= $this->db->escape_str($this->input->get_post('to_date',TRUE));

		

		$pay_mode 					= $this->db->escape_str($this->input->get_post('pay_mode',TRUE));

		$payment_status 		= $this->db->escape_str($this->input->get_post('payment_status',TRUE));

		

		if(!array_key_exists('condition',$opts) || $opts['condition']=='')

		{

			$opts['condition']= "payment_status !='2' ";

			

		}else

		{

			$opts['condition']= "payment_status !='2' ".$opts['condition'];

		}

		

		if($status!='')

		{

			$opts['condition'].= " AND payment_status='$status' ";

		}

		if($keyword!='')

		{

			$opts['condition'].= " AND (order_no like '%".$keyword."%') ";

		}

		if($from_date!='')

		{

			$opts['condition'].= " AND date(order_date)>='".$from_date."' ";

		}

		if($to_date!='')

		{

			$opts['condition'].= " AND date(order_date)<='".$to_date."' ";

		}

		if($pay_mode!='')

		{

			$opts['condition'].= " AND payment_mode='".$pay_mode."' ";

		}

		if($payment_status!='')

		{

			$opts['condition'].= " AND payment_status='".$payment_status."' ";

		}

		

		

	 	$opts['order']= "id DESC ";		

		

		$opts['condition'].= " ";

		

		$fetch_config = array('condition'=>$opts['condition'],

								'order'=>$opts['order'],

								'return_type'=>"array" );	

								

		if(array_key_exists('debug',$opts) )

		{			

			$fetch_config['debug']=$opts['debug'];

		}

		

		

		if(array_key_exists('field',$opts) && $opts['field']!='' )

		{			

			$fetch_config['field']=$opts['field'];

		}

												

		if(array_key_exists('limit',$opts) && applyFilter('NUMERIC_GT_ZERO',$opts['limit'])>0)

		{

			

			$fetch_config['limit']=$opts['limit'];

		}	

		if(array_key_exists('offset',$opts) && applyFilter('NUMERIC_WT_ZERO',$opts['offset'])!=-1)

		{

			$fetch_config['start']=$opts['offset'];

		}		

		$result = $this->findAll($this->tbl_name,$fetch_config);

		

		//echo $this->db->last_query();

		return $result;

	}

	

	

	

	

	public function get_record_by_id($id)

	{

		$id = applyFilter('NUMERIC_GT_ZERO',$id);

		

		if($id>0)

		{

			$condtion = "status !='2' AND id=$id";

			$fetch_config = array(

														'condition'=>$condtion,							 					 

														'debug'=>FALSE,

														'return_type'=>"object"							  

													 );

			$result = $this->find($this->tbl_name,$fetch_config);

			return $result;

		}

	}

	
	

	

	

}

// model end here