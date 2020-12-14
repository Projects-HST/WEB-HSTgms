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
		// $query="SELECT c.paguthi_id,p.paguthi_name  FROM constituent as c
		// left join paguthi as p on p.id=c.paguthi_id GROUP by paguthi_id";
		$query="SELECT id as paguthi_id,paguthi_name  FROM paguthi where status='ACTIVE'";
		$res=$this->db->query($query);
		return $result=$res->result();
	}

	function get_dashboard_result($paguthi_id,$office_id,$from_date,$to_date){

		if($paguthi_id=='ALL' || empty($paguthi_id)){
			$quer_paguthi="";
		}else{
			$quer_paguthi="WHERE paguthi_id='$paguthi_id'";
		}

		if($office_id=='ALL' || empty($office_id)){
			$quer_office="";
		}else{
			if($paguthi_id=='ALL' || empty($paguthi_id)){
				$quer_office="WHERE office_id='$office_id'";
			}else{
			$quer_office="AND office_id='$office_id'";
			}

		}

		if(empty($from_date)){
			$quer_date="";
		}else{
			$dateTime1 = new DateTime($from_date);
			$one_date=date_format($dateTime1,'Y-m-d' );

			$dateTime2 = new DateTime($to_date);
			$two_date=date_format($dateTime2,'Y-m-d' );
					// echo $paguthi_id;exit;
			if($paguthi_id==''){
				if($office_id==''){
					$quer_date="WHERE DATE(created_at) BETWEEN '$one_date' and '$two_date'";
				}else{
					$quer_date="AND DATE(created_at) BETWEEN '$one_date' and '$two_date'";
				}

			}else{
				$quer_date="AND DATE(created_at) BETWEEN '$one_date' and '$two_date'";

			}

		}
		// echo $quer_date;exit;



		  $query="SELECT
			IFNULL(count(*),'0') AS total,
			IFNULL(sum(case when volunteer_status = 'Y' then constituency_id='1' else 0 end),'0') AS no_of_volunteer,
			IFNULL(sum(case when volunteer_status = 'Y' then constituency_id='1' else 0 end)/ count(*) *100,'0') as no_of_volut_percentage,
      IFNULL(sum(case when volunteer_status = 'Y' then constituency_id='0' else 0 end),'0') AS no_of_nonvolunteer,
			IFNULL(sum(case when volunteer_status = 'Y' then constituency_id='0' else 0 end)/ count(*) *100,'0') as no_of_nonvolut_percentage ,
			IFNULL(sum(case when gender = 'M' then 1 else 0 end),'0') AS malecount,
			IFNULL(sum(case when gender = 'M' then 1 else 0 end) / count(*) * 100,'0') as malepercenatge,
			IFNULL(sum(case when gender = 'F' then 1 else 0 end),'0') AS femalecount,
      IFNULL(sum(case when gender = 'F' then 1 else 0 end) / count(*) * 100,'0') as femalepercenatge,
			IFNULL(sum(case when gender = 'T' then 1 else 0 end),'0') AS others,
      IFNULL(sum(case when gender = 'T' then 1 else 0 end) / count(*) * 100,'0') as otherpercenatge,
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
      IFNULL(sum(case when whatsapp_no != '' then 1 else 0 end) / count(*) * 100,'0') as whatsapp_percentage,
			IFNULL(sum(case when whatsapp_broadcast = 'Y' then 1 else 0 end),'0') AS having_whatsapp_broadcast,
      IFNULL(sum(case when whatsapp_broadcast = 'Y' then 1 else 0 end) / count(*) * 100,'0') as broadcast_percentage,
			IFNULL(sum(case when voter_id_no!= '' then 1 else 0 end) / count(*) * 100,'0') as having_voter_percenatge,
			IFNULL(sum(case when voter_id_no!= '' then 1 else 0 end),'0') AS having_vote_id,
			IFNULL(sum(case when dob!= '0000-00-00' then 1 else 0 end) / count(*) * 100,'0') as having_dob_percentage,
			IFNULL(sum(case when dob!= '0000-00-00' then 1 else 0 end),'0') AS having_dob
			from  constituent $quer_paguthi $quer_office $quer_date";


			$res=$this->db->query($query);
			return $result=$res->result();

	}



	function get_grievance_report($paguthi_id,$office_id,$from_date,$to_date)
	{

		if($paguthi_id=='ALL' || empty($paguthi_id)){
			$quer_paguthi_cons="";
		}else{
			$quer_paguthi_cons="WHERE c.paguthi_id='$paguthi_id'";
		}

		if($paguthi_id=='ALL' || empty($paguthi_id)){
		$quer_paguthi_video="";
	}else{
		$quer_paguthi_video="AND c.paguthi_id='$paguthi_id'";
	}

		if($office_id=='ALL' || empty($office_id)){
			$quer_office_cons="";
		}else{
			$quer_office_cons="AND c.office_id='$office_id'";
		}




		if(empty($from_date)){
			$quer_mr_date="";
		}else{
			$dateTime1 = new DateTime($from_date);
			$one_date=date_format($dateTime1,'Y-m-d' );

			$dateTime2 = new DateTime($to_date);
			$two_date=date_format($dateTime2,'Y-m-d' );

			if(empty($quer_paguthi_cons)){
				$quer_mr_date="WHERE DATE(mr.created_at) BETWEEN '$one_date' and '$two_date'";
			}else{
				$quer_mr_date="AND DATE(mr.created_at) BETWEEN '$one_date' and '$two_date'";
			}
		}

		if(empty($from_date)){
			$quer_bw_date="";
			$quer_cv_date="";
			$quer_fw_date="";
		}else{
			$dateTime1 = new DateTime($from_date);
			$one_date=date_format($dateTime1,'Y-m-d' );

			$dateTime2 = new DateTime($to_date);
			$two_date=date_format($dateTime2,'Y-m-d' );

			if(empty($quer_paguthi_cons)){
				$quer_bw_date="WHERE DATE(br.created_at) BETWEEN '$one_date' and '$two_date'";
			}else{
				$quer_bw_date="AND DATE(br.created_at) BETWEEN '$one_date' and '$two_date'";
			}

			if(empty($quer_paguthi_video)){
				$quer_cv_date="AND DATE(cv.updated_at) BETWEEN '$one_date' and '$two_date'";
			}else{
				$quer_cv_date="AND DATE(cv.updated_at) BETWEEN '$one_date' and '$two_date'";
			}

			if(empty($quer_paguthi_cons)){
				$quer_fw_date="WHERE DATE(fw.updated_at) BETWEEN '$one_date' and '$two_date'";
			}else{
				$quer_fw_date="AND DATE(fw.updated_at) BETWEEN '$one_date' and '$two_date'";
			}
		}



		  // echo  $query_1="SELECT s.seeker_info,IFNULL(count(*),'0') as total,
			// 			IFNULL(sum(case when g.repeated_status = 'N' then 1 else 0 end),'0') AS unique_count,
			// 			IFNULL(sum(case when g.repeated_status = 'R' then 1 else 0 end),'0') AS repeat_count
			// 			FROM grievance as g
			// 			left join seeker_type as s on g.seeker_type_id=s.id $quer_paguthi $quer_office $quer_date
			// 			GROUP BY seeker_type_id LIMIT 2";
			// 			exit;


			 $query_3="SELECT IFNULL(count(*),'0') as total,
						IFNULL(sum(case when (mr.meeting_status = 'REQUESTED' OR mr.meeting_status = 'SCHEDULED') then 1 else 0 end),'0')  AS meeting_request_count,
            IFNULL(IFNULL(sum(case when (mr.meeting_status = 'REQUESTED' OR mr.meeting_status = 'SCHEDULED') then 1 else 0 end),'0') / count(*) * 100,'0') AS mr_percentage,
						IFNULL(sum(case when mr.meeting_status = 'COMPLETED'  then 1 else 0 end),'0')  AS meeting_complete_count,
						IFNULL(IFNULL(sum(case when mr.meeting_status = 'COMPLETED' then 1 else 0 end),'0') / count(*) * 100,'0') AS mc_percentage
						FROM meeting_request as mr
            left join constituent as c on c.id=mr.constituent_id $quer_paguthi_cons $quer_office_cons $quer_mr_date";

			$res_3=$this->db->query($query_3);
			$result_3=$res_3->result();

		 $query_4="SELECT IFNULL(count(*),'0') as birth_wish_count
						FROM consitutent_birthday_wish as br
						left join constituent as c on c.id=br.constituent_id $quer_paguthi_cons $quer_office_cons $quer_bw_date";

			$res_4=$this->db->query($query_4);
			$result_4=$res_4->result();


		 	// echo $query_5="SELECT COUNT(cv.id) as cnt_video,p.paguthi_name,o.office_name FROM constituent_video as cv
			// left join constituent as c on c.id=cv.constituent_id
			// LEFT JOIN paguthi as p on p.id=c.paguthi_id
			// LEFT JOIN office as o on o.id=c.office_id
			//  $quer_paguthi_video $quer_office_cons GROUP by c.paguthi_id
			// ORDER BY cnt_video DESC LIMIT 2";



			$query_5="SELECT p.paguthi_name,o.office_name,COUNT(cv.id) as cnt_video from office as o
			left join paguthi as p on p.id=o.paguthi_id
			left join constituent as c on c.office_id=o.id $quer_paguthi_video $quer_office_cons
			left join constituent_video as cv on cv.constituent_id=c.id $quer_cv_date
			GROUP BY o.id";





			$res_5=$this->db->query($query_5);
			$result_5=$res_5->result();

			 // $query_6="SELECT IFNULL(count(fw.id),'0') as total from festival_wishes as fw left join constituent as c on c.id=fw.constituent_id $quer_paguthi_cons $quer_office_cons $quer_fw_date GROUP BY fw.constituent_id";
			 $query_6="SELECT IFNULL(count(fw.id),'0') as total from festival_wishes as fw left join constituent as c on c.id=fw.constituent_id $quer_paguthi_cons $quer_office_cons $quer_fw_date";

			$res_6=$this->db->query($query_6);
			$result_6=$res_6->result();


			$query_7=$this->db->query("SELECT count(fw.id) as wishes_cnt,fm.festival_name FROM festival_wishes  as fw
			left join festival_master as fm on fm.id=fw.festival_id
			left join constituent as c on c.id=fw.constituent_id  $quer_paguthi_cons $quer_office_cons $quer_fw_date
			GROUP BY fw.festival_id");
			$result_7=$query_7->result();

			$data = array('mr_list'=>$result_3,'br_list'=>$result_4,'cv_list'=>$result_5,'fw_list'=>$result_6,"fm_list"=>$result_7);
			return $data;

	}


	function get_grievance_result($paguthi_id,$office_id,$from_date,$to_date){

		if($paguthi_id=='ALL' || empty($paguthi_id)){
			$quer_paguthi="";
	}else{
			$quer_paguthi="AND g.paguthi_id='$paguthi_id'";
	}

	if($office_id=='ALL' || empty($office_id)){
		$quer_office="";
	}else{
			$quer_office="AND g.office_id='$office_id'";
	}

	if(empty($from_date)){
		$quer_date="";
	}else{
		$dateTime1 = new DateTime($from_date);
		$one_date=date_format($dateTime1,'Y-m-d' );
		$dateTime2 = new DateTime($to_date);
		$two_date=date_format($dateTime2,'Y-m-d' );
		$quer_date="AND DATE(g.grievance_date) BETWEEN '$one_date' and '$two_date'";
	}


	
		$query_2=$this->db->query("SELECT count(*) as enquiry_count from grievance as g where g.grievance_type='E' AND g.enquiry_status = 'E' $quer_paguthi $quer_office $quer_date");
		$result_2=$query_2->result();

		$query_3=$this->db->query("SELECT count(*) as petition_count from grievance as g where g.grievance_type='P' $quer_paguthi $quer_office $quer_date");
		$result_3=$query_3->result();

		$query_4=$this->db->query("SELECT IFNULL(sum(case when g.status = 'PENDING' then 1 else 0 end),'0') AS no_of_pending,
        IFNULL(sum(case when g.status = 'COMPLETED' then 1 else 0 end),'0') AS no_of_completed,
        IFNULL(sum(case when g.status = 'REJECTED' then 1 else 0 end),'0') AS no_of_rejected
		FROM grievance as g  where g.grievance_type='P' $quer_paguthi $quer_office $quer_date");
		$result_4=$query_4->result();

		$query_1=$this->db->query("SELECT
		IFNULL(sum(case when g.seeker_type_id = '1' then 1 else 0 end),'0') AS no_of_online,
		IFNULL(sum(case when g.seeker_type_id = '2' then 1 else 0 end),'0') AS no_of_civic
		FROM grievance as g where g.grievance_type='P' $quer_paguthi $quer_office $quer_date");
		$result_1=$query_1->result();

		$query_1_1=$this->db->query("SELECT
		IFNULL(sum(case when g.seeker_type_id = '1' then 1 else 0 end),'0') AS no_of_online,
		IFNULL(sum(case when g.seeker_type_id = '2' then 1 else 0 end),'0') AS no_of_civic
		FROM grievance as g where g.grievance_type='E' AND g.enquiry_status = 'E' $quer_paguthi $quer_office $quer_date");
		$result_1_1=$query_1_1->result();
		
		

		//$query_5=$this->db->query("SELECT count(*) as online_enquiry_count FROM grievance  as g where g.seeker_type_id='1' and g.grievance_type='E' $quer_paguthi $quer_office $quer_date");
		//$result_5=$query_5->result();

		$query_6=$this->db->query("SELECT count(*) as online_petition_count FROM grievance  as g where g.seeker_type_id='1' and g.grievance_type='P' $quer_paguthi $quer_office $quer_date");
		$result_6=$query_6->result();


		$query_7=$this->db->query("SELECT IFNULL(sum(case when g.status = 'PENDING' then 1 else 0 end),'0') AS no_of_pending,
        IFNULL(sum(case when g.status = 'COMPLETED' then 1 else 0 end),'0') AS no_of_completed,
        IFNULL(sum(case when g.status = 'REJECTED' then 1 else 0 end),'0') AS no_of_rejected
		FROM grievance as g  where g.seeker_type_id='1' and g.grievance_type='P' $quer_paguthi $quer_office $quer_date");
		$result_7=$query_7->result();



		//$query_8=$this->db->query("SELECT count(*) as civic_enquiry_count FROM grievance as g where g.seeker_type_id='2' and g.grievance_type='E' $quer_paguthi $quer_office $quer_date");
		//$result_8=$query_8->result();

		$query_9=$this->db->query("SELECT count(*) as civic_petition_count FROM grievance  as g where g.seeker_type_id='2' and g.grievance_type='P' $quer_paguthi $quer_office $quer_date");
		$result_9=$query_9->result();

		$query_10=$this->db->query("SELECT	IFNULL(sum(case when g.status = 'PENDING' then 1 else 0 end),'0') AS no_of_pending,
				IFNULL(sum(case when g.status = 'COMPLETED' then 1 else 0 end),'0') AS no_of_completed,
				IFNULL(sum(case when g.status = 'REJECTED' then 1 else 0 end),'0') AS no_of_rejected
		FROM grievance as g  where g.seeker_type_id='2' and g.grievance_type='P' $quer_paguthi $quer_office $quer_date");
		$result_10=$query_10->result();



		$data = array('enquiry_count'=>$result_2,'petition_count'=>$result_3,'petition_list' => $result_1,'enquiry_list' => $result_1_1,'petition_status'=>$result_4,'online_petition_count'=>$result_6,'online_petition_status'=>$result_7,'civic_petition_count'=>$result_9,'civic_petition_status'=>$result_10);
		return $data;


	}


	function get_footfall_report($paguthi_id,$office_id,$from_date,$to_date){
		if($paguthi_id=='99'){
			$cons_id='99';
			$others_id='0';
			$quer_paguthi='';
			$quer_cons="AND g.constituency_id='0'";
		}else{
			$cons_id='1';
			$others_id='0';
			$quer_cons="";
			if($paguthi_id=='ALL' || empty($paguthi_id)){
				$quer_paguthi="";
			}else{
				$quer_paguthi="AND g.paguthi_id='$paguthi_id'";
			}
		}


	if($office_id=='ALL' || empty($office_id)){
		$quer_office="";
	}else{
			$quer_office="AND g.office_id='$office_id'";
	}

		if(empty($from_date)){
			$quer_date="";
		}else{
			$dateTime1 = new DateTime($from_date);
			$one_date=date_format($dateTime1,'Y-m-d' );
			$dateTime2 = new DateTime($to_date);
			$two_date=date_format($dateTime2,'Y-m-d' );
			$quer_date="AND DATE(g.grievance_date) BETWEEN '$one_date' and '$two_date'";
		}


		$query_1=$this->db->query("SELECT count(*) as cons_footfall_cnt from grievance as g where g.constituency_id='$cons_id' and g.repeated_status='N' $quer_paguthi $quer_office $quer_date");
		$result_1=$query_1->result();

		// echo $query="SELECT count(*) as other_footfall_cnt from grievance as g where g.constituency_id='$others_id' and g.repeated_status='N' $quer_paguthi $quer_office $quer_date";
		// exit;
		$query_2=$this->db->query("SELECT count(*) as other_footfall_cnt from grievance as g where g.constituency_id='$others_id' and g.repeated_status='N' $quer_paguthi $quer_office $quer_date ");
		$result_2=$query_2->result();

		$query_3=$this->db->query("SELECT count(*) as unique_cnt FROM grievance as g where repeated_status='N' $quer_cons $quer_paguthi $quer_office $quer_date");
		$result_3=$query_3->result();

		$query_4=$this->db->query("SELECT count(*) as repeated_cnt FROM grievance as g where repeated_status='R' $quer_cons $quer_paguthi $quer_office $quer_date");
		$result_4=$query_4->result();

		$query_5=$this->db->query("SELECT count(*) as cons_repeated_cnt FROM grievance as g where g.repeated_status='R' and g.constituency_id='$cons_id' $quer_paguthi $quer_office $quer_date");
		$result_5=$query_5->result();

		$query_6=$this->db->query("SELECT count(*) as new_cnt FROM grievance as g where g.repeated_status='N' and g.constituency_id='$cons_id' $quer_paguthi $quer_office $quer_date");
		$result_6=$query_6->result();

		$query_7=$this->db->query("SELECT count(*) as other_repeated_cnt FROM grievance as g where g.repeated_status='R' and g.constituency_id='$others_id' $quer_paguthi $quer_office $quer_date");
		$result_7=$query_7->result();

		$query_8=$this->db->query("SELECT count(*) as other_new_cnt FROM grievance as g where g.repeated_status='N' and g.constituency_id='$others_id' $quer_paguthi $quer_office $quer_date");
		$result_8=$query_8->result();

		$data=array("constituency_cnt"=>$result_1,"other_cnt"=>$result_2,"unique_footfall_cnt"=>$result_3,"repeated_footfall_cnt"=>$result_4,"cons_repeated_cnt"=>$result_5,"cons_unique_cnt"=>$result_6,"other_repeated_cnt"=>$result_7,"other_unique_cnt"=>$result_8);
		return $data;
	}


	function get_footfall_graph($paguthi_id,$office_id,$from_date,$to_date)
	{
			if($paguthi_id=='ALL' || empty($paguthi_id)){
				$quer_paguthi="";
			}else{
				$quer_paguthi="AND g.paguthi_id='$paguthi_id'";
			}

			if($office_id=='ALL' || empty($office_id)){
				$quer_office="";
			}else{
				$quer_office="AND g.office_id='$office_id'";
			}


			if($quer_paguthi==' '){
				$quer_date="WHERE g.grievance_date >= CURDATE() - INTERVAL 1 MONTH";
			}else{
				if(empty($from_date)){
					$quer_date="WHERE g.grievance_date >= CURDATE() - INTERVAL 1 MONTH";
				}else{
					$dateTime1 = new DateTime($from_date);
					$one_date=date_format($dateTime1,'Y-m-d' );

					$dateTime2 = new DateTime($to_date);
					$two_date=date_format($dateTime2,'Y-m-d' );
					$quer_date="WHERE DATE(g.grievance_date) BETWEEN '$one_date' and '$two_date'";

				}
			}




		// if(empty($from_date)){
		//
		// 	if(empty($quer_paguthi)){
		// 		$quer_date="WHERE g.grievance_date >= last_day(now()) + interval 1 day - interval 3 month GROUP BY day_name";
		// 	}else{
		// 		$quer_date="AND g.grievance_date >= last_day(now()) + interval 1 day - interval 3 month GROUP BY day_name";
		// 	}
		// }else{
		// 	$dateTime1 = new DateTime($from_date);
		// 	$one_date=date_format($dateTime1,'Y-m-d' );
		//
		// 	$dateTime2 = new DateTime($to_date);
		// 	$two_date=date_format($dateTime2,'Y-m-d' );
		//
		// 	if(empty($quer_paguthi)){
		// 		$quer_date="WHERE DATE(g.grievance_date) BETWEEN '$one_date' and '$two_date'";
		// 	}else{
		// 		$quer_date="AND DATE(g.grievance_date) BETWEEN '$one_date' and '$two_date'";
		// 	}
		//
		// }


	  $query="SELECT IFNULL(DATE_FORMAT(g.grievance_date,'%d-%b'),'0') as day_name,
		IFNULL(sum(case when g.repeated_status = 'N' then 1 else 0 end),'0') AS unique_count,
		IFNULL(sum(case when g.repeated_status = 'R' then 1 else 0 end),'0') AS repeat_count,
		IFNULL(sum(case when g.repeated_status = 'R' then 1 else 0 end),'0') + IFNULL(sum(case when g.repeated_status = 'N' then 1 else 0 end),'0') as total
		FROM grievance as g
		left join constituent as c on c.id=g.constituent_id $quer_date $quer_paguthi $quer_office group by g.grievance_date order by g.grievance_date asc ";

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


		function data_migration($first_id,$second_id){

		$selecting_data="SELECT cc.* FROM constituent_copy as cc
		left join constituent as c on c.voter_id_no=cc.voter_id_no
		where cc.voter_id_no!='' and c.voter_id_no!='' and cc.id BETWEEN $first_id AND $second_id";
		$result=$this->db->query($selecting_data);
		foreach($result->result() as $row_result){

		$update_1="UPDATE constituent_new SET
		constituency_id='$row_result->constituency_id',
		paguthi_id='$row_result->paguthi_id',
		office_id='$row_result->office_id',
		ward_id='$row_result->ward_id',
		booth_id='$row_result->booth_id',
		booth_address='$row_result->booth_address',
		full_name='$row_result->full_name',
		father_husband_name='$row_result->father_husband_name',
		guardian_name='$row_result->guardian_name',
		mobile_no='$row_result->mobile_no',
		mobile_otp='$row_result->mobile_otp',
		whatsapp_no='$row_result->whatsapp_no',
		whatsapp_broadcast='$row_result->whatsapp_broadcast',
		dob='$row_result->dob',
		door_no='$row_result->door_no',
		address='$row_result->address',
		pin_code='$row_result->pin_code',
		religion_id='$row_result->religion_id',
		email_id='$row_result->email_id',
		gender='$row_result->gender',
		voter_id_status='$row_result->voter_id_status',
		voter_status='$row_result->voter_status',
		voter_id_no='$row_result->voter_id_no',
		aadhaar_status='$row_result->aadhaar_status',
		aadhaar_no='$row_result->aadhaar_no',
		party_member_status='$row_result->party_member_status',
		volunteer_status='$row_result->volunteer_status',
		serial_no='$row_result->serial_no',
		profile_pic='$row_result->profile_pic',
		status='$row_result->status'
		where voter_id_no='$row_result->voter_id_no'";
		$result_1=$this->db->query($update_1);


		$update_2="UPDATE constituent_copy SET constituent_id='$row_result->id' WHERE voter_id_no='$row_result->voter_id_no'";
		$result_2=$this->db->query($update_2);


		}
		exit;


		}

}
?>
