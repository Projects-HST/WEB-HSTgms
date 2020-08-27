<script src="https://cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>
<?php foreach($res as $rows){} ?>

<div  class="right_col" role="main">
   <div class="">

   <div class="clearfix"></div>
	<div class="row">

      <div class="col-md-12 col-sm-12 ">
         <div class="x_panel">
            <div class="x_title">
               <h2>Update News Feeder</h2>
               <div class="clearfix"></div>
            </div>
            <div class="x_content">

               <form id="myformsection" action="<?php echo base_url(); ?>news/update_news" method="post" enctype="multipart/form-data">

                  <div class="item form-group">
                     <label class="col-form-label col-md-3 col-sm-3 ">Constituency <span class="required">*</span>
                     </label>
                     <div class="col-md-4 col-sm-4 ">
                        <select class="form-control" name="constituency_id" id="constituency_id">
                       <option value="">SELECT</option>
                     <?php foreach($res_constituency as $rows_constituency){ ?>
							<option value="<?php echo $rows_constituency->id ?>"><?php echo $rows_constituency->constituency_name; ?></option>
					 <?php } ?>
                   </select><script> $('#constituency_id').val('<?php echo $rows->constituency_id; ?>');</script>
                     </div>
                  </div>
					<div class="item form-group">
                     <label class="col-form-label col-md-3 col-sm-3 ">Date <span class="required">*</span></label>
                     <div class="col-md-4 col-sm-4">
						<input type="text" class="form-control" id="news_old_date" name="news_old_date" value="<?php $date=date_create($rows->news_date);echo date_format($date,"d-m-Y");  ?>" disabled>
                     </div>
					 <div class="col-md-3 col-sm-3">
						<input type="text" class="form-control" id="news_date" name="news_date" placeholder="New Date">
                     </div>
                  </div>
				  <div class="item form-group">
                     <label class="col-form-label col-md-3 col-sm-3 ">Title <span class="required">*</span>
                     </label>
                     <div class="col-md-4 col-sm-4">
                         <input type="text" name="news_title" id="news_title" class="form-control" value="<?php echo $rows->title; ?>" maxlength="200">
                     </div>
                  </div>
                  <div class="item form-group">
                     <label class="col-form-label col-md-3 col-sm-3 ">Details <span class="required">*</span>
                     </label>
                     <div class="col-md-8 col-sm-8 ">
					 <textarea name="news_details" class="form-control" rows="10" cols="80" id="news_details" placeholder="News Details" style="text-transform: uppercase;"><?php echo $rows->details; ?></textarea>
					 <script>CKEDITOR.replace( 'news_details' );</script>

                     </div>
                  </div>
					<div class="item form-group">
						<label class="col-form-label col-md-3 col-sm-3 ">Picture </label>
						<div class="col-md-4 col-sm-4">
							<input type="file" id="news_pic" class="form-control" name="news_pic" title="Please select image" accept="image/*" ><span class="required" style="font-size:11px;font-weight:normal;">1400 * 800 px</span>
						</div>
					</div>
					<div class="item form-group">
						<label class="col-form-label col-md-3 col-sm-3 "></label>
						<div class="col-md-6 col-sm-6">
							<?php
							$image_file_name  = trim($rows->image_file_name );
							if ($image_file_name != '') {?>
								<img src="<?php echo base_url(); ?>assets/news/<?php echo $image_file_name;?>" class="img-responsive" style="width:260px;height:150px;">
							<?php } else { ?>
								<img src="<?php echo base_url(); ?>assets/news/default.png" class="img-responsive profile_img" style="width:260px;height:150px;">
							<?php } ?>
						</div>
					</div>
                  <div class="item form-group">
                     <label class="col-form-label col-md-3 col-sm-3 ">status <span class="required">*</span>
                     </label>
                     <div class="col-md-4 col-sm-4">
                        <select class="form-control" name="status" id="status">
                          <option value="ACTIVE">ACTIVE</option>
                          <option value="INACTIVE">INACTIVE</option>
                        </select><script> $('#status').val('<?php echo $rows->status; ?>');</script>
                     </div>
                  </div>
                  <div class="ln_solid"></div>
                  <div class="item form-group">
                     <div class="col-md-6 col-sm-6 offset-md-3">
						<input type="hidden" name="news_id" value="<?php echo $rows->id; ?>">
						<input type="hidden" name="news_old_pic" value="<?php  echo $rows->image_file_name; ?>">
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
</div>
<script type="text/javascript">

   $('#news_menu').addClass('active');
   $('.news_menu').css('display','block');
   $('#list_news_menu').addClass('active current-page');

$.validator.addMethod('filesize', function (value, element, param) {
		return this.optional(element) || (element.files[0].size <= param)
	}, 'File size must be less than 1 MB');


var dateToday = new Date();

	$('#news_date').datetimepicker({
			format: 'DD-MM-YYYY',
			minDate: dateToday
	});

	$('#myformsection').validate({
	ignore: [],
	debug: false,
		rules: {
			constituency_id: { required: true },
			news_title: { required: true },
			news_details:{
			 required: function()
				{
					CKEDITOR.instances.news_details.updateElement();
				}
			},
			news_pic:{required:false,accept: "jpg,jpeg,png",filesize: 1048576},
			status:{ required: true}
		},
		messages: {
				constituency_id: "Select constituency",
				news_title: "Enter News title",
				 news_details:{
					required:"Enter News Details"
				 },

				news_pic:{
					  required:"Select News Picture",
					  accept:"Please upload .jpg or .png .",
					  filesize:"File must be JPG or PNG, less than 1MB"
					},
				status:"Select Status"
		}
	});


 </script>
