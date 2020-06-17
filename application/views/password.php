<?php foreach($res as $rows){} ?>
<div class="right_col" role="main">
<div class="">

<div class="clearfix"></div>

<div class="row">
<div class="col-md-12 col-sm-12 ">
<div class="x_panel">

<div class="x_title">
	<h2>Password Update</h2>
	<div class="clearfix"></div>
</div>

<div class="x_content">

	<?php if($this->session->flashdata('msg')): ?>
		<div class="alert alert-success alert-dismissible " role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
		</button>
		<?php echo $this->session->flashdata('msg'); ?>
		</div>
	<?php endif; ?>
<br>
	<form method="post" action="<?php echo base_url(); ?>login/password_update" class="form-horizontal" enctype="multipart/form-data" id="frmPassword">
	
	
	<div class="item form-group">
		<label class="col-form-label col-md-3 col-sm-3 label-align">Current Password <span class="required">*</span></label>
	<div class="col-md-6 col-sm-6">
		<input type="password" placeholder="Enter Current Password" name="old_password" id="old_password" class="form-control" value="" maxlength="10"><span toggle="#old_password" class="fa fa-fw  fa-eye-slash field-icon-inner toggle-password"></span>
	</div>
	</div>
	
	<div class="item form-group">
		<label class="col-form-label col-md-3 col-sm-3 label-align">New Password <span class="required">*</span></label>
	<div class="col-md-6 col-sm-6">
			<input type="password" placeholder="Enter New Password" id="new_password" name="new_password" class="form-control input-sm" value="" maxlength="10"><span toggle="#new_password" class="fa fa-fw  fa-eye-slash field-icon-inner toggle-password"></span>
	</div>
	</div>
	
	<div class="item form-group">
		<label class="col-form-label col-md-3 col-sm-3 label-align">Confirm New Password <span class="required">*</span></label>
	<div class="col-md-6 col-sm-">
		<input type="password" placeholder="Confirm New Password" id="retype_password" name="retype_password" class="form-control input-sm" value="" maxlength="10"><span toggle="#retype_password" class="fa fa-fw  fa-eye-slash field-icon-inner toggle-password"></span>
	</div>
	</div>
	
	<div class="item form-group">
		<label class="col-form-label col-md-3 col-sm-3 label-align"></label>
		<div class="col-md-6 col-sm-6" style="font-size:9px;color:#ed0404;">NOTE: PASSWORD SAVED AS CAPITAL LETER</div>
	</div>
	
	<div class="ln_solid"></div>
	<div class="item form-group">
	<div class="col-md-6 col-sm-6 offset-md-3">
		<input type="hidden" name="user_id" value="<?php echo $rows->id; ?>">
		<button type="submit" class="btn btn-success">UPDATE</button>
	</div>
	</div>
	</form>
</div>

</div>
</div>
</div>

</div>
</div>

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
 
  $("#frmPassword").validate({
         rules: {
             old_password:{
               required: true,
                remote: {
                       url: "<?php echo base_url(); ?>login/check_password_match/<?php echo $rows->id; ?>",
                       type: "post"
                    }
             },
             new_password: {
                 required: true,
                 maxlength: 10,
                 minlength:6
             },
             retype_password: {
                 required: true,
                 maxlength: 10,
                 minlength:6,equalTo: '[name="new_password"]'
             }
         },
         messages: {
               old_password: {
                    required: "Enter your current password",
                    remote: "Current password doesn't match!"
                },
                new_password: {
                  required: "Enter a new password",
                  maxlength:"Maximum 10 digits",
                  minlength:"Minimum 6 digits"

                },
               retype_password: {
                 required: "Please confirm the new password by re-typing it.",
                 maxlength:"Maximum 10 digits",
                 minlength:"Minimum 6 digits",
                 equalTo:"This doesn't match with your new password!"

                }
             }
     });

</script>