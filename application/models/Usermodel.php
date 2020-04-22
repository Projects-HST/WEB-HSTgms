<?php
Class Usermodel extends CI_Model
{
	public function __construct()
	{
	  parent::__construct();
		//$this->load->model('mailmodel');
		//$this->load->model('smsmodel');
	}

	function list_role()
	{
		$query="SELECT * FROM `role_master` WHERE status='Active'";
		$resultset=$this->db->query($query);
		return $resultset->result();
	}

	function list_paguthi()
	{
		$query="SELECT * FROM `paguthi` WHERE constituency_id='1' AND status='Active'";
		$resultset=$this->db->query($query);
		return $resultset->result();
	}
	
	function checkemail($email){
	$select="SELECT * FROM user_master WHERE email_id='$email'";
	$result=$this->db->query($select);
		if($result->num_rows()>0){
			echo "false";
		}else{
			echo "true";
		}
    }
	
	function add_users($role,$paguthi,$name,$email,$mobile,$address,$gender,$status,$staff_prof_pic,$user_id) {

		$select="SELECT * FROM user_master WHERE email_id='$email' AND pugathi_id = '$paguthi'";
		$result=$this->db->query($select);
		
       if($result->num_rows()>0){
			 $data = array(
				 "status" => "already"
			 );
			return $data;
       }else{
		   
			$digits = 6;
			$OTP = str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);
			$md5pwd=md5($OTP);
			
			$insert="INSERT INTO user_master (constituency_id,pugathi_id,role_id,full_name,phone_number,email_id,password,gender,address,profile_pic,status,created_by,created_at) VALUES ('1','$paguthi','$role','$name','$mobile','$email','$md5pwd','$gender','$address','$staff_prof_pic','$status','$user_id',NOW())";
			$result=$this->db->query($insert);
				
			$subject ='GMS - Staff Login Details';
			$htmlContent = '<html>
							<head> <title></title>
							</head>
							<body>
							<p>Hi  '.$name.'</p>
							<p>Staff Login Details</p>
							<p>Username: '.$email.'</p>
							<p>Password: '.$OTP.'</p>
							<p></p>
							<p><a href="'.base_url() .'">Click here to Login</a></p>
							</body>
							</html>';
							
			$smsContent = 'Hi  '.$name.' Your Account Username : '.$email.' Password '.$OTP.'';

			//$this->mailmodel->sendEmail($email,$subject,$htmlContent);
			//$this->smsmodel->sendSMS($mobile,$smsContent);
			  
            if ($result) {
                $data = array("status" => "success");
            } else {
                $data = array("status" => "failed");
            }
			 return $data;
       }
   }
	
	function list_users(){
		$query="SELECT A.*, B.paguthi_name FROM user_master A, paguthi b WHERE A.pugathi_id = B.id";
		$resultset=$this->db->query($query);
		return $resultset->result();
	}
	
	function users_details($staff_id){
		$query="SELECT * FROM `user_master` WHERE id='$staff_id'";
		$resultset=$this->db->query($query);
		return $resultset->result();
	}
	
	function checkemail_edit($email,$staff_id){
	$select="SELECT * FROM user_master WHERE email_id='$email' AND id!='$staff_id'";
	$result=$this->db->query($select);
		if($result->num_rows()>0){
			echo "false";
		}else{
			echo "true";
		}
	}

	function update_user($role,$paguthi,$name,$email,$mobile,$address,$gender,$status,$staff_prof_pic,$staff_id,$user_id){
		
		$sQuery = "SELECT * FROM user_master WHERE id = '$staff_id'";
		$user_result = $this->db->query($sQuery);
		$ress = $user_result->result();
		if($user_result->num_rows()>0)
		{
			foreach ($user_result->result() as $rows)
			{
				$old_email_id = $rows->email_id;
			}
		}

		if ($old_email_id != $email){

			$update_user="UPDATE user_master SET pugathi_id='$paguthi',role_id='$role',full_name='$name',email_id='$email',phone_number='$mobile',gender='$gender',address='$address',profile_pic='$staff_prof_pic',status='$status',updated_at=NOW(),updated_by='$user_id' WHERE id='$staff_id'";
			$result_user=$this->db->query($update_user);
			
			$subject ='GMS - Staff Login - Username Updated';
			$htmlContent = '<html>
							<head> <title></title>
							</head>
							<body>
							<p>Hi  '.$name.'</p>
							<p>Login Details</p>
							<p>Username: '.$email.'</p>
							<p></p>
							<p><a href="'.base_url() .'">Click here to Login</a></p>
							</body>
							</html>';
			
			$smsContent = 'Hi  '.$name.' Your Account Username : '.$email.' is updated.';
			
			//$this->mailmodel->sendEmail($email,$subject,$htmlContent);
			//$this->smsmodel->sendSMS($mobile,$smsContent);			

		}else {
			$update_user="UPDATE user_master SET pugathi_id='$paguthi',role_id='$role',full_name='$name',phone_number='$mobile',gender='$gender',address='$address',profile_pic='$staff_prof_pic',status='$status',updated_at=NOW(),updated_by='$user_id' WHERE id='$staff_id'";
			$result_user=$this->db->query($update_user);
		}		
		if ($result_user) {
		  $data = array("status" => "success");
		} else {
		  $data = array("status" => "failed");
		}
		return $data;
	}
	
	
}
?>
