<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class constituent extends CI_Controller {


	function __construct() {
		 parent::__construct();
			$this->load->helper("url");
			$this->load->library('session');
			$this->load->model('mastermodel');
			$this->load->model('smsmodel');
			$this->load->model('constituentmodel');
			$this->load->library('pagination');
			$this->load->helper('form');

 }



	#################### constituent ####################

	public function constituent_member()
	{
		$user_id = $this->session->userdata('user_id');
		$user_type = $this->session->userdata('user_type');
		if($user_type=='1' || $user_type=='2'){
			$data['res_constituency']=$this->mastermodel->get_active_constituency();
			$data['res_paguthi']=$this->mastermodel->get_active_paguthi();
			$data['res_interaction']=$this->mastermodel->get_active_interaction_question();
			$data['res_religion']=$this->mastermodel->get_active_religion();
			$this->load->view('admin/header');
			$this->load->view('admin/constituent/constituent_member',$data);
			$this->load->view('admin/footer');
		}else{
			redirect('/');
		}

	}


	public function recent_constituent_member()
	{
		$user_id = $this->session->userdata('user_id');
		$user_type = $this->session->userdata('user_type');
		if($user_type=='1' || $user_type=='2'){
			$data['result']=$this->constituentmodel->get_recent_constituent_member_list();
			$data['res_paguthi']=$this->mastermodel->get_active_paguthi();
			$data['res_constituency']=$this->mastermodel->get_active_constituency();
			$data['res_seeker']=$this->mastermodel->get_active_seeker();
			$this->load->view('admin/header');
			$this->load->view('admin/constituent/recent_member',$data);
			$this->load->view('admin/footer');
		}else{
			redirect('/');
		}
	}


	public function sample_list()
	{
		$user_id = $this->session->userdata('user_id');
		$user_type = $this->session->userdata('user_type');
		if($user_type=='1' || $user_type=='2'){
			$this->load->view('admin/constituent/sample_list');
		}else{
			redirect('/');
		}
	}



	public function list()
	{
		$user_id = $this->session->userdata('user_id');
		$user_type = $this->session->userdata('user_type');
		if($user_type=='1' || $user_type=='2'){

			$this->load->library("pagination_bootstrap");
			$sql=$this->db->get('constituent',10000);
			$this->pagination_bootstrap->offset(10);
			$this->pagination_bootstrap->set_links(array('first' => 'go to first',
                                             'last' => 'go to last',
                                             'next' => 'next',
                                             'prev' => 'prev'));

			$data['result']=$this->pagination_bootstrap->config('/constituent/list',$sql);
			$this->load->view('admin/constituent/list',$data);

		}else{
			redirect('/');
		}
	}
	public function list_constituent_member()
{
			$user_id = $this->session->userdata('user_id');
			$user_type = $this->session->userdata('user_type');
			if($user_type=='1' || $user_type=='2'){
			$config = array();
			$config["base_url"] = base_url() . "constituent/list_constituent_member";
			$config["total_rows"] = $this->constituentmodel->record_count();
			$config["per_page"] = 10;
			$config["uri_segment"] = 3;
			$config['display_pages'] = FALSE;
			$config['prev_link'] = 'Previous';
			$config['next_link'] = 'Next';
			$config['first_link'] = FALSE;
			$config['last_link'] = FALSE;
			$choice = $config["total_rows"] / $config["per_page"];
			$config["num_links"] = round($choice);
			$this->pagination->initialize($config);
			$page = ($this->uri->segment(3))? $this->uri->segment(3) : 0;
			$data["res"] = $this->constituentmodel->fetch_data($config["per_page"], $page);
			$data['res_paguthi']=$this->mastermodel->get_active_paguthi();
			$data['res_constituency']=$this->mastermodel->get_active_constituency();
			$data['res_seeker']=$this->mastermodel->get_active_seeker();
			$data["links"] = $this->pagination->create_links();
			$this->load->view('admin/header');
			$this->load->view("admin/constituent/list_constituent_member", $data);
			$this->load->view('admin/footer');
		}else{
			redirect('/');
		}

		}


		public function search_member(){
			$user_id = $this->session->userdata('user_id');
			$user_type = $this->session->userdata('user_type');
			if($user_type=='1' || $user_type=='2'){
			// get search string
				$search = ($this->input->post("search_name"))? $this->input->post("search_name") : "NIL";
				$search = ($this->uri->segment(3)) ? $this->uri->segment(3) : $search;
				// pagination settings
				$config = array();
				$config["base_url"] = base_url() . "constituent/list_constituent_member";
				$config["total_rows"] = $this->constituentmodel->record_count();
				$config["per_page"] = 10;
				$config["uri_segment"] = 3;
				$config['display_pages'] = FALSE;
				$config['prev_link'] = 'Previous';
				$config['next_link'] = 'Next';
				$config['first_link'] = FALSE;
				$config['last_link'] = FALSE;
				$choice = $config["total_rows"] / $config["per_page"];
				$config["num_links"] = round($choice);
				$this->pagination->initialize($config);
				$page = ($this->uri->segment(3))? $this->uri->segment(3) : 0;
				$data["res"] = $this->constituentmodel->search_member($config["per_page"], $page,$search);
				$data['res_paguthi']=$this->mastermodel->get_active_paguthi();
				$data['res_constituency']=$this->mastermodel->get_active_constituency();
				$data['res_seeker']=$this->mastermodel->get_active_seeker();
				$data["links"] = $this->pagination->create_links();
				$this->load->view('admin/header');
				$this->load->view("admin/constituent/list_constituent_member", $data);
				$this->load->view('admin/footer');
			}else{
				redirect('/');
			}
		}


	public function list_member()
	{
		$user_id = $this->session->userdata('user_id');
		$user_type = $this->session->userdata('user_type');
		if($user_type=='1' || $user_type=='2'){
			// $data['res']=$this->constituentmodel->get_constituent_member_list();
			$data['res_paguthi']=$this->mastermodel->get_active_paguthi();
			$data['res_constituency']=$this->mastermodel->get_active_constituency();
			$data['res_seeker']=$this->mastermodel->get_active_seeker();

			//pagination settings
			 $config['base_url'] = site_url('constituent/list_member');
			 $config['total_rows'] = $this->db->count_all('constituent');
			 $config['per_page'] = "10";
			 $config["uri_segment"] = 10;
			 $choice = $config["total_rows"]/$config["per_page"];
			 $config["num_links"] = floor($choice);

			 // integrate bootstrap pagination
			 $config['full_tag_open'] = '<ul class="pagination">';
			 $config['full_tag_close'] = '</ul>';
			 $config['first_link'] = false;
			 $config['last_link'] = false;
			 $config['first_tag_open'] = '<li class="page-item">';
			 $config['first_tag_close'] = '</li>';
			 $config['prev_link'] = '«';
			 $config['prev_tag_open'] = '<li class="prev">';
			 $config['prev_tag_close'] = '</li>';
			 $config['next_link'] = '»';
			 $config['next_tag_open'] = '<li>';
			 $config['next_tag_close'] = '</li>';
			 $config['last_tag_open'] = '<li>';
			 $config['last_tag_close'] = '</li>';
			 $config['cur_tag_open'] = '<li class="active"><a  href="#">';
			 $config['cur_tag_close'] = '</a></li>';
			 $config['num_tag_open'] = '<li>';
			 $config['num_tag_close'] = '</li>';



			 $this->pagination->initialize($config);
			 $data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
			 $data['booklist'] = $this->constituentmodel->get_books($config["per_page"], $data['page'], NULL);
			 $data['pagination'] = $this->pagination->create_links();
			$this->load->view('admin/header');
			$this->load->view('admin/constituent/list_member',$data);
			$this->load->view('admin/footer');
		}else{
			redirect('/');
		}
	}





	public function create_constituent_member(){
		$user_id = $this->session->userdata('user_id');
		$user_type = $this->session->userdata('user_type');
		if($user_type=='1' || $user_type=='2'){
			$constituency_id=$this->input->post('constituency_id');
			$paguthi_id=$this->input->post('paguthi_id');
			$ward_id=$this->input->post('ward_id');
			$booth_id=$this->input->post('booth_id');
			$full_name=strtoupper($this->db->escape_str($this->input->post('full_name')));
			$father_husband_name=strtoupper($this->db->escape_str($this->input->post('father_husband_name')));
			$guardian_name=strtoupper($this->db->escape_str($this->input->post('guardian_name')));
			$mobile_no=strtoupper($this->db->escape_str($this->input->post('mobile_no')));
			$whatsapp_no=strtoupper($this->db->escape_str($this->input->post('whatsapp_no')));
			$originalDate=strtoupper($this->db->escape_str($this->input->post('dob')));
			 $dob = date("Y-m-d", strtotime($originalDate));
			$door_no=strtoupper($this->db->escape_str($this->input->post('door_no')));
			$address=strtoupper($this->db->escape_str($this->input->post('address')));
			$pin_code=strtoupper($this->db->escape_str($this->input->post('pin_code')));
			$religion_id=strtoupper($this->db->escape_str($this->input->post('religion_id')));
			$email_id=strtoupper($this->db->escape_str($this->input->post('email_id')));
			$gender=strtoupper($this->db->escape_str($this->input->post('gender')));
			$voter_id_status=strtoupper($this->db->escape_str($this->input->post('voter_id_status')));
			$voter_id_no=strtoupper($this->db->escape_str($this->input->post('voter_id_no')));
			$aadhaar_status=strtoupper($this->db->escape_str($this->input->post('aadhaar_status')));
			$aadhaar_no=strtoupper($this->db->escape_str($this->input->post('aadhaar_no')));
			$party_member_status=strtoupper($this->db->escape_str($this->input->post('party_member_status')));
			$vote_type=strtoupper($this->db->escape_str($this->input->post('vote_type')));
			$serial_no=strtoupper($this->db->escape_str($this->input->post('serial_no')));
			$question_id=$this->input->post('question_id');
			$question_response=$this->input->post('question_response');
			$interaction_section=$this->input->post('interaction_section');
			// $status=strtoupper($this->db->escape_str($this->input->post('status')));
			$profilepic = $_FILES['profile_pic']['name'];
				if(empty($profilepic)){
				$filename='';
			}else{
				$temp = pathinfo($profilepic, PATHINFO_EXTENSION);
				$filename = round(microtime(true)) . '.' . $temp;
				$uploaddir = 'assets/constituent/';
				$profilepic = $uploaddir.$filename;
				move_uploaded_file($_FILES['profile_pic']['tmp_name'], $profilepic);
			}
			$data=$this->constituentmodel->create_constituent_member($constituency_id,$paguthi_id,$ward_id,$booth_id,$full_name,$father_husband_name,$guardian_name,$mobile_no,$whatsapp_no,$dob,$door_no,$address,$pin_code,$religion_id,$email_id,$gender,$voter_id_status,$voter_id_no,$aadhaar_status,$aadhaar_no,$party_member_status,$vote_type,$serial_no,$filename,$question_id,$question_response,$interaction_section,$user_id);
			$messge = array('status'=>$data['status'],'message' => $data['msg'],'class' => $data['class']);
			$this->session->set_flashdata('msg', $messge);
			redirect("constituent/list_constituent_member");
		}else{
			redirect('/');
		}
	}

		public function update_constituent_member(){
			$user_id = $this->session->userdata('user_id');
			$user_type = $this->session->userdata('user_type');
			if($user_type=='1' || $user_type=='2'){
				$constituent_id=$this->input->post('constituent_id');
				$constituency_id=$this->input->post('constituency_id');
				$paguthi_id=$this->input->post('paguthi_id');
				$ward_id=$this->input->post('ward_id');
				$booth_id=$this->input->post('booth_id');
				$full_name=strtoupper($this->db->escape_str($this->input->post('full_name')));
				$father_husband_name=strtoupper($this->db->escape_str($this->input->post('father_husband_name')));
				$guardian_name=strtoupper($this->db->escape_str($this->input->post('guardian_name')));
				$mobile_no=strtoupper($this->input->post('mobile_no'));
				$whatsapp_no=strtoupper($this->input->post('whatsapp_no'));
				$originalDate=strtoupper($this->input->post('dob'));
				 $dob = date("Y-m-d", strtotime($originalDate));
				$door_no=strtoupper($this->db->escape_str($this->input->post('door_no')));
				$address=strtoupper($this->db->escape_str($this->input->post('address')));
				$pin_code=strtoupper($this->db->escape_str($this->input->post('pin_code')));
				$religion_id=strtoupper($this->db->escape_str($this->input->post('religion_id')));
				$email_id=strtoupper($this->db->escape_str($this->input->post('email_id')));
				$gender=strtoupper($this->db->escape_str($this->input->post('gender')));
				$voter_id_status=strtoupper($this->db->escape_str($this->input->post('voter_id_status')));
				$voter_id_no=strtoupper($this->db->escape_str($this->input->post('voter_id_no')));
				$aadhaar_status=strtoupper($this->db->escape_str($this->input->post('aadhaar_status')));
				$aadhaar_no=strtoupper($this->db->escape_str($this->input->post('aadhaar_no')));
				$party_member_status=strtoupper($this->db->escape_str($this->input->post('party_member_status')));
				$vote_type=strtoupper($this->db->escape_str($this->input->post('vote_type')));
				$serial_no=strtoupper($this->db->escape_str($this->input->post('serial_no')));
				$question_id=$this->input->post('question_id');
				$question_response=$this->input->post('question_response');
				// $interaction_section=$this->input->post('interaction_section');
					$old_profile_pic=$this->input->post('old_profile_pic');
				$status=strtoupper($this->db->escape_str($this->input->post('status')));
				$profilepic = $_FILES['profile_pic']['name'];
					if(empty($profilepic)){
					$filename=$old_profile_pic;
				}else{
					$temp = pathinfo($profilepic, PATHINFO_EXTENSION);
					$filename = round(microtime(true)) . '.' . $temp;
					$uploaddir = 'assets/constituent/';
					$profilepic = $uploaddir.$filename;
					move_uploaded_file($_FILES['profile_pic']['tmp_name'], $profilepic);
				}
				$data=$this->constituentmodel->update_constituent_member($constituency_id,$paguthi_id,$ward_id,$booth_id,$full_name,$father_husband_name,$guardian_name,$mobile_no,$whatsapp_no,$dob,$door_no,$address,$pin_code,$religion_id,$email_id,$gender,$voter_id_status,$voter_id_no,$aadhaar_status,$aadhaar_no,$party_member_status,$vote_type,$serial_no,$filename,$status,$user_id,$constituent_id);
				$messge = array('status'=>$data['status'],'message' => $data['msg'],'class' => $data['class']);
				$this->session->set_flashdata('msg', $messge);
				redirect("constituent/list_constituent_member");
			}else{
				redirect('/');
			}
		}



	public function get_constituent_member_edit(){
		$user_id = $this->session->userdata('user_id');
		$user_type = $this->session->userdata('user_type');
		if($user_type=='1' || $user_type=='2'){
			$constituent_id=$this->uri->segment(3);
			$data['res']=$this->constituentmodel->get_constituent_member_edit($constituent_id);
			$data['res_constituency']=$this->mastermodel->get_active_constituency();
			$data['res_paguthi']=$this->mastermodel->get_active_paguthi();
			$data['res_interaction']=$this->mastermodel->get_active_interaction_question();
			$data['res_religion']=$this->mastermodel->get_active_religion();
			$this->load->view('admin/header');
			$this->load->view('admin/constituent/update_constituent_member',$data);
			$this->load->view('admin/footer');
		}else{
			redirect('/');
		}
	}



	public function checkserialno(){
		$serial_no=strtoupper($this->db->escape_str($this->input->post('serial_no')));
		$data=$this->constituentmodel->checkserialno($serial_no);
	}
	public function checkvoter_id_no(){
		$voter_id_no=strtoupper($this->db->escape_str($this->input->post('voter_id_no')));
		$data=$this->constituentmodel->checkvoter_id_no($voter_id_no);
	}
	public function checkaadhaar_no(){
		$aadhaar_no=strtoupper($this->db->escape_str($this->input->post('aadhaar_no')));
		$data=$this->constituentmodel->checkaadhaar_no($aadhaar_no);
	}


	public function checkserialnoexist(){
		$constituent_id=$this->uri->segment(3);
		$serial_no=strtoupper($this->db->escape_str($this->input->post('serial_no')));
		$data=$this->constituentmodel->checkserialnoexist($constituent_id,$serial_no);
	}
	public function checkvoter_id_noexist(){
		$constituent_id=$this->uri->segment(3);
		$voter_id_no=strtoupper($this->db->escape_str($this->input->post('voter_id_no')));
		$data=$this->constituentmodel->checkvoter_id_noexist($constituent_id,$voter_id_no);
	}
	public function checkaadhaar_noexist(){
		$constituent_id=$this->uri->segment(3);
		$aadhaar_no=strtoupper($this->db->escape_str($this->input->post('aadhaar_no')));
		$data=$this->constituentmodel->checkaadhaar_noexist($constituent_id,$aadhaar_no);
	}


################## documents upload ############################



		public function get_list_document(){
			$user_id = $this->session->userdata('user_id');
			$user_type = $this->session->userdata('user_type');
			if($user_type=='1' || $user_type=='2'){
				$constituent_id=$this->uri->segment(3);
				// $data['res']=$this->constituentmodel->get_constituent_member_edit($constituent_id);
				$data['res']=$this->constituentmodel->get_list_document($constituent_id);
				$data['res_grievance']=$this->constituentmodel->get_list_grievance_document($constituent_id);
				$this->load->view('admin/header');
				$this->load->view('admin/constituent/constituent_member_documents',$data);
				$this->load->view('admin/footer');
			}else{
				redirect('/');
			}
		}


		public function constituent_document_upload(){
			$user_id = $this->session->userdata('user_id');
			$user_type = $this->session->userdata('user_type');
			if($user_type=='1' || $user_type=='2'){
				$constituent_id=$this->input->post('constituent_id');
				$doc_name=strtoupper($this->db->escape_str($this->input->post('file_name')));
				$profilepic = $_FILES['doc_file']['name'];
				if(empty($profilepic)){
				$filename=$old_profile_pic;
				}else{
					$temp = pathinfo($profilepic, PATHINFO_EXTENSION);
					$filename = round(microtime(true)) . '.' . $temp;
					$uploaddir = 'assets/constituent/doc/';
					$profilepic = $uploaddir.$filename;
					move_uploaded_file($_FILES['doc_file']['tmp_name'], $profilepic);
				}
				$data=$this->constituentmodel->constituent_document_upload($constituent_id,$doc_name,$filename,$user_id);
				$messge = array('status'=>$data['status'],'message' => $data['msg'],'class' => $data['class']);
				$this->session->set_flashdata('msg', $messge);
				redirect("constituent/get_list_document/$constituent_id");
			}else{
				redirect('/');
			}
		}

		public function delete_document(){
			$user_id = $this->session->userdata('user_id');
			$user_type = $this->session->userdata('user_type');
			if($user_type=='1' || $user_type=='2'){
				$d_id=$this->input->post('d_id');
				$data=$this->constituentmodel->delete_document($d_id,$user_id);
			}else{
				redirect('/');
			}
		}

################## documents upload ############################

################## Interaction response ##############

	public function add_interaction_response(){
		$user_id = $this->session->userdata('user_id');
		$user_type = $this->session->userdata('user_type');
		if($user_type=='1' || $user_type=='2'){
			$constituent_id=$this->uri->segment(3);
			$data['res_interaction']=$this->mastermodel->get_active_interaction_question();
			$this->load->view('admin/header');
			$this->load->view('admin/constituent/interaction_response',$data);
			$this->load->view('admin/footer');
		}else{
			redirect('/');
		}
	}


	public function get_interaction_response_edit(){
		$user_id = $this->session->userdata('user_id');
		$user_type = $this->session->userdata('user_type');
		if($user_type=='1' || $user_type=='2'){
			$constituent_id=$this->uri->segment(3);
			$data['res']=$this->mastermodel->get_active_interaction_question();
			$data['res_interaction']=$this->constituentmodel->get_interaction_response_edit($constituent_id);
			$this->load->view('admin/header');
			$this->load->view('admin/constituent/update_interaction_response',$data);
			$this->load->view('admin/footer');
		}else{
			redirect('/');
		}
	}

	public function save_interaction_response(){
		$user_id = $this->session->userdata('user_id');
		$user_type = $this->session->userdata('user_type');
		if($user_type=='1' || $user_type=='2'){
			$constituent_id=$this->input->post('constituent_id');
			$question_id=$this->input->post('question_id');
			$question_response=$this->input->post('question_response');
			$data=$this->constituentmodel->save_interaction_response($constituent_id,$question_id,$question_response,$user_id);
			$messge = array('status'=>$data['status'],'message' => $data['msg'],'class' => $data['class']);
			$this->session->set_flashdata('msg', $messge);
			redirect("constituent/list_constituent_member");
		}else{
			redirect('/');
		}
	}



################## Interaction response ##############


################## Plant donation ##############

	public function plant_save(){
		$user_id = $this->session->userdata('user_id');
		$user_type = $this->session->userdata('user_type');
		if($user_type=='1' || $user_type=='2'){
			$constituent_id=$this->input->post('constituent_id');
			$name_of_plant=strtoupper($this->db->escape_str($this->input->post('name_of_plant')));
			$no_of_plant=$this->input->post('no_of_plant');
			$data=$this->constituentmodel->plant_save($constituent_id,$name_of_plant,$no_of_plant,$user_id);
			$messge = array('status'=>$data['status'],'message' => $data['msg'],'class' => $data['class']);
			$this->session->set_flashdata('msg', $messge);
			redirect("constituent/list_constituent_member");
		}else{
			redirect('/');
		}
	}

	public function get_plant_donation(){
		$user_id = $this->session->userdata('user_id');
		$user_type = $this->session->userdata('user_type');
		if($user_type=='1' || $user_type=='2'){
			$constituent_id=$this->input->post('c_id');
			$data['res']=$this->constituentmodel->get_plant_donation($constituent_id,$user_id);
			echo json_encode($data['res']);
		}else{
			redirect('/');
		}
	}

################## Plant donation ##############

################## Meeting request ##############

	public function view_meeting_request(){
		$user_id = $this->session->userdata('user_id');
		$user_type = $this->session->userdata('user_type');
		if($user_type=='1' || $user_type=='2'){
			$constituent_id=$this->input->post('c_id');
			$data['res']=$this->constituentmodel->view_meeting_request($constituent_id,$user_id);
			echo json_encode($data['res']);
		}else{
			redirect('/');
		}
	}


	public function save_meeting_request(){
		$user_id = $this->session->userdata('user_id');
		$user_type = $this->session->userdata('user_type');
		if($user_type=='1' || $user_type=='2'){
			$constituent_id=$this->input->post('meeting_constituent_id');
			$originalDate=strtoupper($this->db->escape_str($this->input->post('meeting_date')));
			 $meeting_date = date("Y-m-d", strtotime($originalDate));
			$meeting_detail=strtoupper($this->db->escape_str($this->input->post('meeting_detail')));
			$meeting_status=strtoupper($this->db->escape_str($this->input->post('meeting_status')));
			$data=$this->constituentmodel->save_meeting_request($constituent_id,$meeting_detail,$meeting_date,$meeting_status,$user_id);
			$messge = array('status'=>$data['status'],'message' => $data['msg'],'class' => $data['class']);
			$this->session->set_flashdata('msg', $messge);
			redirect("constituent/list_constituent_member");
		}else{
			redirect('/');
		}
	}

	public function update_meeting_request(){
		$user_id = $this->session->userdata('user_id');
		$user_type = $this->session->userdata('user_type');
		if($user_type=='1' || $user_type=='2'){
			$meeting_id=$this->input->post('meeting_id');
			$originalDate=strtoupper($this->db->escape_str($this->input->post('update_meeting_date')));
			 $meeting_date = date("Y-m-d", strtotime($originalDate));
			$meeting_detail=strtoupper($this->db->escape_str($this->input->post('update_meeting_detail')));
			$meeting_status=strtoupper($this->db->escape_str($this->input->post('update_meeting_status')));
			$data=$this->constituentmodel->update_meeting_request($meeting_id,$meeting_detail,$meeting_date,$meeting_status,$user_id);
			$messge = array('status'=>$data['status'],'message' => $data['msg'],'class' => $data['class']);
			$this->session->set_flashdata('msg', $messge);
			redirect("constituent/list_constituent_member");
		}else{
			redirect('/');
		}
	}


	public function edit_meeting_request(){
		$user_id = $this->session->userdata('user_id');
		$user_type = $this->session->userdata('user_type');
		if($user_type=='1' || $user_type=='2'){
			$meeting_id=$this->input->post('m_id');
			$data['res']=$this->constituentmodel->edit_meeting_request($meeting_id,$user_id);
			echo json_encode($data['res']);
		}else{
			redirect('/');
		}
	}
################## Meeting request ##############

################## Grievance module ##############


public function list_grievance(){
	$user_id = $this->session->userdata('user_id');
	$user_type = $this->session->userdata('user_type');
	if($user_type=='1' || $user_type=='2'){
		$data['res']=$this->constituentmodel->get_all_grievance();
		$data['res_petition']=$this->constituentmodel->get_all_grievance_petition();
		$data['res_enquiry']=$this->constituentmodel->get_all_grievance_enquiry();
		$data['res_sms']=$this->mastermodel->get_active_template();
		$this->load->view('admin/header');
		$this->load->view('admin/constituent/list_grievance',$data);
		$this->load->view('admin/footer');
	}else{
		redirect('/');
	}
}


public function list_grievance_reply(){
	$user_id = $this->session->userdata('user_id');
	$user_type = $this->session->userdata('user_type');
	if($user_type=='1' || $user_type=='2'){
		$data['res']=$this->constituentmodel->list_grievance_reply();
		$this->load->view('admin/header');
		$this->load->view('admin/constituent/list_grievance_reply',$data);
		$this->load->view('admin/footer');
	}else{
		redirect('/');
	}
}


	public function get_constituent_grievance_edit(){
		$user_id = $this->session->userdata('user_id');
		$user_type = $this->session->userdata('user_type');
		if($user_type=='1' || $user_type=='2'){
			$grievanve_id=$this->uri->segment(3);
			$data['res_paguthi']=$this->mastermodel->get_active_paguthi();
			$data['res_constituency']=$this->mastermodel->get_active_constituency();
			$data['res_seeker']=$this->mastermodel->get_active_seeker();
			$data['res_grievance']=$this->constituentmodel->get_constituent_grievance_edit($grievanve_id);
			$this->load->view('admin/header');
			$this->load->view('admin/constituent/update_constituent_grievance',$data);
			$this->load->view('admin/footer');
		}else{
			redirect('/');
		}
	}

	public function get_petition_no(){
		$user_id = $this->session->userdata('user_id');
		$user_type = $this->session->userdata('user_type');
		if($user_type=='1' || $user_type=='2'){
			$paguthi_id=$this->input->post('p_id');
			$grievance_type=$this->input->post('gr_type');
			$data['res']=$this->constituentmodel->get_petition_no($paguthi_id,$grievance_type,$user_id);
			echo json_encode($data['res']);
		}else{
			redirect('/');
		}
	}

	public function get_grievance_status(){
		$user_id = $this->session->userdata('user_id');
		$user_type = $this->session->userdata('user_type');
		if($user_type=='1' || $user_type=='2'){
			$grievance_id=$this->input->post('grievance_id');
			$data['res']=$this->constituentmodel->get_grievance_status($grievance_id,$user_id);
			echo json_encode($data['res']);
		}else{
			redirect('/');
		}
	}




	public function get_sms_text(){
		$user_id = $this->session->userdata('user_id');
		$user_type = $this->session->userdata('user_type');
		if($user_type=='1' || $user_type=='2'){
			$sms_id=$this->input->post('sms_id');
			$data['res']=$this->mastermodel->get_sms_text($sms_id,$user_id);
			echo json_encode($data['res']);
		}else{
			redirect('/');
		}
	}




	public function save_grievance_data(){
		$user_id = $this->session->userdata('user_id');
		$user_type = $this->session->userdata('user_type');
		if($user_type=='1' || $user_type=='2'){
			$constituent_id=$this->input->post('constituent_id');
			$constituency_id=$this->input->post('constituency_id');
			$paguthi_id=$this->input->post('paguthi_id');
			$seeker_id=$this->input->post('seeker_id');
			$grievance_id=$this->input->post('grievance_id');
			$sub_category_id=$this->input->post('sub_category_id');
			$grievance_type=$this->input->post('grievance_type');
			$petition_enquiry_no=strtoupper($this->db->escape_str($this->input->post('petition_enquiry_no')));
			$description=strtoupper($this->db->escape_str($this->input->post('description')));
			$doc_name=strtoupper($this->db->escape_str($this->input->post('doc_name')));
			$reference_note=strtoupper($this->db->escape_str($this->input->post('reference_note')));
			$originalDate=strtoupper($this->db->escape_str($this->input->post('grievance_date')));
			 $grievance_date = date("Y-m-d", strtotime($originalDate));
			 $profilepic = $_FILES['doc_file_name']['name'];
			 if(empty($profilepic)){
			 $filename='';
			 }else{
				 $temp = pathinfo($profilepic, PATHINFO_EXTENSION);
				 $filename = round(microtime(true)) . '.' . $temp;
				 $uploaddir = 'assets/constituent/doc/';
				 $profilepic = $uploaddir.$filename;
				 move_uploaded_file($_FILES['doc_file_name']['tmp_name'], $profilepic);
			 }
			$data=$this->constituentmodel->save_grievance_data($constituent_id,$constituency_id,$paguthi_id,$seeker_id,$grievance_id,$sub_category_id,$grievance_type,$petition_enquiry_no,$description,$grievance_date,$doc_name,$filename,$reference_note,$user_id);
			$messge = array('status'=>$data['status'],'message' => $data['msg'],'class' => $data['class']);
			$this->session->set_flashdata('msg', $messge);
			redirect("constituent/list_grievance");

		}else{
			redirect('/');
		}
	}



	public function update_grievance_status(){
		$user_id = $this->session->userdata('user_id');
		$user_type = $this->session->userdata('user_type');
		if($user_type=='1' || $user_type=='2'){
			$grievance_id=$this->input->post('grievance_id');
			$status=strtoupper($this->db->escape_str($this->input->post('status')));
			$sms_text=strtoupper($this->db->escape_str($this->input->post('sms_text')));
			$constituent_id=$this->input->post('constituent_grievance_id');
			$sms_id=$this->input->post('sms_id');
			$data=$this->constituentmodel->update_grievance_status($grievance_id,$status,$sms_text,$constituent_id,$sms_id,$user_id);
			$messge = array('status'=>$data['status'],'message' => $data['msg'],'class' => $data['class']);
			$this->session->set_flashdata('msg', $messge);
			redirect("constituent/list_grievance");
		}else{
			redirect('/');
		}

	}


	public function update_grievance_data(){
		$user_id = $this->session->userdata('user_id');
		$user_type = $this->session->userdata('user_type');
		if($user_type=='1' || $user_type=='2'){
			$grievance_id=$this->input->post('grievance_id');
			$seeker_id=$this->input->post('seeker_id');
			$reference_note=strtoupper($this->db->escape_str($this->input->post('reference_note')));
			$grievance_tb_id=$this->input->post('grievance_tb_id');
			$sub_category_id=$this->input->post('sub_category_id');
			$description=strtoupper($this->db->escape_str($this->input->post('description')));
			$data=$this->constituentmodel->update_grievance_data($grievance_id,$seeker_id,$reference_note,$sub_category_id,$grievance_tb_id,$description,$user_id);
			$messge = array('status'=>$data['status'],'message' => $data['msg'],'class' => $data['class']);
			$this->session->set_flashdata('msg', $messge);
			redirect("constituent/list_grievance");
		}else{
			redirect('/');
		}
	}



	public function update_refernce_note(){
		$user_id = $this->session->userdata('user_id');
		$user_type = $this->session->userdata('user_type');
		if($user_type=='1' || $user_type=='2'){
			$grievance_id=$this->input->post('reference_grievance_id');
			$reference_note=strtoupper($this->db->escape_str($this->input->post('reference_note')));
			$data=$this->constituentmodel->update_refernce_note($grievance_id,$reference_note,$user_id);
			$messge = array('status'=>$data['status'],'message' => $data['msg'],'class' => $data['class']);
			$this->session->set_flashdata('msg', $messge);
			redirect("constituent/list_grievance");
		}else{
			redirect('/');
		}
	}


	public function reply_grievance_text(){
		$user_id = $this->session->userdata('user_id');
		$user_type = $this->session->userdata('user_type');
		if($user_type=='1' || $user_type=='2'){
			$grievance_id=$this->input->post('reply_grievance_id');
			$sms_text=strtoupper($this->db->escape_str($this->input->post('reply_sms_text')));
			$constituent_id=$this->input->post('constituent_reply_id');
			$sms_id=$this->input->post('reply_sms_id');
			$data=$this->constituentmodel->reply_grievance_text($grievance_id,$sms_text,$constituent_id,$sms_id,$user_id);
			$messge = array('status'=>$data['status'],'message' => $data['msg'],'class' => $data['class']);
			$this->session->set_flashdata('msg', $messge);
			redirect("constituent/list_grievance");
		}else{
			redirect('/');
		}

	}


################## Grievance module ##############


################## Constituent Profile view only ##############

		public function constituent_profile_info(){
				$user_id = $this->session->userdata('user_id');
				$user_type = $this->session->userdata('user_type');
				if($user_type=='1' || $user_type=='2'){
					$constituent_id=$this->uri->segment(3);
					$data['res']=$this->constituentmodel->get_constituent_profile($constituent_id);
					$data['res_grievance']=$this->constituentmodel->get_constituent_grievance($constituent_id);
					$data['res_meeting']=$this->constituentmodel->get_constituent_meeting($constituent_id);
					$data['res_plant']=$this->constituentmodel->get_constituent_plant($constituent_id);
					$this->load->view('admin/header');
					$this->load->view('admin/constituent/constituent_profile_info',$data);
					$this->load->view('admin/footer');
				}else{
					redirect('/');
				}
		}
################## Constituent Profile view only ##############

################## Constituent voice call ##############

	public function give_voice_call(){
		$user_id = $this->session->userdata('user_id');
		$user_type = $this->session->userdata('user_type');
		if($user_type=='1' || $user_type=='2'){
			$constituent_id=$this->input->post('cons_id');
			$data=$this->smsmodel->send_voice_call($constituent_id);

		}else{
			redirect('/');
		}
	}

################## Constituent voice call ##############



}
