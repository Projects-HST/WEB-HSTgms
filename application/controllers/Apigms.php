<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Apigms extends CI_Controller {

	public function index()
	{
		$this->load->view('welcome_message');
	}

	function __construct()
    {
        parent::__construct();
		$this->load->model("apigmsmodel");
		$this->load->helper("url");
		$this->load->library('session');
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

	public function listRole()
	{
		if(!$this->checkMethod())
		{
			return FALSE;
		}

		$user_id = '';
		$user_id = $this->input->post("user_id");

		$data['result']=$this->apigmsmodel->List_role($user_id);
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//

//-----------------------------------------------//

	public function login()
	{
		if(!$this->checkMethod())
		{
			return FALSE;
		}
	
		$user_name = '';
		$password = '';
		$gcmkey ='';
		$mobiletype ='';

		$username = $this->input->post("user_name");
		$password = $this->input->post("password");
		$gcmkey = $this->input->post("device_id");
		$mobiletype = $this->input->post("mobile_type");

		$data['result']=$this->apigmsmodel->Login(strtoupper($username),strtoupper($password),$gcmkey,$mobiletype);
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//

	public function forgotPassword(){
		
		if(!$this->checkMethod())
		{
			return FALSE;
		}

		$user_name = '';
		$username = $this->input->post("user_name");
		
		$data['result']=$this->apigmsmodel->Forgot_password(strtoupper($username));
		$response = $data['result'];
		echo json_encode($response);
	}


//-----------------------------------------------//

    public function profilePictureUpload()
	{
		$user_id = $this->uri->segment(3);
		
		$profilepic = $_FILES['user_pic']['name'];
		$temp = pathinfo($profilepic, PATHINFO_EXTENSION);
		$staff_prof_pic = round(microtime(true)) . '.' . $temp;
		$uploaddir = 'assets/users/';
		$profilepic = $uploaddir.$staff_prof_pic;
		move_uploaded_file($_FILES['user_pic']['tmp_name'], $profilepic);

		$data['result']=$this->apigmsmodel->Update_profilepic($user_id,$staff_prof_pic);
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//

//-----------------------------------------------//

	public function profileDetails()
	{
		if(!$this->checkMethod())
		{
			return FALSE;
		}

        $user_id = '';
        $user_id = $this->input->post("user_id");

		$data['result']=$this->apigmsmodel->Profile_details($user_id);
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//


//-----------------------------------------------//

	public function checkEmail()
	{
		if(!$this->checkMethod())
		{
			return FALSE;
		}

        $email = '';
        $email = $this->input->post("email");

		$data['result']=$this->apigmsmodel->Check_email(strtoupper($email));
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//


//-----------------------------------------------//

	public function checkEmailedit()
	{
		if(!$this->checkMethod())
		{
			return FALSE;
		}

        $email = '';
		$user_id ='';
		$user_id = $this->input->post("user_id");
        $email = $this->input->post("email");

		$data['result']=$this->apigmsmodel->Check_emailedit($user_id,strtoupper($email));
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//

//-----------------------------------------------//

	public function profileUpdate()
	{

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

		$user_id= $this->input->post('user_id');
		$name=$this->input->post('name');
		$address= $this->db->escape_str($this->input->post('address'));
		$phone=$this->input->post('phone');
		$email=$this->input->post('email');
		$gender=$this->input->post('gender');

		$data['result']=$this->apigmsmodel->Profile_update(strtoupper($name),strtoupper($address),$phone,strtoupper($email),$gender,$user_id);
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//

//-----------------------------------------------//

	/* public function forgotPasswordOTP()
	{
		$_POST = json_decode(file_get_contents("php://input"), TRUE);

		if(!$this->checkMethod())
		{
			return FALSE;
		}

		if($_POST == FALSE)
		{
			$res = array();
			$res["opn"] = "Forgot Password OTP";
			$res["scode"] = 204;
			$res["message"] = "Input error";

			echo json_encode($res);
			return;
		}

		$mobile_no = '';
		$OTP = '';
	 	$mobile_no = $this->input->post("mobile_no");
	 	$OTP = $this->input->post("OTP");


		$data['result']=$this->apimainmodel->Forgot_password_otp($mobile_no,$OTP);
		$response = $data['result'];
		echo json_encode($response); 
	}*/

//-----------------------------------------------//

	/* public function resetPassword()
	{
		$_POST = json_decode(file_get_contents("php://input"), TRUE);

		if(!$this->checkMethod())
		{
			return FALSE;
		}

		if($_POST == FALSE)
		{
			$res = array();
			$res["opn"] = "Reset Password";
			$res["scode"] = 204;
			$res["message"] = "Input error";

			echo json_encode($res);
			return;
		}

		$user_id = '';
		$password = '';

		$user_id = $this->input->post("user_id");
	 	$password = $this->input->post("password");

		$data['result']=$this->apimainmodel->Reset_password($user_id,$password);
		$response = $data['result'];
		echo json_encode($response);
	} */

//-----------------------------------------------//

//-----------------------------------------------//

	public function changePassword()
	{
		if(!$this->checkMethod())
		{
			return FALSE;
		}

		$user_id = '';
		$password = '';
		$oldpassword = '';

		$user_id = $this->input->post("user_id");
	 	$password = $this->input->post("password");
		$oldpassword = $this->input->post("old_password");

		$data['result']=$this->apigmsmodel->Change_password($user_id,$password,$oldpassword);
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//

//-----------------------------------------------//

	public function dashBoard()
	{
		if(!$this->checkMethod())
		{
			return FALSE;
		}

		$paguthi = '';
		$paguthi = $this->input->post("paguthi");

		$data['result']=$this->apigmsmodel->Dashboard($paguthi);
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//

//-----------------------------------------------//

	public function editConstituency()
	{
		if(!$this->checkMethod())
		{
			return FALSE;
		}

		$constituency_id = '';
		$constituency_id = $this->input->post("constituency_id");

		$data['result']=$this->apigmsmodel->Edit_constituency($constituency_id);
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//

//-----------------------------------------------//

	public function updateConstituency()
	{
		if(!$this->checkMethod())
		{
			return FALSE;
		}

		$user_id = '';
		$constituency_id = '';
		$constituency_name = '';
		$user_id = $this->input->post("user_id");
		$constituency_id = $this->input->post("constituency_id");
		$constituency_name = $this->input->post("constituency_name");

		$data['result']=$this->apigmsmodel->Update_constituency($user_id,$constituency_id,strtoupper($constituency_name));
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//

//-----------------------------------------------//

	public function addPaguthi()
	{
		if(!$this->checkMethod())
		{
			return FALSE;
		}
		
		$user_id = '';
		$constituency_id = '';
		$paguthi_name = '';
		$paguthi_short_name = '';
		$status = '';
		$user_id = $this->input->post("user_id");
		$constituency_id = $this->input->post("constituency_id");
		$paguthi_name = $this->input->post("paguthi_name");
		$paguthi_short_name = $this->input->post("paguthi_short_name");
		$status = $this->input->post("status");

		$data['result']=$this->apigmsmodel->Add_paguthi($user_id,$constituency_id,strtoupper($paguthi_name),strtoupper($paguthi_short_name),strtoupper($status));
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//

//-----------------------------------------------//

	public function listPaguthi()
	{
		if(!$this->checkMethod())
		{
			return FALSE;
		}

		$constituency_id = '';
		$constituency_id = $this->input->post("constituency_id");

		$data['result']=$this->apigmsmodel->List_paguthi($constituency_id);
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//

//-----------------------------------------------//

	public function editPaguthi()
	{
		if(!$this->checkMethod())
		{
			return FALSE;
		}

		$paguthi_id = '';
		$paguthi_id = $this->input->post("paguthi_id");

		$data['result']=$this->apigmsmodel->Edit_paguthi($paguthi_id);
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//

//-----------------------------------------------//

	public function updatePaguthi()
	{
		if(!$this->checkMethod())
		{
			return FALSE;
		}

		$user_id = '';
		$paguthi_id = '';
		$paguthi_name = '';
		$paguthi_short_name = '';
		$status = '';
		$user_id = $this->input->post("user_id");
		$paguthi_id = $this->input->post("paguthi_id");
		$paguthi_name = $this->input->post("paguthi_name");
		$paguthi_short_name = $this->input->post("paguthi_short_name");
		$status = $this->input->post("status");

		$data['result']=$this->apigmsmodel->Update_paguthi($user_id,$paguthi_id,strtoupper($paguthi_name),strtoupper($paguthi_short_name),strtoupper($status));
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//

//-----------------------------------------------//

	public function addWard()
	{
		if(!$this->checkMethod())
		{
			return FALSE;
		}
		
		$user_id = '';
		$constituency_id='';
		$paguthi_id = '';
		$ward_name = '';
		$status = '';
		$user_id = $this->input->post("user_id");
		$constituency_id = $this->input->post("constituency_id");
		$paguthi_id = $this->input->post("paguthi_id");
		$ward_name = $this->input->post("ward_name");
		$status = $this->input->post("status");

		$data['result']=$this->apigmsmodel->Add_ward($user_id,$constituency_id,$paguthi_id,strtoupper($ward_name),strtoupper($status));
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//

//-----------------------------------------------//

	public function listWard()
	{
		if(!$this->checkMethod())
		{
			return FALSE;
		}

		$user_id = '';
		$user_id = $this->input->post("user_id");

		$data['result']=$this->apigmsmodel->List_ward($user_id);
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//

//-----------------------------------------------//

	public function listPaguthiward()
	{
		if(!$this->checkMethod())
		{
			return FALSE;
		}

		$paguthi_id = '';
		$paguthi_id = $this->input->post("paguthi_id");

		$data['result']=$this->apigmsmodel->List_paguthiward($paguthi_id);
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//

//-----------------------------------------------//

	public function editWard()
	{
		if(!$this->checkMethod())
		{
			return FALSE;
		}

		$ward_id = '';
		$ward_id = $this->input->post("ward_id");

		$data['result']=$this->apigmsmodel->Edit_ward($ward_id);
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//

//-----------------------------------------------//

	public function updateWard()
	{
		if(!$this->checkMethod())
		{
			return FALSE;
		}

		$user_id = '';
		$paguthi_id = '';
		$ward_id = '';
		$ward_name = '';
		$status = '';
		$user_id = $this->input->post("user_id");
		$paguthi_id = $this->input->post("paguthi_id");
		$ward_id = $this->input->post("ward_id");
		$ward_name = $this->input->post("ward_name");
		$status = $this->input->post("status");

		$data['result']=$this->apigmsmodel->Update_ward($user_id,$paguthi_id,$ward_id,strtoupper($ward_name),strtoupper($status));
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//

//-----------------------------------------------//

	public function addBooth()
	{
		if(!$this->checkMethod())
		{
			return FALSE;
		}
		
		$user_id = '';
		$constituency_id='';
		$paguthi_id = '';
		$ward_id = '';
		$booth_name = '';
		$status = '';
		$user_id = $this->input->post("user_id");
		$constituency_id = $this->input->post("constituency_id");
		$paguthi_id = $this->input->post("paguthi_id");
		$ward_id = $this->input->post("ward_id");
		$booth_name = $this->input->post("booth_name");
		$booth_address= $this->db->escape_str($this->input->post('booth_address'));
		$status = $this->input->post("status");

		$data['result']=$this->apigmsmodel->Add_booth($user_id,$constituency_id,$paguthi_id,$ward_id,strtoupper($booth_name),strtoupper($booth_address),strtoupper($status));
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//

//-----------------------------------------------//

	public function listBooth()
	{
		if(!$this->checkMethod())
		{
			return FALSE;
		}

		$user_id = '';
		$user_id = $this->input->post("user_id");

		$data['result']=$this->apigmsmodel->List_booth($user_id);
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//

//-----------------------------------------------//

	public function listWardbooth()
	{
		if(!$this->checkMethod())
		{
			return FALSE;
		}

		$ward_id = '';
		$ward_id = $this->input->post("ward_id");

		$data['result']=$this->apigmsmodel->List_wardbooth($ward_id);
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//

//-----------------------------------------------//

	public function editBooth()
	{
		if(!$this->checkMethod())
		{
			return FALSE;
		}

		$booth_id = '';
		$booth_id = $this->input->post("booth_id");

		$data['result']=$this->apigmsmodel->Edit_booth($booth_id);
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//

//-----------------------------------------------//

	public function updateBooth()
	{
		if(!$this->checkMethod())
		{
			return FALSE;
		}

		$user_id = '';
		$ward_id = '';
		$booth_id = '';
		$booth_name = '';
		$status = '';
		$user_id = $this->input->post("user_id");
		$ward_id = $this->input->post("ward_id");
		$booth_id = $this->input->post("booth_id");
		$booth_name = $this->input->post("booth_name");
		$booth_address= $this->db->escape_str($this->input->post('booth_address'));
		$status = $this->input->post("status");

		$data['result']=$this->apigmsmodel->Update_booth($user_id,$ward_id,$booth_id,strtoupper($booth_name),strtoupper($booth_address),strtoupper($status));
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//

//-----------------------------------------------//

	public function addSeekertype()
	{
		if(!$this->checkMethod())
		{
			return FALSE;
		}
		
		$user_id = '';
		$seekertype='';
		$status = '';
		$user_id = $this->input->post("user_id");
		$seekertype = $this->input->post("seekertype");
		$status = $this->input->post("status");

		$data['result']=$this->apigmsmodel->Add_seekertype($user_id,strtoupper($seekertype),strtoupper($status));
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//

//-----------------------------------------------//

	public function listSeekertype()
	{
		if(!$this->checkMethod())
		{
			return FALSE;
		}

		$user_id = '';
		$user_id = $this->input->post("user_id");

		$data['result']=$this->apigmsmodel->List_seekertype($user_id);
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//

//-----------------------------------------------//

	public function activeSeekertype()
	{
		if(!$this->checkMethod())
		{
			return FALSE;
		}

		$user_id = '';
		$user_id = $this->input->post("user_id");

		$data['result']=$this->apigmsmodel->Active_seekertype($user_id);
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//

//-----------------------------------------------//

	public function editSeekertype()
	{
		if(!$this->checkMethod())
		{
			return FALSE;
		}

		$seekertype_id = '';
		$seekertype_id = $this->input->post("seekertype_id");

		$data['result']=$this->apigmsmodel->Edit_seekertype($seekertype_id);
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//

//-----------------------------------------------//

	public function updateSeekertype()
	{
		if(!$this->checkMethod())
		{
			return FALSE;
		}

		$user_id = '';
		$ward_id = '';
		$booth_id = '';
		$booth_name = '';
		$status = '';
		$user_id = $this->input->post("user_id");
		$seekertype_id = $this->input->post("seekertype_id");
		$seekertype = $this->input->post("seekertype");
		$status = $this->input->post("status");

		$data['result']=$this->apigmsmodel->Update_seekertype($user_id,$seekertype_id,strtoupper($seekertype),strtoupper($status));
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//

//-----------------------------------------------//

	public function addGrievance()
	{
		if(!$this->checkMethod())
		{
			return FALSE;
		}
		
		$user_id = '';
		$seekertype='';
		$status = '';
		$user_id = $this->input->post("user_id");
		$seekertype_id = $this->input->post("seekertype_id");
		$grievance_name = $this->input->post("grievance_name");
		$status = $this->input->post("status");

		$data['result']=$this->apigmsmodel->Add_grievance($user_id,$seekertype_id,strtoupper($grievance_name),strtoupper($status));
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//

//-----------------------------------------------//

	public function listGrievance()
	{
		if(!$this->checkMethod())
		{
			return FALSE;
		}

		$user_id = '';
		$user_id = $this->input->post("user_id");

		$data['result']=$this->apigmsmodel->List_grievance($user_id);
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//

//-----------------------------------------------//

	public function activeGrievance()
	{
		if(!$this->checkMethod())
		{
			return FALSE;
		}

		$user_id = '';
		$user_id = $this->input->post("user_id");

		$data['result']=$this->apigmsmodel->Active_grievance($user_id);
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//

//-----------------------------------------------//

	public function listseekerGrievance()
	{
		if(!$this->checkMethod())
		{
			return FALSE;
		}

		$seekertype_id = '';
		$seekertype_id = $this->input->post("seekertype_id");

		$data['result']=$this->apigmsmodel->List_seekergrievance($seekertype_id);
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//

//-----------------------------------------------//

	public function editGrievance()
	{
		if(!$this->checkMethod())
		{
			return FALSE;
		}

		$grievancetype_id = '';
		$grievancetype_id = $this->input->post("grievancetype_id");

		$data['result']=$this->apigmsmodel->Edit_grievance($grievancetype_id);
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//

//-----------------------------------------------//

	public function updateGrievance()
	{
		if(!$this->checkMethod())
		{
			return FALSE;
		}

		$user_id = '';
		$seekertype='';
		$status = '';
		$user_id = $this->input->post("user_id");
		$seekertype_id = $this->input->post("seekertype_id");
		$grievance_id = $this->input->post("grievance_id");
		$grievance_name = $this->input->post("grievance_name");
		$status = $this->input->post("status");

		$data['result']=$this->apigmsmodel->Update_grievance($user_id,$seekertype_id,$grievance_id,strtoupper($grievance_name),strtoupper($status));
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//

//-----------------------------------------------//

	public function addSubcategory()
	{
		if(!$this->checkMethod())
		{
			return FALSE;
		}
		
		$user_id = '';
		$seekertype='';
		$status = '';
		$user_id = $this->input->post("user_id");
		$grievance_id = $this->input->post("grievance_id");
		$subcategory_name = $this->input->post("subcategory_name");
		$status = $this->input->post("status");

		$data['result']=$this->apigmsmodel->Add_subcategory($user_id,$grievance_id,strtoupper($subcategory_name),strtoupper($status));
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//

//-----------------------------------------------//

	public function listSubcategory()
	{
		if(!$this->checkMethod())
		{
			return FALSE;
		}

		$user_id = '';
		$user_id = $this->input->post("user_id");

		$data['result']=$this->apigmsmodel->List_subcategory($user_id);
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//

//-----------------------------------------------//

	public function activeSubcategory()
	{
		if(!$this->checkMethod())
		{
			return FALSE;
		}

		$user_id = '';
		$user_id = $this->input->post("user_id");

		$data['result']=$this->apigmsmodel->Active_subcategory($user_id);
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//

//-----------------------------------------------//

	public function listGrievancesubcategory()
	{
		if(!$this->checkMethod())
		{
			return FALSE;
		}

		$grievance_id = '';
		$grievance_id = $this->input->post("grievance_id");

		$data['result']=$this->apigmsmodel->List_grievancesubcategory($grievance_id);
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//

//-----------------------------------------------//

	public function editSubcategory()
	{
		if(!$this->checkMethod())
		{
			return FALSE;
		}

		$subcategory_id = '';
		$subcategory_id = $this->input->post("subcategory_id");

		$data['result']=$this->apigmsmodel->Edit_subcategory($subcategory_id);
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//

//-----------------------------------------------//

	public function updateSubcategory()
	{
		if(!$this->checkMethod())
		{
			return FALSE;
		}

		$user_id = '';
		$grievance_id='';
		$subcategory_id='';
		$subcategory_name='';
		$status = '';
		
		$user_id = $this->input->post("user_id");
		$grievance_id = $this->input->post("grievance_id");
		$subcategory_id = $this->input->post("subcategory_id");
		$subcategory_name = $this->input->post("subcategory_name");
		$status = $this->input->post("status");

		$data['result']=$this->apigmsmodel->Update_subcategory($user_id,$grievance_id,$subcategory_id,strtoupper($subcategory_name),strtoupper($status));
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//

//-----------------------------------------------//

	public function addSMStemplate()
	{
		if(!$this->checkMethod())
		{
			return FALSE;
		}
		
		$user_id = '';
		$template_type='';
		$sms_title = '';
		$sms_text = '';
		$status = '';
		$user_id = $this->input->post("user_id");
		$template_type = $this->input->post("template_type");
		$sms_title = $this->input->post("sms_title");
		$sms_text= $this->db->escape_str($this->input->post('sms_text'));
		$status = $this->input->post("status");

		$data['result']=$this->apigmsmodel->Add_smstemplate($user_id,strtoupper($template_type),strtoupper($sms_title),strtoupper($sms_text),strtoupper($status));
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//

//-----------------------------------------------//

	public function listSMStemplate()
	{
		if(!$this->checkMethod())
		{
			return FALSE;
		}

		$user_id = '';
		$user_id = $this->input->post("user_id");

		$data['result']=$this->apigmsmodel->List_smstemplate($user_id);
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//

//-----------------------------------------------//

	public function activeSMStemplate()
	{
		if(!$this->checkMethod())
		{
			return FALSE;
		}

		$user_id = '';
		$user_id = $this->input->post("user_id");

		$data['result']=$this->apigmsmodel->Active_smstemplate($user_id);
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//

//-----------------------------------------------//

	public function editSMStemplate()
	{
		if(!$this->checkMethod())
		{
			return FALSE;
		}

		$template_id = '';
		$template_id = $this->input->post("template_id");

		$data['result']=$this->apigmsmodel->Edit_smstemplate($template_id);
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//

//-----------------------------------------------//

	public function updateSMStemplate()
	{
		if(!$this->checkMethod())
		{
			return FALSE;
		}

		$user_id = '';
		$template_id = '';
		$template_type='';
		$sms_title = '';
		$sms_text = '';
		$status = '';
		
		$user_id = $this->input->post("user_id");
		$template_id = $this->input->post("template_id");
		$template_type = $this->input->post("template_type");
		$sms_title = $this->input->post("sms_title");
		$sms_text= $this->db->escape_str($this->input->post('sms_text'));
		$status = $this->input->post("status");

		$data['result']=$this->apigmsmodel->Update_smstemplate($user_id,$template_id,strtoupper($template_type),strtoupper($sms_title),strtoupper($sms_text),strtoupper($status));
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//

//-----------------------------------------------//

	public function getSMSdetails()
	{
		if(!$this->checkMethod())
		{
			return FALSE;
		}

		$template_id = '';
		$template_id = $this->input->post("template_id");
		
		$data['result']=$this->apigmsmodel->get_SMSdetails($template_id);
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//

//-----------------------------------------------//

	public function addInteraction()
	{
		if(!$this->checkMethod())
		{
			return FALSE;
		}
		
		$user_id = '';
		$widgets_title='';
		$interaction_text = '';
		$status = '';
		
		$user_id = $this->input->post("user_id");
		$widgets_title = $this->input->post("widgets_title");
		$interaction_text= $this->db->escape_str($this->input->post('interaction_text'));
		$status = $this->input->post("status");

		$data['result']=$this->apigmsmodel->Add_interaction($user_id,strtoupper($widgets_title),strtoupper($interaction_text),strtoupper($status));
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//

//-----------------------------------------------//

	public function listInteraction()
	{
		if(!$this->checkMethod())
		{
			return FALSE;
		}

		$user_id = '';
		$user_id = $this->input->post("user_id");

		$data['result']=$this->apigmsmodel->List_interaction($user_id);
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//

//-----------------------------------------------//

	public function activeInteraction()
	{
		if(!$this->checkMethod())
		{
			return FALSE;
		}

		$user_id = '';
		$user_id = $this->input->post("user_id");

		$data['result']=$this->apigmsmodel->Active_interaction($user_id);
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//

//-----------------------------------------------//

	public function editInteraction()
	{
		if(!$this->checkMethod())
		{
			return FALSE;
		}

		$interaction_id = '';
		$interaction_id = $this->input->post("interaction_id");

		$data['result']=$this->apigmsmodel->Edit_interaction($interaction_id);
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//

//-----------------------------------------------//

	public function updateInteraction()
	{
		if(!$this->checkMethod())
		{
			return FALSE;
		}

		$user_id = '';
		$interaction_id ='';
		$widgets_title='';
		$interaction_text = '';
		$status = '';
		
		$user_id = $this->input->post("user_id");
		$interaction_id = $this->input->post("interaction_id");
		$widgets_title = $this->input->post("widgets_title");
		$interaction_text= $this->db->escape_str($this->input->post('interaction_text'));
		$status = $this->input->post("status");

		$data['result']=$this->apigmsmodel->Update_interaction($user_id,$interaction_id,strtoupper($widgets_title),strtoupper($interaction_text),strtoupper($status));
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//


//-----------------------------------------------//

	public function addUser()
	{
		if(!$this->checkMethod())
		{
			return FALSE;
		}
		
		$user_id ='';
		$constituency_id = '';
		$role='';
		$paguthi='';
		$name='';
		$email='';
		$mobile='';
		$address= '';
		$gender='';
		$status='';
		
		$user_id = $this->input->post("user_id");
		$constituency_id = $this->input->post("constituency_id");
		$role=$this->input->post('role');
		$paguthi=$this->input->post('paguthi');
		$name=$this->input->post('name');
		$email=$this->input->post('email');
		$mobile=$this->input->post('phone');
		$address= $this->db->escape_str($this->input->post('address'));
		$gender=$this->input->post('gender');
		$status=$this->input->post('status');

		$data['result']=$this->apigmsmodel->Add_user($user_id,$constituency_id,$role,$paguthi,strtoupper($name),strtoupper($email),$mobile,strtoupper($address),$gender,strtoupper($status));
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//

//-----------------------------------------------//

	public function listUser()
	{
		if(!$this->checkMethod())
		{
			return FALSE;
		}

		$user_id = '';
		$user_id = $this->input->post("user_id");

		$data['result']=$this->apigmsmodel->List_user($user_id);
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//

//-----------------------------------------------//

	public function editUser()
	{
		if(!$this->checkMethod())
		{
			return FALSE;
		}

		$staff_id = '';
		$staff_id = $this->input->post("staff_id");

		$data['result']=$this->apigmsmodel->Edit_user($staff_id);
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//

//-----------------------------------------------//

	public function updateUser()
	{
		if(!$this->checkMethod())
		{
			return FALSE;
		}

		$user_id = '';
		$staff_id = '';
		$constituency_id = '';
		$role='';
		$paguthi='';
		$name='';
		$email='';
		$mobile='';
		$address= '';
		$gender='';
		$status='';
		
		$user_id = $this->input->post("constituency_id");
		$constituency_id = $this->input->post("constituency_id");
		$staff_id = $this->input->post("staff_id");
		$role=$this->input->post('role');
		$paguthi=$this->input->post('paguthi');
		$name=$this->input->post('name');
		$email=$this->input->post('email');
		$mobile=$this->input->post('phone');
		$address= $this->db->escape_str($this->input->post('address'));
		$gender=$this->input->post('gender');
		$status=$this->input->post('status');

		$data['result']=$this->apigmsmodel->Update_user($user_id,$constituency_id,$staff_id,$role,$paguthi,strtoupper($name),strtoupper($email),$mobile,strtoupper($address),$gender,strtoupper($status));
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//


//-----------------------------------------------//

	public function chkSerialno()
	{
		if(!$this->checkMethod())
		{
			return FALSE;
		}

		$serial_no = '';
		$serial_no = $this->input->post("serial_no");

		$data['result']=$this->apigmsmodel->Chk_serialno($serial_no);
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//

//-----------------------------------------------//

	public function chkVoterid()
	{
		if(!$this->checkMethod())
		{
			return FALSE;
		}

		$voter_id = '';
		$voter_id = $this->input->post("voter_id_no");

		$data['result']=$this->apigmsmodel->Chk_voterid($voter_id);
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//

//-----------------------------------------------//

	public function chkAadhaarno()
	{
		if(!$this->checkMethod())
		{
			return FALSE;
		}

		$aadhaar_no = '';
		$aadhaar_no = $this->input->post("aadhaar_no");

		$data['result']=$this->apigmsmodel->Chk_aadhaarno($aadhaar_no);
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//

//-----------------------------------------------//

	public function chkSerialnoexist()
	{
		if(!$this->checkMethod())
		{
			return FALSE;
		}

		$serial_no = '';
		$constituent_id = '';
		$constituent_id = $this->input->post("constituent_id");
		$serial_no = $this->input->post("serial_no");

		$data['result']=$this->apigmsmodel->serialno_exist($constituent_id,$serial_no);
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//

//-----------------------------------------------//

	public function chkVoteridexist()
	{
		if(!$this->checkMethod())
		{
			return FALSE;
		}

		$voter_id = '';
		$constituent_id = '';
		$constituent_id = $this->input->post("constituent_id");
		$voter_id = $this->input->post("voter_id_no");

		$data['result']=$this->apigmsmodel->voterid_exist($constituent_id,$voter_id);
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//

//-----------------------------------------------//

	public function chkAadhaarexist()
	{
		if(!$this->checkMethod())
		{
			return FALSE;
		}

		$aadhaar_no = '';
		$constituent_id = '';
		$constituent_id = $this->input->post("constituent_id");
		$aadhaar_no = $this->input->post("aadhaar_no");

		$data['result']=$this->apigmsmodel->aadhaarnum_exist($constituent_id,$aadhaar_no);
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//


//-----------------------------------------------//

	public function addConstituent()
	{
		if(!$this->checkMethod())
		{
			return FALSE;
		}
		
		$user_id ='';
		$constituency_id='';
		$paguthi_id='';
		$ward_id='';
		$booth_id='';
		$party_member_status='';
		$vote_type='';
		$serial_no='';
		$full_name='';
		$father_husband_name='';
		$guardian_name='';
		$email_id='';
		$mobile_no='';
		$whatsapp_no='';
		$originalDate='';
		$dob = '';
		$door_no='';
		$address='';
		$pin_code='';
		$religion_id='';
		$gender='';
		$voter_id_status='';
		$voter_id_no='';
		$aadhaar_status='';
		$aadhaar_no='';
		$interaction_section='';
		$question_id='';
		$question_response='';
		$status='';
			
		$user_id=$this->input->post('user_id');;
		$constituency_id=$this->input->post('constituency_id');
		$paguthi_id=$this->input->post('paguthi_id');
		$ward_id=$this->input->post('ward_id');
		$booth_id=$this->input->post('booth_id');
		$party_member_status=strtoupper($this->db->escape_str($this->input->post('party_member_status')));
		$vote_type=strtoupper($this->db->escape_str($this->input->post('vote_type')));
		$serial_no=strtoupper($this->db->escape_str($this->input->post('serial_no')));
		
		$full_name=strtoupper($this->db->escape_str($this->input->post('full_name')));
		$father_husband_name=strtoupper($this->db->escape_str($this->input->post('father_husband_name')));
		$guardian_name=strtoupper($this->db->escape_str($this->input->post('guardian_name')));
		$email_id=strtoupper($this->db->escape_str($this->input->post('email_id')));
		$mobile_no=strtoupper($this->db->escape_str($this->input->post('mobile_no')));
		$whatsapp_no=strtoupper($this->db->escape_str($this->input->post('whatsapp_no')));
		$originalDate=strtoupper($this->db->escape_str($this->input->post('dob')));
		$dob = date("Y-m-d", strtotime($originalDate));
		$door_no=strtoupper($this->db->escape_str($this->input->post('door_no')));
		$address=strtoupper($this->db->escape_str($this->input->post('address')));
		$pin_code=strtoupper($this->db->escape_str($this->input->post('pin_code')));
		$religion_id=strtoupper($this->db->escape_str($this->input->post('religion_id')));
		$gender=strtoupper($this->db->escape_str($this->input->post('gender')));
		$voter_id_status=strtoupper($this->db->escape_str($this->input->post('voter_id_status')));
		$voter_id_no=strtoupper($this->db->escape_str($this->input->post('voter_id_no')));
		$aadhaar_status=strtoupper($this->db->escape_str($this->input->post('aadhaar_status')));
		$aadhaar_no=strtoupper($this->db->escape_str($this->input->post('aadhaar_no')));
		
		$interaction_section=$this->input->post('interaction_section');
		$question_id=$this->input->post('question_id');
		$question_response=$this->input->post('question_response');

		$status=strtoupper($this->db->escape_str($this->input->post('status')));
			
		$data['result']=$this->apigmsmodel->Add_constituent($constituency_id,$paguthi_id,$ward_id,$booth_id,$party_member_status,$vote_type,$serial_no,$full_name,$father_husband_name,$guardian_name,$email_id,$mobile_no,$whatsapp_no,$dob,$door_no,$address,$pin_code,$religion_id,$gender,$voter_id_status,$voter_id_no,$aadhaar_status,$aadhaar_no,$question_id,$question_response,$interaction_section,$user_id,$status);
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//

//-----------------------------------------------//

    public function constPictureUpload()
	{
		$const_id = $this->uri->segment(3);
		
		$profilepic = $_FILES['const_pic']['name'];
		$temp = pathinfo($profilepic, PATHINFO_EXTENSION);
		$const_prof_pic = round(microtime(true)) . '.' . $temp;
		$uploaddir = 'assets/constituent/';
		$profilepic = $uploaddir.$const_prof_pic;
		move_uploaded_file($_FILES['const_pic']['tmp_name'], $profilepic);

		$data['result']=$this->apigmsmodel->Update_constpic($const_id,$const_prof_pic);
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//

//-----------------------------------------------//

	public function listConstituent()
	{
		if(!$this->checkMethod())
		{
			return FALSE;
		}

		$user_id = '';
		$user_id = $this->input->post("user_id");
		$data['result']=$this->apigmsmodel->List_constituent($user_id);
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//

//-----------------------------------------------//

	public function editConstituent()
	{
		if(!$this->checkMethod())
		{
			return FALSE;
		}

		$constituent_id = '';
		$constituent_id = $this->input->post("constituent_id");
		$data['result']=$this->apigmsmodel->Edit_constituent($constituent_id);
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//

//-----------------------------------------------//

	public function updateConstituent()
	{
		if(!$this->checkMethod())
		{
			return FALSE;
		}

		$user_id ='';
		$constituent_id = '';
		$constituency_id='';
		$paguthi_id='';
		$ward_id='';
		$booth_id='';
		$party_member_status='';
		$vote_type='';
		$serial_no='';
		$full_name='';
		$father_husband_name='';
		$guardian_name='';
		$email_id='';
		$mobile_no='';
		$whatsapp_no='';
		$originalDate='';
		$dob = '';
		$door_no='';
		$address='';
		$pin_code='';
		$religion_id='';
		$gender='';
		$voter_id_status='';
		$voter_id_no='';
		$aadhaar_status='';
		$aadhaar_no='';
		$interaction_section='';
		$question_id='';
		$question_response='';
		$status='';
		
		
		$user_id=$this->input->post('user_id');;
		$constituent_id = $this->input->post("constituent_id");
		$constituency_id=$this->input->post('constituency_id');
		$paguthi_id=$this->input->post('paguthi_id');
		$ward_id=$this->input->post('ward_id');
		$booth_id=$this->input->post('booth_id');
		$party_member_status=strtoupper($this->db->escape_str($this->input->post('party_member_status')));
		$vote_type=strtoupper($this->db->escape_str($this->input->post('vote_type')));
		$serial_no=strtoupper($this->db->escape_str($this->input->post('serial_no')));
		
		$full_name=strtoupper($this->db->escape_str($this->input->post('full_name')));
		$father_husband_name=strtoupper($this->db->escape_str($this->input->post('father_husband_name')));
		$guardian_name=strtoupper($this->db->escape_str($this->input->post('guardian_name')));
		$email_id=strtoupper($this->db->escape_str($this->input->post('email_id')));
		$mobile_no=strtoupper($this->db->escape_str($this->input->post('mobile_no')));
		$whatsapp_no=strtoupper($this->db->escape_str($this->input->post('whatsapp_no')));
		$originalDate=strtoupper($this->db->escape_str($this->input->post('dob')));
		$dob = date("Y-m-d", strtotime($originalDate));
		$door_no=strtoupper($this->db->escape_str($this->input->post('door_no')));
		$address=strtoupper($this->db->escape_str($this->input->post('address')));
		$pin_code=strtoupper($this->db->escape_str($this->input->post('pin_code')));
		$religion_id=strtoupper($this->db->escape_str($this->input->post('religion_id')));
		$gender=strtoupper($this->db->escape_str($this->input->post('gender')));
		$voter_id_status=strtoupper($this->db->escape_str($this->input->post('voter_id_status')));
		$voter_id_no=strtoupper($this->db->escape_str($this->input->post('voter_id_no')));
		$aadhaar_status=strtoupper($this->db->escape_str($this->input->post('aadhaar_status')));
		$aadhaar_no=strtoupper($this->db->escape_str($this->input->post('aadhaar_no')));
		
		//$interaction_section=$this->input->post('interaction_section');
		//$question_id=$this->input->post('question_id');
		//$question_response=$this->input->post('question_response');

		$status=strtoupper($this->db->escape_str($this->input->post('status')));
				
		$data['result']=$this->apigmsmodel->Update_constituent($constituent_id,$constituency_id,$paguthi_id,$ward_id,$booth_id,$party_member_status,$vote_type,$serial_no,$full_name,$father_husband_name,$guardian_name,$email_id,$mobile_no,$whatsapp_no,$dob,$door_no,$address,$pin_code,$religion_id,$gender,$voter_id_status,$voter_id_no,$aadhaar_status,$aadhaar_no,$user_id,$status);
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//

//-----------------------------------------------//

	public function addMeeting()
	{
		if(!$this->checkMethod())
		{
			return FALSE;
		}
		
		$user_id = '';
		$constituent_id = '';
		$meeting_status = '';
		$meeting_detail = '';
		$meeting_date = '';
		
		$user_id = $this->input->post("user_id");
		$constituent_id = $this->input->post("constituent_id");
		$meeting_status = $this->input->post("meeting_status");
		$meeting_detail = $this->db->escape_str($this->input->post('meeting_detail'));
		$originalDate = $this->db->escape_str($this->input->post('meeting_date'));
		$meeting_date = date("Y-m-d", strtotime($originalDate));

		$data['result']=$this->apigmsmodel->Add_meeting($user_id,$constituent_id,strtoupper($meeting_status),strtoupper($meeting_detail),$meeting_date);
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//

//-----------------------------------------------//

	public function listMeeting()
	{
		if(!$this->checkMethod())
		{
			return FALSE;
		}

		$constituent_id = '';
		$constituent_id = $this->input->post("constituent_id");

		$data['result']=$this->apigmsmodel->List_meeting($constituent_id);
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//

//-----------------------------------------------//

	public function editMeeting()
	{
		if(!$this->checkMethod())
		{
			return FALSE;
		}

		$meeting_id = '';
		$meeting_id = $this->input->post("meeting_id");

		$data['result']=$this->apigmsmodel->Edit_meeting($meeting_id);
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//

//-----------------------------------------------//

	public function updateMeeting()
	{
		if(!$this->checkMethod())
		{
			return FALSE;
		}

		$user_id = '';
		$meeting_id = '';
		$meeting_status = '';
		$meeting_detail = '';
		$meeting_date = '';
		
		$user_id = $this->input->post("user_id");
		$meeting_id = $this->input->post("meeting_id");
		$meeting_status = $this->input->post("meeting_status");
		$meeting_detail = $this->db->escape_str($this->input->post('meeting_detail'));
		$originalDate = $this->db->escape_str($this->input->post('meeting_date'));
		$meeting_date = date("Y-m-d", strtotime($originalDate));

		$data['result']=$this->apigmsmodel->Update_meeting($user_id,$meeting_id,strtoupper($meeting_status),strtoupper($meeting_detail),$meeting_date);
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//

//-----------------------------------------------//

	public function addInteractionresponse()
	{
		if(!$this->checkMethod())
		{
			return FALSE;
		}
		
		$user_id = '';
		$constituent_id='';
		$question_id = '';
		$question_response = '';
		
		$user_id = $this->input->post('user_id');
		$constituent_id=$this->input->post('constituent_id');
		$question_id=$this->input->post('question_id');
		$question_response=$this->input->post('question_response');

		$data['result']=$this->apigmsmodel->Save_interactionresponse($user_id,$constituent_id,$question_id,$question_response);
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//

//-----------------------------------------------//

	public function editInteractionresponse()
	{
		if(!$this->checkMethod())
		{
			return FALSE;
		}

		$constituent_id = '';
		$constituent_id = $this->input->post("constituent_id");

		$data['result']=$this->apigmsmodel->Edit_interactionresponse($constituent_id);
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//

//-----------------------------------------------//

	public function saveInteractionresponse()
	{
		if(!$this->checkMethod())
		{
			return FALSE;
		}

		$user_id = '';
		$constituent_id='';
		$question_id = '';
		$question_response = '';
		
		$user_id = $this->input->post('user_id');
		$constituent_id=$this->input->post('constituent_id');
		$question_id=$this->input->post('question_id');
		$question_response=$this->input->post('question_response');

		$data['result']=$this->apigmsmodel->Save_interactionresponse($user_id,$constituent_id,$question_id,$question_response);
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//

//-----------------------------------------------//

	public function addPlants()
	{
		if(!$this->checkMethod())
		{
			return FALSE;
		}
		
		$user_id = '';
		$constituent_id='';
		$no_of_plant = '';
		$name_of_plant = '';
		$status = '';
		
		$user_id = $this->input->post('user_id');
		$constituent_id=$this->input->post('constituent_id');
		$no_of_plant=$this->input->post('no_of_plant');
		$name_of_plant=$this->input->post('name_of_plant');
		$status=$this->input->post('status');

		$data['result']=$this->apigmsmodel->Add_plants($user_id,$constituent_id,$no_of_plant,strtoupper($name_of_plant),strtoupper($status));
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//

//-----------------------------------------------//

	public function editPlants()
	{
		if(!$this->checkMethod())
		{
			return FALSE;
		}

		$constituent_id = '';
		$constituent_id = $this->input->post("constituent_id");

		$data['result']=$this->apigmsmodel->Edit_plants($constituent_id);
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//

//-----------------------------------------------//

	public function updatePlants()
	{
		if(!$this->checkMethod())
		{
			return FALSE;
		}

		$user_id = '';
		$constituent_id='';
		$no_of_plant = '';
		$name_of_plant = '';
		$status = '';
		
		$user_id = $this->input->post('user_id');
		$constituent_id=$this->input->post('constituent_id');
		$plant_id=$this->input->post('plant_id');
		$no_of_plant=$this->input->post('no_of_plant');
		$name_of_plant=$this->input->post('name_of_plant');
		$status=$this->input->post('status');

		$data['result']=$this->apigmsmodel->Update_plants($user_id,$constituent_id,$plant_id,$no_of_plant,strtoupper($name_of_plant),strtoupper($status));
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//

//-----------------------------------------------//

	public function generatePetitionno()
	{
		if(!$this->checkMethod())
		{
			return FALSE;
		}

		$paguthi_id = '';
		$grievance_type = '';

		$paguthi_id=$this->input->post('paguthi_id');
		$grievance_type=$this->input->post('grievance_type');

		$data['result']=$this->apigmsmodel->Generate_petitionno($paguthi_id,$grievance_type);
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//

//-----------------------------------------------//

	public function addGrievancedetails()
	{
		if(!$this->checkMethod())
		{
			return FALSE;
		}

		$user_id = '';
		$constituent_id='';
		$grievance_type = '';
		
		$petition_enquiry_no = '';
		$grievance_date = '';
		
		$constituency_id = '';
		$paguthi_id = '';
		$seeker_id ='';
		$grievance_id = '';
		$sub_category_id = '';
		
		$reference_note = '';
		$description = '';
		
		$user_id = $this->input->post('user_id');
		$constituent_id=$this->input->post('constituent_id');
		$grievance_type=$this->input->post('grievance_type');
		
		$petition_enquiry_no=strtoupper($this->db->escape_str($this->input->post('petition_enquiry_no')));	
		$originalDate=strtoupper($this->db->escape_str($this->input->post('grievance_date')));
		$grievance_date = date("Y-m-d", strtotime($originalDate));
		
		$constituency_id=$this->input->post('constituency_id');
		$paguthi_id=$this->input->post('paguthi_id');
		$seeker_id=$this->input->post('seeker_id');
		$grievance_id=$this->input->post('grievance_id');
		$sub_category_id=$this->input->post('sub_category_id');

		$reference_note=strtoupper($this->db->escape_str($this->input->post('reference_note')));
		$description=strtoupper($this->db->escape_str($this->input->post('description')));
		
		$data['result']=$this->apigmsmodel->Add_grievancedetails($user_id,$constituent_id,$grievance_type,$petition_enquiry_no,$grievance_date,$constituency_id,$paguthi_id,$seeker_id,$grievance_id,$sub_category_id,$reference_note,$description);
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//

//-----------------------------------------------//

    public function addGrievancedoc()
	{
		
		$grev_id = $this->uri->segment(3);

		$constituent_id = $this->uri->input->post('constituent_id');
		$user_id = $this->input->post('user_id');
		$doc_tile = $this->input->post('doc_tile');
		
		$grevdoc = $_FILES['grev_doc']['name'];
		$temp = pathinfo($grevdoc, PATHINFO_EXTENSION);
		$doc_name = round(microtime(true)) . '.' . $temp;
		$uploaddir = 'assets/constituent/doc/';
		$grevdoc = $uploaddir.$doc_name;
		move_uploaded_file($_FILES['grev_doc']['tmp_name'], $grevdoc);

		$data['result']=$this->apigmsmodel->Add_grievancedoc($user_id,$const_id,$grev_id,$doc_tile,$doc_name);
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//

//-----------------------------------------------//

   public function listGrievancedoc()
	{
		if(!$this->checkMethod())
		{
			return FALSE;
		}

		$constituent_id = '';
		$constituent_id = $this->input->post("constituent_id");
		$data['result']=$this->apigmsmodel->List_grievancedoc($constituent_id);
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//

//-----------------------------------------------//

    public function addConstdoc()
	{
		$constituent_id = $this->input->post('constituent_id');
		$user_id = $this->input->post('user_id');
		$doc_tile = $this->input->post('doc_tile');
		
		$constdoc = $_FILES['const_doc']['name'];
		$temp = pathinfo($constdoc, PATHINFO_EXTENSION);
		$doc_name = round(microtime(true)) . '.' . $temp;
		$uploaddir = 'assets/constituent/doc/';
		$constdoc = $uploaddir.$doc_name;
		move_uploaded_file($_FILES['const_doc']['tmp_name'], $constdoc);

		$data['result']=$this->apigmsmodel->Add_constdoc($user_id,$constituent_id,$doc_tile,$doc_name);
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//

//-----------------------------------------------//

   public function listConstdoc()
	{
		if(!$this->checkMethod())
		{
			return FALSE;
		}

		$constituent_id = '';
		$constituent_id = $this->input->post("constituent_id");

		$data['result']=$this->apigmsmodel->List_constdoc($constituent_id);
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//

//-----------------------------------------------//

	public function dispConstdetails()
	{
		if(!$this->checkMethod())
		{
			return FALSE;
		}

		$constituent_id = '';
		$constituent_id = $this->input->post("constituent_id");

		$data['result']=$this->apigmsmodel->Disp_constdetails($constituent_id);
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//

//-----------------------------------------------//

	public function listallGrievance()
	{
		if(!$this->checkMethod())
		{
			return FALSE;
		}

		$user_id = '';
		$user_id = $this->input->post("user_id");

		$data['result']=$this->apigmsmodel->List_allgrievance($user_id);
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//

//-----------------------------------------------//

	public function listPetitions()
	{
		if(!$this->checkMethod())
		{
			return FALSE;
		}

		$user_id = '';
		$user_id = $this->input->post("user_id");

		$data['result']=$this->apigmsmodel->List_petitions($user_id);
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//

//-----------------------------------------------//

	public function listEnquries()
	{
		if(!$this->checkMethod())
		{
			return FALSE;
		}

		$user_id = '';
		$user_id = $this->input->post("user_id");

		$data['result']=$this->apigmsmodel->List_enquries($user_id);
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//

//-----------------------------------------------//

	public function editGrievancedetails()
	{
		if(!$this->checkMethod())
		{
			return FALSE;
		}

		$grievance_id = '';
		$grievance_id = $this->input->post("grievance_id");

		$data['result']=$this->apigmsmodel->Edit_grievancedetails($grievance_id);
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//

//-----------------------------------------------//

	public function updateGrievancedetails()
	{
		if(!$this->checkMethod())
		{
			return FALSE;
		}

		$grievance_id = '';
		$seeker_id='';
		$reference_note='';
		$grievance_tb_id='';
		$sub_category_id='';
		$description='';
		$user_id = '';
		
		$user_id = $this->input->post("user_id");
		$grievance_id = $this->input->post("grievance_id");
		$reference =strtoupper($this->db->escape_str($this->input->post('reference')));
		$seeker_id = $this->input->post('seeker_id');
		$grievance_type_id=$this->input->post('grievance_type_id');
		$sub_category_id=$this->input->post('sub_category_id');
		$description=strtoupper($this->db->escape_str($this->input->post('description')));
		
		$data['result']=$this->apigmsmodel->Update_grievancedetails($user_id,$grievance_id,$reference,$seeker_id,$grievance_type_id,$sub_category_id,$description);
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//

//-----------------------------------------------//

	public function statusUpdategrievance()
	{
		if(!$this->checkMethod())
		{
			return FALSE;
		}

		$grievance_id = '';
		$status = '';
		$sms_title = '';
		$sms_details = '';
		$user_id = '';
		$constituent_id = '';
		
		$user_id = $this->input->post("user_id");
		$constituent_id = $this->input->post("constituent_id");
		$grievance_id = $this->input->post("grievance_id");
		$status = $this->input->post("status");
		$sms_template_id = $this->input->post("sms_template_id");
		$sms_title = $this->input->post("sms_title");
		$sms_details = $this->input->post("sms_details");

		$data['result']=$this->apigmsmodel->Status_updategrievance($user_id,$constituent_id,$grievance_id,$sms_template_id,$status,$sms_title,$sms_details);
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//

//-----------------------------------------------//

	public function updateGrievancereference()
	{
		if(!$this->checkMethod())
		{
			return FALSE;
		}

		$user_id = '';
		$grievance_id = '';
		$reference='';
		$user_id = $this->input->post("user_id");
		$grievance_id = $this->input->post("grievance_id");
		$reference =strtoupper($this->db->escape_str($this->input->post('reference')));
		
		$data['result']=$this->apigmsmodel->Update_grievancereference($user_id,$grievance_id,$reference);
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//

//-----------------------------------------------//

	public function grievanceReplay()
	{
		if(!$this->checkMethod())
		{
			return FALSE;
		}

		$user_id = '';
		$grievance_id = '';
		$constituent_id='';
		$sms_template_id='';
		$sms_content = '';
		
		$user_id = $this->input->post("user_id");
		$grievance_id = $this->input->post("grievance_id");	
		$constituent_id=$this->input->post('constituent_id');
		$sms_template_id=$this->input->post('sms_template_id');
		$sms_content =strtoupper($this->db->escape_str($this->input->post('sms_details')));
		
		$data['result']=$this->apigmsmodel->Grievance_replay($user_id,$grievance_id,$constituent_id,$sms_template_id,$sms_content);
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//

//-----------------------------------------------//

	public function reportStatus()
	{
		if(!$this->checkMethod())
		{
			return FALSE;
		}

		$from_date = '';
		$to_date = '';
		$status='';
		$paguthi='';
		
		$from_date = $this->input->post("from_date");
		$to_date = $this->input->post("to_date");	
		$status=$this->input->post('status');
		$paguthi=$this->input->post('paguthi');
		
		$data['result']=$this->apigmsmodel->Report_status($from_date,$to_date,$status,$paguthi);
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//

//-----------------------------------------------//

	public function reportCategory()
	{
		if(!$this->checkMethod())
		{
			return FALSE;
		}

		$from_date = '';
		$to_date = '';
		$category='';
		
		$from_date = $this->input->post("from_date");
		$to_date = $this->input->post("to_date");	
		$category=$this->input->post('category');
		
		$data['result']=$this->apigmsmodel->Report_category($from_date,$to_date,$category);
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//

//-----------------------------------------------//

	public function reportsubCategory()
	{
		if(!$this->checkMethod())
		{
			return FALSE;
		}

		$from_date = '';
		$to_date = '';
		$sub_category='';
		
		$from_date = $this->input->post("from_date");
		$to_date = $this->input->post("to_date");	
		$sub_category=$this->input->post('sub_category');
		
		$data['result']=$this->apigmsmodel->Report_subcategory($from_date,$to_date,$sub_category);
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//

//-----------------------------------------------//

	public function reportLocation()
	{
		if(!$this->checkMethod())
		{
			return FALSE;
		}

		$from_date = '';
		$to_date = '';
		$paguthi='';
		
		$from_date = $this->input->post("from_date");
		$to_date = $this->input->post("to_date");	
		$paguthi=$this->input->post('paguthi');
		
		$data['result']=$this->apigmsmodel->Report_location($from_date,$to_date,$paguthi);
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//

//-----------------------------------------------//

	public function reportMeetings()
	{
		if(!$this->checkMethod())
		{
			return FALSE;
		}

		$from_date = '';
		$to_date = '';
		
		$from_date = $this->input->post("from_date");
		$to_date = $this->input->post("to_date");	
		
		$data['result']=$this->apigmsmodel->Report_meetings($from_date,$to_date);
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//

//-----------------------------------------------//

	public function updateMeetingrequest()
	{
		if(!$this->checkMethod())
		{
			return FALSE;
		}

		$user_id = '';
		$meeting_id = '';
		
		$user_id = $this->input->post("user_id");
		$meeting_id = $this->input->post("meeting_id");
		$status = $this->input->post("status");		
		
		$data['result']=$this->apigmsmodel->Update_meetingrequest($user_id,$meeting_id,strtoupper($status));
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//

//-----------------------------------------------//

	public function reportStaff()
	{
		if(!$this->checkMethod())
		{
			return FALSE;
		}

		$from_date = '';
		$to_date = '';
		
		$from_date = $this->input->post("from_date");
		$to_date = $this->input->post("to_date");	
		
		$data['result']=$this->apigmsmodel->Report_staff($from_date,$to_date);
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//

//-----------------------------------------------//

	public function reportBirthday()
	{
		if(!$this->checkMethod())
		{
			return FALSE;
		}

		$selMonth = '';
		$selMonth = $this->input->post("select_month");
		
		$data['result']=$this->apigmsmodel->Report_birthday($selMonth);
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//

//-----------------------------------------------//

	public function updateBirthday()
	{
		if(!$this->checkMethod())
		{
			return FALSE;
		}

		$user_id = '';
		$constituent_id = '';
		$user_id = $this->input->post("user_id");
		$constituent_id = $this->input->post("constituent_id");
		
		$data['result']=$this->apigmsmodel->Update_birthday($user_id,$constituent_id);
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//
}
