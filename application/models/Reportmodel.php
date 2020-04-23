<?php
Class Reportmodel extends CI_Model
{
	public function __construct()
	{
	  parent::__construct();
		//$this->load->model('mailmodel');
		//$this->load->model('smsmodel');
	}



	function get_status_report($frmDate,$toDate,$status,$paguthi)
	{
		$dateTime1 = new DateTime($frmDate);
		$from_date=date_format($dateTime1,'Y-m-d' );
		
		$dateTime2 = new DateTime($toDate);
		$to_date=date_format($dateTime2,'Y-m-d' );
		
		if ($status=='All' && $paguthi == 'All')
		{
			$query="SELECT
						A.*,
						B.full_name,
						B.mobile_no,
						C.full_name AS created_by
					FROM
						grievance A,
						constituent B,
						user_master C
					WHERE
						A.constituent_id = B.id AND A.created_by = C.id AND (`grievance_date` BETWEEN '$from_date' AND '$to_date') ORDER BY A.`grievance_date` DESC";
		}
		if ($status=='All' && $paguthi != 'All')
		{
			$query="SELECT
						A.*,
						B.full_name,
						B.mobile_no,
						C.full_name AS created_by
					FROM
						grievance A,
						constituent B,
						user_master C
					WHERE
						A.constituent_id = B.id AND A.created_by = C.id AND A.pugathi_id = '$paguthi' AND (`grievance_date` BETWEEN '$from_date' AND '$to_date') ORDER BY A.`grievance_date` DESC";
		}
		if ($status!='All' && $paguthi == 'All')
		{
			$query="SELECT
						A.*,
						B.full_name,
						B.mobile_no,
						C.full_name AS created_by
					FROM
						grievance A,
						constituent B,
						user_master C
					WHERE
						A.constituent_id = B.id AND A.created_by = C.id AND A.status = '$status' AND (`grievance_date` BETWEEN '$from_date' AND '$to_date') ORDER BY A.`grievance_date` DESC";
		}
		if ($status!='All' && $paguthi != 'All')
		{
			$query="SELECT
						A.*,
						B.full_name,
						B.mobile_no,
						C.full_name AS created_by
					FROM
						grievance A,
						constituent B,
						user_master C
					WHERE
						A.constituent_id = B.id AND A.created_by = C.id AND A.status = '$status' AND A.pugathi_id = '$paguthi' AND (`grievance_date` BETWEEN '$from_date' AND '$to_date') ORDER BY A.`grievance_date` DESC";
		}
		//echo $query;
		$resultset=$this->db->query($query);
		return $resultset->result();
	}


function get_category_report($frmDate,$toDate,$category)
	{
		$dateTime1 = new DateTime($frmDate);
		$from_date=date_format($dateTime1,'Y-m-d' );
		
		$dateTime2 = new DateTime($toDate);
		$to_date=date_format($dateTime2,'Y-m-d' );
		
		if ($category=='All')
		{
			$query="SELECT
						A.*,
						B.full_name,
						B.mobile_no,
						C.full_name AS created_by
					FROM
						grievance A,
						constituent B,
						user_master C
					WHERE
						A.constituent_id = B.id AND A.created_by = C.id AND (`grievance_date` BETWEEN '$from_date' AND '$to_date') ORDER BY A.`grievance_date` DESC";
		}
		if ($category != 'All')
		{
			$query="SELECT
						A.*,
						B.full_name,
						B.mobile_no,
						C.full_name AS created_by
					FROM
						grievance A,
						constituent B,
						user_master C
					WHERE
						A.constituent_id = B.id AND A.created_by = C.id AND A.grievance_type_id = '$category' AND (`grievance_date` BETWEEN '$from_date' AND '$to_date') ORDER BY A.`grievance_date` DESC";
		}
		
		//echo $query;
		$resultset=$this->db->query($query);
		return $resultset->result();
	}
	
	function get_subcategory_report($frmDate,$toDate,$sub_category)
	{
		$dateTime1 = new DateTime($frmDate);
		$from_date=date_format($dateTime1,'Y-m-d' );
		
		$dateTime2 = new DateTime($toDate);
		$to_date=date_format($dateTime2,'Y-m-d' );
		
		if ($sub_category=='All')
		{
			$query="SELECT
						A.*,
						B.full_name,
						B.mobile_no,
						C.full_name AS created_by
					FROM
						grievance A,
						constituent B,
						user_master C
					WHERE
						A.constituent_id = B.id AND A.created_by = C.id AND (`grievance_date` BETWEEN '$from_date' AND '$to_date') ORDER BY A.`grievance_date` DESC";
		}
		if ($sub_category != 'All')
		{
			$query="SELECT
						A.*,
						B.full_name,
						B.mobile_no,
						C.full_name AS created_by
					FROM
						grievance A,
						constituent B,
						user_master C
					WHERE
						A.constituent_id = B.id AND A.created_by = C.id AND A.sub_category_id = '$sub_category' AND (`grievance_date` BETWEEN '$from_date' AND '$to_date') ORDER BY A.`grievance_date` DESC";
		}
		
		//echo $query;
		$resultset=$this->db->query($query);
		return $resultset->result();
	}
	
	function get_location_report($frmDate,$toDate,$paguthi)
	{
		$dateTime1 = new DateTime($frmDate);
		$from_date=date_format($dateTime1,'Y-m-d' );
		
		$dateTime2 = new DateTime($toDate);
		$to_date=date_format($dateTime2,'Y-m-d' );

		$query="SELECT
					A.*,
					B.full_name,
					B.mobile_no,
					C.full_name AS created_by
				FROM
					grievance A,
					constituent B,
					user_master C
				WHERE
					A.constituent_id = B.id AND A.created_by = C.id AND A. 	pugathi_id = '$paguthi' AND (`grievance_date` BETWEEN '$from_date' AND '$to_date') ORDER BY A.`grievance_date` DESC";
		//echo $query;
		$resultset=$this->db->query($query);
		return $resultset->result();
	}
}
?>
