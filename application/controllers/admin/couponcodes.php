<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class couponCodes extends CI_Controller {
	public function __construct()
	{
        parent::__construct();
		$userAdmin=$this->session->userdata(APP_NAME.'_admin');
		if($userAdmin==false){
			redirect(base_url()."admin/index/login");
			exit();
		}
		$this->load->model('couponcodesmodel','model');
		$this->load->helper('my_helper');
		
	}
	
/*	public function index(){
		$ajax=$this->input->get('ajax');
		$page=$this->input->get('page');
		$key=$this->input->post('key');
		$id=$this->input->get('id');
		if($id!==false && $id>0){
			//Delete content
			$contentData=$this->model->getContentDetails($id);
			if(is_array($contentData) && count($contentData)>0){
				$dt=array('id'=>$contentData['id'],'status'=>0);
				$this->model->updateContent($dt);
			}
		}
		
		$sortBy=$this->input->post('sortBy');
		$limit=LIMIT;
		$page=($page==false) ? 1 : $page; 
		$offSet=($page>1) ? ($page-1)*$limit : 0;
		$sortBy=($sortBy==false) ? 'id' : $sortBy;
		
		$data=$this->model->getCouponCodes();
		$assignData=array('pageName'=>'couponcode','data'=>$data);
		
		if($ajax!=1){
			$this->load->view('admin/header',$assignData);
		}
		$this->load->view('admin/couponcodes',$assignData);
		if($ajax!=1){
			$this->load->view('admin/footer');
		}
	} */
	
	public function index(){
		$ajax=$this->input->get('ajax');
		$page=$this->input->get('page');
		$key=$this->input->post('key');
		$limit=LIMIT;
		$page=($page==false) ? 1 : $page; 
		$offSet=($page>1) ? ($page-1)*$limit : 0;
		
		$data=$this->model->getCoupons();
		$assignData=array('pageName'=>'couponcodes','data'=>$data);
		
		if($ajax!=1){
			$this->load->view('admin/header',$assignData);
		}
		$this->load->view('admin/couponcodes',$assignData);
		if($ajax!=1){
			$this->load->view('admin/footer');
		}
	}
	
	public function edit(){
		$id = $this->input->get('id');
		$data=$this->model->getCouponCodeDetails($id);
		$contentData=array('pageName'=>'couponcode','data'=>$data);
		$this->load->view('admin/header',$contentData);
		$this->load->view('admin/editcouponcode',$contentData);
		$this->load->view('admin/footer');
	}

	public function email(){
			$id = $this->input->get('id');
			$data=$this->model->getCouponCodeDetails($id);
			$restaurants=$this->model->getAllRestaurants();
			$contentData=array('pageName'=>'couponcode','data'=>$data,'restaurants'=>$restaurants);
			$this->load->view('admin/header',$contentData);
			$this->load->view('admin/emailcouponcode',$contentData);
			$this->load->view('admin/footer');
			
			
	}
	
	public function emailCouponCodes(){
		$restaurant_email				= ($this->input->post('restaurant_select')=="restaurant")?$this->input->post('restaurant'):$this->input->post('restaurant1');
	   	$code			= $this->input->post('code');
		//$id			= $this->input->post('id');		
		
		if($restaurant_email=="")
		{
			echo "Please Select An Email";
			exit;
		}
		
		
		$description="Hello and welcome to Grub club! congratulation You got a Coupon.the code is $code
			
			";
			/*$this->email->from('info@petdar', 'petdar');
			$this->email->to("".$data['user_detail']['email'].""); 
			$this->email->subject('Welcome to Petdar');
			$this->email->message($description);	
			$this->email->send();*/
			
			$to 	= $restaurant_email;
			$subject = "Coupon Code";
			
			$message = $description;
			
			// Always set content-type when sending HTML email
			$headers = "MIME-Version: 1.0" . "\r\n";
			$headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
			
			// More headers
			$headers .= 'From: <admin@grubclub.com>' . "\r\n";
			
			mail($to,$subject,$message,$headers);
			
		redirect(base_url()."admin/couponcodes/");
	}
	
	public function update(){
		$id=$this->input->get_post('id');	
		$status	= $this->input->post('status');
	   	$discount = $this->input->post('discount');

		$data = array(
					'id'=>$id,
					'discount_ratio'=>$discount,
					'status'=>$status
				);
		$data = $this->model->updateCouponCode($data);
		$contentData=array('pageName'=>'couponcodes','data'=>$data);
		redirect(base_url()."admin/couponcodes/");
	}
	
	public function add(){
	  	$contentData=array('pageName'=>'couponcodes');
		$this->load->view('admin/header',$contentData);
		$this->load->view('admin/addcouponcodes');
		$this->load->view('admin/footer');
	}
	
    public function addCouponCode(){
		 
	   	$coupon_code	= $this->input->post('coupon_code');
		$discount	= $this->input->post('discount');
		$status	= $this->input->post('status');		
		$dt=array('code'=>$coupon_code,'discount_ratio'=>$discount,'status'=>$status,'creation_date'=>date( 'Y-m-d H:i:s'));
		$this->model->addCouponCode($dt);
		redirect(base_url()."admin/couponcodes/");
	}

	public function delete(){
		$id	= $this->input->get('id');
		$dt=array('id'=>$id);
		$this->model->deleteCouponCode($dt);
		redirect(base_url()."admin/couponcodes/"); 
	}
	
}