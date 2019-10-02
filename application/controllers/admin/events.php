<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Events extends CI_Controller {

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
		$id=$this->input->get_post('id');
		
		$limit='50';
		$page=($page==false) ? 1 : $page; 
		
		$offSet=($page>1) ? ($page-1)*$limit : 0;
		$this->load->helper('pagination_helper');
		$pagination=Pagination_helper::getInstance();
		if($key!=false){
			$AllEvents=$this->adminModel->countAllEvents($key);
			$data=$this->adminModel->getWine($id,$offSet,$limit);
		}else{
			$AllEvents=$this->adminModel->countAllEvents();
			$data=$this->adminModel->getWine($id,$offSet,$limit);
		}
	
		$paging=$pagination->create($page ,base_url().'admin/events/?id='.$id.'' , $AllEvents ,'main_div' ,base_url().'images/admin/spinner_small.gif','paging_spinner',$limit);
		$assignData=array('pageName'=>'events','data'=>$data,'AllEvents'=>$AllEvents,'paging'=>$paging['html'],'search'=>$key);
		if($ajax!=1){
			$this->load->view('admin/header',$assignData);
		}
		$this->load->view('admin/events',$assignData);
		if($ajax!=1){
			$this->load->view('admin/footer');
		}
	}
	
	public function view(){
			$id=$this->input->get_post('id');
			$eventGoing = $this->adminModel->eventGoing($id);
			$eventNotGoing = $this->adminModel->eventNotGoing($id);
			$data = $this->adminModel->getEventDetails($id);
			$assignData=array('pageName'=>'events','data'=>$data,'eventGoing'=>$eventGoing,'eventNotGoing'=>$eventNotGoing);
			$this->load->view('admin/header',$assignData);
			$this->load->view('admin/eventsview',$assignData);
			$this->load->view('admin/footer');
	}

	public function addEvent(){
		$ajax=$this->input->get('ajax');
		$winery = $this->adminModel->getWineNew();
		$assignData=array('pageName'=>'events','winery'=>$winery);
		if(count($_POST)>0){
			$user_id=$this->input->get_post('user_id');
			$name=$this->input->get_post('name');
			$file=$this->input->get_post('file');
			$description =$this->input->get_post('description');
			$venue =$this->input->get_post('venue');
			$timedate =$this->input->get_post('timedate');
			$flavour = $this->input->get_post('flavour');
			$entryfee = $this->input->get_post('entryfee');
			$contact = $this->input->get_post('contact');
			$link = $this->input->get_post('link');
			$email = $this->input->get_post('email');
			$phone = $this->input->get_post('phone');
			//$latitude = $this->input->get_post('latitude');
			//$longitude = $this->input->get_post('longitude');
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
				'winery_id'=>$user_id,
				'event_name'=>$name,
				'status'=>'1',
				'image'=>$imageNew,
				'description'=>$description,
				'venue'=>$venue,
				'timedate'=>$timedate,
				'flavour'=>$flavour,
				'entry_fee'=>$entryfee,
				'contact'=>$contact,
				'link'=>$link,
				'email'=>$email,
				'phone'=>$phone,
				'latitude'=>$latitude,
				'longitude'=>$longitude
			);
			//var_dump($data);exit;
			$this->adminModel->addEvent($data);
			$assignData=array('pageName'=>'events','data'=>$data);
			redirect(base_url().'admin/wineries/?type_id=all');
		}else{
			if($ajax!=1){
				$this->load->view('admin/header',$assignData);
			}
				$this->load->view('admin/addevent',$assignData);
			if($ajax!=1){
				$this->load->view('admin/footer');
			}
		}
		
	}
	
	public function edit(){
			$id=$this->input->get_post('id');
			$data = $this->adminModel->getEventDetails($id);
			$assignData=array('pageName'=>'events','data'=>$data);
			$this->load->view('admin/header',$assignData);
			$this->load->view('admin/eventsedit',$assignData);
			$this->load->view('admin/footer');
	}
		
	public function update(){
			$event_id=$this->input->get_post('event_id');
			$name=$this->input->get_post('name');
			$description =$this->input->get_post('description');
			$venue =$this->input->get_post('venue');
			$timedate =$this->input->get_post('timedate');
			$flavour = $this->input->get_post('flavour');
			$entryfee = $this->input->get_post('entryfee');
			$contact = $this->input->get_post('contact');
			$link = $this->input->get_post('link');
			$email = $this->input->get_post('email');
			$phone = $this->input->get_post('phone');
			$longitude = $this->input->get_post('longitude');
			$latitude = $this->input->get_post('latitude');

        $data = array(
				'event_id'=>$event_id,
				'event_name'=>$name,
				'description'=>$description,
				'venue'=>$venue,
				'timedate'=>$timedate,
				'flavour'=>$flavour,
				'entry_fee'=>$entryfee,
				'contact'=>$contact,
				'link'=>$link,
				'email'=>$email,
				'phone'=>$phone,
				'longitude'=>$longitude,
				'latitude'=>$latitude,
                 );
			$data = $this->adminModel->updateEvent($data,$event_id);
			$assignData=array('pageName'=>'events','data'=>$data);
			$this->load->view('admin/header',$assignData);
			$this->load->view('admin/eventsview',$assignData);
			$this->load->view('admin/footer');
			redirect(base_url().'admin/events/view/?id='.$event_id);
    }
	
	public function delete(){	
		$id=$this->input->get_post('id');
		if($id > 0){
			  $this->adminModel->deleteEvent($id);
		}
			redirect(base_url().'admin/wineries/?type_id=all');
	}
	
	public function editImage(){
			$id=$this->input->get_post('id');
			$data = $this->adminModel->getEventDetails($id);
			$assignData=array('pageName'=>'events','data'=>$data);
			$this->load->view('admin/header',$assignData);
			$this->load->view('admin/eventsimage',$assignData);
			$this->load->view('admin/footer');
	}
	
	public function editPicture(){
		  $id = $this->input->get_post('id');
		  $assignData=array('pageName'=>'eventsview');
		  $imgName = time();
		  $imgPath = BASEPATH."../uploads/".$imgName;
		  $image = base_url().'uploads/'.$imgName;
				
		  if(move_uploaded_file($_FILES["file"]["tmp_name"],$imgPath.".jpg")){
			  $this->load->library('imagethumb');
			  $this->imagethumb->image($imgPath.".jpg",200,200);
			  $userData['image']=$imgName."_thumb.jpg";
			  $view =$imgName."_thumb.jpg";

			  $this->adminModel->updateEventImage($view,$id);
			  redirect(base_url().'admin/events/view/?id='.$id);

		  }
	}
	
}
