<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Apiiosmodel extends CI_Model {

public function __construct()
	{
	  parent::__construct();
		$this->load->model('mailmodel');
		$this->load->model('smsmodel');
		$this->load->model('notificationmodel');
	}

	public function version_check($version_code)
	{
	  if($version_code >= 1){
		  $response = array("status" => "success","version_code"=>$version_code);
	  }else{
		$response = array("status" => "error","version_code"=>$version_code);
	  }
	  return $response;
	}

//#################### Main Login ####################//
	public function Login($username,$password,$gcm_key,$mobile_type)
	{
	    $sql = "SELECT * FROM user_master WHERE (email_id ='$username' OR phone_number = '$username') AND password = md5('".$password."')";
		$user_result = $this->db->query($sql);
		$ress = $user_result->result();
		if($user_result->num_rows()>0)
		{
			$check_status="SELECT * FROM user_master WHERE (email_id='$username' OR phone_number = '$username') AND status='INACTIVE'";
			$user_status = $this->db->query($check_status);
			if($user_status->num_rows()>0){
				$response = array("status" => "Error", "msg" => "Account Deactivated");
				return $response;
			} else{
				foreach ($user_result->result() as $rows)
				{
				  $user_id = $rows->id;
				  $login_count = $rows->login_count+1;
				  $profile_pic = $rows->profile_pic ;
				}
				
				if ($profile_pic != ''){
			        $picture_url = base_url().'assets/users/'.$profile_pic;
			    }else {
			         $picture_url = '';
			    }
				$update_sql = "UPDATE user_master SET last_login=NOW(),login_count='$login_count' WHERE id='$user_id'";
				$update_result = $this->db->query($update_sql);
				
				$gcmQuery = "SELECT * FROM notification_master WHERE gcm_key like '%" .$gcm_key. "%' LIMIT 1";
				$gcm_result = $this->db->query($gcmQuery);
				$gcm_ress = $gcm_result->result();

				if($gcm_result->num_rows()==0)
				{
					$sQuery = "INSERT INTO notification_master (user_type,user_id,gcm_key,mobile_type) VALUES ('2','". $user_id . "','". $gcm_key . "','". $mobile_type . "')";
					$update_gcm = $this->db->query($sQuery);
				}
			}

			$userData  = array(
							"user_id" => $ress[0]->id,
							"user_role" => $ress[0]->role_id,
							"constituency_id" => $ress[0]->constituency_id,
							"pugathi_id" => $ress[0]->pugathi_id,
							"full_name" => $ress[0]->full_name,
							"phone_number" => $ress[0]->phone_number,
							"email_id" => $ress[0]->email_id,
							"gender" => $ress[0]->gender,
							"address" => $ress[0]->address,
							"picture_url" => $picture_url,
							"status" => $ress[0]->status,
							"last_login" => $ress[0]->last_login,
							"login_count" => $ress[0]->login_count						
				);
			
			$response = array("status" => "Success", "msg" => "Login Successfully", "userData" => $userData);
			return $response;
		} else {
			$response = array("status" => "Error", "msg" => "Invalid login credentials!");
			return $response;
		}

	}

//#################### Main Login End ####################//

//#################### Forgot Password ####################//
	public function Forgot_password($user_name)
	{
			$digits = 6;
			$OTP = str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);
    		$nPassword = md5($OTP);

    		$sql = "SELECT * FROM user_master WHERE (email_id ='$user_name' OR phone_number = '$user_name') AND status='ACTIVE'";
    		$user_result = $this->db->query($sql);
    		$ress = $user_result->result();
    		if($user_result->num_rows()>0)
    		{
    			foreach ($user_result->result() as $rows)
    			{
					$user_id = $rows->id;
					$to_phone = $rows->phone_number;
					$name = $rows->full_name;
					$user_type = $rows->role_id ;
					$to_email = $rows->email_id ;
    			}

				$update_sql = "UPDATE user_master SET password = '$nPassword', updated_at =NOW() WHERE id='$user_id'";
				$update_result = $this->db->query($update_sql);

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
				$this->smsmodel->sendSMS($to_phone,$smsContent);
				$response = array("status" => "success", "msg" => "Password reset sucessfully!.");
    		}else {
				$response = array("status" => "error", "msg" => "Username not found");
			}
			return $response;
	}
//#################### Forgot Password End ####################//


//#################### Profile Details ####################//
	public function Profile_details($user_id)
	{
            $sql = "SELECT * FROM `user_master` WHERE id='$user_id'";
			$user_result = $this->db->query($sql);
			$ress = $user_result->result();

			if($user_result->num_rows()>0)
			{
			    foreach ($user_result->result() as $rows)
    			{
    				  $user_picture = $rows->profile_pic ;
    			}
			    if ($user_picture != ''){
			        $picture_url = base_url().'assets/users/'.$user_picture;
			    }else {
			         $picture_url = '';
			    }
				$userData  = array(
							"user_id" => $ress[0]->id,
							"user_role" => $ress[0]->role_id,
							"constituency_id" => $ress[0]->constituency_id,
							"pugathi_id" => $ress[0]->pugathi_id,
							"full_name" => $ress[0]->full_name,
							"phone_number" => $ress[0]->phone_number,
							"email_id" => $ress[0]->email_id,
							"gender" => $ress[0]->gender,
							"address" => $ress[0]->address,
							"picture_url" => $picture_url,
				);
					$response = array("status" => "Success", "msg" => "Profile Details", "userData" => $userData);
    				return $response;
		} else {

					$response = array("status" => "Error");
					return $response;
		}
	}
//#################### Profile Details End ####################//


//#################### Check Email ####################//
	public function Check_email($email)
	{
		$select="SELECT * FROM user_master WHERE email_id='$email'";
		$result=$this->db->query($select);
			if($result->num_rows()>0){
				$response = array("status" => "error", "msg" => "Email Already");
			}else{
				$response = array("status" => "sucess");
			}
			return $response;	
	}

	public function Check_emailedit($user_id,$email)
	{
		$select="SELECT * FROM user_master WHERE email_id='$email' AND id!='$user_id'";
		$result=$this->db->query($select);
			if($result->num_rows()>0){
				$response = array("status" => "error", "msg" => "Email Already");
			}else{
				$response = array("status" => "sucess");
			}
			return $response;	
	}

//#################### Check Email End ####################//

//#################### Check Phone number ####################//
	public function Check_phone($phone)
	{
		$select="SELECT * FROM user_master WHERE phone_number='$phone'";
		$result=$this->db->query($select);
			if($result->num_rows()>0){
				$response = array("status" => "error", "msg" => "Phone number already");
			}else{
				$response = array("status" => "sucess");
			}
			return $response;	
	}

	public function Check_phoneedit($user_id,$phone)
	{
		$select="SELECT * FROM user_master WHERE phone_number='$phone' AND id!='$user_id'";
		$result=$this->db->query($select);
			if($result->num_rows()>0){
				$response = array("status" => "error", "msg" => "Phone number already");
			}else{
				$response = array("status" => "sucess");
			}
			return $response;	
	}

//#################### Check Phone End ####################//


//#################### Profile Update ####################//
	public function Profile_update($name,$address,$phone,$email,$gender,$user_id)
	{	
		$sQuery = "SELECT * FROM user_master WHERE id = '$user_id'";
		$user_result = $this->db->query($sQuery);
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
				$result = $this->db->query($update);
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
				$result = $this->db->query($update);
			}
		}
		
		if  ($phone!=""){  
				if ($old_phone != $phone) {
					$update = "UPDATE user_master SET full_name='$name',gender='$gender',address='$address',phone_number='$phone',updated_at=NOW(),updated_by='$user_id' WHERE id='$user_id'";
					$result = $this->db->query($update);
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
					$result = $this->db->query($update);
				}
		}
		
		if ($email =="" && $phone =="")
		{
			 $update = "UPDATE user_master SET full_name='$name',gender='$gender',address='$address',profile_pic='$staff_prof_pic',updated_at=NOW(),updated_by='$user_id' WHERE id='$user_id'";
			$result = $this->db->query($update);
		}
			
		$response = array("status" => "success", "msg" => "Profile Updated");
		return $response;
	}
//#################### Profile Update End ####################//

//#################### Profile Pic Update ####################//
	public function Update_profilepic($user_id,$userFileName)
	{
            $update_sql= "UPDATE user_master SET profile_pic='$userFileName' WHERE id='$user_id'";
			$update_result = $this->db->query($update_sql);
			$picture_url = base_url().'assets/users/'.$userFileName;

			$response = array("status" => "success", "msg" => "Profile Picture Updated","picture_url" =>$picture_url);
			return $response;
	}
//#################### Profile Pic Update End ####################//

//#################### Change Password ####################//
	public function Change_password($user_id,$newpassword,$oldpassword){
		$check="SELECT * FROM user_master WHERE id='$user_id' AND password=md5('$oldpassword')";
		$res_check=$this->db->query($check);
		if($res_check->num_rows()>0){

		  $update_sql = "UPDATE user_master SET password = md5('$newpassword'),updated_at=NOW() WHERE id='$user_id'";
		  $update_result = $this->db->query($update_sql);
		  if($update_result){
			  $response = array("status" => "success", "msg" => "Password Updated");
		  }else{
			  $response = array("status" => "error", "msg" => "Something went wrong!");
		  }
		}else{
			$response = array("status" => "error", "msg" => "Old Password didn't match");
		}
    	return $response;
	}
//#################### Change Password End ####################//


//#################### List paguthi ####################//
	function List_paguthi($constituency_id)
	{
		$query="SELECT * FROM `paguthi` WHERE constituency_id='$constituency_id' AND status='ACTIVE'";
		$resultset=$this->db->query($query);
		$paguthi_result = $resultset->result();
		if($resultset->num_rows()>0)
			{
				$response = array("status" => "Success", "msg" => "List Paguthi", "paguthi_details" =>$paguthi_result);
			} else {
				$response = array("status" => "Error", "msg" => "No records found");
			}
		return $response;
	}
//#################### List paguthi end ####################//


//#################### Dashboard ####################//

	function Dashboard($paguthi)
	{
		if ($paguthi == 'ALL')
		{
			$constituent_count = "SELECT * FROM constituent";
			$constituent_count_res = $this->db->query($constituent_count);
			$constituent_count = $constituent_count_res->num_rows();
			
			$meeting_count = "SELECT * FROM meeting_request";
			$meeting_count_res = $this->db->query($meeting_count);
			$meeting_count = $meeting_count_res->num_rows();
					
			$grievance_count = "SELECT * FROM grievance";
			$grievance_count_res = $this->db->query($grievance_count);
			$grievance_count = $grievance_count_res->num_rows();
			
			$interactioncount = "SELECT * FROM interaction_history WHERE question_response = 'Y'";
			$interactioncount_res = $this->db->query($interactioncount);
			$interactioncount = $interactioncount_res->num_rows();

			$result  = array(
					"constituent_count" => $constituent_count,
					"meeting_count" => $meeting_count,
					"grievance_count" => $grievance_count,
					"interaction_count" => $interactioncount
				);
					
			
			$s_query = "SELECT
							count(*) AS total,
							CONCAT(
								SUBSTRING(
									DATE_FORMAT(`grievance_date`, '%M'),
									1,
									3
								),
								DATE_FORMAT(`grievance_date`, '-%Y')
							) AS disp_month,
							DATE_FORMAT(`grievance_date`, '%Y%m') AS month_year
						FROM 
							grievance
						WHERE
							PERIOD_DIFF(
								DATE_FORMAT(NOW(), '%Y%m'),
								DATE_FORMAT(`grievance_date`, '%Y%m')) < 12
							GROUP BY
								disp_month 
							ORDER BY 
								grievance_date";
				$s_res = $this->db->query($s_query);
				
    			if($s_res->num_rows()>0){
					
    			    foreach ($s_res->result() as $rows)
    		        {
						 $month_year = $rows->month_year;
						 $total = $rows->total;
						 $disp_month = $rows->disp_month;
						
						
						$n_query = "SELECT
										COUNT(*) AS new_rec
									FROM
										grievance
										WHERE repeated_status = 'N' AND DATE_FORMAT(`grievance_date`, '%Y%m') = '$month_year'
									GROUP BY
										constituent_id";
						$n_res = $this->db->query($n_query);
						if($n_res->num_rows()>0){
							$disp_new = 0; 
							foreach ($n_res->result() as $n_rows)
							{
								 $new_rec = $n_rows->new_rec;
								 $disp_new = ($disp_new +  $new_rec);
							}
						} else {
								 $disp_new = 0;
						}
					
						
						 $r_query = "SELECT
										COUNT(*) AS repeated_rec
									FROM
										grievance
										WHERE repeated_status = 'R' AND DATE_FORMAT(`grievance_date`, '%Y%m') = '$month_year'
									GROUP BY
										constituent_id";
						$r_res = $this->db->query($r_query);
						if($r_res->num_rows()>0){
							$disp_repeated =0;
							foreach ($r_res->result() as $r_rows)
							{
								 $repeated_rec = $r_rows->repeated_rec;
								 $disp_repeated = ($disp_repeated +  $repeated_rec);
							}
						} else {
								 $disp_repeated = 0;
						}
						
    			       $footfall_graph[]  = (object) array(
    					   "disp_month" => $disp_month,
    					   "total" => $total,
						   "new_grev" => $disp_new,
						   "repeated_grev" => $disp_repeated
    			        ); 
    		         }	
				}else {
					$footfall_graph[]  = (object) array(
    					   "disp_month" => "Nill",
    					   "total" => 0,
						   "new_grev" => 0,
						   "repeated_grev" => 0
    			        ); 
				}

			$grievance_graphcount = "SELECT * FROM grievance";
			$grievance_graphcount_res = $this->db->query($grievance_graphcount);
			$grievance_graphcount = $grievance_graphcount_res->num_rows();
			
			$grievance_graphecount = "SELECT * FROM grievance WHERE enquiry_status = 'E'";
			$grievance_graphecount_res = $this->db->query($grievance_graphecount);
			$grievance_graphecount = $grievance_graphecount_res->num_rows();
			
			$grievance_graphppcount = "SELECT * FROM grievance WHERE enquiry_status = 'P' AND status='PROCESSING'";
			$grievance_graphppcount_res = $this->db->query($grievance_graphppcount);
			$grievance_graphppcount = $grievance_graphppcount_res->num_rows();
			
			$grievance_graphpccount = "SELECT * FROM grievance WHERE enquiry_status = 'P' AND status='COMPLETED'";
			$grievance_graphpccount_res = $this->db->query($grievance_graphpccount);
			$grievance_graphpccount = $grievance_graphpccount_res->num_rows();
			

			$grievance_graph  = array(
					"gerv_count" => $grievance_graphcount,
					"gerv_ecount" => $grievance_graphecount,
					"gerv_ppcount" => $grievance_graphppcount,
					"gerv_pccount" => $grievance_graphpccount
				);


			$query="SELECT
					CONCAT(
						SUBSTRING(
							DATE_FORMAT(`created_at`, '%M'),
							1,
							3
						),
						DATE_FORMAT(`created_at`, '-%Y')
					) AS month_year,
					COUNT(*) AS meeting_request
				FROM
					meeting_request
				WHERE
					PERIOD_DIFF(
						DATE_FORMAT(NOW(), '%Y%m'),
						DATE_FORMAT(`created_at`, '%Y%m')) < 6
					GROUP BY
						YEAR(`created_at`),
						MONTH(`created_at`)";
			$res=$this->db->query($query);
			$meeting_graph=$res->result();

			$response = array("status" => "Success", "msg" => "Dashboard Details", "widgets_count" => $result,"footfall_graph" =>$footfall_graph, "grievance_graph" =>$grievance_graph,"meeting_graph" =>$meeting_graph);
		} else {
			$constituent_count = "SELECT * FROM constituent WHERE paguthi_id = '$paguthi' ";
			$constituent_count_res = $this->db->query($constituent_count);
			$constituent_count = $constituent_count_res->num_rows();
						
			$meeting_count = "SELECT * FROM meeting_request A, constituent B WHERE A.constituent_id = B.id AND B.paguthi_id ='$paguthi' ";
			$meeting_count_res = $this->db->query($meeting_count);
			$meeting_count = $meeting_count_res->num_rows();
			
			$grievance_count = "SELECT * FROM grievance WHERE paguthi_id = '$paguthi'";
			$grievance_count_res = $this->db->query($grievance_count);
			$grievance_count = $grievance_count_res->num_rows();
			
			$interactioncount = "SELECT
									ih.constituent_id,
									ih.question_id,
									ih.question_response
								FROM
									interaction_history AS ih
								LEFT JOIN constituent AS c
								ON
									c.id = ih.constituent_id
								WHERE
									c.paguthi_id = '$paguthi' AND ih.question_response = 'Y'";
			$interactioncount_res = $this->db->query($interactioncount);
			$interactioncount = $interactioncount_res->num_rows();
			
			$result  = array(
					"constituent_count" => $constituent_count,
					"meeting_count" => $meeting_count,
					"grievance_count" => $grievance_count,
					"interaction_count" => $interactioncount
				);
				
			$query="SELECT
					ih.constituent_id,
					ih.question_id,
					ih.question_response,
					iq.widgets_title,
					COUNT(ih.question_id) AS tot_values
					FROM
						interaction_history AS ih
					LEFT JOIN constituent AS c
					ON
						c.id = ih.constituent_id
					LEFT JOIN interaction_question AS iq
					ON
						ih.question_id = iq.id
					WHERE
						ih.question_response = 'Y' AND c.paguthi_id = '$paguthi'
					GROUP BY
						ih.question_id";
			$res=$this->db->query($query);
			$int_result=$res->result();
			
			$s_query = "SELECT
							count(*) AS total,
							CONCAT(
								SUBSTRING(
									DATE_FORMAT(`grievance_date`, '%M'),
									1,
									3
								),
								DATE_FORMAT(`grievance_date`, '-%Y')
							) AS disp_month,
							DATE_FORMAT(`grievance_date`, '%Y%m') AS month_year
						FROM 
							grievance
						WHERE paguthi_id = '$paguthi' AND
							PERIOD_DIFF(
								DATE_FORMAT(NOW(), '%Y%m'),
								DATE_FORMAT(`grievance_date`, '%Y%m')) < 12
							GROUP BY
								disp_month
							ORDER BY 
								grievance_date";
				$s_res = $this->db->query($s_query);
				
				if($s_res->num_rows()>0){
					
					$disp_new = 0;
					$disp_repeated =0;
					
    			    foreach ($s_res->result() as $rows)
    		        {
						 $month_year = $rows->month_year;
						 $total = $rows->total;
						 $disp_month = $rows->disp_month;

						$n_query = "SELECT
										COUNT(*) AS new_rec
									FROM
										grievance
										WHERE repeated_status = 'N' AND paguthi_id = '$paguthi' AND DATE_FORMAT(`grievance_date`, '%Y%m') = '$month_year'
									GROUP BY
										constituent_id";
						$n_res = $this->db->query($n_query);
						if($n_res->num_rows()>0){
							$disp_new = 0; 
							foreach ($n_res->result() as $n_rows)
							{
								 $new_rec = $n_rows->new_rec;
								 $disp_new = ($disp_new +  $new_rec);
							}
						} else {
								 $disp_new = 0;
						}
						
						$r_query = "SELECT
										COUNT(*) AS repeated_rec
									FROM
										grievance
										WHERE repeated_status = 'R' AND paguthi_id = '$paguthi' AND DATE_FORMAT(`grievance_date`, '%Y%m') = '$month_year'
									GROUP BY
										constituent_id";
						$r_res = $this->db->query($r_query);
						if($r_res->num_rows()>0){
							$disp_repeated =0;
							foreach ($r_res->result() as $r_rows)
							{
								 $repeated_rec = $r_rows->repeated_rec;
								 $disp_repeated = ($disp_repeated +  $repeated_rec);
							}
						} else {
								 $disp_repeated = 0;
						}

    			       $footfall_graph[]  = (object) array(
    					   "disp_month" => $disp_month,
    					   "total" => $total,
						   "new_grev" => $disp_new,
						   "repeated_grev" => $disp_repeated
    			        ); 
    		         }	
				} else {
					$footfall_graph[]  = (object) array(
    					   "disp_month" => "Nill",
    					   "total" => 0,
						   "new_grev" => 0,
						   "repeated_grev" => 0
    			        ); 
				}
				
			$grievance_graphcount = "SELECT * FROM grievance WHERE paguthi_id = '$paguthi'";
			$grievance_graphcount_res = $this->db->query($grievance_graphcount);
			$grievance_graphcount = $grievance_graphcount_res->num_rows();
			
			$grievance_graphecount = "SELECT * FROM grievance WHERE enquiry_status = 'E' AND paguthi_id = '$paguthi'";
			$grievance_graphecount_res = $this->db->query($grievance_graphecount);
			$grievance_graphecount = $grievance_graphecount_res->num_rows();
			
			$grievance_graphppcount = "SELECT * FROM grievance WHERE enquiry_status = 'P' AND status='PROCESSING' AND paguthi_id = '$paguthi'";
			$grievance_graphppcount_res = $this->db->query($grievance_graphppcount);
			$grievance_graphppcount = $grievance_graphppcount_res->num_rows();
			
			$grievance_graphpccount = "SELECT * FROM grievance WHERE enquiry_status = 'P' AND status='COMPLETED' AND paguthi_id = '$paguthi'";
			$grievance_graphpccount_res = $this->db->query($grievance_graphpccount);
			$grievance_graphpccount = $grievance_graphpccount_res->num_rows();
			

			$grievance_graph  = array(
					"gerv_count" => $grievance_graphcount,
					"gerv_ecount" => $grievance_graphecount,
					"gerv_ppcount" => $grievance_graphppcount,
					"gerv_pccount" => $grievance_graphpccount
				);
			
			
			$query="SELECT
					CONCAT(
						SUBSTRING(
							DATE_FORMAT(A.created_at, '%M'),
							1,
							3
						),
						DATE_FORMAT(A.created_at, '-%Y')
					) AS month_year,
					COUNT(*) AS meeting_request
				FROM
					meeting_request A,
					constituent B
				WHERE A.constituent_id = B.id AND B.paguthi_id = '$paguthi' AND 
					PERIOD_DIFF(
						DATE_FORMAT(NOW(), '%Y%m'),
						DATE_FORMAT(A.created_at, '%Y%m')) < 6
					GROUP BY
						YEAR(A.created_at),
						MONTH(A.created_at)";
			$res=$this->db->query($query);
			$meeting_graph=$res->result();
		
			$response = array("status" => "Success", "msg" => "Dashboard Details", "widgets_count" => $result,"footfall_graph" =>$footfall_graph, "grievance_graph" =>$grievance_graph,"meeting_graph" =>$meeting_graph);
		}
		return $response;
	}



	function widgets_members($paguthi)
	{
		if ($paguthi == 'ALL') {
			
			$constituent_count = "SELECT * FROM constituent";
			$constituent_count_res = $this->db->query($constituent_count);
			$constituent_count = $constituent_count_res->num_rows();
			
			$constituent_mcount = "SELECT * FROM constituent WHERE gender = 'M'";
			$constituent_mcount_res = $this->db->query($constituent_mcount);
			$constituent_mcount = $constituent_mcount_res->num_rows();
			
			$constituent_fcount = "SELECT * FROM constituent WHERE gender = 'F'";
			$constituent_fcount_res = $this->db->query($constituent_fcount);
			$constituent_fcount = $constituent_fcount_res->num_rows();
			
			$constituent_vcount = "SELECT * FROM constituent WHERE voter_id_status = 'Y'";
			$constituent_vcount_res = $this->db->query($constituent_vcount);
			$constituent_vcount = $constituent_vcount_res->num_rows();
			
			$constituent_acount = "SELECT * FROM constituent WHERE aadhaar_status = 'Y'";
			$constituent_acount_res = $this->db->query($constituent_acount);
			$constituent_acount = $constituent_acount_res->num_rows();
			
			$result  = array(
					"member_count" => $constituent_count,
					"male_count" => $constituent_mcount,
					"female_count" => $constituent_fcount,
					"voterid_count" => $constituent_vcount,
					"aadhaar_count" => $constituent_acount
				);
				$response = array("status" => "Success", "msg" => "Constituent Details", "constituent_details" => $result);
		}else {
			
			$constituent_count = "SELECT * FROM constituent WHERE paguthi_id = '$paguthi' ";
			$constituent_count_res = $this->db->query($constituent_count);
			$constituent_count = $constituent_count_res->num_rows();
			
			$constituent_mcount = "SELECT * FROM constituent WHERE gender = 'M' AND paguthi_id = '$paguthi'";
			$constituent_mcount_res = $this->db->query($constituent_mcount);
			$constituent_mcount = $constituent_mcount_res->num_rows();
			
			$constituent_fcount = "SELECT * FROM constituent WHERE gender = 'F' AND paguthi_id = '$paguthi'";
			$constituent_fcount_res = $this->db->query($constituent_fcount);
			$constituent_fcount = $constituent_fcount_res->num_rows();
			
			$constituent_vcount = "SELECT * FROM constituent WHERE voter_id_status = 'Y' AND paguthi_id = '$paguthi'";
			$constituent_vcount_res = $this->db->query($constituent_vcount);
			$constituent_vcount = $constituent_vcount_res->num_rows();
			
			$constituent_acount = "SELECT * FROM constituent WHERE aadhaar_status = 'Y' AND paguthi_id = '$paguthi'";
			$constituent_acount_res = $this->db->query($constituent_acount);
			$constituent_acount = $constituent_acount_res->num_rows();
			
			$result  = array(
					"member_count" => $constituent_count,
					"male_count" => $constituent_mcount,
					"female_count" => $constituent_fcount,
					"voterid_count" => $constituent_vcount,
					"aadhaar_count" => $constituent_acount
				);
			
			$response = array("status" => "Success", "msg" => "Constituent Details", "constituent_details" => $result);
		}
		return $response;
	}
	
	function Widgets_meetings($paguthi)
	{
		if ($paguthi == 'ALL') {

			$meeting_count = "SELECT * FROM meeting_request";
			$meeting_count_res = $this->db->query($meeting_count);
			$meeting_count = $meeting_count_res->num_rows();
			
			$meeting_rcount = "SELECT * FROM meeting_request WHERE meeting_status = 'REQUESTED'";
			$meeting_rcount_res = $this->db->query($meeting_rcount);
			$meeting_rcount = $meeting_rcount_res->num_rows();

			$meeting_ccount = "SELECT * FROM meeting_request WHERE meeting_status = 'COMPLETED'";
			$meeting_ccount_res = $this->db->query($meeting_ccount);
			$meeting_ccount = $meeting_ccount_res->num_rows();
			
			$result  = array(
					"meeting_count" => $meeting_count,
					"requested_count" => $meeting_rcount,
					"completed_count" => $meeting_ccount
				);
				$response = array("status" => "Success", "msg" => "Meetings Details", "meeting_details" => $result);
		}else {
			
			$meeting_count = "SELECT * FROM meeting_request A, constituent B WHERE A.constituent_id = B.id AND B.paguthi_id ='$paguthi' ";
			$meeting_count_res = $this->db->query($meeting_count);
			$meeting_count = $meeting_count_res->num_rows();
			
			$meeting_rcount = "SELECT * FROM meeting_request A, constituent B WHERE A.constituent_id = B.id AND B.paguthi_id ='$paguthi' AND A.meeting_status = 'REQUESTED' ";
			$meeting_rcount_res = $this->db->query($meeting_rcount);
			$meeting_rcount = $meeting_rcount_res->num_rows();
			
			$meeting_ccount = "SELECT * FROM meeting_request A, constituent B WHERE A.constituent_id = B.id AND B.paguthi_id ='$paguthi' AND A.meeting_status = 'COMPLETED'";
			$meeting_ccount_res = $this->db->query($meeting_ccount);
			$meeting_ccount = $meeting_ccount_res->num_rows();
			
			$result  = array(
					"meeting_count" => $meeting_count,
					"requested_count" => $meeting_rcount,
					"completed_count" => $meeting_ccount
				);
			
			$response = array("status" => "Success", "msg" => "Meetings Details", "meeting_details" => $result);
		}
		return $response;
	}
	
	function Widgets_grievances($paguthi)
	{
		if ($paguthi == 'ALL') {

			$grievance_count = "SELECT * FROM grievance";
			$grievance_count_res = $this->db->query($grievance_count);
			$grievance_total_count = $grievance_count_res->num_rows();
			
			$grievance_ecount = "SELECT * FROM grievance WHERE enquiry_status = 'E'";
			$grievance_ecount_res = $this->db->query($grievance_ecount);
			$grievance_ecount = $grievance_ecount_res->num_rows();

			$grievance_pcount = "SELECT * FROM grievance WHERE enquiry_status = 'P'";
			$grievance_pcount_res = $this->db->query($grievance_pcount);
			$grievance_pcount = $grievance_pcount_res->num_rows();
			
			$grievance_processcount = "SELECT * FROM grievance WHERE status = 'PROCESSING'";
			$grievance_processcount_res = $this->db->query($grievance_processcount);
			$grievance_processcount = $grievance_processcount_res->num_rows();
			
			$grievance_completecount = "SELECT * FROM grievance WHERE status = 'COMPLETED'";
			$grievance_completecount_res = $this->db->query($grievance_completecount);
			$grievance_completecount = $grievance_completecount_res->num_rows();
			
			$result  = array(
					"grievance_count" => $grievance_total_count,
					"enquiry_count" => $grievance_ecount,
					"petition_count" => $grievance_pcount,
					"processing_count" => $grievance_processcount,
					"completed_count" => $grievance_completecount
				);
				$response = array("status" => "Success", "msg" => "Grievances Details", "grievances_details" => $result);
		}else {
			
			$grievance_count = "SELECT * FROM grievance WHERE paguthi_id = '$paguthi'";
			$grievance_count_res = $this->db->query($grievance_count);
			$grievance_total_count = $grievance_count_res->num_rows();
			
			$grievance_ecount = "SELECT * FROM grievance WHERE enquiry_status = 'E' AND paguthi_id = '$paguthi'";
			$grievance_ecount_res = $this->db->query($grievance_ecount);
			$grievance_ecount = $grievance_ecount_res->num_rows();

			$grievance_pcount = "SELECT * FROM grievance WHERE enquiry_status = 'P' AND paguthi_id = '$paguthi'";
			$grievance_pcount_res = $this->db->query($grievance_pcount);
			$grievance_pcount = $grievance_pcount_res->num_rows();
			
			$grievance_processcount = "SELECT * FROM grievance WHERE status = 'PROCESSING' AND paguthi_id = '$paguthi'";
			$grievance_processcount_res = $this->db->query($grievance_processcount);
			$grievance_processcount = $grievance_processcount_res->num_rows();
			
			$grievance_completecount = "SELECT * FROM grievance WHERE status = 'COMPLETED' AND paguthi_id = '$paguthi'";
			$grievance_completecount_res = $this->db->query($grievance_completecount);
			$grievance_completecount = $grievance_completecount_res->num_rows();
			
			$result  = array(
					"grievance_count" => $grievance_total_count,
					"enquiry_count" => $grievance_ecount,
					"petition_count" => $grievance_pcount,
					"processing_count" => $grievance_processcount,
					"completed_count" => $grievance_completecount
				);
				$response = array("status" => "Success", "msg" => "Grievances Details", "grievances_details" => $result);
		}
		return $response;
	}
	
	function Widgets_interactions($paguthi)
	{
		if ($paguthi == 'ALL') {

			$interactioncount = "SELECT * FROM interaction_history WHERE question_response = 'Y'";
			$interactioncount_res = $this->db->query($interactioncount);
			$interactioncount = $interactioncount_res->num_rows();
			
			$query="SELECT
						B.widgets_title,
						COUNT(question_id) AS tot_values
					FROM
						`interaction_history` A,
						interaction_question B
					WHERE
						A.`question_id` = B.id AND A.`question_response` = 'Y'
					GROUP BY
						`question_id`";
			$res=$this->db->query($query);
			$int_result=$res->result();
			
			$response = array("status" => "Success", "msg" => "Interaction Details", "interaction_count" => $interactioncount,"interaction_details" => $int_result);
		}else {
			
			$interactioncount = "SELECT
									ih.constituent_id,
									ih.question_id,
									ih.question_response
								FROM
									interaction_history AS ih
								LEFT JOIN constituent AS c
								ON
									c.id = ih.constituent_id
								WHERE
									c.paguthi_id = '$paguthi' AND ih.question_response = 'Y'";
			$interactioncount_res = $this->db->query($interactioncount);
			$interactioncount = $interactioncount_res->num_rows();
			
			$query="SELECT
					ih.question_response,
					iq.widgets_title,
					COUNT(ih.question_id) AS tot_values
					FROM
						interaction_history AS ih
					LEFT JOIN constituent AS c
					ON
						c.id = ih.constituent_id
					LEFT JOIN interaction_question AS iq
					ON
						ih.question_id = iq.id
					WHERE
						ih.question_response = 'Y' AND c.paguthi_id = '$paguthi'
					GROUP BY
						ih.question_id";
			$res=$this->db->query($query);
			$int_result=$res->result();
			
			
			$response = array("status" => "Success", "msg" => "Interaction Details", "interaction_count" => $interactioncount,"interaction_details" => $int_result);
		}
		return $response;
	}
	
	function Dashboard_search($keyword)
	{
		$query="SELECT
					c.id,
					c.full_name,
					c.mobile_no,
					c.serial_no,
					c.profile_pic,
					p.paguthi_name
				FROM
					constituent AS c
				LEFT JOIN paguthi AS p
				ON
					p.id = c.paguthi_id
				WHERE c.full_name LIKE '%$keyword%' OR father_husband_name LIKE '%$keyword%' OR guardian_name LIKE '%$keyword%' OR mobile_no LIKE '%$keyword%' OR whatsapp_no LIKE '%$keyword%' OR door_no LIKE '%$keyword%' OR address LIKE '%$keyword%' OR pin_code LIKE '%$keyword%' OR email_id LIKE '%$keyword%' OR voter_id_no LIKE '%$keyword%' OR aadhaar_no LIKE '%$keyword%' OR serial_no LIKE '%$keyword%'
				ORDER BY
					c.id
				DESC";
		$resultset=$this->db->query($query);
		$constituent_result = $resultset->result();
		if($resultset->num_rows()>0)
			{
				$response = array("status" => "Success", "msg" => "Search Result", "search_result" =>$constituent_result);
			} else {
				$response = array("status" => "Error", "msg" => "No records found");
			}
		return $response;
	}
	
//#################### Dashboard End ####################//


//#################### Constituent Start ####################//

	function List_constituent($paguthi)
	{
		if ($paguthi == 'ALL')
		{
			$constituent_count = "SELECT * FROM constituent";
			$constituent_count_res = $this->db->query($constituent_count);
			$constituent_count = $constituent_count_res->num_rows();
			
			$query="SELECT id,full_name,mobile_no,serial_no,profile_pic FROM constituent ORDER BY id DESC";
			$resultset=$this->db->query($query);
			$constituent_result = $resultset->result();
			if($resultset->num_rows()>0)
				{
					$response = array("status" => "Success", "msg" => "List constituent", "constituent_count" =>$constituent_count, "constituent_result" =>$constituent_result);
				} else {
					$response = array("status" => "Error", "msg" => "No records found");
				}
		} else {
			$constituent_count = "SELECT * FROM constituent WHERE paguthi_id = '$paguthi'";
			$constituent_count_res = $this->db->query($constituent_count);
			$constituent_count = $constituent_count_res->num_rows();
			
			$query="SELECT id,full_name,mobile_no,serial_no,profile_pic FROM constituent WHERE paguthi_id = '$paguthi' ORDER BY id DESC";
			$resultset=$this->db->query($query);
			$constituent_result = $resultset->result();
			if($resultset->num_rows()>0)
				{
					$response = array("status" => "Success", "msg" => "List constituent", "constituent_count" =>$constituent_count, "constituent_result" =>$constituent_result);
				} else {
					$response = array("status" => "Error", "msg" => "No records found");
				}
		}
		return $response;
	}
	
	
	function Constituent_details($constituent_id)
	{
		$query="SELECT
					cy.constituency_name,
					p.paguthi_name,
					wa.ward_name,
					bo.booth_name,
					bo.booth_address,
					re.religion_name,
					con.*
				FROM
					constituent AS con
				LEFT JOIN paguthi AS p
				ON
					p.id = con.paguthi_id
				LEFT JOIN constituency AS cy
				ON
					cy.id = con.constituency_id
				LEFT JOIN ward AS wa
				ON
					wa.id = con.ward_id
				LEFT JOIN booth AS bo
				ON
					bo.id = con.booth_id
				LEFT JOIN religion AS re
				ON
					con.religion_id = re.id
				WHERE
					con.id = '$constituent_id'";
		$resultset=$this->db->query($query);
		$constituent_result = $resultset->result();
		if($resultset->num_rows()>0)
			{
				$response = array("status" => "Success", "msg" => "Constituent Details", "constituent_details" =>$constituent_result);
			} else {
				$response = array("status" => "Error", "msg" => "No records found");
			}

		return $response;
	}
	
	function Constituent_meetings($constituent_id)
	{
			$query="SELECT * FROM meeting_request WHERE constituent_id = '$constituent_id' ORDER BY id DESC";
			$resultset=$this->db->query($query);
			$meeting_result = $resultset->result();
			if($resultset->num_rows()>0)
				{
					$response = array("status" => "Success", "msg" => "Constituent Meetings", "meeting_details" =>$meeting_result);
				} else {
					$response = array("status" => "Error", "msg" => "No records found");
				}
		return $response;
	}
	
	function Constituent_meetingdetails($meeting_id)
	{
			$query="SELECT * FROM meeting_request WHERE id = '$meeting_id'";
			$resultset=$this->db->query($query);
			$meeting_result = $resultset->result();
			if($resultset->num_rows()>0)
				{
					$response = array("status" => "Success", "msg" => "Meeting Details", "meeting_details" =>$meeting_result);
				} else {
					$response = array("status" => "Error", "msg" => "No records found");
				}
		return $response;
	}
	
	function Constituent_grievances($constituent_id)
	{
			$grievance_count = "SELECT * FROM grievance WHERE constituent_id = '$constituent_id'";
			$grievance_count_res = $this->db->query($grievance_count);
			$grievance_count = $grievance_count_res->num_rows();
			
			$query="SELECT
						gr.*,
						pa.paguthi_name,
						se.seeker_info,
						gt.grievance_name,
						gs.sub_category_name,
						pa.paguthi_name
					FROM
						grievance AS gr
					LEFT JOIN seeker_type AS se
					ON
						se.id = gr.seeker_type_id
					LEFT JOIN grievance_type AS gt
					ON
						gt.id = gr.grievance_type_id
					LEFT JOIN grievance_sub_category AS gs
					ON
						gs.id = gr.sub_category_id
					LEFT JOIN paguthi AS pa
					ON
						pa.id = gr.paguthi_id
					WHERE gr.constituent_id = '$constituent_id' ORDER BY gr.id DESC";
			$resultset=$this->db->query($query);
			$grievance_result = $resultset->result();
			if($resultset->num_rows()>0)
				{
					$response = array("status" => "Success", "msg" => "Constituent Grievances","grievance_count" =>$grievance_count, "grievance_details" =>$grievance_result);
				} else {
					$response = array("status" => "Error", "msg" => "No records found");
				}
		return $response;
	}
	
	function Constituent_grievancedetails($grievance_id)
	{
			$query="SELECT
						pa.paguthi_name,
						se.seeker_info,
						gt.grievance_name,
						gs.sub_category_name,
						pa.paguthi_name,
						gr.*
					FROM
						grievance AS gr
					LEFT JOIN seeker_type AS se
					ON
						se.id = gr.seeker_type_id
					LEFT JOIN grievance_type AS gt
					ON
						gt.id = gr.grievance_type_id
					LEFT JOIN grievance_sub_category AS gs
					ON
						gs.id = gr.sub_category_id
					LEFT JOIN paguthi AS pa
					ON
						pa.id = gr.paguthi_id
					WHERE gr.id = '$grievance_id' ORDER BY gr.id DESC";
			$resultset=$this->db->query($query);
			$grievance_result = $resultset->result();
			if($resultset->num_rows()>0)
				{
					$response = array("status" => "Success", "msg" => "Grievance Details", "grievance_details" =>$grievance_result);
				} else {
					$response = array("status" => "Error", "msg" => "No records found");
				}
		return $response;
	}
	
	function Grievance_message($grievance_id)
	{
			$query="SELECT
					gr.id,
					gr.sms_text,
					gr.created_at,
					u.full_name as created_by
				FROM
					grievance_reply AS gr
				LEFT JOIN user_master AS u
				ON
					u.id = gr.created_by
				WHERE gr.grievance_id = '$grievance_id' ";
			$resultset=$this->db->query($query);
			$message_result = $resultset->result();
			if($resultset->num_rows()>0)
				{
					$response = array("status" => "Success", "msg" => "Grievance Message Details", "message_details" =>$message_result);
				} else {
					$response = array("status" => "Error", "msg" => "No records found");
				}
		return $response;
	}
	
	
	function Constituent_interaction($constituent_id)
	{
			$query="SELECT * FROM `interaction_question` WHERE status = 'ACTIVE'";
			$resultset=$this->db->query($query);
			if($resultset->num_rows()>0) {
				foreach ($resultset->result() as $rows)
				{
				  $question_id = $rows->id;
				  $interaction_text = $rows->interaction_text;
				
					$query_1="SELECT * FROM `interaction_history` WHERE question_id = '$question_id' AND constituent_id = '$constituent_id'";
					$resultset_1=$this->db->query($query_1);
					if($resultset_1->num_rows()>0) {
						$status = 'Yes';
					}else {
						$status = 'No';
					}
				
					$interaction_details[]  = array(
						"interaction_question" => $question_id,
						"interaction_text" => $interaction_text,
						"status" => $status
					);
				}
					$response = array("status" => "Success", "msg" => "Interaction Details", "interaction_details" =>$interaction_details);
				} else {
					$response = array("status" => "Error", "msg" => "No records found");
				}
		return $response;
	}
	
	function Constituent_plant($constituent_id)
	{
		$query="SELECT * FROM `plant_donation` WHERE constituent_id='$constituent_id'";
		$resultset=$this->db->query($query);
		$plant_result = $resultset->result();
		if($resultset->num_rows()>0)
			{
				$response = array("status" => "Success", "msg" => "Plant Details", "plant_details" =>$plant_result);
			} else {
				$response = array("status" => "Error", "msg" => "No records found");
			}
		return $response;
	}
	
	function Constituent_documents($constituent_id)
	{
		$query="SELECT * FROM grievance_documents where constituent_id='$constituent_id' AND grievance_id ='' AND status='ACTIVE' order by id desc";
		$resultset=$this->db->query($query);
		$doc_result = $resultset->result();
			if($resultset->num_rows()>0)
			{
				$response = array("status" => "Success", "msg" => "List Documents", "constituent_documents" =>$doc_result);
			} else {
				$response = array("status" => "Error", "msg" => "No records found");
			}
		return $response;
	}
	
	function Constituent_grvdocuments($constituent_id)
	{
		$query="SELECT * FROM grievance_documents where constituent_id='$constituent_id' AND grievance_id !='' AND status='ACTIVE' order by id desc";
		$resultset=$this->db->query($query);
		$doc_result = $resultset->result();
			if($resultset->num_rows()>0)
			{
				$response = array("status" => "Success", "msg" => "List Documents", "constituent_documents" =>$doc_result);
			} else {
				$response = array("status" => "Error", "msg" => "No records found");
			}
		return $response;
	}
	
//#################### Constituent Start ####################//


//#################### Meetings Start ####################//

	function Meeting_request($constituency_id)
	{
		
		$meeting_count = "SELECT * FROM meeting_request WHERE meeting_status = 'REQUESTED'";
		$meeting_count_res = $this->db->query($meeting_count);
		$meeting_count = $meeting_count_res->num_rows();
			
		$query="SELECT
				mr.id,
				con.full_name,
				p.paguthi_name,
				mr.meeting_title,
				mr.meeting_date,
				mr.meeting_status,
				um.full_name as created_by
			FROM
				meeting_request AS mr
			LEFT JOIN constituent AS con
			ON
				con.id = mr.constituent_id
			LEFT JOIN paguthi AS p
			ON
			p.id = con.paguthi_id
			LEFT JOIN user_master AS um
			ON
			mr.created_by = um.id
			WHERE
				mr.meeting_status = 'REQUESTED' order by mr.id desc";
		$resultset=$this->db->query($query);
		$meeting_result = $resultset->result();
			if($resultset->num_rows()>0)
			{
				$response = array("status" => "Success", "msg" => "Meeting Request","meeting_count" =>$meeting_count, "meeting_details" =>$meeting_result);
			} else {
				$response = array("status" => "Error", "msg" => "No records found");
			}
		return $response;
	}


	function Meeting_details($meeting_id)
	{
		$query="SELECT
				mr.id,
				con.full_name,
				p.paguthi_name,
				mr.meeting_title,
				mr.meeting_detail,
				mr.meeting_date,
				mr.meeting_status,
				um.full_name as created_by
			FROM
				meeting_request AS mr
			LEFT JOIN constituent AS con
			ON
				con.id = mr.constituent_id
			LEFT JOIN paguthi AS p
			ON
			p.id = con.paguthi_id
			LEFT JOIN user_master AS um
			ON
			mr.created_by = um.id
			WHERE
				mr.id = '$meeting_id'";
		$resultset=$this->db->query($query);
		$meeting_result = $resultset->result();
			if($resultset->num_rows()>0)
			{
				$response = array("status" => "Success", "msg" => "Meeting Details", "meeting_details" =>$meeting_result);
			} else {
				$response = array("status" => "Error", "msg" => "No records found");
			}
		return $response;
	}


	function Meeting_update($user_id,$meeting_id,$status)
	{
		$sQuery="UPDATE meeting_request SET meeting_status='$status',updated_at=NOW(),updated_by='$user_id' where id='$meeting_id'";
		$update_Query = $this->db->query($sQuery);

		$response = array("status" => "Success", "msg" => "Meeting Updated");
		return $response;
	} 
	
//#################### Meetings End ####################//

	
//#################### Grievance Start ####################//
	function List_grievance($paguthi,$grievance_type)
	{
		if ($paguthi == 'ALL')	{
		
			if ($grievance_type == 'A'){
				
					$query="SELECT g.*,c.full_name,p.paguthi_name,st.seeker_info,gt.grievance_name,gsc.sub_category_name FROM grievance as g
						left join constituent as c on c.id=g.constituent_id
						left join paguthi as p on p.id=g.paguthi_id
						left join seeker_type as st on st.id=g.seeker_type_id
						left join grievance_type as gt on gt.id=g.grievance_type_id
						left join grievance_sub_category as gsc on gsc.id=g.sub_category_id
						order by g.id desc";
			} else if ($grievance_type == 'P') {
					$query="SELECT g.*,c.full_name,p.paguthi_name,st.seeker_info,gt.grievance_name,gsc.sub_category_name FROM grievance as g
						left join constituent as c on c.id=g.constituent_id
						left join paguthi as p on p.id=g.paguthi_id
						left join seeker_type as st on st.id=g.seeker_type_id
						left join grievance_type as gt on gt.id=g.grievance_type_id
						left join grievance_sub_category as gsc on gsc.id=g.sub_category_id where g.grievance_type='P'
						order by g.id desc";
			}else if ($grievance_type == 'E') {
			$query="SELECT g.*,c.full_name,p.paguthi_name,st.seeker_info,gt.grievance_name,gsc.sub_category_name FROM grievance as g
					left join constituent as c on c.id=g.constituent_id
					left join paguthi as p on p.id=g.paguthi_id
					left join seeker_type as st on st.id=g.seeker_type_id
					left join grievance_type as gt on gt.id=g.grievance_type_id
					left join grievance_sub_category as gsc on gsc.id=g.sub_category_id where g.grievance_type='E'
					order by g.id desc";
			} 
			$resultset=$this->db->query($query);
			$grievance_result = $resultset->result();
			$grievance_count = $resultset->num_rows();
			if($resultset->num_rows()>0)
			{
				$response = array("status" => "Success", "msg" => "List All Grievances", "grievance_count" =>$grievance_count, "list_grievances" =>$grievance_result);
			} else {
				$response = array("status" => "Error", "msg" => "No records found");
			}
			
		} else {
			
			if ($grievance_type == 'A'){
					$query="SELECT g.*,c.full_name,p.paguthi_name,st.seeker_info,gt.grievance_name,gsc.sub_category_name FROM grievance as g
						left join constituent as c on c.id=g.constituent_id
						left join paguthi as p on p.id=g.paguthi_id
						left join seeker_type as st on st.id=g.seeker_type_id
						left join grievance_type as gt on gt.id=g.grievance_type_id
						left join grievance_sub_category as gsc on gsc.id=g.sub_category_id where g.paguthi_id='$paguthi' 
						order by g.id desc";
			} else if ($grievance_type == 'P') {
					$query="SELECT g.*,c.full_name,p.paguthi_name,st.seeker_info,gt.grievance_name,gsc.sub_category_name FROM grievance as g
						left join constituent as c on c.id=g.constituent_id
						left join paguthi as p on p.id=g.paguthi_id
						left join seeker_type as st on st.id=g.seeker_type_id
						left join grievance_type as gt on gt.id=g.grievance_type_id
						left join grievance_sub_category as gsc on gsc.id=g.sub_category_id where g.paguthi_id='$paguthi' AND g.grievance_type='P'
						order by g.id desc";
			}else if ($grievance_type == 'E') {
			$query="SELECT g.*,c.full_name,p.paguthi_name,st.seeker_info,gt.grievance_name,gsc.sub_category_name FROM grievance as g
					left join constituent as c on c.id=g.constituent_id
					left join paguthi as p on p.id=g.paguthi_id
					left join seeker_type as st on st.id=g.seeker_type_id
					left join grievance_type as gt on gt.id=g.grievance_type_id
					left join grievance_sub_category as gsc on gsc.id=g.sub_category_id where g.paguthi_id='$paguthi' AND g.grievance_type='E'
					order by g.id desc";
			} 
			$resultset=$this->db->query($query);
			$grievance_result = $resultset->result();
			$grievance_count = $resultset->num_rows();
			if($resultset->num_rows()>0)
			{
				$response = array("status" => "Success", "msg" => "List All Grievances", "grievance_count" =>$grievance_count, "list_grievances" =>$grievance_result);
			} else {
				$response = array("status" => "Error", "msg" => "No records found");
			}
			
		}
		return $response;
	}
	
//#################### Grievance End ####################//

//#################### New Grievance list Start ####################//
	function List_grievancenew($paguthi,$grievance_type,$offset,$rowcount)
	{
		if ($paguthi == 'ALL')	{
		
			if ($grievance_type == 'A'){
				
					$query="SELECT g.*,c.full_name,p.paguthi_name,st.seeker_info,gt.grievance_name,gsc.sub_category_name FROM grievance as g
						left join constituent as c on c.id=g.constituent_id
						left join paguthi as p on p.id=g.paguthi_id
						left join seeker_type as st on st.id=g.seeker_type_id
						left join grievance_type as gt on gt.id=g.grievance_type_id
						left join grievance_sub_category as gsc on gsc.id=g.sub_category_id
						order by g.id desc LIMIT $offset, $rowcount";
			} else if ($grievance_type == 'P') {
					$query="SELECT g.*,c.full_name,p.paguthi_name,st.seeker_info,gt.grievance_name,gsc.sub_category_name FROM grievance as g
						left join constituent as c on c.id=g.constituent_id
						left join paguthi as p on p.id=g.paguthi_id
						left join seeker_type as st on st.id=g.seeker_type_id
						left join grievance_type as gt on gt.id=g.grievance_type_id
						left join grievance_sub_category as gsc on gsc.id=g.sub_category_id where g.grievance_type='P'
						order by g.id desc LIMIT $offset, $rowcount";
			}else if ($grievance_type == 'E') {
			$query="SELECT g.*,c.full_name,p.paguthi_name,st.seeker_info,gt.grievance_name,gsc.sub_category_name FROM grievance as g
					left join constituent as c on c.id=g.constituent_id
					left join paguthi as p on p.id=g.paguthi_id
					left join seeker_type as st on st.id=g.seeker_type_id
					left join grievance_type as gt on gt.id=g.grievance_type_id
					left join grievance_sub_category as gsc on gsc.id=g.sub_category_id where g.grievance_type='E'
					order by g.id desc LIMIT $offset, $rowcount";
			} 
			$resultset=$this->db->query($query);
			$grievance_result = $resultset->result();
			$grievance_count = $resultset->num_rows();
			if($resultset->num_rows()>0)
			{
				$response = array("status" => "Success", "msg" => "List All Grievances", "grievance_count" =>$grievance_count, "list_grievances" =>$grievance_result);
			} else {
				$response = array("status" => "Error", "msg" => "No records found");
			}
			
		} else {
			
			if ($grievance_type == 'A'){
					$query="SELECT g.*,c.full_name,p.paguthi_name,st.seeker_info,gt.grievance_name,gsc.sub_category_name FROM grievance as g
						left join constituent as c on c.id=g.constituent_id
						left join paguthi as p on p.id=g.paguthi_id
						left join seeker_type as st on st.id=g.seeker_type_id
						left join grievance_type as gt on gt.id=g.grievance_type_id
						left join grievance_sub_category as gsc on gsc.id=g.sub_category_id where g.paguthi_id='$paguthi' 
						order by g.id desc LIMIT $offset, $rowcount";
			} else if ($grievance_type == 'P') {
					$query="SELECT g.*,c.full_name,p.paguthi_name,st.seeker_info,gt.grievance_name,gsc.sub_category_name FROM grievance as g
						left join constituent as c on c.id=g.constituent_id
						left join paguthi as p on p.id=g.paguthi_id
						left join seeker_type as st on st.id=g.seeker_type_id
						left join grievance_type as gt on gt.id=g.grievance_type_id
						left join grievance_sub_category as gsc on gsc.id=g.sub_category_id where g.paguthi_id='$paguthi' AND g.grievance_type='P'
						order by g.id desc LIMIT $offset, $rowcount";
			}else if ($grievance_type == 'E') {
			$query="SELECT g.*,c.full_name,p.paguthi_name,st.seeker_info,gt.grievance_name,gsc.sub_category_name FROM grievance as g
					left join constituent as c on c.id=g.constituent_id
					left join paguthi as p on p.id=g.paguthi_id
					left join seeker_type as st on st.id=g.seeker_type_id
					left join grievance_type as gt on gt.id=g.grievance_type_id
					left join grievance_sub_category as gsc on gsc.id=g.sub_category_id where g.paguthi_id='$paguthi' AND g.grievance_type='E'
					order by g.id desc LIMIT $offset, $rowcount";
			} 
			$resultset=$this->db->query($query);
			$grievance_result = $resultset->result();
			$grievance_count = $resultset->num_rows();
			if($resultset->num_rows()>0)
			{
				$response = array("status" => "Success", "msg" => "List All Grievances", "grievance_count" =>$grievance_count, "list_grievances" =>$grievance_result);
			} else {
				$response = array("status" => "Error", "msg" => "No records found");
			}
			
		}
		return $response;
	}
	
//#################### New Grievance list End ####################//


//#################### Staff Details ####################//
	function List_staff()
	{
		$staff_count = "SELECT * FROM user_master WHERE id!='1'";
		$staff_count_res = $this->db->query($staff_count);
		$staff_count = $staff_count_res->num_rows();
			
		$query="SELECT
				A.id
				A.full_name,
				A.phone_number,
				A.email_id,
				A.profile_pic,
				A.status,
				B.paguthi_name
			FROM
				user_master A,
				paguthi B
			WHERE
				A.id!='1' AND A.pugathi_id = B.id";
		$resultset=$this->db->query($query);
		$user_result = $resultset->result();
		if($resultset->num_rows()>0)
			{
				$response = array("status" => "Success", "msg" => "List Staff", "staff_count" =>$staff_count, "staff_details" =>$user_result);
			} else {
				$response = array("status" => "Error", "msg" => "No records found");
			}
		return $response;
	}
	
	function Staff_details($staff_id)
	{
		$query="SELECT
				B.paguthi_name,
				C.role_name,
				A.*
			FROM
				user_master A,
				paguthi B,
				role_master C
			WHERE
				A.id = '$staff_id' AND A.pugathi_id = B.id AND A.role_id = C.id";
		$resultset=$this->db->query($query);
		$user_result = $resultset->result();
		if($resultset->num_rows()>0)
			{
				$response = array("status" => "Success", "msg" => "Staff Details", "staff_details" =>$user_result);
			} else {
				$response = array("status" => "Error", "msg" => "No records found");
			}
		return $response;
	}
//#################### Staff Details End ####################//


//#################### Reports ####################//	

	function Report_status($from_date,$to_date,$status,$paguthi){

		$dateTime1 = new DateTime($from_date);
		$from_date=date_format($dateTime1,'Y-m-d' );
		
		$dateTime2 = new DateTime($to_date);
		$to_date=date_format($dateTime2,'Y-m-d' );
		
		if ($status=='ALL' && $paguthi == 'ALL')
		{
			
			
			$query="SELECT
						A.id,
						F.paguthi_name,
						A.petition_enquiry_no,
						A.grievance_date,
						A.status,
						B.full_name,
						B.mobile_no,
						C.full_name AS created_by,
						D.grievance_name,
						E.role_name
					FROM
						grievance A,
						constituent B,
						user_master C,
						grievance_type D,
						role_master E,
						paguthi F
					WHERE
						A.constituent_id = B.id AND A.created_by = C.id AND A.grievance_type_id = D.id AND C.role_id = E.id AND A.paguthi_id = F.id AND (`grievance_date` BETWEEN '$from_date' AND '$to_date') ORDER BY A.`grievance_date` DESC";
		}
		if ($status=='ALL' && $paguthi != 'ALL')
		{
			$query="SELECT
						A.id,
						F.paguthi_name,
						A.petition_enquiry_no,
						A.grievance_date,
						A.status,
						B.full_name,
						B.mobile_no,
						C.full_name AS created_by,
						D.grievance_name,
						E.role_name
					FROM
						grievance A,
						constituent B,
						user_master C,
						grievance_type D,
						role_master E,
						paguthi F
					WHERE
						A.constituent_id = B.id AND A.created_by = C.id AND A.grievance_type_id = D.id AND C.role_id = E.id AND A.paguthi_id = F.id AND A.paguthi_id = '$paguthi' AND (`grievance_date` BETWEEN '$from_date' AND '$to_date') ORDER BY A.`grievance_date` DESC";
		}
		if ($status!='ALL' && $paguthi == 'ALL')
		{
			$query="SELECT
						A.id,
						F.paguthi_name,
						A.petition_enquiry_no,
						A.grievance_date,
						A.status,
						B.full_name,
						B.mobile_no,
						C.full_name AS created_by,
						D.grievance_name,
						E.role_name
					FROM
						grievance A,
						constituent B,
						user_master C,
						grievance_type D,
						role_master E,
						paguthi F
					WHERE
						A.constituent_id = B.id AND A.created_by = C.id AND A.grievance_type_id = D.id AND C.role_id = E.id AND A.paguthi_id = F.id AND A.status = '$status' AND (`grievance_date` BETWEEN '$from_date' AND '$to_date') ORDER BY A.`grievance_date` DESC";
		}
		if ($status!='ALL' && $paguthi != 'ALL')
		{
			$query="SELECT
						A.id,
						F.paguthi_name,
						A.petition_enquiry_no,
						A.grievance_date,
						A.status,
						B.full_name,
						B.mobile_no,
						C.full_name AS created_by,
						D.grievance_name,
						E.role_name
					FROM
						grievance A,
						constituent B,
						user_master C,
						grievance_type D,
						role_master E,
						paguthi F
					WHERE
						A.constituent_id = B.id AND A.created_by = C.id AND A.grievance_type_id = D.id AND C.role_id = E.id AND A.paguthi_id = F.id AND A.status = '$status' AND A.paguthi_id = '$paguthi' AND (`grievance_date` BETWEEN '$from_date' AND '$to_date') ORDER BY A.`grievance_date` DESC";
		}
		$resultset=$this->db->query($query);
		$result_count = $resultset->num_rows();
		$report_result = $resultset->result();
		if($resultset->num_rows()>0)
			{
				$response = array("status" => "Success", "msg" => "Status based report","result_count" =>$result_count,"status_report" =>$report_result);
			} else {
				$response = array("status" => "Error", "msg" => "No records found");
			}
			
		return $response;
	}
	
	function Report_category($from_date,$to_date,$category){

		$dateTime1 = new DateTime($from_date);
		$from_date=date_format($dateTime1,'Y-m-d' );
		
		$dateTime2 = new DateTime($to_date);
		$to_date=date_format($dateTime2,'Y-m-d' );
		
		if ($category=='ALL')
		{
			$query="SELECT
						A.id,
						F.paguthi_name,
						A.petition_enquiry_no,
						A.grievance_date,
						A.status,
						B.full_name,
						B.mobile_no,
						C.full_name AS created_by,
						D.grievance_name,
						E.role_name
					FROM
						grievance A,
						constituent B,
						user_master C,
						grievance_type D,
						role_master E,
						paguthi F
					WHERE
						A.constituent_id = B.id AND A.created_by = C.id AND A.grievance_type_id = D.id AND C.role_id = E.id AND A.paguthi_id = F.id AND (`grievance_date` BETWEEN '$from_date' AND '$to_date') ORDER BY A.`grievance_date` DESC";
		}
		if ($category != 'ALL')
		{
			$query="SELECT
						A.id,
						F.paguthi_name,
						A.petition_enquiry_no,
						A.grievance_date,
						A.status,
						B.full_name,
						B.mobile_no,
						C.full_name AS created_by,
						D.grievance_name,
						E.role_name
					FROM
						grievance A,
						constituent B,
						user_master C,
						grievance_type D,
						role_master E,
						paguthi F
					WHERE
						A.constituent_id = B.id AND A.created_by = C.id AND A.grievance_type_id = D.id AND C.role_id = E.id AND A.paguthi_id = F.id AND A.grievance_type_id = '$category' AND (`grievance_date` BETWEEN '$from_date' AND '$to_date') ORDER BY A.`grievance_date` DESC";
		}
		
		$resultset=$this->db->query($query);
		$result_count = $resultset->num_rows();
		$report_result = $resultset->result();
		
		if($resultset->num_rows()>0)
			{
				$response = array("status" => "Success", "msg" => "Category based report","result_count" =>$result_count,"category_report" =>$report_result);
			} else {
				$response = array("status" => "Error", "msg" => "No records found");
			}
	
		return $response;
	}
	
	function Report_subcategory($from_date,$to_date,$sub_category){

		$dateTime1 = new DateTime($from_date);
		$from_date=date_format($dateTime1,'Y-m-d' );
		
		$dateTime2 = new DateTime($to_date);
		$to_date=date_format($dateTime2,'Y-m-d' );
		
		if ($sub_category=='ALL')
		{
			$query="SELECT
						A.id,
						F.paguthi_name,
						A.petition_enquiry_no,
						A.grievance_date,
						A.status,
						B.full_name,
						B.mobile_no,
						C.full_name AS created_by,
						D.sub_category_name,
						E.role_name
					FROM
						grievance A,
						constituent B,
						user_master C,
						grievance_sub_category D,
						role_master E,
						paguthi F
					WHERE
						A.constituent_id = B.id AND A.created_by = C.id AND A.sub_category_id = D.id AND C.role_id = E.id AND A.paguthi_id = F.id AND (`grievance_date` BETWEEN '$from_date' AND '$to_date') ORDER BY A.`grievance_date` DESC";
		}
		if ($sub_category != 'ALL')
		{
			$query="SELECT
						A.id,
						F.paguthi_name,
						A.petition_enquiry_no,
						A.grievance_date,
						A.status,
						B.full_name,
						B.mobile_no,
						C.full_name AS created_by,
						D.sub_category_name,
						E.role_name
					FROM
						grievance A,
						constituent B,
						user_master C,
						grievance_sub_category D,
						role_master E,
						paguthi F
					WHERE
						A.constituent_id = B.id AND A.created_by = C.id AND A.sub_category_id = D.id AND C.role_id = E.id AND A.paguthi_id = F.id AND A.sub_category_id = '$sub_category' AND (`grievance_date` BETWEEN '$from_date' AND '$to_date') ORDER BY A.`grievance_date` DESC";
		}
		$resultset=$this->db->query($query);
		$result_count = $resultset->num_rows();
		$report_result = $resultset->result();
		
		if($resultset->num_rows()>0)
			{
				$response = array("status" => "Success", "msg" => "Sub Category based report","result_count" =>$result_count,"subcategory_report" =>$report_result);
			} else {
				$response = array("status" => "Error", "msg" => "No records found");
			}
		
		return $response;
	}
	
	function Report_location($from_date,$to_date,$paguthi){

		$dateTime1 = new DateTime($from_date);
		$from_date=date_format($dateTime1,'Y-m-d' );
		
		$dateTime2 = new DateTime($to_date);
		$to_date=date_format($dateTime2,'Y-m-d' );
		
		if ($paguthi=='ALL')
		{
			$query="SELECT
					A.id,
					F.paguthi_name,
					A.petition_enquiry_no,
					A.grievance_date,
					A.status,
					B.full_name,
					B.mobile_no,
					C.full_name AS created_by,
					D.grievance_name,
					E.role_name
				FROM
					grievance A,
					constituent B,
					user_master C,
					grievance_type D,
					role_master E,
					paguthi F
				WHERE
					A.constituent_id = B.id AND A.created_by = C.id AND A.grievance_type_id = D.id AND C.role_id = E.id AND A.paguthi_id = F.id AND (`grievance_date` BETWEEN '$from_date' AND '$to_date') ORDER BY A.`grievance_date` DESC";
		}
		if ($paguthi != 'ALL')
		{
			$query="SELECT
					A.id,
					F.paguthi_name,
					A.petition_enquiry_no,
					A.grievance_date,
					A.status,
					B.full_name,
					B.mobile_no,
					C.full_name AS created_by,
					D.grievance_name
				FROM
					grievance A,
					constituent B,
					user_master C,
					grievance_type D,
					role_master E,
					paguthi F
				WHERE
					A.constituent_id = B.id AND A.created_by = C.id AND A.grievance_type_id = D.id AND C.role_id = E.id AND A.paguthi_id = F.id AND A.paguthi_id = '$paguthi' AND (`grievance_date` BETWEEN '$from_date' AND '$to_date') ORDER BY A.`grievance_date` DESC";
		}
		
		$resultset=$this->db->query($query);
		$result_count = $resultset->num_rows();
		$report_result = $resultset->result();
		
		if($resultset->num_rows()>0)
		{
			$response = array("status" => "Success", "msg" => "Location based report","result_count" =>$result_count,"location_report" =>$report_result);
		} else {
			$response = array("status" => "Error", "msg" => "No records found");
		}
			
		return $response;
	}
	
	
	function Report_meetings($from_date,$to_date){

		$dateTime1 = new DateTime($from_date);
		$from_date=date_format($dateTime1,'Y-m-d' );
		
		$dateTime2 = new DateTime($to_date);
		$to_date=date_format($dateTime2,'Y-m-d' );
		
		$query="SELECT
						B.full_name,
						A.meeting_date,
						A.meeting_title,
						A.meeting_status,
						C.full_name AS created_by,
						D.paguthi_name
					FROM
						meeting_request A,
						constituent B,
						user_master C,
						paguthi D
					WHERE
						A.constituent_id = B.id AND A.created_by = C.id AND B.paguthi_id = D.id AND(
							A.meeting_date BETWEEN '$from_date' AND '$to_date'
						)
					ORDER BY
						A.meeting_date
					DESC";
		$resultset=$this->db->query($query);
		$result_count = $resultset->num_rows();
		$report_result = $resultset->result();
		
		if($resultset->num_rows()>0)
		{
			$response = array("status" => "Success", "msg" => "Meetings report","result_count" =>$result_count,"meetings_report" =>$report_result);
		} else {
			$response = array("status" => "Error", "msg" => "No records found");
		}
		
		
		return $response;
	}
	
	
	function Report_staff($from_date,$to_date){

		$dateTime1 = new DateTime($from_date);
		$from_date=date_format($dateTime1,'Y-m-d' );
		
		$dateTime2 = new DateTime($to_date);
		$to_date=date_format($dateTime2,'Y-m-d' );
		
		$query="SELECT
				um.id,
				um.full_name,
				COUNT(ct.created_by) AS total,
				COUNT( CASE WHEN ct.status = 'ACTIVE' THEN 1 END ) AS active,
				COUNT( CASE WHEN ct.status = 'INACTIVE' THEN 1 END ) AS inactive
				FROM constituent AS	ct
				LEFT JOIN user_master AS um ON um.id = ct.created_by
				WHERE DATE(ct.created_at) BETWEEN '$from_date' AND '$to_date' GROUP BY ct.created_by";
		$resultset=$this->db->query($query);
		$result_count = $resultset->num_rows();
		$report_result = $resultset->result();
		
		if($resultset->num_rows()>0)
		{
			$response = array("status" => "Success", "msg" => "Staff report","result_count" =>$result_count,"staff_report" =>$report_result);
		} else {
			$response = array("status" => "Error", "msg" => "No records found");
		}
		
		return $response;
	}
	
	function Report_birthday($selMonth){

		$year = date("Y"); 
		$query="SELECT * FROM constituent WHERE MONTH(dob) = '$selMonth'";
		$resultset=$this->db->query($query);
		$result_count = $resultset->num_rows();
		if($resultset->num_rows()>0){
			foreach ($resultset->result() as $rows)
			{
				$const_id = $rows->id;
				$full_name = $rows->full_name;
				$dob = $rows->dob;
				$mobile_no = $rows->mobile_no;
				$door_no = $rows->door_no;
				$address = $rows->address;
				$pin_code = $rows->pin_code;
				
				$subQuery = "SELECT * FROM consitutent_birthday_wish WHERE YEAR(created_at)='$year' AND constituent_id = '$const_id'";
				$subQuery_result = $this->db->query($subQuery);
				if($subQuery_result->num_rows()>0){
					foreach ($subQuery_result->result() as $rows1)
					{
						$birth_id = $rows1->constituent_id;
					}
				}else{
					$birth_id = '';
				}
				
				if ($const_id == $birth_id){
					 $birth_wish = 'Send';
				} else {
					 $birth_wish = 'NotSend';
				}
				$contData[]  = (object) array(
						"const_id" => $const_id,
						"full_name" => $full_name,
						"dob" => $dob,
						"mobile_no" => $mobile_no,
						"door_no" => $door_no,
						"address" => $address,
						"pin_code" => $pin_code,
						"birth_wish_status" => $birth_wish,
				);
			} 
			
			$response = array("status" => "Success", "msg" => "Birthday report","result_count" =>$result_count,"birthday_report" =>$contData);
		}else {
			$response = array("status" => "Error", "msg" => "No records found");
		}
		return $response;
	}
	
//#################### Reports End ####################//	
} 

?>
