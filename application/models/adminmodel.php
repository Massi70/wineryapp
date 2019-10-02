<?php
class AdminModel extends CI_Model{
	private $table;
	
    public function __construct(){
        // Call the Model constructor
        parent::__construct();
		$this->load->library('memcached_library');
    }
	
 	 public function loginAdmin($userName='admin',$password='admin'){
			$this->db->select('id,user_name,password')->from('admin')->where('user_name',$userName,'password',$password);
			$query= $this->db->get();
			$data=$query->row_array();
			return $data;
	}
	
	public function countAllUsers($search=''){
		if($search==''){
			$this->db->select('count(id) as total')->from('user');
		}else{
			$this->db->select('count(id) as total')->from('user')->like('user_name',trim($search),'user_email',trim($search));
		}
		$query= $this->db->get();
		$data=$query->row_array();
		return $data['total'];
	}
	
	function addUser($data){	
		$result = $this->db->insert('user', $data);	// insert data into `users` table	
		//return $this->db->insert_id();
	}
	
	function getUser($id){
		$sql = "SELECT id,user_email,password,user_name,CONCAT('".base_url()."uploads/',image) as image,country,province,address,
				contact,link,description,notes,longitude,latitude 
				from `user` where id='".$id."' and user_status = '1'";
		$query=$this->db->query($sql);
		$data=$query->result_array();
	  	return 	$data;
	}

	function updateUser($data,$id){
		$this->db->where('id',$id);	
		$this->db->update('user',$data);	// update data into `books` table
	}
	
	function deleteUser($id){
		$sql = "update user set user_status = '0' where id = '".$id."'";
		$this->db->query($sql);
	}
	
	public function checkUserEmail($user_email){
		 $sql = $this->db->get_where("user",array("user_email"=>$user_email));
		 $res = $sql->num_rows();
		 if($res>0){
			 return "true";
		 }else{
			 return "false";
		 }
		 //return $res;
    }

	
	public function getAllUsers($search='',$offSet=0,$limit=20){
		 if($search!=''){
			  $sql="select id,fb_id,twitter_id,user_name,user_email,CONCAT('".base_url()."uploads/',user.image) as image,
			  user_status,association_id,contact,country,province,address,link,description
			  from user where `user_name` like '%".trim($search)."%' or `user_email` like '%".trim($search)."%' and user_status = '1' order by `user_name` limit $offSet, $limit";
			$query=$this->db->query($sql);
			 $data=$query->result_array();
		 }else{
			$sql="select id,fb_id,twitter_id,user_name,user_email,CONCAT('".base_url()."uploads/',user.image) as image,
			  user_status,association_id,contact,country,province,address,link,description from user where user_status = '1' order by `id` desc limit $offSet, $limit";
			$query=$this->db->query($sql);
			 $data=$query->result_array();
		}
		
		return $data;
	}
	
	function getWineNew(){
		$sql = "SELECT user.id,user.user_name,CONCAT('".base_url()."uploads/',user.image) as image,user.country,user.province,user.address,
				user.contact,user.link,user.description,user.notes,user.longitude,user.latitude 
				from `user` where user_type_id = '2' and user_status = '1' order by id desc";
		$query=$this->db->query($sql);
		$data=$query->result_array();
	  	return 	$data;
	}
	
	function getWine($id,$offSet,$limit){
		//$sql = "SELECT * from events where winery_id = '".$id."' limit $offSet,$limit";
		$sql = "SELECT user.user_name,events.event_id,events.winery_id,events.event_name,events.status,
		CONCAT('".base_url()."uploads/',events.image) as image,events.description
		,events.venue,events.timedate,events.flavour,events.entry_fee,events.contact,events.link,
		events.email,events.phone,events.latitude,events.longitude from events,user
		where events.winery_id = user.id and events.status = '1' and events.winery_id = '".$id."' limit $offSet,$limit";
		$query=$this->db->query($sql);
		$data=$query->result_array();
	  	return 	$data;
	}
	
	function getWineDetails($id){
		/*$sql = "select user.id,CONCAT('".base_url()."uploads/',user.image) as image,user.user_name,user.password,user.association_id,user.country,user.province,user.address,
			user.contact,user.link,user.description,user.notes,user.longitude,user.latitude
			from user where user.id = '".$id."' and user.user_status = '1'";*/
			
		$sql = "select user.id,user.image,user.user_name,user.password,user.association_id,
				associations.association_name, user.country,user.province,user.address,
				user.contact,user.link,user.description,user.notes,user.longitude,user.latitude
				from `user`,associations where user.association_id = associations.association_id 
				and user.id = '".$id."' and user.user_status = '1' ";	
		$query = $this->db->query($sql);
		$data = $query->result_array();
		return $data;	
	}
	
	function wineList($appType,$offSet,$limit){
		if($appType == 'all'){
			$sql ="SELECT id,app_type_id,user_name,user_status,association_id,country,
			CONCAT('".base_url()."uploads/',image) as image,
					province,address,contact,link,description from user where 
					user_type_id = '2' and user_status ='1' order by id desc limit $offSet,$limit ";
			$query = $this->db->query($sql);
			$data = $query->result_array();
			return $data;
		}else{
			$sql ="SELECT id,app_type_id,user_name,user_status,association_id,country,CONCAT('".base_url()."uploads/',image) as image,
					province,address,contact,link,description from user where 
					user_type_id = '2' and user_status ='1' and app_type_id = '".$appType."' order by id desc limit $offSet,$limit ";
			$query = $this->db->query($sql);
			$data = $query->result_array();
			return $data;
		}
	}
	
	public function countAllWineries($search=''){
		if($search==''){
			//$this->db->select('count(id) as total')->from('associations');
			$sql = "select count(id) as total from user where user_type_id='2' and user_status='1'";
			$query = $this->db->query($sql);
			$data = $query->row_array();
			return $data['total'];
		}else{
			//$this->db->select('count(association_id) as total')->from('associations')->like('association_name',trim($search));
			$sql = "select count(id) as total from user where app_type_id LIKE %'".trim($search)."'% and user_type_id='2' and user_status='1' ";
			$query = $this->db->query($sql);
			$data = $query->row_array();
			return $data['total'];
		}
	} 
	
	
	function getWineEventImages($id){
		$sql = "SELECT winery_image_id,winery_id,CONCAT('".base_url()."uploads/events/',image) as image from event_images where winery_id = '".$id."' order by winery_id desc";
		$query = $this->db->query($sql);
		$data = $query->result_array();
		return $data;	
	}
	
	function addWine($data){	
		$result = $this->db->insert('user', $data);	// insert data into `users` table	
		return $this->db->insert_id();
	}
	
	function addWineryImages($data1){	
		$result = $this->db->insert('event_images', $data1);	// insert data into `users` table	
	} 
	
	function updateWine($data,$winery_id){
		$this->db->where('id',$winery_id);	
		$this->db->update('user',$data);	// update data into `books` table
	}
	
	function updateWineriesImage($view,$id){
		$sql = "update user set image = '".$view."' where id = '".$id."'";
		$this->db->query($sql);
	}
	
	function deleteWine($id){
		$sql = "update user set user_status = '0' where id = '".$id."'";
		$this->db->query($sql);

	}

	function getAssociation($offSet,$limit){	
		$sql = "SELECT association_id,color,CONCAT('".base_url()."uploads/associations/',image) as image ,association_name from associations where status = '1' order by association_id desc limit $offSet,$limit";
		$query=$this->db->query($sql);
		$data=$query->result_array();
	  	return 	$data;
	}
	
	public function countAllAssociations($search=''){
		if($search==''){
			$this->db->select('count(association_id) as total')->from('associations');
		}else{
			$this->db->select('count(association_id) as total')->from('associations')->like('association_name',trim($search));
		}
		$query= $this->db->get();
		$data=$query->row_array();
		return $data['total'];
	}
	
	function addAssociation($data){	
		$result = $this->db->insert('associations', $data);	// insert data into `users` table	
		return $result;
	}
	
	function getAssociationById($id){
		$sql = "SELECT * from associations where association_id = '".$id."' and status = '1'";
		$query = $this->db->query($sql);
		$data = $query->result_array();
		return $data;	
	}
	
	function updateAssociation($data,$association_id){
		$this->db->where('association_id',$association_id);	
		$this->db->update('associations',$data);	// update data into `associations` table
	}
	
	function deleteImage($id){
		//$this->db->where('association_id',$id);
		//$result = $this->db->delete('associations');
		//return $result;
		$sql = "update associations set status = '0' where association_id = '".$id."'";
		$this->db->query($sql);
	}
	
	function checkColor($color){
		$sql = $this->db->get_where("associations",array("color"=>$color));
		 $res = $sql->num_rows();
		 if($res>0){
			 return "true";
		 }else{
			 return "false";
		 }
	}  
	
	public function checkColorUpdate($color,$id){
		$sql = "SELECT * from associations where color = '".$color."' and association_id = '".$id."'";
		$res = $this->db->query($sql);
		
		if($res->num_rows()>0){
			 return "false";
		 }else{
			 return "true";
		 }
		 //return $res;
    }
	
	function getEvents(){
		$sql = "SELECT * from events order by event_id desc";
		$query = $this->db->query($sql);
		$data = $query->result_array();
		return $data;	
	}
	
	public function getAllEvents($search='',$offSet=0,$limit=20){
		 if($search!=''){
			  $sql="select * from events order by event_id limit $offSet, $limit";
			$query=$this->db->query($sql);
			 $data=$query->result_array();
		 }else{
			$sql="select * from events order by `event_id` limit $offSet, $limit";
			$query=$this->db->query($sql);
			 $data=$query->result_array();
		}
		
		return $data;
	}
	
	public function countAllEvents($search=''){
		if($search==''){
			$this->db->select('count(event_id) as total')->from('events');
		}else{
			$this->db->select('count(event_id) as total')->from('events')->like('event_name',trim($search),'email',trim($search));
		}
		$query= $this->db->get();
		$data=$query->row_array();
		return $data['total'];
	}
	
	function getEventDetails($id){
		$sql = "SELECT event_id,winery_id,event_name,status,
			CONCAT('".base_url()."uploads/',image) as image,description,venue,
			timedate,flavour,entry_fee,contact,link,email,phone,latitude,longitude 
			from events where event_id = '".$id."' and status = '1' order by timedate desc";
		$query = $this->db->query($sql);
		$data = $query->result_array();
		return $data;	
	}
	
	function eventGoing($id){
		$sql = "SELECT count(*) as total from event_going where event_id = '".$id."' and is_going = '1'";
		$query = $this->db->query($sql);
		$data = $query->result_array();
		return $data;
	}
	
	function eventNotGoing($id){
		$sql = "SELECT count(*) as total from event_going where event_id = '".$id."' and is_going = '0'";
		$query = $this->db->query($sql);
		$data = $query->result_array();
		return $data;
	}
	
	function addEvent($data){	
		$result = $this->db->insert('events', $data);	// insert data into `users` table	
		return $result;
	}
	
	function editEvent($id,$data){	
		$this->db->where('event_id',$id);
		$this->db->update('events', $data);	// update data into `books` table	
	}
	
	function updateEvent($data,$event_id){
		$this->db->where('event_id',$event_id);	
		$this->db->update('events',$data);	// update data into `books` table
	}
	
	function updateEventImage($view,$id){
		$sql = "update events set image = '".$view."' where event_id = '".$id."'";
		$this->db->query($sql);
	}

	function deleteEvent($id){
		$sql = "update events set status = '0' where event_id = '".$id."'";
		$this->db->query($sql);
	}
	
	public function countAllOperators($search=''){
		if($search==''){
			//$this->db->select('count(id) as total')->from('associations');
			$sql = "select count(id) as total from user where user_type_id='3' and user_status='1'";
			$query = $this->db->query($sql);
			$data = $query->row_array();
			return $data['total'];
		}else{
			//$this->db->select('count(association_id) as total')->from('associations')->like('association_name',trim($search));
			$sql = "select count(id) as total from user where app_type_id LIKE %'".trim($search)."'% and user_type_id='3' and user_status='1' ";
			$query = $this->db->query($sql);
			$data = $query->row_array();
			return $data['total'];
		}
	} 
	
	
	function getAllTourOperators($appType,$offSet,$limit){
		if($appType == 'all'){
			$sql = "SELECT id,user_name,`password`,user_status,user_email,CONCAT('".base_url()."uploads/',image) as image,country,province,address,contact,link
					from `user` where user_type_id = '3' and user_status = '1' order by id desc limit $offSet, $limit";
			$query = $this->db->query($sql);
			$data = $query->result_array();
			return $data;	
		}else{
			$sql = "SELECT id,user_name,`password`,user_status,user_email,CONCAT('".base_url()."uploads/',image) as image,country,province,address,contact,link
					from `user` where user_type_id = '3' and user_status = '1' and app_type_id = '".$appType."' order by id desc limit $offSet, $limit";
			$query = $this->db->query($sql);
			$data = $query->result_array();
			return $data;	
		}
	}
	
	function getOperatorDetails($id){
		$sql = "SELECT id,user_name,`password`,user_status,user_email,CONCAT('".base_url()."uploads/',image) as image,country,province,address,contact,link
				from `user` where id = '".$id."' and user_type_id = '3' and user_status = '1' ";
		$query = $this->db->query($sql);
		$data = $query->result_array();
		return $data;	
	}

	/*function countAllOperators(){
		$sql = 'select count(*) from operators order by id desc';	
		$query = $this->db->query($sql);
		$data = $query->result_array();
		return $data;	
	}*/
	
	function addOperator($data){	
		$result = $this->db->insert('user', $data);	// insert data into `users` table	
		return $this->db->insert_id();
	}
	
	function updateOperator($data,$id){
		$this->db->where('id',$id);	
		$this->db->update('user',$data);	// update data into `books` table
	}	
	
	function deleteOperator($id){
		$sql = "update user set user_status = '0' where id = '".$id."'";
		$this->db->query($sql);

	}
	
	function updateOperatorImage($view,$id){
		$sql = "update user set image = '".$view."' where id = '".$id."'";
		$this->db->query($sql);
	}
	
}
?>