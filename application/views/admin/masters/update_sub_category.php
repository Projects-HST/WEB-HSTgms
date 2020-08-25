<div  class="right_col" role="main">
   <div class="">
      <div class="col-md-12 col-sm-12 ">
         <div class="x_panel">
            <div class="x_title">
               <h2>Update Grievance Sub category</h2>

               <div class="clearfix"></div>
            </div>
            <div class="x_content">
              <?php foreach($res as $rows){}  ?>
               <form id="master_form" action="<?php echo base_url(); ?>masters/update_sub_category_name" method="post" enctype="multipart/form-data">

                  <div class="item form-group">
                     <label class="col-form-label col-md-3 col-sm-3 ">sub category name <span class="required">*</span>
                     </label>
                     <div class="col-md-4 col-sm-6 ">
                        <input id="grievance_name" class=" form-control" name="sub_category_name" type="text" value="<?php echo $rows->sub_category_name;  ?>">
                        <input id="sub_category_id" class="form-control" name="sub_category_id" type="hidden" value="<?php echo $this->uri->segment(3); ?>">
                        <input id="grievance_id" class="form-control" name="grievance_id" type="hidden" value="<?php echo base64_encode($rows->grievance_id*98765); ?>">
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
                        <button type="submit" class="btn btn-success">Update </button>
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
$('#grievancemeenu').addClass('active');
$('#master_form').validate({
     rules: {
         sub_category_name:{required:true,maxlength:80 },

         status:{required:true }
     },
     messages: {
           sub_category_name: { required:"enter the Sub category",remote:"Sub category type already exist"}

         }
 });
 </script>
