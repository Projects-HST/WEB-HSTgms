<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

Class Apiconstituentmodelios extends CI_Model
{
	public $app_db;
	
	function __construct()
	{
		parent::__construct();
		$this->load->model("smsmodel");
	}


    //-------------------- Version check -------------------//
	function version_check($version_code)
	{
	  if($version_code >= 1){
		  $response = array("status" => "success","version_code"=>$version_code);
	  }else{
		$response = array("status" => "error","version_code"=>$version_code);
	  }
	  return $response;
	}
	//-------------------- Version check -------------------//
	
//#################### Constituency code ####################//

	public function chk_constituency_code($constituency_code)
	{
		$dynamic_db_name = array("dynamic_db"  => 'sanzhapp_'.$constituency_code);
		
		$sql = "SELECT
					B.constituency_name,
					A.consituency_code,
					A.party_name,
					A.contact_person,
					A.email_id,
					A.mobile
				FROM
					gms_consty_user_master A,
					gms_consty_master B
				WHERE
					A.consituency_code = '".$constituency_code."' AND A.consituency_id = B.id AND A.status = 'Active'";
		$user_result = $this->db->query($sql);
		$ress = $user_result->result();
		
		if($user_result->num_rows()>0)
		{
			$response = array("status" => "Success", "msg" => "Login Successfully", "userData" => $ress, "dynamic_db" => $dynamic_db_name);
			return $response;
		} else {
			$response = array("status" => "Error", "msg" => "Invalid Institute Code");
			return $response;
		}
		$this->db->close();
	}
//#################### Constituency code End ####################//

    function generateNumericOTP() 
	{
		$n=4;
        $generator = "1357902468";
        $result = "";

        for ($i = 1; $i <= $n; $i++) {
            $result .= substr($generator, (rand()%(strlen($generator))), 1);
        }
        return $result;
    }

######## Mobile number check and sent OTP ##############
    function mobile_check($mobile_no,$dynamic_db)
	{
		//---------Dynamic DB Connection----------//
		$config_app = switch_maindb($dynamic_db);
		$this->app_db = $this->load->database($config_app, TRUE); 
		//---------Dynamic DB Connection----------//

		$select="SELECT id,full_name,father_husband_name,guardian_name,mobile_no,mobile_otp,serial_no,dob FROM constituent where mobile_no='$mobile_no'";
		$res=$this->app_db->query($select);
		if($res->num_rows()!=0){
			$result=$res->result();
			$otp=$this->generateNumericOTP();
			$update="UPDATE constituent SET mobile_otp='$otp' where mobile_no='$mobile_no'";
			$res_update=$this->app_db->query($update);
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

  	function mobile_verify($mobile_no,$otp,$gcmkey,$mobiletype,$dynamic_db)
  	{
		//---------Dynamic DB Connection----------//
		$config_app = switch_maindb($dynamic_db);
		$this->app_db = $this->load->database($config_app, TRUE); 
		//---------Dynamic DB Connection----------//
		
		$select="SELECT id,full_name,father_husband_name,guardian_name,mobile_no,mobile_otp,serial_no,dob,profile_pic FROM constituent where mobile_no='$mobile_no' and mobile_otp='$otp'";
		$res=$this->app_db->query($select);
		if($res->num_rows()!=0){
		$result=$res->result();
		foreach($result as $rows){

		  if(empty($gcmkey)){

		  }else{
			$gcmQuery = "SELECT * FROM notification_master WHERE user_id='$rows->id' and gcm_key like '%" .$gcmkey. "%' LIMIT 1";
			$gcm_result = $this->app_db->query($gcmQuery);
			$gcm_ress = $gcm_result->result();

			if($gcm_result->num_rows()==0)
			{
			  $sQuery = "INSERT INTO notification_master (user_id,user_type,gcm_key,mobile_type) VALUES ('$rows->id','3','$gcmkey','$mobiletype')";
			  $update_gcm = $this->app_db->query($sQuery);
			}
		  }

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
		  
		  $base_colour = "#1271b5";
		  $user_details[]=array(
			'id'=>$rows->id,
			'full_name'=>$rows->full_name,
			'serial_no'=>$rows->serial_no,
			'father_husband_name'=>$rows->father_husband_name,
			'dob'=>$dob,
			'profile_picture'=>$pic,
			'base_colour'=>$base_colour
		  );
		}

		$data=array('status'=>'success','msg'=>'details found','user_count'=>$res->num_rows(),'user_details'=>$user_details);
		}else{
		$data=array('status'=>'error','msg'=>'Invaild OTP');
		}
      return $data;
  	}
######## Mobile number check with OTP ##############

######## user list and details  ##############

  function user_list_and_details($mobile_no,$dynamic_db)
  {
	  
		//---------Dynamic DB Connection----------//
		$config_app = switch_maindb($dynamic_db);
		$this->app_db = $this->load->database($config_app, TRUE); 
		//---------Dynamic DB Connection----------//
		
		$select="SELECT id,full_name,father_husband_name,guardian_name,mobile_no,mobile_otp,serial_no,dob,profile_pic FROM constituent where mobile_no='$mobile_no'";
		$res=$this->app_db->query($select);
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
			  'serial_no'=>$rows->serial_no,
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

  function user_details($constituent_id,$dynamic_db)
  {
	  
	//---------Dynamic DB Connection----------//
	$config_app = switch_maindb($dynamic_db);
	$this->app_db = $this->load->database($config_app, TRUE); 
	//---------Dynamic DB Connection----------//
	
    $select="SELECT ct.*,c.constituency_name,p.paguthi_name,w.ward_name,b.booth_name,b.booth_address,r.religion_name FROM constituent as ct
    left join constituency as c on c.id=ct.constituency_id
    left join paguthi as p on p.id=ct.paguthi_id
    left join ward as w on w.id=ct.ward_id
    left join booth as b on b.id=ct.booth_id
    left join religion as r on r.id=ct.religion_id
    where ct.id='$constituent_id'";
    $res=$this->app_db->query($select);
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

  function greivance_list($user_id,$type,$dynamic_db)
  {
	//---------Dynamic DB Connection----------//
	$config_app = switch_maindb($dynamic_db);
	$this->app_db = $this->load->database($config_app, TRUE); 
	//---------Dynamic DB Connection----------//
		
    $select="SELECT g.*,st.seeker_info,gt.grievance_name,gs.sub_category_name FROM grievance as g
    left join seeker_type as st on st.id=g.seeker_type_id
    left join grievance_type as gt on gt.id=g.grievance_type_id
    left join grievance_sub_category as gs on gs.id=g.sub_category_id
    where g.constituent_id='$user_id' and g.grievance_type='$type' order by g.id desc";
    $res=$this->app_db->query($select);
    if($res->num_rows()!=0){
      $result=$res->result();
      foreach($result as $rows){
        $details[]=array(
          "id"=>$rows->id,
          "seeker_info"=>$rows->seeker_info,
          "grievance_name"=>$rows->grievance_name,
          "grievance_type"=>$rows->grievance_type,
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
  function greivance_details($user_id,$id,$dynamic_db)
  {
		//---------Dynamic DB Connection----------//
		$config_app = switch_maindb($dynamic_db);
		$this->app_db = $this->load->database($config_app, TRUE); 
		//---------Dynamic DB Connection----------//  

		$select="SELECT g.*,st.seeker_info,gt.grievance_name,gs.sub_category_name FROM grievance as g
		left join seeker_type as st on st.id=g.seeker_type_id
		left join grievance_type as gt on gt.id=g.grievance_type_id
		left join grievance_sub_category as gs on gs.id=g.sub_category_id
		where g.constituent_id='$user_id' and g.id='$id' order by g.id desc";
		$res=$this->app_db->query($select);
		if($res->num_rows()!=0){
		  $result=$res->result();
		  foreach($result as $rows){
			$details=array(
			  "id"=>$rows->id,
			  "seeker_info"=>$rows->seeker_info,
			  "grievance_name"=>$rows->grievance_name,
			  "grievance_type"=>$rows->grievance_type,
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

  function meeting_list($constituent_id,$dynamic_db)
  {
  
		//---------Dynamic DB Connection----------//
		$config_app = switch_maindb($dynamic_db);
		$this->app_db = $this->load->database($config_app, TRUE); 
		//---------Dynamic DB Connection----------//

		$select="SELECT id,constituent_id,meeting_title,meeting_detail,DATE_FORMAT(meeting_date,'%d-%m-%Y') as meeting_date,DATE_FORMAT(created_at,'%d-%m-%Y') as created_at,meeting_status FROM meeting_request where constituent_id='$constituent_id' order by id desc";
		$res=$this->app_db->query($select);
		if($res->num_rows()!=0){
		  $result=$res->result();
		  foreach($result as $rows){
			$details[]=array(
			  "id"=>$rows->id,
			  "constituent_id"=>$rows->constituent_id,
			  "created_at"=>$rows->created_at,
			  "meeting_date"=>$rows->meeting_date,
			  "meeting_title"=>$rows->meeting_title,
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

  function meeting_details($constituent_id,$id,$dynamic_db)
  {
  
		//---------Dynamic DB Connection----------//
		$config_app = switch_maindb($dynamic_db);
		$this->app_db = $this->load->database($config_app, TRUE); 
		//---------Dynamic DB Connection----------//
		
		$select="SELECT id,constituent_id,meeting_title,meeting_detail,DATE_FORMAT(meeting_date,'%d-%m-%Y') as meeting_date,DATE_FORMAT(created_at,'%d-%m-%Y') as created_at,meeting_status FROM meeting_request where constituent_id='$constituent_id' and id='$id'";
		$res=$this->app_db->query($select);
		if($res->num_rows()!=0){
		  $result=$res->result();
		  foreach($result as $rows){
			$details=array(
			  "id"=>$rows->id,
			  "constituent_id"=>$rows->constituent_id,
			  "meeting_date"=>$rows->meeting_date,
			  "meeting_title"=>$rows->meeting_title,
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

  function get_plant_donation($constituent_id,$dynamic_db)
  {
		//---------Dynamic DB Connection----------//
		$config_app = switch_maindb($dynamic_db);
		$this->app_db = $this->load->database($config_app, TRUE); 
		//---------Dynamic DB Connection----------//  

		$select="SELECT * FROM plant_donation where constituent_id='$constituent_id'";
		$res=$this->app_db->query($select);
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

  function notification_list($constituent_id,$dynamic_db)
  {
	  	//---------Dynamic DB Connection----------//
		$config_app = switch_maindb($dynamic_db);
		$this->app_db = $this->load->database($config_app, TRUE); 
		//---------Dynamic DB Connection----------//
		
		$select="SELECT id,constituent_id,sms_text,DATE_FORMAT(created_at,'%d-%m-%Y') as created_at,TIME_FORMAT(created_at,'%r') as created_time FROM grievance_reply where constituent_id='$constituent_id' order by id desc";
		$res=$this->app_db->query($select);
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

  function notification_details($constituent_id,$id,$dynamic_db)
  {
  		//---------Dynamic DB Connection----------//
		$config_app = switch_maindb($dynamic_db);
		$this->app_db = $this->load->database($config_app, TRUE); 
		//---------Dynamic DB Connection----------//
		
		$select="SELECT id,constituent_id,sms_text,DATE_FORMAT(created_at,'%d-%m-%Y') as created_at,TIME_FORMAT(created_at,'%r') as created_time FROM grievance_reply where constituent_id='$constituent_id' and id='$id'";
		$res=$this->app_db->query($select);
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


  ######### Newsfeed list ############
	function newsfeed_list($constituent_id,$dynamic_db)
	{

		//---------Dynamic DB Connection----------//
		$config_app = switch_maindb($dynamic_db);
		$this->app_db = $this->load->database($config_app, TRUE); 
		//---------Dynamic DB Connection----------//

		$select="SELECT id,DATE_FORMAT(news_date,'%d-%m-%Y') as news_date,title,details,image_file_name FROM news_feeder where status='ACTIVE' order by news_feeder.news_date desc";
		$res=$this->app_db->query($select);
		if($res->num_rows()!=0){
		$result=$res->result();
		foreach($result as $rows){
		$cur_date=date('d-m-Y');
		$news_date=$rows->news_date;
		$date1 = new DateTime(date('d-m-Y'));
		$date2 = new DateTime($news_date);
		if ($date1 >= $date2) {
		   $time_elapsed = $this->timeAgo($rows->news_date);
		}else{
		  $time_elapsed = "Upcoming";
		  }
		  $str = "paste your code! below. codepad will run it. are you sure?ok";

		$details[]=array(
		  "id"=>$rows->id,
		  "news_date"=>$news_date,
		  "date_elapsed"=>$time_elapsed,
		  "image_file_name"=>base_url().'assets/news/'.$rows->image_file_name,
		  "title"=>$rows->title,
		  "details"=>$rows->details,
		);
		}
		$data=array('status'=>'success','msg'=>'list found','news_list'=>$details);
		}else{
		$data=array('status'=>'error','msg'=>'No list found');
		}
	return $data;
	}

  ######### Newsfeed list ############

  ######### Newsfeed details ############
	function newsfeed_details($constituent_id,$id,$dynamic_db)
	{

		//---------Dynamic DB Connection----------//
		$config_app = switch_maindb($dynamic_db);
		$this->app_db = $this->load->database($config_app, TRUE); 
		//---------Dynamic DB Connection----------//

		$select="SELECT id,DATE_FORMAT(news_date,'%d-%m-%Y') as news_date,title,details,image_file_name FROM news_feeder where status='ACTIVE' and id='$id'";
		$res=$this->app_db->query($select);
		if($res->num_rows()!=0){
		$result=$res->result();
		foreach($result as $rows){
		$details=array(
		  "id"=>$rows->id,
		  "news_date"=>$rows->news_date,
		  "image_file_name"=>base_url().'assets/news/'.$rows->image_file_name,
		  "title"=>$rows->title,
		  "details"=>$rows->details,
		);
		}

		$gallery="SELECT id,image_file_name as gallery_image FROM news_gallery where news_id='$id'";
		$res_gallery=$this->app_db->query($gallery);
		if($res_gallery->num_rows()!=0){
		  $result_gallery=$res_gallery->result();
		  foreach($result_gallery as $rows_gallery){
			$galley_img[]=array(
			  "id"=>$rows->id,
			  "gallery_image"=>base_url().'assets/news/'.$rows_gallery->gallery_image,
			);
		  }
		  $gallery_data=array("status"=>"success","msg"=>"Galley image found","gallery_image"=>$galley_img);
		}else{
		  $gallery_data=array("status"=>"error","msg"=>"No Gallery image");
		}
		$data=array('status'=>'success','msg'=>'list found','news_details'=>$details,"gallery_image"=>$gallery_data);
		}else{
		$data=array('status'=>'error','msg'=>'No details found');
		}
	return $data;
	}
  ######### Newsfeed details ############

  ######### Banner list ############
	function view_banners($constituent_id,$dynamic_db)
	{
		//---------Dynamic DB Connection----------//
		$config_app = switch_maindb($dynamic_db);
		$this->app_db = $this->load->database($config_app, TRUE); 
		//---------Dynamic DB Connection----------//  

		$gallery="SELECT id,banner_image_name as gallery_image FROM banners where status='ACTIVE'";
		$res_gallery=$this->app_db->query($gallery);
		if($res_gallery->num_rows()!=0){
			$result_gallery=$res_gallery->result();
			foreach($result_gallery as $rows_gallery){
			  $galley_img[]=array(
				"id"=>$rows_gallery->id,
				"gallery_image"=>base_url().'assets/banners/'.$rows_gallery->gallery_image,
			  );
			}
			$data=array("status"=>"success","msg"=>"Banner image found","banner_image"=>$galley_img);
		}else{
			$data=array("status"=>"error","msg"=>"No Banner image");
		}
	  return $data;
	}

  ######### Banner list ############

  ######### Date elasped to ago ############

	function timeAgo($time_ago)
	{
		$time_ago = strtotime($time_ago);
		$cur_time   = time();
		$time_elapsed   = $cur_time - $time_ago;
		$seconds    = $time_elapsed ;
		$minutes    = round($time_elapsed / 60 );
		$hours      = round($time_elapsed / 3600);
		$days       = round($time_elapsed / 86400 );
		$weeks      = round($time_elapsed / 604800);
		$months     = round($time_elapsed / 2600640 );
		$years      = round($time_elapsed / 31207680 );
		// Seconds
		if($seconds <= 60){
			return "Today";
		}
		//Minutes
		else if($minutes <=60){
			if($minutes==1){
				return "one minute ago";
			}
			else{
				return "$minutes minutes ago";
			}
		}
		//Hours
		else if($hours <=24){
			if($hours==1){
				return "an hour ago";
			}else{
				return "$hours hrs ago";
			}
		}
		//Days
		else if($days <= 7){
			if($days==1){
				return "yesterday";
			}else{
				return "$days days ago";
			}
		}
		//Weeks
		else if($weeks <= 4.3){
			if($weeks==1){
				return "a week ago";
			}else{
				return "$weeks weeks ago";
			}
		}
		//Months
		else if($months <=12){
			if($months==1){
				return "a month ago";
			}else{
				return "$months months ago";
			}
		}
		//Years
		else{
			if($years==1){
				return "one year ago";
			}else{
				return "$years years ago";
			}
		}
	}
	######### Date elasped to ago ############

}
?>
