<?php
Class Dashboardmodel extends CI_Model
{
	public function __construct()
	{
	  parent::__construct();
		//$this->load->model('mailmodel');
		//$this->load->model('smsmodel');
	}


	function list_paguthi(){
		$query="SELECT c.paguthi_id,p.paguthi_name  FROM constituent as c
		left join paguthi as p on p.id=c.paguthi_id GROUP by paguthi_id";
		$res=$this->db->query($query);
		return $result=$res->result();
	}

	function get_dashboard_result($paguthi_id,$from_date,$to_date){

		if($paguthi_id=='ALL' || empty($paguthi_id)){
			$quer_paguthi="";
		}else{
			$quer_paguthi="WHERE paguthi_id='$paguthi_id'";
		}

		if(empty($from_date)){
			$quer_date="";
		}else{
			$dateTime1 = new DateTime($from_date);
			$one_date=date_format($dateTime1,'Y-m-d' );

			$dateTime2 = new DateTime($to_date);
			$two_date=date_format($dateTime2,'Y-m-d' );

			if(empty($quer_paguthi)){
				$quer_date="WHERE DATE(created_at) BETWEEN '$one_date' and '$two_date'";
			}else{
				$quer_date="AND DATE(created_at) BETWEEN '$one_date' and '$two_date'";
			}
		}


		   $query="SELECT
			IFNULL(count(*),'0') AS total,
			IFNULL(sum(case when constituency_id = '1' then 1 else 0 end),'0') AS no_of_cons,
			IFNULL(sum(case when constituency_id = '1' then 1 else 0 end)/ count(*) *100,'0') as no_of_cons_percentage,
      IFNULL(sum(case when constituency_id = '0' then 1 else 0 end),'0') AS no_of_noncons,
			IFNULL(sum(case when constituency_id = '0' then 1 else 0 end)/ count(*) *100,'0') as no_of_noncons_percentage ,
			IFNULL(sum(case when gender = 'M' then 1 else 0 end),'0') AS malecount,
			IFNULL(sum(case when gender = 'M' then 1 else 0 end) / count(*) * 100,'0') as malepercenatge,
			IFNULL(sum(case when gender = 'F' then 1 else 0 end),'0') AS femalecount,
      IFNULL(sum(case when gender = 'F' then 1 else 0 end) / count(*) * 100,'0') as femalepercenatge,
			IFNULL(sum(case when gender = 'O' then 1 else 0 end),'0') AS others,
      IFNULL(sum(case when gender = 'O' then 1 else 0 end) / count(*) * 100,'0') as otherpercenatge,
			IFNULL(sum(case when voter_id_status = 'Y' then gender='M' else 0 end),'0') AS malevoter,
      IFNULL(sum(case when voter_id_status = 'Y' then gender='M' else 0 end) / count(*) * 100,'0') as malevoter_percentage,
			IFNULL(sum(case when voter_id_status = 'Y' then gender='F' else 0 end),'0') AS femalevoter,
      IFNULL(sum(case when voter_id_status = 'Y' then gender='F' else 0 end) / count(*) * 100,'0') as femalevoter_percentage,
			IFNULL(sum(case when aadhaar_status = 'Y' then gender='M' else 0 end),'0') AS maleaadhar,
      IFNULL(sum(case when aadhaar_status = 'Y' then gender='M' else 0 end) / count(*) * 100,'0') as maleaadhaar_percentage,
			IFNULL(sum(case when aadhaar_status = 'Y' then gender='F' else 0 end),'0') AS femaleaadhar,
      IFNULL(sum(case when aadhaar_status = 'Y' then gender='F' else 0 end) / count(*) * 100,'0') as femaleaadhaar_percentage,
			IFNULL(sum(case when mobile_no != '' then 1 else 0 end),'0') AS having_mobilenumber,
      IFNULL(sum(case when mobile_no != '' then 1 else 0 end) / count(*) * 100,'0') as mobile_percentage,
			IFNULL(sum(case when email_id != '' then 1 else 0 end),'0') AS having_email,
      IFNULL(sum(case when email_id != '' then 1 else 0 end) / count(*) * 100,'0') as email_percentage,
			IFNULL(sum(case when whatsapp_no != '' then 1 else 0 end),'0') AS having_whatsapp,
      IFNULL(sum(case when whatsapp_no != '' then 1 else 0 end) / count(*) * 100,'0') as whatsapp_percentage
			from  constituent $quer_paguthi $quer_date";

			$res=$this->db->query($query);
			return $result=$res->result();

	}



	function get_grievance_report($paguthi_id,$from_date,$to_date)
	{
			if($paguthi_id=='ALL' || empty($paguthi_id)){
			$quer_paguthi="";
		}else{
			$quer_paguthi="WHERE g.paguthi_id='$paguthi_id'";
		}
			if($paguthi_id=='ALL'){
			$quer_paguthi_cons="";
		}else{
			$quer_paguthi_cons="WHERE c.paguthi_id='$paguthi_id'";
		}

		if(empty($from_date)){
			$quer_date="";
		}else{
			$dateTime1 = new DateTime($from_date);
			$one_date=date_format($dateTime1,'Y-m-d' );

			$dateTime2 = new DateTime($to_date);
			$two_date=date_format($dateTime2,'Y-m-d' );

			if(empty($quer_paguthi)){
				$quer_date="WHERE DATE(g.grievance_date) BETWEEN '$one_date' and '$two_date'";
			}else{
				$quer_date="AND DATE(g.grievance_date) BETWEEN '$one_date' and '$two_date'";
			}
		}


		   $query_1="SELECT s.seeker_info,IFNULL(count(*),'0') as total,
						IFNULL(sum(case when g.repeated_status = 'N' then 1 else 0 end),'0') AS unique_count,
						IFNULL(sum(case when g.repeated_status = 'R' then 1 else 0 end),'0') AS repeat_count
						FROM grievance as g
						left join seeker_type as s on g.seeker_type_id=s.id $quer_paguthi $quer_date
						GROUP BY seeker_type_id";

			$res_1=$this->db->query($query_1);
		  $result_1=$res_1->result();

			$query_2="SELECT IFNULL(count(*),'0') as total,
			IFNULL(sum(case when g.repeated_status = 'N' then 1 else 0 end),'0') AS unique_count,
			IFNULL(IFNULL(sum(case when g.repeated_status = 'N' then 1 else 0 end),'0') / count(*) * 100,'0') AS unique_count_percentage,
			IFNULL(sum(case when g.repeated_status = 'R' then 1 else 0 end),'0') AS repeat_count,
			IFNULL(IFNULL(sum(case when g.repeated_status = 'R' then 1 else 0 end),'0') / count(*) * 100,'0') AS repeat_count_percentage
						FROM grievance as g
						left join seeker_type as s on g.seeker_type_id=s.id $quer_paguthi $quer_date";

			$res_2=$this->db->query($query_2);
			$result_2=$res_2->result();

			$query_3="SELECT count(*) as total,
						IFNULL(sum(case when mr.meeting_status = 'REQUESTED' then 1 else 0 end),'0')  AS meeting_request_count
						FROM meeting_request as mr
            left join constituent as c on c.id=mr.constituent_id $quer_paguthi_cons";
			$res_3=$this->db->query($query_3);
			$result_3=$res_3->result();

			$query_4="SELECT count(*) as birth_wish_count FROM consitutent_birthday_wish as br
						left join constituent as c on c.id=br.constituent_id $quer_paguthi_cons";
			$res_4=$this->db->query($query_4);
			$result_4=$res_4->result();


			$data = array('seeker_list' => $result_1,'gr_list'=> $result_2,'mr_list'=>$result_3,'br_list'=>$result_4);
			return $data;

	}

	function get_footfall_graph($paguthi_id,$from_date,$to_date)
	{
			if($paguthi_id=='ALL' || empty($paguthi_id)){
			$quer_paguthi="";
		}else{
			$quer_paguthi="WHERE c.paguthi_id='$paguthi_id'";
		}

		if(empty($from_date)){

			if(empty($quer_paguthi)){
				$quer_date="WHERE g.grievance_date >= last_day(now()) + interval 1 day - interval 3 month GROUP BY week_name";
			}else{
				$quer_date="AND g.grievance_date >= last_day(now()) + interval 1 day - interval 3 month GROUP BY week_name";
			}
		}else{
			$dateTime1 = new DateTime($from_date);
			$one_date=date_format($dateTime1,'Y-m-d' );

			$dateTime2 = new DateTime($to_date);
			$two_date=date_format($dateTime2,'Y-m-d' );

			if(empty($quer_paguthi)){
				$quer_date="WHERE DATE(g.grievance_date) BETWEEN '$one_date' and '$two_date'";
			}else{
				$quer_date="AND DATE(g.grievance_date) BETWEEN '$one_date' and '$two_date'";
			}

		}


		$query="SELECT WEEK(g.grievance_date) AS week_name,count(*) as total,
		sum(case when g.repeated_status = 'N' then 1 else 0 end) AS unique_count,
		sum(case when g.repeated_status = 'R' then 1 else 0 end) AS repeat_count
		FROM grievance as g
		left join constituent as c on c.id=g.constituent_id $quer_paguthi $quer_date";
		$res=$this->db->query($query);
		return $result=$res->result();
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
