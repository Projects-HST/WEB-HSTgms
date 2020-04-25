<div  class="right_col" role="main">
   <div class="">
      <div class="col-md-12 col-sm-12 ">
         <div class="x_panel">
            <h2>List of constituent member</h2>
            <?php if($this->session->flashdata('msg')) {
               $message = $this->session->flashdata('msg');?>
            <div class="<?php echo $message['class'] ?> alert-dismissible">
               <button type="button" class="close" data-dismiss="alert">&times;</button>
               <strong> <?php echo $message['status']; ?>! </strong>  <?php echo $message['message']; ?>
            </div>
            <?php  }  ?>
            <table id="example" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
               <thead>
                  <tr>
                     <th>S.no</th>
                     <th>full name</th>
                     <th>paguthi</th>
                     <th>mobile</th>
                     <th>voter id</th>
                     <th>aadhhar id</th>
                     <th>serial no</th>
                     <th>Meeting</th>
                     <!-- <th>status</th> -->
                     <th>interaction</th>
                     <th>plant</th>

                     <th>Grievance</th>
                     <th>Action</th>
                  </tr>
               </thead>
               <tbody>
                  <?php $i=1; foreach($res as $rows){ ?>
                  <tr>
                     <td><?php echo $i; ?></td>
                     <td><?php echo $rows->full_name; ?></td>
                     <td><?php echo $rows->paguthi_name; ?></td>
                     <td><?php echo $rows->mobile_no ;?></td>
                     <td><?php echo $rows->voter_id_no ;?></td>
                     <td><?php echo $rows->aadhaar_no ;?></td>
                     <td><?php echo $rows->serial_no ;?></td>
                     <td><a  title="VIEW " class="badge badge-warning handle_symbol" onclick="view_meeting_request('<?php echo $rows->id; ?>')">Add/View</a></td>
                     <!-- <td><?php if($rows->status=='ACTIVE'){ ?>
                        <span class="badge badge-success">Active</span>
                        <?php  }else{ ?>
                        <span class="badge badge-danger">Inactive</span>
                        <?php   } ?>
                     </td> -->
                     <td><?php if($rows->interaction_status =='0'){ ?>
                       <a class="badge badge-warning" href="<?php echo base_url(); ?>constituent/add_interaction_response/<?php echo base64_encode($rows->id*98765); ?>" title="INTERACTION ADDED">ADD</i></a>
                        <?php }else{ ?>
                        <a href="<?php echo base_url(); ?>constituent/get_interaction_response_edit/<?php  echo base64_encode($rows->id*98765); ?>" title="VIEW " class="badge badge-success" >View</a>
                        <?php }?>
                     </td>
                     <td><?php if($rows->plant_status =='0'){ ?>
                        <a class="badge badge-warning handle_symbol" onclick="add_plant_donation('<?php echo $rows->id; ?>')" >ADD</i></a>
                        <?php }else{ ?>
                          <a  title="VIEW " class="badge badge-success handle_symbol" onclick="view_donation('<?php echo $rows->id; ?>')">View</a>

                        <?php }?>
                     </td>
                     <td><a  class="badge badge-warning handle_symbol" onclick="get_grievance_modal('<?php echo $rows->id; ?>')">Add grievance</a></td>
                     <td>
                       <a href="<?php echo base_url(); ?>constituent/get_constituent_member_edit/<?php echo base64_encode($rows->id*98765); ?>"><i class="fa fa-edit"></i></a>&nbsp;
                        <a href="<?php echo base_url(); ?>constituent/get_list_document/<?php echo base64_encode($rows->id*98765); ?>"><i class="fa fa-file-word-o"></i></a>&nbsp;


                     </td>
                  </tr>
                  <?php  $i++; } ?>
               </tbody>
            </table>
         </div>
      </div>
   </div>
</div>
<div class="modal fade bs-example-modal-lg" id="plant_model" tabindex="-1" role="dialog" aria-hidden="true">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel">Plant donation</h4>
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
            </button>
         </div>
         <div class="modal-body">
            <form class="form-label-left input_mask" action="<?php echo base_url(); ?>constituent/plant_save" method="post" id="plant_form">
              <div class="item form-group">
                 <label class="col-form-label col-md-3 col-sm-3 label-align">Plant name <span class="required">*</span>
                 </label>
                 <div class="col-md-6 col-sm-6 ">
                    <input id="name_of_plant" class=" form-control" name="name_of_plant" type="text" value="">
                 </div>
              </div>
              <div class="item form-group">
                 <label class="col-form-label col-md-3 col-sm-3 label-align">No.of.Plant<span class="required">*</span>
                 </label>
                 <div class="col-md-6 col-sm-6 ">
                    <input id="no_of_plant" class=" form-control" name="no_of_plant" type="text" value="">
                    <input id="constituent_id" class=" form-control" name="constituent_id" type="hidden" value="">
                 </div>
              </div>
               <div class="form-group row">
                  <div class="col-md-9 col-sm-9  offset-md-3">
                     <button type="submit" class="btn btn-success">Save</button>

                  </div>
               </div>
            </form>
         </div>

      </div>
   </div>
</div>

<div class="modal fade bs-example-modal-lg" id="meeting_model" tabindex="-1" role="dialog" aria-hidden="true">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel">Meeting request</h4>
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
            </button>
         </div>
         <div class="modal-body">
            <form class="form-label-left input_mask" action="<?php echo base_url(); ?>constituent/save_meeting_request" method="post" id="meeting_form">
              <div class="item form-group">
                 <label class="col-form-label col-md-3 col-sm-3 label-align">Meeting status <span class="required">*</span>
                 </label>
                 <div class="col-md-6 col-sm-9 ">
                    <input id="meeting_status" class=" form-control" name="meeting_status" type="text" value="REQUESTED" readonly>
                 </div>
              </div>
              <div class="item form-group">
                 <label class="col-form-label col-md-3 col-sm-3 label-align">Meeting details<span class="required">*</span>
                 </label>
                 <div class="col-md-9 col-sm-9 ">
                    <textarea id="meeting_detail" class=" form-control" name="meeting_detail" rows="5"></textarea>
                    <input id="meeting_constituent_id" class=" form-control" name="meeting_constituent_id" type="hidden" value="">
                 </div>
              </div>
               <div class="form-group row">
                  <div class="col-md-9 col-sm-9  offset-md-3">
                     <button type="submit" class="btn btn-success">Save</button>
                  </div>
               </div>
            </form>

            <table id="example" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
               <thead>
                  <tr>
                     <th style="width:600px !important;">Meeting details</th>
                     <th>status</th>
                     <th>updated at</th>
                     <th>Action</th>

                  </tr>
               </thead>
               <tbody id="table_meeting">


               </tbody>
            </table>



         </div>

      </div>
   </div>
</div>
<div class="modal fade bs-example-modal-lg" id="update_meeting_model" tabindex="-1" role="dialog" aria-hidden="true">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel">update Meeting request</h4>
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
            </button>
         </div>
         <div class="modal-body">
            <form class="form-label-left input_mask" action="<?php echo base_url(); ?>constituent/update_meeting_request" method="post" id="update_meeting_form">
              <div class="item form-group">
                 <label class="col-form-label col-md-3 col-sm-3 label-align">Meeting status <span class="required">*</span>
                 </label>
                 <div class="col-md-6 col-sm-9 ">
                    <input id="update_meeting_status" class=" form-control" name="update_meeting_status" type="text" value="REQUESTED" readonly>
                 </div>
              </div>
              <div class="item form-group">
                 <label class="col-form-label col-md-3 col-sm-3 label-align">Meeting details<span class="required">*</span>
                 </label>
                 <div class="col-md-9 col-sm-9 ">
                    <textarea id="update_meeting_detail" class=" form-control" name="update_meeting_detail" rows="5"></textarea>
                    <input id="meeting_id" class=" form-control" name="meeting_id" type="hidden" value="">
                 </div>
              </div>
               <div class="form-group row">
                  <div class="col-md-9 col-sm-9  offset-md-3">
                     <button type="submit" class="btn btn-success">Update</button>
                  </div>
               </div>
            </form>
       </div>
      </div>
   </div>
</div>

<div class="modal fade bs-example-modal-lg" id="grievance_model" tabindex="-1" role="dialog" aria-hidden="true">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel">Add Grievance</h4>
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
            </button>
         </div>
         <div class="modal-body">
            <form class="form-label-left input_mask" action="<?php echo base_url(); ?>constituent/save_grievance_data" method="post" enctype="multipart/form-data" id="grievance_form">
              <div class=" form-group row">

                 </label>
                 <div class="col-md-5 col-sm-6 ">
                   <p style="margin-top: 7px;">
                     Petition:&nbsp;
                     <input type="radio" class="flat" name="grievance_type" id="grievance_type_p" value="P" >&nbsp;&nbsp;&nbsp;&nbsp; Enquiry:&nbsp;
                     <input type="radio" class="flat" name="grievance_type" id="grievance_type_e" value="E" checked="" required="">
                  </p>
                 </div>
                 <label class="col-form-label col-md-3 col-sm-3 label-align">constituencyt<span class="required">*</span>
                 </label>
                 <div class="col-md-4 col-sm-6 ">
                   <select class="form-control" name="constituency_id" id="constituency_id">
                       <option value="">-SELECT--</option>
                     <?php foreach($res_constituency as $rows_constituency){ ?>

                    <?php } ?>
                     <option value="<?php echo $rows_constituency->id ?>"><?php echo $rows_constituency->constituency_name; ?></option>
                   </select>
                 </div>
              </div>

              <div class=" form-group row modal_row">
                <div class="col-md-4 col-sm-6 ">
                  <label>paguthi</label>
                  <select class="form-control" name="paguthi_id" id="paguthi_id" onchange="get_petition_no(this)">
                      <option value="">-SELECT--</option>
                    <?php foreach($res_paguthi as $rows_paguthi){ ?>
                       <option value="<?php echo $rows_paguthi->id; ?>"><?php echo $rows_paguthi->paguthi_name; ?></option>
                  <?php  } ?>

                  </select>
                </div>
                <div class="col-md-4 col-sm-6 ">
                  <label>Petition no</label>
                  <input type="text" name="petition_enquiry_no" id="petition_enquiry_no" class="form-control" readonly>
                    <input type="hidden" name="constituent_id" id="g_constituent_id" class="form-control" readonly>
                </div>
                <div class="col-md-4 col-sm-6 ">
                    <label>Date</label>
                    <input type="text" name="grievance_date" id="grievance_date" class="form-control" readonly value="<?php echo date('d-m-Y'); ?>">
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
                </div>
                <div class="col-md-4 col-sm-6 ">
                  <label>grievance type</label>
                  <select class="form-control" id="grievance_id" name="grievance_id" onchange="get_sub_category(this)">
                     <option value="">--select--</option>
                  </select>
                </div>
                <div class="col-md-4 col-sm-6 ">
                  <label>grievance sub category</label>
                  <select class="form-control" id="sub_category_id" name="sub_category_id">
                       <option value="">-SELECT--</option>
                  </select>
                </div>
              </div>

              <div class=" form-group row modal_row">
                <div class="col-md-4 col-sm-6 ">
                  <label>set reference</label>
                  <input type="text" name="reference_note" id="reference_note" class="form-control">
                </div>
                <div class="col-md-8 col-sm-6 enquiry_box">
                  <label>description</label>
                  <textarea class="form-control" name="description" id="description" ></textarea>

                </div>
              </div>
              <div class=" form-group row modal_row enquiry_box">
                <div class="col-md-4 col-sm-6 ">
                  <label>doc file name</label>
                  <input type="text" name="doc_name" id="doc_name" class="form-control">
                </div>
                <div class="col-md-4 col-sm-6 ">
                  <label>document</label>
                  <input type="file" name="doc_file_name" id="doc_file_name" class="form-control">
                </div>

              </div>
               <div class="form-group row">
                  <div class="col-md-12 col-sm-9">
                    <center> <button type="submit" class="btn btn-success">Save</button></center>

                  </div>
               </div>
            </form>
         </div>

      </div>
   </div>
</div>
<style>
   td{
   width:250px;
   }
   .modal_row{
     margin-bottom: 20px;
     margin-top: 20px;
   }
</style>
<script type="text/javascript">
function add_plant_donation(sel){
  $('#plant_model').modal('show');
  $('#constituent_id').val(sel);
  $('#name_of_plant').val("");
  $('#no_of_plant').val("");
}
  $('.enquiry_box').hide();
$('input[name=grievance_type]').click(function(){
  if(this.value == 'P'){
    $('#petition_enquiry_no').val("");
    $('.enquiry_box').show();
  }else{
    $('#petition_enquiry_no').val("");
    $('.enquiry_box').hide();
  }
});


function get_grievance_modal(sel){
    $('#g_constituent_id').val("");
  $('#grievance_model').modal('show');
  $('#g_constituent_id').val(sel);
}

function get_petition_no(sel){
  var gr_type=$('input[name="grievance_type"]:checked').val();
  var p_id=sel.value;
  $.ajax({
    url:'<?php echo base_url(); ?>constituent/get_petition_no',
    method:"POST",
    data:{p_id:p_id,gr_type:gr_type},
    dataType: "JSON",
    cache: false,
    success:function(data)
    {
          $('#petition_enquiry_no').val("");
          var stat=data.status;
      if(stat=="success"){
          $('#petition_enquiry_no').val(data.petition_code);
      }else{
        $('#petition_enquiry_no').empty();
      }
    }
  });

}
function view_meeting_request(sel){
  var c_id=sel;
    $('#meeting_constituent_id').val(c_id);
  $.ajax({
    url:'<?php echo base_url(); ?>constituent/view_meeting_request',
    method:"POST",
    data:{c_id:c_id},
    dataType: "JSON",
    cache: false,
    success:function(data)
    {
      $('#meeting_model').modal('show');
      var stat=data.status;
       $("#table_meeting").empty();
      if(stat=="success"){
      var res=data.res;
      var len=res.length;
      for (i = 0; i < len; i++) {
        // $('#constituent_id').val(res[i].constituent_id);
        $('#table_meeting').append('<tr><td>'+res[i].meeting_detail+'</td><td>'+res[i].meeting_status+'</td><td>'+res[i].updated_at+'</td><td><a class="handle_symbol" onclick="edit_meeting_request('+res[i].id+')"><i class="fa fa-edit"></i></a></td></tr>');
     }
      }else{
        $('#table_meeting').append('<tr><td colspan="4">No data</td></tr>');
      }
    }
  });
}

function edit_meeting_request(sel){
var m_id=sel;
  $('#meeting_model').modal('hide');

  $.ajax({
    url:'<?php echo base_url(); ?>constituent/edit_meeting_request',
    method:"POST",
    data:{m_id:m_id},
    dataType: "JSON",
    cache: false,
    success:function(data)
    {
    ;
      var stat=data.status;
      if(stat=="success"){
      $('#update_meeting_model').modal('show');
      var res=data.res;
      var len=res.length;
      for (i = 0; i < len; i++) {
        $('#meeting_id').val(res[i].id);
        $('#update_meeting_detail').text(res[i].meeting_detail);
        $('#update_meeting_status').val(res[i].meeting_status);

     }
      }else{
      // $("#booth_address").empty();
      }
    }
  });

}
function view_donation(sel){
  var c_id=sel;
  $.ajax({
    url:'<?php echo base_url(); ?>constituent/get_plant_donation',
    method:"POST",
    data:{c_id:c_id},
    dataType: "JSON",
    cache: false,
    success:function(data)
    {
      var stat=data.status;
      if(stat=="success"){
      $('#plant_model').modal('show');
      var res=data.res;
      var len=res.length;
      for (i = 0; i < len; i++) {
        $('#name_of_plant').val(res[i].name_of_plant);
        $('#no_of_plant').val(res[i].no_of_plant);
        $('#constituent_id').val(res[i].constituent_id);
     }
      }else{
      $("#booth_address").empty();
      }
    }
  });
}

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
   $('#constiituent_menu').addClass('active');
   $('.constiituent_menu').css('display','block');
   $('#list_constituent_menu').addClass('active');
   $('#plant_form').validate({
        rules: {
              name_of_plant:{required:true ,maxlength:80},
              no_of_plant:{required:true,digits:true }
        },
        messages: {
          name_of_plant:{required:"enter the name of plant " },
          no_of_plant:{required:"enter the number" }
            }
    });
    $('#meeting_form').validate({
         rules: {
               meeting_detail:{required:true ,maxlength:200}

         },
         messages: {
           meeting_detail:{required:"enter the meeting detail " }

             }
     });
     $('#grievance_form').validate({
          rules: {
                constituent_id:{required:true},
                paguthi_id:{required:true},
                constituency_id:{required:true},
                seeker_id:{required:true},
                grievance_id:{required:true},
                doc_name:{required:true},
                doc_file_name:{required:true},
                petition_enquiry_no:{required:true},
                sub_category_id:{required:true},
                sub_category_id:{required:true}
          },
          messages: {
            constituency_id:{required:"select constituency"},
            paguthi_id:{required:"select paguthi"},
            seeker_id:{required:"select seeker"},
            grievance_id:{required:"select grievance"},
            doc_name:{required:"enter the document name"},
            doc_file_name:{required:"select file"},
            sub_category_id:{required:"select sub_category"}
              }
      });

</script>
