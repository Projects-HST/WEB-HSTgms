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
		
		if ($status=='ALL' && $paguthi == 'ALL')
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
		if ($status=='ALL' && $paguthi != 'ALL')
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
						A.constituent_id = B.id AND A.created_by = C.id AND A.grievance_type_id = D.id AND A.paguthi_id = '$paguthi' AND (`grievance_date` BETWEEN '$from_date' AND '$to_date') ORDER BY A.`grievance_date` DESC";
		}
		if ($status!='ALL' && $paguthi == 'ALL')
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
		if ($status!='ALL' && $paguthi != 'ALL')
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
						A.constituent_id = B.id AND A.created_by = C.id AND A.grievance_type_id = D.id AND A.status = '$status' AND A.paguthi_id = '$paguthi' AND (`grievance_date` BETWEEN '$from_date' AND '$to_date') ORDER BY A.`grievance_date` DESC";
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
		
		if ($category=='ALL')
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
		if ($category != 'ALL')
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
		
		if ($sub_category=='ALL')
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
		if ($sub_category != 'ALL')
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


		if ($paguthi=='ALL')
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
		if ($paguthi != 'ALL')
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
					A.constituent_id = B.id AND A.created_by = C.id AND A.grievance_type_id = D.id AND A.paguthi_id = '$paguthi' AND (`grievance_date` BETWEEN '$from_date' AND '$to_date') ORDER BY A.`grievance_date` DESC";
		}
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
					A.constituent_id = B.id AND A.created_by = C.id AND (A.meeting_date BETWEEN '$from_date' AND '$to_date'
					)
				ORDER BY
					 A.meeting_date DESC";
		//echo $query;
		$resultset=$this->db->query($query);
		return $resultset->result();
	}
	
	
	function meeting_update($meeting_id,$user_id,$frmDate,$toDate)
	{
		$update="UPDATE meeting_request SET meeting_status='COMPLETED',updated_at=NOW(),updated_by='$user_id' where id='$meeting_id'";
		$result=$this->db->query($update);
	
		if ($result) {
		   $this->session->set_flashdata('msg', 'You have just updated the meeting request!');
			redirect(base_url().'report/meetings/'.$frmDate.'/'.$toDate);
		} else {
		   $this->session->set_flashdata('msg', 'Failed to Update');
			redirect(base_url().'reportmeetings');
		}
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
				COUNT( CASE WHEN ct.status = 'ACTIVE' THEN 1 END ) AS active,
				COUNT( CASE WHEN ct.status = 'INACTIVE' THEN 1 END ) AS inactive
				FROM constituent AS	ct
				LEFT JOIN user_master AS um ON um.id = ct.created_by
				WHERE DATE(ct.created_at) BETWEEN '$from_date' AND '$to_date' GROUP BY ct.created_by";
		//echo $query;
		$resultset=$this->db->query($query);
		return $resultset->result();
	}
	
	function get_birthday_report($selMonth)
	{
				$year = date("Y"); 
				$query="SELECT * FROM constituent WHERE MONTH(dob) = '$selMonth'";
				$resultset=$this->db->query($query);
				if($resultset->num_rows()>0){
					foreach ($resultset->result() as $rows)
					{
						$const_id = $rows->id;
						$full_name = $rows->full_name;
						$dob = $rows->dob;
						$mobile_no = $rows->mobile_no;
						$door_no = $rows->door_no;
						$address = $rows->address;
						$pin_code = $rows->pin_code;
						
						$subQuery = "SELECT * FROM consitutent_birthday_wish WHERE YEAR(created_at)='$year' AND constituent_id = '$const_id'";
						$subQuery_result = $this->db->query($subQuery);
						if($subQuery_result->num_rows()>0){
							foreach ($subQuery_result->result() as $rows1)
							{
								$birth_id = $rows1->constituent_id;
							}
						}else{
							$birth_id = '';
						}
						
						if ($const_id == $birth_id){
							 $birth_wish = 'Send';
						} else {
							 $birth_wish = 'NotSend';
						}
						$contData[]  = (object) array(
								"const_id" => $const_id,
								"full_name" => $full_name,
								"dob" => $dob,
								"mobile_no" => $mobile_no,
								"door_no" => $door_no,
								"address" => $address,
								"pin_code" => $pin_code,
								"birth_wish_status" => $birth_wish,
						);
					} 
				}else {
						$contData = array();
				}
		return $contData;
	}
	
	function birthday_update($constituent_id,$user_id,$searchMonth)
	{
			$insert="INSERT INTO consitutent_birthday_wish (constituent_id,birthday_letter_status,created_by,created_at) VALUES ('$constituent_id','Send','$user_id',NOW())";
			$result=$this->db->query($insert);
		
			if ($result) {
               $this->session->set_flashdata('msg', 'You have just updated the birthday wishes!');
				redirect(base_url().'report/birthday/'.$searchMonth);
            } else {
               $this->session->set_flashdata('msg', 'Failed to Add');
				redirect(base_url().'report/birthday/'.$searchMonth);
            }
			
	}
	
	// Fetch records
	public function getData($rowno,$rowperpage) {		
		$this->db->select('*');
		$this->db->from('constituent');
		$this->db->limit($rowperpage, $rowno);   
		$query = $this->db->get();
       
		return $query->result_array();
	}

	// Select total records
    public function getrecordCount() {
      $this->db->select('count(*) as allcount');
      $this->db->from('constituent');
      $query = $this->db->get();
      $result = $query->result_array();
      
      return $result[0]['allcount'];
    }
	
}
?>
