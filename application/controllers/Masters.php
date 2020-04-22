<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Masters extends CI_Controller {


	function __construct() {
		 parent::__construct();
			$this->load->helper("url");
			$this->load->library('session');
			$this->load->model('mastermodel');
 }

	public function constituency()
	{
	  $user_id = $this->session->userdata('user_id');
		$user_type = $this->session->userdata('user_type');
		if($user_type=='1'){
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
		if($user_type=='1'){
			$constituency_name=mb_strtoupper($this->input->post('constituency_name'));
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
		if($user_type=='1'){
			$data['res']=$this->mastermodel->get_paguthi();
			$this->load->view('admin/header');
			$this->load->view('admin/masters/paguthi',$data);
			$this->load->view('admin/footer');
		}else{
			redirect('/');
		}

	}


	public function checkpaguthi(){
		$paguthi_name=mb_strtoupper($this->input->post('paguthi_name'));
		$data=$this->mastermodel->checkpaguthi($paguthi_name);
	}
	public function checkpaguthishort(){
		$paguthi_short_name=mb_strtoupper($this->input->post('paguthi_short_name'));
		$data=$this->mastermodel->checkpaguthishort($paguthi_short_name);
	}

	public function checkpaguthiexist(){
		$paguthi_name=mb_strtoupper($this->input->post('paguthi_name'));
		$paguthi_id=$this->uri->segment(3);
		$data=$this->mastermodel->checkpaguthiexist($paguthi_name,$paguthi_id);
	}

	public function checkpaguthishortexist(){
		$paguthi_short_name=mb_strtoupper($this->input->post('paguthi_short_name'));
		$paguthi_id=$this->uri->segment(3);
		$data=$this->mastermodel->checkpaguthishortexist($paguthi_short_name,$paguthi_id);
	}

	public function get_paguthi_edit(){
		$user_id = $this->session->userdata('user_id');
		$user_type = $this->session->userdata('user_type');
		if($user_type=='1'){
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
		if($user_type=='1'){
			$paguthi_name=mb_strtoupper($this->input->post('paguthi_name'));
			$paguthi_short_name=mb_strtoupper($this->input->post('paguthi_short_name'));
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
		if($user_type=='1'){
			$paguthi_name=mb_strtoupper($this->input->post('paguthi_name'));
			$paguthi_short_name=mb_strtoupper($this->input->post('paguthi_short_name'));
			$status=mb_strtoupper($this->input->post('status'));
			$paguthi_id=mb_strtoupper($this->input->post('paguthi_id'));
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
		if($user_type=='1'){
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
		if($user_type=='1'){
			$paguthi_id=$this->input->post('paguthi_id');
			$ward_name=mb_strtoupper($this->input->post('ward_name'));
			$status=mb_strtoupper($this->input->post('status'));
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
		if($user_type=='1'){
			$paguthi_id=$this->input->post('paguthi_id');
			$ward_name=mb_strtoupper($this->input->post('ward_name'));
			$status=mb_strtoupper($this->input->post('status'));
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
		if($user_type=='1'){
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

	#################### Booth ####################
	public function booth()
	{
		$user_id = $this->session->userdata('user_id');
		$user_type = $this->session->userdata('user_type');
		if($user_type=='1'){
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
		if($user_type=='1'){
			$booth_name=mb_strtoupper($this->input->post('booth_name'));
			$ward_id=$this->input->post('ward_id');
			$booth_address=mb_strtoupper($this->input->post('booth_address'));
		  $status=mb_strtoupper($this->input->post('status'));
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
		if($user_type=='1'){
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
		if($user_type=='1'){
			$booth_name=mb_strtoupper($this->input->post('booth_name'));
			$ward_id=$this->input->post('ward_id');
			$booth_address=mb_strtoupper($this->input->post('booth_address'));
			$status=mb_strtoupper($this->input->post('status'));
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
			if($user_type=='1'){
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
			if($user_type=='1'){
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
			$seeker_info=mb_strtoupper($this->input->post('seeker_info'));
			$data=$this->mastermodel->checkseeker($seeker_info);
		}
		public function checkseekerexist(){
			$seeker_info=mb_strtoupper($this->input->post('seeker_info'));
			$seeker_id=$this->uri->segment(3);
			$data=$this->mastermodel->checkseekerexist($seeker_info,$seeker_id);
		}

		public function create_seeker(){
			$user_id = $this->session->userdata('user_id');
			$user_type = $this->session->userdata('user_type');
			if($user_type=='1'){
				$seeker_info=mb_strtoupper($this->input->post('seeker_info'));
				$status=mb_strtoupper($this->input->post('status'));
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
			if($user_type=='1'){
				$seeker_info=mb_strtoupper($this->input->post('seeker_info'));
				$status=mb_strtoupper($this->input->post('status'));
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
		if($user_type=='1'){
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
		if($user_type=='1'){
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
		if($user_type=='1'){
			$seeker_id=$this->input->post('seeker_id');
			$grievance_name=mb_strtoupper($this->input->post('grievance_name'));
			$status=mb_strtoupper($this->input->post('status'));
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
		if($user_type=='1'){
			$seeker_id=$this->input->post('seeker_id');
			$grievance_name=mb_strtoupper($this->input->post('grievance_name'));
				$grievance_id=$this->input->post('grievance_id');
			$status=mb_strtoupper($this->input->post('status'));
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
		if($user_type=='1'){
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
		if($user_type=='1'){
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
		if($user_type=='1'){
			$grievance_id=$this->input->post('grievance_id');
			$sub_category_name=mb_strtoupper($this->input->post('sub_category_name'));
			$status=mb_strtoupper($this->input->post('status'));
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
		if($user_type=='1'){
			$grievance_id=$this->input->post('grievance_id');
			$sub_category_id=$this->input->post('sub_category_id');
			$sub_category_name=mb_strtoupper($this->input->post('sub_category_name'));
			$status=mb_strtoupper($this->input->post('status'));
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
		if($user_type=='1'){
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
		if($user_type=='1'){
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
		if($user_type=='1'){
			$template_type=mb_strtoupper($this->input->post('template_type'));
			$sms_text=mb_strtoupper($this->input->post('sms_text'));
			$sms_title=mb_strtoupper($this->input->post('sms_title'));
			$status=mb_strtoupper($this->input->post('status'));
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
		if($user_type=='1'){
			$template_type=mb_strtoupper($this->input->post('template_type'));
			$template_id=$this->input->post('template_id');
			$sms_text=mb_strtoupper($this->input->post('sms_text'));
			$sms_title=mb_strtoupper($this->input->post('sms_title'));
			$status=mb_strtoupper($this->input->post('status'));
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
		if($user_type=='1'){
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
		if($user_type=='1'){
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
		if($user_type=='1'){
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
		if($user_type=='1'){
			$interaction_text=mb_strtoupper($this->input->post('interaction_text'));
			$status=mb_strtoupper($this->input->post('status'));
			$data=$this->mastermodel->create_interaction_question($interaction_text,$status,$user_id);
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
		if($user_type=='1'){
			$interaction_text=mb_strtoupper($this->input->post('interaction_text'));
			$interaction_id=$this->input->post('interaction_id');
			$status=mb_strtoupper($this->input->post('status'));
			$data=$this->mastermodel->update_interaction_question($interaction_text,$status,$user_id,$interaction_id);
			$messge = array('status'=>$data['status'],'message' => $data['msg'],'class' => $data['class']);
			$this->session->set_flashdata('msg', $messge);
			redirect("masters/interaction");
		}else{
			redirect('/');
		}
	}

	#################### Interaction question  ####################




}
