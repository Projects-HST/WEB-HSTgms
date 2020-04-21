<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
	function __construct() {
		 parent::__construct();
			$this->load->helper("url");
			$this->load->library('session');
 }

	public function index()
	{
		$datas=$this->session->userdata();
		$user_id=$this->session->userdata('user_id');
		$user_type=$this->session->userdata('user_type');
		//print_r($datas);
		if($user_type==1 || $user_type==2){
			$this->load->view('admin/header');
			$this->load->view('admin/dashboard/dashboard');
			$this->load->view('admin/footer');
		}else {
			redirect(base_url());
		}
	
	}

	public function form()
	{
		$this->load->view('admin/header');
		$this->load->view('admin/form');
		$this->load->view('admin/footer');
	}
}
