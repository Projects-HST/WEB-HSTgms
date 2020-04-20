<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	function __construct() {
		 parent::__construct();
			$this->load->helper("url");
			$this->load->library('session');
 }


	public function index()
	{
		$this->load->view('login');
	}
	public function dashboard()
	{
		$this->load->view('admin/header');
		$this->load->view('admin/dashboard');
		$this->load->view('admin/footer');
	}

	public function form()
	{
		$this->load->view('admin/header');
		$this->load->view('admin/form');
		$this->load->view('admin/footer');
	}
	public function table()
	{
		$this->load->view('admin/header');
		$this->load->view('admin/table');
		$this->load->view('admin/footer');
	}
}
