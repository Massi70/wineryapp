<?php
class AddModel extends CI_Model {
	private $table;
    public function __construct(){
        // Call the Model constructor
        parent::__construct();
		$this->load->library('memcached_library');
    }

	public function getAdd($offSet=0,$limit=18,$userId=0,$order='id'){
		  $sql="SELECT * from adds where status=0 order by $order DESC LIMIT $offSet,$limit";	
		$query=$this->db->query($sql);
		$data=$query->result_array();
		
		return $data;
	}
	public function countRecentAdd($id=0){	
		$sql="SELECT * FROM adds where id=$id and status=0";

		$query=$this->db->query($sql);
		$data=$query->row_array();
		return $data;
	}
	
	public function getAddByPosition($position){
		$sql="SELECT * FROM adds where position='$position' and status=0";		
		$query=$this->db->query($sql);
		$data=$query->result_array();
		return $data;
	}
	
	public function getAddDetails($Id,$refresh=0){	
		$key=APP_NAME.'adds-detatils-'.$Id;
		$data = $this->memcached_library->get($key);
		$data=false;
		if($refresh==1){
			$data =false;
		}
		if($data==false){	
			 $sql="SELECT * FROM adds where status=0 and id=$Id";
			$query=$this->db->query($sql);
			$data=$query->row_array();
			$this->memcached_library->set($key,$data);
			return $data;
		}else{
			return $data;	
		}
	}
	public function addAdd($data){
		 if($this->db->insert('adds', $data)){
			 $AddsId=$this->db->insert_id();
			 $this->getAddDetails($AddsId,1);
		 	 return  $AddId;
		}else{
			return false;
		}
	}
	public function updateAdd($data){
		$conditions=array('id'=>$data['id']);
		 if($this->db->update('adds', $data,$conditions)){
			
			 $this->getAddDetails($data['id'],1);
		 	 return  true;
		}else{
			return false;
		}
	}
	
	/******************************************
		Add function for Admin panel
	*********************************************/
	public function getRecentAddSearch($offSet=0,$limit=18,$search='',$order='id'){
		  if($search==''){
		  $sql="SELECT * FROM adds where status=0 ORDER BY $order DESC LIMIT $offSet,$limit";
		  }else{
		  	$sql="SELECT * FROM adds where status=0 and title like '%".$search."%' ORDER BY $order DESC LIMIT $offSet,$limit";
		  }
		$query=$this->db->query($sql);
		$data=$query->result_array();
		
		return $data;
	}
	public function countRecentAddSearch($search=''){	
		
		if($search==''){
			 $sql="SELECT count(id) as total FROM adds where status=0";
		}else{
			$sql="SELECT count(id) as total FROM adds where status=0 and (title like '%".$search."%')";
		}
		$query=$this->db->query($sql);
		$data=$query->row_array();
		return $data['total'];
	}
	
	public function countAdd($type=''){	
		
		if($type==''){
			 $sql="SELECT count(*) as total FROM adds where status=0";
		}else{
			$sql="SELECT count(*) as total FROM adds where status=0 and type = '".$type."'";
		}
		$query=$this->db->query($sql);
		$data=$query->row_array();
		return $data['total'];
	}

}
?>