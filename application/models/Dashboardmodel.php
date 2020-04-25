<?php
Class Dashboardmodel extends CI_Model
{
	public function __construct()
	{
	  parent::__construct();
		//$this->load->model('mailmodel');
		//$this->load->model('smsmodel');
	}

	function get_dashboard_reult($paguthi)
	{
		if ($paguthi == 'All')
		{
			echo "All";
		} else {
			echo $paguthi;
		}
		
		//echo $query;
		//$resultset=$this->db->query($query);
		//return $resultset->result();
	}
	
	function get_search_reult($keyword)
	{
			echo $keyword;
		
		//echo $query;
		//$resultset=$this->db->query($query);
		//return $resultset->result();
	}


	
}
?>
