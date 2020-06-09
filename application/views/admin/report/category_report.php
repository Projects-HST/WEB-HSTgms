<div  class="right_col" role="main">
   <div class="">
      <div class="col-md-12 col-sm-12 ">
         <div class="x_panel">
            <div class="x_title">
               <h2>Category Based Report</h2>

               <div class="clearfix"></div>
            </div>
            <div class="x_content">
		<form id="report_form" action="<?php echo base_url(); ?>report/category" method="post" enctype="multipart/form-data">
			  <div class="item form-group">
				 <label class="col-form-label col-md-1 col-sm-1 label-align">From <span class="required">*</span></label>
				 <div class="col-md-2 col-sm-2">
						<input type="text" class="form-control" placeholder="From Date" id="frmDate" name="frmDate" value="<?php echo $dfromDate; ?>">
				 </div>
				  <label class="col-form-label col-md-1 col-sm-1 label-align">To <span class="required">*</span></label>
				 <div class="col-md-2 col-sm-2">
					<input type="text" class="form-control" placeholder="To Date" id="toDate" name="toDate" value="<?php echo $dtoDate; ?>">
				 </div>
				  <label class="col-form-label col-md-2 col-sm-2 label-align">Category <span class="required">*</span></label>
				 <div class="col-md-2 col-sm-2">
						<select class="form-control" name="category" id ="category" >
							<option value="ALL">ALL</option>
							<?php foreach($category as $rows){ ?>
							<option value="<?php echo $rows->id;?>"><?php echo $rows->grievance_name;?></option>
							<?php } ?>
						</select><script> $('#category').val('<?php echo $dcategory; ?>');</script>
				 </div>
				 <div class="col-md-2 col-sm-2">
					 <button type="submit" class="btn btn-success">SEARCH</button>					 
				 </div>
			  </div>
			  <div class="ln_solid"></div>
		</form>

			   
		<div class="col-md-12 col-sm-12 ">
          <table id="export_example" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
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
               <?php $i=1; foreach($res as $rows){ ?>
                 <tr>
                    <td><?php echo $i; ?></td>
					<td><?php echo $rows->petition_enquiry_no; ?></td>
					<td><?php echo date('d-m-Y', strtotime($rows->created_at)); ?></td>
                    <td><?php echo $rows->full_name; ?></td>
					<td><?php echo $rows->mobile_no; ?></td>
					<td><?php echo $rows->grievance_name; ?></td>
                    <td><?php  echo $rows->status; ?></td>
                    <td><?php  echo $rows->created_by; ?></td>
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
<script type="text/javascript">

$.validator.addMethod("chkDates", function(value, element) {
		var startDate = $('#frmDate').val();		
		var datearray = startDate.split("-");
		var frm_date = datearray[1] + '/' + datearray[0] + '/' + datearray[2];
		
		var endDate = $('#toDate').val();		
		var datearray = endDate.split("-");
		var to_date = datearray[1] + '/' + datearray[0] + '/' + datearray[2];

		return Date.parse(frm_date) <= Date.parse(to_date) || value == "";
	}, "Please check dates");


$('#frmDate').datetimepicker({
        format: 'DD-MM-YYYY'
});

$('#toDate').datetimepicker({
        format: 'DD-MM-YYYY'
});

$('#report_form').validate({ // initialize the plugin
     rules: {
         frmDate:{required:true},
         toDate:{required:true, chkDates: "#frmDate"}
     },
     messages: {
           frmDate: { required:"Select From Date"},
           toDate: { required:"Select To Date"}
         }
 });
 </script>
