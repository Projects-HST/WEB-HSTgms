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


		 $frmDate=$this->input->post('frmDate');
		 $data['dfromDate'] = $frmDate;
		 $toDate=$this->input->post('toDate');
		 $data['dtoDate'] = $toDate;
		 $status=$this->input->post('status');
		 if ($status != ""){
			$data['dstatus'] = $status;
		 } else {
			  $data['dstatus'] = "ALL";
		 }
		 $paguthi=$this->input->post('paguthi');
		 $ward_id=$this->input->post('ward_id');
		 if ($paguthi != ""){
			 $data['dpaguthi'] = $paguthi;
		 } else {
			  $data['dpaguthi'] = "ALL";
		 }
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
		$data['paguthi'] = $this->usermodel->list_paguthi();

			$frmDate=$this->input->post('frmDate');
			$data['dfromDate'] = $frmDate;
			$toDate=$this->input->post('toDate');
			$data['dtoDate'] = $toDate;
			$category=$this->input->post('category');
			if ($category != ""){
			 $data['dcategory'] = $category;
			} else {
			  $data['dcategory'] = "ALL";
			}
			$sub_category_id=$this->input->post('sub_category_id');
			$paguthi=$this->input->post('paguthi');
			$ward_id=$this->input->post('ward_id');

			$rowperpage = 25;
			if($rowno != 0){
			$rowno = ($rowno-1) * $rowperpage;
			}

			// All records count
			$allcount = $this->reportmodel->get_category_count($frmDate,$toDate,$category,$sub_category_id,$paguthi,$ward_id);

			// Get  records
			$users_record = $this->reportmodel->get_category_report($rowno,$rowperpage,$frmDate,$toDate,$category,$sub_category_id,$paguthi,$ward_id);

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
		$frmDate=$this->input->post('frmDate');
		$data['dfromDate'] = $frmDate;
		$toDate=$this->input->post('toDate');
		$data['dtoDate'] = $toDate;
		$paguthi=$this->input->post('paguthi');
		$data['dpaguthi'] = $paguthi;
		$ward_id=$this->input->post('ward_id');

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
		$datas['paguthi'] = $this->usermodel->list_paguthi();

				$frmDate=$this->input->post('frmDate');
				$toDate=$this->input->post('toDate');
				$data['dfromDate'] = $frmDate;
				$data['dtoDate'] = $toDate;
				$status=$this->input->post('status');
				$data['dstatus'] = $status;
				$paguthi=$this->input->post('paguthi');
			 	$ward_id=$this->input->post('ward_id');
		// $datas['res']=$this->reportmodel->get_meeting_report($frmDate,$toDate,$status,$paguthi,$ward_id);
				$rowperpage = 10;

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

		$frmDate=$this->input->post('frmDate');
		$datas['dfromDate'] = $frmDate;
		$toDate=$this->input->post('toDate');
		$datas['dtoDate'] = $toDate;

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
		$data['res_year']=$this->reportmodel->get_birthday_wish_year();
		$month_id=$this->input->post('month');
		$year_id=$this->input->post('year_id');


		$data['searchMonth'] = $month_id;
		// $data['res']=$this->reportmodel->get_birthday_report($selMonth);
		$paguthi=$this->input->post('paguthi');
		$ward_id=$this->input->post('ward_id');
		$rowperpage = 10;

		// Row position
		if($rowno != 0){
		$rowno = ($rowno-1) * $rowperpage;
		}

		// All records count
		$allcount = $this->reportmodel->get_birthday_count($year_id,$month_id,$paguthi,$ward_id);

		// Get  records
		$users_record = $this->reportmodel->get_birthday_report($rowno,$rowperpage,$year_id,$month_id,$paguthi,$ward_id);

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
		$data['year_id']=$year_id;

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
			$data['res_year'] = $this->reportmodel->get_festival_year();
			$year_id = $this->input->post('year_id');
			$paguthi = $this->input->post('paguthi');
			$religion_id = $this->input->post('religion_id');
			$ward_id = $this->input->post('ward_id');
			$data['festival_id']=$religion_id;
			$data['year_id']=$year_id;
			// Row per page
			$rowperpage = 25;

			// Row position
			if($rowno != 0){
				$rowno = ($rowno-1) * $rowperpage;
			}

			// All records count
			$allcount = $this->reportmodel->get_festival_count($year_id,$religion_id,$paguthi,$ward_id);

			// Get records
			$users_record = $this->reportmodel->fetch_festival_wishes_report($rowno,$rowperpage,$year_id,$paguthi,$ward_id,$religion_id);

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
				$paguthi = $this->input->post('paguthi');
				$ward_id = $this->input->post('ward_id');

				$whatsapp_no = $this->input->post('whatsapp_no');
				$mobile_no = $this->input->post('mobile_no');
				$email_id = $this->input->post('email_id');
				$data['whatsapp_no']=$whatsapp_no;
				$data['set_paguthi']=$paguthi;
				$data['mobile_no']=$mobile_no;
				$data['email_id']=$email_id;

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
			$data['search'] = $search_text;
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
			$paguthi = $this->input->post('paguthi');
			$ward_id = $this->input->post('ward_id');

			// Row per page
			$rowperpage = 25;

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


}
