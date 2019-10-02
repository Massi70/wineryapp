<?php
	class WebservicesModel extends CI_Model
	{
		private $table;
		public function __construct(){
		parent :: __construct();
	}

	function getAllUsers(){
		$query = $this->db->get('users');
		return $query->result_array();
	}
	
	function getUserDetails($data){
		$sql="select user_id,user_name,user_email,password,user_status from users where user_id='".$data['user_id']."'  and user_email='".$data['user_email']."'";
		$query=$this->db->query($sql);
		$data=$query->row_array();    // fetches record from the user tables
	  	return 	$data;
   }
   
   	function addUser($data){	
		$this->db->insert('user', $data);	// insert data into `books` table
		return $this->db->insert_id();	
	}
	
	function checkUserName($user_name){
		 $sql = $this->db->get_where("user",array("user_name"=>$user_name));
		 $res = $sql->num_rows();
		 return $res;
    }
	
	function checkUserEmail($user_email){
		 $sql = $this->db->get_where("user",array("user_email"=>$user_email));
		 $res = $sql->num_rows();
		 return $res;
    }

   function checklogin($user_email,$password){
		$sql = $this->db->get_where("user",array("user_email"=>$user_email,"password"=>$password));
		$res = $sql->num_rows();
		return $res;
   }
   
   function login($user_email,$password){
		$sql = $this->db->query('select * from user where user_email="'.$user_email.'"  and password ="'.$password.'"');
		$res = $sql->row_array();
		return $res;
   } 
   
   function fbLogin($fb_id){
		$sql = $this->db->query('select * from user where fb_id="'.$fb_id.'"');
		$res = $sql->row_array();
		return $res;
   } 
   
   function twitterLogin($twitter_id){
		$sql = $this->db->query('select * from user where twitter_id="'.$twitter_id.'"');
		$res = $sql->row_array();
		return $res;
   } 
   
   function addAssociation($data){	
		$result = $this->db->insert('associations', $data);	// insert data into `users` table	
		return $result;
	} 
	
	function getAllAssociation(){
		$sql="select association_id, association_name, image from associations";
		$query=$this->db->query($sql);
		$data=$query->result_array();    // fetches record from the user tables
	  	return 	$data;
	}

	function getWineList(){
		$sql="select wine_name from winery";
		$query=$this->db->query($sql);
		$data=$query->result_array();    // fetches record from the user tables
	  	return 	$data;
	}
	
	function getWineLatLong(){
		$sql="select wine_name,latitude,longitude from winery";
		$query=$this->db->query($sql);
		$data=$query->result_array();    // fetches record from the user tables
	  	return 	$data;
	}

	function getWineryDetails($winery_id){
		$sql="SELECT 
			winery_id,
			association_id,
			wine_name,
			image,
			country,
			province,
			address,
			contact,
			link,
			description,
			notes,
			longitude,
			latitude
			from winery where winery_id = '".$winery_id."'
			";
		$query=$this->db->query($sql);
		$data=$query->row_array();    // fetches record from the user tables
	  	
		$sql="SELECT image from event_images where winery_id = '".$winery_id."'";
		$query=$this->db->query($sql);
		$data2=$query->result_array();    // fetches record from the user tables
		$data['images'] = $data2;
		return 	$data;
	}
	
	function getWineryDetailsByAssociation($association_id){
		$sql="SELECT 
			winery_id,
			association_id,
			wine_name,
			image,
			country,
			province,
			address,
			contact,
			link,
			description,
			notes,
			longitude,
			latitude
			from winery where association_id = '".$association_id."'
			";
		$query=$this->db->query($sql);
		$data=$query->result_array();    // fetches record from the user tables
		$i= 0;
	  	foreach($data as $d):
		//echo $d['winery_id']."</br>";
		$sql="SELECT image from event_images where winery_id = '".$d['winery_id']."'";
		$query=$this->db->query($sql);
		$data2=$query->result_array();    // fetches record from the user tables
		$data[$i]['images'] = $data2;
		$i++;
		endforeach;
		return 	$data;
	}
	
	function getEvents($user_id){
		$sql = "SELECT * from events order by timedate desc";
		$query = $this->db->query($sql);
		$data = $query->result_array();
                $i=0;
                $is_going = 0;
                $is_not_going = 0;
                $flag = 2;
                
		foreach($data as $d):
		$sql2 = "SELECT user_id,is_going from event_going where event_id = '".$d['event_id']."' ";
		$query2 = $this->db->query($sql2);
                $count = $query2->result_array();
                
              
                foreach ($count as $c):
                 if($c['is_going']==1){
                    $is_going++;
                }
                else{
                    $is_not_going ++;
                }
                if($user_id==$c['user_id']){
                     $flag = $c['is_going'];
                }
                
                
                endforeach;
                
                $data[$i]['going_count'] = $is_going;
                $data[$i]['not_going_count'] = $is_not_going;
                $data[$i]['is_going'] = $flag;
                $i++;
                
                $is_going = 0;
                $is_not_going = 0;
                $flag = 2;
		endforeach;
		return $data;	
	}
	
	function getEventsX($user_id){
		$sql = "select * from events,event_going where events.event_id = event_going.event_id
and event_going.user_id = '".$user_id."' and event_going.is_going = '1'";
		$query = $this->db->query($sql);
		$data = $query->result_array();
		return $data;	
	}
	
	function getEventById($eventId){
		$sql = "SELECT * from events where event_id= '".$eventId."'";
		$query = $this->db->query($sql);
		$data = $query->result_array();
		return $data;	
	}
	
	function getEventByWineryId($wineryId,$user_id){
            
            $sql = "SELECT * from events where winery_id ='".$wineryId."' order by timedate desc";
		$query = $this->db->query($sql);
		$data = $query->result_array();
                $i=0;
                $is_going = 0;
                $is_not_going = 0;
                $flag = 2;
                
		foreach($data as $d):
		$sql2 = "SELECT user_id,is_going from event_going where event_id = '".$d['event_id']."' ";
		$query2 = $this->db->query($sql2);
                $count = $query2->result_array();
                
              
                foreach ($count as $c):
                 if($c['is_going']==1){
                    $is_going++;
                }
                else{
                    $is_not_going ++;
                }
                if($user_id==$c['user_id']){
                     $flag = $c['is_going'];
                }
                else{
                    $flag=2;
                }
                
                
                endforeach;
                
                $data[$i]['going_count'] = $is_going;
                $data[$i]['not_going_count'] = $is_not_going;
                $data[$i]['is_going'] = $flag;
                $i++;
                
                $is_going = 0;
                $is_not_going = 0;
                $flag = 2;
		endforeach;
		return $data;	
          
	}
        
	
	function addEventGoingOrNot($data){
		
                $sql = "SELECT count(id) as id from event_going where user_id = '{$data['user_id']}' AND event_id = '{$data['event_id']}'";
                $query = $this->db->query($sql);
                $query_data = $query->result_array();
               
                if($query_data[0]['id']>0){
                    $this->db->update('event_going', $data);
                   
                }
                else{
                  
                    $this->db->insert('event_going', $data);
                }
                
                
                
                
	}
	
	function checkUserGoingOrNotGoing($user_id,$eventId){
		$sql = "SELECT count(id) from event_going where user_id = '".$user_id."' AND event_id= '".$eventId."'";
		$query = $this->db->query($sql);
		$data = $query->num_rows();
		return $data;	
	}
	
	function updateUserGoingOrNotGoing($user_id,$event_id,$is_going,$id){
		$sql="update event_going set user_id='".$user_id."',
								event_id='".$event_id."',
								is_going='".$is_going."'
											where
											id='".$id."'
											";
		$query=$this->db->query($sql);
		if($this->db->affected_rows())
		{
			return true;
		}else{
			return false;
		}
	}


	function countTotalGoingOrNotGoing(){
		$sql = "SELECT count(*) as total from event_going where is_going = '1'";
		$query = $this->db->query($sql);
		$data = $query->result_array();
		return $data;	
	}
	
	function createTour($data){
		$this->db->insert('tour', $data);
		return $this->db->insert_id();
	}
	
	function createTourLocation($data1){
		$this->db->insert('tour_location', $data1);
		//return $this->db->insert_id();
	}

	function createCeller($data){
		$this->db->insert('celler', $data);
	}

	function updateCeller($id,$data){
            
            $this->db->where('id', $id);
            $this->db->update('celler', $data); 
            $res = $this->db->affected_rows();
            if($res>0){
                return $res;
            }
            else{
                return $res;
            }
            
	}
	
	function getCellerById($id){
		$sql = "SELECT * from celler where id='".$id."'";
		$query = $this->db->query($sql);
		$data = $query->row_array();
		return $data;	
	}
	
	function getActiveTour($user_id){
		$sql = "SELECT * from tour where is_active = '1' AND user_id = '{$user_id}'";
		$query = $this->db->query($sql);
		$data = $query->result_array();
		return $data;	
	}
    function getCellarByTourId($id){
		$sql = "SELECT * from celler where tour_id = '{$id}'";
		$query = $this->db->query($sql);
		$data = $query->result_array();
		return $data;	
	}
        
	
	function getInActiveTour($user_id){
		$sql = "SELECT * from tour where is_active = '0' AND user_id = '{$user_id}'";
		$query = $this->db->query($sql);
		$data = $query->result_array();
		return $data;	
	}
	
	function selectOperators(){
		$sql="SELECT image,country,province,address,contact,link from operators";
		$query=$this->db->query($sql);
		$data=$query->result_array();    // fetches record from the user tables
	  	return 	$data;
	}
	
}

?>