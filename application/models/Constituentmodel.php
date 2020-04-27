<?php
Class Constituentmodel extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('smsmodel');
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

################## Meeting request ##############

	function view_meeting_request($constituent_id,$user_id){
		$select="SELECT * FROM meeting_request where constituent_id='$constituent_id' order by id desc";
		$res_select   = $this->db->query($select);
		if($res_select->num_rows()==0){
		 $data=array("status"=>"error");
		 }else{
				 $data=array("status"=>"success","res"=>$res_select->result());
		 }
		 return $data;
	}

	function edit_meeting_request($meeting_id,$user_id){
		$select="SELECT * FROM meeting_request where id='$meeting_id'";
		$res_select   = $this->db->query($select);
		if($res_select->num_rows()==0){
		 $data=array("status"=>"error");
		 }else{
				 $data=array("status"=>"success","res"=>$res_select->result());
		 }
		 return $data;
	}


	function save_meeting_request($constituent_id,$meeting_detail,$meeting_status,$user_id){
		$insert="INSERT INTO meeting_request(constituent_id,meeting_detail,meeting_status,created_at,created_by,updated_at,updated_by) VALUES('$constituent_id','$meeting_detail','$meeting_status',NOW(),'$user_id',NOW(),'$user_id')";
		$result   = $this->db->query($insert);
		if($result){
				$data=array("status"=>"success","msg"=>"meeting request saved Successfully","class"=>"alert alert-success");
			}else{
				$data=array("status"=>"error","msg"=>"Something went wrong","class"=>"alert alert-danger");
			}
			 return $data;
	}


	function update_meeting_request($meeting_id,$meeting_detail,$meeting_status,$user_id){
		$query="UPDATE meeting_request SET meeting_detail='$meeting_detail',meeting_status='$meeting_status',updated_at=NOW(),updated_by='$user_id' where id='$meeting_id'";
		$result   = $this->db->query($query);
		if($result){
				$data=array("status"=>"success","msg"=>"meeting request updated Successfully","class"=>"alert alert-success");
			}else{
				$data=array("status"=>"error","msg"=>"Something went wrong","class"=>"alert alert-danger");
			}
			 return $data;
	}

################## Meeting request ##############


################## Grievance module ##############

		function get_petition_no($paguthi_id,$grievance_type,$user_id){
			$selct_paguthi="SELECT * FROM paguthi where id ='$paguthi_id'";
			$re_paguth=$this->db->query($selct_paguthi);
			foreach($re_paguth->result() as $rows_paguthi){}
				$paguthi_short_name=$rows_paguthi->paguthi_short_name;
				$select="SELECT * FROM grievance where grievance_type='$grievance_type' order by id desc LIMIT 1";
					$res=$this->db->query($select);
					if($res->num_rows()==0){
						$next_id='001';
					}else{
						foreach($res->result() as $rows_id){}
							$next_id=$rows_id->id+1;
					}
				if($grievance_type=='P'){

					$petition_code=$paguthi_short_name."PT".$next_id;
				}else{
						$petition_code=$paguthi_short_name."EQ".$next_id;
				}

				if($petition_code){
						$data=array("status"=>"success",'petition_code'=>$petition_code);

				 }else{
					 $data=array("status"=>"error");
				 }

				return $data;

		}


		function save_grievance_data($constituent_id,$constituency_id,$paguthi_id,$seeker_id,$grievance_id,$sub_category_id,$grievance_type,$petition_enquiry_no,$description,$grievance_date,$doc_name,$filename,$reference_note,$user_id){
			$gr_date=date('Y-m-d');
			$check="SELECT * FROM grievance WHERE petition_enquiry_no='$petition_enquiry_no'";
			$res_check=$this->db->query($check);
			if($res_check->num_rows()==0){
				$insert="INSERT INTO grievance (grievance_type,constituent_id,paguthi_id,petition_enquiry_no,grievance_date,seeker_type_id,grievance_type_id,sub_category_id,reference_note,description,enquiry_status,status,created_by,created_at,updated_by,updated_at) VALUES('$grievance_type','$constituent_id','$paguthi_id','$petition_enquiry_no','$gr_date','$seeker_id','$grievance_id','$sub_category_id','$reference_note','$description','$grievance_type','PROCESSING','$user_id',NOW(),'$user_id',NOW())";
				$res=$this->db->query($insert);
				$last_id=$this->db->insert_id();
				if(empty($filename)){

				}else{
					$insert_doc="INSERT INTO grievance_documents(constituent_id,grievance_id,doc_name,doc_file_name,status,created_by,created_at,updated_by,updated_at) VALUES ('$constituent_id','$last_id','$doc_name','$filename','ACTIVE','$user_id',NOW(),'$user_id',NOW())";
						$result=$this->db->query($insert_doc);
						if($result){
								$data=array("status"=>"success","msg"=>"Grievance added Successfully","class"=>"alert alert-success");
							}else{
								$data=array("status"=>"error","msg"=>"Something went wrong","class"=>"alert alert-danger");
							}
				}
					$data=array("status"=>"success","msg"=>"Grievance added Successfully","class"=>"alert alert-success");
			}else{
				$data=array("status"=>"error","msg"=>"Petition already exists","class"=>"alert alert-danger");
			}
			return $data;


		}



		function get_all_grievance(){
			$query="SELECT g.*,c.full_name,p.paguthi_name,st.seeker_info,gt.grievance_name,gsc.sub_category_name FROM grievance as g
			left join constituent as c on c.id=g.constituent_id
			left join paguthi as p on p.id=g.paguthi_id
			left join seeker_type as st on st.id=g.seeker_type_id
			left join grievance_type as gt on gt.id=g.grievance_type_id
			left join grievance_sub_category as gsc on gsc.id=g.sub_category_id
			order by g.id desc";
			$result=$this->db->query($query);
			return $result->result();
		}

		function get_all_grievance_petition(){
			$query="SELECT g.*,c.full_name,p.paguthi_name,st.seeker_info,gt.grievance_name,gsc.sub_category_name FROM grievance as g
			left join constituent as c on c.id=g.constituent_id
			left join paguthi as p on p.id=g.paguthi_id
			left join seeker_type as st on st.id=g.seeker_type_id
			left join grievance_type as gt on gt.id=g.grievance_type_id
			left join grievance_sub_category as gsc on gsc.id=g.sub_category_id where g.grievance_type='P'
			order by g.id desc";
			$result=$this->db->query($query);
			return $result->result();
		}

		function get_all_grievance_enquiry(){
			$query="SELECT g.*,c.full_name,p.paguthi_name,st.seeker_info,gt.grievance_name,gsc.sub_category_name FROM grievance as g
			left join constituent as c on c.id=g.constituent_id
			left join paguthi as p on p.id=g.paguthi_id
			left join seeker_type as st on st.id=g.seeker_type_id
			left join grievance_type as gt on gt.id=g.grievance_type_id
			left join grievance_sub_category as gsc on gsc.id=g.sub_category_id where g.grievance_type='E'
			order by g.id desc";
			$result=$this->db->query($query);
			return $result->result();
		}


		function get_list_grievance_document($constituent_id){
				$id=base64_decode($constituent_id)/98765;
			$query="SELECT * FROM grievance_documents where constituent_id='$id' and grievance_id!='' order by id desc";
			$result=$this->db->query($query);
			return $result->result();
		}


		function get_grievance_status($grievance_id,$user_id){
			$select="SELECT * FROM grievance where id='$grievance_id'";
			$res_select   = $this->db->query($select);
			if($res_select->num_rows()==0){
			 $data=array("status"=>"error");
			 }else{
					 $data=array("status"=>"success","res"=>$res_select->result());
			 }
			 return $data;
		}


		function update_grievance_status($grievance_id,$status,$sms_text,$constituent_id,$sms_id,$user_id){
			$select="SELECT * FROM constituent where id='$constituent_id'";
			$res=$this->db->query($select);
			foreach($res->result() as $rows){}
			$to_phone=$rows->mobile_no;
			$smsContent=utf8_encode($sms_text);
			$this->smsmodel->sendSMS($to_phone,$smsContent);

			$insert="INSERT INTO grievance_reply (grievance_id,constituent_id,sms_template_id,sms_text,created_at,created_by) VALUES ('$grievance_id','$constituent_id','$sms_id','$sms_text',NOW(),'$user_id')";
			$result_insert=$this->db->query($insert);

			$update="UPDATE grievance SET status='$status',updated_at=NOW(),updated_by='$user_id' WHERE id='$grievance_id'";
			$result=$this->db->query($update);
			if($result){
					$data=array("status"=>"success","msg"=>"Grievance status updated Successfully","class"=>"alert alert-success");
				}else{
					$data=array("status"=>"error","msg"=>"Something went wrong","class"=>"alert alert-danger");
				}
				return $data;
		}


		function reply_grievance_text($grievance_id,$sms_text,$constituent_id,$sms_id,$user_id){
			$select="SELECT * FROM constituent where id='$constituent_id'";
			$res=$this->db->query($select);
			foreach($res->result() as $rows){}
			$to_phone=$rows->mobile_no;
			$smsContent=utf8_encode($sms_text);
			$this->smsmodel->sendSMS($to_phone,$smsContent);

			$insert="INSERT INTO grievance_reply (grievance_id,constituent_id,sms_template_id,sms_text,created_at,created_by) VALUES ('$grievance_id','$constituent_id','$sms_id','$sms_text',NOW(),'$user_id')";
			$result_insert=$this->db->query($insert);
			if($result_insert){
					$data=array("status"=>"success","msg"=>"Constituent reply sent Successfully","class"=>"alert alert-success");
				}else{
					$data=array("status"=>"error","msg"=>"Something went wrong","class"=>"alert alert-danger");
				}
				return $data;
		}


		function update_refernce_note($grievance_id,$reference_note,$user_id){
			$update="UPDATE grievance SET reference_note='$reference_note',updated_at=NOW(),updated_by='$user_id' WHERE id='$grievance_id'";
			$result=$this->db->query($update);
			if($result){
					$data=array("status"=>"success","msg"=>"Grievance reference updated Successfully","class"=>"alert alert-success");
				}else{
					$data=array("status"=>"error","msg"=>"Something went wrong","class"=>"alert alert-danger");
				}
				return $data;
		}

		function update_grievance_data($grievance_id,$seeker_id,$reference_note,$sub_category_id,$grievance_tb_id,$description,$user_id){
			$id=base64_decode($grievance_tb_id)/98765;
			$update="UPDATE grievance SET seeker_type_id='$seeker_id',grievance_type_id='$grievance_id',sub_category_id='$sub_category_id',description='$description',reference_note='$reference_note',updated_at=NOW(),updated_by='$user_id' WHERE id='$id'";
			$result=$this->db->query($update);
			if($result){
					$data=array("status"=>"success","msg"=>"Grievance updated Successfully","class"=>"alert alert-success");
				}else{
					$data=array("status"=>"error","msg"=>"Something went wrong","class"=>"alert alert-danger");
				}
				return $data;
		}

		function list_grievance_reply(){
			$query="SELECT gr.*,c.full_name,u.full_name as sent_by from grievance_reply as gr
			left join constituent as c on c.id=gr.constituent_id
			left join user_master as u on u.id=gr.created_by order by id desc";
			$result=$this->db->query($query);
			return $result->result();
		}



		function get_constituent_grievance_edit($grievance_id){
			$id=base64_decode($grievance_id)/98765;
			$query="SELECT g.*,c.full_name,p.paguthi_name,st.seeker_info,gt.grievance_name,gsc.sub_category_name FROM grievance as g
			left join constituent as c on c.id=g.constituent_id
			left join paguthi as p on p.id=g.paguthi_id
			left join seeker_type as st on st.id=g.seeker_type_id
			left join grievance_type as gt on gt.id=g.grievance_type_id
			left join grievance_sub_category as gsc on gsc.id=g.sub_category_id
			where  g.id='$id'";
			$result=$this->db->query($query);
			return $result->result();
		}



################## Grievance module ##############

################## Constituent Profile view only ##############

	function get_constituent_profile($constituent_id){
		$id=base64_decode($constituent_id)/98765;
		$query="SELECT c.*,ct.constituency_name,p.paguthi_name,w.ward_name,b.booth_name,b.booth_address,r.religion_name FROM constituent as c
		left join constituency as ct on ct.id-c.constituency_id
		left join paguthi as p on p.id=c.paguthi_id
		left join ward as w on w.id=c.ward_id
		left join booth as b on b.id=c.booth_id
		left join religion as r on r.id=c.religion_id
		where c.id='$id'";
		$result=$this->db->query($query);
		return $result->result();
	}


	function get_constituent_grievance($constituent_id){
			$id=base64_decode($constituent_id)/98765;
			$query="SELECT g.*,c.full_name,p.paguthi_name,st.seeker_info,gt.grievance_name,gsc.sub_category_name FROM grievance as g
			left join constituent as c on c.id=g.constituent_id
			left join paguthi as p on p.id=g.paguthi_id
			left join seeker_type as st on st.id=g.seeker_type_id
			left join grievance_type as gt on gt.id=g.grievance_type_id
			left join grievance_sub_category as gsc on gsc.id=g.sub_category_id
			where  g.constituent_id='$id'";
			$result=$this->db->query($query);
			return $result->result();
	}

	function get_constituent_meeting($constituent_id){
			$id=base64_decode($constituent_id)/98765;
			$query="SELECT * FROM meeting_request where constituent_id='$id' order by id desc";
			$result=$this->db->query($query);
			return $result->result();
	}

	function get_constituent_plant($constituent_id){
		$id=base64_decode($constituent_id)/98765;
		$query="SELECT * FROM plant_donation where constituent_id='$id'";
		$result=$this->db->query($query);
		return $result->result();
	}



	################## Constituent Profile view only ##############

}
?>
