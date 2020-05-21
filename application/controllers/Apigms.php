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

	public function listsubCategory()
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

	public function subCategorylist()
	{
		if(!$this->checkMethod())
		{
			return FALSE;
		}

		$category_id = '';
		$category_id = $this->input->post("category_id");

		$data['result']=$this->apigmsmodel->Subcategory_list($category_id);
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



}
