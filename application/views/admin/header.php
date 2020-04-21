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
      <link href="<?php echo base_url(); ?>assets/admin/build/css/custom.min.css" rel="stylesheet">
      <link href="<?php echo base_url(); ?>assets/admin/build/css/extra.css" rel="stylesheet">
      <script src="<?php echo base_url(); ?>assets/admin/vendors/jquery/dist/jquery.min.js" type="text/javascript"></script>
      <script src="<?php echo base_url(); ?>assets/admin/js/jquery.dataTables.min.js"></script>
      <script src="<?php echo base_url(); ?>assets/admin/js/dataTables.bootstrap4.min.js"></script>
	  <link href="<?php echo base_url(); ?>assets/admin/vendors/style.css" rel="stylesheet">
      <script type="text/javascript" src="<?php echo base_url(); ?>assets/admin/vendors/jquery/dist/jquery.validate.min.js"></script>
   </head>
   <body class="nav-md">
      <div class="container body">
         <div class="main_container">
            <div class="col-md-3 left_col">
               <div class="left_col scroll-view">
                  <div class="navbar nav_title" style="border: 0;">
                     <a href="#" class="site_title"><i class="fa fa-paw"></i> <span>Grievance Mgmt</span></a>
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
                        <span>Welcome,</span>
                        <h2><?php echo $this->session->userdata('name');?></h2>
                     </div>
                  </div>
                  <br />
                  <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
                     <div class="menu_section">
                        <h3>Menu </h3>
                        <ul class="nav side-menu">
                           <li>
                              <a href="<?php echo base_url(); ?>/dashboard"><i class="fa fa-home"></i> Dashboard</span></a>
                           </li>
                           <li>
                              <a><i class="fa fa-edit"></i>Masters <span class="fa fa-chevron-down"></span></a>
                              <ul class="nav child_menu">
                                <li><a href="<?php echo base_url(); ?>">Constituency</a></li>
                                <li><a href="<?php echo base_url(); ?>">Paguthi</a></li>
                                <li><a href="<?php echo base_url(); ?>">Ward</a></li>
                                <li><a href="<?php echo base_url(); ?>">Booth</a></li>
                                <li><a href="<?php echo base_url(); ?>">SMS template</a></li>
                                <li><a href="<?php echo base_url(); ?>">Seeker type</a></li>
                                <li><a href="<?php echo base_url(); ?>">Grievance type</a></li>
                                  <li><a href="<?php echo base_url(); ?>">Grievance sub category</a></li>
                              </ul>
                           </li>
                           <li>
                              <a><i class="fa fa-desktop"></i>Constituency memeber <span class="fa fa-chevron-down"></span></a>
                              <ul class="nav child_menu">
                                 <li><a href="add.html">Add Constituency</a></li>
                                 <li><a href="list.html">List Constituency</a></li>
                              </ul>
                           </li>
                           <li>
                              <a><i class="fa fa-desktop"></i>Users <span class="fa fa-chevron-down"></span></a>
                              <ul class="nav child_menu">
                                 <li><a href="#.html">Add user</a></li>
                                 <li><a href="#.html">List user</a></li>
                              </ul>
                           </li>
                           <li>
                              <a><i class="fa fa-desktop"></i>Grievance <span class="fa fa-chevron-down"></span></a>
                              <ul class="nav child_menu">
                                 <li><a href="list.html">List Grievance</a></li>
                              </ul>
                           </li>
                           <li>
                              <a><i class="fa fa-bar-chart-o"></i> Report Presentation <span class="fa fa-chevron-down"></span></a>
                              <ul class="nav child_menu">
                                <li><a href="graph.html">Status</a></li>
                                <li><a href="graph.html">Category</a></li>
                                <li><a href="graph.html">Sub category</a></li>
                                <li><a href="graph.html">Location</a></li>
                              </ul>
                           </li>
                           <li>
                              <a><i class="fa fa-table"></i> Settings <span class="fa fa-chevron-down"></span></a>
                              <ul class="nav child_menu">
                                 <li><a href="#.html">Profile</a></li>
                                 <li><a href="#.html">Password update</a></li>
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
                        <li role="presentation" class="nav-item dropdown open">
                           <a href="javascript:;" class="dropdown-toggle info-number" id="navbarDropdown1" data-toggle="dropdown" aria-expanded="false">
                           <i class="fa fa-envelope-o"></i>
                           <span class="badge bg-green">6</span>
                           </a>
                           
                        </li>
                     </ul>
                  </nav>
               </div>
            </div>
