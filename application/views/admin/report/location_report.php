<style type="text/css">
th{
  width:50px;
  }</style>
  <div  class="right_col" role="main">
   <div class="">
      <div class="col-md-12 col-sm-12 ">
         <div class="x_panel">
            <div class="x_title">
               <h2>Location Based Report</h2>

               <div class="clearfix"></div>
            </div>
            <div class="x_content">

		<form id="report_form" action="<?php echo base_url(); ?>report/location" method="post" enctype="multipart/form-data">

          <div class="form-group row ">
            <label class="col-form-label col-md-1 col-sm-1 ">From </label>
            <div class="col-md-2 col-sm-2">
               <input type="text" class="form-control" placeholder="From Date" id="frmDate" name="l_frmDate" value="<?php echo $l_frmDate; ?>">
            </div>
            <label class="col-form-label col-md-1 col-sm-1 ">To</label>
          <div class="col-md-2 col-sm-2">
           <input type="text" class="form-control" placeholder="To Date" id="toDate" name="l_toDate" value="<?php echo $l_toDate; ?>">
          </div>
          </div>
        <div class="form-group row ">
             <label class="control-label col-md-1 col-sm-3 ">paguthi<span class="required">*</span></label>
             <div class="col-md-2 col-sm-9 ">
             <select class="form-control" name="l_paguthi" id ="paguthi" onchange="get_paguthi(this);">
               <option value="">ALL</option>
               <?php foreach($paguthi as $rows){ ?>
               <option value="<?php echo $rows->id;?>"><?php echo $rows->paguthi_name;?></option>
               <?php } ?>
             </select><script> $('#paguthi').val('<?php echo $l_paguthi; ?>');</script>
           </div>
           <label class="col-form-label col-md-1 col-sm-3">Ward</label>
          <div class="col-md-2 col-sm-2">
             <select class="form-control" name="l_ward_id" id ="ward_id" >
               <option value=""></option>
             </select>
          </div>
          <div class="col-md-3 col-sm-2">
            <input type="submit" name="submit" class="btn btn-success" value="SEARCH">
            <a  href="<?php echo base_url(); ?>report/reset_search" class="btn btn-danger">clear</a>
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
                    <th>Petition No</th>
                    <th>Date</th>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Category</th>
                    <th>Status</th>
                    <th>Created by</th>

                </tr>
             </thead>
             <tbody>
               <?php $i = $row+1; foreach($result as $rows){ ?>
                 <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php echo $rows['petition_enquiry_no']; ?></td>
                    <td><?php echo date('d-m-Y', strtotime($rows['created_at'])); ?></td>
                    <td><?php echo $rows['full_name']; ?></td>
                    <td><?php echo $rows['mobile_no']; ?></td>
                    <td><?php echo $rows['grievance_name']; ?></td>
                    <td class="badge-<?= $rows['status'] ?>"><?php  echo $rows['status']; ?></td>
                    <td><?php  echo $rows['created_by']; ?></td>
                 </tr>
                 <?php $i++; } ?>
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
        $('#ward_id').html('<option value="">ALL</option>');
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

      l_frmDate:{ required: function(element){
         return $("#toDate").val().length > 0; }},
     l_toDate:{ required: function(element){
        return $("#frmDate").val().length > 0; },chkDates: "#frmDate"},
        paguthi:{required:true }
  },
     messages: {
           l_frmDate: { required:"Select From Date"},
           l_toDate: { required:"Select To Date"},
		   paguthi: { required:"Select Location"}
         }
 });
 </script>
