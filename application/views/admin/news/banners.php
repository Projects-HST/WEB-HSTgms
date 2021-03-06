<div  class="right_col" role="main">
   <div class="">

    <div class="clearfix"></div>
	<div class="row">
      <div class="col-md-12 col-sm-12 ">
         <div class="x_panel">
            <div class="x_title">
               <h2>Add Banners</h2>

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
               <form method="post" action="<?php echo base_url(); ?>news/add_banner" class="form-horizontal" enctype="multipart/form-data" id="banners">
					<div class="item form-group">
						<label class="col-form-label col-md-3 col-sm-3 ">Banner images <span class="required">*</span></label>
						<div class="col-md-4 col-sm-4">
							<input type="file" name="banner_image" id="banner_image" class="form-control" accept="image/*"><span class="required" style="font-size:11px;font-weight:normal;">&nbsp;1400 * 800 px</span>
						</div>

					</div>

                  	<div class="item form-group">
					<label class="col-form-label col-md-3 col-sm-3 ">Status <span class="required">*</span></label>
					<div class="col-md-4 col-sm-4">
						<select class="form-control" name="status" id="status">
							<option value="">SELECT</option>
							<option value="ACTIVE">ACTIVE</option>
							<option value="INACTIVE">INACTIVE</option>
						</select>
					</div>
				</div>
                  <div class="item form-group">
                     <div class="col-md-6 col-sm-6 offset-md-3">
						<button type="submit" class="btn btn-success">Add</button>
                     </div>
                  </div>
               </form>
            </div>
         </div>
      </div>
	</div>


	<div class="clearfix"></div>
	<!-- <div class="row">
      <div class="col-md-12 col-sm-12 ">
         <div class="x_panel">
            <div class="x_title">
               <h2>View Banners</h2>
               <div class="clearfix"></div>
            </div>
            <div class="x_content">

              <table id="example" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
             <thead>
                <tr>
                   <th>S.no</th>
                   <th>Banner</th>
                   <th>Status</th>
                   <th>Action</th>

                </tr>
             </thead>
             <tbody>
               <?php $i=1; foreach($res as $rows){ ?>
                 <tr>
                    <td><?php echo $i; ?></td>
                    <td><img src="<?php echo base_url(); ?>assets/banners/<?php echo $rows->banner_image_name; ?>" class="img-responsive" style="width:200px;height:114px;">
                    <td><?php if($rows->status=='ACTIVE'){ ?>
						<span class="badge-<?= $rows->status ?>">Active</span>
						<?php  }else{ ?>
						  <span class="badge-<?= $rows->status ?>">Inactive</span>
						<?php   } ?>
                    </td>
                <td><a title="EDIT BANNER" href="<?php echo base_url(); ?>news/edit_banner/<?php echo base64_encode($rows->id*98765); ?>"><i class="fa fa-edit" style="font-size:20px;"></i></a>&nbsp;&nbsp;<a title="DELETE BANNER" href="<?php echo base_url(); ?>news/delete_banner/<?php echo base64_encode($rows->id*98765); ?>" onclick="return confirm('Are you sure?')"><i class="fa fa-trash"  style="font-size:20px;"></i></a></td>
                </tr>
            <?php  $i++; } ?>
             </tbody>
          </table>
            </div>
         </div>
      </div>
	</div> -->


  <div class="row">

      <div class="col-md-12 col-sm-12 ">
         <div class="x_panel">
            <div class="x_title">
               <h2>View Banners</h2>
               <div class="clearfix"></div>
            </div>
            <div class="x_content">
      <?php if(empty($res)){
          echo "No Banner Found";
        }else{
          foreach($res as $rows){ ?>
          <div class="col-lg-4" style="margin-bottom:25px;">
          <div id="thumbnail">
            <img src="<?php echo base_url(); ?>assets/banners/<?php echo $rows->banner_image_name; ?>" class="img-responsive" style="width:100%;height:180px;">



            </a>
          </div>
            <!-- <p class="text-left">
              <a href="<?php echo base_url(); ?>news/edit_banner/<?php echo base64_encode($rows->id*98765); ?>" class="badge-<?= $rows->status ?> "><?= $rows->status ?></a> -->
              <br>
            <div class="row mb_20">
              <div class="col-6">
                <p class="text-left">
                  <a href="<?php echo base_url(); ?>news/edit_banner/<?php echo base64_encode($rows->id*98765); ?>" class="badge-<?= $rows->status ?> "><?= $rows->status ?></a></p>
              </div>
              <div class="col-6 text-right">
                <p>
                  <a title="UPDATE" href="<?php echo base_url(); ?>news/edit_banner/<?php echo base64_encode($rows->id*98765); ?>" data-toggle="tooltip" title="EDIT" style="cursor:pointer"><i class="fa fa-edit"></i></a>
                <a title="DELETE" href="<?php echo base_url(); ?>news/delete_banner/<?php echo base64_encode($rows->id*98765); ?>" onclick="return confirm('Are you sure you want to delete this image?')" data-toggle="tooltip"  style="cursor:pointer"><i class="fa fa-trash-o"></i></a></p>
                </p>
              </div>
            </div>

        </div>
        <?php
          }
        } ?>
            </div>
         </div>
      </div>


  </div>

	</div>
   </div>
   <style>
   .thumbnail {
           position: relative;
           width: 200px;
           height: 300px;
       }

       .thumbnail img {
           width: 100%;
           height: 100%;
       }


   }
   </style>
<script type="text/javascript">

	$('#news_menu').addClass('active');
	$('.news_menu').css('display','block');
	$('#banners_menu').addClass('active current-page');
	
	
	$.validator.addMethod('filesize', function (value, element, param) {
		return this.optional(element) || (element.files[0].size <= param)
	}, 'File size must be less than 1 MB');

	$('#banners').validate({
		rules: {
			banner_image:{required:true,accept: "jpg,jpeg,png",filesize: 1048576},
			status: {required: true}
		},
		messages: {
			banner_image:{
			  required:"Choose the photo",
			  accept:"Please upload .jpg or .png .",
			  filesize:"File must be JPG or PNG, less than 1MB"
			},
			status: "Select the Status"
		}
	});
</script>
