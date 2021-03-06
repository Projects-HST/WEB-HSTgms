<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Masters extends CI_Controller {

	function __construct() {
		 parent::__construct();
			
		$this->load->library('session');
		$this->load->helper(array('url','db_dynamic_helper'));

		$name_db=$this->session->userdata('consituency_code');
		$config_app = switch_maindb($name_db);
		$this->app_db = $this->load->database($config_app, TRUE); 

		$this->load->model(array('mastermodel'));
		$this->mastermodel->app_db = $this->load->database($config_app,TRUE);
 }

	public function constituency()
	{
		$user_id = $this->session->userdata('user_id');
		$user_type = $this->session->userdata('user_type');
		if($user_type=='1' || $user_type=='2'){
			$data['res']=$this->mastermodel->get_constituency();
			$this->load->view('admin/header');
			$this->load->view('admin/masters/constituency',$data);
			$this->load->view('admin/footer');
		}else{
			redirect('/');
		}

	}

	public function update_constituency()
	{
		$user_id = $this->session->userdata('user_id');
		$user_type = $this->session->userdata('user_type');
		if($user_type=='1' || $user_type=='2'){
			$constituency_name=strtoupper($this->db->escape_str($this->input->post('constituency_name')));
			$data=$this->mastermodel->update_constituency($constituency_name,$user_id);
			$messge = array('status'=>$data['status'],'message' => $data['msg'],'class' => $data['class']);
			$this->session->set_flashdata('msg', $messge);
			redirect("masters/constituency");
		}else{
			redirect('/');
		}

	}

	#################### Paguthi ####################//

	public function paguthi()
	{
		$user_id = $this->session->userdata('user_id');
		$user_type = $this->session->userdata('user_type');
		if($user_type=='1' || $user_type=='2'){
			$data['res']=$this->mastermodel->get_paguthi();
			$this->load->view('admin/header');
			$this->load->view('admin/masters/paguthi',$data);
			$this->load->view('admin/footer');
		}else{
			redirect('/');
		}

	}


	public function checkpaguthi(){
		$paguthi_name=strtoupper($this->db->escape_str($this->input->post('paguthi_name')));
		$data=$this->mastermodel->checkpaguthi($paguthi_name);
	}
	public function checkpaguthishort(){
		$paguthi_short_name=strtoupper($this->db->escape_str($this->input->post('paguthi_short_name')));
		$data=$this->mastermodel->checkpaguthishort($paguthi_short_name);
	}

	public function checkpaguthiexist(){
		$paguthi_name=strtoupper($this->db->escape_str($this->input->post('paguthi_name')));
		$paguthi_id=$this->uri->segment(3);
		$data=$this->mastermodel->checkpaguthiexist($paguthi_name,$paguthi_id);
	}

	public function checkpaguthishortexist(){
		$paguthi_short_name=strtoupper($this->db->escape_str($this->input->post('paguthi_short_name')));
		$paguthi_id=$this->uri->segment(3);
		$data=$this->mastermodel->checkpaguthishortexist($paguthi_short_name,$paguthi_id);
	}

	public function get_paguthi_edit(){
		$user_id = $this->session->userdata('user_id');
		$user_type = $this->session->userdata('user_type');
		if($user_type=='1' || $user_type=='2'){
			$paguthi_id=$this->uri->segment(3);
			$data['res']=$this->mastermodel->get_paguthi_edit($paguthi_id);
			$this->load->view('admin/header');
			$this->load->view('admin/masters/update_paguthi',$data);
			$this->load->view('admin/footer');
		}else{
			redirect('/');
		}
	}

	public function create_paguthi(){
		$user_id = $this->session->userdata('user_id');
		$user_type = $this->session->userdata('user_type');
		if($user_type=='1' || $user_type=='2'){
			$paguthi_name=strtoupper($this->db->escape_str($this->input->post('paguthi_name')));
			$paguthi_short_name=strtoupper($this->db->escape_str($this->input->post('paguthi_short_name')));
			$status=$this->input->post('status');
			$data=$this->mastermodel->create_paguthi($paguthi_name,$paguthi_short_name,$status,$user_id);
			$messge = array('status'=>$data['status'],'message' => $data['msg'],'class' => $data['class']);
			$this->session->set_flashdata('msg', $messge);
			redirect("masters/paguthi");
		}else{
			redirect('/');
		}
	}


	public function update_paguthi(){
		$user_id = $this->session->userdata('user_id');
		$user_type = $this->session->userdata('user_type');
		if($user_type=='1' || $user_type=='2'){
			$paguthi_name=strtoupper($this->db->escape_str($this->input->post('paguthi_name')));
			$paguthi_short_name=strtoupper($this->db->escape_str($this->input->post('paguthi_short_name')));
			$status=strtoupper($this->db->escape_str($this->input->post('status')));
		 	$paguthi_id=$this->input->post('paguthi_id');

			$data=$this->mastermodel->update_paguthi($paguthi_name,$paguthi_short_name,$status,$user_id,$paguthi_id);
			$messge = array('status'=>$data['status'],'message' => $data['msg'],'class' => $data['class']);
			$this->session->set_flashdata('msg', $messge);
			redirect("masters/paguthi");
		}else{
			redirect('/');
		}
	}


	#################### Paguthi ####################//


	#################### ward ####################

	public function ward()
	{
		$user_id = $this->session->userdata('user_id');
		$user_type = $this->session->userdata('user_type');
		if($user_type=='1' || $user_type=='2'){
			$data['res']=$this->mastermodel->get_ward();
			$data['res_paguthi']=$this->mastermodel->get_paguthi();
			$this->load->view('admin/header');
			$this->load->view('admin/masters/ward',$data);
			$this->load->view('admin/footer');
		}else{
			redirect('/');
		}

	}

	public function create_ward(){
		$user_id = $this->session->userdata('user_id');
		$user_type = $this->session->userdata('user_type');
		if($user_type=='1' || $user_type=='2'){
			$paguthi_id=$this->input->post('paguthi_id');
			$ward_name=strtoupper($this->db->escape_str($this->input->post('ward_name')));
			$status=strtoupper($this->db->escape_str($this->input->post('status')));
			$data=$this->mastermodel->create_ward($paguthi_id,$ward_name,$status,$user_id);
			$messge = array('status'=>$data['status'],'message' => $data['msg'],'class' => $data['class']);
			$this->session->set_flashdata('msg', $messge);
			redirect("masters/ward");
		}else{
			redirect('/');
		}
	}

	public function update_ward(){
		$user_id = $this->session->userdata('user_id');
		$user_type = $this->session->userdata('user_type');
		if($user_type=='1' || $user_type=='2'){
			$paguthi_id=$this->input->post('paguthi_id');
			$ward_name=strtoupper($this->db->escape_str($this->input->post('ward_name')));
			$status=strtoupper($this->db->escape_str($this->input->post('status')));
			$ward_id=$this->input->post('ward_id');
			$data=$this->mastermodel->update_ward($paguthi_id,$ward_name,$status,$user_id,$ward_id);
			$messge = array('status'=>$data['status'],'message' => $data['msg'],'class' => $data['class']);
			$this->session->set_flashdata('msg', $messge);
			redirect("masters/ward");
		}else{
			redirect('/');
		}
	}

	public function get_ward_edit(){
		$user_id = $this->session->userdata('user_id');
		$user_type = $this->session->userdata('user_type');
		if($user_type=='1' || $user_type=='2'){
			$ward_id=$this->uri->segment(3);
			$data['res_paguthi']=$this->mastermodel->get_paguthi();
			$data['res']=$this->mastermodel->get_ward_edit($ward_id);
			$this->load->view('admin/header');
			$this->load->view('admin/masters/update_ward',$data);
			$this->load->view('admin/footer');
		}else{
			redirect('/');
		}
	}


	#################### ward ####################

	#################### Office ####################

	public function office()
	{
		$user_id = $this->session->userdata('user_id');
		$user_type = $this->session->userdata('user_type');
		if($user_type=='1' || $user_type=='2'){
			$paguthi_id=$this->uri->segment(3);
			$data['res']=$this->mastermodel->get_office($paguthi_id);
			$this->load->view('admin/header');
			$this->load->view('admin/masters/office',$data);
			$this->load->view('admin/footer');
		}else{
			redirect('/');
		}

	}

	public function checkoffice(){
		$office_name=strtoupper($this->db->escape_str($this->input->post('office_name')));
		$data=$this->mastermodel->checkoffice($office_name);
	}
	public function checkofficeshortname(){
		$office_short_form=strtoupper($this->db->escape_str($this->input->post('office_short_form')));
		$data=$this->mastermodel->checkofficeshortname($office_short_form);
	}

	public function checkofficeexist(){
		$office_name=strtoupper($this->db->escape_str($this->input->post('office_name')));
		$office_id=$this->uri->segment(3);
		$data=$this->mastermodel->checkofficeexist($office_name,$office_id);
	}

	public function checkofficeshortnameexist(){
		$office_short_form=strtoupper($this->db->escape_str($this->input->post('office_short_form')));
		$office_id=$this->uri->segment(3);
		$data=$this->mastermodel->checkofficeshortnameexist($office_short_form,$office_id);
	}



	public function create_office(){
		$user_id = $this->session->userdata('user_id');
		$user_type = $this->session->userdata('user_type');
		if($user_type=='1' || $user_type=='2'){
			$paguthi_id=$this->input->post('paguthi_id');
			$office_name=strtoupper($this->db->escape_str($this->input->post('office_name')));
			$office_short_form=strtoupper($this->db->escape_str($this->input->post('office_short_form')));
			$status=$this->input->post('status');
			$data=$this->mastermodel->create_office($paguthi_id,$office_name,$office_short_form,$status,$user_id);
			$messge = array('status'=>$data['status'],'message' => $data['msg'],'class' => $data['class']);
			$this->session->set_flashdata('msg', $messge);
			redirect("masters/office/$paguthi_id");
		}else{
			redirect('/');
		}
	}


	public function get_office_edit(){
		$user_id = $this->session->userdata('user_id');
		$user_type = $this->session->userdata('user_type');
		if($user_type=='1' || $user_type=='2'){
			$office_id=$this->uri->segment(3);
			$data['res']=$this->mastermodel->get_office_edit($office_id);
			$this->load->view('admin/header');
			$this->load->view('admin/masters/update_office',$data);
			$this->load->view('admin/footer');
		}else{
			redirect('/');
		}
	}


	public function update_office(){
		$user_id = $this->session->userdata('user_id');
		$user_type = $this->session->userdata('user_type');
		if($user_type=='1' || $user_type=='2'){
			$office_name=strtoupper($this->db->escape_str($this->input->post('office_name')));
			$office_short_form=strtoupper($this->db->escape_str($this->input->post('office_short_form')));
			$status=strtoupper($this->db->escape_str($this->input->post('status')));
			$paguthi_id=$this->input->post('paguthi_id');
			$office_id=$this->input->post('office_id');
			$data=$this->mastermodel->update_office($office_name,$office_short_form,$status,$user_id,$office_id);
			$messge = array('status'=>$data['status'],'message' => $data['msg'],'class' => $data['class']);
			$this->session->set_flashdata('msg', $messge);
			redirect("masters/office/$paguthi_id");
		}else{
			redirect('/');
		}
	}



	#################### Office ####################

	#################### Booth ####################
	public function booth()
	{
		$user_id = $this->session->userdata('user_id');
		$user_type = $this->session->userdata('user_type');
		if($user_type=='1' || $user_type=='2'){
			$ward_id=$this->uri->segment(3);
			$data['res']=$this->mastermodel->get_booth($ward_id);
			$this->load->view('admin/header');
			$this->load->view('admin/masters/booth',$data);
			$this->load->view('admin/footer');
		}else{
			redirect('/');
		}

	}


	public function create_booth(){
		$user_id = $this->session->userdata('user_id');
		$user_type = $this->session->userdata('user_type');
		if($user_type=='1' || $user_type=='2'){
			$booth_name=strtoupper($this->db->escape_str($this->input->post('booth_name')));
			$ward_id=$this->input->post('ward_id');
			$booth_address=strtoupper($this->db->escape_str($this->input->post('booth_address')));
		  $status=strtoupper($this->db->escape_str($this->input->post('status')));
			$data=$this->mastermodel->create_booth($booth_name,$booth_address,$status,$user_id,$ward_id);
			$messge = array('status'=>$data['status'],'message' => $data['msg'],'class' => $data['class']);
			$this->session->set_flashdata('msg', $messge);
			redirect("masters/booth/$ward_id");
		}else{
			redirect('/');
		}
	}


	public function get_booth_edit(){
		$user_id = $this->session->userdata('user_id');
		$user_type = $this->session->userdata('user_type');
		if($user_type=='1' || $user_type=='2'){
			$booth_id=$this->uri->segment(3);
			$data['res']=$this->mastermodel->get_booth_edit($booth_id);
			$this->load->view('admin/header');
			$this->load->view('admin/masters/update_booth',$data);
			$this->load->view('admin/footer');
		}else{
			redirect('/');
		}
	}


	public function update_booth(){
		$user_id = $this->session->userdata('user_id');
		$user_type = $this->session->userdata('user_type');
		if($user_type=='1' || $user_type=='2'){
			$booth_name=strtoupper($this->db->escape_str($this->input->post('booth_name')));
			$ward_id=$this->input->post('ward_id');
			$booth_address=strtoupper($this->db->escape_str($this->input->post('booth_address')));
			$status=strtoupper($this->db->escape_str($this->input->post('status')));
			$booth_id=$this->input->post('booth_id');
			$data=$this->mastermodel->update_booth($booth_name,$booth_address,$status,$user_id,$ward_id,$booth_id);
			$messge = array('status'=>$data['status'],'message' => $data['msg'],'class' => $data['class']);
			$this->session->set_flashdata('msg', $messge);
			redirect("masters/booth/$ward_id");
		}else{
			redirect('/');
		}
	}

	#################### Booth ####################


	#################### Seeker type  ####################

		public function seeker()
		{
			$user_id = $this->session->userdata('user_id');
			$user_type = $this->session->userdata('user_type');
			if($user_type=='1' || $user_type=='2'){
				$data['res']=$this->mastermodel->get_seeker();
				$this->load->view('admin/header');
				$this->load->view('admin/masters/seeker',$data);
				$this->load->view('admin/footer');
			}else{
				redirect('/');
			}

		}

		public function get_seeker_edit(){
			$user_id = $this->session->userdata('user_id');
			$user_type = $this->session->userdata('user_type');
			if($user_type=='1' || $user_type=='2'){
				$seeker_id=$this->uri->segment(3);
				$data['res']=$this->mastermodel->get_seeker_edit($seeker_id);
				$this->load->view('admin/header');
				$this->load->view('admin/masters/update_seeker',$data);
				$this->load->view('admin/footer');
			}else{
				redirect('/');
			}
		}

		public function checkseeker(){
			$seeker_info=strtoupper($this->db->escape_str($this->input->post('seeker_info')));
			$data=$this->mastermodel->checkseeker($seeker_info);
		}
		public function checkseekerexist(){
			$seeker_info=strtoupper($this->db->escape_str($this->input->post('seeker_info')));
			$seeker_id=$this->uri->segment(3);
			$data=$this->mastermodel->checkseekerexist($seeker_info,$seeker_id);
		}

		public function create_seeker(){
			$user_id = $this->session->userdata('user_id');
			$user_type = $this->session->userdata('user_type');
			if($user_type=='1' || $user_type=='2'){
				$seeker_info=strtoupper($this->db->escape_str($this->input->post('seeker_info')));
				$status=strtoupper($this->db->escape_str($this->input->post('status')));
				$data=$this->mastermodel->create_seeker($seeker_info,$status,$user_id);
				$messge = array('status'=>$data['status'],'message' => $data['msg'],'class' => $data['class']);
				$this->session->set_flashdata('msg', $messge);
				redirect("masters/seeker");
			}else{
				redirect('/');
			}
		}

		public function update_seeker(){
			$user_id = $this->session->userdata('user_id');
			$user_type = $this->session->userdata('user_type');
			if($user_type=='1' || $user_type=='2'){
				$seeker_info=strtoupper($this->db->escape_str($this->input->post('seeker_info')));
				$status=strtoupper($this->db->escape_str($this->input->post('status')));
				$seeker_id=$this->input->post('seeker_id');
				$data=$this->mastermodel->update_seeker($seeker_info,$status,$user_id,$seeker_id);
				$messge = array('status'=>$data['status'],'message' => $data['msg'],'class' => $data['class']);
				$this->session->set_flashdata('msg', $messge);
				redirect("masters/seeker");
			}else{
				redirect('/');
			}
		}

	#################### Seeker type  ####################

	#################### Grievance type  ####################
	public function grievance()
	{
		$user_id = $this->session->userdata('user_id');
		$user_type = $this->session->userdata('user_type');
		if($user_type=='1' || $user_type=='2'){
			$data['res']=$this->mastermodel->get_grievance();
			$data['res_seeker']=$this->mastermodel->get_seeker();
			$this->load->view('admin/header');
			$this->load->view('admin/masters/grievance',$data);
			$this->load->view('admin/footer');
		}else{
			redirect('/');
		}
	}

	public function get_grievance_edit(){
		$user_id = $this->session->userdata('user_id');
		$user_type = $this->session->userdata('user_type');
		if($user_type=='1' || $user_type=='2'){
			$grievance_id=$this->uri->segment(3);
			$data['res']=$this->mastermodel->get_grievance_edit($grievance_id);
			$data['res_seeker']=$this->mastermodel->get_seeker();
			$this->load->view('admin/header');
			$this->load->view('admin/masters/update_grievance',$data);
			$this->load->view('admin/footer');
		}else{
			redirect('/');
		}
	}


	public function create_grievance(){
		$user_id = $this->session->userdata('user_id');
		$user_type = $this->session->userdata('user_type');
		if($user_type=='1' || $user_type=='2'){
			$seeker_id=$this->input->post('seeker_id');
			$grievance_name=strtoupper($this->db->escape_str($this->input->post('grievance_name')));
			$status=strtoupper($this->db->escape_str($this->input->post('status')));
			$data=$this->mastermodel->create_grievance($seeker_id,$grievance_name,$status,$user_id);
			$messge = array('status'=>$data['status'],'message' => $data['msg'],'class' => $data['class']);
			$this->session->set_flashdata('msg', $messge);
			redirect("masters/grievance");
		}else{
			redirect('/');
		}
	}

	public function update_grievance(){
		$user_id = $this->session->userdata('user_id');
		$user_type = $this->session->userdata('user_type');
		if($user_type=='1' || $user_type=='2'){
			$seeker_id=$this->input->post('seeker_id');
			$grievance_name=strtoupper($this->db->escape_str($this->input->post('grievance_name')));
				$grievance_id=$this->input->post('grievance_id');
			$status=strtoupper($this->db->escape_str($this->input->post('status')));
			$data=$this->mastermodel->update_grievance($seeker_id,$grievance_name,$status,$user_id,$grievance_id);
			$messge = array('status'=>$data['status'],'message' => $data['msg'],'class' => $data['class']);
			$this->session->set_flashdata('msg', $messge);
			redirect("masters/grievance/");
		}else{
			redirect('/');
		}
	}


	#################### Grievance type  ####################


	#################### Grievance Sub category  ####################
	public function sub_category()
	{
		$user_id = $this->session->userdata('user_id');
		$user_type = $this->session->userdata('user_type');
		if($user_type=='1' || $user_type=='2'){
			$grievance_id=$this->uri->segment(3);
			$data['res']=$this->mastermodel->get_grievance_sub_category($grievance_id);
			$this->load->view('admin/header');
			$this->load->view('admin/masters/sub_category',$data);
			$this->load->view('admin/footer');
		}else{
			redirect('/');
		}
	}


	public function get_sub_category_edit()
	{
		$user_id = $this->session->userdata('user_id');
		$user_type = $this->session->userdata('user_type');
		if($user_type=='1' || $user_type=='2'){
			$sub_category_id=$this->uri->segment(3);
			$data['res']=$this->mastermodel->get_sub_category_edit($sub_category_id);
			$this->load->view('admin/header');
			$this->load->view('admin/masters/update_sub_category',$data);
			$this->load->view('admin/footer');
		}else{
			redirect('/');
		}
	}

	public function create_sub_category_name(){
		$user_id = $this->session->userdata('user_id');
		$user_type = $this->session->userdata('user_type');
		if($user_type=='1' || $user_type=='2'){
			$grievance_id=$this->input->post('grievance_id');
			$sub_category_name=strtoupper($this->db->escape_str($this->input->post('sub_category_name')));
			$status=strtoupper($this->db->escape_str($this->input->post('status')));
			$data=$this->mastermodel->create_sub_category_name($grievance_id,$sub_category_name,$status,$user_id);
			$messge = array('status'=>$data['status'],'message' => $data['msg'],'class' => $data['class']);
			$this->session->set_flashdata('msg', $messge);
			redirect("masters/sub_category/$grievance_id");
		}else{
			redirect('/');
		}
	}


	public function update_sub_category_name(){
		$user_id = $this->session->userdata('user_id');
		$user_type = $this->session->userdata('user_type');
		if($user_type=='1' || $user_type=='2'){
			$grievance_id=$this->input->post('grievance_id');
			$sub_category_id=$this->input->post('sub_category_id');
			$sub_category_name=strtoupper($this->db->escape_str($this->input->post('sub_category_name')));
			$status=strtoupper($this->db->escape_str($this->input->post('status')));
			$data=$this->mastermodel->update_sub_category_name($grievance_id,$sub_category_name,$status,$user_id,$sub_category_id);
			$messge = array('status'=>$data['status'],'message' => $data['msg'],'class' => $data['class']);
			$this->session->set_flashdata('msg', $messge);
			redirect("masters/sub_category/$grievance_id");
		}else{
			redirect('/');
		}
	}

	#################### Grievance Sub category  ####################


	#################### Religion  ####################
	public function religion()
	{
		$user_id = $this->session->userdata('user_id');
		$user_type = $this->session->userdata('user_type');
		if($user_type=='1' || $user_type=='2'){
			$data['res']=$this->mastermodel->get_religion();
			$this->load->view('admin/header');
			$this->load->view('admin/masters/religion',$data);
			$this->load->view('admin/footer');
		}else{
			redirect('/');
		}
	}
	#################### Religion  ####################

	#################### SMS template  ####################
	public function sms_template()
	{
		$user_id = $this->session->userdata('user_id');
		$user_type = $this->session->userdata('user_type');
		if($user_type=='1' || $user_type=='2'){
			$data['res']=$this->mastermodel->get_sms_template();
			$this->load->view('admin/header');
			$this->load->view('admin/masters/sms_template',$data);
			$this->load->view('admin/footer');
		}else{
			redirect('/');
		}
	}


	public function create_sms_template(){
		$user_id = $this->session->userdata('user_id');
		$user_type = $this->session->userdata('user_type');
		if($user_type=='1' || $user_type=='2'){
			$template_type=strtoupper($this->db->escape_str($this->input->post('template_type')));
			$sms_text=strtoupper($this->db->escape_str($this->input->post('sms_text')));
			$sms_title=strtoupper($this->db->escape_str($this->input->post('sms_title')));
			$status=strtoupper($this->db->escape_str($this->input->post('status')));
			$data=$this->mastermodel->create_sms_template($template_type,$sms_title,$sms_text,$status,$user_id);
			$messge = array('status'=>$data['status'],'message' => $data['msg'],'class' => $data['class']);
			$this->session->set_flashdata('msg', $messge);
			redirect("masters/sms_template");
		}else{
			redirect('/');
		}
	}


	public function update_sms_template(){
		$user_id = $this->session->userdata('user_id');
		$user_type = $this->session->userdata('user_type');
		if($user_type=='1' || $user_type=='2'){
			$template_type=strtoupper($this->db->escape_str($this->input->post('template_type')));
			$template_id=$this->input->post('template_id');
			$sms_text=strtoupper($this->db->escape_str($this->input->post('sms_text')));
			$sms_title=strtoupper($this->db->escape_str($this->input->post('sms_title')));
			$status=strtoupper($this->db->escape_str($this->input->post('status')));
			$data=$this->mastermodel->update_sms_template($template_type,$sms_title,$sms_text,$status,$user_id,$template_id);
			$messge = array('status'=>$data['status'],'message' => $data['msg'],'class' => $data['class']);
			$this->session->set_flashdata('msg', $messge);
			redirect("masters/sms_template");
		}else{
			redirect('/');
		}
	}


	public function get_sms_template_edit(){
		$user_id = $this->session->userdata('user_id');
		$user_type = $this->session->userdata('user_type');
		if($user_type=='1' || $user_type=='2'){
			$template_id=$this->uri->segment(3);
			$data['res']=$this->mastermodel->get_sms_template_edit($template_id);
			$this->load->view('admin/header');
			$this->load->view('admin/masters/update_template',$data);
			$this->load->view('admin/footer');
		}else{
			redirect('/');
		}
	}
	#################### SMS template  ####################


	#################### Interaction question  ####################
	public function interaction()
	{
		$user_id = $this->session->userdata('user_id');
		$user_type = $this->session->userdata('user_type');
		if($user_type=='1' || $user_type=='2'){
			$data['res']=$this->mastermodel->get_interaction_question();
			$this->load->view('admin/header');
			$this->load->view('admin/masters/interaction',$data);
			$this->load->view('admin/footer');
		}else{
			redirect('/');
		}
	}

	public function get_interaction_question_edit(){
		$user_id = $this->session->userdata('user_id');
		$user_type = $this->session->userdata('user_type');
		if($user_type=='1' || $user_type=='2'){
			$interaction_id=$this->uri->segment(3);
			$data['res']=$this->mastermodel->get_interaction_question_edit($interaction_id);
			$this->load->view('admin/header');
			$this->load->view('admin/masters/update_interaction',$data);
			$this->load->view('admin/footer');
		}else{
			redirect('/');
		}
	}


	public function create_interaction_question(){
		$user_id = $this->session->userdata('user_id');
		$user_type = $this->session->userdata('user_type');
		if($user_type=='1' || $user_type=='2'){
			$interaction_text=strtoupper($this->db->escape_str($this->input->post('interaction_text')));
			$widgets_title=strtoupper($this->db->escape_str($this->input->post('widgets_title')));
			$status=strtoupper($this->db->escape_str($this->input->post('status')));
			$data=$this->mastermodel->create_interaction_question($widgets_title,$interaction_text,$status,$user_id);
			$messge = array('status'=>$data['status'],'message' => $data['msg'],'class' => $data['class']);
			$this->session->set_flashdata('msg', $messge);
			redirect("masters/interaction");
		}else{
			redirect('/');
		}
	}



	public function update_interaction_question(){
		$user_id = $this->session->userdata('user_id');
		$user_type = $this->session->userdata('user_type');
		if($user_type=='1' || $user_type=='2'){
			$interaction_text=strtoupper($this->db->escape_str($this->input->post('interaction_text')));
			$widgets_title=strtoupper($this->db->escape_str($this->input->post('widgets_title')));
			$interaction_id=$this->input->post('interaction_id');
			$status=strtoupper($this->db->escape_str($this->input->post('status')));
			$data=$this->mastermodel->update_interaction_question($widgets_title,$interaction_text,$status,$user_id,$interaction_id);
			$messge = array('status'=>$data['status'],'message' => $data['msg'],'class' => $data['class']);
			$this->session->set_flashdata('msg', $messge);
			redirect("masters/interaction");
		}else{
			redirect('/');
		}
	}

	#################### Interaction question  ####################

	#################### Festival  ####################


	public function festival()
	{
		$user_id = $this->session->userdata('user_id');
		$user_type = $this->session->userdata('user_type');
		if($user_type=='1' || $user_type=='2'){
			$data['res']=$this->mastermodel->get_all_festival();
			$data['res_religion']=$this->mastermodel->get_religion();
			$this->load->view('admin/header');
			$this->load->view('admin/masters/festival',$data);
			$this->load->view('admin/footer');
		}else{
			redirect('/');
		}
	}

	public function create_festival(){
		$user_id = $this->session->userdata('user_id');
		$user_type = $this->session->userdata('user_type');
		if($user_type=='1' || $user_type=='2'){
			$festival_name=strtoupper($this->db->escape_str($this->input->post('festival_name')));
			$religion_id=strtoupper($this->db->escape_str($this->input->post('religion_id')));
			$status=strtoupper($this->db->escape_str($this->input->post('status')));
			$data=$this->mastermodel->create_festival($festival_name,$religion_id,$status,$user_id);
			$messge = array('status'=>$data['status'],'message' => $data['msg'],'class' => $data['class']);
			$this->session->set_flashdata('msg', $messge);
			redirect("masters/festival");
		}else{
			redirect('/');
		}
	}


	public function update_festival(){
		$user_id = $this->session->userdata('user_id');
		$user_type = $this->session->userdata('user_type');
		if($user_type=='1' || $user_type=='2'){
			$festival_name=strtoupper($this->db->escape_str($this->input->post('festival_name')));
			$fm_id=strtoupper($this->db->escape_str($this->input->post('fm_id')));
			$religion_id=strtoupper($this->db->escape_str($this->input->post('religion_id')));
			$status=strtoupper($this->db->escape_str($this->input->post('status')));
			$data=$this->mastermodel->update_festival($festival_name,$religion_id,$status,$user_id,$fm_id);
			$messge = array('status'=>$data['status'],'message' => $data['msg'],'class' => $data['class']);
			$this->session->set_flashdata('msg', $messge);
			redirect("masters/festival");
		}else{
			redirect('/');
		}
	}
	public function get_festival_edit(){
		$user_id = $this->session->userdata('user_id');
		$user_type = $this->session->userdata('user_type');
		if($user_type=='1' || $user_type=='2'){
			$fm_id=$this->uri->segment(3);
			$data['res']=$this->mastermodel->get_festival_edit($fm_id);
			$data['res_religion']=$this->mastermodel->get_religion();
			$this->load->view('admin/header');
			$this->load->view('admin/masters/update_festival',$data);
			$this->load->view('admin/footer');
		}else{
			redirect('/');
		}
	}

	#################### Festival  ####################

	#################### Constituent purpose active data  ####################

	public function get_active_ward(){
		$paguthi_id=$this->input->post('paguthi_id');
		$data['res']=$this->mastermodel->get_active_ward($paguthi_id);
		echo json_encode($data['res']);
	}

	public function get_active_office(){
		$paguthi_id=$this->input->post('paguthi_id');
		$data['res']=$this->mastermodel->get_active_office($paguthi_id);
		echo json_encode($data['res']);
	}




	public function get_active_ward_office(){
		$paguthi_id=$this->input->post('paguthi_id');
		$data['res']=$this->mastermodel->get_active_ward_office($paguthi_id);
		echo json_encode($data['res']);
	}

	public function get_active_booth(){
		$ward_id=$this->input->post('ward_id');
		$data['res']=$this->mastermodel->get_active_booth($ward_id);
		echo json_encode($data['res']);
	}

		public function get_booth_address(){
			$booth_id=$this->input->post('booth_id');
			$data['res']=$this->mastermodel->get_booth_address($booth_id);
			echo json_encode($data['res']);
		}

		public function get_grievance_active(){
			$seeker_id=$this->input->post('seeker_id');
			$data['res']=$this->mastermodel->get_grievance_active($seeker_id);
			echo json_encode($data['res']);

		}
		public function get_active_sub_category(){
			$grievance_id=$this->input->post('grievance_id');
			$data['res']=$this->mastermodel->get_active_sub_category($grievance_id);
			echo json_encode($data['res']);

		}

		public function get_ward_paguthi_details(){
			$booth_id=$this->input->post('booth_id');
			$data['res']=$this->mastermodel->get_ward_paguthi_details($booth_id);
			echo json_encode($data['res']);
		}

	#################### Constituent purpose active data  ####################


}
