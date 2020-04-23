<?php
Class Constituentmodel extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
	}

####################  Constituent member ####################

	function create_constituent_member($constituency_id,$paguthi_id,$ward_id,$booth_id,$full_name,$father_husband_name,$guardian_name,$mobile_no,$whatsapp_no,$dob,$door_no,$address,$pin_code,$religion_id,$email_id,$gender,$voter_id_status,$voter_id_no,$aadhaar_status,$aadhaar_no,$party_member_status,$vote_type,$serial_no,$filename,$question_id,$question_response,$interaction_section,$user_id){
		if($aadhaar_status=='N'){
			$aadhar_id_no=' ';
		}else{
				$aadhar_id_no=$aadhaar_no;
		}
		if($voter_id_status=='N'){
			$voter_no=' ';
		}else{
			$voter_no=$voter_id_no;
		}
		$query="INSERT INTO constituent (constituency_id,paguthi_id,ward_id,booth_id,full_name,father_husband_name,guardian_name,mobile_no,whatsapp_no,dob,door_no,address,pin_code,religion_id,email_id,gender,voter_id_status,voter_id_no,aadhaar_status,aadhaar_no,party_member_status,vote_type,serial_no,profile_pic,status,created_by,created_at) VALUES ('$constituency_id','$paguthi_id','$ward_id','$booth_id','$full_name','$father_husband_name','$guardian_name','$mobile_no','$whatsapp_no','$dob','$door_no','$address','$pin_code','$religion_id','$email_id','$gender','$voter_id_status','$voter_no','$aadhaar_status','$aadhar_id_no','$party_member_status','$vote_type','$serial_no','$filename','ACTIVE','$user_id',NOW())";
		$result=$this->db->query($query);
		 $last_id=$this->db->insert_id();

		 if($interaction_section=='Y'){
			 $count_question=count($question_id);
			for($i=0;$i<$count_question;$i++){
				$insert_interaction="INSERT INTO interaction_history(constituent_id,question_id,question_response,status,created_at,created_by) VALUES('$last_id','$question_id[$i]','$question_response[$i]','Active',NOW(),'$user_id')";
				$res_interaction   = $this->db->query($insert_interaction);
			}
		 }


		if($result){
			$data=array("status"=>"success","msg"=>"sms template created Successfully","class"=>"alert alert-success");
		}else{
			$data=array("status"=>"error","msg"=>"Something went wrong","class"=>"alert alert-danger");
		}


	}



			function checkserialno($serial_no){
				$select="SELECT * FROM constituent Where serial_no='$serial_no'";
					$result=$this->db->query($select);
					if($result->num_rows()>0){
						echo "false";
						}else{
							echo "true";
					}
			}

			function checkvoter_id_no($voter_id_no){
				$select="SELECT * FROM constituent Where voter_id_no='$voter_id_no'";
					$result=$this->db->query($select);
					if($result->num_rows()>0){
						echo "false";
						}else{
							echo "true";
					}
			}

			function checkaadhaar_no($aadhaar_no){
				$select="SELECT * FROM constituent Where aadhaar_no='$aadhaar_no'";
					$result=$this->db->query($select);
					if($result->num_rows()>0){
						echo "false";
						}else{
							echo "true";
					}
			}

			function get_constituent_member_list(){
				$query="SELECT c.*,p.paguthi_name FROM constituent  as c left join paguthi  as p on p.id=c.paguthi_id order by id desc";
				$result=$this->db->query($query);
				return $result->result();
			}

####################  Constituent member ####################



}
?>
