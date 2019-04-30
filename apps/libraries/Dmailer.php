<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Dmailer
{
	
	private $CI;
		
    public function __construct()
	{
		
		$this->CI =& get_instance();		
		/*$config = array(
		'protocol' => 'smtp',
		'smtp_host' => 'ssl://smtp.googlemail.com',
		'smtp_port' => 465,
		'smtp_user' => 'weblink.dkm@gmail.com',
		'smtp_pass' => 'wlhr-1471',     
		 );	*/
		
	    $this->CI->load->library('email');
		
	    //$this->CI->email->initialize($config);    
		
	 }
   
   
   public function mail_notify($mail_conf = array())
   {
	   
			/*
			 $mail_conf =  array(
			'subject'=>"hiiiiiii",
			'to_email'=>"sk@gmail.com",
			'from_email'=>"mk@gmail.com",
			'from_name'=>"mk maurya",
			'body_part'=>"hfdgfgdg gfdgf dgdfgdf gdfg",
			 print_r($mail_conf); exit();
			 			 			
			*/	
			   
		   if(is_array($mail_conf) && !empty($mail_conf) )
		   { 	   	 
				 					 
					$mail_to            = $mail_conf['to_email'];
					$mail_subject       = $mail_conf['subject']; 
					$from_email         = $mail_conf['from_email'];
					$from_name          = $mail_conf['from_name'];	
					$body               = $mail_conf['body_part'];				
					$file               = @$mail_conf['attachment'];
					$cc                 = @$mail_conf['cc'];
					$bcc                = @$mail_conf['bcc'];
					$alternative_msg    = @$mail_conf['alternative_msg'];
					$debug              = @$mail_conf['debug'];
					
								
					$this->CI->email->set_newline("\r\n");
					$this->CI->email->set_mailtype('html');				  
					$this->CI->email->from($from_email, $from_name);
					$this->CI->email->reply_to($from_email, $from_name);
					$this->CI->email->to($mail_to);	
						
					if($cc!='')
					{
						$this->CI->email->cc($cc);						
					}
					if($bcc!='')
					{
						$this->CI->email->cc($bcc);
					}
					
					if($alternative_msg!='')
					{					
						$this->email->set_alt_message($alternative_msg);					
					}
					if($file !='' && file_exists($file))
					{
						$this->CI->email->attach($file);
					}				
					$this->CI->email->subject($mail_subject);				
					$this->CI->email->message($body);								
					$this->CI->email->send();				
					
					if($debug )
					{
						 $this->CI->email->print_debugger();
					}
					
					$this->CI->email->clear(TRUE);	
			  
			  }  
   
     } 
     
		public function send($data=array()){				
			if(array_key_exists('config',$data)){
				$data["config"]['mailtype']='html';
				$this->CI->load->library('email',$data["config"]);
				$config['mailtype']="html";
				$this->CI->email->initialize($config);
			}			
			$from=$this->CI->admin_info->email;
			
			$this->CI->email->from($from, $this->CI->config->item('site_name'));			
			if(array_key_exists('to',$data))
				$to=$data["to"];
			else 
				$to=$from;
					
			$this->CI->email->to($to);
			$this->CI->email->subject($this->CI->config->item('site_name').' :: '.$data["subject"]);
			$mess='<div style="width:600px; margin:0 auto; padding:20px; border:#000 8px solid;">
			<div style="margin-bottom:10px;"><a href="'.base_url().'" target="_blank">
			<img src="'.theme_url().'images/domestic-shops.jpg" alt="'.$this->CI->config->item('site_name').'" border="0" /></a></div>
    		<div style="font:normal 12px Arial, Helvetica, sans-serif; color:#424242; line-height:1.7em; text-align:justify; padding-top:10px; border-top:#00a7eb 1px solid;">';
			$mess.=$data["mess"]."<br/>";						
			$mess.="<strong>Thanks & Regards</strong>"."<br/>";
			$mess.="<strong>".anchor(base_url(),$this->CI->config->item('site_name'))."</strong>";
			$mess.="<br/><br/><br/><br/></div></div>";	
			//echo $mess;exit;		
			$this->CI->email->message($mess);			
			@$this->CI->email->send();		
			//echo $this->CI->email->print_debugger();
		}


}
// END Form Email mailer  Class
/* End of file Dmailer.php */
/* Location: ./application/libraries/Dmailer.php */