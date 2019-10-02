<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class WineryServices extends CI_Controller {
	public $_uId;
	public $_userData;
	public $_assignData;
	public $_checkUser;
	public function __construct(){
        parent::__construct();
		$this->load->model('userModel');
		$this->load->model('webservicesModel');
		$this->load->model('ServicesModel');
   }
	private $_headerData = array();
	private $_navData = array();
	private $_footerData = array();
	private $_jsonData = array();
	private $_finalData = array();
		/*************************** sign up code starts ***************************/
	
	public function register(){
		//$fbId = $this->_uId;
		$fbId = $this->input->get_post('fb_id');
		$twitterId = $this->input->get_post('twitter_id');
		//$twitterId = 219262506;
		$user_email = $this->input->get_post('user_email');
		$user_name = $this->input->get_post('user_name');
		$password = $this->input->get_post('password');
		$cpassword = $this->input->get_post('cpassword');
	try{
			if($user_email == false || $user_email == ""){
				$this->_jsonData['status']=0;
				$this->_jsonData['message']="User Email Missing";
			}else if($user_name == false || $user_name == ""){
				$this->_jsonData['status']=0;
				$this->_jsonData['message']="User Name Missing";
			}else if($password == false || $password == ""){
				$this->_jsonData['status']=0;
				$this->_jsonData['message']="Password Missing";
			}else if($cpassword == false || $cpassword == ""){
				$this->_jsonData['status']=0;
				$this->_jsonData['message']="Confirm Password Missing";
			}else if($password != $cpassword ){
				$this->_jsonData['status']=0;
				$this->_jsonData['message']="Password do not Match";
			}else{
					$checkUserEmail = $this->webservicesModel->checkUserEmail($user_email);
					if($checkUserEmail == 0){
						$data = array(
								'fb_id'=>$fbId,
								'twitter_id'=>$twitterId,
								'user_email'=>$user_email,
								'user_name'=>$user_name,
								'password'=>base64_encode($password)
							);
						$res = $this->webservicesModel->addUser($data);
						$data['id'] = $res;
						$this->_jsonData['status']=1;
						$this->_jsonData['message']="User Data Inserted Successfully";
						$this->_jsonData['data']=$data; 
					}else{
						$this->_jsonData['status']=0;
						$this->_jsonData['message']="User Email Already Exists";
					}
		  }
		echo json_encode($this->_jsonData);
	}catch(Exception $e){
				$this->_jsonData['status']=0;
				$this->_jsonData['message']="Error Occured";
		}
		$this->ServicesModel->createService($_REQUEST,$this->_jsonData,$_SERVER['SERVER_ADDR'],'register',$_FILES);
		
	}
	
	public function signin(){
		$user_email = $this->input->get_post('user_email');
		$password = $this->input->get_post('password');
		$fb_id = $this->input->get_post('fb_id');
		$twitter_id = $this->input->get_post('twitter_id');
	try{
		if($fb_id!=""){
			$fbLogin = $this->webservicesModel->fbLogin($fb_id);
			if(empty($fbLogin)){
            	$this->_jsonData['status']=0;
                $this->_jsonData['message']="User not found";
            }else{
				$this->_jsonData['status']=1;
				$this->_jsonData['message']="User Logged In Successfully";
				$this->_jsonData['data']=$fbLogin;
           }
		   
		}
		
		else if($twitter_id!=""){
			$twitterLogin = $this->webservicesModel->twitterLogin($twitter_id);
			if(empty($twitterLogin)){
            	$this->_jsonData['status']=0;
                $this->_jsonData['message']="User not found";
            }else{
				$this->_jsonData['status']=1;
				$this->_jsonData['message']="User Logged In Successfully";
				$this->_jsonData['data']=$twitterLogin;
           }
		}
		
		
		else if($user_email == false || $user_email == ""){
				$this->_jsonData['status']=0;
				$this->_jsonData['message']="User Email Missing";
			}else if($password == false || $password == ""){
                                $this->_jsonData['status']=0;
				$this->_jsonData['message']="Password Missing";
			}
			
			else{
					$checkUser = $this->webservicesModel->checklogin($user_email,base64_encode($password));
					if($checkUser !=""){
				    	$login = $this->webservicesModel->login($user_email,base64_encode($password));
						$this->_jsonData['status']=1;
						$this->_jsonData['message']="User Logged In Successfully";
						$this->_jsonData['data']=$login; 
					}else{
						$this->_jsonData['status']=0;
						$this->_jsonData['message']="User Email or Password donot match";
					}
			}
		echo json_encode($this->_jsonData);
	}catch(Exception $e){
				$this->_jsonData['status']=0;
				$this->_jsonData['message']="Error Occured";
				$this->_jsonData['data']='';
		}
		$this->ServicesModel->createService($_REQUEST,$this->_jsonData,$_SERVER['SERVER_ADDR'],'signin',$_FILES);
		
	}
	
	public function association(){
		$name = $this->input->get_post('association_name');
		try{
			if($_FILES['file']['name'] == false || $_FILES['file']['name'] == ""){
				$this->_jsonData['status']=0;
				$this->_jsonData['message']="Image Missing";
			}else if($name == false || $name == ""){
				$this->_jsonData['status']=0;
				$this->_jsonData['message']="Association Name Missing";
			}else{
			/*	  $imgName = time();
				  $imgPath = BASEPATH."../uploads/associations/".$imgName;
				  $image = base_url().'uploads/associations/'.$imgName;
				  if(move_uploaded_file($_FILES["file"]["tmp_name"],$imgPath.".jpg")){
					  $this->load->library('imagethumb');
					  $this->imagethumb->image($imgPath.".jpg",200,200);
			*/
					 $imgName = time();
					 $imgPath = BASEPATH."../uploads/associations/".$imgName;
					 $image = base_url().'uploads/associations/'.$imgName;
					 if(move_uploaded_file($_FILES["file"]["tmp_name"],$imgPath.".jpg")){
						 $this->load->library('imagethumb');
						 $this->imagethumb->image($imgPath.".jpg",200,200);
						 $imageNew =$image."_thumb.jpg";
						 $data = array(
									'image'=>$imageNew,
									'association_name'=>$name
								);
						 $this->webservicesModel->addAssociation($data);	
						 $this->_jsonData['status']=1;
						 $this->_jsonData['message']="Association Inserted Successfully";
						 $this->_jsonData['data']=$data; 
				  }else{
					    $this->_jsonData['status']=0;
				 	 	$this->_jsonData['message']="Image can not be Inserted";
				  		$this->_jsonData['data']=''; 
				  }
				 
				  echo json_encode($this->_jsonData);
			}
		}catch(Exception $e){
				  $this->_jsonData['status']=0;
				  $this->_jsonData['message']="Error Occured";
		}
		$this->ServicesModel->createService($_REQUEST,$this->_jsonData,$_SERVER['SERVER_ADDR'],'association',$_FILES);
	}
	
	public function getAssociation(){
		try{
				$data = $this->webservicesModel->getAllAssociation();
				$this->_jsonData['status']=1;
				$this->_jsonData['message']="Associations Got Successfully";
				$this->_jsonData['data']=$data; 
	
				echo json_encode($this->_jsonData);
		}catch(Exception $e){
				$this->_jsonData['status']=0;
				$this->_jsonData['message']="Error Occured";
				$this->_jsonData['data']='';
		}
		$this->ServicesModel->createService($_REQUEST,$this->_jsonData,$_SERVER['SERVER_ADDR'],'getAssociation',$_FILES);
	}
	
	public function getWineList(){
		try{
				$data = $this->webservicesModel->getWineList();
				$this->_jsonData['status']=1;
				$this->_jsonData['message']="Wine List Got Successfully";
				$this->_jsonData['data']=$data; 
	
				echo json_encode($this->_jsonData);
		}catch(Exception $e){
				$this->_jsonData['status']=0;
				$this->_jsonData['message']="Error Occured";
				$this->_jsonData['data']='';
		}
		$this->ServicesModel->createService($_REQUEST,$this->_jsonData,$_SERVER['SERVER_ADDR'],'getWineList',$_FILES);
	}
	
	public function wineryDetails(){
		$winery_id = $this->input->get_post('winery_id');
		try{
			if($winery_id == false || $winery_id == ""){
				$this->_jsonData['status']=0;
				$this->_jsonData['message']="Winery Id Missing";
			}else{
				$data = $this->webservicesModel->getWineryDetails($winery_id);
				$this->_jsonData['status']=1;
				$this->_jsonData['message']="Winery Details Got Successfully";
				$this->_jsonData['data']=$data; 
			}
				echo json_encode($this->_jsonData);
		}catch(Exception $e){
				$this->_jsonData['status']=0;
				$this->_jsonData['message']="Error Occured";
				$this->_jsonData['data']='';
		}
		$this->ServicesModel->createService($_REQUEST,$this->_jsonData,$_SERVER['SERVER_ADDR'],'wineryDetails',$_FILES);
	}

	public function getWineryLatLong(){
		try{
				$data = $this->webservicesModel->getWineLatLong();
				$this->_jsonData['status']=1;
				$this->_jsonData['message']="Winery Details Got Successfully";
				$this->_jsonData['data']=$data; 

				echo json_encode($this->_jsonData);
		}catch(Exception $e){
				$this->_jsonData['status']=0;
				$this->_jsonData['message']="Error Occured";
				$this->_jsonData['data']='';
		}
		$this->ServicesModel->createService($_REQUEST,$this->_jsonData,$_SERVER['SERVER_ADDR'],'wineryLatLong',$_FILES);
	}
	
	public function getAllWineryByAssociation(){
		$association_id = $this->input->get_post('association_id');
		try{
			if($association_id == false || $association_id == ""){
				$this->_jsonData['status']=0;
				$this->_jsonData['message']="Association Id Missing";
			}else{
				$data = $this->webservicesModel->getWineryDetailsByAssociation($association_id);
				$this->_jsonData['status']=1;
				$this->_jsonData['message']="Winery Details Got Successfully";
				$this->_jsonData['data']=$data; 
			}
				echo json_encode($this->_jsonData);
		}catch(Exception $e){
				$this->_jsonData['status']=0;
				$this->_jsonData['message']="Error Occured";
				$this->_jsonData['data']='';
		}
		$this->ServicesModel->createService($_REQUEST,$this->_jsonData,$_SERVER['SERVER_ADDR'],'getAllWineryByAssociation',$_FILES);
	}
	
	public function getEvents(){
		$user_id = $this->input->get_post('user_id');
		try{
			if($user_id == false || $user_id == "" ){
					$this->_jsonData['status']=0;
					$this->_jsonData['message']="User Id Missing";
			}else{
					$data = $this->webservicesModel->getEvents($user_id);
					$this->_jsonData['status']=1;
					$this->_jsonData['message']="Events Got Successfully";
					$this->_jsonData['data']=$data; 
			}
					echo json_encode($this->_jsonData);
		}catch(Exception $e){
				$this->_jsonData['status']=0;
				$this->_jsonData['message']="Error Occured";
				$this->_jsonData['data']='';
		}
		$this->ServicesModel->createService($_REQUEST,$this->_jsonData,$_SERVER['SERVER_ADDR'],'getEvents',$_FILES);
	}

	public function getEventById(){
		try{
			$eventId = $this->input->get_post('event_id');
            if($eventId == false || $eventId == ""){
				$this->_jsonData['status']=0;
				$this->_jsonData['message']="Event Id Missing";
			}else{
				$data = $this->webservicesModel->getEventById($eventId);
				$this->_jsonData['status']=1;
				$this->_jsonData['message']="Events Got Successfully";
				$this->_jsonData['data']=$data; 
			}
				echo json_encode($this->_jsonData);
		}catch(Exception $e){
				$this->_jsonData['status']=0;
				$this->_jsonData['message']="Error Occured";
				$this->_jsonData['data']='';
		}
		$this->ServicesModel->createService($_REQUEST,$this->_jsonData,$_SERVER['SERVER_ADDR'],'getEventById',$_FILES);
	}
	
	public function getEventByWineryId(){
		try{
			$wineryId = $this->input->get_post('winery_id');
                        $user_id = $this->input->get_post('user_id');
            if($wineryId == false || $wineryId == ""){
				$this->_jsonData['status']=0;
				$this->_jsonData['message']="Winery Id Missing";
			}else{
				$data = $this->webservicesModel->getEventByWineryId($wineryId,$user_id);
				$this->_jsonData['status']=1;
				$this->_jsonData['message']="Events Got Successfully";
				$this->_jsonData['data']=$data; 
			}
				echo json_encode($this->_jsonData);
		}catch(Exception $e){
				$this->_jsonData['status']=0;
				$this->_jsonData['message']="Error Occured";
				$this->_jsonData['data']='';
		}
		$this->ServicesModel->createService($_REQUEST,$this->_jsonData,$_SERVER['SERVER_ADDR'],'getEventByWineryId',$_FILES);
	}
	
	public function userGoingOrNotGoing(){
		$id = $this->input->get_post('id');
		$user_id = $this->input->get_post('user_id');
		$event_id = $this->input->get_post('event_id');
		$is_going = $this->input->get_post('is_going');
	try{
		if($user_id == false || $user_id == ""){
			$this->_jsonData['status']=0;
			$this->_jsonData['message']="User Id Missing";
		}else if($event_id == false || $event_id == ""){
			$this->_jsonData['status']=0;
			$this->_jsonData['message']="Event Id Missing";
		}else if($is_going == ""){
			$this->_jsonData['status']=0;
			$this->_jsonData['message']="Event Status Missing";
		}else{
			//$check = $this->webservicesModel->checkUserGoingOrNotGoing($user_id,$event_id);
                    $data = array(
						'user_id'=>$user_id,
						'event_id'=>$event_id,
						'is_going'=>$is_going,
					);
				$this->webservicesModel->addEventGoingOrNot($data);
				//$data['id'] = $res;
				$this->_jsonData['status']=1;
				$this->_jsonData['message']="Data Inserted Successfully";
				$this->_jsonData['data']=$data; 
			}
		
		echo json_encode($this->_jsonData);
	}catch(Exception $e){
				$this->_jsonData['status']=0;
				$this->_jsonData['message']="Error Occured";
				$this->_jsonData['data']='';
		}
		$this->ServicesModel->createService($_REQUEST,$this->_jsonData,$_SERVER['SERVER_ADDR'],'userGoingOrNotGoing',$_FILES);
		
	}
	
	public function checkUserGoingOrNotGoing(){
		$id = $this->input->get_post('id');
		$user_id = $this->input->get_post('user_id');
		$event_id = $this->input->get_post('event_id');
		//$is_going = $this->input->get_post('is_going');
	try{
		if($user_id == false || $user_id == ""){
			$this->_jsonData['status']=0;
			$this->_jsonData['message']="User Id Missing";
		}else if($event_id == false || $event_id == ""){
			$this->_jsonData['status']=0;
			$this->_jsonData['message']="Event Id Missing";
		}else{
			$checkUser = $this->webservicesModel->checkUserGoingOrNotGoing($user_id,$event_id);
			if($checkUser == 0){
				$data = array(
						'user_id'=>$user_id,
						'event_id'=>$event_id,
						'is_going'=>1
					);
				$this->webservicesModel->addEventGoingOrNot($data);
				$this->_jsonData['status']=1;
				$this->_jsonData['message']="Data Inserted Successfully";
				$this->_jsonData['data']=$data; 
			}else{
				$this->webservicesModel->updateUserGoingOrNotGoing($data);
				$this->_jsonData['status']=0;
				$this->_jsonData['message']="Already Exists";
			}
		}
		echo json_encode($this->_jsonData);
	}catch(Exception $e){
				$this->_jsonData['status']=0;
				$this->_jsonData['message']="Error Occured";
				$this->_jsonData['data']='';
		}
		$this->ServicesModel->createService($_REQUEST,$this->_jsonData,$_SERVER['SERVER_ADDR'],'checkUserGoingOrNotGoing',$_FILES);
		
	}
	
	public function countTotalGoingOrNotGoing(){
		try{
				$data = $this->webservicesModel->countTotalGoingOrNotGoing();
				$this->_jsonData['status']=1;
				$this->_jsonData['message']="Events Going Got Successfully";
				$this->_jsonData['data']=$data; 
				echo json_encode($this->_jsonData);
		}catch(Exception $e){
				$this->_jsonData['status']=0;
				$this->_jsonData['message']="Error Occured";
				$this->_jsonData['data']='';
		}
		$this->ServicesModel->createService($_REQUEST,$this->_jsonData,$_SERVER['SERVER_ADDR'],'countTotalGoingOrNotGoing',$_FILES);
	}
	
	public function createTour(){
		$user_id = $this->input->get_post('user_id');
		$name = $this->input->get_post('name');
                $description = $this->input->get_post('description');
		$is_active = $this->input->get_post('is_active');
		$start_date = $this->input->get_post('start_date');
		$end_date = $this->input->get_post('end_date');
		$latlong = $this->input->get_post('latlong');
		
		try{
			if($user_id == false || $user_id == ""){
				$this->_jsonData['status']=0;
				$this->_jsonData['message']="User Id Missing";
			}else if($name == false || $name == ""){
				$this->_jsonData['status']=0;
				$this->_jsonData['message']="Tour Name Missing";
			}
                        else if($description == false || $description == ""){
				$this->_jsonData['status']=0;
				$this->_jsonData['message']="description is Missing";
			}
                        else if($is_active == ""){
				$this->_jsonData['status']=0;
				$this->_jsonData['message']="Tour Status Missing";
			}else if($start_date == false || $start_date == ""){
				$this->_jsonData['status']=0;
				$this->_jsonData['message']="start_date Missing";
			}else if($latlong == false || $latlong == ""){
				$this->_jsonData['status']=0;
				$this->_jsonData['message']="latlong Missing";
			}else{
				$data = array(
						'user_id'=>$user_id,
						'name'=>$name,
                                                'description'=>$description,
						'is_active'=>$is_active,
						'start_date'=>$start_date,
						'end_date'=>$end_date
					);
				$tourId = $this->webservicesModel->createTour($data);

				$array = array();
				$array = explode(",", $latlong);
				$len = count($array);
					
				foreach($array as $key => $latlong){
					$array[$key] = explode(':', $latlong);
				foreach($array[$key] as $k):
                                    
                                    $data1 = array(
                                                            'tour_id'=>$tourId,
                                                            'latitude'=>$array[$key][0],
                                                            'longitude'=>$array[$key][1]
                                                    );
						$this->webservicesModel->createTourLocation($data1);
                                    
				//echo "LAT ".$array[$key][0]." LNG ".$array[$key][1]."</br>";
				break;
				endforeach;
							
						$this->_jsonData['status']=1;
						$this->_jsonData['message']="Tour Created Successfully";
						$this->_jsonData['data']=$data; 
				  }
			}
				echo json_encode($this->_jsonData);
		}catch(Exception $e){
				$this->_jsonData['status']=0;
				$this->_jsonData['message']="Error Occured";
				$this->_jsonData['data']='';
		}
		$this->ServicesModel->createService($_REQUEST,$this->_jsonData,$_SERVER['SERVER_ADDR'],'createTour',$_FILES);
	}
	
	public function wineryCeller(){
		$tour_id = $this->input->get_post('id');
		$variety = $this->input->get_post('variety');
		$winery = $this->input->get_post('winery');
		$flavour = $this->input->get_post('flavour');
		$aroma = $this->input->get_post('aroma');
		$year = $this->input->get_post('year');
		$food = $this->input->get_post('food');
		$price = $this->input->get_post('price');
		$WineryPhone = $this->input->get_post('phone');
		$rateit = $this->input->get_post('rateit');
                $lat = $this->input->get_post('lat');
                $long = $this->input->get_post('long');
		$file = $this->input->get_post('file');
		try{
                    
			if($tour_id == false || $tour_id == ""){
				$this->_jsonData['status']=0;
				$this->_jsonData['message']="tour_id Missing";
			}else if($variety == false || $variety == ""){
				$this->_jsonData['status']=0;
				$this->_jsonData['message']="variety Missing";
			}else if($winery == false || $winery == ""){
				$this->_jsonData['status']=0;
				$this->_jsonData['message']="winery Name Missing";
			}else if($flavour == false || $flavour == ""){
				$this->_jsonData['status']=0;
				$this->_jsonData['message']="flavour Missing";
			}else if($aroma == false || $aroma == ""){
				$this->_jsonData['status']=0;
				$this->_jsonData['message']="aroma Missing";
			}else if($year == false || $year == ""){
				$this->_jsonData['status']=0;
				$this->_jsonData['message']="year Missing";
			}else if($food == false || $food == ""){
				$this->_jsonData['status']=0;
				$this->_jsonData['message']="food Missing";
			}else if($price == false || $price == ""){
				$this->_jsonData['status']=0;
				$this->_jsonData['message']="price Missing";
			}else if($WineryPhone == false || $WineryPhone == ""){
				$this->_jsonData['status']=0;
				$this->_jsonData['message']="WineryPhone Missing";
			}else if($rateit == false || $rateit == ""){
				$this->_jsonData['status']=0;
				$this->_jsonData['message']="rate is Missing";
			}else if($lat == false || $lat == ""){
				$this->_jsonData['status']=0;
				$this->_jsonData['message']="Latitude is Missing";
			}else if($long == false || $long == ""){
				$this->_jsonData['status']=0;
				$this->_jsonData['message']="Longitude is Missing";
			}else{
                                   
					 $imgName = time();
					 $imgPath = BASEPATH."../uploads/".$imgName;
					 $image = base_url().'uploads/'.$imgName;
					 move_uploaded_file($_FILES["file"]["tmp_name"],$imgPath.".jpg");
					 $this->load->library('imagethumb');
					 $this->imagethumb->image($imgPath.".jpg",200,200);
					 $imageNew =$image."_thumb.jpg";
				
					$data = array(
							'tour_id'=>$tour_id,
							'variety'=>$variety,
							'winery'=>$winery,
							'flavour'=>$flavour,
							'aroma'=>$aroma,
							'year'=>$year,
							'food'=>$food,
							'price'=>$price,
							'phone'=>$WineryPhone,
							'rateit'=>$rateit,
							'image'=>$imageNew,
							'latitude'=>$lat,
							'longitude'=>$long
						);
					$this->webservicesModel->createCeller($data);
					$this->_jsonData['status']=1;
					$this->_jsonData['message']="Celler Data Created Successfully";
					$this->_jsonData['data']=$data; 
				}
				echo json_encode($this->_jsonData);
		}catch(Exception $e){
				$this->_jsonData['status']=0;
				$this->_jsonData['message']="Error Occured";
				$this->_jsonData['data']='';
		}
		$this->ServicesModel->createService($_REQUEST,$this->_jsonData,$_SERVER['SERVER_ADDR'],'wineryCeller',$_FILES);
	}
	
	/* public function updateCeller(){
		$variety = $this->input->get_post('variety');
		$winery = $this->input->get_post('winery');
		$flavour = $this->input->get_post('flavour');
		$aroma = $this->input->get_post('aroma');
		$year = $this->input->get_post('year');
		$food = $this->input->get_post('food');
		$price = $this->input->get_post('price');
		$WineryPhone = $this->input->get_post('phone');
		$rateit = $this->input->get_post('rateit');
		//$file = $this->input->get_post('file');
		try{
                    
			if($variety == false || $variety == ""){
				$this->_jsonData['status']=0;
				$this->_jsonData['message']="variety Missing";
			}else if($winery == false || $winery == ""){
				$this->_jsonData['status']=0;
				$this->_jsonData['message']="winery Name Missing";
			}else if($flavour == false || $flavour == ""){
				$this->_jsonData['status']=0;
				$this->_jsonData['message']="flavour Missing";
			}else if($aroma == false || $aroma == ""){
				$this->_jsonData['status']=0;
				$this->_jsonData['message']="aroma Missing";
			}else if($year == false || $year == ""){
				$this->_jsonData['status']=0;
				$this->_jsonData['message']="year Missing";
			}else if($food == false || $food == ""){
				$this->_jsonData['status']=0;
				$this->_jsonData['message']="food Missing";
			}else if($price == false || $price == ""){
				$this->_jsonData['status']=0;
				$this->_jsonData['message']="price Missing";
			}else if($WineryPhone == false || $WineryPhone == ""){
				$this->_jsonData['status']=0;
				$this->_jsonData['message']="WineryPhone Missing";
			}else if($rateit == false || $rateit == ""){
				$this->_jsonData['status']=0;
				$this->_jsonData['message']="rate it Missing";
			}else{
                   /*                
					 $imgName = time();
					 $imgPath = BASEPATH."../uploads/".$imgName;
					 $image = base_url().'uploads/'.$imgName;
					 move_uploaded_file($_FILES["file"]["tmp_name"],$imgPath.".jpg");
					 $this->load->library('imagethumb');
					 $this->imagethumb->image($imgPath.".jpg",200,200);
					 $imageNew =$image."_thumb.jpg";
				*/
			/*		$data = array(
							'variety'=>$variety,
							'winery'=>$winery,
							'flavour'=>$flavour,
							'aroma'=>$aroma,
							'year'=>$year,
							'food'=>$food,
							'price'=>$price,
							'phone'=>$WineryPhone,
							'rateit'=>$rateit
						);
					$this->webservicesModel->updateCeller($data);
					$this->_jsonData['status']=1;
					$this->_jsonData['message']="Celler Data Updated Successfully";
					$this->_jsonData['data']=$data; 
				}
				echo json_encode($this->_jsonData);
		}catch(Exception $e){
				$this->_jsonData['status']=0;
				$this->_jsonData['message']="Error Occured";
				$this->_jsonData['data']='';
		}
		$this->ServicesModel->createService($_REQUEST,$this->_jsonData,$_SERVER['SERVER_ADDR'],'wineryCeller',$_FILES);
	} */
	
	/* public function editPicture(){
		$id = $this->input->get_post('id');
		try{
			if($_FILES['file']['name'] == false || $_FILES['file']['name'] == ""){
				$this->_jsonData['status']="FAILURE";
				$this->_jsonData['message']="Image Missing";
			}else{
				  $imgName = time();
				  $imgPath = BASEPATH."../uploads/".$imgName;
				  $image = base_url().'uploads/'.$imgName;
				  $userData=$this->webservicesModel->getUserData($user_id);
				
				  if(move_uploaded_file($_FILES["file"]["tmp_name"],$imgPath.".jpg")){
					  $this->load->library('imagethumb');
					  $this->imagethumb->image($imgPath.".jpg",200,200);
					  $userData['user_image']=$imgName."_thumb.jpg";
					  $data = array(
								'image'=>$imgName."_thumb.jpg",
								'image_path'=>$image."_thumb.jpg",
							);
					  $res = $this->webservicesModel->updateCeller($userData);
					  $this->_jsonData['status']="SUCCESS";
					  $this->_jsonData['message']="Image Updated Successfully";
					  $this->_jsonData['data']=$data; 
				  }else{
					    $this->_jsonData['status']="FAILURE";
				 	 $this->_jsonData['message']="Image can not be Updated";
				  	$this->_jsonData['data']=''; 
				  }
				  
			}
				  echo json_encode($this->_jsonData);
		}catch(Exception $e){
				  $this->_jsonData['status']="FAILURE";
				  $this->_jsonData['message']="Error Occured";
				  $this->_jsonData['data']=$data; 
		}
		$this->ServicesModel->createService($_REQUEST,$this->_jsonData,$_SERVER['SERVER_ADDR'],'editPicture',$_FILES);

	} */
	
	public function updateCeller(){
		$id = $this->input->get_post('id');
		$variety = $this->input->get_post('variety');
		$winery = $this->input->get_post('winery');
		$flavour = $this->input->get_post('flavour');
		$aroma = $this->input->get_post('aroma');
		$year = $this->input->get_post('year');
		$food = $this->input->get_post('food');
		$price = $this->input->get_post('price');
		$WineryPhone = $this->input->get_post('phone');
		$rateit = $this->input->get_post('rateit');
		$lat = $this->input->get_post('lat');
		$long = $this->input->get_post('long');
                $data= array();
                
                
                
                try{
                                        if(isset($_FILES['file'])){
					 $imgName = time();
					 $imgPath = BASEPATH."../uploads/".$imgName;
					 $image = base_url().'uploads/'.$imgName;
					 move_uploaded_file($_FILES["file"]["tmp_name"],$imgPath.".jpg");
					 $this->load->library('imagethumb');
					 $this->imagethumb->image($imgPath.".jpg",200,200);
					 $imageNew =$image."_thumb.jpg";
                                         $data['image'] = $imageNew;
                                        }
                                        
                                        $data['variety']=$variety;
					$data['winery']=$winery;
					$data['flavour']=$flavour;
					$data['aroma']=$aroma;
					$data['year']=$year;
					$data['food']= $food;
					$data['price']=$price;
					$data['phone']=$WineryPhone;
					$data['rateit']=$rateit;
					$data['latitude']=$lat;
        				$data['longitude']=$long;
						
                                        $res = $this->webservicesModel->updateCeller($id,$data);
                                        if($res==1){
                                        
						$this->_jsonData['status']=$res;
						$this->_jsonData['message']="Celler Data Updated Successfully";
						$this->_jsonData['data']=$res;       
                                                echo json_encode($this->_jsonData);
                                        }
                                        else{
                                                $this->_jsonData['status']=$res;
						$this->_jsonData['message']="Celler Data Updated faild";
						$this->_jsonData['data']=$res;       
                                                echo json_encode($this->_jsonData);
                                        }
	}catch(Exception $e){
				$this->_jsonData['status']=0;
				$this->_jsonData['message']="Error Occured";
				$this->_jsonData['data']='';
		}
		$this->ServicesModel->createService($_REQUEST,$this->_jsonData,$_SERVER['SERVER_ADDR'],'updateCeller',$_FILES);
		
	}
	
	public function getCellerByCellerId(){
		$id = $this->input->get_post('id');
		try{
			if($id == false || $id==""){
				$this->_jsonData['status']=0;
				$this->_jsonData['message']="Id Missing";
			}else{
				$data = $this->webservicesModel->getCellerById($id);
				$this->_jsonData['status']=1;
				$this->_jsonData['message']="Celler By Id got Successfully";
				$this->_jsonData['data']=$data;
			}
			echo json_encode($this->_jsonData);
		}catch(Exception $e){
				$this->_jsonData['status']=0;
				$this->_jsonData['message']="Error Occured";
				$this->_jsonData['data']='';
		}
		$this->ServicesModel->createService($_REQUEST,$this->_jsonData,$_SERVER['SERVER_ADDR'],'getCellerByCellerId',$_FILES);
		
	}
        
    public function getCellerByTourId(){
		$id = $this->input->get_post('id');
		try{
			if($id == false || $id==""){
				$this->_jsonData['status']=0;
				$this->_jsonData['message']="Id Missing";
			}else{
				$data = $this->webservicesModel->getCellarByTourId($id);
				$this->_jsonData['status']=1;
				$this->_jsonData['message']="Celler got Successfully";
				$this->_jsonData['data']=$data;
			}
			echo json_encode($this->_jsonData);
		}catch(Exception $e){
				$this->_jsonData['status']=0;
				$this->_jsonData['message']="Error Occured";
				$this->_jsonData['data']='';
		}
		$this->ServicesModel->createService($_REQUEST,$this->_jsonData,$_SERVER['SERVER_ADDR'],'getCellerByCellerId',$_FILES);
		
	}

	public function getActiveTour(){
		$user_id = $this->input->get_post('user_id');
		try{
			if($user_id=="" || $user_id==false){
				$this->_jsonData['status']=0;
				$this->_jsonData['message']="User Id Missing";
			}else{
				$data = $this->webservicesModel->getActiveTour($user_id);
				$this->_jsonData['status']=1;
				$this->_jsonData['message']="Active Tour Got Successfully";
				$this->_jsonData['data']=$data;
			}
				echo json_encode($this->_jsonData);
		}catch(Exception $e){
				$this->_jsonData['status']=0;
				$this->_jsonData['message']="Error Occured";
				$this->_jsonData['data']='';
		}
		$this->ServicesModel->createService($_REQUEST,$this->_jsonData,$_SERVER['SERVER_ADDR'],'getActiveTour',$_FILES);
		
	}
	
	public function getInActiveTour(){
		$user_id = $this->input->get_post('user_id');
		try{
			if($user_id=="" || $user_id==false){
				$this->_jsonData['status']=0;
				$this->_jsonData['message']="User Id Missing";
			}else{
				$data = $this->webservicesModel->getInActiveTour($user_id);
				$this->_jsonData['status']=1;
				$this->_jsonData['message']="In Active Tour Got Successfully";
				$this->_jsonData['data']=$data;
			}
				echo json_encode($this->_jsonData);
		}catch(Exception $e){
				$this->_jsonData['status']=0;
				$this->_jsonData['message']="Error Occured";
				$this->_jsonData['data']='';
		}
		$this->ServicesModel->createService($_REQUEST,$this->_jsonData,$_SERVER['SERVER_ADDR'],'getActiveTour',$_FILES);
		
	}

	public function getOperators(){
		try{
				$data = $this->webservicesModel->selectOperators();
				$this->_jsonData['status']=1;
				$this->_jsonData['message']="Operators Got Successfully";
				$this->_jsonData['data']=$data;
				echo json_encode($this->_jsonData);
		}catch(Exception $e){
				$this->_jsonData['status']=0;
				$this->_jsonData['message']="Error Occured";
				$this->_jsonData['data']='';
		}
		$this->ServicesModel->createService($_REQUEST,$this->_jsonData,$_SERVER['SERVER_ADDR'],'getOperators',$_FILES);
		
	}
	
} // controller ends
