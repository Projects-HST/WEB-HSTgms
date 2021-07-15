<div  class="right_col" role="main">
   <div class="">
   <div class="clearfix"></div>
	<div class="row">
      <div class="col-md-12 col-sm-12 ">
         <div class="x_panel">
            <div class="x_title">
               <h2>Update Video</h2>

               <div class="clearfix"></div>
            </div>
            <div class="x_content">
              <?php foreach($res as $rows){} ?>

               <form id="video_form" action="<?php echo base_url(); ?>news/update_video" method="post" enctype="multipart/form-data">
                  <div class="item form-group">
                     <label class="col-form-label col-md-3 col-sm-3">Video Title  <span class="required">*</span>
                     </label>
                     <div class="col-md-4 col-sm-6 ">
                        <input id="video_title" class=" form-control" name="video_title" type="text" value="<?php echo $rows->video_title; ?>">
                        <input id="video_id" class=" form-control" name="video_id" type="hidden" value="<?php echo $rows->id; ?>">
                     </div>
                  </div>
                  <div class="item form-group">
                     <label class="col-form-label col-md-3 col-sm-3">Video URL <span class="required">*</span>
                     </label>
                     <div class="col-md-4 col-sm-6 ">
                        <input id="video_url" class=" form-control" name="video_url" type="text" value="<?php echo $rows->video_url; ?>">
                     </div>
                  </div>
                  <div class="item form-group">
                     <label class="col-form-label col-md-3 col-sm-3">status <span class="required">*</span>
                     </label>
                     <div class="col-md-4 col-sm-6 ">
                        <select class="form-control" name="status" id="status">
                          <option value="ACTIVE">ACTIVE</option>
                          <option value="INACTIVE">INACTIVE</option>
                        </select>
                        <script>$('#status').val('<?php echo $rows->status; ?>');</script>
                     </div>
                  </div>
                  <div class="ln_solid"></div>
                  <div class="item form-group">
                     <div class="col-md-4 col-sm-6 offset-md-3">
                        <button type="submit" class="btn btn-success">Update</button>
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
	$('#news_menu').addClass('active');
	$('.news_menu').css('display','block');
	$('#videos_menu').addClass('active current-page');

$('#video_form').validate({
     rules: {
         video_title:{required:true,maxlength:80},
         video_url:{required:true,maxlength:80,
           remote: {
                     url: "<?php echo base_url(); ?>news/checkvideourlexist/<?php echo $rows->id; ?>",
                     type: "post"
                  }
                 },
         status:{required:true }
     },
     messages: {
			video_title: { required:"enter the video title"},
			video_url: { required:"enter the video URL",remote:"video URL already exist"}
     }
 });
 </script>
