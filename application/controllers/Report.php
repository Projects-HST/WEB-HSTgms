<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends CI_Controller {


	function __construct() {
		 parent::__construct();
			$this->load->helper("url");
			$this->load->library('session');
			$this->load->model('reportmodel');
 }

	public function status()
	{
		$user_id = $this->session->userdata('user_id');
		$user_type = $this->session->userdata('user_type');
		if($user_type=='1'){
			//$data['res']=$this->mastermodel->get_constituency();
			$this->load->view('admin/header');
			//$this->load->view('admin/report/status_report',$data);
			$this->load->view('admin/report/status_report');
			$this->load->view('admin/footer');
		}else{
			redirect('/');
		}

	}
	
	public function category()
	{
		$user_id = $this->session->userdata('user_id');
		$user_type = $this->session->userdata('user_type');
		if($user_type=='1'){
			//$data['res']=$this->mastermodel->get_constituency();
			$this->load->view('admin/header');
			//$this->load->view('admin/report/status_report',$data);
			$this->load->view('admin/report/category_report');
			$this->load->view('admin/footer');
		}else{
			redirect('/');
		}
	}


	public function sub_category()
	{
		$user_id = $this->session->userdata('user_id');
		$user_type = $this->session->userdata('user_type');
		if($user_type=='1'){
			//$data['res']=$this->mastermodel->get_constituency();
			$this->load->view('admin/header');
			//$this->load->view('admin/report/status_report',$data);
			$this->load->view('admin/report/subcategory_report');
			$this->load->view('admin/footer');
		}else{
			redirect('/');
		}
	}

	
	public function location()
	{
		$user_id = $this->session->userdata('user_id');
		$user_type = $this->session->userdata('user_type');
		if($user_type=='1'){
			//$data['res']=$this->mastermodel->get_constituency();
			$this->load->view('admin/header');
			//$this->load->view('admin/report/status_report',$data);
			$this->load->view('admin/report/location_report');
			$this->load->view('admin/footer');
		}else{
			redirect('/');
		}
	}

}
