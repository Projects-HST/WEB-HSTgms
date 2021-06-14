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
			
				<div class="login-aside d-flex flex-row-auto bgi-size-cover bgi-no-repeat p-10 p-lg-10" style="background-image: url(<?php echo base_url(); ?>assets/images/bg-1.jpg);">
					<div class="d-flex flex-column-fluid flex-center mt-30 mt-lg-0">
						 <div class="text-center mb-10">
							<h3 class="font-size-h2" style="margin-bottom:30px;">Welcome To</h3>
							<img src="<?php echo base_url(); ?>assets/images/login.png" class="img-responsive login_img" style="margin-bottom:30px;">
							<h3 class="font-size-h2" style="margin-bottom:30px;">Grievance Management System</h3>
							<p>Please enter the Constituency Code <br>given to you for login.</p>
						</div>
					</div>
				</div>
				
				<div class="d-flex flex-column flex-row-fluid position-relative p-7 overflow-hidden">
					<div class="d-flex flex-column-fluid flex-center mt-30 mt-lg-0">
						<div class="login-form login-signin">

							  <div class="text-center mb-10">
								<h3 class="font-size-h2" style="margin-bottom:30px;">Constituency Code</h3>
								<p>Please enter the Constituency Code <br>given to you for login.</p>
							  </div>
						  
							<?php if($this->session->flashdata('msg')): ?>
								<div class="alert alert-danger alert-dismissible " role="alert">
									<button type="button" class="close" data-dismiss="alert" aria-label="Close"><!--<span aria-hidden="true">×</span>--></button>
									<?php echo $this->session->flashdata('msg'); ?>
								</div>
							<?php endif; ?>
								
								<form action="<?php echo base_url(); ?>login/valid_code" method="post" enctype="multipart/form-data" id="loginform" name="loginform">
									<div class="form-group">
									<input class="form-control form-control-solid h-auto py-4 px-5" type="text" placeholder="Constituency Code" name="cons_code" id="cons_code" maxlength="10" autocomplete="off">
									</div>
									<div class="form-group d-flex flex-wrap justify-content-between align-items-center">
									<button type="submit" id="kt_login_signin_submit" class="btn btn-primary font-weight-bold px-9 py-4 my-3" style="text-transform: uppercase;width:100%;">Submit</button>
									</div>
								</form>
						</div>
					</div>
				</div>
				
			</div>
		</div>
		<script type="text/javascript" src="<?php echo base_url(); ?>assets/admin/vendors/jquery/dist/jquery.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>assets/admin/vendors/jquery/dist/jquery.validate.min.js"></script>
	</body>
	<script type="text/javascript">
	
	$('#loginform').validate({ // initialize the plugin
		 rules: {
			 cons_code:{required:true}
		 },
		 messages: {
			  cons_code: "Enter Constituency Code"
		}
	 });
	</script>
</html>
