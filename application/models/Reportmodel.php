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

		$this->db->select('g.*,c.full_name,c.mobile_no,c.father_husband_name,c.address,c.dob,c.door_no,c.pin_code,u.full_name as created_by,gt.grievance_name');
		$this->db->from('grievance as g');
		$this->db->join('constituent as c', 'g.constituent_id = c.id', 'left');
		$this->db->join('user_master as u', 'g.created_by = u.id', 'left');
		$this->db->join('grievance_type as gt', 'gt.id = g.grievance_type_id', 'left');
		if(empty($paguthi) || $paguthi=='ALL'){

		}else{
			$this->db->where('g.paguthi_id',$paguthi);
		}
		if(empty($ward_id)){

		}else{
			$this->db->where('g.office_id',$ward_id);
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
		//
		// echo $this->db->get_compiled_select();
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
			$this->db->where('g.paguthi_id',$paguthi);
		}
		if(empty($ward_id)){

		}else{
			$this->db->where('g.office_id',$ward_id);
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
		$query = $this->db->get();
		$result = $query->result_array();
		return $result[0]['allcount'];
	}

	function get_category_count($frmDate,$toDate,$g_seeker,$category,$sub_category_id,$paguthi,$ward_id){
		$this->db->select('count(g.id) as allcount');
		$this->db->from('grievance as g');
		$this->db->join('constituent as c', 'g.constituent_id = c.id', 'left');
		$this->db->join('user_master as u', 'g.created_by = u.id', 'left');
		$this->db->join('grievance_type as gt', 'gt.id = g.grievance_type_id', 'left');
		if(empty($paguthi) || $paguthi=='ALL'){

		}else{
			$this->db->where('g.paguthi_id',$paguthi);
		}
		if(empty($ward_id)){

		}else{
			$this->db->where('g.office_id',$ward_id);
		}
		if(empty($frmDate)){
				$this->db->where('g.grievance_date >= last_day(now()) + interval 1 day - interval 3 month');
		}else{
			// $dateTime1 = new DateTime($frmDate);
			// $from_date=date_format($dateTime1,'Y-m-d' );
			//
			// $dateTime2 = new DateTime($toDate);
			// $to_date=date_format($dateTime2,'Y-m-d' );
			$from_date=date("Y-m-d", strtotime($frmDate) );
			$to_date=date("Y-m-d", strtotime($toDate) );
			$this->db->where('g.grievance_date >=', $from_date);
			$this->db->where('g.grievance_date <=', $to_date);
		}
		if(empty($g_seeker) || $g_seeker=='ALL'){

		}else{
			$this->db->where('g.seeker_type_id',$g_seeker);
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

	function get_category_report($rowno,$rowperpage,$frmDate,$toDate,$g_seeker,$category,$sub_category_id,$paguthi,$ward_id)
	{

		$this->db->select('g.*,c.full_name,c.mobile_no,c.father_husband_name,c.address,c.dob,c.door_no,c.pin_code,u.full_name as created_by,gt.grievance_name');
		$this->db->from('grievance as g');
		$this->db->join('constituent as c', 'g.constituent_id = c.id', 'left');
		$this->db->join('user_master as u', 'g.created_by = u.id', 'left');
		$this->db->join('grievance_type as gt', 'gt.id = g.grievance_type_id', 'left');
		if(empty($paguthi) || $paguthi=='ALL'){

		}else{
			$this->db->where('g.paguthi_id',$paguthi);
		}
		if(empty($ward_id)){

		}else{
			$this->db->where('g.office_id',$ward_id);
		}

		if(empty($frmDate)){
				$this->db->where('g.grievance_date >= last_day(now()) + interval 1 day - interval 3 month');
		}else{
			// $dateTime1 = new DateTime($frmDate);
			// $from_date=date_format($dateTime1,'Y-m-d' );
			//
			// $dateTime2 = new DateTime($toDate);
			// $to_date=date_format($dateTime2,'Y-m-d' );
			$from_date=date("Y-m-d", strtotime($frmDate) );
			$to_date=date("Y-m-d", strtotime($toDate) );
			$this->db->where('g.grievance_date >=', $from_date);
			$this->db->where('g.grievance_date <=', $to_date);
		}
		if(empty($g_seeker) || $g_seeker=='ALL'){

		}else{
			$this->db->where('g.seeker_type_id',$g_seeker);
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
			// $dateTime1 = new DateTime($frmDate);
			// $from_date=date_format($dateTime1,'Y-m-d' );
			//
			// $dateTime2 = new DateTime($toDate);
			// $to_date=date_format($dateTime2,'Y-m-d' );

			$from_date=date("Y-m-d", strtotime($frmDate) );
			$to_date=date("Y-m-d", strtotime($toDate) );
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
			$this->db->where('c.office_id',$ward_id);
		}
		if(empty($status) || $status=='ALL'){

		}else{
			$this->db->where('mr.meeting_status',$status);
		}
		if(empty($frmDate)){

					$this->db->where('DATE(mr.created_at) >= last_day(now()) + interval 1 day - interval 3 month');
		}else{
			// $dateTime1 = new DateTime($frmDate);
			// $from_date=date_format($dateTime1,'Y-m-d' );
			// $dateTime2 = new DateTime($toDate);
			// $to_date=date_format($dateTime2,'Y-m-d' );
			$from_date=date("Y-m-d", strtotime($frmDate) );
			$to_date=date("Y-m-d", strtotime($toDate) );
			$this->db->where('DATE(mr.created_at) >=', $from_date);
			$this->db->where('DATE(mr.created_at) <=', $to_date);
		}

		// echo $this->db->get_compiled_select(); // before $this->db->get();
		// exit;
		$query = $this->db->get();
		$result = $query->result_array();

		return $result[0]['allcount'];
	}

	function get_meeting_report($rowno,$rowperpage,$frmDate,$toDate,$status,$paguthi,$ward_id)
	{
		$this->db->select('mr.*,c.full_name,c.mobile_no,c.father_husband_name,c.address,c.dob,c.door_no,c.pin_code,u.full_name as created_by');
		$this->db->from('meeting_request as mr');
		$this->db->join('constituent as c', 'mr.constituent_id = c.id', 'left');
		$this->db->join('user_master as u', 'mr.created_by = u.id', 'left');
		if(empty($paguthi) || $paguthi=='ALL'){

		}else{
			$this->db->where('c.paguthi_id',$paguthi);
		}
		if(empty($ward_id)){

		}else{
			$this->db->where('c.office_id',$ward_id);
		}
		if(empty($status) || $status=='ALL'){

		}else{
			$this->db->where('mr.meeting_status',$status);
		}
		if(empty($frmDate)){

					$this->db->where('DATE(mr.created_at) >= last_day(now()) + interval 1 day - interval 3 month');
		}else{
			$from_date=date("Y-m-d", strtotime($frmDate) );
			$to_date=date("Y-m-d", strtotime($toDate) );

			// $dateTime1 = new DateTime($frmDate);
			// $from_date=date_format($dateTime1,'Y-m-d' );
			// $dateTime2 = new DateTime($toDate);
			// $to_date=date_format($dateTime2,'Y-m-d' );
			$this->db->where('DATE(mr.created_at) >=', $from_date);
			$this->db->where('DATE(mr.created_at) <=', $to_date);
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


		if(empty($frmDate)){
			$query_vide="cv.updated_at >= last_day(now()) + interval 1 day - interval 3 month";
			$query_cons="c.created_at >= last_day(now()) + interval 1 day - interval 3 month";
			$query_griever="g.created_at >= last_day(now()) + interval 1 day - interval 3 month";
			$query_wb="wb.updated_at >= last_day(now()) + interval 1 day - interval 3 month";
		}else{
			$dateTime1 = new DateTime($frmDate);
			$from_date=date_format($dateTime1,'Y-m-d' );

			$dateTime2 = new DateTime($toDate);
			$to_date=date_format($dateTime2,'Y-m-d' );

			$query_vide="DATE(cv.updated_at) BETWEEN '$from_date' AND '$to_date'";
			$query_cons=" DATE(c.created_at) BETWEEN '$from_date' AND '$to_date'";
			$query_griever="DATE(g.created_at) BETWEEN '$from_date' AND '$to_date'";
			$query_wb="DATE(wb.updated_at) BETWEEN '$from_date' AND '$to_date'";
		}

		 	$query= "SELECT t3.id,t3.full_name,t3.total_cons,t3.total_v,t3.total_g,count(wb.updated_by) as total_broadcast FROM (SELECT t2.id,t2.full_name,t2.total_cons,t2.total_v,count(g.created_by) as total_g from (select t1.id,t1.full_name,t1.total_cons,count(cv.updated_by) as total_v
			from (select um.id,um.full_name,COUNT(c.created_by) as total_cons from user_master as um left join constituent as c on c.created_by=um.id
			and $query_cons group by um.id) t1 left join constituent_video as cv on cv.updated_by=t1.id and $query_vide GROUP by t1.id) t2 left join grievance as g on g.created_by=t2.id and $query_griever GROUP BY t2.id) t3 left join constituent as wb on wb.updated_by=t3.id and wb.whatsapp_broadcast='YES'
			AND $query_wb group by t3.id";
			$result=$this->db->query($query);
		  return $result->result();

	}

	function get_birthday_report($rowno,$rowperpage,$year_id,$bf_year_id,$month_id,$paguthi,$ward_id)
	{
		$this->db->select('bw.*,c.full_name,c.father_husband_name,c.mobile_no,c.whatsapp_no,c.email_id,c.address,c.dob,c.pin_code,c.door_no');
		$this->db->from('consitutent_birthday_wish as bw');
		$this->db->join('constituent as c', 'c.id = bw.constituent_id', 'left');
		if(empty($year_id)){
			$this->db->where('DATE(bw.created_at) >= last_day(now()) + interval 1 day - interval 3 month');
		}else{
			// $this->db->where('YEAR(bw.created_at)',$year_id);
			$query_where="YEAR(bw.created_at) BETWEEN '$bf_year_id' AND '$year_id'";
			$this->db->where($query_where);
		}
		if(empty($month_id)){

		}else{
			$this->db->where('MONTH(c.dob)',$month_id);
		}
		if(empty($paguthi) || $paguthi=="ALL"){

		}else{
			$this->db->where('c.paguthi_id',$paguthi);
		}
		if(empty($ward_id)){

		}else{
			$this->db->where('c.office_id',$ward_id);
		}
		// echo $this->db->get_compiled_select(); // before $this->db->get();
		// exit;
		$this->db->limit($rowperpage, $rowno);
		$query = $this->db->get();
		return $query->result_array();

	}

	function get_birthday_count($year_id,$bf_year_id,$month_id,$paguthi,$ward_id){
		$this->db->select('count(bw.id) as allcount');
		$this->db->from('consitutent_birthday_wish as bw');
		$this->db->join('constituent as c', 'c.id = bw.constituent_id', 'left');
		if(empty($year_id)){
			$this->db->where('DATE(c.dob) >= last_day(now()) + interval 1 day - interval 3 month');
		}else{
			// $this->db->where('YEAR(bw.created_at)',$year_id);
			$query_where="YEAR(c.created_at) BETWEEN '$bf_year_id' AND '$year_id'";
			$this->db->where($query_where);
		}
		if(empty($month_id)){

		}else{
			$this->db->where('MONTH(c.dob)',$month_id);
		}
		if(empty($paguthi) || $paguthi=="ALL"){

		}else{
			$this->db->where('c.paguthi_id',$paguthi);
		}
		if(empty($ward_id)){

		}else{
			$this->db->where('c.office_id',$ward_id);
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
				$this->db->where('c.office_id',$ward_id);
			}



			$this->db->group_by('c.id');
			// echo $this->db->get_compiled_select(); // before $this->db->get();
			// exit;
			$this->db->limit($rowperpage, $rowno);
			$query = $this->db->get();
			return $query->result_array();

		 }


		 function sent_festival_wishes($cons_id,$festival_id,$user_id){
			 $sess_office_id = $this->session->userdata('sess_office_id');
			 $insert="INSERT INTO festival_wishes (constituent_id,festival_id,sent_status,updated_by,updated_at,created_office_id) VALUES ('$cons_id','$festival_id','SENT','$user_id',NOW(),'$sess_office_id')";
			 $result=$this->db->query($insert);
			 if($result){
				 echo "success";
			 }else{
				 echo "failure";
			 }
		 }


		 function fetch_festival_wishes_report($rowno,$rowperpage,$year_id,$fr_year_id,$paguthi,$ward_id,$religion_id) {
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
 				$this->db->where('c.office_id',$ward_id);
 			}
			if(empty($year_id)){
					$this->db->where('DATE(fw.updated_at) >= last_day(now()) + interval 1 day - interval 3 month');
			}else{
				// $this->db->where('YEAR(fw.updated_at) =',$year_id);
				$query_where="YEAR(fw.updated_at) BETWEEN '$fr_year_id' AND '$year_id'";
				$this->db->where($query_where);
			}
 			// echo $this->db->get_compiled_select(); // before $this->db->get();
 			// exit;
 			$this->db->limit($rowperpage, $rowno);
 			$query = $this->db->get();
 			return $query->result_array();

 		 }

		 function get_festival_count($year_id,$fr_year_id,$religion_id,$paguthi,$ward_id){
			 $this->db->select('count(c.id) as allcount');
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
			 $this->db->where('c.office_id',$ward_id);
		 }
		 if(empty($year_id)){
				 $this->db->where('DATE(fw.updated_at) >= last_day(now()) + interval 1 day - interval 3 month');
		 }else{
			 // $this->db->where('YEAR(fw.updated_at) =',$year_id);
			 $query_where="YEAR(fw.updated_at) BETWEEN '$fr_year_id' AND '$year_id'";
			 $this->db->where($query_where);
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
				 $this->db->where('c.office_id',$ward_id);
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
				 $this->db->where('c.office_id',$ward_id);
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
					$this->db->where('c.office_id',$ward_id);
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
 				$this->db->where('c.office_id',$ward_id);
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
		$query="SELECT YEAR(created_at)  as year_name FROM consitutent_birthday_wish GROUP BY year_name ORDER BY year_name desc";
		$resultset=$this->db->query($query);
		return $resultset->result();
	}

	function get_festival_year(){
		$query="SELECT YEAR(updated_at)  as year_name FROM festival_wishes GROUP BY year_name ORDER BY year_name desc";
		$resultset=$this->db->query($query);
		return $resultset->result();
	}

	 function get_status_report_export($frmDate,$toDate,$status,$paguthi,$ward_id)
		{
				$this->db->select('c.full_name,c.father_husband_name,c.dob,c.gender,CONCAT(c.door_no,c.address) AS address,c.pin_code,c.mobile_no,c.whatsapp_no,r.religion_name,cy.constituency_name,p.paguthi_name,o.office_name,w.ward_name,b.booth_name,st.seeker_info,gt.grievance_name,sb.sub_category_name,g.status,g.grievance_date,g.created_at');
				$this->db->from('grievance as g');
				$this->db->join('constituent as c', 'g.constituent_id = c.id', 'left');

				$this->db->join('religion as r', 'c.religion_id = r.id', 'left');
				$this->db->join('constituency as cy', 'c.constituency_id = cy.id', 'left');
				$this->db->join('paguthi as p', 'c.paguthi_id = p.id', 'left');
				$this->db->join('office as o', 'c.office_id = o.id', 'left');
				$this->db->join('ward as w', 'c.ward_id = w.id', 'left');
				$this->db->join('booth as b', 'c.booth_id = b.id', 'left');
				$this->db->join('seeker_type as st', 'g.seeker_type_id = st.id', 'left');
				$this->db->join('grievance_type as gt', 'gt.id = g.grievance_type_id', 'left');
				$this->db->join('grievance_sub_category as sb', 'sb.id = g.sub_category_id', 'left');

				$this->db->join('user_master as u', 'g.created_by = u.id', 'left');

				if(empty($paguthi) || $paguthi=='ALL'){

				}else{
					$this->db->where('g.paguthi_id',$paguthi);
				}
				if(empty($ward_id)){

				}else{
					$this->db->where('g.office_id',$ward_id);
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
				// echo $this->db->get_compiled_select();
				// exit;
				return	$query = $this->db->get();

		}


		function get_category_report_export($frmDate,$toDate,$g_seeker,$category,$sub_category_id,$paguthi,$ward_id){
			$this->db->select('c.full_name,c.father_husband_name,c.dob,c.gender,CONCAT(c.door_no,c.address) AS address,c.pin_code,c.mobile_no,c.whatsapp_no,r.religion_name,cy.constituency_name,p.paguthi_name,o.office_name,w.ward_name,b.booth_name,st.seeker_info,gt.grievance_name,sb.sub_category_name,g.status,g.grievance_date,g.created_at');
			$this->db->from('grievance as g');
			$this->db->join('constituent as c', 'g.constituent_id = c.id', 'left');

			$this->db->join('religion as r', 'c.religion_id = r.id', 'left');
			$this->db->join('constituency as cy', 'c.constituency_id = cy.id', 'left');
			$this->db->join('paguthi as p', 'c.paguthi_id = p.id', 'left');
			$this->db->join('office as o', 'c.office_id = o.id', 'left');
			$this->db->join('ward as w', 'c.ward_id = w.id', 'left');
			$this->db->join('booth as b', 'c.booth_id = b.id', 'left');
			$this->db->join('seeker_type as st', 'g.seeker_type_id = st.id', 'left');
			$this->db->join('grievance_type as gt', 'gt.id = g.grievance_type_id', 'left');
			$this->db->join('grievance_sub_category as sb', 'sb.id = g.sub_category_id', 'left');

			$this->db->join('user_master as u', 'g.created_by = u.id', 'left');
			if(empty($paguthi) || $paguthi=='ALL'){

			}else{
				$this->db->where('g.paguthi_id',$paguthi);
			}
			if(empty($ward_id)){

			}else{
				$this->db->where('g.office_id',$ward_id);
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
			if(empty($g_seeker) || $g_seeker=='ALL'){

			}else{
				$this->db->where('g.seeker_type_id',$g_seeker);
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

			return $query = $this->db->get();
		}

		function get_meeting_report_export($frmDate,$toDate,$status,$paguthi,$ward_id){
			// $this->db->select('c.full_name,c.mobile_no,mr.meeting_date,mr.meeting_detail,mr.meeting_status');
				$this->db->select('c.full_name,c.father_husband_name,c.dob,c.gender,CONCAT(c.door_no,c.address) AS address,c.pin_code,c.mobile_no,c.whatsapp_no,r.religion_name,cy.constituency_name,p.paguthi_name,o.office_name,w.ward_name,b.booth_name,mr.meeting_detail,mr.meeting_status,mr.meeting_date,mr.updated_at');
			$this->db->from('meeting_request as mr');
			$this->db->join('constituent as c', 'mr.constituent_id = c.id', 'left');
			$this->db->join('religion as r', 'c.religion_id = r.id', 'left');
			$this->db->join('constituency as cy', 'c.constituency_id = cy.id', 'left');
			$this->db->join('paguthi as p', 'c.paguthi_id = p.id', 'left');
			$this->db->join('office as o', 'c.office_id = o.id', 'left');
			$this->db->join('ward as w', 'c.ward_id = w.id', 'left');
			$this->db->join('booth as b', 'c.booth_id = b.id', 'left');
			$this->db->join('user_master as u', 'mr.created_by = u.id', 'left');
			if(empty($paguthi) || $paguthi=='ALL'){

			}else{
				$this->db->where('c.paguthi_id',$paguthi);
			}
			if(empty($ward_id)){

			}else{
				$this->db->where('c.office_id',$ward_id);
			}
			if(empty($status) || $status=='ALL'){

			}else{
				$this->db->where('mr.meeting_status',$status);
			}
			if(empty($frmDate)){

						$this->db->where('DATE(mr.created_at) >= last_day(now()) + interval 1 day - interval 3 month');
			}else{
				$from_date=date("Y-m-d", strtotime($frmDate) );
				$to_date=date("Y-m-d", strtotime($toDate) );
				$this->db->where('DATE(mr.created_at) >=', $from_date);
				$this->db->where('DATE(mr.created_at) <=', $to_date);
			}
			// echo $this->db->get_compiled_select();
			// exit;
		return $query = $this->db->get();
		}

		function get_birthday_report_export($month_id,$year_id,$bf_year_id,$paguthi,$ward_id){

				$this->db->select('c.full_name,c.father_husband_name,c.dob,c.gender,CONCAT(c.door_no,c.address) AS address,c.pin_code,c.mobile_no,c.whatsapp_no,r.religion_name,cy.constituency_name,p.paguthi_name,o.office_name,w.ward_name,b.booth_name,MONTHNAME (c.dob),YEAR(bw.created_at),bw.created_at');
			$this->db->from('consitutent_birthday_wish as bw');
			$this->db->join('constituent as c', 'c.id = bw.constituent_id', 'left');
			$this->db->join('religion as r', 'c.religion_id = r.id', 'left');
			$this->db->join('constituency as cy', 'c.constituency_id = cy.id', 'left');
			$this->db->join('paguthi as p', 'c.paguthi_id = p.id', 'left');
			$this->db->join('office as o', 'c.office_id = o.id', 'left');
			$this->db->join('ward as w', 'c.ward_id = w.id', 'left');
			$this->db->join('booth as b', 'c.booth_id = b.id', 'left');

			if(empty($year_id)){
				$this->db->where('DATE(c.dob) >= last_day(now()) + interval 1 day - interval 3 month');
			}else{
				// $this->db->where('YEAR(bw.created_at)',$year_id);
				$query_where="YEAR(bw.created_at) BETWEEN '$bf_year_id' AND '$year_id'";
				$this->db->where($query_where);
			}
			if(empty($month_id)){

			}else{
				$this->db->where('MONTH(c.dob)',$month_id);
			}
			if(empty($paguthi) || $paguthi=="ALL"){

			}else{
				$this->db->where('c.paguthi_id',$paguthi);
			}
			if(empty($ward_id)){

			}else{
				$this->db->where('c.office_id',$ward_id);
			}
			// echo $this->db->get_compiled_select(); // before $this->db->get();
			// exit;
			return $query = $this->db->get();
		}


		function get_festival_report_export($religion_id,$year_id,$fr_year_id,$paguthi,$ward_id){
			// $this->db->select('c.full_name,c.mobile_no,c.address,fm.festival_name,fw.updated_at as sent_on');
			$this->db->select('c.full_name,c.father_husband_name,c.dob,c.gender,CONCAT(c.door_no,c.address) AS address,c.pin_code,c.mobile_no,c.whatsapp_no,r.religion_name,cy.constituency_name,p.paguthi_name,o.office_name,w.ward_name,b.booth_name,fm.festival_name,YEAR(fw.updated_at),fw.updated_at');
			$this->db->from('festival_wishes as fw');
			$this->db->join('festival_master as fm', 'fm.id = fw.festival_id', 'left');
			$this->db->join('constituent as c', 'c.id = fw.constituent_id', 'left');
			$this->db->join('religion as r', 'c.religion_id = r.id', 'left');
			$this->db->join('constituency as cy', 'c.constituency_id = cy.id', 'left');
			$this->db->join('paguthi as p', 'c.paguthi_id = p.id', 'left');
			$this->db->join('office as o', 'c.office_id = o.id', 'left');
			$this->db->join('ward as w', 'c.ward_id = w.id', 'left');
			$this->db->join('booth as b', 'c.booth_id = b.id', 'left');
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
				$this->db->where('c.office_id',$ward_id);
			}
			if(empty($year_id)){
					$this->db->where('DATE(fw.updated_at) >= last_day(now()) + interval 1 day - interval 3 month');
			}else{
				// $this->db->where('YEAR(fw.updated_at) =',$year_id);
				$query_where="YEAR(fw.updated_at) BETWEEN '$fr_year_id' AND '$year_id'";
				$this->db->where($query_where);
			}
			// echo $this->db->get_compiled_select(); // before $this->db->get();
			// exit;
		return $query = $this->db->get();
		}



		function get_constituent_report_export($email_id,$mobile_no,$whatsapp_no,$paguthi,$ward_id){
		$this->db->select('c.full_name,c.father_husband_name,c.dob,c.gender,CONCAT(c.door_no,c.address) AS address,c.pin_code,c.mobile_no,c.whatsapp_no,c.email_id,r.religion_name,cy.constituency_name,p.paguthi_name,o.office_name,w.ward_name,b.booth_name,c.voter_status,c.voter_id_no,c.volunteer_status,c.party_member_status,c.aadhaar_no, GROUP_CONCAT(DISTINCT(s.seeker_info)) as seeker_info,
    GROUP_CONCAT(DISTINCT(gt.grievance_name)) as grievance_name, count(cv.constituent_id) as video_count,c.whatsapp_broadcast');
		 $this->db->from('constituent as c');
		 $this->db->join('religion as r', 'c.religion_id = r.id', 'left');
		 $this->db->join('constituency as cy', 'c.constituency_id = cy.id', 'left');
		 $this->db->join('paguthi as p', 'c.paguthi_id = p.id', 'left');
		 $this->db->join('office as o', 'c.office_id = o.id', 'left');
		 $this->db->join('ward as w', 'c.ward_id = w.id', 'left');
		 $this->db->join('booth as b', 'c.booth_id = b.id', 'left');
		 $this->db->join('constituent_video as cv', 'cv.constituent_id = c.id', 'left');

		 $this->db->join('grievance as gr', 'gr.constituent_id = c.id', 'left');
		 $this->db->join('seeker_type as s', 's.id = gr.seeker_type_id', 'left');
		 $this->db->join('grievance_type as gt', 'gt.id = gr.grievance_type_id', 'left');

		 if(empty($paguthi)){

		 }else{
			 $this->db->where('c.paguthi_id',$paguthi);
		 }
		 if(empty($ward_id)){

		 }else{
			 $this->db->where('c.office_id',$ward_id);
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
		 $this->db->group_by('c.id');

		//echo $this->db->get_compiled_select(); // before $this->db->get();
		//exit;
		return $query = $this->db->get();
		}

		function get_video_report_export($paguthi,$ward_id){
			// $this->db->select('c.full_name,c.mobile_no,c.door_no,c.address,c.dob,c.father_husband_name,c.pin_code,cv.video_title,cv.video_link,u.full_name as done_by,cv.updated_at');
			$this->db->select('c.full_name,c.father_husband_name,c.dob,c.gender,c.door_no,c.address,c.pin_code,c.mobile_no,c.whatsapp_no,c.email_id,r.religion_name,cy.constituency_name,p.paguthi_name,o.office_name,w.ward_name,b.booth_name,cv.video_link,cv.updated_at');
			$this->db->from('constituent_video as cv');
			$this->db->join('constituent as c', 'c.id = cv.constituent_id', 'left');
			$this->db->join('religion as r', 'c.religion_id = r.id', 'left');
			$this->db->join('constituency as cy', 'c.constituency_id = cy.id', 'left');
			$this->db->join('paguthi as p', 'c.paguthi_id = p.id', 'left');
			$this->db->join('office as o', 'c.office_id = o.id', 'left');
			$this->db->join('ward as w', 'c.ward_id = w.id', 'left');
			$this->db->join('booth as b', 'c.booth_id = b.id', 'left');
			$this->db->join('user_master as u', 'cv.updated_by = u.id', 'left');
			if(empty($paguthi)){

			}else{
				$this->db->where('c.paguthi_id',$paguthi);
			}
			if(empty($ward_id)){

			}else{
				$this->db->where('c.office_id',$ward_id);
			}

			// echo $this->db->get_compiled_select();
			// exit;
			return $query = $this->db->get();
		}



		function get_staff_report_export($frmDate,$toDate){
			if(empty($frmDate)){
				$query_vide="AND cv.updated_at >= last_day(now()) + interval 1 day - interval 3 month";
				$query_cons="AND c.created_at >= last_day(now()) + interval 1 day - interval 3 month";
				$query_griever="AND g.created_at >= last_day(now()) + interval 1 day - interval 3 month";
				$query_meeting="AND mr.created_at >= last_day(now()) + interval 1 day - interval 3 month";
				$query_bw="AND cb.created_at >= last_day(now()) + interval 1 day - interval 3 month";
				$query_fw="AND fw.updated_at >= last_day(now()) + interval 1 day - interval 3 month";
				$query_gr="AND gr.created_at >= last_day(now()) + interval 1 day - interval 3 month";
				$query_mtr="AND mtr.created_at >= last_day(now()) + interval 1 day - interval 3 month";
				$query_wb="AND wb.updated_at >= last_day(now()) + interval 1 day - interval 3 month";
			}else{
				$dateTime1 = new DateTime($frmDate);
				$from_date=date_format($dateTime1,'Y-m-d' );

				$dateTime2 = new DateTime($toDate);
				$to_date=date_format($dateTime2,'Y-m-d' );

				$query_vide="AND DATE(cv.updated_at) BETWEEN '$from_date' AND '$to_date'";
				$query_cons="AND DATE(c.created_at) BETWEEN '$from_date' AND '$to_date'";
				$query_griever="AND DATE(g.created_at) BETWEEN '$from_date' AND '$to_date'";
				$query_meeting="AND DATE(mr.created_at) BETWEEN '$from_date' AND '$to_date'";
				$query_bw="AND DATE(cb.created_at) BETWEEN '$from_date' AND '$to_date'";
				$query_fw="AND DATE(fw.updated_at) BETWEEN '$from_date' AND '$to_date'";
				$query_gr="AND DATE(gr.created_at) BETWEEN '$from_date' AND '$to_date'";
				$query_mtr="AND DATE(mtr.created_at) BETWEEN '$from_date' AND '$to_date'";
				$query_wb="AND DATE(wb.created_at) BETWEEN '$from_date' AND '$to_date'";
			}

							// $sql="SELECT t5.full_name,t5.total_cons,t5.total_g,t5.total_v,t5.total_req,t5.total_br,COUNT(fw.updated_by) as total_fw from (select t4.id,t4.full_name,t4.total_cons,t4.total_v,t4.total_g,t4.total_req,count(cb.created_by) as total_br from
							// (select t3.id,t3.full_name,t3.total_cons,t3.total_v,t3.total_g,count(mr.created_by) as total_req  from (SELECT t2.id, t2.full_name,t2.total_cons,t2.total_v,count(g.created_by) as total_g from (select t1.id,t1.full_name,t1.total_cons,count(cv.updated_by) as total_v from
							// (select um.id,um.full_name,COUNT(c.created_by) as total_cons from user_master as um left join constituent as c on c.created_by=um.id and $query_cons group by um.id) t1 left join constituent_video as cv on cv.updated_by=t1.id and $query_vide GROUP by t1.id) t2 left join grievance as g on g.created_by=t2.id
							// and $query_griever  GROUP BY t2.id) t3 left join meeting_request as mr
							// on mr.created_by=t3.id and $query_meeting group by t3.id) t4 left join consitutent_birthday_wish as cb on cb.created_by=t4.id and $query_bw group by t4.id) t5 LEFT join festival_wishes as fw on fw.updated_by=t5.id and $query_fw GROUP by t5.id";
							$sql="SELECT t8.full_name,t8.total_cons,t8.total_g,t8.total_reply,t8.total_v,count(wb.updated_by) as total_broadcast,t8.total_req,t8.total_meeting_reply,t8.total_br,t8.total_fw from (select t7.id,t7.full_name,t7.total_cons,t7.total_v,t7.total_g,t7.total_req,t7.total_br,t7.total_fw,
								t7.total_reply,count(mtr.created_by) as total_meeting_reply from (select t6.id,t6.full_name,t6.total_cons,t6.total_v,t6.total_g,t6.total_req,t6.total_br,t6.total_fw,count(gr.created_by) as total_reply from (select t5.id,t5.full_name,t5.total_cons,t5.total_v,t5.total_g,t5.total_req,t5.total_br,
									COUNT(fw.updated_by) as total_fw from (select t4.id,t4.full_name,t4.total_cons,t4.total_v,t4.total_g,t4.total_req,count(cb.created_by) as total_br from (select t3.id,t3.full_name,t3.total_cons,t3.total_v,t3.total_g,count(mr.created_by) as total_req
									 from (SELECT t2.id, t2.full_name,t2.total_cons,t2.total_v,count(g.created_by) as total_g from (select t1.id,t1.full_name,t1.total_cons,count(cv.updated_by) as total_v from (select um.id,um.full_name,
										 COUNT(c.created_by) as total_cons	 from user_master as um left join constituent as c on c.created_by=um.id $query_cons group by um.id) t1 left join constituent_video as cv on cv.updated_by=t1.id $query_vide GROUP by t1.id) t2 left join grievance as g on g.created_by=t2.id  $query_griever
										 GROUP BY t2.id) t3 left join meeting_request as mr on mr.created_by=t3.id $query_meeting group by t3.id) t4  left join consitutent_birthday_wish as cb on cb.created_by=t4.id $query_bw group by t4.id) t5 LEFT join festival_wishes as fw on fw.updated_by=t5.id $query_fw GROUP by t5.id) t6
										  left join grievance_reply as gr on gr.created_by=t6.id and gr.sms_flag='G' $query_gr GROUP BY t6.id) t7 LEFT join grievance_reply as mtr on mtr.created_by=t7.id and mtr.sms_flag='M' $query_mtr GROUP by t7.id) t8 left join constituent as wb on wb.updated_by=t8.id AND wb.whatsapp_broadcast='YES' $query_wb  GROUP BY t8.id";


							$query= $this->db->query($sql);



							return $query;
		}


}
?>
