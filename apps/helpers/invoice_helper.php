<?php if(!defined('BASEPATH')) exit('No direct script access allowed');


if ( ! function_exists('CI')){

	function CI(){
		if (!function_exists('get_instance')) return FALSE;
		$CI =& get_instance();
		return $CI;
	}
}


if( ! function_exists('get_invoice_total_for_seller')){

	function get_invoice_total_for_seller($order_no,$seller_id)

	{

		$CI =& get_instance();

		$orderres			= get_invoice_detail($order_no,$seller_id);

		$subtotal=0;

		foreach($orderres as $val_top)

		{

			$total_top=$val_top['discount_price']*$val_top['product_qty'];

			$subtotal +=$total_top+$val_top['product_ship_charge'];

		}

		return $subtotal;

	}

}



if( ! function_exists('get_invoice_total_codcharge_for_seller'))

{

	function get_invoice_total_codcharge_for_seller($order_no,$seller_id)

	{

		$CI =& get_instance();

		$orderres			= get_invoice_detail($order_no,$seller_id);

		$subtotal=0;

		foreach($orderres as $val_top)

		{

			$total_top=$val_top['product_cod_charge'];

			$subtotal +=$total_top;

		}

		return $subtotal;

	}

}



if( ! function_exists('get_invoice'))

{

	function get_invoice($order_no,$seller_id='',$msg='',$print='yes')

	{

		$CI =& get_instance();

		$admin_dtl  	= $CI->admin_info;

		

		$orderres			= get_invoice_detail($order_no,$seller_id);

				

		

		$odtl=get_db_single_row("tbl_orders","*",array("order_id"=>$order_no));

		ob_start();

		invoice_content($odtl,$orderres,'false',$seller_id);

		$mess=ob_get_contents();

		ob_clean();		

		return $mess;

	}

}





if(! function_exists('get_invoice_for_currier') )

{

	function get_invoice_for_currier($order_no,$seller_id,$msg='',$print='yes')

	{

		$CI =& get_instance();

		$admin_dtl  	= $CI->admin_info;

		

		$orderres			= get_invoice_detail($order_no,$seller_id);

		

		$odtl=get_db_single_row("tbl_orders","*",array("order_id"=>$order_no));

		

		$subtotal_top=0;

		$total_shipping_top=0;

		$total_coupon_discount_top=0;

		$total_cod_charge_top=0;

		foreach($orderres as $val_top)

		{

			$total_top=$val_top['discount_price']*$val_top['product_qty'];

			$subtotal_top +=$total_top;

			$total_shipping_top +=$val_top['product_ship_charge'];

			$total_coupon_discount_top +=$val_top['total_coupon_discount'];

			$total_cod_charge_top +=$val_top['product_cod_charge'];

		}

		

		$grand_total_top=(($subtotal_top+$total_shipping_top)-$total_coupon_discount_top)+$total_cod_charge_top;

		

		$tship_charge=($total_shipping_top>0)?display_price($total_shipping_top):'Free';

		$tcoupon_dis=($total_coupon_discount_top>0)?display_price($total_coupon_discount_top):'NA';

		

		$ship_phone=($odtl['ship_phone']!='')?$odtl['ship_phone']:'NA';

		

		$sdtl=get_db_single_row("tbl_seller_company_details","company_name, company_display_name, pick_address, pick_landmark, pick_city, pick_state, pick_country, pick_pincode, bill_address, bill_landmark, bill_city, bill_state, bill_country, bill_pincode,communication_email",array("seller_id"=>$seller_id));

		

		$scompname = ($sdtl['company_display_name']!='')?$sdtl['company_display_name']:$sdtl['company_name'];

		$udtl=get_db_single_row("tbl_users","phone,mobile",array("id"=>$seller_id));

		

		$uphone = ($udtl['phone']!='')?$udtl['phone']:'-';

		$var='		

		<!DOCTYPE HTML>

			<html>

			<head>

			<meta charset="utf-8">

			<title>Welcome</title>

			<script type="text/javascript">

				function print_now()

				{

					document.getElementById("print_data").style.display="none";	

					window.print();

				}

			</script>

			</head>

			<body style="font-size:12px; color:#333; margin:0px; padding:5px; font-family:Arial, Helvetica, sans-serif;">

			<div style="height:400px;">

			<div class="mt10">				

				

				<div style="float:left; width:31%;">

        <div><img src="'.theme_url().'images/ebizy2.png" alt="" width="172" height="54"></div>

        <div style="padding-top:15px; margin:0px; color:#333; line-height:18px;"><strong style="color:#ff6600; font-size:16px">Pick up from</strong><br>'.$scompname.'<br>

'.$sdtl['pick_address'].', '.state_name($sdtl['pick_state']).', '.city_name($sdtl['pick_city']).' - '.$sdtl['pick_pincode'].', <strong>'.country_name($sdtl['pick_country']).'</strong><br>('.$sdtl['pick_landmark'].')<br> <span style=" padding-top:3px;">Email Us : <a href="mailto:'.$sdtl['communication_email'].'" style="color:#000; font-weight:bold;">'.$sdtl['communication_email'].'</a></span></div>

        </div>

        

        <div style="float:left; width:30%; color:#000; margin:0 25px;">

        <div style="margin-top:3px; font-size:15px;">Order ID : <strong>'.$odtl['order_id'].'</strong></div>        

        <div style="color:#ff6600; font-size:16px; margin-top:25px; font-weight:bold;">Seller Information</div>

        <div style="font-size:13px;">'.$scompname.'<br>Phone : '.$uphone.' <br>Mobile : '.$udtl['mobile'].' <br>'.$sdtl['bill_address'].', '.state_name($sdtl['bill_state']).', '.city_name($sdtl['bill_city']).', '.$sdtl['bill_pincode'].'<br>('.$sdtl['bill_landmark'].')</div>

        </div>

        

        <div style="float:left; width:30%; color:#000;">

        <div style="margin-top:3px; font-size:15px;">Order Date : '.getDateFormat($odtl['order_date'],1).'</div>

        <div style="color:#ff6600; font-size:16px; margin-top:25px; font-weight:bold;">Buyer Information</div>

        <div style="font-size:13px;">'.$odtl['ship_name'].'<br>Phone : '.$ship_phone.' <br>Mobile : '.$odtl['ship_mobile'].' <br>'.$odtl['ship_address'].', '.state_name($odtl['ship_state']).', '.city_name($odtl['ship_city']).', '.$odtl['ship_pin_code'].'<br>('.$odtl['ship_landmark'].')</div>

        </div>	

				

				

				<div style="clear:both"></div>

				

				<div style="font:normal 14px/20px Arial, Helvetica, sans-serif; color:#000; text-transform:uppercase; margin-top:20px">Product Details</div>

				<table width="100%" border="0" align="center" cellpadding="4" cellspacing="1" style="margin-top:2px;">

					<tr style="font-size:13px; color:#222; line-height:36px; background:#eee">

						<td width="10%" align="center" style="line-height:20px; width:10%"><strong>S.No</strong></td>

						<td align="left" colspan="2"><strong>Products</strong></td>

						<td width="10%" align="center" style="width:10%"><strong>Amount</strong></td>

					</tr>

					<tr align="center">

						<td colspan="4" valign="top" ><img src="'.theme_url().'images/spacer.gif" width="1" height="1" alt=""></td>

					</tr>';

					$sl=0;

					$subtotal=0;

					$total_shipping=0;

					$total_coupon_discount=0;

					foreach($orderres as $val)

					{

						

						$sl++;

						$gallery_image=get_title_by_id("tbl_products_gallery","product_image",array("product_id"=>$val['product_id'],"product_image !"=>''));

						

						$pdtl=get_db_single_row("tbl_products","*",array("id"=>$val['product_id']));

						$brand_id=$pdtl['brand'];

						$brand_name	='NA';

						$color_name	='NA';

						$size_name	='NA';

						if($brand_id>0)

						{

							$brand_name=get_title_by_id("tbl_brands","brand_name",array("id"=>$brand_id));

						}

						if($val['product_color']>0)

						{

							$color_name=get_title_by_id("tbl_cat_attr_value","cat_attr_value",array("id"=>$val['product_color']));

						}

						if($val['product_size']>0)

						{

							$size_name=get_title_by_id("tbl_cat_attr_value","cat_attr_value",array("id"=>$val['product_size']));

						}

						$shipping_charge = ($val['product_ship_charge']>0)?display_price($val['product_ship_charge']):'Free';

						$total=$val['discount_price']*$val['product_qty'];

						$subtotal +=$total;

						$total_shipping +=$val['product_ship_charge'];

						$total_coupon_discount +=$val['total_coupon_discount'];

						$var .='

						<tr>

							<td align="center" valign="top" style="border-bottom:1px solid #ddd; padding-bottom:10px;">'.$sl.'.</td>

							<td align="left" valign="top" style="border-bottom:1px solid #ddd; padding-bottom:10px;"><img src="'.get_image("product_images",$gallery_image,72,72,'R').'" alt="" width="72" height="72" style="margin-right:10px; padding:5px"></td>

							<td align="left" valign="top" style="border-bottom:1px solid #ddd; padding-bottom:10px;"><p style="color:#333; font-size:13px; padding-top:5px; margin:0px; line-height:18px"> <span style="font-size:16px;">'.$pdtl['product_name'].'</span> <span style="font-size:11px; display:block; padding-top:8px; font-family:Verdana, Geneva, sans-serif">Product Code : '.$pdtl['product_code'].' / Brand : '.$brand_name.' / Size : '.$size_name.' / Color : '.$color_name.'<br>

									Unit Price: <del style="color:red;">'.display_price($val['product_price']).'</del> <b>'.display_price($val['discount_price']).'</b> / Qty. : '.$val['product_qty'].'<br>

									Shipping Charge : '.$shipping_charge;

									if($seller_id<1)

									{

										 $comp_dtl=get_db_single_row("tbl_seller_company_details","company_name,company_display_name",array("seller_id"=>$val['seller_id']));

										 $comp_display_name = ($comp_dtl['company_display_name']!='')?$comp_dtl['company_display_name']:$comp_dtl['company_name'];

										 $seller_dtl_link=get_links($val['seller_id'],"company_details");	

										 $var .='<br>Seller : <a target="_blank" style="color:black; text-decoration:underline;" href="'.$seller_dtl_link.'">'.$comp_display_name.'</a>';

				

									}

									$var .='</span></p></td>

							<td align="center" valign="top" style="width:10%; border-bottom:1px solid #ddd; padding-bottom:10px;"><strong>'.display_price($total).'</strong></td>

						</tr>

						<tr>

							<td colspan="4" align="center" valign="top">&nbsp;</td>

						</tr>';

					}

					$avail_credit_points_value=0;

					if($odtl['avail_credit_points_value']>0 && $seller_id<1)

					{

						$avail_credit_points_value=$odtl['avail_credit_points_value'];

					}

					$grand_total=($subtotal+$total_shipping)-($total_coupon_discount+$avail_credit_points_value);

					$var .='

					<tr align="center">

						<td colspan="4" valign="top" ><img src="'.theme_url().'images/spacer.gif" width="1" height="1" alt=""></td>

					</tr>

				</table>

			</div>

			<div style="clear:both;"></div>

			<div style="float:left" id="print_data">';

			if($print!=''){

			$var .='

			<a href="javascript:void(0);" onclick="print_now();" style="color:#f00; text-decoration:none; float:left; font:bold 13px/22px Arial, Helvetica, sans-serif; text-transform:uppercase; margin:0px 10px 0 0"><img src="'.theme_url().'images/prnt.png" border="0" style="float:left; margin-right:3px" alt=""> Print Invoice</a>';

			}

			

			$tot_ship_price=($total_shipping>0)?display_price($total_shipping):'Free';

			$var .='

			</div>

			<div style="clear:both;"></div>

			<div style="float:right; text-align:right; font:bold 14px/18px Arial, Helvetica, sans-serif; color:#333;">Sub Total : '.display_price($subtotal).'</div>

			<div style="clear:both;"></div>

			<div style="float:right; text-align:right; font:bold 14px/18px Arial, Helvetica, sans-serif; color:#333;">Shipping Charge : '.$tot_ship_price.'</div>';

			if($total_coupon_discount>0)

			{

			$var .='

			<div style="clear:both;"></div>

			<div style="float:right; text-align:right; font:bold 14px/18px Arial, Helvetica, sans-serif; color:#333;">Coupon Discount : '.display_price($total_coupon_discount).'</div>';

			}

			if($avail_credit_points_value>0)

			{

			$var .='

			<div style="clear:both;"></div>

			<div style="float:right; text-align:right; font:bold 14px/18px Arial, Helvetica, sans-serif; color:#333;">Points Redeemed Discount : '.display_price($avail_credit_points_value).'</div>';

			}

			if($total_cod_charge_top>0)

			{

			$var .='

			<div style="clear:both;"></div>

			<div style="float:right; text-align:right; font:bold 14px/18px Arial, Helvetica, sans-serif; color:#333;">COD Charge : '.display_price($total_cod_charge_top).'</div>';

			}

			

			

			

			$var .='

			<div style="clear:both;"></div>

			<div style="float:right; text-align:right; font:bold 14px/18px Arial, Helvetica, sans-serif; color:#333;">Estimated Total : '.display_price($grand_total+$total_cod_charge_top).'</div>

			<div style="clear:both"></div>

			</div>

			</body>

			</html>

		

		';

		

		return $var;

		

	}

}



if( ! function_exists('get_invoice_for_awb_for_buyer'))

{

	function get_invoice_for_awb_for_buyer($order_no,$seller_id='',$msg='',$print='yes')

	{

		$CI =& get_instance();

		$admin_dtl  	= $CI->admin_info;

		

		$orderres			= get_invoice_detail($order_no,$seller_id);

		

		$odtl=get_db_single_row("tbl_orders","*",array("order_id"=>$order_no));

		

		$subtotal_top=0;

		$total_shipping_top=0;

		$total_coupon_discount_top=0;

		$total_cod_charge_top=0;

		foreach($orderres as $val_top)

		{

			$total_top=$val_top['discount_price']*$val_top['product_qty'];

			$subtotal_top +=$total_top;

			$total_shipping_top +=$val_top['product_ship_charge'];

			$total_coupon_discount_top +=$val_top['total_coupon_discount'];

			$total_cod_charge_top +=$val_top['product_cod_charge'];

		}

		

		$grand_total_top=(($subtotal_top+$total_shipping_top)-$total_coupon_discount_top)+$total_cod_charge_top;

		

		$tship_charge=($total_shipping_top>0)?display_price($total_shipping_top):'Free';

		$tcoupon_dis=($total_coupon_discount_top>0)?display_price($total_coupon_discount_top):'NA';

		

		$ship_phone=($odtl['ship_phone']!='')?$odtl['ship_phone']:'NA';

		

		$currierDtl=get_db_single_row("tbl_assign_courrier_company_to_order_delivery","*",array("seller_id"=>$seller_id,"order_id"=>$order_no));

		//trace($currierDtl);

		$var='		

		<!DOCTYPE HTML>

			<html>

			<head>

			<meta charset="utf-8">

			<title>Welcome</title>

			<script type="text/javascript">

				function print_now()

				{

					document.getElementById("print_data").style.display="none";	

					window.print();

				}

			</script>

			</head>

			<body style="font-size:12px; color:#333; margin:0px; padding:5px; font-family:Arial, Helvetica, sans-serif;">

			<div style="height:400px;">

			<div class="mt10">				<div>

        <div style="float:left;"><img src="'.theme_url().'images/ebizy2.png" alt="" width="172" height="54"></div>

        

        <div style="clear:both;"></div>

        </div>

        

        <div style="padding:20px 0 30px 0; border-bottom:#ddd 1px solid; margin:0px; color:#333; line-height:18px;"><strong style="color:#ff6600; font-size:16px">Address</strong><br>

'.$admin_dtl->address.', '.$admin_dtl->city.' - '.$admin_dtl->post_code.', <strong>'.$admin_dtl->country.'</strong><br> <span style=" padding-top:3px;">Email Us : <a href="mailto:'.$admin_dtl->email.'" style="color:#000; font-weight:bold;">'.$admin_dtl->email.'</a></span></div>



  		<div style="margin-top:30px; color:#000; padding-bottom:20px;">

        <div style="font-size:15px;"><strong>Courier Name:</strong> '.$currierDtl['courrier_comp_name'].'</div>

        <div style="font-size:15px; margin-top:5px;"><strong>Courier AWB No.:</strong> '.$currierDtl['tracking_no'].'</div>

				<div style="font-size:15px; margin-top:5px;"><strong>URL.:</strong> '.$currierDtl['courrier_comp_url'].'</div>

        <div style="font-size:15px; margin-top:5px;"><strong>Phone No.:</strong> '.$currierDtl['courrier_comp_phone'].'</div>

				<div style="font-size:15px; margin-top:5px;"><strong>Mobile No.:</strong> '.$currierDtl['courrier_comp_mobile'].'</div>

					<div style="font-size:15px; margin-top:5px;"><strong>Email Id:</strong> '.$currierDtl['courrier_comp_email'].'</div>

				<div style="font-size:15px; margin-top:5px;"><strong>Address:</strong> '.$currierDtl['courrier_com_address'].'</div>

        <div style="font-size:15px; margin-top:15px; float:left; width:48%;"><strong>Invoice NO.:</strong> '.$odtl['order_id'].'</div>

        <div style="font-size:15px; margin-top:15px; float:left;"><strong>Invoice Date:</strong> '.getDateFormat($odtl['order_date'],1).'</div>

        <div style="clear:both;"></div>

        </div>			

			

			

				

				<div style="clear:both"></div>

				

				<div style="font:normal 14px/20px Arial, Helvetica, sans-serif; color:#000; text-transform:uppercase; margin-top:20px">Product Details</div>

				<table width="100%" border="0" align="center" cellpadding="4" cellspacing="1" style="margin-top:2px;">

					<tr style="font-size:13px; color:#222; line-height:36px; background:#eee">

						<td width="10%" align="center" style="line-height:20px; width:10%"><strong>S.No</strong></td>

						<td align="left" colspan="2"><strong>Products</strong></td>

						<td width="10%" align="center" style="width:10%"><strong>Amount</strong></td>

					</tr>

					<tr align="center">

						<td colspan="4" valign="top" ><img src="'.theme_url().'images/spacer.gif" width="1" height="1" alt=""></td>

					</tr>';

					$sl=0;

					$subtotal=0;

					$total_shipping=0;

					$total_coupon_discount=0;

					foreach($orderres as $val)

					{

						

						$sl++;

						$gallery_image=get_title_by_id("tbl_products_gallery","product_image",array("product_id"=>$val['product_id'],"product_image !"=>''));

						

						$pdtl=get_db_single_row("tbl_products","*",array("id"=>$val['product_id']));

						$brand_id=$pdtl['brand'];

						$brand_name	='NA';

						$color_name	='NA';

						$size_name	='NA';

						

						$shipping_charge = ($val['product_ship_charge']>0)?display_price($val['product_ship_charge']):'Free';

						$total=$val['discount_price']*$val['product_qty'];

						$subtotal +=$total;

						$total_shipping +=$val['product_ship_charge'];

						$total_coupon_discount +=$val['total_coupon_discount'];

						$var .='

						<tr>

							<td align="center" valign="top" style="border-bottom:1px solid #ddd; padding-bottom:10px;">'.$sl.'.</td>

							<td align="left" valign="top" style="border-bottom:1px solid #ddd; padding-bottom:10px;"><img src="'.get_image("product_images",$gallery_image,72,72,'R').'" alt="" width="72" height="72" style="margin-right:10px; padding:5px"></td>

							<td align="left" valign="top" style="border-bottom:1px solid #ddd; padding-bottom:10px;"><p style="color:#333; font-size:13px; padding-top:5px; margin:0px; line-height:18px"> <span style="font-size:16px;">'.$pdtl['product_name'].'</span> <span style="font-size:11px; display:block; padding-top:8px; font-family:Verdana, Geneva, sans-serif">Product Code : '.$pdtl['product_code'].' / Brand : '.$brand_name.' / Size : '.$size_name.' / Color : '.$color_name.'<br>

									Unit Price: <del style="color:red;">'.display_price($val['product_price']).'</del> <b>'.display_price($val['discount_price']).'</b> / Qty. : '.$val['product_qty'].'<br>

									Shipping Charge : '.$shipping_charge;

									if($seller_id<1)

									{

										 $comp_dtl=get_db_single_row("tbl_users","name,store_name",array("id"=>$val['seller_id']));										

										 $var .='<br>Seller : <a target="_blank" style="color:black; text-decoration:underline;" href="'.$seller_dtl_link.'">'.($comp_dtl['store_name']?$comp_dtl['store_name']:$comp_dtl['name']).'</a>';

				

									}

									$var .='</span></p></td>

							<td align="center" valign="top" style="width:10%; border-bottom:1px solid #ddd; padding-bottom:10px;"><strong>'.display_price($total).'</strong></td>

						</tr>

						<tr>

							<td colspan="4" align="center" valign="top">&nbsp;</td>

						</tr>';

					}

					

					$grand_total=($subtotal+$total_shipping)-($total_coupon_discount);

					$var .='

					<tr align="center">

						<td colspan="4" valign="top" ><img src="'.theme_url().'images/spacer.gif" width="1" height="1" alt=""></td>

					</tr>

				</table>

			</div>

			<div style="clear:both;"></div>

			<div style="float:left" id="print_data">';

			if($print!=''){

			$var .='

			<a href="javascript:void(0);" onclick="print_now();" style="color:#f00; text-decoration:none; float:left; font:bold 13px/22px Arial, Helvetica, sans-serif; text-transform:uppercase; margin:0px 10px 0 0"><img src="'.theme_url().'images/prnt.png" border="0" style="float:left; margin-right:3px" alt=""> Print Invoice</a>';

			}

			

			$tot_ship_price=($total_shipping>0)?display_price($total_shipping):'Free';

			$var .='

			</div>

			<div style="clear:both;"></div>

			<div style="float:right; text-align:right; font:bold 14px/18px Arial, Helvetica, sans-serif; color:#333;">Sub Total : '.display_price($subtotal).'</div>

			<div style="clear:both;"></div>

			<div style="float:right; text-align:right; font:bold 14px/18px Arial, Helvetica, sans-serif; color:#333;">Shipping Charge : '.$tot_ship_price.'</div>';

			if($total_coupon_discount>0)

			{

			$var .='

			<div style="clear:both;"></div>

			<div style="float:right; text-align:right; font:bold 14px/18px Arial, Helvetica, sans-serif; color:#333;">Coupon Discount : '.display_price($total_coupon_discount).'</div>';

			}			

			if($total_cod_charge_top>0)

			{

			$var .='

			<div style="clear:both;"></div>

			<div style="float:right; text-align:right; font:bold 14px/18px Arial, Helvetica, sans-serif; color:#333;">COD Charge : '.display_price($total_cod_charge_top).'</div>';

			}

			

			

			

			$var .='

			<div style="clear:both;"></div>

			<div style="float:right; text-align:right; font:bold 14px/18px Arial, Helvetica, sans-serif; color:#333;">Estimated Total : '.display_price($grand_total+$total_cod_charge_top).'</div>

			<div style="clear:both"></div>

			</div>

			</body>

			</html>

		

		';

		

		return $var;

	}

}



if(! function_exists('get_invoice_detail') )

{

	function get_invoice_detail($order_no,$seller_id='')

	{

		$CI =& get_instance();

		

		$CI->db->select('o.*,od.*,u.name,p.product_name,p.product_code');	

		$CI->db->from('tbl_orders as o');

		$CI->db->join('tbl_order_details as od','o.order_id=od.order_id');

		$CI->db->join('tbl_users as u','od.seller_id=u.id','LEFT');

		$CI->db->join('tbl_products as p','od.product_id=p.products_id');

		$CI->db->where('o.order_id',$order_no);

		if($seller_id!='')

		{

			$CI->db->where('od.seller_id',$seller_id);	

		}

		$qry=$CI->db->get();

		if($qry->num_rows() > 0)

		{

			$res=$qry->result_array();

			return $res;	

		}

	}	

}





if(! function_exists('invoice_mail') )

{

	

	function invoice_mail($order_no,$to,$from,$from_name,$subject,$seller_id='')

	{

		$CI =& get_instance();

		$CI->load->library(array('Dmailer'));

		/***** Send Invoice mail */

		

		ob_start();

		$body         = get_invoice($order_no,$seller_id);

		$msg          = $body;

		

		//echo $msg;exit;

		$mail_conf =  array(

												'subject'=>$subject,

												'to_email'=>$to,

												'from_email'=>$from,

												'from_name'=> $from_name,

												'body_part'=>$msg

											 );							

		$CI->dmailer->mail_notify($mail_conf);			

		ob_end_clean();

		/******* End Invoice  mail */	

	}	

}



if(! function_exists('invoice_mail_to_seller') )

{

	function invoice_mail_to_seller($order_no)

	{

		$CI =& get_instance();	

		$CI->db->select('seller_id');

		$CI->db->where('order_id',$order_no);

		$CI->db->group_by('seller_id');

		$qry=$CI->db->get('tbl_order_details');

		if($qry->num_rows() > 0)

		{

			$res=$qry->result_array(); 

			

		

			if(is_array($res) && count($res) > 0)

			{

				foreach($res as $value)

				{

				   $subject 			="New Order Placed at ".$CI->config->item('site_url');

					   $admin_dtl=$CI->admin_info;	

						$from_name    = $CI->config->item('site_url');
						$to   				= $admin_dtl->email;

						$from      		= $to;

										

					invoice_mail($order_no,$to,$from,$from_name,$subject,$seller_id);		

				}	

			}

				

		}

	}	

}



if(! function_exists('update_seller_payment_stats') )

{

	function update_seller_payment_stats($order_no)

	{}	

}





if(! function_exists('reduce_quantity') )

{

	function reduce_quantity($order_no,$product_id='')

	{

		$CI =& get_instance();

		

		$CI->db->select("p.available_qty,p.used_qty,od.product_id,od.product_size,od.product_color,od.product_qty");

		$CI->db->from("tbl_order_details as od");

		$CI->db->join("tbl_products as p","od.product_id=p.id");

		$CI->db->where("od.order_id",$order_no);

		if($product_id!='' && $product_id>0)

		{

			$CI->db->where("od.product_id",$product_id);

		}

		$qry=$CI->db->get();

		if($qry->num_rows() > 0)

		{

			$res=$qry->result_array();

			if(is_array($res) && count($res) > 0)

			{

				foreach($res as $value)

				{

					$used_qty				=$value['used_qty']+$value['product_qty'];

					$available_qty	=$value['available_qty']-$value['product_qty'];

					if($available_qty<0)

					{

						$available_qty=0;	

					}

					

					$data=array(

											'used_qty'			=>$used_qty,

											'available_qty'	=>$available_qty

											);

					$where="id = '".$value['product_id']."'";						

					$CI->db->update("tbl_products",$data,$where);

					

					$CI->db->select('id,avl_qty,used_qty');

					$qrystr="product_id ='".$value['product_id']."'";

					if($value['prod_size']>0)

					{

						$qrystr .=" AND size_id ='".$value['product_size']."'";	

					}

					if($value['prod_color']>0)

					{

						$qrystr .=" AND color_id ='".$value['product_color']."'";	

					}

					$CI->db->where($qrystr);

					$qry1=$CI->db->get('tbl_product_inventory');

					if($qry1->num_rows() > 0)

					{

						$res1=$qry1->row();

						$avl_qty=$res1->avl_qty-$value['product_qty'];

						$used_qty=$res1->used_qty+$value['product_qty'];		

						if($avl_qty<0)

						{

							$avl_qty=0;

						}

						$CI->db->update('tbl_product_inventory',array("avl_qty"=>$avl_qty,"used_qty"=>$used_qty),"id ='".$res1->id."'");

					}

					

				}

			}		

		}

		

	}	

}



if(! function_exists('recover_quantity') )

{

	function recover_quantity($order_no,$product_id='')

	{

		$CI =& get_instance();

		

		$CI->db->select("p.available_qty,p.used_qty,od.product_id,od.product_size,od.product_color,od.product_qty");

		$CI->db->from("tbl_order_details as od");

		$CI->db->join("tbl_products as p","od.product_id=p.id");

		$CI->db->where("od.order_id",$order_no);

		if($product_id!='' && $product_id>0)

		{

			$CI->db->where("od.product_id",$product_id);

		}

		$qry=$CI->db->get();

		if($qry->num_rows() > 0)

		{

			$res=$qry->result_array();

			if(is_array($res) && count($res) > 0)

			{

				foreach($res as $value)

				{

					$used_qty				=$value['used_qty']-$value['product_qty'];

					$available_qty	=$value['available_qty']+$value['product_qty'];

					if($available_qty<0)

					{

						$available_qty=0;	

					}

					

					$data=array(

											'used_qty'				=>$used_qty,

											'available_qty'	=>$available_qty

											);

					$where="id = '".$value['product_id']."'";						

					$CI->db->update("tbl_products",$data,$where);

					

					$CI->db->select('id,avl_qty,used_qty');

					$qrystr="product_id ='".$value['product_id']."'";

					if($value['product_size']>0)

					{

						$qrystr .=" AND size_id ='".$value['product_size']."'";	

					}

					if($value['product_color']>0)

					{

						$qrystr .=" AND color_id ='".$value['product_color']."'";	

					}

					$CI->db->where($qrystr);

					$qry1=$CI->db->get('tbl_product_inventory');

					if($qry1->num_rows() > 0)

					{

						$res1=$qry1->row();

						$avl_qty=$res1->avl_qty+$value['product_qty'];

						$used_qty=$res1->used_qty-$value['product_qty'];		

						if($avl_qty<0)

						{

							$avl_qty=0;

						}

						$CI->db->update('tbl_product_inventory',array("avl_qty"=>$avl_qty,"used_qty"=>$used_qty),"id ='".$res1->id."'");

					}

					

				}

			}		

		}

		

	}	

}











if(! function_exists('service_invoice_mail') )

{

	

	function service_invoice_mail($order_no,$to,$from,$from_name,$subject,$seller_id='')

	{

		$CI =& get_instance();

		$CI->load->library(array('Dmailer'));

		/***** Send Invoice mail */

	

		ob_start();

		$body         = get_service_invoice($order_no,$seller_id);

		$msg          = ob_get_contents();

		

		//echo $msg;exit;

		$mail_conf =  array(

							'subject'=>$subject,

							'to_email'=>$to,

							'from_email'=>$from,

							'from_name'=> $from_name,

							'body_part'=>$msg

						 );							

		$CI->dmailer->mail_notify($mail_conf);	

		ob_end_clean();

		/******* End Invoice  mail */	

	}	

}

if( ! function_exists('get_service_invoice'))

{

	function get_service_invoice($order_no,$seller_id='',$msg='',$print='yes')

	{

		$CI =& get_instance();

		$admin_dtl  	= $CI->admin_info;

		

		$price_dtl=get_db_single_row("tbl_premimum_first_service_price","*"," and id ='1'");

		$service= custom_result_set("select * from tbl_premimum_first_service where status ='1'");

	

		 $var='		

		<!DOCTYPE HTML>

			<html>

			<head>

			<meta charset="utf-8">

			<title>Welcome</title>

			<link href="'.theme_url().'css/win.css" rel="stylesheet" type="text/css">

			<link href="'.theme_url().'css/conditional_win.css" rel="stylesheet" type="text/css">

			</head>

			 <div class="fr w77">

        <h1 class="mb10 sm">Premium First Service</h1>';

      

		if(is_array($service) && !empty($service)){

		

		 $after_one_year = date('d/m/Y', strtotime("+".$price_dtl['duration']." years"));

		

       $var.=' <div class="p15 border1 exo fs15 black"> Your Membership Info - Duration : <b>'.$price_dtl['duration'].' Year</b> ('.date("d/m/Y").' - '.$after_one_year.'), Paid Amount : <b class="red">'.display_price($price_dtl['price']).'</b> </div>

        <div class="w80 pt20">';

          

          

        

		  $i=0;

		  foreach($service  as $service_val){

			  $ml=($i%2)==0 ? "":"ml40";

		

         $var.=' <div class="ps_box fl mt30 <?php echo $ml; ?>">

            <div class="ps_pc">

              <figure><img src="'.get_image('service_images',$service_val['image'],88,88,'AR').'" alt=""></figure>

            </div>

            <div class="pc_text">

              <p class="black exo ttu weight600">'.$service_val['title'].'*</p>

              <p class="fs12 i mt3 lht-16">'.$service_val['description'].' </p>

            </div>

            <div class="cb"></div>

          </div>';

          

        

		  $i++;

		  if($i%2==0)

		  $var.= '<div class="cb pb40"></div>';

		  }

		 

      

          $var.='

          <div class="cb"></div>

        </div>';

      

		}

		

     $var.='</div>

		

			</html>

		

		';

	

		return $var;

	}

}



//get_abandoncart



if( ! function_exists('get_abandoncart') )

{

	function get_abandoncart($user_id)

	{

		$ci=CI();

		

		$prodlist=custom_result_set("select u.id,u.name,u.email,u.username from tbl_users as u JOIN tbl_temp_cart as tc ON u.id=tc.user_id JOIN tbl_products as p ON p.id=tc.product_id where u.status='1' and u.user_type='3' and p.available_qty>0 group by u.id ");

		

		$var ='

						<!DOCTYPE HTML>

						<html>

						<head>

						<meta charset="utf-8">

						<title>Welcome</title>

						</head>

						<body style="font-size:12px; color:#333; margin:0px; padding:5px; font-family:Arial, Helvetica, sans-serif;">

						<div class="mt10">

							<div style="color:#333; line-height:18px;"><strong style="color:#ff6600; font-size:16px">Thank You!</strong><br>

								Sample text coming here sample text coming here sample text coming here....</div>

							<div style="clear:both;"></div>

							<div style="font:normal 14px/20px Arial, Helvetica, sans-serif; color:#000; text-transform:uppercase; margin-top:10px">Product Details</div>

							<table width="100%" border="0" align="center" cellpadding="4" cellspacing="1" style="margin-top:2px;">

								<tr style="font-size:13px; color:#222; line-height:36px; background:#eee">

									<td width="10%" align="center" style="line-height:20px; width:10%"><strong>S.No</strong></td>

									<td align="left" colspan="2"><strong>Products</strong></td>

									<td width="10%" align="center" style="width:10%"><strong>Amount</strong></td>

								</tr>

								<tr align="center">

									<td colspan="4" valign="top" ><img src="images/spacer.gif" width="1" height="1" alt=""></td>

								</tr>

								<tr>

									<td align="center" valign="top" style="border-bottom:1px solid #ddd; padding-bottom:10px;">1.</td>

									<td align="left" valign="top" style="border-bottom:1px solid #ddd; padding-bottom:10px;"><img src="product/ds-pro1.jpg" alt="" width="72" height="72" style="margin-right:10px; padding:5px"></td>

									<td align="left" valign="top" style="border-bottom:1px solid #ddd; padding-bottom:10px;"><p style="color:#333; font-size:13px; padding-top:5px; margin:0px; line-height:18px"> <span style="font-size:16px;">Adidas Springblade Drive M Running Shoes</span> <span style="font-size:11px; display:block; padding-top:8px; font-family:Verdana, Geneva, sans-serif">Product Code : RP_12345 / Brand : Adidas / Size : 9 / Color : Red<br>

											Unit Price: <del style="color:red;">Rs.4,500</del> <b>Rs.3,999</b> / Qty. : 1<br>

											Shipping Charge : Rs.50 </span></p></td>

									<td align="center" valign="top" style="width:10%; border-bottom:1px solid #ddd; padding-bottom:10px;"><strong>Rs.3,999</strong></td>

								</tr>

								<tr>

									<td colspan="4" align="center" valign="top">&nbsp;</td>

								</tr>

								<tr>

									<td align="center" valign="top" style="border-bottom:1px solid #ddd; padding-bottom:10px;">2.</td>

									<td width="7%" align="left" valign="top" style="border-bottom:1px solid #ddd; padding-bottom:10px;"><img src="product/ds-pro2.jpg" alt="" width="72" height="72" style="margin-right:10px; padding:5px"></td>

									<td width="73%" align="left" valign="top" style="border-bottom:1px solid #ddd; padding-bottom:10px;"><p style="color:#333; font-size:13px; padding-top:5px; margin:0px; line-height:18px"> <span style="font-size:16px;">Adidas Springblade Drive M Running Shoes</span> <span style="font-size:11px; display:block; padding-top:8px; font-family:Verdana, Geneva, sans-serif">Product Code : RP_12345 / Brand : Adidas / Size : 9 / Color : Red<br>

											Unit Price: <del style="color:red;">Rs.4,500</del> <b>Rs.3,999</b> / Qty. : 1<br>

											Shipping Charge : Rs.50 </span></p></td>

									<td align="center" valign="top" style="width:10%; border-bottom:1px solid #ddd; padding-bottom:10px;"><strong>Rs.3,999</strong></td>

								</tr>

								<tr align="center">

									<td colspan="4" valign="top" ><img src="images/spacer.gif" width="1" height="1" alt=""></td>

								</tr>

							</table>

						</div>

						<div class="cb"></div>

						<div style="text-align:right; font:bold 14px/18px Arial, Helvetica, sans-serif; color:#333;">Sub Total : Rs.7,998</div>

						<div style="clear:both"></div>

						</body>

						</html>

					';

					

					return $var;

	}

	

	

}



if( ! function_exists('get_invoice_for_edit'))

{

	function get_invoice_for_edit($order_no,$seller_id='',$msg='',$print='yes')

	{

		$CI =& get_instance();

		$admin_dtl  	= $CI->admin_info;

		

		$orderres			= get_invoice_detail($order_no,$seller_id);

		

		$odtl=get_db_single_row("tbl_orders","*",array("order_id"=>$order_no));

		

		$subtotal_top=0;

		$total_shipping_top=0;

		$total_coupon_discount_top=0;

		$total_cod_charge_top=0;

		foreach($orderres as $val_top)

		{

			$total_top=$val_top['discount_price']*$val_top['product_qty'];

			$subtotal_top +=$total_top;

			$total_shipping_top +=$val_top['product_ship_charge'];

			$total_coupon_discount_top +=$val_top['total_coupon_discount'];

			$total_cod_charge_top +=$val_top['product_cod_charge'];

		}

		

		$grand_total_top=(($subtotal_top+$total_shipping_top)-$total_coupon_discount_top)+$total_cod_charge_top;

		

		$tship_charge=($total_shipping_top>0)?display_price($total_shipping_top):'Free';

		$tcoupon_dis=($total_coupon_discount_top>0)?display_price($total_coupon_discount_top):'NA';

		

		$ship_phone=($odtl['ship_phone']!='')?$odtl['ship_phone']:'NA';

		

		

		?>

		<!DOCTYPE HTML>

			<html>

			<head>

			<meta charset="utf-8">

			<title>Welcome</title>

			<script type="text/javascript">

				function print_now()

				{

					document.getElementById("print_data").style.display="none";	

					window.print();

				}

			</script>

      

      <link href="<?php echo base_url(); ?>assets/developers/css/proj.css" rel="stylesheet" type="text/css" />

<link rel="icon" type="image/x-icon" href="<?php echo theme_url(); ?>images/favicon.ico" />



<script type="text/javascript">  var _siteRoot='index.html',_root='index.html';</script>

<script type="text/javascript" > var site_url = '<?php echo site_url();?>';</script>

<script type="text/javascript" > var theme_url = '<?php echo theme_url();?>';</script>

<script type="text/javascript" > var resource_url = '<?php echo resource_url(); ?>';</script>

<script type="text/javascript" > var developers_url = '<?php echo developers_url(); ?>';</script>



<script type="text/javascript" src="<?php echo base_url(); ?>assets/developers/js/jquery.min_1.8.2.js"></script>

<script type="text/javascript" src="<?php echo base_url(); ?>assets/developers/js/common.js"></script>

      

			</head>

			<body style="font-size:12px; color:#333; margin:0px; padding:5px; font-family:Arial, Helvetica, sans-serif;"><?php echo form_open('sitepanel/orders/edit_invoice/'.$order_no);?>

			<div style="height:400px;">

			<div class="mt10">

				<table width="100%" border="0" align="center" cellpadding="4" cellspacing="1">

					<tr>

						<td align="left"><p style="padding-top:2px; margin:0px; color:#333; line-height:18px;"><strong style="color:#ff6600; font-size:16px">Ebizy.com</strong><br>

								<?php echo $admin_dtl->address;?>, <?php echo $admin_dtl->city;?> - <?php echo $admin_dtl->post_code;?>, <strong><?php echo $admin_dtl->country;?></strong><br>

								<span style=" padding-top:3px;">Email Us : <a href="mailto:<?php echo $admin_dtl->email;?>" style="color:#000; font-weight:bold;"><?php echo $admin_dtl->email;?></a></span> Phone : <?php echo $admin_dtl->phone;?> </p>

							<br></td>

						<td align="right" valign="middle" style="padding-right:10px;"><img src="<?php echo theme_url();?>images/ebizy2.png" alt="" width="172" height="54"></td>

					</tr>

				</table>

				<br>

				<div style="width:50%; border:10px solid #eee; padding:15px; min-height:150px; float:left">

					<div style="font:bold 16px/20px Arial, Helvetica, sans-serif; color:#333; border-bottom:1px solid #ccc; margin-bottom:10px">Order Summary</div>

					<div style="margin-top:5px; font:normal 12px/20px Arial, Helvetica, sans-serif"><b>Invoice No. : <?php echo $odtl['order_id'];?></b> (Dated : <?php echo getDateFormat($odtl['order_date'],1);?>)</div>

					<div style="margin-top:10px; font:normal 12px/20px Arial, Helvetica, sans-serif">Subtotal Amount : <?php display_price($subtotal_top);?><br>

						Shipping Charge : <?php echo $tship_charge;?>, Discount : <?php echo $tcoupon_dis;?>

            <?php

						if($total_cod_charge_top>0)

						{

							?>							

							<br> COD Charge : <?php echo display_price($total_cod_charge_top);?>

              <?php

						}

						

						?>

						<br><b style="font:bold 16px/30px Arial, Helvetica, sans-serif; color:#000">Total Payable Amount : <?php echo display_price($grand_total_top);?></b>

            

            <div style="padding-top:116px; font-size:14px;">

            	<strong>Payment Mode : </strong><br>

            	<select name="payment_mode" style="width:150px;">

              	<option value="COD" <?php echo ($CI->input->post('payment_mode')=='COD' || $odtl['payment_mode']=='COD')?'selected':'';?>>COD</option>

                <option value="Net Banking" <?php echo ($CI->input->post('payment_mode')=='Net Banking' || $odtl['payment_mode']=='Net Banking')?'selected':'';?>>Net Banking</option>

              </select>

              <?php echo form_error('payment_mode');?>

            </div>

            <div style="padding-top:5px;">

            	<strong>Notify by : </strong><br>

              <input type="checkbox" name="byemail" value="1" <?php echo ($CI->input->post('byemail')==1)?'checked':'';?>> By Email<br>	

              <input type="checkbox" name="bysms" value="1" <?php echo ($CI->input->post('bysms')==1)?'checked':'';?>> By SMS

            </div>  

            </div>

				</div>

				<div style="width:38%; border:10px solid #eee; padding:15px; min-height:150px; float:right;">

					<div style="font:bold 16px/20px Arial, Helvetica, sans-serif; color:#333; border-bottom:1px solid #ccc; margin-bottom:10px">Delivery Address</div>

					<div style="margin-top:5px; font:normal 12px/20px Arial, Helvetica, sans-serif">

					<div>

						<input name="name" type="text" class="w100 p7" placeholder="Name *" value="<?php echo set_value('name',$odtl['ship_name']);?>">

            <?php echo form_error('name');?>

					</div>

					<div style="padding-top:5px;">

						<input name="mobile" type="text" class="w100 p7" placeholder="Mobile *" value="<?php echo set_value('mobile',$odtl['ship_mobile']);?>">

            <?php echo form_error('mobile');?>

					</div>

					<div style="padding-top:5px;">

						<input name="phone" type="text" class="w100 p7" placeholder="Phone No." value="<?php echo set_value('phone',$odtl['ship_phone']);?>">

            <?php echo form_error('phone');?>

					</div>

					<div style="padding-top:5px;">

						<?php

						$arr=array("tbl_name"=>"tbl_country","select_fld"=>"id,country_name","where"=>"and status='1'");

						echo common_dropdown('country',set_value('country',$odtl['ship_country']),$arr,'class="w100 p7 mt7" onchange="bind_data(this.value,\'remote/bind_state?replace_id=city_list&name=state&city_name=city\',\'state_list\',\'loader_state\',\'neighborhood_country\',\'style=width:240px;padding:7px;margin-top:7px;\');"','Select Country');?>

						<?php echo form_error('country'); ?>

					</div>

          <div style="padding-top:5px;">

          <span id="loader_state"></span>

        <span id="state_list">

          

         <?php

		

       $country_id=($CI->input->post('country')!=''?$CI->input->post('country'):((@$odtl['ship_country']!='')?@$odtl['ship_country']:0));

        if(@$country_id!='' || @$country_id==0)

        {               	

$arr=array("tbl_name"=>"tbl_states","select_fld"=>"id,title","where"=>"and status='1' and country_id ='".$country_id."'");

echo common_dropdown('state',set_value('state',@$odtl['ship_state']),$arr,'class="w100 p7 mt7" onchange="bind_data(this.value,\'remote/bind_city?replace_id=city_list&name=city\',\'city_list\',\'loader_city\',\'city_section\',\'style=width:530px;\');"');

}

            		

              	?>

                   <?php echo form_error('state'); ?>

            </span>

          </div>

          

         <div style="padding-top:5px;">

         	<span id="loader_city"></span>

            <span id="city_list">

						<?php

						if($CI->input->post('state')>0)

						{                  	

								$arr=array("tbl_name"=>"tbl_city","select_fld"=>"id,title","where"=>"and status='1' and state_id ='".$CI->input->post('state')."'");

								echo common_dropdown('city',set_value('city',@$odtl['ship_city']),$arr,'class="w100 p7 mt7"');

								}

								elseif(@$odtl['ship_state']>0)

								{

										$arr=array("tbl_name"=>"tbl_city","select_fld"=>"id,title","where"=>"and status='1' and state_id ='".@$odtl['ship_state']."'");

								echo common_dropdown('city',set_value('city',@$odtl['ship_city']),$arr,'class="w100 p7 mt7"');	

								}

								else

								{

										$arr=array("tbl_name"=>"tbl_city","select_fld"=>"id,title","where"=>"and status='1' and state_id ='0'");

								echo common_dropdown('city',set_value('city',@$odtl['ship_city']),$arr,'class="w100 p7 mt7"');	

				}

					

					echo form_error('city'); ?>

          </span>

         </div>

         

         <div style="padding-top:5px;">

           <textarea name="address" rows="3" id="address" class="w100 p7 db mt7" placeholder="Address *"><?php echo set_value('address',$odtl['ship_address']) ?></textarea>

      <?php echo form_error('address'); ?>

         </div>

         <div style="padding-top:5px;">

         <textarea name="landmark" rows="2" id="landmark" class="w100 p7 db mt7" placeholder="Landmark *"><?php echo set_value('landmark',$odtl['ship_landmark']) ?></textarea>

<?php echo form_error('landmark'); ?>

         </div>

          <div style="padding-top:5px;">

          

          </div>

          		<input name="pincode" id="pincode" type="text" class="w100 p7 mt7" placeholder="Pin Code"  value="<?php echo set_value('pincode',$odtl['ship_pin_code']) ?>">

<?php echo form_error('pincode'); ?>			

					</div>

				</div>

				<div style="clear:both"></div>

				

				<div style="font:normal 14px/20px Arial, Helvetica, sans-serif; color:#000; text-transform:uppercase; margin-top:20px">Product Details</div>

				<table width="100%" border="0" align="center" cellpadding="4" cellspacing="1" style="margin-top:2px;">

					<tr style="font-size:13px; color:#222; line-height:36px; background:#eee">

						<td width="10%" align="center" style="line-height:20px; width:10%"><strong>S.No</strong></td>

						<td align="left" colspan="2"><strong>Products</strong></td>

						<td width="10%" align="center" style="width:10%"><strong>Amount</strong></td>

					</tr>

					<tr align="center">

						<td colspan="4" valign="top" ><img src="<?php echo theme_url();?>images/spacer.gif" width="1" height="1" alt=""></td>

					</tr>

          <?php

					$sl=0;

					$subtotal=0;

					$total_shipping=0;

					$total_coupon_discount=0;

					foreach($orderres as $val)

					{

						

						$sl++;

						$gallery_image=get_title_by_id("tbl_products_gallery","product_image",array("product_id"=>$val['product_id'],"product_image !"=>''));

						

						$pdtl=get_db_single_row("tbl_products","*",array("id"=>$val['product_id']));

						$brand_id=$pdtl['brand'];

						$brand_name	='NA';

						$color_name	='NA';

						$size_name	='NA';

						if($brand_id>0)

						{

							$brand_name=get_title_by_id("tbl_brands","brand_name",array("id"=>$brand_id));

						}

						if($val['product_color']>0)

						{

							$color_name=get_title_by_id("tbl_cat_attr_value","cat_attr_value",array("id"=>$val['product_color']));

						}

						if($val['product_size']>0)

						{

							$size_name=get_title_by_id("tbl_cat_attr_value","cat_attr_value",array("id"=>$val['product_size']));

						}

						$shipping_charge = ($val['product_ship_charge']>0)?display_price($val['product_ship_charge']):'Free';

						$total=$val['discount_price']*$val['product_qty'];

						$subtotal +=$total;

						$total_shipping +=$val['product_ship_charge'];

						$total_coupon_discount +=$val['total_coupon_discount'];

						?>

						<tr>

							<td align="center" valign="top" style="border-bottom:1px solid #ddd; padding-bottom:10px;"><?php echo $sl;?>.</td>

							<td align="left" valign="top" style="border-bottom:1px solid #ddd; padding-bottom:10px;"><img src="<?php echo get_image("product_images",$gallery_image,72,72,'R');?>" alt="" width="72" height="72" style="margin-right:10px; padding:5px"></td>

							<td align="left" valign="top" style="border-bottom:1px solid #ddd; padding-bottom:10px;"><p style="color:#333; font-size:13px; padding-top:5px; margin:0px; line-height:18px"> <span style="font-size:16px;"><?php echo $pdtl['product_name'];?></span> <span style="font-size:11px; display:block; padding-top:8px; font-family:Verdana, Geneva, sans-serif">Product Code : <?php echo $pdtl['product_code'];?> / Brand : <?php echo $brand_name;?> / Size : <?php echo $size_name;?> / Color : <?php echo $color_name;?><br>

									Unit Price: <del style="color:red;"><?php echo display_price($val['product_price']);?></del> <b><?php echo display_price($val['discount_price']);?></b> / Qty. : <?php echo $val['product_qty'];?><br>

									Shipping Charge : <?php echo $shipping_charge;?>

                  <?php

									if($seller_id<1)

									{

										 $comp_dtl=get_db_single_row("tbl_seller_company_details","company_name,company_display_name",array("seller_id"=>$val['seller_id']));

										 $comp_display_name = ($comp_dtl['company_display_name']!='')?$comp_dtl['company_display_name']:$comp_dtl['company_name'];

										 $seller_dtl_link=get_links($val['seller_id'],"company_details");	

										 ?>

										 <br>Seller : <a target="_blank" style="color:black; text-decoration:underline;" href="<?php echo $seller_dtl_link;?>"><?php echo $comp_display_name;?></a>

                     <?php

				

									}

									?>

									</span><br>

                  <?php

                  $color_list=custom_result_set("select invt.color_id,attrval.cat_attr_value from tbl_product_inventory as invt JOIN tbl_cat_attr_value as attrval ON invt.color_id=attrval.id where product_id ='".$val['product_id']."' and invt.avl_qty>0 group by attrval.id");

									if(is_array($color_list) && count($color_list) > 0)

									{

									?>

                  Color : 

                  <select name="prodcolor[<?php echo $val['id'];?>]" style="width:100px;">

                    <?php

										foreach($color_list as $colval)

										{

										?>

										<option value="<?php echo $colval['color_id'];?>" <?php echo ($colval['color_id']==$val['product_color'])?'selected':'';?>><?php echo $colval['cat_attr_value'];?></option>

										<?php

										}

										?>

                  </select>

                  <?php } ?>

                 

                  <?php

                  $size_list=custom_result_set("select invt.size_id,attrval.cat_attr_value from tbl_product_inventory as invt JOIN tbl_cat_attr_value as attrval ON invt.size_id=attrval.id where product_id ='".$val['product_id']."' and invt.avl_qty>0 group by attrval.id");

									if(is_array($size_list) && count($size_list) > 0)

									{

									?>

                  Size : 

                  <select name="prodsize[<?php echo $val['id'];?>]" style="width:100px;">

                    <?php

										foreach($size_list as $sizeval)

										{

										?>

										<option value="<?php echo $sizeval['size_id'];?>" <?php echo ($sizeval['size_id']==$val['product_size'])?'selected':'';?>><?php echo $sizeval['cat_attr_value'];?></option>

										<?php

										}

										?>

                  </select>

                  <?php } ?>



                  

                  </p></td>

							<td align="center" valign="top" style="width:10%; border-bottom:1px solid #ddd; padding-bottom:10px;"><strong><?php echo display_price($total);?></strong></td>

						</tr>

						<tr>

							<td colspan="4" align="center" valign="top">&nbsp;</td>

						</tr>

            <?php

					}

					$avail_credit_points_value=0;

					if($odtl['avail_credit_points_value']>0 && $seller_id<1)

					{

						$avail_credit_points_value=$odtl['avail_credit_points_value'];

					}

					$grand_total=($subtotal+$total_shipping)-($total_coupon_discount+$avail_credit_points_value);

					?>

					<tr align="center">

						<td colspan="4" valign="top" ><img src="<?php echo theme_url();?>images/spacer.gif" width="1" height="1" alt=""></td>

					</tr>

				</table>

			</div>

			<div style="clear:both;"></div>

			<div style="float:left" id="print_data">

      <input type="submit" name="update" value="Update Order" />

      <?php 

			$tot_ship_price=($total_shipping>0)?display_price($total_shipping):'Free';

			?>

			</div>

			<div style="clear:both;"></div>

			<div style="float:right; text-align:right; font:bold 14px/18px Arial, Helvetica, sans-serif; color:#333;">Sub Total : <?php echo display_price($subtotal);?></div>

			<div style="clear:both;"></div>

			<div style="float:right; text-align:right; font:bold 14px/18px Arial, Helvetica, sans-serif; color:#333;">Shipping Charge : <?php echo $tot_ship_price;?></div>

      <?php

			if($total_coupon_discount>0)

			{

				?>

			<div style="clear:both;"></div>

			<div style="float:right; text-align:right; font:bold 14px/18px Arial, Helvetica, sans-serif; color:#333;">Coupon Discount : <?php echo display_price($total_coupon_discount);?></div>

      <?php

			}

			if($avail_credit_points_value>0)

			{

				?>

			<div style="clear:both;"></div>

			<div style="float:right; text-align:right; font:bold 14px/18px Arial, Helvetica, sans-serif; color:#333;">Points Redeemed Discount : <?php echo display_price($avail_credit_points_value);?></div>

      <?php

			}

			if($total_cod_charge_top>0)

			{

				?>

			<div style="clear:both;"></div>

			<div style="float:right; text-align:right; font:bold 14px/18px Arial, Helvetica, sans-serif; color:#333;">COD Charge : <?php echo display_price($total_cod_charge_top);?></div>

      <?php

			}

			?>

			<div style="clear:both;"></div>

			<div style="float:right; text-align:right; font:bold 14px/18px Arial, Helvetica, sans-serif; color:#333;">Estimated Total : <?php echo display_price($grand_total+$total_cod_charge_top);?></div>

			<div style="clear:both"></div>

			</div><?php echo form_close();?>

			</body>

			</html>

      <?php

	}

}