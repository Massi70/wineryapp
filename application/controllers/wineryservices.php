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
		$contact = $this->input->get_post('contact');
		$url = $this->input->get_post('url');
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
			}else if($contact == false || $contact == "" ){
				$this->_jsonData['status']=0;
				$this->_jsonData['message']="contact number missing";
			}else if($url == false || $url == "" ){
				$this->_jsonData['status']=0;
				$this->_jsonData['message']="Web URL is Missing";
			}else{
					$checkUserEmail = $this->webservicesModel->checkUserEmail($user_email);
					if($checkUserEmail == 0){
						$data = array(
								'fb_id'=>$fbId,
								'twitter_id'=>$twitterId,
								'user_email'=>$user_email,
								'user_name'=>$user_name,
								'password'=>base64_encode($password),
								'user_status'=>'1',
								'user_type_id'=>'4',
								'contact'=>$contact,
								'link'=>$url
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
            
            if($fb_id!=""||$twitter_id!=""){
		if($fb_id!=""){
			$fbLogin = $this->webservicesModel->fbLogin($fb_id);
			if(empty($fbLogin)){
                        $this->_jsonData['status']=2;
                        $this->_jsonData['message']="User not found";
            }
            
            else{
                        $this->_jsonData['status']=1;
                        $this->_jsonData['message']="User Logged In Successfully";
                        $this->_jsonData['data']=$fbLogin;
                }
                
		}
		
		if($twitter_id!=""){
			$twitterLogin = $this->webservicesModel->twitterLogin($twitter_id);
			if(empty($twitterLogin)){
                        $this->_jsonData['status']=2;
                        $this->_jsonData['message']="User not found";
            }
            else
                {
                        $this->_jsonData['status']=1;
                        $this->_jsonData['message']="User Logged In Successfully";
                        $this->_jsonData['data']=$twitterLogin;
                }
		}
                
                
                
            }
                else if($user_email == false || $user_email == ""){
                        $this->_jsonData['status']=0;
                        $this->_jsonData['message']="User Email Missing";
			}
                        else if($password == false || $password == ""){
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
		$user_id = $this->input->get_post('user_id');
		$appType = $this->input->get_post('type_id');
		try{
			if($association_id == false || $association_id == ""){
				$this->_jsonData['status']=0;
				$this->_jsonData['message']="Association Id Missing";
			}else if($user_id == false || $user_id == ""){
				$this->_jsonData['status']=0;
				$this->_jsonData['message']="user Id Missing";
			}else if($appType == false || $appType ==""){
				$this->_jsonData['status'] = 0;
				$this->_jsonData['message']="App Type Id Missing";
			}else{
				$data = $this->webservicesModel->getWineryDetailsByAssociation($association_id,$appType,$user_id);
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
                    $data = array(
						'user_id'=>$user_id,
						'event_id'=>$event_id,
						'is_going'=>$is_going,
					);
				$this->webservicesModel->addEventGoingOrNot($data);
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
			}else if($description == false || $description == ""){
				$this->_jsonData['status']=0;
				$this->_jsonData['message']="description is Missing";
			}else if($is_active == ""){
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
					 $this->imagethumb->image($imgPath.".jpg",471,138);
					 $imageNew =$imgName."_thumb.jpg";
				
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
						}else{
							$this->_jsonData['status']=$res;
							$this->_jsonData['message']="Celler Data Updated faild";
							$this->_jsonData['data']=$res;       
					   }
							echo json_encode($this->_jsonData);
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
	
    public function getAllCellars(){
		try{
				$data = $this->webservicesModel->getAllCellars();
				$this->_jsonData['status']=1;
				$this->_jsonData['message']="Celler got Successfully";
				$this->_jsonData['data']=$data;
			echo json_encode($this->_jsonData);
		}catch(Exception $e){
				$this->_jsonData['status']=0;
				$this->_jsonData['message']="Error Occured";
				$this->_jsonData['data']='';
		}
		$this->ServicesModel->createService($_REQUEST,$this->_jsonData,$_SERVER['SERVER_ADDR'],'getAllCellars',$_FILES);
		
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
		$appType = $this->input->get_post('type_id');
		try{
			if($appType == false || $appType ==""){
				$this->_jsonData['status'] = 0;
				$this->_jsonData['message']="App Type Id Missing";
			}else{
				$data = $this->webservicesModel->selectOperators($appType);
				$this->_jsonData['status']=1;
				$this->_jsonData['message']="Operators Got Successfully";
				$this->_jsonData['data']=$data;
			}
				echo json_encode($this->_jsonData);
		}catch(Exception $e){
				$this->_jsonData['status']=0;
				$this->_jsonData['message']="Error Occured";
				$this->_jsonData['data']='';
		}
		$this->ServicesModel->createService($_REQUEST,$this->_jsonData,$_SERVER['SERVER_ADDR'],'getOperators',$_FILES);
		
	}
	
	public function InActiveTour(){
		$tour_id = $this->input->get_post('tour_id');
		try{
			if($tour_id=="" || $tour_id==false){
				$this->_jsonData['status']=0;
				$this->_jsonData['message']="tour_id Missing";
			}else{
				$data = $this->webservicesModel->changeTour($tour_id);
				$this->_jsonData['status']=1;
				$this->_jsonData['message']="Tour Inactivated Successfully";
				$this->_jsonData['data']='';
			}
				echo json_encode($this->_jsonData);
		}catch(Exception $e){
				$this->_jsonData['status']=0;
				$this->_jsonData['message']="Error Occured";
				$this->_jsonData['data']='';
		}
		$this->ServicesModel->createService($_REQUEST,$this->_jsonData,$_SERVER['SERVER_ADDR'],'InActiveTour',$_FILES);
		
	}
	
	public function getDistance(){
		$lat = $this->input->get_post('lat');
		$long = $this->input->get_post('long');
		$distance = $this->input->get_post('distance');
		$city = $this->input->get_post('city');
		$data_latlon = array();

		try{
			$latLong = $this->webservicesModel->getAllLatLong($city);
			//echo '<pre>';print_r($latLong);
			$i=0;
			foreach($latLong as $l):
			
			$get_distance = $this->distance($lat,$long,$l['latitude'],$l['longitude']);
			
			if($get_distance<=$distance){
				//echo $get_distance."<br/>";
				$data_latlon[$i] = $latLong[$i];
				$i++;
			}
			endforeach;
				$this->_jsonData['status']=1;
				$this->_jsonData['message']="Distance Measured Successfully";
				$this->_jsonData['data']=$data_latlon;
				
				echo json_encode($this->_jsonData);
		}catch(Exception $e){
			$this->_jsonData['status']=0;
			$this->_jsonData['message']="Error Occured";
		}
		$this->ServicesModel->createService($_REQUEST,$this->_jsonData,$_SERVER['SERVER_ADDR'],'getDistance',$_FILES);
		
	}
	
	function distance($lat1, $lng1, $lat2, $lng2 , $miles = true){
		$pi80 = M_PI / 180;
		$lat1 *= $pi80;
		$lng1 *= $pi80;
		$lat2 *= $pi80;
		$lng2 *= $pi80;
		
		$r = 6372.797; // mean radius of Earth in km
		$dlat = $lat2 - $lat1;
		$dlng = $lng2 - $lng1;
		$a = sin($dlat / 2) * sin($dlat / 2) + cos($lat1) * cos($lat2) * sin($dlng / 2) * sin($dlng / 2);
		$c = 2 * atan2(sqrt($a), sqrt(1 - $a));
		$km = $r * $c;
		
		return ($miles ? ($km * 0.621371192) : $km);
	}
	
	public function rateWinery(){
		$user_id = $this->input->get_post('user_id');
		$winery_id = $this->input->get_post('winery_id');
		$rate = $this->input->get_post('rate');
		try{
			if($user_id=="" || $user_id==false){
				$this->_jsonData['status']=0;
				$this->_jsonData['message']="user_id Missing";
			}else if($winery_id=="" || $winery_id==false){
				$this->_jsonData['status']=0;
				$this->_jsonData['message']="winery_id Missing";
			}else if ($rate=="" || $rate==false){
				$this->_jsonData['status']=0;
				$this->_jsonData['message']="rate Missing";
			}else{
				$checkRating = $this->webservicesModel->checkRating($user_id,$winery_id);
				if(count($checkRating)>0){
					$this->webservicesModel->updateRating($user_id,$winery_id,$rate);
					$this->_jsonData['status']=1;
					$this->_jsonData['message']="Update Successfully";
				}else{
					$data = array(
							'user_id'=>$user_id,
							'winery_id'=>$winery_id,
							'rate'=>$rate
						);
					$this->webservicesModel->insertWineryRating($data);
					$this->_jsonData['status']=1;
					$this->_jsonData['message']="Winery Rating Added Successfully";
					$this->_jsonData['data']=$data;
				}
			}
				echo json_encode($this->_jsonData);
		}catch(Exception $e){
			$this->_jsonData['status']=0;
			$this->_jsonData['message']="Error Occured";
		}
		$this->ServicesModel->createService($_REQUEST,$this->_jsonData,$_SERVER['SERVER_ADDR'],'rateWinery',$_FILES);
		
	}
	
	public function tourGallery(){
		$tour_id = $this->input->get_post('tour_id');
		$path = $this->input->get_post('path');
		$is_image = $this->input->get_post('is_image');
		
		try{
			/*if($tour_id=="" || $tour_id==false){
				$this->_jsonData['status']=0;
				$this->_jsonData['message']="tour_id Missing";
			}else if ($path=="" || $path==false){
				$this->_jsonData['status']=0;
				$this->_jsonData['message']="path Missing";
			}else{*/
					 if($is_image == 1){
						$imgName = time();
						$imgPath = BASEPATH."../uploads/".$imgName;
						$image = base_url().'uploads/'.$imgName;
						move_uploaded_file($_FILES["file"]["tmp_name"],$imgPath.".jpg");
						$this->load->library('imagethumb');
						$this->imagethumb->image($imgPath.".jpg",200,200);
						$imageNew =$imgName."_thumb.jpg";
						$data = array(
							'tour_id'=>$tour_id,
							'data'=>base_url().'uploads/'.$imageNew,
							'path'=>$path,
							'is_image'=>1,
							'video_thumb'=>''
						 );
						$this->webservicesModel->insertTourGallery($data);
						$this->_jsonData['status']=1;
						$this->_jsonData['message']="Record Added Successfully";
						$this->_jsonData['data']=$data;
					}else{
						$fileName = time().".mp4";
						$input=BASEPATH.'../uploads/'.$fileName;
						$video = base_url().'uploads/'.$fileName;
						move_uploaded_file($_FILES["file"]["tmp_name"],$input);
						$ffmpegpath = "/usr/local/bin/ffmpeg";
						$videoImage=time().'user'.$tour_id.'.jpg';
                                                $videoImagethumb=time().'user'.$tour_id.'_thumb.jpg';
                                                
                                                $outputthumb=BASEPATH.'../uploads/r'.$videoImagethumb;
                                                $output1=BASEPATH.'../uploads/r'.$videoImage;
                                                $output2=BASEPATH.'../uploads/'.$videoImage;
                                                $playicon = BASEPATH.'../uploads/play_icon.png';
                                                                        $command="$ffmpegpath -i $input -an -ss 00:00:01 -r 1 -vframes 1 -f mjpeg -y $output1";
                                                                        exec($command,$output,$return);
                                                                        
                                                $this->load->library('imagethumb');
						$this->imagethumb->image($output1,200,200);     
                                                
                                                                        /******  Get Thumb Image  *********/
                                                $dest = imagecreatefromjpeg($outputthumb);$sizedest = getimagesize($outputthumb);

                                                                        /******   Play icon Image *********/
                                                $src = imagecreatefrompng($playicon);$size = getimagesize($playicon);

                                                                        /******   Mergining and placing play icon on center of image *********/
                                                ob_start();
                                                $this->imagecopymerge_alpha($dest, $src, ($sizedest[0]/2)-($size[0]/2), $sizedest[1]/2-($size[1]/2), 0, 0, $size[1]-1,$size[0],100);
                                                imagepng($dest);

                                                file_put_contents($output2,ob_get_clean());unlink($output1);unlink($outputthumb);

						$data = array(
							'tour_id'=>$tour_id,
							'data'=>$video,
							'path'=>$path,
							'is_image'=>0,
							'video_thumb'=>base_url().'uploads/'.$videoImage
						);
						$this->webservicesModel->insertTourGallery($data);
						$this->_jsonData['status']=1;
						$this->_jsonData['message']="Record Added Successfully";
						$this->_jsonData['data']=$data;
					}
			//}
				echo json_encode($this->_jsonData);
		}catch(Exception $e){
			$this->_jsonData['status']=0;
			$this->_jsonData['message']="Error Occured";
		}
		$this->ServicesModel->createService($_REQUEST,$this->_jsonData,$_SERVER['SERVER_ADDR'],'tourGallery',$_FILES);
		
	}
        
    public function imagecopymerge_alpha($dst_im, $src_im, $dst_x, $dst_y, $src_x, $src_y, $src_w, $src_h, $pct){
        // creating a cut resource
        $cut = imagecreatetruecolor($src_w, $src_h);
        // copying relevant section from background to the cut resource
        imagecopy($cut, $dst_im, 0, 0, $dst_x, $dst_y, $src_w, $src_h);
        // copying relevant section from watermark to the cut resource
        imagecopy($cut, $src_im, 0, 0, $src_x, $src_y, $src_w, $src_h);
        // insert cut resource to destination image
        imagecopymerge($dst_im, $cut, $dst_x, $dst_y, 0, 0, $src_w, $src_h, $pct);
        }
	
	public function getTourGallery(){
		$tour_id = $this->input->get_post('tour_id');
		try{
			if($tour_id=="" || $tour_id==false){
				$this->_jsonData['status']=0;
				$this->_jsonData['message']="tour_id Missing";
			}else{
				$res = $this->webservicesModel->getTourGalleryData($tour_id);	
				$this->_jsonData['status']=1;
				$this->_jsonData['message']="Tour Data Retrived Successfully ";
				$this->_jsonData['data']=$res;
			}
				echo json_encode($this->_jsonData);
		}catch(exception $e){
				$this->_jsonData['status']=0;
				$this->_jsonData['message']="Error Occured";
		}
		$this->ServicesModel->createService($_REQUEST,$this->_jsonData,$_SERVER['SERVER_ADDR'],'getTourGallery',$_FILES);
		
	}
	
	public function addTourNotes(){
		$tour_id = $this->input->get_post('tour_id');
		$notes = $this->input->get_post('notes');
		try{
			if($tour_id=="" || $tour_id==false){
				$this->_jsonData['status']=0;
				$this->_jsonData['message']="tour_id Missing";
			}else if($notes=="" || $notes==false){
				$this->_jsonData['status']=0;
				$this->_jsonData['message']="Notes Missing";
			}else{
				$data = array(
							'tour_id'=>$tour_id,
							'notes'=>$notes,
							'datetime'=>date('Y-m-d H:i:s')
						);
				$res = $this->webservicesModel->insertTourNotes($data);	
				$this->_jsonData['status']=1;
				$this->_jsonData['message']="Tour Notes Added Successfully ";
                                $data['note_id'] = $this->db->insert_id();
				$this->_jsonData['data']=$data;
			}
				echo json_encode($this->_jsonData);
		}catch(exception $e){
				$this->_jsonData['status']=0;
				$this->_jsonData['message']="Error Occured";
		}
		$this->ServicesModel->createService($_REQUEST,$this->_jsonData,$_SERVER['SERVER_ADDR'],'addTourNotes',$_FILES);
	}

	public function getTourNotesById(){
		$tour_id = $this->input->get_post('tour_id');
		try{
			if($tour_id=="" || $tour_id==false){
				$this->_jsonData['status']=0;
				$this->_jsonData['message']="tour_id Missing";
			}else{
				$res = $this->webservicesModel->getTourNoteById($tour_id);	
				$this->_jsonData['status']=1;
				$this->_jsonData['message']="Tour Notes Retrived Successfully ";
				$this->_jsonData['data']=$res;
			}
				echo json_encode($this->_jsonData);
		}catch(exception $e){
				$this->_jsonData['status']=0;
				$this->_jsonData['message']="Error Occured";
		}
		$this->ServicesModel->createService($_REQUEST,$this->_jsonData,$_SERVER['SERVER_ADDR'],'getTourNotesById',$_FILES);
		
	}
	
	public function getTourByUserId(){
		$user_id = $this->input->get_post('user_id');
		try{
			if($user_id=="" || $user_id==false){
				$this->_jsonData['status']=0;
				$this->_jsonData['message']="user_id Missing";
			}else{
				$res = $this->webservicesModel->getTourByUserId($user_id);	
				$this->_jsonData['status']=1;
				$this->_jsonData['message']="User Tours Retrived Successfully ";
				$this->_jsonData['data']=$res;
			}
				echo json_encode($this->_jsonData);
		}catch(exception $e){
				$this->_jsonData['status']=0;
				$this->_jsonData['message']="Error Occured";
		}
		$this->ServicesModel->createService($_REQUEST,$this->_jsonData,$_SERVER['SERVER_ADDR'],'getTourByUserId',$_FILES);
		
	}

	public function deleteTourNotes(){
		$note_id = $this->input->get_post('note_id');
		try{
			if($note_id=="" || $note_id==false){
				$this->_jsonData['status']=0;
				$this->_jsonData['message']="note_id Missing";
			}else{
				$this->webservicesModel->deleteTourNotes($note_id);	
				$this->_jsonData['status']=1;
				$this->_jsonData['message']="Note Deleted Successfully ";
			}
				echo json_encode($this->_jsonData);
		}catch(exception $e){
				$this->_jsonData['status']=0;
				$this->_jsonData['message']="Error Occured";
		}
		$this->ServicesModel->createService($_REQUEST,$this->_jsonData,$_SERVER['SERVER_ADDR'],'deleteTourNotes',$_FILES);
		
	}
	
	public function updateTourNotes(){
		$note_id = $this->input->get_post('note_id');
		$notes = $this->input->get_post('notes');
		try{
			if($note_id=="" || $note_id==false){
				$this->_jsonData['status']=0;
				$this->_jsonData['message']="note_id Missing";
			}else if($notes=="" || $notes==false){
				$this->_jsonData['status']=0;
				$this->_jsonData['message']="notes Missing";
			}else{
				$data = array(
						'note_id'=>$note_id,
						'notes'=>$notes,
						'datetime'=>date('Y-m-d H:i:s')
					);
				$this->webservicesModel->updateTourNotes($note_id,$data);	
				$this->_jsonData['status']=1;
				$this->_jsonData['message']="Note Updated Successfully ";
				$this->_jsonData['data']=$data;
			}
				echo json_encode($this->_jsonData);
		}catch(exception $e){
				$this->_jsonData['status']=0;
				$this->_jsonData['message']="Error Occured";
		}
		$this->ServicesModel->createService($_REQUEST,$this->_jsonData,$_SERVER['SERVER_ADDR'],'updateTourNotes',$_FILES);
		
	}

} // controller ends
