<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Apiconstituent extends CI_Controller {



	function __construct()
    {
    parent::__construct();
		$this->load->model("smsmodel");
		$this->load->model("apiconstituentmodel");
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

	public function index()
	{
		$this->load->view('welcome_message');
	}



	//-----------------------------------------------//

		public function mobile_check()
		{
			$_POST = json_decode(file_get_contents("php://input"), TRUE);
			if(!$this->checkMethod())
			{
				return FALSE;
			}

			$mobile_no = $this->input->post("mobile_no");
			$data['result']=$this->apiconstituentmodel->mobile_check($mobile_no);
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
		$data['result']=$this->apiconstituentmodel->mobile_verify($mobile_no,$otp,$gcmkey,$mobiletype);
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
		$data['result']=$this->apiconstituentmodel->user_list_and_details($mobile_no);
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
		$data['result']=$this->apiconstituentmodel->user_details($constituent_id);
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
		$data['result']=$this->apiconstituentmodel->greivance_list($constituent_id,$type);
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
		$data['result']=$this->apiconstituentmodel->greivance_details($constituent_id,$id);
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
		$data['result']=$this->apiconstituentmodel->meeting_list($constituent_id);
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
		$data['result']=$this->apiconstituentmodel->meeting_details($constituent_id,$id);
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
		$data['result']=$this->apiconstituentmodel->get_plant_donation($constituent_id);
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
		$data['result']=$this->apiconstituentmodel->notification_list($constituent_id);
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
		$data['result']=$this->apiconstituentmodel->notification_details($constituent_id,$id);
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
		$data['result']=$this->apiconstituentmodel->newsfeed_list($constituent_id);
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
		$data['result']=$this->apiconstituentmodel->newsfeed_details($constituent_id,$id);
		$response = $data['result'];
		echo json_encode($response);
	}
//-----------------------------------------------//

}
