<!DOCTYPE html>
<html lang="en">
   <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
   <head>
      <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="icon" href="images/favicon.ico" type="image/ico" />
      <title>Grievance management system </title>
      <link href="<?php echo base_url(); ?>assets/admin/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
      <link href="<?php echo base_url(); ?>assets/admin/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
      <link href="<?php echo base_url(); ?>assets/admin/vendors/nprogress/nprogress.css" rel="stylesheet">
      <link href="<?php echo base_url(); ?>assets/admin/vendors/iCheck/skins/flat/green.css" rel="stylesheet">
      <link href="<?php echo base_url(); ?>assets/admin/vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">
      <link href="<?php echo base_url(); ?>assets/admin/vendors/jqvmap/dist/jqvmap.min.css" rel="stylesheet" />
      <link href="<?php echo base_url(); ?>assets/admin/vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
      <link href="<?php echo base_url(); ?>assets/admin/build/css/custom.min.css" rel="stylesheet">
      <script src="<?php echo base_url(); ?>assets/admin/vendors/jquery/dist/jquery.min.js" type="text/javascript"></script>
      <script src="<?php echo base_url(); ?>assets/admin/js/jquery.dataTables.min.js"></script>
      <script src="<?php echo base_url(); ?>assets/admin/js/dataTables.bootstrap4.min.js"></script>

   </head>
   <body class="nav-md">
      <div class="container body">
         <div class="main_container">
            <div class="col-md-3 left_col">
               <div class="left_col scroll-view">
                  <div class="navbar nav_title" style="border: 0;">
                     <a href="#" class="site_title"><i class="fa fa-paw"></i> <span>Grievance  Mgmt</span></a>
                  </div>
                  <div class="clearfix"></div>
                  <div class="profile clearfix">
                     <div class="profile_pic">
                        <img src="images/img.jpg" alt="..." class="img-circle profile_img">
                     </div>
                     <div class="profile_info">
                        <span>Welcome,</span>
                        <h2>Admin</h2>
                     </div>
                  </div>
                  <br />
                  <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
                     <div class="menu_section">
                        <h3>Menu </h3>
                        <ul class="nav side-menu">
                           <li>
                              <a><i class="fa fa-home"></i> Dashboard</span></a>
                           </li>
                           <li>
                              <a><i class="fa fa-edit"></i>Masters <span class="fa fa-chevron-down"></span></a>
                              <ul class="nav child_menu">
                                 <li><a href="#">Category</a></li>
                                 <li><a href="#.html">Constituency</a></li>
                                 <li><a href="#.html">Booth</a></li>
                                 <li><a href="#.html">Religion</a></li>
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
                           <img src="images/img.jpg" alt="">John Doe
                           </a>
                           <div class="dropdown-menu dropdown-usermenu pull-right" aria-labelledby="navbarDropdown">
                              <a class="dropdown-item" href="javascript:;"> Profile</a>
                              <a class="dropdown-item" href="javascript:;">
                              <span class="badge bg-red pull-right">50%</span>
                              <span>Settings</span>
                              </a>
                              <a class="dropdown-item" href="javascript:;">Help</a>
                              <a class="dropdown-item" href="#"><i class="fa fa-sign-out pull-right"></i> Log Out</a>
                           </div>
                        </li>
                        <li role="presentation" class="nav-item dropdown open">
                           <a href="javascript:;" class="dropdown-toggle info-number" id="navbarDropdown1" data-toggle="dropdown" aria-expanded="false">
                           <i class="fa fa-envelope-o"></i>
                           <span class="badge bg-green">6</span>
                           </a>
                           <ul class="dropdown-menu list-unstyled msg_list" role="menu" aria-labelledby="navbarDropdown1">
                              <li class="nav-item">
                                 <a class="dropdown-item">
                                 <span class="image"><img src="images/img.jpg" alt="Profile Image" /></span>
                                 <span>
                                 <span>John Smith</span>
                                 <span class="time">3 mins ago</span>
                                 </span>
                                 <span class="message">
                                 Film festivals used to be do-or-die moments for movie makers. They were where...
                                 </span>
                                 </a>
                              </li>
                              <li class="nav-item">
                                 <a class="dropdown-item">
                                 <span class="image"><img src="images/img.jpg" alt="Profile Image" /></span>
                                 <span>
                                 <span>John Smith</span>
                                 <span class="time">3 mins ago</span>
                                 </span>
                                 <span class="message">
                                 Film festivals used to be do-or-die moments for movie makers. They were where...
                                 </span>
                                 </a>
                              </li>
                              <li class="nav-item">
                                 <a class="dropdown-item">
                                 <span class="image"><img src="images/img.jpg" alt="Profile Image" /></span>
                                 <span>
                                 <span>John Smith</span>
                                 <span class="time">3 mins ago</span>
                                 </span>
                                 <span class="message">
                                 Film festivals used to be do-or-die moments for movie makers. They were where...
                                 </span>
                                 </a>
                              </li>
                              <li class="nav-item">
                                 <a class="dropdown-item">
                                 <span class="image"><img src="images/img.jpg" alt="Profile Image" /></span>
                                 <span>
                                 <span>John Smith</span>
                                 <span class="time">3 mins ago</span>
                                 </span>
                                 <span class="message">
                                 Film festivals used to be do-or-die moments for movie makers. They were where...
                                 </span>
                                 </a>
                              </li>
                              <li class="nav-item">
                                 <div class="text-center">
                                    <a class="dropdown-item">
                                    <strong>See All Alerts</strong>
                                    <i class="fa fa-angle-right"></i>
                                    </a>
                                 </div>
                              </li>
                           </ul>
                        </li>
                     </ul>
                  </nav>
               </div>
            </div>
