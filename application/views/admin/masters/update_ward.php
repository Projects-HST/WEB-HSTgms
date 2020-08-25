<div  class="right_col" role="main">
   <div class="">
      <div class="col-md-12 col-sm-12 ">
         <div class="x_panel">
            <div class="x_title">
               <h2>Update Ward</h2>

               <div class="clearfix"></div>
            </div>
            <div class="x_content">

<?php foreach($res as $rows){} ?>
               <form id="master_form" action="<?php echo base_url(); ?>masters/update_ward" method="post" enctype="multipart/form-data">
                 <div class="item form-group">
                    <label class="col-form-label col-md-3 col-sm-3 ">Paguthi name <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 ">
                       <select class="form-control" name="paguthi_id" id="paguthi_id">
                          <?php foreach($res_paguthi as $rows_paguthi){ ?>
                          <option value="<?php echo $rows_paguthi->id; ?>"><?php echo $rows_paguthi->paguthi_name; ?></option>
                        <?php } ?>
                       </select>
                       <script>$('#paguthi_id').val('<?php echo $rows->paguthi_id; ?>')</script>
                    </div>
                 </div>
                  <div class="item form-group">
                     <label class="col-form-label col-md-3 col-sm-3 ">ward name <span class="required">*</span>
                     </label>
                     <div class="col-md-6 col-sm-6 ">
                        <input id="ward_name" class=" form-control" name="ward_name" type="text" value="<?php echo $rows->ward_name; ?>">
                        <input id="ward_id" class=" form-control" name="ward_id" type="hidden" value="<?php echo base64_encode($rows->id*98765); ?>">
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
$('#wardmenu').addClass('active');
$('#master_form').validate({
     rules: {
         paguthi_id:{required:true
             },
         ward_name:{required:true,maxlength:10
                 },
         status:{required:true }
     },
     messages: {
           ward_name: { required:"enter the ward name"}

         }
 });
 </script>
