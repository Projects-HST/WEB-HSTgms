<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {
	
	function __construct() {
		 parent::__construct();

		 $this->load->library('session');
		 $this->load->helper(array('url','db_dynamic_helper'));
		 
		 $name_db=$this->session->userdata('consituency_code');
		 $config_app = switch_maindb($name_db);
		 $this->app_db = $this->load->database($config_app, TRUE); 
		 
		 $this->load->model(array('usermodel'));
		 $this->usermodel->app_db = $this->load->database($config_app,TRUE);
	}

	public function add()
	{
		$datas=$this->session->userdata();
		$user_id=$this->session->userdata('user_id');
		$user_type=$this->session->userdata('user_type');
		$datas['role'] = $this->usermodel->list_role();
		$datas['paguthi'] = $this->usermodel->list_paguthi();
		$datas['res_office'] = $this->usermodel->list_office();

		if($user_type==1){
			$this->load->view('admin/header');
			$this->load->view('admin/users/add',$datas);
			$this->load->view('admin/footer');
		}else {
			redirect(base_url());
		}
	}

	public function add_users()
	{
		$datas=$this->session->userdata();
        $user_id=$this->session->userdata('user_id');
		$user_type=$this->session->userdata('user_type');
				if($user_type==1){
					$role=$this->input->post('role');
					$paguthi=$this->input->post('paguthi');
					$office_id=$this->input->post('office_id');
					$name=$this->input->post('name');
					$email=$this->input->post('email');
					$mobile=$this->input->post('phone');
					$address= $this->db->escape_str($this->input->post('address'));
 					$gender=$this->input->post('gender');
					$status=$this->input->post('status');
					$profilepic = $_FILES['profile_pic']['name'];

					if(empty($profilepic)){
						$staff_prof_pic='';
					}else{
						$temp = pathinfo($profilepic, PATHINFO_EXTENSION);
						$staff_prof_pic = round(microtime(true)) . '.' . $temp;
						$uploaddir = 'assets/users/';
						$profilepic = $uploaddir.$staff_prof_pic;
						move_uploaded_file($_FILES['profile_pic']['tmp_name'], $profilepic);
					}
					$datas=$this->usermodel->add_users($role,$paguthi,$office_id,strtoupper($name),strtoupper($email),$mobile,strtoupper($address),$gender,$status,$staff_prof_pic,$user_id);

					if($datas['status']=="success"){
						$this->session->set_flashdata('msg', 'You have just created a profile for your staff!');
						redirect(base_url().'users/list_users');
					}else if($datas['status']=="already"){
						$this->session->set_flashdata('msg', 'User Already Exists');
						redirect(base_url().'users/list_users');
					}
					else{
						$this->session->set_flashdata('msg', 'Failed to Add');
						redirect(base_url().'users/list_users');
					}
       }
       else{
         redirect(base_url());
       }
	}

	public function checkemail(){
		$datas=$this->session->userdata();
		$user_id=$this->session->userdata('user_id');
		$user_type=$this->session->userdata('user_type');
		if($user_type==1){
				$email=$this->input->post('email');
				$datas['res']=$this->usermodel->checkemail(strtoupper($email));
		}else{
			redirect(base_url());
		}
	}

	public function checkphone(){
		$datas=$this->session->userdata();
		$user_id=$this->session->userdata('user_id');
		$user_type=$this->session->userdata('user_type');
		if($user_type==1){
				$phone=$this->input->post('phone');
				$datas['res']=$this->usermodel->checkphone($phone);
		}else{
			redirect(base_url());
		}
	}


	public function list_users()
	{
		$datas=$this->session->userdata();
		$user_id=$this->session->userdata('user_id');
		$user_type=$this->session->userdata('user_type');
		$datas['result']=$this->usermodel->list_users();

		if($user_type==1){
			$this->load->view('admin/header');
			$this->load->view('admin/users/list',$datas);
			$this->load->view('admin/footer');
		}else {
			redirect(base_url());
		}
	}

	public function edit()
	{
		$datas=$this->session->userdata();
		$user_id=$this->session->userdata('user_id');
		$user_type=$this->session->userdata('user_type');
		$staff_id=base64_decode($this->uri->segment(3))/98765;
		$datas['role'] = $this->usermodel->list_role();
		$datas['paguthi'] = $this->usermodel->list_paguthi();
		$datas['res_office'] = $this->usermodel->list_office();
		$datas['res']=$this->usermodel->users_details($staff_id);

		if($user_type==1){
			$this->load->view('admin/header');
			$this->load->view('admin/users/edit',$datas);
			$this->load->view('admin/footer');
		}else {
			redirect(base_url());
		}
	}

	public function checkemail_edit(){
		$datas=$this->session->userdata();
		$user_id=$this->session->userdata('user_id');
		$user_type=$this->session->userdata('user_type');
		if($user_type==1){
				$staff_id=base64_decode($this->uri->segment(3))/98765;
				$email=$this->input->post('email');
				$datas['res']=$this->usermodel->checkemail_edit($email,$staff_id);
		}else{
			redirect(base_url());
		}
	}

	public function checkphone_edit(){
		$datas=$this->session->userdata();
		$user_id=$this->session->userdata('user_id');
		$user_type=$this->session->userdata('user_type');
		if($user_type==1){
				$staff_id=base64_decode($this->uri->segment(3))/98765;
				$phone=$this->input->post('phone');
				$datas['res']=$this->usermodel->checkphone_edit($phone,$staff_id);
		}else{
			redirect(base_url());
		}
	}

	public function update_user(){
		$datas=$this->session->userdata();
		$user_id=$this->session->userdata('user_id');
		$user_type=$this->session->userdata('user_type');

		if($user_type==1){
			$staff_id= $this->input->post('staff_id');
			$role=$this->input->post('role');
			$paguthi=$this->input->post('paguthi');
			$office_id=$this->input->post('office_id');
			$name=$this->input->post('name');
			$email=$this->input->post('email');
			$mobile=$this->input->post('phone');
			$address= $this->db->escape_str($this->input->post('address'));
			$gender=$this->input->post('gender');
			$status=$this->input->post('status');

			$user_old_pic=$this->input->post('user_old_pic');
			$profilepic = $_FILES['new_profile_pic']['name'];

			if(empty($profilepic)){
				$staff_prof_pic=$user_old_pic;
			}else{
				$temp = pathinfo($profilepic, PATHINFO_EXTENSION);
				$staff_prof_pic = round(microtime(true)) . '.' . $temp;
				$uploaddir = 'assets/users/';
				$profilepic = $uploaddir.$staff_prof_pic;
				move_uploaded_file($_FILES['new_profile_pic']['tmp_name'], $profilepic);
			}

			$datas=$this->usermodel->update_user($role,$paguthi,$office_id,strtoupper($name),strtoupper($email),$mobile,strtoupper($address),$gender,$status,$staff_prof_pic,$staff_id,$user_id);

			if($datas['status']=="success"){
				$this->session->set_flashdata('msg', 'Profile Updated');
				redirect(base_url().'users/list_users');
			}else{
				$this->session->set_flashdata('msg', 'Failed');
				redirect(base_url().'users/list_users');
			}
		 } else {
				redirect(base_url());
		 }
	}
	
	



}
