<?php
Class Loginmodel extends CI_Model
{
	public function __construct()
	{
	  parent::__construct();
		$this->load->model('mailmodel');
		$this->load->model('smsmodel');
	}

//------------Connect Master DB ---------------//
	function valid_code($cons_code)
	{
		 $query = "SELECT * FROM gms_consty_user_master WHERE consituency_code = '$cons_code' AND status = 'Active'";
		 $resultset=$this->db->query($query);
		 if($resultset->num_rows()>0){
			 $data = array("consituency_code"  => 'sanzhapp_'.$cons_code);
			 //$data = array("consituency_code"  => 'gms');
			 $this->session->set_userdata($data);
			 $data= array("status" => "Active","msg" => "Your Account Is Active");
			 return $data;
		 } else {
			 $data= array("status" => "Deactive","msg" => "Your Account Is De-Activated");
			 return $data;
		 }
		$this->db->close();
	}
//------------Connect Master DB End---------------// 

	function login($username,$password)
	{
		$pwd = md5($password);
		
		$sQuery = "SELECT * FROM colour_codes WHERE selected_status = 'Y'";
		$user_result = $this->app_db->query($sQuery);
		$ress = $user_result->result();
		if($user_result->num_rows()>0)
		{
			foreach ($user_result->result() as $rows)
			{
				$base_colour = $rows->colour_code;
			}
		}
		
		$chkUser = "SELECT A.*, B.constituency_name FROM user_master A, constituency B WHERE A.email_id ='$username' AND A.password='$pwd' AND A.constituency_id = B.id";
		$res=$this->app_db->query($chkUser);
		if($res->num_rows()>0){
		   foreach($res->result() as $rows)
		   {
			   $status = $rows->status;
		   }
			if ($status == 'ACTIVE'){
				  $data = array("user_type"=>$rows->role_id,"user_id"=>$rows->id,"name"=>$rows->full_name,"email_id"=>$rows->email_id,"constituency_id"=>$rows->constituency_id,"constituency_name"=>$rows->constituency_name,"pugathi_id"=>$rows->pugathi_id,"office_id"=>$rows->office_id,"user_pic"=>$rows->profile_pic,"status"=>$rows->status,"base_colour"=>$base_colour);
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
         $result=$this->app_db->query($query);
         if($result->num_rows()>0){
			 foreach($result->result() as $row){
				 $user_id = $row->id;
				 $name = $row->full_name;
				 $user_type = $row->role_id ;
				 $to_email = $row->email_id ;
				}

			 $digits = 6;
			 $OTP = str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);
			 $reset_pwd = md5($OTP);

			$reset="UPDATE user_master SET password ='$reset_pwd' WHERE id='$user_id'";
			$result_pwd=$this->app_db->query($reset);

			 $subject = 'GMS - Forgot Password';
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
			//$this->smsmodel->sendSMS($to_phone,$smsContent);

			echo "success";
         }else{
			echo "error";
		 }
     }

	function profile($user_id){
		$query="SELECT * FROM `user_master` WHERE id='$user_id'";
		$resultset=$this->app_db->query($query);
		return $resultset->result();
	}

	function profile_update($name,$address,$phone,$email,$gender,$staff_prof_pic,$user_id){

		$sQuery = "SELECT * FROM user_master WHERE id = '$user_id'";
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

		if ($email!="")
		{
			if ($old_email_id != $email){

				 $update = "UPDATE user_master SET full_name='$name',gender='$gender',address='$address',email_id='$email',profile_pic='$staff_prof_pic',updated_at=NOW(),updated_by='$user_id' WHERE id='$user_id'";
				$result = $this->app_db->query($update);
				$subject ='GMS - Staff Login - Username Updated';
				$htmlContent = '<html>
								<head> <title></title>
								</head>
								<body>
								<p>Hi  '.$name.'</p>
								<p>Login Details</p>
								<p>Email: '.$email.'</p>
								<p></p>
								<p><a href="'.base_url() .'">Click here to Login</a></p>
								</body>
								</html>';

				$smsContent = 'Hi  '.$name.' Your Account Email : '.$email.' is updated.';
				$this->mailmodel->sendEmail($email,$subject,$htmlContent);
				$this->smsmodel->sendSMS($phone,$smsContent);
			}else {
				$update = "UPDATE user_master SET full_name='$name',gender='$gender',address='$address',profile_pic='$staff_prof_pic',updated_at=NOW(),updated_by='$user_id' WHERE id='$user_id'";
				$result = $this->app_db->query($update);
			}
		}

		if  ($phone!=""){
				if ($old_phone != $phone) {
					$update = "UPDATE user_master SET full_name='$name',gender='$gender',address='$address',phone_number='$phone',updated_at=NOW(),updated_by='$user_id' WHERE id='$user_id'";
					$result = $this->app_db->query($update);
					$subject ='GMS - Staff Login - Phone number Updated';
					$htmlContent = '<html>
									<head> <title></title>
									</head>
									<body>
									<p>Hi  '.$name.'</p>
									<p>Login Details</p>
									<p>New Phone number: '.$phone.'</p>
									<p></p>
									<p><a href="'.base_url() .'">Click here to Login</a></p>
									</body>
									</html>';

					$smsContent = 'Hi  '.$name.' Your Account Phone number : '.$phone.' is updated.';

					$this->mailmodel->sendEmail($email,$subject,$htmlContent);
					$this->smsmodel->sendSMS($phone,$smsContent);
				} else {
					$update = "UPDATE user_master SET full_name='$name',gender='$gender',address='$address',profile_pic='$staff_prof_pic',updated_at=NOW(),updated_by='$user_id' WHERE id='$user_id'";
					$result = $this->app_db->query($update);
				}
		}

		if ($email =="" && $phone =="")
		{
			 $update = "UPDATE user_master SET full_name='$name',gender='$gender',address='$address',profile_pic='$staff_prof_pic',updated_at=NOW(),updated_by='$user_id' WHERE id='$user_id'";
			$result = $this->app_db->query($update);
		}

		$data = array("name"  => $name,"user_pic"  => $staff_prof_pic);
		 $this->session->set_userdata($data);
		 
		if ($result) {
		  $data = array("status" => "success");
		} else {
		  $data = array("status" => "failed");
		}
		return $data;
	}



	function check_password_match($old_password,$user_id){
		$pwd=md5($old_password);
		$select="SELECT * FROM user_master WHERE password='$pwd' AND id='$user_id'";
		$result=$this->app_db->query($select);
	   if($result->num_rows()==0){
			echo "false";
		 }else{
			echo "true";
	   }
   }

	function password_update($new_password,$user_id,$user_type){
		$pwd = md5($new_password);
		$query="UPDATE user_master SET password='$pwd', updated_at=NOW() WHERE id='$user_id'";
		$ex = $this->app_db->query($query);

		$sQuery = "SELECT * FROM user_master WHERE `id` = '$user_id'";
		$user_result = $this->app_db->query($sQuery);
		$ress = $user_result->result();
		if($user_result->num_rows()>0)
		{
			foreach ($user_result->result() as $rows)
			{
				 $name = $rows->full_name;
				 $email = $rows->email_id;
				 $mobile = $rows->phone_number;
			}

		$subject ='M3 - Password Update';
		$htmlContent = '<html>
							<head> <title></title>
							</head>
							<body>
							<p>Hi  '.$name.'</p>
							<p>Your Password Updated Sucessfully!</p>
							</body>
							</html>';

			$smsContent = 'Hi  '.$name.' Your Password Updated Sucessfully!';

			$this->mailmodel->sendEmail($email,$subject,$htmlContent);
			//$this->smsmodel->sendSMS($mobile,$smsContent);
		}

		if ($ex) {
		  $datas = array("status" => "success");
		} else {
		  $datas = array("status" => "failed");
		}
		 return $datas;
	}

	function get_colours(){
		$query="SELECT * FROM colour_codes WHERE status='ACTIVE'";
		$result=$this->app_db->query($query);
		return $result->result();
	}
	
	function update_colour_settings($colour_id){
		
		$query = "UPDATE colour_codes SET selected_status='N'";
		$ex = $this->app_db->query($query);
		
		$query = "UPDATE colour_codes SET selected_status='Y' WHERE id='$colour_id'";
		$ex = $this->app_db->query($query);
		
		$sQuery = "SELECT * FROM colour_codes WHERE selected_status = 'Y'";
		$user_result = $this->app_db->query($sQuery);
		$ress = $user_result->result();
		if($user_result->num_rows()>0)
		{
			foreach ($user_result->result() as $rows)
			{
				$base_colour = $rows->colour_code;
			}
		}
		 $data = array("base_colour"  => $base_colour);
		 $this->session->set_userdata($data);
			 
		if($ex){
			$datas=array("status"=>"success","msg"=>"Colour Updated Successfully!","class"=>"alert alert-success");
		}else{
			$datas=array("status"=>"error","msg"=>"Something went wrong!","class"=>"alert alert-danger");
		}
		
		 return $datas;
	}
}
?>
