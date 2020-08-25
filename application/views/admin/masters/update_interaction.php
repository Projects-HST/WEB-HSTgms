<div  class="right_col" role="main">
   <div class="">
      <div class="col-md-12 col-sm-12 ">
         <div class="x_panel">
            <div class="x_title">
               <h2>Update interaction question</h2>

               <div class="clearfix"></div>
            </div>
            <div class="x_content">
               <form id="master_form" action="<?php echo base_url(); ?>masters/update_interaction_question" method="post" enctype="multipart/form-data">
                 <?php foreach($res as $rows){} ?>
                 <div class="item form-group">
                    <label class="col-form-label col-md-3 col-sm-3 ">widgets title <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 ">
                       <input id="widgets_title" class=" form-control" name="widgets_title" type="text" value="<?php echo  $rows->widgets_title; ?>">
                    </div>
                 </div>

                  <div class="item form-group">
                     <label class="col-form-label col-md-3 col-sm-3 ">Interaction question<span class="required">*</span>
                     </label>
                     <div class="col-md-6 col-sm-6 ">
                        <textarea name="interaction_text" id="interaction_text" class="form-control"><?php echo  $rows->interaction_text; ?></textarea>
                        <input type="hidden" name="interaction_id" id="interaction_id" value="<?php echo base64_encode($rows->id*98765); ?>">
                     </div>
                  </div>

                  <div class="item form-group">
                     <label class="col-form-label col-md-3 col-sm-3 ">status <span class="required">*</span>
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
$('#interactionmenu').addClass('active');

$('#master_form').validate({
     rules: {
         interaction_text:{required:true,maxlength:240 },
         widgets_title:{required:true,maxlength:20 },
         status:{required:true }
     },
     messages: {
       interaction_text:{required:"enter interaction question"},
       widgets_title:{required:"enter title"},
       sms_text:{required:"enter sms text" }

         }
 });
 </script>
