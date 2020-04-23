<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class constituent extends CI_Controller {


	function __construct() {
		 parent::__construct();
			$this->load->helper("url");
			$this->load->library('session');
			$this->load->model('mastermodel');
			$this->load->model('constituentmodel');
 }



	#################### constituent ####################

	public function constituent_member()
	{
		$user_id = $this->session->userdata('user_id');
		$user_type = $this->session->userdata('user_type');
		if($user_type=='1'){
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


	public function list_constituent_member()
	{
		$user_id = $this->session->userdata('user_id');
		$user_type = $this->session->userdata('user_type');
		if($user_type=='1'){
			$data['res']=$this->constituentmodel->get_constituent_member_list();
			$this->load->view('admin/header');
			$this->load->view('admin/constituent/list_constituent_member',$data);
			$this->load->view('admin/footer');
		}else{
			redirect('/');
		}

	}

	public function create_constituent_member(){
		$user_id = $this->session->userdata('user_id');
		$user_type = $this->session->userdata('user_type');
		if($user_type=='1'){
			$constituency_id=$this->input->post('constituency_id');
			$paguthi_id=$this->input->post('paguthi_id');
			$ward_id=$this->input->post('ward_id');
			$booth_id=$this->input->post('booth_id');
			$full_name=mb_strtoupper($this->input->post('full_name'));
			$father_husband_name=mb_strtoupper($this->input->post('father_husband_name'));
			$guardian_name=mb_strtoupper($this->input->post('guardian_name'));
			$mobile_no=mb_strtoupper($this->input->post('mobile_no'));
			$whatsapp_no=mb_strtoupper($this->input->post('whatsapp_no'));
			$originalDate=mb_strtoupper($this->input->post('dob'));
			 $dob = date("Y-m-d", strtotime($originalDate));
			$door_no=mb_strtoupper($this->input->post('door_no'));
			$address=mb_strtoupper($this->input->post('address'));
			$pin_code=mb_strtoupper($this->input->post('pin_code'));
			$religion_id=mb_strtoupper($this->input->post('religion_id'));
			$email_id=mb_strtoupper($this->input->post('email_id'));
			$gender=mb_strtoupper($this->input->post('gender'));
			$voter_id_status=mb_strtoupper($this->input->post('voter_id_status'));
			$voter_id_no=mb_strtoupper($this->input->post('voter_id_no'));
			$aadhaar_status=mb_strtoupper($this->input->post('aadhaar_status'));
			$aadhaar_no=mb_strtoupper($this->input->post('aadhaar_no'));
			$party_member_status=mb_strtoupper($this->input->post('party_member_status'));
			$vote_type=mb_strtoupper($this->input->post('vote_type'));
			$serial_no=mb_strtoupper($this->input->post('serial_no'));
			$question_id=$this->input->post('question_id');
			$question_response=$this->input->post('question_response');
			$interaction_section=$this->input->post('interaction_section');
			// $status=mb_strtoupper($this->input->post('status'));
			$profilepic = $_FILES['profile_pic']['name'];
				if(empty($profilepic)){
				$filename=' ';
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


	public function checkserialno(){
		$serial_no=mb_strtoupper($this->input->post('serial_no'));
		$data=$this->constituentmodel->checkserialno($serial_no);
	}
	public function checkvoter_id_no(){
		$voter_id_no=mb_strtoupper($this->input->post('voter_id_no'));
		$data=$this->constituentmodel->checkvoter_id_no($voter_id_no);
	}
	public function checkaadhaar_no(){
		$aadhaar_no=mb_strtoupper($this->input->post('aadhaar_no'));
		$data=$this->constituentmodel->checkaadhaar_no($aadhaar_no);

	}





}
