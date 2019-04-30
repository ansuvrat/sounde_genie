<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Price_model extends MY_Model
{

	public function __construct()
	{
		parent::__construct();
	}
	
	///////////////////////////// virtual instrument price ///////////////////
	
	public function get_virtual_instrument_price($opts=array())
	{
		$keyword = trim($this->input->get_post('keyword',TRUE));		
		$keyword = $this->db->escape_str($keyword);
		$status = $this->db->escape_str($this->input->get_post('status',TRUE));
		
		$instrument_type = trim($this->input->get_post('instrument_type',TRUE));		
		$duration = trim($this->input->get_post('duration',TRUE));		
		
		if(!array_key_exists('condition',$opts) || $opts['condition']=='')
		{
			$opts['condition']= "status !='2' AND type='1' ";
			
		}else
		{
			$opts['condition']= "status !='2' AND type='1' ".$opts['condition'];
		}
		
		if($keyword!='')
		{
			$opts['condition'].= " AND price like '%".$keyword."%'";
		}
		
		if($status!='')
		{
			$opts['condition'].= " AND status='$status' ";
		}
		
		if($instrument_type!='')
		{
			$opts['condition'].= " AND instrument_type='$instrument_type' ";
		}
		if($duration!='')
		{
			$opts['condition'].= " AND duration='$duration' ";
		}
				
		
	    if(!array_key_exists('order',$opts) || $opts['order']=='')
		{
			$opts['order']= "price_id DESC ";
			
		}			
		
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
		$result = $this->findAll('tbl_virtual_instru_price as a',$fetch_config);
		return $result;
	}
	
	
	public function get_live_instrument_price($opts=array())
	{
		$keyword = trim($this->input->get_post('keyword',TRUE));		
		$keyword = $this->db->escape_str($keyword);
		$status = $this->db->escape_str($this->input->get_post('status',TRUE));
		
		$instrument_type = trim($this->input->get_post('instrument_type',TRUE));		
		$duration = trim($this->input->get_post('duration',TRUE));		
		
		if(!array_key_exists('condition',$opts) || $opts['condition']=='')
		{
			$opts['condition']= "status !='2' AND type='2' ";
			
		}else
		{
			$opts['condition']= "status !='2' AND type='2' ".$opts['condition'];
		}
		
		if($keyword!='')
		{
			$opts['condition'].= " AND price like '%".$keyword."%'";
		}
		
		if($status!='')
		{
			$opts['condition'].= " AND status='$status' ";
		}
		
		if($instrument_type!='')
		{
			$opts['condition'].= " AND instrument_type='$instrument_type' ";
		}
		if($duration!='')
		{
			$opts['condition'].= " AND duration='$duration' ";
		}
				
		
	    if(!array_key_exists('order',$opts) || $opts['order']=='')
		{
			$opts['order']= "price_id DESC ";
			
		}			
		
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
		$result = $this->findAll('tbl_virtual_instru_price as a',$fetch_config);
		return $result;
	}
	
	
	
	public function get_instrument_price_by_id($id)
	{
		$id = applyFilter('NUMERIC_GT_ZERO',$id);
		
		if($id>0)
		{
			$condtion = "status !='2' AND price_id=$id";
			$fetch_config = array(
														'condition'=>$condtion,							 					 
														'debug'=>FALSE,
														'return_type'=>"array"							  
													 );
			$result = $this->find('tbl_virtual_instru_price',$fetch_config);
			return $result;
		}
	}
	////////////////////////////////////End///////////////////////////////////////
	
	
	////////////////////////////////////Lyrics Price///////////////////////////////////////
	
	public function get_lyrics_price($opts=array())
	{
		$keyword = trim($this->input->get_post('keyword',TRUE));		
		$keyword = $this->db->escape_str($keyword);
		$status = $this->db->escape_str($this->input->get_post('status',TRUE));
		
		$lyrics_type = trim($this->input->get_post('lyrics_type',TRUE));		
		$duration = trim($this->input->get_post('duration',TRUE));		
		
		if(!array_key_exists('condition',$opts) || $opts['condition']=='')
		{
			$opts['condition']= "status !='2' ";
			
		}else
		{
			$opts['condition']= "status !='2' ".$opts['condition'];
		}
		
		if($keyword!='')
		{
			$opts['condition'].= " AND price like '%".$keyword."%'";
		}
		
		if($status!='')
		{
			$opts['condition'].= " AND status='$status' ";
		}
		
		if($lyrics_type!='')
		{
			$opts['condition'].= " AND lyrics_type='$lyrics_type' ";
		}
		if($duration!='')
		{
			$opts['condition'].= " AND duration='$duration' ";
		}
				
		
	    if(!array_key_exists('order',$opts) || $opts['order']=='')
		{
			$opts['order']= "price_id DESC ";
			
		}			
		
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
		$result = $this->findAll('tbl_lyrics_price as a',$fetch_config);
		return $result;
	}
	
	
	
	public function get_lyrics_price_by_id($id)
	{
		$id = applyFilter('NUMERIC_GT_ZERO',$id);
		
		if($id>0)
		{
			$condtion = "status !='2' AND price_id=$id";
			$fetch_config = array(
														'condition'=>$condtion,							 					 
														'debug'=>FALSE,
														'return_type'=>"array"							  
													 );
			$result = $this->find('tbl_lyrics_price',$fetch_config);
			return $result;
		}
	}
	
	///////////////////////////////// Lyrics Price End /////////////////////////
	
	///////////////////////////////// mixing price //////////////////////////////
	
	public function get_mixing_price($opts=array())
	{
		$keyword = trim($this->input->get_post('keyword',TRUE));		
		$keyword = $this->db->escape_str($keyword);
		$status = $this->db->escape_str($this->input->get_post('status',TRUE));
		
		$track_id = trim($this->input->get_post('track_id',TRUE));		
		$duration = trim($this->input->get_post('duration',TRUE));		
		
		if(!array_key_exists('condition',$opts) || $opts['condition']=='')
		{
			$opts['condition']= "status !='2' ";
			
		}else
		{
			$opts['condition']= "status !='2' ".$opts['condition'];
		}
		
		if($keyword!='')
		{
			$opts['condition'].= " AND price like '%".$keyword."%'";
		}
		
		if($status!='')
		{
			$opts['condition'].= " AND status='$status' ";
		}
		
		if($track_id!='')
		{
			$opts['condition'].= " AND track_id='$track_id' ";
		}
		if($duration!='')
		{
			$opts['condition'].= " AND duration='$duration' ";
		}
				
		
	    if(!array_key_exists('order',$opts) || $opts['order']=='')
		{
			$opts['order']= "price_id DESC ";
			
		}			
		
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
		$result = $this->findAll('tbl_mixing_price as a',$fetch_config);
		return $result;
	}
	
	
	
	public function get_mixing_price_by_id($id)
	{
		$id = applyFilter('NUMERIC_GT_ZERO',$id);
		
		if($id>0)
		{
			$condtion = "status !='2' AND price_id=$id";
			$fetch_config = array(
														'condition'=>$condtion,							 					 
														'debug'=>FALSE,
														'return_type'=>"array"							  
													 );
			$result = $this->find('tbl_mixing_price',$fetch_config);
			return $result;
		}
	}
	
	
	
	//////////////////////////////// mixing price end ////////////////////////////
	
	///////////////////////////////  Mastring Price /////////////////////////////
	
	
	
	public function get_mastring_price($opts=array())
	{
		$keyword = trim($this->input->get_post('keyword',TRUE));		
		$keyword = $this->db->escape_str($keyword);
		$status = $this->db->escape_str($this->input->get_post('status',TRUE));
		
		$duration = trim($this->input->get_post('duration',TRUE));		
		
		if(!array_key_exists('condition',$opts) || $opts['condition']=='')
		{
			$opts['condition']= "status !='2' ";
			
		}else
		{
			$opts['condition']= "status !='2' ".$opts['condition'];
		}
		
		if($keyword!='')
		{
			$opts['condition'].= " AND price like '%".$keyword."%'";
		}
		
		if($status!='')
		{
			$opts['condition'].= " AND status='$status' ";
		}
		if($duration!='')
		{
			$opts['condition'].= " AND duration='$duration' ";
		}
				
		
	    if(!array_key_exists('order',$opts) || $opts['order']=='')
		{
			$opts['order']= "price_id DESC ";
			
		}			
		
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
		$result = $this->findAll('tbl_mastring_price as a',$fetch_config);
		return $result;
	}
	
	
	
	public function get_mastring_price_by_id($id)
	{
		$id = applyFilter('NUMERIC_GT_ZERO',$id);
		
		if($id>0)
		{
			$condtion = "status !='2' AND price_id=$id";
			$fetch_config = array(
									'condition'=>$condtion,							 					 
									'debug'=>FALSE,
									'return_type'=>"array"							  
								 );
			$result = $this->find('tbl_mastring_price',$fetch_config);
			return $result;
		}
	}
	
	
	////////////////////////////// Mastring Price End ////////////////////////////
	
	
	///////////////////////////////// mixing price //////////////////////////////
	
	public function get_sound_recording_price($opts=array())
	{
		$keyword = trim($this->input->get_post('keyword',TRUE));		
		$keyword = $this->db->escape_str($keyword);
		$status = $this->db->escape_str($this->input->get_post('status',TRUE));
		
		$sound_recording_category = trim($this->input->get_post('sound_recording_category',TRUE));
		
		if(!array_key_exists('condition',$opts) || $opts['condition']=='')
		{
			$opts['condition']= "status !='2' ";
			
		}else
		{
			$opts['condition']= "status !='2' ".$opts['condition'];
		}
		
		if($keyword!='')
		{
			$opts['condition'].= " AND price like '%".$keyword."%'";
		}
		
		if($status!='')
		{
			$opts['condition'].= " AND status='$status' ";
		}
		
		if($sound_recording_category!='')
		{
			$opts['condition'].= " AND sound_recording_category='$sound_recording_category' ";
		}
		
				
		
	    if(!array_key_exists('order',$opts) || $opts['order']=='')
		{
			$opts['order']= "price_id DESC ";
			
		}			
		
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
		$result = $this->findAll('tbl_sound_recording_price as a',$fetch_config);
		return $result;
	}
	
	
	
	public function get_sound_recording_price_by_id($id)
	{
		$id = applyFilter('NUMERIC_GT_ZERO',$id);
		
		if($id>0)
		{
			$condtion = "status !='2' AND price_id=$id";
			$fetch_config = array(
									'condition'=>$condtion,	
									'debug'=>FALSE,
									'return_type'=>"array"							  
								 );
			$result = $this->find('tbl_sound_recording_price',$fetch_config);
			return $result;
		}
	}
	
	
	//////////////////////////////// mixing price end ////////////////////////////
	
	
	
		///////////////////////////////// designing price //////////////////////////////
	
	public function get_designing_price($opts=array())
	{
		$keyword = trim($this->input->get_post('keyword',TRUE));		
		$keyword = $this->db->escape_str($keyword);
		$status = $this->db->escape_str($this->input->get_post('status',TRUE));
		
		$duration = trim($this->input->get_post('duration',TRUE));		
		
		if(!array_key_exists('condition',$opts) || $opts['condition']=='')
		{
			$opts['condition']= "status !='2' ";
			
		}else
		{
			$opts['condition']= "status !='2' ".$opts['condition'];
		}
		
		if($keyword!='')
		{
			$opts['condition'].= " AND price like '%".$keyword."%'";
		}
		
		if($status!='')
		{
			$opts['condition'].= " AND status='$status' ";
		}
		
		
		if($duration!='')
		{
			$opts['condition'].= " AND duration='$duration' ";
		}
				
		
	    if(!array_key_exists('order',$opts) || $opts['order']=='')
		{
			$opts['order']= "price_id DESC ";
			
		}			
		
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
		$result = $this->findAll('tbl_designing_price as a',$fetch_config);
		return $result;
	}
	
	
	
	public function get_designing_price_by_id($id)
	{
		$id = applyFilter('NUMERIC_GT_ZERO',$id);
		
		if($id>0)
		{
			$condtion = "status !='2' AND price_id=$id";
			$fetch_config = array(
									'condition'=>$condtion,	
									'debug'=>FALSE,
									'return_type'=>"array"							  
								 );
			$result = $this->find('tbl_designing_price',$fetch_config);
			return $result;
		}
	}
	
	
	
}
// model end here