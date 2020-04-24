
<div  class="right_col" role="main">
   <div class="">

        <div class="x_panel" class="interaction_div">
           <div class="x_title interaction_div" >
              <h2>Interaction information</h2>
              <div class="clearfix"></div>
           </div>
           <form class="form-horizontal form-label-left" action="<?php echo base_url(); ?>constituent/save_interaction_response" method="post" enctype="multipart/form-data" id="master_form">
           <div class="x_content">
             <div class="form-group row interaction_div">
               <?php  foreach($res_interaction as $rows_question){ ?>
                 <label class="control-label col-md-4 col-sm-3 mb_20"><?php echo $rows_question->interaction_text; ?></label>
                 <div class="col-md-2 col-sm-9 mb_20">
                   <input type="hidden" name="question_id[]" value="<?php echo $rows_question->id; ?>">
                   <input type="hidden" name="constituent_id" value="<?php echo $this->uri->segment(3); ?>">
                   <select class="form-control" name="question_response[]" id="">
                     <option value="Y">YES</option>
                     <option value="N">NO</option>
                   </select>
                 </div>
               <?php    } ?>


              </div>

             <div class="form-group">
                <div class="col-md-9 col-sm-9  ">
                   <center><button type="submit" class="btn btn-success">Save</button></center>
                </div>
             </div>
           </div>
         </form>
        </div>




   </div>
</div>
<style>
.mb_20{
  margin-bottom: 20px;
}
</style>
<script>
$('#constiituent_menu').addClass('active');
$('.constiituent_menu').css('display','block');
$('#list_constituent_menu').addClass('active');
$('#master_form').validate({
     rules: {
         file_name:{required:true },
         doc_file:{required:true }
     },
     messages: {
       file_name:{required:"enter the file name" },
       doc_file:{required:"select file" }
         }
 });


</script>
