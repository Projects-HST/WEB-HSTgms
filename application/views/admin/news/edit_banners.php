<?php foreach($res as $rows){ } ?>
<div  class="right_col" role="main">
   <div class="">
    <div class="clearfix"></div>
	<div class="row">
      <div class="col-md-12 col-sm-12 ">
         <div class="x_panel">
            <div class="x_title">
               <h2>Update Banner</h2>

               <div class="clearfix"></div>
            </div>
            <div class="x_content">
               <form method="post" action="<?php echo base_url(); ?>news/update_banner" class="form-horizontal" enctype="multipart/form-data" id="banners">
					<div class="item form-group">
						<label class="col-form-label col-md-3 col-sm-3 label-align">Select Banner</label>
						<div class="col-md-4 col-sm-4">
							<input type="file" name="banner_image" id="banner_image" class="form-control" accept="image/*">
						</div>
					</div>
					<div class="item form-group">
						<label class="col-form-label col-md-3 col-sm-3 label-align"></label>
						<div class="col-md-6 col-sm-6">
							<?php
							$image_file_name  = trim($rows->banner_image_name );
							if ($image_file_name != '') {?>
								<img src="<?php echo base_url(); ?>assets/banners/<?php echo $image_file_name;?>" class="img-responsive" style="width:300px;height:150px;">
							<?php } else { ?>
								<img src="<?php echo base_url(); ?>assets/banners/default.png" class="img-responsive profile_img" style="width:150px;">
							<?php } ?>
						</div>
					</div>

                  	<div class="item form-group">
					<label class="col-form-label col-md-3 col-sm-3 label-align">Status <span class="required">*</span></label>
					<div class="col-md-4 col-sm-4">
						<select class="form-control" name="status" id="status">
							<option value="">SELECT</option>
							<option value="ACTIVE">ACTIVE</option>
							<option value="INACTIVE">INACTIVE</option>
						</select><script> $('#status').val('<?php echo $rows->status; ?>');</script>
					</div>
				</div>
                  <div class="item form-group">
                     <div class="col-md-6 col-sm-6 offset-md-3">
						<input type="hidden" name="banner_id" value="<?php echo $rows->id; ?>">
						<input type="hidden" name="banner_old_pic" value="<?php  echo $rows->banner_image_name; ?>">
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
	
	$('#banners').validate({
		rules: {
			banner_image:{required:false,accept: "jpg,jpeg,png",filesize: 1048576},
			status: {required: true}
		},
		messages: {
			banner_image:{
			  required:"Select Banner Image",
			  accept:"Please upload .jpg or .png .",
			  filesize:"File must be JPG or PNG, less than 1MB"
			},
			status: "Select Status"
		}
	});
</script>
