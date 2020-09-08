<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class News extends CI_Controller {

	function __construct() {
		 parent::__construct();
			$this->load->helper("url");
			$this->load->library('session');
			$this->load->model('newsmodel');
	}

	public function add()
	{
		$user_id = $this->session->userdata('user_id');
		$user_type = $this->session->userdata('user_type');
			if($user_type=='1' || $user_type=='2'){
			$data['res_constituency']=$this->newsmodel->get_constituency();
			$this->load->view('admin/header');
			$this->load->view('admin/news/add',$data);
			$this->load->view('admin/footer');
		}else{
			redirect('/');
		}

	}

	public function add_news()
	{
		$datas=$this->session->userdata();
        $user_id=$this->session->userdata('user_id');
		$user_type=$this->session->userdata('user_type');
					if($user_type=='1' || $user_type=='2'){

					$constituency_id=$this->input->post('constituency_id');

					$newsdate=$this->input->post('news_date');
					$dateTime1 = new DateTime($newsdate);
					$news_date=date_format($dateTime1,'Y-m-d' );

					$news_title= $this->db->escape_str($this->input->post('news_title'));

					$newsdetails = str_replace("\r\n",'', $this->input->post('news_details'));
					$news_details= $this->db->escape_str($newsdetails);
					$status=$this->input->post('status');
					$notify=$this->input->post('notify');
					$newspic = $_FILES['news_pic']['name'];

					if(empty($newspic)){
						$news_pic='';
					}else{
						$temp = pathinfo($newspic, PATHINFO_EXTENSION);
						$news_pic = round(microtime(true)) . '.' . $temp;
						$uploaddir = 'assets/news/';
						$profilepic = $uploaddir.$news_pic;
						move_uploaded_file($_FILES['news_pic']['tmp_name'], $profilepic);
					}

					$datas=$this->newsmodel->add_news($constituency_id,$news_date,strtoupper($news_title),strtoupper($news_details),$status,$news_pic,$notify,$user_id);

					if($datas['status']=="success"){
						$this->session->set_flashdata('msg', 'News  Created Successfully!');
						redirect(base_url().'news/list');
					}else if($datas['status']=="already"){
						$this->session->set_flashdata('msg', 'News Title Exists');
						redirect(base_url().'news/list');
					}
					else{
						$this->session->set_flashdata('msg', 'Failed to Add');
						redirect(base_url().'news/list');
					}
       }
       else{
         redirect(base_url());
       }
	}

	public function list()
	{
		$datas=$this->session->userdata();
		$user_id=$this->session->userdata('user_id');
		$user_type=$this->session->userdata('user_type');
		$datas['result']=$this->newsmodel->list_news();

			if($user_type=='1' || $user_type=='2'){
			$this->load->view('admin/header');
			$this->load->view('admin/news/list',$datas);
			$this->load->view('admin/footer');
		}else {
			redirect(base_url());
		}
	}

	public function edit()
	{
		$datas=$this->session->userdata();
		$user_id=$this->session->userdata('user_id');
		$user_type=$this->session->userdata('user_type');

		$news_id=base64_decode($this->uri->segment(3))/98765;
		$datas['res_constituency']=$this->newsmodel->get_constituency();
		$datas['res']=$this->newsmodel->news_details($news_id);
			if($user_type=='1' || $user_type=='2'){
			$this->load->view('admin/header');
			$this->load->view('admin/news/edit',$datas);
			$this->load->view('admin/footer');
		}else {
			redirect(base_url());
		}
	}

	public function update_news(){
		$datas=$this->session->userdata();
		$user_id=$this->session->userdata('user_id');
		$user_type=$this->session->userdata('user_type');

			if($user_type=='1' || $user_type=='2'){
			$news_id=$this->input->post('news_id');
			$constituency_id=$this->input->post('constituency_id');

			$news_old_date=$this->input->post('news_old_date');
			$dateTime2 = new DateTime($news_old_date);
			$news_old_date=date_format($dateTime2,'Y-m-d' );

			$newsdate=$this->input->post('news_date');
			$dateTime1 = new DateTime($newsdate);
			$news_date=date_format($dateTime1,'Y-m-d' );

			if ($news_date==''){
				$newsn_date = $news_old_date;
			}else {
				$newsn_date = $news_date;
			}

			$news_title= $this->db->escape_str($this->input->post('news_title'));
			$newsdetails = str_replace("\r\n",'', $this->input->post('news_details'));
			$news_details= $this->db->escape_str($newsdetails);
			$status=$this->input->post('status');

			$news_old_pic=$this->input->post('news_old_pic');
			$newspic = $_FILES['news_pic']['name'];

			if(empty($newspic)){
						 $news_pic=$news_old_pic;
					}else{
						$temp = pathinfo($newspic, PATHINFO_EXTENSION);
						 $news_pic = round(microtime(true)) . '.' . $temp;
						$uploaddir = 'assets/news/';
						$profilepic = $uploaddir.$news_pic;
						move_uploaded_file($_FILES['news_pic']['tmp_name'], $profilepic);
					}
			//exit;
			$datas=$this->newsmodel->update_news($news_id,$constituency_id,$newsn_date,strtoupper($news_title),strtoupper($news_details),$status,$news_pic,$user_id);

			if($datas['status']=="success"){
				$this->session->set_flashdata('msg', 'News Updated successfully');
				redirect(base_url().'news/list');
			}else{
				$this->session->set_flashdata('msg', 'Failed');
				redirect(base_url().'news/list');
			}
	 } else {
			redirect(base_url());
	 }
	}

	public function gallery(){
	$datas=$this->session->userdata();
	$user_id=$this->session->userdata('user_id');
	$user_type=$this->session->userdata('user_type');
	$news_id=base64_decode($this->uri->segment(3))/98765;
		if($user_type=='1' || $user_type=='2'){
			$datas['res']=$this->newsmodel->news_details($news_id);
			$datas['res_img']=$this->newsmodel->gallery_img($news_id);
			 $this->load->view('admin/header');
			 $this->load->view('admin/news/gallery',$datas);
			 $this->load->view('admin/footer');
		 }
		 else{
				redirect('/');
		 }
	}

	public function add_update_gallery(){
			$datas=$this->session->userdata();
			$user_id=$this->session->userdata('user_id');
			$user_type=$this->session->userdata('user_type');
				if($user_type=='1' || $user_type=='2'){

				$news_id=$this->input->post('news_id');
				$name_array = $_FILES['news_photos']['name'];
				$tmp_name_array = $_FILES['news_photos']['tmp_name'];
				$count_tmp_name_array = count($tmp_name_array);
				$static_final_name = time();
				for($i = 0; $i < $count_tmp_name_array; $i++){
			   $extension = pathinfo($name_array[$i] , PATHINFO_EXTENSION);
				 $file_name[]=$static_final_name.$i.".".$extension;
				move_uploaded_file($tmp_name_array[$i], "assets/news/".$static_final_name.$i.".".$extension);
				}

			$datas = $this->newsmodel->create_gallery($news_id,$file_name,$user_id);

			if($datas['status']=="success"){
				$this->session->set_flashdata('msg', 'Photo uploaded successfully!');
				redirect($datas['url']);
			}else if($datas['status']=="limit"){
				$this->session->set_flashdata('msg', 'Gallery Maximum images Exceeds');
				redirect($datas['url']);
			}else{
				$this->session->set_flashdata('msg', 'Failed to Add');
				redirect($datas['url']);
			}
		 }
		 else{
				redirect('/');
		 }
	}

	public function delete_gal(){
		$datas=$this->session->userdata();
		$user_id=$this->session->userdata('user_id');
		$user_type=$this->session->userdata('user_type');
			if($user_type=='1' || $user_type=='2'){
				$news_gal_id=$this->input->post('news_gal_id');
				$datas['res']=$this->newsmodel->delete_gal($news_gal_id);
		}else{
			redirect('/');
		}
	}

	public function banners(){
	$datas=$this->session->userdata();
	$user_id=$this->session->userdata('user_id');
	$user_type=$this->session->userdata('user_type');

			if($user_type=='1' || $user_type=='2'){
			$constituency_id=1;
			$datas['res']=$this->newsmodel->list_banners($constituency_id);
			 $this->load->view('admin/header');
			 $this->load->view('admin/news/banners',$datas);
			 $this->load->view('admin/footer');
		 }
		 else{
				redirect('/');
		 }
	}

	public function add_banner()
	{
		$datas=$this->session->userdata();
        $user_id=$this->session->userdata('user_id');
		$user_type=$this->session->userdata('user_type');
					if($user_type=='1' || $user_type=='2'){

					$constituency_id='1';
					$bannerspic = $_FILES['banner_image']['name'];
					$status=$this->input->post('status');

					if(empty($bannerspic)){
						$banner_image='';
					}else{
						$temp = pathinfo($bannerspic, PATHINFO_EXTENSION);
						$banner_image = round(microtime(true)) . '.' . $temp;
						$uploaddir = 'assets/banners/';
						$profilepic = $uploaddir.$banner_image;
						move_uploaded_file($_FILES['banner_image']['tmp_name'], $profilepic);
					}
					$datas=$this->newsmodel->add_banner($constituency_id,$banner_image,$status,$user_id);

					if($datas['status']=="success"){
						$this->session->set_flashdata('msg', 'Banner image added successfully!');
						redirect(base_url().'news/banners');
					}
					else{
						$this->session->set_flashdata('msg', 'Failed to Add');
						redirect(base_url().'news/banners');
					}
       }
       else{
         redirect(base_url());
       }
	}


	public function delete_banner(){
		$datas=$this->session->userdata();
		$user_id=$this->session->userdata('user_id');
		$user_type=$this->session->userdata('user_type');
		if($user_type=='1' || $user_type=='2'){
				$banner_id=base64_decode($this->uri->segment(3))/98765;
				$datas=$this->newsmodel->delete_banner($banner_id);

					if($datas['status']=="success"){
						$this->session->set_flashdata('msg', 'Banner Deleted Successfully!');
						redirect(base_url().'news/banners');
					}
					else{
						$this->session->set_flashdata('msg', 'Failed');
						redirect(base_url().'news/banners');
					}
		}else{
			redirect('/');
		}
	}

	public function edit_banner(){
	$datas=$this->session->userdata();
	$user_id=$this->session->userdata('user_id');
	$user_type=$this->session->userdata('user_type');

		if($user_type=='1' || $user_type=='2'){
			$banner_id=base64_decode($this->uri->segment(3))/98765;
			$datas['res']=$this->newsmodel->edit_banner($banner_id);
			 $this->load->view('admin/header');
			 $this->load->view('admin/news/edit_banners',$datas);
			 $this->load->view('admin/footer');
		 }
		 else{
				redirect('/');
		 }
	}

	public function update_banner()
	{
		$datas=$this->session->userdata();
        $user_id=$this->session->userdata('user_id');
		$user_type=$this->session->userdata('user_type');
					if($user_type=='1' || $user_type=='2'){

					$banner_id=$this->input->post('banner_id');
					$banner_old_pic=$this->input->post('banner_old_pic');
					$status=$this->input->post('status');
					$bannerspic = $_FILES['banner_image']['name'];

					if(empty($bannerspic)){
						$banner_image=$banner_old_pic;
					}else{
						$temp = pathinfo($bannerspic, PATHINFO_EXTENSION);
						$banner_image = round(microtime(true)) . '.' . $temp;
						$uploaddir = 'assets/banners/';
						$profilepic = $uploaddir.$banner_image;
						move_uploaded_file($_FILES['banner_image']['tmp_name'], $profilepic);
					}
					$datas=$this->newsmodel->update_banner($banner_id,$banner_image,$status,$user_id);

					if($datas['status']=="success"){
						$this->session->set_flashdata('msg', 'Banner Updated Successfully!');
						redirect(base_url().'news/banners');
					}
					else{
						$this->session->set_flashdata('msg', 'Failed to Update');
						redirect(base_url().'news/banners');
					}
       }
       else{
         redirect(base_url());
       }
	}

}
