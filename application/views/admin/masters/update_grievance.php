<div  class="right_col" role="main">
   <div class="">
      <div class="col-md-12 col-sm-12 ">
         <div class="x_panel">
            <div class="x_title">
               <h2>Update Grievance type</h2>

               <div class="clearfix"></div>
            </div>
            <div class="x_content">

              <?php foreach($res as $rows){} ?>
               <form id="master_form" action="<?php echo base_url(); ?>masters/update_grievance" method="post" enctype="multipart/form-data">
                 <div class="item form-group">
                    <label class="col-form-label col-md-3 col-sm-3 label-align">Seeker <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 ">
                       <select class="form-control" name="seeker_id" id="seeker_id">
                         <?php foreach($res_seeker as $rows_seeker){ ?>
                           <option value="<?php echo $rows_seeker->id ?>"><?php echo $rows_seeker->seeker_info ?></option>
                        <?php }?>

                       </select>
                         <script>$('#seeker_id').val('<?php echo $rows->seeker_id; ?>');</script>
                    </div>
                 </div>
                  <div class="item form-group">
                     <label class="col-form-label col-md-3 col-sm-3 label-align">Grievance type name <span class="required">*</span>
                     </label>
                     <div class="col-md-6 col-sm-6 ">
                        <input id="grievance_name" class=" form-control" name="grievance_name" type="text" value="<?php echo $rows->grievance_name; ?>">
                        <input id="grievance_id" class=" form-control" name="grievance_id" type="hidden" value="<?php echo base64_encode($rows->id*98765); ?>">
                     </div>
                  </div>

                  <div class="item form-group">
                     <label class="col-form-label col-md-3 col-sm-3 label-align">status <span class="required">*</span>
                     </label>
                     <div class="col-md-6 col-sm-6 ">
                        <select class="form-control" name="status" id="status">
                          <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
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
$('#master_form').validate({ // initialize the plugin
     rules: {
         grievance_name:{required:true },

         status:{required:true }
     },
     messages: {
           grievance_name: { required:"enter the grievance type name",remote:"grievance type already exist"}

         }
 });
 </script>
