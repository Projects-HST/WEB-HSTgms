<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Apigmsmodel extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }


//#################### Email ####################//

	public function sendMail($to,$subject,$email_message)
	{
		// Set content-type header for sending HTML email
		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
		// Additional headers
		$headers .= 'From: GMS Admin<admin@gms.com>' . "\r\n";
		mail($to,$subject,$email_message,$headers);
	}

//#################### Email End ####################//


//#################### Notification ####################//

	public function sendNotification($gcm_key,$Title,$Message,$mobiletype)
	{
		if ($mobiletype =='1'){

		    require_once 'assets/notification/Firebase.php';
            require_once 'assets/notification/Push.php';

            $device_token = explode(",", $gcm_key);
            $push = null;

//        //first check if the push has an image with it
		     $push = new Push(
					$Title,
					$Message,
					'https://heylaapp.com/testing/assets/notification/images/event.JPG'
				);

// 			//if the push don't have an image give null in place of image
 			 /* $push = new Push(
 			 		'HEYLA',
 			 		'Hi Testing from maran',
 			 		null
 			 	); */

    		//getting the push from push object
    		$mPushNotification = $push->getPush();

    		//creating firebase class object
    		$firebase = new Firebase();

    	foreach($device_token as $token) {
    		 $firebase->send(array($token),$mPushNotification);
    	}

		} else {

			$device_token = explode(",", $gcm_key);
			$passphrase = 'hs123';
		    $loction ='assets/notification/heylaapp.pem';

			$ctx = stream_context_create();
			stream_context_set_option($ctx, 'ssl', 'local_cert', $loction);
			stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);

			// Open a connection to the APNS server
			$fp = stream_socket_client('ssl://gateway.sandbox.push.apple.com:2195', $err, $errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);

			if (!$fp)
				exit("Failed to connect: $err $errstr" . PHP_EOL);

			$body['aps'] = array(
				'alert' => array(
					'body' => $Message,
					'action-loc-key' => 'Heyla App',
				),
				'badge' => 2,
				'sound' => 'assets/notification/oven.caf',
				);

			$payload = json_encode($body);

			foreach($device_token as $token) {

				// Build the binary notification
    			$msg = chr(0) . pack("n", 32) . pack("H*", str_replace(" ", "", $token)) . pack("n", strlen($payload)) . $payload;
        		$result = fwrite($fp, $msg, strlen($msg));
			}

				fclose($fp);
		}
	}

//#################### Notification End ####################//


//#################### SMS ####################//

	public function sendSMS($to_phone,$smsContent)
	{
        //Your authentication key
        $authKey = "308533AMShxOBgKSt75df73187";

        //Multiple mobiles numbers separated by comma
        $mobileNumber = "$to_phone";

        //Sender ID,While using route4 sender id should be 6 characters long.
        $senderId = "GADMIN";

        //Your message to send, Add URL encoding here.
        $message = urlencode($smsContent);

        //Define route
        $route = "transactional";

        //Prepare you post parameters
        $postData = array(
            'authkey'=> $authKey,
            'mobiles'=> $mobileNumber,
            'message'=> $message,
            'sender'=> $senderId,
            'route'=> $route
        );

        //API URL
        $url="https://control.msg91.com/api/sendhttp.php";

        // init the resource
        $ch = curl_init();
        curl_setopt_array($ch, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $postData
            //,CURLOPT_FOLLOWLOCATION => true
        ));



        //Ignore SSL certificate verification
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);


        //get response
        $output = curl_exec($ch);

        //Print error if any
        if(curl_errno($ch))
        {
            echo 'error:' . curl_error($ch);
        }

        curl_close($ch);
	}

//#################### SMS End ####################//

//#################### List Details ####################//
	function List_role()
	{
		$query="SELECT * FROM `role_master` WHERE status='ACTIVE'";
		$resultset=$this->db->query($query);
		$role_result = $resultset->result();
			if($resultset->num_rows()>0)
			{
				$response = array("status" => "Success", "msg" => "List Role", "role_details" =>$role_result);
			} else {
				$response = array("status" => "Error", "msg" => "No records found");
			}
		return $response;
	}
	
//#################### List Details End ####################//


//#################### Main Login ####################//
	public function Login($username,$password,$gcm_key,$mobile_type)
	{
	  
	    $sql = "SELECT * FROM user_master WHERE email_id ='$username' AND password = md5('".$password."')";
		$user_result = $this->db->query($sql);
		$ress = $user_result->result();
		if($user_result->num_rows()>0)
		{
			$check_status="SELECT * FROM user_master WHERE email_id='$username' AND status='INACTIVE'";
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
				
				$gcmQuery = "SELECT * FROM push_notification_master WHERE gcm_key like '%" .$gcm_key. "%' LIMIT 1";
				$gcm_result = $this->db->query($gcmQuery);
				$gcm_ress = $gcm_result->result();

				if($gcm_result->num_rows()==0)
				{
					$sQuery = "INSERT INTO push_notification_master (user_id,gcm_key,mobile_type) VALUES ('". $user_id . "','". $gcm_key . "','". $mobile_type . "')";
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
			$response = array("status" => "Error", "msg" => "Invalid credentials!");
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

    		$sql = "SELECT * FROM user_master WHERE email_id ='".$user_name."'AND status='ACTIVE'";
    		$user_result = $this->db->query($sql);
    		$ress = $user_result->result();
    		if($user_result->num_rows()>0)
    		{
    			foreach ($user_result->result() as $rows)
    			{
					$user_id = $rows->id;
					$mobile_no = $rows->phone_number;
					$name = $row->full_name;
					$user_type = $row->role_id ;
					$to_email = $row->email_id ;
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
			
				$this->sendMail($to_email,$subject,$htmlContent);
				$this->sendSMS($to_phone,$smsContent);
				$response = array("status" => "success", "msg" => "Reset Password");
    		}else {
				$response = array("status" => "error", "msg" => "Username not found");
			}
			return $response;
	}
//#################### Forgot Password End ####################//


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
			}
		}
		if ($email!=""){
			if ($old_email_id != $email){
					$update = "UPDATE user_master SET full_name='$name',gender='$gender',address='$address',email_id='$email',phone_number='$phone',updated_at=NOW(),updated_by='$user_id' WHERE id='$user_id'";
					$result = $this->db->query($update);
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
					
					$this->sendMail($email,$subject,$htmlContent);
					$this->sendSMS($to_phone,$smsContent);
				}else {
						$update = "UPDATE user_master SET full_name='$name',gender='$gender',address='$address',phone_number='$phone',updated_at=NOW(),updated_by='$user_id' WHERE id='$user_id'";
						$result = $this->db->query($update);
				}
			}
			else{
					$update = "UPDATE user_master SET full_name='$name',gender='$gender',address='$address',phone_number='$phone',updated_at=NOW(),updated_by='$user_id' WHERE id='$user_id'";
					$result = $this->db->query($update);
			}
		
		$response = array("status" => "success", "msg" => "Profile Updated");
		return $response;
	}
//#################### Profile Update End ####################//


//#################### Change Password ####################//
	public function Change_password($user_id,$password,$oldpassword){
		$check="SELECT * FROM user_master WHERE id='$user_id' AND password=md5('$oldpassword')";
		$res_check=$this->db->query($check);
		if($res_check->num_rows()>0){

		  $update_sql = "UPDATE user_master SET password = md5('$password'),updated_at=NOW() WHERE id='$user_id'";
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

//#################### Dashboard ####################//

	function Dashboard($paguthi)
	{
		if ($paguthi == 'All')
		{
			$constituent_count = "SELECT * FROM constituent WHERE constituency_id = '1'";
			$constituent_count_res = $this->db->query($constituent_count);
			$constituent_count = $constituent_count_res->num_rows();
			
			$constituent_mcount = "SELECT * FROM constituent WHERE constituency_id = '1' AND gender = 'M'";
			$constituent_mcount_res = $this->db->query($constituent_mcount);
			$constituent_mcount = $constituent_mcount_res->num_rows();
			
			$constituent_fcount = "SELECT * FROM constituent WHERE constituency_id = '1' AND gender = 'F'";
			$constituent_fcount_res = $this->db->query($constituent_fcount);
			$constituent_fcount = $constituent_fcount_res->num_rows();
			
			$constituent_vcount = "SELECT * FROM constituent WHERE constituency_id = '1' AND voter_id_status = 'Y'";
			$constituent_vcount_res = $this->db->query($constituent_vcount);
			$constituent_vcount = $constituent_vcount_res->num_rows();
			
			$constituent_acount = "SELECT * FROM constituent WHERE constituency_id = '1' AND aadhaar_status = 'Y'";
			$constituent_acount_res = $this->db->query($constituent_acount);
			$constituent_acount = $constituent_acount_res->num_rows();
			
			$meeting_count = "SELECT * FROM meeting_request";
			$meeting_count_res = $this->db->query($meeting_count);
			$meeting_count = $meeting_count_res->num_rows();
			
			$meeting_rcount = "SELECT * FROM meeting_request WHERE meeting_status = 'REQUESTED'";
			$meeting_rcount_res = $this->db->query($meeting_rcount);
			$meeting_rcount = $meeting_rcount_res->num_rows();

			$meeting_ccount = "SELECT * FROM meeting_request WHERE meeting_status = 'COMPLETED'";
			$meeting_ccount_res = $this->db->query($meeting_ccount);
			$meeting_ccount = $meeting_ccount_res->num_rows();
			
			$grievance_count = "SELECT * FROM grievance";
			$grievance_count_res = $this->db->query($grievance_count);
			$grievance_count = $grievance_count_res->num_rows();
			
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
			
			$interactioncount = "SELECT * FROM interaction_history WHERE question_response = 'Y'";
			$interactioncount_res = $this->db->query($interactioncount);
			$interactioncount = $interactioncount_res->num_rows();

			$result  = array(
					"con_count" => $constituent_count,
					"conm_count" => $constituent_mcount,
					"conf_count" => $constituent_fcount,
					"conv_count" => $constituent_vcount,
					"cona_count" => $constituent_acount,
					"meet_count" => $meeting_count,
					"meet_rcount" => $meeting_rcount,
					"meet_ccount" => $meeting_ccount,
					"grev_count" => $grievance_count,
					"grev_ecount" => $grievance_ecount,
					"grev_pcount" => $grievance_pcount,
					"grev_processcount" => $grievance_processcount,
					"grev_completecount" => $grievance_completecount,
					"interaction_count" => $interactioncount
				);
			
			
			$query="SELECT
						A.`question_id`,
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
			
			
			$s_query = "SELECT
							count(*) AS total,
							DATE_FORMAT(grievance_date, '%M %Y') AS disp_month,
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

			$response = array("status" => "Success", "msg" => "Dashboard Details", "dashboard_details" => $result,"interaction_details" =>$int_result, "footfall_graph" =>$footfall_graph, "grievance_graph" =>$grievance_graph,"meeting_graph" =>$meeting_graph);
		} else {
			$constituent_count = "SELECT * FROM constituent WHERE constituency_id = '1' AND paguthi_id = '$paguthi' ";
			$constituent_count_res = $this->db->query($constituent_count);
			$constituent_count = $constituent_count_res->num_rows();
			
			$constituent_mcount = "SELECT * FROM constituent WHERE constituency_id = '1' AND gender = 'M' AND paguthi_id = '$paguthi'";
			$constituent_mcount_res = $this->db->query($constituent_mcount);
			$constituent_mcount = $constituent_mcount_res->num_rows();
			
			$constituent_fcount = "SELECT * FROM constituent WHERE constituency_id = '1' AND gender = 'F' AND paguthi_id = '$paguthi'";
			$constituent_fcount_res = $this->db->query($constituent_fcount);
			$constituent_fcount = $constituent_fcount_res->num_rows();
			
			$constituent_vcount = "SELECT * FROM constituent WHERE constituency_id = '1' AND voter_id_status = 'Y' AND paguthi_id = '$paguthi'";
			$constituent_vcount_res = $this->db->query($constituent_vcount);
			$constituent_vcount = $constituent_vcount_res->num_rows();
			
			$constituent_acount = "SELECT * FROM constituent WHERE constituency_id = '1' AND aadhaar_status = 'Y' AND paguthi_id = '$paguthi'";
			$constituent_acount_res = $this->db->query($constituent_acount);
			$constituent_acount = $constituent_acount_res->num_rows();
			
			$meeting_count = "SELECT * FROM meeting_request A, constituent B WHERE A.constituent_id = B.id AND B.paguthi_id ='$paguthi' ";
			$meeting_count_res = $this->db->query($meeting_count);
			$meeting_count = $meeting_count_res->num_rows();
			
			$meeting_rcount = "SELECT * FROM meeting_request A, constituent B WHERE A.constituent_id = B.id AND B.paguthi_id ='$paguthi' AND A.meeting_status = 'REQUESTED' ";
			$meeting_rcount_res = $this->db->query($meeting_rcount);
			$meeting_rcount = $meeting_rcount_res->num_rows();
			
			$meeting_ccount = "SELECT * FROM meeting_request A, constituent B WHERE A.constituent_id = B.id AND B.paguthi_id ='$paguthi' AND A.meeting_status = 'COMPLETED'";
			$meeting_ccount_res = $this->db->query($meeting_ccount);
			$meeting_ccount = $meeting_ccount_res->num_rows();
			
			$grievance_count = "SELECT * FROM grievance WHERE paguthi_id = '$paguthi'";
			$grievance_count_res = $this->db->query($grievance_count);
			$grievance_count = $grievance_count_res->num_rows();
			
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
					"con_count" => $constituent_count,
					"conm_count" => $constituent_mcount,
					"conf_count" => $constituent_fcount,
					"conv_count" => $constituent_vcount,
					"cona_count" => $constituent_acount,
					"meet_count" => $meeting_count,
					"meet_rcount" => $meeting_rcount,
					"meet_ccount" => $meeting_ccount,
					"grev_count" => $grievance_count,
					"grev_ecount" => $grievance_ecount,
					"grev_pcount" => $grievance_pcount,
					"grev_processcount" => $grievance_processcount,
					"grev_completecount" => $grievance_completecount,
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
							DATE_FORMAT(grievance_date, '%M %Y') AS disp_month,
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
		
			$response = array("status" => "Success", "msg" => "Dashboard Details", "dashboard_details" => $result,"interaction_details" =>$int_result, "footfall_graph" =>$footfall_graph, "grievance_graph" =>$grievance_graph,"meeting_graph" =>$meeting_graph);
		}
		return $response;
	}

//#################### Dashboard End ####################//

//#################### Constituency ####################//
	function Edit_constituency($constituency_id)
	{
		$query="SELECT * FROM `constituency` WHERE id='$constituency_id' AND status='ACTIVE'";
		$resultset=$this->db->query($query);
		$constituency_result = $resultset->result();
		if($resultset->num_rows()>0)
			{
				$response = array("status" => "Success", "msg" => "Constituency Details", "constituency_details" =>$constituency_result);
			} else {
				$response = array("status" => "Error", "msg" => "No records found");
			}
		return $response;
	}
	
	function Update_constituency($user_id,$constituency_id,$constituency_name)
	{
		$update_sql = "UPDATE constituency SET constituency_name='$constituency_name',updated_by='$user_id',updated_at=NOW() WHERE id='$constituency_id'";
		$update_result = $this->db->query($update_sql);
		$response = array("status" => "Success", "msg" => "Constituency Updated");
		return $response;
	}

//#################### Constituency End ####################//


//#################### Paguthi ####################//
	function Add_paguthi($user_id,$constituency_id,$paguthi_name,$paguthi_short_name,$status)
	{
		$query="SELECT * FROM `paguthi` WHERE paguthi_name='$paguthi_name'";
		$resultset=$this->db->query($query);
		if($resultset->num_rows()>0)
			{
				$response = array("status" => "Error", "msg" => "Paguthi name exist");
			} else {
				$query="SELECT * FROM `paguthi` WHERE paguthi_short_name='$paguthi_short_name'";
				$resultset=$this->db->query($query);
				if($resultset->num_rows()>0)
					{
						$response = array("status" => "Error", "msg" => "Paguthi short name exist");
					} else {
						$sQuery = "INSERT INTO paguthi (constituency_id,paguthi_name,paguthi_short_name,status,created_at,created_by) VALUES ('$constituency_id','$paguthi_name','$paguthi_short_name','$status',NOW(),'$user_id')";
						$add_Query = $this->db->query($sQuery);
						
						$response = array("status" => "Success", "msg" => "Paguthi added");
					}
			}
		return $response;
	}

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
	
	function Edit_paguthi($paguthi_id)
	{
		$query="SELECT * FROM `paguthi` WHERE id='$paguthi_id'";
		$resultset=$this->db->query($query);
		$paguthi_result = $resultset->result();
		if($resultset->num_rows()>0)
			{
				$response = array("status" => "Success", "msg" => "Paguthi Details", "paguthi_details" =>$paguthi_result);
			} else {
				$response = array("status" => "Error", "msg" => "No records found");
			}
		return $response;
	}
	
	function Update_paguthi($user_id,$paguthi_id,$paguthi_name,$paguthi_short_name,$status)
	{
		$query="SELECT * FROM `paguthi` WHERE paguthi_name='$paguthi_name' AND id!='$paguthi_id'";
		$resultset=$this->db->query($query);
		if($resultset->num_rows()>0)
			{
				$response = array("status" => "Error", "msg" => "Paguthi name exist");
			} else {
				$query="SELECT * FROM `paguthi` WHERE paguthi_short_name='$paguthi_short_name' AND id!='$paguthi_id'";
				$resultset=$this->db->query($query);
				if($resultset->num_rows()>0)
					{
						$response = array("status" => "Error", "msg" => "Paguthi short name exist");
					} else {
							$sQuery = "UPDATE paguthi SET paguthi_name='$paguthi_name',paguthi_short_name='$paguthi_short_name',status='$status',updated_at=NOW(), updated_by='$user_id' WHERE id='$paguthi_id'";
							$update_Query = $this->db->query($sQuery);
						
						$response = array("status" => "Success", "msg" => "Paguthi updated");
					}
			}
		return $response;
	}
	
//#################### Paguthi End ####################//


//#################### Ward ####################//

	function Add_ward($user_id,$constituency_id,$paguthi_id,$ward_name,$status)
	{
		$query="SELECT * FROM `ward` WHERE ward_name='$ward_name'";
		$resultset=$this->db->query($query);
		if($resultset->num_rows()>0)
			{
				$response = array("status" => "Error", "msg" => "Ward name exist");
			} else {
				
						$sQuery = "INSERT INTO ward (constituency_id,paguthi_id,ward_name,status,created_at,created_by) VALUES ('$constituency_id','$paguthi_id','$ward_name','$status',NOW(),'$user_id')";
						$add_Query = $this->db->query($sQuery);
						
						$response = array("status" => "Success", "msg" => "Ward added");
			}
		return $response;
	}

	function List_ward()
	{
		$query="SELECT * FROM `ward`";
		$resultset=$this->db->query($query);
		$ward_result = $resultset->result();
		if($resultset->num_rows()>0)
			{
				$response = array("status" => "Success", "msg" => "List Ward", "ward_details" =>$ward_result);
			} else {
				$response = array("status" => "Error", "msg" => "No records found");
			}
		return $response;
	}
	
	function List_paguthiward($paguthi_id)
	{
		$query="SELECT * FROM `ward` WHERE paguthi_id ='$paguthi_id' AND status='ACTIVE'";
		$resultset=$this->db->query($query);
		$ward_result = $resultset->result();
		if($resultset->num_rows()>0)
			{
				$response = array("status" => "Success", "msg" => "List Ward", "ward_details" =>$ward_result);
			} else {
				$response = array("status" => "Error", "msg" => "No records found");
			}
		return $response;
	}
	
	function Edit_ward($ward_id)
	{
		$query="SELECT * FROM `ward` WHERE id='$ward_id'";
		$resultset=$this->db->query($query);
		$ward_result = $resultset->result();
		if($resultset->num_rows()>0)
			{
				$response = array("status" => "Success", "msg" => "Ward Details", "ward_details" =>$ward_result);
			} else {
				$response = array("status" => "Error", "msg" => "No records found");
			}
		return $response;
	}
	
	function Update_ward($user_id,$paguthi_id,$ward_id,$ward_name,$status)
	{
		$query="SELECT * FROM `ward` WHERE ward_name='$ward_name' AND id!='$ward_id'";
		$resultset=$this->db->query($query);
		if($resultset->num_rows()>0)
			{
				$response = array("status" => "Error", "msg" => "Ward name exist");
			} else {
				$sQuery = "UPDATE ward SET paguthi_id ='$paguthi_id',ward_name='$ward_name',status='$status',updated_at=NOW(), updated_by='$user_id' WHERE id='$ward_id'";
				$update_Query = $this->db->query($sQuery);

				$response = array("status" => "Success", "msg" => "Ward updated");
			}
		return $response;
	}
	
//#################### Ward End ####################//	

//#################### Booth ####################//	

	function Add_booth($user_id,$constituency_id,$paguthi_id,$ward_id,$booth_name,$booth_address,$status)
	{
		$query="SELECT * FROM `booth` WHERE booth_name ='$booth_name' AND ward_id = '$ward_id'";
		$resultset=$this->db->query($query);
		if($resultset->num_rows()>0)
			{
				$response = array("status" => "Error", "msg" => "Booth name exist");
			} else {
				
						$sQuery = "INSERT INTO booth (constituency_id,paguthi_id,ward_id,booth_name,booth_address,status,created_at,created_by) VALUES ('$constituency_id','$paguthi_id','$ward_id','$booth_name','$booth_address','$status',NOW(),'$user_id')";
						$add_Query = $this->db->query($sQuery);
						
						$response = array("status" => "Success", "msg" => "Booth added");
			}
		return $response;
	}

	function List_booth()
	{
		$query="SELECT * FROM `booth`";
		$resultset=$this->db->query($query);
		$booth_result = $resultset->result();
		if($resultset->num_rows()>0)
			{
				$response = array("status" => "Success", "msg" => "List Booth", "booth_details" =>$booth_result);
			} else {
				$response = array("status" => "Error", "msg" => "No records found");
			}
		return $response;
	}
	
	function List_wardbooth($ward_id)
	{
		$query="SELECT * FROM `booth` WHERE ward_id ='$ward_id' AND status='ACTIVE'";
		$resultset=$this->db->query($query);
		$booth_result = $resultset->result();
		if($resultset->num_rows()>0)
			{
				$response = array("status" => "Success", "msg" => "List Booth", "booth_details" =>$booth_result);
			} else {
				$response = array("status" => "Error", "msg" => "No records found");
			}
		return $response;
	}
	
	function Edit_booth($booth_id)
	{
		$query="SELECT * FROM `booth` WHERE id='$booth_id'";
		$resultset=$this->db->query($query);
		$booth_result = $resultset->result();
		if($resultset->num_rows()>0)
			{
				$response = array("status" => "Success", "msg" => "Booth Details", "booth_details" =>$booth_result);
			} else {
				$response = array("status" => "Error", "msg" => "No records found");
			}
		return $response;
	}
	
	function Update_booth($user_id,$ward_id,$booth_id,$booth_name,$booth_address,$status)
	{
		$query="SELECT * FROM `booth` WHERE booth_name='$booth_name' AND ward_id = '$ward_id' AND id!='$booth_id'";
		$resultset=$this->db->query($query);
		if($resultset->num_rows()>0)
			{
				$response = array("status" => "Error", "msg" => "Booth name exist");
			} else {
				$sQuery = "UPDATE booth SET booth_name ='$booth_name',booth_address='$booth_address',status='$status',updated_at=NOW(), updated_by='$user_id' WHERE id='$booth_id'";
				$update_Query = $this->db->query($sQuery);

				$response = array("status" => "Success", "msg" => "Booth updated");
			}
		return $response;
	}
//#################### Booth End####################//	


//#################### Seeker type ####################//	

	function Add_seekertype($user_id,$seekertype,$status)
	{
		$query="SELECT * FROM `seeker_type` WHERE seeker_info ='$seekertype'";
		$resultset=$this->db->query($query);
		if($resultset->num_rows()>0)
			{
				$response = array("status" => "Error", "msg" => "Seeker type exist");
			} else {
				
						$sQuery = "INSERT INTO seeker_type (seeker_info,status,created_at,created_by) VALUES ('$seekertype','$status',NOW(),'$user_id')";
						$add_Query = $this->db->query($sQuery);
						
						$response = array("status" => "Success", "msg" => "Seeker type added");
			}
		return $response;
	}
	
	function List_seekertype()
	{
		$query="SELECT * FROM `seeker_type`";
		$resultset=$this->db->query($query);
		$seeker_result = $resultset->result();
		if($resultset->num_rows()>0)
			{
				$response = array("status" => "Success", "msg" => "List Seeker type", "paguthi_details" =>$seeker_result);
			} else {
				$response = array("status" => "Error", "msg" => "No records found");
			}
		return $response;
	}
	
	function Edit_seekertype($seekertype_id)
	{
		$query="SELECT * FROM `seeker_type` WHERE id='$seekertype_id'";
		$resultset=$this->db->query($query);
		$type_result = $resultset->result();
		if($resultset->num_rows()>0)
			{
				$response = array("status" => "Success", "msg" => "Seeker type Details", "type_details" =>$type_result);
			} else {
				$response = array("status" => "Error", "msg" => "No records found");
			}
		return $response;
	}
	
	function Update_seekertype($user_id,$seekertype_id,$seekertype,$status)
	{
		$query="SELECT * FROM `seeker_type` WHERE seeker_info='$seekertype' AND id!='$seekertype_id'";
		$resultset=$this->db->query($query);
		if($resultset->num_rows()>0)
			{
				$response = array("status" => "Error", "msg" => "Seeker Type exist");
			} else {
				$sQuery = "UPDATE seeker_type SET seeker_info ='$seekertype',status='$status',updated_at=NOW(), updated_by='$user_id' WHERE id='$seekertype_id'";
				$update_Query = $this->db->query($sQuery);

				$response = array("status" => "Success", "msg" => "Seeker Type Updated");
			}
		return $response;
	}
	
//#################### Seeker type end ####################//	


//#################### Grievance type ####################//	

	function Add_grievance($user_id,$seekertype_id,$grievance_name,$status)
	{
		$query="SELECT * FROM `grievance_type` WHERE grievance_name ='$grievance_name' AND seeker_id = '$seekertype_id'";
		$resultset=$this->db->query($query);
		if($resultset->num_rows()>0)
			{
				$response = array("status" => "Error", "msg" => "Grievance name exist");
			} else {
				
						$sQuery = "INSERT INTO grievance_type (seeker_id,grievance_name,status,created_at,created_by) VALUES ('$seekertype_id','$grievance_name','$status',NOW(),'$user_id')";
						$add_Query = $this->db->query($sQuery);
						
						$response = array("status" => "Success", "msg" => "Grievance added");
			}
		return $response;
	}
	
	function List_grievance()
	{
		$query="SELECT * FROM `grievance_type`";
		$resultset=$this->db->query($query);
		$category_result = $resultset->result();
		if($resultset->num_rows()>0)
			{
				$response = array("status" => "Success", "msg" => "List Grievance", "grievance_details" =>$category_result);
			} else {
				$response = array("status" => "Error", "msg" => "No records found");
			}
		return $response;
	}
	
	function List_seekergrievance($seekertype_id)
	{
		$query="SELECT * FROM `grievance_type` WHERE seeker_id = '$seekertype_id' AND status='ACTIVE'";
		$resultset=$this->db->query($query);
		$category_result = $resultset->result();
		if($resultset->num_rows()>0)
			{
				$response = array("status" => "Success", "msg" => "List Grievance", "grievance_details" =>$category_result);
			} else {
				$response = array("status" => "Error", "msg" => "No records found");
			}
		return $response;
	}
	
	function Edit_grievance($grievancetype_id)
	{
		$query="SELECT * FROM `grievance_type` WHERE id='$grievancetype_id'";
		$resultset=$this->db->query($query);
		$grev_result = $resultset->result();
		if($resultset->num_rows()>0)
			{
				$response = array("status" => "Success", "msg" => "Grievance Details", "grievance_details" =>$grev_result);
			} else {
				$response = array("status" => "Error", "msg" => "No records found");
			}
		return $response;
	}
	
	function Update_grievance($user_id,$seekertype_id,$grievance_id,$grievance_name,$status)
	{
		$query="SELECT * FROM `grievance_type` WHERE grievance_name='$grievance_name' AND id!='$grievance_id' AND seeker_id != '$seekertype_id'";
		$resultset=$this->db->query($query);
		if($resultset->num_rows()>0)
			{
				$response = array("status" => "Error", "msg" => "Grievance Type exist");
			} else {
				$sQuery = "UPDATE grievance_type SET seeker_id = '$seekertype_id', grievance_name ='$grievance_name',status='$status',updated_at=NOW(), updated_by='$user_id' WHERE id='$seekertype_id'";
				$update_Query = $this->db->query($sQuery);

				$response = array("status" => "Success", "msg" => "Grievance Type Updated");
			}
		return $response;
	}
//#################### Grievance type end ####################//		

//#################### Grievance Subcategory ####################//	

	function Add_subcategory($user_id,$grievance_id,$subcategory_name,$status)
	{
		$query="SELECT * FROM `grievance_sub_category` WHERE sub_category_name ='$subcategory_name' AND grievance_id = '$grievance_id'";
		$resultset=$this->db->query($query);
		if($resultset->num_rows()>0)
			{
				$response = array("status" => "Error", "msg" => "Grievance Sub Category exist");
			} else {
				
						$sQuery = "INSERT INTO grievance_sub_category (grievance_id,sub_category_name,status,created_at,created_by) VALUES ('$grievance_id','$subcategory_name','$status',NOW(),'$user_id')";
						$add_Query = $this->db->query($sQuery);
						
						$response = array("status" => "Success", "msg" => "Grievance Sub Category added");
			}
		return $response;
	}
	
	function List_subcategory()
	{
		$query="SELECT * FROM `grievance_sub_category`";
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
	
	function List_grievancesubcategory($grievance_id)
	{
		$query="SELECT * FROM `grievance_sub_category` WHERE grievance_id ='$grievance_id' AND status='ACTIVE'";
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
	
	function Edit_subcategory($subcategory_id)
	{
		$query="SELECT * FROM `grievance_sub_category` WHERE id='$subcategory_id'";
		$resultset=$this->db->query($query);
		$grev_result = $resultset->result();
		if($resultset->num_rows()>0)
			{
				$response = array("status" => "Success", "msg" => "Sub Category Details", "subcategory_details" =>$grev_result);
			} else {
				$response = array("status" => "Error", "msg" => "No records found");
			}
		return $response;
	}
	
	function Update_subcategory($user_id,$grievance_id,$subcategory_id,$subcategory_name,$status)
	{
		$query="SELECT * FROM `grievance_sub_category` WHERE sub_category_name='$subcategory_name' AND id!='$subcategory_id' AND grievance_id != '$grievance_id'";
		$resultset=$this->db->query($query);
		if($resultset->num_rows()>0)
			{
				$response = array("status" => "Error", "msg" => "Sub Category exist");
			} else {
				$sQuery = "UPDATE grievance_sub_category SET sub_category_name ='$subcategory_name',status='$status',updated_at=NOW(), updated_by='$user_id' WHERE id='$subcategory_id'";
				$update_Query = $this->db->query($sQuery);

				$response = array("status" => "Success", "msg" => "Sub Category Updated");
			}
		return $response;
	}
//#################### Grievance Subcategory end ####################//		

//#################### SMS Templates ####################//	

	function Add_smstemplate($user_id,$template_type,$sms_title,$sms_text,$status)
	{
		$query="SELECT * FROM `sms_template` WHERE template_type ='$template_type' AND sms_title = '$sms_title'";
		$resultset=$this->db->query($query);
		if($resultset->num_rows()>0)
			{
				$response = array("status" => "Error", "msg" => "Template exist");
			} else {
				
						$sQuery = "INSERT INTO sms_template (template_type,sms_title,sms_text,status,created_at,created_by) VALUES ('$template_type','$sms_title','$sms_text','$status',NOW(),'$user_id')";
						$add_Query = $this->db->query($sQuery);
						
						$response = array("status" => "Success", "msg" => "Template added");
			}
		return $response;
	}
	
	 function List_smstemplate()
	{
		$query="SELECT * FROM `sms_template";
		$resultset=$this->db->query($query);
		$template_result = $resultset->result();
		if($resultset->num_rows()>0)
			{
				$response = array("status" => "Success", "msg" => "List Templates", "template_details" =>$template_result);
			} else {
				$response = array("status" => "Error", "msg" => "No records found");
			}
		return $response;
	}

	function Edit_smstemplate($template_id)
	{
		$query="SELECT * FROM `sms_template` WHERE id='$template_id'";
		$resultset=$this->db->query($query);
		$template_result = $resultset->result();
		if($resultset->num_rows()>0)
			{
				$response = array("status" => "Success", "msg" => "Template Details", "template_details" =>$template_result);
			} else {
				$response = array("status" => "Error", "msg" => "No records found");
			}
		return $response;
	}
	
	function Update_smstemplate($user_id,$template_id,$template_type,$sms_title,$sms_text,$status)
	{
		$query="SELECT * FROM `sms_template` WHERE template_type='$template_type' AND sms_title ='$sms_title' AND id != '$template_id'";
		$resultset=$this->db->query($query);
		if($resultset->num_rows()>0)
			{
				$response = array("status" => "Error", "msg" => "Template exist");
			} else {
				$sQuery = "UPDATE sms_template SET template_type ='$template_type',sms_title ='$sms_title',sms_text ='$sms_text',status='$status',updated_at=NOW(), updated_by='$user_id' WHERE id='$template_id'";
				$update_Query = $this->db->query($sQuery);

				$response = array("status" => "Success", "msg" => "Template Updated");
			}
		return $response;
	} 
//#################### SMS Templates end ####################//	


//#################### Interactions ####################//	

	function Add_interaction($user_id,$widgets_title,$interaction_text,$status)
	{
		$sQuery = "INSERT INTO interaction_question (widgets_title,interaction_text,status,created_at,created_by) VALUES ('$widgets_title','$interaction_text','$status',NOW(),'$user_id')";
		$add_Query = $this->db->query($sQuery);
		
		$response = array("status" => "Success", "msg" => "Interaction added");
		return $response;
	}
	
	 function List_interaction()
	{
		$query="SELECT * FROM `interaction_question";
		$resultset=$this->db->query($query);
		$interaction_result = $resultset->result();
		if($resultset->num_rows()>0)
			{
				$response = array("status" => "Success", "msg" => "List Interaction", "interaction_details" =>$interaction_result);
			} else {
				$response = array("status" => "Error", "msg" => "No records found");
			}
		return $response;
	}

	function Edit_interaction($interaction_id)
	{
		$query="SELECT * FROM `interaction_question` WHERE id='$interaction_id'";
		$resultset=$this->db->query($query);
		$interaction_result = $resultset->result();
		if($resultset->num_rows()>0)
			{
				$response = array("status" => "Success", "msg" => "Interaction Details", "interaction_details" =>$interaction_result);
			} else {
				$response = array("status" => "Error", "msg" => "No records found");
			}
		return $response;
	}
	
	function Update_interaction($user_id,$interaction_id,$widgets_title,$interaction_text,$status)
	{
		$sQuery = "UPDATE interaction_question SET widgets_title ='$widgets_title',interaction_text ='$interaction_text',status='$status',updated_at=NOW(), updated_by='$user_id' WHERE id='$interaction_id'";
		$update_Query = $this->db->query($sQuery);

		$response = array("status" => "Success", "msg" => "Interaction Updated");
		return $response;
	} 
//#################### Interaction end ####################//	

//#################### Users ####################//	

	function Add_user($user_id,$constituency_id,$role,$paguthi,$name,$email,$mobile,$address,$gender,$status)
	{
		$query="SELECT * FROM `user_master` WHERE email_id='$email'";
		$resultset=$this->db->query($query);
			if($resultset->num_rows()>0)
			{
				$response = array("status" => "Error", "msg" => "User exist");
			} else {
				$digits = 6;
				$OTP = str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);
				$md5pwd=md5($OTP);
				
				$insert="INSERT INTO user_master (constituency_id,pugathi_id,role_id,full_name,phone_number,email_id,password,gender,address,status,created_by,created_at) VALUES ('$constituency_id','$paguthi','$role','$name','$mobile','$email','$md5pwd','$gender','$address','$status','$user_id',NOW())";
				$result=$this->db->query($insert);
				$last_insertid = $this->db->insert_id();
				
				
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

				$this->sendEmail($email,$subject,$htmlContent);
				$this->sendSMS($mobile,$smsContent);

				$response = array("status" => "Success", "msg" => "User Added","last_insert_id"=>$last_insertid);
			}
		return $response;
	}
	
	 function List_user()
	{
		$query="SELECT
				A.*,
				B.paguthi_name
			FROM
				user_master A,
				paguthi B
			WHERE
				A.id!='1' AND A.pugathi_id = B.id";
		$resultset=$this->db->query($query);
		$interaction_result = $resultset->result();
		if($resultset->num_rows()>0)
			{
				$response = array("status" => "Success", "msg" => "List Users", "user_details" =>$interaction_result);
			} else {
				$response = array("status" => "Error", "msg" => "No records found");
			}
		return $response;
	}

	function Edit_user($staff_id)
	{
		$query="SELECT * FROM `user_master` WHERE id='$staff_id'";
		$result=$this->db->query($query);
		$resultset = $result->result();
		if($result->num_rows()>0)
			{
				foreach ($result->result() as $rows)
				{
				  $user_picture = $rows->profile_pic ;
				}
				
				if ($user_picture != ''){
			        $picture_url = base_url().'assets/users/'.$user_picture;
			    }else {
			         $picture_url = '';
			    }
				$staff_result  = array(
							"user_id" => $resultset[0]->id,
							"user_role" => $resultset[0]->role_id,
							"constituency_id" => $resultset[0]->constituency_id,
							"pugathi_id" => $resultset[0]->pugathi_id,
							"full_name" => $resultset[0]->full_name,
							"phone_number" => $resultset[0]->phone_number,
							"email_id" => $resultset[0]->email_id,
							"gender" => $resultset[0]->gender,
							"address" => $resultset[0]->address,
							"picture_url" => $picture_url,
							"status" => $resultset[0]->status
				);
				
				$response = array("status" => "Success", "msg" => "User Details", "user_details" =>$staff_result);
			} else {
				$response = array("status" => "Error", "msg" => "No records found");
			}
		return $response;
	}
	
	function Update_user($user_id,$constituency_id,$staff_id,$role,$paguthi,$name,$email,$mobile,$address,$gender,$status)
	{
		$query="SELECT * FROM `user_master` WHERE email_id ='$email' AND id != '$staff_id'";
		$resultset=$this->db->query($query);
			if($resultset->num_rows()>0)
			{
				$response = array("status" => "Error", "msg" => "Email Exist");
			} else {
				
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

					$update_user="UPDATE user_master SET pugathi_id='$paguthi',role_id='$role',full_name='$name',email_id='$email',phone_number='$mobile',gender='$gender',address='$address',status='$status',updated_at=NOW(),updated_by='$user_id' WHERE id='$staff_id'";
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
					
					$this->sendEmail($email,$subject,$htmlContent);
					$this->sendSMS($mobile,$smsContent);			

				}else {
					$update_user="UPDATE user_master SET pugathi_id='$paguthi',role_id='$role',full_name='$name',phone_number='$mobile',gender='$gender',address='$address',status='$status',updated_at=NOW(),updated_by='$user_id' WHERE id='$staff_id'";
					$result_user=$this->db->query($update_user);
				}	
				$response = array("status" => "Success", "msg" => "User Updated");
			}
		
		return $response;
	} 
//#################### Users end ####################//	

} 

?>