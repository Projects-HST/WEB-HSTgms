<style type="text/css">
th{
	width:200px;
}

	</style>
  <div  class="right_col" role="main">
   <div class="">
      <div class="col-md-12 col-sm-12 ">
         <div class="x_panel">
            <div class="x_title">
               <h2>Meeting Requests</h2>

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
		<form id="report_form" action="<?php echo base_url(); ?>constituent/meetings" method="post" enctype="multipart/form-data">
			  <div class="item form-group">
				 <label class="col-form-label col-md-1 col-sm-1 label-align">From </label>
				 <div class="col-md-2 col-sm-2">
						<input type="text" class="form-control" placeholder="From Date" id="frmDate" name="mr_frmDate" value="<?php echo $mr_frmDate; ?>">
				 </div>
				  <label class="col-form-label col-md-1 col-sm-1 label-align">To </label>
				 <div class="col-md-2 col-sm-2">
					<input type="text" class="form-control" placeholder="To Date" id="toDate" name="mr_toDate" value="<?php echo $mr_toDate; ?>">
				 </div>
         <div class="col-md-3 col-sm-4">
            <input class="form-control" id="search" name="mr_search" type="text" placeholder="Search Full name " value="<?php echo $mr_search; ?>" />
          </div>
				 <div class="col-md-3 col-sm-2">
					 <input type="submit" name="submit" class="btn btn-success" value="Search">
					 <a href="<?php echo base_url(). "report/reset_search"; ?>" class="btn btn-danger">Clear All</a>
				 </div>


			  </div>
			  <div class="ln_solid"></div>
		</form>

		<div class="col-md-12 col-sm-12 ">
			<div class="col-md-12 col-sm-12" style="padding:0px;">
				 <div class="col-md-3 col-sm-3"></div>
				 <div class="col-md-3 col-sm-3"></div>
				 <div class="col-md-6 col-sm-6" style="padding:0px;"><?= $pagination; ?></div>
		 </div>
          <table id="" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
             <thead>
                <tr>
                   <th>S.no</th>

                   <th>Name</th>
                   <th>Date</th>
				   		 		<th>Phone</th>
				    			<th>Details</th>
				   				<th>Status</th>
                  <th>Created by</th>
									<th>Requested on</th>
                </tr>
             </thead>
             <tbody>
               <?php $i=$row+1;
			   foreach($result as $rows){
					$meeting_status = $rows['meeting_status'];?>
                 <tr>
                    <td><?php echo $i; ?></td>
                      <td><?php echo $rows['full_name']; ?></td>
					           <td><?php if(empty($rows['meeting_date'])){
                     }else{
                       echo date('d-m-Y', strtotime($rows['meeting_date']));
                     }
                      ?></td>
					<td><?php echo $rows['mobile_no']; ?></td>
					<td><?php echo $rows['meeting_detail']; ?></td>
					<!-- <td><a href="<?php echo base_url(); ?>constituent/meeting_update/<?php echo base64_encode($rows['id']*98765); ?>/<?php echo $dfromDate;?>/<?php echo $dtoDate;?>" onclick="return confirm('ARE YOU SURE YOU WANT TO UPDATE?');" style="font-size:13px;font-weight:bold;color:#ee0606;"><?php  echo $rows->meeting_status; ?></a></td> -->
          <td><a href="#" onclick="meeting_status_update('<?php echo base64_encode($rows['id']*98765); ?>','<?php echo $meeting_status; ?>','<?php echo $rows['constituent_id']; ?>')" style="font-size:13px;font-weight:bold;color:#ee0606;"><?php  echo $rows['meeting_status']; ?></a></td>
					 <td><?php  echo $rows['created_by']; ?></td>
					 <td><?php  echo $rows['created_at']; ?></td>
                 </tr>
				<?php  $i++; } ?>
             </tbody>
          </table>
          <div class="col-md-12 col-sm-12" style="padding:0px;">
             <div class="col-md-3 col-sm-3"></div>
             <div class="col-md-3 col-sm-3"></div>
             <div class="col-md-6 col-sm-6" style="padding:0px;"><?= $pagination; ?></div>
         </div>
        </div>
            </div>
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
            <form class="form-label-left input_mask" action="<?php echo base_url(); ?>constituent/save_meeting_request_status" method="post" id="meeting_form">
              <div class="item form-group">
                 <label class="col-form-label col-md-3 col-sm-3 label-align">Meeting status <span class="required">*</span>
                 </label>
                 <div class="col-md-6 col-sm-9 ">

                    <select class="form-control" name="meeting_status" id="meeting_status">
                      <option value="REQUESTED">REQUESTED</option>
                      <option value="PENDING">PENDING</option>
                      <option value="COMPLETED">COMPLETED</option>
                      <option value="REJECTED">REJECTED</option>
                      <option value="SCHEDULED">SCHEDULED</option>
                    </select>
                 </div>

              </div>
              <div class="item form-group">
                 <label class="col-form-label col-md-3 col-sm-3 label-align">Send SMS
                 </label>
                 <div class="col-md-6 col-sm-9 ">
                   <input type="hidden" class="form-control"  id="meeting_id" name="meeting_id">
                   <input type="hidden" class="form-control"  id="constituent_id" name="constituent_id">
                  <input type="checkbox" class="form-control" style="width:15px;" id="send_checkbox" name="send_checkbox" value="1">
                 </div>

              </div>

							<div class="item form-group meet_date">
                 <label class="col-form-label col-md-3 col-sm-3 label-align">Meeting Date<span class="required">*</span>
                 </label>
                 <div class="col-md-6 col-sm-9 ">
									 <input type="text" class="form-control"  id="meeting_date" name="meeting_date">
                 </div>
              </div>

              <div class="item form-group show_sms">
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
              <div class="item form-group show_sms">
                 <label class="col-form-label col-md-3 col-sm-3 label-align">SMS text<span class="required">*</span>
                 </label>
                 <div class="col-md-9 col-sm-9 ">
                    <textarea id="reply_sms_text" class=" form-control" name="reply_sms_text" rows="5"></textarea>

                    <input id="constituent_reply_id" class=" form-control" name="constituent_reply_id" type="hidden" value="">
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
<script type="text/javascript">
$('#meeting_date').datetimepicker({
      format: 'DD-MM-YYYY',
      minDate: new Date()
});
$('#frmDate').datetimepicker({
        format: 'DD-MM-YYYY'
});

$('#toDate').datetimepicker({
        format: 'DD-MM-YYYY'
});
$('#send_checkbox').change(function () {
      $('.show_sms').fadeToggle();
    });
$('#report_form').validate({ // initialize the plugin
     rules: {
         frmDate:{required:true},
         toDate:{required:true}
     },
     messages: {
           frmDate: { required:"Select From Date"},
           toDate: { required:"Select To Date"}
         }
 });
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
function meeting_status_update(meeting_id,m_status,cons_id){
  $('#meeting_model').modal('show');
  $('#meeting_status').val(m_status);
  $('#meeting_id').val(meeting_id);
  $('#constituent_id').val(cons_id);
}
$('#constiituent_menu').addClass('active');
$('.constiituent_menu').css('display','block');
$('#constituent_meetings').addClass('active current-page');
$('.show_sms').hide();



$('#meeting_status').change(function(){
    var stats=$(this).val();
		if(stats=='SCHEDULED'){
			$('.meet_date').show();
		}else{
			$('.meet_date').hide();
		}
});
$('.meet_date').hide();
$('#meeting_form').validate({
		 rules: {
						meeting_date:{required:true},
						reply_sms_id:{required:true},
					 reply_sms_text:{required:true ,maxlength:240}

		 },
		 messages: {
				 meeting_date:{required:"enter the date"},
				 reply_sms_id:{required:"select the title"},
			 reply_sms_text:{required:"enter the meeting detail " }

				 }
 });

 </script>
