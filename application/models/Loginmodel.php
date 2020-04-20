<?php
Class Loginmodel extends CI_Model
{
	public function __construct()
	{
	  parent::__construct();
		//$this->load->model('mailmodel');
		//$this->load->model('smsmodel');
	}

	function login($username,$password)
	{
		$chkUser = "SELECT * FROM user_master WHERE email_id ='$username' AND password='$password'";
		$res=$this->db->query($chkUser);
		if($res->num_rows()>0){
		   foreach($res->result() as $rows)
		   {
			   $status = $rows->status;
		   }
			if ($status = 'Active'){
				  $data = array("status"=>$rows->status,"email_id"=>$rows->email_id,"name"=>$rows->full_name,"user_type"=>$rows->role_id,"user_id"=>$rows->id,"user_pic"=>$rows->profile_pic);
				 return $data;
			 } else {
				  $data= array("status" => "Inactive");
				  return $data;
			 }
		} else{
				  $data= array("status" => "Error");
				  return $data;
		} 
	}

	
}
?>
