<?php foreach($res as $rows){
	$user_pic  = trim($rows->profile_pic );
	$user_type  = trim($rows->role_id );
} ?>
<div class="right_col" role="main">
<div class="">

<div class="clearfix"></div>

<div class="row">
<div class="col-md-12 col-sm-12 ">
<div class="x_panel">

<div class="x_title">
	<h2>Profile Update</h2>
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
	<form method="post" action="<?php echo base_url(); ?>login/profile_update" class="form-horizontal" enctype="multipart/form-data" id="profile">


	<div class="item form-group">
		<label class="col-form-label col-md-2 col-sm-3 ">Name <span class="required">*</span></label>
	<div class="col-md-4 col-sm-6 ">
		<input type="text" id="name" name="name" class="form-control" placeholder="FULL NAME" value="<?php echo $rows->full_name; ?>" maxlength='30'>
	</div>
	</div>
	<?php if ($user_type == '1'){?>
		<div class="item form-group">
			<label class="col-form-label col-md-2 col-sm-3 ">Phone Number <span class="required">*</span></label>
		<div class="col-md-4 col-sm-6 ">
			<input type="text" id="phone" name="phone" class="form-control" placeholder="PHONE NUMBER" value="<?php echo $rows->phone_number; ?>" maxlength='10'>
		</div>
		</div>
		<div class="item form-group">
			<label class="col-form-label col-md-2 col-sm-3 ">Email ID <span class="required">*</span></label>
		<div class="col-md-4 col-sm-6 ">
			<input type="text" id="email" name="email" class="form-control" placeholder="Email Id" value="<?php echo $rows->email_id; ?>" maxlength='30'>
		</div>
		</div>
	<?php } ?>
	<div class="item form-group">
		<label class="col-form-label col-md-2 col-sm-3 ">Address <span class="required">*</span></label>
	<div class="col-md-4 col-sm-6 ">
		<textarea id="address" name="address" rows="3" class="form-control"><?php echo $rows->address; ?></textarea>
	</div>
	</div>

	<div class="item form-group">
		<label class="col-form-label col-md-2 col-sm-3 ">Gender <span class="required">*</span></label>
	<div class="col-md-4 col-sm-6">
		<?php $sgender = $rows->gender; ?>
		<input type="radio" name="gender" value="M" <?php if($sgender =='M'){ echo "checked"; }?> style="margin-top:10px;"> Male &nbsp; <input type="radio" name="gender" value="F" <?php if($sgender =='F'){ echo "checked";} ?>> Female
	</div>
	</div>

	<div class="item form-group">
		<label class="col-form-label col-md-2 col-sm-3 ">Profile Picture</label>
	<div class="col-md-4 col-sm-6 ">
		<input type="file" id="profile_pic" class="form-control" name="profile_pic" title="Please select image" accept="image/*" >
		<div class="" style="width:90%;margin-top:5px;">
		<?php
		if ($user_pic != '') {?>
			<img src="<?php echo base_url(); ?>assets/users/<?php echo $user_pic;?>" class="img-responsive profile_img" style="width:150px;">
		<?php } else { ?>
			<img src="<?php echo base_url(); ?>assets/users/default.png" class="img-responsive profile_img" style="width:150px;">
		<?php } ?>
		</div>
	</div>
	</div>
	<div class="ln_solid"></div>
	<div class="item form-group">
	<div class="col-md-4 col-sm-6 offset-md-2">
			<input type="hidden" name="user_id" value="<?php echo $rows->id; ?>">
			<input type="hidden" name="user_old_pic" value="<?php echo $rows->profile_pic; ?>">
		<button type="submit" class="btn btn-success">SAVE</button>
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

$.validator.addMethod('filesize', function (value, element, param) {
	return this.optional(element) || (element.files[0].size <= param)
}, 'File size must be less than 1 MB');

		$('#profile').validate({
		rules: {
			name: {
				required: true
			},
			address: {
				required: true
			},
			phone: {
				required: true,
				maxlength: 10,
				minlength:10,
				number:true,
				remote: {
						 url: "<?php echo base_url(); ?>users/checkphone_edit/<?php echo base64_encode($rows->id*98765); ?>",
						 type: "post"
						}
			},
			email: {
				required: true,
				email: true,
				remote: {
						 url: "<?php echo base_url(); ?>users/checkemail_edit/<?php echo base64_encode($rows->id*98765); ?>",
						 type: "post"
						}
			},
			profile_pic:{required:false,accept: "jpg,jpeg,png",filesize: 1048576},
		},
		messages: {
			name: "Enter name",
			address: "Enter address",
			phone: {
			required: "Enter phone number",
			maxlength:"Invalid phone number",
			minlength:"Invalid phone number",
			number:"Invalid phone number",
			remote: "Phone number already in use!"
			},
		email: {
					 required: "Enter email ID",
					 email: "Enter valid Enter email ID",
					 remote: "Email ID already in use!"
			 },
		profile_pic:{
			  required:"",
			  accept:"Please upload .jpg or .png .",
			  filesize:"File must be JPG or PNG, less than 1MB"
			}
		}
		});



</script>
