<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Users extends CI_Controller {
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
		
		$limit='5';
		$page=($page==false) ? 1 : $page; 
		
		$offSet=($page>1) ? ($page-1)*$limit : 0;
		$this->load->helper('pagination_helper');
		$pagination=Pagination_helper::getInstance();
		if($key!=false){
			$totalAppUsers=$this->adminModel->countAllUsers($key);
			$data=$this->adminModel->getAllUsers($key,$offSet,$limit);
		}else{
			$totalAppUsers=$this->adminModel->countAllUsers();
			$data=$this->adminModel->getAllUsers('',$offSet,$limit);
		}
		$paging=$pagination->create($page ,base_url().'admin/users' , $totalAppUsers ,'main_div' ,base_url().'images/admin/spinner_small.gif','paging_spinner',$limit);
		$assignData=array('pageName'=>'users','data'=>$data,'totalUsers'=>$totalAppUsers,'paging'=>$paging['html'],'search'=>$key);
		if($ajax!=1){
			$this->load->view('admin/header',$assignData);
		}
		$this->load->view('admin/users',$assignData);
		if($ajax!=1){
			$this->load->view('admin/footer');
		}
	}
	
	public function downloadCsv(){
		$file='users.csv';
		$sql="select name,email,phone_no,nic_no,birthdate,joined_date,address,city,country from users";
		$ret=$this->userModel->createCsv(BASEPATH.'../files/csv/'.$file,$sql);
		$filePath=base_url().'files/csv/'.$file;
		$iframPath=base_url().'admin/users/iframeDownload/?filePath='.$filePath.'&fileName='.$file;
		$assignData=array('iframSrc'=>$iframPath);
		$this->load->view('admin/download',$assignData);
		
	}
	
	public function iframeDownload(){
		$fileName=$this->input->get('fileName');
		$filePath=$this->input->get('filePath');
		header('Content-Description: File Transfer');
		header('Content-Disposition: attachment; filename='.$fileName);
		header('Content-Type: csv');
		header('Content-Transfer-Encoding: binary');
		readfile($filePath);
		exit;
			
	}
	
	public function addUser(){
		if(count($_POST)>0){
			$user_name = $this->input->get_post('user_name');
			$user_email = $this->input->get_post('user_email');
			$password = $this->input->get_post('password');
			$contact = $this->input->get_post('contact');
			$country = $this->input->get_post('country');
			$province = $this->input->get_post('province');
			$address = $this->input->get_post('address');
			$link = $this->input->get_post('link');
			$description = $this->input->get_post('description');
			$notes = $this->input->get_post('notes');
			$user_type = $this->input->get_post('user_type');
			$app_type = $this->input->get_post('app_type');
			$file = $this->input->get_post('file');
			$msg='';
			 $imgName = time();
			 $imgPath = BASEPATH."../uploads/".$imgName;
			 $image = base_url().'uploads/'.$imgName;
			
			 move_uploaded_file($_FILES["file"]["tmp_name"],$imgPath.".jpg");
			 $this->load->library('imagethumb');
			 $this->imagethumb->image($imgPath.".jpg",200,200);
			 $view = $imgName."_thumb.jpg"; /* for image name only in the db*/
				  $data = array(
						'user_name'=>$user_name,
						'user_email'=>$user_email,
						'password'=>base64_encode($password),
						'image'=>$view,
						'contact'=>$contact,
						'country'=>$country,
						'province'=>$province,
						'address'=>$address,
						'link'=>$link,
						'description'=>$description,
						'notes'=>$notes,
						'user_type_id'=>$user_type,
						'app_type_id'=>$app_type
					);
				$data = $this->adminModel->addUser($data);
				
			/*	ob_start(); //Turn on output buffering ?>
				Thank You! You have Successfully created the Account....
				<?php
					 //echo "Thank You! You have Successfully created the Account....";
					 $var = ob_get_clean();
													
							$this->load->library('email');
							$this->email->from('no-reply@britishwinery.com', 'British Winery');
							$this->email->to($user_email);
							$this->email->subject('Hey ! you have Got Mail from British Winery');
							$this->email->message($var);
							$this->email->send();
							$this->email->print_debugger();*/
				if($app_type == 1){
					ob_start(); //Turn on output buffering ?>
					Thank You! You have Successfully created the Account....
				<?php
					$var = ob_get_clean();
													
					$this->load->library('email');
					$this->email->from('no-reply@britishwinery.com', 'British Columbia Winery');
					$this->email->to($email);
					$this->email->subject('Hey ! you have Got Mail from British Columbia Winery');
					$this->email->message($var);
					$this->email->send();
					$this->email->print_debugger();
					redirect(base_url().'index.php/admin/users/');
				}else{
					ob_start(); //Turn on output buffering ?>
					Thank You! You have Successfully created the Account....
				<?php
					 //echo "Thank You! You have Successfully created the Account....";
					$var = ob_get_clean();
													
					$this->load->library('email');
					$this->email->from('no-reply@ontariowinery.com', 'Ontario Winery');
					$this->email->to($email);
					$this->email->subject('Hey ! you have Got Mail from Ontario Columbia Winery');
					$this->email->message($var);
					$this->email->send();
					$this->email->print_debugger();
					redirect(base_url().'index.php/admin/users/');				}
			 }else{
				$assignData = array('pageName'=>'users');
				$this->load->view('admin/header',$assignData);
				$this->load->view('admin/adduser',$assignData);
				$this->load->view('admin/footer');
			}
	}
	
	public function edit(){
			$id=$this->input->get_post('id');
			$data = $this->adminModel->getUser($id);
			$assignData=array('pageName'=>'users','data'=>$data);
			$this->load->view('admin/header',$assignData);
			$this->load->view('admin/useredit',$assignData);
			$this->load->view('admin/footer');
	}
		
	public function update(){
		$id = $this->input->get_post('id');
		$user_name = $this->input->get_post('user_name');
		$user_email = $this->input->get_post('user_email');
		$password = $this->input->get_post('password');
		$contact = $this->input->get_post('contact');
		$country = $this->input->get_post('country');
		$province = $this->input->get_post('province');
		$address = $this->input->get_post('address');
		$description = $this->input->get_post('description');
		$link = $this->input->get_post('link');

        $data = array(
					'user_name'=>$user_name,
					'user_email'=>$user_email,
					'password'=>base64_encode($password),
					'contact'=>$contact,
					'country'=>$country,
					'province'=>$province,
					'address'=>$address,
					'description'=>$description,
					'link'=>$link
                 );
			$data = $this->adminModel->updateUser($data,$id);
			$assignData=array('pageName'=>'users','data'=>$data);
			$this->load->view('admin/header',$assignData);
			$this->load->view('admin/users',$assignData);
			$this->load->view('admin/footer');
			redirect(base_url().'index.php/admin/users/');

    }
	
	public function delete(){	
		$id=$this->input->get_post('id');
		if($id > 0){
			  $this->adminModel->deleteUser($id);
		}
			redirect(base_url().'index.php/admin/users/');
	}
	
	public function forgetpassword(){
		$user_email = $this->input->get_post('user_email');

	try{
			if($user_email == false || $user_email == ""){
				$this->_jsonData['status']="FAILURE";
				$this->_jsonData['message']="User Email Missing";
			}else{
					$checkUser = $this->webservicesModel->checkUser($user_email);
					if(count($checkUser)>0){
						$this->_jsonData['status']="SUCCESS";
						$this->_jsonData['message']="Password Sent Successfully...";
						$data['message'] = "Hey there, you've got mail!";
						ob_start(); //Turn on output buffering ?>
                       		Hey ! you have Got Mail from MissFire 
                        <?php
							echo "YOur Forgotten Password Is : ".base64_decode($checkUser['password']);
						 $var = ob_get_clean();
												
						//$htmlMessage =  $this->load->view('email/basic', $data,true);
						$this->load->library('email');
						$this->email->from('no-reply@missfire.com', 'Missfire');
						$this->email->to($user_email);
						$this->email->subject('Forget Password');
						$this->email->message($var);
						$this->email->send();
						$this->email->print_debugger(); 
					}else{
						$this->_jsonData['status']="FAILURE";
						$this->_jsonData['message']="No Email Exists";
					}
			}
		echo json_encode($this->_jsonData);
	}catch(Exception $e){
				$this->_jsonData['status']="FAILURE";
				$this->_jsonData['message']="Error Occured";
				$this->_jsonData['data']='';
		}
		$this->ServicesModel->createService($_REQUEST,$this->_jsonData,$_SERVER['SERVER_ADDR'],'forgetpassword',$_FILES);
		
	}
	
	public function checkUsers($user_email){
		//echo $user_email;
		$checkUser = $this->adminModel->checkUserEmail($user_email);
		echo $checkUser;
	}
}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */