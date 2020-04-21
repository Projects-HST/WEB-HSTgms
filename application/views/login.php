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
<<<<<<< HEAD
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.css">
	
=======

	<script type="text/javascript" src="<?php echo base_url(); ?>assets/admin/vendors/jquery/dist/jquery.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/admin/vendors/jquery/dist/jquery.validate.min.js"></script>

>>>>>>> 9254e48c4e0f8a98200491f78fb0b95e9a2e923e
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
			<div class="alert alert-danger alert-dismissible " role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><!--<span aria-hidden="true">×</span>--></button>
				<?php echo $this->session->flashdata('msg'); ?>
			</div>
		<?php endif; ?>
	<div>
<<<<<<< HEAD
		<input type="text" name="username" id="username" class="form-control" placeholder="Username" maxlength="50" style="margin-bottom:10px;">
=======
		<input type="text" name="username" id="username" class="form-control" placeholder="Username" maxlength="15">

>>>>>>> 9254e48c4e0f8a98200491f78fb0b95e9a2e923e
	</div>
	<div>
		 <input type="password" name="password" id="password" class="form-control" placeholder="Password" maxlength="15" style="margin-bottom:10px;"><span toggle="#password" class="fa fa-fw  fa-eye-slash field-icon toggle-password"></span>
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
	<form action="<?php echo base_url(); ?>login/login_check" method="post" enctype="multipart/form-data" id="reset_password" name="reset_password">
	<form method="post" action="#" class="" enctype="multipart/form-data" id="reset_password" name="reset_password">
	<h1>Forgot Password</h1>
	<div>
		<input type="text" class="form-control"  name="user_name" placeholder="Username" maxlength="50" style="margin-bottom:10px;">
	</div>
	<div>
		<button class="btn btn-primary" type="submit">Submit</button>
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
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/admin/vendors/jquery/dist/jquery.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/admin/vendors/jquery/dist/jquery.validate.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.js"></script>
	
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
          username: "Enter valid email id",
          password: "Enter your password"
         }
 });
<<<<<<< HEAD

 $("#reset_password").validate({
       rules: {
           user_name:{required:true,email:true }
       },
       messages: {
            user_name:"Enter valid email id"
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
                                 text: 'Password reset and send to your mail. Please check your mail',
                                 position: 'mid-center',
                                 icon:'success',
                                 stack: false
                             })
                             window.setTimeout(function(){location.reload()},3000);
                     }else{
                       $.toast({
                                 heading: 'Error',
                                 text: "Your username doesn't match our records. Please check.",
                                 position: 'mid-center',
                                 icon:'error',
                                 stack: false
                             })
                     }
                 }
             });
           }
   });
 </script>
=======
 </script>
>>>>>>> 9254e48c4e0f8a98200491f78fb0b95e9a2e923e
