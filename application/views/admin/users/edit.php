<?php foreach($res as $rows){} ?>

<div class="right_col" role="main">
<div class="">

<div class="clearfix"></div>

<div class="row">
<div class="col-md-12 col-sm-12 ">
<div class="x_panel">

<div class="x_title">
	<h2>Edit Users</h2>
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
	<form method="post" action="<?php echo base_url(); ?>users/update_user" class="form-horizontal" enctype="multipart/form-data" id="profile">

	<div class="item form-group">
		<label class="col-form-label col-md-2 col-sm-2 label-align">Role <span class="required">*</span></label>
		<div class="col-md-4 col-sm-4">
			<select class="form-control" name="role" id="role">
				<option value="">Select</option>
				<?php foreach($role as $roles){ ?>
					<option value="<?php echo $roles->id;?>"><?php echo $roles->role_name;?></option>
				<?php } ?>
			</select><script> $('#role').val('<?php echo $rows->role_id; ?>');</script>
		</div>
		<label class="col-form-label col-md-2 col-sm-2 label-align">Paguthi <span class="required">*</span></label>
		<div class="col-md-4 col-sm-4">
			<select class="form-control" name="paguthi" id="paguthi">
				<option value="">Select</option>
				<?php foreach($paguthi as $paguthis){ ?>
					<option value="<?php echo $paguthis->id;?>"><?php echo $paguthis->paguthi_name;?></option>
				<?php } ?>
			</select><script> $('#paguthi').val('<?php echo $rows->pugathi_id; ?>');</script>
		</div>
	</div>
	<div class="item form-group">

		<label class="col-form-label col-md-2 col-sm-2 label-align">Name <span class="required">*</span></label>
		<div class="col-md-4 col-sm-4">
			<input type="text" id="name" name="name" class="form-control" placeholder="FULL NAME" value="<?php echo $rows->full_name; ?>" maxlength='30'>
		</div>
		<label class="col-form-label col-md-2 col-sm-2 label-align">Eamil ID <span class="required">*</span></label>
		<div class="col-md-4 col-sm-4">
			<input type="text" id="email" name="email" class="form-control" placeholder="Email ID" value="<?php echo $rows->email_id; ?>" maxlength='30'>
		</div>
	</div>
		<div class="item form-group">
		<label class="col-form-label col-md-2 col-sm-2 label-align">Gender <span class="required">*</span></label>
		<div class="col-md-4 col-sm-4">
			<?php $sgender = $rows->gender; ?>
		<input type="radio" name="gender" value="M" <?php if($sgender =='M'){ echo "checked"; }?> style="margin-top:10px;"> &nbsp; Male &nbsp; <input type="radio" name="gender" value="F" <?php if($sgender =='F'){ echo "checked";} ?>> Female
		</div>
		<label class="col-form-label col-md-2 col-sm-2 label-align">Phone Number <span class="required">*</span></label>
		<div class="col-md-4 col-sm-4">
			<input type="text" id="phone" name="phone" class="form-control" placeholder="Phone Number" value="<?php echo $rows->phone_number; ?>" maxlength='10'>
		</div>

	</div>
		<div class="item form-group">

		<div class="col-md-6 col-sm-6"></div>
	</div>
	<div class="item form-group">
		<label class="col-form-label col-md-2 col-sm-2 label-align">Address <span class="required">*</span></label>
		<div class="col-md-4 col-sm-4">
			<textarea id="address" name="address" rows="3" class="form-control" maxlength='150'><?php echo $rows->address; ?></textarea>
		</div>
		<div class="col-md-6 col-sm-6"><div class="profile_pic">
		<?php
		$user_pic  = trim($rows->profile_pic );
		if ($user_pic != '') {?>
			<img src="<?php echo base_url(); ?>assets/users/<?php echo $user_pic;?>" class="img-responsive" style="width:150px;">
		<?php } else { ?>
			<img src="<?php echo base_url(); ?>assets/users/default.png" class="img-responsive profile_img" style="width:150px;">
		<?php } ?>
		</div></div>
	</div>
	<div class="item form-group">
		<label class="col-form-label col-md-2 col-sm-2 label-align">Profile Picture <span class="required">*</span></label>
		<div class="col-md-4 col-sm-4">
			<input type="file" id="new_profile_pic" class="form-control" name="new_profile_pic" title="Please select image" accept="image/*" >
		</div>
		<div class="col-md-6 col-sm-6"></div>
	</div>
	<div class="item form-group">
		<label class="col-form-label col-md-2 col-sm-2 label-align">Status <span class="required">*</span></label>
		<div class="col-md-4 col-sm-4">
			<select class="form-control" name="status" id="status">
				<option value="">SELECT</option>
				<option value="ACTIVE">ACTIVE</option>
				<option value="INACTIVE">INACTIVE</option>
			</select><script> $('#status').val('<?php echo $rows->status; ?>');</script>
		</div>
		<div class="col-md-6 col-sm-6"></div>

	</div>
	<div class="ln_solid"></div>

	<div class="item form-group">
	<div class="col-md-6 col-sm-6 offset-md-3">
			<input type="hidden" name="staff_id" value="<?php echo $rows->id; ?>">
			<input type="hidden" name="user_old_pic" value="<?php echo $rows->profile_pic; ?>">
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
$('#user_menu').addClass('active');
$('.user_menu').css('display','block');
$('#list_user').addClass('active current-page');

	$.validator.addMethod('filesize', function (value, element, param) {
		return this.optional(element) || (element.files[0].size <= param)
	}, 'File size must be less than 1 MB');

	$('#profile').validate({
		rules: {
			role: {
				required: true
			},
			paguthi: {
				required: true
			},
			name: {
				required: true
			},
			email: {
				required: true,
				email: true,
				remote: {
						 url: "<?php echo base_url(); ?>users/checkemail_edit/<?php echo base64_encode($rows->id*98765); ?>",
						 type: "post"
						}
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
			status: {
				required: true
			},
			new_profile_pic:{required:false,accept: "jpg,jpeg,png",filesize: 1048576},

		},
		messages: {
			role: "Select role",
			paguthi: "Select paguthi",
			name: "Enter name",
			email: {
						 required: "Enter email ID",
						 email: "Enter valid Enter email ID",
						 remote: "Email ID already in use!"
				 },
			address: "Enter address",
			phone: {
			required: "Enter phone number",
			maxlength:"Invalid phone number",
			minlength:"Invalid phone number",
			number:"Invalid phone number",
			remote: "Phone number already in use!"
			},
			status: "Select Status",
			new_profile_pic:{
			  required:"",
			  accept:"Please upload .jpg or .png .",
			  filesize:"File must be JPG or PNG, less than 1MB"
			}

		}
		});



</script>
