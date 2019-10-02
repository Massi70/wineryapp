<?php

class UserModel extends CI_Model {

	private $table;

    public function __construct(){

        // Call the Model constructor
        parent::__construct();
		$this->load->library('memcached_library');
    }


    public function getUserData($uId,$refresh=0){

		$key=APP_NAME.'user-'.$uId;

		$data = $this->memcached_library->get($key);

		if($refresh==1){
			$data =false;
		}
		if($data==false){
			$this->db->select('user_id,user_name,user_email,user_status')->from('user')->where('user_id',$uId);
			$query= $this->db->get();
			$data=$query->row_array();
			$this->memcached_library->set($key,$data);
		}
		return $data;
	}

	public function createUser($data){
		if($this->db->insert('user', $data)){
			 $userId=$this->db->insert_id() ;
			 $this->getUserData($userId,1);
		 	 return  $userId;
		}else{
			return false;
		}
    }
	
	function addUser($data){	
		$this->db->insert('user', $data);	// insert data into `books` table	
	}
	
	function checkUser($user_name)
	{
		 $sql = $this->db->get_where("user",array("user_name"=>$user_name));
		 $res = $sql->num_rows();
		 return $res;
    }
	
	function checkUserEmail($user_email)
	{
		 $sql = $this->db->get_where("user",array("user_email"=>$user_email));
		 $res = $sql->num_rows();
		 return $res;
    }

   function checklogin($user_name,$password)
	{
		$sql = $this->db->get_where("user",array("user_name"=>$user_name,"password"=>$password));
		$res = $sql->num_rows();
		return $res;
   }
   
   function login($user_name,$password)
	{
		$sql = $this->db->query('select * from user where user_name="'.$user_name.'"  and password ="'.$password.'"');
		$res = $sql->row_array();
		return $res;
   }   
   
}

?>