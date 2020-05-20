<div  class="right_col" role="main">
   <div class="">
      <div class="col-md-12 col-sm-12 ">
         <div class="x_panel">
            <div class="x_title">
               <h2>Update Seeker type</h2>

               <div class="clearfix"></div>
            </div>
            <div class="x_content">

              <?php foreach($res as $rows){} ?>
               <form id="master_form" action="<?php echo base_url(); ?>masters/update_seeker" method="post" enctype="multipart/form-data">
                  <div class="item form-group">
                     <label class="col-form-label col-md-3 col-sm-3 label-align">seeker name <span class="required">*</span>
                     </label>
                     <div class="col-md-6 col-sm-6 ">
                        <input id="seeker_info" class=" form-control" name="seeker_info" type="text" value="<?php echo $rows->seeker_info; ?>">
                        <input id="seeker_id" class=" form-control" name="seeker_id" type="hidden" value="<?php echo base64_encode($rows->id*98765); ?>">
                     </div>
                  </div>

                  <div class="item form-group">
                     <label class="col-form-label col-md-3 col-sm-3 label-align">status <span class="required">*</span>
                     </label>
                     <div class="col-md-6 col-sm-6 ">
                        <select class="form-control" name="status" id="status">
                          <option value="ACTIVE">ACTIVE</option>
                          <option value="INACTIVE">INACTIVE</option>
                        </select>
                          <script>$('#status').val('<?php echo $rows->status; ?>');</script>
                     </div>
                  </div>
                  <div class="ln_solid"></div>
                  <div class="item form-group">
                     <div class="col-md-6 col-sm-6 offset-md-3">
                        <button type="submit" class="btn btn-success">Update</button>
                     </div>
                  </div>
               </form>
            </div>
         </div>
      </div>



   </div>
</div>
<script type="text/javascript">
$('#mastermenu').addClass('active');
$('.mastermenu').css('display','block');
$('#seekermenu').addClass('active');
$('#master_form').validate({
     rules: {
         seeker_info:{required:true,maxlength:80,
           remote: {
                     url: "<?php echo base_url(); ?>masters/checkseekerexist/<?php echo $rows->id; ?>",
                     type: "post"
                  }
             },

         status:{required:true }
     },
     messages: {
           seeker_info: { required:"enter the seeker type",remote:"seeker type already exist"}

         }
 });
 </script>
