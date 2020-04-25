<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
	function __construct() {
		 parent::__construct();
			$this->load->helper("url");
			$this->load->library('session');
			$this->load->model('usermodel');
			$this->load->model('dashboardmodel');
 }

	public function index()
	{
		$datas=$this->session->userdata();
		$user_id=$this->session->userdata('user_id');
		$user_type=$this->session->userdata('user_type');
		$datas['paguthi'] = $this->usermodel->list_paguthi();
		$paguthi=$this->input->post('paguthi');
		
		if ($paguthi == ""){
			$paguthi_value = "All";
		}else {
			$paguthi_value=$paguthi;
		}
		$datas['res']=$this->dashboardmodel->get_dashboard_reult($paguthi_value);
		
		if($user_type==1 || $user_type==2){
			$this->load->view('admin/header');
			$this->load->view('admin/dashboard/dashboard',$datas);
			$this->load->view('admin/footer');
		}else {
			redirect(base_url());
		}
	}
	
	public function searchresult()
	{
		$datas=$this->session->userdata();
		$user_id=$this->session->userdata('user_id');
		$user_type=$this->session->userdata('user_type');
		
		//$datas['paguthi'] = $this->usermodel->list_paguthi();
		
		$keyword=$this->input->post('keyword');
		$datas['res']=$this->dashboardmodel->get_search_reult($keyword);
		
		if($user_type==1 || $user_type==2){
			$this->load->view('admin/header');
			$this->load->view('admin/dashboard/search_result',$datas);
			$this->load->view('admin/footer');
		}else {
			redirect(base_url());
		}
	}
	
}
