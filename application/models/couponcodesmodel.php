<?php
class couponCodesModel extends CI_Model {
	private $table;
    public function __construct(){
        // Call the Model constructor
        parent::__construct();
		$this->load->library('memcached_library');
    }

	public function getContent(){
		$sql="SELECT * from food_type ";	
		$query=$this->db->query($sql);
		$data=$query->result_array();
		
		return $data;
	}
	
	public function getCoupons(){
		$sql="SELECT cc.*,u.user_name FROM coupon_codes cc
			LEFT JOIN user u
			ON cc.user_id=u.id ";	
		$query=$this->db->query($sql);
		$data=$query->result_array();
		return $data;
	}
	
	public function getCouponCodeDetails($Id,$refresh=0){	
		$key=APP_NAME.'content-detatils-'.$Id;
		$data = $this->memcached_library->get($key);
		$data=false;
		if($refresh==1){
			$data =false;
		}
		if($data==false){	
			$sql="SELECT id,CODE,discount_ratio,STATUS FROM coupon_codes WHERE id=$Id";
			$query=$this->db->query($sql);
			$data=$query->row_array();
			$this->memcached_library->set($key,$data);
			return $data;
		}else{
			return $data;	
		}
	}
	
	public function getContentDetailsByKey($type,$refresh=0){	
		$key=APP_NAME.'content-detatils-'.$type;
		$data = $this->memcached_library->get($key);
		$data=false;
		if($refresh==1){
			$data =false;
		}
		if($data==false){	
			$sql="SELECT * FROM contents where content_type='".$type."'";
			$query=$this->db->query($sql);
			$data=$query->row_array();
			$this->memcached_library->set($key,$data);
			return $data;
		}else{
			return $data;	
		}
	}
	
	public function addCouponCode($data){
		 if($this->db->insert('coupon_codes', $data)){
			 $contentsId=$this->db->insert_id();
			 
		 	 return  $contentsId;
		}else{
			return false;
		}
	}
	
/*	public function updateCouponCode($data,$conditions){
		
		 if($this->db->update('coupon_codes', $data,$conditions)){
			
			// $this->getFoodTypeDetails($data['food_type_id'],1);
		 	 return  true;
		}else{
			return false;
		}
	}*/
	
	public function updateCouponCode($data){
		$sql = "update coupon_codes set discount_ratio = '".$data['discount_ratio']."', `status` = '".$data['status']."' where id = '".$data['id']."'";	
		$this->db->query($sql);
	}
	
	public function deleteCouponCode($conditions){
		 
		 if($this->db->delete('coupon_codes',$conditions)){
		  	 return  true;
		}else{
			return false;
		}
	}
	
	public function getCouponCodes(){
		$sql='
		SELECT
		  cc.*,
		  ro.restaurant_name,
		  IF(cc.is_charge = 1, CONCAT( DATEDIFF( DATE_ADD( cc.activation_date, INTERVAL cc.expiration_days DAY), NOW())," Days Remainig"),"not charge") AS "expire_days"
		FROM coupon_codes cc
		  LEFT JOIN restaurant_owner ro
			ON cc.restaurant_id = ro.restaurant_id
		 WHERE DATE_ADD( cc.activation_date, INTERVAL cc.expiration_days DAY) > NOW()
		 OR cc.is_charge=0   ';	
		$query=$this->db->query($sql);
		$data=$query->result_array();
		
		return $data;
	}

	public function getAllRestaurants(){
		$sql='SELECT restaurant_id,restaurant_email,restaurant_name FROM restaurant_owner   ';	
					$query=$this->db->query($sql);
					$data=$query->result_array();
					
					return $data;
	}

}
?>