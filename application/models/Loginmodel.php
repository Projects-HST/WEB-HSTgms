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

	function forgot_password($user_name){
         $query="SELECT * FROM user_master WHERE email_id='$user_name'";
         $result=$this->db->query($query);
         if($result->num_rows()>0){
			 foreach($result->result() as $row){
				 $user_id = $row->id;
				 $name = $row->full_name;
				 $user_type = $row->role_id ;
				}
				
			 $digits = 6;
			 $OTP = str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);
			 $reset_pwd = md5($OTP);
			 
			$reset="UPDATE user_master SET password ='$reset_pwd' WHERE id='$user_id'";
			$result_pwd=$this->db->query($reset);

			 $subject = 'M3 - Password Reset';
             $htmlContent = '<html>
               <head><title></title>
               </head>
               <body>
               <p>Hi  '.$name.'</p>
               <p>Your Account Password is Reset. Please Use Below Password to login</p>
			   <p>Password: '.$OTP.'</p>
			   <p></p>
			   <p><a href="'.base_url() .'">Click here to Login</a></p>
               </body>
               </html>';
			   
			$smsContent = 'Hi  '.$name.' Your Account Password is Reset. Please Use this '.$OTP.' to login';
			
			$this->mailmodel->sendEmail($to_email,$subject,$htmlContent);
			$this->smsmodel->sendSMS($to_phone,$smsContent);
			
			echo "success";
         }else{
			echo "error";
		 }
     }

	function profile($user_id){
		$query="SELECT * FROM `user_master` WHERE id='$user_id'";
		$resultset=$this->db->query($query);
		return $resultset->result();
	}
	
}
?>
