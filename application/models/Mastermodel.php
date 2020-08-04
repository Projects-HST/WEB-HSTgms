<?php
Class Mastermodel extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
	}

####################  constituency ####################

	function get_constituency(){
		$query="SELECT * FROM constituency WHERE status='ACTIVE'";
		$result=$this->db->query($query);
		return $result->result();
	}


	function update_constituency($constituency_name,$user_id){
		$query="UPDATE constituency SET constituency_name='$constituency_name',updated_at=NOW(),updated_by='$user_id' WHERE id='1'";
		$result=$this->db->query($query);
		if($result){
			$data=array("status"=>"success","msg"=>"Constituency Updated Successfully","class"=>"alert alert-success");
		}else{
			$data=array("status"=>"error","msg"=>"Something went wrong","class"=>"alert alert-danger");
		}
		return $data;
	}

####################  constituency ####################


#################### Paguthi ####################//

	function get_paguthi(){
		$query="SELECT * FROM paguthi WHERE constituency_id='1'";
		$result=$this->db->query($query);
		return $result->result();
	}

	function get_paguthi_edit($paguthi_id){
		$id=base64_decode($paguthi_id)/98765;
		$query="SELECT * FROM paguthi WHERE id='$id'";
		$result=$this->db->query($query);
		return $result->result();
	}



	function checkpaguthi($paguthi_name){
    $select="SELECT * FROM paguthi Where paguthi_name='$paguthi_name'";
      $result=$this->db->query($select);
      if($result->num_rows()>0){
        echo "false";
        }else{
          echo "true";
      }
  }
	function checkpaguthishort($paguthi_short_name){
    $select="SELECT * FROM paguthi Where paguthi_short_name='$paguthi_short_name'";
      $result=$this->db->query($select);
      if($result->num_rows()>0){
        echo "false";
        }else{
          echo "true";
      }
  }

	function checkpaguthiexist($paguthi_name,$paguthi_id){
		$select="SELECT * FROM paguthi Where paguthi_name='$paguthi_name' and id!='$paguthi_id'";
      $result=$this->db->query($select);
      if($result->num_rows()>0){
        echo "false";
        }else{
          echo "true";
      }
	}

	function checkpaguthishortexist($paguthi_short_name,$paguthi_id){
		$select="SELECT * FROM paguthi Where paguthi_short_name='$paguthi_short_name' and id!='$paguthi_id'";
			$result=$this->db->query($select);
			if($result->num_rows()>0){
				echo "false";
				}else{
					echo "true";
			}
	}


	function create_paguthi($paguthi_name,$paguthi_short_name,$status,$user_id){
		$select="SELECT * FROM paguthi Where paguthi_name='$paguthi_name'";
			$result=$this->db->query($select);
			if($result->num_rows()==0){
					$insert="INSERT INTO paguthi (constituency_id,paguthi_name,paguthi_short_name,status,created_at,created_by) VALUES ('1','$paguthi_name','$paguthi_short_name','$status',NOW(),'$user_id')";
					$result=$this->db->query($insert);
					if($result){
						$data=array("status"=>"success","msg"=>"Paguthi created Successfully","class"=>"alert alert-success");
					}else{
						$data=array("status"=>"error","msg"=>"Something went wrong","class"=>"alert alert-danger");
					}

			}else{
				$data=array("status"=>"error","msg"=>"Something went wrong","class"=>"alert alert-danger");
			}
			return $data;
	}



	function update_paguthi($paguthi_name,$paguthi_short_name,$status,$user_id,$paguthi_id){
			$id= $paguthi_id;
 		  $update="UPDATE paguthi SET paguthi_name='$paguthi_name',paguthi_short_name='$paguthi_short_name',status='$status',updated_at=NOW(),updated_by='$user_id' where id='$id'";
		  $result=$this->db->query($update);
			if($result){
				$data=array("status"=>"success","msg"=>"Paguthi updated Successfully","class"=>"alert alert-success");
			}else{
				$data=array("status"=>"error","msg"=>"Something went wrong","class"=>"alert alert-danger");
			}
			return $data;
	}
#################### Paguthi ####################//


#################### Ward ####################//

			function get_ward(){
				$query="SELECT w.*,p.paguthi_name FROM ward as w left join paguthi as p on p.id=w.paguthi_id WHERE w.constituency_id='1'";
				$result=$this->db->query($query);
				return $result->result();
			}

			function get_ward_edit($ward_id){
				$id=base64_decode($ward_id)/98765;
				$query="SELECT w.*,p.paguthi_name FROM ward as w left join paguthi as p on p.id=w.paguthi_id WHERE w.constituency_id='1' and w.id='$id'";
				$result=$this->db->query($query);
				return $result->result();
			}


			function create_ward($paguthi_id,$ward_name,$status,$user_id){
				// $select="SELECT * FROM ward Where paguthi_id='$paguthi_id' and ward_name='$ward_name'";
				$select="SELECT * FROM ward Where  ward_name='$ward_name'";
					$result=$this->db->query($select);
					if($result->num_rows()==0){
							$insert="INSERT INTO ward (constituency_id,paguthi_id,ward_name,status,created_at,created_by) VALUES ('1','$paguthi_id','$ward_name','$status',NOW(),'$user_id')";
							$result=$this->db->query($insert);
							if($result){
								$data=array("status"=>"success","msg"=>"ward created Successfully","class"=>"alert alert-success");
							}else{
								$data=array("status"=>"error","msg"=>"Something went wrong","class"=>"alert alert-danger");
							}

					}else{
						$data=array("status"=>"error","msg"=>"Something went wrong","class"=>"alert alert-danger");
					}
					return $data;
			}


			function update_ward($paguthi_id,$ward_name,$status,$user_id,$ward_id){
					$id=base64_decode($ward_id)/98765;
				// $select="SELECT * FROM ward where paguthi_id='$paguthi_id' and ward_name='$ward_name' and id!='$id'";
					$select="SELECT * FROM ward where ward_name='$ward_name' and id!='$id'";
					$result=$this->db->query($select);
					if($result->num_rows()==0){
							$update="UPDATE ward set ward_name='$ward_name',paguthi_id='$paguthi_id',status='$status',updated_at=NOW(),updated_by='$user_id' where id='$id'";
							$result=$this->db->query($update);
							if($result){
								$data=array("status"=>"success","msg"=>"ward update Successfully","class"=>"alert alert-success");
							}else{
								$data=array("status"=>"error","msg"=>"Something went wrong","class"=>"alert alert-danger");
							}

					}else{
						$data=array("status"=>"error","msg"=>"Ward already exist to paguthi","class"=>"alert alert-danger");
					}
					return $data;
			}

	#################### Ward ####################//

	#################### Booth ####################

	function get_booth($ward_id){
		$id=base64_decode($ward_id)/98765;
		$query="SELECT b.* FROM booth as b left join ward as w on w.id=b.ward_id where b.constituency_id='1' and b.ward_id='$id'";
		$result=$this->db->query($query);
		return $result->result();
	}



	function create_booth($booth_name,$booth_address,$status,$user_id,$ward_id){
		$id=base64_decode($ward_id)/98765;
		// $select="SELECT * FROM booth where ward_id='$id' and booth_name='$booth_name'";
			$select="SELECT * FROM booth where  booth_name='$booth_name'";
			$result=$this->db->query($select);
			if($result->num_rows()==0){
					$get_detail="SELECT * FROM ward where id='$id'";
					$res=$this->db->query($get_detail);
					foreach($res->result() as $rows){}
					$insert="INSERT INTO booth (constituency_id,paguthi_id,ward_id,booth_name,booth_address,status,created_at,created_by) values('$rows->constituency_id','$rows->paguthi_id','$id','$booth_name','$booth_address','$status',NOW(),'$user_id')";
					$result=$this->db->query($insert);
					if($result){
						$data=array("status"=>"success","msg"=>"Booth created Successfully","class"=>"alert alert-success");
					}else{
						$data=array("status"=>"error","msg"=>"Something went wrong","class"=>"alert alert-danger");
					}

			}else{
				$data=array("status"=>"error","msg"=>"Booth already exists","class"=>"alert alert-danger");
			}
			return $data;
	}



	function get_booth_edit($booth_id){
		$id=base64_decode($booth_id)/98765;
		$query="SELECT b.* FROM booth as b left join ward as w on w.id=b.ward_id where  b.id='$id'";
		$result=$this->db->query($query);
		return $result->result();
	}


	function update_booth($booth_name,$booth_address,$status,$user_id,$ward_id,$booth_id){
		$id=base64_decode($booth_id)/98765;
		$w_id=base64_decode($ward_id)/98765;
	 // $select="SELECT * FROM booth where ward_id='$w_id' and booth_name='$booth_name' and id!='$id'";
	 $select="SELECT * FROM booth where  booth_name='$booth_name' and id!='$id'";

		$result=$this->db->query($select);
		if($result->num_rows()==0){
				$update="UPDATE booth set booth_name='$booth_name',booth_address='$booth_address',status='$status',updated_at=NOW(),updated_by='$user_id' where id='$id'";
				$result=$this->db->query($update);
				if($result){
					$data=array("status"=>"success","msg"=>"ward update Successfully","class"=>"alert alert-success");
				}else{
					$data=array("status"=>"error","msg"=>"Something went wrong","class"=>"alert alert-danger");
				}

		}else{
			$data=array("status"=>"error","msg"=>"Booth name already exists","class"=>"alert alert-danger");
		}
		return $data;
	}

	#################### Booth ####################


	#################### Seeker type ####################

	function get_seeker(){
		$query="SELECT * FROM seeker_type";
		$result=$this->db->query($query);
		return $result->result();
	}

	function get_seeker_edit($seeker_id){
		$id=base64_decode($seeker_id)/98765;
		$query="SELECT * FROM seeker_type where id='$id'";
		$result=$this->db->query($query);
		return $result->result();
	}


	function checkseeker($seeker_info){
		$select="SELECT * FROM seeker_type Where seeker_info='$seeker_info'";
      $result=$this->db->query($select);
      if($result->num_rows()>0){
        echo "false";
        }else{
          echo "true";
      }
	}

	function checkseekerexist($seeker_info,$seeker_id){

		$select="SELECT * FROM seeker_type Where seeker_info='$seeker_info' and id!='$seeker_id'";
			$result=$this->db->query($select);
			if($result->num_rows()>0){
				echo "false";
				}else{
					echo "true";
			}
	}

	function create_seeker($seeker_info,$status,$user_id){
		$select="SELECT * FROM seeker_type Where seeker_info='$seeker_info'";
			$result=$this->db->query($select);
			if($result->num_rows()==0){
					$insert="INSERT INTO seeker_type (seeker_info,status,created_at,created_by) VALUES ('$seeker_info','$status',NOW(),'$user_id')";
					$result=$this->db->query($insert);
					if($result){
						$data=array("status"=>"success","msg"=>"Seeeker created Successfully","class"=>"alert alert-success");
					}else{
						$data=array("status"=>"error","msg"=>"Something went wrong","class"=>"alert alert-danger");
					}

			}else{
				$data=array("status"=>"error","msg"=>"Something went wrong","class"=>"alert alert-danger");
			}
			return $data;
	}

	function update_seeker($seeker_info,$status,$user_id,$seeker_id){
		$id=base64_decode($seeker_id)/98765;
		$query="UPDATE seeker_type SET seeker_info='$seeker_info',status='$status',updated_at=NOW(),updated_by='$user_id' WHERE id='$id'";
		$result=$this->db->query($query);
		if($result){
			$data=array("status"=>"success","msg"=>"Seeker type Updated Successfully","class"=>"alert alert-success");
		}else{
			$data=array("status"=>"error","msg"=>"Something went wrong","class"=>"alert alert-danger");
		}
		return $data;
	}


	#################### Seeker type ####################


	#################### Grievance type  ####################

	function get_grievance(){
		$query="SELECT g.*,s.seeker_info FROM grievance_type as g left join seeker_type as s on s.id=g.seeker_id order by g.id desc";
		$result=$this->db->query($query);
		return $result->result();
	}

	function get_grievance_edit($grievance_id){
		$id=base64_decode($grievance_id)/98765;
		$query="SELECT g.*,s.seeker_info FROM grievance_type as g left join seeker_type as s on s.id=g.seeker_id where g.id='$id'";
		$result=$this->db->query($query);
		return $result->result();
	}


	function create_grievance($seeker_id,$grievance_name,$status,$user_id){
		$select="SELECT * FROM grievance_type Where seeker_id='$seeker_id' and grievance_name='$grievance_name'";
			$result=$this->db->query($select);
			if($result->num_rows()==0){
					$insert="INSERT INTO grievance_type (seeker_id,grievance_name,status,created_at,created_by) VALUES ('$seeker_id','$grievance_name','$status',NOW(),'$user_id')";
					$result=$this->db->query($insert);
					if($result){
						$data=array("status"=>"success","msg"=>"Grievance created Successfully","class"=>"alert alert-success");
					}else{
						$data=array("status"=>"error","msg"=>"Something went wrong","class"=>"alert alert-danger");
					}

			}else{
				$data=array("status"=>"error","msg"=>"Something went wrong","class"=>"alert alert-danger");
			}
			return $data;
	}

	function update_grievance($seeker_id,$grievance_name,$status,$user_id,$grievance_id){
		$id=base64_decode($grievance_id)/98765;
	 $select="SELECT * FROM grievance_type where seeker_id='$seeker_id' and grievance_name='$grievance_name' and id!='$id'";
		$result=$this->db->query($select);
		if($result->num_rows()==0){
				$update="UPDATE grievance_type set seeker_id='$seeker_id',grievance_name='$grievance_name',status='$status',updated_at=NOW(),updated_by='$user_id' where id='$id'";
				$result=$this->db->query($update);
				if($result){
					$data=array("status"=>"success","msg"=>"grievance update Successfully","class"=>"alert alert-success");
				}else{
					$data=array("status"=>"error","msg"=>"Something went wrong","class"=>"alert alert-danger");
				}

		}else{
			$data=array("status"=>"error","msg"=>"Grievance  name already exist to seeker","class"=>"alert alert-danger");
		}
		return $data;
	}

	#################### Grievance type  ####################


	#################### Grievance Sub category type  ####################

	function get_grievance_sub_category($grievance_id){
		$id=base64_decode($grievance_id)/98765;
		$query="SELECT gsc.*,gt.grievance_name FROM grievance_sub_category as gsc left join grievance_type as gt on gt.id=gsc.grievance_id where gsc.grievance_id='$id' order by gsc.id desc";
		$result=$this->db->query($query);
		return $result->result();
	}


	function get_sub_category_edit($sub_category_id){
		$id=base64_decode($sub_category_id)/98765;
		$query="SELECT gsc.*,gt.grievance_name FROM grievance_sub_category as gsc left join grievance_type as gt on gt.id=gsc.grievance_id where gsc.id='$id'";
		$result=$this->db->query($query);
		return $result->result();
	}


	function create_sub_category_name($grievance_id,$sub_category_name,$status,$user_id){
		$id=base64_decode($grievance_id)/98765;
		$select="SELECT * FROM grievance_sub_category Where grievance_id='$id' and sub_category_name='$sub_category_name'";
			$result=$this->db->query($select);
			if($result->num_rows()==0){
					$insert="INSERT INTO grievance_sub_category (grievance_id,sub_category_name,status,created_at,created_by) VALUES ('$id','$sub_category_name','$status',NOW(),'$user_id')";
					$result=$this->db->query($insert);
					if($result){
						$data=array("status"=>"success","msg"=>"Grievance sub category created Successfully","class"=>"alert alert-success");
					}else{
						$data=array("status"=>"error","msg"=>"Something went wrong","class"=>"alert alert-danger");
					}

			}else{
				$data=array("status"=>"error","msg"=>"already exists went wrong","class"=>"alert alert-danger");
			}
			return $data;
	}



	function update_sub_category_name($grievance_id,$sub_category_name,$status,$user_id,$sub_category_id){
		$id=base64_decode($sub_category_id)/98765;
		$g_id=base64_decode($grievance_id)/98765;
		$select="SELECT * FROM grievance_sub_category where grievance_id='$g_id' and sub_category_name='$sub_category_name' and id!='$id'";
 		$result=$this->db->query($select);
 		if($result->num_rows()==0){
 				$update="UPDATE grievance_sub_category set grievance_id='$g_id',sub_category_name='$sub_category_name',status='$status',updated_at=NOW(),updated_by='$user_id' where id='$id'";
 				$result=$this->db->query($update);
 				if($result){
 					$data=array("status"=>"success","msg"=>"Sub category update Successfully","class"=>"alert alert-success");
 				}else{
 					$data=array("status"=>"error","msg"=>"Something went wrong","class"=>"alert alert-danger");
 				}

 		}else{
 			$data=array("status"=>"error","msg"=>"Subcategory  name already exist to grievance","class"=>"alert alert-danger");
 		}
 		return $data;
	}
	#################### Grievance Sub category type  ####################


	#################### Religion  ####################

	function get_religion(){
		$query="SELECT * FROM religion";
		$result=$this->db->query($query);
		return $result->result();
	}

	#################### Religion  ####################


	#################### SMS template  ####################

	function get_sms_template(){
		$query="SELECT * FROM sms_template order by id desc";
		$result=$this->db->query($query);
		return $result->result();
	}

	function get_sms_template_edit($template_id){
		$id=base64_decode($template_id)/98765;
		$query="SELECT * FROM sms_template where id='$id'";
		$result=$this->db->query($query);
		return $result->result();
	}

	function create_sms_template($template_type,$sms_title,$sms_text,$status,$user_id){
		$select="SELECT * FROM sms_template Where template_type='$template_type' and sms_title='$sms_title'";
			$result=$this->db->query($select);
			if($result->num_rows()==0){
					$insert="INSERT INTO sms_template (template_type,sms_title,sms_text,status,created_at,created_by) VALUES ('$template_type','$sms_title','$sms_text','$status',NOW(),'$user_id')";
					$result=$this->db->query($insert);
					if($result){
						$data=array("status"=>"success","msg"=>"sms template created Successfully","class"=>"alert alert-success");
					}else{
						$data=array("status"=>"error","msg"=>"Something went wrong","class"=>"alert alert-danger");
					}

			}else{
				$data=array("status"=>"error","msg"=>"template already exists","class"=>"alert alert-danger");
			}
			return $data;
	}

	function update_sms_template($template_type,$sms_title,$sms_text,$status,$user_id,$template_id){
		$id=base64_decode($template_id)/98765;
		$select="SELECT * FROM sms_template where template_type='$template_type' and sms_title='$sms_title' and id!='$id'";
 		$result=$this->db->query($select);
 		if($result->num_rows()==0){
 						$update="UPDATE sms_template set template_type='$template_type',sms_title='$sms_title',sms_text='$sms_text',status='$status',updated_at=NOW(),updated_by='$user_id' where id='$id'";
 		        $result=$this->db->query($update);
 				if($result){
 					$data=array("status"=>"success","msg"=>"sms template update Successfully","class"=>"alert alert-success");
 				}else{
 					$data=array("status"=>"error","msg"=>"Something went wrong","class"=>"alert alert-danger");
 				}

 		}else{
 			$data=array("status"=>"error","msg"=>"sms template already exists!","class"=>"alert alert-danger");
 		}
 		return $data;
	}





	#################### SMS template  ####################


	#################### Interaction question  ####################

	function get_interaction_question(){
		$query="SELECT * FROM interaction_question order by id desc";
		$result=$this->db->query($query);
		return $result->result();
	}

	function get_interaction_question_edit($interaction_id){
		$id=base64_decode($interaction_id)/98765;
		$query="SELECT * FROM interaction_question where id='$id'";
		$result=$this->db->query($query);
		return $result->result();
	}


	function create_interaction_question($widgets_title,$interaction_text,$status,$user_id){
		$select="SELECT * FROM interaction_question Where interaction_text='$interaction_text' and widgets_title='$widgets_title'";
			$result=$this->db->query($select);
			if($result->num_rows()==0){
					$insert="INSERT INTO interaction_question (widgets_title,interaction_text,status,created_at,created_by) VALUES ('$widgets_title','$interaction_text','$status',NOW(),'$user_id')";
					$result=$this->db->query($insert);
					if($result){
						$data=array("status"=>"success","msg"=>"interaction question created Successfully","class"=>"alert alert-success");
					}else{
						$data=array("status"=>"error","msg"=>"Something went wrong","class"=>"alert alert-danger");
					}

			}else{
				$data=array("status"=>"error","msg"=>"interaction question already exists","class"=>"alert alert-danger");
			}
			return $data;
	}



	function update_interaction_question($widgets_title,$interaction_text,$status,$user_id,$interaction_id){
		$id=base64_decode($interaction_id)/98765;
		$select="SELECT * FROM interaction_question where interaction_text='$interaction_text' and widgets_title='$widgets_title' and id!='$id'";
		$result=$this->db->query($select);
		if($result->num_rows()==0){
						$update="UPDATE interaction_question set widgets_title='$widgets_title',interaction_text='$interaction_text',status='$status',updated_at=NOW(),updated_by='$user_id' where id='$id'";
						$result=$this->db->query($update);
				if($result){
					$data=array("status"=>"success","msg"=>"interaction question update Successfully","class"=>"alert alert-success");
				}else{
					$data=array("status"=>"error","msg"=>"Something went wrong","class"=>"alert alert-danger");
				}

		}else{
			$data=array("status"=>"error","msg"=>"interaction question already exists!","class"=>"alert alert-danger");
		}
		return $data;
	}

	#################### Interaction question  ####################

	#################### Festival  ####################

	function get_all_festival(){
		$query="SELECT fm.*,r.religion_name FROM festival_master as fm left join religion as r on r.id=fm.religion_id";
		$result=$this->db->query($query);
		return $result->result();
	}

	function create_festival($festival_name,$religion_id,$status,$user_id){
		$select="SELECT * FROM festival_master Where festival_name='$festival_name'";
			$result=$this->db->query($select);
			if($result->num_rows()==0){
					$insert="INSERT INTO festival_master (festival_name,religion_id,status,updated_at,updated_by) VALUES ('$festival_name','$religion_id','$status',NOW(),'$user_id')";
					$result=$this->db->query($insert);
					if($result){
						$data=array("status"=>"success","msg"=>"festival created Successfully","class"=>"alert alert-success");
					}else{
						$data=array("status"=>"error","msg"=>"Something went wrong","class"=>"alert alert-danger");
					}

			}else{
				$data=array("status"=>"error","msg"=>"festival already exists","class"=>"alert alert-danger");
			}
			return $data;
	}


	function get_festival_edit($fm_id){
		$id=base64_decode($fm_id)/98765;
		$query="SELECT fm.*,r.religion_name FROM festival_master as fm left join religion as r on r.id=fm.religion_id where fm.id='$id'";
		$result=$this->db->query($query);
		return $result->result();
	}

	function update_festival($festival_name,$religion_id,$status,$user_id,$fm_id){
		$select="SELECT * FROM festival_master where  festival_name='$festival_name' and id!='$fm_id'";
		$result=$this->db->query($select);
		if($result->num_rows()==0){
						 $update="UPDATE festival_master set festival_name='$festival_name',religion_id='$religion_id',status='$status',updated_at=NOW(),updated_by='$user_id' where id='$fm_id'";
					$result=$this->db->query($update);
				if($result){
					$data=array("status"=>"success","msg"=>"Festival update Successfully","class"=>"alert alert-success");
				}else{
					$data=array("status"=>"error","msg"=>"Something went wrong","class"=>"alert alert-danger");
				}

		}else{
			$data=array("status"=>"error","msg"=>"interaction question already exists!","class"=>"alert alert-danger");
		}
		return $data;
	}


	#################### Festival  ####################


	#################### Constituent purpose active data  ####################

	function get_active_constituency(){
		$query="SELECT * FROM constituency WHERE status='ACTIVE'";
		$result=$this->db->query($query);
		return $result->result();
	}

	function get_active_paguthi(){
		$query="SELECT * FROM paguthi WHERE status='ACTIVE' and constituency_id='1' order by id desc";
		$result=$this->db->query($query);
		return $result->result();
	}

	function get_active_ward($paguthi_id){
		 $query="SELECT * FROM ward WHERE status='ACTIVE' and paguthi_id='$paguthi_id' order by id desc";
		$result=$this->db->query($query);
		if($result->num_rows()==0){
			$data=array("status"=>"error");
		}else{
				$data=array("status"=>"success","res"=>$result->result());
		}
		return $data;
	}


	function get_active_booth($ward_id){
		$query="SELECT * FROM booth where ward_id='$ward_id' and status='ACTIVE' order by id desc";
	 $result=$this->db->query($query);
	 if($result->num_rows()==0){
		 $data=array("status"=>"error");
	 }else{
			 $data=array("status"=>"success","res"=>$result->result());
	 }
	 return $data;
	}


	function get_booth_address($booth_id){
	$query="SELECT * FROM booth where id='$booth_id' and status='ACTIVE' order by id desc";
	 $result=$this->db->query($query);
	 if($result->num_rows()==0){
		 $data=array("status"=>"error");
	 }else{
			 $data=array("status"=>"success","res"=>$result->result());
	 }
	 return $data;
	}


	function get_active_interaction_question(){
		$query="SELECT * FROM interaction_question WHERE status='ACTIVE' order by id desc";
		$result=$this->db->query($query);
		return $result->result();
	}


	function get_active_seeker(){
		$query="SELECT * FROM seeker_type WHERE status='ACTIVE' order by id desc";
		$result=$this->db->query($query);
		return $result->result();
	}

	function get_active_festival(){
		$query="SELECT * FROM festival_master WHERE status='ACTIVE' order by id desc";
		$result=$this->db->query($query);
		return $result->result();
	}

	function get_grievance_active($seeker_id){
		 $query="SELECT * FROM grievance_type WHERE seeker_id='$seeker_id' and status='ACTIVE' order by id desc";
		$result=$this->db->query($query);
		if($result->num_rows()==0){
 		 $data=array("status"=>"error");
 	 }else{
 			 $data=array("status"=>"success","res"=>$result->result());
 	 }
 	 return $data;
	}

	function get_active_sub_category($grievance_id){
	  $query="SELECT * FROM grievance_sub_category WHERE grievance_id='$grievance_id' and status='ACTIVE' order by id desc";
		$result=$this->db->query($query);
		if($result->num_rows()==0){
		 $data=array("status"=>"error");
		 }else{
				 $data=array("status"=>"success","res"=>$result->result());
		 }
	 	return $data;
	}


	function get_ward_paguthi_details($booth_id){
		$query="SELECT b.id as booth_id,b.booth_name,w.ward_name,w.id as ward_id,p.paguthi_name,p.id as paguthi_id FROM booth as b left join ward as w on w.id=b.ward_id left join paguthi as p on p.id=b.paguthi_id
		where b.id='$booth_id' and b.status='ACTIVE'";
		$result=$this->db->query($query);
		if($result->num_rows()==0){
		 $data=array("status"=>"error");
		 }else{
				 $data=array("status"=>"success","res"=>$result->result());
		 }
	 	return $data;
	}

	function get_active_religion(){
		$query="SELECT * FROM religion WHERE status='ACTIVE' order by id asc";
		$result=$this->db->query($query);
		return $result->result();
	}

	function get_active_booth_address(){
		$query="SELECT * FROM booth WHERE status='ACTIVE' order by id asc";
		$result=$this->db->query($query);
		return $result->result();
	}


	function get_active_template(){
		$query="SELECT * FROM sms_template WHERE status='ACTIVE' order by id asc";
		$result=$this->db->query($query);
		return $result->result();
	}


	function get_sms_text($sms_id,$user_id){
		$query="SELECT * FROM sms_template WHERE status='ACTIVE' and id='$sms_id'";
	 $result=$this->db->query($query);
	 if($result->num_rows()==0){
		$data=array("status"=>"error");
	}else{
			$data=array("status"=>"success","res"=>$result->result());
	}
	return $data;
	}
	#################### Constituent purpose active data  ####################


}
?>
