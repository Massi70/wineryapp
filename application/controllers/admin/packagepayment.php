<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class PackagePayment extends CI_Controller {
	
	public function __construct(){
        parent::__construct();
		$userAdmin=$this->session->userdata(APP_NAME.'_admin');
		if($userAdmin==false){
			redirect(base_url()."admin/index/login");
			exit();
		}
		$this->load->model('adminModel');
		$this->load->model('paymentwebModel');
		$this->load->helper('my_helper');
		
	}
	
	public function index(){
			$data=$this->paymentwebModel->packagePayment();
			$assignData = array('pageName'=>'packagepayment','data'=>$data);
			$this->load->view('admin/header',$assignData);
			$this->load->view('admin/packagepayment',$assignData);
			$this->load->view('admin/footer');
	}
	
/*	public function addOperator(){
		$msg='';
		$assignData=array('pageName'=>'addoperators');
		if(count($_POST)>0){
			$appType = $this->input->get_post('estate');
			$operatorname=$this->input->get_post('operatorname');
			$password =$this->input->get_post('password');
			$email =$this->input->get_post('email');
			$country =$this->input->get_post('country');
			$province = $this->input->get_post('province');
			$address = $this->input->get_post('address');
			$contact = $this->input->get_post('contact');
			$link = $this->input->get_post('link');
			$file=$this->input->get_post('file');
			 $imgName = time();
			 $imgPath = BASEPATH."../uploads/".$imgName;
			 $image = base_url().'uploads/'.$imgName;
			 move_uploaded_file($_FILES["file"]["tmp_name"],$imgPath.".jpg");
			 $this->load->library('imagethumb');
			 $this->imagethumb->image($imgPath.".jpg",200,200);
			 $imageNew =$imgName."_thumb.jpg";
			 $checkUser = $this->adminModel->checkUserEmail($email);
			 if($checkUser == 0){
				$data = array(
					'user_type_id'=>3,
					'app_type_id'=>$appType,
					'user_name'=>$operatorname,
					'password'=>base64_encode($password),
					'image'=>$imageNew,
					'user_status'=>'1',
					'user_email'=>$email,
					'country'=>$country,
					'province'=>$province,
					'address'=>$address,
					'contact'=>$contact,
					'link'=>$link,
				);
				$operatorId = $this->adminModel->addOperator($data);
				$assignData=array('pageName'=>'addOperator','data'=>$data);
				ob_start(); //Turn on output buffering ?>
					Thank You! You have Successfully created the Account....
				<?php
					 //echo "Thank You! You have Successfully created the Account....";
					$var = ob_get_clean();
													
					$this->load->library('email');
					$this->email->from('no-reply@britishwinery.com', 'British Winery');
					$this->email->to($email);
					$this->email->subject('Hey ! you have Got Mail from British Winery');
					$this->email->message($var);
					$this->email->send();
					$this->email->print_debugger();
					redirect(base_url().'admin/touroperators/?type_id=all');
			}else{
				$msg = '<center><span style="color:#F00">Email Already Exists</span><center>';
				$assignData = array('pageName'=>'addoperator','checkUser'=>$checkUser,'msg'=>$msg);
				$this->load->view('admin/header',$assignData);
				$this->load->view('admin/addoperator',$assignData);
				$this->load->view('admin/footer');
			}
			}else{
				$this->load->view('admin/header',$assignData);
				$this->load->view('admin/addoperator');
				$this->load->view('admin/footer',$assignData);
		}
	}
	
	public function view(){
			$id=$this->input->get_post('id');
			$data = $this->adminModel->getOperatorDetails($id);
			$assignData=array('pageName'=>'tourOperators','data'=>$data);
			$this->load->view('admin/header',$assignData);
			$this->load->view('admin/operatorview',$assignData);
			$this->load->view('admin/footer');

	}
	
	public function delete(){	
		$id=$this->input->get_post('id');
		if($id > 0){
			  $this->adminModel->deleteOperator($id);
		}
			redirect(base_url().'admin/touroperators/?type_id=all');
	}*/
	
	public function edit(){
			$id=$this->input->get_post('id');
			$data = $this->paymentwebModel->getPackagePayment($id);
			$assignData=array('pageName'=>'packagepayment','data'=>$data);
			$this->load->view('admin/header',$assignData);
			$this->load->view('admin/updatepackagepayment',$assignData);
			$this->load->view('admin/footer');
	}
		
	public function update(){
			$id=$this->input->get_post('id');
			$payment_total=$this->input->get_post('payment_total');
       		$data = array(
					'payment_total'=>$payment_total
				);
			$data = $this->paymentwebModel->updatePackagePayment($data,$id);
			$assignData=array('pageName'=>'packagepayment','data'=>$data);
			$this->load->view('admin/header',$assignData);
			$this->load->view('admin/packagepayment',$assignData);
			$this->load->view('admin/footer');
			redirect(base_url().'admin/packagepayment/');
    }
	
}
?>