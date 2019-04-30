<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/* The MX_Controller class is autoloaded as required */
class MY_Controller extends CI_Controller 
{
	public $spamwords = array(); 
	public $has_spamword;
	public $admin_info;
	public $meta_info;
	public $site_setting;
	
	public function __construct(){
		
		ob_start();
		parent::__construct();		
		
		$this->load->helper('seo/seo');
		$this->load->config('seo/config');		
		$this->config->set_item('language','english');
				 
		$this->db->select('name,email as admin_email,address,mobile,user_type');
		$this->db->from('tbl_users');
		//$this->db->where('id','1');
		$this->db->where('user_type','1');
		$this->db->where('status','1');		
		$query = $this->db->get();			
		if( $query->num_rows() > 0 )
		{
			$this->admin_info = $query->row();
		}
			
		$this->site_setting=get_db_single_row('tbl_admin_settings','*',array('admin_id'=>1));
			
 	} 	
 	
	public function fetch_spamwords()
	{
		if(is_array($this->spamwords) && empty($this->spamwords) )
		{
			$this->db->select('words');
			$this->db->where('status','1');
			$query=$this->db->get('tbl_spam_words');
			//echo $this->db->last_query();
			if($query->num_rows() > 0)
			{
				$this->spamwords=$query->result();
			}
		}
		return  $this->spamwords;
	} 

	public function filter_spamwords($in_string)
	{
		$spam_words="";
		$res=$this->fetch_spamwords();
		$i=0;			 
		foreach($res as $val)
		{
			if( preg_match("/\b".$val->words."\b/i",$in_string) )
			{
				$spam_words.=$val->words.",";
			}
		}
		$spam_words=rtrim($spam_words,',');
		return  $spam_words;
	}
		
	public function has_spamwords($in_string)
	{
		$array = array_map('reset', $this->fetch_spamwords());
		$this->has_spamword=check_spam_words($array,$in_string);
		return  $this->has_spamword;
	}
	
	public function check_spamwords($str)
	{
		if($this->has_spamwords($str))
		{
			$this->form_validation->set_message("check_spamwords","The %s field contains some offensive words. Please remove them first. The Found Offensive Word(s): <b> ".$this->filter_spamwords($str)."</b>");
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
	  
}