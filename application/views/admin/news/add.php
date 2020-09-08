<script src="https://cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>
<div  class="right_col" role="main">
   <div class="">

      <div class="clearfix"></div>
	<div class="row">

      <div class="col-md-12 col-sm-12 ">
         <div class="x_panel">
            <div class="x_title">
               <h2>Create News</h2>

               <div class="clearfix"></div>
            </div>
            <div class="x_content">


               <form id="myformsection" action="<?php echo base_url(); ?>news/add_news" method="post" enctype="multipart/form-data">

                  <div class="item form-group">
                     <label class="col-form-label col-md-3 col-sm-3 ">Constituency <span class="required">*</span></label>
                     <div class="col-md-4 col-sm-4 ">
                        <select class="form-control" name="constituency_id" id="constituency_id">
                       <option value="">SELECT</option>
                     <?php foreach($res_constituency as $rows_constituency){ ?>
						<option value="<?php echo $rows_constituency->id ?>"><?php echo $rows_constituency->constituency_name; ?></option>
                    <?php } ?>
                   </select>
                     </div>
                  </div>
				  <div class="item form-group">
                     <label class="col-form-label col-md-3 col-sm-3 ">Date <span class="required">*</span></label>
                     <div class="col-md-4 col-sm-4">
						<input type="text" class="form-control" id="news_date" name="news_date">
                     </div>
                  </div>
				  <div class="item form-group">
                     <label class="col-form-label col-md-3 col-sm-3 ">Title <span class="required">*</span>
                     </label>
                     <div class="col-md-4 col-sm-4">
                         <input type="text" name="news_title" id="news_title" class="form-control" maxlength="200">
                     </div>
                  </div>
                  <div class="item form-group">
                     <label class="col-form-label col-md-3 col-sm-3 ">Details <span class="required">*</span></label>
                     <div class="col-md-8 col-sm-8 ">
					 <textarea name="news_details" class="form-control" rows="10" cols="80" id="news_details" placeholder="News Details" style="text-transform: uppercase;"></textarea>
					 <script>CKEDITOR.replace( 'news_details' ); </script>

                     </div>
                  </div>
					<div class="item form-group">
						<label class="col-form-label col-md-3 col-sm-3 ">Picture <span class="required">*</span></label>
						<div class="col-md-4 col-sm-4">
							<input type="file" id="news_pic" class="form-control" name="news_pic" title="Please select image" accept="image/*" ><span class="required" style="font-size:11px;font-weight:normal;">&nbsp;1400 * 800 px</span>
						</div>
					</div>
					<div class="item form-group">
						<label class="col-form-label col-md-3 col-sm-3 ">Notification</label>
						<div class="col-md-4 col-sm-4">
							<label class="col-form-label "><input type="radio" id="notify" name="notify" value='Y'> Yes  &nbsp;<input type="radio" id="notify" name="notify" value='N' checked> No </label>
						</div>
					</div>
                  <div class="item form-group">
                     <label class="col-form-label col-md-3 col-sm-3 ">status <span class="required">*</span></label>
                     <div class="col-md-4 col-sm-4">
                        <select class="form-control" name="status">
                          <option value="ACTIVE">ACTIVE</option>
                          <option value="INACTIVE">INACTIVE</option>
                        </select>
                     </div>
                  </div>
                  <div class="ln_solid"></div>
                  <div class="item form-group">
                     <div class="col-md-6 col-sm-6 offset-md-3">
                        <button type="submit" class="btn btn-success">Create</button>
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
	$('#create_news_menu').addClass('active current-page');

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
			news_date:{required:true},
			news_title: { required: true },
			news_details:{
			 required: function()
				{
					CKEDITOR.instances.news_details.updateElement();
				}
			},
			news_pic:{required:true,accept: "jpg,jpeg,png",filesize: 1048576},
			status:{ required: true}
		},
		messages: {
				constituency_id: "Select constituency",
				news_date: { required:"Select News Date"},
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
