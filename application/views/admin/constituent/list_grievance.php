<div  class="right_col" role="main">
   <div class="">
      <div class="col-md-12 col-sm-12 ">
         <div class="x_panel">
            <div class="x_panel">
               <div class="x_title">
                  <h2><i class="fa fa-file-word-o"></i> list of grievance</h2>
                  <div class="clearfix"></div>
               </div>
               <div class="x_content">
                  <ul class="nav nav-tabs bar_tabs" id="myTab" role="tablist">
                     <li class="nav-item">
                        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">All</a>
                     </li>
                     <li class="nav-item">
                        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Petition</a>
                     </li>
                     <li class="nav-item">
                        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#enquiry_tab" role="tab" aria-controls="profile" aria-selected="false">Enquiry</a>
                     </li>

                  </ul>
                  <div class="tab-content" id="myTabContent">
                     <div class="tab-pane fade active show" id="home" role="tabpanel" aria-labelledby="home-tab">

                        <div class="x_panel">
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
                                    <th>Full name</th>
                                    <th>paguthi</th>
                                    <th>seeker</th>
                                    <!-- <th>category</th> -->
                                    <th>sub category</th>
                                    <th>petition no</th>
                                    <th>reference</th>
                                    <th>status</th>
                                    <th>updated at</th>
                                    <th style="width:100px !important;">Action</th>
                                 </tr>
                              </thead>
                              <tbody>
                                <?php $i=1; foreach($res as $rows){ ?>
                                  <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $rows->full_name; ?></td>
                                    <td><?php echo $rows->paguthi_name; ?></td>
                                    <td><?php echo $rows->seeker_info; ?></td>
                                    <!-- <td><?php echo $rows->grievance_name; ?></td> -->
                                    <td><?php echo $rows->sub_category_name; ?></td>
                                    <td><?php echo $rows->petition_enquiry_no; ?></td>
                                    <td><?php if(empty($rows->reference_note)){ ?>
                                      <a class="badge badge-info handle_symbol" onclick="get_set_reference('<?php echo $rows->id; ?>')">Set reference</a>
                                   <?php }else{ ?>
                                     <a class="badge badge-warning handle_symbol" onclick="get_set_reference('<?php echo $rows->id; ?>')"><?php echo $rows->reference_note; ?></a>
                                   <?php } ?></td>
                                    <td><?php $status= $rows->status;
                                        if($status=='COMPLETED'){ ?>
                                          <a class="badge badge-success handle_symbol" onclick="change_grievance_status('<?php echo $rows->id; ?>')">COMPLETED</a>
                                      <?php  }else if($status=='ONHOLD'){ ?>
                                        <a class="badge badge-danger handle_symbol" onclick="change_grievance_status('<?php echo $rows->id; ?>')">ONHOLD</a>
                                        <?php }else{ ?>
                                          <a class="badge badge-warning handle_symbol" onclick="change_grievance_status('<?php echo $rows->id; ?>')">PROCESSING</a>
                                        <?php  }
                                     ?></td>
                                    <td><?php echo $rows->updated_at; ?></td>
                                    <td>
                                      <a title="REPLY" class="handle_symbol" onclick="send_reply_constituent('<?php echo $rows->id; ?>')"><i class="fa fa-reply" aria-hidden="true"></i></a>
                                      &nbsp;

                                      <a title="EDIT" href="<?php echo base_url(); ?>constituent/get_constituent_grievance_edit/<?php echo base64_encode($rows->id*98765); ?>"><i class="fa fa-edit"></i></a>&nbsp;
                                      &nbsp;

                                      <a title="INFO" target="_blank" href="<?php echo base_url(); ?>constituent/constituent_profile_info/<?php echo base64_encode($rows->constituent_id*98765); ?>"><i class="fa fa-eye"></i></a>&nbsp;

                                     </td>
                                    </tr>
                              <?php $i++; } ?>

                              </tbody>
                           </table>
                        </div>
                     </div>
                     <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                       <div class="x_panel">
                          <table id="example_2" class="table table-striped table-bordered dt-responsive nowrap display" style="width:100%">
                             <thead style="width:100% !important;">
                                <tr>
                                  <th>S.no</th>
                                  <th>Full name</th>
                                  <th>paguthi</th>
                                  <th>seeker</th>
                                  <!-- <th>category</th> -->
                                  <th>sub category</th>
                                  <th>petition no</th>
                                  <th>reference</th>
                                  <th>status</th>
                                  <th>updated at</th>
                                  <th>Action</th>
                                </tr>
                             </thead>
                             <tbody>
                               <?php $i=1; foreach($res_petition as $rows_petition){ ?>
                                 <tr>
                                   <td><?php echo $i; ?></td>
                                   <td><?php echo $rows_petition->full_name; ?></td>
                                   <td><?php echo $rows_petition->paguthi_name; ?></td>
                                   <td><?php echo $rows_petition->seeker_info; ?></td>
                                   <!-- <td><?php echo $rows_petition->grievance_name; ?></td> -->
                                   <td><?php echo $rows_petition->sub_category_name; ?></td>
                                   <td><?php echo $rows_petition->petition_enquiry_no; ?></td>
                                   <td><?php if(empty($rows_petition->reference_note)){ ?>
                                     <a class="badge badge-info handle_symbol" onclick="get_set_reference('<?php echo $rows_petition->id; ?>')">Set reference</a>
                                  <?php }else{ ?>
                                    <a class="badge badge-warning handle_symbol" onclick="get_set_reference('<?php echo $rows_petition->id; ?>')"><?php echo $rows_petition->reference_note; ?></a>
                                  <?php } ?></td>
                                  <td><?php $status= $rows_petition->status;
                                      if($status=='COMPLETED'){ ?>
                                        <a class="badge badge-success handle_symbol" onclick="change_grievance_status('<?php echo $rows_petition->id; ?>')">COMPLETED</a>
                                    <?php  }else if($status=='ONHOLD'){ ?>
                                      <a class="badge badge-danger handle_symbol" onclick="change_grievance_status('<?php echo $rows_petition->id; ?>')">ONHOLD</a>
                                      <?php }else{ ?>
                                        <a class="badge badge-warning handle_symbol" onclick="change_grievance_status('<?php echo $rows_petition->id; ?>')">PROCESSING</a>
                                      <?php  }
                                   ?></td>
                                   <td><?php echo $rows_petition->updated_at; ?></td>
                                   <td>
                                     <a title="REPLY" class="handle_symbol" onclick="send_reply_constituent('<?php echo $rows_petition->id; ?>')"><i class="fa fa-reply" aria-hidden="true"></i></a>
                                     &nbsp;

                                     <a title="EDIT" href="<?php echo base_url(); ?>constituent/get_constituent_grievance_edit/<?php echo base64_encode($rows_petition->id*98765); ?>"><i class="fa fa-edit"></i></a>&nbsp;
                                     &nbsp;

                                     <a title="INFO" target="_blank" href="<?php echo base_url(); ?>constituent/constituent_profile_info/<?php echo base64_encode($rows_petition->constituent_id*98765); ?>"><i class="fa fa-eye"></i></a>&nbsp;

                                    </td>
                                   </tr>
                             <?php $i++; } ?>
                             </tbody>
                          </table>
                       </div>

                     </div>
                     <div class="tab-pane fade" id="enquiry_tab" role="tabpanel" aria-labelledby="enquiry-tab">
                       <div class="x_panel">
                          <table id="example_3" class="table table-striped table-bordered dt-responsive nowrap display" style="width:100%">
                             <thead>
                                <tr>
                                  <th>S.no</th>
                                  <th>Full name</th>
                                  <th>paguthi</th>
                                  <th>seeker</th>
                                  <!-- <th>category</th> -->
                                  <th>sub category</th>
                                  <th>petition no</th>
                                  <th>reference</th>
                                  <th>status</th>
                                  <th>updated at</th>
                                  <th>Action</th>
                                </tr>
                             </thead>
                             <tbody>
                               <?php $i=1; foreach($res_enquiry as $rows_enquiry){ ?>
                                 <tr>
                                   <td><?php echo $i; ?></td>
                                   <td><?php echo $rows_enquiry->full_name; ?></td>
                                   <td><?php echo $rows_enquiry->paguthi_name; ?></td>
                                   <td><?php echo $rows_enquiry->seeker_info; ?></td>
                                   <!-- <td><?php echo $rows_enquiry->grievance_name; ?></td> -->
                                   <td><?php echo $rows_enquiry->sub_category_name; ?></td>
                                   <td><?php echo $rows_enquiry->petition_enquiry_no; ?></td>
                                   <td><?php if(empty($rows_enquiry->reference_note)){ ?>
                                     <a class="badge badge-info handle_symbol" onclick="get_set_reference('<?php echo $rows_enquiry->id; ?>')">Set reference</a>
                                  <?php }else{ ?>
                                    <a class="badge badge-warning handle_symbol" onclick="get_set_reference('<?php echo $rows_enquiry->id; ?>')"><?php echo $rows_enquiry->reference_note; ?></a>
                                  <?php } ?></td>
                                  <td><?php $status= $rows_enquiry->status;
                                      if($status=='COMPLETED'){ ?>
                                        <a class="badge badge-success handle_symbol" onclick="change_grievance_status('<?php echo $rows_enquiry->id; ?>')">COMPLETED</a>
                                    <?php  }else if($status=='ONHOLD'){ ?>
                                      <a class="badge badge-danger handle_symbol" onclick="change_grievance_status('<?php echo $rows_enquiry->id; ?>')">ONHOLD</a>
                                      <?php }else{ ?>
                                        <a class="badge badge-warning handle_symbol" onclick="change_grievance_status('<?php echo $rows_enquiry->id; ?>')">PROCESSING</a>
                                      <?php  }
                                   ?></td>
                                   <td><?php echo $rows_enquiry->updated_at; ?></td>
                                   <td>
                                     <a title="REPLY" class="handle_symbol" onclick="send_reply_constituent('<?php echo $rows_enquiry->id; ?>')"><i class="fa fa-reply" aria-hidden="true"></i></a>
                                     &nbsp;

                                     <a title="EDIT" href="<?php echo base_url(); ?>constituent/get_constituent_grievance_edit/<?php echo base64_encode($rows_enquiry->id*98765); ?>"><i class="fa fa-edit"></i></a>&nbsp;
                                     &nbsp;

                                     <a title="INFO" target="_blank" href="<?php echo base_url(); ?>constituent/constituent_profile_info/<?php echo base64_encode($rows_enquiry->constituent_id*98765); ?>"><i class="fa fa-eye"></i></a>&nbsp;

                                    </td>
                                   </tr>
                             <?php $i++; } ?>

                             </tbody>
                          </table>
                       </div>

                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<div class="modal fade bs-example-modal-lg" id="reference_modal" tabindex="-1" role="dialog" aria-hidden="true">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel">update reference</h4>
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
            </button>
         </div>
         <div class="modal-body">
            <form class="form-label-left input_mask" action="<?php echo base_url(); ?>constituent/update_refernce_note" method="post" id="update_referecnce_form">


              <div class="item form-group">
                 <label class="col-form-label col-md-3 col-sm-3 label-align">set reference<span class="required">*</span>
                 </label>
                 <div class="col-md-6 col-sm-9 ">
                    <input id="reference_note" class=" form-control" name="reference_note">
                    <input id="reference_grievance_id" class=" form-control" name="reference_grievance_id" type="hidden" value="">

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

<div class="modal fade bs-example-modal-lg" id="status_modal" tabindex="-1" role="dialog" aria-hidden="true">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel">update Grievance status</h4>
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
            </button>
         </div>
         <div class="modal-body">
            <form class="form-label-left input_mask" action="<?php echo base_url(); ?>constituent/update_grievance_status" method="post" id="update_meeting_form">
              <div class="item form-group">
                 <label class="col-form-label col-md-3 col-sm-3 label-align">status <span class="required">*</span>
                 </label>
                 <div class="col-md-6 col-sm-9 ">
                   <select class="form-control" id="status" name="status">
                        <option value="PROCESSING">PROCESSING</option>
                        <!-- <option value="ONHOLD">ONHOLD</option> -->
                        <option value="COMPLETED">COMPLETED</option>
                   </select>

                 </div>
              </div>
              <div class="item form-group">
                 <label class="col-form-label col-md-3 col-sm-3 label-align">SMS type <span class="required">*</span>
                 </label>
                 <div class="col-md-6 col-sm-9 ">
                   <select class="form-control" id="sms_id" name="sms_id" onchange="get_sms_text(this)">
                     <option value="">--Sms template--</option>
                     <?php foreach($res_sms as $rows_sms){ ?>
                       <option value="<?php echo $rows_sms->id; ?>"><?php echo $rows_sms->sms_title; ?></option>
                     <?php } ?>
                   </select>
                 </div>
              </div>
              <div class="item form-group">
                 <label class="col-form-label col-md-3 col-sm-3 label-align">SMS text<span class="required">*</span>
                 </label>
                 <div class="col-md-9 col-sm-9 ">
                    <textarea id="sms_text" class=" form-control" name="sms_text" rows="5"></textarea>
                    <input id="grievance_id" class=" form-control" name="grievance_id" type="hidden" value="">
                    <input id="constituent_grievance_id" class=" form-control" name="constituent_grievance_id" type="hidden" value="">
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

<div class="modal fade bs-example-modal-lg" id="reply_modal" tabindex="-1" role="dialog" aria-hidden="true">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel">Send reply message</h4>
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
            </button>
         </div>
         <div class="modal-body">
            <form class="form-label-left input_mask" action="<?php echo base_url(); ?>constituent/reply_grievance_text" method="post" id="reply_form">

              <div class="item form-group">
                 <label class="col-form-label col-md-3 col-sm-3 label-align">SMS type <span class="required">*</span>
                 </label>
                 <div class="col-md-6 col-sm-9 ">
                   <select class="form-control" id="reply_sms_id" name="reply_sms_id" onchange="get_sms_text(this)">
                     <option value="">--Sms template--</option>
                     <?php foreach($res_sms as $rows_sms){ ?>
                       <option value="<?php echo $rows_sms->id; ?>"><?php echo $rows_sms->sms_title; ?></option>
                     <?php } ?>
                   </select>
                 </div>
              </div>
              <div class="item form-group">
                 <label class="col-form-label col-md-3 col-sm-3 label-align">SMS text<span class="required">*</span>
                 </label>
                 <div class="col-md-9 col-sm-9 ">
                    <textarea id="reply_sms_text" class=" form-control" name="reply_sms_text" rows="5"></textarea>
                    <input id="reply_grievance_id" class=" form-control" name="reply_grievance_id" type="hidden" value="">
                    <input id="constituent_reply_id" class=" form-control" name="constituent_reply_id" type="hidden" value="">
                 </div>
              </div>
               <div class="form-group row">
                  <div class="col-md-9 col-sm-9  offset-md-3">
                     <button type="submit" class="btn btn-success">send</button>
                  </div>
               </div>
            </form>
       </div>
      </div>
   </div>
</div>

<style>

</style>
<script>
$(document).ready(function () {
    $('#example_2').DataTable({
      "scrollX": true,
        responsive: true,
        language: {
          "search": "",
          searchPlaceholder: "SEARCH HERE"
        }
    });
    $('#example_3').DataTable({
      "scrollX": true,
        responsive: true,
        "language": {
          "search": "",
          searchPlaceholder: "SEARCH HERE"
        }
    });

    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        $($.fn.dataTable.tables(true)).DataTable()
           .columns.adjust()
           .responsive.recalc();
    });
});

   $('#grievance_menu').addClass('active');
   $('.grievance_menu').css('display','none');
   $('#list_grievance_menu').addClass('active');
   $('#update_meeting_form').validate({
        rules: {
            sms_id:{required:true },
            sms_text:{required:true,maxlength:240 }
        },
        messages: {
          sms_id:{required:"select title" },
          sms_text:{required:"enter the sms text" }
        },
        submitHandler: function(form) {
               if (confirm('Are you sure want to update.?')) {
                   form.submit();
               }
      }
    });

    $('#update_referecnce_form').validate({
         rules: {
             reference_note:{required:true,maxlength:50 }
         },
         messages: {
             reference_note:{required:"enter the reference text" }
         },
         submitHandler: function(form) {
                if (confirm('Are you sure want to update.?')) {
                    form.submit();
                }
       }
     });

     $('#reply_form').validate({
       rules: {
           reply_sms_id:{required:true },
           reply_sms_text:{required:true,maxlength:240 }
       },
       messages: {
         reply_sms_id:{required:"select title" },
         reply_sms_text:{required:"enter the sms text" }
       },
       submitHandler: function(form) {
              if (confirm('Are you sure want to update.?')) {
                  form.submit();
              }
     }
      });


function change_grievance_status(sel){
  var grievance_id=sel;
    $('#status_modal').modal('show');

  $.ajax({
    url:'<?php echo base_url(); ?>constituent/get_grievance_status',
    method:"POST",
    data:{grievance_id:grievance_id},
    dataType: "JSON",
    cache: false,
    success:function(data)
    {
      var stat=data.status;
      $('#status').val("");
      $('#grievance_id').val("");
      $('#constituent_grievance_id').val(" ");
      if(stat=="success"){
      $('#status_modal').modal('show');
      var res=data.res;
      var len=res.length;
      for (i = 0; i < len; i++) {
        $('#status').val(res[i].status);
        $('#grievance_id').val(res[i].id);
        $('#constituent_grievance_id').val(res[i].constituent_id);


     }
      }else{

      }
    }
  });
}

function get_sms_text(sel){
  let sms_id=sel.value;
  $.ajax({
    url:'<?php echo base_url(); ?>constituent/get_sms_text',
    method:"POST",
    data:{sms_id:sms_id},
    dataType: "JSON",
    cache: false,
    success:function(data)
    {
      var stat=data.status;
      if(stat=="success"){
      var res=data.res;
      var len=res.length;
      for (i = 0; i < len; i++) {
        $('#sms_text').text(res[i].sms_text);
        $('#reply_sms_text').text(res[i].sms_text);
     }
      }else{
        $('#sms_text').empty();
        $('#reply_sms_text').empty();
      }
    }
  });
}


function get_set_reference(sel){
  let grievance_id=sel;
  $.ajax({
    url:'<?php echo base_url(); ?>constituent/get_grievance_status',
    method:"POST",
    data:{grievance_id:grievance_id},
    dataType: "JSON",
    cache: false,
    success:function(data)
    {
      var stat=data.status;
      if(stat=="success"){
          $('#reference_modal').modal('show');
      var res=data.res;
      var len=res.length;
      for (i = 0; i < len; i++) {
        $('#reference_note').val(res[i].reference_note);
        $('#reference_grievance_id').val(res[i].id);
     }
      }else{
        $('#reference_note').empty();
      }
    }
  });

}
function send_reply_constituent(sel){

  let grievance_id=sel;
   $('#reply_form')[0].reset();
  $.ajax({
    url:'<?php echo base_url(); ?>constituent/get_grievance_status',
    method:"POST",
    data:{grievance_id:grievance_id},
    dataType: "JSON",
    cache: false,
    success:function(data)
    {
      $('#reply_grievance_id').val(" ");
      $('#constituent_reply_id').val(" ");

      var stat=data.status;
      if(stat=="success"){
      $('#reply_modal').modal('show');
      var res=data.res;
      var len=res.length;
      for (i = 0; i < len; i++) {
        $('#reply_grievance_id').val(res[i].id);
        $('#constituent_reply_id').val(res[i].constituent_id);
     }
      }else{
        $('#reply_grievance_id').val(" ");
        $('#constituent_reply_id').val(" ");
      }
    }
  });
}

</script>
