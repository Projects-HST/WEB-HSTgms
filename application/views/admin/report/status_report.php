<div  class="right_col" role="main">
   <div class="">
      <div class="col-md-12 col-sm-12 ">
         <div class="x_panel">
            <div class="x_title">
               <h2>Status Based Report</h2>

               <div class="clearfix"></div>
            </div>
            <div class="x_content">
			
		<form id="report_form" action="<?php echo base_url(); ?>report/status" method="post" enctype="multipart/form-data">

			  <div class="item form-group">
				 <label class="col-form-label col-md-2 col-sm-2 label-align">From <span class="required">*</span></label>
				 <div class="col-md-2 col-sm-2">
						<input type="text" class="form-control" placeholder="From Date" id="frmDate" name="frmDate" value="<?php echo $dfromDate; ?>">
				 </div>
				  <label class="col-form-label col-md-2 col-sm-2 label-align">To <span class="required">*</span></label>
				 <div class="col-md-2 col-sm-2">
					<input type="text" class="form-control" placeholder="To Date" id="toDate" name="toDate" value="<?php echo $dtoDate; ?>">
				 </div>
				 
			  </div>
			   <div class="item form-group">
				  <label class="col-form-label col-md-2 col-sm-2 label-align">Status <span class="required">*</span></label>
				 <div class="col-md-2 col-sm-2">
						<select class="form-control" name="status" id ="status" >
							<option value="ALL">ALL</option>
							<option value="PROCESSING">PROCESSING</option>
							<option value="COMPLETED">COMPLETED</option>
						</select><script> $('#status').val('<?php echo $dstatus; ?>');</script>
				 </div>
				  <label class="col-form-label col-md-2 col-sm-2 label-align">Area <span class="required">*</span></label>
				 <div class="col-md-2 col-sm-2">
						<select class="form-control" name="paguthi" id ="paguthi" >
							<option value="ALL">ALL</option>
							<?php foreach($paguthi as $rows){ ?>
							<option value="<?php echo $rows->id;?>"><?php echo $rows->paguthi_name;?></option>
							<?php } ?>
						</select><script> $('#paguthi').val('<?php echo $dpaguthi; ?>');</script>
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
                    <td><?php  echo $rows->full_name; ?></td>
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

$('#frmDate').datetimepicker({
        format: 'DD-MM-YYYY'
});

$('#toDate').datetimepicker({
        format: 'DD-MM-YYYY'
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
 </script>
