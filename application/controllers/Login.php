<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	function __construct() {
		 parent::__construct();
			$this->load->helper("url");
			$this->load->library('session');
			$this->load->library('session');
			$this->load->model('loginmodel');
 }

	public function index()
	{
			$user_id = $this->session->userdata('user_id');
			$user_type = $this->session->userdata('user_type');
			
			if($user_id){
				redirect('dashboard');
			}else{
				$this->load->view('login');
			}
	}


	public function login_check(){

		$username=$this->input->post('username');
		$password=md5($this->input->post('password'));
		
		$result = $this->loginmodel->login($username,$password);
		
		if($result['status']=='Inactive'){
			$this->session->set_flashdata('msg', 'Account inactive, please contact admin');
			redirect('/');
		}
	
		if($result['status']=='Error'){
			$this->session->set_flashdata('msg', "Invalid username/passsword. Kindly ensure they're correct.");
			redirect('/');
		}
		
		if($result['status']=='Active'){
					$email_id = $result['email_id'];
					$name=$result['name'];
					$user_type=$result['user_type'];
					$status=$result['status'];
					$user_id=$result['user_id'];
					$user_pic=$result['user_pic'];
					$datas= array("user_name"=>$email_id,"name"=>$name,"user_type"=>$user_type,"status"=>$status,"user_id"=>$user_id,"user_pic"=>$user_pic);
					print_r($datas);
					//exit;
					$session_data=$this->session->set_userdata($datas);
					redirect('dashboard');
		}
	}


	public function logout(){
		$datas=$this->session->userdata();
		$this->session->unset_userdata($datas);
		$this->session->sess_destroy();
		redirect('/');
	}

}
