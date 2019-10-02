<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Index extends CI_Controller {
	public function __construct()
	{
        parent::__construct();
		
	}
	
	public function index()
	{
		$userAdmin=$this->session->userdata(APP_NAME.'_admin');
		if($userAdmin==false){
			redirect(base_url()."admin/index/login");
			exit();
		}
		
		$this->load->model('adminModel');
		$totalAppUsers=$this->adminModel->countAllUsers();
		
		$assignData=array('pageName'=>'index','totalAppUsers'=>$totalAppUsers);
		
		$this->load->view('admin/header',$assignData);
		$this->load->view('admin/index');
		$this->load->view('admin/footer');
	}
	
	public function login()
	{
		
		$userAdmin=$this->session->userdata(APP_NAME.'_admin');
		if($userAdmin!=false){
			redirect(base_url()."admin/");
			exit();
		}
		$this->load->model('adminModel');
		
		$loginDo=$this->input->post('loginDo');
		$userName=$this->input->post('user_name');
		$password=$this->input->post('password');
		$msg='';
		
		if($userName==false ||  $password==false){
			
		}else{
			$login=$this->adminModel->loginAdmin($userName,$password);
			
			if($login==false){
				$msg='Invalid user name or password';
			}else{
				$this->session->set_userdata(APP_NAME.'_admin',1);
				redirect(base_url().'admin/');
				exit();
			}
		}
		
		
		$assignData=array('pageName'=>'index','msg'=>$msg);
		$this->load->view('admin/header',$assignData);
		$this->load->view('admin/login');
		$this->load->view('admin/footer');
	}
	
	public function logout(){
		$this->session->sess_destroy();
		redirect(base_url().'admin/index/');
		exit();	
			
	}
}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */