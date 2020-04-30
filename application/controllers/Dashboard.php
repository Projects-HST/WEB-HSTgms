<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
	function __construct() {
		 parent::__construct();
			$this->load->helper("url");
			$this->load->library('session');
			$this->load->model('usermodel');
			$this->load->model('dashboardmodel');
			$this->load->model('mastermodel');
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

		$datas['search_paguthi'] = $paguthi_value;
		$datas['result']=$this->dashboardmodel->get_dashboard_reult($paguthi_value);
		$datas['interaction']=$this->dashboardmodel->get_interaction($paguthi_value);
		
		$datas['footfall_result']=$this->dashboardmodel->get_footfall_graph($paguthi_value);
		$datas['grievance_result']=$this->dashboardmodel->get_grievance_graph($paguthi_value);
		$datas['meeting_result']=$this->dashboardmodel->get_meeeting_graph($paguthi_value);

		//print_r($datas['footfall_result']); 

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
		
		$user_id = $this->session->userdata('user_id');
		$user_type = $this->session->userdata('user_type');
		if($user_type=='1' || $user_type=='2'){
			$keyword = "";
			$data['res_paguthi']=$this->mastermodel->get_active_paguthi();
			$data['res_constituency']=$this->mastermodel->get_active_constituency();
			$data['res_seeker']=$this->mastermodel->get_active_seeker();
			
			$keyword=$this->input->post('keyword');
			$datas['keyword']=$keyword;
			
			$datas['res']=$this->dashboardmodel->get_search_reult($keyword);
			$datas['res']=$this->dashboardmodel->get_search_reult($keyword);
			
			$this->load->view('admin/header');
			$this->load->view('admin/dashboard/search_result',$datas);
			$this->load->view('admin/footer');
		}else{
			redirect('base_url()');
		}
	}
	
}
