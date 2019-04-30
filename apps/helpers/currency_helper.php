<?php

if ( ! function_exists('site_currency'))

{

	function site_currency()

	{

		$CI = CI();

		

		$res=$CI->db->query("SELECT * FROM tbl_currencies WHERE status='1' AND is_default ='Y' ")->result();

		

		if( is_array($res) )

		{

			return $res;

		}

	}



}



if ( ! function_exists('convert_currency'))

{

	function convert_currency($curid='')

	{

		

		$CI = CI();			

		if($curid!="" && $curid > 0 )

		{

			$res=$CI->db->query("SELECT * FROM tbl_currencies WHERE currency_id='$curid' AND status='1' ")->row();			

			if( is_object($res) )

			{

				$CI->session->set_userdata(array('currency_id'=>$res->currency_id));

				$CI->session->set_userdata(array('currency_code'=>$res->code));

				$CI->session->set_userdata(array('symbol_left'=>$res->symbol_left));

				$CI->session->set_userdata(array('symbol_right'=>$res->symbol_right));

				$CI->session->set_userdata(array('currency_value'=>$res->value));

			}

		}else{			

			$res=$CI->db->query("SELECT * FROM tbl_currencies WHERE is_default='Y' AND status='1' ")->row();

			if( is_object($res) )

			{

				$CI->session->set_userdata(array('currency_id'=>$res->currency_id));

				$CI->session->set_userdata(array('currency_code'=>$res->code));

				$CI->session->set_userdata(array('symbol_left'=>$res->symbol_left));

				$CI->session->set_userdata(array('symbol_right'=>$res->symbol_right));

				$CI->session->set_userdata(array('currency_value'=>$res->value));

			}

			

		}

	}

}





if ( ! function_exists('display_price'))

{

	function display_price($price)

	{

		$CI = CI();	

		if($price!="")

		{

			$res=$CI->db->query("SELECT * FROM tbl_currencies WHERE is_default='Y' AND status='1' ")->row();
              
			 
			

			if( is_object($res) )

			{

				$currency_id   =  $CI->session->userdata('currency_id');

				$code          =  $CI->session->userdata('currency_code');

				$symbol_left   =  $CI->session->userdata('symbol_left');

				$symbol_right  =  $CI->session->userdata('symbol_right');

				$value         =  $CI->session->userdata('currency_value');
				
				//$symbol_left="";
				//$symbol_right="";

				if( $currency_id!="" && $value!="")

				{

					$new_price    = ( $price*$value );

					

					$final_price = $res->symbol_left.number_format($price,2);

					

				

				}else

				{

					$CI->session->set_userdata(array('currency_id'=>$res->currency_id));

					$CI->session->set_userdata(array('currency_code'=>$res->code));

					$CI->session->set_userdata(array('symbol_left'=>$res->symbol_left));

					$CI->session->set_userdata(array('symbol_right'=>$res->symbol_right));

					$CI->session->set_userdata(array('currency_value'=>$res->value));

					

				 $final_price = $res->symbol_left.number_format($price,2);


				}

				

				

			}

			return $final_price;

		}

	}

}



if ( ! function_exists('display_price_backup'))

{

	function display_price_backup($price,$showsymbol=TRUE)

	{

		$CI = CI();

		$currency_symbol=$CI->config->item('currency_symbol');

		$final_price='';

		

		$price = ($price!='')?$price:'0';

		

		if($price!='')

		{

			if($showsymbol)

			{

				$final_price=$currency_symbol.number_format($price,2);

			}

			else

			{

				$final_price=number_format($price,2);

			}

		}

			

		return $final_price;

	}

}