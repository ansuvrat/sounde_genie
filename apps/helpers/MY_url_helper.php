<?php if (!defined('BASEPATH')) exit('No direct script access allowed.');

/**
 * CodeIgniter URL Helpers
 *
 * @package		CodeIgniter
 * @subpackage	Helpers
 * @category	Helpers
 * @author		Philip Sturgeon
 */

// ------------------------------------------------------------------------

/**
 * Create URL Title - modified version
 *
 * Takes a "title" string as input and creates a
 * human-friendly URL string with either a dash
 * or an underscore as the word separator.
 * 
 * Added support for Cyrillic characters.
 *
 * @access	public
 * @param	string	the string
 * @param	string	the separator: dash, or underscore
 * @return	string
 */
if ( ! function_exists('url_title'))
{
	function url_title($str, $separator = 'dash', $lowercase = TRUE)
    {
        $CI =& get_instance();
        
        $foreign_characters = array(
            '/ä|æ|ǽ/' => 'ae',
            '/ö|œ/' => 'oe',
            '/ü/' => 'ue',
            '/Ä/' => 'Ae',
            '/Ü/' => 'Ue',
            '/Ö/' => 'Oe',
            '/À|Á|Â|Ã|Ä|Å|Ǻ|Ā|Ă|Ą|Ǎ|А/' => 'A',
            '/à|á|â|ã|å|ǻ|ā|ă|ą|ǎ|ª|а/' => 'a',
            '/Б/' => 'B',
            '/б/' => 'b',
            '/Ç|Ć|Ĉ|Ċ|Č|Ц/' => 'C',
            '/ç|ć|ĉ|ċ|č|ц/' => 'c',
            '/Ð|Ď|Đ|Д/' => 'D',
            '/ð|ď|đ|д/' => 'd',
            '/È|É|Ê|Ë|Ē|Ĕ|Ė|Ę|Ě|Е|Ё|Э/' => 'E',
            '/è|é|ê|ë|ē|ĕ|ė|ę|ě|е|ё|э/' => 'e',
            '/Ф/' => 'F',
            '/ф/' => 'f',
            '/Ĝ|Ğ|Ġ|Ģ|Г/' => 'G',
            '/ĝ|ğ|ġ|ģ|г/' => 'g',
            '/Ĥ|Ħ|Х/' => 'H',
            '/ĥ|ħ|х/' => 'h',
            '/Ì|Í|Î|Ï|Ĩ|Ī|Ĭ|Ǐ|Į|İ|И/' => 'I',
            '/ì|í|î|ï|ĩ|ī|ĭ|ǐ|į|ı|и/' => 'i',
            '/Ĵ|Й/' => 'J',
            '/ĵ|й/' => 'j',
            '/Ķ|К/' => 'K',
            '/ķ|к/' => 'k',
            '/Ĺ|Ļ|Ľ|Ŀ|Ł|Л/' => 'L',
            '/ĺ|ļ|ľ|ŀ|ł|л/' => 'l',
            '/М/' => 'M',
            '/м/' => 'm',
            '/Ñ|Ń|Ņ|Ň|Н/' => 'N',
            '/ñ|ń|ņ|ň|ŉ|н/' => 'n',
            '/Ò|Ó|Ô|Õ|Ō|Ŏ|Ǒ|Ő|Ơ|Ø|Ǿ|О/' => 'O',
            '/ò|ó|ô|õ|ō|ŏ|ǒ|ő|ơ|ø|ǿ|º|о/' => 'o',
            '/П/' => 'P',
            '/п/' => 'p',
            '/Ŕ|Ŗ|Ř|Р/' => 'R',
            '/ŕ|ŗ|ř|р/' => 'r',
            '/Ś|Ŝ|Ş|Š|С/' => 'S',
            '/ś|ŝ|ş|š|ſ|с/' => 's',
            '/Ţ|Ť|Ŧ|Т/' => 'T',
            '/ţ|ť|ŧ|т/' => 't',
            '/Ù|Ú|Û|Ũ|Ū|Ŭ|Ů|Ű|Ų|Ư|Ǔ|Ǖ|Ǘ|Ǚ|Ǜ|У/' => 'U',
            '/ù|ú|û|ũ|ū|ŭ|ů|ű|ų|ư|ǔ|ǖ|ǘ|ǚ|ǜ|у/' => 'u',
            '/В/' => 'V',
            '/в/' => 'v',
            '/Ý|Ÿ|Ŷ|Ы/' => 'Y',
            '/ý|ÿ|ŷ|ы/' => 'y',
            '/Ŵ/' => 'W',
            '/ŵ/' => 'w',
            '/Ź|Ż|Ž|З/' => 'Z',
            '/ź|ż|ž|з/' => 'z',
            '/Æ|Ǽ/' => 'AE',
            '/ß/'=> 'ss',
            '/Ĳ/' => 'IJ',
            '/ĳ/' => 'ij',
            '/Œ/' => 'OE',
            '/ƒ/' => 'f',
            '/Ч/' => 'Ch',
            '/ч/' => 'ch',
            '/Ю/' => 'Ju',
            '/ю/' => 'ju',
            '/Я/' => 'Ja',
            '/я/' => 'ja',
            '/Ш/' => 'Sh',
            '/ш/' => 'sh',
            '/Щ/' => 'Shch',
            '/щ/' => 'shch',
            '/Ж/' => 'Zh',
            '/ж/' => 'zh',
        );

        $str = preg_replace(array_keys($foreign_characters), array_values($foreign_characters), $str);
        
        $replace = ($separator == 'dash') ? '-' : '_';
        
        $trans = array(
            '&\#\d+?;'                => '',
            '&\S+?;'                => '',
            '\s+'                    => $replace,
            '[^a-z0-9\-\._]' => '',
            $replace.'+'            => $replace,
            $replace.'$'            => $replace,
            '^'.$replace            => $replace,
            '\.+$'                    => ''
        );

        $str = strip_tags($str);

        foreach ($trans as $key => $val)
        {
            $str = preg_replace("#".$key."#i", $val, $str);
        }
        
        if ($lowercase === TRUE)
        {
            if( function_exists('mb_convert_case') )
            {
                $str = mb_convert_case($str, MB_CASE_LOWER, "UTF-8");
            }
            else
            {
                $str = strtolower($str);
            }
        }

        $str = preg_replace('#[^'.$CI->config->item('permitted_uri_chars').']#i', '', $str);        
        return trim(stripslashes($str));
     }
}


 function switch_account($type,$action='',$product_id='')
 {
	 $redirect='seller';
	 if($action=='add')
	 {
		 $redirect='seller/catalog/add';
	 }
	 elseif($action=='edit' && $product_id>0)
	 {
		 $redirect='seller/catalog/edit/'.$product_id;
	 }
	 elseif($action=='coupon_add')
	 {
		 $redirect='seller/add_coupon/';
	 }
	 
	 switch ($type )
	 {
		 case 1:
				redirect($redirect, '');
				break;
			
		 default:
			
       redirect('buyer', '');
			
	}
			  
 }	


// ------------------------------------------------------------------------


/**
 * Theme URL
 *
 * Returns the Ionize current theme URL
 *
 * @access	public
 * @return	string
 */
 
if ( ! function_exists('resource_url'))
{
	function resource_url()
	{
		return base_url()."assets/designer/resources/";
	}
}

if ( ! function_exists('developers_url'))
{
	function developers_url()
	{
		return base_url()."assets/developers/";
	}
}

 
if ( ! function_exists('theme_url'))
{
	function theme_url()
	{
		return base_url()."assets/designer/themes/default/";
	}
}

if ( ! function_exists('img_url'))
{
	function img_url()
	{
		return base_url()."uploaded_files/";
	}
}

if ( ! function_exists('thumb_cache_url'))
{
	function thumb_cache_url()
	{
		return base_url()."uploaded_files/thumb_cache/";
	}
	
}