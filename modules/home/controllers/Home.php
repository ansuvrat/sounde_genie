<?php
class Home extends Public_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('home/home_model','pages/pages_model'));
	}

	public function index()
	{
		$data['page_title']="Home";
		$data['rwbanner']=get_db_multiple_row("tbl_home_banner","*","status ='1' ");
		
		$condition       = array('page_id'=>1,'status'=>'1');
		$content         =  $this->pages_model->get_cms_page( $condition );
		$data['content'] = $content;
		
		$rwdata=get_db_multiple_row("tbl_cms_youtube","description,type","status ='1'");
		$composition='';
		$lyrics='';
		$mixing='';
		$recording='';
		if(is_array($rwdata) && count($rwdata) > 0 ){
			foreach($rwdata as $val){
			   
			   if($val['type']==1){
				 $composition=$val['description'];  
			   }
			   if($val['type']==2){
				 $lyrics=$val['description'];  
			   }
			   if($val['type']==3){
				 $mixing=$val['description'];  
			   }
			   if($val['type']==6){
				 $recording=$val['description'];  
			   }
				
			}
		}
		$data['composition']=$composition;
		$data['lyrics']=$lyrics;
		$data['mixing']=$mixing;
		$data['recording']=$recording;
		
		$this->load->view('home',$data);
	}
	
	
}