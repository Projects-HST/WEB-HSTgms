<?php
Class Constituentmodel extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
	}

####################  Constituent member ####################

	function create_constituent_member($constituency_id,$paguthi_id,$ward_id,$booth_id,$full_name,$father_husband_name,$guardian_name,$mobile_no,$whatsapp_no,$dob,$door_no,$address,$pin_code,$religion_id,$email_id,$gender,$voter_id_status,$voter_id_no,$aadhaar_status,$aadhaar_no,$party_member_status,$vote_type,$serial_no,$filename,$question_id,$question_response,$interaction_section,$user_id){
		$select="SELECT * FROM constituent where serial_no='$serial_no'";
		$res_select   = $this->db->query($select);
		if($res_select->num_rows()==0){
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
			$data=array("status"=>"success","msg"=>"constituent created Successfully","class"=>"alert alert-success");
		}else{
			$data=array("status"=>"error","msg"=>"Something went wrong","class"=>"alert alert-danger");
		}

	}else{
		$data=array("status"=>"error","msg"=>"Already exists!.","class"=>"alert alert-danger");
	}
	return $data;
	}


			function update_constituent_member($constituency_id,$paguthi_id,$ward_id,$booth_id,$full_name,$father_husband_name,$guardian_name,$mobile_no,$whatsapp_no,$dob,$door_no,$address,$pin_code,$religion_id,$email_id,$gender,$voter_id_status,$voter_id_no,$aadhaar_status,$aadhaar_no,$party_member_status,$vote_type,$serial_no,$filename,$status,$user_id,$constituent_id){
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
				$id=base64_decode($constituent_id)/98765;
				$update="UPDATE constituent SET constituency_id='$constituency_id',paguthi_id='$paguthi_id',ward_id='$ward_id',booth_id='$booth_id',full_name='$full_name',father_husband_name='$father_husband_name',guardian_name='$guardian_name',mobile_no='$mobile_no',whatsapp_no='$whatsapp_no',dob='$dob',door_no='$door_no',address='$address',pin_code='$pin_code',religion_id='$religion_id',email_id='$email_id',gender='$gender',voter_id_status='$voter_id_status',voter_id_no='$voter_no',aadhaar_status='$aadhaar_status',aadhaar_no='$aadhar_id_no',party_member_status='$party_member_status',vote_type='$vote_type',serial_no='$serial_no',profile_pic='$filename',status='$status',updated_at=NOW(),updated_by='$user_id' where id='$id'";

					$result=$this->db->query($update);
					if($result){
						$data=array("status"=>"success","msg"=>"constituent updated Successfully","class"=>"alert alert-success");
					}else{
						$data=array("status"=>"error","msg"=>"Something went wrong","class"=>"alert alert-danger");
					}
					return $data;



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

			function checkserialnoexist($constituent_id,$serial_no){
				$select="SELECT * FROM constituent Where serial_no='$serial_no' and id!='$constituent_id'";
					$result=$this->db->query($select);
					if($result->num_rows()>0){
						echo "false";
						}else{
							echo "true";
					}
			}

			function checkvoter_id_noexist($constituent_id,$voter_id_no){
				$select="SELECT * FROM constituent Where voter_id_no='$voter_id_no' and id!='$constituent_id'";
					$result=$this->db->query($select);
					if($result->num_rows()>0){
						echo "false";
						}else{
							echo "true";
					}
			}

			function checkaadhaar_noexist($constituent_id,$aadhaar_no){
				$select="SELECT * FROM constituent Where aadhaar_no='$aadhaar_no' and id!='$constituent_id'";
					$result=$this->db->query($select);
					if($result->num_rows()>0){
						echo "false";
						}else{
							echo "true";
					}
			}

			function get_constituent_member_list(){
				$query="SELECT IFNULL(ih.constituent_id,'0') as interaction_status,IFNULL(pd.constituent_id,'0') as plant_status,c.*,p.paguthi_name FROM constituent  as c left join paguthi  as p on p.id=c.paguthi_id
				left join interaction_history as ih on c.id=ih.constituent_id
				left join plant_donation as pd on pd.constituent_id=c.id group by c.id order by c.id desc";
				$result=$this->db->query($query);
				return $result->result();
			}

			function get_constituent_member_edit($constituent_id){
				$id=base64_decode($constituent_id)/98765;
				$query="SELECT c.*,p.paguthi_name FROM constituent  as c left join paguthi  as p on p.id=c.paguthi_id where c.id='$id'";
				$result=$this->db->query($query);
				return $result->result();
			}

####################  Constituent member ####################


################## documents upload ############################

			function get_list_document($constituent_id){
					$id=base64_decode($constituent_id)/98765;
					$query="SELECT * FROM grievance_documents where constituent_id='$id' and status='ACTIVE' order by id desc";
					$result=$this->db->query($query);
					return $result->result();
			}
			function constituent_document_upload($constituent_id,$doc_name,$filename,$user_id){
					$id=base64_decode($constituent_id)/98765;
					$insert="INSERT INTO grievance_documents(constituent_id,doc_name,doc_file_name,status,created_by,created_at,updated_by,updated_at) VALUES ('$id','$doc_name','$filename','ACTIVE','$user_id',NOW(),'$user_id',NOW())";
						$result=$this->db->query($insert);
						if($result){
							$data=array("status"=>"success","msg"=>"constituent updated Successfully","class"=>"alert alert-success");
						}else{
							$data=array("status"=>"error","msg"=>"Something went wrong","class"=>"alert alert-danger");
						}
						return $data;

			}

			function delete_document($d_id,$user_id){
					$update="UPDATE grievance_documents SET status='INACTIVE',updated_at=NOW(),updated_by='$user_id' where id='$d_id'";
					$result=$this->db->query($update);
				if($result){
					echo "success";
				}else{
						echo "failure";
				}
				// return $data;
			}
################## documents upload ############################


################## Interaction response ##############


	function save_interaction_response($constituent_id,$question_id,$question_response,$user_id){

			$id=base64_decode($constituent_id)/98765;

			$delete="DELETE FROM interaction_history where constituent_id='$id'";
			$res=	$this->db->query($delete);

			$count_question=count($question_id);
	 		for($i=0;$i<$count_question;$i++){
				 $insert_interaction="INSERT INTO interaction_history(constituent_id,question_id,question_response,status,created_at,created_by,updated_at,updated_by) VALUES('$id','$question_id[$i]','$question_response[$i]','ACTIVE',NOW(),'$user_id',NOW(),'$user_id')";
				 $res_interaction   = $this->db->query($insert_interaction);
			 }

		 if($res_interaction){
			 $data=array("status"=>"success","msg"=>"interaction saved Successfully","class"=>"alert alert-success");
		 }else{
			 $data=array("status"=>"error","msg"=>"Something went wrong","class"=>"alert alert-danger");
		 }
		 return $data;
	}

		function get_interaction_response_edit($constituent_id){
			$id=base64_decode($constituent_id)/98765;
			$query="SELECT * FROM interaction_history where constituent_id='$id' order by question_id desc";
			$result=$this->db->query($query);
			return $result->result();
		}

################## Interaction response ##############

################## plant donation ##############

	function plant_save($constituent_id,$name_of_plant,$no_of_plant,$user_id){
		$select="SELECT * FROM plant_donation where constituent_id='$constituent_id'";
		$res_select   = $this->db->query($select);
		if($res_select->num_rows()==0){
			$insert_interaction="INSERT INTO plant_donation(constituent_id,name_of_plant,no_of_plant,status,created_at,created_by) VALUES('$constituent_id','$name_of_plant','$no_of_plant','ACTIVE',NOW(),'$user_id')";
			$result   = $this->db->query($insert_interaction);
			if($result){
					$data=array("status"=>"success","msg"=>"Plant  donation saved Successfully","class"=>"alert alert-success");
				}else{
					$data=array("status"=>"error","msg"=>"Something went wrong","class"=>"alert alert-danger");
				}
		}else{
			$update="UPDATE plant_donation SET name_of_plant='$name_of_plant',no_of_plant='$no_of_plant',updated_at=NOW(),updated_by='$user_id' where constituent_id='$constituent_id'";
			$result   = $this->db->query($update);
			if($result){
					$data=array("status"=>"success","msg"=>"Plant  donation saved Successfully","class"=>"alert alert-success");
				}else{
					$data=array("status"=>"error","msg"=>"Something went wrong","class"=>"alert alert-danger");
				}
		}

			return $data;
	}


	function get_plant_donation($constituent_id,$user_id){
		$select="SELECT * FROM plant_donation where constituent_id='$constituent_id'";
		$res_select   = $this->db->query($select);
		if($res_select->num_rows()==0){
 		 $data=array("status"=>"error");
	 	 }else{
	 			 $data=array("status"=>"success","res"=>$res_select->result());
	 	 }
	 	 return $data;


	}
################## plant donation ##############


}
?>
