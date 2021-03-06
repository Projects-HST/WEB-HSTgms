<style type="text/css">
.pagination-first-tag{
	border:1px solid #eeeeee;
	padding:10px;
	background:#31aa15;
}
 
.pagination-last-tag{
	border:1px solid #eeeeee;
	padding:10px;
	background:#31aa15;
	
}
.pagination-next-tag{
	padding:10px;
	border:1px solid #eeeeee;
	background:#31aa15;
}
 
.pagination-prev-tag{
	padding:10px;
	border:1px solid #eeeeee;
	background:#31aa15;
	
}
 
.pagination-current-tag{
	color:#000000;
	font-weight:bold;
	padding:10px;
	border:1px solid #eeeeee;
}
 
.pagination-number{
	padding:10px;
	border:1px solid #eeeeee;
}
 
.pagination-first-tag a, .pagination-next-tag a, .pagination-last-tag a, .pagination-prev-tag a{
	color:#ffffff;
	
}
	</style>
<div  class="right_col" role="main">
   <div class="">
   
   <form id="search_form" action="<?php echo base_url(); ?>dashboard/searchresult" method="post" enctype="multipart/form-data">
		<div class="title_left" style="padding-top:70px;">
			<div class="col-md-12 col-sm-12 form-group pull-right top_search">
			<div class="input-group">
				<input type="text" class="form-control" name="keyword" id="keyword" placeholder="Search for..." value="">
				<span class="input-group-btn">
					<button class="btn btn-default" type="submit" style="padding:12px;">Go!</button>
				</span>
			</div>
			</div>
		</div>
		</form>

		
		<hr>
		
      <div class="col-md-12 col-sm-12 ">
         <div class="x_panel">
            <div class="x_title">
               <h2>List of constituent member</h2>
               <div class="clearfix"></div>
            </div>
            <div class="x_content">
			
			<div class="col-md-12 col-sm-12" style="padding:0px;">
				  <div class="col-md-3 col-sm-3"></div>
				  <div class="col-md-3 col-sm-3"></div>
				  <div class="col-md-6 col-sm-6" style="padding:0px;"><?= $pagination; ?></div>
			</div>
				
			<div class="col-md-12 col-sm-12">
			<table id="" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
			<tr>
				<th>S.no</th>
                     <th>full name</th>
                     <th>mobile</th>
                     <th>Meeting</th>
                     <th>interaction</th>
                     <th>plant</th>
                     <th>Grievance</th>
                     <th>Action</th>
			</tr>
			<?php 
			$sno = $row+1;
			foreach($result as $data){
				$const_id = $data['id'];
				$paguthi_id = $data['paguthi_id'];
				
				$intQuery = "SELECT * FROM interaction_history WHERE constituent_id = '$const_id'";
				$intQuery_result = $this->db->query($intQuery);
				if($intQuery_result->num_rows()>0){
					$int_status = "Y";
				}else{
					$int_status = "N";
				}
				
				$pltQuery = "SELECT * FROM plant_donation WHERE constituent_id = '$const_id'";
				$pltQuery_result = $this->db->query($pltQuery);
				if($pltQuery_result->num_rows()>0){
					$plt_status = "Y";
				}else{
					$plt_status = "N";
				}

				
				echo "<tr>";
				echo "<td>".$sno."</td>";
				echo "<td>".$data['full_name']."</td>";
				echo "<td>".$data['mobile_no']."</td>";
				echo '<td><a title="VIEW " class="badge badge-add handle_symbol" onclick="view_meeting_request('.$const_id.')">Add/View</a></td>';
				if ($int_status == "Y"){
					echo '<td><a class="badge badge-view" href="'.base_url().'constituent/get_interaction_response_edit/'. base64_encode($const_id*98765).'" title="INTERACTION VIEW">VIEW</i></a></td>';
				} else {
					echo '<td><a class="badge badge-add" href="'.base_url().'constituent/add_interaction_response/'. base64_encode($const_id*98765).'" title="INTERACTION ADD">ADD</i></a></td>';
				}
				if ($plt_status == "Y"){
					echo '<td><a class="badge badge-view handle_symbol" onclick="view_donation('.$const_id.')">VIEW</i></a></td>';
				} else {
					echo '<td><a class="badge badge-add handle_symbol" onclick="add_plant_donation('.$const_id.')">ADD</i></a></td>';
				}
				echo '<td><a  class="badge badge-add handle_symbol" onclick="get_grievance_modal('.$const_id.')">Add grievance</a></td>';
				echo '<td>	<a id="EDIT" href="'. base_url().'constituent/get_constituent_member_edit/'.base64_encode($const_id*98765).'"><i class="fa fa-edit"></i></a>&nbsp;
							<a title="DOCUMENTS" href="'.base_url().'constituent/get_list_document/'.base64_encode($const_id*98765).'"><i class="fa fa-file-word-o"></i></a>&nbsp;
							<a title="INFO" target="_blank" href="'.base_url().'constituent/constituent_profile_info/'.base64_encode($const_id*98765).'"><i class="fa fa-eye"></i></a>&nbsp;
							<a title="SEND VOICE CALL" onclick="give_voice_call('.$const_id.')" class="handle_symbol"><i class="fa fa-phone"></i></a></td>';
				echo "</tr>";
				$sno++;
			}
			?>
		</table>
		</div>
	
		<div class="col-md-12 col-sm-12" style="padding:0px;">
			  <div class="col-md-3 col-sm-3"></div>
			  <div class="col-md-3 col-sm-3"></div>
			  <div class="col-md-6 col-sm-6" style="padding:0px;"><?= $pagination; ?></div>
		</div>
	<!-- Paginate -->
	

        
            </div>
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
                 <label class="col-form-label col-md-3 col-sm-3 label-align">Meeting Title <span class="required">*</span>
                 </label>
                 <div class="col-md-6 col-sm-9 ">
                    <input id="meeting_title" class=" form-control" name="meeting_title" type="text">
                 </div>
              </div>
              <div class="item form-group">
                 <label class="col-form-label col-md-3 col-sm-3 label-align">Meeting date <span class="required">*</span>
                 </label>
                 <div class="col-md-6 col-sm-9 ">
                    <input id="meeting_date" class=" form-control" name="meeting_date" type="text">
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
            <table id="" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
               <thead>
                  <tr>
                    <th>title</th>
                     <th style="width:600px !important;">Meeting details</th>
                     <th>date</th>
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
                 <label class="col-form-label col-md-3 col-sm-3 label-align">Meeting title <span class="required">*</span>
                 </label>
                 <div class="col-md-6 col-sm-9 ">
                    <input id="update_meeting_title" class=" form-control" name="update_meeting_title" type="text">
                 </div>
              </div>
              <div class="item form-group">
                 <label class="col-form-label col-md-3 col-sm-3 label-align">Meeting date <span class="required">*</span>
                 </label>
                 <div class="col-md-6 col-sm-9 ">
                    <input id="update_meeting_date" class=" form-control" name="update_meeting_date" type="text">
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
                  <label>paguthi   <span class="required">*</span></label>
                  <select class="form-control" name="paguthi_id" id="paguthi_id" onchange="get_petition_no(this)">
                      <option value="">-SELECT--</option>
                    <?php foreach($res_paguthi as $rows_paguthi){ ?>
                       <option value="<?php echo $rows_paguthi->id; ?>"><?php echo $rows_paguthi->paguthi_name; ?></option>
                  <?php  } ?>

                  </select>
                </div>
                <div class="col-md-4 col-sm-6 ">
                  <label>Petition no  <span class="required">*</span></label>
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
                  <label>seeker type  <span class="required">*</span></label>
                  <select class="form-control" id="seeker_id" name="seeker_id" onchange="get_grievance(this)">
                    <option value="">-SELECT--</option>
                    <?php foreach($res_seeker as $rows_seeker){ ?>
                       <option value="<?php echo $rows_seeker->id; ?>"><?php echo $rows_seeker->seeker_info; ?></option>
                  <?php  } ?>

                  </select>
                </div>
                <div class="col-md-4 col-sm-6 ">
                  <label>grievance type  <span class="required">*</span></label>
                  <select class="form-control" id="grievance_id" name="grievance_id" onchange="get_sub_category(this)">
                     <option value="">--select--</option>
                  </select>
                </div>
                <div class="col-md-4 col-sm-6 ">
                  <label>grievance sub category  <span class="required">*</span></label>
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

<script type="text/javascript">

$('#meeting_date').datetimepicker({
      format: 'DD-MM-YYYY',
      minDate: new Date()
});

$('#update_meeting_date').datetimepicker({
      format: 'DD-MM-YYYY',
        minDate: new Date()
});

function add_plant_donation(sel){
  $('#plant_model').modal('show');
  $('#constituent_id').val(sel);
  $('#name_of_plant').val("");
  $('#no_of_plant').val("");
}

function view_donation(sel){
  var c_id=sel;
  alert (c_id);
  alert ("aa");
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
        $('#table_meeting').append('<tr><td>'+res[i].meeting_title+'</td><td>'+res[i].meeting_detail+'</td><td>'+res[i].disp_date+'</td><td>'+res[i].meeting_status+'</td><td>'+res[i].disp_updated_date+'</td><td><a class="handle_symbol" onclick="edit_meeting_request('+res[i].id+')"><i class="fa fa-edit"></i></a></td></tr>');
     }
      }else{
        $('#table_meeting').append('<tr><td colspan="6">No data</td></tr>');
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
        $('#update_meeting_title').val(res[i].meeting_title);
        $('#update_meeting_detail').text(res[i].meeting_detail);
        $('#update_meeting_status').val(res[i].meeting_status);
        $('#update_meeting_date').val(res[i].disp_date);

     }
      }else{
      // $("#booth_address").empty();
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


function give_voice_call(sel){
  let cons_id=sel;
  $.ajax({
    url:'<?php echo base_url(); ?>constituent/give_voice_call',
    method:"POST",
    data:{cons_id:cons_id},
    dataType: "JSON",
    cache: false,
    success:function(data)
    {
      alert(data.status)
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
                meeting_date:{required:true},
               meeting_detail:{required:true ,maxlength:200}

         },
         messages: {
             meeting_date:{required:"enter the date"},
           meeting_detail:{required:"enter the meeting detail " }

             }
     });
     $('#update_meeting_form').validate({
          rules: {
                 update_meeting_date:{required:true},
                update_meeting_detail:{required:true ,maxlength:200}

          },
          messages: {
              update_meeting_date:{required:"enter the date"},
            update_meeting_detail:{required:"enter the meeting detail " }

              }
      });

      $.validator.addMethod('filesize', function (value, element,param) {
        var size=element.files[0].size;
        size=size/1024;
        size=Math.round(size);
        return this.optional(element) || size <=param ;
      }, 'File size must be less than 1 MB');
      
     $('#grievance_form').validate({
          rules: {
                constituent_id:{required:true},
                paguthi_id:{required:true},
                constituency_id:{required:true},
                seeker_id:{required:true},
                grievance_id:{required:true},
                doc_name:{required:true},
                doc_file_name:{required:true,extension:'jpe?g,png,doc,docx,pdf', filesize: 1000 },
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

      $('body').append('<div style="" id="loadingDiv"><div class="loader">Loading...</div></div>');
$(window).on('load', function(){
  setTimeout(removeLoader, 2000); //wait for page load PLUS two seconds.
});
function removeLoader(){
    $( "#loadingDiv" ).fadeOut(500, function() {
      // fadeOut complete. Remove the loading div
      $( "#loadingDiv" ).remove(); //makes page more lightweight
  });
}
</script>
