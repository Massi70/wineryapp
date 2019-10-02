<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class wineries extends CI_Controller {

	public function __construct(){

        parent::__construct();

		$userAdmin=$this->session->userdata(APP_NAME.'_admin');

		if($userAdmin==false){

			redirect(base_url()."admin/index/login");

			exit();

		}

		$this->load->model('userModel');
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
			$AllWineries=$this->adminModel->countAllWineries($key);
			$data=$this->adminModel->wineList($offSet,$limit);
		}else{
			$appType = $this->input->get_post('type_id');
			$AllWineries=$this->adminModel->countAllWineries();
			$data=$this->adminModel->wineList($appType,$offSet,$limit);
		}
		$paging=$pagination->create($page ,base_url().'admin/wineries/?type_id='.$appType.'' , $AllWineries ,'main_div' ,base_url().'images/admin/spinner_small.gif','paging_spinner',$limit);
		$assignData=array('pageName'=>'wineries','data'=>$data,'appType'=>$appType,'AllWineries'=>$AllWineries,'paging'=>$paging['html'],'search'=>$key);
		if($ajax!=1){
			$this->load->view('admin/header',$assignData);
		}
			$this->load->view('admin/wineries',$assignData);
		if($ajax!=1){
			$this->load->view('admin/footer');
		}

/*
			$data = $this->adminModel->wineList();
			$assignData=array('pageName'=>'wineries','data'=>$data);
			$this->load->view('admin/header',$assignData);
			$this->load->view('admin/wineries',$assignData);
			$this->load->view('admin/footer');

*/
	}
	
	public function addWine(){
		if(count($_POST)>0){
			$appType = $this->input->get_post('estate');
			$association = $this->input->get_post('association_id');
			$name=$this->input->get_post('name');
			$email=$this->input->get_post('user_email');
			$password=$this->input->get_post('password');
			$file=$this->input->get_post('file');
			$country =$this->input->get_post('country');
			$province =$this->input->get_post('province');
			$address =$this->input->get_post('address');
			$contact = $this->input->get_post('contact');
			$link = $this->input->get_post('link');
			$description = $this->input->get_post('description');
			$notes = $this->input->get_post('notes');
			$latlong = $this->input->get_post('txt_latlng');

			 $imgName = time();
			 $imgPath = BASEPATH."../uploads/".$imgName;
			 $image = base_url().'uploads/'.$imgName;
			 move_uploaded_file($_FILES["file"]["tmp_name"],$imgPath.".jpg");
			 $this->load->library('imagethumb');
			 $this->imagethumb->image($imgPath.".jpg",200,200);
			 $imageNew =$imgName."_thumb.jpg";
			 
			 $array = array();
			 $latlong1 = explode(",", $latlong);
			 $latitude = $latlong1[0];
			 $longitude = $latlong1[1];
			
				$data = array(
					'user_type_id'=>'2',
					'app_type_id'=>$appType,
					'user_name'=>$name,
					'user_email'=>$email,
					'password'=>base64_encode($password),
					'image'=>$imageNew,
					'association_id'=>$association,
					'country'=>$country,
					'province'=>$province,
					'address'=>$address,
					'contact'=>$contact,
					'link'=>$link,
					'description'=>$description,
					'notes'=>$notes,
					'latitude'=>$latitude,
					'longitude'=>$longitude
				);
				$wineryId=$this->adminModel->addWine($data);
	
				$totalImages = count($_FILES["item_file"]['name']);
				if($totalImages>0){ 
					for($j=0; $j<$totalImages; $j++) { 
						$filen = time().'_'.$j.".jpg"; 
						$path = BASEPATH.'../uploads/events/'.$filen; 
						$image = base_url().'uploads/events/'.$filen;
						$images =$filen;
						move_uploaded_file($_FILES["item_file"]['tmp_name']["$j"],$path);
						
						$data1 = array(
							'winery_id'=>$wineryId,
							'image'=>$images
						);
						$this->adminModel->addWineryImages($data1);
					}
				}
					$assignData=array('pageName'=>'wineries','data'=>$data,'data1'=>$data1);
					if($appType == 1){
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
					redirect(base_url().'admin/wineries/?type_id=1');
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
					redirect(base_url().'admin/wineries/?type_id=2');
				}
		}else{
				$page=$this->input->get('page');
				$limit='10';
				$offSet=($page>1) ? ($page-1)*$limit : 0;
				$association = $this->adminModel->getAssociation($offSet,$limit);	
				$assignData = array('pageName'=>'wineries','association'=>$association);
				$this->load->view('admin/header',$assignData);
				$this->load->view('admin/addwine',$assignData);
				$this->load->view('admin/footer');
			}
	}
	
	public function view(){
			$id=$this->input->get_post('id');
			$data = $this->adminModel->getWineDetails($id);
			$data1 = $this->adminModel->getWineEventImages($id);
			$assignData=array('pageName'=>'wineries','data'=>$data,'data1'=>$data1);
			$this->load->view('admin/header',$assignData);
			$this->load->view('admin/wineriesview',$assignData);
			$this->load->view('admin/footer');
	}
	
	public function edit(){
			$id=$this->input->get_post('id');
			$data = $this->adminModel->getWineDetails($id);
			//$assignData=array('pageName'=>'wineries','data'=>$data);
			$page=$this->input->get('page');
			$limit='10';
			$offSet=($page>1) ? ($page-1)*$limit : 0;
			$association = $this->adminModel->getAssociation($offSet,$limit);	
			$assignData = array('pageName'=>'wineries','data'=>$data,'association'=>$association);	
			$this->load->view('admin/header',$assignData);
			$this->load->view('admin/wineriesedit',$assignData);
			$this->load->view('admin/footer');
	}
		
	public function update(){
			$winery_id=$this->input->get_post('winery_id');
			$association = $this->input->get_post('association_id');
			$name = $this->input->get_post('name');
			$password = $this->input->get_post('password');
			$country = $this->input->post('country');
			$province = $this->input->post('province');
			$address = $this->input->post('address');
			$contact = $this->input->post('contact');
			$link = $this->input->post('link');
			$description = $this->input->post('description');
			$notes = $this->input->post('notes');
			$longitude = $this->input->post('longitude');
			$latitude = $this->input->post('latitude');

        $data = array(
				  "id"=>$winery_id,
				  'association_id'=>$association,
                  "user_name" => $name,
				  "password" => base64_encode($password),
                  "country" => $country,
                  "province" => $province,
				  "address" => $address,
				  "contact" => $contact,
				  "link" => $link,
				  "description" => $description,
				  "notes" => $notes,
				  "longitude" => $longitude,
				  "latitude" => $latitude
                 );
			$data = $this->adminModel->updateWine($data,$winery_id);
			$assignData=array('pageName'=>'wineries','data'=>$data);
			$this->load->view('admin/header',$assignData);
			$this->load->view('admin/wineriesview',$assignData);
			$this->load->view('admin/footer');
			redirect(base_url().'admin/wineries/view/?id='.$winery_id);

    }
	
	public function delete(){	
		$id=$this->input->get_post('id');
		if($id > 0){
			  $this->adminModel->deleteWine($id);
		}
			redirect(base_url().'admin/wineries/?type_id=all');
	}
	
	public function editImage(){
			$id=$this->input->get_post('id');
			$data = $this->adminModel->getWineDetails($id);
			$assignData=array('pageName'=>'wineries','data'=>$data);
			$this->load->view('admin/header',$assignData);
			$this->load->view('admin/wineriesimage',$assignData);
			$this->load->view('admin/footer');
	}
	
	public function editPicture(){
		  $id = $this->input->get_post('id');
		  $assignData=array('pageName'=>'wineriesview');
		  $imgName = time();
		  $imgPath = BASEPATH."../uploads/".$imgName;
		  $image = base_url().'uploads/'.$imgName;
				
		  if(move_uploaded_file($_FILES["file"]["tmp_name"],$imgPath.".jpg")){
			  $this->load->library('imagethumb');
			  $this->imagethumb->image($imgPath.".jpg",200,200);
			  $userData['image']=$imgName."_thumb.jpg";
			  $view =$imgName."_thumb.jpg";
						//'image_path'=>$image."_thumb.jpg",

			  $this->adminModel->updateWineriesImage($view,$id);
			  redirect(base_url().'admin/wineries/view/?id='.$id);

		  }
	}
	
	public function checkUsers($user_email){
		$checkUser = $this->adminModel->checkUserEmail($user_email);
		echo $checkUser;
	}
	

}


/* End of file welcome.php */

/* Location: ./application/controllers/welcome.php */
?>