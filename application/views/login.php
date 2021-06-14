<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<meta name="description"/>
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
		<link href="<?php echo base_url(); ?>assets/admin/css/login.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url(); ?>assets/admin/css/style.bundle.css" rel="stylesheet" type="text/css" />

		<link rel="shortcut icon" href="<?php echo base_url(); ?>assets/images/favicon.png" />
		<title>Login Page</title>
	</head>
	<body id="kt_body" class="header-fixed header-mobile-fixed subheader-enabled page-loading">

		<div class="d-flex flex-column flex-root">
			<div class="login login-1 login-signin-on d-flex flex-column flex-lg-row flex-column-fluid bg-white" id="kt_login">
				
				<div class="login-aside d-flex flex-row-auto bgi-size-cover bgi-no-repeat p-10 p-lg-10" style="background-image: url(<?php echo base_url(); ?>assets/images/bg-4.jpg);">
					<div class="d-flex flex-row-fluid flex-column justify-content-between">
						
					</div>
				</div>
				
				<div class="d-flex flex-column flex-row-fluid position-relative p-7 overflow-hidden">
					<div class="d-flex flex-column-fluid flex-center mt-30 mt-lg-0">
						<div class="login-form login-signin">
						  <div class="text-center mb-10">
							<h3 class="font-size-h1">Sign In</h3>
							<p class="text-muted font-weight-bold">Enter your Email Address and Password</p>
						  </div>
						  
							<?php if($this->session->flashdata('msg')): ?>
								<div class="alert alert-danger alert-dismissible " role="alert">
									<button type="button" class="close" data-dismiss="alert" aria-label="Close"><!--<span aria-hidden="true">×</span>--></button>
									<?php echo $this->session->flashdata('msg'); ?>
								</div>
							<?php endif; ?>
							
							<form action="<?php echo base_url(); ?>login/login_check" method="post" enctype="multipart/form-data" id="loginform" name="loginform">
							<div class="form-group">
							  <input class="form-control form-control-solid h-auto py-4 px-5" type="email" placeholder="Email Address" name="username" id="username" autocomplete="off" />
							 
							</div>
							<div class="form-group">
							  <input class="form-control form-control-solid h-auto py-4 px-5" type="password" placeholder="Password" name="password" id="password" autocomplete="off" /><span toggle="#password" class="fa fa-fw  fa-eye-slash field-icon toggle-password"></span>
							  
							</div>
							<!--begin::Action-->
							<div class="form-group d-flex flex-wrap justify-content-between align-items-center">
							  <a href="<?php echo base_url(); ?>login/forgotpassword" class="text-dark-50 text-hover-primary my-3 mr-2" id="kt_login_forgot">Forgot Password ?</a>
							  <button type="submit" id="kt_login_signin_submit" class="btn btn-primary font-weight-bold px-9 py-4 my-3">SIGN IN</button>
							</div>
							<!--end::Action-->
						  </form>
						  <!--end::Form-->
						</div>
						<!--end::Signin-->
					</div>

				</div>
			</div>
		</div>
		<script type="text/javascript" src="<?php echo base_url(); ?>assets/admin/vendors/jquery/dist/jquery.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>assets/admin/vendors/jquery/dist/jquery.validate.min.js"></script>
	</body>
	<script type="text/javascript">
	
	$(".toggle-password").click(function() {

	  $(this).toggleClass("fa-eye-slash fa-eye");
	  var input = $($(this).attr("toggle"));
	  if (input.attr("type") == "password") {
		input.attr("type", "text");
	  } else {
		input.attr("type", "password");
	  }
	});

	$('#loginform').validate({ // initialize the plugin
		 rules: {
			 username:{required:true,email:true },
			 password:{required:true }
		 },
		 messages: {
			  username: "Enter valid email address",
			  password: "Enter Password"
			 }
	 });
	 
 </script>
</html>
