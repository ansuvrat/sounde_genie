<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Member_model extends MY_Model{


	public function get_members($limit='10',$offset='0',$param=array()){
		$status			    =   @$param['status'];
		$id					=   @$param['id'];
		$keyword			=   trim($this->input->get_post('keyword',TRUE));
		$keyword			=   $this->db->escape_str($keyword);

		$condition="1 AND tbl_users.status != '2'";
		if($status!=''){
			$condition =("tbl_users.status = '".$status."'");
		}

		if(@array_key_exists('cond',$param)){
			$condition .=$param["cond"];
		}
		if($id!=''){
			$condition .=(" AND id = $id");		
		}

		if(@array_key_exists('select',$param) && $param["select"]!=''){
			$select =$param["select"];
		}else{
			$select ="tbl_users.*";
		}
		

		$order=@array_key_exists('order',$param)?$param["order"]:"id desc";
		
		$this->db->limit($limit,$offset);
		$this->db->select("SQL_CALC_FOUND_ROWS $select",FALSE);
		$this->db->from('tbl_users');
		$this->db->where($condition,"",FALSE);
		$this->db->order_by($order);
		$q=$this->db->get();
		//echo_sql();

		$result = $q->result_array();		
		$result = ($limit=='1') ? @$result[0]: $result;
		return $result;
	
	}
		

	public function get_member_row($id,$condtion=''){
		
		$id = (int) $id;
		if($id!='' && is_numeric($id)){
			$condtion = "status !='2' AND id=$id $condtion ";

			$fetch_config = array(
							  'condition'=>$condtion,
							  'debug'=>FALSE,				
							  'return_type'=>"array");

			  $result = $this->find('tbl_users',$fetch_config);
			  return $result;
		}
	}




	public function get_wislists($offset=FALSE,$per_page=FALSE, $param=array())

	{



		$where				=   @$param['where'];



		$keyword = trim($this->db->escape_str($this->input->post('keyword')));

		$id      = (int)trim($this->db->escape_str($this->input->post('wislist_id')));

			

		$from_date = $this->input->post('from_date');

		$to_date   = $this->input->post('to_date');

			

		$condition="wp.status ='1'".$where;

			

			

		if($id!='')

		{

			$condition.=" AND  wis.id = '".$id."'";

		}

			

		if($keyword!='')

		{

			$condition.=" AND ( wp.product_name LIKE '%".$keyword."%' OR wp.product_code LIKE '%".$keyword."%' ) ";

		}

		/*if($from_date!='' ||  $to_date!='')

		{

		$condition_date=array();

		$condtion.=" AND (";

		if($from_date!='')

		{

		$condition_date[]="wis.wishlists_date_added>='$from_date'";

		}else

		{

		$condition_date[]="wis.wishlists_date_added<='$to_date'";

		}

		$condtion.=implode(" AND ",$condition_date)." )";

		}*/

		$opts=array(

			'condition'=>$condition,

			'limit'=>$per_page,

			'offset'=>$offset,

			'debug'=> FALSE,

			'fromcond'=>'tbl_products AS wp',

			'selectcond'=>'wp.*,wis.posted_date, wis.id as wid',

			'joins'=>array(array('tblname'=>'tbl_wishes AS wis','jclause'=>'wis.product_id=wp.products_id'))	

		);

		return $this->myCustomJoin($opts);
	}
	
	
	public function get_favoriteproduct($limit='10',$offset='0')
	{
	
		$wherecond="flw.user_id = '$this->userId'  ";
		$wherecond.=" AND prd.status='1'";
		$this->db->where($wherecond);	
        $this->db->order_by('flw.id ','desc');
		if($limit)
		$this->db->limit($limit,$offset);
		$this->db->select('SQL_CALC_FOUND_ROWS flw.*,prd.products_id,prd.product_name,prd.product_code,prd.product_discounted_price,prd.product_price,prd.quantity,product_friendly_url',FALSE);
		$this->db->from('tbl_favorite_product as flw');
        $this->db->join('tbl_products AS prd','prd.products_id=flw.pid ','INNER');
		$q=$this->db->get();
		//echo_sql();	
		$result =  $q->result_array() ;
		return $result;
	}
	
	
	public function get_followseller($limit='10',$offset='0')
	{
	
		$wherecond="flw.follower_id = '$this->userId'  ";
		$wherecond.=" AND flw.status='1' AND usr.status='1'";
		$this->db->where($wherecond);	
        $this->db->order_by('flw.id ','desc');
		if($limit)
		$this->db->limit($limit,$offset);
		$this->db->select('SQL_CALC_FOUND_ROWS flw.*,usr.id as memID,usr.name,usr.shop_name,usr.email,usr.logo,usr.address1,usr.address2,usr.sell_landline_code,usr.sell_landline_no,usr.sell_mobile,usr.customer_support_no,usr.sell_city,usr.sell_state,usr.sell_country',FALSE);
		$this->db->from('tbl_seller_followers as flw');
        $this->db->join('tbl_users AS usr','usr.id=flw.seller_id ','INNER');
		$q=$this->db->get();
		//echo_sql();	
		$result =  $q->result_array() ;
		return $result;
	}
	
	
	public function getorder($orderID){
		
		if($orderID!=''){
			$condtion = "order_id ='$orderID' ";

			$fetch_config = array(
							  'condition'=>$condtion,
							  'debug'=>FALSE,				
							  'return_type'=>"array");

			  $result = $this->find('tbl_order',$fetch_config);
			  return $result;
		}
	}
	
	
	public function get_enquiry($limit='10',$offset='0',$id=FALSE)
	 {
		$keyword			=   trim($this->input->get_post('keyword',TRUE));
		$keyword			=   $this->db->escape_str($keyword);
		$wherecond="status = '1' AND mem_id ='".$this->session->userdata('user_id')."' ";
		
		$opts=array(
								'condition'=>$wherecond,
								'offset'=>$offset,
								'limit'=>$limit,
								'orderby'=>'id DESC',
								'fromcond'=>'tbl_live_instrument_enquiry',
								'selectcond'=>"*",
								);
			return $this->myCustomJoin($opts);	
		
	}
	
	public function get_orders($limit='10',$offset='0',$id=FALSE)
	 {
		$keyword			=   $this->db->escape_str(trim($this->input->get_post('keyword',TRUE)));
		$from_date			=   $this->db->escape_str(trim($this->input->get_post('from_date',TRUE)));
		$to_date			=   $this->db->escape_str(trim($this->input->get_post('to_date',TRUE)));
		
		$wherecond="status = '1' AND mem_id ='".$this->session->userdata('user_id')."' ";
		
		if($from_date != '' && $to_date == '' ){
			$wherecond.=" AND DATE(order_date) ='$from_date' ";
		}
		if($from_date == '' && $to_date != '' ){
			$wherecond.=" AND DATE(order_date) ='$to_date' ";
		}
		if($from_date != '' && $to_date != '' ){
			$wherecond.=" AND DATE(order_date) BETWEEN  '$from_date' AND '$to_date' ";
		}
		
		
		$opts=array(
								'condition'=>$wherecond,
								'offset'=>$offset,
								'limit'=>$limit,
								'orderby'=>'id DESC',
								'fromcond'=>'tbl_order',
								'selectcond'=>"*",
								);
			return $this->myCustomJoin($opts);	
		
	}
	
	
	

}