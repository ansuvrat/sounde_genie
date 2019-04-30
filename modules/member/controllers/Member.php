<?php
class Member extends Private_Controller
{

	private $mId;

	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('member/member_model'));
		$this->load->helper(array('file','paypal','member'));
		$this->load->library(array('safe_encrypt','Dmailer'));
		$this->form_validation->set_error_delimiters("<div class='required'>","</div>");
	}

	public function index()
	{
		
		$options          = array('status'=>'1','id'=>$this->userId);
		$res              = $this->member_model->get_members(1,0,$options);
		$data['mres']     = $res;
		$data['orderArr'] = $this->member_model->get_orders(2,0);
		$data['title']    = "My Account";
		$this->load->view('myaccount',$data);
	}


	public function edit_account(){

		$data['mres']=$this->member_model->get_member_row($this->userId,"");
		$action=$this->input->post("action");
		if($action=="Edit"){
		
		$this->form_validation->set_rules('name',"First name", 'trim|required|max_length[50]');
		$this->form_validation->set_rules('mobile',"Mobile", 'trim|required|max_length[14]');
		
		if ($this->form_validation->run() == TRUE){

				$posted_data = array(
									 "name"	  => $this->input->post("name"),
									 "mobile" => $this->input->post("mobile")
					                );
				$posted_data = $this->security->xss_clean($posted_data);
				$where       = "id ='".$this->userId."'";
				$this->member_model->safe_update('tbl_users',$posted_data,$where);

				$name=ucwords($this->input->post('name'));
				$this->session->set_userdata(array("name"=>$name));
				$this->session->set_userdata(array('msg_type'=>'success'));
				$this->session->set_flashdata('success',"Account has been updated successfully");
			  redirect('member/edit_account');
		  }
		}
		$data['title'] = "Edit Account";
		$this->load->view('edit_account',$data);
	}
	
	public function changepassword(){
		
		$data['page_title']="Change Password";
		$this->form_validation->set_rules('old_password', 'Old Password', 'trim|required');
		$this->form_validation->set_rules('new_password', 'New Password', 'trim|required|valid_password');
		$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|matches[new_password]');

		if ($this->form_validation->run() == TRUE)
		{
			$password_old   =  $this->safe_encrypt->encode($this->input->post('old_password',TRUE));
			$mres=$this->member_model->get_member_row($this->userId," AND password='$password_old' ");
			if( is_array($mres) && !empty($mres) )
			{
				$password = $this->safe_encrypt->encode($this->input->post('new_password',TRUE));
				$data  = array('password'=>$password);
				$where = "id=".$this->userId." ";
				$this->member_model->safe_update('tbl_users',$data,$where,FALSE);
				$this->session->set_userdata(array('msg_type'=>'success'));
				$this->session->set_flashdata('success',$this->config->item('myaccount_password_changed'));
			}else
			{
				$this->session->set_userdata(array('msg_type'=>'warning'));
				$this->session->set_flashdata('warning',$this->config->item('myaccount_password_not_match'));
			}
			redirect('member/changepassword','');
		}
		
		$this->load->view("changepassword_view",$data);
	}
	
	public function indivisualservice(){
		
		 if($this->session->userdata('sessuser_type')==2){
		  
			$this->session->set_userdata(array('msg_type'=>'error'));
			$this->session->set_flashdata('error','Invalid access.Only company is allowed.');
			redirect("member");	
		}
		$data['page_title']="Individual Services";
		$this->load->view("indivisualservice_view",$data);
	}
	
	public function musicproduction(){
		
		if($this->session->userdata('sessuser_type')==2){
		  
			$this->session->set_userdata(array('msg_type'=>'error'));
			$this->session->set_flashdata('error','Invalid access. Only normal member is allowed');
			redirect("member");	
		}
		$composition         = '';
		$lyrics              = '';
		$mixing              = '';
		$mastering           = '';
		$composition_youtube = '';
		$lyrics_youtube      = '';
		$mixing_youtube      = '';
		$mastering_youtube   = '';
		
		$rwdata=get_db_multiple_row("tbl_cms_youtube","youtube_url,description,type","status ='1' ");
		if(is_array($rwdata) && count($rwdata) > 0 ){
		  foreach($rwdata as $mVal){
			  if($mVal['type']==1){
				 $composition=$mVal['description'];  
				 $composition_youtube=$mVal['youtube_url']; 
			  }
			  if($mVal['type']==2){
				 $lyrics=$mVal['description']; 
				 $lyrics_youtube=$mVal['youtube_url'];  
			  }
			  if($mVal['type']==3){
				 $mixing=$mVal['description']; 
				 $mixing_youtube=$mVal['youtube_url'];   
			  }
			  if($mVal['type']==6){
				 $mastering=$mVal['description'];  
				 $mastering_youtube=$mVal['youtube_url'];  
			  }
		  }
		}
		$data['composition']         = $composition;
		$data['composition_youtube'] = $composition_youtube;
		$data['lyrics']              = $lyrics;
		$data['lyrics_youtube']      = $lyrics_youtube;
		$data['mixing']              = $mixing;
		$data['mixing_youtube']      = $mixing_youtube;
		$data['mastering']           = $mastering;
		$data['mastering_youtube']   = $mastering_youtube;
		
		$data['page_title']="Music Production";
		$this->load->view("musicproduction_view",$data);
	}
	
	public function composition(){
		
		if($this->session->userdata('sessuser_type')==2){
		  
			$this->session->set_userdata(array('msg_type'=>'error'));
			$this->session->set_flashdata('error','Invalid access. Only normal member is allowed');
			redirect("member");	
		}
		$data['page_title']="Composition";
		$this->load->view("composition_view",$data);
	}
	
	public function companyservice(){
		
		if($this->session->userdata('sessuser_type')==3){
		  
			$this->session->set_userdata(array('msg_type'=>'error'));
			$this->session->set_flashdata('error','Invalid access.Only company is allowed.');
			redirect("member");	
		}
		$data['page_title']="Company Services";
		$this->load->view("companyservice_view",$data);
	}
	
	public function companymusicproduction(){
		
		if($this->session->userdata('sessuser_type')==3){
		  
			$this->session->set_userdata(array('msg_type'=>'error'));
			$this->session->set_flashdata('error','Invalid access.Only company is allowed.');
			redirect("member");	
		}
		$data['page_title']="Music Production";
		$this->load->view("companymusicproduction_view",$data);
	}
	
	public function companyliveinstrument(){
		
		if($this->session->userdata('sessuser_type')==3){
		  
			$this->session->set_userdata(array('msg_type'=>'error'));
			$this->session->set_flashdata('error','Invalid access.Only company is allowed.');
			redirect("member");	
		}
		
		$data['page_title']="Live Real Instrument";
		$data['rwtesttype']=get_db_multiple_row("tbl_instrument_type","id,title","ins_type ='1' AND status ='1' ORDER BY title ASC ");
		if($this->input->post('action')=='Add'){
			$this->form_validation->set_rules('instype', 'Instrument Type', 'trim|required');
			$this->form_validation->set_rules('duration', 'Duration', 'trim|required');
			$this->form_validation->set_rules('price', 'Price', 'trim|required');
			$this->form_validation->set_rules('comment', 'Comment', 'trim|required|max_length[888850]');
			$this->form_validation->set_rules('image1','Upload File',"file_required|file_allowed_type[document_image]");
			if($this->form_validation->run()==TRUE)
			{
				$uploaded_file = "";
				if( !empty($_FILES) && $_FILES['image1']['name']!='' )
				{
					
					$this->load->library('upload');
					$uploaded_data =  $this->upload->my_upload('image1','order_file');
					if( is_array($uploaded_data)  && !empty($uploaded_data) )
					{
						$uploaded_file = $uploaded_data['upload_data']['file_name'];
					}
				}
				$orderID=random_string('alnum',6);
				$duration=$this->input->post('duration');
				$rwpriceArr=get_db_single_row("tbl_virtual_instru_price","duration,price"," AND price_id='$duration'");
				$price='';
				$oduration='';
				if(is_array($rwpriceArr) && count($rwpriceArr) > 0){
					$price=$rwpriceArr['price'];
				    $oduration=$rwpriceArr['duration'];
				}
				$rwprd=get_db_single_row("tbl_instrument_type","id,title"," AND id='".$this->input->post('instype')."'");
				$product='';
				if(is_array($rwprd) && count($rwprd)){
				  $product=$rwprd['title'];
				}
				
				$posted_data = array(
									'order_id'      => $orderID,
									
									'order_date'    => $this->config->item('config.date.time'),
									'upd_file'      => $uploaded_file,
									'mem_id'        => $this->session->userdata('user_id'),
									'name'          => $this->name,
									'mem_type'      => $this->userType,
									'phone'         => $this->mobile,
									'email'         => $this->username,
									'order_type'    => 9,
									'product_id'    => $this->input->post('instype',TRUE),
									'product'       => $product,
									'duration'      => $oduration,
									'price'         => $price,
									'comment'       => $this->input->post('comment',TRUE),
						 			'pay_mode'      => '',
									'pay_status'    => 1,
									'confirm_status'=> 1,
									'status'        => 1
				);
			$this->member_model->safe_insert('tbl_order',$posted_data,FALSE);
			 $this->session->set_userdata(array('sesorderID'=>$orderID));
			 redirect("member/paymentmethod");
			}
		}
		$this->load->view("companyliveinstrument_view",$data);
	}
	
	public function getliveinstrumentduration(){
		
		$inval=$this->input->get_post('inval');
		$rwdata=get_db_multiple_row("tbl_virtual_instru_price","price_id,duration","instrument_type ='$inval' ORDER BY duration ASC");
		?>
        
         <option value="">Duration</option>
        <?php
		 if(is_array($rwdata) && count($rwdata) > 0 ){
			 foreach($rwdata as $insVal){
		?>
        <option value="<?php echo $insVal['price_id'];?>"><?php echo $insVal['duration'];?> Minutes</option>
       
        <?php
			 }
		 }
	}
	
	public function getliveinstrumentprice(){
		
		$priceID=$this->input->get_post('priceID');
		$rwliveinsprice=get_db_single_row("tbl_virtual_instru_price","price"," AND price_id ='$priceID'");
		if(is_array($rwliveinsprice) && count($rwliveinsprice) > 0 ){ ?>
			<input name="price" type="text" value="<?php echo $rwliveinsprice['price'];?>" readonly>
		<?php }else{ ?>
			<input name="price" type="text" value="<?php echo set_value('price');?>" readonly>
		<?php }
	}
	
	public function paymentmethod(){
		
		$orderID=$this->session->userdata('sesorderID');
		$rworder=$this->member_model->getorder($orderID);
		if(is_array($rworder) && count($rworder) > 0 ){
		 $data['rworder']=$rworder;	
		 if($this->input->post('action')=='Add'){
			 $this->session->unset_userdata('sesorderID');
			 paypalForm($rworder);
			 
		 }
		 $this->load->view("paymentmethod_view",$data);	
		}else{
		  redirect("home");	
		}
	}
	
	public function order_success(){
		$orderID=$this->uri->segment(3);
		$rworder=get_db_single_row("tbl_order","*"," AND md5(order_id) ='$orderID' ");
		if(is_array($rworder) && count($rworder) > 0 ){
			$this->db->query("UPDATE tbl_order SET pay_mode='Paypal',pay_status='2' WHERE md5(order_id) ='$orderID'");
		// Send email ..................
			ob_start();
			$mail_subject =$this->config->item('site_name')." Order overview";
			$from_email   = $this->admin_info->admin_email;
			$from_name    = $this->config->item('site_name');
			$mail_to      = $rworder['email'];
			$body         = get_invoice($rworder,FALSE);
			$msg          = ob_get_clean();
			$mail_conf =  array(
			'subject'=>$this->config->item('site_name')." Order overview",
			'to_email'=>$mail_to,
			'from_email'=>$from_email,
			'from_name'=> $this->config->item('site_name'),
			'body_part'=>$msg);
			
			$this->dmailer->mail_notify($mail_conf);
		//End	
			redirect("member/invoice/".$orderID);
		}else{
			redirect("home");	
		}
	}
	
	public function order_cancle(){
		$orderID=$this->uri->segment(3);
		$rworder=get_db_single_row("tbl_order","id,order_id"," AND md5(order_id) ='$orderID' ");
		if(is_array($rworder) && count($rworder) > 0 ){
			redirect("member/invoice/".$orderID);
		}else{
			redirect("home");	
		}
	}
	
	public function invoice(){
		
		$orderID=$this->uri->segment(3);
		$rworder=get_db_single_row("tbl_order","*"," AND md5(order_id) ='$orderID' ");
		if(is_array($rworder) && count($rworder) > 0 ){
			
			$data['rworder']=$rworder;
			$this->load->view("invoice_view",$data);	
		}else{
			redirect("home");	
		}
	}
	
	public function printinvoice(){
		$orderID=$this->uri->segment(3);
		$rworder=get_db_single_row("tbl_order","*"," AND md5(order_id) ='$orderID' ");
		if(is_array($rworder) && count($rworder) > 0 ){
			
			$data['rworder']=$rworder;
			$this->load->view("printinvoice_view",$data);	
		}
	}
	
// company virtual instrument
   
   public function companyvirtualinstrument(){
		
		if($this->session->userdata('sessuser_type')==3){
		  
			$this->session->set_userdata(array('msg_type'=>'error'));
			$this->session->set_flashdata('error','Invalid access.Only company is allowed.');
			redirect("member");	
		}
		$data['page_title']="Virtual Sampled Instrument";
		$data['rwtesttype']=get_db_multiple_row("tbl_instrument_type","id,title","ins_type ='2' AND status ='1' ORDER BY title ASC ");
		if($this->input->post('action')=='Add'){
			$this->form_validation->set_rules('instype', 'Instrument Type', 'trim|required');
			$this->form_validation->set_rules('duration', 'Duration', 'trim|required');
			$this->form_validation->set_rules('price', 'Price', 'trim|required');
			$this->form_validation->set_rules('comment', 'Comment', 'trim|required|max_length[888850]');
			$this->form_validation->set_rules('image1','Upload File',"file_required|file_allowed_type[document_image]");
			if($this->form_validation->run()==TRUE)
			{
				$uploaded_file = "";
				if( !empty($_FILES) && $_FILES['image1']['name']!='' )
				{
					
					$this->load->library('upload');
					$uploaded_data =  $this->upload->my_upload('image1','order_file');
					if( is_array($uploaded_data)  && !empty($uploaded_data) )
					{
						$uploaded_file = $uploaded_data['upload_data']['file_name'];
					}
				}
				$orderID=random_string('alnum',6);
				$duration=$this->input->post('duration');
				$rwpriceArr=get_db_single_row("tbl_virtual_instru_price","duration,price"," AND price_id='$duration'");
				$price='';
				$oduration='';
				if(is_array($rwpriceArr) && count($rwpriceArr) > 0){
					$price=$rwpriceArr['price'];
				    $oduration=$rwpriceArr['duration'];
				}
				$rwprd=get_db_single_row("tbl_instrument_type","id,title"," AND id='".$this->input->post('instype')."'");
				$product='';
				if(is_array($rwprd) && count($rwprd)){
				  $product=$rwprd['title'];
				}
				
				$posted_data = array(
									'order_id'      => $orderID,
									
									'order_date'    => $this->config->item('config.date.time'),
									'upd_file'      => $uploaded_file,
									'mem_id'        => $this->session->userdata('user_id'),
									'name'          => $this->name,
									'mem_type'      => $this->userType,
									'phone'         => $this->mobile,
									'email'         => $this->username,
									'order_type'    => 3,
									'product_id'    => $this->input->post('instype',TRUE),
									'product'       => $product,
									'duration'      => $oduration,
									'price'         => $price,
									'comment'       => $this->input->post('comment',TRUE),
						 			'pay_mode'      => '',
									'pay_status'    => 1,
									'confirm_status'=> 1,
									'status'        => 1
				                 );
			 $this->member_model->safe_insert('tbl_order',$posted_data,FALSE);
			 $this->session->set_userdata(array('sesorderID'=>$orderID));
			 redirect("member/paymentmethod");
			 
			}
		}
		$this->load->view("companyvirtualinstrument_view",$data);
	}	
	
// Company sound design ......................
   
   public function companysoundproduction(){
	   
	   if($this->session->userdata('sessuser_type')==3){
		  
			$this->session->set_userdata(array('msg_type'=>'error'));
			$this->session->set_flashdata('error','Invalid access.Only company is allowed.');
			redirect("member");	
		}
	   $data['page_title']="Sound Design";
	   $data['rwcatArr']=get_db_multiple_row("tbl_sounddesign_category","id,sounddegn_category","status ='1' ORDER BY sounddegn_category ASC");
	   
	    if($this->input->post('action')=='Add'){
			$this->form_validation->set_rules('cat_id', 'Category', 'trim|required');
			$this->form_validation->set_rules('duration', 'Duration', 'trim|required');
			$this->form_validation->set_rules('price', 'Price', 'trim|required');
			$this->form_validation->set_rules('comment', 'Comment', 'trim|required|max_length[888850]');
			$this->form_validation->set_rules('image1','Upload File',"file_required|file_allowed_type[document_image]");
			if($this->form_validation->run()==TRUE)
			{
				$uploaded_file = "";
				if( !empty($_FILES) && $_FILES['image1']['name']!='' )
				{
					
					$this->load->library('upload');
					$uploaded_data =  $this->upload->my_upload('image1','order_file');
					if( is_array($uploaded_data)  && !empty($uploaded_data) )
					{
						$uploaded_file = $uploaded_data['upload_data']['file_name'];
					}
				}
				$orderID=random_string('alnum',6);
				$duration=$this->input->post('duration');
				$rwpriceArr=get_db_single_row("tbl_sound_designing","duration,price"," AND id='$duration'");
				$price='';
				$oduration='';
				if(is_array($rwpriceArr) && count($rwpriceArr) > 0){
					$price=$rwpriceArr['price'];
				    $oduration=$rwpriceArr['duration'];
				}
				$rwprd=get_db_single_row("tbl_sounddesign_category","id,sounddegn_category"," AND id='".$this->input->post('cat_id')."'");
				$product='';
				if(is_array($rwprd) && count($rwprd)){
				  $product=$rwprd['sounddegn_category'];
				}
				
				$posted_data = array(
									'order_id'      => $orderID,
									
									'order_date'    => $this->config->item('config.date.time'),
									'upd_file'      => $uploaded_file,
									'mem_id'        => $this->session->userdata('user_id'),
									'name'          => $this->name,
									'mem_type'      => $this->userType,
									'phone'         => $this->mobile,
									'email'         => $this->username,
									'order_type'    => 10,
									'product_id'    => $this->input->post('cat_id',TRUE),
									'product'       => $product,
									'duration'      => $oduration,
									'price'         => $price,
									'comment'       => $this->input->post('comment',TRUE),
						 			'pay_mode'      => '',
									'pay_status'    => 1,
									'confirm_status'=> 1,
									'status'        => 1
				);
			$this->member_model->safe_insert('tbl_order',$posted_data,FALSE);
			 $this->session->set_userdata(array('sesorderID'=>$orderID));
			 redirect("member/paymentmethod");
			}
		}
	   
	   $this->load->view("companysoundproduction_view",$data);
   }
   
   
   public function getcompanysounddesign(){
		
		$catID=$this->input->get_post('catID');
		$rwdesigndurArr=get_db_multiple_row("tbl_sound_designing","duration,id","cat_id ='$catID'");
		?>
        <option value="">Duration</option>
		<?php
		 if(is_array($rwdesigndurArr) && count($rwdesigndurArr) > 0 ){
			 foreach($rwdesigndurArr as $durVal){ ?>
            <option value="<?php echo $durVal['id'];?>"><?php echo $durVal['duration'];?> Minutes</option>   
       <?php }
		 }
	}
	
	
	public function getcompanysounddesignprice(){
		
		$priceID=$this->input->get_post('priceID');
		$rwliveinsprice=get_db_single_row("tbl_sound_designing","price"," AND id ='$priceID'");
		if(is_array($rwliveinsprice) && count($rwliveinsprice) > 0 ){ ?>
			<input name="price" type="text" value="<?php echo $rwliveinsprice['price'];?>" readonly>
		<?php }else{ ?>
			<input name="price" type="text" value="<?php echo set_value('price');?>" readonly>
		<?php }
	}
	
	
	public function soundproduction(){
		
		 if($this->session->userdata('sessuser_type')==2){
		  
			$this->session->set_userdata(array('msg_type'=>'error'));
			$this->session->set_flashdata('error','Invalid access. Only normal member is allowed');
			redirect("member");	
		}
		$data['page_title']="Sound Production";
		$rwdata=get_db_multiple_row("tbl_cms_youtube","youtube_url,description,type","type >=4 ");
		$recording_desc='';
		$recording_youtube='';
		$designing_desc='';
		$designing_youtube='';
		
		if(is_array($rwdata) && count($rwdata) > 0){
			foreach($rwdata as $cval){
				if($cval['type']==4){
					
					$recording_desc=$cval['description'];
		            $recording_youtube=$cval['youtube_url'];
				}
				if($cval['type']==5){
					
					$designing_desc=$cval['description'];
		            $designing_youtube=$cval['youtube_url'];
				}
			}
		}
		$data['recording_desc']=$recording_desc;
		$data['recording_youtube']=$recording_youtube;
		$data['designing_desc']=$designing_desc;
		$data['designing_youtube']=$designing_youtube;
		
		$this->load->view("soundproduction_view",$data);
	}
	
	public function soundrecording(){
		
		 if($this->session->userdata('sessuser_type')==2){
		  
			$this->session->set_userdata(array('msg_type'=>'error'));
			$this->session->set_flashdata('error','Invalid access. Only normal member is allowed');
			redirect("member");	
		}
		$data['page_title']="Sound Recording";
		$data['rwcat']=get_db_multiple_row("tbl_sound_category","cat_name,id","status ='1' ORDER BY cat_name ASC ");
		
		if($this->input->post('action')=='Add'){
			$this->form_validation->set_rules('cat_id', 'Category', 'trim|required');
			$this->form_validation->set_rules('prefer_date', 'Prefered Date', 'trim|required|callback_validpreferdate');
			$this->form_validation->set_rules('price', 'Price', 'trim|required');
			$this->form_validation->set_rules('comment', 'Comment', 'trim|required|max_length[888850]');
			$this->form_validation->set_rules('image1','Upload File',"file_required|file_allowed_type[document_image]");
			if($this->form_validation->run()==TRUE)
			{
				$uploaded_file = "";
				if( !empty($_FILES) && $_FILES['image1']['name']!='' )
				{
					
					$this->load->library('upload');
					$uploaded_data =  $this->upload->my_upload('image1','order_file');
					if( is_array($uploaded_data)  && !empty($uploaded_data) )
					{
						$uploaded_file = $uploaded_data['upload_data']['file_name'];
					}
				}
				$orderID=random_string('alnum',6);
				
				$rwprd=get_db_single_row("tbl_sound_category","id,cat_name"," AND id='".$this->input->post('cat_id')."'");
				$product='';
				if(is_array($rwprd) && count($rwprd)){
				  $product=$rwprd['cat_name'];
				}
				$preferDate='';
				$prefer_date=$this->input->post('prefer_date');
				if($prefer_date!=''){
				  	$preferdateArr=explode('-',$prefer_date);
					$preferDate=$preferdateArr[2].'-'.$preferdateArr[1].'-'.$preferdateArr[0];
				}
				
				
				$posted_data = array(
									'order_id'      => $orderID,
									
									'order_date'    => $this->config->item('config.date.time'),
									'upd_file'      => $uploaded_file,
									'mem_id'        => $this->session->userdata('user_id'),
									'name'          => $this->name,
									'mem_type'      => $this->userType,
									'phone'         => $this->mobile,
									'email'         => $this->username,
									'order_type'    => 1,
									'prefer_date'   => $preferDate,
									'product_id'    => $this->input->post('cat_id',TRUE),
									'product'       => $product,
									'price'         => $this->input->post('price',TRUE),
									'comment'       => $this->input->post('comment',TRUE),
						 			'pay_mode'      => '',
									'pay_status'    => 1,
									'confirm_status'=> 1,
									'status'        => 1
				);
			$this->member_model->safe_insert('tbl_order',$posted_data,FALSE);
			 $this->session->set_userdata(array('sesorderID'=>$orderID));
			 redirect("member/paymentmethod");
			}
		}
		
		$this->load->view("soundrecording_view",$data);
	}
	
	public function validpreferdate(){
		$prefer_date=$this->input->post('prefer_date');
		$cdate=$this->config->item('config.date');
		
		if(strtotime($cdate) > strtotime($prefer_date)){
		  $this->form_validation->set_message("validpreferdate","Prefered Date is not less than current date");
		  return false;	
		}
	}
	
	public function getrecordingcategorypeice(){
		
		$catID=$this->input->get_post('catID');
		$rwliveinsprice=get_db_single_row("tbl_sound_recording_price","price"," AND sound_recording_category ='$catID'");
		if(is_array($rwliveinsprice) && count($rwliveinsprice) > 0 ){ ?>
			<input name="price" type="text" value="<?php echo $rwliveinsprice['price'];?>" readonly>
		<?php }else{ ?>
			<input name="price" type="text" value="<?php echo set_value('price');?>" readonly>
		<?php }
	}
	
//Sound design start here ..............
  
  public function sounddesigning(){
	  
	   if($this->session->userdata('sessuser_type')==2){
		  
			$this->session->set_userdata(array('msg_type'=>'error'));
			$this->session->set_flashdata('error','Invalid access. Only normal member is allowed');
			redirect("member");	
		}
	  $data['page_title']="Sound Designing";
	  $data['rwdata']=get_db_multiple_row("tbl_designing_price","price_id,duration","status ='1' ORDER BY duration ASC ");
	  
	  if($this->input->post('action')=='Add'){
			$this->form_validation->set_rules('product', 'Title', 'trim|required|max_length[200]');
			$this->form_validation->set_rules('duration', 'Duration', 'trim|required');
			$this->form_validation->set_rules('price', 'Price', 'trim|required');
			$this->form_validation->set_rules('comment', 'Comment', 'trim|required|max_length[888850]');
			$this->form_validation->set_rules('image1','Upload File',"file_required|file_allowed_type[document_image]");
			if($this->form_validation->run()==TRUE)
			{
				$uploaded_file = "";
				if( !empty($_FILES) && $_FILES['image1']['name']!='' )
				{
					
					$this->load->library('upload');
					$uploaded_data =  $this->upload->my_upload('image1','order_file');
					if( is_array($uploaded_data)  && !empty($uploaded_data) )
					{
						$uploaded_file = $uploaded_data['upload_data']['file_name'];
					}
				}
				$orderID=random_string('alnum',6);
				
				$posted_data = array(
									'order_id'      => $orderID,
									
									'order_date'    => $this->config->item('config.date.time'),
									'upd_file'      => $uploaded_file,
									'mem_id'        => $this->session->userdata('user_id'),
									'name'          => $this->name,
									'mem_type'      => $this->userType,
									'phone'         => $this->mobile,
									'email'         => $this->username,
									'order_type'    => 2,
									'product_id'    => 0,
									'duration'       => $this->input->post('duration'),
									'product'       => $this->input->post('product'),
									'price'         => $this->input->post('price',TRUE),
									'comment'       => $this->input->post('comment',TRUE),
						 			'pay_mode'      => '',
									'pay_status'    => 1,
									'confirm_status'=> 1,
									'status'        => 1
				);
			$this->member_model->safe_insert('tbl_order',$posted_data,FALSE);
			 $this->session->set_userdata(array('sesorderID'=>$orderID));
			 redirect("member/paymentmethod");
			}
		}
	  
	  $this->load->view("sounddesigning_view",$data);
  }
  
  public function getsounddesignprice(){
		
		$priceID=$this->input->get_post('priceID');
		$rwliveinsprice=get_db_single_row("tbl_designing_price","price"," AND price_id ='$priceID'");
		if(is_array($rwliveinsprice) && count($rwliveinsprice) > 0 ){ ?>
			<input name="price" type="text" value="<?php echo $rwliveinsprice['price'];?>" readonly>
		<?php }else{ ?>
			<input name="price" type="text" value="<?php echo set_value('price');?>" readonly>
		<?php }
	}
	
	public function mixing(){
		
		if($this->session->userdata('sessuser_type')==2){
		  
			$this->session->set_userdata(array('msg_type'=>'error'));
			$this->session->set_flashdata('error','Invalid access. Only normal member is allowed');
			redirect("member");	
		}
		$data['page_title']="Mixing";
		
		if($this->input->post('action')=='Add'){
			$this->form_validation->set_rules('track_id', 'Track', 'trim|required|max_length[200]');
			$this->form_validation->set_rules('duration', 'Duration', 'trim|required');
			$this->form_validation->set_rules('price', 'Price', 'trim|required');
			$this->form_validation->set_rules('comment', 'Comment', 'trim|required|max_length[888850]');
			$this->form_validation->set_rules('image1','Upload File',"file_required|file_allowed_type[document_image]");
			if($this->form_validation->run()==TRUE)
			{
				$uploaded_file = "";
				if( !empty($_FILES) && $_FILES['image1']['name']!='' )
				{
					
					$this->load->library('upload');
					$uploaded_data =  $this->upload->my_upload('image1','order_file');
					if( is_array($uploaded_data)  && !empty($uploaded_data) )
					{
						$uploaded_file = $uploaded_data['upload_data']['file_name'];
					}
				}
				$orderID=random_string('alnum',6);
				
				$product="Track ".$this->input->post('track_id');
				
				$duration='';
				$rwdesigndurArr=get_db_single_row("tbl_mixing_price","duration"," AND price_id ='".$this->input->post('duration')."'");
				if(is_array($rwdesigndurArr) && count($rwdesigndurArr) > 0 ){
					$duration=$rwdesigndurArr['duration'];
				}
				
				
				$posted_data = array(
									'order_id'      => $orderID,
									
									'order_date'    => $this->config->item('config.date.time'),
									'upd_file'      => $uploaded_file,
									'mem_id'        => $this->session->userdata('user_id'),
									'name'          => $this->name,
									'mem_type'      => $this->userType,
									'phone'         => $this->mobile,
									'email'         => $this->username,
									'order_type'    => 6,
									'product_id'    => 0,
									'duration'      => $duration,
									'product'       => $product,
									'price'         => $this->input->post('price',TRUE),
									'comment'       => $this->input->post('comment',TRUE),
						 			'pay_mode'      => '',
									'pay_status'    => 1,
									'confirm_status'=> 1,
									'status'        => 1
				);
			 $this->member_model->safe_insert('tbl_order',$posted_data,FALSE);
			 $this->session->set_userdata(array('sesorderID'=>$orderID));
			 redirect("member/paymentmethod");
			}
		}
		
		$this->load->view("mixing_view",$data);
		
	}
	
	
	
	public function getmixingduration(){
		
		$trackID=$this->input->get_post('trackID');
		$rwdesigndurArr=get_db_multiple_row("tbl_mixing_price","duration,price_id","track_id ='$trackID'");
		?>
        <option value="">Duration</option>
		<?php
		 if(is_array($rwdesigndurArr) && count($rwdesigndurArr) > 0 ){
			 foreach($rwdesigndurArr as $durVal){ ?>
            <option value="<?php echo $durVal['price_id'];?>"><?php echo $durVal['duration'];?> Minutes</option>   
       <?php }
		 }
	}
	
	public function getmixingprice(){
		
		$priceID=$this->input->get_post('priceID');
		$rwliveinsprice=get_db_single_row("tbl_mixing_price","price"," AND price_id ='$priceID'");
		if(is_array($rwliveinsprice) && count($rwliveinsprice) > 0 ){ ?>
			<input name="price" type="text" value="<?php echo $rwliveinsprice['price'];?>" readonly>
		<?php }else{ ?>
			<input name="price" type="text" value="<?php echo set_value('price');?>" readonly>
		<?php }
	}
	
	
	public function liveinstrument(){
		
		if($this->session->userdata('sessuser_type')==2){
		  
			$this->session->set_userdata(array('msg_type'=>'error'));
			$this->session->set_flashdata('error','Invalid access. Only normal member is allowed');
			redirect("member");	
		}
		
		$data['page_title']="Live Instrument";
		$data['rwdata']=get_db_multiple_row('tbl_instrument_type',"id,title","ins_type ='1' AND status='1' ORDER BY title ");
		if($this->input->post('action')=='Add'){
			$this->form_validation->set_rules('instype[]', 'Category', 'trim|required|max_length[200]');
			$this->form_validation->set_rules('prefer_date', 'Preferred Date', 'trim|required|callback_validpreferdate');
			$this->form_validation->set_rules('comment', 'Comment', 'trim|required|max_length[888850]');
			$this->form_validation->set_rules('image1','Upload File',"file_required|file_allowed_type[document_image]");
			if($this->form_validation->run()==TRUE)
			{
				$uploaded_file = "";
				if( !empty($_FILES) && $_FILES['image1']['name']!='' )
				{
					
					$this->load->library('upload');
					$uploaded_data =  $this->upload->my_upload('image1','order_file');
					if( is_array($uploaded_data)  && !empty($uploaded_data) )
					{
						$uploaded_file = $uploaded_data['upload_data']['file_name'];
					}
				}
				$instype=$this->input->post('instype');
				if(is_array($instype) && count($instype) > 0 ){
				 $instypeid=implode(",",$instype); 	
				}
				$preferdate="";
				if($this->input->post('prefer_date') !=''){
				  $preferdateArr=explode(',',$this->input->post('prefer_date'));
				  $preferdate=$preferdateArr[2].'-'.$preferdateArr[1].'-'.$preferdateArr[0];	
				}
				
				
				$posted_data = array(
									'post_date'    => $this->config->item('config.date.time'),
									'upd_file'      => $uploaded_file,
									'mem_id'        => $this->session->userdata('user_id'),
									'name'          => $this->name,
									'mobile'        => $this->mobile,
									'email'         => $this->username,
									'category'    => $instypeid,
									'preffered_date'    => $preferdate,
									'comment'       => $this->input->post('comment',TRUE),									'status'        => 1
				);
			$this->member_model->safe_insert('tbl_live_instrument_enquiry',$posted_data,FALSE);
			$this->session->set_userdata(array('msg_type'=>'success'));
			$this->session->set_flashdata('success',"Your enquiry has been added successfully.We will back to you soon...");
			 redirect("member/liveinstrument");
			}
		}
		$this->load->view("liveinstrument_view",$data);
	}
	
	public function virtualinstrument(){
		
		if($this->session->userdata('sessuser_type')==2){
		  
			$this->session->set_userdata(array('msg_type'=>'error'));
			$this->session->set_flashdata('error','Invalid access. Only normal member is allowed');
			redirect("member");	
		}
		$data['page_title']="Virtual Instrument";
		$data['rwinstypeArr']=get_db_multiple_row("tbl_instrument_type","id,title","ins_type ='2' AND status='1' ORDER BY title ASC ");
		
		if($this->input->post('action')=='Add'){
			$this->form_validation->set_rules('instype', 'Instrument Type', 'trim|required|max_length[200]');
			$this->form_validation->set_rules('duration', 'Duration', 'trim|required');
			$this->form_validation->set_rules('price', 'Price', 'trim|required');
			$this->form_validation->set_rules('comment', 'Comment', 'trim|required|max_length[888850]');
			$this->form_validation->set_rules('image1','Upload File',"file_required|file_allowed_type[document_image]");
			if($this->form_validation->run()==TRUE)
			{
				$uploaded_file = "";
				if( !empty($_FILES) && $_FILES['image1']['name']!='' )
				{
					
					$this->load->library('upload');
					$uploaded_data =  $this->upload->my_upload('image1','order_file');
					if( is_array($uploaded_data)  && !empty($uploaded_data) )
					{
						$uploaded_file = $uploaded_data['upload_data']['file_name'];
					}
				}
				$orderID=random_string('alnum',6);
				
				$product="";
				$rwprd=get_db_single_row("tbl_instrument_type","id,title"," AND id='".$this->input->post('instype')."'");
				$product='';
				if(is_array($rwprd) && count($rwprd)){
				  $product=$rwprd['title'];
				}
				$duration='';
				$rwdesigndurArr=get_db_single_row("tbl_virtual_instru_price","duration"," AND price_id ='".$this->input->post('duration')."'");
				if(is_array($rwdesigndurArr) && count($rwdesigndurArr) > 0 ){
					$duration=$rwdesigndurArr['duration'];
				}
				
				$posted_data = array(
									'order_id'      => $orderID,
									'order_date'    => $this->config->item('config.date.time'),
									'upd_file'      => $uploaded_file,
									'mem_id'        => $this->session->userdata('user_id'),
									'name'          => $this->name,
									'mem_type'      => $this->userType,
									'phone'         => $this->mobile,
									'email'         => $this->username,
									'order_type'    => 3,
									'product_id'    => $this->input->post('instype'),
									'duration'      => $duration,
									'product'       => $product,
									'price'         => $this->input->post('price',TRUE),
									'comment'       => $this->input->post('comment',TRUE),
						 			'pay_mode'      => '',
									'pay_status'    => 1,
									'confirm_status'=> 1,
									'status'        => 1
				);
			$this->member_model->safe_insert('tbl_order',$posted_data,FALSE);
			 $this->session->set_userdata(array('sesorderID'=>$orderID));
			 redirect("member/paymentmethod");
			}
		}
		
		$this->load->view("virtualinstrument_view",$data);
	}
	
	
	public function getvirtualinstrumentduration(){
		
		$instypeID=$this->input->get_post('instypeID');
		$rwdesigndurArr=get_db_multiple_row("tbl_virtual_instru_price","duration,price_id","instrument_type ='$instypeID'");
		?>
        <option value="">Duration</option>
		<?php
		 if(is_array($rwdesigndurArr) && count($rwdesigndurArr) > 0 ){
			 foreach($rwdesigndurArr as $durVal){ ?>
            <option value="<?php echo $durVal['price_id'];?>"><?php echo $durVal['duration'];?> Minutes</option>   
       <?php }
		 }
	}
	
	public function getvirtualinstrumentdurationprice(){
		
		$priceID=$this->input->get_post('priceID');
		$rwliveinsprice=get_db_single_row("tbl_virtual_instru_price","price"," AND price_id ='$priceID'");
		if(is_array($rwliveinsprice) && count($rwliveinsprice) > 0 ){ ?>
			<input name="price" type="text" value="<?php echo $rwliveinsprice['price'];?>" readonly>
		<?php }else{ ?>
			<input name="price" type="text" value="<?php echo set_value('price');?>" readonly>
		<?php }
	}
	
	
	public function lyrics(){
		
		if($this->session->userdata('sessuser_type')==2){
		  
			$this->session->set_userdata(array('msg_type'=>'error'));
			$this->session->set_flashdata('error','Invalid access. Only normal member is allowed');
			redirect("member");	
		}
		
		$data['page_title']="Lyrics";
		$this->load->view("lyrics_view",$data);
		
	}
	
	public function singlemusicalpiece(){
	    
		if($this->session->userdata('sessuser_type')==2){
		  
			$this->session->set_userdata(array('msg_type'=>'error'));
			$this->session->set_flashdata('error','Invalid access. Only normal member is allowed');
			redirect("member");	
		}
			
	   $data['page_title']="Single Musical Piece";
	   $data['rwdata']=get_db_multiple_row("tbl_lyrics_price","price_id,duration","lyrics_type ='1' AND status='1' ORDER BY duration ASC ");
	   
	   if($this->input->post('action')=='Add'){
			$this->form_validation->set_rules('title', 'Title', 'trim|required|max_length[200]');
			$this->form_validation->set_rules('duration', 'Duration', 'trim|required');
			$this->form_validation->set_rules('price', 'Price', 'trim|required');
			$this->form_validation->set_rules('comment', 'Comment', 'trim|required|max_length[888850]');
			$this->form_validation->set_rules('image1','Upload File',"file_required|file_allowed_type[document_image]");
			if($this->form_validation->run()==TRUE)
			{
				$uploaded_file = "";
				if( !empty($_FILES) && $_FILES['image1']['name']!='' )
				{
					
					$this->load->library('upload');
					$uploaded_data =  $this->upload->my_upload('image1','order_file');
					if( is_array($uploaded_data)  && !empty($uploaded_data) )
					{
						$uploaded_file = $uploaded_data['upload_data']['file_name'];
					}
				}
				$orderID=random_string('alnum',6);
				$duration='';
				$rwdesigndurArr=get_db_single_row("tbl_lyrics_price","duration"," AND price_id ='".$this->input->post('duration')."'");
				if(is_array($rwdesigndurArr) && count($rwdesigndurArr) > 0 ){
					$duration=$rwdesigndurArr['duration'];
				}
				$posted_data = array(
									'order_id'      => $orderID,
									
									'order_date'    => $this->config->item('config.date.time'),
									'upd_file'      => $uploaded_file,
									'mem_id'        => $this->session->userdata('user_id'),
									'name'          => $this->name,
									'mem_type'      => $this->userType,
									'phone'         => $this->mobile,
									'email'         => $this->username,
									'order_type'    => 4,
									'product_id'    => 0,
									'duration'      => $duration,
									'product'       => $this->input->post('title'),
									'price'         => $this->input->post('price',TRUE),
									'comment'       => $this->input->post('comment',TRUE),
						 			'pay_mode'      => '',
									'pay_status'    => 1,
									'confirm_status'=> 1,
									'status'        => 1
				);
			$this->member_model->safe_insert('tbl_order',$posted_data,FALSE);
			 $this->session->set_userdata(array('sesorderID'=>$orderID));
			 redirect("member/paymentmethod");
			}
		}
	   $this->load->view("singlemusicalpiece_view",$data);	
	}
	
	
	
	public function getsinglemusicalpieceprice(){
		
		$priceID=$this->input->get_post('priceID');
		$rwliveinsprice=get_db_single_row("tbl_lyrics_price","price"," AND price_id ='$priceID'");
		if(is_array($rwliveinsprice) && count($rwliveinsprice) > 0 ){ ?>
			<input name="price" type="text" value="<?php echo $rwliveinsprice['price'];?>" readonly>
		<?php }else{ ?>
			<input name="price" type="text" value="<?php echo set_value('price');?>" readonly>
		<?php }
	}
	
	public function fullalbumlyrics(){
		
		if($this->session->userdata('sessuser_type')==2){
		  
			$this->session->set_userdata(array('msg_type'=>'error'));
			$this->session->set_flashdata('error','Invalid access. Only normal member is allowed');
			redirect("member");	
		}
		$data['page_title']="Full Album Lyrics";
		$rwdata=get_db_multiple_row("tbl_lyrics_price","price_id,duration","lyrics_type ='2' AND status='1' ORDER BY duration ASC ");
		$data['rwdata']=$rwdata;
		
		 if($this->input->post('action')=='Add'){
			$this->form_validation->set_rules('title', 'Title', 'trim|required|max_length[200]');
			$this->form_validation->set_rules('duration', 'Duration', 'trim|required');
			$this->form_validation->set_rules('price', 'Price', 'trim|required');
			$this->form_validation->set_rules('comment', 'Comment', 'trim|required|max_length[888850]');
			$this->form_validation->set_rules('image1','Upload File',"file_required|file_allowed_type[document_image]");
			if($this->form_validation->run()==TRUE)
			{
				$uploaded_file = "";
				if( !empty($_FILES) && $_FILES['image1']['name']!='' )
				{
					
					$this->load->library('upload');
					$uploaded_data =  $this->upload->my_upload('image1','order_file');
					if( is_array($uploaded_data)  && !empty($uploaded_data) )
					{
						$uploaded_file = $uploaded_data['upload_data']['file_name'];
					}
				}
				$orderID=random_string('alnum',6);
				
				$duration='';
				$rwdesigndurArr=get_db_single_row("tbl_lyrics_price","duration"," AND price_id ='".$this->input->post('duration')."'");
				if(is_array($rwdesigndurArr) && count($rwdesigndurArr) > 0 ){
					$duration=$rwdesigndurArr['duration'];
				}
				
				
				$posted_data = array(
									'order_id'      => $orderID,
									
									'order_date'    => $this->config->item('config.date.time'),
									'upd_file'      => $uploaded_file,
									'mem_id'        => $this->session->userdata('user_id'),
									'name'          => $this->name,
									'mem_type'      => $this->userType,
									'phone'         => $this->mobile,
									'email'         => $this->username,
									'order_type'    => 5,
									'product_id'    => 0,
									'duration'      => $duration,
									'product'       => $this->input->post('title'),
									'price'         => $this->input->post('price',TRUE),
									'comment'       => $this->input->post('comment',TRUE),
						 			'pay_mode'      => '',
									'pay_status'    => 1,
									'confirm_status'=> 1,
									'status'        => 1
				);
			$this->member_model->safe_insert('tbl_order',$posted_data,FALSE);
			 $this->session->set_userdata(array('sesorderID'=>$orderID));
			 redirect("member/paymentmethod");
			}
		}
		
		$this->load->view("fullalbumlyrics_view",$data);	
	}
	
	public function getfullmusicalpieceprice(){
		
		$priceID=$this->input->get_post('priceID');
		$rwliveinsprice=get_db_single_row("tbl_lyrics_price","price"," AND price_id ='$priceID'");
		if(is_array($rwliveinsprice) && count($rwliveinsprice) > 0 ){ ?>
			<input name="price" type="text" value="<?php echo $rwliveinsprice['price'];?>" readonly>
		<?php }else{ ?>
			<input name="price" type="text" value="<?php echo set_value('price');?>" readonly>
		<?php }
	}
	
	
	public function mastering(){
		
		if($this->session->userdata('sessuser_type')==2){
		  
			$this->session->set_userdata(array('msg_type'=>'error'));
			$this->session->set_flashdata('error','Invalid access. Only normal member is allowed');
			redirect("member");	
		}
		$data['page_title']="Mastering";
		$this->load->view("mastering_view",$data);	
	}
	
	public function singlesongmastering(){
		
		if($this->session->userdata('sessuser_type')==2){
		  
			$this->session->set_userdata(array('msg_type'=>'error'));
			$this->session->set_flashdata('error','Invalid access. Only normal member is allowed');
			redirect("member");	
		}
		$data['page_title']="Single Song Mastering";
		$data['rwdata']=get_db_multiple_row("tbl_mastring_price","price_id,duration","mastring_type ='1' AND status='1' ORDER BY duration ASC ");
		
		 if($this->input->post('action')=='Add'){
			$this->form_validation->set_rules('title', 'Song Title', 'trim|required|max_length[200]');
			$this->form_validation->set_rules('duration', 'Duration', 'trim|required');
			$this->form_validation->set_rules('price', 'Price', 'trim|required');
			$this->form_validation->set_rules('comment', 'Comment', 'trim|required|max_length[888850]');
			$this->form_validation->set_rules('image1','Upload File',"file_required|file_allowed_type[document_image]");
			if($this->form_validation->run()==TRUE)
			{
				$uploaded_file = "";
				if( !empty($_FILES) && $_FILES['image1']['name']!='' )
				{
					
					$this->load->library('upload');
					$uploaded_data =  $this->upload->my_upload('image1','order_file');
					if( is_array($uploaded_data)  && !empty($uploaded_data) )
					{
						$uploaded_file = $uploaded_data['upload_data']['file_name'];
					}
				}
				$orderID=random_string('alnum',6);
				
				$duration='';
				$rwdesigndurArr=get_db_single_row("tbl_mastring_price","duration"," AND price_id ='".$this->input->post('duration')."'");
				if(is_array($rwdesigndurArr) && count($rwdesigndurArr) > 0 ){
					$duration=$rwdesigndurArr['duration'];
				}
				
				
				$posted_data = array(
									'order_id'      => $orderID,
									
									'order_date'    => $this->config->item('config.date.time'),
									'upd_file'      => $uploaded_file,
									'mem_id'        => $this->session->userdata('user_id'),
									'name'          => $this->name,
									'mem_type'      => $this->userType,
									'phone'         => $this->mobile,
									'email'         => $this->username,
									'order_type'    => 7,
									'product_id'    => 0,
									'duration'      => $duration,
									'product'       => $this->input->post('title'),
									'price'         => $this->input->post('price',TRUE),
									'comment'       => $this->input->post('comment',TRUE),
						 			'pay_mode'      => '',
									'pay_status'    => 1,
									'confirm_status'=> 1,
									'status'        => 1
				);
			$this->member_model->safe_insert('tbl_order',$posted_data,FALSE);
			 $this->session->set_userdata(array('sesorderID'=>$orderID));
			 redirect("member/paymentmethod");
			}
		}
		$this->load->view("singlesongmastering_view",$data);
	}
	
	public function getsinglesongmasteringprice(){
		
		$priceID=$this->input->get_post('priceID');
		$rwliveinsprice=get_db_single_row("tbl_mastring_price","price"," AND price_id ='$priceID'");
		if(is_array($rwliveinsprice) && count($rwliveinsprice) > 0 ){ ?>
			<input name="price" type="text" value="<?php echo $rwliveinsprice['price'];?>" readonly>
		<?php }else{ ?>
			<input name="price" type="text" value="<?php echo set_value('price');?>" readonly>
		<?php }
	}
	
	public function fullalbummastering(){
	   
	   	if($this->session->userdata('sessuser_type')==2){
		  
			$this->session->set_userdata(array('msg_type'=>'error'));
			$this->session->set_flashdata('error','Invalid access. Only normal member is allowed');
			redirect("member");	
		}
		$data['page_title']="Full Album Mastering";
		$data['rwdata']=get_db_multiple_row("tbl_mastring_price","price_id,duration","mastring_type ='2' AND status='1' ORDER BY duration ASC ");
		 if($this->input->post('action')=='Add'){
			$this->form_validation->set_rules('title', 'Album Title', 'trim|required|max_length[200]');
			$this->form_validation->set_rules('track[]', 'Track', 'trim|required');
			$this->form_validation->set_rules('price', 'Price', 'trim|required');
			$this->form_validation->set_rules('comment', 'Comment', 'trim|required|max_length[888850]');
			$this->form_validation->set_rules('image1','Upload File',"file_required|file_allowed_type[document_image]");
			if($this->form_validation->run()==TRUE)
			{
				$uploaded_file = "";
				if( !empty($_FILES) && $_FILES['image1']['name']!='' )
				{
					
					$this->load->library('upload');
					$uploaded_data =  $this->upload->my_upload('image1','order_file');
					if( is_array($uploaded_data)  && !empty($uploaded_data) )
					{
						$uploaded_file = $uploaded_data['upload_data']['file_name'];
					}
				}
				$orderID=random_string('alnum',6);
				
				$album_track='';
				$trackArr=$this->input->post('track');
				
				if(is_array($trackArr) && count($trackArr) > 0 ){
				  foreach($trackArr as $val){
					  
					  $trackduration=get_db_field_value("tbl_mastring_price","duration","WHERE price_id ='".$val."'");
					  $album_track.="Track ".$trackduration.',';
				  }
				}
				$album_track=rtrim($album_track,',');
				
				$posted_data = array(
									'order_id'      => $orderID,
									
									'order_date'    => $this->config->item('config.date.time'),
									'upd_file'      => $uploaded_file,
									'mem_id'        => $this->session->userdata('user_id'),
									'name'          => $this->name,
									'mem_type'      => $this->userType,
									'phone'         => $this->mobile,
									'email'         => $this->username,
									'order_type'    => 7,
									'product_id'    => 0,
									'duration'      => 0,
									'album_track'   => $album_track,
									'product'       => $this->input->post('title'),
									'price'         => $this->input->post('price',TRUE),
									'comment'       => $this->input->post('comment',TRUE),
						 			'pay_mode'      => '',
									'pay_status'    => 1,
									'confirm_status'=> 1,
									'status'        => 1
				);
			$this->member_model->safe_insert('tbl_order',$posted_data,FALSE);
			 $this->session->set_userdata(array('sesorderID'=>$orderID));
			 redirect("member/paymentmethod");
			}
		}
		$this->load->view("fullalbummastering_view",$data);
	}
	
	
	
	public function getfullalbummasteringprice(){
		
		
		$ids=$this->input->get_post('ids');
		$price='';
		if($ids !=''){
			
			$idsArr=explode(',',$ids);
			if(is_array($idsArr) && count($idsArr) > 0 ){
			  foreach($idsArr as $val){
				 $rwliveinsprice=get_db_single_row("tbl_mastring_price","price"," AND price_id ='$val'"); 
				 if(is_array($rwliveinsprice) && count($rwliveinsprice) > 0 ){
					$price=$price+$rwliveinsprice['price']; 
				 }
			  }
			}
		}
		if($price > 0 ){ ?>
			<input name="price" type="text" value="<?php echo $price;?>" readonly>
	 <?php	}else{ ?>
            <input name="price" type="text" value="<?php echo set_value('price');?>" readonly>
	 <?php
	 }
	}
	
	public function enquiry(){
		
		$record_per_page         = (int) $this->input->post('per_page')? $this->input->post('per_page'): $this->config->item('per_page');
		$config['per_page']      = ( $record_per_page > 0 ) ? $record_per_page : $this->config->item('per_page');
		$record_per_page        = (int) $this->input->post('per_page');
        $parent_segment         = (int) $this->uri->segment(3);
        $page_segment           = find_paging_segment();
		$offset                  = (int) $this->uri->segment($page_segment,0);
		$limit                   = $config['per_page'];
		$cond                    = "";
		$res_array2              = $this->member_model->get_enquiry($limit, $offset);
		//echo_sql();
		
		$config['total_rows']    = $data['totalProduct']= $this->member_model->total_rec_found;
		$base_url                = "member/enquiry/pg/";
		$data['frm_url']         = $base_url;
		$data['page_links']      = front_pagination("$base_url",$config['total_rows'],$config['per_page'],$page_segment);
		
		$data['per_page']        = $config['per_page'];
		$data['record_per_page'] = $record_per_page;
		$data['res']             = $res_array2;
		$data['offset']          = $offset;
		$data['page_heading']    = "Enquiry";
		$this->load->view("enquiry_view",$data);
	}
	
	
	public function orders(){
		
		$record_per_page         = (int) $this->input->post('per_page')? $this->input->post('per_page'): $this->config->item('per_page');
		$config['per_page']      = ( $record_per_page > 0 ) ? $record_per_page : $this->config->item('per_page');
		$record_per_page        = (int) $this->input->post('per_page');
        $parent_segment         = (int) $this->uri->segment(3);
        $page_segment           = find_paging_segment();
		$offset                  = (int) $this->uri->segment($page_segment,0);
		$limit                   = $config['per_page'];
		$cond                    = "";
		$res_array2              = $this->member_model->get_orders($limit, $offset);
		//echo_sql();
		
		$config['total_rows']    = $data['totalProduct']= $this->member_model->total_rec_found;
		$base_url                = "member/orders/pg/";
		$data['frm_url']         = $base_url;
		$data['page_links']      = front_pagination("$base_url",$config['total_rows'],$config['per_page'],$page_segment);
		
		$data['per_page']        = $config['per_page'];
		$data['record_per_page'] = $record_per_page;
		$data['res']             = $res_array2;
		$data['offset']          = $offset;
		$data['page_heading']    = "Order";
		$this->load->view("order_view",$data);
	}
	
	public function downloadordfile(){
		
		$this->load->helper("download");
		$orderID=$this->uri->segment(3);
		$rwdata=get_db_single_row("tbl_order","upd_file"," AND order_id='$orderID'");
		if(is_array($rwdata) && count($rwdata) > 0 ){
			
			if($rwdata['upd_file']!='' && file_exists(UPLOAD_DIR.'/order_file/'.$rwdata['upd_file'])){
				$pth    =   file_get_contents(base_url()."uploaded_files/order_file/".$rwdata['upd_file']);
				$nme    =   $rwdata['upd_file'];
				force_download($nme, $pth);     
			}
			
		}
		
	}
	
	


}
/* End of file member.php */
/* Location: .application/modules/member/member.php ccvcvvc  v vbvvbvbv bv bv v v*/