<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<meta name="description"/>
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
		<link href="<?php echo base_url(); ?>assets/admin/css/login.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url(); ?>assets/admin/css/style.bundle.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url(); ?>assets/admin/css/jquery.toast.min.css" rel="stylesheet" type="text/css" />
		
		<link rel="shortcut icon" href="<?php echo base_url(); ?>assets/admin/media/logos/favicon.png" />
	</head>
	<body id="kt_body" class="header-fixed header-mobile-fixed subheader-enabled page-loading">

		<div class="d-flex flex-column flex-root">
			<div class="login login-1 login-signin-on d-flex flex-column flex-lg-row flex-column-fluid bg-white" id="kt_login">
				<div class="login-aside d-flex flex-row-auto bgi-size-cover bgi-no-repeat p-10 p-lg-10" style="background-image: url(<?php echo base_url(); ?>assets/admin/images/bg-4.jpg);">
					
				</div>
				<div class="d-flex flex-column flex-row-fluid position-relative p-7 overflow-hidden">
					<div class="d-flex flex-column-fluid flex-center mt-30 mt-lg-0">
						<title>Forgot Password</title>

<div class="login-form login-signin">
  <div class="text-center mb-10">
    <h3 class="font-size-h1">Forgot Password</h3>
    <p class="text-muted font-weight-bold">Enter your Login Email Address</p>
  </div>

   <form action="<?php echo base_url(); ?>login/login_check" method="post" enctype="multipart/form-data" id="reset_password" name="reset_password">
    <div class="form-group">
      
      <input class="form-control form-control-solid h-auto py-4 px-5" type="email" placeholder="Email Address" name="user_name" id="user_name" autocomplete="off" />

    </div>

    <!--begin::Action-->
    <div class="form-group d-flex flex-wrap justify-content-between align-items-center">
      <a href="<?php echo base_url(); ?>login/user_login" class="text-dark-50 text-hover-primary my-3 mr-2" id="kt_login_forgot">Login</a>
      <button type="submit" id="kt_login_signin_submit" class="btn btn-primary font-weight-bold px-9 py-4 my-3">RESET PASSWORD</button>
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
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.js"></script>
	</body>
	<script type="text/javascript">
$("#reset_password").validate({
       rules: {
           user_name:{required:true,email:true }
       },
       messages: {
            user_name:"Enter valid email address"
           },
    submitHandler: function(form) {
      $.ajax({
                 url: "<?php echo base_url(); ?>login/forgot_password",
                 type: 'POST',
                 data: $('#reset_password').serialize(),
                 success: function(response) {
                     if (response=="success") {
                       $.toast({
                                 heading: 'Success',
                                 text: 'Password reset successfully and sent to your Email Id',
                                 position: 'bottom-right',
                                 icon:'success',
                                 stack: false
                             })
                            // window.setTimeout(function(){location.reload()},3000);
							window.setTimeout(function(){window.location.replace("<?php echo base_url(); ?>login/user_login/")},100000);

                     }else{
                       $.toast({
                                 heading: 'Error',
                                 text: "Your Email Id doesn't match our record. Please check!.",
                                 position: 'bottom-right',
                                 icon:'error',
                                 stack: false
                             })
                     }
                 }
             });
           }
   });
 </script>
</html>
