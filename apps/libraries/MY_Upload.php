<?php
/**
* CI-CMS Upload class overwrite
* This file is part of CI-CMS
* @package   CI-CMS
* @copyright 2008 Hery.serasera.org
* @license   http://www.gnu.org/licenses/gpl.html
* @version   $Id$
*/

if (!defined('BASEPATH'))
{

	exit('No direct script access allowed');
}


class MY_Upload extends CI_Upload
{

	public  function __construct()
	{
		parent::__construct();
		$this->CI =& get_instance();
	}

	protected function _prep_filename($filename)
	{
		if ($this->mod_mime_fix === FALSE OR $this->allowed_types === '*' OR ($ext_pos = strrpos($filename, '.')) === FALSE)
		{
			return $filename;
		}

		$ext = substr($filename, $ext_pos);
		$filename = substr($filename, 0, $ext_pos);
		//return str_replace('.', '_', $filename).$ext;
		return url_title(strtolower($filename)).$ext;
	}

	function my_upload($filed,$path)
	{
		$CI =$this->CI;

		$allowed_size		=	$CI->config->item('allow.file.size');
		$allowed_width	=	$CI->config->item('allow.image.width');
		$allowed_height	=	$CI->config->item('allow.image.height');


		$CI->load->library('upload');
		$config['upload_path'] = UPLOAD_DIR.'/'.$path.'/';
		$config['allowed_types'] = file_ext($_FILES[$filed]['name']);
		$config['max_size']  = $allowed_size;
		$config['max_width']  = $allowed_width;
		$config['max_height']  = $allowed_height;
		$config['remove_spaces'] = TRUE;

		$CI->upload->initialize($config);
		if ( ! $CI->upload->do_upload($filed))
		{
			$error = array('error' =>$CI->upload->display_errors());
			//return $error;
		}
		else
		{
			$data = array('upload_data' => $CI->upload->data());
			return $data;

		}
	}


}


?>