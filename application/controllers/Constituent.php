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
			$this->load->model('reportmodel');
			$this->load->helper('cookie');


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
			$data['res_booth']=$this->mastermodel->get_active_booth_address();
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



	public function list_cons()
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
			if(empty($originalDate)){
					$meeting_date ='';
			}else{
					$meeting_date = date("Y-m-d", strtotime($originalDate));
			}
			$meeting_detail=strtoupper($this->db->escape_str($this->input->post('meeting_detail')));
			$meeting_title=strtoupper($this->db->escape_str($this->input->post('meeting_title')));
			$meeting_status=strtoupper($this->db->escape_str($this->input->post('meeting_status')));
			$data=$this->constituentmodel->save_meeting_request($constituent_id,$meeting_title,$meeting_detail,$meeting_date,$meeting_status,$user_id);
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
			if(empty($originalDate)){
					$meeting_date ='';
			}else{
					$meeting_date = date("Y-m-d", strtotime($originalDate));
			}
			$meeting_detail=strtoupper($this->db->escape_str($this->input->post('update_meeting_detail')));
			$meeting_title=strtoupper($this->db->escape_str($this->input->post('update_meeting_title')));
			$meeting_status=strtoupper($this->db->escape_str($this->input->post('update_meeting_status')));
			$data=$this->constituentmodel->update_meeting_request($meeting_id,$meeting_title,$meeting_detail,$meeting_date,$meeting_status,$user_id);
			$messge = array('status'=>$data['status'],'message' => $data['msg'],'class' => $data['class']);
			$this->session->set_flashdata('msg', $messge);
			redirect("constituent/list_constituent_member");
		}else{
			redirect('/');
		}
	}


	public function save_meeting_request_status(){
		$user_id = $this->session->userdata('user_id');
		$user_type = $this->session->userdata('user_type');
		if($user_type=='1' || $user_type=='2'){
			$meeting_id=$this->input->post('meeting_id');
			$constituent_id=$this->input->post('constituent_id');
			$originalDate=strtoupper($this->db->escape_str($this->input->post('meeting_date')));
			if(empty($originalDate)){
					$meeting_date ='';
			}else{
					$meeting_date = date("Y-m-d", strtotime($originalDate));
			}
			$send_checkbox=strtoupper($this->db->escape_str($this->input->post('send_checkbox')));
			$reply_sms_id=strtoupper($this->db->escape_str($this->input->post('reply_sms_id')));
	 		$reply_sms_text=strtoupper($this->db->escape_str($this->input->post('reply_sms_text')));
			$meeting_status=strtoupper($this->db->escape_str($this->input->post('meeting_status')));
			$data=$this->constituentmodel->save_meeting_request_status($meeting_id,$constituent_id,$meeting_status,$meeting_date,$send_checkbox,$reply_sms_id,$reply_sms_text,$user_id);
			$messge = array('status'=>$data['status'],'message' => $data['msg'],'class' => $data['class']);
			$this->session->set_flashdata('msg', $messge);
			redirect("constituent/meetings");
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


public function list_grievance_reply($rowno=0){
	$user_id = $this->session->userdata('user_id');
	$user_type = $this->session->userdata('user_type');
	if($user_type=='1' || $user_type=='2'){
		// Search text
		$search_text = "";
		if($this->input->post('submit') != NULL ){
			$search_text = $this->input->post('search');

		}else{
			if($this->session->userdata('search') != NULL){

			}
		}
		// Row per page
		$rowperpage = 20;

		// Row position
		if($rowno != 0){
			$rowno = ($rowno-1) * $rowperpage;
		}

		// All records count
		$allcount = $this->constituentmodel->getrecordreplycount($search_text);

		// Get records
		$users_record = $this->constituentmodel->list_grievance_reply($rowno,$rowperpage,$search_text);

		// Pagination Configuration
		$config['base_url'] = base_url().'constituent/list_grievance_reply';
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
		$data['res'] = $users_record;
		$data['row'] = $rowno;
		$data['search'] = $search_text;
		// $data['res']=$this->constituentmodel->list_grievance_reply();
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
			redirect("constituent/all_grievance");

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
			redirect("constituent/all_grievance");
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
			redirect("constituent/all_grievance");
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
			redirect($_SERVER['HTTP_REFERER']);

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

	public function send_reply_constituent_text(){
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
			redirect("constituent/list_constituent_member");
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

public function birthday($rowno=0)
	{
		$datas=$this->session->userdata();
		$user_id=$this->session->userdata('user_id');
		$user_type=$this->session->userdata('user_type');
				if($this->input->post('month')){
  			setcookie('pagination_limit',$this->input->post('month'));
  			$selMonth = $this->input->post('month');
				}elseif($this->input->cookie('pagination_limit')){
  				$selMonth = $this->input->cookie('pagination_limit', true);
				}else{
					$selMonth = date("m");
				}

		$data['month_id']=$selMonth;
		$rowperpage = 20;
		if($rowno != 0){
			$rowno = ($rowno-1) * $rowperpage;
		}
	  $allcount = $this->constituentmodel->get_all_birtday_count($selMonth);
		$users_record=$this->constituentmodel->get_birthday_report($rowno,$rowperpage,$selMonth);
		$config['base_url'] = base_url().'constituent/birthday';
		// $config['page_query_string'] = TRUE;

		$config['use_page_numbers'] = TRUE;
		$config['total_rows'] = $allcount;
		$config['per_page'] = $rowperpage;
		$config['full_tag_open'] = '<div style="margin:20px 10px 30px 0px;float:right;">';
		$config['full_tag_close'] = '</div>';
		$config['first_link'] = 'First';
		$config['last_link'] = 'Last';
		$config['first_tag_open'] = '<span class="pagination-first-tag">';
		$config['first_tag_close'] = '</span>';
		$config['last_tag_open'] = '<span class="pagination-last-tag">';
		$config['last_tag_close'] = '</span>';
		$config['next_link'] = 'Next';
		$config['prev_link'] = 'Prev';
		$config['next_tag_open'] = '<span class="pagination-next-tag">';
		$config['next_tag_close'] = '</span>';
		$config['prev_tag_open'] = '<span class="pagination-prev-tag">';
		$config['prev_tag_close'] = '</span>';
		$config['cur_tag_open'] = '<strong class="pagination-current-tag">';
		$config['cur_tag_close'] = '</strong>';
		$config['num_tag_open'] = '<span class="pagination-number">';
		$config['num_tag_close'] = '</span>';
		$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links();
		$data['result'] = $users_record;
		$data['row'] = $rowno;
		$data['allcount']=$allcount;

		if($user_type=='1' || $user_type=='2'){
			$this->load->view('admin/header');
			$this->load->view('admin/constituent/birthday_report',$data);
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
		$constituent_id=base64_decode($this->uri->segment(3))/98765;
		$data['res']=$this->constituentmodel->birthday_update($constituent_id,$user_id);
		redirect('constituent/birthday');

	}


public function meetings($rowno=0)
	{
		$datas=$this->session->userdata();
		$user_id=$this->session->userdata('user_id');
		$user_type=$this->session->userdata('user_type');



		if($this->input->post('submit') == true ){

			if($this->input->post('frmDate')){
					setcookie('m_frmDate',$this->input->post('frmDate'));
					$frmDate=$this->input->post('frmDate');
			}elseif($this->input->cookie('m_frmDate')){
					$frmDate = $this->input->cookie('m_frmDate', true);
			}else{
					$frmDate = "";
			}

			if($this->input->post('toDate')){
					setcookie('m_toDate',$this->input->post('toDate'));
					$toDate=$this->input->post('toDate');
			}elseif($this->input->cookie('m_frmDate')){
					$toDate = $this->input->cookie('m_toDate', true);
			}else{
					// $toDate = "";
			}

			if($this->input->post('search')){
					setcookie('m_search',$this->input->post('search'));
					$search_text=$this->input->post('search');
			}elseif($this->input->cookie('m_search')){
					$search_text = $this->input->cookie('m_search', true);
			}else{
					$search_text = "";
			}

		}else{
			setcookie('m_frmDate','');
			setcookie('m_toDate','');
			setcookie('m_search','');
			$frmDate='';
			$toDate = "";
			$search_text='';
		}


		$data['res_sms']=$this->mastermodel->get_active_template();
		$rowperpage = 20;
		if($rowno != 0){
			$rowno = ($rowno-1) * $rowperpage;
		}
		$allcount = $this->constituentmodel->get_meeting_count($search_text,$frmDate,$toDate);
		$users_record=$this->constituentmodel->get_meeting_report($rowno,$rowperpage,$search_text,$frmDate,$toDate);
		$config['base_url'] = base_url().'constituent/meetings';
		$config['use_page_numbers'] = TRUE;
		$config['total_rows'] = $allcount;
		$config['per_page'] = $rowperpage;
		$config['full_tag_open'] = '<div style="margin:20px 10px 30px 0px;float:right;">';
		$config['full_tag_close'] = '</div>';
		$config['first_link'] = 'First';
		$config['last_link'] = 'Last';
		$config['first_tag_open'] = '<span class="pagination-first-tag">';
		$config['first_tag_close'] = '</span>';
		$config['last_tag_open'] = '<span class="pagination-last-tag">';
		$config['last_tag_close'] = '</span>';
		$config['next_link'] = 'Next';
		$config['prev_link'] = 'Prev';
		$config['next_tag_open'] = '<span class="pagination-next-tag">';
		$config['next_tag_close'] = '</span>';
		$config['prev_tag_open'] = '<span class="pagination-prev-tag">';
		$config['prev_tag_close'] = '</span>';
		$config['cur_tag_open'] = '<strong class="pagination-current-tag">';
		$config['cur_tag_close'] = '</strong>';
		$config['num_tag_open'] = '<span class="pagination-number">';
		$config['num_tag_close'] = '</span>';
		$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links();
		$data['result'] = $users_record;
		$data['row'] = $rowno;
		$data['search'] = $search_text;

		if($user_type=='1' || $user_type=='2'){
			$this->load->view('admin/header');
			$this->load->view('admin/constituent/meeting_report',$data);
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
		$meeting_id=base64_decode($this->uri->segment(3))/98765;
		$frmDate=$this->uri->segment(4);
		$toDate=$this->uri->segment(5);
		$datas['res']=$this->constituentmodel->meeting_update($meeting_id,$user_id,$frmDate,$toDate);
		if($user_type=='1' || $user_type=='2'){
			$this->load->view('admin/header');
			$this->load->view('admin/report/meeting_report',$datas);
			$this->load->view('admin/footer');
		}else{
			redirect('/');
		}
	}

	public function list_constituent_member($rowno=0)
	{
		$user_id = $this->session->userdata('user_id');
		$user_type = $this->session->userdata('user_type');
		if($user_type=='1' || $user_type=='2'){

			$data['res_paguthi']=$this->mastermodel->get_active_paguthi();
			$data['res_constituency']=$this->mastermodel->get_active_constituency();
			$data['res_seeker']=$this->mastermodel->get_active_seeker();
			$data['res_sms']=$this->mastermodel->get_active_template();
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
			$rowperpage = 20;

			// Row position
			if($rowno != 0){
			  $rowno = ($rowno-1) * $rowperpage;
			}

			// All records count
			$allcount = $this->constituentmodel->getConstituentcount($search_text);

			// Get records
			$users_record = $this->constituentmodel->getConstituent($rowno,$rowperpage,$search_text);

			// Pagination Configuration
			$config['base_url'] = base_url().'constituent/list_constituent_member';
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
			$this->load->view('admin/constituent/search_list_records',$data);
			$this->load->view('admin/footer');

			}else{
				redirect('/');
			}

	}

	public function export_constituent(){

		// Search text
		$search_text = "";
		 if($this->session->userdata('search') != NULL){
			$search_text = $this->session->userdata('search');
		  }

		$filename = 'users_'.date('Ymd').'.csv';
		//$filename = 'users_'.date('Ymd').'.xls';

		header("Content-Description: File Transfer");
		header("Content-Type: application/csv; ");
		header("Content-Disposition: attachment; filename=$filename");
		//header("Content-type: application/vnd.ms-excel");
		//header("Content-Disposition: attachment;Filename=$filename");

	   // get data
	    $resultData = $this->constituentmodel->exportConstituent($search_text);
		//print_r($resultData);
		//exit;

		// file creation
		$file = fopen('php://output','w');
		$header = array("Name","Father/Husband_name","Mobile","Door no","Address","Pincode","Aadhaar","Voter id","Serial no","Status");
		fputcsv($file, $header);
		foreach ($resultData as $key=>$line){
			fputcsv($file,$line);
		}
		fclose($file);
		exit;
	}




	public function festival_wishes($rowno=0){
		$user_id = $this->session->userdata('user_id');
		$user_type = $this->session->userdata('user_type');
		if($user_type=='1' || $user_type=='2'){
			$data['res_festival']=$this->mastermodel->get_active_festival();
			$data['paguthi'] = $this->mastermodel->get_active_paguthi();
			// Search text
			if($this->input->post('religion_id')){
					setcookie('religion_id',$this->input->post('religion_id'));
					$religion_id = $this->input->post('religion_id');
			}elseif($this->input->cookie('religion_id')){
					$religion_id = $this->input->cookie('religion_id', true);
			}else{
					$religion_id = "";
			}
			if($this->input->post('paguthi')){
					setcookie('paguthi',$this->input->post('paguthi'));
					$paguthi = $this->input->post('paguthi');
			}elseif($this->input->cookie('paguthi')){
					$paguthi = $this->input->cookie('paguthi', true);
			}else{
					$paguthi = "";
			}

			if($this->input->post('ward_id')){
					setcookie('ward_id',$this->input->post('ward_id'));
					$ward_id = $this->input->post('ward_id');
			}elseif($this->input->cookie('ward_id')){
					$ward_id = $this->input->cookie('ward_id', true);
			}else{
					$ward_id = "";
			}


				$data['festival_id']=$religion_id;
				$data['paguthi_id']=$paguthi;
			// Row per page
			$rowperpage = 25;

			// Row position
			if($rowno != 0){
				$rowno = ($rowno-1) * $rowperpage;
			}

			// All records count
			$allcount = $this->constituentmodel->festival_wishes_count($paguthi,$ward_id,$religion_id);

			// Get records
			$users_record = $this->constituentmodel->fetch_festival_data($rowno,$rowperpage,$paguthi,$ward_id,$religion_id);

			// Pagination Configuration
			$config['base_url'] = base_url().'constituent/festival_wishes';
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
			$this->load->view('admin/constituent/festival_wishes',$data);
			$this->load->view('admin/footer');

			}else{
				redirect('/');
			}

	}

	public function reset_search()
	{
		$datas=$this->session->userdata();
		$user_id=$this->session->userdata('user_id');
		$user_type=$this->session->userdata('user_type');

		$this->session->unset_userdata('search');
		redirect(base_url()."constituent/festival_wishes");
	}

	public function sent_festival_wishes(){
		$datas=$this->session->userdata();
		$user_id=$this->session->userdata('user_id');
		$user_type=$this->session->userdata('user_type');
		$cons_id = $this->input->post('cons_id');
		$festival_id = $this->input->post('festival_id');
		$data=$this->reportmodel->sent_festival_wishes($cons_id,$festival_id,$user_id);
	}



	public function all_grievance($rowno=0){
		$user_id = $this->session->userdata('user_id');
		$user_type = $this->session->userdata('user_type');
		if($user_type=='1' || $user_type=='2'){
			$data['res_sms']=$this->mastermodel->get_active_template();
				if($this->input->post('submit') == true ){
					if($this->input->post('a_search')){
							setcookie('a_search',$this->input->post('a_search'));
							$search = $this->input->post('a_search');
					}elseif($this->input->cookie('a_search')){
							$search = $this->input->cookie('a_search', true);
					}else{
							$search = "";
					}
				}else{
					setcookie('a_search','');
					$search='';
				}

			// Row per page
			$rowperpage = 25;

			// Row position
			if($rowno != 0){
				$rowno = ($rowno-1) * $rowperpage;
			}

			// All records count
			$allcount = $this->constituentmodel->get_all_grievance_count($search);

			// Get records
			$users_record = $this->constituentmodel->all_grievance($rowno,$rowperpage,$search);

			// Pagination Configuration
			$config['base_url'] = base_url().'constituent/all_grievance';
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
			$data['search'] = $search;
			$data['allcount'] = $allcount;
			// Load view
			$this->load->view('admin/header');
			$this->load->view('admin/constituent/all_grievance',$data);
			$this->load->view('admin/footer');

			}else{
				redirect('/');
			}

	}

	public function all_petition($rowno=0){
		$user_id = $this->session->userdata('user_id');
		$user_type = $this->session->userdata('user_type');
		if($user_type=='1' || $user_type=='2'){
			$data['res_sms']=$this->mastermodel->get_active_template();
			// Search text
			if($this->input->post('submit') == true ){
				if($this->input->post('p_search')){
						setcookie('p_search',$this->input->post('p_search'));
						$search_text = $this->input->post('p_search');
				}elseif($this->input->cookie('p_search')){
						$search_text = $this->input->cookie('p_search', true);
				}else{
						$search_text = "";
				}
			}else{
				setcookie('p_search','');
				$search_text='';
			}
			// Row per page
			$rowperpage = 25;

			// Row position
			if($rowno != 0){
				$rowno = ($rowno-1) * $rowperpage;
			}

			// All records count
			$allcount = $this->constituentmodel->getrecordCount($search_text);

			// Get records
			$users_record = $this->constituentmodel->all_petition($rowno,$rowperpage,$search_text);

			// Pagination Configuration
			$config['base_url'] = base_url().'constituent/all_petition';
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
			$this->load->view('admin/constituent/all_petition',$data);
			$this->load->view('admin/footer');

			}else{
				redirect('/');
			}

	}

	public function all_enquiry($rowno=0){
		$user_id = $this->session->userdata('user_id');
		$user_type = $this->session->userdata('user_type');
		if($user_type=='1' || $user_type=='2'){
			$data['res_sms']=$this->mastermodel->get_active_template();
			// Search text
			if($this->input->post('submit') == true ){
				if($this->input->post('e_search')){
						setcookie('e_search',$this->input->post('e_search'));
						$search_text = $this->input->post('e_search');
				}elseif($this->input->cookie('e_search')){
						$search_text = $this->input->cookie('e_search', true);
				}else{
						$search_text = "";
				}
			}else{
				setcookie('a_search','');
				$search_text='';
			}
			// Row per page
			$rowperpage = 25;

			// Row position
			if($rowno != 0){
				$rowno = ($rowno-1) * $rowperpage;
			}

			// All records count
			$allcount = $this->constituentmodel->getrecordCount($search_text);

			// Get records
			$users_record = $this->constituentmodel->all_enquiry($rowno,$rowperpage,$search_text);

			// Pagination Configuration
			$config['base_url'] = base_url().'constituent/all_enquiry';
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
			$this->load->view('admin/constituent/all_enquiry',$data);
			$this->load->view('admin/footer');

			}else{
				redirect('/');
			}

	}


//------ Constituent Video -----//

	public function get_constituent_video(){
		$user_id = $this->session->userdata('user_id');
		$user_type = $this->session->userdata('user_type');
		if($user_type=='1' || $user_type=='2'){
			$constituent_id=$this->input->post('c_id');
			$data['res']=$this->constituentmodel->get_constituent_video($constituent_id,$user_id);
			echo json_encode($data['res']);
		}else{

		}
	}


	public function save_video_link(){
		$user_id = $this->session->userdata('user_id');
		$user_type = $this->session->userdata('user_type');
		if($user_type=='1' || $user_type=='2'){
			$constituent_id=$this->input->post('video_constituent_id');
			$video_link=$this->db->escape_str($this->input->post('video_link'));
			$video_title=strtoupper($this->db->escape_str($this->input->post('video_title')));
			$data['res']=$this->constituentmodel->save_video_link($constituent_id,$video_title,$video_link,$user_id);
			echo json_encode($data['res']);
		}else{

		}
	}

	public function update_video_link(){
		$user_id = $this->session->userdata('user_id');
		$user_type = $this->session->userdata('user_type');
		if($user_type=='1' || $user_type=='2'){
			$video_link_id=$this->input->post('video_link_id');
			 $video_link=$this->db->escape_str($this->input->post('update_video_link'));
			$video_title=strtoupper($this->db->escape_str($this->input->post('update_video_title')));
			$data['res']=$this->constituentmodel->update_video_link($video_link_id,$video_title,$video_link,$user_id);
			echo json_encode($data['res']);
		}else{

		}
	}

	public function edit_video_constituent(){
		$user_id = $this->session->userdata('user_id');
		$user_type = $this->session->userdata('user_type');
		if($user_type=='1' || $user_type=='2'){
			$v_id=$this->input->post('v_id');
			$data['res']=$this->constituentmodel->edit_video_constituent($v_id,$user_id);
			echo json_encode($data['res']);
		}else{
			redirect('/');
		}
	}

	//------ Constituent Video -----//



}
