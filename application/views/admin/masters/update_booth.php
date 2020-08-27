<div  class="right_col" role="main">
   <div class="">
      <div class="col-md-12 col-sm-12 ">
         <div class="x_panel">
            <div class="x_title">
               <h2>Update Booth</h2>

               <div class="clearfix"></div>
            </div>
            <div class="x_content">

              <?php foreach($res as $rows){} ?>
               <form id="master_form" action="<?php echo base_url(); ?>masters/update_booth" method="post" enctype="multipart/form-data">

                  <div class="item form-group">
                     <label class="col-form-label col-md-3 col-sm-3 ">booth  <span class="required">*</span>
                     </label>
                     <div class="col-md-4 col-sm-6 ">
                        <input id="booth_name" class=" form-control" name="booth_name" type="text" value="<?php echo $rows->booth_name; ?>">
                        <input id="ward_id" class=" form-control" name="ward_id" type="hidden" value="<?php echo base64_encode($rows->ward_id*98765); ?>">
                          <input id="booth_id" class=" form-control" name="booth_id" type="hidden" value="<?php echo base64_encode($rows->id*98765); ?>">
                     </div>
                  </div>
                  <div class="item form-group">
                     <label class="col-form-label col-md-3 col-sm-3 ">booth address <span class="required">*</span>
                     </label>
                     <div class="col-md-4 col-sm-6 ">
                        <textarea name="booth_address" id="booth_address" class="form-control"><?php echo $rows->booth_address; ?></textarea>
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
<script type="text/javascript">
$('#mastermenu').addClass('active');
$('.mastermenu').css('display','block');
$('#wardmenu').addClass('active');
$('#master_form').validate({
     rules: {
         booth_name:{required:true,maxlength:40
             },
         booth_address:{required:true,maxlength:240
                 },
         status:{required:true }
     },
     messages: {
           booth_name: { required:"enter the booth name"},
           booth_address: { required:"enter the booth address"}

         }
 });
 </script>
