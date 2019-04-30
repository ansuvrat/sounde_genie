<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
class MY_Exceptions extends CI_Exceptions
{
		
		public function __construct()
    {
			parent::__construct();
			log_message('debug', 'MY_Exceptions Class Initialized');
    }
		
		public function show_404($page = '', $log_error = TRUE)
		{
			$this->config =& get_config();
      $base_url = $this->config['base_url'];
			$error_uri=$this->config['url_404'];
			
			$PHPSESSID=session_id();
			$strCookie = 'PHPSESSID=' . $PHPSESSID . '; path=/';
			
			// Close current session
			session_write_close();

			// create new cURL resource
			$ch = curl_init();
			
			// set URL and other options
			curl_setopt($ch, CURLOPT_URL, $base_url . $error_uri);
			curl_setopt($ch, CURLOPT_HEADER, 0); // note: the 404 header is already set in the error controller
			curl_setopt( $ch, CURLOPT_COOKIE, $strCookie );
			
			// pass URL to the browser
			curl_exec($ch);
			
			// close cURL resource, and free up system resources
			curl_close($ch);
			
		}
		
}