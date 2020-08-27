<div  class="right_col" role="main">
   <div class="">
      <div class="col-md-12 col-sm-12 ">
         <div class="x_panel">
            <div class="x_title">
               <h2>Update Festival</h2>

               <div class="clearfix"></div>
            </div>
            <div class="x_content">
              <?php foreach($res as $rows) {}?>

               <form id="master_form" action="<?php echo base_url(); ?>masters/update_festival" method="post" enctype="multipart/form-data">
                 <div class="item form-group">
                    <label class="col-form-label col-md-3 col-sm-3 ">religion  <span class="required">*</span>
                    </label>
                    <div class="col-md-4 col-sm-6 ">
                       <select class="form-control" name="religion_id" id="religion_id">
                          <?php foreach($res_religion as $rows_religion){ ?>
                          <option value="<?php echo $rows_religion->id; ?>"><?php echo $rows_religion->religion_name; ?></option>
                        <?php } ?>
                       </select>
                       <script>$('#religion_id').val('<?php echo $rows->religion_id; ?>');</script>
                    </div>
                 </div>
                  <div class="item form-group">
                     <label class="col-form-label col-md-3 col-sm-3 ">Festival  <span class="required">*</span>
                     </label>
                     <div class="col-md-4 col-sm-6 ">
                       <input type="hidden" name="fm_id" value="<?php echo $rows->id; ?>">
                        <input id="festival_name" class=" form-control" name="festival_name" type="text" value="<?php echo $rows->festival_name;  ?>">
                     </div>
                  </div>

                  <div class="item form-group">
                     <label class="col-form-label col-md-3 col-sm-3 ">status <span class="required">*</span>
                     </label>
                     <div class="col-md-4 col-sm-6 ">
                        <select class="form-control" name="status">
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
         religion_id:{required:true
             },
         festival_name:{required:true,maxlength:80
                 },
         status:{required:true }
     },
     messages: {
           festival_name: { required:"enter the festival name"}

         }
 });
 </script>
