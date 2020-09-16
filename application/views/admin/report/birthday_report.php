<div  class="right_col" role="main">
   <div class="">
   <div class="clearfix"></div>
	<div class="row">
      <div class="col-md-12 col-sm-12 ">
         <div class="x_panel">
            <div class="x_title">
               <h2>Birthday wishes Report</h2>
               <a href="<?php echo base_url(); ?>report/get_birthday_report_export" class="btn btn-export pull-right">Export</a>
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

		<form id="report_form" action="<?php echo base_url(); ?>report/birthday" method="post" enctype="multipart/form-data">

        <div class="form-group row ">
          <label class="col-form-label col-md-2 col-sm-2 ">From Year <span class="required">*</span></label>
           <div class="col-md-2 col-sm-2">
            <select id="bf_year_id" name="bf_year_id" class="form-control">
              <option value="">SELECT YEAR</option>
              <?php foreach($res_year as $row_year){ ?>
                <option value="<?= $row_year->year_name; ?>"><?= $row_year->year_name; ?></option>
            <?php  } ?>
            </select>
              <script>$('#bf_year_id').val('<?php echo $bf_year_id; ?>')</script>
           </div>

          <label class="col-form-label col-md-2 col-sm-2 ">To Year <span class="required">*</span></label>
           <div class="col-md-2 col-sm-2">
            <select id="year_id" name="b_year_id" class="form-control">
              <option value="">SELECT YEAR</option>
              <?php foreach($res_year as $row_year){ ?>
                <option value="<?= $row_year->year_name; ?>"><?= $row_year->year_name; ?></option>
            <?php  } ?>
            </select>
              <script>$('#year_id').val('<?php echo $b_year_id; ?>')</script>
           </div>
          <label class="col-form-label col-md-2 col-sm-2 ">Select Month <span class="required">*</span></label>
           <div class="col-md-2 col-sm-2">
            <select id="month" name="b_month" class="form-control">
              <option value="">SELECT MONTH</option>
              <option value="1">January</option>
              <option value="2">February</option>
              <option value="3">March</option>
              <option value="4">April</option>
              <option value="5">May</option>
              <option value="6">June</option>
              <option value="7">July</option>
              <option value="8">August</option>
              <option value="9">September</option>
              <option value="10">October</option>
              <option value="11">November</option>
              <option value="12">December</option>
            </select>

              <script> $('#month').val('<?php echo $b_month; ?>');</script>


           </div>
        </div>
        <div class="form-group row ">
             <label class="control-label col-md-2 col-sm-3 ">paguthi<span class="required">*</span></label>
             <div class="col-md-2 col-sm-9 ">
             <select class="form-control" name="b_paguthi" id ="paguthi" onchange="get_paguthi(this);">
               <option value="">ALL</option>
               <?php foreach($paguthi as $rows){ ?>
               <option value="<?php echo $rows->id;?>"><?php echo $rows->paguthi_name;?></option>
               <?php } ?>
             </select>

               <script> $('#paguthi').val('<?php echo $b_paguthi; ?>');</script>



           </div>
           <label class="col-form-label col-md-2 col-sm-3 ">Office</label>
          <div class="col-md-2 col-sm-2">
             <select class="form-control" name="b_ward_id" id ="office_id" >
               <option value="">ALL</option>
               <?php foreach($res_office as $rows_office){ ?>
                  <option value="<?php echo $rows_office->id ?>"><?php echo $rows_office->office_name; ?></option>
              <?php } ?>
             </select>
              <script> $('#office_id').val('<?php echo $b_ward_id; ?>');</script>
          </div>
          <div class="col-md-4 col-sm-2">
            <input type="submit" name="submit" class="btn btn-success" value="SEARCH">
            <a  href="<?php echo base_url(); ?>report/reset_search" class="btn btn-danger">clear</a>

          </div>

         </div>
			  <div class="ln_solid"></div>
		</form>

		<div class="col-md-12 col-sm-12 ">
      <div class="col-md-12 col-sm-12" style="padding:0px;">
         <div class="col-md-3 col-sm-3">
            <p style="margin-top:20px;">Total records : <?php echo $allcount; ?></p>
         </div>
         <div class="col-md-3 col-sm-3"></div>
         <div class="col-md-6 col-sm-6" style="padding:0px;"><?= $pagination; ?></div>
      </div>
          <table id="" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
             <thead>
                <tr>
                    <th>S.no </th>
                    <th>Name</th>
                    <th>Father name</th>
                    <th>Dob</th>
                    <th>Address</th>
                    <th>Phone no</th>
                    <th>letter Sent on</th>
                </tr>
             </thead>
             <tbody>
               <?php
			    if (count($result) >0) {
					$i = $row+1;
					foreach($result as $rows){

			   ?>
                 <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php echo $rows['full_name']; ?></td>
                    <td><?php echo $rows['father_husband_name']; ?></td>
                    <!-- <td><?php echo date('d-m-Y', strtotime($rows['dob'])); ?></td> -->
                    <td><?php if($rows['dob']=='0000-00-00'){ echo""; }else{echo date('d-m-Y', strtotime($rows['dob'])); } ?></td>
                    <td><?php echo $rows['door_no']; ?><br><?php echo $rows['address']; ?><br><?php echo $rows['pin_code']; ?></td>
                    <td><?php echo $rows['mobile_no']; ?></td>
                    <td><?php echo date("d-m-Y H:i", strtotime($rows['created_at'])); ?></td>

                 </tr>
				<?php $i++; } } ?>
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
</div>
<script type="text/javascript">
$('#reportmenu').addClass('active');
$('.reportmenu').css('display','block');
function get_paguthi(sel){
  var paguthi_id=sel.value;
  $.ajax({
		url:'<?php echo base_url(); ?>masters/get_active_office',
		method:"POST",
		data:{paguthi_id:paguthi_id},
		dataType: "JSON",
		cache: false,
		success:function(data)
		{
		   var stat=data.status;
		   // $("#office_id").empty();
       //
		   // if(stat=="success"){
		   // var res=data.res;
		   // var len=res.length;
       //  $('#office_id').html('<option value="">ALL</option>');
		   // for (i = 0; i < len; i++) {
		   // $('<option>').val(res[i].id).text(res[i].office_name).appendTo('#office_id');
		   // }
       //
		   // }else{
		   // $("#office_id").empty();
       //
		   // }
		}
	});
}


$.validator.addMethod("chkDates", function(value, element) {
		var startDate = $('#bf_year_id').val();
		var endDate = $('#year_id').val();
		return Date.parse(startDate) <= Date.parse(endDate) || value == "";
	}, "Fom Year cannot be greater than To YEAR");

$('#report_form').validate({ // initialize the plugin
     rules: {
         bf_year_id:{required:true},
         b_year_id:{ required: function(element){
            return $("#bf_year_id").val().length > 0; },chkDates: "#bf_year_id"},
         b_month:{required:true}
     },
     messages: {
          bf_year_id:{required:"select from year"},
           b_year_id: { required:"Select to year"},
           b_month: { required:"Select month"}
         }
 });
 // $('#report_form').validate({ // initialize the plugin
 //      rules: {
 //
 //              m_frmDate:{ required: function(element){
 //                 return $("#toDate").val().length > 0; }},
 //             m_toDate:{ required: function(element){
 //                return $("#frmDate").val().length > 0; },chkDates: "#frmDate"},
 //      },
 //      messages: {
 //            m_frmDate: { required:"Select From Date"},
 //            m_toDate: { required:"Select To Date"}
 //          }
 //  });
 </script>
