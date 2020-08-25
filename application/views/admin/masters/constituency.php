<div  class="right_col" role="main">
   <div class="">
      <div class="col-md-12 col-sm-12 ">
         <div class="x_panel">
            <div class="x_title">
               <h2>Update Constituency</h2>

               <div class="clearfix"></div>
            </div>
            <div class="x_content">
             <?php if($this->session->flashdata('msg')) {
               $message = $this->session->flashdata('msg');?>
               <div class="<?php echo $message['class'] ?> alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert">&times;</button>
                  <strong> <?php echo $message['status']; ?>! </strong>  <?php echo $message['message']; ?>
              </div>
             <?php  }  ?>

               <form id="master_form" action="<?php echo base_url(); ?>masters/update_constituency" method="post" enctype="multipart/form-data">
                  <div class="item form-group">
                     <label class="col-form-label col-md-3 col-sm-3 ">Constituency name <span class="required">*</span>
                     </label>
                     <?php foreach($res as $rows){} ?>
                     <div class="col-md-4 col-sm-6 ">
                        <input id="constituency_name" class="date-picker form-control" name="constituency_name" type="text" value="<?php echo $rows->constituency_name; ?>">
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
$('#constituencymenu').addClass('active');
$('#master_form').validate({
     rules: {
         constituency_name:{required:true,maxlength:80 }
     },
     messages: {

         }
 });
 </script>
