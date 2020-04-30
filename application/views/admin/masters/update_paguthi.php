<div  class="right_col" role="main">
   <div class="">
      <div class="col-md-12 col-sm-12 ">
         <div class="x_panel">
            <div class="x_title">
               <h2>Update Paguthi</h2>

               <div class="clearfix"></div>
            </div>
            <div class="x_content">
              <?php foreach($res as $rows){} ?>

               <form id="master_form" action="<?php echo base_url(); ?>masters/update_paguthi" method="post" enctype="multipart/form-data">
                  <div class="item form-group">
                     <label class="col-form-label col-md-3 col-sm-3 label-align">Paguthi name <span class="required">*</span>
                     </label>
                     <div class="col-md-6 col-sm-6 ">
                        <input id="constituency_name" class=" form-control" name="paguthi_name" type="text" value="<?php echo $rows->paguthi_name; ?>">
                        <input id="paguthi_id" class=" form-control" name="paguthi_id" type="hidden" value="<?php echo $rows->id; ?>">
                     </div>
                  </div>
                  <div class="item form-group">
                     <label class="col-form-label col-md-3 col-sm-3 label-align">Paguthi short name <span class="required">*</span>
                     </label>
                     <div class="col-md-6 col-sm-6 ">
                        <input id="paguthi_short_name" class=" form-control" name="paguthi_short_name" type="text" value="<?php echo $rows->paguthi_short_name; ?>">
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
$('#paguthimenu').addClass('active');
$('#master_form').validate({
     rules: {
         paguthi_name:{required:true,maxlength:80
           remote: {
                     url: "<?php echo base_url(); ?>masters/checkpaguthiexist/<?php echo $rows->id; ?>",
                     type: "post"
                  }
             },
         paguthi_short_name:{required:true,maxlength:5,
           remote: {
                     url: "<?php echo base_url(); ?>masters/checkpaguthishortexist/<?php echo $rows->id; ?>",
                     type: "post"
                  }
                 },
         status:{required:true }
     },
     messages: {
       paguthi_name: { required:"enter the paguthi name",remote:"paguthi name already exist"},
       paguthi_short_name: { required:"enter the paguthi short name",remote:"paguthi short name already exist"}
         }
 });
 </script>
