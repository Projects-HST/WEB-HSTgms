<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Apiandroidmodel extends CI_Model {

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
			
				$update = "UPDATE user_master SET full_name='$name',gender='$gender',address='$address',email_id='$email',updated_at=NOW(),updated_by='$user_id' WHERE id='$user_id'";
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
				$update = "UPDATE user_master SET full_name='$name',gender='$gender',address='$address',updated_at=NOW(),updated_by='$user_id' WHERE id='$user_id'";
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
					$update = "UPDATE user_master SET full_name='$name',gender='$gender',address='$address',updated_at=NOW(),updated_by='$user_id' WHERE id='$user_id'";
					$result = $this->db->query($update);
				}
		}
		
		if ($email =="" && $phone =="")
		{
			 $update = "UPDATE user_master SET full_name='$name',gender='$gender',address='$address',updated_at=NOW(),updated_by='$user_id' WHERE id='$user_id'";
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

	function Dashboard($paguthi_id,$from_date,$to_date)
	{
		if($paguthi_id=='ALL' || empty($paguthi_id)){
			$quer_paguthi="";
		}else{
			$quer_paguthi="WHERE paguthi_id='$paguthi_id'";
		} 	

		if($paguthi_id=='ALL' || empty($paguthi_id)){
			$quer_paguthi_video="";
		}else{
			$quer_paguthi_video="AND c.paguthi_id='$paguthi_id'";
		}
		
		
	 	if($paguthi_id=='99'){
			$cons_id='99';
			$others_id='0';
			$query_paguthi='';
			$query_cons="AND constituency_id='0'";
		}else{
			$cons_id='1';
			$others_id='0';
			$query_cons="";
			if($paguthi_id=='ALL' || empty($paguthi_id)){
				$query_paguthi="";
			}else{
				$query_paguthi="AND paguthi_id='$paguthi_id'";
			}
		}
		
		if(empty($from_date)){
			$quer_date="";
		}else{
			$dateTime1 = new DateTime($from_date);
			$one_date=date_format($dateTime1,'Y-m-d' );

			$dateTime2 = new DateTime($to_date);
			$two_date=date_format($dateTime2,'Y-m-d' );

			if($paguthi_id==''){
				$quer_date="WHERE DATE(created_at) BETWEEN '$one_date' and '$two_date'";
			}else{
				$quer_date="AND DATE(created_at) BETWEEN '$one_date' and '$two_date'";
			}
		}
		
		if(empty($from_date)){
			$query_date="";
		}else{
			$dateTime1 = new DateTime($from_date);
			$one_date=date_format($dateTime1,'Y-m-d' );
			
			$dateTime2 = new DateTime($to_date);
			$two_date=date_format($dateTime2,'Y-m-d' );
			$query_date="AND DATE(grievance_date) BETWEEN '$one_date' and '$two_date'";
		} 
		
		
		if(empty($from_date)){
			$quer_mr_date="";
			$quer_bw_date="";
			$quer_cv_date="";
			$quer_fw_date="";
		}else{
			$dateTime1 = new DateTime($from_date);
			$one_date=date_format($dateTime1,'Y-m-d' );

			$dateTime2 = new DateTime($to_date);
			$two_date=date_format($dateTime2,'Y-m-d' );

			if(empty($paguthi_id)){
				$quer_mr_date="WHERE DATE(mr.created_at) BETWEEN '$one_date' and '$two_date'";
			}else{
				$quer_mr_date="AND DATE(mr.created_at) BETWEEN '$one_date' and '$two_date'";
			}
			
			if(empty($paguthi_id)){
				$quer_bw_date="WHERE DATE(br.created_at) BETWEEN '$one_date' and '$two_date'";
			}else{
				$quer_bw_date="AND DATE(br.created_at) BETWEEN '$one_date' and '$two_date'";
			}

			if(empty($paguthi_id)){
				$quer_fw_date="WHERE DATE(fw.updated_at) BETWEEN '$one_date' and '$two_date'";
			}else{
				$quer_fw_date="AND DATE(fw.updated_at) BETWEEN '$one_date' and '$two_date'";
			}
			if(empty($paguthi_id)){
				$quer_cv_date="AND DATE(cv.updated_at) BETWEEN '$one_date' and '$two_date'";
			}else{
				$quer_cv_date="AND DATE(cv.updated_at) BETWEEN '$one_date' and '$two_date'";
			}
		}
			
			$constituent_count = "SELECT * FROM constituent $quer_paguthi $quer_date";
			$constituent_count_res = $this->db->query($constituent_count);
			$constituent_count = $constituent_count_res->num_rows(); 
			
//------------------------------------------------//
			$enquiry_count = "SELECT * FROM grievance WHERE grievance_type='E' AND enquiry_status = 'E' $query_paguthi $query_date";
			$enquiry_count_res = $this->db->query($enquiry_count);
			$enquiry_count = $enquiry_count_res->num_rows(); 
			
			$petition_count = "SELECT * FROM grievance WHERE grievance_type='P' $query_paguthi $query_date";
			$petition_count_res = $this->db->query($petition_count);
			$petition_count = $petition_count_res->num_rows(); 
			
			$grievance_count = $enquiry_count + $petition_count;

//------------------------------------------------//

			$query_3="SELECT * from grievance as g where g.repeated_status ='N' $query_cons $query_paguthi $query_date GROUP BY g.constituent_id, g.grievance_date";
			$result_3=$this->db->query($query_3);
			$footfall_unique_cnt = $result_3->num_rows();
			
			$query_4="SELECT * from grievance as g where g.repeated_status ='R' $query_cons $query_paguthi $query_date GROUP BY g.constituent_id, g.grievance_date";
			$result_4=$this->db->query($query_4);
			$footfall_repeated_cnt = $result_4->num_rows();
			
			$footfall_count = $footfall_unique_cnt + $footfall_repeated_cnt;

//------------------------------------------------//
			
			$query_5="SELECT * FROM meeting_request AS mr LEFT JOIN constituent AS c ON c.id = mr.constituent_id $quer_paguthi $quer_mr_date";
			$result_5=$this->db->query($query_5);
			$meeting_count = $result_5->num_rows();
			
//------------------------------------------------//	
		
			$volunter_count = "SELECT * FROM constituent WHERE volunteer_status='Y' AND constituency_id ='1'";
			$volunter_count_res = $this->db->query($volunter_count);
			$volunter_count = $volunter_count_res->num_rows(); 

			$non_volunter_count = "SELECT * FROM constituent WHERE volunteer_status='Y' AND constituency_id ='0'";
			$non_volunter_count_res = $this->db->query($non_volunter_count);
			$non_volunter_count = $non_volunter_count_res->num_rows(); 
			
			$tot_volunter_count = $volunter_count+$non_volunter_count;

//------------------------------------------------//
			
			$br_wish_count="SELECT * FROM consitutent_birthday_wish as br left join constituent as c on c.id=br.constituent_id $quer_paguthi $quer_bw_date";
			$br_wish_count_res =$this->db->query($br_wish_count);
			$br_wish_count = $br_wish_count_res->num_rows(); 
			
			$fn_wish_count="SELECT * from festival_wishes as fw left join constituent as c on c.id=fw.constituent_id $quer_paguthi $quer_fw_date";
			$fn_wish_count_res = $this->db->query($fn_wish_count);
			$fn_wish_count = $fn_wish_count_res->num_rows();
			
			$tot_geeting_count = $br_wish_count+$fn_wish_count;

//------------------------------------------------//
			
			$video_count="SELECT p.paguthi_name,o.office_name,COUNT(cv.id) as cnt_video from office as o
			left join paguthi as p on p.id=o.paguthi_id
			left join constituent as c on c.office_id=o.id $quer_paguthi_video
			left join constituent_video as cv on cv.constituent_id=c.id $quer_cv_date
			GROUP BY o.id";
			$video_count_res=$this->db->query($video_count);
			$video_count=$video_count_res->result();
			$tot_video_count = 0;
			foreach($video_count as $row_video_count){
			  $tot_video_count += $row_video_count->cnt_video;
			}
			
			
			$result  = array(
					"constituent_count" => $constituent_count,
					"grievance_count" => $grievance_count,
					"footfall_count" => $footfall_count,
					"meeting_count" => $meeting_count,
					"volunter_count" => $tot_volunter_count,
					"geeting_count" => $tot_geeting_count,
					"video_count" => $tot_video_count
				);
				
//------------------------------------------------//
				
			if($paguthi_id=='ALL' || empty($paguthi_id)){
				$graph_quer_paguthi="";
			}else{
				$graph_quer_paguthi="AND g.paguthi_id='$paguthi_id'";
			}

			if($paguthi_id==' '){
					$graph_date="WHERE g.grievance_date >= CURDATE() - INTERVAL 1 MONTH";
			}else{
				if(empty($from_date)){
					$graph_date="WHERE g.grievance_date >= CURDATE() - INTERVAL 1 MONTH";
				}else{
					$dateTime1 = new DateTime($from_date);
					$one_date=date_format($dateTime1,'Y-m-d' );

					$dateTime2 = new DateTime($to_date);
					$two_date=date_format($dateTime2,'Y-m-d' );
					$graph_date="WHERE DATE(g.grievance_date) BETWEEN '$one_date' and '$two_date'";

				}
			}
			
			$graph_query = "SELECT IFNULL(DATE_FORMAT(g.grievance_date,'%d-%b'),'0') as day_name,
			IFNULL(sum(case when g.repeated_status = 'N' then 1 else 0 end),'0') AS unique_count,
			IFNULL(sum(case when g.repeated_status = 'R' then 1 else 0 end),'0') AS repeat_count,
			IFNULL(sum(case when g.repeated_status = 'R' then 1 else 0 end),'0') + IFNULL(sum(case when g.repeated_status = 'N' then 1 else 0 end),'0') as total
			FROM grievance as g
			left join constituent as c on c.id=g.constituent_id $graph_date $graph_quer_paguthi group by g.grievance_date order by g.grievance_date asc ";

			$graph_query_res=$this->db->query($graph_query);
			$graph_result=$graph_query_res->result();

			$response = array("status" => "Success", "msg" => "Dashboard Details", "widgets_count" => $result, "graph_result" => $graph_result);
			
			return $response;
		}


	function widgets_members($paguthi_id,$from_date,$to_date)
	{
		
		if($paguthi_id=='ALL' || empty($paguthi_id)){
			$quer_paguthi="";
		}else{
			$quer_paguthi="WHERE paguthi_id='$paguthi_id'";
		} 	
				
		if(empty($from_date)){
			$quer_date="";
		}else{
			$dateTime1 = new DateTime($from_date);
			$one_date=date_format($dateTime1,'Y-m-d' );

			$dateTime2 = new DateTime($to_date);
			$two_date=date_format($dateTime2,'Y-m-d' );

			if($paguthi_id==''){
				$quer_date="WHERE DATE(created_at) BETWEEN '$one_date' and '$two_date'";
			}else{
				$quer_date="AND DATE(created_at) BETWEEN '$one_date' and '$two_date'";
			}
		}
		
		$query="SELECT
			IFNULL(count(*),'0') AS total,
			IFNULL(sum(case when gender = 'M' then 1 else 0 end),'0') AS malecount,
			IFNULL(sum(case when gender = 'M' then 1 else 0 end) / count(*) * 100,'0') as malepercenatge,
			IFNULL(sum(case when gender = 'F' then 1 else 0 end),'0') AS femalecount,
			IFNULL(sum(case when gender = 'F' then 1 else 0 end) / count(*) * 100,'0') as femalepercenatge,
			IFNULL(sum(case when gender = 'T' then 1 else 0 end),'0') AS others,
			IFNULL(sum(case when gender = 'T' then 1 else 0 end) / count(*) * 100,'0') as otherpercenatge,
			IFNULL(sum(case when voter_id_status = 'Y' then gender='M' else 0 end),'0') AS malevoter,
			IFNULL(sum(case when voter_id_status = 'Y' then gender='M' else 0 end) / count(*) * 100,'0') as malevoter_percentage,
			IFNULL(sum(case when voter_id_status = 'Y' then gender='F' else 0 end),'0') AS femalevoter,
			IFNULL(sum(case when voter_id_status = 'Y' then gender='F' else 0 end) / count(*) * 100,'0') as femalevoter_percentage,
			IFNULL(sum(case when aadhaar_status = 'Y' then gender='M' else 0 end),'0') AS maleaadhar,
			IFNULL(sum(case when aadhaar_status = 'Y' then gender='M' else 0 end) / count(*) * 100,'0') as maleaadhaar_percentage,
			IFNULL(sum(case when aadhaar_status = 'Y' then gender='F' else 0 end),'0') AS femaleaadhar,
			IFNULL(sum(case when aadhaar_status = 'Y' then gender='F' else 0 end) / count(*) * 100,'0') as femaleaadhaar_percentage,
			IFNULL(sum(case when mobile_no != '' then 1 else 0 end),'0') AS having_mobilenumber,
			IFNULL(sum(case when mobile_no != '' then 1 else 0 end) / count(*) * 100,'0') as mobile_percentage,
			IFNULL(sum(case when email_id != '' then 1 else 0 end),'0') AS having_email,
			IFNULL(sum(case when email_id != '' then 1 else 0 end) / count(*) * 100,'0') as email_percentage,
			IFNULL(sum(case when whatsapp_no != '' then 1 else 0 end),'0') AS having_whatsapp,
			IFNULL(sum(case when whatsapp_no != '' then 1 else 0 end) / count(*) * 100,'0') as whatsapp_percentage,
			IFNULL(sum(case when whatsapp_broadcast = 'Y' then 1 else 0 end),'0') AS having_whatsapp_broadcast,
			IFNULL(sum(case when whatsapp_broadcast = 'Y' then 1 else 0 end) / count(*) * 100,'0') as broadcast_percentage,
			IFNULL(sum(case when voter_id_no!= '' then 1 else 0 end) / count(*) * 100,'0') as having_voter_percenatge,
			IFNULL(sum(case when voter_id_no!= '' then 1 else 0 end),'0') AS having_vote_id,
			IFNULL(sum(case when dob!= '0000-00-00' then 1 else 0 end) / count(*) * 100,'0') as having_dob_percentage,
			IFNULL(sum(case when dob!= '0000-00-00' then 1 else 0 end),'0') AS having_dob
			FROM constituent $quer_paguthi $quer_date";

			$res=$this->db->query($query);
			$result=$res->result();

		$response = array("status" => "Success", "msg" => "Constituent Details", "constituent_details" => $result);
		return $response;
	}
	
	
	function Widgets_grievances($paguthi_id,$from_date,$to_date)
	{
		
		if($paguthi_id=='ALL' || empty($paguthi_id)){
				$quer_paguthi="";
		}else{
				$quer_paguthi="AND g.paguthi_id='$paguthi_id'";
		}

		if(empty($from_date)){
			$quer_date="";
		}else{
			$dateTime1 = new DateTime($from_date);
			$one_date=date_format($dateTime1,'Y-m-d' );
			$dateTime2 = new DateTime($to_date);
			$two_date=date_format($dateTime2,'Y-m-d' );
			$quer_date="AND DATE(g.grievance_date) BETWEEN '$one_date' and '$two_date'";
		}

		$query_2=$this->db->query("SELECT count(*) as enquiry_count from grievance as g where g.grievance_type='E' AND g.enquiry_status = 'E' $quer_paguthi $quer_date");
		$result_2=$query_2->result();
		foreach($result_2 as $row_enquiry_count){
			  $enquiry_count = $row_enquiry_count->enquiry_count;
			}

		$query_3=$this->db->query("SELECT count(*) as petition_count from grievance as g where g.grievance_type='P' $quer_paguthi $quer_date");
		$result_3=$query_3->result();
		foreach($result_3 as $row_petition_count){
			  $petition_count = $row_petition_count->petition_count;
			}
		$tot_grive_count = $enquiry_count + $petition_count;
		
		$query_4=$this->db->query("SELECT IFNULL(sum(case when g.status = 'PENDING' then 1 else 0 end),'0') AS no_of_pending,
        IFNULL(sum(case when g.status = 'COMPLETED' then 1 else 0 end),'0') AS no_of_completed,
        IFNULL(sum(case when g.status = 'REJECTED' then 1 else 0 end),'0') AS no_of_rejected
		FROM grievance as g  where g.grievance_type='P' $quer_paguthi $quer_date");
		$result_4=$query_4->result();
		foreach($result_4 as $row_petition_status){
			  $petition_pending = $row_petition_status->no_of_pending;
			  if($petition_pending==0){ $petition_pending_percentage = "0.00"; }else{ $petition_pending_percentage = number_format($petition_pending/$petition_count *100 ,2);}
			  $petition_completed = $row_petition_status->no_of_completed;
			  if($petition_completed==0){ $petition_completed_percentage = "0.00"; }else{ $petition_completed_percentage = number_format($petition_completed/$petition_count *100 ,2);}
			  $petition_rejected = $row_petition_status->no_of_rejected;
			  if($petition_rejected==0){ $petition_rejected_percentage = "0.00"; }else{ $petition_rejected_percentage = number_format($petition_rejected/$petition_count *100 ,2);}
			}
		$petition_status  = array(
				"petition_pending" => $petition_pending,
				"petition_pending_percentage" => $petition_pending_percentage,
				"petition_completed" => $petition_completed,
				"petition_completed_percentage" => $petition_completed_percentage,
				"petition_rejected" => $petition_rejected,
				"petition_rejected_percentage" => $petition_rejected_percentage
		);

		$query_1=$this->db->query("SELECT
		IFNULL(sum(case when g.seeker_type_id = '1' then 1 else 0 end),'0') AS no_of_online,
		IFNULL(sum(case when g.seeker_type_id = '2' then 1 else 0 end),'0') AS no_of_civic
		FROM grievance as g where g.grievance_type='P' $quer_paguthi $quer_date");
		$result_1=$query_1->result();
		foreach($result_1 as $row_petition_list){
			  $no_of_online = $row_petition_list->no_of_online;
			  if($no_of_online==0){ $no_of_online_percentage = "0.00"; }else{ $no_of_online_percentage = number_format($no_of_online/$petition_count *100 ,2);}
			  $no_of_civic = $row_petition_list->no_of_civic;
			  if($no_of_civic==0){ $no_of_civic_percentage = "0.00"; }else{ $no_of_civic_percentage = number_format($no_of_civic/$petition_count *100 ,2);}
			}
		$petition_list  = array(
				"no_of_online" => $no_of_online,
				"no_of_online_percentage" => $no_of_online_percentage,
				"no_of_civic" => $no_of_civic,
				"no_of_civic_percentage" => $no_of_civic_percentage
		);
		
		$query_1_1=$this->db->query("SELECT
		IFNULL(sum(case when g.seeker_type_id = '1' then 1 else 0 end),'0') AS no_of_online,
		IFNULL(sum(case when g.seeker_type_id = '2' then 1 else 0 end),'0') AS no_of_civic
		FROM grievance as g where g.grievance_type='E' AND g.enquiry_status = 'E' $quer_paguthi $quer_date");
		$result_1_1=$query_1_1->result();
		foreach($result_1_1 as $row_enquiry_list){
			  $no_of_online = $row_enquiry_list->no_of_online;
			  if($no_of_online==0){ $no_of_online_percentage = "0.00"; }else{ $no_of_online_percentage = number_format($no_of_online/$enquiry_count *100 ,2);}
			  $no_of_civic = $row_enquiry_list->no_of_civic;
			  if($no_of_civic==0){ $no_of_civic_percentage = "0.00"; }else{ $no_of_civic_percentage = number_format($no_of_civic/$enquiry_count *100 ,2);}
			}
		$enquiry_list  = array(
				"no_of_online" => $no_of_online,
				"no_of_online_percentage" => $no_of_online_percentage,
				"no_of_civic" => $no_of_civic,
				"no_of_civic_percentage" => $no_of_civic_percentage
		);

		$query_6=$this->db->query("SELECT count(*) as online_petition_count FROM grievance  as g where g.seeker_type_id='1' 
		and g.grievance_type='P' $quer_paguthi $quer_date");
		$result_6=$query_6->result();
		foreach($result_6 as $online_pet_count){
			  $online_petition_count = $online_pet_count->online_petition_count;
			}

		$query_7=$this->db->query("SELECT IFNULL(sum(case when g.status = 'PENDING' then 1 else 0 end),'0') AS no_of_pending,
        IFNULL(sum(case when g.status = 'COMPLETED' then 1 else 0 end),'0') AS no_of_completed,
        IFNULL(sum(case when g.status = 'REJECTED' then 1 else 0 end),'0') AS no_of_rejected
		FROM grievance as g  where g.seeker_type_id='1' and g.grievance_type='P' $quer_paguthi $quer_date");
		$result_7=$query_7->result();
		foreach($result_7 as $online_petition_status){
			  $petition_pending = $online_petition_status->no_of_pending;
			  if($petition_pending==0){ $petition_pending_percentage = "0.00"; }else{ $petition_pending_percentage = number_format($petition_pending/$online_petition_count *100 ,2);}
			  $petition_completed = $online_petition_status->no_of_completed;
			  if($petition_completed==0){ $petition_completed_percentage = "0.00"; }else{ $petition_completed_percentage = number_format($petition_completed/$online_petition_count *100 ,2);}
			  $petition_rejected = $online_petition_status->no_of_rejected;
			  if($petition_rejected==0){ $petition_rejected_percentage = "0.00"; }else{ $petition_rejected_percentage = number_format($petition_rejected/$online_petition_count *100 ,2);}
			}
		$online_petition_status  = array(
				"petition_pending" => $petition_pending,
				"petition_pending_percentage" => $petition_pending_percentage,
				"petition_completed" => $petition_completed,
				"petition_completed_percentage" => $petition_completed_percentage,
				"petition_rejected" => $petition_rejected,
				"petition_rejected_percentage" => $petition_rejected_percentage
		);


		$query_9=$this->db->query("SELECT count(*) as civic_petition_count FROM grievance  as g where g.seeker_type_id='2' 
		and g.grievance_type='P' $quer_paguthi $quer_date");
		$result_9=$query_9->result();
		foreach($result_9 as $civic_pet_count){
			  $civic_petition_count = $civic_pet_count->civic_petition_count;
			}

		$query_10=$this->db->query("SELECT	IFNULL(sum(case when g.status = 'PENDING' then 1 else 0 end),'0') AS no_of_pending,
		IFNULL(sum(case when g.status = 'COMPLETED' then 1 else 0 end),'0') AS no_of_completed,
		IFNULL(sum(case when g.status = 'REJECTED' then 1 else 0 end),'0') AS no_of_rejected
		FROM grievance as g  where g.seeker_type_id='2' and g.grievance_type='P' $quer_paguthi $quer_date");
		$result_10=$query_10->result();

		foreach($result_10 as $civic_petition_status){
			  $petition_pending = $civic_petition_status->no_of_pending;
			  if($petition_pending==0){ $petition_pending_percentage = "0.00"; }else{ $petition_pending_percentage = number_format($petition_pending/$civic_petition_count *100 ,2);}
			  $petition_completed = $civic_petition_status->no_of_completed;
			  if($petition_completed==0){ $petition_completed_percentage = "0.00"; }else{ $petition_completed_percentage = number_format($petition_completed/$civic_petition_count *100 ,2);}
			  $petition_rejected = $civic_petition_status->no_of_rejected;
			   if($petition_rejected==0){ $petition_rejected_percentage = "0.00"; }else{ $petition_rejected_percentage = number_format($petition_rejected/$civic_petition_count *100 ,2);}
			}
		$civic_petition_status  = array(
				"petition_pending" => $petition_pending,
				"petition_pending_percentage" => $petition_pending_percentage,
				"petition_completed" => $petition_completed,
				"petition_completed_percentage" => $petition_completed_percentage,
				"petition_rejected" => $petition_rejected,
				"petition_rejected_percentage" => $petition_rejected_percentage
		);

		$data = array('status' => 'Success', 'msg' => 'Grievances Details','tot_grive_count'=>$tot_grive_count,'enquiry_count'=>$enquiry_count,'petition_count'=>$petition_count,'petition_status'=>$petition_status,'petition_list' => $petition_list,'enquiry_list' => $enquiry_list,'online_petition_count'=>$online_petition_count,'online_petition_status'=>$online_petition_status,'civic_petition_count'=>$civic_petition_count,'civic_petition_status'=>$civic_petition_status);
		return $data;

	}
	
	function Widgets_footfall($paguthi_id,$from_date,$to_date)
	{
		if($paguthi_id=='99'){
			$cons_id='99';
			$others_id='0';
			$quer_paguthi='';
			$quer_cons="AND g.constituency_id='0'";
		}else{
			$cons_id='1';
			$others_id='0';
			$quer_cons="";
			if($paguthi_id=='ALL' || empty($paguthi_id)){
				$quer_paguthi="";
			}else{
				$quer_paguthi="AND g.paguthi_id='$paguthi_id'";
			}
	}

		if(empty($from_date)){
			$quer_date="";
		}else{
			$dateTime1 = new DateTime($from_date);
			$one_date=date_format($dateTime1,'Y-m-d' );
			$dateTime2 = new DateTime($to_date);
			$two_date=date_format($dateTime2,'Y-m-d' );
			$quer_date="AND DATE(g.grievance_date) BETWEEN '$one_date' and '$two_date'";
		}
		
		$query_1="SELECT * from grievance as g where g.constituency_id ='$cons_id' and g.repeated_status ='N' $quer_paguthi $quer_date GROUP BY g.constituent_id, g.grievance_date";
		$result_1=$this->db->query($query_1);
		$cons_footfall_cnt = $result_1->num_rows();
		
		$query_2="SELECT * from grievance as g where g.constituency_id ='$others_id' and g.repeated_status ='N' $quer_paguthi $quer_date GROUP BY g.constituent_id, g.grievance_date";
		$result_2=$this->db->query($query_2);
		$other_footfall_cnt = $result_2->num_rows();

		$query_3="SELECT * from grievance as g where g.repeated_status ='N' $quer_cons $quer_paguthi $quer_date GROUP BY g.constituent_id, g.grievance_date";
		$result_3=$this->db->query($query_3);
		$unique_cnt = $result_3->num_rows();
		
		$query_4="SELECT * from grievance as g where g.repeated_status ='R' $quer_cons $quer_paguthi $quer_date GROUP BY g.constituent_id, g.grievance_date";
		$result_4=$this->db->query($query_4);
		$repeated_cnt = $result_4->num_rows();
		
		$query_5="SELECT * from grievance as g where g.constituency_id ='$cons_id' and g.repeated_status ='N' $quer_paguthi $quer_date GROUP BY g.constituent_id, g.grievance_date";
		$result_5=$this->db->query($query_5);
		$sing_unique_cnt = $result_5->num_rows();
		
		$query_6="SELECT * from grievance as g where g.constituency_id ='$cons_id' and g.repeated_status ='R' $quer_paguthi $quer_date GROUP BY g.constituent_id, g.grievance_date";
		$result_6=$this->db->query($query_6);
		$sing_repeted_cnt = $result_6->num_rows();
		
		$query_7="SELECT * from grievance as g where g.constituency_id ='$others_id' and g.repeated_status ='N' $quer_paguthi $quer_date GROUP BY g.constituent_id, g.grievance_date";
		$result_7=$this->db->query($query_7);
		$other_unique_cnt = $result_7->num_rows();
		
		$query_8="SELECT * from grievance as g where g.constituency_id ='$others_id' and g.repeated_status ='R' $quer_paguthi $quer_date GROUP BY g.constituent_id, g.grievance_date";
		$result_8=$this->db->query($query_8);
		$other_repeted_cnt = $result_8->num_rows();

		$total_footfall_cnt = $unique_cnt + $repeated_cnt;
		$total_unique_footfall_cnt = $cons_footfall_cnt + $other_footfall_cnt;
		$constituency_cnt = $sing_unique_cnt + $sing_repeted_cnt;
		$other_cnt = $other_unique_cnt + $other_repeted_cnt;

		if ($total_footfall_cnt >0 ){ 
				$unique_footfall_cnt_presntage = number_format($unique_cnt/$total_footfall_cnt*100,2);
				$repeated_footfall_cnt_presntage = number_format($repeated_cnt/$total_footfall_cnt*100,2);
		} else {
				$unique_footfall_cnt_presntage = "0.00";
				$repeated_footfall_cnt_presntage = "0.00";
		}
		
		if ($total_unique_footfall_cnt >0 ){ 
				$cons_unique_footfall_cnt_presntage = number_format($cons_footfall_cnt/$total_unique_footfall_cnt*100,2);
				$other_unique_footfall_cnt_presntage = number_format($other_footfall_cnt/$total_unique_footfall_cnt*100,2);
		} else {
				$cons_unique_footfall_cnt_presntage = "0.00";
				$other_unique_footfall_cnt_presntage = "0.00";
		}
		
		if ($constituency_cnt >0 ){ 
				$cons_unique_cnt_presntage = number_format($sing_unique_cnt/$constituency_cnt*100,2);
				$cons_repeated_cnt_presntage = number_format($sing_repeted_cnt/$constituency_cnt*100,2);
		} else {
				$cons_unique_cnt_presntage = "0.00";
				$cons_repeated_cnt_presntage = "0.00";
		}
		
		if ($other_cnt >0 ){ 
				$other_unique_cnt_presntage = number_format($other_unique_cnt/$other_cnt*100,2);
				$other_repeated_cnt_presntage = number_format($other_repeted_cnt/$other_cnt*100,2);
		} else {
				$other_unique_cnt_presntage = "0.00";
				$other_repeated_cnt_presntage = "0.00";
		}
		
		$footfall_details  = array(
				"total_footfall_cnt" => $total_footfall_cnt,
				"unique_footfall_cnt" => $unique_cnt,
				"repeated_footfall_cnt" => $repeated_cnt,
				"unique_footfall_cnt_presntage" => $unique_footfall_cnt_presntage,
				"repeated_footfall_cnt_presntage" => $repeated_footfall_cnt_presntage,
				
				"total_unique_footfall_cnt" => $total_unique_footfall_cnt,
				"cons_unique_footfall_cnt" => $cons_footfall_cnt,
				"other_unique_footfall_cnt" => $other_footfall_cnt,
				"cons_unique_footfall_cnt_presntage" => $cons_unique_footfall_cnt_presntage,
				"other_unique_footfall_cnt_presntage" => $other_unique_footfall_cnt_presntage,
				
				"constituency_cnt" => $constituency_cnt,
				"cons_unique_cnt" => $sing_unique_cnt,
				"cons_repeated_cnt" => $sing_repeted_cnt,
				"cons_unique_cnt_presntage" => $cons_unique_cnt_presntage,
				"cons_repeated_cnt_presntage" => $cons_repeated_cnt_presntage,
				
				"other_cnt" => $other_cnt,
				"other_unique_cnt" => $other_unique_cnt,
				"other_repeated_cnt" => $other_repeted_cnt,
				"other_unique_cnt_presntage" => $other_unique_cnt_presntage,
				"other_repeated_cnt_presntage" => $other_repeated_cnt_presntage
			);
			$response = array("status" => "Success", "msg" => "Footfall Details", "footfall_details" => $footfall_details);
			return $response;	

	
	}
	
	
	function Widgets_meetings($paguthi_id,$from_date,$to_date)
	{
		if($paguthi_id=='ALL' || empty($paguthi_id)){
				$quer_paguthi="";
		}else{
				$quer_paguthi="AND g.paguthi_id='$paguthi_id'";
		}
		
		if(empty($from_date)){
			$quer_mr_date="";
		}else{
			$dateTime1 = new DateTime($from_date);
			$one_date=date_format($dateTime1,'Y-m-d' );

			$dateTime2 = new DateTime($to_date);
			$two_date=date_format($dateTime2,'Y-m-d' );

			if(empty($quer_paguthi_cons)){
				$quer_mr_date="WHERE DATE(mr.created_at) BETWEEN '$one_date' and '$two_date'";
			}else{
				$quer_mr_date="AND DATE(mr.created_at) BETWEEN '$one_date' and '$two_date'";
			}
		}
		
		$query_3="SELECT IFNULL(count(*),'0') as total,
			IFNULL(sum(case when (mr.meeting_status = 'REQUESTED' OR mr.meeting_status = 'SCHEDULED') then 1 else 0 end),'0')  AS meeting_request_count,
			IFNULL(IFNULL(sum(case when (mr.meeting_status = 'REQUESTED' OR mr.meeting_status = 'SCHEDULED') then 1 else 0 end),'0') / count(*) * 100,'0') AS mr_percentage,
			IFNULL(sum(case when mr.meeting_status = 'COMPLETED'  then 1 else 0 end),'0')  AS meeting_complete_count,
			IFNULL(IFNULL(sum(case when mr.meeting_status = 'COMPLETED' then 1 else 0 end),'0') / count(*) * 100,'0') AS mc_percentage
			FROM meeting_request as mr
			left join constituent as c on c.id=mr.constituent_id $quer_paguthi $quer_mr_date";
			$res_3=$this->db->query($query_3);
			$result_3=$res_3->result();
			foreach($result_3 as $row_meeting_status){
				$total_meeting = $row_meeting_status->total;
				$request_count = $row_meeting_status->meeting_request_count;
				$request_count_percentage = number_format($row_meeting_status->mr_percentage, 2);
				$complete_count = $row_meeting_status->meeting_complete_count;
				$complete_count_percentage = number_format($row_meeting_status->mc_percentage, 2);
			}
			$meeting_details  = array(
				"total_meeting" => $total_meeting,
				"request_count" => $request_count,
				"request_count_percentage" => $request_count_percentage,
				"complete_count" => $complete_count,
				"complete_count_percentage" => $complete_count_percentage
			);
			$response = array("status" => "Success", "msg" => "Meetings Details", "meeting_details" => $meeting_details);
			return $response;
	}
	
	
	function Widgets_volunteer($paguthi_id)
	{
			$volunter_count = "SELECT * FROM constituent WHERE volunteer_status='Y' AND constituency_id ='1'";
			$volunter_count_res = $this->db->query($volunter_count);
			$volunter_count = $volunter_count_res->num_rows(); 

			$non_volunter_count = "SELECT * FROM constituent WHERE volunteer_status='Y' AND constituency_id ='0'";
			$non_volunter_count_res = $this->db->query($non_volunter_count);
			$non_volunter_count = $non_volunter_count_res->num_rows(); 
			
			$tot_volunter_count = $volunter_count+$non_volunter_count;
		
			if ($tot_volunter_count >0){
				$volunteer_percentage = number_format($volunter_count/$tot_volunter_count*100,2);
				$nonvolunteer_percentage = number_format($non_volunter_count/$tot_volunter_count*100,2);
			} else {
				$volunteer_percentage = "0.00";
				$nonvolunteer_percentage = "0.00";
			}
			$volunteer_details  = array(
				"total_volunteer" => $tot_volunter_count,
				"no_of_volunteer" => $volunter_count,
				"volunteer_percentage" => $volunteer_percentage,
				"no_of_nonvolunteer" => $non_volunter_count,
				"nonvolunteer_percentage" => $nonvolunteer_percentage
			);
			$response = array("status" => "Success", "msg" => "Volunter Details", "volunteer_details" => $volunteer_details);
			
			return $response;
	}
	
	
	
	function Widgets_greetings($paguthi_id,$from_date,$to_date)
	{
		if($paguthi_id=='ALL' || empty($paguthi_id)){
			$quer_paguthi_cons="";
		}else{
			$quer_paguthi_cons="WHERE c.paguthi_id='$paguthi_id'";
		}

		if(empty($from_date)){
			$quer_bw_date="";
			$quer_fw_date="";
		}else{
			$dateTime1 = new DateTime($from_date);
			$one_date=date_format($dateTime1,'Y-m-d' );

			$dateTime2 = new DateTime($to_date);
			$two_date=date_format($dateTime2,'Y-m-d' );

			if(empty($quer_paguthi_cons)){
				$quer_bw_date="WHERE DATE(br.created_at) BETWEEN '$one_date' and '$two_date'";
			}else{
				$quer_bw_date="AND DATE(br.created_at) BETWEEN '$one_date' and '$two_date'";
			}

			if(empty($quer_paguthi_cons)){
				$quer_fw_date="WHERE DATE(fw.updated_at) BETWEEN '$one_date' and '$two_date'";
			}else{
				$quer_fw_date="AND DATE(fw.updated_at) BETWEEN '$one_date' and '$two_date'";
			}
		}
		
		$query_5="SELECT IFNULL(count(*),'0') as birth_wish_count FROM consitutent_birthday_wish as br left join constituent as c on c.id=br.constituent_id $quer_paguthi_cons $quer_bw_date";
		$res_5=$this->db->query($query_5);
		$result_5=$res_5->result();
			foreach($result_5 as $row_birthday_wish){
			   $birthday_wish_count = $row_birthday_wish->birth_wish_count;
			}

		$query_6="SELECT IFNULL(count(fw.id),'0') as total from festival_wishes as fw left join constituent as c on c.id=fw.constituent_id $quer_paguthi_cons $quer_fw_date";
		$res_6=$this->db->query($query_6);
		$result_6=$res_6->result();
		
			foreach($result_6 as $row_festival_wishes){
			   $festival_wishes_count = $row_festival_wishes->total;
			}

		$query_7=$this->db->query("SELECT count(fw.id) as wishes_cnt,fm.festival_name FROM festival_wishes  as fw left join festival_master as fm on fm.id=fw.festival_id left join constituent as c on c.id=fw.constituent_id  $quer_paguthi_cons $quer_fw_date
		GROUP BY fw.festival_id");
		$result_7=$query_7->result();
		
			foreach($result_7 as $row_festival_list_wishes){
			   $festival_name = $row_festival_list_wishes->festival_name;
			   $festival_wish_cnt = $row_festival_list_wishes->wishes_cnt;
			   if ($festival_wishes_count >0){
				    $festival_greetings_details[] = "Nill";
					$festival_wishes_percentage = number_format($festival_wish_cnt/$festival_wishes_count*100,2);
			   }else {
					$festival_wishes_percentage = "0.00";
			   }
			   $festival_greetings_details[] = array("festival_name"=>$festival_name, "festival_wish_cnt"=>$festival_wish_cnt,"festival_wishes_percentage"=>$festival_wishes_percentage);   
			}
		
		$total_greetings = $birthday_wish_count + $festival_wishes_count;

		$greetings_details  = array(
			"total_greetings" => $total_greetings,
			"birthday_wish_count" => $birthday_wish_count,
			"festival_wishes_count" => $festival_wishes_count
		);
		$response = array("status" => "Success", "msg" => "Greetings Details", "greetings_details" => $greetings_details,"festival_greetings_details" => $festival_greetings_details);
		
		return $response;
	}
	
	
	
	function Widgets_videos($paguthi_id,$from_date,$to_date)
	{
		if($paguthi_id=='ALL' || empty($paguthi_id)){
			$quer_paguthi_video="";
		}else{
			$quer_paguthi_video="AND c.paguthi_id='$paguthi_id'";
		}

		if(empty($from_date)){
			$quer_cv_date="";
		}else{
			$dateTime1 = new DateTime($from_date);
			$one_date=date_format($dateTime1,'Y-m-d' );

			$dateTime2 = new DateTime($to_date);
			$two_date=date_format($dateTime2,'Y-m-d' );

			
			if(empty($quer_paguthi_video)){
				$quer_cv_date="AND DATE(cv.updated_at) BETWEEN '$one_date' and '$two_date'";
			}else{
				$quer_cv_date="AND DATE(cv.updated_at) BETWEEN '$one_date' and '$two_date'";
			}	
		}

		$query_5="SELECT p.paguthi_name,o.office_name,COUNT(cv.id) as cnt_video from office as o
		left join paguthi as p on p.id=o.paguthi_id
		left join constituent as c on c.office_id=o.id $quer_paguthi_video 
		left join constituent_video as cv on cv.constituent_id=c.id $quer_cv_date
		GROUP BY o.id";
		$res_5=$this->db->query($query_5);
		$result_5=$res_5->result();
		$video_count = 0;
			foreach($result_5 as $row_video_count){
				$video_count += $row_video_count->cnt_video; 		   
			}
			
			foreach($result_5 as $row_video_list){
				$office_name = $row_video_list->office_name;
				$video_list_count = $row_video_list->cnt_video;
				if ($video_list_count >0){
					$video_list_percentage = number_format($video_list_count/$video_count*100,2);
			   }else {
					$video_list_percentage = "0.00";
			   }
			   $video_list_details[] = array("office_name"=>$office_name, "video_cnt"=>$video_list_count,"video_percentage"=>$video_list_percentage);   
			   
			}
		$response = array("status" => "Success", "msg" => "Video Details", "video_count" => $video_count, "video_list" => $video_list_details,);
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
	
	function Dashboard_searchnew($keyword,$offset,$rowcount)
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
				WHERE c.full_name LIKE '%$keyword%' OR c.father_husband_name LIKE '%$keyword%' OR c.guardian_name LIKE '%$keyword%' OR c.mobile_no LIKE '%$keyword%' OR c.whatsapp_no LIKE '%$keyword%' OR c.door_no LIKE '%$keyword%' OR c.address LIKE '%$keyword%' OR pin_code LIKE '%$keyword%' OR c.email_id LIKE '%$keyword%' OR c.voter_id_no LIKE '%$keyword%' OR c.aadhaar_no LIKE '%$keyword%' OR c.serial_no LIKE '%$keyword%'
				ORDER BY
					c.id
				DESC LIMIT $offset, $rowcount";
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
	
	function List_constituentnew($paguthi,$offset,$rowcount)
	{
		if ($paguthi == 'ALL')
		{
			$constituent_count = "SELECT * FROM constituent";
			$constituent_count_res = $this->db->query($constituent_count);
			$constituent_count = $constituent_count_res->num_rows();
			
			$query="SELECT id,full_name,mobile_no,serial_no,profile_pic FROM constituent ORDER BY id DESC LIMIT $offset, $rowcount";
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
			
			$query="SELECT id,full_name,mobile_no,serial_no,profile_pic FROM constituent WHERE paguthi_id = '$paguthi' ORDER BY id DESC LIMIT $offset, $rowcount";
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
	
	function List_constituentsearch($keyword,$paguthi,$offset,$rowcount)
	{
		if ($paguthi == 'ALL')
		{
			$constituent_count = "SELECT * FROM constituent WHERE full_name LIKE '%$keyword%' OR father_husband_name LIKE '%$keyword%' OR guardian_name LIKE '%$keyword%' OR mobile_no LIKE '%$keyword%' OR whatsapp_no LIKE '%$keyword%' OR door_no LIKE '%$keyword%' OR address LIKE '%$keyword%' OR pin_code LIKE '%$keyword%' OR email_id LIKE '%$keyword%' OR voter_id_no LIKE '%$keyword%' OR aadhaar_no LIKE '%$keyword%' OR serial_no LIKE '%$keyword%' ORDER BY id DESC";
			$constituent_count_res = $this->db->query($constituent_count);
			$constituent_count = $constituent_count_res->num_rows();
			
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
				WHERE c.full_name LIKE '%$keyword%' OR c.father_husband_name LIKE '%$keyword%' OR c.guardian_name LIKE '%$keyword%' OR c.mobile_no LIKE '%$keyword%' OR c.whatsapp_no LIKE '%$keyword%' OR c.door_no LIKE '%$keyword%' OR c.address LIKE '%$keyword%' OR c.pin_code LIKE '%$keyword%' OR c.email_id LIKE '%$keyword%' OR c.voter_id_no LIKE '%$keyword%' OR c.aadhaar_no LIKE '%$keyword%' OR c.serial_no LIKE '%$keyword%'
				ORDER BY
					c.id
				DESC LIMIT $offset, $rowcount";
			$resultset=$this->db->query($query);
			$constituent_result = $resultset->result();
			if($resultset->num_rows()>0)
				{
					$response = array("status" => "Success", "msg" => "List constituent", "constituent_count" =>$constituent_count, "constituent_result" =>$constituent_result);
				} else {
					$response = array("status" => "Error", "msg" => "No records found");
				}
		} else {
			$constituent_count = "SELECT * FROM constituent WHERE paguthi_id = '$paguthi' AND (full_name LIKE '%$keyword%' OR father_husband_name LIKE '%$keyword%' OR guardian_name LIKE '%$keyword%' OR mobile_no LIKE '%$keyword%' OR whatsapp_no LIKE '%$keyword%' OR door_no LIKE '%$keyword%' OR address LIKE '%$keyword%' OR pin_code LIKE '%$keyword%' OR email_id LIKE '%$keyword%' OR voter_id_no LIKE '%$keyword%' OR aadhaar_no LIKE '%$keyword%' OR serial_no LIKE '%$keyword%') ORDER BY id DESC";
			$constituent_count_res = $this->db->query($constituent_count);
			$constituent_count = $constituent_count_res->num_rows();
			
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
				WHERE c.paguthi_id = '$paguthi' AND (c.full_name LIKE '%$keyword%' OR c.father_husband_name LIKE '%$keyword%' OR c.guardian_name LIKE '%$keyword%' OR c.mobile_no LIKE '%$keyword%' OR c.whatsapp_no LIKE '%$keyword%' OR c.door_no LIKE '%$keyword%' OR c.address LIKE '%$keyword%' OR c.pin_code LIKE '%$keyword%' OR c.email_id LIKE '%$keyword%' OR c.voter_id_no LIKE '%$keyword%' OR c.aadhaar_no LIKE '%$keyword%' OR c.serial_no LIKE '%$keyword%')
				ORDER BY
					c.id
				DESC LIMIT $offset, $rowcount";
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

	function Meeting_requestnew($constituency_id,$offset,$rowcount)
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
				mr.meeting_status = 'REQUESTED' order by mr.id desc LIMIT $offset, $rowcount";
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
	
	
	function Meeting_requestsearch($constituency_id,$keyword,$offset,$rowcount)
	{
		$meeting_count = "SELECT
							mr.id,
							con.full_name,
							p.paguthi_name,
							mr.meeting_title,
							mr.meeting_date,
							mr.meeting_status,
							um.full_name AS created_by
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
							mr.meeting_status = 'REQUESTED' AND (con.full_name like '%$keyword%' OR p.paguthi_name like '%$keyword%' OR mr.meeting_title like '%$keyword%' OR mr.meeting_detail like '%$keyword%' OR um.full_name like '%$keyword%')";
		$meeting_count_res = $this->db->query($meeting_count);
		$meeting_count = $meeting_count_res->num_rows();
			
		$query = "SELECT
							mr.id,
							con.full_name,
							p.paguthi_name,
							mr.meeting_title,
							mr.meeting_date,
							mr.meeting_status,
							um.full_name AS created_by
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
							mr.meeting_status = 'REQUESTED' AND (con.full_name like '%$keyword%' OR p.paguthi_name like '%$keyword%' OR mr.meeting_title like '%$keyword%' OR mr.meeting_detail like '%$keyword%' OR um.full_name like '%$keyword%') order by mr.id desc LIMIT $offset, $rowcount";
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
				
					$cquery="SELECT * FROM grievance order by id desc";
						
					$query="SELECT g.*,c.full_name,p.paguthi_name,st.seeker_info,gt.grievance_name,gsc.sub_category_name FROM grievance as g
						left join constituent as c on c.id=g.constituent_id
						left join paguthi as p on p.id=g.paguthi_id
						left join seeker_type as st on st.id=g.seeker_type_id
						left join grievance_type as gt on gt.id=g.grievance_type_id
						left join grievance_sub_category as gsc on gsc.id=g.sub_category_id
						order by g.id desc LIMIT $offset, $rowcount";
			} else if ($grievance_type == 'P') {
					 $cquery="SELECT * FROM grievance where grievance_type='P' order by id desc";
						
					 $query="SELECT g.*,c.full_name,p.paguthi_name,st.seeker_info,gt.grievance_name,gsc.sub_category_name FROM grievance as g
						left join constituent as c on c.id=g.constituent_id
						left join paguthi as p on p.id=g.paguthi_id
						left join seeker_type as st on st.id=g.seeker_type_id
						left join grievance_type as gt on gt.id=g.grievance_type_id
						left join grievance_sub_category as gsc on gsc.id=g.sub_category_id where g.grievance_type='P'
						order by g.id desc LIMIT $offset, $rowcount";
			}else if ($grievance_type == 'E') {
					$cquery="SELECT * FROM grievance where grievance_type='E' order by id desc";
					
					$query="SELECT g.*,c.full_name,p.paguthi_name,st.seeker_info,gt.grievance_name,gsc.sub_category_name FROM grievance as g
					left join constituent as c on c.id=g.constituent_id
					left join paguthi as p on p.id=g.paguthi_id
					left join seeker_type as st on st.id=g.seeker_type_id
					left join grievance_type as gt on gt.id=g.grievance_type_id
					left join grievance_sub_category as gsc on gsc.id=g.sub_category_id where g.grievance_type='E'
					order by g.id desc LIMIT $offset, $rowcount";
			} 
			
			$resultset_count=$this->db->query($cquery);
			$grievance_count = $resultset_count->num_rows();
			
			$resultset=$this->db->query($query);
			$grievance_result = $resultset->result();
			
			if($resultset->num_rows()>0)
			{
				$response = array("status" => "Success", "msg" => "List All Grievances", "grievance_count" =>$grievance_count, "list_grievances" =>$grievance_result);
			} else {
				$response = array("status" => "Error", "msg" => "No records found");
			}
			
		} else {
			
			if ($grievance_type == 'A'){
				
					$cquery="SELECT * FROM grievance where paguthi_id='$paguthi' order by id desc";
						
					$query="SELECT g.*,c.full_name,p.paguthi_name,st.seeker_info,gt.grievance_name,gsc.sub_category_name FROM grievance as g
						left join constituent as c on c.id=g.constituent_id
						left join paguthi as p on p.id=g.paguthi_id
						left join seeker_type as st on st.id=g.seeker_type_id
						left join grievance_type as gt on gt.id=g.grievance_type_id
						left join grievance_sub_category as gsc on gsc.id=g.sub_category_id where g.paguthi_id='$paguthi' 
						order by g.id desc LIMIT $offset, $rowcount";
			} else if ($grievance_type == 'P') {
				
					 $cquery="SELECT * FROM grievance where paguthi_id='$paguthi' AND grievance_type='P' order by id desc";
						
					 $query="SELECT g.*,c.full_name,p.paguthi_name,st.seeker_info,gt.grievance_name,gsc.sub_category_name FROM grievance as g
						left join constituent as c on c.id=g.constituent_id
						left join paguthi as p on p.id=g.paguthi_id
						left join seeker_type as st on st.id=g.seeker_type_id
						left join grievance_type as gt on gt.id=g.grievance_type_id
						left join grievance_sub_category as gsc on gsc.id=g.sub_category_id where g.paguthi_id='$paguthi' AND g.grievance_type='P'
						order by g.id desc LIMIT $offset, $rowcount";
			}else if ($grievance_type == 'E') {
				
					$cquery="SELECT * FROM grievance where paguthi_id='$paguthi' AND grievance_type='E' order by id desc";

					$query="SELECT g.*,c.full_name,p.paguthi_name,st.seeker_info,gt.grievance_name,gsc.sub_category_name FROM grievance as g
					left join constituent as c on c.id=g.constituent_id
					left join paguthi as p on p.id=g.paguthi_id
					left join seeker_type as st on st.id=g.seeker_type_id
					left join grievance_type as gt on gt.id=g.grievance_type_id
					left join grievance_sub_category as gsc on gsc.id=g.sub_category_id where g.paguthi_id='$paguthi' AND g.grievance_type='E'
					order by g.id desc LIMIT $offset, $rowcount";
			} 
			
			$resultset_count=$this->db->query($cquery);
			$grievance_count = $resultset_count->num_rows();
			
			$resultset=$this->db->query($query);
			$grievance_result = $resultset->result();

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


//#################### New Grievance search Start ####################//
	function List_grievancesearch($keyword,$paguthi,$grievance_type,$offset,$rowcount)
	{
		if ($paguthi == 'ALL')	{
		
			if ($grievance_type == 'A'){
				
					$cquery="SELECT
								g.*,
								c.full_name,
								p.paguthi_name,
								st.seeker_info,
								gt.grievance_name,
								gsc.sub_category_name
							FROM
								grievance AS g
							LEFT JOIN constituent AS c
							ON
								c.id = g.constituent_id
							LEFT JOIN paguthi AS p
							ON
								p.id = g.paguthi_id
							LEFT JOIN seeker_type AS st
							ON
								st.id = g.seeker_type_id
							LEFT JOIN grievance_type AS gt
							ON
								gt.id = g.grievance_type_id
							LEFT JOIN grievance_sub_category AS gsc
							ON
								gsc.id = g.sub_category_id
								WHERE g.petition_enquiry_no LIKE '%$keyword%' OR st.seeker_info LIKE '%$keyword%' OR gt.grievance_name LIKE '%$keyword%' OR gsc.sub_category_name LIKE '%$keyword%'
							ORDER BY `g`.`id` ASC";
							
					$query="SELECT
								g.*,
								c.full_name,
								p.paguthi_name,
								st.seeker_info,
								gt.grievance_name,
								gsc.sub_category_name
							FROM
								grievance AS g
							LEFT JOIN constituent AS c
							ON
								c.id = g.constituent_id
							LEFT JOIN paguthi AS p
							ON
								p.id = g.paguthi_id
							LEFT JOIN seeker_type AS st
							ON
								st.id = g.seeker_type_id
							LEFT JOIN grievance_type AS gt
							ON
								gt.id = g.grievance_type_id
							LEFT JOIN grievance_sub_category AS gsc
							ON
								gsc.id = g.sub_category_id
								WHERE g.petition_enquiry_no LIKE '%$keyword%' OR st.seeker_info LIKE '%$keyword%' OR gt.grievance_name LIKE '%$keyword%' OR gsc.sub_category_name LIKE '%$keyword%'
							ORDER BY `g`.`id`  ASC LIMIT $offset, $rowcount";
			} else if ($grievance_type == 'P') {
					$cquery="SELECT
								g.*,
								c.full_name,
								p.paguthi_name,
								st.seeker_info,
								gt.grievance_name,
								gsc.sub_category_name
							FROM
								grievance AS g
							LEFT JOIN constituent AS c
							ON
								c.id = g.constituent_id
							LEFT JOIN paguthi AS p
							ON
								p.id = g.paguthi_id
							LEFT JOIN seeker_type AS st
							ON
								st.id = g.seeker_type_id
							LEFT JOIN grievance_type AS gt
							ON
								gt.id = g.grievance_type_id
							LEFT JOIN grievance_sub_category AS gsc
							ON
								gsc.id = g.sub_category_id
								WHERE g.grievance_type='P' AND g.petition_enquiry_no LIKE '%$keyword%' OR st.seeker_info LIKE '%$keyword%' OR gt.grievance_name LIKE '%$keyword%' OR gsc.sub_category_name LIKE '%$keyword%'
							ORDER BY `g`.`id` ASC";
						
					$query="SELECT
								g.*,
								c.full_name,
								p.paguthi_name,
								st.seeker_info,
								gt.grievance_name,
								gsc.sub_category_name
							FROM
								grievance AS g
							LEFT JOIN constituent AS c
							ON
								c.id = g.constituent_id
							LEFT JOIN paguthi AS p
							ON
								p.id = g.paguthi_id
							LEFT JOIN seeker_type AS st
							ON
								st.id = g.seeker_type_id
							LEFT JOIN grievance_type AS gt
							ON
								gt.id = g.grievance_type_id
							LEFT JOIN grievance_sub_category AS gsc
							ON
								gsc.id = g.sub_category_id
								WHERE g.grievance_type='P' AND g.petition_enquiry_no LIKE '%$keyword%' OR st.seeker_info LIKE '%$keyword%' OR gt.grievance_name LIKE '%$keyword%' OR gsc.sub_category_name LIKE '%$keyword%'
							ORDER BY `g`.`id` ASC LIMIT $offset, $rowcount";
			}else if ($grievance_type == 'E') {
					$cquery="SELECT
								g.*,
								c.full_name,
								p.paguthi_name,
								st.seeker_info,
								gt.grievance_name,
								gsc.sub_category_name
							FROM
								grievance AS g
							LEFT JOIN constituent AS c
							ON
								c.id = g.constituent_id
							LEFT JOIN paguthi AS p
							ON
								p.id = g.paguthi_id
							LEFT JOIN seeker_type AS st
							ON
								st.id = g.seeker_type_id
							LEFT JOIN grievance_type AS gt
							ON
								gt.id = g.grievance_type_id
							LEFT JOIN grievance_sub_category AS gsc
							ON
								gsc.id = g.sub_category_id
								WHERE g.grievance_type='E' AND g.petition_enquiry_no LIKE '%$keyword%' OR st.seeker_info LIKE '%$keyword%' OR gt.grievance_name LIKE '%$keyword%' OR gsc.sub_category_name LIKE '%$keyword%'
							ORDER BY `g`.`id` ASC";
					
					$query="SELECT
								g.*,
								c.full_name,
								p.paguthi_name,
								st.seeker_info,
								gt.grievance_name,
								gsc.sub_category_name
							FROM
								grievance AS g
							LEFT JOIN constituent AS c
							ON
								c.id = g.constituent_id
							LEFT JOIN paguthi AS p
							ON
								p.id = g.paguthi_id
							LEFT JOIN seeker_type AS st
							ON
								st.id = g.seeker_type_id
							LEFT JOIN grievance_type AS gt
							ON
								gt.id = g.grievance_type_id
							LEFT JOIN grievance_sub_category AS gsc
							ON
								gsc.id = g.sub_category_id
								WHERE g.grievance_type='E' AND g.petition_enquiry_no LIKE '%$keyword%' OR st.seeker_info LIKE '%$keyword%' OR gt.grievance_name LIKE '%$keyword%' OR gsc.sub_category_name LIKE '%$keyword%'
							ORDER BY `g`.`id` ASC LIMIT $offset, $rowcount";
			} 
			
			$resultset_count=$this->db->query($cquery);
			$grievance_count = $resultset_count->num_rows();
			
			$resultset=$this->db->query($query);
			$grievance_result = $resultset->result();
			
			if($resultset->num_rows()>0)
			{
				$response = array("status" => "Success", "msg" => "List All Grievances", "grievance_count" =>$grievance_count, "list_grievances" =>$grievance_result);
			} else {
				$response = array("status" => "Error", "msg" => "No records found");
			}
			
		} else {
			
			if ($grievance_type == 'A'){
				
					$cquery="SELECT
								g.*,
								c.full_name,
								p.paguthi_name,
								st.seeker_info,
								gt.grievance_name,
								gsc.sub_category_name
							FROM
								grievance AS g
							LEFT JOIN constituent AS c
							ON
								c.id = g.constituent_id
							LEFT JOIN paguthi AS p
							ON
								p.id = g.paguthi_id
							LEFT JOIN seeker_type AS st
							ON
								st.id = g.seeker_type_id
							LEFT JOIN grievance_type AS gt
							ON
								gt.id = g.grievance_type_id
							LEFT JOIN grievance_sub_category AS gsc
							ON
								gsc.id = g.sub_category_id
								WHERE g.paguthi_id='$paguthi' AND g.petition_enquiry_no LIKE '%$keyword%' OR st.seeker_info LIKE '%$keyword%' OR gt.grievance_name LIKE '%$keyword%' OR gsc.sub_category_name LIKE '%$keyword%'
							ORDER BY `g`.`id` ASC";
							
					$query="SELECT
								g.*,
								c.full_name,
								p.paguthi_name,
								st.seeker_info,
								gt.grievance_name,
								gsc.sub_category_name
							FROM
								grievance AS g
							LEFT JOIN constituent AS c
							ON
								c.id = g.constituent_id
							LEFT JOIN paguthi AS p
							ON
								p.id = g.paguthi_id
							LEFT JOIN seeker_type AS st
							ON
								st.id = g.seeker_type_id
							LEFT JOIN grievance_type AS gt
							ON
								gt.id = g.grievance_type_id
							LEFT JOIN grievance_sub_category AS gsc
							ON
								gsc.id = g.sub_category_id
								WHERE g.paguthi_id='$paguthi' AND g.petition_enquiry_no LIKE '%$keyword%' OR st.seeker_info LIKE '%$keyword%' OR gt.grievance_name LIKE '%$keyword%' OR gsc.sub_category_name LIKE '%$keyword%'
							ORDER BY `g`.`id`  ASC LIMIT $offset, $rowcount";
			} else if ($grievance_type == 'P') {
					$cquery="SELECT
								g.*,
								c.full_name,
								p.paguthi_name,
								st.seeker_info,
								gt.grievance_name,
								gsc.sub_category_name
							FROM
								grievance AS g
							LEFT JOIN constituent AS c
							ON
								c.id = g.constituent_id
							LEFT JOIN paguthi AS p
							ON
								p.id = g.paguthi_id
							LEFT JOIN seeker_type AS st
							ON
								st.id = g.seeker_type_id
							LEFT JOIN grievance_type AS gt
							ON
								gt.id = g.grievance_type_id
							LEFT JOIN grievance_sub_category AS gsc
							ON
								gsc.id = g.sub_category_id
								WHERE g.paguthi_id='$paguthi' AND g.grievance_type='P' AND g.petition_enquiry_no LIKE '%$keyword%' OR st.seeker_info LIKE '%$keyword%' OR gt.grievance_name LIKE '%$keyword%' OR gsc.sub_category_name LIKE '%$keyword%'
							ORDER BY `g`.`id` ASC";
						
					$query="SELECT
								g.*,
								c.full_name,
								p.paguthi_name,
								st.seeker_info,
								gt.grievance_name,
								gsc.sub_category_name
							FROM
								grievance AS g
							LEFT JOIN constituent AS c
							ON
								c.id = g.constituent_id
							LEFT JOIN paguthi AS p
							ON
								p.id = g.paguthi_id
							LEFT JOIN seeker_type AS st
							ON
								st.id = g.seeker_type_id
							LEFT JOIN grievance_type AS gt
							ON
								gt.id = g.grievance_type_id
							LEFT JOIN grievance_sub_category AS gsc
							ON
								gsc.id = g.sub_category_id
								WHERE g.paguthi_id='$paguthi' AND g.grievance_type='P' AND g.petition_enquiry_no LIKE '%$keyword%' OR st.seeker_info LIKE '%$keyword%' OR gt.grievance_name LIKE '%$keyword%' OR gsc.sub_category_name LIKE '%$keyword%'
							ORDER BY `g`.`id` ASC LIMIT $offset, $rowcount";
			}else if ($grievance_type == 'E') {
					$cquery="SELECT
								g.*,
								c.full_name,
								p.paguthi_name,
								st.seeker_info,
								gt.grievance_name,
								gsc.sub_category_name
							FROM
								grievance AS g
							LEFT JOIN constituent AS c
							ON
								c.id = g.constituent_id
							LEFT JOIN paguthi AS p
							ON
								p.id = g.paguthi_id
							LEFT JOIN seeker_type AS st
							ON
								st.id = g.seeker_type_id
							LEFT JOIN grievance_type AS gt
							ON
								gt.id = g.grievance_type_id
							LEFT JOIN grievance_sub_category AS gsc
							ON
								gsc.id = g.sub_category_id
								WHERE g.paguthi_id='$paguthi' AND g.grievance_type='E' AND g.petition_enquiry_no LIKE '%$keyword%' OR st.seeker_info LIKE '%$keyword%' OR gt.grievance_name LIKE '%$keyword%' OR gsc.sub_category_name LIKE '%$keyword%'
							ORDER BY `g`.`id` ASC";
					
					$query="SELECT
								g.*,
								c.full_name,
								p.paguthi_name,
								st.seeker_info,
								gt.grievance_name,
								gsc.sub_category_name
							FROM
								grievance AS g
							LEFT JOIN constituent AS c
							ON
								c.id = g.constituent_id
							LEFT JOIN paguthi AS p
							ON
								p.id = g.paguthi_id
							LEFT JOIN seeker_type AS st
							ON
								st.id = g.seeker_type_id
							LEFT JOIN grievance_type AS gt
							ON
								gt.id = g.grievance_type_id
							LEFT JOIN grievance_sub_category AS gsc
							ON
								gsc.id = g.sub_category_id
								WHERE g.paguthi_id='$paguthi' AND (g.grievance_type='E' AND g.petition_enquiry_no LIKE '%$keyword%' OR st.seeker_info LIKE '%$keyword%' OR gt.grievance_name LIKE '%$keyword%' OR gsc.sub_category_name LIKE '%$keyword%')
							ORDER BY `g`.`id` ASC LIMIT $offset, $rowcount";
			}  
			
			$resultset_count=$this->db->query($cquery);
			$grievance_count = $resultset_count->num_rows();
			
			$resultset=$this->db->query($query);
			$grievance_result = $resultset->result();
			
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
				A.id,
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
						A.grievance_type,
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
						A.grievance_type,
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
						A.grievance_type,
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
						A.grievance_type,
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
	
	function Report_statusnew($from_date,$to_date,$status,$paguthi,$offset,$rowcount){

		$dateTime1 = new DateTime($from_date);
		$from_date=date_format($dateTime1,'Y-m-d' );
		
		$dateTime2 = new DateTime($to_date);
		$to_date=date_format($dateTime2,'Y-m-d' );
		
		if ($status=='ALL' && $paguthi == 'ALL')
		{		
			 $cquery="SELECT
						A.id,
						F.paguthi_name,
						A.grievance_type,
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
						
			$query= $cquery." LIMIT $offset, $rowcount";
		}
		if ($status=='ALL' && $paguthi != 'ALL')
		{
			 $cquery="SELECT
						A.id,
						F.paguthi_name,
						A.grievance_type,
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
						
			$query= $cquery." LIMIT $offset, $rowcount";
		}
		if ($status!='ALL' && $paguthi == 'ALL')
		{
			 $cquery="SELECT
						A.id,
						F.paguthi_name,
						A.grievance_type,
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
						
			$query= $cquery." LIMIT $offset, $rowcount";
		}
		if ($status!='ALL' && $paguthi != 'ALL')
		{
			 $cquery="SELECT
						A.id,
						F.paguthi_name,
						A.grievance_type,
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
			
			$query= $cquery." LIMIT $offset, $rowcount";
		}
		
		$resultset_count=$this->db->query($cquery);
		$result_count = $resultset_count->num_rows();
			
		$resultset=$this->db->query($query);
		$report_result = $resultset->result();
		if($resultset->num_rows()>0)
			{
				$response = array("status" => "Success", "msg" => "Status based report","result_count" =>$result_count,"report_list" =>$report_result);
			} else {
				$response = array("status" => "Error", "msg" => "No records found");
			}
			
		return $response;
	}
	
	function Report_statussearch($from_date,$to_date,$status,$paguthi,$keyword,$offset,$rowcount){

		$dateTime1 = new DateTime($from_date);
		$from_date=date_format($dateTime1,'Y-m-d' );
		
		$dateTime2 = new DateTime($to_date);
		$to_date=date_format($dateTime2,'Y-m-d' );
		
		if ($status=='ALL' && $paguthi == 'ALL')
		{		
			 $cquery="SELECT
						A.id,
						F.paguthi_name,
						A.grievance_type,
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
						A.constituent_id = B.id AND A.created_by = C.id AND A.grievance_type_id = D.id AND C.role_id = E.id AND A.paguthi_id = F.id AND (`grievance_date` BETWEEN '$from_date' AND '$to_date') 
						AND (A.status like '%$keyword%' OR  A.petition_enquiry_no like '%$keyword%' OR A.grievance_date like '%$keyword%' OR B.full_name like '%$keyword%' OR B.mobile_no like '%$keyword%' OR C.full_name like '%$keyword%' OR D.grievance_name like '%$keyword%')
						ORDER BY A.`grievance_date` DESC";
						
			$query= $cquery." LIMIT $offset, $rowcount";
		}
		if ($status=='ALL' && $paguthi != 'ALL')
		{
			 $cquery="SELECT
						A.id,
						F.paguthi_name,
						A.grievance_type,
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
						A.constituent_id = B.id AND A.created_by = C.id AND A.grievance_type_id = D.id AND C.role_id = E.id AND A.paguthi_id = F.id AND A.paguthi_id = '$paguthi' AND (`grievance_date` BETWEEN '$from_date' AND '$to_date') 
						AND (A.status like '%$keyword%' OR  A.petition_enquiry_no like '%$keyword%' OR A.grievance_date like '%$keyword%' OR B.full_name like '%$keyword%' OR B.mobile_no like '%$keyword%' OR C.full_name like '%$keyword%' OR D.grievance_name like '%$keyword%')
						ORDER BY A.`grievance_date` DESC";
						
			$query= $cquery." LIMIT $offset, $rowcount";
		}
		if ($status!='ALL' && $paguthi == 'ALL')
		{
			 $cquery="SELECT
						A.id,
						F.paguthi_name,
						A.grievance_type,
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
						A.constituent_id = B.id AND A.created_by = C.id AND A.grievance_type_id = D.id AND C.role_id = E.id AND A.paguthi_id = F.id AND A.status = '$status' AND (`grievance_date` BETWEEN '$from_date' AND '$to_date') 
						AND (A.status like '%$keyword%' OR  A.petition_enquiry_no like '%$keyword%' OR A.grievance_date like '%$keyword%' OR B.full_name like '%$keyword%' OR B.mobile_no like '%$keyword%' OR C.full_name like '%$keyword%' OR D.grievance_name like '%$keyword%')
						ORDER BY A.`grievance_date` DESC";
						
			$query= $cquery." LIMIT $offset, $rowcount";
		}
		if ($status!='ALL' && $paguthi != 'ALL')
		{
			 $cquery="SELECT
						A.id,
						F.paguthi_name,
						A.grievance_type,
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
						A.constituent_id = B.id AND A.created_by = C.id AND A.grievance_type_id = D.id AND C.role_id = E.id AND A.paguthi_id = F.id AND A.status = '$status' AND A.paguthi_id = '$paguthi' AND (`grievance_date` BETWEEN '$from_date' AND '$to_date') 
						AND (A.status like '%$keyword%' OR  A.petition_enquiry_no like '%$keyword%' OR A.grievance_date like '%$keyword%' OR B.full_name like '%$keyword%' OR B.mobile_no like '%$keyword%' OR C.full_name like '%$keyword%' OR D.grievance_name like '%$keyword%')
						ORDER BY A.`grievance_date` DESC";
						
			$query= $cquery." LIMIT $offset, $rowcount";
		}
		
		$resultset_count=$this->db->query($cquery);
		$result_count = $resultset_count->num_rows();
		
		$resultset=$this->db->query($query);
		$report_result = $resultset->result();
		if($resultset->num_rows()>0)
			{
				$response = array("status" => "Success", "msg" => "Status based report","result_count" =>$result_count,"report_list" =>$report_result);
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
						A.grievance_type,
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
						A.grievance_type,
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
	
	function Report_categorynew($from_date,$to_date,$category,$offset,$rowcount){

		$dateTime1 = new DateTime($from_date);
		$from_date=date_format($dateTime1,'Y-m-d' );
		
		$dateTime2 = new DateTime($to_date);
		$to_date=date_format($dateTime2,'Y-m-d' );
		
		if ($category=='ALL')
		{
			$cquery="SELECT
						A.id,
						F.paguthi_name,
						A.grievance_type,
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
		
			$query= $cquery." LIMIT $offset, $rowcount";
		
		}
		if ($category != 'ALL')
		{
			$cquery="SELECT
						A.id,
						F.paguthi_name,
						A.grievance_type,
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
			
			$query= $cquery." LIMIT $offset, $rowcount";
		}
		
		$resultset_count=$this->db->query($cquery);
		$result_count = $resultset_count->num_rows();
		
		$resultset=$this->db->query($query);
		$report_result = $resultset->result();
		
		if($resultset->num_rows()>0)
			{
				$response = array("status" => "Success", "msg" => "Category based report","result_count" =>$result_count,"report_list" =>$report_result);
			} else {
				$response = array("status" => "Error", "msg" => "No records found");
			}
	
		return $response;
	}
	
	function Report_categorysearch($from_date,$to_date,$category,$keyword,$offset,$rowcount){

		$dateTime1 = new DateTime($from_date);
		$from_date=date_format($dateTime1,'Y-m-d' );
		
		$dateTime2 = new DateTime($to_date);
		$to_date=date_format($dateTime2,'Y-m-d' );
		
		if ($category=='ALL')
		{
			 $cquery="SELECT
						A.id,
						F.paguthi_name,
						A.grievance_type,
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
						A.constituent_id = B.id AND A.created_by = C.id AND A.grievance_type_id = D.id AND C.role_id = E.id AND A.paguthi_id = F.id AND (`grievance_date` BETWEEN '$from_date' AND '$to_date') 
						AND (A.status like '%$keyword%' OR  A.petition_enquiry_no like '%$keyword%' OR A.grievance_date like '%$keyword%' OR B.full_name like '%$keyword%' OR B.mobile_no like '%$keyword%' OR C.full_name like '%$keyword%' OR D.grievance_name like '%$keyword%')
						ORDER BY A.`grievance_date` DESC";
						
			$query= $cquery." LIMIT $offset, $rowcount";
		}
		if ($category != 'ALL')
		{
			 $cquery="SELECT
						A.id,
						F.paguthi_name,
						A.grievance_type,
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
						A.constituent_id = B.id AND A.created_by = C.id AND A.grievance_type_id = D.id AND C.role_id = E.id AND A.paguthi_id = F.id AND A.grievance_type_id = '$category' AND (`grievance_date` BETWEEN '$from_date' AND '$to_date') 
						AND (A.status like '%$keyword%' OR  A.petition_enquiry_no like '%$keyword%' OR A.grievance_date like '%$keyword%' OR B.full_name like '%$keyword%' OR B.mobile_no like '%$keyword%' OR C.full_name like '%$keyword%' OR D.grievance_name like '%$keyword%')
						ORDER BY A.`grievance_date` DESC";
						
				$query= $cquery." LIMIT $offset, $rowcount";
		}
		
		
		$resultset_count=$this->db->query($cquery);
		$result_count = $resultset_count->num_rows();
		
		$resultset=$this->db->query($query);
		$report_result = $resultset->result();
		
		if($resultset->num_rows()>0)
			{
				$response = array("status" => "Success", "msg" => "Category based report","result_count" =>$result_count,"report_list" =>$report_result);
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
						A.grievance_type,
						A.petition_enquiry_no,
						A.grievance_date,
						A.status,
						B.full_name,
						B.mobile_no,
						C.full_name AS created_by,
						G.grievance_name,
						D.sub_category_name,
						E.role_name
					FROM
						grievance A,
						constituent B,
						user_master C,
						grievance_type G,
						grievance_sub_category D,
						role_master E,
						paguthi F
					WHERE
						A.constituent_id = B.id AND A.created_by = C.id AND A.grievance_type_id = G.id AND A.sub_category_id = D.id AND C.role_id = E.id AND A.paguthi_id = F.id AND (`grievance_date` BETWEEN '$from_date' AND '$to_date') ORDER BY A.`grievance_date` DESC";
		}
		if ($sub_category != 'ALL')
		{
			$query="SELECT
						A.id,
						F.paguthi_name,
						A.grievance_type,
						A.petition_enquiry_no,
						A.grievance_date,
						A.status,
						B.full_name,
						B.mobile_no,
						C.full_name AS created_by,
						G.grievance_name,
						D.sub_category_name,
						E.role_name
					FROM
						grievance A,
						constituent B,
						user_master C,
						grievance_type G,
						grievance_sub_category D,
						role_master E,
						paguthi F
					WHERE
						A.constituent_id = B.id AND A.created_by = C.id AND A.grievance_type_id = G.id AND A.sub_category_id = D.id AND C.role_id = E.id AND A.paguthi_id = F.id AND A.sub_category_id = '$sub_category' AND (`grievance_date` BETWEEN '$from_date' AND '$to_date') ORDER BY A.`grievance_date` DESC";
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
	
	function Report_subcategorynew($from_date,$to_date,$sub_category,$offset,$rowcount){

		$dateTime1 = new DateTime($from_date);
		$from_date=date_format($dateTime1,'Y-m-d' );
		
		$dateTime2 = new DateTime($to_date);
		$to_date=date_format($dateTime2,'Y-m-d' );
		
		if ($sub_category=='ALL')
		{
			$cquery="SELECT
						A.id,
						F.paguthi_name,
						A.grievance_type,
						A.petition_enquiry_no,
						A.grievance_date,
						A.status,
						B.full_name,
						B.mobile_no,
						C.full_name AS created_by,
						G.grievance_name,
						D.sub_category_name,
						E.role_name
					FROM
						grievance A,
						constituent B,
						user_master C,
						grievance_type G,
						grievance_sub_category D,
						role_master E,
						paguthi F
					WHERE
						A.constituent_id = B.id AND A.created_by = C.id AND A.grievance_type_id = G.id AND A.sub_category_id = D.id AND C.role_id = E.id AND A.paguthi_id = F.id AND (`grievance_date` BETWEEN '$from_date' AND '$to_date') ORDER BY A.`grievance_date` DESC";
			
			$query= $cquery." LIMIT $offset, $rowcount";
		}
		if ($sub_category != 'ALL')
		{
			$cquery="SELECT
						A.id,
						F.paguthi_name,
						A.grievance_type,
						A.petition_enquiry_no,
						A.grievance_date,
						A.status,
						B.full_name,
						B.mobile_no,
						C.full_name AS created_by,
						G.grievance_name,
						D.sub_category_name,
						E.role_name
					FROM
						grievance A,
						constituent B,
						user_master C,
						grievance_type G,
						grievance_sub_category D,
						role_master E,
						paguthi F
					WHERE
						A.constituent_id = B.id AND A.created_by = C.id AND A.grievance_type_id = G.id AND A.sub_category_id = D.id AND C.role_id = E.id AND A.paguthi_id = F.id AND A.sub_category_id = '$sub_category' AND (`grievance_date` BETWEEN '$from_date' AND '$to_date') ORDER BY A.`grievance_date` DESC";
			
			$query= $cquery." LIMIT $offset, $rowcount";			
		}
		
		$resultset_count=$this->db->query($cquery);
		$result_count = $resultset_count->num_rows();
		
		$resultset=$this->db->query($query);
		$report_result = $resultset->result();
		
		if($resultset->num_rows()>0)
			{
				$response = array("status" => "Success", "msg" => "Sub Category based report","result_count" =>$result_count,"report_list" =>$report_result);
			} else {
				$response = array("status" => "Error", "msg" => "No records found");
			}
		
		return $response;
	}
	
	function Report_subcategorysearch($from_date,$to_date,$sub_category,$keyword,$offset,$rowcount){

		$dateTime1 = new DateTime($from_date);
		$from_date=date_format($dateTime1,'Y-m-d' );
		
		$dateTime2 = new DateTime($to_date);
		$to_date=date_format($dateTime2,'Y-m-d' );
		
		if ($sub_category=='ALL')
		{
			$cquery="SELECT
						A.id,
						F.paguthi_name,
						A.grievance_type,
						A.petition_enquiry_no,
						A.grievance_date,
						A.status,
						B.full_name,
						B.mobile_no,
						C.full_name AS created_by,
						G.grievance_name,
						D.sub_category_name,
						E.role_name
					FROM
						grievance A,
						constituent B,
						user_master C,
						grievance_type G,
						grievance_sub_category D,
						role_master E,
						paguthi F
					WHERE
						A.constituent_id = B.id AND A.created_by = C.id AND A.grievance_type_id = G.id AND A.sub_category_id = D.id AND C.role_id = E.id AND A.paguthi_id = F.id AND (`grievance_date` BETWEEN '$from_date' AND '$to_date') 
						AND (A.status like '%$keyword%' OR  A.petition_enquiry_no like '%$keyword%' OR A.grievance_date like '%$keyword%' OR B.full_name like '%$keyword%' OR B.mobile_no like '%$keyword%' OR C.full_name like '%$keyword%' OR D.sub_category_name like '%$keyword%') 
						ORDER BY A.`grievance_date` DESC";
						
			$query= $cquery." LIMIT $offset, $rowcount";
		}
		if ($sub_category != 'ALL')
		{
			$cquery="SELECT
						A.id,
						F.paguthi_name,
						A.grievance_type,
						A.petition_enquiry_no,
						A.grievance_date,
						A.status,
						B.full_name,
						B.mobile_no,
						C.full_name AS created_by,
						G.grievance_name,
						D.sub_category_name,
						E.role_name
					FROM
						grievance A,
						constituent B,
						user_master C,
						grievance_type G,
						grievance_sub_category D,
						role_master E,
						paguthi F
					WHERE
						A.constituent_id = B.id AND A.created_by = C.id AND A.grievance_type_id = G.id AND A.sub_category_id = D.id AND C.role_id = E.id AND A.paguthi_id = F.id AND A.sub_category_id = '$sub_category' AND (`grievance_date` BETWEEN '$from_date' AND '$to_date') 
						AND (A.status like '%$keyword%' OR  A.petition_enquiry_no like '%$keyword%' OR A.grievance_date like '%$keyword%' OR B.full_name like '%$keyword%' OR B.mobile_no like '%$keyword%' OR C.full_name like '%$keyword%' OR D.sub_category_name like '%$keyword%') 
						ORDER BY A.`grievance_date` DESC";
						
			$query= $cquery." LIMIT $offset, $rowcount";
		}
		
		$resultset_count=$this->db->query($cquery);
		$result_count = $resultset_count->num_rows();
		
		$resultset=$this->db->query($query);
		$report_result = $resultset->result();
		
		if($resultset->num_rows()>0)
			{
				$response = array("status" => "Success", "msg" => "Sub Category based report","result_count" =>$result_count,"report_list" =>$report_result);
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
					A.grievance_type,
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
					A.grievance_type,
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
	
	function Report_locationnew($from_date,$to_date,$paguthi,$offset,$rowcount){

		$dateTime1 = new DateTime($from_date);
		$from_date=date_format($dateTime1,'Y-m-d' );
		
		$dateTime2 = new DateTime($to_date);
		$to_date=date_format($dateTime2,'Y-m-d' );
		
		if ($paguthi=='ALL')
		{
			$cquery="SELECT
					A.id,
					F.paguthi_name,
					A.grievance_type,
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
					
			$query= $cquery." LIMIT $offset, $rowcount";
		}
		if ($paguthi != 'ALL')
		{
			$cquery="SELECT
					A.id,
					F.paguthi_name,
					A.grievance_type,
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
					
			$query= $cquery." LIMIT $offset, $rowcount";
		}
		
		$resultset_count=$this->db->query($cquery);
		$result_count = $resultset_count->num_rows();
		
		$resultset=$this->db->query($query);
		$report_result = $resultset->result();
		
		if($resultset->num_rows()>0)
		{
			$response = array("status" => "Success", "msg" => "Location based report","result_count" =>$result_count,"report_list" =>$report_result);
		} else {
			$response = array("status" => "Error", "msg" => "No records found");
		}
			
		return $response;
	}
	
	
	function Report_locationsearch($from_date,$to_date,$paguthi,$keyword,$offset,$rowcount){

		$dateTime1 = new DateTime($from_date);
		$from_date=date_format($dateTime1,'Y-m-d' );
		
		$dateTime2 = new DateTime($to_date);
		$to_date=date_format($dateTime2,'Y-m-d' );
		
		if ($paguthi=='ALL')
		{
			$cquery="SELECT
					A.id,
					F.paguthi_name,
					A.grievance_type,
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
					A.constituent_id = B.id AND A.created_by = C.id AND A.grievance_type_id = D.id AND C.role_id = E.id AND A.paguthi_id = F.id AND (`grievance_date` BETWEEN '$from_date' AND '$to_date') 
					AND (A.status like '%$keyword%' OR  A.petition_enquiry_no like '%$keyword%' OR A.grievance_date like '%$keyword%' OR B.full_name like '%$keyword%' OR B.mobile_no like '%$keyword%' OR C.full_name like '%$keyword%' OR D.grievance_name like '%$keyword%') 
					ORDER BY A.`grievance_date` DESC";
					
			$query= $cquery." LIMIT $offset, $rowcount";
		}
		if ($paguthi != 'ALL')
		{
			$cquery="SELECT
					A.id,
					F.paguthi_name,
					A.grievance_type,
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
					A.constituent_id = B.id AND A.created_by = C.id AND A.grievance_type_id = D.id AND C.role_id = E.id AND A.paguthi_id = F.id AND A.paguthi_id = '$paguthi' AND (`grievance_date` BETWEEN '$from_date' AND '$to_date') 
					AND (A.status like '%$keyword%' OR  A.petition_enquiry_no like '%$keyword%' OR A.grievance_date like '%$keyword%' OR B.full_name like '%$keyword%' OR B.mobile_no like '%$keyword%' OR C.full_name like '%$keyword%' OR D.grievance_name like '%$keyword%') 
					ORDER BY A.`grievance_date` DESC";
					
			$query= $cquery." LIMIT $offset, $rowcount";
		}
		
		$resultset_count=$this->db->query($cquery);
		$result_count = $resultset_count->num_rows();
		
		$resultset=$this->db->query($query);
		$report_result = $resultset->result();
		
		if($resultset->num_rows()>0)
		{
			$response = array("status" => "Success", "msg" => "Location based report","result_count" =>$result_count,"report_list" =>$report_result);
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
					A.id,
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
					A.constituent_id = B.id AND A.created_by = C.id AND B.paguthi_id = D.id AND(A.meeting_date BETWEEN '$from_date' AND '$to_date')
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
	
	function Report_meetingsnew($from_date,$to_date,$offset,$rowcount){

		$dateTime1 = new DateTime($from_date);
		$from_date=date_format($dateTime1,'Y-m-d' );
		
		$dateTime2 = new DateTime($to_date);
		$to_date=date_format($dateTime2,'Y-m-d' );
		
		$cquery="SELECT
					A.id,
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
					A.constituent_id = B.id AND A.created_by = C.id AND B.paguthi_id = D.id AND(A.meeting_date BETWEEN '$from_date' AND '$to_date')
				ORDER BY
					A.meeting_date
				DESC";
				
		$query= $cquery." LIMIT $offset, $rowcount";
				
		$resultset_count=$this->db->query($cquery);
		$result_count = $resultset_count->num_rows();
		
		$resultset=$this->db->query($query);
		$report_result = $resultset->result();
		
		if($resultset->num_rows()>0)
		{
			$response = array("status" => "Success", "msg" => "Meetings report","result_count" =>$result_count,"report_list" =>$report_result);
		} else {
			$response = array("status" => "Error", "msg" => "No records found");
		}
		return $response;
	}
	
	
	function Report_meetingssearch($from_date,$to_date,$keyword,$offset,$rowcount){

		$dateTime1 = new DateTime($from_date);
		$from_date=date_format($dateTime1,'Y-m-d' );
		
		$dateTime2 = new DateTime($to_date);
		$to_date=date_format($dateTime2,'Y-m-d' );
		
		$cquery="SELECT
					A.id,
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
					A.constituent_id = B.id AND A.created_by = C.id AND B.paguthi_id = D.id AND(A.meeting_date BETWEEN '$from_date' AND '$to_date')
					AND (A.meeting_status like '%$keyword%' OR  A.meeting_date like '%$keyword%' OR A.meeting_title like '%$keyword%' OR B.full_name like '%$keyword%' OR C.full_name like '%$keyword%' OR D.paguthi_name like '%$keyword%') 
				ORDER BY
					A.meeting_date
				DESC";
				
		$query= $cquery." LIMIT $offset, $rowcount";
				
		$resultset_count=$this->db->query($cquery);
		$result_count = $resultset_count->num_rows();
		
		$resultset=$this->db->query($query);
		$report_result = $resultset->result();
		
		if($resultset->num_rows()>0)
		{
			$response = array("status" => "Success", "msg" => "Meetings report","result_count" =>$result_count,"report_list" =>$report_result);
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
	
	function Report_birthdaynew($selMonth,$offset,$rowcount){

		$year = date("Y"); 
		
		$cquery="SELECT * FROM constituent WHERE MONTH(dob) = '$selMonth'";

		$query= $cquery." LIMIT $offset, $rowcount";
				
		$resultset_count=$this->db->query($cquery);
		$result_count = $resultset_count->num_rows();
		
		$resultset=$this->db->query($query);
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
	
	
	function Report_birthdaysearch($selMonth,$keyword,$offset,$rowcount){

		$year = date("Y"); 	
	
		$cquery="SELECT * FROM constituent WHERE MONTH(dob) = '$selMonth' AND (full_name LIKE '%$keyword%' OR father_husband_name LIKE '%$keyword%' OR guardian_name LIKE '%$keyword%' OR mobile_no LIKE '%$keyword%' OR whatsapp_no LIKE '%$keyword%' OR door_no LIKE '%$keyword%' OR address LIKE '%$keyword%' OR pin_code LIKE '%$keyword%' OR email_id LIKE '%$keyword%' OR voter_id_no LIKE '%$keyword%' OR aadhaar_no LIKE '%$keyword%' OR serial_no LIKE '%$keyword%')";
		
		$query= $cquery." LIMIT $offset, $rowcount";
		
		$resultset_count=$this->db->query($cquery);
		$result_count = $resultset_count->num_rows();
		
		$resultset=$this->db->query($query);
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


//#################### Category and Sub Category ####################//	
	function Active_category()
	{
		$query="SELECT * FROM `grievance_type` WHERE status='ACTIVE'";
		$resultset=$this->db->query($query);
		$category_result = $resultset->result();
		if($resultset->num_rows()>0)
			{
				$response = array("status" => "Success", "msg" => "List Category", "category_details" =>$category_result);
			} else {
				$response = array("status" => "Error", "msg" => "No records found");
			}
		return $response;
	}
	
	function Active_subcategory()
	{
		$query="SELECT * FROM `grievance_sub_category` WHERE status='ACTIVE'";
		$resultset=$this->db->query($query);
		$sub_category_result = $resultset->result();
		if($resultset->num_rows()>0)
			{
				$response = array("status" => "Success", "msg" => "List Sub Category", "sub_category_details" =>$sub_category_result);
			} else {
				$response = array("status" => "Error", "msg" => "No records found");
			}
		return $response;
	}
	
	//#################### Category and Sub Category End ####################//
	
} 

?>
