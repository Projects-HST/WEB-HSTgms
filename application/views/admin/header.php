<?php

	//$user_pic = $this->session->userdata('user_pic');
	//$user_type = $this->session->userdata('user_type');
?>
<!DOCTYPE html>
<html lang="en">
   <head>
		   <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="icon" href="images/favicon.ico" type="image/ico" />
      <title>GRIEVANCE MANAGEMENT SYSTEM </title>
      <link href="<?php echo base_url(); ?>assets/admin/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
      <link href="<?php echo base_url(); ?>assets/admin/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
      <link href="<?php echo base_url(); ?>assets/admin/vendors/nprogress/nprogress.css" rel="stylesheet">
      <link href="<?php echo base_url(); ?>assets/admin/vendors/iCheck/skins/flat/green.css" rel="stylesheet">
      <link href="<?php echo base_url(); ?>assets/admin/vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">
      <link href="<?php echo base_url(); ?>assets/admin/vendors/jqvmap/dist/jqvmap.min.css" rel="stylesheet" />

	  <link href="<?php echo base_url(); ?>assets/admin/vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
	  <link href="<?php echo base_url(); ?>assets/admin/vendors/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.css" rel="stylesheet">

	  <link href="<?php echo base_url(); ?>assets/admin/vendors/datatable/css/buttons.dataTables.min.css" rel="stylesheet">

	  <link href="<?php echo base_url(); ?>assets/admin/build/css/custom.min.css" rel="stylesheet">
      <link href="<?php echo base_url(); ?>assets/admin/build/css/extra.css" rel="stylesheet">
	  <link href="<?php echo base_url(); ?>assets/admin/vendors/style.css" rel="stylesheet">

	  <script src="<?php echo base_url(); ?>assets/admin/vendors/jquery/dist/jquery.min.js" type="text/javascript"></script>

	  <script src="<?php echo base_url(); ?>assets/admin/vendors/datatable/js/jquery.dataTables.min.js"></script>
      <script src="<?php echo base_url(); ?>assets/admin/vendors/datatable/js/dataTables.bootstrap4.min.js"></script>
	  <script src="<?php echo base_url(); ?>assets/admin/vendors/datatable/js/dataTables.buttons.min.js"></script>
	  <script src="<?php echo base_url(); ?>assets/admin/vendors/datatable/js/jszip.min.js"></script>
	  <script src="<?php echo base_url(); ?>assets/admin/vendors/datatable/js/pdfmake.min.js"></script>
	  <script src="<?php echo base_url(); ?>assets/admin/vendors/datatable/js/vfs_fonts.js"></script>
	  <script src="<?php echo base_url(); ?>assets/admin/vendors/datatable/js/buttons.html5.min.js "></script>

    <script src="<?php echo base_url(); ?>assets/admin/vendors/jquery/dist/jquery.validate.min.js"></script>
	  <script src="<?php echo base_url(); ?>assets/admin/vendors/jquery/dist/additional-methods.min.js"></script>

	  <script src="<?php echo base_url(); ?>assets/admin/vendors/moment/min/moment.min.js"></script>
	  <script src="<?php echo base_url(); ?>assets/admin/vendors/bootstrap-daterangepicker/daterangepicker.js"></script>
	  <script src="<?php echo base_url(); ?>assets/admin/vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>

   </head>
   <body class="nav-md">
      <div class="container body">
         <div class="main_container">
            <div class="col-md-3 left_col">
               <div class="left_col scroll-view">
                  <div class="navbar nav_title" style="border: 0;background-color:#31aa15;">
                     <p class="site_title" style="margin-top:0px;text-align:center;background-color: #1e8c05;font-weight:600;"> <span >GMS</span></p>
                  </div>
                  <div class="clearfix"></div>
                  <div class="profile clearfix menu_profile">
                     <div class="profile_pic">
						<?php
						if ($user_pic != '') {?>
							<img src="<?php echo base_url(); ?>assets/users/<?php echo $user_pic;?>" class="img-circle profile_img">
						<?php } else { ?>
							<img src="<?php echo base_url(); ?>assets/users/default.png" class="img-circle profile_img">
						<?php } ?>
                     </div>
                     <div class="profile_info">

                        <h2 style="margin-top:5px;text-align:center;"><?php echo $this->session->userdata('name');?></h2>
												 <hr>
                     </div>

                  </div>



                  <div id="sidebar-menu" class="main_menu_side hidden-print main_menu menu_bar">

                     <div class="menu_section">


                        <ul class="nav side-menu">
                           <li id="dashboardmenu">
														 <a href="<?php echo base_url(); ?>dashboard">
															 <img src="<?php echo base_url(); ?>assets/images/icons/Dashboard.png"
															 class="img-responsive menu_img">
															  Dashboard</a>
													 </li>
                           <li id="mastermenu">
                              <a><img src="<?php echo base_url(); ?>assets/images/icons/Master.png" class="img-responsive menu_img"> Masters <span class="fa fa-chevron-down"></span></a>
                              <ul class="nav child_menu mastermenu">
																 <?php if ($user_type =='1'){ ?>
                                  <li id="constituencymenu"><a href="<?php echo base_url(); ?>masters/constituency">Constituency</a></li>
                                  <li id="paguthimenu"><a href="<?php echo base_url(); ?>masters/paguthi">Paguthi</a></li>
                                  <li id="wardmenu"><a href="<?php echo base_url(); ?>masters/ward">Ward</a></li>
                                  <li id="seekermenu"><a href="<?php echo base_url(); ?>masters/seeker">Seeker type</a></li>
																		<?php } ?>
																	 <?php  if ($user_type =='2' || $user_type =='1'){ ?>
                                  <li id="grievancemeenu"><a href="<?php echo base_url(); ?>masters/grievance">Grievance type</a></li>
                                  <li id="smsmenu"><a href="<?php echo base_url(); ?>masters/sms_template">SMS template</a></li>
																<?php } ?>
                                  <!-- <li id="interactionmenu"><a href="<?php echo base_url(); ?>masters/interaction">Interaction </a></li> -->
                                  <!-- <li><a href="<?php echo base_url(); ?>masters/religion">religion</a></li> -->
																	<?php if ($user_type =='1'){ ?>
																	<li><a href="<?php echo base_url(); ?>masters/festival">Festival</a></li>
																	<?php } ?>
                                </ul>
                           </li>
                           <li id="constiituent_menu">
                              <a><img src="<?php echo base_url(); ?>assets/images/icons/Constituent.png" class="img-responsive menu_img"> Constituent  <span class="fa fa-chevron-down"></span></a>
                              <ul class="nav child_menu constiituent_menu">
                                 <li id="create_constituent_menu"><a href="<?php echo base_url(); ?>constituent/constituent_member">create Constituent</a></li>
                                 <li id="list_constituent_menu"><a href="<?php echo base_url(); ?>constituent/list_constituent_member"> Constituent List</a></li>
                                 <!-- <li id="list_constituent_menu"><a href="<?php echo base_url(); ?>constituent/recent_constituent_member">Recent Constituent</a></li> -->

								 <li id="constituent_meetings"><a href="<?php echo base_url(); ?>constituent/meetings">Meeting list</a></li>
								 <li id="constituent_birthday"><a href="<?php echo base_url(); ?>constituent/birthday">Birthday Wishes</a></li>
								 <li><a href="<?php echo base_url(); ?>constituent/festival_wishes">Festival wishes</a></li>

                              </ul>
                           </li>
                           <li id="grievance_menu">
                              <a><img src="<?php echo base_url(); ?>assets/images/icons/Grievance.png" class="img-responsive menu_img"> Grievance <span class="fa fa-chevron-down"></span></a>
                              <ul class="nav child_menu grievance_menu">
                                 <!-- <li id="list_grievance_menu"><a href="<?php echo base_url(); ?>constituent/list_grievance">List Grievance</a></li> -->
																 <li id="list_grievance_menu"><a href="<?php echo base_url(); ?>constituent/all_grievance">ALL</a></li>
																 <li id="list_grievance_menu"><a href="<?php echo base_url(); ?>constituent/all_petition">Petition</a></li>
																 <li id="list_grievance_menu"><a href="<?php echo base_url(); ?>constituent/all_enquiry">Enquiry</a></li>
                                  <li id="list_grievance_reply_menu"><a href="<?php echo base_url(); ?>constituent/list_grievance_reply">Grievance reply </a></li>
                              </ul>
                           </li>
						   <?php if ($user_type =='1'){ ?>
                           <li id="user_menu">
                              <a><img src="<?php echo base_url(); ?>assets/images/icons/User.png" class="img-responsive menu_img"> Users <span class="fa fa-chevron-down"></span></a>
                              <ul class="nav child_menu user_menu">
                                 <li id="create_user"><a href="<?php echo base_url(); ?>users/add">Create user</a></li>
                                 <li id="list_user"><a href="<?php echo base_url(); ?>users/list_users">user list</a></li>
                              </ul>
                           </li>
						   <?php } ?>
							<li id="news_menu">
                              <a><img src="<?php echo base_url(); ?>assets/images/icons/Newsfeeder.png" class="img-responsive menu_img"> News Feeder <span class="fa fa-chevron-down"></span></a>
                              <ul class="nav child_menu news_menu">
                                 <li id="create_news_menu"><a href="<?php echo base_url(); ?>news/add">Create news Feeder</a></li>
                                 <li id="list_news_menu"><a href="<?php echo base_url(); ?>news/list">List news Feeder</a></li>
                              </ul>
                           </li>
						<li id="banners_menu"><a href="<?php echo base_url(); ?>news/banners"><img src="<?php echo base_url(); ?>assets/images/icons/Banner.png" class="img-responsive menu_img"> Banners</a></li>
                           <li id="reportmenu">
                              <a><img src="<?php echo base_url(); ?>assets/images/icons/Report.png" class="img-responsive menu_img"> Report  <span class="fa fa-chevron-down"></span></a>
                              <ul class="nav child_menu reportmenu">
                                <li><a href="<?php echo base_url(); ?>report/status">Status</a></li>
                                <li><a href="<?php echo base_url(); ?>report/category">Grievance</a></li>
                                <!-- <li><a href="<?php echo base_url(); ?>report/sub_category">Grievance Sub category</a></li> -->
                                <!-- <li><a href="<?php echo base_url(); ?>report/location">Location</a></li> -->
																<li><a href="<?php echo base_url(); ?>report/meetings">Meeting</a></li>

																<li><a href="<?php echo base_url(); ?>report/birthday">Birthday letter</a></li>
																<li><a href="<?php echo base_url(); ?>report/festival_wishes_report">Festival letter</a></li>
																<li><a href="<?php echo base_url(); ?>report/constituent_list">constituent</a></li>
																<li><a href="<?php echo base_url(); ?>report/video">Video</a></li>
																<li><a href="<?php echo base_url(); ?>report/staff">Staff</a></li>
                              </ul>
                           </li>
                           <!-- <li>
                              <a><img src="<?php echo base_url(); ?>assets/images/icons/Setting.png" class="img-responsive menu_img"> Settings <span class="fa fa-chevron-down"></span></a>
                              <ul class="nav child_menu">
                                 <li><a href="<?php echo base_url(); ?>login/profile">Profile</a></li>
                                 <li><a href="<?php echo base_url(); ?>login/password">Change Password</a></li>
                              </ul>
                           </li> -->
                        </ul>
                     </div>
                  </div>

               </div>
            </div>
            <div class="top_nav">
               <div class="nav_menu" style="padding-bottom:2px;">
                  <div class="nav toggle">
                     <!-- <a id="menu_toggle"><i class="fa fa-bars"></i></a> -->
										 <p class="gms_title">Grievance management system</p>
                  </div>
									<!-- <div class="">
										<p>GMS</p>
									</div> -->
                  <nav class="nav navbar-nav">
                     <ul class=" navbar-right">
                        <li class="nav-item dropdown open" style="padding-left: 15px;">
                           <a href="javascript:;" class="user-profile dropdown-toggle" aria-haspopup="true" id="navbarDropdown" data-toggle="dropdown" aria-expanded="false">
                          <?php
						if ($user_pic != '') {?>
							<img src="<?php echo base_url(); ?>assets/users/<?php echo $user_pic;?>">
						<?php } else { ?>
							<img src="<?php echo base_url(); ?>assets/users/default.png">
						<?php } ?><?php echo $this->session->userdata('name');?>
                           </a>
                           <div class="dropdown-menu dropdown-usermenu pull-right" aria-labelledby="navbarDropdown">
                              <a class="dropdown-item" href="<?php echo base_url(); ?>login/profile"> Profile</a>
                              <a class="dropdown-item" href="<?php echo base_url(); ?>login/password"> change Password</a>
                              <a class="dropdown-item" href="<?php echo base_url(); ?>login/logout"><i class="fa fa-sign-out pull-right"></i> LogOut</a>
                           </div>
                        </li>
                     </ul>
                  </nav>
               </div>
            </div>
