<style>
th{
    width:200px;
}

</style>
<div  class="right_col" role="main">
   <div class="">
      <div class="col-md-12 col-sm-12 ">
         <div class="x_panel">
            <div class="x_title">
               <h2>Meeting Based Report</h2>

               <div class="clearfix"></div>
            </div>
            <div class="x_content">
			<?php if($this->session->flashdata('msg')): ?>
		<div class="alert alert-success alert-dismissible " role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
		</button>
		<?php echo $this->session->flashdata('msg'); ?>
		</div>
	<?php endif; ?>
		<form id="report_form" action="<?php echo base_url(); ?>report/meetings" method="post" enctype="multipart/form-data">
      <div class="form-group row ">
        <label class="col-form-label col-md-1 col-sm-1 ">From </label>
        <div class="col-md-2 col-sm-2">
           <input type="text" class="form-control" placeholder="From Date" id="frmDate" name="m_frmDate" value="<?php echo $m_frmDate; ?>">
        </div>
        <label class="col-form-label col-md-1 col-sm-1 ">To </label>
      <div class="col-md-2 col-sm-2">
       <input type="text" class="form-control" placeholder="To Date" id="toDate" name="m_toDate" value="<?php echo $m_toDate; ?>">
      </div>
      <label class="col-form-label col-md-1 col-sm-1 ">Status <span class="required">*</span></label>
    <div class="col-md-2 col-sm-2">
      <select class="form-control" name="m_status" id ="status" >
        <option value="">ALL</option>
        <option value="REQUESTED">REQUESTED</option>
        <option value="PENDING">PENDING</option>
        <option value="COMPLETED">COMPLETED</option>
        <option value="REJECTED">REJECTED</option>
        <option value="SCHEDULED">SCHEDULED</option>
      </select><script> $('#status').val('<?php echo $m_status; ?>');</script>
    </div>
      </div>
      <div class="form-group row ">
           <label class="control-label col-md-1 col-sm-3 ">Office<span class="required">*</span></label>
           <div class="col-md-2 col-sm-9 ">
           <select class="form-control" name="m_paguthi" id ="paguthi" onchange="get_paguthi(this);">
             <option value="">ALL</option>
             <?php foreach($paguthi as $rows){ ?>
             <option value="<?php echo $rows->id;?>"><?php echo $rows->paguthi_name;?></option>
             <?php } ?>
           </select><script> $('#paguthi').val('<?php echo $m_paguthi; ?>');</script>
         </div>
         <label class="col-form-label col-md-1 col-sm-3">Ward</label>
        <div class="col-md-2 col-sm-2">
           <select class="form-control" name="m_ward_id" id ="ward_id" >
             <option value=""></option>
           </select>
        </div>
        <div class="col-md-2 col-sm-2">
          <input type="submit" name="submit" class="btn btn-success" value="SEARCH">
          <a  href="<?php echo base_url(); ?>report/reset_search" class="btn btn-danger">Reset</a>
        </div>

       </div>
			  <div class="ln_solid"></div>
		</form>

		<div class="col-md-12 col-sm-12 ">
      <div class="col-md-12 col-sm-12" style="padding:0px;">
         <div class="col-md-3 col-sm-3">
            <h2>Search Result</h2>
            Total records <?php echo $allcount; ?>
         </div>
         <div class="col-md-3 col-sm-3"></div>
         <div class="col-md-6 col-sm-6" style="padding:0px;"><?= $pagination; ?></div>
      </div>
          <table id="" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
             <thead>
                <tr>
                  <th>S.no</th>
                  <th>Date</th>
                  <th>Name</th>
                  <th>Phone</th>
                  <th>Details</th>
                  <th>Status</th>
                  <th>Created by</th>
                  <th>Created at</th>
                </tr>
             </thead>
             <tbody>
               <?php $i = $row+1; foreach($result as $rows){ ?>
                 <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php echo date('d-m-Y', strtotime($rows['meeting_date'])); ?></td>
                    <td><?php echo $rows['full_name']; ?></td>
                    <td><?php echo $rows['mobile_no']; ?></td>
                    <td><?php echo $rows['meeting_detail']; ?></td>

                    <?php
                    $meeting_status = $rows['meeting_status'];
                    if ($meeting_status == 'REQUESTED'){ ?>
                    <td style="font-size:13px;font-weight:bold;color:#ee0606;"><?php  echo $meeting_status; ?></td>
                    <!--<td><a href="<?php echo base_url(); ?>report/meeting_update/<?php echo base64_encode($rows['id']*98765); ?>/<?php echo $dfromDate;?>/<?php echo $dtoDate;?>" onclick="return confirm('ARE YOU SURE YOU WANT TO UPDATE?');" style="font-size:13px;font-weight:bold;color:#ee0606;"><?php  echo $rows['meeting_status']; ?></a></td>-->
                    <?php } else { ?>
                    <td style="font-size:13px;font-weight:bold;color:#1fae03;"><?php  echo $meeting_status; ?></td>
                    <?php } ?>

                    <td><?php  echo $rows['created_by']; ?></td>
                    <td><?php  echo  date("d-m-Y", strtotime($rows['created_at']) ); ?></td>
                 </tr>
            <?php $i++; } ?>
             </tbody>
          </table>
          <div class="col-md-12 col-sm-12" style="padding:0px;">
             <div class="col-md-3 col-sm-3">

             </div>
             <div class="col-md-3 col-sm-3"></div>
             <div class="col-md-6 col-sm-6" style="padding:0px;"><?= $pagination; ?></div>
          </div>
        </div>
            </div>
         </div>
      </div>



   </div>
</div>

<script type="text/javascript">
$('#reportmenu').addClass('active');
$('.reportmenu').css('display','block');
function get_paguthi(sel){
  var paguthi_id=sel.value;
  $.ajax({
		url:'<?php echo base_url(); ?>masters/get_active_ward',
		method:"POST",
		data:{paguthi_id:paguthi_id},
		dataType: "JSON",
		cache: false,
		success:function(data)
		{
		   var stat=data.status;
		   $("#ward_id").empty();

		   if(stat=="success"){
		   var res=data.res;
		   var len=res.length;
        $('#ward_id').html('<option value="">-SELECT ward --</option>');
		   for (i = 0; i < len; i++) {
		   $('<option>').val(res[i].id).text(res[i].ward_name).appendTo('#ward_id');
		   }

		   }else{
		   $("#ward_id").empty();

		   }
		}
	});
}
$.validator.addMethod("chkDates", function(value, element) {
		var startDate = $('#frmDate').val();
		var datearray = startDate.split("-");
		var frm_date = datearray[1] + '/' + datearray[0] + '/' + datearray[2];

		var endDate = $('#toDate').val();
		var datearray = endDate.split("-");
		var to_date = datearray[1] + '/' + datearray[0] + '/' + datearray[2];

		return Date.parse(frm_date) <= Date.parse(to_date) || value == "";
	}, "Fom date cannot be greater than To date");

$('#frmDate').datetimepicker({
        format: 'DD-MM-YYYY'
});

$('#toDate').datetimepicker({
        format: 'DD-MM-YYYY'
});

$('#report_form').validate({ // initialize the plugin
     rules: {

             m_frmDate:{ required: function(element){
                return $("#toDate").val().length > 0; }},
            m_toDate:{ required: function(element){
               return $("#frmDate").val().length > 0; },chkDates: "#frmDate"},
     },
     messages: {
           m_frmDate: { required:"Select From Date"},
           m_toDate: { required:"Select To Date"}
         }
 });
 </script>
