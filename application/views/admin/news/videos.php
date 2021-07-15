<div  class="right_col" role="main">
   <div class="">
   <div class="clearfix"></div>
	<div class="row">
      <div class="col-md-12 col-sm-12 ">
         <div class="x_panel">
            <div class="x_title">
               <h2>Create Videos</h2>
               <div class="clearfix"></div>
            </div>
            <div class="x_content">


               <form id="video_form" action="<?php echo base_url(); ?>news/create_video" method="post" enctype="multipart/form-data">
                  <div class="item form-group">
                     <label class="col-form-label col-md-3 col-sm-3">Video Title  <span class="required">*</span>
                     </label>
                     <div class="col-md-4 col-sm-6 ">
                        <input id="video_title" class=" form-control" name="video_title" type="text" value="">
                     </div>
                  </div>
                  <div class="item form-group">
                     <label class="col-form-label col-md-3 col-sm-3">Video URL <span class="required">*</span>
                     </label>
                     <div class="col-md-4 col-sm-6 ">
                        <input id="video_url" class=" form-control" name="video_url" type="text" value="">
                     </div>
                  </div>
                  <div class="item form-group">
                     <label class="col-form-label col-md-3 col-sm-3">Status <span class="required">*</span>
                     </label>
                     <div class="col-md-4 col-sm-6 ">
                        <select class="form-control" name="status">
                          <option value="ACTIVE">ACTIVE</option>
                          <option value="INACTIVE">INACTIVE</option>
                        </select>
                     </div>
                  </div>
                  <div class="ln_solid"></div>
                  <div class="item form-group">
                     <div class="col-md-4 col-sm-6 offset-md-3">
                        <button type="submit" class="btn btn-success">Create</button>
                     </div>
                  </div>
               </form>
            </div>
         </div>
      </div>


        <div class="col-md-12 col-sm-12 ">
          <?php if($this->session->flashdata('msg')) {
            $message = $this->session->flashdata('msg');?>
            <div class="<?php echo $message['class'] ?> alert-dismissible">
               <button type="button" class="close" data-dismiss="alert">&times;</button>
                <?php echo $message['message']; ?>
           </div>
          <?php  }  ?>
             <div class="x_panel">
			 <div class="x_title">
               <h2>List Videos</h2>
               <div class="clearfix"></div>
            </div>
          <table id="example" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
             <thead>
                <tr style="text-align:center;">
                   <th>S.no</th>
                   <th>Video title</th>
                   <th>Video url</th>
                   <th>status</th>
                   <th>Action</th>

                </tr>
             </thead>
             <tbody>
               <?php $i=1; foreach($res as $rows){ ?>
                 <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php echo $rows->video_title; ?></td>
                    <td><?php echo $rows->video_url ;?></td>
                    <td><?php if($rows->status=='ACTIVE'){ ?>
                    <span class="badge-<?= $rows->status ?>">Active</span>
                    <?php  }else{ ?>
                    <span class="badge-<?= $rows->status ?>">Inactive</span>
                    <?php   } ?>
                    </td>
                    <td>
                    <a title="EDIT" href="<?php echo base_url(); ?>news/get_video_edit/<?php echo base64_encode($rows->id*98765); ?>"><i class="fa fa-edit"></i></a></td>
                 </tr>

            <?php  $i++; } ?>



             </tbody>
          </table>
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
							url: "<?php echo base_url(); ?>news/checkvideourl",
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
