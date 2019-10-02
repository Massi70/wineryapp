<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class association extends CI_Controller {
	public function __construct(){
        parent::__construct();
		$userAdmin=$this->session->userdata(APP_NAME.'_admin');
		if($userAdmin==false){
			redirect(base_url()."admin/index/login");
			exit();
		}
		$this->load->model('adminModel');
		//$this->load->helper('my_helper');
		
	}

/*	public function index(){

		if(count($_POST)>0){
			 $assignData=array('pageName'=>'association');
			 $imgName = time();
			 $imgPath = BASEPATH."../uploads/".$imgName;
			 $image = base_url().'uploads/'.$imgName;
			 move_uploaded_file($_FILES["file"]["tmp_name"],$imgPath.".jpg");
			  //$this->load->library('imagethumb');
				  //$this->imagethumb->image($imgPath.".jpg",100,100);
			 $data = array(
					'image'=>$image.".jpg",
				);
			$data['query']=	$this->adminModel->addAssociation($data);
			$data = $this->adminModel->getAssociation();
			$assignData=array('pageName'=>'association','data'=>$data);
			$this->load->view('admin/header',$assignData);
			$this->load->view('admin/association',$assignData);
			$this->load->view('admin/footer');
		}else{
			$data = $this->adminModel->getAssociation();
			$assignData=array('pageName'=>'association','data'=>$data);
			$this->load->view('admin/header',$assignData);
			$this->load->view('admin/association',$assignData);
			$this->load->view('admin/footer');
	 	}
		//print_r($data);
		//redirect(base_url().'index.php/index/');
		//return;
	}	 */
	
	public function index(){
		$ajax=$this->input->get('ajax');
		$page=$this->input->get('page');
		$key=$this->input->post('key');
		
		$limit='10';
		$page=($page==false) ? 1 : $page; 
		
		$offSet=($page>1) ? ($page-1)*$limit : 0;
		$this->load->helper('pagination_helper');
		$pagination=Pagination_helper::getInstance();
		if($key!=false){
			$AllAssociations=$this->adminModel->countAllAssociations($key);
			$data=$this->adminModel->getAssociation($offSet,$limit);
		}else{
			$AllAssociations=$this->adminModel->countAllAssociations();
			$data=$this->adminModel->getAssociation($offSet,$limit);
		}
		
		$paging=$pagination->create($page ,base_url().'admin/association/' , $AllAssociations ,'main_div' ,base_url().'images/admin/spinner_small.gif','paging_spinner',$limit);
		$assignData=array('pageName'=>'association','data'=>$data,'AllAssociations'=>$AllAssociations,'paging'=>$paging['html'],'search'=>$key);
		if($ajax!=1){
			$this->load->view('admin/header',$assignData);
		}
			$this->load->view('admin/association',$assignData);
		if($ajax!=1){
			$this->load->view('admin/footer');
		}


	
		
		
	/*	$data = $this->adminModel->getAssociation();
			$assignData=array('pageName'=>'association','data'=>$data);
			$this->load->view('admin/header',$assignData);
			$this->load->view('admin/association',$assignData);
			$this->load->view('admin/footer');
			
	*/
	}	 
	
	public function addAssociation(){
		$name = $this->input->get_post('name');
		$color = $this->input->get_post('colorpickerField1');
		$msg = '';
		if(count($_POST)>0){

				 $assignData=array('pageName'=>'addassociation');
				 $imgName = time();
				 $imgPath = BASEPATH."../uploads/associations/".$imgName;
				 $image = base_url().'uploads/associations/'.$imgName;
				
				 move_uploaded_file($_FILES["file"]["tmp_name"],$imgPath.".jpg");
				 $this->load->library('imagethumb');
				 $this->imagethumb->image($imgPath.".jpg",200,200);
				 $view = $imgName."_thumb.jpg"; /* for image name only in the db*/
				 $data = array(
						'association_name'=>$name,
						'image'=>$view,
						'color'=>$color
					);
				$data =	$this->adminModel->addAssociation($data);
				$assignData=array('pageName'=>'association','data'=>$data);
				$this->load->view('admin/header',$assignData);
				$this->load->view('admin/association',$assignData);
				$this->load->view('admin/footer');
				redirect(base_url().'admin/association/');
		}else{
			$assignData=array('pageName'=>'association');
			$this->load->view('admin/header',$assignData);
			$this->load->view('admin/addassociation',$assignData);
			$this->load->view('admin/footer');
	 	}
	}	
	
	public function edit(){
			$page=$this->input->get('page');
			$page=($page==false) ? 1 : $page; 
			$offSet=($page>1) ? ($page-1)*$limit : 0;
			$limit='10';
			$id=$this->input->get_post('id');
			$data=$this->adminModel->getAssociationById($id);
			$assignData=array('pageName'=>'association','data'=>$data);
			$this->load->view('admin/header',$assignData);
			$this->load->view('admin/editassociation',$assignData);
			$this->load->view('admin/footer');
	}
		
	public function update(){
			$association_id=$this->input->get_post('association_id');
			$association_name=$this->input->get_post('name');
			$color = $this->input->get_post('colorpickerField1');
	         $data = array(
				  "association_id"=>$association_id,
                  "color" =>$color,
				  "association_name"=>$association_name
                 );
			$data = $this->adminModel->updateAssociation($data,$association_id);
			/*$assignData=array('pageName'=>'association','data'=>$data);
			$this->load->view('admin/header',$assignData);
			$this->load->view('admin/association',$assignData);
			$this->load->view('admin/footer');*/
			redirect(base_url().'admin/association/');

    } 
	
	public function delete(){	
		$id=$this->input->get_post('id');
		if($id > 0){
			  $this->adminModel->deleteImage($id);
		}
			redirect(base_url().'admin/association/');
	}

	public function checkColor($color){
		$checkUserColor = $this->adminModel->checkColor($color);
		echo $checkUserColor;
	}

	public function checkColorUpdate($color,$id){
		//echo $color;echo $id;
		$checkUserColor = $this->adminModel->checkColorUpdate($color,$id);
		echo $checkUserColor;
	}
	
	
	
}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */