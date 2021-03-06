<?php
Class Usermodel extends CI_Model
{
	public function __construct()
	{
	  parent::__construct();
		$this->load->model('mailmodel');
		$this->load->model('smsmodel');
	}

	function list_role()
	{
		$query="SELECT * FROM `role_master` WHERE status='ACTIVE'";
		$resultset=$this->app_db->query($query);
		return $resultset->result();
	}

	function list_paguthi()
	{
		$query="SELECT * FROM `paguthi` WHERE constituency_id='1' AND status='ACTIVE'";
		$resultset=$this->app_db->query($query);
		return $resultset->result();
	}

	function list_office()
	{
		$query="SELECT * FROM `office` WHERE  status='ACTIVE'";
		$resultset=$this->app_db->query($query);
		return $resultset->result();
	}

	function list_seeker()
	{
		$query="SELECT * FROM `seeker_type` WHERE status='ACTIVE'";
		$resultset=$this->app_db->query($query);
		return $resultset->result();
	}

	function list_category()
	{
		$query="SELECT * FROM `grievance_type` WHERE status='ACTIVE'";
		$resultset=$this->app_db->query($query);
		return $resultset->result();
	}

	function list_subcategory()
	{
		$query="SELECT * FROM `grievance_sub_category` WHERE status='ACTIVE'";
		$resultset=$this->app_db->query($query);
		return $resultset->result();
	}

	function checkemail($email){
	$select="SELECT * FROM user_master WHERE email_id='$email'";
	$result=$this->app_db->query($select);
		if($result->num_rows()>0){
			echo "false";
		}else{
			echo "true";
		}
    }

	function checkphone($phone){
	$select="SELECT * FROM user_master WHERE phone_number='$phone'";
	$result=$this->app_db->query($select);
		if($result->num_rows()>0){
			echo "false";
		}else{
			echo "true";
		}
    }


	function add_users($role,$paguthi,$office_id,$name,$email,$mobile,$address,$gender,$status,$staff_prof_pic,$user_id) {

		$select="SELECT * FROM user_master WHERE email_id='$email' AND pugathi_id = '$paguthi'";
		$result=$this->app_db->query($select);

       if($result->num_rows()>0){
			 $data = array(
				 "status" => "already"
			 );
			return $data;
       }else{

			$digits = 6;
			$OTP = str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);
			$md5pwd=md5($OTP);

			$insert="INSERT INTO user_master (constituency_id,pugathi_id,office_id,role_id,full_name,phone_number,email_id,password,gender,address,profile_pic,status,created_by,created_at) VALUES ('1','$paguthi','$office_id','$role','$name','$mobile','$email','$md5pwd','$gender','$address','$staff_prof_pic','$status','$user_id',NOW())";
			$result=$this->app_db->query($insert);

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

			$this->mailmodel->sendEmail($email,$subject,$htmlContent);
			$this->smsmodel->sendSMS($mobile,$smsContent);

            if ($result) {
                $data = array("status" => "success");
            } else {
                $data = array("status" => "failed");
            }
			 return $data;
       }
   }

	function list_users(){
		$query="SELECT
				A.*,
				B.paguthi_name
			FROM
				user_master A,
				paguthi B
			WHERE
				A.id!='1' AND A.pugathi_id = B.id";
		$resultset=$this->app_db->query($query);
		return $resultset->result();
	}

	function users_details($staff_id){
		$query="SELECT * FROM `user_master` WHERE id='$staff_id'";
		$resultset=$this->app_db->query($query);
		return $resultset->result();
	}

	function checkemail_edit($email,$staff_id){
	$select="SELECT * FROM user_master WHERE email_id='$email' AND id!='$staff_id'";
	$result=$this->app_db->query($select);
		if($result->num_rows()>0){
			echo "false";
		}else{
			echo "true";
		}
	}

	function checkphone_edit($phone,$staff_id){
	 $select="SELECT * FROM user_master WHERE phone_number='$phone' AND id!='$staff_id'";
	$result=$this->app_db->query($select);
		if($result->num_rows()>0){
			echo "false";
		}else{
			echo "true";
		}
	}

	function update_user($role,$paguthi,$office_id,$name,$email,$mobile,$address,$gender,$status,$staff_prof_pic,$staff_id,$user_id){

		$sQuery = "SELECT * FROM user_master WHERE id = '$staff_id'";
		$user_result = $this->app_db->query($sQuery);
		$ress = $user_result->result();
		if($user_result->num_rows()>0)
		{
			foreach ($user_result->result() as $rows)
			{
				$old_email_id = $rows->email_id;
				$old_phone = $rows->phone_number;
			}
		}

		if ($old_email_id != $email){

			$update_user="UPDATE user_master SET pugathi_id='$paguthi',office_id='$office_id',role_id='$role',full_name='$name',email_id='$email',gender='$gender',address='$address',profile_pic='$staff_prof_pic',status='$status',updated_at=NOW(),updated_by='$user_id' WHERE id='$staff_id'";
			$result_user=$this->app_db->query($update_user);

			$subject ='GMS - Staff Login - Username Updated';
			$htmlContent = '<html>
							<head> <title></title>
							</head>
							<body>
							<p>Hi  '.$name.'</p>
							<p>Login Details</p>
							<p>New Email: '.$email.'</p>
							<p></p>
							<p><a href="'.base_url() .'">Click here to Login</a></p>
							</body>
							</html>';

			$smsContent = 'Hi  '.$name.' Your Account Email : '.$email.' is updated.';

			$this->mailmodel->sendEmail($email,$subject,$htmlContent);
			$this->smsmodel->sendSMS($mobile,$smsContent);

		}else if  ($old_phone != $mobile) {
				$update_user="UPDATE user_master SET pugathi_id='$paguthi',office_id='$office_id',role_id='$role',full_name='$name',phone_number='$mobile',gender='$gender',address='$address',profile_pic='$staff_prof_pic',status='$status',updated_at=NOW(),updated_by='$user_id' WHERE id='$staff_id'";
				$result_user=$this->app_db->query($update_user);
				$subject ='GMS - Staff Login - Phone number Updated';
				$htmlContent = '<html>
								<head> <title></title>
								</head>
								<body>
								<p>Hi  '.$name.'</p>
								<p>Login Details</p>
								<p>New Phone number: '.$mobile.'</p>
								<p></p>
								<p><a href="'.base_url() .'">Click here to Login</a></p>
								</body>
								</html>';

				$smsContent = 'Hi  '.$name.' Your Account Phone number : '.$mobile.' is updated.';

				$this->mailmodel->sendEmail($email,$subject,$htmlContent);
				$this->smsmodel->sendSMS($mobile,$smsContent);
		}else {
			$update_user="UPDATE user_master SET pugathi_id='$paguthi',office_id='$office_id',role_id='$role',full_name='$name',gender='$gender',address='$address',profile_pic='$staff_prof_pic',status='$status',updated_at=NOW(),updated_by='$user_id' WHERE id='$staff_id'";
			$result_user=$this->app_db->query($update_user);
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
