<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Masters extends CI_Controller {


	function __construct() {
		 parent::__construct();
			$this->load->helper("url");
			$this->load->library('session');
 }

	public function constituency()
	{
		$this->load->view('admin/header');
		$this->load->view('admin/masters/constituency');
		$this->load->view('admin/footer');
	}

	public function form()
	{
		$this->load->view('admin/header');
		$this->load->view('admin/form');
		$this->load->view('admin/footer');
	}
}
