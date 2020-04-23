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
							<input type="text" class="form-control" placeholder="From Date" id="frmDate" name="frmDate">
                     </div>
					  <label class="col-form-label col-md-1 col-sm-1 label-align">To <span class="required">*</span></label>
                     <div class="col-md-2 col-sm-2">
						<input type="text" class="form-control" placeholder="To Date" id="toDate" name="toDate">
                     </div>
					  <label class="col-form-label col-md-2 col-sm-2 label-align">Category <span class="required">*</span></label>
                     <div class="col-md-2 col-sm-2">
							<select class="form-control" name="category" id ="category" >
								<option value="All">All</option>
								<?php foreach($category as $rows){ ?>
								<option value="<?php echo $rows->id;?>"><?php echo $rows->grievance_name;?></option>
								<?php } ?>
							</select>
                     </div>
					 <div class="col-md-2 col-sm-2">
                         <button type="submit" class="btn btn-success">SEARCH</button>					 
                     </div>
                  </div>
                  <div class="ln_solid"></div>
               </form>

			   
				<div class="col-md-12 col-sm-12 ">
          <table id="example" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
             <thead>
                <tr>
                   <th>S.no</th>
                   <th>Name</th>
				   <th>Email Id</th>
				   <th>Petition No</th>
				   <th>Status</th>
                   <th>Created by</th>

                </tr>
             </thead>
             <tbody>
               <?php $i=1; foreach($res as $rows){ ?>
                 <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php echo $rows->full_name; ?></td>
					<td><?php echo $rows->mobile_no; ?></td>
					<td><?php echo $rows->petition_enquiry_no; ?></td>
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
