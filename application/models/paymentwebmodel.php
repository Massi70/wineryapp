<?php
class PaymentWebModel extends CI_Model {
	private $table;
    public function __construct(){
        // Call the Model constructor
        parent::__construct();
		$this->load->library('memcached_library');
    }
	
 	 public function loginWeb($userName='admin',$password='admin'){
	 		$sql="select *
						 from user   
						 where user_email='".$userName."'
						 		and password='".base64_encode($password)."'
								 
						 ";
			$query=$this->db->query($sql);
		 
			$data=$query->row_array();
			 
			
			return $data;
		
	}
	 
	 
	 

	public function savePayment($data){
		 if($this->db->insert('payment', $data)){
			 $contentsId=$this->db->insert_id();
			  
		 	 return  $contentsId;
		}else{
			return false;
		}
	}
	public function getCouponCodes($coupon_code){
		 	 
			$sql="SELECT * FROM coupon_codes WHERE CODE=".$coupon_code;
			$query=$this->db->query($sql);
		 
			$data=$query->row_array();
			 
			
			return $data;
		
	}

	public function activateCouponCode($id){
		 
			 
			$sql="UPDATE coupon_codes
					SET is_charge = 1,
					  restaurant_id = ".$this->session->userdata("restaurant_id").",
					  activation_date = NOW()
					WHERE is_charge = 0
						AND id = ".$id;
			$query=$this->db->query($sql);
			return $this->db->affected_rows();
		 
		
	}
	public function updatePaidStatus($id){
		  
		  $sql="UPDATE restaurant_owner
					SET restaurant_is_paid = 1
					WHERE  restaurant_id=".$id;
			$query=$this->db->query($sql);
			return $this->db->affected_rows();
		 
		
	}
	public function changePaidStatus($id,$status){
		  
		  $sql="UPDATE restaurant_owner
					SET restaurant_is_paid = ".$status."
					WHERE  restaurant_id=".$id;
			$query=$this->db->query($sql);
			return $this->db->affected_rows();
		 
		
	}
	
	
	public function changePaidStatusAndExtendExpiretionPeriod($id,$pekage){
		
			$sql="UPDATE `user` u
					SET  
					  u.expire_date = IFNULL(u.expire_date, NOW() )
					WHERE u.id = ".$id;
			//$query=$this->db->query($sql);
			if($pekage==1)
				$interval =3;
			else if($pekage==2)
				$interval=6;
			else if($pekage==3)
				$interval=12;
					
		  
		  $sql="UPDATE `user` u
					SET u.is_paid = 1,
					  u.expire_date = IF(NOW() >= u.expire_date,DATE_ADD(NOW(), INTERVAL ".$interval." MONTH),DATE_ADD(u.expire_date, INTERVAL ".$interval." MONTH))
					WHERE u.id =".$id;
			$query=$this->db->query($sql);
			return $this->db->affected_rows();
		 
		
	}
	
	
	public function changePaidStatusAndExtendExpiretionDays($id,$days){
		  
		  $sql="UPDATE restaurant_owner ro
 
				SET 
				restaurant_is_paid = 1,
				ro.restaurant_expire_date = IF(NOW() >= ro.restaurant_expire_date,DATE_ADD(NOW(), INTERVAL $days DAY),DATE_ADD(ro.restaurant_expire_date, INTERVAL $days DAY))
				WHERE ro.restaurant_id =".$id;
			$query=$this->db->query($sql);
			return $this->db->affected_rows();
		 
		
	}
	
	public function getUserDetail($id){
		 
			 
			$sql="SELECT * FROM `user` WHERE id=".$id;
			$query=$this->db->query($sql);
		  	$data=$query->row_array();
			return $data;
		
	}
	
	public function changeCouponStautusCharged($data,$id){
		 
			 
			$this->db->update('coupon_codes', $data, array('id' => $id));
			
		  return $this->db->affected_rows();
		 
		
	}
	
	public function getEventDetails($id){
		$sql = "SELECT event_id,winery_id,event_name,status,
		CONCAT('".base_url()."uploads/',image) as image,description,venue,
		timedate,flavour,entry_fee,contact,link,email,phone,latitude,longitude 
		from events where event_id = '".$id."' and status = '1' order by timedate desc";
		$query = $this->db->query($sql);
		$data = $query->row_array();
		return $data;	
	}
	public function getEventGoingTotal($id){
		$sql = "SELECT
					  COUNT(eg.id) AS total
					FROM event_going eg
					WHERE eg.event_id = $id
						AND eg.is_going = '1'";
		$query = $this->db->query($sql);
		$data = $query->row_array();
		return $data;	
	}
	public function getEventNotGoingTotal($id){
		$sql = "SELECT
					  COUNT(eg.id) AS total
					FROM event_going eg
					WHERE eg.event_id = $id
						AND eg.is_going = '0'";
		$query = $this->db->query($sql);
		$data = $query->row_array();
		return $data;	
	}
	
	public function userIsExist($email){
		  
		 	 $sql="SELECT * FROM user WHERE user_email='".$email."'";
 				//restaurant_email='".$userName."' and restaurant_password='".base64_encode( $password )."'";
			$query=$this->db->query($sql);
			
			if($query->num_rows() >0 )
				return $query->row_array();
			 else
				return FALSE;
  			
	}

	public function packagePayment(){
		 	 $sql="SELECT * FROM package_payment";
 				//restaurant_email='".$userName."' and restaurant_password='".base64_encode( $password )."'";
			$query=$this->db->query($sql);
			if($query->num_rows() >0 )
				return $query->result_array();
			 else
				return FALSE;
	}
	
	function getPackagePayment($id){
		$sql = "SELECT id, payment_total from package_payment where id = '".$id."'";
		$query = $this->db->query($sql);
		$data = $query->result_array();
		return $data;	
	}
	
	function updatePackagePayment($data,$id){
		$this->db->where('id',$id);	
		$this->db->update('package_payment',$data);	// update data into `package_payment` table
	}
	
	
	
}
?>