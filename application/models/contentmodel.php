<?php
class ContentModel extends CI_Model {
	private $table;
    public function __construct(){
        // Call the Model constructor
        parent::__construct();
		$this->load->library('memcached_library');
    }

	public function getContent(){
		  $sql="SELECT * from contents where status=1";	
		$query=$this->db->query($sql);
		$data=$query->result_array();
		
		return $data;
	}
	
	public function getContentDetails($Id,$refresh=0){	
		$key=APP_NAME.'content-detatils-'.$Id;
		$data = $this->memcached_library->get($key);
		$data=false;
		if($refresh==1){
			$data =false;
		}
		if($data==false){	
			 $sql="SELECT * FROM contents where id=$Id";
			$query=$this->db->query($sql);
			$data=$query->row_array();
			$this->memcached_library->set($key,$data);
			return $data;
		}else{
			return $data;	
		}
	}
	public function addContent($data){
		 if($this->db->insert('contents', $data)){
			 $contentsId=$this->db->insert_id();
			 $this->getContentDetails($contentsId,1);
		 	 return  $videoId;
		}else{
			return false;
		}
	}
	public function updateContent($data){
		$conditions=array('id'=>$data['id']);
		 if($this->db->update('contents', $data,$conditions)){
			
			 $this->getContentDetails($data['id'],1);
		 	 return  true;
		}else{
			return false;
		}
	}
	


}
?>