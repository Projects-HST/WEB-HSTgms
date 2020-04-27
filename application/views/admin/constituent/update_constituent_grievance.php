<div  class="right_col" role="main" style="height:100vh;">
   <div class="">
      <div class="col-md-12 col-sm-12 ">
        <div class="x_panel">
           <div class="x_title">
             <?php foreach($res_grievance as $con_row){ } ?>
              <h2><i class="fa fa-file-word-o"></i> Update <?php if($con_row->grievance_type=='P'){ echo "Petition"; }else{ echo "ENQUIRY"; } ?></h2>
              <div class="clearfix"></div>
           </div>

           <form class="form-label-left input_mask" action="<?php echo base_url(); ?>constituent/update_grievance_data" method="post" enctype="multipart/form-data" id="grievance_form">
               <div class=" form-group row modal_row">

               <div class="col-md-4 col-sm-6 ">
                 <label>Petition no</label>
                 <input type="text" name="petition_enquiry_no" id="petition_enquiry_no" class="form-control" readonly value="<?php echo $con_row->petition_enquiry_no; ?>">

               </div>
               <div class="col-md-4 col-sm-6 ">
                   <label>Date</label>

                   <input type="text" name="grievance_date" id="grievance_date" class="form-control" readonly value="<?php echo $con_row->grievance_date; ?>">
               </div>
               <div class="col-md-4 col-sm-6 ">
                 <label>set reference</label>
                 <input type="text" name="reference_note" id="reference_note" class="form-control" value="<?php echo $con_row->reference_note; ?>">
                 <input type="hidden" name="grievance_tb_id" id="grievance_tb_id" class="form-control" value="<?php echo base64_encode($con_row->id*98765); ?>">

               </div>
             </div>

             <div class=" form-group row modal_row">
               <div class="col-md-4 col-sm-6 ">
                 <label>seeker type</label>
                 <select class="form-control" id="seeker_id" name="seeker_id" onchange="get_grievance(this)">
                   <option value="">-SELECT--</option>
                   <?php foreach($res_seeker as $rows_seeker){ ?>
                      <option value="<?php echo $rows_seeker->id; ?>"><?php echo $rows_seeker->seeker_info; ?></option>
                 <?php  } ?>

                 </select>
               <script>$('#seeker_id').val('<?php echo $con_row->seeker_type_id; ?>');</script>
               </div>
               <div class="col-md-4 col-sm-6 ">
                 <label>grievance type</label>
                 <select class="form-control" id="grievance_id" name="grievance_id" onchange="get_sub_category(this)">
                   <?php $query="SELECT * FROM grievance_type WHERE status='ACTIVE' and seeker_id='$con_row->seeker_type_id' order by id desc";
                   $result=$this->db->query($query);
                   if($result->num_rows()==0){ ?>
                   <option value=""></option>
                   <?php 	}else{
                   $res_gr=$result->result();
                   foreach($res_gr as $rows_gri){ ?>
                     <option value="<?php echo $rows_gri->id; ?>"><?php echo $rows_gri->grievance_name; ?></option>
                   <?php   }		}    ?>
                 </select>
                 <script>$('#grievance_id').val('<?php echo $con_row->grievance_type_id; ?>');</script>
               </div>
               <div class="col-md-4 col-sm-6 ">
                 <label>grievance sub category</label>
                 <select class="form-control" id="sub_category_id" name="sub_category_id">
                   <?php $query_sub="SELECT * FROM grievance_sub_category WHERE status='ACTIVE' and grievance_id='$con_row->grievance_type_id' order by id desc";
                   $result_sub=$this->db->query($query_sub);
                   if($result_sub->num_rows()==0){ ?>
                   <option value=""></option>
                   <?php 	}else{
                   $res_sub=$result_sub->result();
                   foreach($res_sub as $rows_sub){ ?>
                     <option value="<?php echo $rows_sub->id; ?>"><?php echo $rows_sub->sub_category_name; ?></option>
                   <?php   }		}    ?>
                 </select>
                  <script>$('#sub_category_id').val('<?php echo $con_row->sub_category_id; ?>');</script>
               </div>
             </div>

             <div class=" form-group row modal_row">

               <div class="col-md-8 col-sm-6 enquiry_box">
                 <label>description</label>
                 <textarea class="form-control" name="description" id="description" rows="5" ><?php echo $con_row->description; ?></textarea>

               </div>
             </div>

              <div class="form-group row">
                 <div class="col-md-12 col-sm-9">
                   <center> <button type="submit" class="btn btn-success">Update</button></center>

                 </div>
              </div>
           </form>

         </div>

      </div>
      </div>
      </div>
<script>
$('#grievance_menu').addClass('active');
$('.grievance_menu').css('display','block');
$('#list_grievance_menu').addClass('active');
function get_grievance(sel){
var seeker_id=sel.value;
$.ajax({
  url:'<?php echo base_url(); ?>masters/get_grievance_active',
  method:"POST",
  data:{seeker_id:seeker_id},
  dataType: "JSON",
  cache: false,
  success:function(data)
  {
    var stat=data.status;
    if(stat=="success"){
        $("#grievance_id").empty();
    var res=data.res;
    var len=res.length;
       $('#grievance_id').html('<option value="">-SELECT --</option>');
    for (i = 0; i < len; i++) {
    $('<option>').val(res[i].id).text(res[i].grievance_name).appendTo('#grievance_id');
   }
    }else{
    $("#grievance_id").empty();
    $("#sub_category_id").empty();
    }
  }
});
}

function get_sub_category(sel){
  var grievance_id=sel.value;
  $.ajax({
    url:'<?php echo base_url(); ?>masters/get_active_sub_category',
    method:"POST",
    data:{grievance_id:grievance_id},
    dataType: "JSON",
    cache: false,
    success:function(data)
    {
      var stat=data.status;
      if(stat=="success"){
          $("#sub_category_id").empty();
      var res=data.res;
      var len=res.length;
       $('#sub_category_id').html('<option value="">-SELECT  --</option>');
      for (i = 0; i < len; i++) {
      $('<option>').val(res[i].id).text(res[i].sub_category_name).appendTo('#sub_category_id');
     }
      }else{
      $("#sub_category_id").empty();
      }
    }
  });
}
$('#grievance_form').validate({
     rules: {

           seeker_id:{required:true},
           grievance_id:{required:true},
           petition_enquiry_no:{required:true},
           sub_category_id:{required:true}
     },
     messages: {
       seeker_id:{required:"select seeker"},
       grievance_id:{required:"select grievance"},
       sub_category_id:{required:"select sub_category"}
         }
 });
</script>
