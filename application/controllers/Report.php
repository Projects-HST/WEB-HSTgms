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
			$this->load->model('mastermodel');
			$this->load->model('smsmodel');
 }

	public function status($rowno=0)
	{
		$datas=$this->session->userdata();
		$user_id=$this->session->userdata('user_id');
		$user_type=$this->session->userdata('user_type');
		$data['paguthi'] = $this->usermodel->list_paguthi();
		$data['res_office'] = $this->usermodel->list_office();
		 $frmDate="";
		 $toDate="";
		 $status="";
		 $paguthi="";
		 $ward_id="";
		 if($this->input->post('submit') != NULL ){
			 $frmDate=$this->input->post('s_frmDate');
			 $toDate=$this->input->post('s_toDate');
			 $status=$this->input->post('s_status');
			 $paguthi=$this->input->post('s_paguthi');
			 $ward_id=$this->input->post('s_ward_id');
			 $status_session_array=$this->session->set_userdata(array(
				 "s_frmDate"=>$frmDate,
				 "s_toDate"=>$toDate,
				 "s_status"=>$status,
				 "s_paguthi"=>$paguthi,
				 "s_ward_id"=>$ward_id
			 ));
		 }else{
			 if($this->session->userdata('s_frmDate') != NULL){
			 $frmDate = $this->session->userdata('s_frmDate');
			 }
			 if($this->session->userdata('s_toDate') != NULL){
			$toDate = $this->session->userdata('s_toDate');
			}
			if($this->session->userdata('s_status') != NULL){
		 		$status = $this->session->userdata('s_status');
		 	}
			if($this->session->userdata('s_paguthi') != NULL){
		 		$paguthi = $this->session->userdata('s_paguthi');
		 	}
			if($this->session->userdata('s_ward_id') != NULL){
		 		$ward_id = $this->session->userdata('s_ward_id');
		 	}
		 }
		 $data['dfromDate'] = $frmDate;
		 $data['dtoDate'] = $toDate;
		 $data['status'] = $status;
		 $data['dpaguthi'] = $paguthi;
		 $data['s_ward_id'] = $ward_id;

		$rowperpage = 25;

		// Row position
		if($rowno != 0){
			$rowno = ($rowno-1) * $rowperpage;
		}

		// All records count
		$allcount = $this->reportmodel->get_count_status_report($frmDate,$toDate,$status,$paguthi,$ward_id);

		// Get records
		$users_record = $this->reportmodel->get_status_report($rowno,$rowperpage,$frmDate,$toDate,$status,$paguthi,$ward_id);

		// Pagination Configuration
		$config['base_url'] = base_url().'report/status';
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

	 if($user_type=='1' || $user_type=='2'){
			$this->load->view('admin/header');
			$this->load->view('admin/report/status_report',$data);
			$this->load->view('admin/footer');
		}else{
			redirect('/');
		}

	}




	public function category($rowno=0)
	{
		$datas=$this->session->userdata();
		$user_id=$this->session->userdata('user_id');
		$user_type=$this->session->userdata('user_type');
		$data['category'] = $this->usermodel->list_category();
		$data['seeker'] = $this->usermodel->list_seeker();
		$data['paguthi'] = $this->usermodel->list_paguthi();
		$data['res_office'] = $this->usermodel->list_office();
		$frmDate="";
		$toDate="";
		$category="";
		$sub_category_id="";
		$paguthi="";
		$ward_id="";
		$g_seeker="";
			if($this->input->post('submit') != NULL ){
 			 $frmDate=$this->input->post('g_frmDate');
 			 $toDate=$this->input->post('g_toDate');
 			 $category=$this->input->post('g_category');
			 $g_seeker=$this->input->post('g_seeker');
			 $sub_category_id=$this->input->post('g_sub_category_id');
 			 $paguthi=$this->input->post('g_paguthi');
 			 $ward_id=$this->input->post('g_ward_id');
 			 $status_session_array=$this->session->set_userdata(array(
 				 "g_frmDate"=>$frmDate,
 				 "g_toDate"=>$toDate,
 				 "g_category"=>$category,
				 "g_seeker"=>$g_seeker,
				 "g_sub_category_id"=>$sub_category_id,
 				 "g_paguthi"=>$paguthi,
 				 "g_ward_id"=>$ward_id
 			 ));
 		 }else{
 			 if($this->session->userdata('g_frmDate') != NULL){
 			 		$frmDate = $this->session->userdata('g_frmDate');
 			 }
 			 if($this->session->userdata('g_toDate') != NULL){
 				$toDate = $this->session->userdata('g_toDate');
 			}
 			if($this->session->userdata('g_category') != NULL){
 		 		$category = $this->session->userdata('g_category');
 		 	}
			if($this->session->userdata('g_seeker') != NULL){
				$g_seeker = $this->session->userdata('g_seeker');
			}
			if($this->session->userdata('g_sub_category_id') != NULL){
				$sub_category_id = $this->session->userdata('g_sub_category_id');
			}
 			if($this->session->userdata('g_paguthi') != NULL){
 		 		$paguthi = $this->session->userdata('g_paguthi');
 		 	}
 			if($this->session->userdata('g_ward_id') != NULL){
 		 		$ward_id = $this->session->userdata('g_ward_id');
 		 	}
 		 }
		 $data['g_paguthi']=$paguthi;
		 $data['g_ward_id']=$ward_id;
		 $data['g_category']=$category;
		 $data['g_seeker']=$g_seeker;
		 $data['g_frmDate']=$frmDate;
		 $data['g_toDate']=$toDate;

			$rowperpage = 25;
			if($rowno != 0){
			$rowno = ($rowno-1) * $rowperpage;
			}

			// All records count
			$allcount = $this->reportmodel->get_category_count($frmDate,$toDate,$g_seeker,$category,$sub_category_id,$paguthi,$ward_id);

			// Get  records
			$users_record = $this->reportmodel->get_category_report($rowno,$rowperpage,$frmDate,$toDate,$g_seeker,$category,$sub_category_id,$paguthi,$ward_id);

			// Pagination Configuration
			$config['base_url'] = base_url().'report/category';
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
			$data['row'] = $rowno;
			$data['allcount'] = $allcount;


		if($user_type=='1' || $user_type=='2'){
			$this->load->view('admin/header');
			$this->load->view('admin/report/category_report',$data);
			$this->load->view('admin/footer');
		}else{
			redirect('/');
		}
	}



	public function location($rowno=0)
	{
		$datas=$this->session->userdata();
		$user_id=$this->session->userdata('user_id');
		$user_type=$this->session->userdata('user_type');
		$data['paguthi'] = $this->usermodel->list_paguthi();
		$frmDate="";
		$toDate="";
		$paguthi="";
		$ward_id="";
		if($this->input->post('submit') != NULL ){
			$frmDate=$this->input->post('l_frmDate');
  		$toDate=$this->input->post('l_toDate');
  		$paguthi=$this->input->post('l_paguthi');
  		$ward_id=$this->input->post('l_ward_id');
		 $status_session_array=$this->session->set_userdata(array(
			 "l_frmDate"=>$frmDate,
			 "l_toDate"=>$toDate,
			 "l_paguthi"=>$paguthi,
			 "l_ward_id"=>$ward_id
		 ));
	 }else{
		 if($this->session->userdata('l_frmDate') != NULL){
				$frmDate = $this->session->userdata('l_frmDate');
		 }
		 if($this->session->userdata('l_toDate') != NULL){
			$toDate = $this->session->userdata('l_toDate');
		}
		if($this->session->userdata('l_paguthi') != NULL){
			$paguthi = $this->session->userdata('l_paguthi');
		}
		if($this->session->userdata('l_ward_id') != NULL){
			$ward_id = $this->session->userdata('l_ward_id');
		}
	 }
	 $data['l_frmDate']=$frmDate;
	 $data['l_toDate']=$toDate;
	 $data['l_paguthi']=$paguthi;
	 $data['l_ward_id']=$ward_id;

		$rowperpage = 25;
		if($rowno != 0){
		$rowno = ($rowno-1) * $rowperpage;
		}

		// All records count
		$allcount = $this->reportmodel->get_location_count($frmDate,$toDate,$paguthi,$ward_id);

		// Get  records
		$users_record = $this->reportmodel->get_location_report($rowno,$rowperpage,$frmDate,$toDate,$paguthi,$ward_id);

		// Pagination Configuration
		$config['base_url'] = base_url().'report/location';
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
		$data['row'] = $rowno;
		$data['allcount'] = $allcount;


		if($user_type=='1' || $user_type=='2'){
			$this->load->view('admin/header');
			$this->load->view('admin/report/location_report',$data);
			$this->load->view('admin/footer');
		}else{
			redirect('/');
		}
	}

	public function meetings($rowno=0)
	{
		$datas=$this->session->userdata();
		$user_id=$this->session->userdata('user_id');
		$user_type=$this->session->userdata('user_type');
		$data['paguthi'] = $this->usermodel->list_paguthi();
		$data['res_office'] = $this->usermodel->list_office();
		$frmDate="";
		$toDate="";
		$status="";
		$paguthi="";
		$ward_id="";
		if($this->input->post('submit') != NULL ){
			$frmDate=$this->input->post('m_frmDate');
			$toDate=$this->input->post('m_toDate');
			$status=$this->input->post('m_status');
			$paguthi=$this->input->post('m_paguthi');
			$ward_id=$this->input->post('m_ward_id');
		 $status_session_array=$this->session->set_userdata(array(
			 "m_frmDate"=>$frmDate,
			 "m_toDate"=>$toDate,
			 "m_paguthi"=>$paguthi,
			 "m_ward_id"=>$ward_id,
			 "m_status"=>$status
		 ));
	 }else{
		 if($this->session->userdata('m_frmDate') != NULL){
				$frmDate = $this->session->userdata('m_frmDate');
		 }
		 if($this->session->userdata('m_toDate') != NULL){
			$toDate = $this->session->userdata('m_toDate');
		}
		if($this->session->userdata('m_paguthi') != NULL){
			$paguthi = $this->session->userdata('m_paguthi');
		}
		if($this->session->userdata('m_ward_id') != NULL){
			$ward_id = $this->session->userdata('m_ward_id');
		}
		if($this->session->userdata('m_status') != NULL){
			$status = $this->session->userdata('m_status');
		}
	 }
	 $data['m_frmDate']=$frmDate;
	 $data['m_toDate']=$toDate;
	 $data['m_paguthi']=$paguthi;
	 $data['m_ward_id']=$ward_id;
	 $data['m_status']=$status;

				$rowperpage = 20;

				// Row position
				if($rowno != 0){
				$rowno = ($rowno-1) * $rowperpage;
				}

				// All records count
				$allcount = $this->reportmodel->get_meeting_count($frmDate,$toDate,$status,$paguthi,$ward_id);

				// Get  records
				$users_record = $this->reportmodel->get_meeting_report($rowno,$rowperpage,$frmDate,$toDate,$status,$paguthi,$ward_id);

				// Pagination Configuration
				$config['base_url'] = base_url().'report/meetings';
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
				$data['row'] = $rowno;
				$data['allcount'] = $allcount;

				if($user_type=='1' || $user_type=='2'){
					$this->load->view('admin/header');
					$this->load->view('admin/report/meeting_report',$data);
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

		if($user_type=='1' || $user_type=='2'){
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
		$frmDate="";
		$toDate="";
		if($this->input->post('submit') != NULL ){
			$frmDate=$this->input->post('st_frmDate');
			$toDate=$this->input->post('st_toDate');
		 $status_session_array=$this->session->set_userdata(array(
			 "st_frmDate"=>$frmDate,
			 "st_toDate"=>$toDate
		 ));
	 }else{
		 if($this->session->userdata('st_frmDate') != NULL){
				$frmDate = $this->session->userdata('st_frmDate');
		 }
		 if($this->session->userdata('st_toDate') != NULL){
			$toDate = $this->session->userdata('st_toDate');
		}

	 }
		$datas['st_frmDate'] = $frmDate;
		$datas['st_toDate'] = $toDate;
		$datas['res']=$this->reportmodel->get_staff_report($frmDate,$toDate);
		if($user_type=='1' || $user_type=='2'){
			$this->load->view('admin/header');
			$this->load->view('admin/report/staff_report',$datas);
			$this->load->view('admin/footer');
		}else{
			redirect('/');
		}
	}

	public function birthday($rowno=0)
	{
		$datas=$this->session->userdata();
		$user_id=$this->session->userdata('user_id');
		$user_type=$this->session->userdata('user_type');
		$data['paguthi'] = $this->usermodel->list_paguthi();
		$data['res_office'] = $this->usermodel->list_office();
		$data['res_year']=$this->reportmodel->get_birthday_wish_year();
		$month_id="";
		$year_id="";
			$bf_year_id="";
		$paguthi="";
		$ward_id="";
		if($this->input->post('submit') != NULL ){
			$month_id=$this->input->post('b_month');
			$bf_year_id=$this->input->post('bf_year_id');
			$year_id=$this->input->post('b_year_id');
			$paguthi=$this->input->post('b_paguthi');
			$ward_id=$this->input->post('b_ward_id');
		 $status_session_array=$this->session->set_userdata(array(
			 "b_month"=>$month_id,
			 "bf_year_id"=>$bf_year_id,
			 "b_year_id"=>$year_id,
			 "m_paguthi"=>$paguthi,
			 "m_ward_id"=>$ward_id
		 ));
	 }else{
		 if($this->session->userdata('b_month') != NULL){
				$month_id = $this->session->userdata('b_month');
		 }
		 if($this->session->userdata('b_year_id') != NULL){
			$year_id = $this->session->userdata('b_year_id');
		}
		if($this->session->userdata('bf_year_id') != NULL){
		 $bf_year_id = $this->session->userdata('bf_year_id');
	 }
		if($this->session->userdata('b_paguthi') != NULL){
			$paguthi = $this->session->userdata('b_paguthi');
		}
		if($this->session->userdata('b_ward_id') != NULL){
			$ward_id = $this->session->userdata('b_ward_id');
		}

	 }
	 $data['b_month']=$month_id;
	 $data['b_year_id']=$year_id;
	 $data['bf_year_id']=$bf_year_id;
	 $data['b_paguthi']=$paguthi;
	 $data['b_ward_id']=$ward_id;



		$rowperpage = 20;

		// Row position
		if($rowno != 0){
		$rowno = ($rowno-1) * $rowperpage;
		}

		// All records count
		$allcount = $this->reportmodel->get_birthday_count($year_id,$bf_year_id,$month_id,$paguthi,$ward_id);

		// Get  records
		$users_record = $this->reportmodel->get_birthday_report($rowno,$rowperpage,$year_id,$bf_year_id,$month_id,$paguthi,$ward_id);

		// Pagination Configuration
		$config['base_url'] = base_url().'report/birthday';
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
		$data['row'] = $rowno;
		$data['allcount'] = $allcount;


		if($user_type=='1' || $user_type=='2'){
			$this->load->view('admin/header');
			$this->load->view('admin/report/birthday_report',$data);
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

		$data['res_paguthi']=$this->mastermodel->get_active_paguthi();
		$data['res_constituency']=$this->mastermodel->get_active_constituency();
		$data['res_seeker']=$this->mastermodel->get_active_seeker();

		// Row per page
		$rowperpage = 10;

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
		$data['row'] = $rowno;

		$this->load->view('admin/header');
		$this->load->view('admin/report/list_records',$data);
		$this->load->view('admin/footer');
	}

	public function list_constituent($rowno=0){


	$data['res_paguthi']=$this->mastermodel->get_active_paguthi();
	$data['res_constituency']=$this->mastermodel->get_active_constituency();
	$data['res_seeker']=$this->mastermodel->get_active_seeker();

    // Search text
    $search_text = "";
    if($this->input->post('submit') != NULL ){
      $search_text = $this->input->post('search');
      $this->session->set_userdata(array("search"=>$search_text));
    }else{
      if($this->session->userdata('search') != NULL){
        $search_text = $this->session->userdata('search');
      }
    }

    // Row per page
    $rowperpage = 25;

    // Row position
    if($rowno != 0){
      $rowno = ($rowno-1) * $rowperpage;
    }

    // All records count
    $allcount = $this->reportmodel->getrecordCount($search_text);

    // Get records
    $users_record = $this->reportmodel->getData($rowno,$rowperpage,$search_text);

    // Pagination Configuration
    $config['base_url'] = base_url().'report/list_constituent';
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
    $data['row'] = $rowno;
    $data['search'] = $search_text;

    // Load view
		$this->load->view('admin/header');
		$this->load->view('admin/report/search_list_records',$data);
		$this->load->view('admin/footer');

  }


  public function clear_search()
	{
		$datas=$this->session->userdata();
		$user_id=$this->session->userdata('user_id');
		$user_type=$this->session->userdata('user_type');

		$this->session->unset_userdata('search');
		redirect(base_url()."constituent/list_constituent_member");
	}


	function festival_wishes_report($rowno=0){
		$user_id = $this->session->userdata('user_id');
		$user_type = $this->session->userdata('user_type');
		if($user_type=='1' || $user_type=='2'){
			$data['res_festival']=$this->mastermodel->get_active_festival();
			$data['paguthi'] = $this->mastermodel->get_active_paguthi();
			$data['res_office'] = $this->usermodel->list_office();
			$data['res_year'] = $this->reportmodel->get_festival_year();
			$religion_id="";
			$year_id="";
			$paguthi="";
			$ward_id="";
			$fr_year_id="";
			if($this->input->post('submit') != NULL ){
				$year_id = $this->input->post('f_year_id');
				$fr_year_id = $this->input->post('fr_year_id');
				$paguthi = $this->input->post('f_paguthi');
				$religion_id = $this->input->post('f_religion_id');
				$ward_id = $this->input->post('f_ward_id');
			 $status_session_array=$this->session->set_userdata(array(
				 "f_year_id"=>$year_id,
				 "fr_year_id"=>$fr_year_id,
				 "f_religion_id"=>$religion_id,
				 "f_paguthi"=>$paguthi,
				 "f_ward_id"=>$ward_id
			 ));
		 }else{
			 if($this->session->userdata('f_year_id') != NULL){
					$year_id = $this->session->userdata('f_year_id');
			 }
			 if($this->session->userdata('fr_year_id') != NULL){
				 $fr_year_id = $this->session->userdata('fr_year_id');
			}
			 if($this->session->userdata('f_religion_id') != NULL){
				$religion_id = $this->session->userdata('f_religion_id');
			}
			if($this->session->userdata('f_paguthi') != NULL){
				$paguthi = $this->session->userdata('f_paguthi');
			}
			if($this->session->userdata('f_ward_id') != NULL){
				$ward_id = $this->session->userdata('f_ward_id');
			}

		 }

		 $data['f_year_id']=$year_id;
		 $data['fr_year_id']=$fr_year_id;
		 $data['f_religion_id']=$religion_id;
		 $data['f_paguthi']=$paguthi;
		 $data['f_ward_id']=$ward_id;
			// Row per page
			$rowperpage = 20;

			// Row position
			if($rowno != 0){
				$rowno = ($rowno-1) * $rowperpage;
			}

			// All records count
			$allcount = $this->reportmodel->get_festival_count($year_id,$fr_year_id,$religion_id,$paguthi,$ward_id);

			// Get records
			$users_record = $this->reportmodel->fetch_festival_wishes_report($rowno,$rowperpage,$year_id,$fr_year_id,$paguthi,$ward_id,$religion_id);

				// Pagination Configuration
				$config['base_url'] = base_url().'report/festival_wishes_report';
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
			$data['row'] = $rowno;
			$data['allcount'] = $allcount;
		// Load view
			$this->load->view('admin/header');
			$this->load->view('admin/report/festival_wishes_report',$data);
			$this->load->view('admin/footer');

			}else{
				redirect('/');
			}
	}


	function constituent_list($rowno=0){
		$user_id = $this->session->userdata('user_id');
		$user_type = $this->session->userdata('user_type');
		if($user_type=='1' || $user_type=='2'){
			$data['paguthi'] = $this->mastermodel->get_active_paguthi();
			$data['res_office'] = $this->usermodel->list_office();
				$paguthi="";
				$ward_id="";
				$whatsapp_no="";
				$mobile_no="";
				$email_id="";
				if($this->input->post('submit') != NULL ){
					$paguthi = $this->input->post('c_paguthi');
					$ward_id = $this->input->post('c_ward_id');
					$whatsapp_no = $this->input->post('c_whatsapp_no');
					$mobile_no = $this->input->post('c_mobile_no');
					$email_id = $this->input->post('c_email_id');
				 $status_session_array=$this->session->set_userdata(array(
					 "c_whatsapp_no"=>$whatsapp_no,
					 "c_mobile_no"=>$mobile_no,
					 "c_email_id"=>$email_id,
					 "c_paguthi"=>$paguthi,
					 "c_ward_id"=>$ward_id
				 ));
			 }else{
				 if($this->session->userdata('c_email_id') != NULL){
						$email_id = $this->session->userdata('c_email_id');
				 }
				 if($this->session->userdata('c_mobile_no') != NULL){
						$mobile_no = $this->session->userdata('c_mobile_no');
				 }
				 if($this->session->userdata('c_whatsapp_no') != NULL){
					$whatsapp_no = $this->session->userdata('c_whatsapp_no');
				}
				if($this->session->userdata('c_paguthi') != NULL){
					$paguthi = $this->session->userdata('c_paguthi');
				}
				if($this->session->userdata('c_ward_id') != NULL){
					$ward_id = $this->session->userdata('c_ward_id');
				}

			 }
			 $data['c_email_id']=$email_id;
			 $data['c_mobile_no']=$mobile_no;
			 $data['c_whatsapp_no']=$whatsapp_no;
			 $data['c_paguthi']=$paguthi;
			 $data['c_ward_id']=$ward_id;

			// Row per page
			$rowperpage = 25;

			// Row position
			if($rowno != 0){
				$rowno = ($rowno-1) * $rowperpage;
			}

			// All records count
			$allcount = $this->reportmodel->get_constituent_count($paguthi,$ward_id,$whatsapp_no,$mobile_no,$email_id);

			// Get records
			$users_record = $this->reportmodel->constituent_list($rowno,$rowperpage,$paguthi,$ward_id,$whatsapp_no,$mobile_no,$email_id);

				// Pagination Configuration
				$config['base_url'] = base_url().'report/constituent_list';
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
			$data['row'] = $rowno;
			$data['allcount'] = $allcount;
		// Load view
			$this->load->view('admin/header');
			$this->load->view('admin/report/constituent_list',$data);
			$this->load->view('admin/footer');

			}else{
				redirect('/');
			}
	}



	function video($rowno=0){
		$user_id = $this->session->userdata('user_id');
		$user_type = $this->session->userdata('user_type');
		if($user_type=='1' || $user_type=='2'){
			$data['paguthi'] = $this->mastermodel->get_active_paguthi();
			$data['res_office'] = $this->usermodel->list_office();
			$paguthi="";
			$ward_id="";
			if($this->input->post('submit') != NULL ){
				$paguthi = $this->input->post('v_paguthi');
				$ward_id = $this->input->post('v_ward_id');
			 $status_session_array=$this->session->set_userdata(array(
				 "v_paguthi"=>$paguthi,
				 "v_ward_id"=>$ward_id
			 ));
		 }else{

			if($this->session->userdata('v_paguthi') != NULL){
				$paguthi = $this->session->userdata('v_paguthi');
			}
			if($this->session->userdata('v_ward_id') != NULL){
				$ward_id = $this->session->userdata('v_ward_id');
			}

		 }

		 $data['v_paguthi']=$paguthi;
		 $data['v_ward_id']=$ward_id;

			// Row per page
			$rowperpage = 20;

			// Row position
			if($rowno != 0){
				$rowno = ($rowno-1) * $rowperpage;
			}

			// All records count
			$allcount = $this->reportmodel->get_video_count($paguthi,$ward_id);

			// Get records
			$users_record = $this->reportmodel->get_video_report($rowno,$rowperpage,$paguthi,$ward_id);

				// Pagination Configuration
				$config['base_url'] = base_url().'report/video';
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
			$data['row'] = $rowno;
			$data['allcount'] = $allcount;
			$data['paguthi_id']=$paguthi;

		// Load view
			$this->load->view('admin/header');
			$this->load->view('admin/report/video_report',$data);
			$this->load->view('admin/footer');

			}else{
				redirect('/');
			}
	}

	public function get_status_report_export()
		{
			 $file_name = 'Report'.date('Ymd').'.csv';
			 header("Content-Description: File Transfer");
			 header("Content-Disposition: attachment; filename=$file_name");
			 header("Content-Type: application/csv;");

			 if(empty($frmDate)){
				 $frmDate = $this->session->userdata('s_frmDate');
			 }else{
				 $frmDate="";
			 }
			 if(empty($toDate)){
				 $toDate =$this->session->userdata('s_toDate');
			 }else{
				 $toDate="";
			 }
			 if(empty($status)){
				$status = $this->session->userdata('s_status');
			 }else{
				 $status="";
			 }
			 if(empty($paguthi)){
				$paguthi = $this->session->userdata('s_paguthi');
			 }else{
				 $paguthi="";
			 }
			 if(empty($ward_id)){
				 $ward_id = $this->session->userdata('s_ward_id');
			 }else{
				 $ward_id="";
			 }

		$res_data = $this->reportmodel->get_status_report_export($frmDate,$toDate,$status,$paguthi,$ward_id);

		 // file creation
		 $file = fopen('php://output', 'w');

		 $header = array("Name", "FatherName/HusbandName/GuardianName", "DOB", "Gender"," Door No.& Address", "Pincode", "PhoneNo", "WhatsApp No", "Religion", "Constituency", "Paguthi", "OfficeName", "Ward", "Booth", "SeekerType", "GrievanceType", "SubCategory", "Grievence Status", "CreatedDate", "UpdatedDate");
		 fputcsv($file, $header);
		 foreach ($res_data->result_array() as $key => $value)
		 {
			 fputcsv($file, $value);
		 }
		 fclose($file);
		 exit;
		}




		public function get_category_report_export()
		{
		 $file_name = 'Report'.date('Ymd').'.csv';
		 header("Content-Description: File Transfer");
		 header("Content-Disposition: attachment; filename=$file_name");
		 header("Content-Type: application/csv;");

		 if(empty($frmDate)){
			 $frmDate = $this->session->userdata('g_frmDate');
		 }else{
			 $frmDate="";
		 }
		 if(empty($toDate)){
			 $toDate =$this->session->userdata('g_toDate');
		 }else{
			 $toDate="";
		 }
		 if(empty($category)){
			$category = $this->session->userdata('g_category');
		 }else{
			 $category="";
		 }
		 if(empty($g_seeker)){
			$g_seeker = $this->session->userdata('g_seeker');
		 }else{
			 $g_seeker="";
		 }

		 if(empty($sub_category_id)){
			$sub_category_id = $this->session->userdata('g_sub_category_id');
		 }else{
			 $sub_category_id="";
		 }
		 if(empty($paguthi)){
			$paguthi = $this->session->userdata('g_paguthi');
		 }else{
			 $paguthi="";
		 }
		 if(empty($ward_id)){
			 $ward_id = $this->session->userdata('g_ward_id');
		 }else{
			 $ward_id="";
		 }
		 	 $res_data = $this->reportmodel->get_category_report_export($frmDate,$toDate,$g_seeker,$category,$sub_category_id,$paguthi,$ward_id);
			 $file = fopen('php://output', 'w');
			 $header = array( "Name", "Father Name/Husband Name/Guardian Name", "DOB", "Gender", "Door No.& Address", "Pincode", "Phone No", "WhatsApp No", "Religion", "Constituency", "Paguthi", "Office Name", "Ward", "Booth"," Seeker Type",
			 "Grievance Type", "Sub Category", "Grievence Status", "Created Date", "Updated Date");
			 fputcsv($file, $header);
			 foreach ($res_data->result_array() as $key => $value)
			 {
				 fputcsv($file, $value);
			 }
			 fclose($file);
			 exit;
	}

	public function get_meeting_report_export()
	{
	 $file_name = 'Report'.date('Ymd').'.csv';
	 header("Content-Description: File Transfer");
	 header("Content-Disposition: attachment; filename=$file_name");
	 header("Content-Type: application/csv;");

	 if(empty($frmDate)){
		 $frmDate = $this->session->userdata('m_frmDate');
	 }else{
		 $frmDate="";
	 }
	 if(empty($toDate)){
		 $toDate =$this->session->userdata('m_toDate');
	 }else{
		 $toDate="";
	 }
	 if(empty($status)){
		$status = $this->session->userdata('m_status');
	 }else{
		 $status="";
	 }

	 if(empty($paguthi)){
		$paguthi = $this->session->userdata('m_paguthi');
	 }else{
		 $paguthi="";
	 }
	 if(empty($ward_id)){
		 $ward_id = $this->session->userdata('m_ward_id');
	 }else{
		 $ward_id="";
	 }
		 $res_data = $this->reportmodel->get_meeting_report_export($frmDate,$toDate,$status,$paguthi,$ward_id);
		 $file = fopen('php://output', 'w');

			$header = array("Name","FatherName/HusbandName/GuardianName","DOB", "Gender", "Door No.& Address","Pincode", "PhoneNo", "WhatsApp No", "Religion", "Constituency" ,"Paguthi", "OfficeName", "Ward", "Booth", "Details", "Meeting Status","CreatedDate" ,"UpdatedDate");
		 fputcsv($file, $header);
		 foreach ($res_data->result_array() as $key => $value)
		 {
			 fputcsv($file, $value);
		 }
		 fclose($file);
		 exit;
}




public function get_birthday_report_export()
{
 $file_name = 'Report'.date('Ymd').'.csv';
 header("Content-Description: File Transfer");
 header("Content-Disposition: attachment; filename=$file_name");
 header("Content-Type: application/csv;");


	 if(empty($month_id)){
		 $month_id =$this->session->userdata('b_month');
	 }else{
		 $month_id="";
	 }
	 if(empty($year_id)){
		$year_id = $this->session->userdata('b_year_id');
	 }else{
		 $year_id="";
	 }
	 if(empty($bf_year_id)){
		$bf_year_id = $this->session->userdata('bf_year_id');
	 }else{
		 $bf_year_id="";
	 }

	 if(empty($paguthi)){
		$paguthi = $this->session->userdata('b_paguthi');
	 }else{
		 $paguthi="";
	 }
	 if(empty($ward_id)){
		 $ward_id = $this->session->userdata('b_ward_id');
	 }else{
		 $ward_id="";
	 }


	 $res_data = $this->reportmodel->get_birthday_report_export($month_id,$year_id,$bf_year_id,$paguthi,$ward_id);
	 $file = fopen('php://output', 'w');
	 $header = array("Name","FatherName/HusbandName/GuardianName","DOB", "Gender", "Door No.& Address","Pincode", "PhoneNo", "WhatsApp No", "Religion", "Constituency" ,"Paguthi", "OfficeName", "Ward", "Booth","Sent On Month Of" ,"Sent On Year Of", "Letter Sent On");
	 fputcsv($file, $header);
	 foreach ($res_data->result_array() as $key => $value)
	 {
		 fputcsv($file, $value);
	 }
	 fclose($file);
	 exit;
}


public function get_festival_report_export()
{
 $file_name = 'Report'.date('Ymd').'.csv';
 header("Content-Description: File Transfer");
 header("Content-Disposition: attachment; filename=$file_name");
 header("Content-Type: application/csv;");


	 if(empty($religion_id)){
		 $religion_id =$this->session->userdata('f_religion_id');
	 }else{
		 $religion_id="";
	 }
	 if(empty($year_id)){
		$year_id = $this->session->userdata('f_year_id');
	 }else{
		 $year_id="";
	 }

	 if(empty($paguthi)){
		$paguthi = $this->session->userdata('f_paguthi');
	 }else{
		 $paguthi="";
	 }
	 if(empty($ward_id)){
		 $ward_id = $this->session->userdata('f_ward_id');
	 }else{
		 $ward_id="";
	 }
	 if(empty($fr_year_id)){
		$fr_year_id = $this->session->userdata('fr_year_id');
	}else{
		$fr_year_id="";
	}
	 $res_data = $this->reportmodel->get_festival_report_export($religion_id,$year_id,$fr_year_id,$paguthi,$ward_id);
	 $file = fopen('php://output', 'w');
	  $header = array("Name","FatherName/HusbandName/GuardianName","DOB", "Gender", "Door No.& Address","Pincode", "PhoneNo", "WhatsApp No", "Religion", "Constituency" ,"Paguthi", "Office Name", "Ward", "Booth","Festival Name" ,"Sent On Year Of", "Letter Sent On");
	 fputcsv($file, $header);
	 foreach ($res_data->result_array() as $key => $value)
	 {
		 fputcsv($file, $value);
	 }
	 fclose($file);
	 exit;
}



public function get_constituent_report_export()
{
 	 if(empty($email_id)){
		 $email_id =$this->session->userdata('c_email_id');
	 }else{
		 $email_id="";
	 }
	 if(empty($mobile_no)){
		$mobile_no = $this->session->userdata('c_mobile_no');
	 }else{
		 $mobile_no="";
	 }

	 if(empty($whatsapp_no)){
		$whatsapp_no = $this->session->userdata('c_whatsapp_no');
	 }else{
		 $whatsapp_no="";
	 }

	 if(empty($paguthi)){
		$paguthi = $this->session->userdata('c_paguthi');
	 }else{
		 $paguthi="";
	 }
	 if(empty($ward_id)){
		 $ward_id = $this->session->userdata('c_ward_id');
	 }else{
		 $ward_id="";
	 }

	 $res_data = $this->reportmodel->get_constituent_report_export($email_id,$mobile_no,$whatsapp_no,$paguthi,$ward_id);

	 $file_name = 'Report'.date('Ymd').'.csv';
	 header("Content-Description: File Transfer");
	 header("Content-Disposition: attachment; filename=$file_name");
	 header("Content-Type: application/csv;");

	 $file = fopen('php://output', 'w');
	 $header = array("Name"," Father Name/Husband Name/Guardian Name", "DOB", "Gender", "Door No.& Address", "Pincode", "Phone No", "WhatsApp No", "Mail Id", "Religion", "Constituency", "Paguthi", "Office Name", "Ward", "Booth", "Voter Type",
	 "Voter Id", "Volunteer Type", "Party Member","Aadhaar No","Seeker Type","Grievance Info","Videos Count","WhatsApp Broadcast");
	 fputcsv($file, $header);
	 foreach ($res_data->result_array() as $key => $value)
	 {
		 fputcsv($file, $value);
	 }
	 fclose($file);
	 exit;
}


	public function get_video_report_export(){
			$file_name = 'Report'.date('Ymd').'.csv';
			header("Content-Description: File Transfer");
			header("Content-Disposition: attachment; filename=$file_name");
			header("Content-Type: application/csv;");

			if(empty($paguthi)){
			 $paguthi = $this->session->userdata('v_paguthi');
			}else{
				$paguthi="";
			}
			if(empty($ward_id)){
				$ward_id = $this->session->userdata('v_ward_id');
			}else{
				$ward_id="";
			}

			$res_data = $this->reportmodel->get_video_report_export($paguthi,$ward_id);
			$file = fopen('php://output', 'w');
			$header = array("Name", "Father Name/Husband Name/Guardian Name", "DOB", "Gender", "Door No. & Address", "Pincode", "Phone No", "WhatsApp No", "Mail Id", "Religion", "Constituency", "Paguthi", "Office Name", "Ward", "Booth"," Video Link", "Created Date");
			fputcsv($file, $header);
			foreach ($res_data->result_array() as $key => $value)
			{
				fputcsv($file, $value);
			}
			fclose($file);
			exit;
	}

	public function get_staff_report_export(){
			$file_name = 'Report'.date('Ymd').'.csv';
			header("Content-Description: File Transfer");
			header("Content-Disposition: attachment; filename=$file_name");
			header("Content-Type: application/csv;");

			if(empty($frmDate)){
			 $frmDate = $this->session->userdata('st_frmDate');
			}else{
				$frmDate="";
			}
			if(empty($toDate)){
				$toDate = $this->session->userdata('st_toDate');
			}else{
				$toDate="";
			}

			$res_data = $this->reportmodel->get_staff_report_export($frmDate,$toDate);
			$file = fopen('php://output', 'w');
			$header = array("Staff Name", "Total Constituent Created", "Total Grievance", "Total Grievance Reply Count", "Total Videos", "Total Added Broadcast Count","Total Meeting Created Count", "Total Meeting Reply Count", "Total Birthday Letter Count", "Total Festival Letter Count");
			fputcsv($file, $header);
			foreach ($res_data->result_array() as $key => $value)
			{
				fputcsv($file, $value);
			}
			fclose($file);
			exit;
	}

	public function reset_search(){
		$datas=$this->session->userdata();
		$user_id=$this->session->userdata('user_id');
		$user_type=$this->session->userdata('user_type');
		$array_items = array('st_frmDate','st_toDate','g_seeker','bf_year_id','fr_year_id','b_month','s_toDate', 's_frmDate','s_paguthi','s_ward_id','s_status','g_frmDate','g_toDate','g_category','g_sub_category_id','g_paguthi','g_ward_id','m_frmDate','m_toDate','m_status','m_paguthi','m_ward_id','b_year_id','b_month','b_paguthi','b_ward_id','f_religion_id','f_year_id',
		'f_paguthi','f_ward_id','c_paguthi','c_ward_id','c_whatsapp_no','c_mobile_no','c_email_id','v_paguthi','v_ward_id','l_paguthi','l_ward_id','l_frmDate','l_toDate','mr_frmDate','mr_toDate','mr_search','a_search','e_search','p_search','cf_religion_id','cf_paguthi','cf_ward_id');
		$this->session->unset_userdata($array_items);
		redirect($_SERVER['HTTP_REFERER']);
	}




}
