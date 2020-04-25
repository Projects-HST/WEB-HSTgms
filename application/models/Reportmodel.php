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
						C.full_name AS created_by,
						D.grievance_name
					FROM
						grievance A,
						constituent B,
						user_master C,
						grievance_type D
					WHERE
						A.constituent_id = B.id AND A.created_by = C.id AND A.grievance_type_id = D.id AND (`grievance_date` BETWEEN '$from_date' AND '$to_date') ORDER BY A.`grievance_date` DESC";
		}
		if ($status=='All' && $paguthi != 'All')
		{
			$query="SELECT
						A.*,
						B.full_name,
						B.mobile_no,
						C.full_name AS created_by,
						D.grievance_name
					FROM
						grievance A,
						constituent B,
						user_master C,
						grievance_type D
					WHERE
						A.constituent_id = B.id AND A.created_by = C.id AND A.grievance_type_id = D.id AND A.pugathi_id = '$paguthi' AND (`grievance_date` BETWEEN '$from_date' AND '$to_date') ORDER BY A.`grievance_date` DESC";
		}
		if ($status!='All' && $paguthi == 'All')
		{
			$query="SELECT
						A.*,
						B.full_name,
						B.mobile_no,
						C.full_name AS created_by,
						D.grievance_name
					FROM
						grievance A,
						constituent B,
						user_master C,
						grievance_type D
					WHERE
						A.constituent_id = B.id AND A.created_by = C.id AND A.grievance_type_id = D.id AND A.status = '$status' AND (`grievance_date` BETWEEN '$from_date' AND '$to_date') ORDER BY A.`grievance_date` DESC";
		}
		if ($status!='All' && $paguthi != 'All')
		{
			$query="SELECT
						A.*,
						B.full_name,
						B.mobile_no,
						C.full_name AS created_by,
						D.grievance_name
					FROM
						grievance A,
						constituent B,
						user_master C,
						grievance_type D
					WHERE
						A.constituent_id = B.id AND A.created_by = C.id AND A.grievance_type_id = D.id AND A.status = '$status' AND A.pugathi_id = '$paguthi' AND (`grievance_date` BETWEEN '$from_date' AND '$to_date') ORDER BY A.`grievance_date` DESC";
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
						C.full_name AS created_by,
						D.grievance_name
					FROM
						grievance A,
						constituent B,
						user_master C,
						grievance_type D
					WHERE
						A.constituent_id = B.id AND A.created_by = C.id AND A.grievance_type_id = D.id AND (`grievance_date` BETWEEN '$from_date' AND '$to_date') ORDER BY A.`grievance_date` DESC";
		}
		if ($category != 'All')
		{
			$query="SELECT
						A.*,
						B.full_name,
						B.mobile_no,
						C.full_name AS created_by,
						D.grievance_name
					FROM
						grievance A,
						constituent B,
						user_master C,
						grievance_type D
					WHERE
						A.constituent_id = B.id AND A.created_by = C.id AND A.grievance_type_id = D.id AND A.grievance_type_id = '$category' AND (`grievance_date` BETWEEN '$from_date' AND '$to_date') ORDER BY A.`grievance_date` DESC";
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
						C.full_name AS created_by,
						D.sub_category_name
					FROM
						grievance A,
						constituent B,
						user_master C,
						grievance_sub_category D
					WHERE
						A.constituent_id = B.id AND A.created_by = C.id AND A.sub_category_id = D.id  AND (`grievance_date` BETWEEN '$from_date' AND '$to_date') ORDER BY A.`grievance_date` DESC";
		}
		if ($sub_category != 'All')
		{
			$query="SELECT
						A.*,
						B.full_name,
						B.mobile_no,
						C.full_name AS created_by,
						D.sub_category_name
					FROM
						grievance A,
						constituent B,
						user_master C,
						grievance_sub_category D
					WHERE
						A.constituent_id = B.id AND A.created_by = C.id AND A.sub_category_id = D.id AND A.sub_category_id = '$sub_category' AND (`grievance_date` BETWEEN '$from_date' AND '$to_date') ORDER BY A.`grievance_date` DESC";
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
					C.full_name AS created_by,
					D.grievance_name
				FROM
					grievance A,
					constituent B,
					user_master C,
					grievance_type D
				WHERE
					A.constituent_id = B.id AND A.created_by = C.id AND A.grievance_type_id = D.id AND A.pugathi_id = '$paguthi' AND (`grievance_date` BETWEEN '$from_date' AND '$to_date') ORDER BY A.`grievance_date` DESC";
		//echo $query;
		$resultset=$this->db->query($query);
		return $resultset->result();
	}
	
	function get_meeting_report($frmDate,$toDate)
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
					meeting_request A,
					constituent B,
					user_master C
				WHERE
					A.constituent_id = B.id AND A.created_by = C.id AND(
						DATE(A.created_at) BETWEEN '$from_date' AND '$to_date'
					)
				ORDER BY
					A.`created_at`
				DESC";
		//echo $query;
		$resultset=$this->db->query($query);
		return $resultset->result();
	}
	
	function get_staff_report($frmDate,$toDate)
	{
		$dateTime1 = new DateTime($frmDate);
		$from_date=date_format($dateTime1,'Y-m-d' );
		
		$dateTime2 = new DateTime($toDate);
		$to_date=date_format($dateTime2,'Y-m-d' );

		$query="SELECT
				um.id,
				um.full_name,
				COUNT(ct.created_by) AS total,
				COUNT(
					CASE WHEN ct.status = 'ACTIVE' THEN 1
				END
			) AS active,
			COUNT(
				CASE WHEN ct.status = 'INACTVIE' THEN 1
			END
			) AS inactive
			FROM constituent AS
				ct
			LEFT JOIN user_master AS um
			ON
				um.id = ct.created_by
			WHERE
				DATE(ct.created_at) BETWEEN '$from_date' AND '$to_date'
			GROUP BY
				ct.created_by";
		//echo $query;
		$resultset=$this->db->query($query);
		return $resultset->result();
	}
	
	function get_birthday_report($frmDate,$toDate)
	{
		$dateTime1 = new DateTime($frmDate);
		$from_date=date_format($dateTime1,'m' );
		
		$dateTime2 = new DateTime($toDate);
		$to_date=date_format($dateTime2,'m' );

		$query="SELECT * FROM constituent WHERE MONTH(dob) BETWEEN '$from_date' AND '$to_date'";
		$resultset=$this->db->query($query);
		return $resultset->result();
	}
}
?>
