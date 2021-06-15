<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Apiios extends CI_Controller {

	public function index()
	{
		$this->load->view('welcome_message');
	}

	function __construct()
    {
        parent::__construct();
		 $this->load->library('session');
		 $this->load->helper(array('url','db_dynamic_helper')); 
		 $this->load->model('apiiosmodel');
		
    }

	public function checkMethod()
	{
		if($_SERVER['REQUEST_METHOD'] != 'POST')
		{
			$res = array();
			$res["scode"] = 203;
			$res["message"] = "Request Method not supported";

			echo json_encode($res);
			return FALSE;
		}
		return TRUE;
	}

	//-----------------------------------------------//

	public function version_check()
	{
		$_POST = json_decode(file_get_contents("php://input"), TRUE);
		
		if(!$this->checkMethod())
		{
			return FALSE;
		}

		$version_code = '';
		$version_code = $this->input->post("version_code");
		$data['result']=$this->apiiosmodel->version_check($version_code);
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//

//-----------------------------------------------//

	public function chk_constituency_code()
	{
	   $_POST = json_decode(file_get_contents("php://input"), TRUE);

		if(!$this->checkMethod())
		{
			return FALSE;
		}

		$constituency_code = '';
		$constituency_code = $this->input->post("constituency_code");
		
		$data['result']=$this->apiiosmodel->chk_Constituency_code($constituency_code);
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//

//-----------------------------------------------//

	public function login()
	{
		$_POST = json_decode(file_get_contents("php://input"), TRUE);
		
		if(!$this->checkMethod())
		{
			return FALSE;
		}
	
		$user_name = '';
		$password = '';
		$gcmkey ='';
		$mobiletype ='';
		$dynamic_db = '';
		
		$username=$this->db->escape_str($this->input->post('user_name'));
		$password=$this->db->escape_str($this->input->post('password'));
		$gcmkey = $this->input->post("device_id");
		$mobiletype = $this->input->post("mobile_type");
		$dynamic_db = $this->input->post("dynamic_db");

		$data['result']=$this->apiiosmodel->Login(strtoupper($username),strtoupper($password),$gcmkey,$mobiletype,$dynamic_db);
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//

//-----------------------------------------------//

	public function mobile_login()
	{
		$_POST = json_decode(file_get_contents("php://input"), TRUE);
		
		if(!$this->checkMethod())
		{
			return FALSE;
		}

		$mobile_no = '';
		$dynamic_db = '';
		$mobile_no = $this->input->post("mobile_no");
		$dynamic_db = $this->input->post("dynamic_db");
		
		$data['result']=$this->apiiosmodel->Mobile_login($mobile_no,$dynamic_db);
		$response = $data['result'];
		echo json_encode($response);
	}
//-----------------------------------------------//


	public function mobile_verify()
	{
		$_POST = json_decode(file_get_contents("php://input"), TRUE);
		
		if(!$this->checkMethod())
		{
			return FALSE;
		}

		$mobile_no = $this->input->post("mobile_no");
		$otp = $this->input->post("otp");
		$gcm_key = $this->input->post("device_id");
		$mobile_type = $this->input->post("mobile_type");
		$dynamic_db = $this->input->post("dynamic_db");
		
		$data['result']=$this->apiiosmodel->Mobile_verify($mobile_no,$otp,$gcm_key,$mobile_type,$dynamic_db);
		$response = $data['result'];
		echo json_encode($response);
	}
	
//-----------------------------------------------//

	public function forgotPassword(){
		
		$_POST = json_decode(file_get_contents("php://input"), TRUE);
		
		if(!$this->checkMethod())
		{
			return FALSE;
		}

		$user_name = '';
		$dynamic_db = '';
		
		$user_name=$this->db->escape_str($this->input->post('user_name'));
		$dynamic_db = $this->input->post("dynamic_db");
		
		$data['result']=$this->apiiosmodel->Forgot_password(strtoupper($user_name),$dynamic_db);
		$response = $data['result'];
		echo json_encode($response);
	}


//-----------------------------------------------//

	public function profileDetails()
	{
		$_POST = json_decode(file_get_contents("php://input"), TRUE);
		
		if(!$this->checkMethod())
		{
			return FALSE;
		}

        $user_id = '';
		$dynamic_db = '';
		
        $user_id = $this->input->post("user_id");
		$dynamic_db = $this->input->post("dynamic_db");

		$data['result']=$this->apiiosmodel->Profile_details($user_id,$dynamic_db);
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//


//-----------------------------------------------//

	public function checkEmail()
	{
		$_POST = json_decode(file_get_contents("php://input"), TRUE);
		
		if(!$this->checkMethod())
		{
			return FALSE;
		}

        $email = '';
		$dynamic_db = '';
		
        $email = $this->input->post("email");
		$dynamic_db = $this->input->post("dynamic_db");

		$data['result']=$this->apiiosmodel->Check_email(strtoupper($email),$dynamic_db);
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//


//-----------------------------------------------//

	public function checkEmailedit()
	{
		$_POST = json_decode(file_get_contents("php://input"), TRUE);
		
		if(!$this->checkMethod())
		{
			return FALSE;
		}

        $email = '';
		$user_id ='';
		$dynamic_db = '';
		
		$user_id = $this->input->post("user_id");
        $email = $this->input->post("email");
		$dynamic_db = $this->input->post("dynamic_db");

		$data['result']=$this->apiiosmodel->Check_emailedit($user_id,strtoupper($email),$dynamic_db);
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//

//-----------------------------------------------//

	public function checkPhone()
	{
		$_POST = json_decode(file_get_contents("php://input"), TRUE);
		
		if(!$this->checkMethod())
		{
			return FALSE;
		}

        $phone = '';
		$dynamic_db = '';
		
        $phone = $this->input->post("phone");
		$dynamic_db = $this->input->post("dynamic_db");

		$data['result']=$this->apiiosmodel->Check_phone($phone,$dynamic_db);
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//


//-----------------------------------------------//

	public function checkPhoneedit()
	{
		$_POST = json_decode(file_get_contents("php://input"), TRUE);
		
		if(!$this->checkMethod())
		{
			return FALSE;
		}

        $phone = '';
		$user_id ='';
		$dynamic_db = '';
		
		$user_id = $this->input->post("user_id");
        $phone = $this->input->post("phone");
		$dynamic_db = $this->input->post("dynamic_db");

		$data['result']=$this->apiiosmodel->Check_phoneedit($user_id,$phone,$dynamic_db);
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//

//-----------------------------------------------//

	public function profileUpdate()
	{
		$_POST = json_decode(file_get_contents("php://input"), TRUE);

		if(!$this->checkMethod())
		{
			return FALSE;
		}

        $user_id = '';
        $name = '';
        $address = '';
        $phone = '';
        $email = '';
        $gender = '';
		$dynamic_db = '';

		$user_id= $this->input->post('user_id');
		$name=$this->input->post('name');
		$address= $this->db->escape_str($this->input->post('address'));
		$phone=$this->input->post('phone');
		$email=$this->input->post('email');
		$gender=$this->input->post('gender');
		$dynamic_db = $this->input->post("dynamic_db");

		$data['result']=$this->apiiosmodel->Profile_update(strtoupper($name),strtoupper($address),$phone,strtoupper($email),$gender,$user_id,$dynamic_db);
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//

//-----------------------------------------------//

    public function profilePictureUpload()
	{
		$user_id = $this->uri->segment(3);
		$dynamic_db = $this->uri->segment(4);
		
		$profilepic = $_FILES['user_pic']['name'];
		$temp = pathinfo($profilepic, PATHINFO_EXTENSION);
		$staff_prof_pic = round(microtime(true)) . '.' . $temp;
		$uploaddir = 'assets/users/';
		$profilepic = $uploaddir.$staff_prof_pic;
		move_uploaded_file($_FILES['user_pic']['tmp_name'], $profilepic);

		$data['result']=$this->apiiosmodel->Update_profilepic($user_id,$staff_prof_pic,$dynamic_db);
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//

//-----------------------------------------------//

	public function changePassword()
	{
		$_POST = json_decode(file_get_contents("php://input"), TRUE);
		
		if(!$this->checkMethod())
		{
			return FALSE;
		}

		$user_id = '';
		$newpassword = '';
		$oldpassword = '';
		$dynamic_db = '';

		$user_id = $this->input->post("user_id");
	 	$newpassword = $this->input->post("new_password");
		$oldpassword = $this->input->post("old_password");
		$dynamic_db = $this->input->post("dynamic_db");

		$data['result']=$this->apiiosmodel->Change_password($user_id,$newpassword,$oldpassword,$dynamic_db);
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//

//-----------------------------------------------//

	public function listPaguthi()
	{
		$_POST = json_decode(file_get_contents("php://input"), TRUE);
		
		if(!$this->checkMethod())
		{
			return FALSE;
		}

		$constituency_id = '';
		$dynamic_db = '';
		
		$constituency_id = $this->input->post("constituency_id");
		$dynamic_db = $this->input->post("dynamic_db");

		$data['result']=$this->apiiosmodel->List_paguthi($constituency_id,$dynamic_db);
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//

//-----------------------------------------------//

	public function dashBoard()
	{
		$_POST = json_decode(file_get_contents("php://input"), TRUE);
		
		if(!$this->checkMethod())
		{
			return FALSE;
		}

		$paguthi_id = '';
		$from_date = '';
		$to_date = '';
		$dynamic_db = '';
		
		$paguthi_id = $this->input->post("paguthi_id");
		$from_date = $this->input->post("from_date");
		$to_date = $this->input->post("to_date");
		$dynamic_db = $this->input->post("dynamic_db");

		$data['result']=$this->apiiosmodel->Dashboard($paguthi_id,$from_date,$to_date,$dynamic_db);
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//

//-----------------------------------------------//

	public function widgets_members()
	{
		$_POST = json_decode(file_get_contents("php://input"), TRUE);
		
		if(!$this->checkMethod())
		{
			return FALSE;
		}

		$paguthi_id = '';
		$from_date = '';
		$to_date = '';
		$dynamic_db = '';
		
		$paguthi_id = $this->input->post("paguthi_id");
		$from_date = $this->input->post("from_date");
		$to_date = $this->input->post("to_date");
		$dynamic_db = $this->input->post("dynamic_db");

		$data['result']=$this->apiiosmodel->Widgets_members($paguthi_id,$from_date,$to_date,$dynamic_db);
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//


//-----------------------------------------------//

	public function widgets_grievances()
	{
		$_POST = json_decode(file_get_contents("php://input"), TRUE);
		
		if(!$this->checkMethod())
		{
			return FALSE;
		}

		$paguthi_id = '';
		$from_date = '';
		$to_date = '';
		$dynamic_db = '';
		
		$paguthi_id = $this->input->post("paguthi_id");
		$from_date = $this->input->post("from_date");
		$to_date = $this->input->post("to_date");
		$dynamic_db = $this->input->post("dynamic_db");

		$data['result']=$this->apiiosmodel->Widgets_grievances($paguthi_id,$from_date,$to_date,$dynamic_db);
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//


//-----------------------------------------------//

	public function widgets_footfall()
	{
		$_POST = json_decode(file_get_contents("php://input"), TRUE);
		
		if(!$this->checkMethod())
		{
			return FALSE;
		}

		$paguthi_id = '';
		$from_date = '';
		$to_date = '';
		$dynamic_db = '';
		
		$paguthi_id = $this->input->post("paguthi_id");
		$from_date = $this->input->post("from_date");
		$to_date = $this->input->post("to_date");
		$dynamic_db = $this->input->post("dynamic_db");

		$data['result']=$this->apiiosmodel->Widgets_footfall($paguthi_id,$from_date,$to_date,$dynamic_db);
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//


//-----------------------------------------------//

	public function widgets_meetings()
	{
		$_POST = json_decode(file_get_contents("php://input"), TRUE);
		
		if(!$this->checkMethod())
		{
			return FALSE;
		}

		$paguthi_id = '';
		$from_date = '';
		$to_date = '';
		$dynamic_db = '';
		
		$paguthi_id = $this->input->post("paguthi_id");
		$from_date = $this->input->post("from_date");
		$to_date = $this->input->post("to_date");
		$dynamic_db = $this->input->post("dynamic_db");

		$data['result']=$this->apiiosmodel->Widgets_meetings($paguthi_id,$from_date,$to_date,$dynamic_db);
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//


//-----------------------------------------------//

	public function widgets_volunteer()
	{
		$_POST = json_decode(file_get_contents("php://input"), TRUE);
		
		if(!$this->checkMethod())
		{
			return FALSE;
		}

		$paguthi_id = '';
		$dynamic_db = '';
		
		$paguthi_id = $this->input->post("paguthi_id");
		$dynamic_db = $this->input->post("dynamic_db");
		

		$data['result']=$this->apiiosmodel->Widgets_volunteer($paguthi_id,$dynamic_db);
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//

//-----------------------------------------------//

	public function widgets_greetings()
	{
		$_POST = json_decode(file_get_contents("php://input"), TRUE);
		
		if(!$this->checkMethod())
		{
			return FALSE;
		}

		$paguthi_id = '';
		$from_date = '';
		$to_date = '';
		$dynamic_db = '';
		
		$paguthi_id = $this->input->post("paguthi_id");
		$from_date = $this->input->post("from_date");
		$to_date = $this->input->post("to_date");
		$dynamic_db = $this->input->post("dynamic_db");

		$data['result']=$this->apiiosmodel->Widgets_greetings($paguthi_id,$from_date,$to_date,$dynamic_db);
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//


//-----------------------------------------------//

	public function widgets_videos()
	{
		$_POST = json_decode(file_get_contents("php://input"), TRUE);
		
		if(!$this->checkMethod())
		{
			return FALSE;
		}

		$paguthi_id = '';
		$from_date = '';
		$to_date = '';
		$dynamic_db = '';
		
		$paguthi_id = $this->input->post("paguthi_id");
		$from_date = $this->input->post("from_date");
		$to_date = $this->input->post("to_date");
		$dynamic_db = $this->input->post("dynamic_db");

		$data['result']=$this->apiiosmodel->Widgets_videos($paguthi_id,$from_date,$to_date,$dynamic_db);
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//


//-----------------------------------------------//

	public function widgets_interactions()
	{
		$_POST = json_decode(file_get_contents("php://input"), TRUE);
		
		if(!$this->checkMethod())
		{
			return FALSE;
		}

		$paguthi = '';
		$dynamic_db = '';
		
		$paguthi = $this->input->post("paguthi");
		$dynamic_db = $this->input->post("dynamic_db");

		$data['result']=$this->apiiosmodel->Widgets_interactions($paguthi,$dynamic_db);
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//

//-----------------------------------------------//

	public function dashBoard_search()
	{
		$_POST = json_decode(file_get_contents("php://input"), TRUE);
		
		if(!$this->checkMethod())
		{
			return FALSE;
		}

		$keyword = '';
		$dynamic_db = '';
		
		//$keyword = $this->input->post("keyword");
		$keyword=$this->db->escape_str($this->input->post('keyword'));
		$dynamic_db = $this->input->post("dynamic_db");

		$data['result']=$this->apiiosmodel->Dashboard_search($keyword,$dynamic_db);
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//

//-----------------------------------------------//

	public function dashBoard_searchnew()
	{
		$_POST = json_decode(file_get_contents("php://input"), TRUE);
		
		if(!$this->checkMethod())
		{
			return FALSE;
		}

		$keyword = '';
		$offset = '';
		$rowcount = '';
		$dynamic_db = '';
		
		//$keyword = $this->input->post("keyword");
		$keyword=$this->db->escape_str($this->input->post('keyword'));
		$offset = $this->input->post("offset");
		$rowcount = $this->input->post("rowcount");
		$dynamic_db = $this->input->post("dynamic_db");
		
		$data['result']=$this->apiiosmodel->Dashboard_searchnew($keyword,$offset,$rowcount,$dynamic_db);
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//

//-----------------------------------------------//

	public function listConstituent()
	{
		$_POST = json_decode(file_get_contents("php://input"), TRUE);
		
		if(!$this->checkMethod())
		{
			return FALSE;
		}

		$paguthi = '';
		$dynamic_db = '';
		
		$paguthi = $this->input->post("paguthi");
		$dynamic_db = $this->input->post("dynamic_db");
		
		$data['result']=$this->apiiosmodel->List_constituent($paguthi,$dynamic_db);
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//

//-----------------------------------------------//

	public function listConstituentnew()
	{
		$_POST = json_decode(file_get_contents("php://input"), TRUE);
		
		if(!$this->checkMethod())
		{
			return FALSE;
		}

		$paguthi = '';
		$offset = '';
		$rowcount = '';
		$dynamic_db = '';
		
		$paguthi = $this->input->post("paguthi");
		$offset = $this->input->post("offset");
		$rowcount = $this->input->post("rowcount");
		$dynamic_db = $this->input->post("dynamic_db");
		
		$data['result']=$this->apiiosmodel->List_constituentnew($paguthi,$offset,$rowcount,$dynamic_db);
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//

//-----------------------------------------------//

	public function listConstituentsearch()
	{
		$_POST = json_decode(file_get_contents("php://input"), TRUE);
		
		if(!$this->checkMethod())
		{
			return FALSE;
		}

		$keyword = '';
		$paguthi = '';
		$offset = '';
		$rowcount = '';
		$dynamic_db = '';
		
		//$keyword = $this->input->post("keyword");
		$keyword=$this->db->escape_str($this->input->post('keyword'));
		$paguthi = $this->input->post("paguthi");
		$offset = $this->input->post("offset");
		$rowcount = $this->input->post("rowcount");
		$dynamic_db = $this->input->post("dynamic_db");
		
		$data['result']=$this->apiiosmodel->List_constituentsearch($keyword,$paguthi,$offset,$rowcount,$dynamic_db);
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//

//-----------------------------------------------//

	public function constituentDetails()
	{
		$_POST = json_decode(file_get_contents("php://input"), TRUE);
		
		if(!$this->checkMethod())
		{
			return FALSE;
		}

		$constituent_id = '';
		$dynamic_db = '';
		
		$constituent_id = $this->input->post("constituent_id");
		$dynamic_db = $this->input->post("dynamic_db");
		
		$data['result']=$this->apiiosmodel->Constituent_details($constituent_id,$dynamic_db);
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//

//-----------------------------------------------//

	public function constituentMeetings()
	{
		$_POST = json_decode(file_get_contents("php://input"), TRUE);
		
		if(!$this->checkMethod())
		{
			return FALSE;
		}

		$constituent_id = '';
		$dynamic_db = '';
		
		$constituent_id = $this->input->post("constituent_id");
		$dynamic_db = $this->input->post("dynamic_db");
		
		$data['result']=$this->apiiosmodel->Constituent_meetings($constituent_id,$dynamic_db);
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//

//-----------------------------------------------//

	public function constituentMeetingdetails()
	{
		$_POST = json_decode(file_get_contents("php://input"), TRUE);
		
		if(!$this->checkMethod())
		{
			return FALSE;
		}

		$meeting_id = '';
		$dynamic_db = '';
		
		$meeting_id = $this->input->post("meeting_id");
		$dynamic_db = $this->input->post("dynamic_db");
		
		$data['result']=$this->apiiosmodel->Constituent_meetingdetails($meeting_id,$dynamic_db);
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//

//-----------------------------------------------//

	public function constituentGrievances()
	{
		$_POST = json_decode(file_get_contents("php://input"), TRUE);
		
		if(!$this->checkMethod())
		{
			return FALSE;
		}

		$constituent_id = '';
		$dynamic_db = '';
		
		$constituent_id = $this->input->post("constituent_id");
		$dynamic_db = $this->input->post("dynamic_db");
		
		$data['result']=$this->apiiosmodel->Constituent_grievances($constituent_id,$dynamic_db);
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//

//-----------------------------------------------//

	public function constituentGrievancedetails()
	{
		$_POST = json_decode(file_get_contents("php://input"), TRUE);
		
		if(!$this->checkMethod())
		{
			return FALSE;
		}

		$grievance_id = '';
		$dynamic_db = '';
		
		$grievance_id = $this->input->post("grievance_id");
		$dynamic_db = $this->input->post("dynamic_db");
		
		$data['result']=$this->apiiosmodel->Constituent_grievancedetails($grievance_id,$dynamic_db);
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//

//-----------------------------------------------//

	public function grievanceMessage()
	{
		$_POST = json_decode(file_get_contents("php://input"), TRUE);
		
		if(!$this->checkMethod())
		{
			return FALSE;
		}

		$grievance_id = '';
		$dynamic_db = '';
		
		$grievance_id = $this->input->post("grievance_id");
		$dynamic_db = $this->input->post("dynamic_db");
		
		$data['result']=$this->apiiosmodel->Grievance_message($grievance_id,$dynamic_db);
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//


//-----------------------------------------------//

	public function constituentInteraction()
	{
		$_POST = json_decode(file_get_contents("php://input"), TRUE);
		
		if(!$this->checkMethod())
		{
			return FALSE;
		}

		$constituent_id = '';
		$dynamic_db = '';
		
		$constituent_id = $this->input->post("constituent_id");
		$dynamic_db = $this->input->post("dynamic_db");
		
		$data['result']=$this->apiiosmodel->Constituent_interaction($constituent_id,$dynamic_db);
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//

//-----------------------------------------------//

	public function constituentPlant()
	{
		$_POST = json_decode(file_get_contents("php://input"), TRUE);
		
		if(!$this->checkMethod())
		{
			return FALSE;
		}

		$constituent_id = '';
		$dynamic_db = '';
		
		$constituent_id = $this->input->post("constituent_id");
		$dynamic_db = $this->input->post("dynamic_db");
		
		$data['result']=$this->apiiosmodel->Constituent_plant($constituent_id,$dynamic_db);
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//

//-----------------------------------------------//

	public function constituentDocuments()
	{
		$_POST = json_decode(file_get_contents("php://input"), TRUE);
		
		if(!$this->checkMethod())
		{
			return FALSE;
		}

		$constituent_id = '';
		$dynamic_db = '';
		
		$constituent_id = $this->input->post("constituent_id");
		$dynamic_db = $this->input->post("dynamic_db");
		
		$data['result']=$this->apiiosmodel->Constituent_documents($constituent_id,$dynamic_db);
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//


//-----------------------------------------------//

	public function constituentgrvDocuments()
	{
		$_POST = json_decode(file_get_contents("php://input"), TRUE);
		
		if(!$this->checkMethod())
		{
			return FALSE;
		}

		$constituent_id = '';
		$dynamic_db = '';
		
		$constituent_id = $this->input->post("constituent_id");
		$dynamic_db = $this->input->post("dynamic_db");
		
		$data['result']=$this->apiiosmodel->Constituent_grvdocuments($constituent_id,$dynamic_db);
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//

//-----------------------------------------------//

	public function meetingRequest()
	{
		$_POST = json_decode(file_get_contents("php://input"), TRUE);
		
		if(!$this->checkMethod())
		{
			return FALSE;
		}

		$constituency_id = '';
		$dynamic_db = '';
		
		$constituency_id = $this->input->post("constituency_id");
		$dynamic_db = $this->input->post("dynamic_db");
		
		$data['result']=$this->apiiosmodel->Meeting_request($constituency_id,$dynamic_db);
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//

//-----------------------------------------------//

	public function meetingRequestnew()
	{
		$_POST = json_decode(file_get_contents("php://input"), TRUE);
		
		if(!$this->checkMethod())
		{
			return FALSE;
		}

		$constituency_id = '';
		$offset = '';
		$rowcount = '';
		$dynamic_db = '';
		
		$constituency_id = $this->input->post("constituency_id");
		$offset = $this->input->post("offset");
		$rowcount = $this->input->post("rowcount");
		$dynamic_db = $this->input->post("dynamic_db");
		
		$data['result']=$this->apiiosmodel->Meeting_requestnew($constituency_id,$offset,$rowcount,$dynamic_db);
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//


//-----------------------------------------------//

	public function meetingRequestsearch()
	{
		$_POST = json_decode(file_get_contents("php://input"), TRUE);
		
		if(!$this->checkMethod())
		{
			return FALSE;
		}

		$constituency_id = '';
		$keyword = '';
		$offset = '';
		$rowcount = '';
		$dynamic_db = '';
		
		$constituency_id = $this->input->post("constituency_id");
		//$keyword = $this->input->post("keyword");
		$keyword=$this->db->escape_str($this->input->post('keyword'));
		$offset = $this->input->post("offset");
		$rowcount = $this->input->post("rowcount");
		$dynamic_db = $this->input->post("dynamic_db");
		
		$data['result']=$this->apiiosmodel->Meeting_requestsearch($constituency_id,$keyword,$offset,$rowcount,$dynamic_db);
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//

//-----------------------------------------------//

	public function meetingDetails()
	{
		$_POST = json_decode(file_get_contents("php://input"), TRUE);
		
		if(!$this->checkMethod())
		{
			return FALSE;
		}

		$meeting_id = '';
		$dynamic_db = '';
		
		$meeting_id = $this->input->post("meeting_id");
		$dynamic_db = $this->input->post("dynamic_db");
		
		$data['result']=$this->apiiosmodel->Meeting_details($meeting_id,$dynamic_db);
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//

//-----------------------------------------------//

	public function meetingUpdate()
	{
		$_POST = json_decode(file_get_contents("php://input"), TRUE);
		
		if(!$this->checkMethod())
		{
			return FALSE;
		}

		$user_id = '';
		$meeting_id = '';
		$status = '';
		$dynamic_db = '';
		
		$user_id = $this->input->post("user_id");
		$meeting_id = $this->input->post("meeting_id");
		$status = $this->input->post("status");
		$dynamic_db = $this->input->post("dynamic_db");
		
		$data['result']=$this->apiiosmodel->Meeting_update($user_id,$meeting_id,strtoupper($status),$dynamic_db);
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//

//-----------------------------------------------//

	public function listGrievance()
	{
		$_POST = json_decode(file_get_contents("php://input"), TRUE);
		
		if(!$this->checkMethod())
		{
			return FALSE;
		}

		$paguthi = '';
		$grievance_type = '';
		$dynamic_db = '';
		
		$paguthi = $this->input->post("paguthi");
		$grievance_type = $this->input->post("grievance_type");
		$dynamic_db = $this->input->post("dynamic_db");

		$data['result']=$this->apiiosmodel->List_grievance($paguthi,$grievance_type,$dynamic_db);
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//


//-----------------------------------------------//

	public function listGrievancenew()
	{
		$_POST = json_decode(file_get_contents("php://input"), TRUE);
		
		if(!$this->checkMethod())
		{
			return FALSE;
		}

		$paguthi = '';
		$grievance_type = '';
		$offset = '';
		$rowcount = '';
		$dynamic_db = '';
		
		$paguthi = $this->input->post("paguthi");
		$grievance_type = $this->input->post("grievance_type");
		$offset = $this->input->post("offset");
		$rowcount = $this->input->post("rowcount");
		$dynamic_db = $this->input->post("dynamic_db");

		$data['result']=$this->apiiosmodel->List_grievancenew($paguthi,$grievance_type,$offset,$rowcount,$dynamic_db);
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//


//-----------------------------------------------//

	public function listGrievancesearch()
	{
		$_POST = json_decode(file_get_contents("php://input"), TRUE);
		
		if(!$this->checkMethod())
		{
			return FALSE;
		}

		$keyword = '';
		$paguthi = '';
		$grievance_type = '';
		$offset = '';
		$rowcount = '';
		$dynamic_db = '';
		
		//$keyword = $this->input->post("keyword");
		$keyword=$this->db->escape_str($this->input->post('keyword'));
		$paguthi = $this->input->post("paguthi");
		$grievance_type = $this->input->post("grievance_type");
		$offset = $this->input->post("offset");
		$rowcount = $this->input->post("rowcount");
		$dynamic_db = $this->input->post("dynamic_db");

		$data['result']=$this->apiiosmodel->List_grievancesearch($keyword,$paguthi,$grievance_type,$offset,$rowcount,$dynamic_db);
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//

//-----------------------------------------------//

	public function listStaff()
	{
		$_POST = json_decode(file_get_contents("php://input"), TRUE);
		
		if(!$this->checkMethod())
		{
			return FALSE;
		}

		$constituency_id = '';
		$constituency_id = $this->input->post("constituency_id");
		$dynamic_db = $this->input->post("dynamic_db");

		$data['result']=$this->apiiosmodel->List_staff($constituency_id,$dynamic_db);
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//

//-----------------------------------------------//

	public function staffDetails()
	{
		$_POST = json_decode(file_get_contents("php://input"), TRUE);
		
		if(!$this->checkMethod())
		{
			return FALSE;
		}

		$staff_id = '';
		$dynamic_db = '';
		
		$staff_id = $this->input->post("staff_id");
		$dynamic_db = $this->input->post("dynamic_db");

		$data['result']=$this->apiiosmodel->Staff_details($staff_id,$dynamic_db);
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//



//-----------------------------------------------//

	public function reportStatus()
	{
		$_POST = json_decode(file_get_contents("php://input"), TRUE);
		
		if(!$this->checkMethod())
		{
			return FALSE;
		}

		$from_date = '';
		$to_date = '';
		$status='';
		$paguthi='';
		$dynamic_db = '';
		
		 $from_date = $this->input->post("from_date");
		 $to_date = $this->input->post("to_date");	
		 $status=$this->input->post('status');
		 $paguthi=$this->input->post('paguthi');
		 $dynamic_db = $this->input->post("dynamic_db");
		
		$data['result']=$this->apiiosmodel->Report_status($from_date,$to_date,$status,$paguthi,$dynamic_db);
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//

//-----------------------------------------------//

	public function reportStatusnew()
	{
		$_POST = json_decode(file_get_contents("php://input"), TRUE);
		
		if(!$this->checkMethod())
		{
			return FALSE;
		}

		$from_date = '';
		$to_date = '';
		$status='';
		$paguthi='';
		$offset = '';
		$rowcount = '';
		$dynamic_db = '';
		
		$from_date = $this->input->post("from_date");
		$to_date = $this->input->post("to_date");	
		$status=$this->input->post('status');
		$paguthi=$this->input->post('paguthi');
		$offset = $this->input->post("offset");
		$rowcount = $this->input->post("rowcount");
		$dynamic_db = $this->input->post("dynamic_db");
		
		$data['result']=$this->apiiosmodel->Report_statusnew($from_date,$to_date,$status,$paguthi,$offset,$rowcount,$dynamic_db);
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//

//-----------------------------------------------//

	public function reportStatussearch()
	{
		$_POST = json_decode(file_get_contents("php://input"), TRUE);
		
		if(!$this->checkMethod())
		{
			return FALSE;
		}

		
		$from_date = '';
		$to_date = '';
		$status='';
		$paguthi='';
		$keyword = '';
		$offset = '';
		$rowcount = '';
		$dynamic_db = '';
		
		$from_date = $this->input->post("from_date");
		$to_date = $this->input->post("to_date");	
		$status=$this->input->post('status');
		$paguthi = $this->input->post("paguthi");
		//$keyword = $this->input->post("keyword");
		$keyword=$this->db->escape_str($this->input->post('keyword'));
		$offset = $this->input->post("offset");
		$rowcount = $this->input->post("rowcount");
		$dynamic_db = $this->input->post("dynamic_db");
		
		$data['result']=$this->apiiosmodel->Report_statussearch($from_date,$to_date,$status,$paguthi,$keyword,$offset,$rowcount,$dynamic_db);
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//



//-----------------------------------------------//

	public function reportCategory()
	{
		$_POST = json_decode(file_get_contents("php://input"), TRUE);
		
		if(!$this->checkMethod())
		{
			return FALSE;
		}

		$from_date = '';
		$to_date = '';
		$category='';
		$dynamic_db = '';
		
		$from_date = $this->input->post("from_date");
		$to_date = $this->input->post("to_date");	
		$category=$this->input->post('category');
		$dynamic_db = $this->input->post("dynamic_db");
		
		$data['result']=$this->apiiosmodel->Report_category($from_date,$to_date,$category,$dynamic_db);
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//

//-----------------------------------------------//

	public function reportCategorynew()
	{
		$_POST = json_decode(file_get_contents("php://input"), TRUE);
		
		if(!$this->checkMethod())
		{
			return FALSE;
		}

		$from_date = '';
		$to_date = '';
		$category='';
		$offset = '';
		$rowcount = '';
		$dynamic_db = '';
		
		$from_date = $this->input->post("from_date");
		$to_date = $this->input->post("to_date");	
		$category=$this->input->post('category');
		$offset = $this->input->post("offset");
		$rowcount = $this->input->post("rowcount");
		$dynamic_db = $this->input->post("dynamic_db");
		
		$data['result']=$this->apiiosmodel->Report_categorynew($from_date,$to_date,$category,$offset,$rowcount,$dynamic_db);
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//

//-----------------------------------------------//

	public function reportCategorysearch()
	{
		$_POST = json_decode(file_get_contents("php://input"), TRUE);
		
		if(!$this->checkMethod())
		{
			return FALSE;
		}
		
		$from_date = '';
		$to_date = '';
		$category='';
		$keyword = '';
		$offset = '';
		$rowcount = '';
		$dynamic_db = '';
		
		$from_date = $this->input->post("from_date");
		$to_date = $this->input->post("to_date");	
		$category=$this->input->post('category');
		//$keyword = $this->input->post("keyword");
		$keyword=$this->db->escape_str($this->input->post('keyword'));
		$offset = $this->input->post("offset");
		$rowcount = $this->input->post("rowcount");
		$dynamic_db = $this->input->post("dynamic_db");
		
		$data['result']=$this->apiiosmodel->Report_categorysearch($from_date,$to_date,$category,$keyword,$offset,$rowcount,$dynamic_db);
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//



//-----------------------------------------------//

	public function reportsubCategory()
	{
		$_POST = json_decode(file_get_contents("php://input"), TRUE);
		
		if(!$this->checkMethod())
		{
			return FALSE;
		}

		$from_date = '';
		$to_date = '';
		$sub_category='';
		$dynamic_db = '';
		
		$from_date = $this->input->post("from_date");
		$to_date = $this->input->post("to_date");	
		$sub_category=$this->input->post('sub_category');
		$dynamic_db = $this->input->post("dynamic_db");
		
		$data['result']=$this->apiiosmodel->Report_subcategory($from_date,$to_date,$sub_category,$dynamic_db);
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//

//-----------------------------------------------//

	public function reportsubCategorynew()
	{
		$_POST = json_decode(file_get_contents("php://input"), TRUE);
		
		if(!$this->checkMethod())
		{
			return FALSE;
		}

		$from_date = '';
		$to_date = '';
		$sub_category='';
		$offset = '';
		$rowcount = '';
		$dynamic_db = '';
		
		$from_date = $this->input->post("from_date");
		$to_date = $this->input->post("to_date");	
		$sub_category=$this->input->post('sub_category');
		$offset = $this->input->post("offset");
		$rowcount = $this->input->post("rowcount");
		$dynamic_db = $this->input->post("dynamic_db");
		
		$data['result']=$this->apiiosmodel->Report_subcategorynew($from_date,$to_date,$sub_category,$offset,$rowcount,$dynamic_db);
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//

//-----------------------------------------------//

	public function reportsubCategorysearch()
	{
		$_POST = json_decode(file_get_contents("php://input"), TRUE);
		
		if(!$this->checkMethod())
		{
			return FALSE;
		}

		
		$from_date = '';
		$to_date = '';
		$sub_category='';
		$keyword = '';
		$offset = '';
		$rowcount = '';
		$dynamic_db = '';
		
		$from_date = $this->input->post("from_date");
		$to_date = $this->input->post("to_date");	
		$sub_category=$this->input->post('sub_category');
		//$keyword = $this->input->post("keyword");
		$keyword=$this->db->escape_str($this->input->post('keyword'));
		$offset = $this->input->post("offset");
		$rowcount = $this->input->post("rowcount");
		$dynamic_db = $this->input->post("dynamic_db");
		
		$data['result']=$this->apiiosmodel->Report_subcategorysearch($from_date,$to_date,$sub_category,$keyword,$offset,$rowcount,$dynamic_db);
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//



//-----------------------------------------------//

	public function reportLocation()
	{
		$_POST = json_decode(file_get_contents("php://input"), TRUE);
		
		if(!$this->checkMethod())
		{
			return FALSE;
		}

		$from_date = '';
		$to_date = '';
		$paguthi='';
		$dynamic_db = '';
		
		$from_date = $this->input->post("from_date");
		$to_date = $this->input->post("to_date");	
		$paguthi=$this->input->post('paguthi');
		$dynamic_db = $this->input->post("dynamic_db");
		
		$data['result']=$this->apiiosmodel->Report_location($from_date,$to_date,$paguthi,$dynamic_db);
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//

//-----------------------------------------------//

	public function reportLocationnew()
	{
		$_POST = json_decode(file_get_contents("php://input"), TRUE);
		
		if(!$this->checkMethod())
		{
			return FALSE;
		}

		$from_date = '';
		$to_date = '';
		$paguthi='';
		$offset = '';
		$rowcount = '';
		$dynamic_db = '';
		
		$from_date = $this->input->post("from_date");
		$to_date = $this->input->post("to_date");	
		$paguthi=$this->input->post('paguthi');
		$offset = $this->input->post("offset");
		$rowcount = $this->input->post("rowcount");
		$dynamic_db = $this->input->post("dynamic_db");
		
		$data['result']=$this->apiiosmodel->Report_locationnew($from_date,$to_date,$paguthi,$offset,$rowcount,$dynamic_db);
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//

//-----------------------------------------------//

	public function reportLocationsearch()
	{
		$_POST = json_decode(file_get_contents("php://input"), TRUE);
		
		if(!$this->checkMethod())
		{
			return FALSE;
		}

		$from_date = '';
		$to_date = '';
		$paguthi='';
		$keyword = '';
		$offset = '';
		$rowcount = '';
		$dynamic_db = '';
		
		$from_date = $this->input->post("from_date");
		$to_date = $this->input->post("to_date");	
		$paguthi=$this->input->post('paguthi');
		//$keyword=$this->input->post('keyword');
		$keyword=$this->db->escape_str($this->input->post('keyword'));
		$offset = $this->input->post("offset");
		$rowcount = $this->input->post("rowcount");
		$dynamic_db = $this->input->post("dynamic_db");
		
		$data['result']=$this->apiiosmodel->Report_locationsearch($from_date,$to_date,$paguthi,$keyword,$offset,$rowcount,$dynamic_db);
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//



//-----------------------------------------------//

	public function reportMeetings()
	{
		$_POST = json_decode(file_get_contents("php://input"), TRUE);
		
		if(!$this->checkMethod())
		{
			return FALSE;
		}

		$from_date = '';
		$to_date = '';
		$dynamic_db = '';
		
		$from_date = $this->input->post("from_date");
		$to_date = $this->input->post("to_date");
		$offset = $this->input->post("offset");
		$rowcount = $this->input->post("rowcount");
		$dynamic_db = $this->input->post("dynamic_db");
		
		$data['result']=$this->apiiosmodel->Report_meetings($from_date,$to_date,$dynamic_db);
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//

//-----------------------------------------------//

	public function reportMeetingsnew()
	{
		$_POST = json_decode(file_get_contents("php://input"), TRUE);
		
		if(!$this->checkMethod())
		{
			return FALSE;
		}

		$from_date = '';
		$to_date = '';
		$offset = '';
		$rowcount = '';
		$dynamic_db = '';
		
		$from_date = $this->input->post("from_date");
		$to_date = $this->input->post("to_date");
		$offset = $this->input->post("offset");
		$rowcount = $this->input->post("rowcount");
		$dynamic_db = $this->input->post("dynamic_db");
		
		$data['result']=$this->apiiosmodel->Report_meetingsnew($from_date,$to_date,$offset,$rowcount,$dynamic_db);
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//

//-----------------------------------------------//

	public function reportMeetingssearch()
	{
		$_POST = json_decode(file_get_contents("php://input"), TRUE);
		
		if(!$this->checkMethod())
		{
			return FALSE;
		}

		$from_date = '';
		$to_date = '';
		$keyword = '';
		$offset = '';
		$rowcount = '';
		$dynamic_db = '';
		
		$from_date = $this->input->post("from_date");
		$to_date = $this->input->post("to_date");
		//$keyword = $this->input->post("keyword");
		$keyword=$this->db->escape_str($this->input->post('keyword'));
		$offset = $this->input->post("offset");
		$rowcount = $this->input->post("rowcount");
		$dynamic_db = $this->input->post("dynamic_db");
		
		$data['result']=$this->apiiosmodel->Report_meetingssearch($from_date,$to_date,$keyword,$offset,$rowcount,$dynamic_db);
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//



//-----------------------------------------------//

	public function reportStaff()
	{
		$_POST = json_decode(file_get_contents("php://input"), TRUE);
		
		if(!$this->checkMethod())
		{
			return FALSE;
		}

		$from_date = '';
		$to_date = '';
		$dynamic_db = '';
		
		$from_date = $this->input->post("from_date");
		$to_date = $this->input->post("to_date");
		$dynamic_db = $this->input->post("dynamic_db");
		
		$data['result']=$this->apiiosmodel->Report_staff($from_date,$to_date,$dynamic_db);
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//

//-----------------------------------------------//

	public function reportBirthday()
	{
		$_POST = json_decode(file_get_contents("php://input"), TRUE);
		
		if(!$this->checkMethod())
		{
			return FALSE;
		}

		$selMonth = '';
		$dynamic_db = '';
		
		$selMonth = $this->input->post("select_month");
		$dynamic_db = $this->input->post("dynamic_db");
		
		$data['result']=$this->apiiosmodel->Report_birthday($selMonth,$dynamic_db);
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//

//-----------------------------------------------//

	public function reportBirthdaynew()
	{
		$_POST = json_decode(file_get_contents("php://input"), TRUE);
		
		if(!$this->checkMethod())
		{
			return FALSE;
		}

		$selMonth = '';
		$offset = '';
		$rowcount = '';
		$dynamic_db = '';
		
		$selMonth = $this->input->post("select_month");
		$offset = $this->input->post("offset");
		$rowcount = $this->input->post("rowcount");
		$dynamic_db = $this->input->post("dynamic_db");
		
		$data['result']=$this->apiiosmodel->Report_birthdaynew($selMonth,$offset,$rowcount,$dynamic_db);
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//

//-----------------------------------------------//

	public function reportBirthdaysearch()
	{
		$_POST = json_decode(file_get_contents("php://input"), TRUE);
		
		if(!$this->checkMethod())
		{
			return FALSE;
		}

		$selMonth = '';
		$keyword = '';
		$offset = '';
		$rowcount = '';
		$dynamic_db = '';
		
		$selMonth = $this->input->post("select_month");
		//$keyword = $this->input->post("keyword");
		$keyword=$this->db->escape_str($this->input->post('keyword'));
		$offset = $this->input->post("offset");
		$rowcount = $this->input->post("rowcount");
		$dynamic_db = $this->input->post("dynamic_db");
		
		$data['result']=$this->apiiosmodel->Report_birthdaysearch($selMonth,$keyword,$offset,$rowcount,$dynamic_db);
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//

//-----------------------------------------------//

	public function activeCategory()
	{
		$_POST = json_decode(file_get_contents("php://input"), TRUE);
		
		if(!$this->checkMethod())
		{
			return FALSE;
		}

		$user_id = '';
		$dynamic_db = '';
		
		$user_id = $this->input->post("user_id");
		$dynamic_db = $this->input->post("dynamic_db");

		$data['result']=$this->apiiosmodel->Active_category($user_id,$dynamic_db);
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//

//-----------------------------------------------//

	public function activeSubcategory()
	{
		$_POST = json_decode(file_get_contents("php://input"), TRUE);
		
		if(!$this->checkMethod())
		{
			return FALSE;
		}

		$user_id = '';
		$dynamic_db = '';
		
		$user_id = $this->input->post("user_id");
		$dynamic_db = $this->input->post("dynamic_db");

		$data['result']=$this->apiiosmodel->Active_subcategory($user_id,$dynamic_db);
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//

}
