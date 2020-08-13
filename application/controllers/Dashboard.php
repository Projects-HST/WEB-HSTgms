<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
	function __construct() {
		 parent::__construct();
			$this->load->helper("url");
			$this->load->library('session');
			$this->load->model('usermodel');
			$this->load->model('dashboardmodel');
			$this->load->model('constituentmodel');
			$this->load->model('mastermodel');
			$this->load->library('pagination');
			$this->load->helper('form');
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

	public function searchresult($rowno=0)
	{

		$user_id = $this->session->userdata('user_id');
		$user_type = $this->session->userdata('user_type');
		if($user_type=='1' || $user_type=='2'){
			$search_text=$this->input->post('keyword');
			$data['keyword']=$search_text;
			$rowperpage = 25;

			// Row position
			if($rowno != 0){
				$rowno = ($rowno-1) * $rowperpage;
			}

			// All records count
			$allcount = $this->constituentmodel->getrecordconscount($search_text);

			// Get records
			$users_record = $this->constituentmodel->getConstituent($rowno,$rowperpage,$search_text);

			// Pagination Configuration
			$config['base_url'] = base_url().'dashboard/searchresult';
			$config['use_page_numbers'] = TRUE;
			$config['total_rows'] = $allcount;
			$config['per_page'] = $rowperpage;
			//Pagination Container tag
			$config['full_tag_open'] = '<div style="margin:20px 10px 30px 0px;float:right;">';
			$config['full_tag_close'] = '</div>';
			//First and last Link Text
			$config['first_link'] = 'First';
			$config['last_link'] = 'Last';
			//First tag
			$config['first_tag_open'] = '<span class="pagination-first-tag">';
			$config['first_tag_close'] = '</span>';
			//Last tag
			$config['last_tag_open'] = '<span class="pagination-last-tag">';
			$config['last_tag_close'] = '</span>';
			//Next and Prev Link
			$config['next_link'] = 'Next';
			$config['prev_link'] = 'Prev';
			//Next and Prev Link Styling
			$config['next_tag_open'] = '<span class="pagination-next-tag">';
			$config['next_tag_close'] = '</span>';
			$config['prev_tag_open'] = '<span class="pagination-prev-tag">';
			$config['prev_tag_close'] = '</span>';
			//Current page tag
			$config['cur_tag_open'] = '<strong class="pagination-current-tag">';
			$config['cur_tag_close'] = '</strong>';
			$config['num_tag_open'] = '<span class="pagination-number">';
			$config['num_tag_close'] = '</span>';
			// Initialize
			$this->pagination->initialize($config);
			$data['pagination'] = $this->pagination->create_links();
			$data['result'] = $users_record;
			$data['total_records'] = $allcount;
			$data['row'] = $rowno;
			$data['search'] = $search_text;

			$this->load->view('admin/header');
			$this->load->view('admin/dashboard/search_result',$data);
			$this->load->view('admin/footer');
		}else{
			redirect('base_url()');
		}
	}

}
