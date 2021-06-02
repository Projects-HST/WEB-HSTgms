<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Apiconstituentios extends CI_Controller {

	function __construct()
    {
        parent::__construct();
		 $this->load->library('session');
		 $this->load->helper(array('url','db_dynamic_helper')); 
		 $this->load->model('apiconstituentmodelios');
    }
	
	public function index()
	{
		$this->load->view('welcome_message');
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

		$version_code = $this->input->post("version_code");
		
		$data['result']=$this->apiconstituentmodelios->version_check($version_code);
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
		
		$data['result']=$this->apiconstituentmodelios->chk_constituency_code($constituency_code);
		$response = $data['result'];
		echo json_encode($response);
	}

//-----------------------------------------------//

//-----------------------------------------------//

	public function mobile_check()
	{
		$_POST = json_decode(file_get_contents("php://input"), TRUE);
		
		if(!$this->checkMethod())
		{
			return FALSE;
		}

		$dynamic_db = '';
		$dynamic_db = $this->input->post("dynamic_db");
		$mobile_no = $this->input->post("mobile_no");
		
		$data['result']=$this->apiconstituentmodelios->mobile_check($mobile_no,$dynamic_db);
		$response = $data['result'];
		echo json_encode($response);
	}
	//-----------------------------------------------//

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
		$gcmkey = $this->input->post("device_id");
		$mobiletype = $this->input->post("mobile_type");
		$dynamic_db = $this->input->post("dynamic_db");
		
		$data['result']=$this->apiconstituentmodelios->mobile_verify($mobile_no,$otp,$gcmkey,$mobiletype,$dynamic_db);
		$response = $data['result'];
		echo json_encode($response);
	}
//-----------------------------------------------//
//-----------------------------------------------//

	public function user_list_and_details()
	{
		$_POST = json_decode(file_get_contents("php://input"), TRUE);

		if(!$this->checkMethod())
		{
			return FALSE;
		}

		$mobile_no = $this->input->post("mobile_no");
		$dynamic_db = $this->input->post("dynamic_db");
		
		$data['result']=$this->apiconstituentmodelios->user_list_and_details($mobile_no,$dynamic_db);
		$response = $data['result'];
		echo json_encode($response);
	}
//-----------------------------------------------//


//-----------------------------------------------//

	public function user_details()
	{
		$_POST = json_decode(file_get_contents("php://input"), TRUE);

		if(!$this->checkMethod())
		{
			return FALSE;
		}

		$constituent_id = $this->input->post("user_id");
		$dynamic_db = $this->input->post("dynamic_db");
		
		$data['result']=$this->apiconstituentmodelios->user_details($constituent_id,$dynamic_db);
		$response = $data['result'];
		echo json_encode($response);
	}
//-----------------------------------------------//


//-----------------------------------------------//

	public function greivance_list()
	{
		$_POST = json_decode(file_get_contents("php://input"), TRUE);

		if(!$this->checkMethod())
		{
			return FALSE;
		}

		$constituent_id = $this->input->post("user_id");
		$type = $this->input->post("type");
		$dynamic_db = $this->input->post("dynamic_db");
		
		$data['result']=$this->apiconstituentmodelios->greivance_list($constituent_id,$type,$dynamic_db);
		$response = $data['result'];
		echo json_encode($response);
	}
//-----------------------------------------------//

//-----------------------------------------------//

	public function greivance_details()
	{
		$_POST = json_decode(file_get_contents("php://input"), TRUE);

		if(!$this->checkMethod())
		{
			return FALSE;
		}

		$constituent_id = $this->input->post("user_id");
		$id = $this->input->post("id");
		$dynamic_db = $this->input->post("dynamic_db");
		
		$data['result']=$this->apiconstituentmodelios->greivance_details($constituent_id,$id,$dynamic_db);
		$response = $data['result'];
		echo json_encode($response);
	}
//-----------------------------------------------//

//-----------------------------------------------//

	public function meeting_list()
	{
		$_POST = json_decode(file_get_contents("php://input"), TRUE);

		if(!$this->checkMethod())
		{
			return FALSE;
		}

		$constituent_id = $this->input->post("user_id");
		$dynamic_db = $this->input->post("dynamic_db");
		
		$data['result']=$this->apiconstituentmodelios->meeting_list($constituent_id,$dynamic_db);
		$response = $data['result'];
		echo json_encode($response);
	}
//-----------------------------------------------//


//-----------------------------------------------//

	public function meeting_details()
	{
		$_POST = json_decode(file_get_contents("php://input"), TRUE);

		if(!$this->checkMethod())
		{
			return FALSE;
		}

		$constituent_id = $this->input->post("user_id");
		$id = $this->input->post("id");
		$dynamic_db = $this->input->post("dynamic_db");
		
		$data['result']=$this->apiconstituentmodelios->meeting_details($constituent_id,$id,$dynamic_db);
		$response = $data['result'];
		echo json_encode($response);
	}
//-----------------------------------------------//
//-----------------------------------------------//

	public function get_plant_donation()
	{
		$_POST = json_decode(file_get_contents("php://input"), TRUE);

		if(!$this->checkMethod())
		{
			return FALSE;
		}

		$constituent_id = $this->input->post("user_id");
		$dynamic_db = $this->input->post("dynamic_db");
		
		$data['result']=$this->apiconstituentmodelios->get_plant_donation($constituent_id,$dynamic_db);
		$response = $data['result'];
		echo json_encode($response);
	}
//-----------------------------------------------//

//-----------------------------------------------//

	public function notification_list()
	{
		$_POST = json_decode(file_get_contents("php://input"), TRUE);

		if(!$this->checkMethod())
		{
			return FALSE;
		}

		$constituent_id = $this->input->post("user_id");
		$dynamic_db = $this->input->post("dynamic_db");
		
		$data['result']=$this->apiconstituentmodelios->notification_list($constituent_id,$dynamic_db);
		$response = $data['result'];
		echo json_encode($response);
	}
//-----------------------------------------------//

//-----------------------------------------------//

	public function notification_details()
	{
		$_POST = json_decode(file_get_contents("php://input"), TRUE);

		if(!$this->checkMethod())
		{
			return FALSE;
		}

		$constituent_id = $this->input->post("user_id");
		$id = $this->input->post("id");
		$dynamic_db = $this->input->post("dynamic_db");
		
		$data['result']=$this->apiconstituentmodelios->notification_details($constituent_id,$id,$dynamic_db);
		$response = $data['result'];
		echo json_encode($response);
	}
//-----------------------------------------------//

//-----------------------------------------------//

	public function newsfeed_list()
	{
		$_POST = json_decode(file_get_contents("php://input"), TRUE);

		if(!$this->checkMethod())
		{
			return FALSE;
		}

		$constituent_id = $this->input->post("user_id");
		$dynamic_db = $this->input->post("dynamic_db");
		
		$data['result']=$this->apiconstituentmodelios->newsfeed_list($constituent_id,$dynamic_db);
		$response = $data['result'];
		echo json_encode($response);
	}
//-----------------------------------------------//

//-----------------------------------------------//

	public function newsfeed_details()
	{
		$_POST = json_decode(file_get_contents("php://input"), TRUE);

		if(!$this->checkMethod())
		{
			return FALSE;
		}

		$constituent_id = $this->input->post("user_id");
		$id = $this->input->post("id");
		$dynamic_db = $this->input->post("dynamic_db");
		
		$data['result']=$this->apiconstituentmodelios->newsfeed_details($constituent_id,$id,$dynamic_db);
		$response = $data['result'];
		echo json_encode($response);
	}
//-----------------------------------------------//

//-----------------------------------------------//

	public function view_banners()
	{
		$_POST = json_decode(file_get_contents("php://input"), TRUE);

		if(!$this->checkMethod())
		{
			return FALSE;
		}

		$constituent_id = $this->input->post("user_id");
		$dynamic_db = $this->input->post("dynamic_db");
		
		$data['result']=$this->apiconstituentmodelios->view_banners($constituent_id,$dynamic_db);
		$response = $data['result'];
		echo json_encode($response);
	}
//-----------------------------------------------//

}
