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
			$constituent_count = "SELECT * FROM constituent WHERE constituency_id = '1'";
			$constituent_count_res = $this->db->query($constituent_count);
			$constituent_count = $constituent_count_res->num_rows();
			
			$constituent_mcount = "SELECT * FROM constituent WHERE constituency_id = '1' AND gender = 'M'";
			$constituent_mcount_res = $this->db->query($constituent_mcount);
			$constituent_mcount = $constituent_mcount_res->num_rows();
			
			$constituent_fcount = "SELECT * FROM constituent WHERE constituency_id = '1' AND gender = 'F'";
			$constituent_fcount_res = $this->db->query($constituent_fcount);
			$constituent_fcount = $constituent_fcount_res->num_rows();
			
			$constituent_vcount = "SELECT * FROM constituent WHERE constituency_id = '1' AND voter_id_status = 'Y'";
			$constituent_vcount_res = $this->db->query($constituent_vcount);
			$constituent_vcount = $constituent_vcount_res->num_rows();
			
			$constituent_acount = "SELECT * FROM constituent WHERE constituency_id = '1' AND aadhaar_status = 'Y'";
			$constituent_acount_res = $this->db->query($constituent_acount);
			$constituent_acount = $constituent_acount_res->num_rows();
			
			$meeting_count = "SELECT * FROM meeting_request";
			$meeting_count_res = $this->db->query($meeting_count);
			$meeting_count = $meeting_count_res->num_rows();
			
			$meeting_rcount = "SELECT * FROM meeting_request WHERE meeting_status = 'REQUESTED'";
			$meeting_rcount_res = $this->db->query($meeting_rcount);
			$meeting_rcount = $meeting_rcount_res->num_rows();

			$meeting_ccount = "SELECT * FROM meeting_request WHERE meeting_status = 'COMPLETED'";
			$meeting_ccount_res = $this->db->query($meeting_ccount);
			$meeting_ccount = $meeting_ccount_res->num_rows();
			
			$grievance_count = "SELECT * FROM grievance";
			$grievance_count_res = $this->db->query($grievance_count);
			$grievance_count = $grievance_count_res->num_rows();
			
			$grievance_ecount = "SELECT * FROM grievance WHERE grievance_type = 'E'";
			$grievance_ecount_res = $this->db->query($grievance_ecount);
			$grievance_ecount = $grievance_ecount_res->num_rows();

			$grievance_pcount = "SELECT * FROM grievance WHERE grievance_type = 'P'";
			$grievance_pcount_res = $this->db->query($grievance_pcount);
			$grievance_pcount = $grievance_pcount_res->num_rows();
			
			$grievance_processcount = "SELECT * FROM grievance WHERE status = 'PROCESSING'";
			$grievance_processcount_res = $this->db->query($grievance_processcount);
			$grievance_processcount = $grievance_processcount_res->num_rows();
			
			$grievance_completecount = "SELECT * FROM grievance WHERE status = 'COMPLETED'";
			$grievance_completecount_res = $this->db->query($grievance_completecount);
			$grievance_completecount = $grievance_completecount_res->num_rows();
			
			$interactioncount = "SELECT * FROM interaction_history WHERE question_response = 'Y'";
			$interactioncount_res = $this->db->query($interactioncount);
			$interactioncount = $interactioncount_res->num_rows();

			$result  = array(
					"con_count" => $constituent_count,
					"conm_count" => $constituent_mcount,
					"conf_count" => $constituent_fcount,
					"conv_count" => $constituent_vcount,
					"cona_count" => $constituent_acount,
					"meet_count" => $meeting_count,
					"meet_rcount" => $meeting_rcount,
					"meet_ccount" => $meeting_ccount,
					"grev_count" => $grievance_count,
					"grev_ecount" => $grievance_ecount,
					"grev_pcount" => $grievance_pcount,
					"grev_processcount" => $grievance_processcount,
					"grev_completecount" => $grievance_completecount,
					"interaction_count" => $interactioncount
				);
					
			return $result;
		} else {
			$constituent_count = "SELECT * FROM constituent WHERE constituency_id = '1' AND paguthi_id = '$paguthi' ";
			$constituent_count_res = $this->db->query($constituent_count);
			$constituent_count = $constituent_count_res->num_rows();
			
			$constituent_mcount = "SELECT * FROM constituent WHERE constituency_id = '1' AND gender = 'M' AND paguthi_id = '$paguthi'";
			$constituent_mcount_res = $this->db->query($constituent_mcount);
			$constituent_mcount = $constituent_mcount_res->num_rows();
			
			$constituent_fcount = "SELECT * FROM constituent WHERE constituency_id = '1' AND gender = 'F' AND paguthi_id = '$paguthi'";
			$constituent_fcount_res = $this->db->query($constituent_fcount);
			$constituent_fcount = $constituent_fcount_res->num_rows();
			
			$constituent_vcount = "SELECT * FROM constituent WHERE constituency_id = '1' AND voter_id_status = 'Y' AND paguthi_id = '$paguthi'";
			$constituent_vcount_res = $this->db->query($constituent_vcount);
			$constituent_vcount = $constituent_vcount_res->num_rows();
			
			$constituent_acount = "SELECT * FROM constituent WHERE constituency_id = '1' AND aadhaar_status = 'Y' AND paguthi_id = '$paguthi'";
			$constituent_acount_res = $this->db->query($constituent_acount);
			$constituent_acount = $constituent_acount_res->num_rows();
			
			$meeting_count = "SELECT * FROM meeting_request A, constituent B WHERE A.constituent_id = B.id AND B.paguthi_id ='$paguthi' ";
			$meeting_count_res = $this->db->query($meeting_count);
			$meeting_count = $meeting_count_res->num_rows();
			
			$meeting_rcount = "SELECT * FROM meeting_request A, constituent B WHERE A.constituent_id = B.id AND B.paguthi_id ='$paguthi' AND A.meeting_status = 'REQUESTED' ";
			$meeting_rcount_res = $this->db->query($meeting_rcount);
			$meeting_rcount = $meeting_rcount_res->num_rows();
			
			$meeting_ccount = "SELECT * FROM meeting_request A, constituent B WHERE A.constituent_id = B.id AND B.paguthi_id ='$paguthi' AND A.meeting_status = 'COMPLETED'";
			$meeting_ccount_res = $this->db->query($meeting_ccount);
			$meeting_ccount = $meeting_ccount_res->num_rows();
			
			$grievance_count = "SELECT * FROM grievance WHERE paguthi_id = '$paguthi'";
			$grievance_count_res = $this->db->query($grievance_count);
			$grievance_count = $grievance_count_res->num_rows();
			
			$grievance_ecount = "SELECT * FROM grievance WHERE grievance_type = 'E' AND paguthi_id = '$paguthi'";
			$grievance_ecount_res = $this->db->query($grievance_ecount);
			$grievance_ecount = $grievance_ecount_res->num_rows();

			$grievance_pcount = "SELECT * FROM grievance WHERE grievance_type = 'P' AND paguthi_id = '$paguthi'";
			$grievance_pcount_res = $this->db->query($grievance_pcount);
			$grievance_pcount = $grievance_pcount_res->num_rows();
			
			$grievance_processcount = "SELECT * FROM grievance WHERE status = 'PROCESSING' AND paguthi_id = '$paguthi'";
			$grievance_processcount_res = $this->db->query($grievance_processcount);
			$grievance_processcount = $grievance_processcount_res->num_rows();
			
			$grievance_completecount = "SELECT * FROM grievance WHERE status = 'COMPLETED' AND paguthi_id = '$paguthi'";
			$grievance_completecount_res = $this->db->query($grievance_completecount);
			$grievance_completecount = $grievance_completecount_res->num_rows();

			$interactioncount = "SELECT
									ih.constituent_id,
									ih.question_id,
									ih.question_response
								FROM
									interaction_history AS ih
								LEFT JOIN constituent AS c
								ON
									c.id = ih.constituent_id
								WHERE
									c.paguthi_id = '$paguthi'";
			$interactioncount_res = $this->db->query($interactioncount);
			$interactioncount = $interactioncount_res->num_rows();
			
			$result  = array(
					"con_count" => $constituent_count,
					"conm_count" => $constituent_mcount,
					"conf_count" => $constituent_fcount,
					"conv_count" => $constituent_vcount,
					"cona_count" => $constituent_acount,
					"meet_count" => $meeting_count,
					"meet_rcount" => $meeting_rcount,
					"meet_ccount" => $meeting_ccount,
					"grev_count" => $grievance_count,
					"grev_ecount" => $grievance_ecount,
					"grev_pcount" => $grievance_pcount,
					"grev_processcount" => $grievance_processcount,
					"grev_completecount" => $grievance_completecount,
					"interaction_count" => $interactioncount
				);
			return $result;
		}
	}
	
	
	function get_interaction($paguthi)
	{
		if ($paguthi == 'All')
		{
			$query="SELECT
						A.`question_id`,
						B.widgets_title,
						COUNT(question_id) AS tot_values
					FROM
						`interaction_history` A,
						interaction_question B
					WHERE
						A.`question_id` = B.id AND A.`question_response` = 'Y'
					GROUP BY
						`question_id`";
			$res=$this->db->query($query);
			$result=$res->result();
			
			return $result;
		} else {
			$query="SELECT
					ih.constituent_id,
					ih.question_id,
					ih.question_response,
					iq.widgets_title,
					COUNT(ih.question_id) AS tot_values
					FROM
						interaction_history AS ih
					LEFT JOIN constituent AS c
					ON
						c.id = ih.constituent_id
					LEFT JOIN interaction_question AS iq
					ON
						ih.question_id = iq.id
					WHERE
						ih.question_response = 'Y' AND c.paguthi_id = '$paguthi'
					GROUP BY
						ih.question_id";
			$res=$this->db->query($query);
			$result=$res->result();
			
			return $result;
		}
	}
	
	function get_footfall_graph($paguthi)
	{
		if ($paguthi == 'All')
		{
			 $query="SELECT
						DATE_FORMAT(grievance_date, '%M %y') AS disp_month,
						COUNT(*) AS total_grievance
					FROM
						`grievance`
					GROUP BY
						disp_month";
			$res=$this->db->query($query);
			$result=$res->result();
			return $result;
		} else {
			$query="SELECT
					DATE_FORMAT(grievance_date, '%M %y') AS disp_month,
					COUNT(*) AS total_grievance
				FROM
					`grievance`
				WHERE 
					paguthi_id = '$paguthi'
				GROUP BY
					disp_month";
		$res=$this->db->query($query);
		$result=$res->result();
		return $result;
		}
	}
	
	function get_grievance_graph($paguthi)
	{
		if ($paguthi == 'All')
		{
			$grievance_graphcount = "SELECT * FROM grievance";
			$grievance_graphcount_res = $this->db->query($grievance_graphcount);
			$grievance_graphcount = $grievance_graphcount_res->num_rows();
			
			$grievance_graphecount = "SELECT * FROM grievance WHERE grievance_type = 'E'";
			$grievance_graphecount_res = $this->db->query($grievance_graphecount);
			$grievance_graphecount = $grievance_graphecount_res->num_rows();
			
			$grievance_graphppcount = "SELECT * FROM grievance WHERE grievance_type = 'P' AND status='PROCESSING'";
			$grievance_graphppcount_res = $this->db->query($grievance_graphppcount);
			$grievance_graphppcount = $grievance_graphppcount_res->num_rows();
			
			$grievance_graphpccount = "SELECT * FROM grievance WHERE grievance_type = 'P' AND status='COMPLETED'";
			$grievance_graphpccount_res = $this->db->query($grievance_graphpccount);
			$grievance_graphpccount = $grievance_graphpccount_res->num_rows();
			

			$result  = array(
					"gerv_count" => $grievance_graphcount,
					"gerv_ecount" => $grievance_graphecount,
					"gerv_ppcount" => $grievance_graphppcount,
					"gerv_pccount" => $grievance_graphpccount
				);
			return $result;
		} else {
			$grievance_graphcount = "SELECT * FROM grievance WHERE paguthi_id = '$paguthi'";
			$grievance_graphcount_res = $this->db->query($grievance_graphcount);
			$grievance_graphcount = $grievance_graphcount_res->num_rows();
			
			$grievance_graphecount = "SELECT * FROM grievance WHERE grievance_type = 'E' AND paguthi_id = '$paguthi'";
			$grievance_graphecount_res = $this->db->query($grievance_graphecount);
			$grievance_graphecount = $grievance_graphecount_res->num_rows();
			
			$grievance_graphppcount = "SELECT * FROM grievance WHERE grievance_type = 'P' AND status='PROCESSING' AND paguthi_id = '$paguthi'";
			$grievance_graphppcount_res = $this->db->query($grievance_graphppcount);
			$grievance_graphppcount = $grievance_graphppcount_res->num_rows();
			
			$grievance_graphpccount = "SELECT * FROM grievance WHERE grievance_type = 'P' AND status='COMPLETED' AND paguthi_id = '$paguthi'";
			$grievance_graphpccount_res = $this->db->query($grievance_graphpccount);
			$grievance_graphpccount = $grievance_graphpccount_res->num_rows();
			

			$result  = array(
					"gerv_count" => $grievance_graphcount,
					"gerv_ecount" => $grievance_graphecount,
					"gerv_ppcount" => $grievance_graphppcount,
					"gerv_pccount" => $grievance_graphpccount
				);
			return $result;
		}
	}
	
	function get_meeeting_graph($paguthi)
	{
		if ($paguthi == 'All')
		{
			$query="SELECT
					CONCAT(
						SUBSTRING(
							DATE_FORMAT(`created_at`, '%M'),
							1,
							3
						),
						DATE_FORMAT(`created_at`, '-%Y')
					) AS month_year,
					COUNT(*) AS meeting_request
				FROM
					meeting_request
				WHERE
					PERIOD_DIFF(
						DATE_FORMAT(NOW(), '%Y%m'),
						DATE_FORMAT(`created_at`, '%Y%m')) < 6
					GROUP BY
						YEAR(`created_at`),
						MONTH(`created_at`)";
			$res=$this->db->query($query);
			$result=$res->result();
			return $result;
		} else {
			$query="SELECT
					CONCAT(
						SUBSTRING(
							DATE_FORMAT(A.created_at, '%M'),
							1,
							3
						),
						DATE_FORMAT(A.created_at, '-%Y')
					) AS month_year,
					COUNT(*) AS meeting_request
				FROM
					meeting_request A,
					constituent B
				WHERE A.constituent_id = B.id AND B.paguthi_id = '$paguthi' AND 
					PERIOD_DIFF(
						DATE_FORMAT(NOW(), '%Y%m'),
						DATE_FORMAT(A.created_at, '%Y%m')) < 6
					GROUP BY
						YEAR(A.created_at),
						MONTH(A.created_at)";
		$res=$this->db->query($query);
		$result=$res->result();
		return $result;
		}
	}
		
		
	
	function get_search_reult($keyword){
		$query="SELECT
					c.*,
					p.paguthi_name
				FROM
					constituent AS c
				LEFT JOIN paguthi AS p
				ON
					p.id = c.paguthi_id
				WHERE c.full_name LIKE '%$keyword%' OR father_husband_name LIKE '%$keyword%' OR guardian_name LIKE '%$keyword%' OR mobile_no LIKE '%$keyword%' OR whatsapp_no LIKE '%$keyword%' OR door_no LIKE '%$keyword%' OR address LIKE '%$keyword%' OR pin_code LIKE '%$keyword%' OR email_id LIKE '%$keyword%' OR voter_id_no LIKE '%$keyword%' OR aadhaar_no LIKE '%$keyword%' OR serial_no LIKE '%$keyword%'
				ORDER BY
					c.id
				DESC";
				$result=$this->db->query($query);
				return $result->result();
			}

}
?>
