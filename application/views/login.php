<!DOCTYPE html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>GMS </title>
	<link href="<?php echo base_url(); ?>assets/admin/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
	<link href="<?php echo base_url(); ?>assets/admin/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
	<link href="<?php echo base_url(); ?>assets/admin/vendors/nprogress/nprogress.css" rel="stylesheet">
	<link href="<?php echo base_url(); ?>assets/admin/vendors/animate.css/animate.min.css" rel="stylesheet">
	<link href="<?php echo base_url(); ?>assets/admin/build/css/custom.min.css" rel="stylesheet">
	<link href="<?php echo base_url(); ?>assets/admin/vendors/style.css" rel="stylesheet">

	<script type="text/javascript" src="<?php echo base_url(); ?>assets/admin/vendors/jquery/dist/jquery.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/admin/vendors/jquery/dist/jquery.validate.min.js"></script>

</head>
<body class="login">

<a class="hiddenanchor" id="signup"></a>
<a class="hiddenanchor" id="signin"></a>

<div class="login_wrapper">

<div class="animate form login_form">
<section class="login_content">
	<form action="<?php echo base_url(); ?>login/login_check" method="post" enctype="multipart/form-data" id="loginform" name="loginform">
	<h1>Login Form</h1>
		<?php if($this->session->flashdata('msg')): ?>
		  <div class="alert alert-danger">
			  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
				  ×</button>
			  <?php echo $this->session->flashdata('msg'); ?>
		  </div>
		  <?php endif; ?>
	<div>
		<input type="text" name="username" id="username" class="form-control" placeholder="Username" maxlength="15">

	</div>
	<div>
		 <input type="password" name="password" id="password" class="form-control" placeholder="Password" maxlength="15">
	</div>
	<div>
		<button class="btn btn-primary" type="submit">Log in</button>
		<a href="#signup" class="reset_pass"> Lost your password? </a>
	</div>
	<div class="separator"></div>
	</form>
</section>
</div>


<div id="register" class="animate form registration_form">
<section class="login_content">
	<form>
	<h1>Forgot Password</h1>
	<div>
		<input type="text" class="form-control" placeholder="Username" required="" />
	</div>
	<div>
		<button class="btn btn-primary" type="button">Submit</button>
		<a href="#signin" class="reset_pass"> Log in </a>
	</div>

	<div class="separator">
		<div class="clearfix"></div>
	</div>
	</form>
</section>
</div>

</div>

</body>
</html>
<script type="text/javascript">
$('#loginform').validate({ // initialize the plugin
     rules: {
         username:{required:true },
         password:{required:true }
     },
     messages: {
           username: "Enter your username",
           password: "Enter your password"
         }
 });
 </script>
