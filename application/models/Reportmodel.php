<?php
Class Reportmodel extends CI_Model
{
	public function __construct()
	{
	  parent::__construct();
		//$this->load->model('mailmodel');
		//$this->load->model('smsmodel');
	}

	function get_status_report($frmDate,$toDate,$status,$paguthi,$ward_id)
	{
		$dateTime1 = new DateTime($frmDate);
		$from_date=date_format($dateTime1,'Y-m-d' );

		$dateTime2 = new DateTime($toDate);
		$to_date=date_format($dateTime2,'Y-m-d' );

		if(empty($frmDate) && empty($toDate) && empty($status) && empty($paguthi) && empty($ward_id)){
			$query="SELECT g.*,c.full_name,c.mobile_no,u.full_name as created_by,gt.grievance_name FROM grievance as g
			left join constituent as c on c.id=g.constituent_id
			left join user_master as u on g.created_by=u.id
			left join grievance_type as gt on gt.id=g.grievance_type_id
			where g.grievance_date >= last_day(now()) + interval 1 day - interval 3 month";

		}else{

			if($status=='ALL'){
				$quer_status=' ';
			}else{
				$quer_status="AND g.status='$status'";
			}
			if($paguthi=='ALL'){
				$quer_pagu='';
			}else{
				$quer_pagu="AND g.paguthi_id='$paguthi'";
			}
			if(empty($ward_id)){
				$query_war='';
			}else{
				$query_war="AND c.ward_id='$ward_id'";
			}
			$query="SELECT g.*,c.full_name,c.mobile_no,u.full_name as created_by,gt.grievance_name FROM grievance as g
			left join constituent as c on c.id=g.constituent_id
			left join user_master as u on g.created_by=u.id
			left join grievance_type as gt on gt.id=g.grievance_type_id
			where (g.grievance_date BETWEEN '$from_date' AND '$to_date') $quer_status $quer_pagu $query_war";

		}
		$resultset=$this->db->query($query);
		return $resultset->result();

	}


	function get_category_report($frmDate,$toDate,$category,$sub_category_id,$paguthi,$ward_id)
	{
		$dateTime1 = new DateTime($frmDate);
		$from_date=date_format($dateTime1,'Y-m-d' );

		$dateTime2 = new DateTime($toDate);
		$to_date=date_format($dateTime2,'Y-m-d' );

		if(empty($frmDate) && empty($toDate) && empty($category) && empty($paguthi) && empty($ward_id)){
			$query="SELECT g.*,c.full_name,c.mobile_no,u.full_name as created_by,gt.grievance_name FROM grievance as g
			left join constituent as c on c.id=g.constituent_id
			left join user_master as u on g.created_by=u.id
			left join grievance_type as gt on gt.id=g.grievance_type_id
			where g.grievance_date >= last_day(now()) + interval 1 day - interval 3 month";

		}else{

			if($category=='ALL'){
				$quer_status=' ';
			}else{
				$quer_status="AND g.grievance_type_id='$category'";
			}
			if($paguthi=='ALL'){
				$quer_pagu='';
			}else{
				$quer_pagu="AND g.paguthi_id='$paguthi'";
			}
			if(empty($ward_id)){
				$query_war='';
			}else{
				$query_war="AND c.ward_id='$ward_id'";
			}
			if(empty($sub_category_id)){
				$query_sub='';
			}else{
				$query_sub="AND g.sub_category_id='$sub_category_id'";
			}
			$query="SELECT g.*,c.full_name,c.mobile_no,u.full_name as created_by,gt.grievance_name FROM grievance as g
			left join constituent as c on c.id=g.constituent_id
			left join user_master as u on g.created_by=u.id
			left join grievance_type as gt on gt.id=g.grievance_type_id
			where (g.grievance_date BETWEEN '$from_date' AND '$to_date') $quer_status $quer_pagu $query_war $query_sub";

		}
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

	function get_location_report($frmDate,$toDate,$paguthi,$ward_id)
	{
		$dateTime1 = new DateTime($frmDate);
		$from_date=date_format($dateTime1,'Y-m-d' );

		$dateTime2 = new DateTime($toDate);
		$to_date=date_format($dateTime2,'Y-m-d' );

		if(empty($frmDate) && empty($toDate) && empty($paguthi) && empty($ward_id)){
			$query="SELECT g.*,c.full_name,c.mobile_no,u.full_name as created_by,gt.grievance_name FROM grievance as g
			left join constituent as c on c.id=g.constituent_id
			left join user_master as u on g.created_by=u.id
			left join grievance_type as gt on gt.id=g.grievance_type_id
			where g.grievance_date >= last_day(now()) + interval 1 day - interval 3 month";

		}else{


			if($paguthi=='ALL'){
				$quer_pagu='';
			}else{
				$quer_pagu="AND g.paguthi_id='$paguthi'";
			}
			if(empty($ward_id)){
				$query_war='';
			}else{
				$query_war="AND c.ward_id='$ward_id'";
			}

			$query="SELECT g.*,c.full_name,c.mobile_no,u.full_name as created_by,gt.grievance_name FROM grievance as g
			left join constituent as c on c.id=g.constituent_id
			left join user_master as u on g.created_by=u.id
			left join grievance_type as gt on gt.id=g.grievance_type_id
			where (g.grievance_date BETWEEN '$from_date' AND '$to_date')  $quer_pagu $query_war";

		}


		$resultset=$this->db->query($query);
		return $resultset->result();
	}

	function get_meeting_report($frmDate,$toDate,$status,$paguthi,$ward_id)
	{
		$dateTime1 = new DateTime($frmDate);
		$from_date=date_format($dateTime1,'Y-m-d' );

		$dateTime2 = new DateTime($toDate);
		$to_date=date_format($dateTime2,'Y-m-d' );

		if(empty($frmDate) && empty($toDate) && empty($paguthi) && empty($ward_id)){
			$query="SELECT mr.*,c.full_name,c.mobile_no,u.full_name as created_by from  meeting_request as mr
			left join constituent as c on c.id=mr.constituent_id
			left join user_master as u on u.id=mr.created_by
			where mr.meeting_date >= last_day(now()) + interval 1 day - interval 3 month";

		}else{

			if($status=='ALL'){
				$quer_status=' ';
			}else{
				$quer_status="AND mr.meeting_status='$status'";
			}
			if($paguthi=='ALL'){
				$quer_pagu='';
			}else{
				$quer_pagu="AND g.paguthi_id='$paguthi'";
			}
			if(empty($ward_id)){
				$query_war='';
			}else{
				$query_war="AND c.ward_id='$ward_id'";
			}

		  $query="SELECT mr.*,c.full_name,c.mobile_no,u.full_name as created_by from  meeting_request as mr
			left join constituent as c on c.id=mr.constituent_id
			left join user_master as u on u.id=mr.created_by
			where (mr.meeting_date BETWEEN '$from_date' AND '$to_date')  $quer_status $quer_pagu $query_war";


		}

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

	/* // Fetch records
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
    } */

	// Fetch records
	public function getData($rowno,$rowperpage,$search="") {

		$this->db->select('*');
		$this->db->from('constituent');

		if($search != ''){
				$this->db->like('full_name', $search);
				$this->db->or_like('father_husband_name', $search);
				$this->db->or_like('guardian_name', $search);
				$this->db->or_like('mobile_no', $search);
				$this->db->or_like('whatsapp_no', $search);
				$this->db->or_like('address', $search);
				$this->db->or_like('pin_code', $search);
				$this->db->or_like('email_id', $search);
				$this->db->or_like('voter_id_no', $search);
				$this->db->or_like('aadhaar_no', $search);
				$this->db->or_like('serial_no', $search);
		}
		$this->db->limit($rowperpage, $rowno);
		$query = $this->db->get();

		return $query->result_array();
  }

  // Select total records
	public function getrecordCount($search = '') {

		$this->db->select('count(*) as allcount');
		$this->db->from('constituent');

		if($search != ''){
				$this->db->like('full_name', $search);
				$this->db->or_like('father_husband_name', $search);
				$this->db->or_like('guardian_name', $search);
				$this->db->or_like('mobile_no', $search);
				$this->db->or_like('whatsapp_no', $search);
				$this->db->or_like('address', $search);
				$this->db->or_like('pin_code', $search);
				$this->db->or_like('email_id', $search);
				$this->db->or_like('voter_id_no', $search);
				$this->db->or_like('aadhaar_no', $search);
				$this->db->or_like('serial_no', $search);
		}

		$query = $this->db->get();
		$result = $query->result_array();

		return $result[0]['allcount'];
  }



			function return_query()
			{
				return $this->_compile_select();
			}

		function fetch_festival_data($rowno,$rowperpage,$search="",$paguthi,$ward_id,$religion_id) {
			$this->db->select('c.*,f.constituent_id as sent_status,f.festival_id as sent_festival_id');
			$this->db->from('constituent as c');


			if(empty($religion_id)){
				$this->db->join('festival_wishes as f', 'f.constituent_id = c.id', 'left');
			}else{
				$this->db->join('festival_wishes as f', 'f.constituent_id = c.id and f.festival_id='.$religion_id, 'left');
				$this->db->join('festival_master as fm', 'fm.religion_id = c.religion_id', 'left');
				// $this->db->or_where('fm.id',$religion_id);
				$this->db->where('fm.id',$religion_id);

			}
			if(empty($paguthi)){

			}else{
				$this->db->or_where('c.paguthi_id',$paguthi);
			}
			if(empty($ward_id)){

			}else{
				$this->db->or_where('c.ward_id',$ward_id);
			}



			$this->db->group_by('c.id');
			// echo $this->db->get_compiled_select(); // before $this->db->get();
			// exit;
			$this->db->limit($rowperpage, $rowno);
			$query = $this->db->get();
			return $query->result_array();

		 }


		 function sent_festival_wishes($cons_id,$festival_id,$user_id){
			 $insert="INSERT INTO festival_wishes (constituent_id,festival_id,sent_status,updated_by,updated_at) VALUES ('$cons_id','$festival_id','SENT','$user_id',NOW())";
			 $result=$this->db->query($insert);
			 if($result){
				 echo "success";
			 }else{
				 echo "failure";
			 }
		 }


		 function fetch_festival_wishes_report($rowno,$rowperpage,$search="",$paguthi,$ward_id,$religion_id) {
 			$this->db->select('c.*,fm.festival_name,fw.updated_at as sent_on');
 			$this->db->from('festival_wishes as fw');
			$this->db->join('festival_master as fm', 'fm.id = fw.festival_id', 'left');
			$this->db->join('constituent as c', 'c.id = fw.constituent_id', 'left');
 			if(empty($religion_id)){

 			}else{
 				$this->db->or_where('fm.id',$religion_id);
 			}
 			if(empty($paguthi)){

 			}else{
 				$this->db->or_where('c.paguthi_id',$paguthi);
 			}
 			if(empty($ward_id)){

 			}else{
 				$this->db->or_where('c.ward_id',$ward_id);
 			}
 			// echo $this->db->get_compiled_select(); // before $this->db->get();
 			// exit;
 			$this->db->limit($rowperpage, $rowno);
 			$query = $this->db->get();
 			return $query->result_array();

 		 }


		 function constituent_list($rowno,$rowperpage,$paguthi,$ward_id,$whatsapp_no,$mobile_no,$email_id){
			 $this->db->select('c.*');
 			$this->db->from('constituent as c');
 			if(empty($paguthi)){

 			}else{
 				$this->db->or_where('c.paguthi_id',$paguthi);
 			}
 			if(empty($ward_id)){

 			}else{
 				$this->db->or_where('c.ward_id',$ward_id);
 			}
			if(empty($mobile_no)){

 			}else{
 				$this->db->or_where('c.mobile_no!=',0);
 			}
			if(empty($whatsapp_no)){

 			}else{
 				$this->db->or_where('c.whatsapp_no!=',0);
 			}
			if(empty($email_id)){

 			}else{
 				$this->db->or_where('c.email_id!=" "');
 			}

  			// echo $this->db->get_compiled_select(); // before $this->db->get();
  			// exit;
  			$this->db->limit($rowperpage, $rowno);
  			$query = $this->db->get();
  			return $query->result_array();

		 }



}
?>
