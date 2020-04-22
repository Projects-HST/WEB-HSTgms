<div class="right_col" role="main">
<div class="">

<div class="clearfix"></div>

<div class="row">
<div class="col-md-12 col-sm-12 ">
<div class="x_panel">

<div class="x_title">
	<h2>Create Users</h2>
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
	<form method="post" action="<?php echo base_url(); ?>users/add_users" class="form-horizontal" enctype="multipart/form-data" id="profile">
	
	<div class="item form-group">
		<label class="col-form-label col-md-2 col-sm-2 label-align">Role <span class="required">*</span></label>
		<div class="col-md-4 col-sm-4">
			<select class="form-control" name="role" id="role">
				<option value="">Select</option>
				<?php foreach($role as $rows){ ?>
					<option value="<?php echo $rows->id;?>"><?php echo $rows->role_name;?></option>
				<?php } ?>
			</select>
		</div>
		<label class="col-form-label col-md-2 col-sm-2 label-align">Paguthi <span class="required">*</span></label>
		<div class="col-md-4 col-sm-4">
			<select class="form-control" name="paguthi" id="paguthi">
				<option value="">Select</option>
				<?php foreach($paguthi as $rows){ ?>
					<option value="<?php echo $rows->id;?>"><?php echo $rows->paguthi_name;?></option>
				<?php } ?>
			</select>
		</div>
	</div>
	<div class="item form-group">
		
		<label class="col-form-label col-md-2 col-sm-2 label-align">Name <span class="required">*</span></label>
		<div class="col-md-4 col-sm-4">
			<input type="text" id="name" name="name" class="form-control" placeholder="FULL NAME">
		</div>
		<label class="col-form-label col-md-2 col-sm-2 label-align">Eamil ID <span class="required">*</span></label>
		<div class="col-md-4 col-sm-4">
			<input type="text" id="email" name="email" class="form-control" placeholder="Email ID">
		</div>
	</div>
		<div class="item form-group">
		<label class="col-form-label col-md-2 col-sm-2 label-align">Gender <span class="required">*</span></label>
		<div class="col-md-4 col-sm-4">
			<input type="radio" name="gender" value="M" checked style="margin-top:10px;"> &nbsp; Male &nbsp; <input type="radio" name="gender" value="F"> Female
		</div>
		<label class="col-form-label col-md-2 col-sm-2 label-align">Phone Number <span class="required">*</span></label>
		<div class="col-md-4 col-sm-4">
			<input type="text" id="phone" name="phone" class="form-control" placeholder="Phone Number">
		</div>
		
	</div>
		<div class="item form-group">
		
		<div class="col-md-6 col-sm-6"></div>
	</div>
	<div class="item form-group">
		<label class="col-form-label col-md-2 col-sm-2 label-align">Address <span class="required">*</span></label>
		<div class="col-md-4 col-sm-4">
			<textarea id="address" name="address" rows="3" class="form-control"></textarea>
		</div>
		<div class="col-md-6 col-sm-6"></div>
	</div>
	<div class="item form-group">
		<label class="col-form-label col-md-2 col-sm-2 label-align">Profile Picture <span class="required">*</span></label>
		<div class="col-md-4 col-sm-4">
			<input type="file" id="profile_pic" class="form-control" name="profile_pic" title="Please select image" accept="image/*" >
		</div>
		<div class="col-md-6 col-sm-6"></div>
	</div>
	<div class="item form-group">
		<label class="col-form-label col-md-2 col-sm-2 label-align">Status <span class="required">*</span></label>
		<div class="col-md-4 col-sm-4">
			<select class="form-control" name="status">
				<option value="">SELECT</option>
				<option value="Active">ACTIVE</option>
				<option value="Inactive">INACTIVE</option>
			</select>
		</div>
		<div class="col-md-6 col-sm-6"></div>
		
	</div>
	<div class="ln_solid"></div>
	
	<div class="item form-group">
	<div class="col-md-6 col-sm-6 offset-md-3">
		<button type="submit" class="btn btn-success">CREATE</button>
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
						 url: "<?php echo base_url(); ?>users/checkemail",
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
			},
			profile_pic:{required:true,accept: "jpg,jpeg,png",filesize: 1048576},
			status: {
				required: true
			}
		},
		messages: {
			role: "Select Role",
			paguthi: "Select Paguthi",
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
			number:"Invalid phone number"

			},
			profile_pic:{
			  required:"Select Profile Picture",
			  accept:"Please upload .jpg or .png .",
			  filesize:"File must be JPG or PNG, less than 1MB"
			},
			status: "Select Status",
		}
		});



</script>