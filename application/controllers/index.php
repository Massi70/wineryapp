<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Index extends CI_Controller {
	public $_uId;
	public $_userData;
	public $_assignData;
	public $_checkUser;
	
	public function __construct(){
		parent :: __construct();
		$this->load->model('adminModel');
		$this->load->model('webservicesModel');
	}
	
	public function index(){
		
		if($this->session->userdata("user_login"))
		{
			redirect(base_url().'index/home');
		}
		$this->load->view('header');
		//$this->load->view('login');
		$this->load->view('footer');
	}
	
	public function registration(){
		
		 
		$this->load->view('header');
		
		$_SERVER['REMOTE_ADDR'];
		$ip_addr = $_SERVER['REMOTE_ADDR'];
		$geoplugin = unserialize( file_get_contents('http://www.geoplugin.net/php.gp?ip='.$ip_addr) );
		
		if ( is_numeric($geoplugin['geoplugin_latitude']) && is_numeric($geoplugin['geoplugin_longitude']) ) {
			$data['lat'] = $geoplugin['geoplugin_latitude'];
			$data['long'] = $geoplugin['geoplugin_longitude'];
		}
		$this->load->view('registration',$data);
		$this->load->view('footer');
	}
	
	/*public function login(){
 
		$user_email = $this->input->get_post('user_email');
		$password = $this->input->get_post('password');
		$msg='';
		
		if($user_email==false ||  $password==false){
			
		}else{
				$login = $this->webservicesModel->login($user_email,$password);
				if($login == false){
					$msg='<center><font color=red>Invalid user email or password</font></center>';
				}else{
					$this->session->set_userdata(APP_NAME,1);
					redirect(base_url().'index/home');
					exit;
				}
		}
			$assignData=array('pageName'=>'login','msg'=>$msg);
			$this->load->view('header',$assignData);
			$this->load->view('home',$assignData);
			$this->load->view('footer');

	}*/
	
	public function signin(){
		
		try{
			
			$userName=$this->input->get_post('user_name');
			$password=$this->input->get_post('password');
			 
		 	
			$error=0;
			$data=array();
			if($userName==''){
				$data['status']='FAILURE';
				$data['message']='Username is missing';
			}else if($password==''){
				$data['status']='FAILURE';
				$data['message']='Password is missing';
			}else{
				 
				$array= array(); 
				$userInfo=$this->webservicesModel->loginWeb($userName,$password);
				if(is_array($userInfo) && count($userInfo)>0){
					 // print_r($userInfo);
					$this->session->set_userdata("user_login",$userInfo);
					$data['status']='SUCESS';
					$data['user_data']=$userInfo ;
	 
					 
				}else{
					 $data['status']='FAILURE';
					 $data['message']='User name or Password is incorrect';
					 
				 	 
				}
 
			}
		}catch(Exception $e){
			$data['status']='FAILURE';
			$data['message']='Error Occured';
			 
		}
	 
		 
		 
		echo json_encode($data);
		
	}
	
	function reverse_geocode($address) {
		$address = str_replace(" ", "+", "$address");
		$url = "http://maps.google.com/maps/api/geocode/json?address=$address&sensor=false";
		$result = file_get_contents("$url");
		$json = json_decode($result);
		foreach ($json->results as $result)
		{
			foreach($result->address_components as $addressPart) {
				if((in_array('locality', $addressPart->types)) && (in_array('political', $addressPart->types)))
					$city = $addressPart->long_name;
				else if((in_array('administrative_area_level_1', $addressPart->types)) && (in_array('political', $addressPart->types)))
					$state = $addressPart->long_name;
				else if((in_array('country', $addressPart->types)) && (in_array('political', $addressPart->types)))
					$country = $addressPart->long_name;
			}
		}
		$return_address = array();
		$return_address['country']	= $country ;
		$return_address['state']	= $state;
		$return_address['city']		= $city;
		
		/*if(($city != '') && ($state != '') && ($country != ''))
		{
					$address = $city.', '.$state.', '.$country;
		}
		else if(($city != '') && ($state != ''))
		{
			$address = $city.', '.$state;
		}
		else if(($state != '') && ($country != ''))
		{
				$address = $state.', '.$country;
		}
		else if($country != '')
			$address = $country;*/
			
		// return $address;
		return $return_address;
	}
	public function signup(){
		try{
			$this->load->model('UserModel');
			
			$userName=$this->input->get_post('user_name');
			$user_email=$this->input->get_post('user_email');
			$rpassword=$this->input->get_post('rpassword');
			$user_type=$this->input->get_post('user_type');
			$txt_latlng=$this->input->get_post('txt_latlng');
			$Contact=$this->input->get_post('Contact');
			$web_link=$this->input->get_post('web_link');
			$app_type=$this->input->get_post('app_type');
			if($user_type=='2')
			{
				$notes=$this->input->get_post('notes');
				$detail=$this->input->get_post('detail');
			}
			$newFileName=time().".png";
			
  			  
		 	$error=0;
			$data=array();
			if($userName==''){
				$data['status']='FAILURE';
				$data['message']= "Username is missing";
			}else if($user_email==''){
				$data['status']='FAILURE';
				$data['message']='email is missing';
			}else if($rpassword==''){
				$data['status']='FAILURE';
				$data['message']='password is missing';
			}else if($user_type==''){
				$data['status']='FAILURE';
				$data['message']='User type is missing';
			}else if($txt_latlng==''){
				$data['status']='FAILURE';
				$data['message']='Lan and Lon  is missing';
			}
			else if($Contact==''){
				$data['status']='FAILURE';
				$data['message']='contact  is missing';
			}
			else if($web_link==''){
				$data['status']='FAILURE';
				$data['message']='web link  is missing';
			}else if($app_type==''){
				$data['status']='FAILURE';
				$data['message']='$app_type is missing';
			} else if($user_type==''){
				$data['status']='FAILURE';
				$data['message']='User type is missing';
			}
			else if($user_type=='2' && $notes==''){
				$data['status']='FAILURE';
				$data['message']='notes is missing';
			}
			else if($user_type=='2' && $detail==''){
				$data['status']='FAILURE';
				$data['message']='detail  is missing';
			} 
			 else if(!isset($_FILES["file"]["name"]) )
			{
				$data['status']='FAILURE';
				$data['message']='image  is missing';
			}
			else if($this->webservicesModel->userIsExist($user_email))
			{
				 $data['status']='FAILURE';
				$data['message']="Email Is Already Exist";
			}
			else{
				
				$city='';$State='';$country='';$address='';
				$txt_latlng =  str_replace(' ','',$txt_latlng);
				$url = "http://maps.googleapis.com/maps/api/geocode/json?latlng=".$txt_latlng."&sensor=false";
				$result = file_get_contents("$url");
				$json = json_decode($result);
			    
				if(isset($json->results[0]->formatted_address))
			   	$address=$json->results[0]->formatted_address;
				
				if(isset($json->results[0]->address_components))
				{
					foreach ($json->results[0]->address_components as $index=>$result)
					{
						if(isset($result->types[0]) && $result->types[0]=='locality')
							$city= $result->long_name;
							
						if(isset($result->types[0]) && $result->types[0]=='administrative_area_level_1')
							$State= $result->long_name;
						if(isset($result->types[0]) && $result->types[0]=='country')
							$country= $result->long_name;		
						 
					}
				}
				
				$path= dirname(BASEPATH)."/uploads/";
				 move_uploaded_file($_FILES["file"]["tmp_name"], $path. $newFileName);
				
				$password= base64_encode($rpassword);
       			$txt_latlng=explode(',',$txt_latlng);
				$data1=array(
							'app_type_id'=>$app_type,
							'user_email'=>$user_email,
							 'user_name'=>$userName,
							 'password'=>$password,
							 'user_type_id'=>$user_type,
							 'contact'=>$Contact,
							 'link'=>$web_link,
							 'address'=>$address,
							 'city'=>$city,
							 'province'=>$State,
							 'country'=>$country,
							 'image'=>$newFileName,
							 'latitude'=>$txt_latlng[0],
							 'longitude'=>$txt_latlng[1],
							 'user_status'=>'1'
				);
				if($user_type=='2')
				{
					$data1['notes']=$notes;
					$data1['description']=$detail;
					 
				}
						  
				if( $this->webservicesModel->registerUser($data1) )
				{
					 $to 	= $user_email;
					 $subject = "Winery Registration";
					
					 $message = "Hi <br>
					 			Congratulation Winery Account Created SuccessFully ";
					
					// Always set content-type when sending HTML email
					$headers = "MIME-Version: 1.0" . "\r\n";
					$headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
					
					// More headers
					$headers .= 'From: <info@admin.com>' . "\r\n";
					
					mail($to,$subject,$message,$headers);
			
					$data['message']='User Registered successfully';
					$data['status']='SUCCESS';
				}
				else
				{
					$data['message']='Query Error';
					$data['status']='FAILURE';
				}
				
				 
			}
		}catch(Exception $e){
			$data['status']='FAILURE';
			$data['message']='Error Occured';
		}
		  
		echo json_encode($data);
		
	}
	
	public function ForgotPassword(){
	 	try{
			
			$userName=$this->input->get_post('user_name');
		 
			 
		 	
			$error=0;
			$data=array();
			if($userName==''){
				$data['status']='FAILURE';
				$data['message']='Username is missing';
			}else{
				 
				$array= array(); 
				$this->load->model('UserModel');
				$userData= $this->webservicesModel->userIsExist($userName);
				if($userData)
				{ 
					  	 $to 	= $userName;
						 $subject = "Winery Password";
						
						 $message = "Hi <br>
									 This is Your Password ". base64_decode( $userData['password']);
						
						// Always set content-type when sending HTML email
						$headers = "MIME-Version: 1.0" . "\r\n";
						$headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
						
						// More headers
						$headers .= 'From: <info@admin.com>' . "\r\n";
						
						mail($to,$subject,$message,$headers);
					 	
						$data['status']='FAILURE';
						$data['message']='password is Send to  Email Address' ;
						
				}
				else{
					 $data['status']='FAILURE';
					 $data['message']='Email Address Not Exist';
					  
				 	 
				}
 
			}
		}catch(Exception $e){
			$data['status']='FAILURE';
			$data['message']='Error Occured';
			$data['user_data']="" ;
		}
	  
	  	echo json_encode($data);
 
	}
	
	public function home(){
		
		if(!$this->session->userdata("user_login"))
		{
			redirect(base_url());
		}
		$user_login=$this->session->userdata("user_login");
		echo "<pre>";
		//print_r($user_login);
		echo "</pre>";
		$id=$user_login['id'];
		$user_login=$this->session->userdata("user_login");
		$assignData=array('pageName'=>'Profile','val'=>$user_login);
		$this->load->view('header',$assignData);
		$this->load->view('home');
		$this->load->view('footer');
		 

	}
	
	public function events(){
		
		$user_login=$this->session->userdata("user_login");
		if(!$this->session->userdata("user_login") || $user_login['user_type_id']!=2)
		{
			redirect(base_url());
		}
		  
		$id=$user_login['id'];
		$user_login=$this->session->userdata("user_login");
		$data = $this->webservicesModel->getEvents($id);
		$assignData=array('pageName'=>'Profile','val'=>$user_login,'data'=>$data);
		$this->load->view('header',$assignData);
		$this->load->view('events');
		$this->load->view('footer');
		 

	}
	
	public function edit(){
			$id=$this->input->get_post('id');
			$data = $this->webservicesModel->getEventDetails($id);
			$assignData=array('pageName'=>'events','data'=>$data);
			$this->load->view('admin/header',$assignData);
			$this->load->view('admin/eventsedit',$assignData);
			$this->load->view('admin/footer');
	}	 
	
	
	public function logOut(){ 
		$this->session->unset_userdata("user_login");
		redirect(base_url());
	}	
	
	
	

	
}