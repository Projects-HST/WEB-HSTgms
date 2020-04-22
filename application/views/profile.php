<?php foreach($res as $rows){
	$user_pic  = trim($rows->profile_pic );
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
		<label class="col-form-label col-md-3 col-sm-3 label-align">Name <span class="required">*</span></label>
	<div class="col-md-6 col-sm-6 ">
		<input type="text" id="name" name="name" class="form-control" placeholder="FULL NAME" value="<?php echo $rows->full_name; ?>">
	</div>
	</div>
	
	<div class="item form-group">
		<label class="col-form-label col-md-3 col-sm-3 label-align">Phone Number <span class="required">*</span></label>
	<div class="col-md-6 col-sm-6 ">
		<input type="text" id="phone" name="phone" class="form-control" placeholder="PHONE NUMBER" value="<?php echo $rows->phone_number; ?>">
	</div>
	</div>
	
	<div class="item form-group">
		<label class="col-form-label col-md-3 col-sm-3 label-align">Address <span class="required">*</span></label>
	<div class="col-md-6 col-sm-6 ">
		<textarea id="address" name="address" rows="3" class="form-control"><?php echo $rows->address; ?></textarea>
	</div>
	</div>
	
	<div class="item form-group">
		<label class="col-form-label col-md-3 col-sm-3 label-align">Gender <span class="required">*</span></label>
	<div class="col-md-6 col-sm-6">
		<?php $sgender = $rows->gender; ?>
		<input type="radio" name="gender" value="M" <?php if($sgender =='M'){ echo "checked"; }?> style="margin-top:10px;"> &nbsp; Male &nbsp; <input type="radio" name="gender" value="F" <?php if($sgender =='F'){ echo "checked";} ?>> Female
	</div>
	</div>

	<div class="item form-group">
		<label class="col-form-label col-md-3 col-sm-3 label-align">Profile Picture</label>
	<div class="col-md-6 col-sm-6 ">
		<input type="file" id="profile_pic" class="form-control" name="profile_pic" title="Please select image" accept="image/*" >
		<div class="profile_pic">
		<?php
		if ($user_pic != '') {?>
			<img src="<?php echo base_url(); ?>assets/users/<?php echo $user_pic;?>" class="img-circle profile_img">
		<?php } else { ?>
			<img src="<?php echo base_url(); ?>assets/users/default.png" class="img-circle profile_img">
		<?php } ?>
		</div>
	</div>
	</div>
	<div class="ln_solid"></div>
	<div class="item form-group">
	<div class="col-md-6 col-sm-6 offset-md-3">
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
			},
			staff_new_pic:{required:false,accept: "jpg,jpeg,png",filesize: 1048576},
		},
		messages: {
			name: "Enter name",
			address: "Enter address",
			phone: {
			required: "Enter phone number",
			maxlength:"Invalid phone number",
			minlength:"Invalid phone number",
			number:"Invalid phone number"

			},
		staff_new_pic:{
			  required:"",
			  accept:"Please upload .jpg or .png .",
			  filesize:"File must be JPG or PNG, less than 1MB"
			}
		}
		});



</script>