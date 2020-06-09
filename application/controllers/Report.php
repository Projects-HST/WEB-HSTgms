<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends CI_Controller {

	function __construct() {
		 parent::__construct();
			$this->load->helper("url");
			$this->load->library('session');
			$this->load->library('pagination');
			$this->load->model('reportmodel');
			$this->load->model('usermodel');
 }

	public function status()
	{
		$datas=$this->session->userdata();
		$user_id=$this->session->userdata('user_id');
		$user_type=$this->session->userdata('user_type');
		$datas['paguthi'] = $this->usermodel->list_paguthi();
		
		
		 $frmDate=$this->input->post('frmDate');
		 $datas['dfromDate'] = $frmDate;
		 $toDate=$this->input->post('toDate');
		 $datas['dtoDate'] = $toDate;
		 $status=$this->input->post('status');
		 if ($status != ""){
			$datas['dstatus'] = $status;
		 } else {
			  $datas['dstatus'] = "ALL";
		 }
		 $paguthi=$this->input->post('paguthi');
		 if ($paguthi != ""){
			 $datas['dpaguthi'] = $paguthi;
		 } else {
			  $datas['dpaguthi'] = "ALL";
		 }
		$datas['res']=$this->reportmodel->get_status_report($frmDate,$toDate,$status,$paguthi);

		if($user_type=='1'){
			$this->load->view('admin/header');
			$this->load->view('admin/report/status_report',$datas);
			$this->load->view('admin/footer');
		}else{
			redirect('/');
		}

	}
	
	public function category()
	{
		$datas=$this->session->userdata();
		$user_id=$this->session->userdata('user_id');
		$user_type=$this->session->userdata('user_type');
		$datas['category'] = $this->usermodel->list_category();
		
		
		 $frmDate=$this->input->post('frmDate');
		 $datas['dfromDate'] = $frmDate;
		 $toDate=$this->input->post('toDate');
		 $datas['dtoDate'] = $toDate;
		 $category=$this->input->post('category');
		 if ($category != ""){
			 $datas['dcategory'] = $category;
		 } else {
			  $datas['dcategory'] = "ALL";
		 }		
		$datas['res']=$this->reportmodel->get_category_report($frmDate,$toDate,$category);
		
		if($user_type=='1'){
			$this->load->view('admin/header');		
			$this->load->view('admin/report/category_report',$datas);
			$this->load->view('admin/footer');
		}else{
			redirect('/');
		}
	}


	public function sub_category()
	{
		$datas=$this->session->userdata();
		$user_id=$this->session->userdata('user_id');
		$user_type=$this->session->userdata('user_type');
		$datas['subcategory'] = $this->usermodel->list_subcategory();
		
		 $frmDate=$this->input->post('frmDate');
		 $datas['dfromDate'] = $frmDate;
		 $toDate=$this->input->post('toDate');
		 $datas['dtoDate'] = $toDate;
		 $sub_category=$this->input->post('sub_category');
		 if ($sub_category != ""){
			 $datas['dsub_category'] = $sub_category;
		 } else {
			  $datas['dsub_category'] = "ALL";
		 }	
		
		$datas['res']=$this->reportmodel->get_subcategory_report($frmDate,$toDate,$sub_category);
		
		if($user_type=='1'){
			$this->load->view('admin/header');		
			$this->load->view('admin/report/subcategory_report',$datas);
			$this->load->view('admin/footer');
		}else{
			redirect('/');
		}
	}

	
	public function location()
	{
		$datas=$this->session->userdata();
		$user_id=$this->session->userdata('user_id');
		$user_type=$this->session->userdata('user_type');
		$datas['paguthi'] = $this->usermodel->list_paguthi();
		
		$frmDate=$this->input->post('frmDate');
		 $datas['dfromDate'] = $frmDate;
		 $toDate=$this->input->post('toDate');
		 $datas['dtoDate'] = $toDate;
		 $paguthi=$this->input->post('paguthi');
		 if ($paguthi != ""){
			 $datas['dpaguthi'] = $paguthi;
		 } else {
			  $datas['dpaguthi'] = "ALL";
		 }
		
		$datas['res']=$this->reportmodel->get_location_report($frmDate,$toDate,$paguthi);
		
		if($user_type=='1'){
			$this->load->view('admin/header');		
			$this->load->view('admin/report/location_report',$datas);
			$this->load->view('admin/footer');
		}else{
			redirect('/');
		}
	}
	
	public function meetings()
	{
		$datas=$this->session->userdata();
		$user_id=$this->session->userdata('user_id');
		$user_type=$this->session->userdata('user_type');
		$datas['paguthi'] = $this->usermodel->list_paguthi();
		
		$frmDate = "";
		$toDate = "";
		
		$frmDate=$this->input->post('frmDate');
		$getfrmDate=$this->uri->segment(3);
		
		$toDate=$this->input->post('toDate');
		$gettoDate=$this->uri->segment(4);
		
		if ($frmDate!=''){
			$frmDate=$this->input->post('frmDate');
		}else if ($getfrmDate!=''){
			$frmDate=$this->uri->segment(3);
		}
		
		if ($toDate!=''){
			$toDate=$this->input->post('toDate');
		}else if ($gettoDate!=''){
			$toDate=$this->uri->segment(4);
		}
		
		
		$datas['dfromDate'] = $frmDate;
		$datas['dtoDate'] = $toDate;
		
		
		$datas['res']=$this->reportmodel->get_meeting_report($frmDate,$toDate);
		
		if($user_type=='1'){
			$this->load->view('admin/header');		
			$this->load->view('admin/report/meeting_report',$datas);
			$this->load->view('admin/footer');
		}else{
			redirect('/');
		}
	}
	
	public function meeting_update()
	{
		$datas=$this->session->userdata();
		$user_id=$this->session->userdata('user_id');
		$user_type=$this->session->userdata('user_type');
		$datas['paguthi'] = $this->usermodel->list_paguthi();

		$meeting_id=base64_decode($this->uri->segment(3))/98765;
		$frmDate=$this->uri->segment(4);
		$toDate=$this->uri->segment(5);
		
		$datas['res']=$this->reportmodel->meeting_update($meeting_id,$user_id,$frmDate,$toDate);
		
		if($user_type=='1'){
			$this->load->view('admin/header');		
			$this->load->view('admin/report/meeting_report',$datas);
			$this->load->view('admin/footer');
		}else{
			redirect('/');
		}
	}
	
	public function staff()
	{
		$datas=$this->session->userdata();
		$user_id=$this->session->userdata('user_id');
		$user_type=$this->session->userdata('user_type');
		$datas['paguthi'] = $this->usermodel->list_paguthi();
		
		$frmDate=$this->input->post('frmDate');
		$datas['dfromDate'] = $frmDate;
		$toDate=$this->input->post('toDate');
		$datas['dtoDate'] = $toDate;
		
		$datas['res']=$this->reportmodel->get_staff_report($frmDate,$toDate);
		
		if($user_type=='1'){
			$this->load->view('admin/header');		
			$this->load->view('admin/report/staff_report',$datas);
			$this->load->view('admin/footer');
		}else{
			redirect('/');
		}
	}
	
	public function birthday()
	{
		$datas=$this->session->userdata();
		$user_id=$this->session->userdata('user_id');
		$user_type=$this->session->userdata('user_type');
		//$datas['paguthi'] = $this->usermodel->list_paguthi();
		$selMonth = "";
		$selMonth=$this->input->post('month');
		$getMonth=$this->uri->segment(3);
		
		if ($selMonth!=''){
			$selMonth=$this->input->post('month');
		}else if ($getMonth!=''){
			$selMonth=$this->uri->segment(3);
		}else{
			$selMonth = date("m");
		}
		$datas['searchMonth'] = $selMonth;
		$datas['res']=$this->reportmodel->get_birthday_report($selMonth);

		if($user_type=='1'){
			$this->load->view('admin/header');		
			$this->load->view('admin/report/birthday_report',$datas);
			$this->load->view('admin/footer');
		}else{
			redirect('/');
		}
	}
	
	public function birthday_update()
	{
		$datas=$this->session->userdata();
		$user_id=$this->session->userdata('user_id');
		$user_type=$this->session->userdata('user_type');
		$searchMonth=$this->uri->segment(3);
		$constituent_id=base64_decode($this->uri->segment(4))/98765;

		$datas['res']=$this->reportmodel->birthday_update($constituent_id,$user_id,$searchMonth);
	}
	
	public function list_records($rowno=0){

		// Row per page
		$rowperpage = 50000;

		// Row position
		if($rowno != 0){
			$rowno = ($rowno-1) * $rowperpage;
		}
      	
      	// All records count
      	$allcount = $this->reportmodel->getrecordCount();

      	// Get  records
      	$users_record = $this->reportmodel->getData($rowno,$rowperpage);
      	
      	// Pagination Configuration
      	$config['base_url'] = base_url().'report/list_records';
      	$config['use_page_numbers'] = TRUE;
		$config['total_rows'] = $allcount;
		$config['per_page'] = $rowperpage;
		//Pagination Container tag
		$config['full_tag_open'] = '<div style="margin:50px 30%;">';
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
		$data['row'] = $rowno;

		$this->load->view('admin/header');		
		$this->load->view('admin/report/list_records',$data);
		$this->load->view('admin/footer');
	}

}
