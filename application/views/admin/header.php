<?php $user_pic = $this->session->userdata('user_pic'); ?>
<!DOCTYPE html>
<html lang="en">
   <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
   <head>
      <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
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
                  <div class="navbar nav_title" style="border: 0;">
                     <a href="#" class="site_title"> <span>GMS</span></a>
                  </div>
                  <div class="clearfix"></div>
                  <div class="profile clearfix">
                     <div class="profile_pic">
						<?php
						if ($user_pic != '') {?>
							<img src="<?php echo base_url(); ?>assets/users/<?php echo $user_pic;?>" class="img-circle profile_img">
						<?php } else { ?>
							<img src="<?php echo base_url(); ?>assets/users/default.png" class="img-circle profile_img">
						<?php } ?>
                     </div>
                     <div class="profile_info">

                        <h2 style="margin-top:9px;text-align:center;"><?php echo $this->session->userdata('name');?></h2>
                     </div>
                  </div>


                  <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">

                     <div class="menu_section">
                        <h3> MENU </h3>

                        <ul class="nav side-menu">
                           <li id="dashboardmenu"><a href="<?php echo base_url(); ?>dashboard"><img src="<?php echo base_url(); ?>assets/images/icons/dashboard.png" class="img-responsive menu_img"></i> Dashboard</span></a>                           </li>
                           <li id="mastermenu">
                              <a><img src="<?php echo base_url(); ?>assets/images/icons/master.png" class="img-responsive menu_img"> Masters <span class="fa fa-chevron-down"></span></a>
                              <ul class="nav child_menu mastermenu">
                                  <li id="constituencymenu"><a href="<?php echo base_url(); ?>masters/constituency">Constituency</a></li>
                                  <li id="paguthimenu"><a href="<?php echo base_url(); ?>masters/paguthi">Paguthi</a></li>
                                  <li id="wardmenu"><a href="<?php echo base_url(); ?>masters/ward">Ward</a></li>
                                  <li id="seekermenu"><a href="<?php echo base_url(); ?>masters/seeker">Seeker type</a></li>
                                  <li id="grievancemeenu"><a href="<?php echo base_url(); ?>masters/grievance">Grievance type</a></li>
                                  <li id="smsmenu"><a href="<?php echo base_url(); ?>masters/sms_template">SMS template</a></li>
                                  <li id="interactionmenu"><a href="<?php echo base_url(); ?>masters/interaction">Interaction </a></li>
                                  <!-- <li><a href="<?php echo base_url(); ?>masters/religion">religion</a></li> -->
                                </ul>
                           </li>
                           <li id="constiituent_menu">
                              <a><img src="<?php echo base_url(); ?>assets/images/icons/constituent_info.png" class="img-responsive menu_img"> Constituent  <span class="fa fa-chevron-down"></span></a>
                              <ul class="nav child_menu constiituent_menu">
                                 <li id="create_constituent_menu"><a href="<?php echo base_url(); ?>constituent/constituent_member">create Constituent</a></li>
                                 <li id="list_constituent_menu"><a href="<?php echo base_url(); ?>constituent/list_constituent_member">List Constituent</a></li>
                                 <li id="list_constituent_menu"><a href="<?php echo base_url(); ?>constituent/recent_constituent_member">Recent Constituent</a></li>
								 <li id="constituent_birthday"><a href="<?php echo base_url(); ?>constituent/birthday">Birthday Wishes</a></li>
								 <li id="constituent_meetings"><a href="<?php echo base_url(); ?>constituent/meetings">Meeting Request</a></li>
                              </ul>
                           </li>
                           <li id="grievance_menu">
                              <a><img src="<?php echo base_url(); ?>assets/images/icons/grievance.png" class="img-responsive menu_img"> Grievance <span class="fa fa-chevron-down"></span></a>
                              <ul class="nav child_menu grievance_menu">
                                 <li id="list_grievance_menu"><a href="<?php echo base_url(); ?>constituent/list_grievance">List Grievance</a></li>
                                  <li id="list_grievance_reply_menu"><a href="<?php echo base_url(); ?>constituent/list_grievance_reply">Grievance reply </a></li>
                              </ul>
                           </li>
                           <li>
                              <a><img src="<?php echo base_url(); ?>assets/images/icons/user.png" class="img-responsive menu_img"> Users <span class="fa fa-chevron-down"></span></a>
                              <ul class="nav child_menu">
                                 <li><a href="<?php echo base_url(); ?>users/add">Add user</a></li>
                                 <li><a href="<?php echo base_url(); ?>users/list_users">List user</a></li>
                              </ul>
                           </li>

                           <li>
                              <a><img src="<?php echo base_url(); ?>assets/images/icons/report.png" class="img-responsive menu_img"> Report  <span class="fa fa-chevron-down"></span></a>
                              <ul class="nav child_menu">
                                <li><a href="<?php echo base_url(); ?>report/status">Status</a></li>
                                <li><a href="<?php echo base_url(); ?>report/category">Category</a></li>
                                <li><a href="<?php echo base_url(); ?>report/sub_category">Sub category</a></li>
                                <li><a href="<?php echo base_url(); ?>report/location">Location</a></li>
								<li><a href="<?php echo base_url(); ?>report/meetings">Meetings</a></li>
								<li><a href="<?php echo base_url(); ?>report/staff">Staff Report</a></li>
								<li><a href="<?php echo base_url(); ?>report/birthday">Birthday letter</a></li>
                              </ul>
                           </li>
                           <li>
                              <a><img src="<?php echo base_url(); ?>assets/images/icons/setting.png" class="img-responsive menu_img"> Settings <span class="fa fa-chevron-down"></span></a>
                              <ul class="nav child_menu">
                                 <li><a href="<?php echo base_url(); ?>login/profile">Profile</a></li>
                                 <li><a href="<?php echo base_url(); ?>login/password">Password update</a></li>
                              </ul>
                           </li>
                        </ul>
                     </div>
                  </div>

               </div>
            </div>
            <div class="top_nav">
               <div class="nav_menu">
                  <div class="nav toggle">
                     <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                  </div>
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
                              <a class="dropdown-item" href="<?php echo base_url(); ?>login/password"> Password update</a>
                              <a class="dropdown-item" href="<?php echo base_url(); ?>login/logout"><i class="fa fa-sign-out pull-right"></i> Log Out</a>
                           </div>
                        </li>
                        <!-- <li role="presentation" class="nav-item dropdown open">
                           <a href="javascript:;" class="dropdown-toggle info-number" id="navbarDropdown1" data-toggle="dropdown" aria-expanded="false">
                           <i class="fa fa-envelope-o"></i>
                           <span class="badge bg-green">6</span>
                           </a>

                        </li> -->
                     </ul>
                  </nav>
               </div>
            </div>
