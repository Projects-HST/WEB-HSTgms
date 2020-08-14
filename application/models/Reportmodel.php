<?php
Class Reportmodel extends CI_Model
{
	public function __construct()
	{
	  parent::__construct();
		//$this->load->model('mailmodel');
		//$this->load->model('smsmodel');
	}

	function get_status_report($rowno,$rowperpage,$frmDate,$toDate,$status,$paguthi,$ward_id)
	{

		$this->db->select('g.*,c.full_name,c.mobile_no,u.full_name as created_by,gt.grievance_name');
		$this->db->from('grievance as g');
		$this->db->join('constituent as c', 'g.constituent_id = c.id', 'left');
		$this->db->join('user_master as u', 'g.created_by = u.id', 'left');
		$this->db->join('grievance_type as gt', 'gt.id = g.grievance_type_id', 'left');
		if(empty($paguthi) || $paguthi=='ALL'){

		}else{
			$this->db->where('c.paguthi_id',$paguthi);
		}
		if(empty($ward_id)){

		}else{
			$this->db->where('c.ward_id',$ward_id);
		}
		if(empty($status) || $status=='ALL'){

		}else{
			$this->db->where('g.status',$status);
		}
		if(empty($frmDate)){
				$this->db->where('g.grievance_date >= last_day(now()) + interval 1 day - interval 3 month');
		}else{
			$dateTime1 = new DateTime($frmDate);
			$from_date=date_format($dateTime1,'Y-m-d' );

			$dateTime2 = new DateTime($toDate);
			$to_date=date_format($dateTime2,'Y-m-d' );
			$this->db->where('g.grievance_date >=', $from_date);
			$this->db->where('g.grievance_date <=', $to_date);
		}

		// echo $this->db->get_compiled_select(); // before $this->db->get();
		// exit;
		$this->db->limit($rowperpage, $rowno);
		$query = $this->db->get();
		return $query->result_array();


	}

	function get_count_status_report($frmDate,$toDate,$status,$paguthi,$ward_id){
		$this->db->select('count(*) as allcount');
		$this->db->from('grievance as g');
		$this->db->join('constituent as c', 'g.constituent_id = c.id', 'left');
		$this->db->join('user_master as u', 'g.created_by = u.id', 'left');
		$this->db->join('grievance_type as gt', 'gt.id = g.grievance_type_id', 'left');
		if(empty($paguthi) || $paguthi=='ALL'){

		}else{
			$this->db->where('c.paguthi_id',$paguthi);
		}
		if(empty($ward_id)){

		}else{
			$this->db->where('c.ward_id',$ward_id);
		}
		if(empty($status) || $status=='ALL'){

		}else{
			$this->db->where('g.status',$ward_id);
		}
		if(empty($frmDate)){
				$this->db->where('g.grievance_date >= last_day(now()) + interval 1 day - interval 3 month');
		}else{
			$dateTime1 = new DateTime($frmDate);
			$from_date=date_format($dateTime1,'Y-m-d' );

			$dateTime2 = new DateTime($toDate);
			$to_date=date_format($dateTime2,'Y-m-d' );
			$this->db->where('g.grievance_date >=', $from_date);
			$this->db->where('g.grievance_date <=', $to_date);
		}

		// echo $this->db->get_compiled_select(); // before $this->db->get();
		// exit;
		$query = $this->db->get();
		$result = $query->result_array();
		return $result[0]['allcount'];
	}

	function get_category_count($frmDate,$toDate,$category,$sub_category_id,$paguthi,$ward_id){
		$this->db->select('count(g.id) as allcount');
		$this->db->from('grievance as g');
		$this->db->join('constituent as c', 'g.constituent_id = c.id', 'left');
		$this->db->join('user_master as u', 'g.created_by = u.id', 'left');
		$this->db->join('grievance_type as gt', 'gt.id = g.grievance_type_id', 'left');
		if(empty($paguthi) || $paguthi=='ALL'){

		}else{
			$this->db->where('c.paguthi_id',$paguthi);
		}
		if(empty($ward_id)){

		}else{
			$this->db->where('c.ward_id',$ward_id);
		}
		if(empty($frmDate)){
				$this->db->where('g.grievance_date >= last_day(now()) + interval 1 day - interval 3 month');
		}else{
			$dateTime1 = new DateTime($frmDate);
			$from_date=date_format($dateTime1,'Y-m-d' );

			$dateTime2 = new DateTime($toDate);
			$to_date=date_format($dateTime2,'Y-m-d' );
			$this->db->where('g.grievance_date >=', $from_date);
			$this->db->where('g.grievance_date <=', $to_date);
		}
		if(empty($category) || $category=='ALL'){

		}else{
			$this->db->where('g.grievance_type_id',$category);
		}
		if(empty($sub_category_id)){

		}else{
			$this->db->where('g.sub_category_id',$sub_category_id);
		}
		// echo $this->db->get_compiled_select();
		// exit;
		$query = $this->db->get();
		$result = $query->result_array();
		return $result[0]['allcount'];
	}

	function get_category_report($rowno,$rowperpage,$frmDate,$toDate,$category,$sub_category_id,$paguthi,$ward_id)
	{

		$this->db->select('g.*,c.full_name,c.mobile_no,u.full_name as created_by,gt.grievance_name');
		$this->db->from('grievance as g');
		$this->db->join('constituent as c', 'g.constituent_id = c.id', 'left');
		$this->db->join('user_master as u', 'g.created_by = u.id', 'left');
		$this->db->join('grievance_type as gt', 'gt.id = g.grievance_type_id', 'left');
		if(empty($paguthi) || $paguthi=='ALL'){

		}else{
			$this->db->where('c.paguthi_id',$paguthi);
		}
		if(empty($ward_id)){

		}else{
			$this->db->where('c.ward_id',$ward_id);
		}
		if(empty($frmDate)){
				$this->db->where('g.grievance_date >= last_day(now()) + interval 1 day - interval 3 month');
		}else{
			$dateTime1 = new DateTime($frmDate);
			$from_date=date_format($dateTime1,'Y-m-d' );

			$dateTime2 = new DateTime($toDate);
			$to_date=date_format($dateTime2,'Y-m-d' );
			$this->db->where('g.grievance_date >=', $from_date);
			$this->db->where('g.grievance_date <=', $to_date);
		}
		if(empty($category) || $category=='ALL'){

		}else{
			$this->db->where('g.grievance_type_id',$category);
		}
		if(empty($sub_category_id)){

		}else{
			$this->db->where('g.sub_category_id',$sub_category_id);
		}
		// echo $this->db->get_compiled_select();
		// exit;
		$this->db->limit($rowperpage, $rowno);
		$query = $this->db->get();
		return $query->result_array();
	}



	function get_location_count($frmDate,$toDate,$paguthi,$ward_id){
		$this->db->select('count(g.id) as allcount');
		$this->db->from('grievance as g');
		$this->db->join('constituent as c', 'g.constituent_id = c.id', 'left');
		$this->db->join('user_master as u', 'g.created_by = u.id', 'left');
		$this->db->join('grievance_type as gt', 'gt.id = g.grievance_type_id', 'left');
		if(empty($paguthi) || $paguthi=='ALL'){

		}else{
			$this->db->where('c.paguthi_id',$paguthi);
		}
		if(empty($ward_id)){

		}else{
			$this->db->where('c.ward_id',$ward_id);
		}
		if(empty($frmDate)){
				$this->db->where('g.grievance_date >= last_day(now()) + interval 1 day - interval 3 month');
		}else{
			$dateTime1 = new DateTime($frmDate);
			$from_date=date_format($dateTime1,'Y-m-d' );

			$dateTime2 = new DateTime($toDate);
			$to_date=date_format($dateTime2,'Y-m-d' );
			$this->db->where('g.grievance_date >=', $from_date);
			$this->db->where('g.grievance_date <=', $to_date);
		}
		$query = $this->db->get();
		$result = $query->result_array();

		return $result[0]['allcount'];


	}

	function get_location_report($rowno,$rowperpage,$frmDate,$toDate,$paguthi,$ward_id)
	{

		$this->db->select('g.*,c.full_name,c.mobile_no,u.full_name as created_by,gt.grievance_name');
		$this->db->from('grievance as g');
		$this->db->join('constituent as c', 'g.constituent_id = c.id', 'left');
		$this->db->join('user_master as u', 'g.created_by = u.id', 'left');
		$this->db->join('grievance_type as gt', 'gt.id = g.grievance_type_id', 'left');
		if(empty($paguthi) || $paguthi=='ALL'){

		}else{
			$this->db->where('c.paguthi_id',$paguthi);
		}
		if(empty($ward_id)){

		}else{
			$this->db->where('c.ward_id',$ward_id);
		}
		if(empty($frmDate)){
				$this->db->where('g.grievance_date >= last_day(now()) + interval 1 day - interval 3 month');
		}else{
			$dateTime1 = new DateTime($frmDate);
			$from_date=date_format($dateTime1,'Y-m-d' );

			$dateTime2 = new DateTime($toDate);
			$to_date=date_format($dateTime2,'Y-m-d' );
			$this->db->where('g.grievance_date >=', $from_date);
			$this->db->where('g.grievance_date <=', $to_date);
		}

		// echo $this->db->get_compiled_select();
		// exit;
		$this->db->limit($rowperpage, $rowno);
		$query = $this->db->get();
		return $query->result_array();
	}

	function get_meeting_count($frmDate,$toDate,$status,$paguthi,$ward_id){
		$this->db->select('count(mr.id) as allcount');
		$this->db->from('meeting_request as mr');
		$this->db->join('constituent as c', 'mr.constituent_id = c.id', 'left');
		$this->db->join('user_master as u', 'mr.created_by = u.id', 'left');
		if(empty($paguthi) || $paguthi=='ALL'){

		}else{
			$this->db->where('c.paguthi_id',$paguthi);
		}
		if(empty($ward_id)){

		}else{
			$this->db->where('c.ward_id',$ward_id);
		}
		if(empty($status) || $status=='ALL'){

		}else{
			$this->db->where('mr.meeting_status',$status);
		}
		if(empty($frmDate)){
				$this->db->where('mr.meeting_date >= last_day(now()) + interval 1 day - interval 3 month');
		}else{
			$dateTime1 = new DateTime($frmDate);
			$from_date=date_format($dateTime1,'Y-m-d' );

			$dateTime2 = new DateTime($toDate);
			$to_date=date_format($dateTime2,'Y-m-d' );
			$this->db->where('mr.meeting_date >=', $from_date);
			$this->db->where('mr.meeting_date <=', $to_date);
		}

		// echo $this->db->get_compiled_select(); // before $this->db->get();
		// exit;
		$query = $this->db->get();
		$result = $query->result_array();

		return $result[0]['allcount'];
	}

	function get_meeting_report($rowno,$rowperpage,$frmDate,$toDate,$status,$paguthi,$ward_id)
	{
		$this->db->select('mr.*,c.full_name,c.mobile_no,u.full_name as created_by');
		$this->db->from('meeting_request as mr');
		$this->db->join('constituent as c', 'mr.constituent_id = c.id', 'left');
		$this->db->join('user_master as u', 'mr.created_by = u.id', 'left');
		if(empty($paguthi) || $paguthi=='ALL'){

		}else{
			$this->db->where('c.paguthi_id',$paguthi);
		}
		if(empty($ward_id)){

		}else{
			$this->db->where('c.ward_id',$ward_id);
		}
		if(empty($status) || $status=='ALL'){

		}else{
			$this->db->where('mr.meeting_status',$status);
		}
		if(empty($frmDate)){
				$this->db->where('mr.meeting_date >= last_day(now()) + interval 1 day - interval 3 month');
		}else{
			$dateTime1 = new DateTime($frmDate);
			$from_date=date_format($dateTime1,'Y-m-d' );

			$dateTime2 = new DateTime($toDate);
			$to_date=date_format($dateTime2,'Y-m-d' );
			$this->db->where('mr.meeting_date >=', $from_date);
			$this->db->where('mr.meeting_date <=', $to_date);
		}

		// echo $this->db->get_compiled_select(); // before $this->db->get();
		// exit;
		$this->db->limit($rowperpage, $rowno);
		$query = $this->db->get();
		return $query->result_array();

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

	function get_birthday_report($rowno,$rowperpage,$year_id,$month_id,$paguthi,$ward_id)
	{
		$this->db->select('bw.*,c.full_name,c.mobile_no,c.whatsapp_no,c.email_id,c.address,c.dob,c.pin_code,c.door_no');
		$this->db->from('consitutent_birthday_wish as bw');
		$this->db->join('constituent as c', 'c.id = bw.constituent_id', 'left');
		if(empty($year_id)){
			$this->db->where('DATE(bw.created_at) >= last_day(now()) + interval 1 day - interval 3 month');
		}else{
			$this->db->where('YEAR(bw.created_at)',$year_id);
		}
		if(empty($month_id)){

		}else{
			$this->db->where('MONTH(bw.created_at)',$month_id);
		}
		if(empty($paguthi) || $paguthi=="ALL"){

		}else{
			$this->db->where('c.paguthi_id',$paguthi);
		}
		if(empty($ward_id)){

		}else{
			$this->db->where('c.ward_id',$ward_id);
		}
		// echo $this->db->get_compiled_select(); // before $this->db->get();
		// exit;
		$this->db->limit($rowperpage, $rowno);
		$query = $this->db->get();
		return $query->result_array();

	}

	function get_birthday_count($year_id,$month_id,$paguthi,$ward_id){
		$this->db->select('count(bw.id) as allcount');
		$this->db->from('consitutent_birthday_wish as bw');
		$this->db->join('constituent as c', 'c.id = bw.constituent_id', 'left');
		if(empty($year_id)){
			$this->db->where('DATE(bw.created_at) >= last_day(now()) + interval 1 day - interval 3 month');
		}else{
			$this->db->where('YEAR(bw.created_at)',$year_id);
		}
		if(empty($month_id)){

		}else{
			$this->db->where('MONTH(bw.created_at)',$month_id);
		}
		if(empty($paguthi) && $paguthi=='ALL'){

		}else{
			$this->db->where('c.paguthi_id',$paguthi);
		}
		if(empty($ward_id)){

		}else{
			$this->db->where('c.ward_id',$ward_id);
		}
		$query = $this->db->get();
		$result = $query->result_array();

		return $result[0]['allcount'];
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
				$this->db->where('c.paguthi_id',$paguthi);
			}
			if(empty($ward_id)){

			}else{
				$this->db->where('c.ward_id',$ward_id);
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


		 function fetch_festival_wishes_report($rowno,$rowperpage,$year_id,$paguthi,$ward_id,$religion_id) {
 			$this->db->select('c.*,fm.festival_name,fw.updated_at as sent_on');
 			$this->db->from('festival_wishes as fw');
			$this->db->join('festival_master as fm', 'fm.id = fw.festival_id', 'left');
			$this->db->join('constituent as c', 'c.id = fw.constituent_id', 'left');
 			if(empty($religion_id)){

 			}else{
 				$this->db->where('fm.id',$religion_id);
 			}
 			if(empty($paguthi)){

 			}else{
 				$this->db->where('c.paguthi_id',$paguthi);
 			}
 			if(empty($ward_id)){

 			}else{
 				$this->db->where('c.ward_id',$ward_id);
 			}
			if(empty($year_id)){
					$this->db->where('DATE(fw.updated_at) >= last_day(now()) + interval 1 day - interval 3 month');
			}else{
				$this->db->where('YEAR(fw.updated_at) >=',$year_id);
			}
 			// echo $this->db->get_compiled_select(); // before $this->db->get();
 			// exit;
 			$this->db->limit($rowperpage, $rowno);
 			$query = $this->db->get();
 			return $query->result_array();

 		 }

		 function get_festival_count($year_id,$religion_id,$paguthi,$ward_id){
			 $this->db->select('count(c.id) as allcount');
			 $this->db->from('festival_wishes as fw');
		 $this->db->join('festival_master as fm', 'fm.id = fw.festival_id', 'left');
		 $this->db->join('constituent as c', 'c.id = fw.constituent_id', 'left');
			 if(empty($religion_id)){

			 }else{
				 $this->db->or_where('fm.id',$religion_id);
			 }
			 if(empty($paguthi)){

			 }else{
				 $this->db->where('c.paguthi_id',$paguthi);
			 }
			 if(empty($ward_id)){

			 }else{
				 $this->db->where('c.ward_id',$ward_id);
			 }
			 $query = $this->db->get();
	 		$result = $query->result_array();

	 		return $result[0]['allcount'];
		 }


		 function get_video_report($rowno,$rowperpage,$paguthi,$ward_id){
			 $this->db->select('c.*,cv.video_title,cv.video_link,u.full_name as done_by,cv.updated_at');
			 $this->db->from('constituent_video as cv');
		 	 $this->db->join('constituent as c', 'c.id = cv.constituent_id', 'left');
			 $this->db->join('user_master as u', 'cv.updated_by = u.id', 'left');
			 if(empty($paguthi)){

			 }else{
				 $this->db->where('c.paguthi_id',$paguthi);
			 }
			 if(empty($ward_id)){

			 }else{
				 $this->db->where('c.ward_id',$ward_id);
			 }

			 // echo $this->db->get_compiled_select();
			 // exit;
			 $this->db->limit($rowperpage, $rowno);
			 $query = $this->db->get();
			 return $query->result_array();
		 }

		 function get_video_count($paguthi,$ward_id){
			 $this->db->select('count(cv.id) as allcount');
			 $this->db->from('constituent_video as cv');
		 	 $this->db->join('constituent as c', 'c.id = cv.constituent_id', 'left');
			 $this->db->join('user_master as u', 'cv.updated_by = u.id', 'left');
			 if(empty($paguthi)){

			 }else{
				 $this->db->where('c.paguthi_id',$paguthi);
			 }
			 if(empty($ward_id)){

			 }else{
				 $this->db->where('c.ward_id',$ward_id);
			 }
			 $query = $this->db->get();
	 		$result = $query->result_array();
	 		return $result[0]['allcount'];
		 }

		 function get_constituent_count($paguthi,$ward_id,$whatsapp_no,$mobile_no,$email_id){
			 	$this->db->select('count(c.id) as allcount');
				$this->db->from('constituent as c');
				if(empty($paguthi)){

				}else{
					$this->db->where('c.paguthi_id',$paguthi);
				}
				if(empty($ward_id)){

				}else{
					$this->db->where('c.ward_id',$ward_id);
				}
			if(empty($mobile_no)){

				}else{
					$this->db->where('c.mobile_no!=',0);
				}
			if(empty($whatsapp_no)){

				}else{
					$this->db->where('c.whatsapp_no!=',0);
				}
			if(empty($email_id)){

				}else{
					$this->db->where('c.email_id!=" "');
				}
				$query = $this->db->get();
				$result = $query->result_array();
				return $result[0]['allcount'];


		 }

		 function constituent_list($rowno,$rowperpage,$paguthi,$ward_id,$whatsapp_no,$mobile_no,$email_id){
			 $this->db->select('c.*');
 			$this->db->from('constituent as c');
 			if(empty($paguthi)){

 			}else{
 				$this->db->where('c.paguthi_id',$paguthi);
 			}
 			if(empty($ward_id)){

 			}else{
 				$this->db->where('c.ward_id',$ward_id);
 			}
			if(empty($mobile_no)){

 			}else{
 				$this->db->where('c.mobile_no!=',0);
 			}
			if(empty($whatsapp_no)){

 			}else{
 				$this->db->where('c.whatsapp_no!=',0);
 			}
			if(empty($email_id)){

 			}else{
 				$this->db->where('c.email_id!=" "');
 			}

  			// echo $this->db->get_compiled_select(); // before $this->db->get();
  			// exit;
  			$this->db->limit($rowperpage, $rowno);
  			$query = $this->db->get();
  			return $query->result_array();

		 }


	public function exportrecords($search = '') {

		$this->db->select('full_name,father_husband_name,mobile_no,door_no,address,pin_code,aadhaar_no,voter_id_no,serial_no,status');
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

		return $query->result_array();
  }


	function get_birthday_wish_year(){
		$query="SELECT YEAR(created_at)  as year_name FROM consitutent_birthday_wish GROUP BY year_name";
		$resultset=$this->db->query($query);
		return $resultset->result();
	}

	function get_festival_year(){
		$query="SELECT YEAR(updated_at)  as year_name FROM festival_wishes GROUP BY year_name";
		$resultset=$this->db->query($query);
		return $resultset->result();
	}
}
?>
