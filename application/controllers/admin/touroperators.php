<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class tourOperators extends CI_Controller {
	
	public function __construct(){
        parent::__construct();
		$userAdmin=$this->session->userdata(APP_NAME.'_admin');
		if($userAdmin==false){
			redirect(base_url()."admin/index/login");
			exit();
		}
		$this->load->model('adminModel');
		$this->load->helper('my_helper');
		
	}
	
	public function index(){
		$ajax=$this->input->get('ajax');
		$page=$this->input->get('page');
		$key=$this->input->post('key');
		
		$limit='50';
		$page=($page==false) ? 1 : $page; 
		
		$offSet=($page>1) ? ($page-1)*$limit : 0;
		$this->load->helper('pagination_helper');
		$pagination=Pagination_helper::getInstance();
		if($key!=false){
			$AllOperators=$this->adminModel->countAllOperators($key);
			$data=$this->adminModel->getAllTourOperators($offSet,$limit);
		}else{
			$appType = $this->input->get_post('type_id');
			$AllOperators=$this->adminModel->countAllOperators();
			$data=$this->adminModel->getAllTourOperators($appType,$offSet,$limit);
		}
		$paging=$pagination->create($page ,base_url().'admin/touroperators/?type_id='.$appType.'' , $AllOperators ,'main_div' ,base_url().'images/admin/spinner_small.gif','paging_spinner',$limit);
		$assignData=array('pageName'=>'touroperators','data'=>$data,'appType'=>$appType,'AllOperators'=>$AllOperators,'paging'=>$paging['html'],'search'=>$key);
		if($ajax!=1){
			$this->load->view('admin/header',$assignData);
		}
			$this->load->view('admin/touroperators',$assignData);
		if($ajax!=1){
			$this->load->view('admin/footer');
		}

			
			
			
	/*		$data = $this->adminModel->getAllTourOperators();
			$assignData=array('pageName'=>'touroperators','data'=>$data);
			$this->load->view('admin/header',$assignData);
			$this->load->view('admin/touroperators',$assignData);
			$this->load->view('admin/footer');
	*/
	}
	
	public function addOperator(){
		$assignData=array('pageName'=>'touroperators');
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
				if($appType == 1){
				ob_start(); //Turn on output buffering ?>
					Thank You! You have Successfully created the Operator....
				<?php
					$var = ob_get_clean();		
					$this->load->library('email');
					$this->email->from('no-reply@britishwinery.com', 'British Winery');
					$this->email->to($email);
					$this->email->subject('Hey ! you have Got Mail from British Winery');
					$this->email->message($var);
					$this->email->send();
					$this->email->print_debugger();
					redirect(base_url().'admin/touroperators/?type_id=1');
			 }else{
				ob_start(); //Turn on output buffering ?>
					Thank You! You have Successfully created the Account....
				<?php
					$var = ob_get_clean();
					$this->load->library('email');
					$this->email->from('no-reply@ontariowinery.com', 'Ontario Winery');
					$this->email->to($email);
					$this->email->subject('Hey ! you have Got Mail from Ontario Columbia Winery');
					$this->email->message($var);
					$this->email->send();
					$this->email->print_debugger();
					redirect(base_url().'admin/touroperators/?type_id=2'); 
			 }
			}else{
				$this->load->view('admin/header',$assignData);
				$this->load->view('admin/addoperator');
				$this->load->view('admin/footer');
			}
	}
	
	public function view(){
			$id=$this->input->get_post('id');
			$data = $this->adminModel->getOperatorDetails($id);
			$assignData=array('pageName'=>'touroperators','data'=>$data);
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
	}
	
	public function edit(){
			$id=$this->input->get_post('id');
			$data = $this->adminModel->getOperatorDetails($id);
			$assignData=array('pageName'=>'touroperators','data'=>$data);
			$this->load->view('admin/header',$assignData);
			$this->load->view('admin/operatoredit',$assignData);
			$this->load->view('admin/footer');
	}
		
	public function update(){
			$id=$this->input->get_post('id');
			$operatorname=$this->input->get_post('operatorname');
			$email =$this->input->get_post('email');
			$country =$this->input->get_post('country');
			$province = $this->input->get_post('province');
			$address = $this->input->get_post('address');
			$contact = $this->input->get_post('contact');
			$link = $this->input->get_post('link');
			
       		 $data = array(
					'user_name'=>$operatorname,
					'user_email'=>$email,
					'country'=>$country,
					'province'=>$province,
					'address'=>$address,
					'contact'=>$contact,
					'link'=>$link,
				);
			$data = $this->adminModel->updateOperator($data,$id);
			$assignData=array('pageName'=>'touroperators','data'=>$data);
			$this->load->view('admin/header',$assignData);
			$this->load->view('admin/operatorview',$assignData);
			$this->load->view('admin/footer');
			redirect(base_url().'admin/touroperators/view/?id='.$id);

    }
	
	public function editImage(){
			$id=$this->input->get_post('id');
			$data = $this->adminModel->getOperatorDetails($id);
			$assignData=array('pageName'=>'touroperators','data'=>$data);
			$this->load->view('admin/header',$assignData);
			$this->load->view('admin/operatorimage',$assignData);
			$this->load->view('admin/footer');
	}
	
	public function editPicture(){
		  $id = $this->input->get_post('id');
		  $assignData=array('pageName'=>'operatorview');
		  $imgName = time();
		  $imgPath = BASEPATH."../uploads/".$imgName;
		  $image = base_url().'uploads/'.$imgName;
				
		  if(move_uploaded_file($_FILES["file"]["tmp_name"],$imgPath.".jpg")){
			  $this->load->library('imagethumb');
			  $this->imagethumb->image($imgPath.".jpg",200,200);
			  $userData['image']=$imgName."_thumb.jpg";
			  $view =$imgName."_thumb.jpg";
						//'image_path'=>$image."_thumb.jpg",

			$this->adminModel->updateOperatorImage($view,$id);
			redirect(base_url().'admin/touroperators/view/?id='.$id);

		  }
	}
	
	public function checkUsers($user_email){
		$checkUser = $this->adminModel->checkUserEmail($user_email);
		echo $checkUser;
	}


}
?>