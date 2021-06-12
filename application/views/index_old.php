<!DOCTYPE html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>GMS - LOGIN </title>
	<link href="<?php echo base_url(); ?>assets/admin/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
	<link href="<?php echo base_url(); ?>assets/admin/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
	<link href="<?php echo base_url(); ?>assets/admin/vendors/nprogress/nprogress.css" rel="stylesheet">
	<link href="<?php echo base_url(); ?>assets/admin/vendors/animate.css/animate.min.css" rel="stylesheet">
	<link href="<?php echo base_url(); ?>assets/admin/build/css/custom.min.css" rel="stylesheet">
	<link href="<?php echo base_url(); ?>assets/admin/vendors/style.css" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.css">

</head>
<style>

</style>
<body class="login">

<div class="login_wrapper">
<div class="row">
              
              <div class="col-md-6 col-sm-12" style="background-image: url(<?php echo base_url(); ?>assets/admin/media/bg/bg-4.jpg);">

              </div>
              

              
              <div class="col-md-6 col-sm-12  ">
			  
				<section class="login_content">
					<img src="<?php echo base_url(); ?>assets/images/login.png" class="img-responsive login_img">
					<form action="<?php echo base_url(); ?>login/valid_code" method="post" enctype="multipart/form-data" id="loginform" name="loginform">

					<h1>Login</h1>
						<?php if($this->session->flashdata('msg')): ?>
							<div class="alert alert-danger alert-dismissible " role="alert">
								<button type="button" class="close" data-dismiss="alert" aria-label="Close"><!--<span aria-hidden="true">×</span>--></button>
								<?php echo $this->session->flashdata('msg'); ?>
							</div>
						<?php endif; ?>
					<div>
						<input type="text" name="cons_code" id="cons_code" class="form-control" placeholder="Consultancy Code" maxlength="50" style="margin-bottom:10px;">
					</div>
					
					<div class="text-center">
					<p>	<button class="btn btn-primary green_btn" type="submit" style="text-transform: uppercase;">Submit</button></p>
					</div>
					
					</form>
				</section>
              </div>
              
</div>
</div>
<style>
.reset_pass{
	font-weight: 500;
	color: #212529;
}
.green_btn{
	background-color: #31aa15;
	border: none;
	    width: 100%;
}
.green_btn:hover{
	background-color: #31aa15;
	border: none;

}
h1{
	color: #212529;
}
.error{
	text-align: left;
	width:100%;
}
</style>
</body>
</html>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/admin/vendors/jquery/dist/jquery.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/admin/vendors/jquery/dist/jquery.validate.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.js"></script>

<script type="text/javascript">

$('#loginform').validate({ // initialize the plugin
     rules: {
         cons_code:{required:true}
     },
     messages: {
          cons_code: "Enter Consultancy Code"
         }
 });

 
 </script>
