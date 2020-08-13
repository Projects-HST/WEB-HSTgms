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
		$datas['paguthi'] = $this->dashboardmodel->list_paguthi();
		$paguthi_id=$this->input->post('paguthi_id');
		$from_date=$this->input->post('from_date');
		$to_date=$this->input->post('to_date');
		$datas['from_date']=$from_date;
		$datas['to_date']=$to_date;
		$datas['paguthi_id']=$paguthi_id;
		$datas['result_cons']=$this->dashboardmodel->get_dashboard_result($paguthi_id,$from_date,$to_date);
		$datas['grievance_report']=$this->dashboardmodel->get_grievance_report($paguthi_id,$from_date,$to_date);
		$datas['footfall_result']=$this->dashboardmodel->get_footfall_graph($paguthi_id,$from_date,$to_date);
		if($user_type=='1' || $user_type=='2'){
			$this->load->view('admin/header');
			$this->load->view('admin/dashboard/dashboard',$datas);
			$this->load->view('admin/footer');
		}else {
			redirect('/');
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
			// $datas['res']=$this->dashboardmodel->get_search_reult($keyword);

			$this->load->view('admin/header');
			$this->load->view('admin/dashboard/search_result',$datas);
			$this->load->view('admin/footer');
		}else{
			redirect('base_url()');
		}
	}

}
