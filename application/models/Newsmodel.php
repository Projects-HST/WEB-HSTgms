<?php
Class Newsmodel extends CI_Model
{
	public function __construct()
	{
	  parent::__construct();
		$this->load->model('mailmodel');
		$this->load->model('smsmodel');
		$this->load->model('notificationmodel');
	}


	function get_constituency(){
		$query="SELECT * FROM constituency WHERE status='ACTIVE'";
		$result=$this->db->query($query);
		return $result->result();
	}


	function add_news($constituency_id,$news_date,$news_title,$news_details,$status,$news_pic,$notify,$user_id){
		$select="SELECT * FROM news_feeder Where title='$news_title'";
		$result=$this->db->query($select);
		if($result->num_rows()==0){

			$insert = "INSERT INTO news_feeder(constituency_id,news_date,title,details,image_file_name,status,created_at,created_by) VALUES ('$constituency_id','$news_date','$news_title','$news_details','$news_pic','$status',NOW(),'$user_id')";
			$result = $this->db->query($insert);
	

			if ($notify == 'Y') {
				$sQuery = "SELECT * FROM notification_master";
				$result = $this->db->query($sQuery);
				if($result->num_rows()>0)
				{
					foreach ($result->result() as $rows)
					{
						$gcm_key = $rows->gcm_key;
						$mobile_type = $rows->mobile_type;
						$this->notificationmodel->sendNotification($gcm_key,$news_title,$news_details,$news_pic,$mobile_type);
					}
				}
			}
				
				if($result){
					$data=array("status"=>"success");
				}else{
					$data=array("status"=>"error");
				}
		}else{
			$data=array("status"=>"error");
		}
		return $data;
	}

	function list_news(){
		$query="SELECT * FROM news_feeder ORDER BY id DESC";
		$resultset=$this->db->query($query);
		return $resultset->result();
	}

	function news_details($news_id){
		$query="SELECT * FROM `news_feeder` WHERE id='$news_id'";
		$resultset=$this->db->query($query);
		return $resultset->result();
	}


	function update_news($news_id,$constituency_id,$news_date,$news_title,$news_details,$status,$news_pic,$user_id){
		 $update_news="UPDATE news_feeder SET constituency_id='$constituency_id',news_date='$news_date',title='$news_title',details='$news_details',image_file_name='$news_pic',status='$status',updated_at=NOW(),updated_by='$user_id' WHERE id='$news_id'";
		$result_news=$this->db->query($update_news);
		if ($result_news) {
		  $data = array("status" => "success");
		} else {
		  $data = array("status" => "failed");
		}
		return $data;
	}


	function create_gallery($news_id,$file_name,$user_id){

		$enc_newid =  base64_encode($news_id*98765);
		$count_picture=count($file_name);

          for($i=0;$i<$count_picture;$i++){
            $check_batch="SELECT * FROM news_gallery WHERE news_id='$news_id'";
           $res=$this->db->query($check_batch);
            $res->num_rows();
            if($res->num_rows()>=10){
				$data = array("status" => "limit","url"=>base_url().'news/gallery/'.$enc_newid);
				return $data;
			}else{
				$gal_l=$file_name[$i];
				$gall_img="INSERT INTO news_gallery(news_id,image_file_name,created_at,created_by) VALUES('$news_id','$gal_l',NOW(),'$user_id')";
				$res_gal   = $this->db->query($gall_img);
              }
            }
          if ($res_gal) {
              $data = array("status" => "success","url"=>base_url().'news/gallery/'.$enc_newid);
              return $data;
          } else {
              $data = array("status" => "failed");
              return $data;
          }
	}

	function gallery_img($news_id){
			$get_all_gallery_img="SELECT * FROM news_gallery WHERE news_id='$news_id'";
			$get_all=$this->db->query($get_all_gallery_img);
			return $get_all->result();
	}

	function delete_gal($news_gal_id){
			
			$sQuery = "SELECT * FROM news_gallery WHERE id = '$news_gal_id'";
			$result = $this->db->query($sQuery);
			if($result->num_rows()>0)
			{
				foreach ($result->result() as $rows)
				{
					$image_file_name = $rows->image_file_name;
				}
			}
			$file_to_delete = 'assets/news/'.$image_file_name;
			unlink($file_to_delete);
			
			$del_gallery_img="DELETE  FROM news_gallery WHERE id='$news_gal_id'";
			$del_gallery=$this->db->query($del_gallery_img); 

			if ($del_gallery) {
				echo "success";
			} else {
				echo "Something Went Wrong";
			}
	}
	
	
	function add_banner($constituency_id,$banner_image,$status,$user_id){
		
			$insert="INSERT INTO banners(constituency_id,banner_image_name,status,created_at,created_by) VALUES ('$constituency_id','$banner_image','$status',NOW(),'$user_id')";
			$result=$this->db->query($insert);
			if($result){
				$data=array("status"=>"success");
			}else{
				$data=array("status"=>"error");
			}
		
		return $data;
	}
	
	function list_banners($constituency_id){
		$query="SELECT * FROM banners WHERE constituency_id = '$constituency_id' ORDER BY id DESC";
		$resultset=$this->db->query($query);
		return $resultset->result();
	}
	
	function delete_banner($banner_id){
			
			$sQuery = "SELECT * FROM banners WHERE id = '$banner_id'";
			$result = $this->db->query($sQuery);
			if($result->num_rows()>0)
			{
				foreach ($result->result() as $rows)
				{
					$banner_image_name = $rows->banner_image_name;
				}
			}
			$file_to_delete = 'assets/banners/'.$banner_image_name;
			unlink($file_to_delete);
			
			$del_gallery_img="DELETE  FROM banners WHERE id='$banner_id'";
			$del_gallery=$this->db->query($del_gallery_img); 

			if ($del_gallery) {
					$data=array("status"=>"success");
			} else {
					$data=array("status"=>"error");
			}
			return $data;
	}
	
	function edit_banner($banner_id){
		$query="SELECT * FROM banners WHERE id = '$banner_id'";
		$resultset=$this->db->query($query);
		return $resultset->result();
	}
	
	function update_banner($banner_id,$banner_image,$status,$user_id){
		$update_news="UPDATE banners SET banner_image_name='$banner_image',status='$status',updated_at=NOW(),updated_by='$user_id' WHERE id='$banner_id'";
		//exit;
		$result_news=$this->db->query($update_news);
		if ($result_news) {
		  $data = array("status" => "success");
		} else {
		  $data = array("status" => "failed");
		}
		return $data;
	}

}
?>
