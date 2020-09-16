<div  class="right_col" role="main">
   <div class="">
   <div class="clearfix"></div>
	<div class="row">
      <div class="col-md-12 col-sm-12 ">
         <div class="x_panel">
            <div class="x_title">
               <h2>update sms template</h2>

               <div class="clearfix"></div>
            </div>
            <div class="x_content">
               <form id="master_form" action="<?php echo base_url(); ?>masters/update_sms_template" method="post" enctype="multipart/form-data">
                 <?php foreach($res as $rows){} ?>
                 <div class="item form-group">
                    <label class="col-form-label col-md-3 col-sm-3 "> type <span class="required">*</span>
                    </label>
                    <div class="col-md-4 col-sm-6 ">
                       <select class="form-control" name="template_type" id="template_type">
                         <option value="GENERAL">GENERAL</option>
                         <option value="REPLY">REPLY</option>
                       </select>
                         <script>$('#status').val('<?php echo $rows->template_type; ?>');</script>
                    </div>
                 </div>
                  <div class="item form-group">
                     <label class="col-form-label col-md-3 col-sm-3 "> title <span class="required">*</span>
                     </label>
                     <div class="col-md-4 col-sm-6 ">
                        <input id="sms_title" class="form-control" name="sms_title" type="text" value="<?php echo $rows->sms_title; ?>">
                        <input id="template_id" class="form-control" name="template_id" type="hidden" value="<?php echo base64_encode($rows->id*98765); ?>">
                     </div>
                  </div>
                  <div class="item form-group">
                     <label class="col-form-label col-md-3 col-sm-3 "> text  <span class="required">*</span>
                     </label>
                     <div class="col-md-4 col-sm-6 ">
                        <textarea name="sms_text" id="sms_text" class="form-control"><?php echo $rows->sms_text; ?></textarea>
                     </div>
                  </div>

                  <div class="item form-group">
                     <label class="col-form-label col-md-3 col-sm-3 ">status <span class="required">*</span>
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
$('#mastermenu').addClass('active');
$('.mastermenu').css('display','block');
$('#smsmenu').addClass('active');
$('#master_form').validate({
     rules: {
         sms_title:{required:true,maxlength:50 },
         sms_text:{required:true,maxlength:240 },
         status:{required:true }
     },
     messages: {
       sms_title:{required:"enter sms title"},
       sms_text:{required:"enter sms text" }

         }
 });
 </script>
