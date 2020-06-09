<?php
Class Apiconstituentmodel extends CI_Model
{
  function __construct()
    {
    parent::__construct();
    $this->load->model("smsmodel");
    }


    function generateNumericOTP() {
      $n=4;
        $generator = "1357902468";
        $result = "";

        for ($i = 1; $i <= $n; $i++) {
            $result .= substr($generator, (rand()%(strlen($generator))), 1);
        }
        return $result;
    }

######## Mobile number check and sent OTP ##############
    function mobile_check($mobile_no){
      $select="SELECT id,full_name,father_husband_name,guardian_name,mobile_no,mobile_otp,serial_no,dob FROM constituent where mobile_no='$mobile_no'";
      $res=$this->db->query($select);
      if($res->num_rows()!=0){
        $result=$res->result();
        $otp=$this->generateNumericOTP();
        $update="UPDATE constituent SET mobile_otp='$otp' where mobile_no='$mobile_no'";
        $res_update=$this->db->query($update);
        $to_phone=$mobile_no;
        $smsContent='Verification OTP.'.$otp;
        $this->smsmodel->sendSMS($to_phone,$smsContent);

        $data=array('status'=>'success','msg'=>'details found','mobile_otp'=>$otp);
      }else{
        $data=array('status'=>'error','msg'=>'No details found for this mobile number');
      }
      return $data;
    }
######## Mobile number check and sent OTP ##############

######## Mobile number check with OTP ##############

  	function mobile_verify($mobile_no,$otp,$gcmkey,$mobiletype)
  	{
      $select="SELECT id,full_name,father_husband_name,guardian_name,mobile_no,mobile_otp,serial_no,dob,profile_pic FROM constituent where mobile_no='$mobile_no' and mobile_otp='$otp'";
      $res=$this->db->query($select);
      if($res->num_rows()!=0){
        $result=$res->result();
        foreach($result as $rows){
          if($rows->dob=='0000-00-00'){
            $dob='';
          }else{
            $dob=date("d-m-Y",  strtotime($rows->dob));
          }
          if(empty($rows->profile_pic)){
            $pic=base_url().'assets/constituent/default.png';
          }else{
            $pic=base_url().'assets/constituent/'.$rows->profile_pic;
          }

          $user_details[]=array(
            'id'=>$rows->id,
            'full_name'=>$rows->full_name,
            'father_husband_name'=>$rows->father_husband_name,
            'dob'=>$dob,
            'profile_picture'=>$pic,
          );
        }

        $data=array('status'=>'success','msg'=>'details found','user_count'=>$res->num_rows(),'user_details'=>$user_details);
      }else{
        $data=array('status'=>'error','msg'=>'No details found for this mobile number');
      }
      return $data;
  	}
######## Mobile number check with OTP ##############

  ######## user list and details  ##############

  function user_list_and_details($mobile_no)
  {
    $select="SELECT id,full_name,father_husband_name,guardian_name,mobile_no,mobile_otp,serial_no,dob FROM constituent where mobile_no='$mobile_no'";
    $res=$this->db->query($select);
    if($res->num_rows()!=0){
      $result=$res->result();
      foreach($result as $rows){
        if($rows->dob=='0000-00-00'){
          $dob='';
        }else{
          $dob=date("d-m-Y",  strtotime($rows->dob));
        }
        if(empty($rows->profile_pic)){
          $pic=base_url().'assets/constituent/default.png';
        }else{
          $pic=base_url().'assets/constituent/'.$rows->profile_pic;
        }

        $user_details[]=array(
          'id'=>$rows->id,
          'full_name'=>$rows->full_name,
          'father_husband_name'=>$rows->father_husband_name,
          'dob'=>$dob,
          'profile_picture'=>$pic,
        );
      }
        $data=array('status'=>'success','msg'=>'details found','user_count'=>$res->num_rows(),'user_details'=>$user_details);

    }else{
      $data=array('status'=>'error','msg'=>'No details found for this mobile number');
    }
    return $data;
  }
  ######## user list and details  ##############


  ######### user details ############

  function user_details($constituent_id){
    $select="SELECT ct.*,c.constituency_name,p.paguthi_name,w.ward_name,b.booth_name,b.booth_address,r.religion_name FROM constituent as ct
    left join constituency as c on c.id=ct.constituency_id
    left join paguthi as p on p.id=ct.paguthi_id
    left join ward as w on w.id=ct.ward_id
    left join booth as b on b.id=ct.booth_id
    left join religion as r on r.id=ct.religion_id
    where ct.id='$constituent_id'";
    $res=$this->db->query($select);
    if($res->num_rows()!=0){
      $result=$res->result();
      foreach($result as $rows){}
        if($rows->dob=='0000-00-00'){
          $dob='';
        }else{
          $dob=date("d-m-Y",  strtotime($rows->dob));
        }
        if(empty($rows->profile_pic)){
          $pic=base_url().'assets/constituent/default.png';
        }else{
          $pic=base_url().'assets/constituent/'.$rows->profile_pic;
        }

        $user_details[]=array(
          'id'=>$rows->id,
          'full_name'=>$rows->full_name,
          'address'=>$rows->address,
          'pin_code'=>$rows->pin_code,
          'father_husband_name'=>$rows->father_husband_name,
          'mobile_no'=>$rows->mobile_no,
          'whatsapp_no'=>$rows->whatsapp_no,
          'email_id'=>$rows->email_id,
          'religion_name'=>$rows->religion_name,
          'constituency_name'=>$rows->constituency_name,
          'paguthi_name'=>$rows->paguthi_name,
          'ward_name'=>$rows->ward_name,
          'booth_name'=>$rows->booth_name,
          'booth_address'=>$rows->booth_address,
          'serial_no'=>$rows->serial_no,
          'aadhaar_no'=>$rows->aadhaar_no,
          'voter_id_no'=>$rows->voter_id_no,
          'dob'=>$dob,
          'gender'=>$rows->gender,
          'profile_picture'=>$pic,
        );

        $data=array('status'=>'success','msg'=>'details found','user_details'=>$user_details);

    }else{
        $data=array('status'=>'error','msg'=>'No details found');
    }
      return $data;


  }

  ######### user details ############

  ######### grievance list ############

  function greivance_list($user_id,$type){
    $select="SELECT g.*,st.seeker_info,gt.grievance_name,gs.sub_category_name FROM grievance as g
    left join seeker_type as st on st.id=g.seeker_type_id
    left join grievance_type as gt on gt.id=g.grievance_type_id
    left join grievance_sub_category as gs on gs.id=g.sub_category_id
    where g.constituent_id='$user_id' and g.grievance_type='$type' order by g.id desc";
    $res=$this->db->query($select);
    if($res->num_rows()!=0){
      $result=$res->result();
      foreach($result as $rows){
        $details[]=array(
          "id"=>$rows->id,
          "seeker_info"=>$rows->seeker_info,
          "grievance_name"=>$rows->grievance_name,
          "sub_category_name"=>$rows->sub_category_name,
          "petition_enquiry_no"=>$rows->petition_enquiry_no,
          "grievance_date"=>date("d-m-Y",  strtotime($rows->grievance_date)),
          "reference_note"=>$rows->reference_note,
          "description"=>$rows->description,
          "status"=>$rows->status,
        );
      }
      $data=array('status'=>'success','msg'=>'list found','grievance_list'=>$details);
    }else{
        $data=array('status'=>'error','msg'=>'No list found');
    }
  return $data;

  }

  ######### grievance list ############

  ######### grievance details ############
  function greivance_details($user_id,$id){
    $select="SELECT g.*,st.seeker_info,gt.grievance_name,gs.sub_category_name FROM grievance as g
    left join seeker_type as st on st.id=g.seeker_type_id
    left join grievance_type as gt on gt.id=g.grievance_type_id
    left join grievance_sub_category as gs on gs.id=g.sub_category_id
    where g.constituent_id='$user_id' and g.id='$id' order by g.id desc";
    $res=$this->db->query($select);
    if($res->num_rows()!=0){
      $result=$res->result();
      foreach($result as $rows){
        $details=array(
          "id"=>$rows->id,
          "seeker_info"=>$rows->seeker_info,
          "grievance_name"=>$rows->grievance_name,
          "sub_category_name"=>$rows->sub_category_name,
          "petition_enquiry_no"=>$rows->petition_enquiry_no,
          "grievance_date"=>date("d-m-Y",  strtotime($rows->grievance_date)),
          "reference_note"=>$rows->reference_note,
          "description"=>$rows->description,
          "status"=>$rows->status,
        );
      }
      $data=array('status'=>'success','msg'=>'details found','grievance_details'=>$details);
    }else{
        $data=array('status'=>'error','msg'=>'No details found');
    }
  return $data;

  }
  ######### grievance details ############

  ######### Meeting list ############

  function meeting_list($constituent_id){
    $select="SELECT id,constituent_id,meeting_detail,DATE_FORMAT(meeting_date,'%d-%m-%Y') as meeting_date,DATE_FORMAT(created_at,'%d-%m-%Y') as created_at,meeting_status FROM meeting_request where constituent_id='$constituent_id' order by id desc";
    $res=$this->db->query($select);
    if($res->num_rows()!=0){
      $result=$res->result();
      foreach($result as $rows){
        $details[]=array(
          "id"=>$rows->id,
          "constituent_id"=>$rows->constituent_id,
          "created_at"=>$rows->created_at,
          "meeting_date"=>$rows->meeting_date,
          "meeting_detail"=>$rows->meeting_detail,
          "meeting_status"=>$rows->meeting_status,
        );
      }
      $data=array('status'=>'success','msg'=>'list found','meeting_list'=>$details);
    }else{
        $data=array('status'=>'error','msg'=>'No list found');
    }
  return $data;
  }

  ######### Meeting list ############

  ######### Meeting details ############

  function meeting_details($constituent_id,$id){
    $select="SELECT id,constituent_id,meeting_detail,DATE_FORMAT(meeting_date,'%d-%m-%Y') as meeting_date,DATE_FORMAT(created_at,'%d-%m-%Y') as created_at,meeting_status FROM meeting_request where constituent_id='$constituent_id' and id='$id'";
    $res=$this->db->query($select);
    if($res->num_rows()!=0){
      $result=$res->result();
      foreach($result as $rows){
        $details=array(
          "id"=>$rows->id,
          "constituent_id"=>$rows->constituent_id,
          "meeting_date"=>$rows->meeting_date,
          "created_at"=>$rows->created_at,
          "meeting_detail"=>$rows->meeting_detail,
          "meeting_status"=>$rows->meeting_status,
        );
      }
      $data=array('status'=>'success','msg'=>'details found','meeting_details'=>$details);
    }else{
        $data=array('status'=>'error','msg'=>'No details found');
    }
  return $data;
  }

  ######### Meeting details ############

  ######### Plant donation ############

  function get_plant_donation($constituent_id){
    $select="SELECT * FROM plant_donation where constituent_id='$constituent_id'";
    $res=$this->db->query($select);
    if($res->num_rows()!=0){
      $result=$res->result();
      foreach($result as $rows){
        $details=array(
          "id"=>$rows->id,
          "constituent_id"=>$rows->constituent_id,
          "no_of_plant"=>$rows->no_of_plant,
          "name_of_plant"=>$rows->name_of_plant,
          "created_at"=>date("d-m-Y",  strtotime($rows->created_at)),
        );
      }
      $data=array('status'=>'success','msg'=>'plant donation found','details'=>$details);
    }else{
        $data=array('status'=>'error','msg'=>'No details found');
    }
  return $data;
  }

  ######### Plant donation ############

  ######### Notification list ############

  function notification_list($constituent_id){
    $select="SELECT id,constituent_id,sms_text,DATE_FORMAT(created_at,'%d-%m-%Y') as created_at,TIME_FORMAT(created_at,'%h-%i') as created_time FROM grievance_reply where constituent_id='$constituent_id' order by id desc";
    $res=$this->db->query($select);
    if($res->num_rows()!=0){
      $result=$res->result();
      foreach($result as $rows){
        $details[]=array(
          "id"=>$rows->id,
          "constituent_id"=>$rows->constituent_id,
          "created_at"=>$rows->created_at,
          "created_time"=>$rows->created_time,
          "notification_text"=>$rows->sms_text,
        );
      }
      $data=array('status'=>'success','msg'=>'list found','notification_list'=>$details);
    }else{
        $data=array('status'=>'error','msg'=>'No list found');
    }
  return $data;
  }

  ######### Notification list ############

  ######### Notification details ############

  function notification_details($constituent_id,$id){
    $select="SELECT id,constituent_id,sms_text,DATE_FORMAT(created_at,'%d-%m-%Y') as created_at,TIME_FORMAT(created_at,'%h-%i') as created_time FROM grievance_reply where constituent_id='$constituent_id' and id='$id'";
    $res=$this->db->query($select);
    if($res->num_rows()!=0){
      $result=$res->result();
      foreach($result as $rows){
        $details=array(
          "id"=>$rows->id,
          "constituent_id"=>$rows->constituent_id,
          "created_at"=>$rows->created_at,
            "created_time"=>$rows->created_time,
          "notification_text"=>$rows->sms_text,
        );
      }
      $data=array('status'=>'success','msg'=>'details found','notification_details'=>$details);
    }else{
        $data=array('status'=>'error','msg'=>'No list found');
    }
  return $data;
  }

  ######### Notification details ############



}
?>
