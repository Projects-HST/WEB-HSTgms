<div  class="right_col" role="main">
   <div class="">
   <div class="clearfix"></div>
	<div class="row">
      <div class="col-md-12 col-sm-12 ">
         <div class="x_panel">
            <div class="x_title">
               <h2>update office</h2>

               <div class="clearfix"></div>
            </div>
            <div class="x_content">

              <?php foreach($res as $rows){} ?>
               <form id="master_form" action="<?php echo base_url(); ?>masters/update_office" method="post" enctype="multipart/form-data">
                  <div class="item form-group">
                     <label class="col-form-label col-md-3 col-sm-3">Office  <span class="required">*</span>
                     </label>
                     <div class="col-md-4 col-sm-6 ">
                        <input id="constituency_name" class=" form-control" name="office_name" type="text" value="<?= $rows->office_name; ?>">
                        <input id="office_id" class=" form-control" name="office_id" type="hidden" value="<?= base64_encode($rows->id*98765); ?>">
                        <input id="paguthi_id" class=" form-control" name="paguthi_id" type="hidden" value="<?= base64_encode($rows->paguthi_id*98765); ?>">
                     </div>
                  </div>
                  <div class="item form-group">
                     <label class="col-form-label col-md-3 col-sm-3">Office short form <span class="required">*</span>
                     </label>
                     <div class="col-md-4 col-sm-6 ">
                        <input id="paguthi_short_name" class=" form-control" name="office_short_form" type="text" value="<?= $rows->office_short_form; ?>">
                     </div>
                  </div>
                  <div class="item form-group">
                     <label class="col-form-label col-md-3 col-sm-3">status <span class="required">*</span>
                     </label>
                     <div class="col-md-4 col-sm-6 ">
                        <select class="form-control" name="status" id="status">
                          <option value="ACTIVE">ACTIVE</option>
                          <option value="INACTIVE">INACTIVE</option>
                        </select>
                        <script>$('#status').val('<?= $rows->status; ?>');</script>
                     </div>
                  </div>
                  <div class="ln_solid"></div>
                  <div class="item form-group">
                     <div class="col-md-4 col-sm-6 offset-md-3">
                        <button type="submit" class="btn btn-success" style="background-color:<?php echo $this->session->userdata('base_colour');?>;color:#000000;border:1px solid <?php echo $this->session->userdata('base_colour');?>;">Update</button>
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
$('#paguthimenu').addClass('active');
$('#master_form').validate({
     rules: {
         office_name:{required:true,maxlength:40,
           remote: {
                     url: "<?php echo base_url(); ?>masters/checkofficeexist/<?= $rows->id ?>",
                     type: "post"
                  }
             },
         office_short_form:{required:true,maxlength:4,
           remote: {
                     url: "<?php echo base_url(); ?>masters/checkofficeshortnameexist/<?= $rows->id ?>",
                     type: "post"
                  }
                 },
         status:{required:true }
     },
     messages: {
           office_name: { required:"enter the office name",remote:"office name already exist"},
           office_short_form: { required:"enter the office short form",remote:"office short form already exist"}
         }
 });
 </script>
